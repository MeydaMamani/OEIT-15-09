<?php
    require ('abrir.php');    
    if (isset($_POST['Buscar'])) {
    global $conex;

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

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

        // para tabla FED

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
          $resultado_fed = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                            FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                  A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red')
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                          Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          where GES_CAPT_OPO is not null";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $dist = '';
          $resultado_fed = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                          Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                          GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                          FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                          Min(CASE WHEN (a.Codigo_Item ='85018' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                          Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                          Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                          Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                          Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                          Min(CASE WHEN (a.Codigo_Item ='R456' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                          Min(CASE WHEN (a.Codigo_Item ='80055.01' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                          Min(CASE WHEN (a.Codigo_Item ='U1692' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        WHERE (anio in ('2021') and Genero='f' and mes ='$mes')
                        GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                        Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                        where GES_CAPT_OPO is not null";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado_fed = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                          Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                          GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                          FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                          Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                          Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                          Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                          Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                          Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                          Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                          Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                          Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist')
                        GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                        Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                        where GES_CAPT_OPO is not null";
        }

        $params = array(); 
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta_fed2 = sqlsrv_query($conn, $resultado_fed, $params, $options);
        $row_cnt = sqlsrv_num_rows($consulta_fed2);
    }   
?>