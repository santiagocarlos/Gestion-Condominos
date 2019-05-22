@extends('adminlte::layouts.initial')

@section('htmlheader_title')
	Configura dónde vives
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		@if(session()->has('error'))
      <div class="callout callout-danger" role="alert">
         <h4>Error!</h4>
         {{ session('error') }}
      </div>
    @endif
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">Configura dónde vives</div>
						<div class="panel-body">
				            <form class="form-horizontal" action="{{ route('registerApartAdmin') }}" method="POST">
        						{!! csrf_field() !!}
				              <div class="box-body">
				              	    <div class="form-group">
						                  <label for="tower" class="col-sm-3 control-label">Torre </label>
						                  <div class="col-sm-9">
						                    <select class="form-control" name="tower_id">
						                    	<option value="0">Selecciona una Torre</option>
						                    	@foreach($towers as $tower)
						                    		<option value="{{ $tower->id }}">{{ $tower->name }}</option>
						                    	@endforeach
						                    </select>
						                  		<div class="errors">
																	  {{ $errors->first('tower_id') }}
																	</div>
						                  </div>
					                </div>

					                <div class="form-group">
					                	<label for="floor_tower" class="col-sm-3 control-label">Piso</label>
					                		<div class="col-sm-9">
						                		<select class="form-control" name="floor_tower">
						                			<option value="0">Selecciona un Piso</option>
						                			@for($i = 1; $i <= $array_file[1] ; $i++)
						                				<option value="{{ $i }}">{{ $i }}</option>
						                			@endfor
						                		</select>
						                			<div class="errors">
																	  {{ $errors->first('floor_tower') }}
																	</div>
					                		</div>
					                </div>

					                <div class="form-group">
					                	<label for="apartment" class="col-sm-3 control-label">Apartamento</label>
					                		<div class="col-sm-9">
						                			<input type="text" class="form-control" name="apartment">
						                			<div class="errors">
																	  {{ $errors->first('apartment') }}
																	</div>
					                		</div>
					                </div>

					                <div class="form-group">
					                	<label for="intercom" class="col-sm-3 control-label">Intercomunicador <small><i>(opcional)</i></small></label>
					                		<div class="col-sm-9">
						                			<input type="text" class="form-control" name="intercom">
						                			<div class="errors">
																	  {{ $errors->first('intercom') }}
																	</div>
					                		</div>
					                </div>

					                <div class="form-group">
					                	<label for="parking" class="col-sm-3 control-label">Puesto de Estacionamiento <small><i>(opcional)</i></small></label>
					                		<div class="col-sm-9">
						                			<input type="text" class="form-control" name="parking">
					                		</div>
					                </div>

					                <div class="form-group">
					                	<label for="aliquot" class="col-sm-3 control-label">Alícuota <small>(%)</small></label>
					                		<div class="col-sm-2">
						                			<input type="text" class="form-control" name="aliquot" onkeypress="return filterAliquot(event,this);">
						                			<div class="errors">
																	  {{ $errors->first('aliquot') }}
																	</div>
					                		</div>
					                </div>
						              	{{-- <div class="form-group">
						              		@if(count($errors) > 0)
														  	@if($errors->has('equals'))
													          <ul>
													              <li>
													                <span>{{ $errors->first('equals') }}</span>
													              </li>
													          </ul>
													        @endif
														  @endif
						              	</div> --}}
				              </div>

						          <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

				              <!-- /.box-body -->
				              <div class="box-footer">
				                <button type="submit" class="btn btn-success pull-right">Guardar</button>
				              </div>
				              <!-- /.box-footer -->
				            </form>
						</div>
				</div>
			</div>
		</div>
	</div>
@endsection
