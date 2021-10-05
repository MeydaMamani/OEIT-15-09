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

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
          $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                          DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                          from
                          (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                          OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                          ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                          ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                          ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                          ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                          OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                          gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                          where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $dist = '';
          $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                          DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                          from
                          (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                          OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                          MIN(CASE WHEN( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                          ( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                          ( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                          ( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                          ( (Anio='2021' AND Mes='$mes')  and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                          OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                          gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                          where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            GESTANTES_ATENDIDAS,nro_control,TAMIZAJE_VIOLENCIA,TMZ_POSTIVO_PROBLEMAS_VIOLENCIA, DIAGNOSTICO_INICIO_TRATAMIENTO,
                            DATEDIFF(day, GESTANTES_ATENDIDAS,DIAGNOSTICO_INICIO_TRATAMIENTO) DIAS_ATENCION,ATENDIO
                            from
                            (SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Valor_Lab ELSE NULL END )AS 'nro_control',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'TMZ_POSTIVO_PROBLEMAS_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                                  OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_INICIO_TRATAMIENTO',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )                                      THEN Nombres_Personal ELSE NULL END )AS 'ATENDIO'
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')) )  OR                                    
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                            gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente) b
                            where GESTANTES_ATENDIDAS is not null and TAMIZAJE_VIOLENCIA is not null";
        }

        $params = array(); 
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta1 = sqlsrv_query($conn, $resultado, $params, $options);
        $row_cnt = sqlsrv_num_rows($consulta1);

        $correctos=0;
        $incorrectos=0;
  }    
?>