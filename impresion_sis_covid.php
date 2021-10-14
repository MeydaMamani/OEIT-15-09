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

      if (strlen($mes) == 1){
          $mes = '0'.$mes;
      }
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
        $redt = 'PASCO';
      }

      $resultado = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                    pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                          WHEN pn.NUM_DNI IS NOT NULL
                          THEN pn.NUM_DNI
                          ELSE pn.NUM_CNV
                        END,
                      CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_MADRE,' ', pn.NOMBRE_NINO) AS APELLIDOS_NOMBRES,
                      pn.TIPO_SEGURO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN
                          into BDHIS_MINSA.dbo.PADRON_EVALUAR6
                      from NOMINAL_PADRON_NOMINAL AS pn
                      where YEAR (DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='$mes'
                      and mes='2021$mes';
                      with c as ( select DOCUMENTO, nombre_dist, ROW_NUMBER() over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                      from BDHIS_MINSA.dbo.PADRON_EVALUAR6)
                      delete  from c
                      where duplicado >1";	

      $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                      A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                      Min(CASE WHEN (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='2021' AND  EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'85018',
                      Min(CASE WHEN (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'D50X',
                      Min(CASE WHEN (Codigo_Item ='U310' AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'U310_SF1',
                      Min(CASE WHEN (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'SUPLE'
                      into BDHIS_MINSA.dbo.suple6
                      --select * from BDHIS_MINSA.dbo.suple6
                      FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA AS A
                      WHERE
                        ((a.fecha_atencion> '2021-05-01') and (a.fecha_atencion<= CONCAT('2021-$mes-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/2021'),0)))))) AND
                        ( (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='2021' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                        (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D'  AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                        (Codigo_Item IN('U310','99199.17') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) or
                        (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) )
                      GROUP BY A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                      A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente				
                      ORDER BY Numero_Documento_Paciente asc, A.Nombre_Establecimiento";

      if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
        $dist=$dist_1;
        $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                        s.D50X,s.U310_SF1,s.SUPLE
                        FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                        on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red'
                        order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                        DROP TABLE BDHIS_MINSA.dbo.suple6
                        DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
      }
      else if ($red_1 == 4 and $dist_1 == 'TODOS') {
        $dist = '';
        $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                          pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente AS TIPO_DOC, APELLIDOS_NOMBRES,
                          pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN AS PN_ULTIMO_LUGAR, S.Nombre_Establecimiento AS ESTAB_ACTIVIDAD, s.[85018] HEMOGLOBINA,
                          s.D50X, s.U310_SF1, s.SUPLE
                          FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 AS s
                          on pn.DOCUMENTO=s.Numero_Documento_Paciente
                          order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO	   
                          DROP TABLE BDHIS_MINSA.dbo.suple6
                          DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";   
      }
      else if($dist_1 != 'TODOS'){
        $dist=$dist_1;
        $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                      pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                      pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                      s.D50X,s.U310_SF1,s.SUPLE
                      FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                      on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red' AND pn.NOMBRE_DIST='$dist'
                      order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                      DROP TABLE BDHIS_MINSA.dbo.suple6
                      DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
      }
         
      $consulta2 = sqlsrv_query($conn2, $resultado);
      $consulta3 = sqlsrv_query($conn, $resultado2);
      $consulta4 = sqlsrv_query($conn, $resultado3);

        if(!empty($consulta4)){
            $ficheroExcel="SIS_COVID".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;TIPO_DOC;NUMERO_DOC;AP_NOM;TIPO_SEGURO;DIRECCION;DNI;USUARIO_NOM;USUARIO_PROC;FEC_REG;FEC_SEG;FEC_ENT;DIAS_SEG;CF300;CMED;C_AMBOS\n";                    
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta4)){
                echo $i++.";";
                if(is_null ($consulta['PROVINCIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['PROVINCIA'].";"; }

                if(is_null ($consulta['DISTRITO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DISTRITO'].";" ; }

                if(is_null ($consulta['TIP_DOC']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['TIP_DOCO']).";"; }

                if(is_null ($consulta['NUMERO_DOC']) ){ echo ' - '.";"; }
                else{ echo $consulta['NUMERO_DOC'].";" ; }

                if(is_null ($consulta['AP_NOM']) ){ echo ' - '.";"; }
                else{ echo $consulta['AP_NOM'].";" ; }

                if(is_null ($consulta['TIPO_SEGURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_SEGURO']-> format('d/m/y').";" ; }

                if(is_null ($consulta['DIRECCION']) ){ echo ' - '.";"; }
                else{ echo $consulta['DIRECCION'].";" ; }

                if(is_null ($consulta['DNI']) ){ echo ' - '.";"; }
                else{ echo $consulta['DNI'].";" ; }

                if(is_null ($consulta['USUARIO_NOM']) ){ echo ' - '.";"; }
                else{ echo $consulta['USUARIO_NOM'].";" ; }

                if(is_null ($consulta['TIPO_SEGURO']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_SEGURO'].";" ; }

                if(is_null ($consulta['USUARIO_PROC']) ){ echo ' - '.";"; }
                else{ echo $consulta['USUARIO_PROC'].";" ; }

                if(is_null ($consulta['FEC_REG']) ){ echo ' - '.";"; }
                else{ echo $consulta['FEC_REG'].";" ; }

                if(is_null ($consulta['FEC_SEG']) ){ echo ' - '.";"; }
                else{ echo $consulta['FEC_SEG']-> format('d/m/y').";" ; }

                if(is_null ($consulta['FEC_ENT']) ){ echo ' - '.";"; }
                else{ echo $consulta['FEC_ENT']-> format('d/m/y').";" ; }

                if(is_null ($consulta['DIAS_SEG']) ){ echo ' - '.";"; }
                else{ echo $consulta['DIAS_SEG']-> format('d/m/y').";" ; }

                if(is_null ($consulta['CF300']) ){ echo ' - '.";"; }
                else{ echo $consulta['CF300']-> format('d/m/y').";" ; }

                if(!is_null ($consulta['HEMOGLOBINA']) && !is_null ($consulta['D50X']) && !is_null ($consulta['U310_SF1']) && is_null ($consulta['SUPLE'])){
                  if($consulta['HEMOGLOBINA'] == $consulta['D50X'] && $consulta['HEMOGLOBINA'] == $consulta['U310_SF1']){
                      echo "Si"."\n";
                  }else{
                      $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                      $nuevo_formato_anemia = date_format($consulta['D50X'], "d-m-Y");
                      $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                      $fecha_anemia = strtotime(date_format($consulta['D50X'], "d-m-Y"));
                      $fecha_tratamiento = strtotime(date_format($consulta['U310_SF1'], "d-m-Y"));
                      $fecha_anemia_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_anemia."+ 7 days")));

                      if($fecha_anemia < $fecha_hemoglobina_7_dias && $fecha_anemia > $nuevo_formato_hemoglobina) {
                        echo "Si"."\n";
                      }
                      else{
                        echo "No"."\n";
                      }
                  }
              }
              else if(!is_null ($consulta['HEMOGLOBINA']) && is_null ($consulta['D50X']) && is_null ($consulta['U310_SF1']) && !is_null ($consulta['SUPLE'])){
                  if($consulta['HEMOGLOBINA'] == $consulta['SUPLE']){
                    echo "Si"."\n";
                  }
                  else{
                      $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                      $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                      $fecha_suplementacion = strtotime(date_format($consulta['SUPLE'], "d-m-Y"));
                      if($fecha_suplementacion < $fecha_hemoglobina_7_dias && $fecha_suplementacion > $nuevo_formato_hemoglobina) {
                        echo "Si"."\n";
                      }
                  }
              }
              else{
                echo "No"."\n";
              }
            }   
        }
    }
?>