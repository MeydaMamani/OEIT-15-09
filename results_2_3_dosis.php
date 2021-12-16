<?php
    include('./base.php');
    include('zone_setting.php');
    include('query_cruce_2_3_dosis.php');
    $row_cont=0; $fallecido=0; $rechazo=0; $dosis=0;
    while ($consulta = sqlsrv_fetch_array($consulta1)){  
        $row_cont++;
        if($consulta['FELLECIDO']=='FELLECIDO'){
            $fallecido++;
        }
        if($consulta['RECHAZO']=='RECHAZO'){
            $rechazo++;
        }
        if(!is_null ($consulta['FECHA_3RA_DOSIS'])){
            $dosis++;
        }
    }  
?>

    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center pt-2 pb-3">
                <h3>Cruce de Segunda Dosis y Tercera Dosis</h3>
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
                                        <b class="font-45 total text-secondary"> <?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-45 text-secondary"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 datos_avance">
                    <div class="card-body p-1">
                        <p class="card-title text-secondary text-center font-18 pt-2">Fallecidos</h4>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-3 justify-content-center d-flex">
                                    <div class="col-md-5 text-end">
                                        <img src="./img/at.png" width="90" alt="">
                                    </div>
                                    <div class="mt-3 col-md-7 text-center">
                                        <b class="font-45 cumple"> <?php echo $fallecido; ?></b> <i class="mdi mdi-check font-45 text-success"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-3 datos_avance">
                    <div class="card-body p-0">
                    <p class="card-title text-secondary text-center font-18 pt-3">Rechazo</h4>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-3 justify-content-center d-flex">
                                    <div class="col-md-5 text-end">
                                        <img src="./img/va_7.png" width="90" alt="">
                                    </div>
                                    <div class="mt-3 col-md-7 text-center">
                                        <b class="font-45 cumple_completo"> <?php echo $rechazo; ?></b> <i class="mdi mdi-close font-45 text-danger"></i>
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
                                    if($fallecido == 0 and $row_cont == 0){ echo '0 %'; }else{
                                        echo number_format((float)((($fallecido+$rechazo+$dosis)/$row_cont)*100), 2, '.', ''), '%'; }
                                    ?> 
                                </h1>
                                <h4 class="text-muted">Avance</h4></div>
                            <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($fallecido == 0 and $row_cont == 0){ echo '0'; }else{
                                        echo number_format((float)((($fallecido+$rechazo+$dosis)/$row_cont)*100), 0, '.', ''); }
                                    ?>"><i class="mdi mdi-receipt"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 d-flex mb-2 mt-2 justify-content-center">
                <form action="print_cruce_2_3_dosis.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                </form>
                <button type="button" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='cruce_2_3_dosis.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
            <div class="col-12 table-responsive" id="prematuro">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-13 border" style="background: #c9d0e2;">
                            <th id="patient"></th>
                            <th colspan="5" class="border" id="patient">Paciente</th>
                            <th colspan="6" class="border" id="first_dose">Segunda Dosis</th>
                            <th colspan="7" class="border" id="second_dose">Tercera Dosis</th>
                        </tr>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle border" id="patient">#</th>
                            <th class="align-middle border" id="patient">Tipo Documento</th>
                            <th class="align-middle border" id="patient">Documento</th> 
                            <th class="align-middle border" id="patient">Paciente</th> 
                            <th class="align-middle border" id="patient">Edad</th>
                            <th class="align-middle border" id="patient">Celular</th>
                            <th class="align-middle border" id="first_dose">Provincia</th>
                            <th class="align-middle border" id="first_dose">Distrito</th>
                            <th class="align-middle border" id="first_dose">Establecimiento</th>
                            <th class="align-middle border" id="first_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="first_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="first_dose">Grupo de Riesgo</th>
                            <th class="align-middle border" id="second_dose">Provincia</th>
                            <th class="align-middle border" id="second_dose">Distrito</th>
                            <th class="align-middle border" id="second_dose">Establecimiento</th>
                            <th class="align-middle border" id="second_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="second_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="second_dose">Fallecido</th>
                            <th class="align-middle border" id="second_dose">Rechazo</th>
                            
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_no_fed">
                        <div class="mb-2">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php 
                            include('query_cruce_2_3_dosis.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta1)){  
                                if(is_null ($consulta['TIPO_DOC']) ){
                                    $newdate = '  -'; }
                                else{
                                    $newdate = $consulta['TIPO_DOC'];}

                                if(is_null ($consulta['NUM_DOC']) ){
                                    $newdate2 = '  -'; }
                                else{
                                    $newdate2 = $consulta['NUM_DOC'];}

                                if(is_null ($consulta['SEGUNDA_PACIEN']) ){
                                    $newdate3 = '  -'; }
                                else{
                                    $newdate3 = $consulta['SEGUNDA_PACIEN'];}

                                if(is_null ($consulta['SEGUNDA_EDAD']) ){
                                    $newdate4 = '  -'; }
                                else{
                                    $newdate4 = $consulta['SEGUNDA_EDAD'];}

                                if(is_null ($consulta['SEGUNDA_CEL']) ){
                                    $newdate5 = '  -'; }
                                else{
                                    $newdate5 = $consulta['SEGUNDA_CEL'];}

                                if(is_null ($consulta['SEGUNDA_PROV']) ){
                                    $newdate6 = '  -'; }
                                else{
                                    $newdate6 = $consulta['SEGUNDA_PROV'];}

                                if(is_null ($consulta['SEGUNDA_DIST']) ){
                                    $newdate7 = '  -'; }
                                else{
                                    $newdate7 = $consulta['SEGUNDA_DIST'];}

                                if(is_null ($consulta['SEGUNDA_EESS']) ){
                                    $newdate8 = '  -'; }
                                else{
                                    $newdate8 = $consulta['SEGUNDA_EESS'];}
                                
                                if(is_null ($consulta['SEGUNDA']) ){
                                    $newdate9 = '  -'; }
                                else{
                                    $newdate9 = $consulta['SEGUNDA']  -> format('d/m/y');}

                                if(is_null ($consulta['SEGUNDA_FAB']) ){
                                    $newdate10 = '  -'; }
                                else{
                                    $newdate10 = $consulta['SEGUNDA_FAB'];}

                                if(is_null ($consulta['SEGUNDA_GRUPO']) ){
                                    $newdate11 = '  -'; }
                                else{
                                    $newdate11 = $consulta['SEGUNDA_GRUPO'];}

                                if(is_null ($consulta['PROVINCIA']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['PROVINCIA'];}

                                if(is_null ($consulta['DISTRITO']) ){
                                    $newdate13 = '  -'; }
                                else{
                                    $newdate13 = $consulta['DISTRITO'];}

                                if(is_null ($consulta['ESTABLECIMIENTO']) ){
                                    $newdate14 = '  -'; }
                                else{
                                    $newdate14 = $consulta['ESTABLECIMIENTO'];}

                                if(is_null ($consulta['FECHA_3RA_DOSIS']) ){
                                    $newdate15 = '  -'; }
                                else{
                                    $newdate15 = $consulta['FECHA_3RA_DOSIS'] -> format('d/m/y');}

                                if(is_null ($consulta['FABRICANTE']) ){
                                    $newdate16 = '  -'; }
                                else{
                                    $newdate16 = $consulta['FABRICANTE'];}

                                if(is_null ($consulta['FELLECIDO']) ){
                                    $newdate17 = '  -'; }
                                else{
                                    $newdate17 = $consulta['FELLECIDO'];}

                                if(is_null ($consulta['RECHAZO']) ){
                                    $newdate18 = '  -'; }
                                else{
                                    $newdate18 = $consulta['RECHAZO'];}
        
                        ?>
                        <tr class="text-center font-12" id="table_fed">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate; ?></td>
                            <td class="align-middle"><?php echo $newdate2; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php  
                                $resultado = str_replace("anios", "años", $newdate11);
                                echo $resultado;
                            ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate14); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate15); ?></td>
                            <td class="align-middle"><?php echo $newdate16; ?></td>
                            <td class="align-middle"><?php echo $newdate17; ?></td>
                            <td class="align-middle"><?php echo $newdate18; ?></td>
                        </tr>
                        <?php
                            ;}              
                            sqlsrv_close($conn6);
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="20">
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

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>