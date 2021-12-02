<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');    
    global $conex;
    include('./base.php');
?>
    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
                <h3>Niños Prematuros</h3>
            </div>
            <form name="f1" method="post" action="#" class="_form_gestante">
                <div class="row">
                    <div class="col-md-4">
                        <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                            <option value="0" selected>Seleccione Red</option>
                            <option value="1">DANIEL ALCIDES CARRION</option> 
                            <option value="2">OXAPAMPA</option>
                            <option value="3">PASCO</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-mobile">
                        <select class="select_gestante form-select" name="distrito" id="distrito" aria-label="Default select example">
                            <option value="-">-</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-center">
                        <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                    </div>
                </div>
            </form><br>
            <div class="row">
                <div class="col-md-8 border border-secondary">
                    <h4 class="p-2 text-center">Avance Distrital</h4>
                    <div style="height: 250px;">
                        <canvas id="myChartDistrict"></canvas>
                    </div>
                </div>
                <div class="col-md-4 border border-secondary">
                    <h4 class="p-2 text-center">Avance Regional</h4>
                    <!-- <button class="btn-sm btn_dac" id="btn_dac" name="province" value="DANIEL ALCIDES CARRION"> DANIEL A. CARRION</button>
                            <button class="btn-sm btn_pasco" name="province"> PASCO</button>
                            <button class="btn-sm btn_oxa" name="province"> OXAPAMPA</button> -->
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8 table-responsive">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr class="text-light font-11 text-center" style="background: #0f81db;">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Provincia</th>
                                <th class="align-middle">Distrito</th>
                                <th class="align-middle">Junio</th>
                                <th class="align-middle">Julio</th>
                                <th class="align-middle">Agosto</th>
                                <th class="align-middle">Setiembre</th>
                                <th class="align-middle">Octubre</th>
                                <th class="align-middle">Noviembre</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                include('query_board_prematuros.php');
                                $i=1;
                                while ($consulta = sqlsrv_fetch_array($consult_resume5)){  
                                    // CAMBIO AQUI
                                    if(is_null ($consulta['Provnacido']) ){
                                        $newdate1 = '  -'; }
                                    else{
                                        $newdate1 = $consulta['Provnacido'] ;
                                        if($newdate1 == 'DANIEL ALCIDES CARRION'){
                                            $newdate1 = 'DANIEL CARRION';
                                        }
                                    }
                    
                                    if(is_null ($consulta['Distnacido'])){ $newdate2 = '  -'; }
                                    else{ $newdate2 = $consulta['Distnacido'] ;}
                        
                                    if(is_null ($consulta['JUNIO_NUM']) ){ $newdate9 = 0; }
                                    else{ $newdate9 = $consulta['JUNIO_NUM'];}

                                    if(is_null ($consulta['JUNIO_DEN']) ){ $newdate10 = 0; }
                                    else{ $newdate10 = $consulta['JUNIO_DEN'];}

                                    if(is_null ($consulta['JULIO_NUM']) ){ $newdate11 = 0; }
                                    else{ $newdate11 = $consulta['JULIO_NUM'];}

                                    if(is_null ($consulta['JULIO_DEN']) ){ $newdate12 = 0; }
                                    else{ $newdate12 = $consulta['JULIO_DEN'];}

                                    if(is_null ($consulta['AGOSTO_NUM']) ){ $newdate13 = 0; }
                                    else{ $newdate13 = $consulta['AGOSTO_NUM'];}

                                    if(is_null ($consulta['AGOSTO_DEN']) ){ $newdate14 = 0; }
                                    else{ $newdate14 = $consulta['AGOSTO_DEN'];}

                                    if(is_null ($consulta['SETIEMBRE_NUM']) ){ $newdate15 = 0; }
                                    else{ $newdate15 = $consulta['SETIEMBRE_NUM'];}

                                    if(is_null ($consulta['SETIEMBRE_DEN']) ){ $newdate16 = 0; }
                                    else{ $newdate16 = $consulta['SETIEMBRE_DEN'];}

                                    if(is_null ($consulta['OCTUBRE_NUM']) ){ $newdate17 = 0; }
                                    else{ $newdate17 = $consulta['OCTUBRE_NUM'];}

                                    if(is_null ($consulta['OCTUBRE_DEN']) ){ $newdate18 = 0; }
                                    else{ $newdate18 = $consulta['OCTUBRE_DEN'];}

                                    if(is_null ($consulta['NOVIEMBRE_NUM']) ){ $newdate19 = 0; }
                                    else{ $newdate19 = $consulta['NOVIEMBRE_NUM'];}

                                    if(is_null ($consulta['NOVIEMBRE_DEN']) ){ $newdate20 = 0; }
                                    else{ $newdate20 = $consulta['NOVIEMBRE_DEN'];}

                            ?>
                            <tr class="font-10 text-center">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle" style="text-align: left;"><?php echo utf8_encode($newdate1); ?></td>
                                <td class="align-middle" style="text-align: left;"><?php echo utf8_encode($newdate2); ?></td>
                                <!-- <td class="align-middle"><?php echo $newdate9, '-', $newdate10; ?></td>
                                <td class="align-middle"><?php echo $newdate11, '-', $newdate12; ?></td>
                                <td class="align-middle"><?php echo $newdate13, '-', $newdate14; ?></td>
                                <td class="align-middle"><?php echo $newdate15, '-', $newdate16; ?></td>
                                <td class="align-middle"><?php echo $newdate17, '-', $newdate18; ?></td>
                                <td class="align-middle"><?php echo $newdate19, '-', $newdate20; ?></td> -->
                                <td class="align-middle"><?php if($newdate9 == 0 and $newdate10 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate9/$newdate10)*100), 2, '.', ''), '%'; } ?></td>
                                <td class="align-middle"><?php if($newdate11 == 0 and $newdate12 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate11/$newdate12)*100), 2, '.', ''), '%'; } ?></td>    
                                <td class="align-middle"><?php if($newdate13 == 0 and $newdate14 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate13/$newdate14)*100), 2, '.', ''), '%'; } ?></td>
                                <td class="align-middle"><?php if($newdate15 == 0 and $newdate16 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate15/$newdate16)*100), 2, '.', ''), '%'; } ?></td>
                                <td class="align-middle"><?php if($newdate17 == 0 and $newdate18 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate17/$newdate18)*100), 2, '.', ''), '%'; } ?></td>   
                                <td class="align-middle"><?php if($newdate19 == 0 and $newdate20 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate19/$newdate20)*100), 2, '.', ''), '%'; } ?></td>
                            </tr>
                            <?php
                                ;}                    
                                include("cerrar.php");
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4 p-0 text-center">
                    <div class="border border-secondary" style="width: 110%;">
                        <h4 class="p-2">Avance Regional</h4>
                        <canvas id="myChartProvince"></canvas>
                    </div><br>
                    <div class="col-12" style="width: 110%;">
                        <div class="d-flex justify-content-center">
                            <button class="btn-sm btn_dac" id="btn_dac" name="province" value="DANIEL ALCIDES CARRION"> DANIEL A. CARRION</button>
                            <button class="btn-sm btn_pasco" name="province"> PASCO</button>
                            <button class="btn-sm btn_oxa" name="province"> OXAPAMPA</button>
                        </div>
                    </div><br>
                    <div class="border border-secondary" style="width: 110%;">
                        <h4 class="p-2">Avance Distrital</h4>
                        <div class="dac" style="height: 410px;">
                            <canvas id="myChartDistrict"></canvas>
                        </div>
                        <div class="oxa" style="height: 410px; display: none;">
                            <canvas id="myChartDistrict1"></canvas>
                        </div>
                        <div class="pasco" style="height: 500px; display: none;">
                            <canvas id="myChartDistrict2"></canvas>
                        </div>
                    </div><br>
                </div>
            </div>
        </div>
    </div>
   
    <script src="./js/records_menu.js"></script>
    <script src="./js/select2.js"></script>
    <script src="./js/district.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="./js/chartjs-plugin-datalabels.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $("#btn_buscar").click(function(){           
            var distrito = $("#distrito").val();
            console.log(distrito);
            $.ajax({
                url: 'query_board_prematuros.php?&dist='+distrito,
                method: 'GET',
                success: function(data) {
                    
                    // var establecimiento = data;
                    // var expresionRegular = /\s*,\s*/;
                    // var listaEstablecimiento = establecimiento.split(expresionRegular);
                    // var indice = listaEstablecimiento.length-1;
                    // listaEstablecimiento[indice] = 'TODOS';
                    // num_distritos = listaEstablecimiento.length 
                    // document.f1.establecimiento.length = num_distritos
                    // for(i=0;i<num_distritos;i++){ 
                    //     document.f1.establecimiento.options[i].value=listaEstablecimiento[i] 
                    //     document.f1.establecimiento.options[i].text=listaEstablecimiento[i] 
                    // } 
                }
            })
        });
        //POR DISTRITO
        new Chart(document.getElementById("myChartDistrict"), {
            type: 'bar',
            data: {
                labels:[ "JUNIO", "JULIO", "AGOSTO", "SETIEMBRE", "OCTUBRE", "NOVIEMBRE"],
                datasets:[
                    {
                        label:'DATOSSSS',
                        data:[
                            <?php
                                include('query_board_prematuros.php');
                                $list_junio[] = array(); $list_julio[] = array(); $list_agost[] = array();
                                $list_junio[] = array(); $list_junio[] = array(); $list_junio[] = array(); 
                                while ($con = sqlsrv_fetch_array($consult_resume6)){
                                    if($con['JUNIO_NUM'] == 0 and $con['JUNIO_DEN'] == 0){ $junio = 0; }
                                    else{  $junio = ($con['JUNIO_NUM']/$con['JUNIO_DEN'])*100; }

                                    if($con['JULIO_NUM'] == 0 and $con['JULIO_DEN'] == 0){ $julio = 0; }
                                    else{  $julio = ($con['JULIO_NUM']/$con['JULIO_DEN'])*100; }

                                    if($con['AGOSTO_NUM'] == 0 and $con['AGOSTO_DEN'] == 0){ $agosto = 0; }
                                    else{ $agosto = ($con['AGOSTO_NUM']/$con['AGOSTO_DEN'])*100; }

                                    if($con['SETIEMBRE_NUM'] == 0 and $con['SETIEMBRE_DEN'] == 0){ $setiembre = 0; }
                                    else{  $setiembre = ($con['SETIEMBRE_NUM']/$con['SETIEMBRE_DEN'])*100; }

                                    if($con['OCTUBRE_NUM'] == 0 and $con['OCTUBRE_DEN'] == 0){ $octubre = 0; }
                                    else{  $octubre = ($con['OCTUBRE_NUM']/$con['OCTUBRE_DEN'])*100; }

                                    if($con['NOVIEMBRE_NUM'] == 0 and $con['NOVIEMBRE_DEN'] == 0){ $noviembre = 0; }
                                    else{  $noviembre = ($con['NOVIEMBRE_NUM']/$con['NOVIEMBRE_DEN'])*100; }

                                }
                                echo "$junio, $julio, $agosto, $setiembre, $octubre, $noviembre";
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                ]
            },
            plugins: [ChartDataLabels],
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let percentage = value.toFixed(2)+"%";
                            console.log(percentage);
                            return percentage;
                        },
                        color: 'black',
                        anchor: 'end',
                        align: 'top',
                        offset: 3
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
        });
    </script>

    <!-- <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <?php include('board_prematuros_graph.php'); ?> -->
    <!-- <script>
        $( document ).ready(function() {
            $("#btn_dac").click();
        });
    </script> -->
</body>
</html>