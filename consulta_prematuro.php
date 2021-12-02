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

        $resultado = "SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                        apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                        into  padron_nino_cnv1
                        from nominal_padron_nominal
                        where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2';
                        with c as ( select num_cnv, nombre_dist, ROW_NUMBER() 
                                over(partition by num_cnv order by num_cnv) as duplicado
                        from dbo.padron_nino_cnv1)
                        delete  from c
                        where duplicado >1";
        // PARA RESUMEN
        $resume = "SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                    apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                    into BD_PADRON_NOMINAL.dbo.RESUME_PASO_UNO_PREMATURO
                    from nominal_padron_nominal
                    where year(fecha_nacimiento_nino)='2021';
                    with c as ( select num_cnv, nombre_dist, ROW_NUMBER() 
                            over(partition by num_cnv order by num_cnv) as duplicado
                    from RESUME_PASO_UNO_PREMATURO)
                    delete  from c
                    where duplicado >1";

        $resume1 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                    p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                    T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                    into BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO
                    from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.RESUME_PASO_UNO_PREMATURO p
                    ON  C.NUMCNV=p.num_cnv
                    AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                        AND Provnacido in ('PASCO', 'OXAPAMPA', 'DANIEL ALCIDES CARRION')
                    LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                    on c.Numcnv=t.Numero_Documento_Paciente
                    AND edad_reg='1' and t.Tipo_Edad ='M' and
                                Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                    ORDER BY Provnacido, Distnacido, Establecimiento";

        $resume2 = "SELECT Provnacido,Distnacido,
                    COUNT(CASE WHEN mide>='2021-$mes2-01' AND mide<=CONCAT('2021-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))) THEN Numcnv END) 'MIDENOMINADOR'
                    INTO BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO
                    FROM BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO A
                    WHERE ((TIPO_SEGURO IN('1,','0,','1, 2, ','0, 1, '))OR (TIPO_SEGURO IS NULL))
                    GROUP BY Provnacido,Distnacido";

        $resume3 = "SELECT Provnacido,Distnacido,
                    COUNT(CASE WHEN mide>='2021-$mes2-01' AND mide<=CONCAT('2021-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))) THEN Numcnv END) 'MINUMERADOR'
                    INTO BDHIS_MINSA.dbo.NUMERADOR_PREMATURO
                    FROM BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO A
                    WHERE ((TIPO_SEGURO IN('1,','0,','1, 2, ','0, 1, '))OR (TIPO_SEGURO IS NULL)) AND (SUPLEMENTADO IS NOT NULL)
                    GROUP BY Provnacido,Distnacido";

        $resume4 = "SELECT A.Provnacido, A.Distnacido, MIDENOMINADOR, MINUMERADOR
                    FROM BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO A
                    LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR_PREMATURO B ON A.Distnacido=B.Distnacido
                    ORDER BY A.Provnacido,A.Distnacido
                    DROP TABLE BD_PADRON_NOMINAL.dbo.RESUME_PASO_UNO_PREMATURO
                    DROP TABLE BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO
                    DROP TABLE BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO
                    DROP TABLE BDHIS_MINSA.dbo.NUMERADOR_PREMATURO";

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
                                ORDER BY Provnacido, Distnacido, Establecimiento
                                DROP TABLE BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' AND Provnacido in ('PASCO', 'OXAPAMPA', 'DANIEL ALCIDES CARRION')
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                ORDER BY Provnacido, Distnacido, Establecimiento
                                DROP TABLE BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1";
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
                                ORDER BY Provnacido, Distnacido, Establecimiento
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1";
        }

        $consulta1 = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);

        $consult_resume1 = sqlsrv_query($conn2, $resume);
        $consult_resume2 = sqlsrv_query($conn, $resume1);
        $consult_resume3 = sqlsrv_query($conn, $resume2);
        $consult_resume4 = sqlsrv_query($conn, $resume3);
        $consult_resume5 = sqlsrv_query($conn, $resume4);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

    }
?>