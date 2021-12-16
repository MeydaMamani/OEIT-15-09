<?php 
    require('abrir2.php');
    require('abrir6.php');
        
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

    if (isset($_POST['Buscar'])) {
        global $conex;
        
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];

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

        if($dist_1 == 'CONSTITUCIÓN') {
            $dist_1 = 'CONSTITUCION';
        }
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.TIPO_DOC,V.NUM_DOC,V.SEGUNDA_PACIEN,
                            V.SEGUNDA_EDAD,V.SEGUNDA_CEL,V.SEGUNDA,V.SEGUNDA_GRUPO,V.SEGUNDA_FAB,
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_3RA_DOSIS',
                            CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FELLECIDO',
                            CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO 3RA DOSIS' END AS 'RECHAZO',
                            CASE WHEN (V.TERCERA_DEP IS NULL) THEN VN.TERCERA_DEP ELSE V.TERCERA_DEP END AS 'DEPARTAMENTO',
                            CASE WHEN (V.TERCERA_PROV IS NULL) THEN VN.TERCERA_PROV ELSE V.TERCERA_PROV END AS 'PROVINCIA',
                            CASE WHEN (V.TERCERA_DIST IS NULL) THEN VN.TERCERA_DIST ELSE V.TERCERA_DIST END AS 'DISTRITO',
                            CASE WHEN (V.TERCERA_EESS IS NULL) THEN VN.TERCERA_EESS ELSE V.TERCERA_EESS END AS 'ESTABLECIMIENTO',
                            CASE WHEN (V.TERCERA_GRUPO IS NULL) THEN VN.TERCERA_GRUPO ELSE V.TERCERA_GRUPO END AS 'GRUPO DE RIESGO',
                            CASE WHEN (V.TERCERA_FAB IS NULL) THEN VN.TERCERA_FAB ELSE V.TERCERA_FAB END AS 'FABRICANTE'
                            FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC = VN.NUM_DOC AND V.TIPO_DOC=VN.TIPO_DOC AND VN.TERCERA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '3 DOSIS'
                            WHERE V.SEGUNDA IS NOT NULL AND DATEADD(DAY,150,V.SEGUNDA) < GETDATE()
                            AND V.SEGUNDA_PROV='$red' 
                            ORDER BY V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.SEGUNDA_PACIEN";

}
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.TIPO_DOC,V.NUM_DOC,V.SEGUNDA_PACIEN,
                            V.SEGUNDA_EDAD,V.SEGUNDA_CEL,V.SEGUNDA,V.SEGUNDA_GRUPO,V.SEGUNDA_FAB,
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_3RA_DOSIS',
                            CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FELLECIDO',
                            CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO 3RA DOSIS' END AS 'RECHAZO',
                            CASE WHEN (V.TERCERA_DEP IS NULL) THEN VN.TERCERA_DEP ELSE V.TERCERA_DEP END AS 'DEPARTAMENTO',
                            CASE WHEN (V.TERCERA_PROV IS NULL) THEN VN.TERCERA_PROV ELSE V.TERCERA_PROV END AS 'PROVINCIA',
                            CASE WHEN (V.TERCERA_DIST IS NULL) THEN VN.TERCERA_DIST ELSE V.TERCERA_DIST END AS 'DISTRITO',
                            CASE WHEN (V.TERCERA_EESS IS NULL) THEN VN.TERCERA_EESS ELSE V.TERCERA_EESS END AS 'ESTABLECIMIENTO',
                            CASE WHEN (V.TERCERA_GRUPO IS NULL) THEN VN.TERCERA_GRUPO ELSE V.TERCERA_GRUPO END AS 'GRUPO DE RIESGO',
                            CASE WHEN (V.TERCERA_FAB IS NULL) THEN VN.TERCERA_FAB ELSE V.TERCERA_FAB END AS 'FABRICANTE'
                            FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC = VN.NUM_DOC AND V.TIPO_DOC=VN.TIPO_DOC AND VN.TERCERA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '3 DOSIS'
                            WHERE V.SEGUNDA IS NOT NULL AND DATEADD(DAY,150,V.SEGUNDA) < GETDATE()
                            AND V.SEGUNDA_PROV='$red' AND V.SEGUNDA_DIST='$dist'
                            ORDER BY V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.SEGUNDA_PACIEN";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>