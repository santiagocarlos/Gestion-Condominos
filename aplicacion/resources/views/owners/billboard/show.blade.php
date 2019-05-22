@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">

  		 <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <span class="username">{{ $notice->title }}</span>
                <span class="description">Publicado {{ $notice->created_at->diffForHumans() }} en {{ $notice->category->name }}</span>
              </div>
              <!-- /.user-block -->
              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- post text -->
              <p>{!! $notice->description !!}</p>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <a href="{{ URL::previous() }}">
              <button type="button" class="btn btn-warning"><i class="fa fa-eye"></i> Atrás</button>
            </a>
          </div>
          </div>
  </div>



@endsection
