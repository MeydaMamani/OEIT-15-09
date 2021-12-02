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
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT 
                            CASE WHEN (V.PRIMERA_PROV IS NULL) THEN VN.PRIMERA_PROV ELSE V.PRIMERA_PROV END AS 'PROVINCIA_UNO',
                            CASE WHEN (V.PRIMERA_DIST IS NULL) THEN VN.PRIMERA_DIST ELSE V.PRIMERA_DIST END AS 'DISTRITO_UNO',
                            CASE WHEN (V.SEGUNDA_PROV IS NULL) THEN VN.SEGUNDA_PROV ELSE V.SEGUNDA_PROV END AS 'PROVINCIA_DOS',
                            CASE WHEN (V.SEGUNDA_DIST IS NULL) THEN VN.SEGUNDA_DIST ELSE V.SEGUNDA_DIST END AS 'DISTRITO_DOS',
                            V.TIPO_DOC, V.NUM_DOC,
                            CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                            CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                            CASE WHEN (V3.FECHA_VACUNACION IS NULL) THEN VN3.FECHA_VACUNACION ELSE V3.FECHA_VACUNACION END AS 'FECHA_TERCERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_CEL IS NULL) THEN V.PRIMERA_CEL ELSE V.SEGUNDA_CEL END AS 'NUM_CELULAR',
                            CASE WHEN (V.PRIMERA_FAB IS NULL) THEN VN.PRIMERA_FAB ELSE V.PRIMERA_FAB END AS 'NOMBRE_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_FAB IS NULL) THEN VN.SEGUNDA_FAB ELSE V.SEGUNDA_FAB END AS 'NOMBRE_SEGUNDA_DOSIS',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN VN.SEGUNDA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD',
                            CASE WHEN (V.SEGUNDA_GRUPO IS NULL) THEN VN.SEGUNDA_GRUPO ELSE V.SEGUNDA_GRUPO END AS 'GRUPO_RIESGO'
                            INTO T2 FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN 
                            ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V3 ON 
                            V.NUM_DOC = V3.NUM_DOC AND V.TIPO_DOC = V3.TIPO_DOC AND V3.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN3
                            ON V.NUM_DOC = VN3.NUM_DOC AND V.TIPO_DOC = VN3.TIPO_DOC AND VN3.DOSIS_APLICADA='3ª dosis'
                            WHERE (V.PRIMERA_PROV = '$red' or V.SEGUNDA_PROV = '$red')";

            $resultado2 = "SELECT * FROM T2 WHERE FECHA_TERCERA_DOSIS IS NOT NULL
                            DROP TABLE T2";
            
        }
        else if($dist_1 != 'TODOS'){
            echo 'OY RED', $red, '<br>';
            echo 'OY DISTR', $dist_1;
            $dist=$dist_1;
            $resultado1 = "SELECT 
                            CASE WHEN (V.PRIMERA_PROV IS NULL) THEN VN.PRIMERA_PROV ELSE V.PRIMERA_PROV END AS 'PROVINCIA_UNO',
                            CASE WHEN (V.PRIMERA_DIST IS NULL) THEN VN.PRIMERA_DIST ELSE V.PRIMERA_DIST END AS 'DISTRITO_UNO',
                            CASE WHEN (V.SEGUNDA_PROV IS NULL) THEN VN.SEGUNDA_PROV ELSE V.SEGUNDA_PROV END AS 'PROVINCIA_DOS',
                            CASE WHEN (V.SEGUNDA_DIST IS NULL) THEN VN.SEGUNDA_DIST ELSE V.SEGUNDA_DIST END AS 'DISTRITO_DOS',
                            V.TIPO_DOC, V.NUM_DOC,
                            CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                            CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                            CASE WHEN (V3.FECHA_VACUNACION IS NULL) THEN VN3.FECHA_VACUNACION ELSE V3.FECHA_VACUNACION END AS 'FECHA_TERCERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_CEL IS NULL) THEN V.PRIMERA_CEL ELSE V.SEGUNDA_CEL END AS 'NUM_CELULAR',
                            CASE WHEN (V.PRIMERA_FAB IS NULL) THEN VN.PRIMERA_FAB ELSE V.PRIMERA_FAB END AS 'NOMBRE_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_FAB IS NULL) THEN VN.SEGUNDA_FAB ELSE V.SEGUNDA_FAB END AS 'NOMBRE_SEGUNDA_DOSIS',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN VN.SEGUNDA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD',
                            CASE WHEN (V.SEGUNDA_GRUPO IS NULL) THEN VN.SEGUNDA_GRUPO ELSE V.SEGUNDA_GRUPO END AS 'GRUPO_RIESGO'
                            INTO T2 FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN 
                            ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V3 ON 
                            V.NUM_DOC = V3.NUM_DOC AND V.TIPO_DOC = V3.TIPO_DOC AND V3.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN3
                            ON V.NUM_DOC = VN3.NUM_DOC AND V.TIPO_DOC = VN3.TIPO_DOC AND VN3.DOSIS_APLICADA='3ª dosis'
                            WHERE (V.PRIMERA_PROV = '$red' or V.SEGUNDA_PROV = '$red')
                            AND (V.PRIMERA_DIST = '$dist' or V.SEGUNDA_DIST = '$dist')";

            $resultado2 = "SELECT * FROM T2 WHERE FECHA_TERCERA_DOSIS IS NOT NULL
                            DROP TABLE T2";
        }

        $consulta2 = sqlsrv_query($conn6, $resultado1);
        $consulta3 = sqlsrv_query($conn6, $resultado2);
    }
?>