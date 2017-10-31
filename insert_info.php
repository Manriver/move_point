<?php			//echo print_r($_POST); exit();
ini_set('display_errors', 'Off');
session_start();
$usuario_alta = $_SESSION['ss_id_usuario'];

$respuesta = new stdClass();
$uso = $_POST['uso'];
$id_formato = $_POST['id_for'];
$id_ente = $_POST['idente'];
if(isset($_POST['riesgo'])){$riesgo = $_POST['riesgo'];}else{$riesgo = "";}
if(isset($_POST['uso2'])){$uso2 = $_POST['uso2'];}else{$uso2 = "";}
if(isset($_POST['levels'])){$niveles = $_POST['levels'];}else{$niveles = "NULL";}
if(isset($_POST['ocup'])){$ocupantes = $_POST['ocup'];}else{$ocupantes = "NULL";}
if(isset($_POST['clasificacion'])){$clasificacion = $_POST['clasificacion'];}else{$clasificacion = "";}
if(isset($_POST['clasificacion_nuevo'])){$clasificacion2 = $_POST['clasificacion_nuevo'];}else{$clasificacion2 = "";}
if(isset($_POST['nota'])){$nota = $_POST['nota'];}else{$nota = "";}

$user = 'owinspeccion';
$pass = 'wu6upH@budru';
$cadena = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.65.114)
	         (PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = prodorac)))';
$conexion = oci_connect($user, $pass,$cadena);
if (!$conexion) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);}

$insert = "INSERT INTO RIESGO_INCIERTO(USO_INMUEBLE,USO_2,NIVELES,OCUPANTES,CLASIFICACION,CLASIFICACION_NUEVO,RIESGO,IDENTEVIVIENDA,NOTAS,IDFORMATO,USARIO_ALTA,FECHA_ALTA) " 
		 ."VALUES('".strtoupper($uso)."','".strtoupper($uso2)."',".$niveles.",".$ocupantes.",'".strtoupper($clasificacion)."' "
		 .",'".strtoupper($clasificacion2)."','".strtoupper($riesgo)."',".$id_ente.",'".strtoupper($nota)."',".$id_formato.",".$usuario_alta.",SYSDATE)";
//echo "sql = ".$insert; exit();
$stid0 = oci_parse($conexion,$insert);
$res = oci_execute($stid0);

if($res){
	$respuesta->mensaje = "Se adjunto correctamente la informacion al registro ".$id_formato.".";
    $respuesta->codigo = 1;
	echo json_encode($respuesta);
	exit();
}else{
	$respuesta->mensaje = "Ocurrió un error.";
$respuesta->codigo = 0;
echo json_encode($respuesta);
exit();	
}
	









?>