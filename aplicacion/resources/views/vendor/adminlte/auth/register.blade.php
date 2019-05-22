@extends('adminlte::layouts.authwizard')

@section('htmlheader_title')
    Registrar
@endsection

@section('content')

<body class="hold-transition login-page">

<div class="container">

    <div class="row">
        <section>
            <div class="wizard">
                @if (session()->has('error'))
                  <div class="alert alert-danger">
                    {{ session('error') }}
                  </div>
                @endif
                <div class="row">
                    <center>Configuración</center>
                </div>
                <div class="wizard-inner">
                    <div class="connecting-line"></div>
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Regístrate">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-user"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Conjunto Residencial">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-home"></i>
                                    </span>
                                </a>
                            </li>
                            <li role="presentation" class="disabled">
                                <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Tipo de Administrador">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-picture"></i>
                                    </span>
                                </a>
                            </li>

                            <li role="presentation" class="disabled">
                                <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Finalizar">
                                    <span class="round-tab">
                                        <i class="glyphicon glyphicon-ok"></i>
                                    </span>
                                </a>
                            </li>
                         </ul>
                </div>

            <form role="form" action="{{ url('/register') }}" method="post">
                {!! csrf_field() !!}
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">
                        <center>
                            <h3>Regístrate <br><small>Serás el administrador de un nuevo condominio, por tanto debemos registrar tus datos. <br> <i>Por favor llena todos los campos</i></small></h3>
                        </center>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input type="text" name="name" value="{{ old('name') }}" class="form-control input-lg" placeholder="Nombre" tabindex="1">
                                </div>
                                    <span class="errors">{{ $errors->first('name') }}</span>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="last_name">Apellido</label>
                                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control input-lg" placeholder="Apellido" tabindex="2">
                                    <span class="errors">{{ $errors->first('last_name') }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="ci">Cédula <small><i>solo números</i></small></label>
                                    <input type="text" name="ci" value="{{ old('ci') }}" class="form-control input-lg" placeholder="Cédula" tabindex="3">
                                    <span class="errors">{{ $errors->first('ci') }} </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="birth">Fecha de Nacimiento</label>
                                    <input type="text" name="date_birth" value="{{ old('date_birth') }}" class="form-control input-lg datepicker" placeholder="dd-mm-yyyy" tabindex="4">
                                    <span class="errors">{{ $errors->first('date_birth') }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" placeholder="example@gmail.com" tabindex="5">
                                    <span class="errors">{{ $errors->first('email') }} </span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="phone">Teléfono</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control input-lg" placeholder="0123-4567899" tabindex="6">
                                    <span class="errors">{{ $errors->first('phone') }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control input-lg" placeholder="Contraseña" tabindex="7">
                                    <span class="errors">{{ $errors->first('password') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirmar Contraseña</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control input-lg" placeholder="Confirmar Contraseña" tabindex="8">
                                    <span class="errors">{{ $errors->first('password_confirmation') }} </span>
                                </div>
                            </div>
                            <input type="hidden" name="roles[0]" value="1">
                            <input type="hidden" name="roles[1]" value="2">
                        </div>
                            <ul class="list-inline pull-right">
                                <li><button type="button" class="btn btn-primary btn-lg next-step">Guardar y continuar</button></li>
                            </ul>
                        </div>

                    <div class="tab-pane" role="tabpanel" id="step2">
                        <center>
                            <h3>Conjunto Residencial <br><small>Bien, ahora vamos con las configuraciones del Conjunto Residencial. <br> <i>Por favor llena todos los campos</i></small></h3>
                        </center>
                        <hr>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="residential">Nombre del Conjunto Residencial</label>
                                    <input type="text" name="residential" value="{{ old('residential') }}" class="form-control input-lg" placeholder="Conjunto Residencial" tabindex="1">
                                    <span class="errors">{{ $errors->first('residential') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="towers">¿Cuántas torres tiene el conjunto?</label>
                                    <input type="number" name="towers" min="1" max="50" value="{{ old('towers') }}" class="form-control input-lg" placeholder="1" tabindex="2">
                                    <span class="errors">{{ $errors->first('towers') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="apartment">¿Cuántos apartamentos tiene cada torre?</label>
                                    <input type="number" name="apartment" min="1" max="600" value="{{ old('apartment') }}" class="form-control input-lg" placeholder="1" tabindex="3">
                                    <span class="errors">{{ $errors->first('aparment') }}</span>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label for="floor_tower">¿Cuántos pisos tiene cada torre?</label>
                                    <input type="number" name="floor_tower" class="form-control input-lg" value="{{ old('floor_tower') }}" placeholder="1" tabindex="4">
                                    <span class="errors">{{ $errors->first('floor_tower') }}</span>
                                </div>
                            </div>
                        </div>
                            <ul class="list-inline pull-right">
                                <li><button type="button" class="btn btn-default btn-lg prev-step">Anterior</button></li>
                                <li><button type="button" class="btn btn-primary btn-lg next-step">Guardar y continuar</button></li>
                            </ul>
                        </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <center>
                            <h3>Tipo de Administrador <br><small></small></h3>
                        </center>
                        <hr>
                        <div class="frb-group">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="frb frb-info">
                                    <input type="radio" id="radio-button-1" name="admin" value="0">
                                    <label for="radio-button-1">
                                        <span class="frb-title">Administrador Externo</span>
                                        <span class="frb-description">No vivo dentro del Conjunto Residencial. <br><br></span>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="frb frb-info">
                                    <input type="radio" id="radio-button-2" name="admin" value="1">
                                    <label for="radio-button-2">
                                        <span class="frb-title">Administrador Interno</span>
                                        <span class="frb-description">Vivo dentro del Conjunto Residencial (configuraré mi dirección más tarde)</span>
                                    </label>
                                </div>
                            </div>
                            <span class="form-control-feedback errors">{{ $errors->first('admin') }} </span>
                        </div>
                </div>
                        <ul class="list-inline pull-right">
                            <li><button type="button" class="btn btn-default btn-lg prev-step">Anterior</button></li>
                            <li><button type="submit" class="btn btn-success btn-lg">Finalizar</button></li>
                        </ul>
                    </div>
                   {{--  <div class="tab-pane" role="tabpanel" id="complete">
                        <h3>Listo!</h3>
                        <p>Haz completado todos los pasos y se ha guardado la informacion suministrada.</p>
                    </div> --}}
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </section>
   </div>
</div>

    @include('adminlte::layouts.partials.scripts_wizard_register')

</body>

@endsection
