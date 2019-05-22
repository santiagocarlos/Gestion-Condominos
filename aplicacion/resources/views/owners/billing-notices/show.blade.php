@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
		<div class="box box-default">
      <div class="box-header with-border">
        <h3 class="box-title">Recibo de Condominio</h3>
      </div>
      <br>
      <div class="col-md-2 pull-right">
        <a href="{{ route('owners.pdf.condoReceipt',[Crypt::encrypt($id), Crypt::encrypt($apart)]) }}" target="_blank">
          <button class="btn btn-primary btn-block" title="Descargar PDF"><i class="fa fa-download"></i> Descargar PDF</button>
        </a>
      </div>
      <br><br>
			<div class="box-body">
            <!-- /.box-header -->
              <table class="table table-bordered">
                <tr>
                  {{-- <th style="width: 10px">#</th> --}}
                  <th>Servicio/Gasto</th>
                  <th>Descripción</th>
                  <th>Total (Bs)</th>
                  <th style="width: 200px">Total según alícuota (Bs)</th>
                </tr>
                @foreach($billing_notice as $billingNotice)
                <tr>
                 {{--  <td>2.</td> --}}
                  <td>{{ $billingNotice->name }} - ({{ $billingNotice->company }})</td>
                  <td>{{ $billingNotice->description }}</td>
                  <td style="text-align: right;">{{ number_format($billingNotice->valor, 2, ',','.') }}</td>
                  <td style="text-align: right;">{{ number_format($billingNotice->alicuota, 2, ',','.') }}</td>
                </tr>
                @endforeach
                @if($arrears_interests['surcharge'] != null)
                  <tr>
                    <td><strong>Morosidad Acumulada</strong></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">{{ $arrears_interests['surcharge'] }}</td>
                  </tr>
                @endif
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: right;"><strong>Total:</strong> &nbsp;&nbsp;&nbsp; {{ number_format($amountBillingNotice['total'], 2, ',','.') }} Bs</td>
                </tr>
              </table>
            <!-- /.box-body -->
      <br>
      </div>
          <div class="box-footer">
            <a href="{{ URL::previous() }}">
              <button type="button" class="btn btn-warning"><i class="fa fa-reply"></i> Atrás</button>
            </a>
          </div>
      </div>
  </div>
@endsection