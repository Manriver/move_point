<?php			//print_r($_POST); exit();
include_once("../nusoap-0.9.5/lib/nusoap.php");

//error_reporting(E_ALL);
ini_set('display_errors', 'Off');

// info1 en caso de que no existe "usr" 
$info1['error'] = 'Ingrese el nombre de usuario';
$info1['codigo'] = 1;

// info2 en caso de que no existe "pass"
$info2['error'] = 'Ingrese la contraseña';
$info2['codigo'] = 2;

// info3 en caso de que no existe registro en BD
$info3['error'] = 'Datos Incorrectos';
$info3['codigo'] = 3;

// info4 en caso de que exista registro en BD, exista en tabla USUARIO, USUARIO PERSONA Y PERSONA
$info4['error'] = 'Acceso Correcto';
$info4['codigo'] = 0;
//$info4['url'] = ACCESO_PRINCIPAL;
$info4['url'] = 'inicio.html';

if(trim($_POST['username']) == ""){
	echo json_encode($info1);
	exit();}
    
if(trim($_POST['password']) == ""){        	
	echo json_encode($info2);
	exit();}

$user=$_POST['username'];
$pwd=md5($_POST['password']);
$app=55;
//$excep = array ('trace' => 1, 'exceptions' => 1, 'cache_wsdl' => WSDL_CACHE_NONE );
$excep = array ('trace' => 1, 'exceptions' => 1);
$client = new nusoap_client ('http://10.1.126.7/ws_usuarios/ws_usuarios?wsdl',$excep);
$param=array('usuario'=>$user,'password'=>$pwd,'aplicacion'=>$app);
$result = $client->call('validaAccesoPrincipal',$param);			//echo '<pre>';			print_r($result);

 if($result['acceso'] == 1) {
	$user_data = json_decode($result['data']);			//print_r($user_data);		//NO SESSION
	$id_usuario = $user_data->usuario->id_usuario;			//SESSION
	$perfil = $user_data->usuario->perfil;					//SESSION
	$permisos = $user_data->usuario->permisos[0];			//NO SESSION
	$id_permiso = $permisos->ID_PERMISO;					//SESSION
	$descripcion_permiso = $permisos->DESCRIPCION;			//SESSION	
	$nombre_completo = $user_data->usuario->nombre." ".$user_data->usuario->apellidoPaterno." ".$user_data->usuario->apellidoMaterno;			//SESSION
	session_start();
	$_SESSION['ss_registrado']= date("Y-n-j H:i:s");
	$_SESSION['ss_id_usuario'] = $id_usuario;
	$_SESSION['ss_perfil'] = $perfil;
	$_SESSION['ss_id_permiso'] = $id_permiso;
	$_SESSION['ss_descripcion_permiso'] = $descripcion_permiso;
	$_SESSION['ss_nombre_completo'] = $nombre_completo;
	
	echo json_encode($info4);
	exit();	
}else{
	echo json_encode($info3);
	exit();
}










//Insertamos los valores de Session	
/*$user['ss_registrado'] = date("Y-n-j H:i:s");
$user['ss_id_usuario'] =  $id_usuario;
$user['ss_login'] =  $login;
$user['ss_id_persona'] =  $id_persona;
$user['ss_rfc'] =  $rfc;
$user['ss_correo'] =  $correo;
$user['ss_telefono'] =  $telefono;
$user['ss_id_perfil'] =  $id_perfil;
$user['ss_perfil'] =  $perfil;
$user['ss_nombre_completo'] =  $nombre_completo;
//PARA ESTE SISTEMA
$user['ss_id_aplicacion'] = $id_aplicacion;
$user['ss_aplicacion'] = $aplicacion;
$user['ss_desc_corta'] = $desc_corta;
$this->session->set_userdata($user);*/	
/*if ( $rs_usuario != null ) {
	echo json_encode($info4);	
	exit();
}*/
	