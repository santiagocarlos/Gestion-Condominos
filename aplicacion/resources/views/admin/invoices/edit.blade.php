@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
<br><br><br>
	<div class="container-fluid spark-screen">
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Editar Factura</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.invoices.update', $invoice->id) }}" method="POST">
              {!! csrf_field() !!}
              {!! method_field('PUT') !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nro_invoice">Número de Factura</label>
                    <input type="text" class="form-control" name="nro_invoice" placeholder="# Factura" value="{{ $invoice->nro_invoice or old('nro_invoice') }}">
                      <div class="errors">
                        {{ $errors->first('nro_invoice') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="expense">Gasto</label>
                    <select class="form-control" name="expense_id">
                      <option value="{{ $invoice->expense->id }}">{{ $invoice->expense->name }} - ({{ $invoice->expense->company }})</option>
                      @foreach($expenses as $expense)
                      <option value="{{ $expense->id }}">{{ $expense->name }} - ({{ $expense->company }})</option>
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
                      <input type="text" class="form-control" name="date" id="datepicker" placeholder="dd-mm-yyyy" value="{{ $invoice->date->format('d-m-Y')  }}">
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
                      <input type="text" class="form-control" name="amount" onkeypress="return filterFloat(event,this);" value="{{ $invoice->amount or old('amount') }}">
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
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar Información</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
