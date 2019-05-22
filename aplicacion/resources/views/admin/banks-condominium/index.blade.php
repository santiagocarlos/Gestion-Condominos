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
      <a href="{{ route('admin.banks-condominium.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Banco"><i class="fa fa-plus"></i> Agregar Cuenta</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Cuentas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Banco</th>
                  <th>Nro. De Cuenta</th>
                  <th>Titular</th>
                  <th>Identificación</th>
                  <th>E-mail</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($banks as $bank)
                <tr>
                  <td>{{ $bank->name }}</td>
                  <td>{{ $bank->account_number }}</td>
                  <td>{{ $bank->holder }}</td>
                  <td>{{ $bank->dni }}</td>
                  <td>{{ $bank->email }}</td>
                  <td>
                    <center>
                    {!!link_to_route('admin.banks-condominium.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($bank->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    <form style="display:inline" action="{{ route('admin.banks-condominium.destroy', $bank->id) }}" method="POST">
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
                  <th>Banco</th>
                  <th>Nro. De Cuenta</th>
                  <th>Titular</th>
                  <th>Identificación</th>
                  <th>E-mail</th>
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
