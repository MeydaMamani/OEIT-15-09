<?php
    require ('abrir.php');
    require ('abrir2.php');
    
    // include('query_homologation.php');
    // $dist = $_GET['red'];
    // echo 'SDOY RED ', $dist;
    if(isset($_GET['red'])){
        $dist = $_GET['red'];
        echo 'SDOY RED ', $dist;
        $myDist = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                    COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                    MIN(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS Nulosdni,
                    MIN(CASE WHEN EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA'  THEN 1 ELSE 0 END) AS NulosEJEVIAL1,
                    MIN(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS NuloDESCRIPCION,
                    MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS NULOREFERENCIADESCRIPCION,
                    MIN(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS Nino_visitdo
                    from NOMINAL_PADRON_NOMINAL
                    where mes='202110' and YEAR(FECHA_NACIMIENTO_NINO)='2021' and month (FECHA_NACIMIENTO_NINO)='10' and NOMBRE_PROV='$dist'
                    group by NOMBRE_PROV,NOMBRE_DIST
                    ORDER BY NOMBRE_PROV, NOMBRE_DIST";
    
        $con_red = sqlsrv_query($conn2, $myDist);
        while ($consul = sqlsrv_fetch_array($con_red)){
            echo $consul['NOMBRE_DIST'];
        }

    }else{
        $myDist = "";
        $con_red = sqlsrv_query($conn2, $myDist);   
    }

?>