<?php

namespace App\Http\Controllers;

use Alert;
use App\WaysToPay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class WaysToPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ways = WaysToPay::all();
        return view('admin.ways-to-pay.index', compact('ways'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.ways-to-pay.create');
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
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request)  {
            WaysToPay::create($request->all());
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.ways-to-pay.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\WaysToPay  $waysToPay
     * @return \Illuminate\Http\Response
     */
    public function show(WaysToPay $waysToPay)
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
        $way = WaysToPay::findOrFail($id_decrypt);

        return view('admin.ways-to-pay.edit', compact('way'));
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
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        DB::transaction(function () use ($request, $id)  {
            $way = WaysToPay::findOrFail($id);
            $way->update($request->all());
        });

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.ways-to-pay.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $way = WaysToPay::findOrFail($id)->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.ways-to-pay.index');
    }
}
