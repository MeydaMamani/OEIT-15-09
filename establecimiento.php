<?php
    require('abrir.php');
    $red_1 = $_GET['red'];
    $dist = $_GET['dist'];
    if ($red_1 == 1) {
        $red = 'DANIEL ALCIDES CARRION';
    }
    elseif ($red_1 == 2) {
        $red = 'OXAPAMPA';
    }
    elseif ($red_1 == 3) {
        $red = 'PASCO';
    }
    elseif ($red_1 == 4) {
        $redt = 'PASCO';
    }
    $consulta_establ = "SELECT Id_Establecimiento, Nombre_Establecimiento  FROM MAESTRO_HIS_ESTABLECIMIENTO 
                        WHERE Descripcion_Sector='GOBIERNO REGIONAL' AND Provincia='$red' AND Distrito='$dist'";
    $resul_establ = sqlsrv_query($conn, $consulta_establ);
    // echo $resul_establ;
    while ($consulta = sqlsrv_fetch_array($resul_establ)){
        $id = $consulta['Id_Establecimiento'];
        $nombre_establecimiento = $consulta['Nombre_Establecimiento'];
        echo $nombre_establecimiento, ',';
    }
?>