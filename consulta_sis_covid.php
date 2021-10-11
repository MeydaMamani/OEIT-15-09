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
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado = "SELECT *, ROW_NUMBER() over (PARTITION by NUMERO_DOCUMENTO ORDER BY FECHA_REGISTRO  ASC) AS RN 
                            INTO SINF0 FROM F0 WHERE MES='2021/10'
                            DELETE SINF0 WHERE RN>1
                            SELECT SO.RESIDENCIA_PROVINCIA,SO.RESIDENCIA_DISTRITO,SO.TIPO_DOCUMENTO,SO.NUMERO_DOCUMENTO,
                            SO.NOMBRES,SO.APELLIDO_PATERNO,SO.APELLIDO_MATERNO,SO.DIRECCION,SO.USUARIO_DNI, 
                            SO.USUARIO_NOMBRE,SO.USUARIO_PROCEDENCIA,SO.FECHA_REGISTRO,
                            SE.FICHA_300_FECHA_DEL_SEGUIMIENTO,
                            ME.FECHA_ENTREGA,
                            DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) AS DIAS_SEGUIMIENTO,
                            DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) AS DIAS_MED,
                            CASE WHEN (DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1'))THEN 1 ELSE NULL END AS CF300,
                            CASE WHEN (DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS CMED,
                            CASE WHEN (DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1') 
                            AND DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS C_AMBOS
                            INTO SOSPECHOSO FROM SINF0 SO 
                            LEFT JOIN (SELECT SE.*, ROW_NUMBER() over (PARTITION by SE.NUMERO_DOCUMENTO ORDER BY SE.FICHA_300_FECHA_DEL_SEGUIMIENTO ASC) AS RN 
                            FROM F300 SE WHERE SE.MES='2021/10') SE ON SE.NUMERO_DOCUMENTO = SO.NUMERO_DOCUMENTO AND SE.RN = 1 
                            LEFT JOIN (SELECT ME.*, ROW_NUMBER() over (PARTITION by ME.NUMERO_DOCUMENTO ORDER BY ME.FECHA_ENTREGA ASC) AS RN 
                            FROM MED ME WHERE ME.MES='2021/10') ME ON ME.NUMERO_DOCUMENTO = SO.NUMERO_DOCUMENTO AND ME.RN = 1 
                            WHERE SO.MES='2021/10' 
                            GROUP BY SO.RESIDENCIA_PROVINCIA,SO.RESIDENCIA_DISTRITO,SO.TIPO_DOCUMENTO,SO.NUMERO_DOCUMENTO,
                            SO.NOMBRES,SO.APELLIDO_PATERNO,SO.APELLIDO_MATERNO,SO.DIRECCION,SO.USUARIO_DNI, 
                            SO.USUARIO_NOMBRE,SO.USUARIO_PROCEDENCIA,SO.FECHA_REGISTRO, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA,ME.FECHA_RECETA";

            $resultado2 = "SELECT F.*, ROW_NUMBER() over (PARTITION by NUMERO_DOCUMENTO ORDER BY FECHA_EJECUCION_PRUEBA ASC) AS RN, ES.DEPARTAMENTO AS DEPAR_EESS, ES.DESCRIPCION_SECTOR
                            INTO SINF100 FROM F100 F LEFT JOIN MAESTRO_HIS_ESTABLECIMIENTO ES ON F.COD_ESTABLECIMIENTO_REGISTRA =ES.Id_Establecimiento  
                            WHERE MES='2021/10' AND CLASIFICACION_CLINICA_SEVERIDAD IN ('Leve o Asintomßtica',
                            'LEVE O ASINTOM-TICO (Tratamiento domiciliario. Tos, malestar general, dolor de garganta, fiebre, congesti¾n nasal))','Leve',
                            'LEVE  (Tratamiento domiciliario. Tos, malestar general, dolor de garganta, fiebre, congesti¾n nasal))') AND RESULTADO_2 IN ('IgG POSITIVO','IgM Reactivo',
                            'IgM e IgG Reactivo','IgM e IgG POSITIVO','IgG Reactivo','IgM POSITIVO','Reactivo','Anticuerpos totales reactivo')
                            AND ES.DEPARTAMENTO = 'PASCO' AND ES.DESCRIPCION_SECTOR='GOBIERNO REGIONAL'
                            DELETE SINF100 WHERE RN>1
                            SELECT PR.PROVINCIA, PR.DISTRITO, PR.TIPO_DOCUMENTO, PR.NUMERO_DOCUMENTO, CONCAT(PR.APELLIDO_PATERNO, ' ', PR.APELLIDO_MATERNO, ' ', PR.NOMBRES) full_name,
                            PR.RESULTADO_1, PR.CLASIFICACION_CLINICA_SEVERIDAD, PR.REGISTRADOR, PR.DOC_REGISTRADOR, PR.RESULTADO_2, PR.COD_ESTABLECIMIENTO_EJECUTA,
                            PR.ESTABLECIMIENTO_EJECUTA, PR.FECHA_EJECUCION_PRUEBA, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA,
                            DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) AS DIAS_SEGUIMIENTO,
                            DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) AS DIAS_MED,
                            CASE WHEN (DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1'))THEN 1 ELSE NULL END AS CF300,
                            CASE WHEN (DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS CMED,
                            CASE WHEN (DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1') 
                            AND DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS C_AMBOS
                            INTO PRUEBA FROM SINF100 PR
                            LEFT JOIN (SELECT SE.*, ROW_NUMBER() over (PARTITION by SE.NUMERO_DOCUMENTO ORDER BY SE.FICHA_300_FECHA_DEL_SEGUIMIENTO ASC) AS RN 
                            FROM F300 SE WHERE SE.MES='2021/10') SE ON SE.NUMERO_DOCUMENTO = PR.NUMERO_DOCUMENTO AND SE.RN = 1 
                            LEFT JOIN (SELECT ME.*, ROW_NUMBER() over (PARTITION by ME.NUMERO_DOCUMENTO ORDER BY ME.FECHA_ENTREGA ASC) AS RN 
                            FROM MED ME WHERE ME.MES='2021/10') ME ON ME.NUMERO_DOCUMENTO = PR.NUMERO_DOCUMENTO AND ME.RN = 1 
                            WHERE PR.MES='2021/10' 
                            GROUP BY PR.PROVINCIA, PR.DISTRITO, PR.TIPO_DOCUMENTO, PR.NUMERO_DOCUMENTO, PR.NOMBRES, PR.APELLIDO_PATERNO, PR.APELLIDO_MATERNO,
                            PR.RESULTADO_1, PR.CLASIFICACION_CLINICA_SEVERIDAD, PR.REGISTRADOR, PR.DOC_REGISTRADOR, PR.RESULTADO_2, PR.COD_ESTABLECIMIENTO_EJECUTA,
                            PR.ESTABLECIMIENTO_EJECUTA, PR.FECHA_EJECUCION_PRUEBA, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA, ME.FECHA_RECETA";

            $resultado3 = "SELECT * FROM PRUEBA";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red' and Distnacido = '$dist'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }

        $consulta1 = sqlsrv_query($conn5, $resultado);
        $consulta2 = sqlsrv_query($conn5, $resultado2);
        $consulta3 = sqlsrv_query($conn5, $resultado3);

    }
?>