<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    require('abrir5.php'); 
    
    $red_1 = $_POST['red'];
    $dist_1 = $_POST['distrito'];
    $mes = $_POST['mes'];

    if (strlen($mes) == 1){
        $mes2 = '0'.$mes;
    }else{
        $mes2 = $mes;
    }

    if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
      elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
      elseif ($red_1 == 3) { $red = 'PASCO'; }
      elseif ($red_1 == 4) { $redt = 'PASCO'; }

      $resultado = "SELECT *, ROW_NUMBER() over (PARTITION by NUMERO_DOCUMENTO ORDER BY FECHA_REGISTRO  ASC) AS RN 
                    INTO SINF0 FROM F0 WHERE MES='2021/10'
                    DELETE SINF0 WHERE RN>1
                    SELECT SO.RESIDENCIA_PROVINCIA,SO.RESIDENCIA_DISTRITO,SO.TIPO_DOCUMENTO,SO.NUMERO_DOCUMENTO,
                    CONCAT(SO.APELLIDO_PATERNO, ' ', SO.APELLIDO_MATERNO, ' ', SO.NOMBRES) as full_name, SO.DIRECCION,SO.USUARIO_DNI, 
                    SO.USUARIO_NOMBRE,SO.USUARIO_PROCEDENCIA,SO.FECHA_REGISTRO,
                    SE.FICHA_300_FECHA_DEL_SEGUIMIENTO,
                    ME.FECHA_ENTREGA,
                    DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) AS DIAS_SEGUIMIENTO,
                    DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) AS DIAS_MED,
                    CASE WHEN (DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1'))THEN 1 ELSE NULL END AS CF300,
                    CASE WHEN (DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS CMED,
                    CASE WHEN (DATEDIFF(DAY,SO.FECHA_REGISTRO,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1') 
                    AND DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS C_AMBOS
                    INTO SOSPECHOSO FROM SINF0 SO 
                    LEFT JOIN (SELECT SE.*, ROW_NUMBER() over (PARTITION by SE.NUMERO_DOCUMENTO ORDER BY SE.FICHA_300_FECHA_DEL_SEGUIMIENTO ASC) AS RN 
                    FROM F300 SE WHERE SE.MES='2021/10') SE ON SE.NUMERO_DOCUMENTO = SO.NUMERO_DOCUMENTO AND SE.RN = 1 
                    LEFT JOIN (SELECT ME.*, ROW_NUMBER() over (PARTITION by ME.NUMERO_DOCUMENTO ORDER BY ME.FECHA_ENTREGA ASC) AS RN 
                    FROM MED ME WHERE ME.MES='2021/10') ME ON ME.NUMERO_DOCUMENTO = SO.NUMERO_DOCUMENTO AND ME.RN = 1 
                    WHERE SO.MES='2021/10' 
                    GROUP BY SO.RESIDENCIA_PROVINCIA,SO.RESIDENCIA_DISTRITO,SO.TIPO_DOCUMENTO,SO.NUMERO_DOCUMENTO,
                    SO.DIRECCION,SO.USUARIO_DNI, SO.APELLIDO_PATERNO, SO.APELLIDO_MATERNO, SO.NOMBRES,
                    SO.USUARIO_NOMBRE,SO.USUARIO_PROCEDENCIA,SO.FECHA_REGISTRO, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA,ME.FECHA_RECETA;";

      $resultado3 = "SELECT F.*, ROW_NUMBER() over (PARTITION by NUMERO_DOCUMENTO ORDER BY FECHA_EJECUCION_PRUEBA ASC) AS RN, ES.DEPARTAMENTO AS DEPAR_EESS, ES.DESCRIPCION_SECTOR
                      INTO SINF100 FROM F100 F LEFT JOIN MAESTRO_HIS_ESTABLECIMIENTO ES ON F.COD_ESTABLECIMIENTO_REGISTRA =ES.Id_Establecimiento  
                      WHERE MES='2021/10' AND CLASIFICACION_CLINICA_SEVERIDAD IN ('Leve o Asintomßtica',
                      'LEVE O ASINTOM-TICO (Tratamiento domiciliario. Tos, malestar general, dolor de garganta, fiebre, congesti¾n nasal))','Leve',
                      'LEVE  (Tratamiento domiciliario. Tos, malestar general, dolor de garganta, fiebre, congesti¾n nasal))') AND RESULTADO_2 IN ('IgG POSITIVO','IgM Reactivo',
                      'IgM e IgG Reactivo','IgM e IgG POSITIVO','IgG Reactivo','IgM POSITIVO','Reactivo','Anticuerpos totales reactivo')
                      AND ES.DEPARTAMENTO = 'PASCO' AND ES.DESCRIPCION_SECTOR='GOBIERNO REGIONAL'
                      DELETE SINF100 WHERE RN>1
                      SELECT PR.PROVINCIA, PR.DISTRITO, PR.TIPO_DOCUMENTO, PR.NUMERO_DOCUMENTO, CONCAT(PR.APELLIDO_MATERNO, ' ', PR.APELLIDO_PATERNO, ' ', PR.NOMBRES ) as full_name, 
                      PR.RESULTADO_1, PR.CLASIFICACION_CLINICA_SEVERIDAD, PR.REGISTRADOR, PR.DOC_REGISTRADOR, PR.RESULTADO_2, PR.COD_ESTABLECIMIENTO_EJECUTA,
                      PR.ESTABLECIMIENTO_EJECUTA, PR.FECHA_EJECUCION_PRUEBA, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA,
                      DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) AS DIAS_SEGUIMIENTO,
                      DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) AS DIAS_MED,
                      CASE WHEN (DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1'))THEN 1 ELSE NULL END AS CF300,
                      CASE WHEN (DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS CMED,
                      CASE WHEN (DATEDIFF(DAY,PR.FECHA_EJECUCION_PRUEBA,SE.FICHA_300_FECHA_DEL_SEGUIMIENTO) IN ('0','1') 
                      AND DATEDIFF(DAY,ME.FECHA_RECETA,ME.FECHA_ENTREGA) IN ('0','1','2'))THEN 1 ELSE NULL END AS C_AMBOS
                      INTO PRUEBA FROM SINF100 PR
                      LEFT JOIN (SELECT SE.*, ROW_NUMBER() over (PARTITION by SE.NUMERO_DOCUMENTO ORDER BY SE.FICHA_300_FECHA_DEL_SEGUIMIENTO ASC) AS RN 
                      FROM F300 SE WHERE SE.MES='2021/10') SE ON SE.NUMERO_DOCUMENTO = PR.NUMERO_DOCUMENTO AND SE.RN = 1 
                      LEFT JOIN (SELECT ME.*, ROW_NUMBER() over (PARTITION by ME.NUMERO_DOCUMENTO ORDER BY ME.FECHA_ENTREGA ASC) AS RN 
                      FROM MED ME WHERE ME.MES='2021/10') ME ON ME.NUMERO_DOCUMENTO = PR.NUMERO_DOCUMENTO AND ME.RN = 1 
                      WHERE PR.MES='2021/10' 
                      GROUP BY PR.PROVINCIA, PR.DISTRITO, PR.TIPO_DOCUMENTO, PR.NUMERO_DOCUMENTO, PR.NOMBRES, PR.APELLIDO_PATERNO, PR.APELLIDO_MATERNO,
                      PR.RESULTADO_1, PR.CLASIFICACION_CLINICA_SEVERIDAD, PR.REGISTRADOR, PR.DOC_REGISTRADOR, PR.RESULTADO_2, PR.COD_ESTABLECIMIENTO_EJECUTA,
                      PR.ESTABLECIMIENTO_EJECUTA, PR.FECHA_EJECUCION_PRUEBA, SE.FICHA_300_FECHA_DEL_SEGUIMIENTO, ME.FECHA_ENTREGA, ME.FECHA_RECETA";
          
      if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
          $resultado2 = "SELECT * FROM SOSPECHOSO WHERE RESIDENCIA_PROVINCIA = '$red'
                              DROP TABLE SINF0
                              DROP TABLE SOSPECHOSO";

          $resultado4 = "SELECT * FROM PRUEBA WHERE PROVINCIA = '$red'
                              DROP TABLE SINF100
                              DROP TABLE PRUEBA";
      }
      else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $resultado2 = "SELECT * FROM SOSPECHOSO
                              DROP TABLE SINF0
                              DROP TABLE SOSPECHOSO";

          $resultado4 = "SELECT * FROM PRUEBA
                              DROP TABLE SINF100
                              DROP TABLE PRUEBA";
      }
      else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado2 = "SELECT * FROM SOSPECHOSO WHERE RESIDENCIA_PROVINCIA = '$red' AND RESIDENCIA_DISTRITO = '$dist'
                              DROP TABLE SINF0
                              DROP TABLE SOSPECHOSO";

          $resultado4 = "SELECT * FROM PRUEBA WHERE PROVINCIA = '$red' AND DISTRITO = '$dist'
                              DROP TABLE SINF100
                              DROP TABLE PRUEBA";
      }

      $consulta1 = sqlsrv_query($conn5, $resultado);
      $consulta2 = sqlsrv_query($conn5, $resultado2);
      $consulta3 = sqlsrv_query($conn5, $resultado3);
      $consulta4 = sqlsrv_query($conn5, $resultado4);

    if(isset($_POST["exportarCSV_f0"])) {
      ini_set("default_charset", "UTF-8");
      global $conex;
      header('Content-Type: text/html; charset=UTF-8');

      if(!empty($consulta2)){
          $ficheroExcel="CASOS_SOSPECHOSOS_F0 ".date("d-m-Y").".csv";        
          //Indicamos que vamos a tratar con un fichero CSV
          header("Content-type: text/csv");
          header("Content-Disposition: attachment; filename=".$ficheroExcel);            
          // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
          echo "#;PROVINCIA;DISTRITO;TIPO_DOCUMENTO;DOCUMENTO;APELLIDOS_NOMBRES;DIRECCION;DNI;USUARIO;PROCEDENCIA;FECHA_REGISTRO;FECHA_SEGUIMIENTO;FECHA_ENTREGA;CUMPLE\n";
          // Recorremos la consulta SQL y lo mostramos
          $i=1;
          while ($consulta = sqlsrv_fetch_array($consulta2)){
            echo $i++.";";
            if(is_null ($consulta['RESIDENCIA_PROVINCIA']) ){ echo '- '.";"; }
            else{ echo $consulta['RESIDENCIA_PROVINCIA'].";" ;}

            if(is_null ($consulta['RESIDENCIA_DISTRITO']) ){ echo '- '.";"; }
            else{ echo $consulta['RESIDENCIA_DISTRITO'].";" ;}

            if(is_null ($consulta['TIPO_DOCUMENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['TIPO_DOCUMENTO'].";" ;}

            if(is_null ($consulta['NUMERO_DOCUMENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['NUMERO_DOCUMENTO'].";" ;}

            if(is_null ($consulta['full_name']) ){ echo '- '.";"; }
            else{ echo $consulta['full_name'].";" ;}
           
            if(is_null ($consulta['DIRECCION']) ){ echo '- '.";"; }
            else{ echo $consulta['DIRECCION'].";" ;}

            if(is_null ($consulta['USUARIO_DNI']) ){ echo '- '.";"; }
            else{ echo $consulta['USUARIO_DNI'].";" ;}

            if(is_null ($consulta['USUARIO_NOMBRE']) ){ echo '- '.";"; }
            else{ echo $consulta['USUARIO_NOMBRE'].";" ;}

            if(is_null ($consulta['USUARIO_PROCEDENCIA']) ){ echo '- '.";"; }
            else{ echo $consulta['USUARIO_PROCEDENCIA'].";" ;}

            if(is_null ($consulta['FECHA_REGISTRO']) ){ echo '- '.";"; }
            else{ echo $consulta['FECHA_REGISTRO'] -> format('d/m/y').";" ;}

            if(is_null ($consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO'] -> format('d/m/y').";" ;}

            if(is_null ($consulta['FECHA_ENTREGA']) ){ echo '- '.";"; }
            else{ echo $consulta['FECHA_ENTREGA'] -> format('d/m/y').";" ;}

            if($consulta['C_AMBOS'] == 1){ echo "CORECTO"."\n"; }
            else{ echo "INCORECTO"."\n"; }
          }   
      }
    }

    if(isset($_POST["exportarCSV_f100"])) {
      if(!empty($consulta4)){
        $ficheroExcel="CASOS_SOSPECHOSOS_F100 ".date("d-m-Y").".csv";        
        //Indicamos que vamos a tratar con un fichero CSV
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=".$ficheroExcel);            
        // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
        echo "#;PROVINCIA;DISTRITO;TIPO_DOCUMENTO;DOCUMENTO;APELLIDOS_NOMBRES;RESULTADO_1;CLASIFICACION_CLINICA;REGISTRADOR;DOCUMENTO_REGISTRADOR;CODIGO_ESTABLECIMIENTO;ESTABLECIMIENTO;FECHA_PRUEBA;FECHA_SEGUIMIENTO;FECHA_ENTREGA;CUMPLE\n";
        // Recorremos la consulta SQL y lo mostramos
        $i=1;
        while ($consulta = sqlsrv_fetch_array($consulta4)){
            echo $i++.";";
            if(is_null ($consulta['PROVINCIA']) ){ echo '- '.";"; }
            else{ echo $consulta['PROVINCIA'].";" ;}

            if(is_null ($consulta['DISTRITO']) ){ echo '- '.";"; }
            else{ echo $consulta['DISTRITO'].";" ;}

            if(is_null ($consulta['TIPO_DOCUMENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['TIPO_DOCUMENTO'].";" ;}

            if(is_null ($consulta['NUMERO_DOCUMENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['NUMERO_DOCUMENTO'].";" ;}

            if(is_null ($consulta['full_name']) ){ echo '- '.";"; }
            else{ echo $consulta['full_name'].";" ;}
           
            if(is_null ($consulta['RESULTADO_1']) ){ echo '- '.";"; }
            else{ echo $consulta['RESULTADO_1'].";" ;}

            if(is_null ($consulta['CLASIFICACION_CLINICA_SEVERIDAD']) ){ echo '- '.";"; }
            else{ echo $consulta['CLASIFICACION_CLINICA_SEVERIDAD'].";" ;}

            if(is_null ($consulta['REGISTRADOR']) ){ echo '- '.";"; }
            else{ echo $consulta['REGISTRADOR'].";" ;}

            if(is_null ($consulta['DOC_REGISTRADOR']) ){ echo '- '.";"; }
            else{ echo $consulta['DOC_REGISTRADOR'].";" ;}

            if(is_null ($consulta['COD_ESTABLECIMIENTO_EJECUTA']) ){ echo '- '.";"; }
            else{ echo $consulta['COD_ESTABLECIMIENTO_EJECUTA'].";" ;}

            if(is_null ($consulta['ESTABLECIMIENTO_EJECUTA']) ){ echo '- '.";"; }
            else{ echo $consulta['ESTABLECIMIENTO_EJECUTA'].";" ;}

            if(is_null ($consulta['FECHA_EJECUCION_PRUEBA']) ){ echo '- '.";"; }
            else{ echo $consulta['FECHA_EJECUCION_PRUEBA'] -> format('d/m/y').";" ;}

            if(is_null ($consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO']) ){ echo '- '.";"; }
            else{ echo $consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO'] -> format('d/m/y').";" ;}

            if(is_null ($consulta['FECHA_ENTREGA']) ){ echo '- '.";"; }
            else{ echo $consulta['FECHA_ENTREGA'] -> format('d/m/y').";" ;}

            if($consulta['C_AMBOS'] == 1){ echo "CORECTO"."\n"; }
            else{ echo "INCORECTO"."\n"; }
        }   
      }
    }
?>