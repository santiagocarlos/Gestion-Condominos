@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
		<div class="box box-default">
			<div class="box-header with-border">
            <h3 class="box-title">Recibos de Cobro</h3>
      </div>
			<div class="box-body">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
	            <div class="box">
	              <div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nº. Cobro</th>
                  <th>Monto</th>
                  <th>Apartamento</th>
                  <th>Estado</th>
                  <th>Mes Cobro</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($billing_notices as $billing)
                <tr>
                    <td>
                      <center>
                        {{ $billing->nro }}
                      </center>
                    </td>
                    <td style="text-align: right;">
                      {{ $billing->amount }} Bs.
                    </td>
                    <td>
                      <center>
                      {{ $billing->name }}-{{ $billing->floor }}-{{ $billing->apartment }}
                      </center>
                    </td>
                      <td>
                    @if($billing->status == "0")
                      <center>
                        <small class="label bg-red">no pagada</small>
                      </center>
                    @endif
                    @if($billing->status == "1")
                      <center>
                        <small class="label pull-right bg-yellow">pagada parcialmente</small>
                      </center>
                    @endif
                    @if($billing->status == "2")
                      <center>
                        <small class="label pull-right bg-green">pagada</small>
                      </center>
                    @endif
                  </td>
                    <td>
                      <center>
                        {{ $billing->date->format('F Y') }}
                      </center>
                    </td>
                    <td>
                      <center>
                        {!!link_to_route('owners.billing-notices.showFromOwner', $title = ' Ver',
                                                    $parameters = ['id' => Crypt::encrypt($billing->id), 'apart' => Crypt::encrypt($billing->apartmentsId)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-eye']);!!}
                      </center>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº. Cobro</th>
                  <th>Monto</th>
                  <th>Apartamento</th>
                  <th>Estado</th>
                  <th>Mes Cobro</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
	            	</div>
	            </div>
            </div>
        </div>
      </div>
    </div>
  </div>



@endsection
