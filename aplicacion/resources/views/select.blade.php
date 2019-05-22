<!DOCTYPE html>
<html lang="es">
@section('htmlheader_title') {{-- TITULO DE LA PAGINA --}}
Selección de Rol
@endsection
@section('htmlheader')
@show
<style>
    body{
      background-color: #ecf0f5;
      /*background: url('{{asset('img/fondo.jpg')}}') no-repeat center center fixed;
      background-attachment: fixed;
      background-size: cover;*/
    }
    .card{
        width: 165px;
        height: 220px;
        display: inline-block;
        background-color: rgba(255,255,255,.7);
        margin:20px;
        text-align: center;
        padding:0px 10px 0px 10px;
        cursor: pointer;
        opacity: .6;
        -webkit-border-radius: 5px 5px 3px 3px;
        -moz-border-radius: 5px 5px 3px 3px;
        border-radius: 5px 5px 3px 3px;
        -webkit-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px -1px rgba(0,0,0,0.75);
        transition: all .7s ease;
    }
    .card h4{
      font-size: 12pt;
      font-weight: 600;
    }
    .card:hover{
      opacity: 1;
      -webkit-box-shadow: 0px 10px 20px -6px rgba(0,192,239,1);
      -moz-box-shadow: 0px 10px 20px -6px rgba(0,192,239,1);
      box-shadow: 0px 10px 20px -6px rgba(0,192,239,1);
      -webkit-box-shadow: 0px 12px 67px -3px rgba(0,192,239,1);
      -moz-box-shadow: 0px 12px 67px -3px rgba(0,192,239,1);
      box-shadow: 0px 12px 67px -3px rgba(0,192,239,1);
      background-color: #00c0ef;
      color:#fff;
      transition-duration:.7s ease-out;
    }
    .brand{
      color: #006400;
      border:1px solid rgba(255,255,255,.7);
      margin-top:30px;
      background-color: rgba(255,255,255,.5);
      -webkit-box-shadow: 0px 0px 46px -3px rgba(0,100,0,1);
      -moz-box-shadow: 0px 0px 46px -3px rgba(0,100,0,1);
      box-shadow: 0px 0px 46px -3px rgba(0,100,0,1);
    }
    .brand .tittle{
      font-size: 50pt;
      padding-top: 25px;
      vertical-align: middle;
      line-height: 0.3;
    }
    .brand .description{
      font-size: 9pt;
      margin-top: 13px;
    }
    @media(max-width: 768px){
    }
    @media(min-width: 769px){
      .brand .tittle{
        line-height: 0.7;
        margin-bottom: 18px;
      }
    }
    .img-custom{
        width: 150px;
        height: 150px;
    }
</style>

<body class="container">
  <div class="row">

    {{--@include('layouts.partials.mainheader')--}}

    <div class=" col-md-offset-4 col-md-4 col-md-offset-4 visible-md visible-lg"  >
        <p style="margin-top: 50px; text-align: center; font-size: 22px;">
          Gestión de Condominios
        </p>
        {{-- <center><img src="{{asset('img\logo.png')}}" class="img-responsive"></center> --}}
    </div>
    {{-- <div class=" col-sm-offset-2 col-sm-8 col-sm-offset-2 col-xs-12 visible-sm visible-xs" >
        <center><img src="{{asset('img\logo.png')}}" class="img-responsive"></center>
    </div> --}}
    <div class="clearfix"></div>
    <center><p>Por favor, seleccione un rol para ingresar.</p></center>

    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="content">
        <!-- Your Page Content Here -->
        {!! Form::open(array('route' => 'auth.select','method'=>'POST','id'=>'form-select')) !!}
        {{ csrf_field() }}
        <div class="row">
            @if(isset($roles) && count($roles)>0)
              @foreach($roles as $rol)
                <div class="card col-lg-2" data-id="{{ $rol->id }}">
                  <img src="{{ asset('img/icon-user-default.png') }}" class="img-responsive img-custom" data-id="{{ $rol->id }}" id="image">
                  <h4 class="text-center">{{ $rol->display_name }}</h4>
                </div>
              @endforeach
            @endif
          <input type="hidden" name="rol" id="rol">

        </div>

        {!! Form::close() !!}
    </section><!-- /.content -->
  </div>

@section('scripts')
    @include('adminlte::layouts.partials.scripts_auth')
@show

<script>
    $(document).on('click','.card', function (e) {
        let $this = $(this);
        let $form = $('#form-select');
        let $input = $('#rol');

        let $id = $this.data('id');


        $input.val($id);

        $form.submit();
    });
</script>
</body>
</html>