<?php 

require ('abrir.php');
   
if (isset($_POST['Buscar'])) {
global $conex;
//  header('Content-Type: text/html; charset=ISO-8859-1');
 include('./base.php');
?>
<style>
  .profiletimeline {
    position: relative;
    padding-left: 40px;
    margin-right: 10px;
    border-left: 1px solid rgba(120, 130, 140, 0.13);
    margin-left: 30px;
  }
  .profiletimeline .sl-item {
    margin-top: 8px;
    margin-bottom: 15px;
  }
  .profiletimeline .sl-left {
    float: left;
    margin-left: -31px;
    z-index: 1;
    margin-right: 15px;
  }
  .size-icon-information-person{
        max-width: 32px !important;
      margin-left: -20px;  
    }

    .information-person-text {
        font-size: 14px;
        font-weight: 600;
        color: #383838;
    }
</style>
      <?php 
        $doc = $_POST['doc'];
        $resultado = "SELECT t.Provincia_Establecimiento,t.Distrito_Establecimiento,t.Nombre_Establecimiento, t.Tipo_Doc_Paciente,
                      t.Numero_Documento_Paciente,t.Fecha_Nacimiento_Paciente, t.Id_Cita, t.Fecha_Atencion,t.Tipo_Diagnostico, t.Codigo_Item, t.Valor_Lab, t.Descripcion_Item
                      from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t 
                      where Numero_Documento_Paciente='$doc' and anio='2021' and Fecha_Nacimiento_Paciente>='1979-01-01'
                      order by Fecha_Atencion DESC,id_cita;";

              $consulta2 = sqlsrv_query($conn, $resultado);
          ?>
        <br>
        <div class="container">
            <div class="row mb-4">
              <div class="col-lg-10">
                <h4 class="m-b-30"> INFORMACIÓN - <?php echo $doc; ?></h4>
              </div>
              <div class="col-lg-2 text-end">
                <button type="submit" name="Limpiar" class="btn btn-outline-info btn-sm 1btn_buscar" onclick="location.href='detalle_paciente.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <?php  while ($consulta = sqlsrv_fetch_array($consulta2)){  
                $newdate = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');
                $newdate2 = $consulta['Fecha_Atencion'] -> format('d/m/y');?>
            <div class="border border-primary">
              <div class="row pt-3">
                  <div class="col-4">
                    <div class="profiletimeline">
                        <div class="sl-item">
                          <div class="sl-left"><img src="./img/icon-information.png" width="50" alt="user" class="img-circle size-icon-information-person"></div>
                          <div class="sl-right">
                            <div>
                              <label class="information-person-text">Establecimiento</label>
                              <p class="font-13"><?php echo $consulta['Nombre_Establecimiento']; ?></p>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="sl-item">
                          <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                          <div class="sl-right">
                            <div>
                              <label class="information-person-text">Fecha de Atención</label>
                              <p class="font-13"><?php echo $newdate2; ?></p>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="sl-item">
                          <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                          <div class="sl-right">
                            <div>
                              <label class="information-person-text">Valor Lab</label>
                              <p class="font-13"><?php echo $consulta['Valor_Lab']; ?></p>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="profiletimeline">
                      <div class="sl-item">
                        <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                          <div>
                            <label class="information-person-text">Fecha de Nacimiento</label>
                            <p class="font-13"><?php echo $newdate; ?></p>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="sl-item">
                        <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                          <div>
                            <label class="information-person-text">Tipo de Diagnóstico</label>
                            <p class="font-13"><?php echo $consulta['Tipo_Diagnostico']; ?></p>
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="sl-item">
                        <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                          <div>
                            <label class="information-person-text">Descripción Item</label>
                            <p class="font-13"><?php echo $consulta['Descripcion_Item']; ?></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-4">
                      <div class="profiletimeline">
                        <div class="sl-item">
                          <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                          <div class="sl-right">
                            <div>
                              <label class="information-person-text">Id Cita</label>
                              <p class="font-13"><?php echo $consulta['Id_Cita']; ?></p>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="sl-item">
                          <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                          <div class="sl-right">
                            <div>
                              <label class="information-person-text">Código Item</label>
                              <p class="font-13"><?php echo $consulta['Codigo_Item']; ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
              </div>
            </div>
            <br>
                  <?php
                      ;}              
                      include("cerrar.php");
                  ?>
        </div>
    <?php } ?>