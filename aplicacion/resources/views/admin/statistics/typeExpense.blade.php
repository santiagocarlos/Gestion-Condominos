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
              <h3 class="box-title">Generar Gráfico</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.statistics.graphicExpense') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <label>Elige el gasto para el cual deseas generar un gráfico</label>
                  <div class="form-group">
                    <select class="form-control" name="expense_id">
                      <option value="0">Selecciona una opción</option>
                      @foreach($expenses as $expense)
                        <option value="{{ $expense->id }}">{{ $expense->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="errors">
                    {{ $errors->first('date_start') }}
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-save"></i> Generar Gráfico</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
