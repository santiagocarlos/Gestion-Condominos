<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.3/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Role;
use App\Tower;
use App\BackupRol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('adminlte::home');
    }

    public function select()
    {
        $roles = DB::table('roles')
            ->join('role_user', 'roles.id', '=', 'role_user.role_id')
            ->select('roles.name', 'roles.id','roles.display_name')
            ->where('role_user.user_id', '=', Auth::user()->id)
            ->get();

            return view('select', compact('roles'));
    }

    public function select_store(Request $request)
    {
        $role = Role::findOrFail($request->rol);
        $request->session()->put('user.role', $role); // guardamos rol del usuario en session

        $user_roles = DB::table('role_user')
            ->select('role_id')
            ->where('user_id', '=', Auth::user()->id)
            ->pluck('role_id');

        foreach ($user_roles as $value)
        {
            if ($request->rol != $value)
            {
                $br = new BackupRol;
                $br->user_id = Auth::user()->id;
                $br->role_id = $value;
                $br->save();
            }
        }

        DB::table('role_user')->where('role_id', '!=', $request->rol)->where('user_id', '=', Auth::user()->id)->delete();

        if ($role->id == "1")
        {
            return redirect('/home');
        }
        if ($role->id == "2")
        {
            return redirect()->route('owners.owners.home');
        }
    }


}