<?php

namespace App\Console\Commands;
use App\ArrearsInterests;
use App\BillingNotice;
use App\Owner;
use App\Residential;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InterestsArrears extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'interests:arrears';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ejecuta el Porcentaje de Mora';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $billing = BillingNotice::where('status', '1')->orWhere('status', '0')
                              ->select('id', 'nro','amount','apartment_id', 'date')
                              ->get();
        if ($billing->isEmpty())
        {
          exit;
        }
        foreach ($billing as $bill)
        {
          $bill_interest = ArrearsInterests::where('billing_notice_id', $bill->id)->first();
          $array_file = Residential::get();
          $days_of_month = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
          $percentage_dialy_interest = ($array_file[5]/100)/$days_of_month;
          $surcharge = $percentage_dialy_interest*$bill->amount;

          $date_limit_billing = \Carbon\Carbon::parse($bill->date)->format('Y-m-').$array_file[4];
          $current_date = date('Y-m-d');

          if (strtotime($current_date) > strtotime($date_limit_billing))
          {
            if ($bill_interest == null )
            {
              DB::transaction(function () use ($bill, $surcharge) {
                $interests = ArrearsInterests::create([
                  'billing_notice_id' => $bill->id,
                  'surcharge' => round($surcharge,4),
                  'start_date' => date('Y-m-d')
                ]);

                $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                if ($owner != null)
                {
                  $owner->status = 1;
                  $owner->save();
                }
              });
            }
            else
            {
              $bill_interest->surcharge += $surcharge ;
              $bill_interest->save();
            }
          }
        }
    }
}
