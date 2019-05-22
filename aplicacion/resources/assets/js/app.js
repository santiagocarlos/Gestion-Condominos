require('./bootstrap');

$('form').on('submit', function(){
	$find(this).find('input[type=submit]').attr('disable', true);
});
