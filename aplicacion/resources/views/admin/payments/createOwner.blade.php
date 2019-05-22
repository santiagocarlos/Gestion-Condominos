
@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-12">
      <p></p>
    </div>
   <br>
	 <div class="row">
    <div class="col-md-12">
     <div class="box box-default">
      <div class="box-header with-border">
            <h3 class="box-title">Reportar Pago</h3>
      </div>
      <div class="box-body">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
               <div class="box-body">
                <form action="{{ route('admin.payments.create') }}" method="POST" class="form-group">
                {!! csrf_field() !!}
                {{-- <div class="row">
                  <div class="col-md-6 form-group">
                    <label>Forma de Pago</label>
                    <select class="form-control" name="way_to_pay_id">
                      <option value="0">Selecciona Una</option>
                      @foreach($waysToPay as $wayToPay)
                      <option value="{{ $wayToPay->id }}">{{ $wayToPay->name }}</option>
                      @endforeach
                    </select>
                    <div class="errors">
                        {{ $errors->first('way_to_pay_id') }}
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Banco Emisor</label>
                    <select class="form-control" name="bank_id">
                      <option value="0">Selecciona Una</option>
                      @foreach($banks as $bank)
                      <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                      @endforeach
                    </select>
                    <div class="errors">
                        {{ $errors->first('bank_id') }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>Banco Destino</label>
                    <select class="form-control" name="bank_condominia_id">
                      <option value="0">Selecciona Una</option>
                      @foreach($banksCondominium as $bankCondominium)
                      <option value="{{ $bankCondominium->id }}">{{ $bankCondominium->name }}-({{ $bankCondominium->account_number }})-[{{ $bankCondominium->holder }}-{{ $bankCondominium->dni }}]</option>
                      @endforeach
                    </select>
                    <div class="errors">
                        {{ $errors->first('bank_condominia_id') }}
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Número de Comprobante</label>
                    <input type="text" class="form-control" name="nro_confirmation" placeholder="Número de Comprobante" value="{{ old("nro_confirmation") }}">
                    <div class="errors">
                        {{ $errors->first('nro_confirmation') }}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <label>Monto</label>
                    <input type="text" class="form-control" name="amount" placeholder="Monto" value="{{ old('amount') }}">
                    <div class="errors">
                        {{ $errors->first('amount') }}
                    </div>
                  </div>
                  <div class="col-md-6 form-group">
                    <label>Fecha del Pago</label>
                    <input type="text" class="form-control datepicker" name="date_pay" placeholder="dd-mm-yyyy" value="{{ old('date_pay') }}">
                    <div class="errors">
                        {{ $errors->first('date_pay') }}
                    </div>
                  </div>
                </div> --}}
                <div class="row">
                  <div class="col-lg-12 form-group">
                    <label>Propietario</label>
                    <select class="form-control" name="owner_id">
                      <option value="0">Selecciona una opción</option>
                      @foreach($owners as $owner)
                        <option value="{{ $owner->id }}">{{ $owner->nameOwner }} {{ $owner->last_name }} [{{ $owner->name }}-{{ $owner->floor }}-{{ $owner->apartment }}]</option>
                      @endforeach
                    </select>
                  </div>
                </div>
               {{--  <div class="row">
                  <div class="col-md-12 form-group">
                    <label>Cargar archivo</label>
                    <small>Formatos permitidos: .jpg, .jpeg, .png, .pdf</small>
                    <input type="file" class="form-control-file" name="image">
                    <div class="errors">
                        {{ $errors->first('image') }}
                    </div>
                  </div>
                </div> --}}
                {{-- <div class="row">
                  <div class="col-md-12 form-group">
                    <label>Selecciona los recibos de condominio a pagar</label>
                    <br><small>Presiona <strong>Crtl+click</strong> para seleccionar más de una opción</small><br>
                    <select class="form-control" name="billing[]" multiple>
                      <option value="" disabled>Selecciona una/varias opciones</option>
                      @foreach($billing_notices as $billing)
                      @if($billing->status == '1')
                      <option value="{{ $billing->id }}"><strong>#{{ $billing->nro }}</strong> - [{{ $billing->name }}-{{ $billing->floor }}-{{ $billing->apartment }}] - (Monto Recibo: {{ $billing->amount }} Bs) <i> &nbsp;&nbsp; [{{ \App\Payment::partialPayments($billing->id) }} Bs pagados previamente]</i></option>
                      @endif
                      @if($billing->status == '0')
                      <option value="{{ $billing->id }}"><strong>#{{ $billing->nro }}</strong> - [{{ $billing->name }}-{{ $billing->floor }}-{{ $billing->apartment }}] - (Monto Recibo: {{ $billing->amount }} Bs)</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div> --}}
                <div class="box-footer">
                  <a href="{{ URL::previous() }}">
                    <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
                  </a>
                  <button type="submit" class="btn btn-success pull-right">Siguiente <i class="fa fa-long-arrow-right"></i></button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
   </div>
	</div>
@endsection
