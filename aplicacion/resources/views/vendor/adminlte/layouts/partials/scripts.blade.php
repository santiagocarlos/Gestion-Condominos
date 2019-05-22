<!-- REQUIRED JS SCRIPTS -->

<!-- JQuery and bootstrap are required by Laravel 5.3 in resources/assets/js/bootstrap.js-->
<!-- Laravel App -->
<script src="{{ asset('/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<script src="{{ asset('/js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('/plugins/ckeditor/ckeditor.js') }}"></script>
<!-- Datepicker Files -->
<script src="{{asset('datepicker/js/bootstrap-datepicker.js')}}"></script>
<!-- Languaje -->
<script src="{{asset('datepicker/locales/bootstrap-datepicker.es.min.js')}}"></script>
@include('sweet::alert')

<script>
	$('button#deleteButton').on('click', function(e){
e.preventDefault();
swal({
    title: "Atención",
    text: "¿Estás seguro que deseas eliminar este registro? Una vez eliminado no podrás recuperarlo",
    icon: "warning",
    dangerMode: true,
    buttons: {
      cancel: "Cancelar",
      confirm: "Sí, eliminar",
    },
})
	.then ((willDelete) => {
	    if (willDelete) {
	       $(this).closest("form").submit();
	    }
	});
});

    $('button#deleteButtonExpense').on('click', function(e){
e.preventDefault();
swal({
    title: "Atención",
    text: "Ten cuidado! Si eliminas este gasto se eliminarán las facturas asociadas al mismo y también los recibos de condominio que contengan este gasto. Esta opción es peligrosa si no se sabe bien lo que se está haciendo. ¿Estás seguro que deseas eliminar este registro? Una vez eliminado no podrás recuperarlo",
    icon: "warning",
    dangerMode: true,
    buttons: {
      cancel: "Cancelar",
      confirm: "Sí, eliminar",
    },
})
    .then ((willDelete) => {
        if (willDelete) {
           $(this).closest("form").submit();
        }
    });
});

    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
    ]) !!};

  $(function () {
    $('#example1').DataTable();
  })


$('.datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true
});

$('#datepicker').datepicker({
    format: "dd-mm-yyyy",
    language: "es",
    autoclose: true
});

$(document).ready(function(){
    var next = 1;
    $(".add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="phone[' + next + ']" type="text">';
        var newInput = $(newIn);
        var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);

            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });
});

</script>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementById('myImg');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
img.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
  captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
</script>
