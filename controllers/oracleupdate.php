<?php 
// ini_set('display_errors', 'Off');
session_start();
$date_user = $_SESSION['ss_registrado'];

$id_usuario = $_SESSION['ss_id_usuario'];

$nombre_usuario = $_SESSION['ss_nombre_completo'];

// ini_set('MAX_EXECUTION_TIME', 3600);

$pointjsonde = json_decode($_POST['datos']);/*$_POST['datos']*/

// echo $pointjsonde[0]->lat."<br>";
// echo $pointjsonde[1]->lat."<br>";

$resultado = array();

$user = 'owinspeccion';
$pass = 'wu6upH@budru';
$cadena = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.65.114)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = prodorac)))';

$conexion = oci_connect($user, $pass,$cadena);

if (!$conexion) {
    $e = oci_error();
    trigger_error(htmlentities(strtoupper($e['message'])." --> ERROR EN LA CONEXION", ENT_QUOTES), E_USER_ERROR);
}

$file = fopen("consultas.txt", "a");

//------------------------------------------------------- UPDATE
// Preparar la sentencia
$qryudt = 'UPDATE FORMATO_DICTAMEN SET LATITUD ='.$pointjsonde[1]->lat.', LONGITUD = '.$pointjsonde[1]->lng.' WHERE IDFORMATO ='.$pointjsonde[0]->idregistro;
echo $qryudt;
fwrite($file, "Consulta Actualizacion: ".$qryudt. PHP_EOL);

$qry_updt = oci_parse($conexion, $qryudt);
if (!$qry_updt) {
    $e_updt = oci_error($conexion);
    trigger_error(htmlentities(strtoupper($e_updt['message'])." --> ERROR AL REALIZAR LA CONSULTA", ENT_QUOTES), E_USER_ERROR);
    	$resultado["mensaje_update"] = "Ocurrió un error ".$e_updt['message'];
		$resultado["codigo_update"] = 0;
}

// Realizar la lógica de la consulta
/*
    $r_updt = oci_execute($qry_updt);
    if (!$r_updt) {
        $e_updt = oci_error($qry_updt);
        trigger_error(htmlentities(strtoupper($e_updt['message'])." --> ERROR EN LA CONSULTA LA TABLA NO EXISTE", ENT_QUOTES), E_USER_ERROR);
        	$resultado["mensaje_update"] = "Ocurrió un error ".$e_updt['message'];
    		$resultado["codigo_update"] = 0;
    }else{

    	$resultado["mensaje_update"] = "Se actualizo correctamente la informacion del idformato: ".$pointjsonde[0]->idregistro.".";
        $resultado["codigo_update"] = 1;
    }
*/
//------------------------------------------------------- INSERT
// Preparar la sentencia
$qryist = "INSERT INTO HISTORY_MOVI_POING (IDFORMATO, LATITUD, LONGITUD, ID_USUARIO, DATE_USUARIO, NOMBRE_USUARIO) VALUES (".$pointjsonde[0]->idregistro.", ".$pointjsonde[1]->lat.", ".$pointjsonde[1]->lng.", ".$id_usuario.", ".$date_user.", '".$nombre_usuario."')";
echo $qryist;
fwrite($file, "Consulta Insercion: ".$qryist. PHP_EOL);

$qry_ist = oci_parse($conexion, $qryist);
if (!$qry_ist) {
    $e_ist = oci_error($conexion);
    trigger_error(htmlentities(strtoupper($e_ist['message'])." --> ERROR AL REALIZAR LA CONSULTA", ENT_QUOTES), E_USER_ERROR);
    	$resultado["mensaje_insert"] = "Ocurrió un error ".$e_ist['message'];
		$resultado["codigo_insert"] = 0;
}

// Realizar la lógica de la consulta
/*    
    $r_ist = oci_execute($qry_ist);
    if (!$r_ist) {
        $e_ist = oci_error($qry_ist);
        trigger_error(htmlentities(strtoupper($e_ist['message'])." --> ERROR EN LA CONSULTA LA TABLA NO EXISTE", ENT_QUOTES), E_USER_ERROR);
        	$resultado["mensaje_insert"] = "Ocurrió un error ".$e_ist['message'];
    		$resultado["codigo_insert"] = 0;
    }else{

    	$resultado["mensaje_insert"] = "Se registro el historial correctamente del registro ".$pointjsonde[0]->idregistro.".";
        $resultado["codigo_insert"] = 1;
    }
*/
//------------------------------------------------------- SELECT
// Preparar la sentencia
/*
    $qryslt = 'SELECT * FROM FORMATO_DICTAMEN WHERE IDFORMATO='.$pointjsonde[0]->idregistro;
    echo $qryslt;

    $qry_slt = oci_parse($conexion, $qryslt);
    if (!$qry_slt) {
        $e_slt = oci_error($conexion);
        trigger_error(htmlentities(strtoupper($e_slt['message'])." --> ERROR AL REALIZAR LA CONSULTA", ENT_QUOTES), E_USER_ERROR);
    }

    // Realizar la lógica de la consulta
    $r_slt = oci_execute($qry_slt);
    if (!$r_slt) {
        $e_slt = oci_error($qry_slt);
        trigger_error(htmlentities(strtoupper($e_slt['message'])." --> ERROR EN LA CONSULTA LA TABLA NO EXISTE", ENT_QUOTES), E_USER_ERROR);
    }

    while ($row = oci_fetch_array ($qryslt, OCI_BOTH)) {
        // echo $row[0];
        $resultado["IDFORMATO"] = $row['IDFORMATO'];
        // echo $row[1];
        $resultado["CLAS_GLOBAL"]=$row['CLAS_GLOBAL'];
    }
*/
// oci_free_statement($qryslt);
oci_free_statement($qry_ist);
oci_free_statement($qry_updt);
oci_close($conexion);

fwrite($file, "Resultado de Consulta Mensaje Insercion ".$resultado["mensaje_insert"]. PHP_EOL);
fwrite($file, "Resultado de Consulta Codigo Insercion".$resultado["codigo_insert"]. PHP_EOL);
fwrite($file, "Resultado de Consulta Mensaje Actualizacion".$resultado["mensaje_update"]. PHP_EOL);
fwrite($file, "Resultado de Consulta Codigo Actualizacion".$resultado["codigo_update"]. PHP_EOL);
fclose($file);
echo json_encode($resultado);

exit();

?>