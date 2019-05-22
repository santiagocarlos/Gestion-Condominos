@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
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
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Apartamentos</h3>
            </div>
            @if($cant_apartments == 'full')
              <div class="col-md-5 col-md-push-3">
                <div class="alert alert-danger" role="alert">
                  Este piso ya esta lleno. Intenta con otro.
                </div>
              </div>
            @endif
            <form role="form" action="{{ route('admin.apartments.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                @for($i = 1 ; $i <= $cant_apartments ; $i++)
                <div class="row">
                  <div class="col-md-2"></div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="apartment">Apartamento</label>
                      <input type="text" name="apartment[{{ $i }}]" class="form-control" value="{{ old('apartment.'.$i) }}">
                        <div class="errors">
                          {{ $errors->first('apartment.'.$i) }}
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="intercom">Intercomunicador</label>
                      <input type="text" name="intercom[{{ $i }}]" class="form-control" value="{{ old('intercom.'.$i) }}">
                        <div class="errors">
                          {{ $errors->first('intercom.'.$i) }}
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="parking">Estacionamiento</label>
                      <input type="text" class="form-control" name="parking[{{ $i }}]" value="{{ old('parking.'.$i) }}">
                        <div class="errors">
                          {{ $errors->first('parking.'.$i) }}
                        </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                    <div class="form-group">
                      <label for="aliquot">Alícuota <small>(%)</small></label>
                      <input type="text" class="form-control" name="aliquot[{{ $i }}]" value="{{ old('aliquot.'.$i) }}" onkeypress="return filterAliquot(event,this);">
                        <div class="errors">
                          {{ $errors->first('aliquot.'.$i) }}
                        </div>
                    </div>
                  </div>
                </div>
                <hr>
              @endfor
              </div>
              <input type="hidden" name="tower_id" value="{{ $tower_id }}">
              <input type="hidden" name="floor" value="{{ $floor }}">
              <input type="hidden" name="cant_apartments" value="{{ $cant_apartments }}">
              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Siguiente</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
