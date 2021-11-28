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
    
        $resultado = "SELECT P.*,
                        CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                        CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS'
                        INTO TBDOSIS FROM PADRON_MAYOR_12_ANIOS_19_11  P
                        LEFT JOIN VACUNADOS V
                        ON P.NUM_DOC=V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC
                        LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN
                        ON P.NUM_DOC=VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT CONCAT(P.APELLIDO_PATERNO, ' ', P.APELLIDO_MATERNO, ' ', P.NOMBRES) AS FULL_NAME, P.*, 
                            CASE WHEN (V.FECHA_VACUNACION IS NULL) THEN VN.FECHA_VACUNACION 
                            ELSE V.FECHA_VACUNACION END AS 'TERCERA DOSIS'
                            FROM TBDOSIS P 
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V ON 
                            P.NUM_DOC = V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC AND V.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN
                            ON P.NUM_DOC = VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC AND VN.DOSIS_APLICADA='3ª dosis'
                            WHERE PROVINCIA = '$red'
                            DROP TABLE TBDOSIS";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT CONCAT(P.APELLIDO_PATERNO, ' ', P.APELLIDO_MATERNO, ' ', P.NOMBRES) AS FULL_NAME, P.*, 
                            CASE WHEN (V.FECHA_VACUNACION IS NULL) THEN VN.FECHA_VACUNACION 
                            ELSE V.FECHA_VACUNACION END AS 'TERCERA DOSIS'
                            FROM TBDOSIS P 
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V ON 
                            P.NUM_DOC = V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC AND V.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN
                            ON P.NUM_DOC = VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC AND VN.DOSIS_APLICADA='3ª dosis'
                            WHERE PROVINCIA = '$red' AND DISTRITO = '$dist'
                            DROP TABLE TBDOSIS";

        }

        $consulta1 = sqlsrv_query($conn6, $resultado);
        $consulta2 = sqlsrv_query($conn6, $resultado2);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>