<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;        
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if($mes == 1){ $nombre_mes = 'Enero'; }
        else if($mes == 2){ $nombre_mes = 'Febrero'; }
        else if($mes == 3){ $nombre_mes = 'Marzo'; }
        else if($mes == 4){ $nombre_mes = 'Abril'; }
        else if($mes == 5){ $nombre_mes = 'Mayo'; }
        else if($mes == 6){ $nombre_mes = 'Junio'; }
        else if($mes == 7){ $nombre_mes = 'Julio'; }
        else if($mes == 8){ $nombre_mes = 'Agosto'; }
        else if($mes == 9){ $nombre_mes = 'Setiembre'; }
        else if($mes == 10){ $nombre_mes = 'Octubre'; }
        else if($mes == 11){ $nombre_mes = 'Noviembre'; }
        else if($mes == 12){ $nombre_mes = 'Diciembre'; }
        
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
        
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes' AND NOMBRE_PROV='$red'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";
        }

        $consulta1 = sqlsrv_query($conn2, $resultado2);
    }
?>