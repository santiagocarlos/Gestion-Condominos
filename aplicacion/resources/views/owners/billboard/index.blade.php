@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
    @foreach($news as $notices)
  		 <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <span class="username">{{ $notices->title }}</span>
                <span class="description">Publicado {{ $notices->created_at->diffForHumans() }} en {{ $notices->category->name }}</span>
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
              <p>{!! $notices->description !!}</p>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
            <a href="{{ route('owners.billboard.show', Crypt::encrypt($notices->id)) }}">
              <button type="button" class="btn btn-success pull-right"><i class="fa fa-eye"></i> Ver aviso completo</button>
            </a>
          </div>
          </div>
    @endforeach
  </div>



@endsection
