<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');   
    require('abrir4.php'); 
 
    if(isset($_POST["exportarCSV"])) {
        ini_set("default_charset", "UTF-8");
        global $conex;
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes;
        }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $redt = 'PASCO';  }
        
        // -----  BD PADRON NOMINAL
    $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS_NACIMIENTO,NOMBRE_EESS, MENOR_VISITADO, MENOR_ENCONTRADO, TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                    'DOCUMENTO' = CASE 
                        WHEN pn.NUM_DNI IS NOT NULL
                        THEN pn.NUM_DNI
                        ELSE pn.NUM_CNV
                    END,
                    CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES
                    into BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred
                    FROM NOMINAL_PADRON_NOMINAL PN
                    WHERE YEAR(FECHA_NACIMIENTO_NINO)='2021' AND MONTH(FECHA_NACIMIENTO_NINO)='$mes' AND MES='2021$mes2';
                    with c as ( select DOCUMENTO,  ROW_NUMBER() over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                    from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred)
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
          where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,120,Fecha_Nacimiento_Paciente) and dateadd(dd,159,Fecha_Nacimiento_Paciente))
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
          where Anio='2021'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,300,Fecha_Nacimiento_Paciente) and dateadd(dd,3299,Fecha_Nacimiento_Paciente))
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
    $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST, MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
            ONCEAVO_CNTRL_MES FROM (
              SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                Max(CASE WHEN ((C3.NUMEROFILA='2') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                Max(CASE WHEN ((C4.NUMEROFILA='2') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                Max(CASE WHEN ((C5.NUMEROFILA='2') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                Max(CASE WHEN ((C6.NUMEROFILA='2') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                Max(CASE WHEN ((C7.NUMEROFILA='2') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                Max(CASE WHEN ((C8.NUMEROFILA='2') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                Max(CASE WHEN ((C9.NUMEROFILA='2') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                Max(CASE WHEN ((C10.NUMEROFILA='2') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'                        
              FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                LEFT JOIN  cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                LEFT JOIN CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente LEFT JOIN CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente LEFt JOIN CRED_MES4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                LEFT JOIN CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente LEFT JOIN cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                LEFT JOIN cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente LEFT JOIN cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                LEFT JOIN cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente LEFT JOIN CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                LEFT JOIN CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES) A
                WHERE NOMBRE_PROV='$red'
                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                ONCEAVO_CNTRL_MES                              
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
    $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST, MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
            ONCEAVO_CNTRL_MES FROM (
              SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                Max(CASE WHEN ((C3.NUMEROFILA='2') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                Max(CASE WHEN ((C4.NUMEROFILA='2') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                Max(CASE WHEN ((C5.NUMEROFILA='2') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                Max(CASE WHEN ((C6.NUMEROFILA='2') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                Max(CASE WHEN ((C7.NUMEROFILA='2') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                Max(CASE WHEN ((C8.NUMEROFILA='2') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                Max(CASE WHEN ((C9.NUMEROFILA='2') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                Max(CASE WHEN ((C10.NUMEROFILA='2') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'                        
              FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                LEFT JOIN  cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                LEFT JOIN CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente LEFT JOIN CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente LEFt JOIN CRED_MES4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                LEFT JOIN CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente LEFT JOIN cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                LEFT JOIN cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente LEFT JOIN cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                LEFT JOIN cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente LEFT JOIN CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                LEFT JOIN CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES) A
                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                ONCEAVO_CNTRL_MES                              
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
    $resultado15 = "SELECT NOMBRE_PROV,NOMBRE_DIST, MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
            ONCEAVO_CNTRL_MES FROM (
              SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A.Fecha_Atencion ELSE NULL END)'SEG_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='1') )THEN A1.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL',
                Max(CASE WHEN ((a.NUMEROFILA='2') )THEN A1.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL',
                Max(CASE WHEN ((C1.NUMEROFILA='1') )THEN C1.Fecha_Atencion ELSE NULL END)'PRIMER_CNTRL_MES',
                Max(CASE WHEN ((C2.NUMEROFILA='1') )THEN C2.Fecha_Atencion ELSE NULL END)'SEGUNDO_CNTRL_MES',
                Max(CASE WHEN ((C3.NUMEROFILA='2') )THEN C3.Fecha_Atencion ELSE NULL END)'TERCER_CNTRL_MES',
                Max(CASE WHEN ((C4.NUMEROFILA='2') )THEN C4.Fecha_Atencion ELSE NULL END)'CUARTO_CNTRL_MES',
                Max(CASE WHEN ((C5.NUMEROFILA='2') )THEN C5.Fecha_Atencion ELSE NULL END)'QUINTO_CNTRL_MES',
                Max(CASE WHEN ((C6.NUMEROFILA='2') )THEN C6.Fecha_Atencion ELSE NULL END)'SEXTO_CNTRL_MES',
                Max(CASE WHEN ((C7.NUMEROFILA='2') )THEN C7.Fecha_Atencion ELSE NULL END)'SEPTIMO_CNTRL_MES',
                Max(CASE WHEN ((C8.NUMEROFILA='2') )THEN C8.Fecha_Atencion ELSE NULL END)'OCTAVO_CNTRL_MES',
                Max(CASE WHEN ((C9.NUMEROFILA='2') )THEN C9.Fecha_Atencion ELSE NULL END)'NOVENO_CNTRL_MES',
                Max(CASE WHEN ((C10.NUMEROFILA='2') )THEN C10.Fecha_Atencion ELSE NULL END)'DECIMO_CNTRL_MES',
                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES'                        
              FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                LEFT JOIN  cred_rn1_2 A on P.DOCUMENTO=A.numero_documento_paciente left JOIN cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                LEFT JOIN CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente LEFT JOIN CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                LEFt JOIN CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente LEFt JOIN CRED_MES4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                LEFT JOIN CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente LEFT JOIN cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                LEFT JOIN cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente LEFT JOIN cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                LEFT JOIN cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente LEFT JOIN CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                LEFT JOIN CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES) A
                WHERE NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                ONCEAVO_CNTRL_MES                              
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

        if(!empty($consulta15)){
            $ficheroExcel="CRED ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;MENOR_ENCONTRADO;APELLIDOS_NOMBRES;DOCUMENTO;TIPO_SEGURO;FECHA_NACIMIENTO_NINO;1ER_CTRL;2DO_CTRL;CUMPLE;3ER_CTRL;4TO_CTRL;1ER_CRTL_MES;2DO_CRTL_MES;3ER_CTRL_MES;4TO_CRTL_MES;5TO_CRTL_MES;6TO_CRTL_MES;7MO_CTRL_MES;8VO_CTRL_MES;9NO_CTRL_MES;10MO_CTRL_MES;11VO_CTRL_MES\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta15)){
                echo $i++.";";
                if(is_null ($consulta['NOMBRE_PROV']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRE_PROV'].";"; }

                if(is_null ($consulta['NOMBRE_DIST']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRE_DIST'].";" ; }

                if(is_null ($consulta['MENOR_ENCONTRADO']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['MENOR_ENCONTRADO']).";"; }

                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ echo ' - '.";"; }
                else{ echo $consulta['APELLIDOS_NOMBRES'].";" ; }

                if(is_null ($consulta['DOCUMENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DOCUMENTO'].";" ; }

                if(is_null ($consulta['TIPO_SEGURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_SEGURO'].";" ; }

                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECHA_NACIMIENTO_NINO']-> format('d/m/y').";" ; }

                if(is_null ($consulta['PRIMER_CNTRL']) ){ echo ' - '.";"; }
                else{ echo $consulta['PRIMER_CNTRL']-> format('d/m/y').";" ; }

                if(is_null ($consulta['SEG_CNTRL']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEG_CNTRL']-> format('d/m/y').";" ; }

                if(is_null ($consulta['CUMPLE_1']) ){ echo ' - '.";"; }
                else{ echo $consulta['CUMPLE_1'].";" ; }

                if(is_null ($consulta['TERCER_CNTRL']) ){ echo ' - '.";"; }
                else{ echo $consulta['TERCER_CNTRL']-> format('d/m/y').";" ; }

                if(is_null ($consulta['CUARTO_CNTRL']) ){ echo ' - '.";"; }
                else{ echo $consulta['CUARTO_CNTRL']-> format('d/m/y').";" ; }

                if(is_null ($consulta['PRIMER_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['PRIMER_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEGUNDO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['TERCER_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['TERCER_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['CUARTO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['CUARTO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['QUINTO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['QUINTO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['SEXTO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEXTO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEPTIMO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['OCTAVO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['NOVENO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOVENO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['DECIMO_CNTRL_MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['DECIMO_CNTRL_MES']-> format('d/m/y').";" ; }

                if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){ echo ' - '."\n"; }
                else{ echo $consulta['ONCEAVO_CNTRL_MES']-> format('d/m/y')."\n" ; }
            }   
        }
    }
?>