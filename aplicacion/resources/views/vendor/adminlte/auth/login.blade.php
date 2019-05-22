@extends('adminlte::layouts.auth')

@section('htmlheader_title')
    Iniciar Sesión
@endsection

@section('content')
<body class="hold-transition login-page">
    <div id="app">
        <div class="login-box">
            <div class="login-logo">
                <b>Gestión</b> de Condominios
            </div><!-- /.login-logo -->

        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Uppss!</strong> {{ trans('adminlte_lang::message.someproblems') }}<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="login-box-body">
        <p class="login-box-msg"> {{ trans('adminlte_lang::message.siginsession') }} </p>
        <form action="{{ url('/login') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" placeholder="{{ trans('adminlte_lang::message.email') }}" name="email"/>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" placeholder="{{ trans('adminlte_lang::message.password') }}" name="password"/>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-7">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember"> {{ trans('adminlte_lang::message.remember') }}
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-5">
                    <button type="submit" id="btn-login" class="btn btn-primary btn-block btn-flat">{{ trans('adminlte_lang::message.buttonsign') }}</button>
                </div><!-- /.col -->
            </div>
        </form>

       {{--  @include('adminlte::auth.partials.social_login') --}}

        <a href="{{ url('/password/reset') }}">{{ trans('adminlte_lang::message.forgotpassword') }}</a><br>
        <a href="{{ url('/register') }}" class="text-center">{{ trans('adminlte_lang::message.registermember') }}</a>

    </div><!-- /.login-box-body -->

    </div><!-- /.login-box -->
    </div>
    @include('adminlte::layouts.partials.scripts_auth')

    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

@endsection
