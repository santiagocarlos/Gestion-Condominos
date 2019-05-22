@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Propietario</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.owners.update', $owner->id) }}" method="POST">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $owner->name or old('name') }}" placeholder="Nombre">
                      <div class="errors">
                        {{ $errors->first('name') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Apellido</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $owner->last_name or old('last_name') }}" placeholder="Apellido">
                        <div class="errors">
                          {{ $errors->first('last_name') }}
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="ci">Cédula <small><i>(sólo números)</i></small></label>
                      <input type="text" class="form-control" name="ci" id="ci" value="{{ $owner->ci or old('ci') }}" placeholder="Cédula">
                      <div class="errors">
                        {{ $errors->first('ci') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="birth">Fecha de Nacimiento</label>
                      <input type="text" class="form-control datepicker" name="birth" id="birth" value="{{ $owner->birth or old('birth') }}" placeholder="dd-mm-yyyy">
                      <div class="errors">
                        {{ $errors->first('birth') }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="email">Correo Electrónico</label>
                      <input type="text" class="form-control" name="email" id="email" value="{{ $owner->email or old('email') }}" placeholder="email@example.com">
                      <div class="errors">
                        {{ $errors->first('email') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Teléfono</label>
                      <input type="text" class="form-control" name="number" id="phone" value="{{ $owner->number or old('phone') }}" placeholder="0123-45678900">
                      <div class="errors">
                        {{ $errors->first('number') }}
                      </div>
                    </div>
                  </div>
                </div>

                <hr>
                <div class="box-header with-border">
                  <h3 class="box-title">Selecciona los apartamentos pertenecientes al propietario</h3>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="apartments">Apartamentos</label>
                      <select name="apartments[]" class="form-control" multiple>
                        <option value="0">Selecciona una/varias opciones</option>
                        @for($i = 0; $i < count($apartments_owner) ; $i++)
                          <option value="{{ $id_aparts[$i] }}" selected>{{ $apartments_owner[$i] }}</option>
                        @endfor
                        @foreach($apartments as $apartment)
                          <option value="{{ $apartment->id }}">{{ $apartment->name }} - {{ $apartment->floor }} - {{ $apartment->apartment }}</option>
                        @endforeach
                      </select>
                      <div class="errors">
                        {{ $errors->first('apartments') }}
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <br>
                    <p>
                      <i> <strong>Por favor vuelve a seleccionar los apartamentos <br> correspondientes a este propietario</strong> </i>
                      </p>
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
