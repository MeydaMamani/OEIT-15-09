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
        
        $resultado = "SELECT distinct(Numero_Documento_Paciente), 'PREMATURO' PREMATURO
                        INTO bdhis_minsa_externo.dbo.PREMATURO1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where anio='2021' and codigo_item in ('P0711','P0712','P0713','P073')";

        $resultado2 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                            WHEN pn.NUM_DNI IS NOT NULL
                            THEN pn.NUM_DNI
                            ELSE pn.NUM_CNV
                        END,
                        CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.NOMBRE_EESS ULTIMA_ATE_PN INTO BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                        from NOMINAL_PADRON_NOMINAL pn
                        where YEAR  (DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='$mes'
                        and mes='2021$mes2';
                        with c as ( select DOCUMENTO,  ROW_NUMBER() 
                                over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 )
                        delete  from c
                        where duplicado >1";

        $resultado3 = "SELECT Numero_Documento_Paciente, Fecha_Atencion, Tipo_Doc_Paciente,Edad_Dias_Paciente_FechaAtencion
                        INTO BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        -- WHERE ANIO='2021' AND (Fecha_Atencion>='2021-07-20' and Fecha_Atencion<='2021-08-31')
                        WHERE ANIO='2021' AND (Fecha_Atencion >= CONVERT(DATE, DATEADD(dd, -110, CONCAT('2021$mes2', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))) 
                        and Fecha_Atencion<=CONCAT('2021-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))
                        AND Tipo_Diagnostico='D' AND (Codigo_Item IN ('Z298','99199.17') AND VALOR_LAB IN ('SF1','PO1','P01')) AND EDAD_REG in ('3','4') AND Tipo_Edad='M'
                        ORDER BY Fecha_Atencion;
                        with c as ( select numero_documento_paciente,  ROW_NUMBER() 
                                over(partition by numero_documento_paciente order by numero_documento_paciente) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41)
                        delete  from c
                        where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from PADRON_EVALUAR41 pn
                    LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red'
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                                pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                                P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                            from PADRON_EVALUAR41 pn
                            LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                            LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from PADRON_EVALUAR41 pn
                    LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red' AND pn.NOMBRE_DIST ='$dist'
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }

        $consulta2 = sqlsrv_query($conn, $resultado);
        $consulta3 = sqlsrv_query($conn2, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);
        $consulta5 = sqlsrv_query($conn4, $resultado4);

        if(!empty($consulta5)){
            $ficheroExcel="NIÑOS_4_MESES ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;ESTABLECIMIENTO;MENOR_VISITADO;MENOR_ENCONTRADO;FECHA_NACIMIENTO;DOCUMENTO;TIPO_SEGURO;APELLIDOS_Y_NOMBRES;PREMATURO;SUPLEMENTADO(DIAS);ULTIMA_ATE_PN;CUMPLE\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta5)){
                echo $i++.";";
                if(is_null ($consulta['NOMBRE_PROV']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRE_PROV'].";"; }

                if(is_null ($consulta['NOMBRE_DIST']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRE_DIST'].";" ; }

                if(is_null ($consulta['EESS_ATENCION']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['EESS_ATENCION']).";"; }

                if(is_null ($consulta['MENOR_VISITADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['MENOR_VISITADO'].";" ; }

                if(is_null ($consulta['MENOR_ENCONTRADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['MENOR_ENCONTRADO'].";" ; }

                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECHA_NACIMIENTO_NINO']-> format('d/m/y').";" ; }

                if(is_null ($consulta['DOCUMENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DOCUMENTO'].";" ; }

                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ echo ' - '.";"; }
                else{ echo $consulta['APELLIDOS_NOMBRES'].";" ; }

                if(is_null ($consulta['PREMATURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['PREMATURO'].";" ; }

                if(is_null ($consulta['SUPLEMENTADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['SUPLEMENTADO'].";" ; }

                if(is_null ($consulta['ULTIMA_ATE_PN']) ){ echo ' - '.";"; }
                else{ echo $consulta['ULTIMA_ATE_PN'].";" ; }

                if(is_null ($consulta['TIPO_SEGURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_SEGURO'].";" ; }

                if($consulta['PREMATURO'] != 'PREMATURO'){ 
                    foreach (range(110, 130) as $numero) {
                        if($numero == $consulta['SUPLEMENTADO']){
                            echo "Si"."\n";
                        }
                    }
                    if(is_null ($consulta['SUPLEMENTADO'])){
                        echo "No"."\n";
                    }
                    if(!is_null ($consulta['SUPLEMENTADO']) && ($consulta['SUPLEMENTADO']<110 || $consulta['SUPLEMENTADO']>130)){
                        echo "Observado"."\n";
                     }
                }
                else{
                    echo "No Mide"."\n";
                }  
            }   
        }
    }
?>