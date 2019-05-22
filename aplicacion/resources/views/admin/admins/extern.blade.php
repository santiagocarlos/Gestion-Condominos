@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Administrador Externo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.admins.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" placeholder="Nombre">
                      <div class="errors">
                        {{ $errors->first('name') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Apellido</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Apellido">
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
                      <input type="text" class="form-control" name="ci" id="ci" value="{{ old('ci') }}" placeholder="Cédula">
                      <div class="errors">
                        {{ $errors->first('ci') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="birth">Fecha de Nacimiento</label>
                      <input type="text" class="form-control datepicker" name="birth" id="birth" value="{{ old('birth') }}" placeholder="dd-mm-yyyy">
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
                      <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="email@example.com">
                      <div class="errors">
                        {{ $errors->first('email') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Teléfono</label>
                      <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}" placeholder="0123-45678900">
                      <div class="errors">
                        {{ $errors->first('phone') }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password">Contraseña</label>
                      <input type="password" name="password" class="form-control input-lg" placeholder="Contraseña">
                      <div class="errors">
                        {{ $errors->first('password') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="password_confirmation">Confirmar Contraseña</label>
                      <input type="password" name="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña">
                      <div class="errors">
                        {{ $errors->first('password_confirmation') }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="role">Tipo de Administrador</label>
                      <select class="form-control" name="role[]">
                        <option value="0">Selecciona Uno</option>
                        @foreach($roles as $role)
                          <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                      </select>
                      <div class="errors">
                        {{ $errors->first('role') }}
                      </div>
                    </div>
                  </div>
                  <input type="hidden" name="extern" value="1">
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
