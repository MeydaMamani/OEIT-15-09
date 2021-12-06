<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    if (isset($_POST['Buscar'])) {
        header("Content-Type: text/html; charset=UTF-16LE");
        header('Content-Type: text/html; charset=UTF-8');
        global $conex;
        include('./base.php');

    include('zone_setting.php');
    include('consulta_prematuro.php');
    $row_cnt=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){
        $row_cnt++;
        if(is_null ($consulta['SUPLEMENTADO']) ){ $incorrectos++; }
        else{ $correctos++; }
    }

    $num_red_pasco=0; $den_red_pasco=0;
    $num_red_oxa=0; $den_red_oxa=0;
    $num_red_dac=0; $den_red_dac=0;
    $prov_dac = false; $prov_pasco = false; $prov_oxa = false;
    while ($consulta = sqlsrv_fetch_array($consult_resume5)){
        if($consulta['Provnacido'] == 'PASCO'){
            $den_red_pasco = $den_red_pasco + $consulta['MIDENOMINADOR'];
            $num_red_pasco = $num_red_pasco + $consulta['MINUMERADOR'];
            $prov_pasco = true;
        }
        if($consulta['Provnacido'] == 'DANIEL ALCIDES CARRION'){
            $den_red_dac = $den_red_dac + $consulta['MIDENOMINADOR'];
            $num_red_dac = $num_red_dac + $consulta['MINUMERADOR'];
            $prov_dac = true;
        }
        if($consulta['Provnacido'] == 'OXAPAMPA'){
            $den_red_oxa = $den_red_oxa + $consulta['MIDENOMINADOR'];
            $num_red_oxa = $num_red_oxa + $consulta['MINUMERADOR'];
            $prov_oxa = true;
        }
    }

    $monday = date( 'd/m/Y', strtotime( 'monday this week' ) );
