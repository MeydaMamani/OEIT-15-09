<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');  

        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        header('Content-Type: text/html; charset=UTF-8');
    
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

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION';  }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $red = 'TODOS'; }

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $dist=$dist_1;
            $mes_ant = $mes-1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.tmz
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";

            $resultado2 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.r456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado3 = "SELECT * FROM (
                            SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T 
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.tmz TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            where ANIO='2021' AND MES='$mes' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where vif is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.tmz
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.r456";

            // SEGUNDO TAB
            $resultado4 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";
            
            $resultado5 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado6 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente,Numero_Documento_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X85','X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * 
                                INTO BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                                FROM ( SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                                        T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                                        dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente)
                                        where ANIO='2021' AND MES in ('$mes_ant') AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                                        and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                                        where r456 is not null;
                                    with c as ( select ATENDIDOS,  ROW_NUMBER() 
                                            over(partition by ATENDIDOS order by iniciotto) as duplicado
                                            from BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO )
                                    delete  from c
                                    where duplicado >1";

            $resultado9 = "SELECT *, DATEDIFF (DAY, R456 , diagnostico) AS DIA1,  DATEDIFF (DAY, diagnostico , iniciotto) AS DIA2 FROM BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $mes_ant = $mes-1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.tmz
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";

            $resultado2 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.r456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado3 = "SELECT * FROM (
                            SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T 
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.tmz TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            where ANIO='2021' AND MES='$mes' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where vif is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.tmz
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.r456";

            // SEGUNDO TAB
            $resultado4 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";
            
            $resultado5 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado6 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente,Numero_Documento_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X85','X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * 
                                INTO BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                                FROM ( SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                                        T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                                        dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente)
                                        where ANIO='2021' AND MES in ('$mes_ant') AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                                        and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                                        where r456 is not null;
                                    with c as ( select ATENDIDOS,  ROW_NUMBER() 
                                            over(partition by ATENDIDOS order by iniciotto) as duplicado
                                            from BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO )
                                    delete  from c
                                    where duplicado >1";

            $resultado9 = "SELECT *, DATEDIFF (DAY, R456 , diagnostico) AS DIA1,  DATEDIFF (DAY, diagnostico , iniciotto) AS DIA2 FROM BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $mes_ant = $mes-1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.tmz
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";

            $resultado2 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.r456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado3 = "SELECT * FROM (
                            SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T 
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.tmz TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            where ANIO='2021' AND MES='$mes' AND T.Distrito_Establecimiento='$dist' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where vif is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.tmz
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.r456";

            // SEGUNDO TAB
            $resultado4 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                            and Tipo_Diagnostico='D'";
            
            $resultado5 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, Numero_Documento_Paciente,
                            Tipo_Doc_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item='R456'
                            and Tipo_Diagnostico='D'";

            $resultado6 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente,Numero_Documento_Paciente,Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X85','X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85',
                            'X86','X87','X88','X89','X90','91','X92','X93','X94','X95','X96','X97','X98','X99',
                            'Y00','Y01','Y02','Y03','Y04','Y05','Y06','Y07','Y08','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * 
                                INTO BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                                FROM ( SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                                        T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                                        dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente)
                                        LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente)
                                        where ANIO='2021' AND MES in ('$mes_ant') AND T.Distrito_Establecimiento='$dist' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                                        and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                                        where r456 is not null;
                                    with c as ( select ATENDIDOS,  ROW_NUMBER() 
                                            over(partition by ATENDIDOS order by iniciotto) as duplicado
                                            from BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO )
                                    delete  from c
                                    where duplicado >1";

            $resultado9 = "SELECT *, DATEDIFF (DAY, R456 , diagnostico) AS DIA1,  DATEDIFF (DAY, diagnostico , iniciotto) AS DIA2 FROM BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.CONSOLIDADO";
        }

    if(isset($_POST["exportarSospecha"])) {
        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO GESTANTES CON SOSPECHA DE VIOLENCIA "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <table>
        <thead>
            <tr></tr>
            <tr class="text-center">
                <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">Gestantes con Sospecha de Violencia - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="8" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </tfoot>
        </thead>
    </table>
    <table class="table table-hover">
        <thead>
            <tr class="text-light font-12 text-center" style="background: #44688c; color: white;">
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Tamizaje VIF</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Sospecha Violencia</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
            <?php  
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta3)){  
                    // CAMBIO AQUI
                    if(is_null ($consulta['Provincia_Establecimiento']) ){
                    $newdate1 = '  -'; }
                    else{
                    $newdate1 = $consulta['Provincia_Establecimiento'] ;}
    
                    if(is_null ($consulta['Distrito_Establecimiento']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['Distrito_Establecimiento'] ;}
        
                    if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['Tipo_Doc_Paciente'];}
    
                    if(is_null ($consulta['Numero_Documento_Paciente']) ){
                    $newdate4 = '  -'; }
                    else{
                    $newdate4 = $consulta['Numero_Documento_Paciente'];}
                    
                    if(is_null ($consulta['Fecha_Atencion']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['Fecha_Atencion']-> format('d/m/y');}
        
                    if(is_null ($consulta['VIF']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['VIF'] -> format('d/m/y');}
    
                    if(is_null ($consulta['R456']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['R456'] -> format('d/m/y');}
    
            ?>
            <tr>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate1); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php 
                    if($newdate3 == 1) { echo 'DNI'; }
                    else if($newdate3 == 2) { echo 'CE'; }
                    else if($newdate3 == 3) { echo 'PASS'; }
                    else if($newdate3 == 4) { echo 'DIE'; }
                    else if($newdate3 == 5) { echo 'SIN DOCUMENTO'; }
                    else if($newdate3 == 6) { echo 'CNV'; }
                ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>                            
            </tr>
            <?php
                ;}                    
                include("cerrar.php");
            ?>
        </tbody>
    </table>

<?php
        }
    }

    else if(isset($_POST["exportarTratamiento"])) {
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);
        $consulta7 = sqlsrv_query($conn, $resultado7);
        $consulta8 = sqlsrv_query($conn, $resultado8);
        $consulta9 = sqlsrv_query($conn, $resultado9);

        if(!empty($consulta9)){
            $ficheroExcel="DEIT_PASCO GESTANTES CON INICIO DE TRATAMIENTO "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
    ?>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <table>
        <thead>
            <tr></tr>
            <tr class="text-center">
                <th colspan="11" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="11" style="font-size: 26px; border: 1px solid #3A3838;">Gestantes con Inicio Tratamiento - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="11" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </tfoot>
        </thead>
    </table>
    <table class="table table-hover">
        <thead>
            <tr class="text-light font-12 text-center" style="background: #44688c; color: white;">
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Tamizaje VIF </th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Sospecha Violencia</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Diagnóstico</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Inicio Tratamiento</th>
                <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
            </tr>
        </thead>
        <tbody>
            <tr></tr>
            <?php  
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta9)){
                    if(is_null ($consulta['Provincia_Establecimiento']) ){
                        $newdate1 = '  -'; }
                    else{
                        $newdate1 = $consulta['Provincia_Establecimiento'] ;}
    
                    if(is_null ($consulta['Distrito_Establecimiento']) ){
                        $newdate2 = '  -'; }
                    else{
                        $newdate2 = $consulta['Distrito_Establecimiento'] ;}
    
                    if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                        $newdate3 = '  -'; }
                    else{
                        $newdate3 = $consulta['Tipo_Doc_Paciente'];}
        
                    if(is_null ($consulta['Numero_Documento_Paciente']) ){
                        $newdate4 = '  -'; }
                    else{
                        $newdate4 = $consulta['Numero_Documento_Paciente'];}
    
                    if(is_null ($consulta['Fecha_Atencion']) ){
                        $newdate5 = '  -'; }
                    else{
                        $newdate5 = $consulta['Fecha_Atencion'] -> format('d/m/y');}
                    
                    if(is_null ($consulta['VIF']) ){
                        $newdate6 = '  -'; }
                    else{
                        $newdate6 = $consulta['VIF'] -> format('d/m/y');}
        
                    if(is_null ($consulta['R456']) ){
                        $newdate7 = '  -'; }
                    else{
                        $newdate7 = $consulta['R456'] -> format('d/m/y');}
    
                    if(is_null ($consulta['diagnostico']) ){
                        $newdate8 = '  -'; }
                    else{
                        $newdate8 = $consulta['diagnostico'] -> format('d/m/y');}
    
                    if(is_null ($consulta['iniciotto']) ){
                        $newdate9 = '  -'; }
                    else{
                        $newdate9 = $consulta['iniciotto'] -> format('d/m/y');}
    
            ?>
            <tr>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate1); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate3; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php 
                    if(!is_null ($consulta['VIF']) && !is_null($consulta['R456']) && !is_null ($consulta['diagnostico']) && !is_null ($consulta['iniciotto'])){
                        if($consulta['VIF'] == $consulta['R456']){
                            if($consulta['DIA1'] <= 15 && $consulta['DIA2'] <= 7){
                                echo "<span class='badge bg-correct'>CUMPLE</span>";
                            }else{
                                echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                            }
                        }else{
                            echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                        }
                    }else{
                        echo "<span class='badge bg-incorrect'>NO CUMPLE</span>"; 
                    }
                ?></td>
            </tr>
            <?php
                ;}                    
                include("cerrar.php");
            ?>
        </tbody>
    </table>

<?php
        }
    }
?>