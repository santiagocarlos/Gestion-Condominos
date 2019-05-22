<?php

namespace App\Http\Controllers;

use Alert;
use App\ArrearsInterests;
use App\BillingNotice;
use App\DatesTranslator;
use App\Expense;
use App\Notifications\BillingNoticeCreated;
use App\Tower;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class BillingNoticeController extends Controller
{
    use DatesTranslator;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billing_notices = BillingNotice::join('apartments','billing_notices.apartment_id','=','apartments.id')
        ->join('towers','apartments.tower_id','=','towers.id')->get();
        return view('admin.billing-notices.index',compact('billing_notices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $towers = Tower::select('id','name')->get();
        return view('admin.billing-notices.create',compact('towers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = explode('-', $request->date);
        $month = $date[0];
        $year  = $date[1];
        $datebd = $year."-".$month."-01";

        $expenseByTower = Expense::expenseByTower($request->tower_id, $month, $year);

        if ($expenseByTower[0]->valor == NULL)
        {
            return redirect()->route('admin.billing-notices.create')->with('error','No hay gastos para el mes que ingresaste. No se puede generar el cobro');
        }
        else
        {
            $toSave = BillingNotice::apartmentsToSave($request->tower_id, $month, $year);
            $saved = BillingNotice::apartmentsSaved($request->tower_id, $month, $year);
          //  dd($saved);
            //dd($toSave);
            if ($toSave->aptToSave == 0)
            {
                return redirect()->route('admin.billing-notices.create')->with('error','Esta torre no tiene apartamentos para generar cobros.');
            }
            if ($toSave->aptToSave == $saved->guardedMonth)
            {
                return redirect()->route('admin.billing-notices.create')->with('error','Ya se generó el cobro correspondiente para este mes en esa torre.');
            }
            $expenses = Expense::select('id','common')->get();
            //dd(count($expenses));
            for ($i=0; $i < count($expenses) ; $i++)
            {
                $list = BillingNotice::listBillingNoticesByApartments($request->tower_id, $month, $year);
                //dd($list);
                for ($j=0; $j < count($list) ; $j++)
                {
                    $number = mt_rand(1,100000);
                    $billing_notices = BillingNotice::create([
                        'nro' => $number,
                        'amount' => $list[$j]->valorFinal,
                        'apartment_id' => $list[$j]->id,
                        'status' => '0',
                        "date" => $datebd
                    ]);
                    $owner = User::join('owners', 'users.id', 'owners.user_id')
                                  ->join('apartments', 'apartments.id', 'owners.apartment_id')
                                  ->where('apartments.id', $list[$j]->id)
                                  ->first();
                            //dd($owner);
                    if ($owner == null)
                    {
                        continue;
                    }
                    else{
                        Notification::send($owner, new BillingNoticeCreated($owner, $billing_notices) );
                    }
                }
                break;
            }
            Alert::success('Cobros creados exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.billing-notices.index');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BillingNotice  $billingNotice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BillingNotice  $billingNotice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BillingNotice  $billingNotice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list()
    {
        $billing_notices = BillingNotice::listAllBilling();
        //dd($billing_notices);
        return view('owners.billing-notices.index',compact('billing_notices'));
    }

    public function showFromOwner($id_encrypt, $apart_encrypt)
    {
        $id = Crypt::decrypt($id_encrypt);
        $apart = Crypt::decrypt($apart_encrypt);

        $billing_notice = BillingNotice::expensesBillingNotice($id, $apart);

        $arrears_interests = ArrearsInterests::where('billing_notice_id', $id)
                                                ->select(DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge'))->first();

        $amountBillingNotice = BillingNotice::join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')->where('billing_notices.id',$id)->select(DB::raw('ROUND(billing_notices.amount + arrears_interests.surcharge, 2) as total'))->first();

        if ($amountBillingNotice != null)
        {
            return view('owners.billing-notices.show',compact('billing_notice','amountBillingNotice','id','apart', 'arrears_interests'));
        }

        $amountBillingNotice = BillingNotice::where('billing_notices.id',$id)->select(DB::raw('ROUND(billing_notices.amount, 2) as total'))->first();

        return view('owners.billing-notices.show',compact('billing_notice','amountBillingNotice','id','apart', 'arrears_interests'));
    }

    public static function pdfCondoReceipt($id_encrypt, $apart_encrypt)
    {
        $id = Crypt::decrypt($id_encrypt);
        $apart = Crypt::decrypt($apart_encrypt);
        $billing_notice = BillingNotice::expensesBillingNotice($id, $apart);

        $arrears_interests = ArrearsInterests::where('billing_notice_id', $id)
                                                ->select(DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge'))->first();

        $data_building = BillingNotice::join('apartments', 'billing_notices.apartment_id', '=', 'apartments.id')
                                        ->join('towers', 'apartments.tower_id', '=', 'towers.id')
                                        ->where('billing_notices.id',$id)->first();

        $amountBillingNotice = BillingNotice::join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')->where('billing_notices.id',$id)->select(DB::raw('ROUND(billing_notices.amount + arrears_interests.surcharge, 2) as total'))->first();

        if ($amountBillingNotice == null)
        {
            $amountBillingNotice = BillingNotice::where('billing_notices.id',$id)->select(DB::raw('ROUND(billing_notices.amount, 2) as total'))->first();

            $pdf = PDF::loadView('owners.billing-notices.pdf.receipt',compact('billing_notice','amountBillingNotice', 'arrears_interests', 'data_building'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream('reciboCondominio.pdf');
        }
        else
        {
            $pdf = PDF::loadView('owners.billing-notices.pdf.receipt',compact('billing_notice','amountBillingNotice', 'arrears_interests', 'data_building'));
            $pdf->setPaper('A4', 'landscape');

            return $pdf->stream('reciboCondominio.pdf');
        }
    }
}
