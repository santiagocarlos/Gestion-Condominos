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
      <a href="{{ route('admin.owners.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Propietario"><i class="fa fa-plus"></i> Agregar Propietario</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Propietarios</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>Correo</th>
                 {{--  <th>Teléfono</th> --}}
                  <th>Propietario de Apartamento(s)</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($owners as $owner)
                <tr>
                  <td>{{ $owner->name }} {{ $owner->last_name }}</td>
                  <td>{{ $owner->email }}</td>
                  {{-- <td>{{ $owner->number }}</td> --}}
                  <td>
                      {!! $owner->apartments_owner !!}
                    </td>
                  <td>
                    <center>
                    {!!link_to_route('admin.owners.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($owner->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    <form style="display:inline" action="{{ route('admin.owners.destroy', $owner->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button type="submit" id="deleteButton" class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                    </center>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre y Apellido</th>
                  <th>Correo</th>
                  {{-- <th>Teléfono</th> --}}
                  <th>Propietario de Apartamento(s)</th>
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
