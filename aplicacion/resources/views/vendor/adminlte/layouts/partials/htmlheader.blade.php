<head>
    <meta charset="UTF-8">
    <title> Panel de Administración - @yield('htmlheader_title', 'Your title here') </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/css/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/wizard/styles.css')  }}" rel="stylesheet" />
    <link href="{{ asset('/plugins/datatables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{asset('datepicker/css/bootstrap-datepicker3.css')}}" rel="stylesheet">

    <!-- Fonts and Icons -->
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">


    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>
