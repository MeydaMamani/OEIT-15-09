<?php

$serverName = "172.16.0.230"; //serverName\instanceName
$connectionInfo = array( "Database"=>"SIS_COVID", "UID"=>"OEIT-JHON", "PWD"=>"minsa123");
$conn5 = sqlsrv_connect( $serverName, $connectionInfo);

if($conn5) {
     echo "";
     
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));

}

?>
