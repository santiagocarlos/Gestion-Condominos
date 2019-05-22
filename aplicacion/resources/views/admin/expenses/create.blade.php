@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Gasto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.expenses.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nombre" value="{{ old('name') }}">
                      <div class="errors">
                        {{ $errors->first('name') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="company">Compañía</label>
                    <input type="text" class="form-control" name="company" id="company" placeholder="Compañía" value="{{ old('company') }}">
                      <div class="errors">
                        {{ $errors->first('company') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="description">Descripción <small><i>(opcional)</i></small></label>
                    <textarea class="form-control" name="description" placeholder="Escribe una descripción...">{{ old('description') }}</textarea>
                   <div class="errors">
                        {{ $errors->first('description') }}
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-group">
                    <label>Selecciona el tipo de Gasto</label><br><br>
                    <div class="form-group">
                      <input type="radio" name="common" id="commonYes" value="0" > <label for="commonYes">Común</label> &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="common" id="commonNo" value="1" > <label for="commonNo">Por Torre</label> &nbsp;&nbsp;&nbsp;&nbsp;
                      <input type="radio" name="common" id="commonAp" value="2" > <label for="commonAp">Por Apartamento</label>
                    <div class="errors">
                        {{ $errors->first('common') }}
                    </div>
                    </div>
                  </div>
                  <div class="col-md-6" id="div1" style="display: none;">
                    <div class="form-group">
                      <label>Selecciona las torres a las cuales afecta este gasto</label>
                      <p><small>Presiona <strong>(Crtl+click)</strong> para seleccionar más de una opción</small></p>
                      <select name="towers[]" id="towers" class="form-control" multiple="multiple">
                        <option value="0">Selecciona una/varias opciones</option>
                        @foreach($towers as $tower)
                        <option value="{{ $tower->id }}">{{ $tower->name }}</option>
                        @endforeach
                      </select>
                      <div class="errors">
                        {{ $errors->first('towers') }}
                    </div>
                    </div>
                  </div>
                  <div class="col-md-6" id="div2"  style="display: none;">
                    <div class="form-group">
                      <label>Selecciona los apartamentos a los cuales afecta este gasto</label>
                      <p><small>Presiona <strong>(Crtl+click)</strong> para seleccionar más de una opción</small></p>
                      <select name="apartments[]" id="apartments" class="form-control" multiple="multiple">
                        <option value="0">Selecciona una/varias opciones</option>
                        @foreach($apartments as $apartment)
                        <option value="{{ $apartment->id }}">{{ $apartment->name }} - Piso {{ $apartment->floor }} - Apartamento {{ $apartment->apartment }}</option>
                        @endforeach
                      </select>
                      <div class="errors">
                        {{ $errors->first('apartments') }}
                    </div>
                    </div>
                  </div>
                  @foreach($towers as $tower)
                    <input type="hidden" name="twrcom[]" value="{{ $tower->id }}">
                  @endforeach
                </div>
                <div class="box-footer">
                  <a href="{{ URL::previous() }}">
                    <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                  </a>
                  <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar Información</button>
                </div>
              </div>
            </form>
      </div>
	   </div>
  </div>

@endsection
