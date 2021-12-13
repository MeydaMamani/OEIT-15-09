<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
    include('zone_setting.php');
    include('consulta_gestante_tratamiento.php');
    $v2=0; $row_cont1=0;
    while ($consulta = sqlsrv_fetch_array($consulta1)){
        $row_cont1++;
        if(!is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){ $v2++; }
    }
    $t=0; $v=0; $row_cont2=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){ 
        $row_cont2++;
        if(!is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){ $t++; }
        if(!is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){ $v++; }
    }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center p-2">
                <h4>Gestantes con Tamizaje e Inicio de Tratamiento por Violencia CG - <?php echo $nombre_mes; ?></h4>
            </div>
            <div class="text-end">
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='gestante_tratamiento.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-justified" id="myTab promsa" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab promsa" data-bs-toggle="tab" data-bs-target="#visits" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="mdi mdi-walk"></i> Gestantes con Sospecha de Violencia</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab promsa" data-bs-toggle="tab" data-bs-target="#nominal_advance" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="mdi mdi-checkbox-multiple-marked-outline"></i> Gestantes con Inicio de Tratamiento</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <!-- SOSPECHA VIOLENCIA -->
                    <div class="tab-pane fade show active p-3" id="visits" role="tabpanel" aria-labelledby="home-tab">
                        <div class="row m-2">
                            <div class="card col-md-3">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/pregnant_total.png" width="110" alt="">
                                                </div>
                                                <div class="mt-4 col-md-7 text-center">
                                                    <b class="font-45 total text-secondary"> <?php echo $row_cont1; ?></b> <i class="mdi mdi-plus font-45 text-secondary" style="margin-left: -10px;"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="card col-md-3">
                                <div class="card-body p-0">
                                    <p class="card-title text-secondary text-center font-18 pt-3">Sospecha de Violencia</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/pregnant_correct.png" width="90" alt="" height="120">
                                                </div>
                                                <div class="mt-4 col-md-7 text-center">
                                                    <b class="font-45 incorrecto text-danger"> <?php echo $v2; ?></b> <i class="mdi mdi-alert font-45 text-danger"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="card col-md-3">
                                <div class="card-body p-1">
                                    <div class="row pt-4">
                                        <div class="col-md-8 p-r-0 text-center">
                                            <h1 class="font-light avance mb-3 mt-2 text-primary"><?php
                                                if($v2 == 0 and $row_cont1 == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($v2/$row_cont1)*100), 2, '.', ''), '%'; }
                                                ?> 
                                            </h1>
                                            <h2 class="text-muted">Avance</h2>
                                        </div>
                                        <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($v2 == 0 and $row_cont1 == 0){ echo '0'; }else{
                                                    echo number_format((float)(($v2/$row_cont1)*100), 0, '.', ''); }
                                                ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <form action="impresion_gestante_tratamiento.php" method="POST">
                                <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                                <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                                <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                                <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                            </form>
                        </div>
                        <div class="col-12 table-responsive" id="gestante_tratamiento">
                            <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                                <thead>
                                    <tr class="text-light font-12 text-center" style="background: #44688c;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Provincia</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">Documento Paciente</th>
                                        <th class="align-middle">Gestantes Atendidas</th>
                                        <th class="align-middle">N° Control</th>
                                        <th class="align-middle" id="gestante_tratamiento_head">Tamizaje Violencia</th>
                                        <th class="align-middle" id="gestante_tratamiento_head">Problemas relacionados con violencia</th> 
                                    </tr>
                                </thead>
                                <div class="float-end pb-1 col-md-3 table_no_fed">
                                    <div class="mb-3">
                                        <div id="inputbus" class="input-group input-group-sm">
                                            <input id="demo-input-search" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                            <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <tbody>
                                    <?php  
                                        include('consulta_gestante_tratamiento.php');
                                        $i=1;
                                        while ($consulta = sqlsrv_fetch_array($consulta1)){  
                                            // CAMBIO AQUI
                                            if(is_null ($consulta['Provincia_Establecimiento']) ){
                                            $newdate1 = '  -'; }
                                            else{
                                            $newdate1 = $consulta['Provincia_Establecimiento'] ;}

                                            if(is_null ($consulta['Distrito_Establecimiento']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Distrito_Establecimiento'] ;}
                                
                                            if(is_null ($consulta['Numero_Documento_Paciente']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['Numero_Documento_Paciente'];}

                                            if(is_null ($consulta['GESTANTES_ATENDIDAS']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                            $newdate4 = $consulta['GESTANTES_ATENDIDAS'] -> format('d/m/y');}
                                            
                                            if(is_null ($consulta['nro_control']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['nro_control'];}
                                
                                            if(is_null ($consulta['TAMIZAJE_VIOLENCIA']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['TAMIZAJE_VIOLENCIA'] -> format('d/m/y');}

                                            if(is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){
                                                $newdate7 = '  -'; }
                                                else{
                                            $newdate7 = $consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA'] -> format('d/m/y');}

                                    ?>
                                    <tr style="font-size: 12px; text-align: center;">
                                        <td class="align-middle"><?php echo $i++; ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle"><?php echo $newdate3; ?></td>
                                        <td class="align-middle"><?php echo $newdate4; ?></td>
                                        <td class="align-middle"><?php echo $newdate5; ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>                            
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">
                                            <div class="">
                                                <ul class="pagination"></ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- INICIO TRATAMIENTO -->
                    <div class="tab-pane fade p-3" id="nominal_advance" role="tabpanel" aria-labelledby="profile-tab">
                        <!-- <h4 class="text-center mb-4 mt-2" style="color: #000073;">Gestantes con Inicio de Tratamiento</h4> -->
                        <div class="row m-2">
                            <div class="card col-md-3">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/pregnant_total.png" width="110" alt="">
                                                </div>
                                                <div class="mt-4 col-md-7 text-center">
                                                    <b class="font-45 total text-secondary"> <?php echo $row_cont2; ?></b> <i class="mdi mdi-plus font-45 text-secondary" style="margin-left: -10px;"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-3">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Inicio de Tratamiento</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/11677442-a961-45c6-a9df-f7c12ab3598a.png" width="100" alt="">
                                                </div>
                                                <div class="mt-4 col-md-7 text-center">
                                                    <b class="font-45 correcto text-success"> <?php echo $t; ?></b> <i class="mdi mdi-check font-45 text-success" style="margin-left: -10px;"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-3">
                                <div class="card-body p-0">
                                    <p class="card-title text-secondary text-center font-18 pt-3">Sospecha de Violencia</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/pregnant_correct.png" width="90" alt="" height="120">
                                                </div>
                                                <div class="mt-4 col-md-7 text-center">
                                                    <b class="font-45 incorrecto text-danger"> <?php echo $v; ?></b> <i class="mdi mdi-alert font-45 text-danger"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-3">
                                <div class="card-body p-1">
                                    <div class="row pt-4">
                                        <div class="col-md-8 p-r-0 text-center">
                                            <h1 class="font-light avance mb-3 mt-2 text-primary"><?php
                                                if($t == 0 and $v == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($t/$v)*100), 2, '.', ''), '%'; }
                                                ?> 
                                            </h1>
                                            <h2 class="text-muted">Avance</h2>
                                        </div>
                                        <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($t == 0 and $v == 0){ echo '0'; }else{
                                                    echo number_format((float)(($t/$v)*100), 0, '.', ''); }
                                                ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 text-center">
                            <form action="impresion_gestante_tratamiento.php" method="POST">
                                <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                                <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                                <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                                <button type="submit" id="export_data" name="exportarCSV2" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                            </form>
                        </div>
                        <div class="col-12 table-responsive" id="gestante_tratamiento">
                            <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                                <thead>
                                    <tr class="text-light font-12 text-center" style="background: #44688c;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Provincia</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">Documento Paciente</th>
                                        <th class="align-middle">Gestantes Atendidas</th>
                                        <th class="align-middle">N° Control</th>
                                        <th class="align-middle" id="gestante_tratamiento_head">Tamizaje Violencia</th>
                                        <th class="align-middle" id="gestante_tratamiento_head">Problemas relacionados con violencia</th> 
                                        <th class="align-middle" id="gestante_tratamiento_head">Diagnóstico Inicio de Tratamiento</th>
                                        <th class="align-middle">Día Atención</th>
                                        <th class="align-middle">Atendido</th>
                                        <th class="align-middle">Cumple</th>
                                    </tr>
                                </thead>
                                <div class="float-end pb-1 col-md-3 table_no_fed">
                                    <div class="mb-3">
                                        <div id="inputbus" class="input-group input-group-sm">
                                            <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                            <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <tbody>
                                    <?php  
                                        include('consulta_gestante_tratamiento.php');
                                        $i=1;
                                        while ($consulta = sqlsrv_fetch_array($consulta2)){  
                                            // CAMBIO AQUI
                                            if(is_null ($consulta['Provincia_Establecimiento']) ){
                                            $newdate1 = '  -'; }
                                            else{
                                            $newdate1 = $consulta['Provincia_Establecimiento'] ;}

                                            if(is_null ($consulta['Distrito_Establecimiento']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Distrito_Establecimiento'] ;}
                                
                                            if(is_null ($consulta['Numero_Documento_Paciente']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['Numero_Documento_Paciente'];}

                                            if(is_null ($consulta['GESTANTES_ATENDIDAS']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                            $newdate4 = $consulta['GESTANTES_ATENDIDAS'] -> format('d/m/y');}
                                            
                                            if(is_null ($consulta['nro_control']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['nro_control'];}
                                
                                            if(is_null ($consulta['TAMIZAJE_VIOLENCIA']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['TAMIZAJE_VIOLENCIA'] -> format('d/m/y');}

                                            if(is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){
                                                $newdate7 = '  -'; }
                                                else{
                                            $newdate7 = $consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA'] -> format('d/m/y');}

                                            if(is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){
                                            $newdate8 = '  -'; }
                                            else{
                                            $newdate8 = $consulta['DIAGNOSTICO_INICIO_TRATAMIENTO'] -> format('d/m/y');}

                                            if(is_null ($consulta['DIAS_ATENCION']) ){
                                            $newdate9 = '  -'; }
                                            else{
                                            $newdate9 = $consulta['DIAS_ATENCION'];}

                                            if(is_null ($consulta['ATENDIO']) ){
                                            $newdate10 = '  -'; }
                                            else{
                                            $newdate10 = $consulta['ATENDIO'];}
                                    ?>
                                    <tr style="font-size: 12px; text-align: center;">
                                        <td class="align-middle"><?php echo $i++; ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle"><?php echo $newdate3; ?></td>
                                        <td class="align-middle"><?php echo $newdate4; ?></td>
                                        <td class="align-middle"><?php echo $newdate5; ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>
                                        <td class="align-middle"><?php echo $newdate8; ?></td>
                                        <td class="align-middle"><?php echo $newdate9; ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                                        <td class="align-middle"><?php 
                                        if($consulta['DIAS_ATENCION'] <= 7 && $consulta['DIAS_ATENCION'] >= 0 && !is_null ($consulta['DIAS_ATENCION'])){
                                            echo "<span class='badge bg-correct'>Si</span>";
                                        }else if($consulta['DIAS_ATENCION'] > 7){
                                            echo "<span class='badge bg-observed'>Observado</span>";
                                        }else if(is_null ($consulta['DIAS_ATENCION'])){
                                            echo "<span class='badge bg-incorrect'>No</span>";
                                        }
                                        ?></td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="11">
                                            <div class="">
                                                <ul class="pagination"></ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CUADRO RESUMEN-->
    <div class="modal fade" id="ModalResumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1250px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Cuadro Resumen</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="text-light text-center" style="font-size: 12px; background: #5a6a77;">
                        <th class="align-middle">#</th>
                        <th class="align-middle">Provincia</th>
                        <th class="align-middle">Distrito</th>
                        <th class="align-middle">Gestantes Atendidas</th>
                        <th class="align-middle">Tamizaje Violencia</th>
                        <th class="align-middle">Problemas relacionados con violencia</th> 
                        <th class="align-middle">Diagnóstico de Tratamiento</th>
                        <th class="align-middle">Avance</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      include('consulta_resumen_gestante_tratamiento.php'); 
                      $i=1;
                      while ($consulta = sqlsrv_fetch_array($consulta2)){  
                        $violencia=$consulta['PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA'];
                        $tratamiento=$consulta['DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO'];
                    ?>
                      <tr style="font-size: 11px; text-align: center;">
                        <td class="align-middle"><?php echo $i++; ?></td>
                        <td class="align-middle"><?php echo utf8_encode($consulta['Provincia_Establecimiento']); ?></td>
                        <td class="align-middle"><?php echo utf8_encode($consulta['Distrito_Establecimiento']); ?></td>
                        <td class="align-middle"><?php echo $consulta['GESTANTES_ATENDIDAS']; ?></td>
                        <td class="align-middle"><?php echo $consulta['TAMIZAJE_VIOLENCIA']; ?></td>
                        <td class="align-middle"><?php echo $violencia; ?></td>
                        <td class="align-middle"><?php echo $tratamiento; ?></td>
                        <td class="align-middle"><?php 
                            if($tratamiento == 0 and $violencia == 0){
                              echo '0 %';
                            }else{
                              echo ($tratamiento/$violencia)* 100, ' %';
                            }                                
                          ?>
                        </td>
                      </tr>
                      <?php
                      ;}
                      include('cerrar2.php');
                      ?>
                  </tbody>
                </table>
              </div>
              <div class="col-md">
                <canvas id="myChart" style="width: 500px !important; height: 350px !important;"></canvas>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- MODAL INFORMACION-->
    <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
          <div class="modal-body">
            <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
            <img src="./img/I_T.png" style="width: 100%;">
          </div>
        </div>
      </div>
    </div>    
<?php } ?>
    
  <script src="./js/records_menu.js"></script>
  <!-- <script src="./js/jquery-3.6.0.min.js"></script> -->
  <script src="./plugin/footable/js/footable-init.js"></script>
  <script src="./plugin/footable/js/footable.all.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

  <script>
        $('#demo-input-search').on('input', function (e) {
            e.preventDefault();
            addrow2.trigger('footable_filter', {filter: $(this).val()});
        });
                
        var addrow2 = $('#demo-foo-addrow');
            addrow2.footable().on('click', '.delete-row-btn', function() {
            var footable = addrow.data('footable');
            var row = $(this).parents('tr:first');
            footable.removeRow(row);
        });
  </script>
  <script>
          var ctx= document.getElementById("myChart").getContext("2d");
          var myChart= new Chart(ctx,{
              type: "bar",
              data:{
                  labels:[
                    <?php
                      include('consulta_grafica_gestante_tratamiento.php');
                      for ($i = 0; $i < $numero; $i++) {
                        $data = $lista_distritos[$i];
                        echo "'$data', ";
                      }
                    ?>
                  ],
                  datasets:[{
                          label:'Num datos',
                          data:[
                            <?php
                              include('consulta_grafica_gestante_tratamiento.php');
                              for ($i = 0; $i < $n; $i++) {
                                if($lista_tratamiento[$i] == 0 and $lista_violencia[$i] == 0){
                                  echo "'0', ";
                                }else{
                                  $data = (($lista_tratamiento[$i]/$lista_violencia[$i])*100);
                                  echo "'$data', ";
                                }
                              }
                            ?>
                          ],
                          backgroundColor:[
                              'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)', '#a0e53280',
                              'rgb(74, 135, 72,0.5)', '#98f2c4', '#98ddf2', '#d9daf9',
                              '#f298bd', '#ce9898', 'rgb(66, 134, 244,0.5)', '#e5b63280',
                              'rgb(229, 89, 50,0.5)', '#a0e53280', 'rgb(74, 135, 72,0.5)', '#98f2c4',
                              '#98ddf2', '#d9daf9', '#f298bd', '#ce9898', 
                              'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)', '#a0e53280',
                              'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)',
                          ]
                  }]
              },
              options:{
                  scales:{
                      yAxes:[{
                              ticks:{
                                  beginAtZero:true
                              }
                      }]
                  },
                  plugins: {
                      legend: {
                          labels: {
                              font: {
                                  size: 12,
                              }
                          }
                      }
                  }
              }
          });
  </script>
</body>
</html>