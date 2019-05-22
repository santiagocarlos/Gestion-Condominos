@extends('adminlte::layouts.graphic')

@section('htmlheader_title')
  {{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
  <div class="container-fluid spark-screen">
    <br><br><br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Generar Gráfico</h3>
            </div>

            <div id="chart1"></div>
            {!! $chart1 !!}

          </div>
   </div>
   <div class="row">
    <a href="{{ URL::previous() }}">
     <button class="btn btn-warning btn-lg"><i class="fa fa-reply"></i> Atrás</button>
    </a>
   </div>
  </div>

@endsection