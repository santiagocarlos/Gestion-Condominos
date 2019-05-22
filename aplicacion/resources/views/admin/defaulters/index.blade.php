@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-9">
    </div>
    <div class="col-md-3">
      {{-- <a href="{{ route('admin.common-areas.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Área Común"><i class="fa fa-plus"></i> Agregar Área Común</button>
      </a> --}}
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Morosos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Cédula</th>
                  <th>Nombre</th>
                  <th>Torre</th>
                  <th>Apartamento</th>
                  <th>Recibo en Mora</th>
                  <th>Mes</th>
                  <th>Mora Acumulada</th>
                </tr>
                </thead>
                <tbody>
                @foreach($defaulters as $defaulter)
                <tr>
                  <td>{{ $defaulter->ci }}</td>
                  <td>{{ $defaulter->name }} {{ $defaulter->last_name }}</td>
                  <td><center>{{ $defaulter->towerName }}</center></td>
                  <td><center>{{ $defaulter->floor }} - {{ $defaulter->apartment }}</center></td>
                  <td>#{{ $defaulter->nro }} - ({{ $defaulter->amount }} Bs)</td>
                  <td>{{ $defaulter->date->format('F Y') }}</td>
                  <td>{{ $defaulter->surcharge }} Bs</td>
                  {{-- <td>
                    {!!link_to_route('admin.common-areas.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($area->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    <form style="display:inline" action="" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                  </td> --}}
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Cédula</th>
                  <th>Nombre</th>
                  <th>Torre</th>
                  <th>Apartamento</th>
                  <th>Recibo en Mora</th>
                  <th>Mes</th>
                  <th>Mora Acumulada</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
