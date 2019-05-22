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
      <a href="{{ route('admin.billing-notices.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Cobro"><i class="fa fa-plus"></i> Agregar Cobro</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Avisos de Cobro</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th># Número</th>
                  <th>Apartamento</th>
                  <th>Monto</th>
                  <th>Estado</th>
                  <th>Mes</th>
                  {{-- <th>Acciones</th> --}}
                </tr>
                </thead>
                <tbody>
                @foreach($billing_notices as $billing_notice)
                <tr>
                  <td><strong>#</strong> {{ $billing_notice->nro }}</td>
                  <td>{{ $billing_notice->name }} - {{ $billing_notice->floor }} - {{ $billing_notice->apartment }}</td>
                  <td>{{ $billing_notice->amount }}</td>
                  <td>
                    @if($billing_notice->status == "0")
                      <center>
                        <small class="label bg-red">no pagada</small>
                      </center>
                    @endif
                    @if($billing_notice->status == "1")
                      <center>
                        <small class="label pull-right bg-yellow">pagada parcialmente</small>
                      </center>
                    @endif
                    @if($billing_notice->status == "2")
                      <center>
                        <small class="label pull-right bg-green">pagada</small>
                      </center>
                    @endif
                  </td>
                  <td>{{ $billing_notice->date->format('F Y') }}</td>
                  {{-- <td>
                    <center>
                    {!!link_to_route('admin.common-areas.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($area->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    <form style="display:inline" action="" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                  </center>
                  </td> --}}
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Número</th>
                  <th>Apartamento</th>
                  <th>Monto</th>
                  <th>Estado</th>
                  <th>Mes</th>
                  {{-- <th>Acciones</th> --}}
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
