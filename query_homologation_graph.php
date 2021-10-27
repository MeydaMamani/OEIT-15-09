<?php
    require ('abrir.php');
    require ('abrir2.php');
    if (isset($_POST['Buscar'])) {
        global $conex;
        include('query_homologation.php');
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado3 = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='$red'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV
                            DROP TABLE sellomunicipal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado3 = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV
                            DROP TABLE sellomunicipal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT NOMBRE_PROV,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
                            sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
                            sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='$red'
                            group by NOMBRE_PROV
                            ORDER BY NOMBRE_PROV
                            DROP TABLE sellomunicipal";
        }
        
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta1 = sqlsrv_query($conn2, $resultado2);
        $consulta_red = sqlsrv_query($conn2, $resultado3);
    }    
?>