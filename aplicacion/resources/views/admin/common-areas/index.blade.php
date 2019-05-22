@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-9">
      <p>Las áreas comunes son las áreas que comparten todos los habitantes del conjunto residencial, éstas pueden ser: Canchas, Piscinas, Parilleras, Parques, entre otros. <i>Por favor agrega las áreas comúnes para este conjunto residencial.</i></p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.common-areas.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Área Común"><i class="fa fa-plus"></i> Agregar Área Común</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Áreas Comunes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($areas as $area)
                <tr>
                  <td>{{ $area->name }}</td>
                  <td>
                    {!!link_to_route('admin.common-areas.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($area->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    <form style="display:inline" action="{{ route('admin.common-areas.destroy',$area->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                  </td>
                </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
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
