@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <br><br><br><br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Cuenta</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.banks-condominium.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="bank_id">Banco</label>
                    <select class="form-control" name="bank_id">
                      <option value="0">Selecciona Uno</option>
                      @foreach($banks as $bank)
                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                      @endforeach
                    </select>
                      <div class="errors">
                        {{ $errors->first('bank_id') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="account_number">Número de Cuenta</label>
                    <input type="text" name="account_number" class="form-control" placeholder="0000-0000-00-000000000">
                      <div class="errors">
                        {{ $errors->first('account_number') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-group">
                    <label for="holder">Titular</label>
                    <input type="text" name="holder" class="form-control" placeholder="Titular">
                      <div class="errors">
                        {{ $errors->first('holder') }}
                      </div>
                  </div>
                </div>

                <div class="col-md-6">
                    <label for="holder">Identificación</label>
                  <div class="form-group">
                    <div class="col-md-2">
                      <select class="form-control" name="type-dni">
                        <option value="V-">V</option>
                        <option value="J-">J</option>
                        <option value="E-">E</option>
                      </select>
                    </div>
                    <div class="col-md-10">
                      <input type="text" name="dni" class="form-control" placeholder="000000">
                    </div>
                      <div class="errors">
                        {{ $errors->first('dni') }}
                      </div>
                  </div>
                </div>

              <div class="col-md-12">
                  <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="text" name="email" class="form-control" placeholder="email@example.com">
                      <div class="errors">
                        {{ $errors->first('email') }}
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
