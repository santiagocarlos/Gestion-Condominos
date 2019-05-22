<?php

namespace App\Http\Controllers;

use Alert;
use App\Bank;
use App\BanksCondominium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class BanksCondominiumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = BanksCondominium::join('banks', 'banks.id', 'banks_condominia.bank_id')
                ->select(
                        'banks.name',
                        'banks_condominia.*'
                        )
                ->get();

        return view('admin.banks-condominium.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::where('banks.id', '<>', 1)->get();

        return view('admin.banks-condominium.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bank_id' => 'required|not_in:0',
            'account_number' => 'required|string',
            'holder' => 'required|string',
            'type-dni' => 'required|string',
            'dni' => 'required|string',
            'email' => 'required|email',
        ],
        [
            'bank_id.required' => 'Este campo es obligatorio',
            'bank_id.not_in' => 'Debes seleccionar una opción',
            'account_number.required' => 'Este campo es obligatorio',
            'holder.required' => 'Este campo es obligatorio',
            'type-dni.required' => 'Este campo es obligatorio',
            'dni.required' => 'Este campo es obligatorio',
            'email.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request)  {
            $banksCondominium = BanksCondominium::create($request->all());
                $typeDni = $request->input('type-dni');
                $dni = $request->input('dni');
                $dniComplete = $typeDni.$dni;
            $banksCondominium->dni = $dniComplete;
            $banksCondominium->save();
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.banks-condominium.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $bankCondominium = BanksCondominium::findOrFail($id_decrypt);
        $nameBank = Bank::where('id', $bankCondominium->id)->select('name')->first();
        $dni = explode("-",$bankCondominium->dni);
        $banks = Bank::all();
        return view('admin.banks-condominium.edit', compact('banks','bankCondominium','dni','nameBank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(),[
            'bank_id' => 'required|not_in:0',
            'account_number' => 'required|string',
            'holder' => 'required|string',
            'type-dni' => 'required|string',
            'dni' => 'required|string',
            'email' => 'required|email',
        ],
        [
            'bank_id.required' => 'Este campo es obligatorio',
            'bank_id.not_in' => 'Debes seleccionar una opción',
            'account_number.required' => 'Este campo es obligatorio',
            'holder.required' => 'Este campo es obligatorio',
            'type-dni.required' => 'Este campo es obligatorio',
            'dni.required' => 'Este campo es obligatorio',
            'email.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request, $id)  {
            $banksCondominium = BanksCondominium::findOrFail($id);
                $typeDni = $request->input('type-dni');
                $dni = $request->input('dni');
                $dniComplete = $typeDni.$dni;
            $banksCondominium->account_number = $request->input('account_number');
            $banksCondominium->holder = $request->input('holder');
            $banksCondominium->dni = $dniComplete;
            $banksCondominium->email = $request->input('email');
            $banksCondominium->bank_id = $request->input('bank_id');
            $banksCondominium->save();
        });

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.banks-condominium.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bankCondominium = BanksCondominium::findOrFail($id)->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.banks-condominium.index');
    }
}
