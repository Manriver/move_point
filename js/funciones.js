//FUNCION QUE ACTIVA LOS MENSAJES EN VALIDACION DE FORMULARIOS, ETC.
function mostrarMensaje(tipo,mensaje){
	//SUCCESS (VERDE)	//INFO (AZUL)	//WARNING (AMARILLO)	//DANGER (ROJO)
	var icono = '';
	switch(tipo){
		case 'error': 	icono = 'glyphicon glyphicon-remove';
						tipo = 'danger';
						break;
		case 'correcto':icono = 'glyphicon glyphicon-ok';
						tipo = 'success';
						break;
		case 'mensaje': icono = 'glyphicon glyphicon-eye-open';
						tipo = 'info';
						break;
		case 'alerta': 	icono = 'glyphicon glyphicon-warning-sign';
						tipo = 'warning';
						break;
		default: 		icono = 'glyphicon glyphicon-warning-sign';
						tipo = 'error';
						mensaje = 'Asignación de tipo incorrecto. (Error: MSG0001)';
						break;
	}
	
	$.notify({
		// options
          icon: icono,
          title: '<strong>Atención: </strong>',
          message: mensaje
        },{
          // settings
          type: tipo
	});
}

function addAlert(clase,title,cadena){
	
	var tipo = "";
	
	switch(clase){
		case 'correcto':
		tipo = "alert-success";
		break;
		
		case 'info':
		tipo = "alert-info";
		break;
		
		case 'warning':
		tipo = "alert-warning";
		break;
		
		case 'error':
		tipo = "alert-danger";
		break;
		
		default: 		
		tipo = 'error';
		break;
	}
	
	var message = '';
	message = '<div id="mensajes" class="alert '+tipo+' alert-dismissible" role="alert">'
			  +'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
			  +'<strong>' + title + '</strong>' + cadena +'</div>';
	return message;
}

function number_valida(event)
{
    event = (event) ? event : window.event;
    var evt = (event.which) ? event.which : event.keyCode;
    if(evt.shiftKey){return event.preventDefault();}
    if (evt == 46 || evt == 8 || evt == 9){}else {if(evt < 95){if (evt < 48 || evt > 57){return event.preventDefault();}}
	else {if (evt < 96 || evt > 105){return event.preventDefault();}}}
}

function transformaFecha(fecha)			//2014-08-06			alert(fecha);
{
	
	var meses = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
	var dia = fecha.substring(8,10);			//alert(dia);
	var mes = parseInt(fecha.substring(5,7));			//alert(mes);
	var anio = fecha.substring(0,4);			//alert(anio);
	var trans = dia+' de '+meses[mes]+ ' del '+anio;			//alert(trans);
	return trans.toUpperCase();    
}

function recorta(cadeniux){
	if(cadeniux.length  > 30){
		cadeniux = cadeniux.substring(0,30);    
		cadeniux = cadeniux+'...';}
	return cadeniux;}