<?php

$serverName = "172.16.0.230"; //serverName\instanceName
$connectionInfo = array( "Database"=>"BD_PADRON_NOMINAL", "UID"=>"OEIT-JHON", "PWD"=>"minsa123");
$conn2 = sqlsrv_connect( $serverName, $connectionInfo);

if($conn2) {
     echo "";
     
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));

}

?>
