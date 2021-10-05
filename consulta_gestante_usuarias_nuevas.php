<?php
    require ('abrir.php');    
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
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                          a.Fecha_Atencion, t.Codigo_Item
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                          (select t.Provincia_Establecimiento,t.Distrito_Establecimiento, t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                              t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                          where  t.anio='2021' and t.mes='$mes' AND  ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                              (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                              t.Id_Cita IN
                                (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                                t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                                AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                          on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                          where  a.anio='2021' AND a.MES='$mes' AND a.Provincia_Establecimiento='$red' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                          AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981'))";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $dist = '';
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                            a.Fecha_Atencion, t.Codigo_Item from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                            (select t.Provincia_Establecimiento,t.Distrito_Establecimiento,t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                                    t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                            where  t.anio='2021' and t.mes='$mes' and ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                                    (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                                    t.Id_Cita IN
                              (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                              where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                              t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                              AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                            on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                            where  a.anio='2021' AND a.MES='$mes' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                            AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981')) ";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                          a.Fecha_Atencion, t.Codigo_Item
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                          (select t.Provincia_Establecimiento,t.Distrito_Establecimiento, t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                              t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                          where  t.anio='2021' and t.mes='$mes' AND  ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                              (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                              t.Id_Cita IN
                                (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                                t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                                AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                          on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                          where  a.anio='2021' AND a.MES='$mes' AND a.Provincia_Establecimiento='$red' AND a.distrito_establecimiento='$dist' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                          AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981'))";
        }

        $params = array(); 
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta2 = sqlsrv_query($conn, $resultado, $params, $options);
        // $row_cnt = sqlsrv_num_rows($consulta2);
  }    
?>