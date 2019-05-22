<?php

namespace App;

use App\BillingNotice;
use App\DatesTranslator;
use App\Expense;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
	use DatesTranslator;

  public $timestamps = false;

	protected $fillable = [
     'nro_invoice', 'amount', 'expense_id', 'date'
  ];

  public function expense()
  {
  	return $this->belongsTo(Expense::class);
  }

  public static function insertInvoice($data)
  {
			DB::transaction(function () use ($data)  {
			    $invoice = Invoice::create([
			        'nro_invoice' => $data['nro_invoice'],
			        'amount' => $data['amount'],
			        'expense_id' => $data['expense_id'],
			        'date' => Carbon::parse($data['date'])->format('Y-m-d'),
			    ]);
			});
  }

  public static function updateInvoice($id, $request)
  {
		DB::transaction(function () use ($id, $request)  {
		    $invoice = Invoice::findOrFail($id);
		    $invoice->update($request->only('nro_invoice','expense_id','amount'));
		    $invoice->date = Carbon::parse($request->input('date'))->format('Y-m-d');
		    $invoice->save();
		});
  }

  public static function verifyInvoiceMonthCharged($month, $year)
  {
  	return $cant = BillingNotice::whereMonth('date', '=', $month)->whereYear('date', '=', $year)->count();
  }
}
