<?php 

require('abrir.php');
require('abrir2.php');
require('abrir3.php');
   
if (isset($_POST['Buscar'])) {
global $conex;
//  header('Content-Type: text/html; charset=ISO-8859-1');
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

    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
  	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
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
              <img class="logo2" src="./IMG/oeit.png">
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
  <br>
  <br>
  <br>
  <br>

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

        $resultado = "
                      INSERT INTO  padron_nino_web_cnv
                      SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                        apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                      FROM nominal_padron_nominal
                      WHERE year(fecha_nacimiento_nino)='2021' AND MES='202108';
                      with c as
                      (
                      select num_cnv, nombre_dist, ROW_NUMBER() 
                      over(partition by num_cnv order by num_cnv) as duplicado
                      from dbo.padron_nino_web_cnv
                        )
                        delete  from c
                        where duplicado >1;";

         $resultado2= "SELECT C.Periodo AS PERIODO, DATEADD(DAY,59,C.FECNACIDO) MIDE, C.SECTOR AS SECTOR, C.Provnacido AS PROVNACIDO, C.Distnacido AS DISTNACIDO,C.Establecimiento AS ESTABLECIMIENTO, 
                      p.MENOR_ENCONTRADO AS MENCONTRADO, C.FECNACIDO AS FECNACIDO, C.NUMCNV AS NUMCNV,C.PESO AS CPESO, C.SEMANAGESTACION AS SEMAGES, 'SI' PREMATURO,
                      T.Fecha_Atencion AS SUPLEMENTADO,T.Tipo_Doc_Paciente AS TIPODOC, P.TIPO_SEGURO AS TIPOSEG,            p.NOMBRE_EESS AS SE_ATIENDE
                         
                      from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_web_cnv p
                      ON  C.NUMCNV=p.num_cnv
                      --cruzando suple
                      AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                        AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' AND  ((C.Provnacido IN('$red') OR C.Depnacido = '$redt') AND ((C.Distnacido IN ('$dist') OR C.Provnacido='$red') OR C.Depnacido = '$redt') ) 
                      LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                      on c.Numcnv=t.Numero_Documento_Paciente
                       AND edad_reg='1' and t.Tipo_Edad ='M' 

                      delete  from  BD_PADRON_NOMINAL.DBO.padron_nino_web_cnv;";
                    }
          else{
                  $dist=$dist_1;
                  $resultado = "
                      INSERT INTO  padron_nino_web_cnv 
                      SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                        apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                      FROM nominal_padron_nominal
                      WHERE year(fecha_nacimiento_nino)='2021' AND MES='202108';
                      with c as
                      (
                      select num_cnv, nombre_dist, ROW_NUMBER() 
                      over(partition by num_cnv order by num_cnv) as duplicado
                      from dbo.padron_nino_web_cnv
                        )
                        delete  from c
                        where duplicado >1;";

         $resultado2= "SELECT C.Periodo AS PERIODO, DATEADD(DAY,59,C.FECNACIDO) MIDE, C.SECTOR AS SECTOR, C.Provnacido AS PROVNACIDO, C.Distnacido AS DISTNACIDO,C.Establecimiento AS ESTABLECIMIENTO, 
                      p.MENOR_ENCONTRADO AS MENCONTRADO, C.FECNACIDO AS FECNACIDO, C.NUMCNV AS NUMCNV,C.PESO AS CPESO, C.SEMANAGESTACION AS SEMAGES, 'SI' PREMATURO,
                      T.Fecha_Atencion AS SUPLEMENTADO,T.Tipo_Doc_Paciente AS TIPODOC, P.TIPO_SEGURO AS TIPOSEG,            p.NOMBRE_EESS AS SE_ATIENDE
                         
                      from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_web_cnv p
                      ON  C.NUMCNV=p.num_cnv
                      --cruzando suple
                      AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                        AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' AND  ((C.Provnacido IN('$red') OR C.Depnacido = '$redt') AND ((C.Distnacido IN ('$dist') AND C.Provnacido='$red') OR C.Depnacido = '$redt') ) 
                      LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                      on c.Numcnv=t.Numero_Documento_Paciente
                       AND edad_reg='1' and t.Tipo_Edad ='M' 

                      delete  from  BD_PADRON_NOMINAL.DBO.padron_nino_web_cnv;";
                    }


        $consulta2 = sqlsrv_query($conn2, $resultado);
        $consulta3 = sqlsrv_query($conn3, $resultado2);

          ?>

        <div class="text-center mb-4">
            <h2 class="text-primary">BIENVENIDO</h2>
        </div>  
        <div class="col-11 mb-4 text-end">
            <button type="submit" name="Limpiar" class="btn btn-secondary 1btn_buscar" onclick="location.href='prematuros.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th class="align-middle">SECTOR</th>
                            <th class="align-middle">PROVINCIA</th>
                            <th class="align-middle">DISTRITO</th>
                            <th class="align-middle">ESTABLECIMIENTO</th>
                            <th class="align-middle">MENOR ENCONTRADO</th> 
                            <th class="align-middle">FECHA NACIDO</th>
                            <th class="align-middle">NUM CNV</th>
                            <th class="align-middle">PESO</th>
                            <th class="align-middle">SEMANA GESTANTE</th>
                            <th class="align-middle">PREMATURO</th> 
                            <th class="align-middle">SUPLEMENTADO</th>
                            <th class="align-middle">TIPO DOC</th>
                            <th class="align-middle">TIPO SEGURO</th> 
                            <th class="align-middle">SE ATIENDE</th>
                        </tr>
                    </thead>
                    <?php  while ($consulta = sqlsrv_fetch_array($consulta3)){  
                        if(is_null ($consulta['PERIODO']) ){
                            $newdate = '  -'; }
                            else{
                        $newdate = $consulta['PERIODO'] -> format('d/m/y');}
            
                        if(is_null ($consulta['MIDE']) ){
                            $newdate2 = '  -'; }
                            else{
                        $newdate2 = $consulta['MIDE'] -> format('d/m/y');}
            
                        if(is_null ($consulta['SECTOR']) ){
                            $newdate3 = '  -'; }
                            else{
                        $newdate3 = $consulta['SECTOR'] ;}
            
                        if(is_null ($consulta['PROVNACIDO']) ){
                            $newdate4 = '  -'; }
                            else{
                        $newdate4 = $consulta['PROVNACIDO'];}
            
                        if(is_null ($consulta['DISTNACIDO']) ){
                            $newdate5 = '  -'; }
                            else{
                        $newdate5 = $consulta['DISTNACIDO'];}
            
                        if(is_null ($consulta['ESTABLECIMIENTO']) ){
                            $newdate6 = '  -'; }
                            else{
                        $newdate6 = $consulta['ESTABLECIMIENTO'];}
            
                        if(is_null ($consulta['MENCONTRADO']) ){
                            $newdate7 = '  -'; }
                            else{
                        $newdate7 = $consulta['MENCONTRADO'];}
            
                        if(is_null ($consulta['FECNACIDO']) ){
                            $newdate8 = '  -'; }
                            else{
                        $newdate8 = $consulta['FECNACIDO'] -> format('d/m/y');}
            
                        if(is_null ($consulta['NUMCNV']) ){
                            $newdate9 = '  -'; }
                            else{
                            $newdate9 = $consulta['NUMCNV'];}
                        
            
                        if(is_null ($consulta['CPESO']) ){
                            $newdate10 = '  -'; }
                            else{ 
                            $newdate10 = $consulta['CPESO'];}
                        
            
                        if(is_null ($consulta['SEMAGES']) ){
                            $newdate11 = '  -'; }
                            else{
                            $newdate11 = $consulta['SEMAGES'];}
            
                        if(is_null ($consulta['PREMATURO']) ){
                            $newdate12 = '  -'; }
                            else{
                            $newdate12 = $consulta['PREMATURO'];}
            
                        if(is_null ($consulta['SUPLEMENTADO']) ){
                            $newdate13 = '  -'; }
                            else{
                            $newdate13 = $consulta['SUPLEMENTADO'] -> format('d/m/y');}
            
                        if(is_null ($consulta['TIPODOC']) ){
                            $newdate14 = '  -'; }
                            else{
                            $newdate14 = $consulta['TIPODOC'];}
            
                        if(is_null ($consulta['TIPOSEG']) ){
                            $newdate15 = '  -'; }
                            else{
                            $newdate15 = $consulta['TIPOSEG'];} 
            
                        if(is_null ($consulta['SE_ATIENDE']) ){
                            $newdate16 = '  -'; }
                            else{
                            $newdate16 = $consulta['SE_ATIENDE'];}?>
                    <tbody>
                        <tr>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo $newdate14; ?></td>
                            <td class="align-middle"><?php echo $newdate15; ?></td>
                            <td class="align-middle"><?php echo $newdate16; ?></td>
                        </tr>
                        
                        <?php
                            ;}
                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
</section>