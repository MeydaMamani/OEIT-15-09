<?php 
    require('abrir6.php');
        
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

    $resultado = "SELECT V.TIPO_DOC, V.NUM_DOC,
                    CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                    CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                    CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                    CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                    CASE WHEN (V.SEGUNDA IS NULL) THEN DATEADD(DAY,150,VN.SEGUNDA) ELSE DATEADD(DAY,150,V.SEGUNDA) END AS 'FECHA_PARA_3RA_DOSIS'
                    INTO T1 FROM VACUNADOS V
                    LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN 
                    ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC";

    $resultado2 = "SELECT * FROM T1 WHERE FECHA_PARA_3RA_DOSIS <GETDATE()";
           
    $consulta2 = sqlsrv_query($conn6, $resultado);
    $consulta3 = sqlsrv_query($conn6, $resultado2);
?>