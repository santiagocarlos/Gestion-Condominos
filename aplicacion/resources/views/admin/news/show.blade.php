@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Ver Noticia</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-blue">
                    Publicada el {{ $notice->created_at->format('l d, F Y') }}
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              {{-- <i class="fa fa-envelope bg-blue"></i> --}}
              <div class="timeline-item">
                <h3 class="timeline-header">{{ $notice->title }}</h3>

                <div class="timeline-body">
                  {!! $notice->description !!}
                </div>
              </div>
            </li>
          </ul>
          <div class="box-footer">
            <a href="{{ URL::previous() }}">
              <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
            </a>
          </div>
        </div>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
