<?php 

require ('abrir.php');
   
if (isset($_POST['Buscar'])) {
global $conex;
//  header('Content-Type: text/html; charset=ISO-8859-1');
 include('./base.php');
?>
      <?php 
        $doc = $_POST['doc'];
        $resultado = "SELECT t.Provincia_Establecimiento,t.Distrito_Establecimiento,t.Nombre_Establecimiento, t.Tipo_Doc_Paciente,
                      t.Numero_Documento_Paciente,t.Fecha_Nacimiento_Paciente, t.Id_Cita, t.Fecha_Atencion,t.Tipo_Diagnostico, t.Codigo_Item, t.Valor_Lab, t.Descripcion_Item
                      from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t 
                      where Numero_Documento_Paciente='$doc' and anio='2021' and Fecha_Nacimiento_Paciente>='1960-01-01'
                      order by Fecha_Atencion DESC,id_cita;";

              $consulta2 = sqlsrv_query($conn, $resultado);
          ?>
        <br>
        <div class="page-wrapper">
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
          
                  <ul class="list-group border-primary">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-primary">
                      <p><b>Establecimiento:</b> <?php echo $consulta['Nombre_Establecimiento']; ?> </p>
                      <p><b>Fecha de Atención:</b> <?php echo $newdate2; ?> </p>
                      <p><b>Id Cita:</b> <?php echo $consulta['Id_Cita']; ?> </p>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-primary">
                      <div class="col-3">
                        <div class="profiletimeline">
                          <div class="sl-item">
                            <div class="sl-left"><img src="./img/icon-information.png" width="100" alt="user" class="img-circle size-icon-information-person"></div>
                            <div class="sl-right">
                              <div>
                                <label class="information-person-text">Tipo Diagnóstico</label>
                                <p class="font-13"><?php echo $consulta['Tipo_Diagnostico']; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-3">
                        <div class="profiletimeline">
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
                      <div class="col-2">
                        <div class="profiletimeline">
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
                                <label class="information-person-text">Descripción</label>
                                <p class="font-13"><?php echo $consulta['Descripcion_Item']; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </li>
                  </ul>  
                  <br>
                    <?php
                        ;}              
                        include("cerrar.php");
                    ?>
          </div>
        </div>
    <?php } ?>

    <script src="./js/records_menu.js"></script>