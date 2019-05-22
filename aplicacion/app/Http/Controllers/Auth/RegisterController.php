<?php

namespace App\Http\Controllers\Auth;

use App\Admin;
use App\Http\Controllers\Controller;
use App\Owner;
use App\People;
use App\Tower;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;

/**
 * Class RegisterController
 * @package %%NAMESPACE%%\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('adminlte::auth.register');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/config/towers';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'ci' => 'required|digits_between:4,8|numeric|unique:peoples',
            'phone' => 'required|numeric|unique:phones,number',
            'date_birth' => 'required|date_format:"d-m-Y"',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'admin' => 'required',

            "residential" => 'required',
            "towers" => 'required|numeric|digits_between:1,50',
            "apartment" => 'required|numeric|digits_between:1,600',
            "floor_tower" => 'required|numeric|digits_between:1,20'
        ],
        [
            'ci.unique' => 'Esta cédula ya se encuentra registrada',
            'email.unique' => 'Este e-mail ya se encuentra registrado',
            'phone.unique' => 'Este teléfono ya se encuentra registrado',
            'ci.required' => 'El campo cédula es obligatorio',
            'admin.required' => 'Debes seleccionar el tipo de administrador que serás',
            'residential.required' => 'El nombre del Conjunto Residencial es obligatorio',
            'towers.required' => 'El numero de torres de estar entre 1 y 50',
            'aparment.required' => 'El numero de apartamentos debe estar entre 1 y 600',
            'floor_tower.required' => 'La cantidad de pisos por torre no debe exceder los 20 pisos',
            'birth.required' => 'La fecha de nacimiento es obligatoria',
            'birth.date_format' => 'La fecha no cumple con el formato requerido',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

            $people = People::create([
                "ci" => $data['ci'],
                "name" => $data['name'],
                "last_name" => $data['last_name'],
                "birth" => Carbon::parse($data['date_birth'])->format('Y-m-d'),
            ]);

            $user = User::create([
                "email" => $data['email'],
                "password" => bcrypt($data['password']),
                "people_id" => $people->id,
            ]);

            $user->roles()->attach($data['roles']);

            $people->phones()->create([
                'number' => $data['phone'],
            ]);
            $admin = Admin::create([
                'user_id' => $people->id,
            ]);
            $nameResidential = $data['residential'];
            $floor_tower = $data['floor_tower'];
            $cant_towers = $data['towers'];
            $cant_apartments = $data['apartment'];

            $bodyFile = $nameResidential."\n".
                        $floor_tower."\n".
                        $cant_towers."\n".
                        $cant_apartments;

            Storage::put('file.txt', $bodyFile);
            for ($i=0; $i < $data['towers'] ; $i++)
            {
                Tower::create([
                    'admin_id' => $admin->id,
                ]);
            }

            if ($data['admin'] == 1)
            {
                Owner::create([
                    'user_id' => $user->id,
                    'status' => false,
                ]);

                session()->put('admin_internal',1);
            }
        return $user;
    }
/*
    public function register(Request $request)
    {
            $nameResidential = $request->residential;
            $floor_tower = $request->floor_tower;
            $cant_towers = $request->towers;
            $cant_apartments = $request->apartment;

            if ($cant_apartments < $floor_tower)
            {
                return redirect()->route('register')->with('error','El numero de apartamentos no puede ser menor que la cantidad de pisos');
            }

            $people = People::create([
                "ci" => $request->ci,
                "name" => $request->name,
                "last_name" => $request->last_name,
                "birth" => Carbon::parse($request->date_birth)->format('Y-m-d'),
            ]);

            $user = User::create([
                "email" => $request->email,
                "password" => bcrypt($request->password),
                "people_id" => $people->id,
            ]);

            $user->roles()->attach($request->roles);

            $people->phones()->create([
                'number' => $request->phone,
            ]);
            $admin = Admin::create([
                'user_id' => $people->id,
            ]);


            $bodyFile = $nameResidential."\n".
                        $floor_tower."\n".
                        $cant_towers."\n".
                        $cant_apartments;

            Storage::put('file.txt', $bodyFile);
            for ($i=0; $i < $request->towers ; $i++)
            {
                Tower::create([
                    'admin_id' => $admin->id,
                ]);
            }

            if ($request->admin == 1)
            {
                Owner::create([
                    'user_id' => $user->id,
                    'status' => false,
                ]);

                session()->put('admin_internal',1);
            }
        event(new Registered($user));

        return redirect()->route('configTowersInitial');
    }*/
}
