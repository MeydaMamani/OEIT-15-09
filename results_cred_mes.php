<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;
        include('./base.php');

    include('zone_setting.php');
    include('query_cred_mes.php');
    $row_cont=0; $cumple_crtl_mes=0; $cumple_meses=0; $avance=0;
    while ($consulta = sqlsrv_fetch_array($consulta15)){
        $row_cont ++;
        if($consulta['CUMPLE_CTRLMES']=='CUMPLE'){
            $cumple_crtl_mes++;
        }
        if(!is_null($consulta['PRIMER_CNTRL_MES']) && !is_null($consulta['SEGUNDO_CNTRL_MES']) && !is_null($consulta['CUARTO_CNTRL_MES']) 
            && !is_null($consulta['SEXTO_CNTRL_MES']) && !is_null($consulta['NOVENO_CNTRL_MES'])){
            $cumple_meses++;
        }
        if(!is_null($consulta['PRIMER_CNTRL_MES']) && !is_null($consulta['SEGUNDO_CNTRL_MES']) && !is_null($consulta['CUARTO_CNTRL_MES']) 
            && !is_null($consulta['SEXTO_CNTRL_MES']) && !is_null($consulta['NOVENO_CNTRL_MES'])){
            if($consulta['CUMPLE_CTRLMES']=='CUMPLE'){
                $avance++;
            }
        }
    }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
                <h3 class="mb-4">Cred Mensual - <?php echo $nombre_mes; ?></h3>
            </div>
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
                                        <b class="font-45 total text-secondary"> <?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-45 text-secondary" style="margin-left: -8px;"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 datos_avance">
                    <div class="card-body p-1">
                        <p class="card-title text-secondary text-center font-18 pt-2">Cumple Control Mes</h4>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-3 justify-content-center d-flex">
                                    <div class="col-md-5 text-end">
                                        <img src="./img/boy.png" width="90" alt="">
                                    </div>
                                    <div class="mt-3 col-md-7 text-center">
                                        <b class="font-45 cumple"> <?php echo $cumple_crtl_mes; ?></b> <i class="mdi mdi-check font-45 text-success"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 datos_avance">
                    <div class="card-body p-0">
                    <p class="card-title text-secondary text-center font-18 pt-3">Cumple Correctamente</h4>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-3 justify-content-center d-flex">
                                    <div class="col-md-5 text-end">
                                        <img src="./img/boy_x.png" width="90" alt="">
                                    </div>
                                    <div class="mt-3 col-md-7 text-center">
                                        <b class="font-45 cumple_completo"> <?php echo $avance; ?></b> <i class="mdi mdi-check font-45 text-success"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 datos_avance">
                    <div class="card-body p-1">
                        <div class="row pt-4">
                            <div class="col-md-8 p-0 text-center">
                                <h1 class="font-light avance mb-3"><?php
                                    if($avance == 0 and $row_cont == 0){ echo '0 %'; }else{
                                        echo number_format((float)(($avance/$row_cont)*100), 2, '.', ''), '%'; }
                                    ?> 
                                </h1>
                                <h4 class="text-muted">Avance</h4></div>
                            <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($avance == 0 and $row_cont == 0){ echo '0'; }else{
                                        echo number_format((float)(($avance/$row_cont)*100), 0, '.', ''); }
                                    ?>"><i class="mdi mdi-receipt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-5 d-flex">
                    <button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="mdi mdi-checkbox-multiple-blank"></i> FED</button>
                    <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="mdi mdi-checkbox-blank-circle"></i> Todo</button>
                </div>
                <div class="col-md-7 d-flex">
                    <form action="print_cred_mes.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="button" name="Limpiar" class="btn btn-outline-danger m-2 btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Informacion</button>
                    <button type="button" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='cred_x_mes.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div><br>
            <div class="col-12 table-responsive table_no_fed" id="cred">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0ebd8;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Menor Encontrado</th>
                            <th class="align-middle">Apellidos y Nombres</th> 
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Seguro</th>
                            <th class="align-middle">Fecha Nacimiento Niño</th>
                            <th class="align-middle" id="fields_cred">Primer Control</th>
                            <th class="align-middle" id="fields_cred">Segundo Control</th>
                            <th class="align-middle" id="fields_cred">Tercer Control</th>
                            <th class="align-middle" id="fields_cred">Cuarto Control</th>
                            <th class="align-middle">CUMPLE CONTROL MES</th>
                            <th class="align-middle" id="fields_cred1">Primer Control Mes</th>
                            <th class="align-middle" id="fields_cred1">Segundo Control Mes</th>
                            <th class="align-middle">Tercero Control Mes</th>
                            <th class="align-middle"id="fields_cred1">Cuarto Control Mes</th>
                            <th class="align-middle">Quinto Control Mes</th>
                            <th class="align-middle" id="fields_cred1">Sexto Control Mes</th>
                            <th class="align-middle">Séptimo Control Mes</th>
                            <th class="align-middle">Octavo Control Mes</th>
                            <th class="align-middle" id="fields_cred1">Noveno Control Mes</th>
                            <th class="align-middle">Decimo Control Mes</th>
                            <th class="align-middle">Onceavo Control Mes</th>
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
                            include('query_cred_mes.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta15)){
                                if(is_null ($consulta['NOMBRE_PROV']) ){
                                    $newdate = '  -'; }
                                else{
                                    $newdate = $consulta['NOMBRE_PROV'];}

                                if(is_null ($consulta['NOMBRE_DIST']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['NOMBRE_DIST'];}
                    
                                if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['MENOR_ENCONTRADO'] ;}
                    
                                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['APELLIDOS_NOMBRES'];}
                    
                                if(is_null ($consulta['DOCUMENTO']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['DOCUMENTO'];}
                    
                                if(is_null ($consulta['TIPO_SEGURO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['TIPO_SEGURO'];}
                    
                                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['PRIMER_CNTRL']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['PRIMER_CNTRL'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['SEG_CNTRL']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['SEG_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['TERCER_CNTRL']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['TERCER_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['CUARTO_CNTRL']) ){
                                    $newdate11 = '  -'; }
                                else{
                                    $newdate11 = $consulta['CUARTO_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['CUMPLE_CTRLMES']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['CUMPLE_CTRLMES'];}

                                if(is_null ($consulta['PRIMER_CNTRL_MES']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                $newdate13 = $consulta['PRIMER_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){
                                    $newdate14 = '  -'; }
                                    else{
                                $newdate14 = $consulta['SEGUNDO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['TERCER_CNTRL_MES']) ){
                                    $newdate15 = '  -'; }
                                    else{
                                $newdate15 = $consulta['TERCER_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['CUARTO_CNTRL_MES']) ){
                                    $newdate16 = '  -'; }
                                    else{
                                $newdate16 = $consulta['CUARTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['QUINTO_CNTRL_MES']) ){
                                    $newdate17 = '  -'; }
                                    else{
                                $newdate17 = $consulta['QUINTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEXTO_CNTRL_MES']) ){
                                    $newdate18 = '  -'; }
                                    else{
                                $newdate18 = $consulta['SEXTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){
                                    $newdate19 = '  -'; }
                                    else{
                                $newdate19 = $consulta['SEPTIMO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){
                                    $newdate20 = '  -'; }
                                    else{
                                $newdate20 = $consulta['OCTAVO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['NOVENO_CNTRL_MES']) ){
                                    $newdate21 = '  -'; }
                                    else{
                                $newdate21 = $consulta['NOVENO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['DECIMO_CNTRL_MES']) ){
                                    $newdate22 = '  -'; }
                                    else{
                                $newdate22 = $consulta['DECIMO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){
                                    $newdate23 = '  -'; }
                                    else{
                                $newdate23 = $consulta['ONCEAVO_CNTRL_MES'] -> format('d/m/y');}                    
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
                            <td class="align-middle" id="fields_cred_body"><?php echo $newdate8; ?></td>
                            <td class="align-middle" id="fields_cred_body"><?php echo $newdate9; ?></td>
                            <td class="align-middle" id="fields_cred_body"><?php echo $newdate10; ?></td>
                            <td class="align-middle" id="fields_cred_body"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php 
                                if($newdate12 == 'CUMPLE'){
                                    echo "<span class='badge bg-correct'>CUMPLE</span>";
                                }else{
                                    echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                                }
                                ?></td>
                            <td class="align-middle" id="fields_cred_body1"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="fields_cred_body1"><?php echo $newdate14; ?></td>
                            <td class="align-middle"><?php echo $newdate15; ?></td>
                            <td class="align-middle" id="fields_cred_body1"><?php echo $newdate16; ?></td>
                            <td class="align-middle"><?php echo $newdate17; ?></td>
                            <td class="align-middle" id="fields_cred_body1"><?php echo $newdate18; ?></td>
                            <td class="align-middle"><?php echo $newdate19; ?></td>
                            <td class="align-middle"><?php echo $newdate20; ?></td>
                            <td class="align-middle" id="fields_cred_body1"><?php echo $newdate21; ?></td>
                            <td class="align-middle"><?php echo $newdate22; ?></td>
                            <td class="align-middle"><?php echo $newdate23; ?></td>
                        </tr>                        
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="24">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- TABLA FEDDD -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #d9d9d9;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Menor Encontrado</th>
                            <th class="align-middle">Apellidos y Nombres</th> 
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Seguro</th>
                            <th class="align-middle">Fecha Nacimiento Niño</th>
                            <th class="align-middle" id="color_fed_head">Primer Control</th>
                            <th class="align-middle" id="color_fed_head">Segundo Control</th>
                            <th class="align-middle" id="color_fed_head">Tercer Control</th>
                            <th class="align-middle" id="color_fed_head">Cuarto Control</th>
                            <th class="align-middle">CUMPLE CONTROL MES</th>
                            <th class="align-middle" id="color_fed_head">Primer Control Mes</th>
                            <th class="align-middle" id="color_fed_head">Segundo Control Mes</th>
                            <th class="align-middle">Tercero Control Mes</th>
                            <th class="align-middle" id="color_fed_head">Cuarto Control Mes</th>
                            <th class="align-middle">Quinto Control Mes</th>
                            <th class="align-middle" id="color_fed_head">Sexto Control Mes</th>
                            <th class="align-middle">Séptimo Control Mes</th>
                            <th class="align-middle">Octavo Control Mes</th>
                            <th class="align-middle" id="color_fed_head">Noveno Control Mes</th>
                            <th class="align-middle">Decimo Control Mes</th>
                            <th class="align-middle">Onceavo Control Mes</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_fed" style="display: none;">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php  
                            include('query_cred_mes.php');
                            $i_fed=1; $cumple_crtl_mes_fed=0; $cumple_meses_fed=0; $avance_fed=0;
                            while ($consulta = sqlsrv_fetch_array($consulta15)){
                                $tipo = strval($consulta['TIPO_SEGURO']);
                                $tipo2 = strpos($tipo, '2');
                                $tipo0 = strpos($tipo, '0');
                                $tipo1 = strpos($tipo, '1');
                                $tipo3 = strpos($tipo, '3');
                                $tipo4 = strpos($tipo, '4');

                                if(($tipo2 === 0 || $tipo2 > 0) && (($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))
                                    || (($tipo == '') || ($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))){

                                        if($consulta['CUMPLE_CTRLMES']=='CUMPLE'){
                                            $cumple_crtl_mes_fed++;
                                        }
                                        if(!is_null($consulta['PRIMER_CNTRL_MES']) && !is_null($consulta['SEGUNDO_CNTRL_MES']) && !is_null($consulta['CUARTO_CNTRL_MES']) 
                                            && !is_null($consulta['SEXTO_CNTRL_MES']) && !is_null($consulta['NOVENO_CNTRL_MES'])){
                                            $cumple_meses_fed++;
                                        }
                                        if(!is_null($consulta['PRIMER_CNTRL_MES']) && !is_null($consulta['SEGUNDO_CNTRL_MES']) && !is_null($consulta['CUARTO_CNTRL_MES']) 
                                            && !is_null($consulta['SEXTO_CNTRL_MES']) && !is_null($consulta['NOVENO_CNTRL_MES'])){
                                            if($consulta['CUMPLE_CTRLMES']=='CUMPLE'){
                                                $avance_fed++;
                                            }
                                        }
                                        
                                    if(is_null ($consulta['NOMBRE_PROV']) ){
                                        $newdate = '  -'; }
                                    else{
                                        $newdate = $consulta['NOMBRE_PROV'];}

                                    if(is_null ($consulta['NOMBRE_DIST']) ){
                                        $newdate2 = '  -'; }
                                        else{
                                    $newdate2 = $consulta['NOMBRE_DIST'];}
                        
                                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                        $newdate3 = '  -'; }
                                        else{
                                    $newdate3 = $consulta['MENOR_ENCONTRADO'] ;}
                        
                                    if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                                        $newdate4 = '  -'; }
                                        else{
                                    $newdate4 = $consulta['APELLIDOS_NOMBRES'];}
                        
                                    if(is_null ($consulta['DOCUMENTO']) ){
                                        $newdate5 = '  -'; }
                                        else{
                                    $newdate5 = $consulta['DOCUMENTO'];}
                        
                                    if(is_null ($consulta['TIPO_SEGURO']) ){
                                        $newdate6 = '  -'; }
                                        else{
                                    $newdate6 = $consulta['TIPO_SEGURO'];}
                        
                                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                        $newdate7 = '  -'; }
                                        else{
                                    $newdate7 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                        
                                    if(is_null ($consulta['PRIMER_CNTRL']) ){
                                        $newdate8 = '  -'; }
                                        else{
                                    $newdate8 = $consulta['PRIMER_CNTRL'] -> format('d/m/y');}
                        
                                    if(is_null ($consulta['SEG_CNTRL']) ){
                                        $newdate9 = '  -'; }
                                        else{
                                    $newdate9 = $consulta['SEG_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['TERCER_CNTRL']) ){
                                        $newdate10 = '  -'; }
                                    else{
                                        $newdate10 = $consulta['TERCER_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUARTO_CNTRL']) ){
                                        $newdate11 = '  -'; }
                                        else{
                                    $newdate11 = $consulta['CUARTO_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUMPLE_CTRLMES']) ){
                                        $newdate12 = '  -'; }
                                    else{
                                        $newdate12 = $consulta['CUMPLE_CTRLMES'];}

                                    if(is_null ($consulta['PRIMER_CNTRL_MES']) ){
                                        $newdate13 = '  -'; }
                                        else{
                                    $newdate13 = $consulta['PRIMER_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){
                                        $newdate14 = '  -'; }
                                        else{
                                    $newdate14 = $consulta['SEGUNDO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['TERCER_CNTRL_MES']) ){
                                        $newdate15 = '  -'; }
                                        else{
                                    $newdate15 = $consulta['TERCER_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUARTO_CNTRL_MES']) ){
                                        $newdate16 = '  -'; }
                                        else{
                                    $newdate16 = $consulta['CUARTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['QUINTO_CNTRL_MES']) ){
                                        $newdate17 = '  -'; }
                                        else{
                                    $newdate17 = $consulta['QUINTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEXTO_CNTRL_MES']) ){
                                        $newdate18 = '  -'; }
                                        else{
                                    $newdate18 = $consulta['SEXTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){
                                        $newdate19 = '  -'; }
                                        else{
                                    $newdate19 = $consulta['SEPTIMO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){
                                        $newdate20 = '  -'; }
                                        else{
                                    $newdate20 = $consulta['OCTAVO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['NOVENO_CNTRL_MES']) ){
                                        $newdate21 = '  -'; }
                                        else{
                                    $newdate21 = $consulta['NOVENO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['DECIMO_CNTRL_MES']) ){
                                        $newdate22 = '  -'; }
                                        else{
                                    $newdate22 = $consulta['DECIMO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){
                                        $newdate23 = '  -'; }
                                        else{
                                    $newdate23 = $consulta['ONCEAVO_CNTRL_MES'] -> format('d/m/y');}
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i_fed++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate8; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate9; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate10; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php 
                                if($newdate12 == 'CUMPLE'){
                                    echo "<span class='badge bg-correct'>CUMPLE</span>";
                                }else{
                                    echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                                }
                            ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate14; ?></td>
                            <td class="align-middle"><?php echo $newdate15; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate16; ?></td>
                            <td class="align-middle"><?php echo $newdate17; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate18; ?></td>
                            <td class="align-middle"><?php echo $newdate19; ?></td>
                            <td class="align-middle"><?php echo $newdate20; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate21; ?></td>
                            <td class="align-middle"><?php echo $newdate22; ?></td>
                            <td class="align-middle"><?php echo $newdate23; ?></td>
                        </tr>
                        <?php
                                }
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="24">
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

    <!-- MODAL INFORMACION-->
    <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <img src="./img/CRED.png" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

<script src="./js/records_menu.js"></script>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script>
    $(function(){
        $(".btn_fed").click(function(){
            $(".btn_fed").addClass("active");
            $(".btn_all").removeClass("active");
            $(".total").text(<?php echo $i_fed-1; ?>);
            $(".table_fed").show();
            $(".table_no_fed").hide();
            $(".cumple").text(<?php echo $cumple_crtl_mes_fed; ?>);
            $(".cumple_completo").text(<?php echo $avance_fed; ?>);
            $(".avance").text(<?php if($avance_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($avance_fed/($i_fed-1))*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
            $("#chart").removeClass("css-bar-<?php if($avance == 0 and $row_cont == 0){ echo '0'; }else{
                            echo number_format((float)(($avance/$row_cont)*100), 0, '.', ''); } ?>");
            $("#chart").addClass("css-bar-<?php if($avance_fed==0 && $i_fed-1 == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($avance_fed/($i_fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
        });
        $(".btn_all").click(function(){
            $(".btn_all").addClass("active");
            $(".btn_fed").removeClass("active");
            $(".total").text(<?php echo $row_cont ?>);
            $(".table_fed").hide();
            $(".table_no_fed").show();
            $(".cumple").text(<?php echo $cumple_crtl_mes; ?>);
            $(".cumple_completo").text(<?php echo $avance; ?>);
            $(".avance").text(<?php if($avance == 0 and $row_cont == 0){ echo "'0 %'"; }
                else{ $porcentaje = number_format((float)(($avance/$row_cont)*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
            $("#chart").removeClass("css-bar-<?php if($avance_fed==0 && $i_fed-1 == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($avance_fed/($i_fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
            $("#chart").addClass("css-bar-<?php if($avance == 0 and $row_cont == 0){ echo '0'; }else{
                                                echo number_format((float)(($avance/$row_cont)*100), 0, '.', ''); } ?>");
        });
      });

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
</body>
</html>