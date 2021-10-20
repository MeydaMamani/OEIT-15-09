<?php
    $serverName = "172.16.0.230"; //serverName\instanceName
    $connectionInfo = array( "Database"=>"BD_PADRONES_COVID", "UID"=>"OEIT-JHON", "PWD"=>"minsa123");
    $conn6 = sqlsrv_connect( $serverName, $connectionInfo);

    if($conn6) {
        echo "";
        
    }else{
        echo "Conexión no se pudo establecer.<br />";
        die( print_r( sqlsrv_errors(), true));
    }
?>
