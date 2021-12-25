<?php
  require('abrir7.php');

  if (isset($_POST['Buscar'])) {
    global $conex;
    //  header('Content-Type: text/html; charset=ISO-8859-1');
    include('./base.php');
    $doc = $_POST['doc'];
    // $resultado = "SELECT C.COMORBILIDAD, C.*, V.* FROM VACUNADOS AS V LEFT JOIN T_CONSOLIDADO_VACUNA_COVID AS C ON V.NUM_DOC = C.NUM_DOC 
    //               WHERE (PRIMERA_DEP = 'PASCO' or SEGUNDA_DEP = 'PASCO') AND c.NUM_DOC='$doc'";
    $resultado = "SELECT * FROM VACUNADOS WHERE (PRIMERA_DEP='PASCO' OR SEGUNDA_DEP='PASCO' OR TERCERA_DEP='PASCO') AND NUM_DOC='$doc'";

    $consulta2 = sqlsrv_query($conn7, $resultado);
    $consulta = sqlsrv_fetch_array($consulta2);

    if (isset($consulta['NUM_DOC'])) {
    ?>
    <br><br>
<div class="page-wrapper">
    <div class="container">
      <div class="row mb-4">
        <div class="col-lg-10">
          <h4 class="m-b-30"> INFORMACIÓN - <?php echo $doc; ?></h4>
        </div>
        <div class="col-lg-2 text-end">
          <button type="submit" name="Limpiar" class="btn btn-outline-info" onclick="location.href='vacuna_covid.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
        </div>
      </div>
      <div class="border border-success">
        <div class="row pt-3">
            <div class="col-md-4">
                <div class="profiletimeline">
                    <?php if($consulta['PRIMERA']){ ?>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Primera Dosis</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["PRIMERA"]) ){ echo '  -'; }
                                    else{ echo $consulta['PRIMERA'] -> format('d/m/y'); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['SEGUNDA']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Segunda Dosis</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["SEGUNDA"]) ){ echo '  -'; }
                                    else{ echo $consulta['SEGUNDA'] -> format('d/m/y'); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['TERCERA']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Tercera Dosis</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["TERCERA"]) ){ echo '  -'; }
                                    else{ echo $consulta['TERCERA'] -> format('d/m/y'); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="profiletimeline">
                    <?php if($consulta['PRIMERA_FAB']){ ?>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Fabricación Vacuna</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["PRIMERA_FAB"]) ){ echo '  -'; }
                                    else{ echo utf8_encode($consulta['PRIMERA_FAB']); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['SEGUNDA_FAB']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Fabricación Vacuna</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["SEGUNDA_FAB"]) ){ echo '  -'; }
                                    else{ echo utf8_encode($consulta['SEGUNDA_FAB']); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['TERCERA_FAB']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Fabricación Vacuna</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["TERCERA_FAB"]) ){ echo '  -'; }
                                    else{ echo utf8_encode($consulta['TERCERA_FAB']); }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="profiletimeline">
                    <?php if($consulta['PRIMERA_GRUPO']){ ?>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Grupo de Riesgo</label>
                                <p class="font-13"><?php  
                                    if(is_null ($consulta["PRIMERA_GRUPO"]) ){ echo '  -'; }
                                    else{ 
                                        $dato = utf8_encode($consulta['PRIMERA_GRUPO']);
                                        $resultado = str_replace("a±os", "años", $dato);
                                        echo $resultado; }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['SEGUNDA_GRUPO']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Grupo de Riesgo</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["SEGUNDA_GRUPO"]) ){ echo '  -'; }
                                    else{ $dato = utf8_encode($consulta['SEGUNDA_GRUPO']);
                                        $resultado = str_replace("a±os", "años", $dato);
                                        echo $resultado; }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($consulta['TERCERA_GRUPO']){ ?>
                    <hr>
                    <div class="sl-item">
                        <div class="sl-left"><img src="./img/coronavirus.png" width="160" alt="user" class="img-circle size-icon-information-person"></div>
                        <div class="sl-right">
                            <div>
                                <label class="information-person-text">Fabricación Vacuna</label>
                                <p class="font-13"><?php 
                                    if(is_null ($consulta["TERCERA_GRUPO"]) ){ echo '  -'; }
                                    else{ $dato = utf8_encode($consulta['TERCERA_GRUPO']);
                                        $resultado = str_replace("a±os", "años", $dato);
                                        echo $resultado; }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-1">
                <?php if($consulta['PRIMERA_ACTIVIDAD']){ ?>
                    <div class="mt-3 d-flex justify-content-center align-items-center">
                        <h5 class="text-center text-secondary"> <?php
                            if($consulta['PRIMERA_ACTIVIDAD'] == "VACUNA COVID-19"){
                                echo "V";
                            }else if($consulta['PRIMERA_ACTIVIDAD'] == "EXCEPCIONES DE REGISTRO VACUNA COVID-19"){
                                echo "E";
                            }
                        ?></h5>
                    </div>
                <?php } ?>
                <?php if($consulta['SEGUNDA_ACTIVIDAD']){ ?>
                    <br>
                    <div class="mt-3 d-flex justify-content-center align-items-center">
                        <h5 class="text-center text-secondary"> <?php
                            if($consulta['SEGUNDA_ACTIVIDAD'] == "VACUNA COVID-19"){
                                echo "V";
                            }else if($consulta['SEGUNDA_ACTIVIDAD'] == "EXCEPCIONES DE REGISTRO VACUNA COVID-19"){
                                echo "E";
                            }
                        ?></h5>
                    </div>    
                <?php } ?>
                <?php if($consulta['TERCERA_ACTIVIDAD']){ ?>
                    <br>
                    <div class="mt-3 d-flex justify-content-center align-items-center">
                        <h5 class="text-center text-secondary"> <?php
                            if($consulta['TERCERA_ACTIVIDAD'] == "VACUNA COVID-19"){
                                echo "V";
                            }else if($consulta['TERCERA_ACTIVIDAD'] == "EXCEPCIONES DE REGISTRO VACUNA COVID-19"){
                                echo "E";
                            }
                        ?></h5>
                    </div>
                <?php } ?>
            </div>
            <?php
            } else { ?>
            <div class="page-wrapper">  
                <div class="container">
                    <div class="col-md-12 text-end">
                        <button type="submit" name="Limpiar" class="btn btn-outline-info" onclick="location.href='vacuna_covid.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                    </div><br>
                    <div class="alert alert-primary" role="alert">
                        Usted no cuenta con nínguna dosis o no se encuentra en el padrón regional de Pasco
                    </div>
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
</div>
  <?php } ?>

 <script src="./js/records_menu.js"></script>
</body>
</html>