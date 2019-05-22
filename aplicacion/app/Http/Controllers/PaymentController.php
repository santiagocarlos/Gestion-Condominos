<?php

namespace App\Http\Controllers;

use Alert;
use App\ArrearsInterests;
use App\Bank;
use App\BanksCondominium;
use App\BillingNotice;
use App\Notifications\PaymentConfirm;
use App\Notifications\PaymentCreatedFromAdmin;
use App\Notifications\PaymentReceived;
use App\Owner;
use App\Payment;
use App\People;
use App\User;
use App\WaysToPay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $payments = Payment::join('banks','banks.id','=','payments.bank_id')->join('ways_to_pays','ways_to_pays.id','=','payments.way_to_pay_id')
                ->select('payments.*', 'banks.name as nameBank', 'ways_to_pays.name as nameWayToPay')
                ->get();
      return view('admin.payments.index',compact('payments'));
    }

    public function unconfirmed()
    {
      $payments = Payment::join('banks','banks.id','=','payments.bank_id')->join('ways_to_pays','ways_to_pays.id','=','payments.way_to_pay_id')
                ->where('date_confirm', null)
                ->select('payments.*', 'banks.name as nameBank', 'ways_to_pays.name as nameWayToPay')
                ->get();

      return view('admin.payments.unconfirmed',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
      //dd($request->input('owner_id'));
        $owner = People::join('users', 'users.people_id', 'peoples.id')
                        ->join('owners', 'owners.user_id', 'users.id')
                        ->join('apartments', 'apartments.id', 'owners.apartment_id')
                        ->join('towers', 'towers.id', 'apartments.tower_id')
                        ->select(
                          'peoples.id',
                          'peoples.ci',
                          'peoples.name as namePeople',
                          'peoples.last_name',
                          'towers.name as nameTower',
                          'apartments.floor',
                          'apartments.apartment'
                        )
                        ->where('users.id', $request->input('owner_id'))->first();
                   // dd($owner);
        $banks = Bank::all();
        $waysToPay = WaysToPay::all();
        $billing_notices = BillingNotice::listBillingFromAdmin($request->input('owner_id'));
        $banksCondominium = BanksCondominium::join('banks', 'banks.id', 'banks_condominia.bank_id')
                                              ->select(
                                                'banks_condominia.id',
                                                'banks_condominia.account_number',
                                                'banks_condominia.holder',
                                                'banks_condominia.dni',
                                                'banks_condominia.email',
                                                'banks_condominia.bank_id',
                                                'banks.name'
                                              )
                                              ->get();

        $owner_id = $request->input('owner_id');

        return view('admin.payments.create', compact('banks', 'waysToPay', 'banksCondominium', 'owner', 'billing_notices', 'owner_id', 'owner'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_owner()
    {
        $owners = User::join('peoples', 'peoples.id', 'users.id')
                  ->join('owners', 'owners.user_id', 'users.id')
                  ->join('apartments', 'apartments.id', 'owners.apartment_id')
                  ->join('towers', 'towers.id', 'apartments.tower_id')
                  ->select('users.id', 'users.email', 'peoples.name as nameOwner', 'peoples.last_name','towers.name', 'apartments.floor', 'apartments.apartment')
                  ->get();

        return view('admin.payments.createOwner', compact('owners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //dd($request);
        $validator = Validator::make($request->all(),[
            'way_to_pay_id' => 'required|not_in:0',
            'bank_id' => 'required|not_in:0',
            'bank_condominia_id' => 'required|not_in:0',
            'nro_confirmation' => 'required|numeric',
            'amount' => 'required|numeric',
            'date_pay' => 'required|date_format:"d-m-Y"',
            'image' => 'required|file',
        ],
        [
            'way_to_pay_id.required' => 'Este campo es obligatorio',
            'way_to_pay_id.not_in' => 'Debes seleccionar una opción',
            'bank_id.required' => 'Este campo es obligatorio',
            'bank_id.not_in' => 'Debes seleccionar una opción',
            'bank_condominia_id.required' => 'Este campo es obligatorio',
            'bank_condominia_id.not_in' => 'Debes seleccionar una opción',
            'nro_confirmation.required' => 'Este campo es obligatorio',
            'nro_confirmation.numeric' => 'Este campo solo acepta números',
            'amount.required' => 'Este campo es obligatorio',
            'amount.numeric' => 'Este campo solo acepta números',
            'date_pay.required' => 'Este campo es obligatorio',
            'date_pay.date_format' => 'Este campo no cumple con el formato requerido, el formato es dd-mm-yyyy',
            'image.required' => 'Debes cargar obligatoriamente una imagen o un PDF para poder confirmar el pago',
            'image.file' => 'Este campo es requerido',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        return DB::transaction(function () use ($request)  {
            if ($request->hasFile('image'))
            {
                $file = $request->file('image');
                if ($file->getClientMimeType() == 'image/png' or $file->getClientMimeType() == 'image/jpeg
' or $file->getClientMimeType() == 'image/pjpeg' or $file->getClientMimeType() == 'application/pdf')
                {

                  $billing = BillingNotice::join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')
                                ->whereIn('billing_notices.id', $request->input('billing'))
                                ->select(
                                  'billing_notices.*',
                                  DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge'),
                                  DB::raw('ROUND(billing_notices.amount + surcharge, 2) as amount')
                                )
                                ->orderBy('date', 'ASC')
                                ->get();
                  if ($billing->isEmpty())
                  {
                    $billing = BillingNotice::whereIn('billing_notices.id', $request->input('billing'))
                                ->select(
                                  'billing_notices.*'
                                  )
                                ->orderBy('date', 'ASC')
                                ->get();
                  }

                  $paidAmount = $request->input('amount');
                  $acum = 0;
                  foreach ($billing as $bil)
                  {
                    $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')
                                                  ->select(DB::raw('ROUND(billing_notices.amount + arrears_interests.surcharge, 2) as total'))
                                                  ->first();
                    if (!$amountTotal)
                    {
                      $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->first();
                      $acum += $amountTotal->amount;
                    }else{
                      $acum += $amountTotal->total;
                    }
                    if ($acum == 0)
                    {
                      $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->first();

                      $acum += $amountTotal->total;
                    }
                  }
                  $cantBilling = count(request('billing'));
                  if ($cantBilling == 1)
                  {
                    $acum2 = 0;
                    foreach ($billing as $bill)
                    {
                      $amountPaidPartially = Payment::join('billing_notice_payment','billing_notice_payment.payment_id','=','payments.id')->join('billing_notices','billing_notice_payment.billing_notice_id','=','billing_notices.id')->where('billing_notices.id','=',$bill->id)->sum('payments.amount');
                        if ($amountPaidPartially == 0)
                        {
                          $acum2 = $paidAmount;
                          break;
                        }
                      $acum2 += $amountPaidPartially;
                    }
                    if ($paidAmount > $acum2 and (($paidAmount+$acum2) > $acum ))
                    {
                      return redirect()->route('admin.payments.index')->with('error', 'No puedes pagar más del monto de la deuda');
                    }
                  }
                  if ($paidAmount > $acum)
                  {
                    return redirect()->route('admin.payments.index')->with('error', 'No puedes pagar más del monto de la deuda');
                  }
                  else
                  {
                    $file = $request->file('image');
                    $name = 'pago_'.Auth::user()->id."_".time().'.png';
                    $file->move(public_path().'/images_payments/', $name);

                    $payment = Payment::create($request->all());
                    $payment->date_pay = Carbon::parse($request->date_pay)->format('Y-m-d');
                    $payment->image = $name;
                    $payment->save();

                    $administrators = User::join('admins', 'admins.user_id', '=', 'users.id')->get();
                    Notification::send($administrators, new PaymentReceived($payment));

                    foreach ($billing as $bill)
                    {
                      $acumPartial = Payment::partialPayments($bill->id);
                      if ($paidAmount < $bill->amount)
                      {
                        if (($acumPartial+$paidAmount) == $bill->amount)
                        {
                          $bill->status = 2;
                          $bill->save();
                          $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                          if ($owner != null)
                          {
                            $owner->status = 0;
                            $owner->save();
                          }
                          $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                          if($arrears_interests)
                          {
                            $arrears_interests->end_date = date('Y-m-d');
                            $arrears_interests->save();
                          }

                          $paidPartial = $paidAmount;
                          $paidAmount = -1;
                        }
                        else{
                          $bill->status = 1;
                          $bill->save();
                          $paidPartial = $paidAmount;
                          $paidAmount = -1;
                        }
                      }
                      if ($paidAmount > $bill->amount)
                      {
                          $bill->status = 2;
                          $bill->save();
                          $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                          if ($owner != null)
                          {
                            $owner->status = 0;
                            $owner->save();
                          }
                          $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                          if($arrears_interests)
                          {
                            $arrears_interests->end_date = date('Y-m-d');
                            $arrears_interests->save();
                          }
                          $resto = $paidAmount - $bill->amount;
                          $paidPartial = $bill->amount;
                          $paidAmount = $resto;
                      }
                      if ($paidAmount == $bill->amount)
                      {
                        $bill->status = 2;
                        $bill->save();
                        $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                        if ($owner != null)
                        {
                          $owner->status = 0;
                          $owner->save();
                        }
                        $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                        if($arrears_interests)
                        {
                          $arrears_interests->end_date = date('Y-m-d');
                          $arrears_interests->save();
                        }
                        $resto = $paidAmount - $bill->amount;
                        $paidPartial = $paidAmount - $resto;
                        $paidAmount = 0;
                      }
                      if ($paidAmount == 0)
                      {
                        $bill->status = 2;
                        $bill->save();
                        $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                        if ($owner != null)
                        {
                          $owner->status = 0;
                          $owner->save();
                        }
                        $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                        if($arrears_interests)
                        {
                          $arrears_interests->end_date = date('Y-m-d');
                          $arrears_interests->save();
                        }
                        DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                        break;
                      }
                      if($paidAmount < 0)
                      {
                        //echo "aqui";exit;
                        DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                        break;
                      }
                      DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                    }
                  }
                }
                else
                {
                    return redirect()->route('admin.payments.index')->with('error','El archivo cargado no es permitido');
                }
            }
            Alert::success('Pago registrado exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.payments.index');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $payment = Payment::join('banks','banks.id','=','payments.bank_id')
                            ->join('ways_to_pays','ways_to_pays.id','=','payments.way_to_pay_id')
                            ->where('payments.id',$id_decrypt)
                            ->select('payments.*', 'banks.name as nameBank', 'ways_to_pays.name as nameWayToPay')
                            ->first();

        return view('admin.payments.show',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        $payment = Payment::findOrFail($payment->id);
        $payment->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.payments.index');
    }

    public function index_owner()
    {
        $banks = Bank::where('id', '<>', 1)->get();
        $waysToPay = WaysToPay::where('name','<>','Efectivo')->get();
        $billing_notices = BillingNotice::listBilling();
       //dd($billing_notices);
        $banksCondominium = BanksCondominium::join('banks', 'banks.id', 'banks_condominia.bank_id')
                                              ->select(
                                                'banks_condominia.id',
                                                'banks_condominia.account_number',
                                                'banks_condominia.holder',
                                                'banks_condominia.dni',
                                                'banks_condominia.email',
                                                'banks_condominia.bank_id',
                                                'banks.name'
                                              )
                                              ->get();

        return view('owners.payments.index', compact('banks','waysToPay','billing_notices','banksCondominium'));
    }

    public function store_owner(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'way_to_pay_id' => 'required|not_in:0',
            'bank_id' => 'required|not_in:0',
            'bank_condominia_id' => 'required|not_in:0',
            'nro_confirmation' => 'required|numeric',
            'amount' => 'required|numeric',
            'date_pay' => 'required|date_format:"d-m-Y"',
            'image' => 'required|file',
        ],
        [
            'way_to_pay_id.required' => 'Este campo es obligatorio',
            'way_to_pay_id.not_in' => 'Debes seleccionar una opción',
            'bank_id.required' => 'Este campo es obligatorio',
            'bank_id.not_in' => 'Debes seleccionar una opción',
            'bank_condominia_id.required' => 'Este campo es obligatorio',
            'bank_condominia_id.not_in' => 'Debes seleccionar una opción',
            'nro_confirmation.required' => 'Este campo es obligatorio',
            'nro_confirmation.numeric' => 'Este campo solo acepta números',
            'amount.required' => 'Este campo es obligatorio',
            'amount.numeric' => 'Este campo solo acepta números',
            'date_pay.required' => 'Este campo es obligatorio',
            'date_pay.date_format' => 'Este campo no cumple con el formato requerido, el formato es dd-mm-yyyy',
            'image.required' => 'Debes cargar obligatoriamente una imagen o un PDF para poder confirmar el pago',
            'image.file' => 'Este campo es requerido',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        return DB::transaction(function () use ($request)  {
            if ($request->hasFile('image'))
            {
                $file = $request->file('image');
                if ($file->getClientMimeType() == 'image/png' or $file->getClientMimeType() == 'image/jpeg
' or $file->getClientMimeType() == 'image/pjpeg' or $file->getClientMimeType() == 'application/pdf')
                {

                  $billing = BillingNotice::join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')
                                ->whereIn('billing_notices.id', $request->input('billing'))
                                ->select(
                                  'billing_notices.*',
                                  DB::raw('ROUND(arrears_interests.surcharge, 2) as surcharge'),
                                  DB::raw('ROUND(billing_notices.amount + surcharge, 2) as amount')
                                )
                                ->orderBy('date', 'ASC')
                                ->get();
                  if ($billing->isEmpty())
                  {
                    $billing = BillingNotice::whereIn('billing_notices.id', $request->input('billing'))
                                ->select(
                                  'billing_notices.*'
                                  )
                                ->orderBy('date', 'ASC')
                                ->get();
                  }

                  $paidAmount = $request->input('amount');
                  $acum = 0;
                  foreach ($billing as $bil)
                  {
                    $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->join('arrears_interests', 'billing_notices.id', '=', 'arrears_interests.billing_notice_id')
                                                  ->select(DB::raw('ROUND(billing_notices.amount + arrears_interests.surcharge, 2) as total'))
                                                  ->first();
                    if (!$amountTotal)
                    {
                      $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->first();
                      $acum += $amountTotal->amount;
                    }else{
                      $acum += $amountTotal->total;
                    }
                    if ($acum == 0)
                    {
                      $amountTotal = BillingNotice::where('billing_notices.id',$bil->id)
                                                  ->first();

                      $acum += $amountTotal->total;
                    }
                  }
                  $cantBilling = count(request('billing'));
                  if ($cantBilling == 1)
                  {
                    $acum2 = 0;
                    foreach ($billing as $bill)
                    {
                      $amountPaidPartially = Payment::join('billing_notice_payment','billing_notice_payment.payment_id','=','payments.id')->join('billing_notices','billing_notice_payment.billing_notice_id','=','billing_notices.id')->where('billing_notices.id','=',$bill->id)->sum('payments.amount');
                        if ($amountPaidPartially == 0)
                        {
                          $acum2 = $paidAmount;
                          break;
                        }
                      $acum2 += $amountPaidPartially;
                    }
                    if ($paidAmount > $acum2 and (($paidAmount+$acum2) > $acum ))
                    {
                      return redirect()->route('owners.payments.index')->with('error', 'No puedes pagar más del monto de la deuda');
                    }
                  }
                  if ($paidAmount > $acum)
                  {
                    return redirect()->route('owners.payments.index')->with('error', 'No puedes pagar más del monto de la deuda');
                  }
                  else{
                    $file = $request->file('image');
                    $name = 'pago_'.Auth::user()->id."_".time().'.png';
                    $file->move(public_path().'/images_payments/', $name);

                    $payment = Payment::create($request->all());
                    $payment->date_pay = Carbon::parse($request->date_pay)->format('Y-m-d');
                    $payment->image = $name;
                    $payment->save();

                    $administrators = User::join('admins', 'admins.user_id', '=', 'users.id')->get();
                    Notification::send($administrators, new PaymentReceived($payment));

                    foreach ($billing as $bill)
                    {
                      $acumPartial = Payment::partialPayments($bill->id);
                      if ($paidAmount < $bill->amount)
                      {
                        if (($acumPartial+$paidAmount) == $bill->amount)
                        {
                          $bill->status = 2;
                          $bill->save();
                          $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                          if ($owner != null)
                          {
                            $owner->status = 0;
                            $owner->save();
                          }
                          $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                          if($arrears_interests)
                          {
                            $arrears_interests->end_date = date('Y-m-d');
                            $arrears_interests->save();
                          }

                          $paidPartial = $paidAmount;
                          $paidAmount = -1;
                        }
                        else{
                          $bill->status = 1;
                          $bill->save();
                          $paidPartial = $paidAmount;
                          $paidAmount = -1;
                        }
                      }
                     // echo $paidAmount;exit;
                      if ($paidAmount > $bill->amount)
                      {
                          $bill->status = 2;
                          $bill->save();
                          $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                          if ($owner != null)
                          {
                            $owner->status = 0;
                            $owner->save();
                          }
                          $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                          if($arrears_interests)
                          {
                            $arrears_interests->end_date = date('Y-m-d');
                            $arrears_interests->save();
                          }
                          $resto = $paidAmount - $bill->amount;
                          $paidPartial = $bill->amount;
                          $paidAmount = $resto;
                      }
                      if ($paidAmount == $bill->amount)
                      {
                        $bill->status = 2;
                        $bill->save();
                        $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                        if ($owner != null)
                        {
                          $owner->status = 0;
                          $owner->save();
                        }
                        $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                        if($arrears_interests)
                        {
                          $arrears_interests->end_date = date('Y-m-d');
                          $arrears_interests->save();
                        }
                        $resto = $paidAmount - $bill->amount;
                        $paidPartial = $paidAmount - $resto;
                        $paidAmount = 0;
                      }
                      if ($paidAmount == 0)
                      {
                        $bill->status = 2;
                        $bill->save();
                        $owner = Owner::where('apartment_id', $bill->apartment_id)->first();
                        if ($owner != null)
                        {
                          $owner->status = 0;
                          $owner->save();
                        }
                        $arrears_interests = ArrearsInterests::where('billing_notice_id', $bill->id)->first();

                        if($arrears_interests)
                        {
                          $arrears_interests->end_date = date('Y-m-d');
                          $arrears_interests->save();
                        }
                        DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                        break;
                      }
                      if($paidAmount < 0)
                      {
                        //echo "aqui";exit;
                        DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                        break;
                      }
                      DB::insert('insert into billing_notice_payment (payment_id, billing_notice_id, amount) values (?, ?, ?)', [$payment->id, $bill->id, $paidPartial]);
                    }
                  }
                }
                else
                {
                    return redirect()->route('owners.payments.index')->with('error','El archivo cargado no es permitido');
                }
            }
        Alert::success('Pago registrado exitosamente!')->persistent("Cerrar");
        return redirect()->route('owners.payments.history');
        });
    }

    public function confirm($id)
    {
      $id_decrypt = Crypt::decrypt($id);

      $user = User::join('owners', 'owners.user_id','users.id')
            ->join('apartments', 'owners.apartment_id', 'apartments.id')
            ->join('billing_notices', 'apartments.id', 'billing_notices.apartment_id')
            ->join('billing_notice_payment', 'billing_notices.id', 'billing_notice_payment.billing_notice_id')
            ->join('payments', 'billing_notice_payment.payment_id', 'payments.id')
            ->select('users.id','users.email')
            ->where('payments.id', $id_decrypt)->first();

      $payment = Payment::where('payments.id', $id_decrypt)->first();

      Notification::send($user, new PaymentConfirm($payment));
      Payment::where('id',$id_decrypt)->update(['date_confirm' => DB::raw('NOW()')]);
      Alert::success('Pago confirmado exitosamente!')->persistent("Cerrar");
      return redirect()->route('admin.payments.index');
    }

    public function history_pays()
    {
        $history_pays = Payment::historyPayments();

        return view('owners.payments.history', compact('history_pays'));
    }
}
