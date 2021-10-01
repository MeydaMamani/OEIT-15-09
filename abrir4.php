<?php

$serverName = "172.16.0.230"; //serverName\instanceName
$connectionInfo = array( "Database"=>"BDHIS_MINSA_EXTERNO", "UID"=>"OEIT-JHON", "PWD"=>"minsa123");
$conn4 = sqlsrv_connect( $serverName, $connectionInfo);

if($conn4) {
     echo "";
     
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));

}

?>
