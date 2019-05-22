@extends('adminlte::layouts.owners')

@section('main-content')
	<div class="row">
		<div class="box box-default">
			<div class="box-header with-border">
            <h3 class="box-title">Tus Propiedades</h3>
      </div>
			<div class="box-body">
         <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row">
	            <div class="box">
	              <div class="box-body">
									<table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Torre</th>
                  <th>Piso</th>
                  <th>Apartamento</th>
                </tr>
                </thead>
                <tbody>
                @foreach($properties as $propertie)
                  <tr>
                      <td style="text-align: center;">
                        {{ $propertie->nameTower }}
                      </td>
                      <td style="text-align: center;">
                        {{ $propertie->floor }}
                      </td>
                      <td style="text-align: center;">
                        {{ $propertie->apartment }}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Torre</th>
                  <th>Piso</th>
                  <th>Apartamento</th>
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