?>

    <div class="page-wrapper">
        <div class="container_fed">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD CNV con Fecha: <?php echo $monday; ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
                <h3 class="mb-4">Niños Prematuros CG03 - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="mb-1">
                <div class="row m-2">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="card col-md-6 data_advance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-1">Cantidad Registros</p>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/user_cant.png" width="55" alt="">
                                                </div>
                                                <div class="mt-1 col-md-7 text-center">
                                                    <b class="font-49 total text-secondary"> <?php echo $row_cnt; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-6 data_advance">
                                <div class="card-body p-1">
                                    <p class="card-title text-secondary text-center font-18 pt-1">Suplementados</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/boy.png" width="55" alt="">
                                                </div>
                                                <div class="mt-1 col-md-7 text-center">
                                                    <b class="font-49 correcto text-success"> <?php echo $correctos; ?></b> <i class="mdi mdi-check font-49 text-success"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="card col-md-6 data_advance">
                                <div class="card-body p-0">
                                <p class="card-title text-secondary text-center font-18 pt-1">No Suplementados</h4>
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 justify-content-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/boy_x.png" width="55" alt="">
                                                </div>
                                                <div class="mt-1 col-md-7 text-center">
                                                    <b class="font-49 incorrecto text-danger"> <?php echo $incorrectos; ?></b> <i class="mdi mdi-close font-49 text-danger"></i>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card col-md-6 data_advance p-0">
                                <div class="card-body p-1">
                                    <div class="row pt-2 m-0">
                                        <div class="col-md-7 p-0 text-center">
                                            <h2 class="font-light avance mb-2 text-primary"><?php
                                                if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                                ?> 
                                            </h2>
                                            <h4 class="text-muted">Avance</h4></div>
                                        <div class="col-md-5 p-0 text-center align-self-center position-sticky">
                                            <div id="chart" class="css-bar mb-2 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                                    echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                                ?>"><i class="mdi mdi-receipt"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="col-12 table-responsive" id="prematuro_resume">
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr class="font-11 text-center" style="background: #e0eff5;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Provincia</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">Den</th>
                                        <th class="align-middle">Num</th>
                                        <th class="align-middle">Avance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        include('consulta_prematuro.php');
                                        $i=1;
                                        while ($consulta = sqlsrv_fetch_array($consult_resume5)){
                                            if(is_null ($consulta['Provnacido']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Provnacido'];}
                        
                                            if(is_null ($consulta['Distnacido']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['Distnacido'] ;}
                        
                                            if(is_null ($consulta['MIDENOMINADOR']) ){
                                                $newdate4 = 0; }
                                                else{
                                            $newdate4 = $consulta['MIDENOMINADOR'];}
                        
                                            if(is_null ($consulta['MINUMERADOR']) ){
                                                $newdate5 = 0; }
                                                else{
                                            $newdate5 = $consulta['MINUMERADOR'];}
                        
                                    ?>
                                    <tr class="font-11">
                                        <td class="align-middle text-center"><?php echo $i++; ?></td>
                                        <td class="align-middle text-left"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle text-left"><?php echo utf8_encode($newdate3); ?></td>
                                        <td class="align-middle text-center"><?php echo ($newdate4); ?></td>
                                        <td class="align-middle text-center"><?php echo $newdate5; ?></td>
                                        <td class="align-middle text-center"><?php if($newdate4 == 0 and $newdate5 == 0){ echo '0 %'; }
                                        else{ echo number_format((float)(($newdate5/$newdate4)*100), 2, '.', ''), '%'; } ?></td>
                                    </tr>
                                    <?php
                                        ;}
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4 mt-3 p-l-2 text-center">
                        <div class="row">
                            <?php if($prov_dac == true){?>
                            <div class="card col-md-4 data_advance p-0">
                                <div class="card-header p-2">
                                    Daniel A. Carrión
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-2 mb-3">
                                            <h2 class="font-light mb-2 text-danger"><?php
                                                if($num_red_dac == 0 and $den_red_dac == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($num_red_dac/$den_red_dac)*100), 2, '.', ''), '%'; }
                                                ?> 
                                            </h2>
                                            <img src="./img/m_dac.png" alt="Imagen mapa DAC" width="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if($prov_pasco == true){?>
                            <div class="card col-md-4 data_advance p-0">
                                <div class="card-header">
                                    Pasco
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-2">
                                            <h2 class="font-light mb-2" style="color: #c7c712;"><?php
                                                if($num_red_pasco == 0 and $den_red_pasco == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($num_red_pasco/$den_red_pasco)*100), 2, '.', ''), '%'; }
                                                ?> 
                                            </h2>
                                            <img src="./img/m_pas.png" alt="Imagen mapa Pasco" width="100">
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <?php } ?>
                            <?php if($prov_oxa == true){?>
                            <div class="card col-md-4 data_advance p-0">
                                <div class="card-header">
                                    Oxapampa
                                </div>
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-md-12 text-center mt-2">
                                            <h2 class="font-light mb-2 text-success"><?php
                                                if($num_red_oxa == 0 and $den_red_oxa == 0){ echo '0 %'; }else{
                                                    echo number_format((float)(($num_red_oxa/$den_red_oxa)*100), 2, '.', ''), '%'; }
                                                    ?> 
                                            </h2>
                                            <img src="./img/m_oxa.png" alt="Imagen mapa Oxapampa" width="100">
                                        </div>
                                    </div>
                                </div>
                           </div>
                           <?php } ?>
                        </div>
                   </div>
                </div>
            </div>
            <div class="d-flex mb-2">
                <div class="col-md-5 d-flex">
                    <button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="mdi mdi-checkbox-multiple-blank"></i> FED</button>
                    <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="mdi mdi-checkbox-blank-circle"></i> Todo</button>
                </div>
                <div class="col-md-7 d-flex">
                    <form action="impresion_prematuro.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="button" class="btn btn-outline-danger m-2 btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Información</button>
                    <button type="button" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='prematuros.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div>
            <div class="col-12 table-responsive table_no_fed" id="prematuro">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_prematuro_head">Fecha Nacido</th>
                            <th class="align-middle" id="color_prematuro_head">Menor Encontrado</th>
                            <th class="align-middle">Suplementado</th>
                            <th class="align-middle" id="color_prematuro_head">Tipo Seguro</th>
                            <th class="align-middle" id="color_prematuro_head">Se Atiende</th>
                        </tr>
                    </thead>
                    <div class="float-end col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_prematuro.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){
                                if(is_null ($consulta['Provnacido']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['Provnacido'];}
            
                                if(is_null ($consulta['Distnacido']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['Distnacido'] ;}
            
                                if(is_null ($consulta['Establecimiento']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['Establecimiento'];}
            
                                if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['MENOR_ENCONTRADO'];}
            
                                if(is_null ($consulta['FECNACIDO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['FECNACIDO'] -> format('d/m/y');}
            
                                if(is_null ($consulta['Numcnv']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Numcnv'];}
            
                                if(is_null ($consulta['NOMBRES_MENOR']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['NOMBRES_MENOR'];}
            
                                if(is_null ($consulta['PREMATURO']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['PREMATURO'];}
            
                                if(is_null ($consulta['SUPLEMENTADO']) ){
                                    $newdate11 = 'No'; }
                                    else{
                                $newdate11 = 'Si';}
            
                                if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                                    $newdate12 = '  -'; }
                                    else{
                                $newdate12 = $consulta['Tipo_Doc_Paciente'];}
            
                                if(is_null ($consulta['TIPO_SEGURO']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                $newdate13 = $consulta['TIPO_SEGURO'];}
            
                                if(is_null ($consulta['SE_ATIENDE']) ){
                                    $newdate14 = '  -'; }
                                    else{
                                $newdate14 = $consulta['SE_ATIENDE'];}
            
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo ($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo $newdate6; ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php if($newdate11 == 'Si'){ echo "<span class='badge bg-correct'>$newdate11</span>"; }
                            else{ echo "<span class='badge bg-incorrect'>$newdate11</span>"; } ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo utf8_encode($newdate14); ?></td>
                        </tr>
                        <?php
                            ;}
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="15">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- TABLA FED -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #d9d9d9;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_fed_head">Fecha Nacido</th>
                            <th class="align-middle" id="color_fed_head">Menor Encontrado</th>
                            <th class="align-middle">Suplementado</th>
                            <th class="align-middle" id="color_fed_head">Tipo Seguro</th>
                            <th class="align-middle" id="color_fed_head">Se Atiende</th>
                        </tr>
                    </thead>
                    <div class="float-end col-md-3 table_fed" style="display: none;">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_prematuro.php');
                            $fed=1; $fed_no_supl=0; $fed_supl=0;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){
                                $tipo = strval($consulta['TIPO_SEGURO']);
                                // $tipo = strval('1, 3,');
                                $tipo2 = strpos($tipo, '2');
                                $tipo0 = strpos($tipo, '0');
                                $tipo1 = strpos($tipo, '1');
                                $tipo3 = strpos($tipo, '3');
                                $tipo4 = strpos($tipo, '4');
                                // if((strlen($tipo2) >= 1 && ($tipo0 != '' || $tipo1 != '' || $tipo3 != '' || $tipo4 != '')) || strlen($tipo2) < 1)  {
                                if(($tipo2 === 0 || $tipo2 > 0) && (($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))
                                    || (($tipo == '') || ($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))){    
            
                                    if(is_null ($consulta['Provnacido']) ){
                                        $newdate2 = '  -'; }
                                        else{
                                    $newdate2 = $consulta['Provnacido'];}
            
                                    if(is_null ($consulta['Distnacido']) ){
                                        $newdate3 = '  -'; }
                                        else{
                                    $newdate3 = $consulta['Distnacido'] ;}
            
                                    if(is_null ($consulta['Establecimiento']) ){
                                        $newdate4 = '  -'; }
                                        else{
                                    $newdate4 = $consulta['Establecimiento'];}
            
                                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                        $newdate5 = '  -'; }
                                        else{
                                    $newdate5 = $consulta['MENOR_ENCONTRADO'];}
            
                                    if(is_null ($consulta['FECNACIDO']) ){
                                        $newdate6 = '  -'; }
                                        else{
                                    $newdate6 = $consulta['FECNACIDO'] -> format('d/m/y');}
            
                                    if(is_null ($consulta['Numcnv']) ){
                                        $newdate7 = '  -'; }
                                        else{
                                    $newdate7 = $consulta['Numcnv'];}
            
                                    if(is_null ($consulta['NOMBRES_MENOR']) ){
                                        $newdate8 = '  -'; }
                                        else{
                                    $newdate8 = $consulta['NOMBRES_MENOR'];}
            
                                    if(is_null ($consulta['PREMATURO']) ){
                                        $newdate10 = '  -'; }
                                        else{
                                    $newdate10 = $consulta['PREMATURO'];}
            
                                    if(is_null ($consulta['SUPLEMENTADO']) ){
                                        $newdate11 = 'No';
                                        $fed_no_supl++;
                                    }
                                    else{
                                    $newdate11 = 'Si'; $fed_supl++;}
            
                                    if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                                        $newdate12 = '  -'; }
                                        else{
                                    $newdate12 = $consulta['Tipo_Doc_Paciente'];}
            
                                    if(is_null ($consulta['TIPO_SEGURO']) ){
                                        $newdate13 = '  -'; }
                                        else{
                                    $newdate13 = $consulta['TIPO_SEGURO'];}
            
                                    if(is_null ($consulta['SE_ATIENDE']) ){
                                        $newdate14 = '  -'; }
                                        else{
                                    $newdate14 = $consulta['SE_ATIENDE'];}
            
                        ?>
                        <tr class="font-12 text-center">
                            <td class="align-middle"><?php echo $fed++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate6; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php if($newdate11 == 'Si'){ echo "<span class='badge bg-correct'>$newdate11</span>"; }
                            else{ echo "<span class='badge bg-incorrect'>$newdate11</span>"; } ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo utf8_encode($newdate14); ?></td>
                        </tr>
                        <?php
                            }
                            ;}
                            include("cerrar.php");
                            ?>
                            <div class="contador_fed" style="display: none;"><?php echo $fed-1; ?></div>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="15">
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
                    <img src="./img/inf_prematuros.png" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script src="./plugin/chartist-js/jquery.sparkline.min.js"></script>

    <script>
        $(function(){
            $(".btn_fed").click(function(){
                $(".btn_fed").addClass("active");
                $(".btn_all").removeClass("active");
                $(".total").text(<?php echo $fed-1; ?>);
                $(".correcto").text(<?php echo $fed_supl; ?>);
                $(".incorrecto").text(<?php echo $fed_no_supl; ?>);
                $(".avance").text(<?php if($fed_supl==0 && $fed_no_supl == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($fed_supl/($fed-1))*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $("#chart").removeClass("css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                                echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                            ?>");
                $("#chart").addClass("css-bar-<?php if($fed_supl==0 && $fed_no_supl == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($fed_supl/($fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
                $(".table_fed").show();
                $(".table_no_fed").hide();
            });
            $(".btn_all").click(function(){
                $(".btn_all").addClass("active");
                $(".btn_fed").removeClass("active");
                $(".total").text(<?php echo $row_cnt; ?>);
                $(".correcto").text(<?php echo $correctos; ?>);
                $(".incorrecto").text(<?php echo $incorrectos; ?>);
                $(".avance").text(<?php if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }
                    else{ $porcentaje = number_format((float)(($correctos/$row_cnt)*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $("#chart").removeClass("css-bar-<?php if($fed_supl==0 && $fed_no_supl == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($fed_supl/($fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
                $("#chart").addClass("css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                                echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                            ?>");
                $(".table_fed").hide();
                $(".table_no_fed").show();
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