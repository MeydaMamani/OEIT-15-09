<?php
    require('abrir.php');
    
    $consult_profession = "SELECT distinct(Id_Profesion), Descripcion_Profesion from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Id_Profesion is not null
                            ORDER BY Id_Profesion, Descripcion_Profesion";
    
    $result_profession = sqlsrv_query($conn, $consult_profession);
    // echo $resul_establ;  
    while ($consulta = sqlsrv_fetch_array($result_profession)){
        $id = $consulta['Id_Profesion'];
        $prefession = utf8_encode($consulta['Descripcion_Profesion']);
        echo $id, '---', $prefession, '---';
    }
?>