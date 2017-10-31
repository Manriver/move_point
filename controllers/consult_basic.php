<?php 
ini_set('MAX_EXECUTION_TIME', 3600);

//(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.65.114)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = prodorac)))
$user = 'owinspeccion';
$pass = 'wu6upH@budru';
$cadena = '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.65.114)
	         (PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = prodorac)))';


//$conexion = oci_connect('owinspeccion', 'wu6upH@budru', '(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.1.65.114)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED) (SERVICE_NAME = prodorac)))');
$conexion = oci_connect($user, $pass,$cadena);


if (!$conexion) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Preparar la sentencia
$stid = oci_parse($conexion, 'SELECT * FROM FORMATO_DICTAMEN WHERE ROWNUM <= 2 ');
if (!$stid) {
    $e = oci_error($conexion);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Realizar la lógica de la consulta
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Obtener los resultados de la consulta
// print "<table border='1'>\n";
/*
while ($fila = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    // print "<tr>\n";
    foreach ($fila as $elemento) {
        print "    <td>" . ($elemento !== null ? htmlentities($elemento, ENT_QUOTES) : "") . "</td>\n";
    }
    // print "</tr>\n";
}
// print "</table>\n";
*/

while ($row = oci_fetch_array ($stid, OCI_BOTH)) {
    echo $row[0];
    echo " and ".$row['IDFORMATO']." is the same<br>";
    echo $row[1];
    echo " and ".$row['TICKET']." is the same<br>";
}


oci_free_statement($stid);
oci_close($conexion);


?>