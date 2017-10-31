$(document).ready(function(){

	var $login = $('#acceder');
	
	$login.on('click',function(e){
		e.preventDefault();
	    var url = 'controllers/login.php';
	    var datos = $('#form_login').serializeArray();

	    petichon = $.ajax({
	    	url: url,
	    	type: 'POST',
	    	dataType: 'json',
	    	data: datos
	    });

	    petichon.done(function(res){
	    	if (res.codigo >0) {
				mostrarMensaje('error', res.error);
	        }else
	           $(location).attr('href',res.url);
	    })
	});
});
