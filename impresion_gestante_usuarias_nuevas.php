<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
 
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
        elseif ($red_1 == 4) { $redt = 'PASCO'; }
        
        $resultado = "SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                        apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                        into  padron_nino_cnv1
                        from nominal_padron_nominal
                        where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2';
                        with c as ( select num_cnv, nombre_dist, ROW_NUMBER() 
                                over(partition by num_cnv order by num_cnv) as duplicado
                        from dbo.padron_nino_cnv1)
                        delete  from c
                        where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' AND Provnacido in ('PASCO', 'OXAPAMPA', 'DANIEL ALCIDES CARRION')
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red' and Distnacido = '$dist'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }

        $consulta1 = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);

        if(!empty($consulta2)){
            $ficheroExcel="GESTANTE_NUEVAS ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;ESTABLECIMIENTO;MENOR_ENCONTRADO;FECHA_NACIDO;DOCUMENTO;APELLIDOS_Y_NOMBRES;PREMATURO;SUPLEMENTADO;TIPO_DOC_PACIENTE;TIPO_SEGURO;SE_ATIENDE\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['Provnacido']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provnacido'].";"; }

                if(is_null ($consulta['Distnacido']) ){ echo ' - '.";"; }
                else{ echo $consulta['Distnacido'].";" ; }

                if(is_null ($consulta['Establecimiento']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['Establecimiento']).";"; }

                if(is_null ($consulta['MENOR_ENCONTRADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['MENOR_ENCONTRADO'].";" ; }

                if(is_null ($consulta['FECNACIDO']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECNACIDO'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['Numcnv']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numcnv'].";" ; }

                if(is_null ($consulta['NOMBRES_MENOR']) ){ echo ' - '.";"; }
                else{ echo $consulta['NOMBRES_MENOR'].";" ; }

                if(is_null ($consulta['PREMATURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['PREMATURO'].";" ; }

                if(is_null ($consulta['SUPLEMENTADO']) ){ echo 'NO'.";"; }
                else{ echo 'SI'.";" ; }

                if(is_null ($consulta['Tipo_Doc_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Tipo_Doc_Paciente'].";" ; }

                if(is_null ($consulta['TIPO_SEGURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_SEGURO'].";" ; }

                if(is_null ($consulta['SE_ATIENDE']) ){ echo ' - '.";"; }
                else{ echo $consulta['SE_ATIENDE']."\n" ; }
            }   
        }
    }
?>