@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Torre</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.towers.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="form-group">
                  <label for="name-tower">Ingresa el nombre de la torre</label>
                  <input type="text" class="form-control" name="tower" id="name-tower" value="{{ old('tower') }}" placeholder="Nombre">
                    <div class="errors">
                      {{ $errors->first('tower') }}
                    </div>
                </div>
                <div class="form-group">
                  <label>Administrador</label>
                  <select class="form-control" name="admin_id">
                    <option value="0">Selecciona Uno</option>
                    @foreach($admins as $admin)
                    <option value="{{ base64_encode($admin->id) }}">{{ $admin->name }} {{ $admin->last_name }}</option>
                    @endforeach
                  </select>
                  <div class="errors">
                      {{ $errors->first('admin_id') }}
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" id="btn-save" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar Información</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
