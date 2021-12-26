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
        
        $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS_NACIMIENTO,NOMBRE_EESS, MENOR_VISITADO, MENOR_ENCONTRADO, TIPO_SEGURO, FECHA_NACIMIENTO_NINO,
                        'DOCUMENTO' = CASE 
                                            WHEN pn.NUM_DNI IS NOT NULL
                                            THEN pn.NUM_DNI
                                            ELSE pn.NUM_CNV
                                    END,
                                    CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES
                                    into BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred
                        FROM NOMINAL_PADRON_NOMINAL PN
                        WHERE YEAR(FECHA_NACIMIENTO_NINO)='$anio' AND MONTH(FECHA_NACIMIENTO_NINO)='$mes'  AND MES='$anio$mes2';
                        with c as ( select DOCUMENTO,  ROW_NUMBER() over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred )
                        delete  from c
                        where duplicado >1";

        // ------------  CRED RN  1er y 2do control
        $resultado2 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA 
                        into BDHIS_MINSA_EXTERNO.dbo.cred_rn1_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and Fecha_Atencion<= DATEADD(DD,14,Fecha_Nacimiento_Paciente)
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // --------------- CRED  3ER Y 4TO CONTROL RN
        $resultado3 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                            Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                            OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                            into BDHIS_MINSA_EXTERNO.dbo.cred_Rn3_4
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,15,Fecha_Nacimiento_Paciente) and dateadd(dd,28,Fecha_Nacimiento_Paciente))
                            and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                            order by Numero_Documento_Paciente, Fecha_Atencion";

        // ------  CRED MENSULIZADO POR PERIOROD SEGUN FICHA  CRED1 
        $resultado4 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,29,Fecha_Nacimiento_Paciente) and dateadd(dd,59,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 2
        $resultado5 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                            Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                            OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                            into BDHIS_MINSA_EXTERNO.dbo.cred_mes2
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,60,Fecha_Nacimiento_Paciente) and dateadd(dd,89,Fecha_Nacimiento_Paciente))
                            and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                            order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 3
        $resultado6 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes3
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,90,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";
        
        // ----------  CRED 4
        $resultado7 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes4
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,120,Fecha_Nacimiento_Paciente) and dateadd(dd,159,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 5
        $resultado8 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes5
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,150,Fecha_Nacimiento_Paciente) and dateadd(dd,179,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 6
        $resultado9 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes6
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,180,Fecha_Nacimiento_Paciente) and dateadd(dd,209,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 7
        $resultado10 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                            Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                            OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                            into BDHIS_MINSA_EXTERNO.dbo.cred_mes7
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,210,Fecha_Nacimiento_Paciente) and dateadd(dd,239,Fecha_Nacimiento_Paciente))
                            and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                            order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 8
        $resultado11 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                            Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                            OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                            into BDHIS_MINSA_EXTERNO.dbo.cred_mes8
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,240,Fecha_Nacimiento_Paciente) and dateadd(dd,269,Fecha_Nacimiento_Paciente))
                            and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                            order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 9
        $resultado12 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                            Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                            OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                            into BDHIS_MINSA_EXTERNO.dbo.cred_mes9
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,270,Fecha_Nacimiento_Paciente) and dateadd(dd,299,Fecha_Nacimiento_Paciente))
                            and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                            order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 10
        $resultado13 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes10
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,300,Fecha_Nacimiento_Paciente) and dateadd(dd,329,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------  CRED 11
        $resultado14 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.cred_mes11
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='Z001' and (Fecha_Atencion between dateadd(dd,330,Fecha_Nacimiento_Paciente) and dateadd(dd,364,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-$mes2-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------  ANTINEUMOCOCICA  90670.....--1
        $resultado15 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90670_1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90670' 
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------  ANTINEUMOCOCICA  90670.....--2
        $resultado16 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90670_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90670' 
                        and (Fecha_Atencion between dateadd(dd,119,Fecha_Nacimiento_Paciente) and dateadd(dd,159,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90681.....--1
        $resultado17 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90681_1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90681' 
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90681.....--2
        $resultado18 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90681_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90681' 
                        and (Fecha_Atencion between dateadd(dd,119,Fecha_Nacimiento_Paciente) and dateadd(dd,159,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90712  -  90713.....--1
        $resultado19 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90712_13_1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item in('90712','90713')
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90712  -  90713.....--2
        $resultado20 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90712_13_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item in('90712','90713')
                        and (Fecha_Atencion between dateadd(dd,119,Fecha_Nacimiento_Paciente) and dateadd(dd,169,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90712  -  90713.....--3
        $resultado21 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90712_13_3
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item in('90712','90713')
                        and (Fecha_Atencion between dateadd(dd,170,Fecha_Nacimiento_Paciente) and dateadd(dd,209,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------   90723.....--1
        $resultado22 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90723_1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90723' 
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ---------------------  90723  2    77777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777
        $resultado23 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90723_2
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90723' 
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        //  ---------------------  90723  3    77777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777777
        $resultado24 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS
                        into BDHIS_MINSA_EXTERNO.dbo.v90723_3
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and Tipo_Diagnostico='D' and Codigo_Item='90723' 
                        and (Fecha_Atencion between dateadd(dd,55,Fecha_Nacimiento_Paciente) and dateadd(dd,119,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ----------------------- suplementcion SUPLE 4 ---------------------------------------------------------------------------------------------------------------------------------
        $resultado25 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.suple4
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and (Tipo_Diagnostico='D' and Codigo_Item in ('Z298','99199.17') and Valor_Lab in ('SF1','SF2','SF3','SF4','SF5','SF6','SF7','SF8','SF9','S10','S11','S12',
                        'P01','P02','P03','P04','P05','P06','P07','P08','P09','P10','P11','P12','PO1','PO2','PO3','PO4','PO5','PO6','PO7','PO8','PO9'))
                        and (Fecha_Atencion between dateadd(dd,110,Fecha_Nacimiento_Paciente) and dateadd(dd,130,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        // ------    5 meses
        $resultado26 = "SELECT Nombre_Establecimiento, Fecha_Nacimiento_Paciente,Tipo_Doc_Paciente,Numero_Documento_Paciente, Valor_Lab,
                        Fecha_Atencion, Codigo_Item, DATEDIFF(DAY,Fecha_Nacimiento_Paciente,Fecha_Atencion) DIAS, ROW_NUMBER()
                        OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION) AS NUMEROFILA
                        into BDHIS_MINSA_EXTERNO.dbo.suple5
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where Anio='$anio'  and (Tipo_Diagnostico='D' and Codigo_Item in ('Z298','99199.17') and Valor_Lab in ('SF1','SF2','SF3','SF4','SF5','SF6','SF7','SF8','SF9','S10','S11','S12',
                        'P01','P02','P03','P04','P05','P06','P07','P08','P09','P10','P11','P12','PO1','PO2','PO3','PO4','PO5','PO6','PO7','PO8','PO9'))
                        and (Fecha_Atencion between dateadd(dd,150,Fecha_Nacimiento_Paciente) and dateadd(dd,170,Fecha_Nacimiento_Paciente))
                        and Fecha_Nacimiento_Paciente>='$anio-01-01'
                        order by Numero_Documento_Paciente, Fecha_Atencion";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado27 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
                            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                            ONCEAVO_CNTRL_MES,
                            VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                            VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5	FROM
                            (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
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
                                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES',
                                v1.Fecha_Atencion VAntineumo1,	v2.Fecha_Atencion VAntineumo2,
                                v3.Fecha_Atencion Vrotavirus1,	v4.Fecha_Atencion Vrotavirus2,
                                v5.Fecha_Atencion VAntipolio1,	v6.Fecha_Atencion VAntipolio2,
                                v7.Fecha_Atencion VAntipolio3,	v8.Fecha_Atencion Vpenta1,
                                v9.Fecha_Atencion Vpenta2,v10.Fecha_Atencion Vpenta3,		
                                Max(CASE WHEN ((s4.NUMEROFILA='2') )THEN s4.Fecha_Atencion ELSE NULL END)'Suple4',
                                Max(CASE WHEN ((s5.NUMEROFILA='2') )THEN s5.Fecha_Atencion ELSE NULL END)'Suple5'
                                FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                                LEFT JOIN  BDHIS_MINSA_EXTERNO.dbo.cred_rn1_2 A	on P.DOCUMENTO=A.numero_documento_paciente
                                left JOIN BDHIS_MINSA_EXTERNO.dbo.cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v1 on p.DOCUMENTO=v1.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v2 on p.DOCUMENTO=v2.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_1 v3 on p.DOCUMENTO=v3.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_2 v4 on p.DOCUMENTO=v4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 v5 on p.DOCUMENTO=v5.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 v6 on p.DOCUMENTO=v6.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 v7 on p.DOCUMENTO=v7.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_1 v8 on p.DOCUMENTO=v8.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_2 v9 on p.DOCUMENTO=v9.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_3 v10 on p.DOCUMENTO=v10.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple4 s4 on p.DOCUMENTO=s4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple5 s5 on p.DOCUMENTO=s5.Numero_Documento_Paciente
                                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,
                                    v1.Fecha_Atencion,	v2.Fecha_Atencion,	v3.Fecha_Atencion,		v4.Fecha_Atencion,	v5.Fecha_Atencion,
                                v6.Fecha_Atencion,	v7.Fecha_Atencion,	v8.Fecha_Atencion,	v9.Fecha_Atencion,v10.Fecha_Atencion  	)A WHERE NOMBRE_PROV = '$red'
                                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL
                                ,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                                ONCEAVO_CNTRL_MES, 	
                                VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                                VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5
                                
                                ----------------ELIMINANDO TABLAS
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
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11
                                drop table 	BDHIS_MINSA_EXTERNO.dbo.v90670_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90670_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_1
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_3
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple4
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple5";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          // -----------CRUZANDO INDICADOR
            $resultado27 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
                            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                            ONCEAVO_CNTRL_MES,
                            VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                            VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5	FROM
                            (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
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
                                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES',
                                v1.Fecha_Atencion VAntineumo1,	v2.Fecha_Atencion VAntineumo2,
                                v3.Fecha_Atencion Vrotavirus1,	v4.Fecha_Atencion Vrotavirus2,
                                v5.Fecha_Atencion VAntipolio1,	v6.Fecha_Atencion VAntipolio2,
                                v7.Fecha_Atencion VAntipolio3,	v8.Fecha_Atencion Vpenta1,
                                v9.Fecha_Atencion Vpenta2,v10.Fecha_Atencion Vpenta3,		
                                Max(CASE WHEN ((s4.NUMEROFILA='2') )THEN s4.Fecha_Atencion ELSE NULL END)'Suple4',
                                Max(CASE WHEN ((s5.NUMEROFILA='2') )THEN s5.Fecha_Atencion ELSE NULL END)'Suple5'
                                FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                                LEFT JOIN  BDHIS_MINSA_EXTERNO.dbo.cred_rn1_2 A	on P.DOCUMENTO=A.numero_documento_paciente
                                left JOIN BDHIS_MINSA_EXTERNO.dbo.cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v1 on p.DOCUMENTO=v1.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v2 on p.DOCUMENTO=v2.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_1 v3 on p.DOCUMENTO=v3.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_2 v4 on p.DOCUMENTO=v4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 v5 on p.DOCUMENTO=v5.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 v6 on p.DOCUMENTO=v6.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 v7 on p.DOCUMENTO=v7.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_1 v8 on p.DOCUMENTO=v8.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_2 v9 on p.DOCUMENTO=v9.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_3 v10 on p.DOCUMENTO=v10.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple4 s4 on p.DOCUMENTO=s4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple5 s5 on p.DOCUMENTO=s5.Numero_Documento_Paciente
                                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,
                                    v1.Fecha_Atencion,	v2.Fecha_Atencion,	v3.Fecha_Atencion,		v4.Fecha_Atencion,	v5.Fecha_Atencion,
                                v6.Fecha_Atencion,	v7.Fecha_Atencion,	v8.Fecha_Atencion,	v9.Fecha_Atencion,v10.Fecha_Atencion  	)A
                                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL
                                ,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                                ONCEAVO_CNTRL_MES, 	
                                VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                                VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5
                                
                                ----------------ELIMINANDO TABLAS
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
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11
                                drop table 	BDHIS_MINSA_EXTERNO.dbo.v90670_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90670_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_1
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_3
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple4
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple5";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado27 = "SELECT NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL,
                            CASE WHEN DATEDIFF(dd,primer_cntrl,SEG_CNTRL) BETWEEN 3 AND 7 THEN 'CUMPLE' END CUMPLE_1,
                            TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                            QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                            ONCEAVO_CNTRL_MES,
                            VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                            VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5	FROM
                            (SELECT P.NOMBRE_PROV,P.NOMBRE_DIST,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,P.DOCUMENTO,P.TIPO_SEGURO, P.FECHA_NACIMIENTO_NINO,
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
                                Max(CASE WHEN ((C11.NUMEROFILA='2') )THEN C11.Fecha_Atencion ELSE NULL END)'ONCEAVO_CNTRL_MES',
                                v1.Fecha_Atencion VAntineumo1,	v2.Fecha_Atencion VAntineumo2,
                                v3.Fecha_Atencion Vrotavirus1,	v4.Fecha_Atencion Vrotavirus2,
                                v5.Fecha_Atencion VAntipolio1,	v6.Fecha_Atencion VAntipolio2,
                                v7.Fecha_Atencion VAntipolio3,	v8.Fecha_Atencion Vpenta1,
                                v9.Fecha_Atencion Vpenta2,v10.Fecha_Atencion Vpenta3,		
                                Max(CASE WHEN ((s4.NUMEROFILA='2') )THEN s4.Fecha_Atencion ELSE NULL END)'Suple4',
                                Max(CASE WHEN ((s5.NUMEROFILA='2') )THEN s5.Fecha_Atencion ELSE NULL END)'Suple5'
                                FROM BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR_cred P  
                                LEFT JOIN  BDHIS_MINSA_EXTERNO.dbo.cred_rn1_2 A	on P.DOCUMENTO=A.numero_documento_paciente
                                left JOIN BDHIS_MINSA_EXTERNO.dbo.cred_rn3_4 a1 ON P.DOCUMENTO=A1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES1 C1 ON  P.DOCUMENTO=C1.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES2 C2 ON  P.DOCUMENTO=C2.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES3 C3 ON P.DOCUMENTO=C3.numero_documento_paciente
                                LEFt JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes4 C4 ON  P.DOCUMENTO=C4.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES5 C5 ON  P.DOCUMENTO=C5.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes6 C6 ON  P.DOCUMENTO=C6.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes7 C7 ON  P.DOCUMENTO=C7.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes8 C8 ON  P.DOCUMENTO=C8.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.cred_mes9 C9 ON  P.DOCUMENTO=C9.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES10 C10 ON  P.DOCUMENTO=C10.numero_documento_paciente
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.CRED_MES11 C11 ON  P.DOCUMENTO=C11.numero_documento_paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v1 on p.DOCUMENTO=v1.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90670_1 v2 on p.DOCUMENTO=v2.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_1 v3 on p.DOCUMENTO=v3.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90681_2 v4 on p.DOCUMENTO=v4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 v5 on p.DOCUMENTO=v5.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 v6 on p.DOCUMENTO=v6.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 v7 on p.DOCUMENTO=v7.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_1 v8 on p.DOCUMENTO=v8.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_2 v9 on p.DOCUMENTO=v9.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.v90723_3 v10 on p.DOCUMENTO=v10.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple4 s4 on p.DOCUMENTO=s4.Numero_Documento_Paciente
                                left join BDHIS_MINSA_EXTERNO.dbo.suple5 s5 on p.DOCUMENTO=s5.Numero_Documento_Paciente
                                GROUP BY P.NOMBRE_PROV,P.NOMBRE_DIST,P.DOCUMENTO, P.TIPO_SEGURO,P.FECHA_NACIMIENTO_NINO,P.MENOR_ENCONTRADO,P.APELLIDOS_NOMBRES,
                                    v1.Fecha_Atencion,	v2.Fecha_Atencion,	v3.Fecha_Atencion,		v4.Fecha_Atencion,	v5.Fecha_Atencion,
                                v6.Fecha_Atencion,	v7.Fecha_Atencion,	v8.Fecha_Atencion,	v9.Fecha_Atencion,v10.Fecha_Atencion  	)A WHERE NOMBRE_PROV = '$red' AND NOMBRE_DIST = '$dist'
                                group by NOMBRE_PROV,NOMBRE_DIST,MENOR_ENCONTRADO,APELLIDOS_NOMBRES,DOCUMENTO,TIPO_SEGURO, FECHA_NACIMIENTO_NINO,	PRIMER_CNTRL,SEG_CNTRL
                                ,		TERCER_CNTRL,CUARTO_CNTRL,PRIMER_CNTRL_MES,SEGUNDO_CNTRL_MES,TERCER_CNTRL_MES,CUARTO_CNTRL_MES,
                                QUINTO_CNTRL_MES, SEXTO_CNTRL_MES,SEPTIMO_CNTRL_MES, OCTAVO_CNTRL_MES, NOVENO_CNTRL_MES, DECIMO_CNTRL_MES,
                                ONCEAVO_CNTRL_MES, 	
                                VAntineumo1,VAntineumo2,Vrotavirus1, Vrotavirus2, VAntipolio1, VAntipolio2,
                                VAntipolio3,	vpenta1, Vpenta2, Vpenta3,suple4,suple5
                                
                                ----------------ELIMINANDO TABLAS
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
                                drop table BDHIS_MINSA_EXTERNO.dbo.cred_mes11
                                drop table 	BDHIS_MINSA_EXTERNO.dbo.v90670_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90670_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_1
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90681_2
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90712_13_3 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_1 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_2 
                                drop table BDHIS_MINSA_EXTERNO.dbo.v90723_3
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple4
                                drop table BDHIS_MINSA_EXTERNO.dbo.suple5";
        }        


        $consulta1 = sqlsrv_query($conn2, $resultado);
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
        $consulta15 = sqlsrv_query($conn, $resultado15);
        $consulta16 = sqlsrv_query($conn, $resultado16);
        $consulta17 = sqlsrv_query($conn, $resultado17);
        $consulta18 = sqlsrv_query($conn, $resultado18);
        $consulta19 = sqlsrv_query($conn, $resultado19);
        $consulta20 = sqlsrv_query($conn, $resultado20);
        $consulta21 = sqlsrv_query($conn, $resultado21);
        $consulta22 = sqlsrv_query($conn, $resultado22);
        $consulta23 = sqlsrv_query($conn, $resultado23);
        $consulta24 = sqlsrv_query($conn, $resultado24);
        $consulta25 = sqlsrv_query($conn, $resultado25);
        $consulta26 = sqlsrv_query($conn, $resultado26);
        $consulta27 = sqlsrv_query($conn4, $resultado27);

    }
?>