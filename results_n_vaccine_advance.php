<?php 
    require('abrir.php');
    require('abrir6.php');

    if (isset($_POST['Buscar'])) {
        global $conex;
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php'); 
        include('query_vaccine_advance.php');
        $row_cont=0; $correctos=0; $incorrectos=0;
        while ($consulta = sqlsrv_fetch_array($consulta1)){
            $row_cont++;
        }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
              <h3>Avance de la Vacunación Tercera Dosis</h3>
            </div>
            <div class="mb-3">
                <div class="row m-2">
                    <div class="col-md-1"></div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-3">
                                <h5 class="text-muted">Avance 1era Dosis</h5>
                                <div class="col-md-12 p-r-0 text-center">
                                    <h1 class="font-light avance mb-3"><?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h1>
                                </div>
                                <div class="col-md-12 p-0 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-3">
                                <h5 class="text-muted">Avance 2da Dosis</h5>
                                <div class="col-md-12 p-r-0 text-center">
                                    <h1 class="font-light avance mb-3"><?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h1>
                                </div>
                                <div class="col-md-12 p-0 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-3">
                                <h5 class="text-muted">Avance 3era Dosis</h5>
                                <div class="col-md-12 p-r-0 text-center">
                                    <h1 class="font-light avance mb-3"><?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h1>
                                </div>
                                <div class="col-md-12 p-0 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Faltan Inmunizarse</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center">
                                        <div class="col-md-12 text-center">
                                            <img src="./img/user_cant.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-12 text-center">
                                            <b class="font-49 total"> <?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Rechazo</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center">
                                        <div class="col-md-12 text-center">
                                            <img src="./img/boy.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-12 text-center">
                                            <b class="font-49 correcto"> <?php echo $correctos; ?></b> <i class="mdi mdi-close font-49 text-danger"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <form action="print_vaccine_advance.php" method="POST">
                            <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                            <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                            <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                        </form>
                        <button class="btn btn-outline-secondary btn-sm m-2" onclick="location.href='nominal_vaccine_advance.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                    </div>
                </div>
            </div>
            <div class="col-12 table-responsive" id="three_dose">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-13 border" style="background: #c9d0e2;">
                            <th id="patient"></th>
                            <th colspan="5" class="border" id="patient">Paciente</th>
                            <th colspan="5" class="border" id="first_dose">Primera Dosis</th>
                            <th colspan="7" class="border" id="second_dose">Segunda Dosis</th>
                            <th colspan="1" class="border">Tercera Dosis</th>
                        </tr>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle border" id="patient">#</th>
                            <th class="align-middle border" id="patient">Tipo Documento</th>
                            <th class="align-middle border" id="patient">Documento</th> 
                            <th class="align-middle border" id="patient">Paciente</th> 
                            <th class="align-middle border" id="patient">Dirección</th>
                            <th class="align-middle border" id="patient">Celular</th>
                            <th class="align-middle border" id="first_dose">Provincia</th>
                            <th class="align-middle border" id="first_dose">Distrito</th>
                            <th class="align-middle border" id="first_dose">Establecimiento</th>
                            <th class="align-middle border" id="first_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="first_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="second_dose">Provincia</th>
                            <th class="align-middle border" id="second_dose">Distrito</th>
                            <th class="align-middle border" id="second_dose">Establecimiento</th>
                            <th class="align-middle border" id="second_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="second_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="second_dose">Edad</th>
                            <th class="align-middle border" id="second_dose">Grupo de Riesgo</th>
                            <th class="align-middle border">Fecha de Vacunación</th>
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
                    <!-- <tbody>
                        <?php  
                            include('query_vaccine_advance.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta1)){  
                                if(is_null ($consulta['TIPO_DOC']) ){
                                    $newdate = '   -'; }
                                else{
                                    $newdate = $consulta['TIPO_DOC'] ;}
                        
                                if(is_null ($consulta['NUM_DOC']) ){
                                    $newdate2 = '   -'; }
                                else{
                                    $newdate2 = $consulta['NUM_DOC'];}
                        
                                if(is_null ($consulta['PRIMERA_PACIEN']) ){
                                    $newdate3 = '  -'; }
                                else{
                                    $newdate3 = $consulta['PRIMERA_PACIEN'];}
                        
                                if(is_null ($consulta['PRIMERA_PROV']) ){
                                    $newdate4 = '  -'; }
                                else{
                                    $newdate4 = $consulta['PRIMERA_PROV'];}
                        
                                if(is_null ($consulta['PRIMERA_DIST']) ){
                                    $newdate5 = '   -'; }
                                else{
                                    $newdate5 = $consulta['PRIMERA_DIST'];}

                                if(is_null ($consulta['PRIMERA_EESS']) ){
                                    $newdate6 = '    -'; }
                                else{
                                    $newdate6 = $consulta['PRIMERA_EESS'];}    
                        
                                if(is_null ($consulta['PRIMERA']) ){
                                    $newdate7 = '   -'; }
                                else{
                                    $newdate7 = $consulta['PRIMERA'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['PRIMERA_FAB']) ){
                                    $newdate8 = '   -';}
                                else{
                                    $newdate8 = $consulta['PRIMERA_FAB'];}
                        
                                if(is_null ($consulta['SEGUNDA_PROV']) ){
                                    $newdate9 = '   -';}
                                else{
                                    $newdate9 = $consulta['SEGUNDA_PROV'];}
                        
                                if(is_null ($consulta['SEGUNDA_DIST']) ){
                                    $newdate10 = '    -'; }
                                else{
                                    $newdate10 = $consulta['SEGUNDA_DIST'];}    
                            
                                if(is_null ($consulta['SEGUNDA_EESS']) ){
                                    $newdate11 = '   -'; }
                                else{
                                    $newdate11 = $consulta['SEGUNDA_EESS'];}
                        
                                if(is_null ($consulta['SEGUNDA']) ){
                                    $newdate12 = '   -';}
                                else{
                                    $newdate12 = $consulta['SEGUNDA'] -> format('d/m/y');;}
                            
                                if(is_null ($consulta['SEGUNDA_FAB']) ){
                                    $newdate13 = '   -';}
                                else{
                                    $newdate13 = $consulta['SEGUNDA_FAB'];}

                                if(is_null ($consulta['SEGUNDA_EDAD']) ){
                                    $newdate14 = '   -';}
                                else{
                                    $newdate14 = $consulta['SEGUNDA_EDAD'];}    
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate6); ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate12); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate13); ?></td>
                            <td class="align-middle"><?php echo $newdate14; ?></td>
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
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>

    <?php } ?>
    
    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>