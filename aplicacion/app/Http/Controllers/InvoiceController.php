<?php

namespace App\Http\Controllers;

use Alert;
use App\Expense;
use App\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('expense')->get();
        //dd($invoices);
        return view('admin.invoices.index',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $expenses = Expense::getExpensesCompanyTowersAptos(0, 1, 2);
        return view('admin.invoices.create', compact('expenses'));
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
            'nro_invoice' => 'required|numeric',
            'expense_id' => 'required|not_in:0|numeric',
            'date' => 'required|date_format:"d-m-Y"',
            'amount' => 'required|numeric',
        ],
        [
            'nro_invoice.required' => 'Este campo es obligatorio',
            'nro_invoice.numeric' => 'Este campo solo acepta números',
            'expense_id.required' => 'Debes seleccionar una opción',
            'expense_id.not_in' => 'Debes seleccionar una opción',
            'date.required' => 'Este campo es obligatorio',
            'date.date_format' => 'La fecha no cumple con el formato adecuado',
            'amount.required' => 'Este campo es obligatorio',
            'amount.numeric' => 'Este campo solo acepta números',
        ]);
        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        $date = explode('-', $request->date);
        $month = $date[1];
        $year  = $date[2];

        $monthCharged = Invoice::verifyInvoiceMonthCharged($month, $year);

        if ($monthCharged >= 1)
            return redirect()->route('admin.invoices.create')->with('error','No se puede ingresar esta factura. Para el mes de esta factura ya fueron generados los cobros correspondientes.');

        $data = $request->all();
        Invoice::insertInvoice($data);
        Alert::success('Guardado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
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
        $invoice = Invoice::with('expense:id,name,company')->findOrFail($id_decrypt);
        $expenses = Expense::select('id','name','company')->get();
        return view('admin.invoices.edit',compact('invoice','expenses'));
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
            'nro_invoice' => 'required|numeric',
            'expense_id' => 'required|not_in:0|numeric',
            'date' => 'required|date_format:"d-m-Y"',
            'amount' => 'required|numeric',
        ],
        [
            'nro_invoice.required' => 'Este campo es obligatorio',
            'nro_invoice.numeric' => 'Este campo solo acepta números',
            'expense_id.required' => 'Debes seleccionar una opción',
            'expense_id.not_in' => 'Debes seleccionar una opción',
            'date.required' => 'Este campo es obligatorio',
            'date.date_format' => 'La fecha no cumple con el formato adecuado',
            'amount.required' => 'Este campo es obligatorio',
            'amount.numeric' => 'Este campo solo acepta números',
        ]);
        if($validator->fails())
            return Redirect::back()->withErrors($validator)->withInput();

        Invoice::updateInvoice($id, $request);
        Alert::success('Editado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.invoices.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id_decrypt = Crypt::decrypt($id);
        $invoice = Invoice::findOrFail($id_decrypt);
        $invoice->delete();

        Alert::success('Eliminado exitosamente!')->persistent("Cerrar");
        return redirect()->route('admin.invoices.index');
    }
}
