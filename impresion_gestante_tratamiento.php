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
          $red = 'TODOS';
        }

        // GESTANTES CON SOSPECHA DE VIOLENCIA
        $resultado = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                        Tipo_Doc_Paciente,Numero_Documento_Paciente,Fecha_Atencion
                        INTO BDHIS_MINSA_EXTERNO.dbo.tmz
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                        where ANIO='2021' AND ((Codigo_Item='96150' and Valor_Lab='VIF') OR Codigo_Item='96150.01')
                        and Tipo_Diagnostico='D'";

        $resultado2 = "SELECT  DISTINCT(Numero_Documento_Paciente) AS ATENDIDOS, 
                        Tipo_Doc_Paciente,Numero_Documento_Paciente,Fecha_Atencion
                        INTO BDHIS_MINSA_EXTERNO.dbo.r456
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                        where ANIO='2021' AND Codigo_Item='R456'
                        and Tipo_Diagnostico='D'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $mes_ant = $mes-1;
            $resultado3 = "SELECT * from (
                            SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TMZ TM
                            ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            where ANIO='2021' AND MES='$mes' AND Provincia_Establecimiento='$red' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where vif is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            drop table BDHIS_MINSA_EXTERNO.dbo.tmz
                            drop table BDHIS_MINSA_EXTERNO.dbo.r456";
  
            $resultado5 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                          DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                          from
                          (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )    THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',
  
                          MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                                OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                          MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                          ( (Anio='2021' AND Mes in ('$mes_ant'))  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                          ( (Anio='2021' AND Mes in ('$mes_ant'))  and  Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                          ( (Anio='2021' AND Mes in ('$mes_ant')) and  Provincia_Establecimiento='$red'  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                          ( (Anio='2021' AND Mes in ('$mes')) and  Provincia_Establecimiento='$red'  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                                  OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                          gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                          where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null
                          ORDER BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $mes_ant = $mes-1;
            $resultado3 = "SELECT * from (
                                SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                                T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TMZ TM
                                ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                                LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                                where ANIO='2021' AND MES='$mes' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                                and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                                where vif is not null
                                ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                                drop table BDHIS_MINSA_EXTERNO.dbo.tmz
                                drop table BDHIS_MINSA_EXTERNO.dbo.r456";

            $resultado5 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                            DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                            from
                            (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant') and Descripcion_Sector='GOBIERNO REGIONAL' AND (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) ) THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant') and Descripcion_Sector='GOBIERNO REGIONAL' AND (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) ) THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant') and Descripcion_Sector='GOBIERNO REGIONAL' AND (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' ) OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant') and Descripcion_Sector='GOBIERNO REGIONAL' AND (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',

                            MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%') OR (Codigo_Item like 'X87%') OR (Codigo_Item like 'X88%') OR (Codigo_Item like 'X89%')
                                OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                            MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                            ( (Anio='2021' AND Mes in ('$mes_ant')) and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                            ( (Anio='2021' AND Mes in ('$mes_ant')) and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                            ( (Anio='2021' AND Mes in ('$mes_ant')) and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                            ( (Anio='2021' AND Mes in ('$mes'))  and Descripcion_Sector='GOBIERNO REGIONAL' AND (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078')) or (Codigo_Item like 'X85%') OR (Codigo_Item like 'X86%') OR (Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%') OR (Codigo_Item like 'X89%')
                                    OR(Codigo_Item like 'X90%') OR (Codigo_Item like 'X91%') OR (Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                            GROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                            where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null
                            ORDER BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $mes_ant = $mes-1;
            $resultado3 = "SELECT * from (
                            SELECT DISTINCT(T.Numero_Documento_Paciente) AS ATENDIDOS, T.Provincia_Establecimiento,T.Distrito_Establecimiento,
                            T.Tipo_Doc_Paciente,T.Numero_Documento_Paciente,T.Fecha_Atencion, TM.Fecha_Atencion VIF, R.Fecha_Atencion R456
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.TMZ TM
                            ON (T.Numero_Documento_Paciente=TM.Numero_Documento_Paciente) and (t.Fecha_Atencion=tm.Fecha_Atencion)
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.r456 R ON (T.Numero_Documento_Paciente=r.Numero_Documento_Paciente) and (t.Fecha_Atencion=r.Fecha_Atencion)
                            where ANIO='2021' AND MES='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND ((Codigo_Item IN ('Z3491','Z3591','Z3492','Z3592','Z3493','Z3593'))
                            and Tipo_Diagnostico='D') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))  ) a
                            where vif is not null
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, ATENDIDOS
                            drop table BDHIS_MINSA_EXTERNO.dbo.tmz
                            drop table BDHIS_MINSA_EXTERNO.dbo.r456";
  
            $resultado5 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                          DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                          from
                          (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes_ant')  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )    THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',
  
                          MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                                OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                          MIN(CASE WHEN( (Anio='2021' AND Mes in ('$mes'))  and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                          ( (Anio='2021' AND Mes in ('$mes_ant'))  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                          ( (Anio='2021' AND Mes in ('$mes_ant'))  and  Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                          ( (Anio='2021' AND Mes in ('$mes_ant')) and  Distrito_Establecimiento='$dist'  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                          ( (Anio='2021' AND Mes in ('$mes')) and  Distrito_Establecimiento='$dist'  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                                  OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                          gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                          where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null
                          ORDER BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";
        }

    if(isset($_POST["exportarCSV"])) {
        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO CG_FT_GESTANTES_DX_POSIT_VIOLEN_CON_DIAG_E_INICIO_TRATAMIENTO "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">Gestantes con Tamizaje e Inicio de Tratamiento por Violencia CG - <?php echo $nombre_mes; ?></th>
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tamizaje VIF</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Sospecha Violencia</th>
            </tr>
        </thead>
        <tbody>
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

    else if(isset($_POST["exportarCSV2"])) {
        $consulta5 = sqlsrv_query($conn, $resultado5);

        if(!empty($consulta5)){
            $ficheroExcel="DEIT_PASCO CG_FT_GESTANTES_DX_POSIT_VIOLEN_CON_DIAG_E_INICIO_TRATAMIENTO "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="12" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="12" style="font-size: 26px; border: 1px solid #3A3838;">Gestantes con Tamizaje e Inicio de Tratamiento por Violencia CG - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="12" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </tfoot>
        </thead>
    </table>
    <table class="table table-hover">
        <thead>
            <tr class="text-light font-12 text-center" style="background: #44688c;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento Paciente</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Gestantes Atendidas</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">N° Control</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="gestante_tratamiento_head">Tamizaje Violencia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="gestante_tratamiento_head">Problemas relacionados con violencia</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="gestante_tratamiento_head">Diagnóstico Inicio de Tratamiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Día Atención</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Atendido</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta5)){  
                    // CAMBIO AQUI
                    if(is_null ($consulta['Provincia_Establecimiento']) ){
                    $newdate1 = '  -'; }
                    else{
                    $newdate1 = $consulta['Provincia_Establecimiento'] ;}
    
                    if(is_null ($consulta['Distrito_Establecimiento']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['Distrito_Establecimiento'] ;}
        
                    if(is_null ($consulta['Numero_Documento_Paciente']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['Numero_Documento_Paciente'];}
    
                    if(is_null ($consulta['GESTANTES_ATENDIDAS']) ){
                    $newdate4 = '  -'; }
                    else{
                    $newdate4 = $consulta['GESTANTES_ATENDIDAS'] -> format('d/m/y');}
                    
                    if(is_null ($consulta['nro_control']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['nro_control'];}
        
                    if(is_null ($consulta['TAMIZAJE_VIOLENCIA']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['TAMIZAJE_VIOLENCIA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){
                    $newdate8 = '  -'; }
                    else{
                    $newdate8 = $consulta['DIAGNOSTICO_INICIO_TRATAMIENTO'] -> format('d/m/y');}
    
                    if(is_null ($consulta['DIAS_ATENCION']) ){
                    $newdate9 = '  -'; }
                    else{
                    $newdate9 = $consulta['DIAS_ATENCION'];}
    
                    if(is_null ($consulta['ATENDIO']) ){
                    $newdate10 = '  -'; }
                    else{
                    $newdate10 = $consulta['ATENDIO'];}
            ?>
            <tr style="font-size: 12px; text-align: center;">
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate1); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate3; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate4; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate10); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php 
                if($consulta['DIAS_ATENCION'] <= 7 && $consulta['DIAS_ATENCION'] >= 0 && !is_null ($consulta['DIAS_ATENCION'])){
                    echo "<span class='badge bg-correct'>Si</span>";
                }else if($consulta['DIAS_ATENCION'] > 7){
                    echo "<span class='badge bg-observed'>Observado</span>";
                }else if(is_null ($consulta['DIAS_ATENCION'])){
                    echo "<span class='badge bg-incorrect'>No</span>";
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