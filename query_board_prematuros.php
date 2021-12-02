<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    

    global $conex;
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
                COUNT(CASE WHEN mide>='2021-06-01' AND mide<='2021-06-30' THEN Numcnv else null END) 'JUNIO_DEN',
                COUNT(CASE WHEN mide>='2021-07-01' AND mide<='2021-07-31' THEN Numcnv else null END) 'JULIO_DEN',
                COUNT(CASE WHEN mide>='2021-08-01' AND mide<='2021-08-31' THEN Numcnv else null END) 'AGOSTO_DEN',
                COUNT(CASE WHEN mide>='2021-09-01' AND mide<='2021-09-30' THEN Numcnv else null END) 'SETIEMBRE_DEN',
                COUNT(CASE WHEN mide>='2021-10-01' AND mide<='2021-10-31' THEN Numcnv else null END) 'OCTUBRE_DEN',
                COUNT(CASE WHEN mide>='2021-11-01' AND mide<='2021-11-30' THEN Numcnv else null END) 'NOVIEMBRE_DEN'
                INTO BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO
                FROM BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO A
                WHERE ((TIPO_SEGURO IN('1,','0,','1, 2, ','0, 1, '))OR (TIPO_SEGURO IS NULL))
                GROUP BY Provnacido,Distnacido";

    $resume3 = "SELECT Provnacido,Distnacido,
                COUNT(CASE WHEN mide>='2021-06-01' AND mide<='2021-06-30' THEN Numcnv else null END) 'JUNIO_NUM',
                COUNT(CASE WHEN mide>='2021-07-01' AND mide<='2021-07-31' THEN Numcnv else null END) 'JULIO_NUM',
                COUNT(CASE WHEN mide>='2021-08-01' AND mide<='2021-08-31' THEN Numcnv else null END) 'AGOSTO_NUM',
                COUNT(CASE WHEN mide>='2021-09-01' AND mide<='2021-09-30' THEN Numcnv else null END) 'SETIEMBRE_NUM',
                COUNT(CASE WHEN mide>='2021-10-01' AND mide<='2021-10-31' THEN Numcnv else null END) 'OCTUBRE_NUM',
                COUNT(CASE WHEN mide>='2021-11-01' AND mide<='2021-11-30' THEN Numcnv else null END) 'NOVIEMBRE_NUM'
                INTO BDHIS_MINSA.dbo.NUMERADOR_PREMATURO
                FROM BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO A
                WHERE ((TIPO_SEGURO IN('1,','0,','1, 2, ','0, 1, '))OR (TIPO_SEGURO IS NULL)) AND (SUPLEMENTADO IS NOT NULL)
                GROUP BY Provnacido,Distnacido";

    $resume4 = "SELECT A.Provnacido, A.Distnacido, JUNIO_NUM, JUNIO_DEN, JULIO_NUM, JULIO_DEN,
                AGOSTO_NUM, AGOSTO_DEN, SETIEMBRE_NUM, SETIEMBRE_DEN, OCTUBRE_NUM, OCTUBRE_DEN, NOVIEMBRE_NUM, NOVIEMBRE_DEN
                FROM BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO A
                LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR_PREMATURO B ON A.Distnacido=B.Distnacido
                ORDER BY A.Provnacido,A.Distnacido
                ";

    // POR DISTRITO
    $distrito = $_GET['dist'];
    echo $distrito;
    $resume5 = "SELECT A.Provnacido, A.Distnacido, JUNIO_NUM, JUNIO_DEN, JULIO_NUM, JULIO_DEN,
                AGOSTO_NUM, AGOSTO_DEN, SETIEMBRE_NUM, SETIEMBRE_DEN, OCTUBRE_NUM, OCTUBRE_DEN, NOVIEMBRE_NUM, NOVIEMBRE_DEN
                FROM BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO A
                LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR_PREMATURO B ON A.Distnacido=B.Distnacido
                WHERE A.Distnacido='OXAPAMPA'
                ORDER BY A.Provnacido,A.Distnacido
                DROP TABLE BD_PADRON_NOMINAL.dbo.RESUME_PASO_UNO_PREMATURO
                DROP TABLE BDHIS_MINSA.dbo.RESUME_PASO_DOS_PREMATURO
                DROP TABLE BDHIS_MINSA.dbo.RESUME_DENOMINADOR_PREMATURO
                DROP TABLE BDHIS_MINSA.dbo.NUMERADOR_PREMATURO";
    
    $consult_resume1 = sqlsrv_query($conn2, $resume);
    $consult_resume2 = sqlsrv_query($conn, $resume1);
    $consult_resume3 = sqlsrv_query($conn, $resume2);
    $consult_resume4 = sqlsrv_query($conn, $resume3);
    $consult_resume5 = sqlsrv_query($conn, $resume4);
    
    $consult_resume6 = sqlsrv_query($conn, $resume5);

    $num_red_pasco=0; $den_red_pasco=0;
    $num_red_oxa=0; $den_red_oxa=0;
    $num_red_dac=0; $den_red_dac=0;
    // while ($consulta = sqlsrv_fetch_array($consult_resume5)){
    //     if($consulta['Provnacido'] == 'PASCO'){
    //         $den_red_pasco = $den_red_pasco + $consulta['MIDENOMINADOR'];
    //         $num_red_pasco = $num_red_pasco + $consulta['MINUMERADOR'];
    //     }
    //     if($consulta['Provnacido'] == 'DANIEL ALCIDES CARRION'){
    //         $den_red_dac = $den_red_dac + $consulta['MIDENOMINADOR'];
    //         $num_red_dac = $num_red_dac + $consulta['MINUMERADOR'];
    //     }
    //     if($consulta['Provnacido'] == 'OXAPAMPA'){
    //         $den_red_oxa = $den_red_oxa + $consulta['MIDENOMINADOR'];
    //         $num_red_oxa = $num_red_oxa + $consulta['MINUMERADOR'];
    //     }
    // }
?>