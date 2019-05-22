<?php

namespace App;

use App\DatesTranslator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillingNotice extends Model
{
	use DatesTranslator;

	protected $fillable = [
     'nro', 'amount', 'apartment_id', 'status', 'date',
  ];

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }

  public static function apartmentsToSave($tower, $month, $year)
	{
			$toSave = DB::select('
									SELECT count( distinct (apartments.id)) as aptToSave
									FROM
									apartments
									JOIN (
									SELECT contador.id FROM (
									SELECT
									towers.id
									                FROM expenses
									                JOIN invoices ON invoices.expense_id = expenses.id
									                JOIN expense_tower ON expense_tower.expense_id = expenses.id
									                JOIN towers ON expense_tower.tower_id = towers.id
									                WHERE towers.id = '.$tower.' AND MONTH(invoices.date) = '.$month.' AND YEAR(invoices.date) = '.$year.'
									        ) as contador
									) as contador ON contador.id = apartments.tower_id
			 ');

			return $toSave[0];
	}

  public static function apartmentsSaved($tower_id, $month, $year)
  {
  	$saved = DB::select('
								SELECT count(billing_notices.apartment_id) as guardedMonth FROM
								billing_notices
								WHERE apartment_id IN
								( SELECT distinct (apartments.id)
								FROM
								apartments
								JOIN (
								SELECT contador.id FROM (
								SELECT
								towers.id
								  FROM expenses
								  JOIN invoices ON invoices.expense_id = expenses.id
								  JOIN expense_tower ON expense_tower.expense_id = expenses.id
								  JOIN towers ON expense_tower.tower_id = towers.id
								  JOIN (SELECT expense_tower.expense_id, COUNT( expense_tower.expense_id ) as cuenta
								          FROM expense_tower GROUP BY expense_tower.expense_id) as contador
								          ON contador.expense_id = expense_tower.expense_id
								  WHERE towers.id = '.$tower_id.' AND MONTH(invoices.date) = '.$month.' AND YEAR(invoices.date) = '.$year.'
								) as contador
								) as contador ON contador.id = apartments.tower_id )
  	');

  	return $saved[0];
  }

    public static function listBillingNoticesByApartments($tower_id, $month, $year)
    {
       $list = DB::select('
            SELECT distinct (apartments.id),
               apartments.*, (apartments.aliquot/100) * contador.valor as cuota,
            CASE WHEN deudoresapt.total_by_apto IS NULL THEN ((apartments.aliquot/100) * contador.valor)
            ELSE ((apartments.aliquot/100) * contador.valor)+deudoresapt.total_by_apto END AS valorFinal
            FROM
            apartments
               JOIN (
              SELECT SUM(contador.valor) as valor, contador.id
              FROM (
                SELECT
                    contador.cuenta,
                        CASE WHEN expenses.common = 0 THEN invoices.amount/contador.cuenta
                        ELSE invoices.amount END as valor, towers.id
                    FROM expenses
                        JOIN invoices ON invoices.expense_id = expenses.id
                        JOIN expense_tower ON expense_tower.expense_id = expenses.id
                        JOIN towers ON expense_tower.tower_id = towers.id
                        JOIN (SELECT expense_tower.expense_id, COUNT( expense_tower.expense_id) as cuenta
                                 FROM expense_tower GROUP BY expense_tower.expense_id) as contador
                        ON contador.expense_id = expense_tower.expense_id
                        WHERE towers.id = '.$tower_id.'  AND MONTH(invoices.date) = '.$month.' AND YEAR(invoices.date) = '.$year.'
                        ) as contador
                ) as contador ON contador.id = apartments.tower_id
            LEFT JOIN (
            SELECT
                expenses.id as expid, expenses.name, expenses.company, expenses.common,
                invoices.*,
                apartments.id as aptid, apartments.tower_id, apartments.floor, apartments.apartment, apartments.aliquot,
                SUM(invoices.amount) as total_by_apto
                FROM expenses
                JOIN invoices ON invoices.expense_id = expenses.id
                JOIN apartment_expense ON apartment_expense.expense_id = expenses.id
                JOIN apartments ON apartments.id = apartment_expense.apartment_id
                WHERE expenses.common IN (SELECT expenses.common FROM expenses)  AND MONTH(invoices.date) = '.$month.' AND YEAR(invoices.date) = '.$year.'
                GROUP BY apartments.id
            ) as deudoresapt ON deudoresapt.aptid = apartments.id
            WHERE
            apartments.tower_id = '.$tower_id.'
          ');

       return $list;
    }

    public static function expensesBillingNotice($billing_notice, $apartment)
    {
      $expenses = DB::select('
                SELECT distinct (expenses.id), expenses.name, expenses.company, expenses.description, expenses.common,
                  invoices.id as invoiceID, invoices.amount, invoices.date,
                     CASE WHEN expenses.common = 0
                           THEN invoices.amount/contador.cuenta
                           ELSE invoices.amount END as valor,
                     CASE WHEN expenses.common = 0
                           THEN (invoices.amount/contador.cuenta)*(apartments.aliquot/100)
                           ELSE invoices.amount*(apartments.aliquot/100) END as alicuota
                  FROM expenses
                  JOIN expense_tower ON expense_tower.expense_id = expenses.id
                  JOIN invoices ON invoices.expense_id = expenses.id
                  JOIN (SELECT expense_tower.expense_id, COUNT( expense_tower.expense_id) as cuenta
                            FROM expense_tower GROUP BY expense_tower.expense_id) as contador
                     ON contador.expense_id = expense_tower.expense_id
                  JOIN apartments ON apartments.tower_id = expense_tower.tower_id AND apartments.id = '.$apartment.'
                  WHERE expense_tower.tower_id =
                  (
                    SELECT apartments.tower_id
                      FROM billing_notices
                         JOIN apartments ON billing_notices.apartment_id = apartments.id
                           WHERE billing_notices.id = '.$billing_notice.'
                  )

                  UNION ALL
                  SELECT
                  expenses.id as expenseId, expenses.name, expenses.company, expenses.description, expenses.common,
                  invoices.id as invoiceID, invoices.amount, invoices.date,
                   CASE WHEN expenses.common = 2
                           THEN invoices.amount
                           ELSE invoices.amount END as valor,
                  CASE WHEN expenses.common = 2
                           THEN invoices.amount
                           ELSE invoices.amount END as alicuota
                  FROM expenses
                  JOIN apartment_expense ON apartment_expense.expense_id = expenses.id
                  JOIN invoices ON invoices.expense_id = expenses.id

                  WHERE apartment_expense.apartment_id =
                  (
                    SELECT apartments.id
                      FROM billing_notices
                         JOIN apartments ON billing_notices.apartment_id = apartments.id
                           WHERE billing_notices.id = '.$billing_notice.'
                  )
          ');
        return $expenses;
    }

    public static function listBilling()
    {
      $billing_noti = BillingNotice::join('owners','owners.apartment_id','=','billing_notices.apartment_id')
                            ->join('apartments','billing_notices.apartment_id','=','apartments.id')
                            ->join('towers','apartments.tower_id','=','towers.id')
                            ->join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')
                            ->where('owners.user_id','=',Auth::user()->id)
                            ->where('billing_notices.status','0')
                            ->orWhere('billing_notices.status','1')
                            ->select(
                                'billing_notices.id',
                                'billing_notices.nro',
                                'billing_notices.amount',
                                'billing_notices.status',
                                'billing_notices.date',
                                'apartments.id as apartmentsId',
                                'apartments.floor',
                                'apartments.apartment',
                                'towers.name',
                                DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge'),
                                DB::raw('ROUND(billing_notices.amount + surcharge, 2) as total')
                            )
                            ->orderBy('billing_notices.date', 'ASC')
                            ->get();

      if ($billing_noti->isEmpty())
      {
         $billing_notices = BillingNotice::join('owners','owners.apartment_id','=','billing_notices.apartment_id')
                            ->join('apartments','billing_notices.apartment_id','=','apartments.id')
                            ->join('towers','apartments.tower_id','=','towers.id')
                            ->where('owners.user_id','=',Auth::user()->id)
                            ->where('billing_notices.status','0')
                            ->orWhere('billing_notices.status','1')
                            ->select(
                                'billing_notices.id',
                                'billing_notices.nro',
                                'billing_notices.amount',
                                'billing_notices.status',
                                'billing_notices.date',
                                'apartments.id as apartmentsId',
                                'apartments.floor',
                                'apartments.apartment',
                                'towers.name',
                                'billing_notices.amount'
                            )
                            ->orderBy('billing_notices.date', 'ASC')
                            ->get();
        return $billing_notices;
      }else
      {
        return $billing_noti;
      }

    }

    public static function listBillingFromAdmin($owner)
    {
      $billing_notices = BillingNotice::join('owners','owners.apartment_id','=','billing_notices.apartment_id')
                            ->join('apartments','billing_notices.apartment_id','=','apartments.id')
                            ->join('towers','apartments.tower_id','=','towers.id')
                            ->where('owners.user_id','=',$owner)
                            ->where('billing_notices.status','0')
                            ->orWhere('billing_notices.status','1')
                            ->select(
                                'billing_notices.id',
                                'billing_notices.nro',
                                'billing_notices.amount',
                                'billing_notices.status',
                                'billing_notices.date',
                                'apartments.id as apartmentsId',
                                'apartments.floor',
                                'apartments.apartment',
                                'towers.name'
                            )
                            ->orderBy('billing_notices.date', 'ASC')
                            ->get();

        return $billing_notices;
    }

    public static function listAllBilling()
    {
      $billing_notices = BillingNotice::join('owners','owners.apartment_id','=','billing_notices.apartment_id')
                            ->join('apartments','billing_notices.apartment_id','=','apartments.id')
                            ->join('towers','apartments.tower_id','=','towers.id')
                            ->where('owners.user_id','=',Auth::user()->id)
                            ->select(
                                'billing_notices.id',
                                'billing_notices.nro',
                                'billing_notices.amount',
                                'billing_notices.status',
                                'billing_notices.date',
                                'apartments.id as apartmentsId',
                                'apartments.floor',
                                'apartments.apartment',
                                'towers.name'
                            )
                            ->orderBy('billing_notices.date', 'ASC')
                            ->get();

        return $billing_notices;
    }


}
