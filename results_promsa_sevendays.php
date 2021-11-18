<?php
    require('abrir.php');
    require('abrir2.php');
   
    if (isset($_POST['Buscar'])) {
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php'); 
        include('zone_setting.php');
        include('query_promsa_seven_days.php');
        $total_visits=0; $face_to_face=0; $telemonitoring=0;
        while ($consulta = sqlsrv_fetch_array($consulta1)){
            $total_visits++;
            if($consulta['ACTIVIDAD'] == 'PRESENCIAL'){
                $face_to_face++;
            }elseif($consulta['ACTIVIDAD'] == 'TELEMONITOREO'){
                $telemonitoring++;
            }
        }

        // $total_nominal=0;
        // while ($consulta = sqlsrv_fetch_array($consulta3)){
        //     $total_nominal++;
        // }

        // $total_resum=0; $num_dac=0; $den_dac=0; $num_pasco=0; $den_pasco=0; 
        // $num_oxa=0; $den_oxa=0; $prov_dac = false; $prov_pasco = false; $prov_oxa = false;
        // while ($consulta = sqlsrv_fetch_array($consulta6)){
        //     $total_resum++;
        //     if($consulta['NOMBRE_PROV'] ==  'DANIEL ALCIDES CARRION'){
        //         $num_dac = $num_dac + $consulta['NUMERADOR'];
        //         $den_dac = $den_dac + $consulta['DENOMINADOR'];
        //         $prov_dac = true;
        //     }
        //     if($consulta['NOMBRE_PROV'] ==  'PASCO'){
        //         $num_pasco = $num_pasco + $consulta['NUMERADOR'];
        //         $den_pasco = $den_pasco + $consulta['DENOMINADOR'];
        //         $prov_pasco = true;
        //     }
        //     if($consulta['NOMBRE_PROV'] ==  'OXAPAMPA'){
        //         $num_oxa = $num_oxa + $consulta['NUMERADOR'];
        //         $den_oxa = $den_oxa + $consulta['DENOMINADOR'];
        //         $prov_oxa = true;
        //     }
        // }
?>

<div class="page-wrapper">
    <div class="container">
        <div class="text-center mt-3">
            <h3 class="mb-4">Visita Domiciliaria 7 Días - <?php echo $nombre_mes; ?></h3>
        </div>
        <div class="col-md-12 text-end mb-2">
            <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='promsa.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
        </div>
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-justified" id="myTab promsa" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab promsa" data-bs-toggle="tab" data-bs-target="#visits" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="mdi mdi-walk"></i> Visitas</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab promsa" data-bs-toggle="tab" data-bs-target="#nominal_advance" type="button" role="tab" aria-controls="profile" aria-selected="false">Avance Nominal</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab promsa" data-bs-toggle="tab" data-bs-target="#revision" type="button" role="tab" aria-controls="profile" aria-selected="false">Resumen</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <!-- VISITAS -->
                <div class="tab-pane fade show active" id="visits" role="tabpanel" aria-labelledby="home-tab">
                    <br>
                    <div class="mb-3">
                        <div class="row m-2">
                            <div class="card col-md-4 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/user_cant.png" width="90" alt="">
                                                </div>
                                                <div class="mt-3 col-md-7 text-center">
                                                    <b class="font-55 total"> <?php echo $total_visits; ?></b> <i class="mdi mdi-plus font-55 text-secondary"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-4 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Presencial</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/nurse.png" width="90" alt="">
                                                </div>
                                                <div class="mt-3 col-md-7 text-center">
                                                    <b class="font-55 correcto"> <?php echo $face_to_face; ?></b> <i class="mdi mdi-check font-55 text-success"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-4 datos_avance">
                                <div class="card-body p-0">
                                <p class="card-title text-secondary text-center font-18 pt-3">Telemonitoreo</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/online.png" width="90" alt="">
                                                </div>
                                                <div class="mt-3 col-md-7 text-center">
                                                    <b class="font-55 incorrecto"> <?php echo $telemonitoring; ?></b> <i class="mdi mdi-close font-55 text-danger"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 table-responsive table_no_fed" id="visitas_cuatro_meses">
                        <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                            <thead>
                                <tr class="text-center font-12" style="background: #c9d0e2;">
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Provincia</th>
                                    <th class="align-middle">Distrito</th>
                                    <th class="align-middle">Establecimiento</th>
                                    <th class="align-middle">Documento</th>
                                    <th class="align-middle">Código</th>
                                    <th class="align-middle">Descripción</th> 
                                    <th class="align-middle">Actividad</th>
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
                                    include('query_promsa_seven_days.php');
                                    $i=1;
                                    while ($consulta = sqlsrv_fetch_array($consulta1)){  
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
                                
                                
                                        if(is_null ($consulta['Numero_Documento_Paciente']) ){
                                            $newdate7 = '  -'; }
                                            else{
                                        $newdate7 = $consulta['Numero_Documento_Paciente'];}
                                
                                        if(is_null ($consulta['Codigo_Item']) ){
                                            $newdate8 = '  -'; }
                                            else{
                                        $newdate8 = $consulta['Codigo_Item'];}
                            
                                        if(is_null ($consulta['Descripcion_Item']) ){
                                            $newdate9 = '  -'; }
                                            else{
                                        $newdate9 = $consulta['Descripcion_Item'];}
                                
                                        if(is_null ($consulta['ACTIVIDAD']) ){
                                            $newdate10 = '  -'; }
                                            else{
                                        $newdate10 = $consulta['ACTIVIDAD'];}
                                
                                ?>
                                <tr class="text-center font-12">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo $newdate3; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                                    <td class="align-middle"><?php echo $newdate7; ?></td>
                                    <td class="align-middle"><?php echo $newdate8; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate9); ?></td>
                                    <td class="align-middle"><?php echo $newdate10; ?></td>
                                </tr>
                                <?php
                                    }                    
                                    include("cerrar.php");
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="16">
                                        <div class="">
                                            <ul class="pagination"></ul>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- AVANCE NOMINAL -->
                <div class="tab-pane fade" id="nominal_advance" role="tabpanel" aria-labelledby="profile-tab">
                    <br>
                    <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $total_nominal; ?></b></div>
                    <br>
                    <div class="col-12 table-responsive table_no_fed" id="advance_cuatro_meses">
                        <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                            <thead>
                                <tr class="text-center font-12" style="background: #c9d0e2;">
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Provincia</th>
                                    <th class="align-middle">Distrito</th>
                                    <th class="align-middle">Establecimiento</th>
                                    <th class="align-middle">Menor Visitado</th>
                                    <th class="align-middle">Menor Encontrado</th>
                                    <th class="align-middle">Establecimiento Nacimiento</th>
                                    <th class="align-middle">CNV</th>
                                    <th class="align-middle">DNI</th>
                                    <th class="align-middle">Apellido Paterno</th>
                                    <th class="align-middle">Apellido Materno</th>
                                    <th class="align-middle">Nombres</th>
                                    <th class="align-middle">Fecha Nacimiento</th>
                                    <th class="align-middle">Tipo Seguro</th>
                                    <th class="align-middle">Tipo Programa Social</th>
                                    <th class="align-middle">Fecha Modificación</th>
                                    <th class="align-middle" id="fields_4_meses_nominal">Fecha Atención</th>
                                    <th class="align-middle" id="fields_4_meses_nominal">Actividad</th>
                                    <th class="align-middle" id="fields_4_meses_nominal">Visitado</th>
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
                                    include('query_promsa_seven_days.php');
                                    $i=1;
                                    while ($consult = sqlsrv_fetch_array($consulta3)){  
                                        if(is_null ($consult['NOMBRE_PROV']) ){
                                            $newdate_3 = '  -'; }
                                            else{
                                        $newdate_3 = $consult['NOMBRE_PROV'] ;}
                                
                                        if(is_null ($consult['NOMBRE_DIST']) ){
                                            $newdate_4 = '  -'; }
                                            else{
                                        $newdate_4 = $consult['NOMBRE_DIST'];}
                                
                                        if(is_null ($consult['NOMBRE_EESS']) ){
                                            $newdate_5 = '  -'; }
                                            else{
                                        $newdate_5 = $consult['NOMBRE_EESS'];}
                                
                                        if(is_null ($consult['MENOR_VISITADO']) ){
                                            $newdate_6 = '  -'; }
                                            else{
                                        $newdate_6 = $consult['MENOR_VISITADO'];}
                                
                                        if(is_null ($consult['MENOR_ENCONTRADO']) ){
                                            $newdate_7 = '  -'; }
                                            else{
                                        $newdate_7 = $consult['MENOR_ENCONTRADO'];}
                                
                                        if(is_null ($consult['NOMBRE_EESS_NACIMIENTO']) ){
                                            $newdate_8 = '  -'; }
                                            else{
                                        $newdate_8 = $consult['NOMBRE_EESS_NACIMIENTO'];}
                            
                                        if(is_null ($consult['NUM_CNV']) ){
                                            $newdate_9 = '  -'; }
                                            else{
                                        $newdate_9 = $consult['NUM_CNV'];}
                                
                                        if(is_null ($consult['NUM_DNI']) ){
                                            $newdate_10 = '  -'; }
                                            else{
                                        $newdate_10 = $consult['NUM_DNI'];}

                                        if(is_null ($consult['APELLIDO_PATERNO_NINO']) ){
                                            $newdate_11 = '  -'; }
                                            else{
                                        $newdate_11 = $consult['APELLIDO_PATERNO_NINO'];}

                                        if(is_null ($consult['APELLIDO_MATERNO_NINO']) ){
                                            $newdate_12 = '  -'; }
                                            else{
                                        $newdate_12 = $consult['APELLIDO_MATERNO_NINO'];}

                                        if(is_null ($consult['NOMBRE_NINO']) ){
                                            $newdate_13 = '  -'; }
                                            else{
                                        $newdate_13 = $consult['NOMBRE_NINO'];}

                                        if(is_null ($consult['FECHA_NACIMIENTO_NINO']) ){
                                            $newdate_14 = '  -'; }
                                            else{
                                        $newdate_14 = $consult['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}

                                        if(is_null ($consult['TIPO_SEGURO']) ){
                                            $newdate_15 = '  -'; }
                                            else{
                                        $newdate_15 = $consult['TIPO_SEGURO'];}

                                        if(is_null ($consult['TIPO_PROGRAMA_SOCIAL']) ){
                                            $newdate_16 = '  -'; }
                                            else{
                                        $newdate_16 = $consult['TIPO_PROGRAMA_SOCIAL'];}

                                        if(is_null ($consult['FECHA_MODIFICACION_REGISTRO']) ){
                                            $newdate_17 = '  -'; }
                                            else{
                                        $newdate_17 = $consult['FECHA_MODIFICACION_REGISTRO'] -> format('d/m/y');}

                                        if(is_null ($consult['Fecha_Atencion']) ){
                                            $newdate_18 = '  -'; }
                                            else{
                                        $newdate_18 = $consult['Fecha_Atencion'] -> format('d/m/y');}

                                        if(is_null ($consult['ACTIVIDAD']) ){
                                            $newdate_19 = '  -'; }
                                            else{
                                        $newdate_19 = $consult['ACTIVIDAD'];}

                                        if(is_null ($consult['VISITADO']) ){
                                            $newdate_20 = '  -'; }
                                            else{
                                        $newdate_20 = $consult['VISITADO'];}
                                
                                ?>
                                <tr class="text-center font-12">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo $newdate_3; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate_4); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate_5); ?></td>
                                    <td class="align-middle"><?php echo $newdate_6; ?></td>
                                    <td class="align-middle"><?php echo $newdate_7; ?></td>
                                    <td class="align-middle"><?php echo $newdate_8; ?></td>
                                    <td class="align-middle"><?php echo $newdate_9; ?></td>
                                    <td class="align-middle"><?php echo $newdate_10; ?></td>
                                    <td class="align-middle"><?php echo $newdate_11; ?></td>
                                    <td class="align-middle"><?php echo $newdate_12; ?></td>
                                    <td class="align-middle"><?php echo $newdate_13; ?></td>
                                    <td class="align-middle"><?php echo $newdate_14; ?></td>
                                    <td class="align-middle"><?php echo $newdate_15; ?></td>
                                    <td class="align-middle"><?php echo $newdate_16; ?></td>
                                    <td class="align-middle"><?php echo $newdate_17; ?></td>
                                    <td class="align-middle"><?php echo $newdate_18; ?></td>
                                    <td class="align-middle"><?php echo $newdate_19; ?></td>
                                    <td class="align-middle"><?php echo $newdate_20; ?></td>
                                </tr>
                                <?php
                                    ;}                    
                                    include("cerrar.php");
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="16">
                                        <div class="">
                                            <ul class="pagination"></ul>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- RESUMEN -->
                <div class="tab-pane fade" id="revision" role="tabpanel" aria-labelledby="profile-tab">
                    <br>
                    <div class="mb-3">
                        <div class="row m-2">
                            <div class="card col-md-3 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-3 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/user_cant.png" width="90" alt="">
                                                </div>
                                                <div class="mt-3 col-md-7 text-center">
                                                    <b class="font-55 total"> <?php echo $total_resum; ?></b> <i class="mdi mdi-plus font-55 text-secondary"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if($prov_dac == true){?>
                            <div class="card col-md-3 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">DANIEL A. CARRIÓN</p>
                                    <div class="row pt-4">
                                        <div class="col-md-7 p-0 text-center">
                                            <h1 class="font-light avance mb-1 text-primary"><?php 
                                                    if($num_dac == 0 and $den_dac == 0){ echo '0 %'; }
                                                    else{ echo number_format((float)(($num_dac/$den_dac)*100), 2, '.', ''), '%'; }
                                                ?>
                                            </h1>
                                            <h4 class="text-muted">Avance</h4></div>
                                        <div class="col-md-5 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php 
                                                if($num_dac == 0 and $den_dac == 0){ echo '0'; }
                                                else{  echo number_format((float)(($num_dac/$den_dac)*100), 0, '.', ''); }
                                            ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($prov_pasco == true){?>
                            <div class="card col-md-3 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">PASCO</p>
                                    <div class="row pt-4">
                                        <div class="col-md-7 p-0 text-center">
                                            <h1 class="font-light avance mb-1 text-primary"><?php 
                                                    if($num_pasco == 0 and $den_pasco == 0){ echo '0 %'; }
                                                    else{ echo number_format((float)(($num_pasco/$den_pasco)*100), 2, '.', ''), '%'; }
                                                ?>
                                            </h1>
                                            <h4 class="text-muted">Avance</h4></div>
                                        <div class="col-md-5 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php 
                                                if($num_pasco == 0 and $den_pasco == 0){ echo '0'; }
                                                else{  echo number_format((float)(($num_pasco/$den_pasco)*100), 0, '.', ''); }
                                            ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($prov_oxa == true){?>
                            <div class="card col-md-3 datos_avance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-2">OXAPAMPA</p>
                                    <div class="row pt-4">
                                        <div class="col-md-7 p-0 text-center">
                                            <h1 class="font-light avance mb-1 text-primary"><?php 
                                                    if($num_oxa == 0 and $den_oxa == 0){ echo '0 %'; }
                                                    else{ echo number_format((float)(($num_oxa/$den_oxa)*100), 2, '.', ''), '%'; }
                                                ?>
                                            </h1>
                                            <h4 class="text-muted">Avance</h4></div>
                                        <div class="col-md-5 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php 
                                                if($num_oxa == 0 and $den_oxa == 0){ echo '0'; }
                                                else{  echo number_format((float)(($num_oxa/$den_oxa)*100), 0, '.', ''); }
                                            ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="col-12 table-responsive table_no_fed" id="cuatro_meses">
                        <table id="demo-foo-addrow3" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                            <thead>
                                <tr class="text-center font-12" style="background: #c9d0e2;">
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Provincia</th>
                                    <th class="align-middle">Distrito</th>
                                    <th class="align-middle">Denominador</th>
                                    <th class="align-middle">Numerador</th>
                                    <th class="align-middle">Total</th>
                                </tr>
                            </thead>
                            <div class="float-end pb-1 col-md-3 table_no_fed">
                                <div class="mb-3">
                                    <div id="inputbus" class="input-group input-group-sm">
                                        <input id="demo-input-search3" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                        <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                                    </div>
                                </div>
                            </div>
                            <tbody>
                                <?php  
                                    include('query_promsa_seven_days.php');
                                    $i=1;
                                    while ($consulta = sqlsrv_fetch_array($consulta6)){  
                                        if(is_null ($consulta['NOMBRE_PROV']) ){
                                            $newdate3 = '  -'; }
                                            else{
                                        $newdate3 = $consulta['NOMBRE_PROV'] ;}
                                
                                        if(is_null ($consulta['NOMBRE_DIST']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                        $newdate4 = $consulta['NOMBRE_DIST'];}
                                
                                        if(is_null ($consulta['DENOMINADOR']) ){
                                            $newdate6 = '  -'; }
                                            else{
                                        $newdate6 = $consulta['DENOMINADOR'];}
                                
                                        if(is_null ($consulta['NUMERADOR']) ){
                                            $newdate7 = '  -'; }
                                            else{
                                        $newdate7 = $consulta['NUMERADOR'];}
                                
                               
                                ?>
                                <tr class="text-center font-12">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo $newdate3; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                    <td class="align-middle"><?php echo $newdate6; ?></td>
                                    <td class="align-middle"><?php echo $newdate7; ?></td>
                                    <td class="align-middle"><?php if($newdate6 == 0 and $newdate7 == 0){ echo '0%'; }
										else{  echo number_format((float)(($newdate7/$newdate6)*100), 2, '.', ''), '%'; } ?></td>
                                </tr>
                                <?php
                                    }                    
                                    include("cerrar.php");
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="16">
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
    
<?php } ?>

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
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

        $('#demo-input-search3').on('input', function (e) {
            e.preventDefault();
            addrow3.trigger('footable_filter', {filter: $(this).val()});
        });
                
        var addrow3 = $('#demo-foo-addrow3');
            addrow3.footable().on('click', '.delete-row-btn', function() {
            var footable = addrow.data('footable');
            var row = $(this).parents('tr:first');
            footable.removeRow(row);
        });
    </script>    
</body>
</html>