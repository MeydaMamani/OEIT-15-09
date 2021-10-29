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
  
        if(!empty($consulta1)){
            $ficheroExcel="DEIT_PASCO CG_FT_GESTANTES_DX_POSIT_VIOLEN_CON_DIAG_E_INICIO_TRATAMIENTO "._date("d-m-Y", false, 'America/Lima').".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;DOCUMENTO_PACIENTE;GESTANTE_ATENDIDA;NUM_CONTROL;TAMIZAJE_VIOLENCIA;PROBLEMAS_RELACIONADOS_VIOLENCIA;DIAGNOSTICO_INICIO_TRATAMIENTO;DIA_ATENCION;ATENDIDO;CUMPLE\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta1)){
                echo $i++.";";
                if(is_null ($consulta['Provincia_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provincia_Establecimiento'].";"; }

                if(is_null ($consulta['Distrito_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Distrito_Establecimiento'].";" ; }

                if(is_null ($consulta['Numero_Documento_Paciente']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['Numero_Documento_Paciente']).";"; }

                if(is_null ($consulta['GESTANTES_ATENDIDAS']) ){ echo ' - '.";"; }
                else{ echo $consulta['GESTANTES_ATENDIDAS'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['nro_control']) ){ echo ' - '.";"; }
                else{ echo $consulta['nro_control'].";" ; }

                if(is_null ($consulta['TAMIZAJE_VIOLENCIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['TAMIZAJE_VIOLENCIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DIAGNOSTICO_INICIO_TRATAMIENTO'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['DIAS_ATENCION']) ){ echo ' - '.";"; }
                else{ echo $consulta['DIAS_ATENCION'].";" ; }

                if(is_null ($consulta['ATENDIO']) ){ echo ' - '.";"; }
                else{ echo $consulta['ATENDIO'].";" ; }

                if($consulta['DIAS_ATENCION'] <= 7 && $consulta['DIAS_ATENCION'] >= 0 && !is_null ($consulta['DIAS_ATENCION'])){
                    echo "Si"."\n";
                }else if($consulta['DIAS_ATENCION'] > 7){
                    echo "Observado"."\n";
                }else if(is_null ($consulta['DIAS_ATENCION'])){
                    echo "No"."\n";
                }else{
                    echo '-'."\n";
                }

            }   
        }
    }
?>