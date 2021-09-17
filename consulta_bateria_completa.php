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
    <link rel="shortcut icon" href="./IMG/logo.jpg">
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
              <img class="logo" src="./IMG/diresa1.jpeg">
            </div>
            <div class="cajanombre">
              <span class="nomlogo">DIRESA-PASCO</span>
            </div>
          </div>
        </div>
        <div class="cajacolumna">
          <div class="cajacontiene2">
            <div class="cajalogo2">
              <img class="logo2" src="./IMG/gorepa1.png">
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
          <img src="IMG/menu.png" alt="menu">
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
          $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
    Abrev_Tipo_Doc_Paciente TIPO_DOC,
    Numero_Documento_Paciente DOCUMENTO,
        Fecha_Nacimiento_Paciente,  
     GES_CAPT_OPO CAPTADA,EDAD_CAPTADA,TMZ_ANEMIA ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF
    
  FROM (

        SELECT
        A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
        A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente, 

    Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591','Z3492','Z3493','Z3592','Z3593') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
    Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591','Z3492','Z3493','Z3592','Z3593') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
    Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
    Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
    Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
    Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
    Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
  Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO'
         
        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
   WHERE
        (anio in ('2021') and Genero='f' AND (Provincia_Establecimiento IN('$red') OR Departamento_Establecimiento = '$redt') AND ((Distrito_Establecimiento IN ('$dist') OR Provincia_Establecimiento='$red') OR Departamento_Establecimiento = '$redt') AND mes = '$mes' ) 

        GROUP BY
        Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
        Numero_Documento_Paciente, Fecha_Nacimiento_Paciente
    ) b
    where GES_CAPT_OPO is not null;";
        }
        
        else{
          $dist=$dist_1;
          $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
    Abrev_Tipo_Doc_Paciente TIPO_DOC,
    Numero_Documento_Paciente DOCUMENTO,
        Fecha_Nacimiento_Paciente,  
     GES_CAPT_OPO CAPTADA, EDAD_CAPTADA,TMZ_ANEMIA ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF
    
  FROM (

        SELECT
        A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
        A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente, 

    Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591','Z3492','Z3493','Z3592','Z3593') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
    Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591','Z3492','Z3493','Z3592','Z3593') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
    Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
    Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
    Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
    Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
    Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
  Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO'
         
        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
   WHERE
        (anio in ('2021') and Genero='f' AND (Provincia_Establecimiento IN('$red') OR Departamento_Establecimiento = '$redt') AND ((Distrito_Establecimiento IN ('$dist') AND Provincia_Establecimiento='$red') OR Departamento_Establecimiento = '$redt') AND mes = '$mes' ) 

        GROUP BY
        Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
        Numero_Documento_Paciente, Fecha_Nacimiento_Paciente
    ) b
    where GES_CAPT_OPO is not null;";
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
              <th>CAPTADA</th>
              <th>EDAD CAPTADA</th>
              <th>TMZ ANEMIA</th>
              <th>SIFILIS</th>
              <th>VIH</th>
              <th>BACTERIURIA</th>
              <th>TMZ VIF</th>
              <th>RESULTADO</th>
            </tr>
          </thead>
                  <?php  while ($consulta = sqlsrv_fetch_array($consulta2)){  
                $newdate = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');
                $newdate2 = $consulta['CAPTADA'] -> format('d/m/y');
                if(is_null ($consulta['ANEMIA']) ){
                    $newdate3 = '  -'; }
                  else{
                $newdate3 = $consulta['ANEMIA'] -> format('d/m/y');}

                if(is_null ($consulta['SIFILIS']) ){
                    $newdate4 = '  -'; }
                  else{
                $newdate4 = $consulta['SIFILIS'] -> format('d/m/y');}

                if(is_null ($consulta['VIH']) ){
                    $newdate5 = '  -'; }
                  else{
                $newdate5 = $consulta['VIH'] -> format('d/m/y');}

                if(is_null ($consulta['BACTERIURIA']) ){
                    $newdate6 = '  -'; }
                  else{
                $newdate6 = $consulta['BACTERIURIA'] -> format('d/m/y');}

                if(is_null ($consulta['TMZ_VIF']) ){
                    $newdate7 = '  -'; }
                  else{
                $newdate7 = $consulta['TMZ_VIF'] -> format('d/m/y');}

                if ($consulta['CAPTADA'] = $consulta['ANEMIA'] AND $consulta['CAPTADA'] = $consulta['SIFILIS'] AND $consulta['CAPTADA'] = $consulta['VIH'] AND $consulta['CAPTADA'] = $consulta['BACTERIURIA']) {
                  $resultado = 'CORRECTO';
                } 
                else{
                  $resultado = 'INCORRECTO';
                }
                ?>
          <tbody>
      <tr>
        <th><?php echo $consulta['PROVINCIA']; ?></th>
        <td><?php echo $consulta['DISTRITO']; ?></td>
        <td><?php echo $consulta['IPRESS']; ?></td>
        <td><?php echo $consulta['TIPO_DOC']; ?></td>
        <td><?php echo $consulta['DOCUMENTO']; ?></td>
        <td><?php echo $newdate; ?></td>
        <td><?php echo $newdate2; ?></td>
        <td><?php echo $consulta['EDAD_CAPTADA']; ?></td>
        <td><?php echo $newdate3; ?></td>
        <td><?php echo $newdate4; ?></td>
        <td><?php echo $newdate5; ?></td>
        <td><?php echo $newdate6; ?></td>
        <td><?php echo $newdate7; ?></td>
        <td><?php echo $resultado; ?></td>
      </tr>

  <?php
        ;}
 
        include("cerrar.php");
    ?>
    </tbody>
    </table>
    </div>
     <input type="submit" name="Limpiar" class="btn_buscar" value="Cancelar" onclick="location.href='bateria_completa.php';">
    </center>
</section>
<?php } ?>