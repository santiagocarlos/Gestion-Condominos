<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Recibo de Condominio</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Fonts and Icons -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

    <style type="text/css">
      .table
      {
        width: 100%;
        border-bottom: 2px solid #000;
      }
      .table th
      {
        text-align: center;
        width: 100%;
        border-top: 2px solid #000;
        border-bottom: 2px solid #000;
        /*border: 2px solid #000;*/
        height: 50px;
      }
    </style>
</head>

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">
  <div class="content-wrapper">
    <div class="container">
      <section class="content">
          <div class="row">
          <br>
            <!-- /.box-header -->
              <table class="table">
                <tr>
                  <th>Torre</th>
                  <th>Piso</th>
                  <th>Apartamento</th>
                  <th>Alicuota</th>
                  <th>Mes</th>
                </tr>
                <tr>
                  <td><center>{{ $data_building['name'] }}</center></td>
                  <td><center>{{ $data_building['floor'] }}</center></td>
                  <td><center>{{ $data_building['apartment'] }}</center></td>
                  <td><center>{{ $data_building['aliquot'] }}</center></td>
                  <td><center>{{ $data_building['date']->format('F Y') }}</center></td>
                </tr>
              </table>
              <table class="table">
                <tr>
                  {{-- <th style="width: 10px">#</th> --}}
                  <th>Servicio/Gasto</th>
                  <th>Descripción</th>
                  <th>Total (Bs)</th>
                  <th>Total según alícuota (Bs)</th>
                </tr>
                @foreach($billing_notice as $billingNotice)
                <tr>
                 {{--  <td>2.</td> --}}
                  <td>{{ $billingNotice->name }} - ({{ $billingNotice->company }})</td>
                  <td>{{ $billingNotice->description }}</td>
                  <td style="text-align: center;">{{ number_format($billingNotice->valor, 2, ',','.') }}</td>
                  <td style="text-align: center;">{{ number_format($billingNotice->alicuota, 2, ',','.') }}</td>
                </tr>
                @endforeach
                @if($arrears_interests['surcharge'] != null)
                  <tr>
                    <td><strong>Morosidad Acumulada</strong></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center;">{{ $arrears_interests['surcharge'] }}</td>
                  </tr>
                @endif
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td style="text-align: center;"><strong>Total:</strong> &nbsp;&nbsp;&nbsp; {{ number_format($amountBillingNotice['total'], 2, ',','.') }} Bs</td>
                </tr>
              </table>
        </div>
      </section>
    </div>
  </div>
    @include('adminlte::layouts.partials.footerPDF')

</div>
</body>
</html>