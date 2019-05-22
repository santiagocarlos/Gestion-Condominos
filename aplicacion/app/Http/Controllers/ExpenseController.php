<?php

namespace App\Http\Controllers;

use Alert;
use App\Apartment;
use App\BillingNotice;
use App\Expense;
use App\Invoice;
use App\Tower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with("towers","apartments","invoices")->get();
        return view('admin.expenses.index',compact("expenses"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $towers = Tower::select('id','name')->get();
        $apartments = Apartment::getApartmentsSelectMultiple();
        return view('admin.expenses.create', compact('towers','apartments'));
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
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'common' => 'required',
            'towers' => 'array|not_in:0',
            'apartments' => 'array|not_in:0',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
            'company.required' => 'Este campo es obligatorio',
            'common.required' => 'Debes seleccionar una opción',
            'towers.not_in' => 'Debes elegir una o varias opciones',
            'apartments.not_in' => 'Debes elegir una o varias opciones',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        Expense::insertExpense($request);

        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.expenses.index');
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
        return Expense::editExpense($id);
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
            'name' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'common' => 'required',
            'towers' => 'array|not_in:0',
        ],
        [
            'name.required' => 'Este campo es obligatorio',
            'company.required' => 'Este campo es obligatorio',
            'common.required' => 'Debes seleccionar una opción',
            'towers.not_in' => 'Debes elegir una o varias opciones',
        ]);

        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        Expense::updateExpense($request, $id);

        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.expenses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //$invoice = Invoice::where('expense_id', '=', $id)->first();
        $expense = Expense::findOrFail($id);
        $expense->delete();

        //$billing = BillingNotice::whereYear('date', '=', date('Y', strtotime($invoice->date)))->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.expenses.index');
    }
}
