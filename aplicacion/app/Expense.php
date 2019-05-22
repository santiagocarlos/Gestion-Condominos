<?php

namespace App;

use App\Apartment;
use App\DatesTranslator;
use App\Invoice;
use App\Tower;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class Expense extends Model
{
    use DatesTranslator;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'name', 'company', 'description', 'common'
    ];

    public function towers()
    {
    	return $this->belongsToMany(Tower::class)->withTimestamps();
    }

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public static function insertExpense($request)
    {
        if ($request->input('common') === "0")
        {
            DB::transaction(function () use ($request) {
                $expense = Expense::create($request->all());
                $expense->towers()->attach($request->twrcom);
            });
        }
        if($request->input('common') === "1")
        {
            DB::transaction(function () use ($request)  {
                $expense = Expense::create($request->all());
                $expense->towers()->attach($request->towers);
            });
        }
        if($request->input('common') === "2")
        {
            DB::transaction(function () use ($request)  {
                $expense = Expense::create($request->all());
                $expense->apartments()->attach($request->apartments);
            });
        }
    }

    public static function editExpense($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $expense = Expense::with(['towers:id,name', 'apartments:id,tower_id,floor,apartment'])->findOrFail($id_decrypt);
        $towers = Tower::select('id','name')->get();
        $apartments = Apartment::getApartmentsSelectMultiple();

        if ($expense->common == "1")
        {
            $array = $expense->towers->toArray();
            $towers = Tower::where('id','<>',$array)->select('id','name')->get();
            $apartments = Apartment::getApartmentsSelectMultiple();
            return view('admin.expenses.edit',compact('expense','towers','apartments'));
        }
        if ($expense->common == "2")
        {
            $towers = Tower::select('id','name')->get();
            $apartments = Apartment::getApartmentsSelectMultiple();
            return view('admin.expenses.edit',compact('expense','towers','apartments'));
        }
        return view('admin.expenses.edit',compact('expense','towers','apartments'));

    }

    public static function updateExpense($request, $id)
    {
        if ($request->input('common') === "0")
        {
            DB::transaction(function () use ($id, $request) {
                $expense = Expense::findOrFail($id)->update($request->all());
            });
        }
        if($request->input('common') === "1")
        {
            DB::transaction(function () use ($id, $request)  {
                $expense = Expense::findOrFail($id);
                $expense->update($request->all());
                $expense->towers()->sync($request->towers);
            });
        }
        if ($request->input('common') === "2")
        {
            DB::transaction(function () use ($id, $request)  {
                $expense = Expense::findOrFail($id);
                $expense->update($request->all());
                $expense->apartments()->sync($request->apartments);
            });
        }
    }

    public static function expenseByTower($tower, $month, $year)
    {
        $expense = DB::select('
            SELECT SUM(contador.valor) as valor, contador.id FROM (
            SELECT
            contador.cuenta,
            CASE WHEN expenses.common = 0 THEN invoices.amount/contador.cuenta
            ELSE invoices.amount END as valor, towers.id
            FROM expenses
            JOIN invoices ON invoices.expense_id = expenses.id
            JOIN expense_tower ON expense_tower.expense_id = expenses.id
            JOIN towers ON expense_tower.tower_id = towers.id
            JOIN (SELECT expense_tower.expense_id, COUNT( expense_tower.expense_id ) as cuenta
                FROM expense_tower GROUP BY expense_tower.expense_id) as contador
                ON contador.expense_id = expense_tower.expense_id
            WHERE towers.id = '.$tower.' AND MONTH(invoices.date) = '.$month.' AND YEAR(invoices.date) = '.$year.' ) as contador
        ');

        return $expense;
    }

    public static function getExpensesCompanyTowersAptos($common0, $common1, $common2)
    {
        $expenses = DB::select('
                  SELECT distinct (expenses.name), expenses.id, expenses.company, expenses.common, "Común"
                    FROM expenses
                    JOIN expense_tower ON expenses.id = expense_tower.expense_id
                    JOIN towers ON expense_tower.tower_id = towers.id
                    WHERE expenses.common = '.$common0.'

                    UNION ALL

                      SELECT expenses.name, expenses.id, expenses.company, expenses.common, towers.name
                    FROM expenses
                    JOIN expense_tower ON expenses.id = expense_tower.expense_id
                    JOIN towers ON expense_tower.tower_id = towers.id
                    WHERE expenses.common = '.$common1.'

                    UNION ALL

                    SELECT expenses.name, expenses.id, expenses.company, expenses.common,
                    GROUP_CONCAT( towers.name, "-",apartments.floor, "-",apartments.apartment)
                    FROM expenses
                    JOIN apartment_expense ON expenses.id = apartment_expense.expense_id
                    JOIN apartments ON apartment_expense.apartment_id = apartments.id
                    JOIN towers ON apartments.tower_id = towers.id
                    WHERE expenses.common = '.$common2.'
        ');

        return $expenses;
    }

}
