<?php

namespace App\Http\Controllers;

use Alert;
use App\Apartment;
use App\Residential;
use App\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments = Apartment::getInfoTableApartments();
        return view('admin.apartments.index',compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $towers = Tower::all();
        $array_file = Residential::get();
        return view('admin.apartments.create',compact('towers','array_file'));
    }

    public function createByfloor(Request $request)
    {
        $cant_apartments = Apartment::checkAvailabilityByFloor($request->input('tower_id'), $request->input('floor'));
        $tower_id = base64_decode($request->input('tower_id'));
        $floor = base64_decode($request->input('floor'));

        return view('admin.apartments.create-apartments',compact('cant_apartments','tower_id','floor'));
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
            'apartment' => 'required|array',
            'apartment.*' => 'required|distinct',
            'intercom' => 'array',
            'aliquot' => 'required|array',
            'aliquot.*' => 'required|numeric',
        ],
        [
            'apartment.*.required' => 'Este campo es obligatorio',
            'apartment.*.distinct' => 'Los valores deben ser distintos',
            'aliquot.*.required' => 'Este campo es obligatorio',
            'aliquot.*.numeric' => 'Este campo solo acepta números',
        ]);

        if($validator->fails())
            return Redirect::route('admin.apartByFloor')->withErrors($validator)->withInput();

        $cant_apartments = $request->input('cant_apartments');

        for ($i=1; $i <= $cant_apartments ; $i++)
        {
            $apartments = Apartment::where('tower_id', $request->input('tower_id'))
                              ->where('floor', $request->input('floor'))
                              ->where('apartment', $request['apartment'][$i])
                              ->count();
            if ($apartments != 0)
            {
                return redirect()->back()->with('error', 'Uno de los apartamentos que intentas ingresar ya se encuentra registrado.');
            }
        }

        for ($i=1 ; $i <= $request->input('cant_apartments') ; $i++)
        {
            Apartment::create([
                'tower_id' => $request->input('tower_id'),
                'floor' => $request->input('floor'),
                'apartment' => $request['apartment'][$i],
                'intercom' => $request['intercom'][$i],
                'parking' => $request['parking'][$i],
                'aliquot' => $request['aliquot'][$i],
             ]);
        }

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.apartments.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
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
        $apartment = Apartment::getApartmentById($id);
        return view('admin.apartments.edit',compact('apartment'));
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
            'apartment' => 'required|string',
        ],
        [
            'apartment.required' => 'Este campo es obligatorio',
        ]);

        if($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput();
        }


        $data = $request->all();
        $apartment = Apartment::getApartment($data['tower_id'], $data['floor'], $data['apartment']);

        $apartment->update($request->only('apartment','intercom','parking'));

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.apartments.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $apartment = Apartment::findOrfail($id);

        $apartment->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.apartments.index');
    }
}
