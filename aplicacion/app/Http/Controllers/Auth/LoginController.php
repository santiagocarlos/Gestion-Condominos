<?php

namespace App\Http\Controllers\Auth;

use App\BackupRol;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('adminlte::auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/select';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function logout()
    {
        $br = BackupRol::where('user_id','=',Auth::user()->id)->get();

        foreach ($br as $value)
        {
            DB::table('role_user')->insert([
                [
                    'user_id'=>$value->user_id,
                    'role_id'=>$value->role_id
                ]
            ]);
            $value->delete();
        }
        Auth::logout();

        return redirect('/login');
    }
}
