@extends('adminlte::layouts.initial')

@section('htmlheader_title')
	Configurar Fecha Límite para los Pagos Mensuales
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">Configurar Fecha Límite para los Pagos Mensuales</div>
						<div class="panel-body">
				      <form role="form" action="{{ route('config.storeMoorInterestConfigurationInitial') }}" method="POST">
	              {!! csrf_field() !!}
	              <div class="box-body">
	                <div class="row">
	                  <div class="col-md-6 col-md-push-3">
	                    <div class="form-group">
	                      <p style="text-align: center; font-weight: bold;">La fecha límite para los pagos será los días</p>
	                      <div class="col-md-8 col-md-push-2">
	                        <select class="form-control" name="deadline_id">
	                          <option value="0">Seleccione Una</option>
	                          @for($i= 01; $i <= 31 ; $i++)
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
            	</form>
						</div>
				</div>
			</div>
		</div>
	</div>
@endsection
