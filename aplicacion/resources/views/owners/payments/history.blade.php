{{-- {{ Auth::user()->id }} --}}

@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
		<div class="box box-default">
			<div class="box-header with-border">
            <h3 class="box-title">Historial de Pagos</h3>
      </div>
      <br>
	              <div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nº. Comprobante</th>
                    {{-- <th>Mes Cobro</th> --}}
                    <th>Monto Pagado</th>
                    <th>Forma de Pago</th>
                    <th>Banco</th>
                    <th>Estado</th>
                    <th>Fecha de Pago</th>
                    <th>Fecha de Verificación</th>
                </tr>
                </thead>
                <tbody>
                @foreach($history_pays as $history_pay)
                <tr>
                    <td>
                      <center>
                        {{ $history_pay->nro_confirmation }}
                      </center>
                    </td>
                   {{--  <td>
                    </td> --}}
                    <td>
                      <center>
                        {{ $history_pay->amount }} Bs
                      </center>
                    </td>
                    <td>
                      {{ $history_pay->wayToPayName }}
                    </td>
                    <td>
                      {{ $history_pay->bankName }}
                    </td>
                    <td>
                      @if($history_pay->date_confirm == NULL)
                        <center>
                          <span class="label label-danger">sin confirmación</span>
                        </center>
                      @endif
                      @if($history_pay->date_confirm != NULL)
                        <center>
                          <span class="label label-success">confirmado</span>
                        </center>
                      @endif
                    </td>
                    <td>
                      {{ $history_pay->date_pay->format('l d, F Y') }}
                    </td>
                    <td>
                      @if($history_pay->date_confirm == null)
                        <center>
                          <span class="label label-danger">sin confirmación</span>
                        </center>
                      @endif
                      @if($history_pay->date_confirm != null)
                        {{ $history_pay->date_confirm }}
                      @endif
                    </td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº. Comprobante</th>
                    {{-- <th>Mes Cobro</th> --}}
                    <th>Monto Pagado</th>
                    <th>Forma de Pago</th>
                    <th>Banco</th>
                    <th>Estado</th>
                    <th>Fecha de Pago</th>
                    <th>Fecha de Verificación</th>
                </tr>
                </tfoot>
              </table>
	         </div>
    </div>
  </div>

@endsection
