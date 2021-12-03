<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
    global $conex;
    include('./base.php');
?>
    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
                <h3>Ficha 2 - Niños Menores de 18 meses</h3>
            </div>
            <!-- <?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> -->
            <div name="f1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="row">
                    <div class="col-md-4">
                        <select class="select_gestante form-select" name="provincia" id="provincia" onchange="cargarPueblos();" aria-label="Default select example">
                            <option value="0" selected>Seleccione Red</option>
                        </select>
                    </div>
                    <div class="col-md-4 text-mobile">
                        <select class="select_gestante form-select" name="pueblo" id="pueblo" aria-label="Default select example">
                            <option value="-" selected>Seleccione Distrito</option>
                        </select>
                    </div>
                    <div class="col-md-2 text-mobile">
                        <select class="select_gestante form-select" name="anio" id="anio" aria-label="Default select example">
                            <option value="-" selected>Seleccione Año</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col-md-8 border border-secondary">
                    <h4 class="p-2 text-center">Avance Distrital <?php 
                        $dist_1 = '';
                        echo $dist_1;
                        ?>
                    </h4>
                    <div style="height: 250px;">
                        <canvas id="myChartDistrict"></canvas>
                    </div>
                </div>
                <div class="col-md-4 border border-secondary">
                    <h4 class="p-2 text-center">Avance Regional</h4>
                </div>
            </div>
            <br>
            <div class="row">
                <!-- <div class="col-md-8 table-responsive">
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
                </div> -->
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
                        <!-- <div class="dac" style="height: 410px;">
                            <canvas id="myChartDistrict"></canvas>
                        </div>
                        <div class="oxa" style="height: 410px; display: none;">
                            <canvas id="myChartDistrict1"></canvas>
                        </div>
                        <div class="pasco" style="height: 500px; display: none;">
                            <canvas id="myChartDistrict2"></canvas>
                        </div> -->
                    </div><br>
                </div>
            </div>
        </div>
    </div>
   
    <script src="./js/records_menu.js"></script>
    <script src="./js/select2.js"></script>
    <!-- <script src="./js/district.js"></script> -->
    <script src="./js/Chart.min.js"></script>
    <script src="./js/chartjs-plugin-datalabels.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $('#provincia').select2();
        $('#pueblo').select2();
        $('#anio').select2();
        function cargarProvincias() {
            var array = ["DANIEL ALCIDES CARRION", "OXAPAMPA", "PASCO"];
            array.sort();
            addOptions("provincia", array);
        }

        function addOptions(domElement, array) {
            var selector = document.getElementsByName(domElement)[0];
            for (provincia in array) {
                var opcion = document.createElement("option");
                opcion.text = array[provincia];
                opcion.value = array[provincia].toLowerCase().replace(/\s+/g, '');
                selector.add(opcion);
            }
        }

        function cargarPueblos() {
            var listaPueblos = {
                danielalcidescarrion: ["CHACAYAN","GOYLLARISQUIZGA","PAUCAR","SAN PEDRO DE PILLAO","SANTA ANA DE TUSI","TAPUC","VILCABAMBA","YANAHUANCA"],
                oxapampa: ["CHONTABAMBA","CONSTITUCIÓN","HUANCABAMBA","OXAPAMPA","PALCAZU","POZUZO","PUERTO BERMUDEZ","VILLA RICA"],
                pasco: ["CHAUPIMARCA","HUACHON","HUARIACA","HUAYLLAY","NINACACA","PALLANCHACRA","PAUCARTAMBO","SAN FRANCISCO DE ASIS DE YARUSYACAN","SIMON BOLIVAR","TICLACAYAN","TINYAHUARCO","VICCO","YANACANCHA"]
            }
            
            var provincias = document.getElementById('provincia')
            var pueblos = document.getElementById('pueblo')
            var provinciaSeleccionada = provincias.value            
            // Se limpian los pueblos
            pueblos.innerHTML = '<option value="">Seleccione un Distrito...</option>'            
            if(provinciaSeleccionada !== ''){
                // Se seleccionan los pueblos y se ordenan
                provinciaSeleccionada = listaPueblos[provinciaSeleccionada]
                provinciaSeleccionada.sort()                
                // Insertamos los pueblos
                provinciaSeleccionada.forEach(function(pueblo){
                    let opcion = document.createElement('option')
                    opcion.value = pueblo
                    opcion.text = pueblo
                    pueblos.add(opcion)
                });
            }            
        }  
        cargarProvincias();
    </script>
    <script>
        $("#btn_buscar").click(function(){
            var distrito = $("#pueblo").val();
            var anio = $("#anio").val();
            console.log("ME DISTE CLICK", distrito);
            console.log("ME DISTE ------", anio);
            $.ajax({
                url: 'query_ficha2.php?distrito='+distrito+'&anio='+anio,
                method: 'GET',
                success: function(data) {
                    console.log('SOY DATA', data);
                    //POR DISTRITO
                    var ctx_province= document.getElementById("myChartDistrict").getContext("2d");
                    var myChartProvince= new Chart(ctx_province,{
                        type: 'bar',
                        data: {
                            labels:[ "ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SET", "OCT", "NOV", "DIC"],
                            datasets:[
                                {
                                    label:'DATOSSSS',
                                    data:[
                                        <?php
                                            include('query_ficha2.php');
                                            $dist_1 = '';
                                            $anio = '';
                                            echo "$ene, $feb, $mar, $abr, $may, $jun, $jul, $ago, $set, $oct, $nov, $dic";
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
                }
            })
        });
    </script>    
</body>
</html>