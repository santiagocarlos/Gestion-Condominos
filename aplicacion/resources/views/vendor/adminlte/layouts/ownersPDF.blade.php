<!DOCTYPE html>
<html lang="es">
@section('htmlheader')
    @include('adminlte::layouts.partials.headerpdf')
@show

<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  {{-- @include('adminlte::layouts.partials.mainheaderowner') --}}
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      {{-- @include('adminlte::layouts.partials.content-header-owner') --}}
      <!-- Main content -->
      <section class="content">
        @yield('main-content')
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
    @include('adminlte::layouts.partials.footerPDF')

</div>
<!-- ./wrapper -->

@section('scripts')
    @include('adminlte::layouts.partials.scripts')
@show

</body>
</html>
