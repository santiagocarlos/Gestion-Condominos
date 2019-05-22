@extends('adminlte::layouts.initial')

@section('htmlheader_title')
	Configurar Torres
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="panel panel-default">
					<div class="panel-heading">Configurar Torres</div>
						<div class="panel-body">
				            <form class="form-horizontal" action="{{ route('registerTowers') }}" method="POST">
        						{!! csrf_field() !!}
				              <div class="box-body">
				              	@foreach($towers as $tower)
					                <div class="form-group">
					                  <label for="inputEmail3" class="col-sm-3 control-label">Nombre Torre {{ $tower->id }}</label>
					                  <div class="col-sm-9">
					                    <input type="text" class="form-control" name="towers[{{ $tower->id }}]" placeholder="Nombre">
					                  </div>
					                </div>
				              	@endforeach
				              	<div class="form-group">
				              		@if(count($errors) > 0)
												  	@if($errors->has('equals'))
											          <div class="alert alert-danger" role="alert">
											             {{ $errors->first('equals') }}
											          </div>
											        @endif
												  @endif
				              	</div>
				              </div>
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
