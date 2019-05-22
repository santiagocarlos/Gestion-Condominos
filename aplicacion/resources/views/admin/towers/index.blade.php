@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
    <div class="col-md-10">
    </div>
    <div class="col-md-2">
      <a href="{{ route('admin.towers.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Torre"><i class="fa fa-plus"></i> Agregar</button>
      </a>
    </div>
   </div>
   <br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Torres</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  {{-- <th>Administrador</th> --}}
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($towers as $tower)
                    <tr>
                        <td><center>{{ $tower->name }}</center></td>
                        {{-- <td>{{ $tower->name }} {{ $tower->last_name }}</td> --}}
                      <td align="center">
                        {!!link_to_route('admin.towers.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($tower->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                        {{-- <a href="{{ route('admin.towers.edit',$tower->tower_id) }}">
                          <button class="btn btn-warning"><span class="fa fa-edit" title="Editar"></span></button>
                        </a> --}}
                        @if(count($tower->apartments) == 0)
                        <form style="display:inline" action="{{ route('admin.towers.destroy',$tower->id) }}" method="POST">
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
                  {{-- <th>Administrador</th> --}}
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
