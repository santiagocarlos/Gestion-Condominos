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
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-push-3" >
					<div class="panel panel-info">
						<div class="panel-heading">
						<h3 class="panel-title">Actualizar Datos Personales</h3>
						</div>
					<div class="panel-body">
						<div class="row">
						  <div class=" col-md-12 col-lg-12 ">
					     <form action="{{ route('owners.owners.storeInfo') }}" method="POST">
                {!! csrf_field() !!}
                <table class="table table-user-information">
                  <tbody>
                    <tr>
                      <td>Nombre:
                        <input type="text" class="form-control" name="name" value="{{ $infoUser->name }}">
                        <div class="errors">
                          {{ $errors->first('name') }}
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Apellido:
                        <input type="text" class="form-control" name="last_name" value="{{ $infoUser->last_name }}">
                        <div class="errors">
                          {{ $errors->first('last_name') }}
                        </div>
                      </td>
                    </tr>
                    <input type="hidden" name="id" value="{{ Crypt::encrypt(Auth::user()->id) }}">
                    <tr>
                      <td>Cédula:
                        <input type="text" class="form-control" name="ci" value="{{ $infoUser->ci }}">
                      </td>
                      <div class="errors">
                          {{ $errors->first('ci') }}
                        </div>
                    </tr>
                    <tr>
                      <td>Email: {{ $infoUser->user->email }}</td>
                      <td></td>
                    </tr>
                    {{-- @foreach($infoUser->phones as $phone) --}}
                    <tr>
			                <td>Números de Teléfonos:
                        <div class="row">
                          <input type="hidden" name="count" value="1" />
                              <div class="control-group" id="fields">
                                  <div class="controls" id="profs">
                                        @foreach($phones as $key => $phone)
                                          <div id="field" class="col-lg-10">
                                            <input autocomplete="off" class="input form-control" id="field1" name="phone[{{ $key }}]" type="text" data-items="8" value="{{ $phone->number }}">
                                            <button id="b1" class="btn add-more" type="button">+</button>
                                          </div>
                                        @endforeach
                                  <br>
                                  <small>Presiona + para agregar otro campo :)</small>
                                  </div>
                              </div>
                        </div>
                        </td>
				            </tr>
                    {{-- @endforeach --}}
                  </tbody>
                 </table>
                    <input type="submit" class="btn btn-success pull-right" value="Actualizar">
                </form>
						    </div>
							</div>
						</div>
					</div>
        </div>
    </div>
  </div>



@endsection
