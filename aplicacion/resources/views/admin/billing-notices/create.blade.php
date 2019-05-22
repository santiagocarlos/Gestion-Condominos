@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <br><br><br>
	 <div class="row">

    @if(session()->has('error'))
      <div class="callout callout-danger" role="alert">
         <h4>Error!</h4>
         {{ session('error') }}
      </div>
    @endif
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Generar Cobro</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.billing-notices.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <label>Torre</label>
                  <div class="form-group">
                    <select class="form-control" name="tower_id">
                      <option value="0">Selecciona una Torre</option>
                      @foreach($towers as $tower)
                      <option value="{{ $tower->id }}">{{ $tower->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="col-md-6">
                  <label>Mes</label>
                  <div class="form-group">
                    <select class="form-control" name="date">
                      <option value="0">Selecciona el Mes</option>
                      <option value="01-{{ now()->year }}">Enero {{ now()->year }}</option>
                      <option value="02-{{ now()->year }}">Febrero {{ now()->year }}</option>
                      <option value="03-{{ now()->year }}">Marzo {{ now()->year }}</option>
                      <option value="04-{{ now()->year }}">Abril {{ now()->year }}</option>
                      <option value="05-{{ now()->year }}">Mayo {{ now()->year }}</option>
                      <option value="06-{{ now()->year }}">Junio {{ now()->year }}</option>
                      <option value="07-{{ now()->year }}">Julio {{ now()->year }}</option>
                      <option value="08-{{ now()->year }}">Agosto {{ now()->year }}</option>
                      <option value="09-{{ now()->year }}">Septiembre {{ now()->year }}</option>
                      <option value="10-{{ now()->year }}">Octubre {{ now()->year }}</option>
                      <option value="11-{{ now()->year }}">Noviembre {{ now()->year }}</option>
                      <option value="12-{{ now()->year }}">Diciembre {{ now()->year }}</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Generar Cobro</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
