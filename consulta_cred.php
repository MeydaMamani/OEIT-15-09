<?php 

require('abrir.php');
require('abrir2.php');
require('abrir3.php');
require('abrir4.php');
   
if (isset($_POST['Buscar'])) {
global $conex;
//  header('Content-Type: text/html; charset=ISO-8859-1');
?>
<!DOCTYPE HTML>
<html lang="es">
<head> <!--mi Cabecera, icono, titulo y meta-->
    <meta charset="utf-8"/>
    <title>OEIT - DIRESA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
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
              <img class="logo2" src="./img/oeit.png">
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
  <br>
  <br>
  <br>
  <br>

    <?php
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
        
        if (strlen($mes) == 1){
            echo '--------------', ('0'.$mes);
            $mes = '0'.$mes;
        }
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
            $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                            A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED 1',
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
                            (anio='2021' and Fecha_Nacimiento_Paciente>= '2021-$mes-01')
                              
                            GROUP BY A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                            A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Fecha_Nacimiento_Paciente
                            ORDER BY A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente";
		}
        else{
            $dist=$dist_1;
            ECHO '-------------------', $red;
            ECHO '---', $dist;
            $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                            A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90585' )THEN A.Fecha_Atencion ELSE NULL END)'BCG',
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and Tipo_Diagnostico='D' AND Codigo_Item='90744' )THEN A.Fecha_Atencion ELSE NULL END)'HVB',
                            MAX(CASE WHEN (Anio_Actual_Paciente='0' and Mes_Actual_Paciente='0' and Dia_Actual_Paciente<=11 and ((Codigo_Item='Z001' AND Valor_Lab='1' AND Tipo_Diagnostico='D')or (Codigo_Item='99381.01' AND Valor_Lab='1' AND Tipo_Diagnostico='D') ) )THEN A.Fecha_Atencion ELSE NULL END)'CRED 1',
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
                            (anio='2021' and Fecha_Nacimiento_Paciente>= '2021-$mes-01')
                            AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist'
                              
                            GROUP BY A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                            A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Fecha_Nacimiento_Paciente
                            ORDER BY A.Distrito_Establecimiento DESC, A.Nombre_Establecimiento, Numero_Documento_Paciente";            
		}

        $consulta2 = sqlsrv_query($conn, $resultado);
        ?>

        <div class="text-center mb-4">
            <h2 class="text-primary">BIENVENIDO</h2>
        </div>  
        <div class="col-11 mb-4 text-end">
            <button type="submit" name="Limpiar" class="btn btn-secondary 1btn_buscar" onclick="location.href='cred.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 table-responsive">
                <table class="table table-hover table-bordered text-center table-responsive">
                    <thead class="text-light" style="background: #538fbc;">
                        <tr>
                            <th class="align-middle">#</th>
                            <th class="align-middle">PROVINCIA ESTABLECIMIENTO</th>
                            <th class="align-middle">DISTRITO ESTABLECIMIENTO</th>
                            <th class="align-middle">NOMBRE ESTABLECIMIENTO</th> 
                            <th class="align-middle">TIPO DOCUMENTO PACIENTE</th>
                            <th class="align-middle">N° DOCUMENTO PACIENTE</th>
                            <th class="align-middle">FECHA NACIMIENTO PACIENTE</th>
                            <th class="align-middle">BCG</th>
							<th class="align-middle">HVB</th>
                            <th class="align-middle">CRED 1</th>
                            <th class="align-middle">CRED 2</th> 
                            <th class="align-middle">CRED 3</th>
                            <th class="align-middle">CRED 4</th>
                            <th class="align-middle">CRED1MES</th>
                        </tr>
                    </thead>
                    <?php  
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){  
                        // CAMBIO AQUI
						// $hola = $consulta['85018'];
                        if(is_null ($consulta['Provincia_Establecimiento']) ){
                            $newdate3 = '  -'; }
                            else{
                        $newdate3 = $consulta['Provincia_Establecimiento'] ;}
            
                        if(is_null ($consulta['Distrito_Establecimiento']) ){
                            $newdate4 = '  -'; }
                            else{
                        $newdate4 = $consulta['Distrito_Establecimiento'];}
            
                        if(is_null ($consulta['Nombre_Establecimiento']) ){
                            $newdate5 = '  -'; }
                            else{
                        $newdate5 = $consulta['Nombre_Establecimiento'];}
            
                        if(is_null ($consulta['Abrev_Tipo_Doc_Paciente']) ){
                            $newdate6 = '  -'; }
                            else{
                        $newdate6 = $consulta['Abrev_Tipo_Doc_Paciente'];}
            
                        if(is_null ($consulta['Numero_Documento_Paciente']) ){
                            $newdate7 = '  -'; }
                            else{
                        $newdate7 = $consulta['Numero_Documento_Paciente'];}
            
                        if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){
                            $newdate8 = '  -'; }
                            else{
                        $newdate8 = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');}
           
                        if(is_null ($consulta['BCG']) ){
                            $newdate9 = '  -'; }
                            else{
                        $newdate9 = $consulta['BCG'] -> format('d/m/y');}
            
                        if(is_null ($consulta['HVB']) ){
                            $newdate10 = '  -'; }
                            else{ 
                            $newdate10 = $consulta['HVB']-> format('d/m/y');}
                                    
                        if(is_null ($consulta['CRED 1']) ){
                            $newdate11 = '  -'; }
                            else{
                            $newdate11 = $consulta['CRED 1'] -> format('d/m/y');}
            
                        if(is_null ($consulta['CRED2']) ){
                            $newdate12 = '  -'; }
                            else{
                            $newdate12 = $consulta['CRED2'] -> format('d/m/y');}
            
                        if(is_null ($consulta['CRED3']) ){
                            $newdate13 = '  -'; }
                            else{
                            $newdate13 = $consulta['CRED3'] -> format('d/m/y');}
            
                        if(is_null ($consulta['CRED4']) ){
                            $newdate14 = '  -'; }
                            else{
                            $newdate14 = $consulta['CRED4'] -> format('d/m/y');}
            
                        if(is_null ($consulta['CRED1MES']) ){
                            $newdate15 = '  -'; }
                            else{
                            $newdate15 = $consulta['CRED1MES'] -> format('d/m/y');}						
                        ?>
                    <tbody>
                        <tr>
                            <td class="align-middle"><?php echo $i++; ?></td>
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