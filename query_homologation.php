<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;        
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if($mes == 1){ $nombre_mes = 'ENERO'; }
        else if($mes == 2){ $nombre_mes = 'FEBRERO'; }
        else if($mes == 3){ $nombre_mes = 'MARZO'; }
        else if($mes == 4){ $nombre_mes = 'ABRIL'; }
        else if($mes == 5){ $nombre_mes = 'MAYO'; }
        else if($mes == 6){ $nombre_mes = 'JUNIO'; }
        else if($mes == 7){ $nombre_mes = 'JULIO'; }
        else if($mes == 8){ $nombre_mes = 'AGOSTO'; }
        else if($mes == 9){ $nombre_mes = 'SETIEMBRE'; }
        else if($mes == 10){ $nombre_mes = 'OCTUBRE'; }
        else if($mes == 11){ $nombre_mes = 'NOVIEMBRE'; }
        else if($mes == 12){ $nombre_mes = 'DICIEMBRE'; }
        
        if (strlen($mes) == 1){
            $mes2 = '0'.$mes;
        }else{
            $mes2 = $mes;
        }

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
        
        $resultado = "SELECT NOMBRE_PROV,NOMBRE_DIST, MENOR_VISITADO, MENOR_ENCONTRADO,FECHA_VISITA,NUM_CNV,COD_CUI,NUM_DNI,FECHA_NACIMIENTO_NINO,APELLIDO_PATERNO_NINO,
                        APELLIDO_MATERNO_NINO,NOMBRE_NINO,AREA_CENTRO_POBLA,EJE_VIAL,DESCRIPCION,REFERENCIA_DIREC,TIPO_SEGURO,
                        'MES_A_MEDIR' = CASE 
                            WHEN CAST(FECHA_NACIMIENTO_NINO AS DATE)>='2021-06-02' AND CAST(FECHA_NACIMIENTO_NINO AS DATE)<='2021-07-02'
                            THEN 'JULIO'
                            WHEN CAST(FECHA_NACIMIENTO_NINO AS DATE)>='2021-07-03' AND CAST(FECHA_NACIMIENTO_NINO AS DATE)<='2021-08-01'
                            THEN 'AGOSTO'
                            WHEN CAST(FECHA_NACIMIENTO_NINO AS DATE)>='2021-08-02' AND CAST(FECHA_NACIMIENTO_NINO AS DATE)<='2021-09-01'
                            THEN 'SETIEMBRE'
                            WHEN CAST(FECHA_NACIMIENTO_NINO AS DATE)>='2021-09-02' AND CAST(FECHA_NACIMIENTO_NINO AS DATE)<='2021-10-01'
                            THEN 'OCTUBRE'
                            WHEN CAST(FECHA_NACIMIENTO_NINO AS DATE)>='2021-10-02' AND CAST(FECHA_NACIMIENTO_NINO AS DATE)<='2021-10-31'
                            THEN 'NOVIEMBRE'
                            ELSE '0'
                            END
                        into sellomunicipal
                        from NOMINAL_PADRON_NOMINAL
                        WHERE MES='2021$mes2' AND YEAR(FECHA_NACIMIENTO_NINO)>='2021'
                        GROUP BY NOMBRE_PROV,NOMBRE_DIST, MENOR_VISITADO, MENOR_ENCONTRADO,FECHA_VISITA,NUM_CNV,COD_CUI,NUM_DNI,FECHA_NACIMIENTO_NINO,APELLIDO_PATERNO_NINO,
                        APELLIDO_MATERNO_NINO,NOMBRE_NINO,AREA_CENTRO_POBLA,EJE_VIAL,DESCRIPCION,REFERENCIA_DIREC,TIPO_SEGURO
                        ORDER BY FECHA_NACIMIENTO_NINO";

        $resultado2 = "UPDATE sellomunicipal
                        SET NUM_DNI = '0'
                        WHERE NUM_DNI is null
                        UPDATE sellomunicipal
                        SET EJE_VIAL='0'
                        WHERE EJE_VIAL =''";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='$red'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";
        }
        
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta1 = sqlsrv_query($conn2, $resultado2);
        $consulta2 = sqlsrv_query($conn2, $resultado3);
    }
?>