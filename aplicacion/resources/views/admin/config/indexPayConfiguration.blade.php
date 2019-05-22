@extends('adminlte::layouts.app')

@section('htmlheader_title')
  {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
  <div class="container-fluid spark-screen">
    <div class="col-md-11"></div>
    <div class="col-md-1">
      <a href="{{ route('admin.config.editPaymentDeadlineConfiguration') }}">
        <button class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>
      </a>
    </div>
    <br><br><br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Fecha Límite Pagos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Día</th>
                  {{-- <th>Acciones</th> --}}
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Los {{ $residential[4] }} de cada mes</td>
                    {{-- <td>
                      <a href="{{ route('admin.config.editPaymentDeadlineConfiguration') }}">
                        <button class="btn btn-warning"><i class="fa fa-edit"></i> Editar</button>
                      </a>
                    </td> --}}
                  </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>Día</th>
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
