@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
<br><br><br>
	<div class="container-fluid spark-screen">
    @if(session()->has('error'))
      <div class="callout callout-danger" role="alert">
         <h4>Error!</h4>
         {{ session('error') }}
      </div>
    @endif
    @if(count($errors) > 0)
      <div class="alert alert-danger" role="alert">
         <ul>
           @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
           @endforeach
         </ul>
      </div>
    @endif
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Factura</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.invoices.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nro_invoice">Número de Factura</label>
                    <input type="text" class="form-control" name="nro_invoice" placeholder="# Factura" value="{{ old('nro_invoice') }}">
                      <div class="errors">
                        {{ $errors->first('nro_invoice') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="expense">Servicio</label>
                    <select class="form-control" name="expense_id">
                      <option value="0">Selecciona Uno</option>
                      @foreach($expenses as $expense)
                      <option value="{{ $expense->id }}">{{ $expense->name }} - ({{ $expense->company }}) - {{ $expense->Común }}</option>
                      @endforeach
                    </select>
                      <div class="errors">
                        {{ $errors->first('expense') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="date">Fecha de la Factura</label>
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control" name="date" id="datepicker" placeholder="dd-mm-yyyy" value="{{ old('date') }}">
                    </div>
                      <div class="errors">
                        {{ $errors->first('date') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="amount">Monto</label> <small> <i>usa <strong>punto</strong> (.) para separar decimales</i></small>
                    <div class="input-group">
                      <div class="input-group-addon">
                        <i class="fa fa-usd"></i>
                      </div>
                      <input type="text" class="form-control" name="amount" onkeypress="return filterFloat(event,this);" value="{{ old('amount') }}">
                    </div>
                      <div class="errors">
                        {{ $errors->first('amount') }}
                      </div>
                  </div>
                </div>

              </div>
              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <a href="{{ route('admin.expenses.index') }}">
                  <button type="button" class="btn btn-info"><i class="fa fa-gears"></i> Ir a la Lista de Gastos</button>
                </a>
                <button type="submit" id="btn-save" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar Información</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
