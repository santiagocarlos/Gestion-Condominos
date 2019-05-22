@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
      <a href="{{ route('admin.typeAdmin') }}">
        <button class="btn btn-success btn-block" title="Agregar Administrador"><i class="fa fa-plus"></i> Agregar Administrador</button>
      </a>
    </div>
   </div>
   <br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Administradores</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                  {{-- <th>Rol</th> --}}
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($admins as $admin)
                    <tr>
                        <td>{{ $admin->name }} {{ $admin->last_name }}</td>
                        <td>{{ $admin->email }}</td>
                        {{-- <td></td> --}}
                      <td>
                        {!!link_to_route('admin.admins.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($admin->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                        @if(Auth::user()->id != $admin->id)
                        <form style="display:inline" action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST">
                          {!! csrf_field() !!}
                          {!! method_field('DELETE') !!}
                          <button class="btn btn-danger" type="submit"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                        </form>
                        @endif
                      </td>
                    </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Correo</th>
                 {{--  <th>Rol</th> --}}
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
