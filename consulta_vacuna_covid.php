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

        $doc = $_POST['doc'];
        $resultado = "SELECT * FROM VACUNADOS WHERE num_doc = '$doc';";


        $consulta2 = sqlsrv_query($conn, $resultado);
        $consulta = sqlsrv_fetch_array($consulta2);
          echo "<br>";
          echo "<font color=\"white\">BIENVENIDO</font>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          echo "<br>";
          if (isset($consulta['NUM_DOC'])) {
             ?>
<div class="container">
           <br>
           <br>
           <br>
           <table class="tabla" text="#FCFAFA" background="red" width="50%" border="1" bordercolor="#335DFF" >
         <thead>
            <tr>
              <th>NUMERO DOCUMENTO</th>
              <th>FAB VACUNA</th>
              <th>PRIMERA DOSIS</th>
              <th>FAB VACUNA</th>
              <th>SEGUNDA DOSIS</th>
              <th>DEPARTAMENTO</th>
            </tr>
          </thead>
          <tbody>
      <tr>
        <th><?php echo $consulta['NUM_DOC']; ?></th>
        <th><?php echo $consulta['PRIMERA_FAB']; ?></th>
        <th><?php echo $consulta['PRIMERA']; ?></th>
        <th><?php echo $consulta['SEGUNDA_FAB']; ?></th>
        <th><?php echo $consulta['SEGUNDA']; ?></th>
        <th><?php echo $consulta['PRIMERA_DEP']; echo"/"; echo $consulta['SEGUNDA_DEP']; ?></th>
      </tr>
      <?php    
        } 
        else{
          echo "<br>";
          echo "<br>";
          ?>
          <table class="tabla" text="#FCFAFA" background="red" width="50%" border="1" bordercolor="#335DFF" >
         <thead>
            <tr>
              <th><?php echo $doc; ?></th>
            </tr>
          </thead>
          <tbody>
      <tr>
        <th>USTED NO CUENTA CON NINGUNA DOSIS DE LA VACUNA</th>
      </tr>
  <?php
      }  ;
 
        include("cerrar.php");
    ?>
    </tbody>
    </table>
    </div>
     <input type="submit" name="Limpiar" class="btn_buscar" value="Cancelar" onclick="location.href='vacuna_covid.php';">
    </center>
    <?php } ?>
</section>