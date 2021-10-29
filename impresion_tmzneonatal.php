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
        elseif ($red_1 == 4) { $redt = 'PASCO';  }
        
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red' AND nombre_dist='$dist'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO CG_FT_TMZ_NEONATAL "._date("d-m-Y", false, 'America/Lima').".csv";
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;DOCUMENTO;APELLIDOS_Y_NOMBRES;FECHA_DE_NACIMIENTO;NOMBRES_ESS;MENOR_ENCONTRADO;TIPO_DE_SEGURO;LUGAR_TAMIZAJE(HIS);FECHA_DE_ATENCION;CUMPLE\n";                    
            // Recorremos la consulta SQL y lo mostramos44
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta3)){
                echo $i++.";";
                if(is_null ($consulta['nombre_prov']) ){ echo ' - '.";"; }
                else{ echo $consulta['nombre_prov'].";"; }

                if(is_null ($consulta['nombre_dist']) ){ echo ' - '.";"; }
                else{ echo $consulta['nombre_dist'].";" ; }

                if(is_null ($consulta['num_dni']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['num_dni']).";"; }

                if(is_null ($consulta['apellidos_nino']) ){ echo ' - '.";"; }
                else{ echo $consulta['apellidos_nino'].";" ; }

                if(is_null ($consulta['fecha_nacimiento_nino']) ){ echo ' - '.";"; }
                else{ echo $consulta['fecha_nacimiento_nino'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['NOMBRE_EESS']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRE_EESS'].";" ; }

                if(is_null ($consulta['MENOR_ENCONTRADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['MENOR_ENCONTRADO'].";" ; }

                if(is_null ($consulta['tipo_seguro']) ){ echo ' - '.";"; }
                else{ echo $consulta['tipo_seguro'].";" ; }

                if(is_null ($consulta['Lugar_TMZ']) ){ echo ' - '.";"; }
                else{ echo $consulta['Lugar_TMZ'].";" ; }

                if(is_null ($consulta['Fecha_Atencion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Atencion'] -> format('d/m/y').";" ; }

                if(is_null($consulta['Fecha_Atencion']) || is_null($consulta['fecha_nacimiento_nino'])){
                    echo "No"."\n";
                }else {
                    $fecha_atencion  = new DateTime(date_format($consulta['Fecha_Atencion'], "d-m-Y"));
                    $fecha_nacimiento = new DateTime(date_format($consulta['fecha_nacimiento_nino'], "d-m-Y"));
                    $intvl = $fecha_nacimiento->diff($fecha_atencion);
                    if($intvl->days <= 6 && $intvl->days >=0){
                        echo "Si"."\n";
                    }else if($intvl->days > 6){
                        echo "Observado"."\n";
                    }
                }
            }   
        }
    }
?>