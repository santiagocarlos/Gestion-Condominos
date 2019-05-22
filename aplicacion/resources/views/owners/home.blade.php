{{-- {{ Auth::user()->id }} --}}
@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
		<div class="box box-default">
			<div class="box-header with-border">
            <h3 class="box-title"></h3>
      </div>
      <br>
			<div class="box-body">
				{{-- <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	        <div class="row">
	          <div class="col-lg-3 col-xs-6">
	            <div class="small-box bg-red">
	              <div class="inner">
	                <h3>150</h3>
	                <p>Recibos Vencidos</p>
	              </div>
	              <div class="icon">
	                <i class="ion ion-cash"></i>
	              </div>
	              <a href="#" class="small-box-footer">
	                Más <i class="fa fa-arrow-circle-right"></i>
	              </a>
	            </div>
	           </div>
	          <div class="row">
	            <div class="col-lg-3 col-xs-6">
	              <div class="small-box bg-aqua">
	                <div class="inner">
	                  <h3>4</h3>
	                  <p>Recibos de Condominio</p>
	                </div>
	                <div class="icon">
	                  <i class="ion ion-compose"></i>
	                </div>
	                <a href="#" class="small-box-footer">
	                  Más <i class="fa fa-arrow-circle-right"></i>
	                </a>
	              </div>
	            </div>
	          </div>
	        </div>
      	</div> --}}
      	<br>
				<div class="col-xs-12 col-sm-12 col-md-6" >
					<div class="panel panel-info">
						<div class="panel-heading">
						<h3 class="panel-title">Datos Personales</h3>
						</div>
					<div class="panel-body">
						<div class="row">
						  <div class=" col-md-12 col-lg-12 ">
					      <table class="table table-user-information">
					        <tbody>
                    <tr>
                      <td>Nombre: {{ $infoUser->name }} {{ $infoUser->last_name }}</td>
                    </tr>
                    <tr>
                      <td>Cédula: {{ $infoUser->ci }}</td>
                    </tr>
                    <tr>
                      <td>Email: {{ $infoUser->user->email }}</td>
                      <td></td>
                    </tr>
                    {{-- @foreach($infoUser->phones as $phone) --}}
                    <tr>
			                <td>Números de Teléfonos:
                        <br>
                        {!! '<li>'.$infoUser->phones->pluck('number')->implode('<br><li> ') !!}</td>
				            </tr>
                    {{-- @endforeach --}}
					        </tbody>
					       </table>
						        <a href="{{ route('owners.owners.editInfo') }}" class="btn btn-primary">Actualiza tus Datos</a>
						    </div>
							</div>
						</div>
					</div>
        </div>
          <div class="col-xs-12 col-sm-12 col-md-6" >
          <div class="col-lg-12 col-xs-6">
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>{{ $cant_properties }}</h3>
                  <p>Propiedades</p>
                </div>
                <div class="icon">
                  <i class="ion ion-cash"></i>
                </div>
                <a href="{{ route('owners.owners.properties') }}" class="small-box-footer">
                  Ver <i class="fa fa-arrow-circle-right"></i>
                </a>
              </div>
             </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Recibos Por Pagar</h3>
            </div>
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>ID</th>
                  <th>Fecha</th>
                  <th>Monto</th>
                </tr>
               @if($billing_notices > '0')
                @foreach($billing_notices as $billing)
                <tr>
                  <td>{{ $billing->nro }}</td>
                  <td>{{ $billing->date->format('F Y') }}</td>
                  <td>{{ $billing->amount }} Bs</td>
                </tr>
                @endforeach
              @else
              <div class="box-body table-responsive no-padding">
              <center>
                    <p>No tienes recibos por pagar. <br> Estas solvente</p>
              </center>
              @endif
            </div>
              </table>

            </div>
            <!--<div class="box-footer">
              <h3 class="box-title">
              <hr>
              Total Adeudado:
              </h3>
            </div>-->
          </div>
         </div>
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
	            <section class="content-header">
	              <h3 class="box-title">Historial de Pagos</h3>
	            </section>
	            <div class="box">
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
                      @if($history_pay->date_confirm == "null")
                        <center>
                          <span class="label label-danger">sin confirmación</span>
                        </center>
                      @endif
                      @if($history_pay->date_confirm != "null")
                        {{ \Carbon\Carbon::parse($history_pay->date_confirm)->format('d-m-Y') }}
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
        </div>
      </div>
    </div>
  </div>



@endsection
