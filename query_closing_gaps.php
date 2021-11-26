<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');

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
    
        $resultado = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                        V.PRIMERA_GRUPO,V.PRIMERA,VN.SEGUNDA,VN.SEGUNDA_DEP, 
                        CASE WHEN (V.PRIMERA_FAB ='ASTRAZENECA') THEN DATEADD(DAY,27,V.PRIMERA) ELSE DATEADD(DAY,20,V.PRIMERA) END AS 'FECHA_PARA_SEGUNDA',
                        CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FALLECIDOS',
                        CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO' END AS 'RECHAZO'
                        INTO TEMPORAL1 FROM VACUNADOS V
                        LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC
                        LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                        LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                        WHERE V.SEGUNDA IS NULL";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            AND V.PRIMERA_PROV = '$red'
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                            WHERE V.PRIMERA_PROV='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'";
     
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            AND V.PRIMERA_PROV='$red' AND V.PRIMERA_DIST='$dist'
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                            WHERE V.PRIMERA_PROV = '$red' AND V.PRIMERA_DIST='$dist'";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);
        $consulta2 = sqlsrv_query($conn6, $resultado2);
        $consulta3 = sqlsrv_query($conn6, $resultado3);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>