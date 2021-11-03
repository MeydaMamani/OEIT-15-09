<?php
  require('abrir6.php');

  if (isset($_POST['Buscar'])) {
    global $conex;
    //  header('Content-Type: text/html; charset=ISO-8859-1');
    include('./base.php');

    $doc = $_POST['doc'];
    $resultado = "SELECT * FROM PADRON_18_MAYOR_09_09 WHERE num_doc = '$doc'";
    $consulta2 = sqlsrv_query($conn6, $resultado);
    $consulta = sqlsrv_fetch_array($consulta2);
    
    if (isset($consulta['NUM_DOC'])) {
  ?>
<div class="page-wrapper">
    <div class="container">
      <div class="row mb-4">
        <div class="col-lg-12 text-end">
          <button type="submit" name="Limpiar" class="btn btn-outline-info" onclick="location.href='vacuna_padron.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
        </div>
      </div>
      <div class="row m-3">
		<div class="col-md-2"></div>
        <div class="col-md-8">
            <div class="alert alert-primary" role="alert">
                Perteneces al Padrón de Pasco acérquese a tu punto de vacunación más cercano
            </div>
            <div class="card" style="box-shadow: 10px 10px 4px 0 rgba(0, 0, 0, 20%);">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <img src="./img/profile_woman.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="190">
                            <h4 class="text-secondary">DNI: <?php echo $consulta['NUM_DOC']; ?></h4>
                        </div>
                        <div class="col-md-8">
                            <img src="./img/covid19_1.png" alt="Imagen Covid" width="60" style="float: left;">
                            <p class="img-covid"><b>Padrón Covid-19</b></p>
                            <div class="profiletimeline1">
                                <div class="sl-item">
                                    <div class="sl-left">
                                        <div class="circle1"><h4><span class="fa fa-check"></span></h4></div>
                                    </div> 
                                    <div class="sl-right">
                                        <p><b>Provincia: </b><?php echo $consulta['PROVINCIA']; ?></p>
                                        <p><b>Distrito: </b><?php echo $consulta['DISTRITO']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="sl-item">
                                    <div class="sl-left">
                                        <div class="circle1"><h4><span class="fa fa-check"></span></h4></div>
                                    </div>
                                    <div class="sl-right">
                                        <p><b>Grupo Edad: </b><?php echo $consulta['GRUPO_EDAD']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
      <?php
        } else { ?>
        <div class="page-wrapper">
            <div class="container">
              <div class="col-md-12 text-end">
                <button type="submit" name="Limpiar" class="btn btn-outline-info" onclick="location.href='vacuna_padron.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div><br>
              <div class="alert alert-danger" role="alert">
                USTED NO SE ENCUENTRA EN EL PADRON REGIONAL, ACERQUESE A SU ESTABLECIMIENTO DE SALUD MAS CERCANO PARA UNA REEVALUACION Y SER CONSIDERADO EN NUESTRA BASE DE DATOS REGIONAL
              </div>
            </div>
        </div>    
          <?php } 
        
          sqlsrv_close($conn6);
      ?>
    </div>
  <?php } ?>

 <script src="./js/records_menu.js"></script>
</body>
</html>