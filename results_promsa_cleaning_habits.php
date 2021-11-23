<?php
    require('abrir.php');
    require('abrir2.php');
   
    if (isset($_POST['Buscar'])) {
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php'); 
        include('zone_setting.php');
        include('query_promsa_cleaning_habits.php');
        $total_visits=0; $med_covid=0; $pulsioximetro=0; $inmunizaciones=0; $pamar=0;
        while ($consulta = sqlsrv_fetch_array($consulta1)){
           $total_visits++;
            if($consulta['Valor_Lab'] == 1){
                $med_covid = $med_covid + $consulta['TOTAL'];
            }
            elseif($consulta['Valor_Lab'] == 2){
                $pulsioximetro = $pulsioximetro + $consulta['TOTAL'];
            }
            elseif($consulta['Valor_Lab'] == 3){
                $inmunizaciones = $inmunizaciones + $consulta['TOTAL'];
            }
            elseif($consulta['Valor_Lab'] == 4){
                $pamar = $pamar + $consulta['TOTAL'];
            }
        }

        $total_nominal=0;
        // while ($consulta = sqlsrv_fetch_array($consulta3)){
        //     $total_nominal++;
        // }

        $total_resum=0; $num_dac=0; $den_dac=0; $num_pasco=0; $den_pasco=0; 
        $num_oxa=0; $den_oxa=0; $prov_dac = false; $prov_pasco = false; $prov_oxa = false;
        while ($consulta = sqlsrv_fetch_array($consulta2)){
            $total_resum++;
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
        }
?>

<div class="page-wrapper">
    <div class="container">
        <div class="text-center mt-3">
            <h3>Estilos de Vida en Otras Temáticas - <?php echo $nombre_mes; ?></h3>
        </div>
        <div class="col-md-12 text-end mb-4">
            <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='promsa.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <div class="row m-2">
                    <div class="col-md-1"></div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex  mt-4">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/user_cant.png" width="70" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-40 total"> <?php echo $total_visits; ?></b><i class="mdi mdi-plus font-40 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Medidas Preventivas Covid</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium justify-content-center d-flex">
                                        <div class="col-md-12 text-center">
                                            <b class="font-45 correcto"> <?php echo $med_covid; ?></b><i class="mdi mdi-plus font-40 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">Correcto Uso de Pulsioximetro</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium justify-content-center d-flex">
                                        <div class="col-md-12 text-center">
                                            <b class="font-45 incorrecto"> <?php echo $pulsioximetro; ?></b><i class="mdi mdi-plus font-40 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Inmunizaciones</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="mt-3 col-md-12 text-center">
                                            <b class="font-55 correcto"> <?php echo $inmunizaciones; ?></b><i class="mdi mdi-plus font-40 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-2 datos_avance">
                        <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">Cuidado de PAMAR</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex mt-4">
                                        <div class="col-md-12 text-center">
                                            <b class="font-55 incorrecto"> <?php echo $pamar; ?></b><i class="mdi mdi-plus font-40 text-secondary"></i>
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
                            <th class="align-middle">Código</th>
                            <th class="align-middle">Descripción</th> 
                            <th class="align-middle">Valor</th>
                            <th class="align-middle">Temática</th>
                            <th class="align-middle">Total</th>
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
                            include('query_promsa_cleaning_habits.php');
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
                        
                                if(is_null ($consulta['Codigo_Item']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['Codigo_Item'];}
                    
                                if(is_null ($consulta['Descripcion_Item']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['Descripcion_Item'];}

                                if(is_null ($consulta['Valor_Lab']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Valor_Lab'];}
                        
                                if(is_null ($consulta['TOTAL']) ){
                                    $newdate11 = '  -'; }
                                    else{
                                $newdate11 = $consulta['TOTAL'];}
                        
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate9); ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php 
                                if($newdate7 == 1){
                                    echo 'Medidas Preventivas Covid';
                                }
                                else if($newdate7 == 2){
                                    echo 'Correcto Uso de Pulsioximetro';
                                }
                                else if($newdate7 == 3){
                                    echo 'Inmunizaciones';
                                }
                                else if($newdate7 == 4){
                                    echo 'Cuidado de PAMAR';
                                }
                            ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
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