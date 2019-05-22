<?php

namespace App\Http\Controllers;
use Alert;
use App\Apartment;
use App\Owner;
use App\Residential;
use App\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminConfigInitialController extends Controller
{
    //
    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $towers = Tower::all();
        return view('admin.config.towers',compact('towers'));
    }

    public function storeTowers(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'towers' => 'required|array',
            'towers.*' => 'required|string',
        ],
        [
            'towers.*.required' => 'El nombre de las torres es obligatorio',
        ]);

        $flag = false;

        foreach($request['towers'] as $index => $value)
        {
            if ($request['towers'][$index] != $request['towers'][$index+1])
            {
                break;
            }
            if( ($request['towers'][$index] == $request['towers'][$index+1]))
            {
                $flag = true;
                break;
            }
        }

        if($validator->fails() || $flag)
        {
            foreach($request['towers'] as $index => $value)
            {
                if ($request['towers'][$index] != $request['towers'][$index+1])
                {
                    break;
                }
                if( ($request['towers'][$index] == $request['towers'][$index+1]))
                {
                    $validator->getMessageBag()->add("equals",'Las torres no pueden llamarse iguales');
                    break;
                }
            }
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data = $request->all();

        foreach ($data['towers'] as $key => $value)
        {
           $tower = Tower::findOrFail($key);
           $tower->name = $value;
           $tower->save();
        }
        if (session('admin_internal') === 1)
        {
          return redirect()->route('apartAdmin');
        }
        return redirect()->route('config.initialPaymentDeadline');
    }

    public function apartAdmin()
    {
      $towers = Tower::all();

      $array_file = Residential::get();

      return view('admin.config.apartmentAdmin',compact('towers','array_file'));
    }

    public function registerApartAdmin(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'tower_id' => 'required|numeric|not_in:0|digits_between:1,10',
          'floor_tower' => 'required|numeric|not_in:0|digits_between:1,11',
          'apartment' => 'required',
          'aliquot' => 'required|numeric'
      ],
      [
          'tower_id.not_in' => 'Debes elegir la torre donde vives',
          'floor_tower.not_in' => 'Debes elegir el piso donde vives',
          'apartment.required' => 'El apartamento es obligatorio',
          'aliquot.required' => 'Este campo es requerido'
      ]);

      if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();

      $data = $request->all();
      $apartment = Apartment::where('tower_id', $data['tower_id'])
                              ->where('floor', $data['floor_tower'])
                              ->where('apartment', $data['apartment'])
                              ->count();

      if ($apartment != 0)
      {
        return redirect()->back()->with('error', 'El apartamento que intentas ingresar ya se encuentra registrado');
      }

      DB::transaction(function () use ($request)  {
        $apartment = Apartment::create([
          'tower_id' => $request->input('tower_id'),
          'floor' => $request->input('floor_tower'),
          'apartment' => $request->input('apartment'),
          'intercom' => $request->input('intercom'),
          'parking' => $request->input('parking'),
          'aliquot' => $request->input('aliquot'),
        ]);

      $owner = Owner::all()->first();
      $owner->apartment_id = $apartment->id;
      $owner->save();
      });

      return redirect()->route('config.initialPaymentDeadline');
    }

    public function initialPaymentDeadline()
    {
      return view('admin.config.initialPaymentDeadline');
    }

    public function paymentDeadline()
    {
      return view('admin.config.paymentDeadline');
    }

    public function storeMoorInterestConfigurationInitial(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'deadline_id' => 'required|not_in:0',
          'percentage' => 'required|numeric'
      ],
      [
          'deadline_id.required' => 'Este campo es obligatorio',
          'deadline_id.not_in' => 'Debes elegir la torre donde vives',
          'percentage.required' => 'Este campo es obligatorio',
          'percentage.numeric' => 'Solo se aceptan números'
      ]);

      if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();

      $data = $request->all();

      $deadline = $data['deadline_id'];
      $percentage = $data['percentage'];

      $bodyFile = $deadline."\n".
                  $percentage;

      $save = Storage::append('file.txt', $bodyFile);
      if ($save)
      {
        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('routeHome');
      }
    }

    public function storeMoorInterestConfiguration(Request $request)
    {
      $validator = Validator::make($request->all(),[
          'deadline_id' => 'required|not_in:0',
          'percentage' => 'required|numeric'
      ],
      [
          'deadline_id.required' => 'Este campo es obligatorio',
          'deadline_id.not_in' => 'Debes elegir la torre donde vives',
          'percentage.required' => 'Este campo es obligatorio',
          'percentage.numeric' => 'Solo se aceptan números'
      ]);

      if($validator->fails())
          return Redirect::back()->withErrors($validator)->withInput();

      $data = $request->all();

      $deadline = $data['deadline_id'];
      $percentage = $data['percentage'];

      $bodyFile = $deadline."\n".
                  $percentage;

      $save = Storage::append('file.txt', $bodyFile);
      if ($save)
      {
        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.config.indexPayConfiguration');
      }
    }

    public function updatePaymentDeadline(Request $request)
    {
      $residential = Residential::get();

      $nameResd = $residential[0];
      $floors = $residential[1];
      $towers = $residential[2];
      $aptos_by_tower = $residential[3];
      $day_deadline = $request->input('deadline_id');
      $percentage = $request->input('percentage');

      $bodyFile = $nameResd."\n".
                  $floors."\n".
                  $towers."\n".
                  $aptos_by_tower."\n\n".
                  $day_deadline."\n".
                  $percentage;

      Residential::deleteConfig();
      Storage::put('file.txt', $bodyFile);

      Alert::success('Guardado exitosamente!')->persistent("Cerrar");
      return redirect()->route('admin.config.indexPayConfiguration');
    }


}
