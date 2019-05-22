<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>

<script src="{{ asset('/plugins/bootstrap3.3.0/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('/js/wizard/wizard.js') }}" type="text/javascript"></script>

<!-- Datepicker Files -->
<script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>

<script>
$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true
});
</script>
