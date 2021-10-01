<?php 
  require('abrir.php');
  require('abrir2.php');
  require('abrir3.php');
  require('abrir4.php');
    
  if (isset($_POST['Buscar'])) {
  global $conex;

?>
<?php
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
        
  if (strlen($mes) == 1){
      $mes2 = '0'.$mes;
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
           
  if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS') {
    $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                  A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED1',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED2',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED3',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED4',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'CRED1MES'
                
                  FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A WHERE
                  ( (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ))OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )) AND
                  (anio='2021' and Fecha_Nacimiento_Paciente>= '2021-$mes2-01')
                  AND Provincia_Establecimiento='$red'
                  GROUP BY A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                  A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Fecha_Nacimiento_Paciente
                  ORDER BY A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente";

  }
  else if ($red_1 == 4 and $dist_1 == 'TODOS') {
    $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                  A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED1',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED2',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED3',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED4',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'CRED1MES'
                
                  FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A WHERE
                  ( (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ))OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )) AND
                  (anio='2021' and Fecha_Nacimiento_Paciente>= '2021-$mes2-01')
                              
                  GROUP BY A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                  A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Fecha_Nacimiento_Paciente
                  ORDER BY A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente";

  }
  else if($dist_1 != 'TODOS') {
    $dist=$dist_1;
    $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                  A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED1',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED2',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED3',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED4',
                  MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'CRED1MES'
                
                  FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A WHERE
                  ( (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ))OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) ) OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )OR 
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )OR
                  (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )) AND
                  (anio='2021' and Fecha_Nacimiento_Paciente>= '2021-$mes2-01')
                  AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                  GROUP BY A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                  A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Fecha_Nacimiento_Paciente
                  ORDER BY A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente";
  }

        $params = array(); 
        $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta2 = sqlsrv_query($conn, $resultado, $params, $options);
        $row_cnt = sqlsrv_num_rows($consulta2);
  }
?>