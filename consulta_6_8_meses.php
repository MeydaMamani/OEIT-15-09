<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
        ini_set("default_charset", "UTF-8");
        mb_internal_encoding("UTF-8");

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];

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

        $resultado = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                      pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                            WHEN pn.NUM_DNI IS NOT NULL
                            THEN pn.NUM_DNI
                            ELSE pn.NUM_CNV
                          END,
                        CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) AS APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN
                            into BDHIS_MINSA.dbo.PADRON_EVALUAR6
                        from NOMINAL_PADRON_NOMINAL AS pn
                        where YEAR (DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='$anio' and month(DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='$mes'
                        and mes='$anio$mes2';
                        with c as ( select DOCUMENTO, nombre_dist, ROW_NUMBER() over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA.dbo.PADRON_EVALUAR6)
                        delete  from c
                        where duplicado >1";	

        $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                        A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                        Min(CASE WHEN (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='$anio' AND  EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'85018',
                        Min(CASE WHEN (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'D50X',
                        Min(CASE WHEN (Codigo_Item ='U310' AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'U310_SF1',
                        Min(CASE WHEN (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'SUPLE'
                        into BDHIS_MINSA.dbo.suple6
                        --select * from BDHIS_MINSA.dbo.suple6
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA AS A
                        WHERE
                          ((a.fecha_atencion> CONVERT(DATE, DATEADD(dd, -170, CONCAT('$anio$mes2', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/$anio'),0))))))) and 
                          (a.fecha_atencion<= CONCAT('$anio-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/$anio'),0)))))) AND
                          ( (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='$anio' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                          (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D'  AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                          (Codigo_Item IN('U310','99199.17') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) or
                          (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) )
                        GROUP BY A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                        A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente				
                        ORDER BY Numero_Documento_Paciente asc, A.Nombre_Establecimiento";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
          $dist=$dist_1;
          $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                          pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                          pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                          s.D50X,s.U310_SF1,s.SUPLE
                          FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                          on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red'
                          order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                          DROP TABLE BDHIS_MINSA.dbo.suple6
                          DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $dist = '';
          $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                            pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente AS TIPO_DOC, APELLIDOS_NOMBRES,
                            pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN AS PN_ULTIMO_LUGAR, S.Nombre_Establecimiento AS ESTAB_ACTIVIDAD, s.[85018] HEMOGLOBINA,
                            s.D50X, s.U310_SF1, s.SUPLE
                            FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 AS s
                            on pn.DOCUMENTO=s.Numero_Documento_Paciente
                            order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO	   
                            DROP TABLE BDHIS_MINSA.dbo.suple6
                            DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";   
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                        s.D50X,s.U310_SF1,s.SUPLE
                        FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                        on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red' AND pn.NOMBRE_DIST='$dist'
                        order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                        DROP TABLE BDHIS_MINSA.dbo.suple6
                        DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
        }
           
        $consulta2 = sqlsrv_query($conn2, $resultado);
        $consulta3 = sqlsrv_query($conn, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>