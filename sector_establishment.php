<?php
    require('abrir.php');
    
    $sector = $_GET['sector'];
    
    $consulta_establ = "SELECT Codigo_Unico, Nombre_Establecimiento FROM MAESTRO_HIS_ESTABLECIMIENTO WHERE Disa='PASCO' AND Descripcion_Sector = '$sector'";
    $resul_establ = sqlsrv_query($conn, $consulta_establ);
    // echo $resul_establ;
    while ($consulta = sqlsrv_fetch_array($resul_establ)){
        $id = $consulta['Codigo_Unico'];
        $nombre_establecimiento = utf8_encode($consulta['Nombre_Establecimiento']);
        echo $id, '---', $nombre_establecimiento, '---';
    }
?>