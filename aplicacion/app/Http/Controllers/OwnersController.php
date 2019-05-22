<?php

namespace App\Http\Controllers;

use Alert;
use App\Apartment;
use App\BillingNotice;
use App\Owner;
use App\Payment;
use App\People;
use App\Phone;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class OwnersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::getListOwners();
        return view('admin.owners.index',compact('owners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $apartments = Apartment::getApartmentsToSelectMultiple();
        return view('admin.owners.create',compact('apartments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'ci' => 'required|digits_between:4,8|numeric|unique:peoples',
            'phone' => 'required|numeric|unique:phones,number',
            'birth' => 'required|date_format:"d-m-Y"',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'apartments' => 'required|array|not_in:0',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
            'last_name.required' => 'Este campo es obligatorio',
            'ci.unique' => 'Esta cédula ya se encuentra registrada',
            'email.required' => 'Este campo es obligatorio',
            'email.unique' => 'Este e-mail ya se encuentra registrado',
            'phone.required' => 'Este campo es obligatorio',
            'phone.unique' => 'Este teléfono ya se encuentra registrado',
            'ci.required' => 'Este campo es obligatorio',
            'birth.required' => 'La fecha de nacimiento es obligatoria',
            'birth.date_format' => 'La fecha no cumple con el formato requerido',
            'password.required' => 'Este campo es obligatorio',
            'apartments.required' => 'Selecciona un apartamento',
            'apartments.not_in' => 'Debes seleccionar un/varios apartamento(s)',
        ]);

        if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();
      //dd($request);
        DB::transaction(function () use ($request)  {
            $data = $request->all();
            Owner::insertOwner($data);
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.owners.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $owner = Owner::findOwner($id_decrypt);
        $aparts = Owner::getIdApartmentsOwners($id_decrypt);
        $array = (array) $aparts[0];
        $id_aparts = (array) explode(",", $array['apartments_owner']);
        $apartments_owner = (array) explode(",", $owner->apartments_owner);

        $apartments = Apartment::getApartmentsToSelectMultiple();
        return view('admin.owners.edit',compact('owner','apartments_owner','id_aparts','apartments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'ci' => 'required|digits_between:4,8|numeric',
            'number' => 'required|numeric',
            'birth' => 'required|date_format:"d-m-Y"',
            'email' => 'required|email|max:255',
            'apartments' => 'required|array|not_in:0',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
            'last_name.required' => 'Este campo es obligatorio',
            'email.required' => 'Este campo es obligatorio',
            'number.required' => 'Este campo es obligatorio',
            'number.unique' => 'Este teléfono ya se encuentra registrado',
            'ci.required' => 'Este campo es obligatorio',
            'birth.required' => 'La fecha de nacimiento es obligatoria',
            'birth.date_format' => 'La fecha no cumple con el formato requerido',
            'apartments.required' => 'Selecciona un apartamento',
            'apartments.not_in' => 'Debes seleccionar un/varios apartamento(s)',
        ]);

        if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();

        $people = People::findOrFail($id);
        $people->update($request->only('name','last_name'));
        $people->birth = Carbon::parse($request->input('birth'))->format('Y-m-d');
        $people->phones()->update($request->only('number'));
        $people->save();

        $user = User::findOrFail($id);
        $user->update($request->only('email'));

        $apartment = Owner::updateApartments($user->id, $request->apartments);

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.owners.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function () use ($id)  {
            $user = User::findOrFail($id);
            $user->roles()->detach(2);
            $user->people()->delete();
            $user->delete();
        });

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.owners.index');
    }

    public function home()
    {
        $infoUser = People::getInfo();
        $billing_notices = BillingNotice::listBilling();
        $history_pays = Payment::historyPayments();
        $cant_properties = Owner::where('user_id', Auth::user()->id)->count();

        return view('owners.home', compact('infoUser','billing_notices','history_pays', 'cant_properties'));
    }

    public function properties()
    {
        $properties = Owner::join('apartments', 'owners.apartment_id', '=', 'apartments.id')
                            ->join('towers', 'apartments.tower_id', '=', 'towers.id')
                            ->select(
                                'towers.name as nameTower',
                                'apartments.floor',
                                'apartments.apartment'
                            )
                            ->where('owners.user_id', Auth::user()->id)->get();

        return view('owners.properties', compact('properties'));
    }

    public function editInfo()
    {
        $infoUser = People::getInfo();
        $phones = Phone::where('people_id','=', Auth::user()->id)->select('id', 'number')->get();

        return view('owners.editInfo', compact('infoUser', 'phones'));
    }

    public function storeInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'ci' => 'required|numeric',
            'phone' => 'array',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
            'last_name.required' => 'Este campo es obligatorio',
            'ci.required' => 'Este campo es obligatorio',
            'ci.numeric' => 'Este campo acepta solo números',
            'phone.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();

        $data = $request->all();
        $id_decrypt = Crypt::decrypt($data['id']);

        DB::transaction(function () use ($id_decrypt, $request, $data)  {
            $people = People::findOrFail($id_decrypt);
            $people->update($request->only(['name', 'last_name', 'ci']));
            $phone = Phone::where('people_id', $id_decrypt)->delete();
            $people->save();

            foreach ($request->phone as $phone)
            {
                Phone::create([
                    'number' => $phone,
                    'people_id' => $people->id
                ]);
            }
        });

        Alert::success('Datos guardados exitosamente!')->persistent("Cerrar");
        return redirect()->route('owners.owners.home');
    }

}
