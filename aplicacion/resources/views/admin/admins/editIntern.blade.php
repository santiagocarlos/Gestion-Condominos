@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Administrador Interno</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.admins.update', $admin_owner->peopleId) }}" method="POST">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name">Nombre</label>
                      <input type="text" class="form-control" name="name" id="name" value="{{ $admin_owner->name or old('name') }}" placeholder="Nombre">
                      <div class="errors">
                        {{ $errors->first('name') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="last_name">Apellido</label>
                      <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $admin_owner->last_name or old('last_name') }}" placeholder="Apellido">
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
                      <input type="text" class="form-control" name="ci" id="ci" value="{{ $admin_owner->ci or old('ci') }}" placeholder="Cédula">
                      <div class="errors">
                        {{ $errors->first('ci') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="birth">Fecha de Nacimiento</label>
                      <input type="text" class="form-control" name="birth" id="birth" value="{{ $admin_owner->birth_formated or old('birth') }}" placeholder="dd/mm/yyyy">
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
                      <input type="text" class="form-control" name="email" id="email" value="{{ $admin_owner->email or old('email') }}" placeholder="email@example.com">
                      <div class="errors">
                        {{ $errors->first('email') }}
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="phone">Teléfono</label>
                      <input type="text" class="form-control" name="number" id="phone" value="{{ $admin_owner->number or old('phone') }}" placeholder="0123-45678900">
                      <div class="errors">
                        {{ $errors->first('number') }}
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
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
                <hr>
                @if(count($errors) > 0)
                  <div class="alert alert-danger">
                    <ul>
                      @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                      @endforeach
                    </ul>
                  </div>
                @endif
                <div class="box-header with-border">
                  <h3 class="box-title">Configura las propiedades del administrador</h3>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="apartments">Apartamentos</label>
                      <select name="apartments[]" class="form-control" multiple="multiple">
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
                      <i> Puedes seleccionar varios. <br> Presiona (<strong>Crtl+click</strong>) para seleccionar más de una opción. </i>
                      </p>
                  </div>
                </div>
                <input type="hidden" name="intern" value="1">
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
