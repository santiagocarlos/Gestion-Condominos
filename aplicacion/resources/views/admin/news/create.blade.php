@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <br>
   <div class="row">
      <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Noticia</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="{{ route('admin.news.store') }}" method="POST">
              {!! csrf_field() !!}
              <div class="box-body">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="title">Título de la Noticia</label>
                    <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Título de la Noticia">
                      <div class="errors">
                        {{ $errors->first('title') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="category">Categoría</label>
                    <br>
                    @if($cant_categories == "0")
                      <strong>No hay categorías, debes agregar al menos una. <a href="{{ route('admin.categories.create') }}">Haz click acá</a></strong>
                    @else
                      <select class="form-control" name="category_id">
                        <option value="0">Selecciona Una</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                      </select>
                    @endif
                      <div class="errors">
                        {{ $errors->first('category_id') }}
                      </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Detalle</label>
                    <textarea class="ckeditor" name="description" rows="10" cols="80"></textarea>
                      <div class="errors">
                        {{ $errors->first('description') }}
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
