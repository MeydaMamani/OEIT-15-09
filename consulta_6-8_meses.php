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
                $resultado = "SELECT distinct(Numero_Documento_Paciente), 'PREMATURO' AS PREMATURO
                        INTO bdhis_minsa_externo.dbo.PREMATURO
                    from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                    where anio='2021' and codigo_item in ('P0711','P0712','P0713','P073')";

                $resultado2 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.NOMBRE_EESS, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                                pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                                                                        WHEN pn.NUM_DNI IS NOT NULL
                                                                        THEN pn.NUM_DNI
                                                                        ELSE pn.NUM_CNV
                                                                    END,
                                CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_MADRE,' ', pn.NOMBRE_NINO) AS APELLIDOS_NOMBRES,
                                pn.TIPO_SEGURO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN
                                        into BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR4
                                from NOMINAL_PADRON_NOMINAL AS pn
                                where YEAR (DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='$mes'
                                and mes='2021$mes'";

                $resultado3 = "SELECT Numero_Documento_Paciente, Fecha_Atencion, Tipo_Doc_Paciente, Edad_Dias_Paciente_FechaAtencion
                                    INTO BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND (Fecha_Atencion >= CONVERT(DATE, DATEADD(dd, -110, CONCAT('2021$mes', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/2021'),0)))))) 
                                     and Fecha_Atencion<=CONCAT('2021-$mes-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/2021'),0)))))
                                AND Tipo_Diagnostico='D' AND Codigo_Item IN ('Z298','99199.17') AND VALOR_LAB IN ('SF1','PO1','P01') AND EDAD_REG in ('3','4') AND Tipo_Edad='M'
                                ORDER BY Fecha_Atencion;
                                with c as
                                (select numero_documento_paciente, ROW_NUMBER() over(partition by numero_documento_paciente order by numero_documento_paciente) as duplicado
                                from BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4)
                                delete from c
                                where duplicado >1";
                $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.NOMBRE_EESS AS EESS_ATENCION, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                                pn.FECHA_NACIMIENTO_NINO, PN.DOCUMENTO, PN.APELLIDOS_NOMBRES, P.PREMATURO,
                                S.Edad_Dias_Paciente_FechaAtencion AS SUPLEMENTADO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                                from PADRON_EVALUAR4 AS pn
                                LEFT JOIN PREMATURO AS P
                                ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                                LEFT JOIN SUPLEMENTADO4 AS S
                                ON PN.DOCUMENTO=S.Numero_Documento_Paciente
                                DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO
                                DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR4
                                DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4";
        }
        else{
            $dist=$dist_1;
            ECHO '-------------------', $red;
            ECHO '-------------------', $dist;
            $resultado = "SELECT distinct(Numero_Documento_Paciente), 'PREMATURO' AS PREMATURO
                            INTO bdhis_minsa_externo.dbo.PREMATURO
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where anio='2021' and codigo_item in ('P0711','P0712','P0713','P073')";
            $resultado2 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.NOMBRE_EESS, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                            pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                                                                    WHEN pn.NUM_DNI IS NOT NULL
                                                                    THEN pn.NUM_DNI
                                                                    ELSE pn.NUM_CNV
                                                                END,
                            CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_MADRE,' ', pn.NOMBRE_NINO) AS APELLIDOS_NOMBRES,
                            pn.TIPO_SEGURO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN
                                    into BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR4
                            from NOMINAL_PADRON_NOMINAL AS pn
                            where YEAR (DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='$mes'
                            and mes='2021$mes'";

            $resultado3 = "SELECT Numero_Documento_Paciente, Fecha_Atencion, Tipo_Doc_Paciente, Edad_Dias_Paciente_FechaAtencion
                                INTO BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE ANIO='2021' AND (Fecha_Atencion >= CONVERT(DATE, DATEADD(dd, -110, CONCAT('2021$mes', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/2021'),0)))))) 
                                and Fecha_Atencion<=CONCAT('2021-$mes-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/2021'),0)))))
                            AND Tipo_Diagnostico='D' AND Codigo_Item IN ('Z298','99199.17') AND VALOR_LAB IN ('SF1','PO1','P01') AND EDAD_REG in ('3','4') AND Tipo_Edad='M'
                            ORDER BY Fecha_Atencion;
                            with c as
                            (select numero_documento_paciente, ROW_NUMBER() over(partition by numero_documento_paciente order by numero_documento_paciente) as duplicado
                            from BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4)
                            delete from c
                            where duplicado >1";
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.NOMBRE_EESS AS EESS_ATENCION, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                            pn.FECHA_NACIMIENTO_NINO, PN.DOCUMENTO, PN.APELLIDOS_NOMBRES, P.PREMATURO,
                            S.Edad_Dias_Paciente_FechaAtencion AS SUPLEMENTADO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                            from PADRON_EVALUAR4 AS pn
                            LEFT JOIN PREMATURO AS P
                            ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                            LEFT JOIN SUPLEMENTADO4 AS S
                            ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red' AND pn.NOMBRE_DIST='$dist'

                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR4
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO4";
        }


        $consulta2 = sqlsrv_query($conn, $resultado);
        $consulta3 = sqlsrv_query($conn2, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);
        $consulta5 = sqlsrv_query($conn4, $resultado4);

          ?>

        <div class="text-center mb-4">
            <h2 class="text-primary">BIENVENIDO</h2>
        </div>  
        <div class="col-11 mb-4 text-end">
            <button type="submit" name="Limpiar" class="btn btn-secondary 1btn_buscar" onclick="location.href='6-8_meses.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
        </div>
        <div class="row">
            <div class="col-1"></div>
            <div class="col-10 table-responsive">
                <table class="table table-hover table-bordered text-center table-responsive">
                    <thead class="bg-primary text-light">
                        <tr>
                            <th class="align-middle">#</th>
                            <th class="align-middle">PROVINCIA</th>
                            <th class="align-middle">DISTRITO</th>
                            <th class="align-middle">ESTABLECIMIENTO</th>
                            <th class="align-middle">MENOR VISITADO</th> 
                            <th class="align-middle">MENOR ENCONTRADO</th> 
                            <th class="align-middle">DNI</th>
                            <th class="align-middle">NUM CNV</th>
                            <th class="align-middle">FECHA NACIMIENTO</th>
                            <th class="align-middle">DOCUMENTO</th>
                            <th class="align-middle">APELLIDOS Y NOMBRES</th>
                            <th class="align-middle">PREMATURO</th> 
                            <th class="align-middle">SUPLEMENTADO</th>
                            <th class="align-middle">ULTIMA ATE PN</th>
                            <th class="align-middle">TIPO SEGURO</th> 
                        </tr>
                    </thead>
                    <?php  
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta5)){  
                        // CAMBIO AQUI
                        if(is_null ($consulta['NOMBRE_PROV']) ){
                            $newdate3 = '  -'; }
                            else{
                        $newdate3 = $consulta['NOMBRE_PROV'] ;}
            
                        if(is_null ($consulta['NOMBRE_DIST']) ){
                            $newdate4 = '  -'; }
                            else{
                        $newdate4 = $consulta['NOMBRE_DIST'];}
            
                        if(is_null ($consulta['EESS_ATENCION']) ){
                            $newdate5 = '  -'; }
                            else{
                        $newdate5 = $consulta['EESS_ATENCION'];}
            
                        if(is_null ($consulta['MENOR_VISITADO']) ){
                            $newdate6 = '  -'; }
                            else{
                        $newdate6 = $consulta['MENOR_VISITADO'];}
            
                        if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                            $newdate7 = '  -'; }
                            else{
                        $newdate7 = $consulta['MENOR_ENCONTRADO'];}
            
                        if(is_null ($consulta['NUM_DNI']) ){
                            $newdate8 = '  -'; }
                            else{
                        $newdate8 = $consulta['NUM_DNI'];}

                        if(is_null ($consulta['NUM_CNV']) ){
                            $newdate9 = '  -'; }
                            else{
                        $newdate9 = $consulta['NUM_CNV'];}
            
                        if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                            $newdate10 = '  -'; }
                            else{
                        $newdate10 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
            
                        if(is_null ($consulta['DOCUMENTO']) ){
                            $newdate11 = '  -'; }
                            else{ 
                            $newdate11 = $consulta['DOCUMENTO'];}
                                    
                        if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                            $newdate12 = '  -'; }
                            else{
                            $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
            
                        if(is_null ($consulta['PREMATURO']) ){
                            $newdate13 = '  -'; }
                            else{
                            $newdate13 = $consulta['PREMATURO'];}
            
                        if(is_null ($consulta['SUPLEMENTADO']) ){
                            $newdate14 = '  -'; }
                            else{
                            $newdate14 = $consulta['SUPLEMENTADO'];}
            
                        if(is_null ($consulta['ULTIMA_ATE_PN']) ){
                            $newdate15 = '  -'; }
                            else{
                            $newdate15 = $consulta['ULTIMA_ATE_PN'];}
            
                        if(is_null ($consulta['TIPO_SEGURO']) ){
                            $newdate16 = '  -'; }
                            else{
                            $newdate16 = $consulta['TIPO_SEGURO'];}

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