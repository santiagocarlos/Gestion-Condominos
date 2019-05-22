@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    {{-- @if (session()->has('error'))
      <div class="alert alert-danger">
        {{ session('error') }}
      </div>
    @endif --}}
	 <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Apartamento</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.apartByFloor') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="tower">Torre</label>
                    <select class="form-control" name="tower_id">
                      <option value="0">Seleccione Una</option>
                      @foreach($towers as $tower)
                      <option value="{{ base64_encode($tower->id) }}">{{ $tower->name }}</option>
                      @endforeach
                    </select>
                      <div class="errors">
                        {{ $errors->first('tower_id') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="floor">Piso</label>
                    <select class="form-control" name="floor">
                      <option value="0">Seleccione Uno</option>
                      @for($i = 1; $i <= $array_file[1] ; $i++)
                      <option value="{{ base64_encode($i) }}">{{ $i }}</option>
                      @endfor
                    </select>
                      <div class="errors">
                        {{ $errors->first('floor') }}
                      </div>
                  </div>
                </div>

              </div>

              <div class="box-footer">
                <a href="{{ URL::previous() }}">
                  <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                </a>
                <button type="submit" class="btn btn-success pull-right"><i class="fa fa-share"></i> Siguiente</button>
              </div>
            </form>
          </div>
   </div>
	</div>

@endsection
