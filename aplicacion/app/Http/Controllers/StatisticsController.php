<?php

namespace App\Http\Controllers;

use App\Admin;
use App\ArrearsInterests;
use App\Expense;
use App\Invoice;
use App\Owner;
use App\Payment;
use App\Statistics;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;


class StatisticsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cant_payments = Payment::all()->count();
        $cant_expenses = Expense::all()->count();
        $cant_defaulters = Owner::where('status', 1)->count();
        $cant_owners = Owner::all()->count();
        $cant_admins = Admin::all()->count();
        $acumulate_mora = ArrearsInterests::sum('surcharge');
        $acumulate_mora_round = round($acumulate_mora,2);
        $total_pays = Payment::sum('amount');

        return view('admin.statistics.index', compact(
            'cant_payments', 'cant_expenses', 'cant_owners', 'cant_defaulters', 'cant_admins', 'acumulate_mora_round', 'total_pays'
        ));
    }

    public function date_range()
    {
        return view('admin.statistics.dateRange');
    }


    public function graphicRange(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'date_start' => 'required|date_format:"d-m-Y"',
            'date_end' => 'required|date_format:"d-m-Y"|after_or_equal:date_start',
        ],
        [
            'date_start.required' => 'Este campo es obligatorio',
            'date_end.required' => 'Este campo es obligatorio',
            'date_start.date' => 'La fecha no tiene un formato válido',
            'date_end.date' => 'La fecha no tiene un formato válido',
            'date_end.after_or_equal' => 'La fecha fin no puede ser menor a la fecha de inicio',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        $data = $request->all();

        $date_from_carbon = Carbon::parse($data['date_start'])->format('Y-m-d');
        $date_from = strtotime($date_from_carbon);

        $date_to_carbon = Carbon::parse($data['date_end'])->format('Y-m-d');
        $date_to = strtotime($date_to_carbon);


        for ($i=$date_from; $i<=$date_to; $i+=86400)
        {
            $payment = Payment::where('date_pay', date("Y-m-d", $i))->count();
            if ($payment > 0)
            {
                $dates[] = date("Y-m-d", $i);
            }
        }

        $payments = Payment::where('date_pay','<=',$date_to_carbon)->where('date_pay','>=',$date_from_carbon)
                            ->groupBy('date_pay')->select(DB::raw('count(*) as total'))->orderBy('date_pay',"DESC")->get();

        foreach($payments as $pay)
        {
            $pays[] = $pay->total;
        }

        $chart1 = \Chart::title([
            'text' => '',
        ])
        ->chart([
            'type'     => 'line', // pie , columnt ect
            'renderTo' => 'chart1', // render the chart into your div with id
        ])
        ->subtitle([
            'text' => '',
        ])
        ->colors([
            '#0c2959'
        ])
        ->xaxis([
            'categories' =>
                $dates
            ,
            'labels'     => [
                'rotation'  => 15,
                'align'     => 'top',
                'formatter' => 'startJs:function(){return this.value}:endJs',
                // use 'startJs:yourjavasscripthere:endJs'
            ],
        ])
        ->yaxis([
            'text' => 'This Y Axis',
        ])
        ->legend([
            'layout'        => 'vertikal',
            'align'         => 'right',
            'verticalAlign' => 'middle',
        ])
        ->series(
            [
                [
                    'name'  => 'Pagos <br> Recibidos',
                    'data'  => $pays,
                    'color' => '#0c2959',
                ],
            ]
        )
        ->display();

        return view('admin.statistics.graphicRange', compact('chart1'));
    }

    public function typeExpense()
    {
        $expenses = Expense::where('common', 0)->get();
        return view('admin.statistics.typeExpense', compact('expenses'));
    }


    public function graphicExpense(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'expense_id' => 'required|not_in:0',
        ],
        [
            'expense_id.required' => 'Este campo es obligatorio',
            'expense_id.not_in' => 'Debes seleccionar una opción',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        $data = $request->all();

        $invoices = DB::select('
            SELECT SUBSTR(invoices.date,1,7) AS fecha,
            SUM(amount) as sum_a, expense_id
            FROM invoices WHERE expense_id = '.$request->input('expense_id').' GROUP BY expense_id,SUBSTR(invoices.date,1,7)
        ');

        for ($i=0; $i < count($invoices) ; $i++)
        {
            $dates[] = $invoices[$i]->fecha;
        }

        for ($i=0; $i < count($invoices) ; $i++)
        {
            $amount_t[] = (int) $invoices[$i]->sum_a;
        }

        $chart1 = \Chart::title([
            'text' => '',
        ])
        ->chart([
            'type'     => 'line', // pie , columnt ect
            'renderTo' => 'chart1', // render the chart into your div with id
        ])
        ->subtitle([
            'text' => '',
        ])
        ->colors([
            '#0c2959'
        ])
        ->xaxis([
            'categories' =>
                $dates
            ,
            'labels'     => [
                'rotation'  => 15,
                'align'     => 'top',
                'formatter' => 'startJs:function(){return this.value}:endJs',
                // use 'startJs:yourjavasscripthere:endJs'
            ],
        ])
        ->yaxis([
            'text' => 'This Y Axis',
        ])
        ->legend([
            'layout'        => 'vertikal',
            'align'         => 'right',
            'verticalAlign' => 'middle',
        ])
        ->series(
            [
                [
                    'name'  => 'Monto <br> Mensual',
                    'data'  => $amount_t,
                    'color' => '#0c2959',
                ],
            ]
        )
        ->display();

        return view('admin.statistics.graphicExpense', compact('chart1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function show(Statistics $statistics)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function edit(Statistics $statistics)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Statistics $statistics)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Statistics  $statistics
     * @return \Illuminate\Http\Response
     */
    public function destroy(Statistics $statistics)
    {
        //
    }
}
