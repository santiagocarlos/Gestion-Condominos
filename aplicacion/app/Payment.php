<?php

namespace App;

use App\Bank;
use App\BillingNotice;
use App\DatesTranslator;
use App\Payment;
use App\WaysToPay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    use DatesTranslator;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nro_confirmation', 'amount', 'image', 'bank_id', 'bank_condominia_id', 'way_to_pay_id', 'date_pay', 'date_confirm'
    ];

    public function bank()
    {
    	return $this->hasOne(Bank::class);
    }

    public function wayToPay()
    {
    	return $this->hasOne(WaysToPay::class);
    }

    public function billingNotices()
    {
        return $this->belongsToMany(BillingNotice::class);
    }

    public static function historyPayments()
    {
       return $history_pays = Payment::join('ways_to_pays','ways_to_pays.id','=','payments.way_to_pay_id')
                                ->join('banks','banks.id','=','payments.bank_id')
                                ->select(
                                        'payments.id as paymentId',
                                        'nro_confirmation',
                                        'payments.amount',
                                        'payments.date_pay',
                                        'payments.date_confirm',
                                        'banks.name as bankName',
                                        'ways_to_pays.name as wayToPayName'
                                        )
                                ->get();
    }

    public static function partialPayments($id)
    {
        return $partialPayments = BillingNotice::join('billing_notice_payment', 'billing_notice_payment.billing_notice_id','=', 'billing_notices.id')->where('billing_notice_payment.billing_notice_id',$id)->sum('billing_notice_payment.amount');
    }
}
