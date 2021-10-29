<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes;
        }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $redt = 'PASCO'; }
        
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

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO CG_FT_GESTANTES_USUAR_NUEVAS_SERV_PLANIF_FAM - PPFF_CON_DX_VIOLENC (TMZ) "._date("d-m-Y", false, 'America/Lima').".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;ESTABLECIMIENTO;TIPO_DOCUMENTO;DOCUMENTO;FECHA_NAC_PACIENTE;EDAD;FECHA_ATENCION;CODIGO;CUMPLE\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['Provincia_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provincia_Establecimiento'].";"; }

                if(is_null ($consulta['distrito_establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['distrito_establecimiento'].";" ; }

                if(is_null ($consulta['Nombre_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['Nombre_Establecimiento']).";"; }

                if(is_null ($consulta['Abrev_Tipo_Doc_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Abrev_Tipo_Doc_Paciente'].";" ; }

                if(is_null ($consulta['Numero_Documento_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numero_Documento_Paciente'].";" ; }

                if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['Edad_Reg']) ){ echo ' - '.";"; }
                else{ echo $consulta['Edad_Reg'].";" ; }

                if(is_null ($consulta['Fecha_Atencion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Atencion'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['Codigo_Item']) ){ echo ' - '.";"; }
                else{ echo $consulta['Codigo_Item'].";" ; }

                if($consulta['Codigo_Item'] != '' and !is_null ($consulta['Codigo_Item'])){
                    echo "Si"."\n";
                }else{
                    echo "No"."\n";
                }
            }   
        }
    }
?>