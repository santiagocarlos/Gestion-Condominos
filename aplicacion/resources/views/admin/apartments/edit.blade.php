@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Apartamento</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.apartments.update',$apartment->id) }}" method="POST">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tower">Torre</label>
                    <select class="form-control" name="tower_id" readonly="readonly">
                      <option value="{{ $apartment->tower_id }}">{{ $apartment->name }}</option>
                     {{--  @foreach($towers as $tower)
                      <option value="{{ base64_encode($tower->id) }}">{{ $tower->name }}</option>
                      @endforeach --}}
                    </select>
                      <div class="errors">
                        {{ $errors->first('tower_id') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="floor">Piso</label>
                    <select class="form-control" name="floor" readonly="readonly">
                      <option value="{{ $apartment->floor }}">Piso {{ $apartment->floor }}</option>
                      {{-- @for($i = 1; $i <= $residential[1] ; $i++)
                      <option value="{{ base64_encode($i) }}">Piso {{ $i }}</option>
                      @endfor --}}
                    </select>
                      <div class="errors">
                        {{ $errors->first('floor') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="apartment">Apartamento</label>
                  <input type="text" name="apartment" class="form-control" value="{{ $apartment->apartment }}">
                  <div class="errors">
                        {{ $errors->first('apartment') }}
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="intercom">Intercomunicador</label>
                  <input type="text" name="intercom" class="form-control" value="{{ $apartment->intercom or old('intercom') }}">
                  <div class="errors">
                        {{ $errors->first('intercom') }}
                  </div>
                </div>
                <div class="col-md-4">
                  <label for="parking">Estacionamiento</label>
                  <input type="text" name="parking" class="form-control" value="{{ $apartment->parking or old('parking') }}">
                  <div class="errors">
                        {{ $errors->first('parking') }}
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar Información</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
