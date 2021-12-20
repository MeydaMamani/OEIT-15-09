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

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION';  }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $red = 'TODOS'; }


        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
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
                            where ANIO='2021' AND MES='$mes' AND T.Provincia_Establecimiento='$red' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
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
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * FROM (
                            SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                            dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente) and (t.Fecha_Atencion=dx.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente) and (t.Fecha_Atencion=tto.Fecha_Atencion)
                            where ANIO='2021' AND MES in ('$mes_ant') AND T.Provincia_Establecimiento='$red' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where r456 is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA";
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
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * FROM (
                            SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                            dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente) and (t.Fecha_Atencion=dx.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.ttoviolencia tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente) and (t.Fecha_Atencion=tto.Fecha_Atencion)
                            where ANIO='2021' AND MES in ('$mes_ant') AND  ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where r456 is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA";
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
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico='D'";

            $resultado7 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                            Tipo_Doc_Paciente, Numero_Documento_Paciente, Fecha_Atencion
                            INTO BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('T741','T742','T743','T748','T749','Y070','Y078','X85','Y09')
                            and Tipo_Diagnostico IN('D','R') AND Id_Cita IN
                            (SELECT  ID_CITA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            where ANIO='2021' AND Codigo_Item in ('99215','99366','99207.04','Z504','99207.01','90834','90860',
                            '90806','C2111.01','96100.01','90847','C0011'))";

            $resultado8 = "SELECT * FROM (
                            SELECT  DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456,
                            dx.Fecha_Atencion diagnostico, tto.Fecha_Atencion iniciotto
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE TM ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SOSPECHA R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA dx ON (T.Numero_Documento_Paciente=dx.Numero_Documento_Paciente) and (t.Fecha_Atencion=dx.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA tto ON (T.Numero_Documento_Paciente=tto.Numero_Documento_Paciente) and (t.Fecha_Atencion=tto.Fecha_Atencion)
                            where ANIO='2021' AND MES in ('$mes_ant') AND T.Distrito_Establecimiento='$dist' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where r456 is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TAMIZAJE
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SOSPECHA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.DXVIOLENCIA
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.TTOVIOLENCIA";
        }

        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);
        $consulta7 = sqlsrv_query($conn, $resultado7);
        $consulta8 = sqlsrv_query($conn, $resultado8);
        $correctos=0; $incorrectos=0;
    }    
?>