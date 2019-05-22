@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-9">
      <p></p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.invoices.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Factura"><i class="fa fa-plus"></i> Agregar Factura</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Listado de Facturas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th># Factura</th>
                  <th>Servicio - Compañía</th>
                  <th>Monto</th>
                  <th>Fecha</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                <tr>
                  <td><strong># {{ $invoice->nro_invoice }}</strong></td>
                  <td>{{ $invoice->expense->name }} - ({{ $invoice->expense->company }})</td>
                  <td>{{ $invoice->amount }} Bs</td>
                  <td>{{ $invoice->date->format('D, d F Y') }}</td>
                  <td>
                    {!!link_to_route('admin.invoices.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($invoice->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}

                    @if(\App\BillingNotice::whereYear('date', $invoice->date->format('Y'))
                                            ->whereMonth('date', $invoice->date->format('m'))->count() == 0)
                    <form style="display:inline" action="{{ route('admin.invoices.destroy', Crypt::encrypt($invoice->id)) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button type="submit" id="deleteButton" class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Servicio - Compañía</th>
                  <th>Descripción</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
