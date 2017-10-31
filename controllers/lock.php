<?php 
session_start();
$obj = new stdClass;
$obj->sesion = 'abc';
$user_check = $_SESSION['ss_registrado'];
if(!isset($user_check)){
	$obj->sesion = 0;	
	echo json_encode($obj);
	exit();
}	
$fechaGuardada = $_SESSION['ss_registrado'];
$ahora = date("Y-n-j H:i:s");
$tiempo_transcurrido = (strtotime($ahora)-strtotime($fechaGuardada));

if($tiempo_transcurrido >= 1800){
	session_destroy();
	$obj->sesion = 0;	
	echo json_encode($obj);
	exit();
}else{
	$_SESSION['ss_registrado'] = $ahora;
	$obj->sesion = 1;	
	echo json_encode($obj);
	exit();

}
 
	
?>