@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-9">
      <p>Se listan por torre los apartamentos.</i></p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.apartments.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Apartamento"><i class="fa fa-plus"></i> Agregar Apartamento</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Apartamentos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Torre</th>
                  <th>Piso</th>
                  <th>Apartamento</th>
                  <th>Alícuota</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  @foreach($apartments as $apartment)
                  <td><center>{{ $apartment->name }}</center></td>
                  <td><center>{{ $apartment->floor }}</center></td>
                  <td><center>{{ $apartment->apartment }}</center></td>
                  <td><center>{{ $apartment->aliquot }}%</center></td>
                  <td>
                    <center>
                    {!!link_to_route('admin.apartments.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($apartment->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    @if($apartment->billing_notices->count() == 0)
                    <form style="display:inline" action="{{ route('admin.apartments.destroy',$apartment->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button type="submit" id="deleteButton" class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                    @endif
                    </center>
                  </td>
                </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Torre</th>
                  <th>Piso</th>
                  <th>Apartamento</th>
                  <th>Alícuota</th>
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
