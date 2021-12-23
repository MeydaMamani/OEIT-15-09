<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');

    if (isset($_POST['Buscar'])) {
        global $conex;        
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

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO'; }
        elseif ($red_1 == 4) { $redt = 'PASCO'; }

        $resultado = "SELECT Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item,ROW_NUMBER()OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION)AS ORDEN
                        INTO BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where (CODIGO_ITEM IN ('59401.04','99199.26'))";

        $resultado2 = "SELECT Numero_Documento_Paciente,
                        MAX(CASE WHEN(ORDEN='1')THEN Fecha_Atencion ELSE NULL END)AS PRIMER_ENTREGA_SUPLEMENTO,
                        MAX(CASE WHEN(ORDEN='2')THEN Fecha_Atencion ELSE NULL END)AS SEGUNDO_ENTREGA_SUPLEMENTO,
                        MAX(CASE WHEN(ORDEN='3')THEN Fecha_Atencion ELSE NULL END)AS TERCERA_ENTREGA_SUPLEMENTO
                        INTO BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                        FROM SULFATO_FERROSO_AND_ACIDO_FOLICO
                        GROUP BY Numero_Documento_Paciente";

        $resultado3 = "SELECT A.NUMERO_DOCUMENTO_PACIENTE,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND ((CODIGO_ITEM IN ('85018','85018.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS DOSAJE_HEMOGLOBINA,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86780','86592','86593','86318.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_SIFILIS,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86703','86703.02','87389','86318.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_VIH,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('81007','81002','81000.02'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_BACTERIURIA,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('80055.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS PERFIL_OBSTETRICO,
                        MIN(CASE WHEN((FECHA_ATENCION>='2020-10-01')AND((CODIGO_ITEM IN ('Z3491','Z3591'))))THEN FECHA_ATENCION ELSE NULL END)AS PRIMER_TRIMESTRE_APN_PRESENCIAL,
                        MIN(CASE WHEN((FECHA_ATENCION>='2021-01-07')AND((CODIGO_ITEM IN ('Z3492','Z3592'))))THEN FECHA_ATENCION ELSE NULL END)AS SEGUNDO_TRIMESTRE_APN_PRESENCIAL,
                        MIN(CASE WHEN((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))THEN FECHA_ATENCION ELSE NULL END)AS TERCER_TRIMESTRE_1APN_PRESENCIAL,
                        MAX(CASE WHEN((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))THEN FECHA_ATENCION ELSE NULL END)AS TERCER_TRIMESTRE_2APN_PRESENCIAL,B.PRIMER_ENTREGA_SUPLEMENTO,B.SEGUNDO_ENTREGA_SUPLEMENTO,B.TERCERA_ENTREGA_SUPLEMENTO
                        INTO BDHIS_MINSA.dbo.PASO1 FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        LEFT JOIN BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO B ON A.Numero_Documento_Paciente=B.Numero_Documento_Paciente
                        WHERE (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('85018','85018.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86780','86592','86593','86318.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86703','86703.02','87389','86318.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('81007','81002','81000.02'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('80055.01'))AND Tipo_Diagnostico='D'))OR
                        ((FECHA_ATENCION>='2020-10-01')AND((CODIGO_ITEM IN ('Z3491','Z3591'))))OR
                        ((FECHA_ATENCION>='2021-01-07')AND((CODIGO_ITEM IN ('Z3492','Z3592'))))OR
                        ((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))OR
                        ((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))
                        GROUP BY A.NUMERO_DOCUMENTO_PACIENTE,B.PRIMER_ENTREGA_SUPLEMENTO,B.SEGUNDO_ENTREGA_SUPLEMENTO,B.TERCERA_ENTREGA_SUPLEMENTO";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='$anio$mes2'
                            AND Prov_Madre='$red'
                            ORDER BY Prov_Madre, Dist_Madre, Nombre_EESS
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='$anio$mes2'
                            ORDER BY Prov_Madre, Dist_Madre, Nombre_EESS
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='$anio$mes2'
                            AND Dist_Madre='$dist'
                            ORDER BY Prov_Madre, Dist_Madre, Nombre_EESS
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }

        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn3, $resultado4);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

    }
?>