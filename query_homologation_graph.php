<?php
    require ('abrir.php');
    require ('abrir2.php');
    if (isset($_POST['Buscar'])) {
        global $conex;

        include('query_homologation.php');
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resul_red = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes' AND NOMBRE_PROV='$red'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resul_red = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resul_red = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                            MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                            MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                            MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                            from NOMINAL_PADRON_NOMINAL
                            where mes='2021$mes2' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='$mes'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV";
        }

        $consulta_red = sqlsrv_query($conn2, $resul_red);

    }    
?>