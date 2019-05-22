@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Administrador Externo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.admins.update', $admin->id) }}" method="POST">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $admin->name or old('name') }}" placeholder="Nombre">
                      <div class="errors">
                        {{ $errors->first('name') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Apellido</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $admin->last_name or old('last_name') }}" placeholder="Apellido">
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
                      <input type="text" class="form-control" name="ci" id="ci" value="{{ $admin->ci or old('ci') }}" placeholder="Cédula">
                      <div class="errors">
                        {{ $errors->first('ci') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="birth">Fecha de Nacimiento</label>
                      <input type="text" class="form-control datepicker" name="birth" id="birth" value="{{ $admin->birth_formated or old('birth') }}" placeholder="dd-mm-yyyy">
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
                      <input type="text" class="form-control" name="email" id="email" value="{{ $admin->email or old('email') }}" placeholder="email@example.com">
                      <div class="errors">
                        {{ $errors->first('email') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Teléfono</label>
                      <input type="text" class="form-control" name="number" id="phone" value="{{ $admin->number or old('number') }}" placeholder="0123-45678900">
                      <div class="errors">
                        {{ $errors->first('number') }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-6">
                      <label for="role">Tipo de Administrador</label>
                      <br><br>
                      <div class="form-group">
                          @foreach ($roles as $id => $name)
                          <label>
                            <input type="checkbox"
                            value="{{ $id }}"
                            {{ $user->roles->pluck('id')->contains($id) ? 'checked' : '' }}
                            name="roles[]">
                            {{ $name }} <br>
                          </label>
                        @endforeach
                        <div class="errors">
                          {!! $errors->first('roles', '<span class=error>:message</span>') !!}
                        </div>
                    </div>
                  </div>
                  </div>
                </div>
                <hr>
                <input type="hidden" name="extern" value="1">
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
