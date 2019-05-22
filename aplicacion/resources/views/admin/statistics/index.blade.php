
@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-12">
      <p></p>
    </div>
   <br>
	 <div class="row">
    <div class="container-fluid spark-screen">
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $cant_payments }}</h3>
            <p>Pagos Recibidos</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/fair.png') }}">
          </div>
          <a href="{{ route('admin.statistics.dateRange') }}" class="small-box-footer">Ver gráfico <i class="fa fa-arrow-circle-right"></i></a>
        </div>
       </div>
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $cant_expenses }}</h3>
            <p>Gastos</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/maintenance.png') }}">
          </div>
          <a href="{{ route('admin.statistics.typeExpense') }}" class="small-box-footer">Ver gráfico <i class="fa fa-arrow-circle-right"></i></a>
        </div>
       </div>
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $cant_owners }}</h3>
            <p>Propietarios</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/owner.png') }}">
          </div>
          <a href="{{ route('admin.owners.index') }}" class="small-box-footer">Ver Lista <i class="fa fa-arrow-circle-right"></i></a>
        </div>
       </div>
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $cant_defaulters }}</h3>

            <p>Morosos</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/owner.png') }}">
          </div>
          <a href="{{ route('admin.defaulters.index') }}" class="small-box-footer">Ver lista <i class="fa fa-arrow-circle-right"></i></a>
        </div>
       </div>
    </div>
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $acumulate_mora_round }} <small style="color: #FFF">Bs</small></h3>

            <p>Morosidad Acumulada</p>
          </div>
          <br>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/fair.png') }}">
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
        </div>
       </div>
       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $cant_admins }}</h3>

            <p>Administradores</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/comittee.png') }}">
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
        </div>
       </div>

       <div class="col-lg-3 col-xs-6">
        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{ $total_pays }} <small style="color: #FFF">Bs</small></h3>

            <p>Total Pagado</p>
          </div>
          <div class="icon">
            <img height="80" width="80" src="{{ asset('img/fair.png') }}">
          </div>
          {{-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> --}}
        </div>
       </div>
    </div>
    </div>
   </div>
	</div>
@endsection
