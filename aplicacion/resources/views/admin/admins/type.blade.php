@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
	 <div class="row">
    <br><br><br>
    <center><p>Selecciona el tipo de administrador que vas a agregar</p></center>
    <br><br><br>
    <div class="frb-group">
    <div class="row">
        <div class="col-md-6">
            <div class="frb frb-info">
                  <input type="radio" id="radio-button-1" onclick="location.href='{{ route('admin.externAdmin') }}'" name="admin">
                <label for="radio-button-1">
                    <span class="frb-title">Administrador Externo</span>
                    <br>
                    <span class="frb-description">No vivo dentro del Conjunto Residencial. <br><br></span>
                </label>
            </div>
        </div>
        <div class="col-md-6">
            <div class="frb frb-info">
                <input type="radio" id="radio-button-2" onclick="location.href='{{ route('admin.internAdmin') }}'" name="admin">
                <label for="radio-button-2">
                    <span class="frb-title">Administrador Interno</span>
                    <br>
                    <span class="frb-description">Vivo dentro del Conjunto Residencial      </span>
                    <br><br>
                </label>
            </div>
        </div>
        <span class="form-control-feedback errors">{{ $errors->first('admin') }} </span>
    </div>
</div>
   </div>
	</div>

@endsection
