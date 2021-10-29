<?php
  require('abrir7.php');

  if (isset($_POST['Buscar'])) {
    global $conex;
    //  header('Content-Type: text/html; charset=ISO-8859-1');
    include('./base.php');
?>
  <?php

  $doc = $_POST['doc'];
  $resultado = "SELECT * FROM VACUNADOS WHERE num_doc = '$doc' AND (PRIMERA_DEP = 'PASCO' or SEGUNDA_DEP = 'PASCO');";

  $consulta2 = sqlsrv_query($conn7, $resultado);
  $consulta = sqlsrv_fetch_array($consulta2);

  if (isset($consulta['NUM_DOC'])) {
  ?>
    <br>
    <div class="container">
      <div class="row mb-4">
        <div class="col-lg-10">
          <h4 class="m-b-30"> INFORMACIÓN - <?php echo $doc; ?></h4>
        </div>
        <div class="col-lg-2 text-end">
          <button type="submit" name="Limpiar" class="btn btn-outline-info btn-sm 1btn_buscar" onclick="location.href='vacuna_covid.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
        </div>
      </div>
      <div class="border border-success">
        <div class="row pt-3">
          <div class="col-4">
            <div class="profiletimeline">
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">N° Documento</label>
                    <p class="font-13"><?php echo $consulta['NUM_DOC']; ?></p>
                  </div>
                </div>
              </div>
              <hr>
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">Departamento</label>
                    <p class="font-13"><?php echo $consulta['PRIMERA_DEP'];
                                        echo "/";
                                        echo $consulta['SEGUNDA_DEP']; ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="profiletimeline">
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">Fabricación Vacuna</label>
                    <p class="font-13"><?php echo utf8_encode($consulta['PRIMERA_FAB']); ?></p>
                  </div>
                </div>
              </div>
              <hr>
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">Fabricación Vacuna</label>
                    <p class="font-13"><?php echo utf8_encode($consulta['SEGUNDA_FAB']); ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-4">
            <div class="profiletimeline">
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">Primera Dosis</label>
                    <p class="font-13"><?php echo $consulta['PRIMERA'] -> format('d/m/y'); ?></p>
                  </div>
                </div>
              </div>
              <hr>
              <div class="sl-item">
                <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                <div class="sl-right">
                  <div>
                    <label class="information-person-text">Segunda Dosis</label>
                    <p class="font-13"><?php echo $consulta['SEGUNDA'] -> format('d/m/y'); ?></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php
      } else { ?>
          <br>
          <div class="container">
            <div class="col-md-12 text-end">
              <button type="submit" name="Limpiar" class="btn btn-outline-info btn-sm 1btn_buscar" onclick="location.href='vacuna_covid.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
            </div><br>
            <div class="alert alert-primary" role="alert">
              Usted no cuenta con nínguna dosis o no se encuentra en el padrón regional de Pasco
            </div>
          </div>
        <?php } ?>
        </div>
      </div>
      <br>
      <?php
        sqlsrv_close($conn7);
      ?>
    </div>
  <?php } ?>