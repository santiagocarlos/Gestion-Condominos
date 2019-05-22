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
              <h3 class="box-title">Ver Detalle de Pago</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- timeline time label -->
            <li class="time-label">
                  <span class="bg-blue">
                    Pagado el {{ $payment->date_pay->format('l d, F Y') }}
                  </span>
            </li>
            <!-- /.timeline-label -->
            <!-- timeline item -->
            <li>
              {{-- <i class="fa fa-envelope bg-blue"></i> --}}
              <div class="timeline-item">
                <h3 class="timeline-header"></h3>
                <ul>
                  <li><strong>Número de Confirmación:</strong> {{ $payment->nro_confirmation }}</li><br>
                  <li><strong>Monto:</strong> {{ $payment->amount }}</li><br>
                  <li><strong>Banco:</strong> {{ $payment->nameBank }}</li><br>
                  <li><strong>Forma de Pago:</strong> {{ $payment->nameWayToPay }}</li><br>
                  <li><strong>Fecha de Pago:</strong> {{ $payment->date_pay->format('d, F Y') }}</li><br>
                  @if($payment->date_confirm == NULL)
                  <li>
                    <strong>Fecha de Confirmación:</strong> <span class="label label-danger">sin confirmación</span>
                  </li><br>
                  @else
                  <li>
                    <strong>Fecha de Confirmación:</strong> <span class="label label-success">confirmado</span> {{ $payment->date_confirm }}
                  </li><br>
                  @endif
                  <li><strong>Imagen:</strong></li>
                </ul>
                <div class="timeline-body">
                  <img id="myImg" src="{{ asset('images_payments')."/".$payment->image }}" style="width:100%;max-width:900px" class="img-responsive">
                </div>
                <!-- The Modal -->
                <div id="myModal" class="modal">
                  <span class="close">&times;</span>
                  <img class="modal-content" id="img01">
                  <div id="caption"></div>
                </div>
              </div>
            </li>
          </ul>
          <div class="box-footer">
            <a href="{{ URL::previous() }}">
              <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
            </a>
            @if($payment->date_confirm == NULL)
              <a href="{{ route('admin.payments.confirm', Crypt::encrypt($payment->id)) }}">
                <button type="button" class="btn btn-success pull-right"><i class="fa fa-check"></i> Confirmar Pago</button>
              </a>
            @endif
          </div>
        </div>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
