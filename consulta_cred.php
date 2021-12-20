<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
        
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
    
        // -----  BD PADRON NOMINAL
        $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS_NACIMIENTO,NOMBRE_EESS, MENOR_VISITADO, MENOR_ENCONTRADO, TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                        'DOCUMENTO' = CASE 
                                    WHEN pn.NUM_DNI IS NOT NULL
                                    THEN pn.NUM_DNI
                                    ELSE pn.NUM_CNV
                            END,
                            CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES
                        INTO BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred
                        FROM NOMINAL_PADRON_NOMINAL PN
                        WHERE YEAR(FECHA_NACIMIENTO_NINO)='2021' AND MONTH(FECHA_NACIMIENTO_NINO)='$mes2' AND MES='2021$mes2'
                        ;
                        with c as
                        (
                        select DOCUMENTO,  ROW_NUMBER() 
                                over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred
                        )
                        delete  from c
                        where duplicado >1";

        // ------------  CRED RN  1er y 2do control
        $resultado2 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA 
                        into BDHIS_MINSA_EXTERNO.dbo.cred_rn1_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and Fecha_Atencion<= DATEADD(DD,14,Fecha_Nacimiento_Paciente)
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // --------------- CRED  3ER Y 4TO CONTROL RN
        $resultado3 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_Rn3_4
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,15,Fecha_Nacimiento_Paciente) and dateadd(dd,28,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ------  CRED MENSULIZADO POR PERIOROD SEGUN FICHA  CRED1
        $resultado4 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,29,Fecha_Nacimiento_Paciente) and dateadd(dd,59,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ----------------------------CRED 2
        $resultado5 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,60,Fecha_Nacimiento_Paciente) and dateadd(dd,89,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ----------------------------CRED 3
        $resultado6 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes3
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,90,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        // --------------------------CRED 4
        $resultado7 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes4
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,120,Fecha_Nacimiento_Paciente) and dateadd(dd,149,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ----------  CRED 5
        $resultado8 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes5
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,150,Fecha_Nacimiento_Paciente) and dateadd(dd,179,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 6
        $resultado9 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes6
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,180,Fecha_Nacimiento_Paciente) and dateadd(dd,209,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 7
        $resultado10 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes7
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,210,Fecha_Nacimiento_Paciente) and dateadd(dd,239,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 8
        $resultado11 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes8
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,240,Fecha_Nacimiento_Paciente) and dateadd(dd,269,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ----------  CRED 9
        $resultado12 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes9
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,270,Fecha_Nacimiento_Paciente) and dateadd(dd,299,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 10
        $resultado13 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes10
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,300,Fecha_Nacimiento_Paciente) and dateadd(dd,329,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 11
        $resultado14 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes11
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,330,Fecha_Nacimiento_Paciente) and dateadd(dd,364,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='2021-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // -----------CRUZANDO INDICADOR
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS') {
            $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                            TERCER_CNTRL,CUARTO_CNTRL,
                            CASE 
                            WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_CTRLMES,
                            PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                            ONCEAVO_CNTRL_MES
                            FROM
                                (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                                Max(CASE WHEN ((a1.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                                Max(CASE WHEN ((a1.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                                Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                                Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                                Max(CASE WHEN ((C3.NUMEROFILA='1') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                                Max(CASE WHEN ((C4.NUMEROFILA='1') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                                Max(CASE WHEN ((C5.NUMEROFILA='1') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                                Max(CASE WHEN ((C6.NUMEROFILA='1') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                                Max(CASE WHEN ((C7.NUMEROFILA='1') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                                Max(CASE WHEN ((C8.NUMEROFILA='1') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                                Max(CASE WHEN ((C9.NUMEROFILA='1') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                                Max(CASE WHEN ((C10.NUMEROFILA='1') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                                Max(CASE WHEN ((C11.NUMEROFILA='1') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'
                                FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                                LEFT JOIN cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente
                                left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                                LEFT JOIN CRED_MES1 C1 ON P.DOCUMENTO=C1.numero_documento_paciente
                                LEFT JOIN CRED_MES2 C2 ON P.DOCUMENTO=C2.numero_documento_paciente
                                LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                                LEFt JOIN CRED_MES4 C4 ON P.DOCUMENTO=C4.numero_documento_paciente
                                LEFT JOIN CRED_MES5 C5 ON P.DOCUMENTO=C5.numero_documento_paciente
                                LEFT JOIN cred_mes6 C6 ON P.DOCUMENTO=C6.numero_documento_paciente
                                LEFT JOIN cred_mes7 C7 ON P.DOCUMENTO=C7.numero_documento_paciente
                                LEFT JOIN cred_mes8 C8 ON P.DOCUMENTO=C8.numero_documento_paciente
                                LEFT JOIN cred_mes9 C9 ON P.DOCUMENTO=C9.numero_documento_paciente
                                LEFT JOIN CRED_MES10 C10 ON P.DOCUMENTO=C10.numero_documento_paciente
                                LEFT JOIN CRED_MES11 C11 ON P.DOCUMENTO=C11.numero_documento_paciente
                                WHERE NOMBRE_PROV='$red'
                                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES   )A
                                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                                    PRIMER_CNTRL,SEG_CNTRL,	TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,
                                    CUARTO_CNTRL_MES,QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES,
                                    NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,	ONCEAVO_CNTRL_MES
                                ORDER BY NOMBRE_PROV,NOMBRE_DIST
                                drop table BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred 
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn1_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn3_4
                                drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES1
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes2
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes3
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes4
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes5
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes6
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes7
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes8
                                drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES9
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes10
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                        TERCER_CNTRL,CUARTO_CNTRL,
                        CASE 
                        WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_CTRLMES,
                        PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                        QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                        ONCEAVO_CNTRL_MES
                        FROM
                            (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                            Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                            Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                            Max(CASE WHEN ((a1.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                            Max(CASE WHEN ((a1.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                            Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                            Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                            Max(CASE WHEN ((C3.NUMEROFILA='1') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                            Max(CASE WHEN ((C4.NUMEROFILA='1') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                            Max(CASE WHEN ((C5.NUMEROFILA='1') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                            Max(CASE WHEN ((C6.NUMEROFILA='1') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                            Max(CASE WHEN ((C7.NUMEROFILA='1') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                            Max(CASE WHEN ((C8.NUMEROFILA='1') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                            Max(CASE WHEN ((C9.NUMEROFILA='1') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                            Max(CASE WHEN ((C10.NUMEROFILA='1') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                            Max(CASE WHEN ((C11.NUMEROFILA='1') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'
                            FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                            LEFT JOIN cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente
                            left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                            LEFT JOIN CRED_MES1 C1 ON P.DOCUMENTO=C1.numero_documento_paciente
                            LEFT JOIN CRED_MES2 C2 ON P.DOCUMENTO=C2.numero_documento_paciente
                            LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                            LEFt JOIN CRED_MES4 C4 ON P.DOCUMENTO=C4.numero_documento_paciente
                            LEFT JOIN CRED_MES5 C5 ON P.DOCUMENTO=C5.numero_documento_paciente
                            LEFT JOIN cred_mes6 C6 ON P.DOCUMENTO=C6.numero_documento_paciente
                            LEFT JOIN cred_mes7 C7 ON P.DOCUMENTO=C7.numero_documento_paciente
                            LEFT JOIN cred_mes8 C8 ON P.DOCUMENTO=C8.numero_documento_paciente
                            LEFT JOIN cred_mes9 C9 ON P.DOCUMENTO=C9.numero_documento_paciente
                            LEFT JOIN CRED_MES10 C10 ON P.DOCUMENTO=C10.numero_documento_paciente
                            LEFT JOIN CRED_MES11 C11 ON P.DOCUMENTO=C11.numero_documento_paciente
                            GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES   )A
                            group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                                PRIMER_CNTRL,SEG_CNTRL,	TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,
                                CUARTO_CNTRL_MES,QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES,
                                NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,	ONCEAVO_CNTRL_MES
                            ORDER BY NOMBRE_PROV,NOMBRE_DIST
                            drop table BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred 
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn1_2 
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn3_4
                            drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES1
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes2
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes3
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes4
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes5
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes6
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes7
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes8
                            drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES9
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes10
                            drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11";

        }
        else if($dist_1 != 'TODOS') {
            $dist=$dist_1;
            $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                            TERCER_CNTRL,CUARTO_CNTRL,
                            CASE 
                            WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_CTRLMES,
                            PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                            ONCEAVO_CNTRL_MES
                            FROM
                                (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                                Max(CASE WHEN ((a1.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                                Max(CASE WHEN ((a1.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                                Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                                Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                                Max(CASE WHEN ((C3.NUMEROFILA='1') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                                Max(CASE WHEN ((C4.NUMEROFILA='1') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                                Max(CASE WHEN ((C5.NUMEROFILA='1') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                                Max(CASE WHEN ((C6.NUMEROFILA='1') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                                Max(CASE WHEN ((C7.NUMEROFILA='1') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                                Max(CASE WHEN ((C8.NUMEROFILA='1') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                                Max(CASE WHEN ((C9.NUMEROFILA='1') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                                Max(CASE WHEN ((C10.NUMEROFILA='1') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                                Max(CASE WHEN ((C11.NUMEROFILA='1') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'
                                FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                                LEFT JOIN cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente
                                left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                                LEFT JOIN CRED_MES1 C1 ON P.DOCUMENTO=C1.numero_documento_paciente
                                LEFT JOIN CRED_MES2 C2 ON P.DOCUMENTO=C2.numero_documento_paciente
                                LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                                LEFt JOIN CRED_MES4 C4 ON P.DOCUMENTO=C4.numero_documento_paciente
                                LEFT JOIN CRED_MES5 C5 ON P.DOCUMENTO=C5.numero_documento_paciente
                                LEFT JOIN cred_mes6 C6 ON P.DOCUMENTO=C6.numero_documento_paciente
                                LEFT JOIN cred_mes7 C7 ON P.DOCUMENTO=C7.numero_documento_paciente
                                LEFT JOIN cred_mes8 C8 ON P.DOCUMENTO=C8.numero_documento_paciente
                                LEFT JOIN cred_mes9 C9 ON P.DOCUMENTO=C9.numero_documento_paciente
                                LEFT JOIN CRED_MES10 C10 ON P.DOCUMENTO=C10.numero_documento_paciente
                                LEFT JOIN CRED_MES11 C11 ON P.DOCUMENTO=C11.numero_documento_paciente
                                WHERE NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES   )A
                                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                                    PRIMER_CNTRL,SEG_CNTRL,	TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,
                                    CUARTO_CNTRL_MES,QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES,
                                    NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,	ONCEAVO_CNTRL_MES
                                ORDER BY NOMBRE_PROV,NOMBRE_DIST    
                                drop table BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred 
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn1_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_Rn3_4
                                drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES1
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes2
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes3
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes4
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes5
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes6
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes7
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes8
                                drop table BDHIS_MINSA_EXTERNO.dbo.CRED_MES9
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes10
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11";
        }
    
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);
        $consulta7 = sqlsrv_query($conn, $resultado7);
        $consulta8 = sqlsrv_query($conn, $resultado8);
        $consulta9 = sqlsrv_query($conn, $resultado9);
        $consulta10 = sqlsrv_query($conn, $resultado10);
        $consulta11 = sqlsrv_query($conn, $resultado11);
        $consulta12 = sqlsrv_query($conn, $resultado12);
        $consulta13 = sqlsrv_query($conn, $resultado13);
        $consulta14 = sqlsrv_query($conn, $resultado14);
        $consulta15 = sqlsrv_query($conn4, $resultado15);
    }

    $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
    $consult = sqlsrv_query($conn2, $my_date_modify);
    while ($cons = sqlsrv_fetch_array($consult)){
        $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
    }
?>