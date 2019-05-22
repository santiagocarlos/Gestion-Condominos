<?php

namespace App\Http\Controllers;

use Alert;
use App\Admin;
use App\People;
use App\Tower;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TowersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $towers = Tower::getTowers_Admin();
        return view('admin.towers.index',compact('towers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admins = Admin::join('users','admins.id','=','users.id')
                        ->join('peoples','users.id','=','peoples.id')->get();
        return view('admin.towers.create',compact('admins'));
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
            'admin_id' => 'required|not_in:0',
            'tower' => 'required|string|unique:towers,name',
        ],
        [
            'admin_id.not_in' => 'Debes elegir el administrador para esta torre',
            'tower_id.required' => 'Ocurrió un error',
            'tower.required' => 'El nombre de la torre es obligatorio',
            'tower.unique' => 'La torre que ingresaste ya se encuentra registrada',
        ]);
        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request)  {
            Tower::create([
                'name' => $request->input('tower'),
                'admin_id' => base64_decode($request->input('admin_id')),
            ]);
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.towers.index');
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
        $tower = Tower::getTowerById($id);

        $admins = Admin::join('users','admins.user_id','=','users.id')
                         ->join('peoples','users.id','=','peoples.id')->get();

        return view('admin.towers.edit',compact('tower','admins'));
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
        $validator = Validator::make($request->all(),[
            'admin_id' => 'required|not_in:0',
            'tower' => 'required|string',
        ],
        [
            'admin_id.not_in' => 'Debes elegir un administrador',
            'tower.required' => 'El nombre de la torre es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        $tower = Tower::findOrFail($id);
        $tower->name = $request->input('tower');
        $tower->admin_id = base64_decode($request->input('admin_id'));

        $tower->save();
        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.towers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tower = Tower::findOrFail($id)->delete();
        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.towers.index');
    }
}
