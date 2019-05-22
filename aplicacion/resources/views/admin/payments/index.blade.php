
@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    @if(session()->has('error'))
      <div class="callout callout-danger" role="alert">
         <h4>Error!</h4>
         {{ session('error') }}
      </div>
    @endif
    <div class="row">
    <div class="col-md-6">
      <p></p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.payments.unconfirmed') }}">
        <button class="btn btn-warning btn-block" title="Ver Pagos No Confirmados"><i class="fa fa-eye"></i> Ver Pagos No Confirmados</button>
      </a>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.payments.createOwner') }}">
        <button class="btn btn-success btn-block" title="Agregar Pago"><i class="fa fa-plus"></i> Agregar Pago</button>
      </a>
    </div>
    @if(session()->has('error'))
      <div class="callout callout-danger" role="alert">
         <h4>Error!</h4>
         {{ session('error') }}
      </div>
    @endif
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Pagos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Número de Comprobante</th>
                  <th>Monto</th>
                  <th>Forma de Pago</th>
                  <th>Banco</th>
                  <th>Fecha de Pago</th>
                  <th>Estado</th>
                  <th>Fecha de Confirmación</th>
                  <th width="150px">Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($payments as $payment)
                <tr>
                  <td><center>{{ $payment->nro_confirmation }}</center></td>
                  <td>{{ $payment->amount }} Bs</td>
                  <td>{{ $payment->nameWayToPay }}</td>
                  <td>{{ $payment->nameBank }}</td>
                  <td>{{ $payment->date_pay->format('l d, F Y') }}</td>
                  <td>
                    @if($payment->date_confirm == NULL)
                        <center>
                          <span class="label label-danger">sin confirmación</span>
                        </center>
                      @endif
                      @if($payment->date_confirm != NULL)
                        <center>
                          <span class="label label-success">confirmado</span>
                        </center>
                      @endif
                  </td>
                  <td>
                    @if($payment->date_confirm == null)
                      <center>
                        <span class="label label-danger">sin confirmación</span>
                      </center>
                    @endif
                    @if($payment->date_confirm != null)
                      {{ \Carbon\Carbon::parse($payment->date_confirm)->format('d-m-Y') }}
                    @endif
                  </td>
                  <td>
                    <center>
                      <a href="{{ route('admin.payments.show', Crypt::encrypt($payment->id)) }}">
                        <button class="btn btn-success" title="Ver"><span class="fa fa-eye"></span></button>
                      </a>
                      <a href="{{ route('admin.payments.confirm', Crypt::encrypt($payment->id)) }}">
                        <button class="btn btn-warning" title="Confimar Pago"><span class="fa fa-check"></span></button>
                      </a>
                      <form style="display:inline" action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST">
                          {!! csrf_field() !!}
                          {!! method_field('DELETE') !!}
                        <button class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span></button>
                      </form>
                    </center>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Número de Comprobante</th>
                  <th>Monto</th>
                  <th>Forma de Pago</th>
                  <th>Banco</th>
                  <th>Fecha de Pago</th>
                  <th>Estado</th>
                  <th>Fecha de Confirmación</th>
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
