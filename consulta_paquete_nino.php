<?php 

require ('abrir.php');
   
if (isset($_POST['Buscar'])) {
global $conex;
 header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE HTML>
<html lang="es">
<head> <!--mi Cabecera, icono, titulo y meta-->
    <meta charset="UTF-8">
    <title>OEIT - DIRESA</title>
    <meta name="description" content="PAGINA DIRESA PASCO">
    <meta name="keywords" content="OEIT DIRESA-PASCO">
    <link rel="shortcut icon" href="./img/logo.jpg">
    <link rel="stylesheet" type="text/css" href="./inicio.css" media="screen, handheld">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" media="(max-width: 1100px)" href="max-width-810.css" />
    <link rel="stylesheet" media="(max-width: 700px)" href="max-width-700.css" />
    <link rel="stylesheet" media="(max-width: 612px)" href="max-width-612.css" />
    <link rel="stylesheet" media="(max-width: 450px)" href="max-width-450.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
</head>
<body>
<header>
  <div class="cajageneral cajaheader">
    <div class="cajavarios">
      <div class="cajageneral3">  <!--Logo y Otros-->
        <div class="cajacolumna">
          <div class="cajacontiene1">
            <div class="cajalogo">
              <img class="logo" src="./img/diresa1.jpeg">
            </div>
            <div class="cajanombre">
              <span class="nomlogo">DIRESA-PASCO</span>
            </div>
          </div>
        </div>
        <div class="cajacolumna">
          <div class="cajacontiene2">
            <div class="cajalogo2">
              <img class="logo2" src="./img/gorepa1.png">
            </div>
          </div><!--Caja Vacia solo para colocar botones de ingreso u otros-->
        </div>
      </div>
    </div>
  </div>
</header>
<main class="menu-content">
  <nav class="content-menu">

      <label for="toggle" class="res-menu">
          <img src="img/menu.png" alt="menu">
      </label>
      <input type="checkbox" id="toggle">
      <div class="menu">
          <ul class="first-deslice">
              <li class="first-iten"><a class="first-link" href="Inicio.php">INICIO</a></li>
              
              <li class="first-iten"><a class="first-link">COVID-19</a>
                  <ul class="second-deslice">
                      <li class="second-iten"><a class="second-link" href="vacuna_covid.php">CONSULTA TU VACUNACION</a></li>
                      <li class="second-iten"><a class="second-link" href="http://200.10.69.226/consultas/inicio_padron.php">CONSULTA PADRON</a></li>
                      <li class="second-iten"><a class="second-link" href="#">DESCARGUE SU CONSENTIMIENTO</a></li>
                      <li class="second-iten"><a class="second-link" href="#">SISCOVID</a></li>
                  </ul>
              </li>
              <li class="first-iten"><a class="first-link">GESTANTE</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="bateria_completa.php">BATERIA COMPLETA</a></li>
                    
                </ul>
              </li>
              <li class="first-iten"><a class="first-link">PACIENTE</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="detalle_paciente.php">DETALLE PACIENTE</a></li>
                    <li class="second-iten"><a class="second-link" href="#"></a></li>
                </ul>
              </li>
              <li class="first-iten"><a class="first-link" href="#">NIÑO</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="prematuros.php">NIÑOS PREMATUROS</a></li>
                    <li class="second-iten"><a class="second-link" href="4_meses.php">4 MESES</a></li>
                    <li class="second-iten"><a class="second-link" href="6-8_meses.php">6 - 8 MESES</a></li>
                </ul>
              </li>
          </ul>
      </div>
  </nav>
</main>
<section class="cajaslider"><!--slider*/-->
 <center >
      <?php 

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if ($red_1 == 1) {
          $red = 'DANIEL ALCIDES CARRION';
          $redt = '';
        }
        elseif ($red_1 == 2) {
          $red = 'OXAPAMPA';
          $redt = '';
        }
        elseif ($red_1 == 3) {
          $red = 'PASCO';
          $redt = '';
        }
        elseif ($red_1 == 4) {
          $redt = 'PASCO';
          $red = '';
        }
        
           
        if ($dist_1 == 'TODOS') {
          $dist = '';
          $resultado = "SELECT
A.Provincia_Establecimiento AS PROVINCIA,
A.Distrito_Establecimiento AS DISTRITO,
A.Nombre_Establecimiento AS EESS,
A.Abrev_Tipo_Doc_Paciente AS TIPO_DOC,
A.Numero_Documento_Paciente AS NUM_DOC,
A.Fecha_Nacimiento_Paciente AS FECHA_NACIMIENTO,
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED1',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED2',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED3',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actuasl_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED4',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'CRED1MES'

FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
       WHERE
          ( (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' ) OR
      (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' ) OR
      (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ))OR 
            (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) ) OR
              (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )OR 
              (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )OR
        (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )) AND
        (anio='2021' and month(Fecha_Nacimiento_Paciente)= '$mes' AND (Provincia_Establecimiento IN('$red') OR Departamento_Establecimiento = '$redt') AND ((Distrito_Establecimiento IN ('$dist') OR Provincia_Establecimiento='$red') OR Departamento_Establecimiento = '$redt'))
        
GROUP BY
A.Provincia_Establecimiento,
A.Abrev_Tipo_Doc_Paciente,
A.Numero_Documento_Paciente,
A.Distrito_Establecimiento,
A.Nombre_Establecimiento,
A.Fecha_Nacimiento_Paciente
ORDER BY
A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente;";
        }



        else{
          $dist=$dist_1;
          $resultado = "SELECT
A.Provincia_Establecimiento AS PROVINCIA,
A.Distrito_Establecimiento AS DISTRITO,
A.Nombre_Establecimiento AS EESS,
A.Abrev_Tipo_Doc_Paciente AS TIPO_DOC,
A.Numero_Documento_Paciente AS NUM_DOC,
A.Fecha_Nacimiento_Paciente AS FECHA_NACIMIENTO,
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED1',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED2',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED3',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED4',
MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'CRED1MES'

FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
       WHERE
          ( (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' ) OR
      (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' ) OR
      (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ))OR 
            (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=5 AND Dia_Actual_Paciente<=14 ) and((Codigo_Item='Z001' AND Valor_Lab='2' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='2' AND Tipo_Diagnostico='D') ) ) OR
              (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=24 ) and ((Codigo_Item='Z001' AND Valor_Lab='3' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='3' AND Tipo_Diagnostico='D') ) )OR 
              (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and (Dia_Actual_Paciente>=10 AND Dia_Actual_Paciente<=29) and ((Codigo_Item='Z001' AND Valor_Lab='4' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='4' AND Tipo_Diagnostico='D') ) )OR
        (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='1' and Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D' )) AND
        (anio='2021' and month(Fecha_Nacimiento_Paciente)= '$mes' AND (Provincia_Establecimiento IN('$red') OR Departamento_Establecimiento = '$redt') AND ((Distrito_Establecimiento IN ('$dist') AND Provincia_Establecimiento='$red') OR Departamento_Establecimiento = '$redt'))
       
        
GROUP BY
A.Provincia_Establecimiento,
A.Abrev_Tipo_Doc_Paciente,
A.Numero_Documento_Paciente,
A.Distrito_Establecimiento,
A.Nombre_Establecimiento,
A.Fecha_Nacimiento_Paciente
ORDER BY
A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente;";
        }
        
    $params = array();
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $consulta2 = sqlsrv_query($conn, $resultado, $params, $options);
        $row_cnt = sqlsrv_num_rows($consulta2);
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "CANTIDAD DE REGISTRO:";
          echo $row_cnt;
          ?>
          <div class="container">
            <br>
           <table class="tabla" text="#FCFAFA" background="red" width="50%" border="1" bordercolor="#335DFF" >
         <thead>
            <tr>
              <th>PROVINCIA</th>
              <th>DISTRITO</th>
              <th>IPRESS</th>
              <th>TIPO DOC</th>
              <th>DOCUMENTO</th>
              <th>FECHA NACIMIENTO PACIENTE</th>
              <th>BCG</th>
              <th>HVB</th>
              <th>CRED 1</th>
              <th>CRED 2</th>
              <th>CRED 3</th>
              <th>CRED 4</th>
              <th>CRED 1 MES</th>
            </tr>
          </thead>
                  <?php  while ($consulta = sqlsrv_fetch_array($consulta2)){  
                $newdate = $consulta['FECHA_NACIMIENTO'] -> format('d/m/y');

                 if(is_null ($consulta['BCG']) ){
                    $newdate2 = '  -'; }
                  else{
                $newdate2 = $consulta['BCG'] -> format('d/m/y');}

                if(is_null ($consulta['HVB']) ){
                    $newdate3 = '  -'; }
                  else{
                $newdate3 = $consulta['HVB'] -> format('d/m/y');}

                if(is_null ($consulta['CRED1']) ){
                    $newdate4 = '  -'; }
                  else{
                $newdate4 = $consulta['CRED1'] -> format('d/m/y');}

                if(is_null ($consulta['CRED2']) ){
                    $newdate5 = '  -'; }
                  else{
                $newdate5 = $consulta['CRED2'] -> format('d/m/y');}

                if(is_null ($consulta['CRED3']) ){
                    $newdate6 = '  -'; }
                  else{
                $newdate6 = $consulta['CRED3'] -> format('d/m/y');}

                if(is_null ($consulta['CRED4']) ){
                    $newdate7 = '  -'; }
                  else{
                $newdate7 = $consulta['CRED4'] -> format('d/m/y');}

                if(is_null ($consulta['CRED1MES']) ){
                    $newdate8 = '  -'; }
                  else{
                $newdate8 = $consulta['CRED1MES'] -> format('d/m/y');}

                
                ?>
          <tbody>
      <tr>
        <th><?php echo $consulta['PROVINCIA']; ?></th>
        <td><?php echo $consulta['DISTRITO']; ?></td>
        <td><?php echo $consulta['EESS']; ?></td>
        <td><?php echo $consulta['TIPO_DOC']; ?></td>
        <td><?php echo $consulta['NUM_DOC']; ?></td>
        <td><?php echo $newdate; ?></td>
        <td><?php echo $newdate2; ?></td>
        <td><?php echo $newdate3; ?></td>
        <td><?php echo $newdate4; ?></td>
        <td><?php echo $newdate5; ?></td>
        <td><?php echo $newdate6; ?></td>
        <td><?php echo $newdate7; ?></td>
        <td><?php echo $newdate8; ?></td>
      </tr>

  <?php
        ;}
 
        include("cerrar.php");
    ?>
    </tbody>
    </table>
    </div>
     <input type="submit" name="Limpiar" class="btn_buscar" value="Cancelar" onclick="location.href='paquete_nino.php';">
    </center>
</section>
<?php } ?>