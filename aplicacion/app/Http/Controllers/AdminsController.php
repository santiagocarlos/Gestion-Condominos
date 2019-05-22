<?php

namespace App\Http\Controllers;

use Alert;
use App\Admin;
use App\Apartment;
use App\Owner;
use App\People;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AdminsController extends Controller
{
    public function type()
    {
        return view('admin.admins.type');
    }

    public function extern()
    {
        $roles = Role::all()->where('name','<>','owner');
        return view('admin.admins.extern',compact('roles'));
    }

    public function intern()
    {
        $apartments = Apartment::getApartmentsToSelectMultiple();
        $roles = Role::all()->where('name','<>','owner');
        return view('admin.admins.intern',compact('roles','apartments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::join('users','admins.user_id','=','users.id')
                        ->join('peoples','users.people_id','=','peoples.id')
                        ->select('peoples.id','users.email','peoples.name','peoples.last_name')
                        ->get();

        return view('admin.admins.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('admin.admins.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request['extern']) and $request['extern'] == 1)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'ci' => 'required|digits_between:4,8|numeric|unique:peoples',
                'phone' => 'required|numeric|unique:phones,number',
                'birth' => 'required|date_format:"d-m-Y"',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|array|not_in:0',
            ],
            [
                'ci.unique' => 'Esta cédula ya se encuentra registrada',
                'email.unique' => 'Este e-mail ya se encuentra registrado',
                'phone.unique' => 'Este teléfono ya se encuentra registrado',
                'ci.required' => 'El campo cédula es obligatorio',
                'birth.required' => 'La fecha de nacimiento es obligatoria',
                'birth.date_format' => 'La fecha no cumple con el formato requerido',
                'role.required' => 'Debes seleccionar el tipo de administrador que serás',
                'role.not_in' => 'Debes seleccionar el tipo de administrador que serás',
            ]);

            if($validator->fails())
              return Redirect::back()->withErrors($validator)->withInput();

            Admin::insertAdminExtern($request);

            Alert::success('Guardado exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.admins.index');
        }

        if (isset($request['intern']) and $request['intern'] == 1)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'ci' => 'required|digits_between:4,8|numeric|unique:peoples',
                'phone' => 'required|numeric|unique:phones,number',
                'birth' => 'required|date_format:"d-m-Y"',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|array|not_in:0',
                'apartments' => 'required|array|not_in:0',
            ],
            [
                'ci.unique' => 'Esta cédula ya se encuentra registrada',
                'email.unique' => 'Este e-mail ya se encuentra registrado',
                'phone.unique' => 'Este teléfono ya se encuentra registrado',
                'ci.required' => 'El campo cédula es obligatorio',
                'birth.required' => 'La fecha de nacimiento es obligatoria',
                'birth.date_format' => 'La fecha no cumple con el formato requerido',
                'role.required' => 'Debes seleccionar el tipo de administrador que serás',
                'role.not_in' => 'Debes seleccionar el tipo de administrador que serás',
                'apartments.required' => 'Selecciona un apartamento',
                'apartments.not_in' => 'Debes seleccionar un/varios apartamento(s)',
            ]);

            if($validator->fails())
              return Redirect::back()->withErrors($validator)->withInput();

            Admin::insertAdminIntern($request);
            Alert::success('Guardado exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.admins.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        $admin_owner = Admin::getAdminOwner($id_decrypt);
        //dd($admin_owner);
        $owner = Owner::findOwner($id_decrypt);
        $aparts = Owner::getIdApartmentsOwners($id_decrypt);
        $array = (array) $aparts[0];
        $id_aparts = (array) explode(",", $array['apartments_owner']);
        $apartments_owner = (array) explode(",", $owner->apartments_owner);
        $apartments = Apartment::getApartmentsToSelectMultiple();

        $roles = Role::pluck('display_name','id');

        if (!$admin_owner or $admin_owner == 'null')
        {
            $admin = Admin::getAdmin($id_decrypt);
            $roles = Role::pluck('display_name','id');
            $user = User::findOrFail($admin->id);
            return view('admin.admins.editExtern',compact('admin','user','roles'));
        }
        else
        {
            $user = User::findOrFail($admin_owner->peopleId);
            return view('admin.admins.editIntern',compact('admin_owner','roles','id_aparts','apartments_owner','apartments'));
        }
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
        if (isset($request['intern']) or $request['intern'] == 1)
        {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'ci' => 'required|digits_between:4,8|numeric',
                'number' => 'required|numeric',
                'birth' => 'required|date_format:"d-m-Y"',
                'email' => 'required|email|max:255',
                'roles' => 'required|array',
                'apartments' => 'required|array|not_in:0',
            ],
            [
                'ci.numeric' => 'Este campo debe contener solo números',
                'email.unique' => 'Este e-mail ya se encuentra registrado',
                'number.required' => 'Este campo es obligatorio',
                'number.unique' => 'Este teléfono ya se encuentra registrado',
                'ci.required' => 'El campo cédula es obligatorio',
                'birth.required' => 'La fecha de nacimiento es obligatoria',
                'birth.date_format' => 'La fecha no cumple con el formato requerido',
                'roles.required' => 'Debes seleccionar el tipo de administrador que serás',
                'apartments.required' => 'Selecciona un apartamento',
                'apartments.not_in' => 'Debes seleccionar un/varios apartamento(s)',
            ]);

            if($validator->fails())
              return Redirect::back()->withErrors($validator)->withInput();

            $people = People::findOrFail($id);
            $people->update($request->only('ci','name','last_name'));
            $people->birth = Carbon::parse($request->input('birth'))->format('Y-m-d');
            $people->phones()->update($request->only('number'));

            $people->save();

            $user = User::findOrFail($id);
            $user->update($request->only('email'));
            $user->roles()->sync($request->roles);

            $owner = Owner::where('user_id','=',$id);
            $apartment = Owner::updateApartments($user->id, $request->apartments);
            Alert::success('Editado exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.admins.index');
        }

        if (isset($request['extern']) or $request['extern'] == 1)
        {
             $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'ci' => 'required|digits_between:4,8|numeric',
                'phone' => 'required|numeric',
                'birth' => 'required|date_format:"d-m-Y"',
                'email' => 'required|email|max:255',
                'roles' => 'required|array',
            ],
            [
                'ci.numeric' => 'Este campo debe contener solo números',
                'email.email' => 'Debe ser un e-mail válido',
                'phone.numeric' => 'Este campo debe contener solo números',
                'ci.required' => 'El campo cédula es obligatorio',
                'birth.required' => 'La fecha de nacimiento es obligatoria',
                'birth.date_format' => 'La fecha no cumple con el formato requerido',
                'roles.required' => 'Debes seleccionar el tipo de administrador que serás',
            ]);

            if($validator->fails())
              return Redirect::back()->withErrors($validator)->withInput();

            $people = People::findOrFail($id);
            $people->ci = $request->input('ci');
            $people->name = $request->input('name');
            $people->last_name = $request->input('last_name');
            $people->birth = Carbon::parse($request->input('birth'))->format('Y-m-d');
            $people->save();

            $user = User::findOrFail($id);
            $user->update($request->only('email'));
            $user->roles()->sync($request->roles);

            Alert::success('Editado exitosamente!')->persistent("Cerrar");
            return redirect()->route('admin.admins.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::deleteAdmin($id);
        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.admins.index');
    }


}
