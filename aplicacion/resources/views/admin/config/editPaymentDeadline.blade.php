@extends('adminlte::layouts.app')

@section('htmlheader_title')
  {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
  <div class="container-fluid spark-screen">
   <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Configurar Fecha Límite para los Pagos Mensuales</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <br><br>
            <form role="form" action="{{ route('admin.config.updatePaymentDeadlineConfiguration') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6 col-md-push-3">
                    <div class="form-group">
                      <p style="text-align: center; font-weight: bold;">La fecha límite para los pagos será los días</p>
                      <div class="col-md-5 col-md-push-3">
                        <select class="form-control" name="deadline_id">
                          <option value="0">Seleccione Una</option>
                          @for($i= 1; $i <= 31 ; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endfor
                        </select>
                      <p style="text-align: center; font-weight: bold; margin-top: 10px;"><strong>de cada mes</strong></p>
                      </div>
                      <br>
                        <div class="errors">
                          {{ $errors->first('tower_id') }}
                        </div>
                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-3 col-md-push-4 form-group">
                    <label>Porcentaje de penalización de morosidad <br><small>(solo números)</small></label>
                    <input type="text" name="percentage" class="form-control" onkeypress="return filterAliquot(event,this);">
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-share"></i> Guardar</button>
              </div>
            </form>
          </div>
   </div>
  </div>
@endsection
