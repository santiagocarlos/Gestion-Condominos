<?php

namespace App\Http\Controllers;

use Alert;
use App\CommonAreas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class CommonAreasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $areas = CommonAreas::all();
        return view('admin.common-areas.index',compact('areas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.common-areas.create');
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
            CommonAreas::create([
                'name' => $request->input('name'),
            ]);
        });

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.common-areas.index');
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $area = CommonAreas::findOrFail($id_decrypt);
        return view('admin.common-areas.edit',compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
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

        $area = CommonAreas::findOrFail($id);
        $area->update($request->all());

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.common-areas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $area = CommonAreas::findOrFail($id);
        $area->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.common-areas.index');
    }
}
