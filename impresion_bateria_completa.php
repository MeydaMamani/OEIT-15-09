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
        
        
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                            FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                  A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red')
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                          Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          where GES_CAPT_OPO is not null";
  
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                          Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                          GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                        
                          FROM (SELECT
                              A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                              A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,                     
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                          Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                          Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                          Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                          Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                          Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                          Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                          Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                          Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                              FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes')                    
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                                Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          WHERE GES_CAPT_OPO is not null";
  
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                            FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                  A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist')
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                          Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          where GES_CAPT_OPO is not null";
        }
  
        $params = array(); 
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta2 = sqlsrv_query($conn, $resultado, $params, $options);

        if(!empty($consulta2)){
            $ficheroExcel="BATERIA_COMPLETA".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;IPRESS;TIPO_DOCUMENTO;DOCUMENTO;FECHA_NACIMIENTO_PACIENTE;CAPTADA;TMZ_VIF;TMZ_ANEMIA;SIFILIS;VIH;BACTERIURIA;CUMPLE\n";
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['PROVINCIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['PROVINCIA'].";"; }

                if(is_null ($consulta['DISTRITO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DISTRITO'].";" ; }

                if(is_null ($consulta['IPRESS']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['IPRESS']).";"; }

                if(is_null ($consulta['TIPO_DOC']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_DOC'].";" ; }

                if(is_null ($consulta['DOCUMENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DOCUMENTO'].";" ; }

                if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Nacimiento_Paciente']-> format('d/m/y').";" ; }

                if(is_null ($consulta['CAPTADA']) ){ echo ' - '.";"; }
                else{ echo $consulta['CAPTADA']-> format('d/m/y').";" ; }

                if(is_null ($consulta['TMZ_VIF']) ){ echo ' - '.";"; }
                else{ echo $consulta['TMZ_VIF'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['TMZ_ANEMIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['TMZ_ANEMIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SIFILIS']) ){ echo ' - '.";"; }
                else{ echo $consulta['SIFILIS'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['VIH']) ){ echo ' - '.";"; }
                else{ echo $consulta['VIH']-> format('d/m/y').";" ; }

                if(is_null ($consulta['BACTERIURIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['BACTERIURIA']-> format('d/m/y').";" ; }

                if ($consulta['CAPTADA'] == $consulta['TMZ_ANEMIA'] AND $consulta['CAPTADA'] == $consulta['SIFILIS'] AND $consulta['CAPTADA'] == $consulta['VIH'] AND $consulta['CAPTADA'] == $consulta['BACTERIURIA']) {
                    echo 'CORRECTO'."\n";
                } 
                else{
                    echo 'INCORRECTO'."\n";
                }
            }   
        }
    }
?>