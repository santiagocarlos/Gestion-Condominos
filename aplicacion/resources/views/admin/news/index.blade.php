@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-9">
      <p></p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.news.create') }}">
        <button class="btn btn-success btn-block" title="Publicar Noticia"><i class="fa fa-plus"></i> Publicar Noticia</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Noticias</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Título</th>
                  <th>Detalle</th>
                  <th>Categoría</th>
                  <th>Fecha Creación</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $notice)
                <tr>
                  <td>{{ $notice->title }}</td>
                  <td>{!! str_limit($notice->description, $limit = 55, $end = '...') !!}</td>
                  <td>{{ $notice->category->name }}</td>
                  <td>{{ $notice->created_at->format('l d, F Y') }}</td>
                  <td>
                    <center>
                      <a href="{{ route('admin.news.show', Crypt::encrypt($notice->id)) }}">
                        <button class="btn btn-success" title="Ver"><span class="fa fa-eye"></span></button>
                      </a>
                      <a href="{{ route('admin.news.edit', Crypt::encrypt($notice->id)) }}">
                        <button class="btn btn-warning" title="Editar"><span class="fa fa-edit"></span></button>
                      </a>
                    <form style="display:inline" action="{{ route('admin.news.destroy', $notice->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button type="submit" id="deleteButton" class="btn btn-danger" title="Eliminar"><span class="fa fa-trash"></span></button>
                    </form>
                    </center>
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Título</th>
                  <th>Detalle</th>
                  <th>Categoría</th>
                  <th>Fecha Creación</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
