<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
    global $conex;
    include('./base.php');
    include('query_ficha2.php');
    $num_reg=0; $den_reg=0;
    while ($con = sqlsrv_fetch_array($consulta9)){
        $num_reg = $num_reg + $con['NUMERADOR1'];
        $den_reg = $den_reg + $con['DENOMINADOR1'];
    }
?>
    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
                <h3>Ficha 2 - Niños Menores de 18 meses</h3>
            </div>
            <!-- <?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?> -->
            <div class="row">
                <div class="col-md-3">
                    <select class="select_gestante form-select" name="provincia" id="provincia" onchange="cargarPueblos();" aria-label="Default select example">
                        <option value="0" selected>Seleccione Red</option>
                    </select>
                </div>
                <div class="col-md-3 text-mobile">
                    <select class="select_gestante form-select" name="pueblo" id="pueblo" onchange="misDistricts();" aria-label="Default select example">
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
                <div class="col-md-2 divmes">
                    <select class="select_gestante form-select" name="mes" id="mes" aria-label="Default select example">
                        <option value="-" selected>Seleccione Mes</option>
                        <option value="1">ENERO</option>
                        <option value="2">FEBRERO</option>
                        <option value="3">MARZO</option>
                        <option value="4">ABRIL</option>
                        <option value="5">MAYO</option>
                        <option value="6">JUNIO</option>
                        <option value="7">JULIO</option>
                        <option value="8">AGOSTO</option>
                        <option value="9">SETIEMBRE</option>
                        <option value="10">OCTUBRE</option>
                        <option value="11">NOVIEMBRE</option>
                        <option value="12">DICIEMBRE</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button name="Buscar" class="btn text-white" type="submit" id="btn_buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                </div>
            </div><br>
            <div class="mb-4">
                <div class="col-md-12 border border-secondary" id="district">
                    <h4 class="p-2 text-center">Avance Distrital Para <span><?php echo $nombre_mes; ?></span></h4>
                    <div style="height: 300px;" id="carga">
                        <canvas id="myChartDistrict"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 table-responsive" id="ficha2">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                            <tr class="text-light font-11 text-center" style="background: black;">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Provincia</th>
                                <th class="align-middle">Distrito</th>
                                <th class="align-middle">Num</th>
                                <th class="align-middle">Den</th>
                                <th class="align-middle">Avance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  
                                $i=1;
                                include('query_ficha2.php');
                                while ($consulta = sqlsrv_fetch_array($consulta6)){  
                                    // CAMBIO AQUI
                                    if(is_null ($consulta['NOMBRE_PROV']) ){ $newdate1 = '  -'; }
                                    else{ $newdate1 = $consulta['NOMBRE_PROV']; }
                    
                                    if(is_null ($consulta['NOMBRE_DIST'])){ $newdate2 = '  -'; }
                                    else{ $newdate2 = $consulta['NOMBRE_DIST'] ;}
                        
                                    if(is_null ($consulta['NUMERADOR1']) ){ $newdate3 = 0; }
                                    else{ $newdate3 = $consulta['NUMERADOR1'];}

                                    if(is_null ($consulta['DENOMINADOR1']) ){ $newdate4 = 0; }
                                    else{ $newdate4 = $consulta['DENOMINADOR1'];}

                            ?>
                            <tr class="font-11 text-center">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle" style="text-align: left;"><?php echo utf8_encode($newdate1); ?></td>
                                <td class="align-middle" style="text-align: left;"><?php echo utf8_encode($newdate2); ?></td>
                                <td class="align-middle"><?php echo ($newdate3); ?></td>
                                <td class="align-middle"><?php echo ($newdate4); ?></td>
                                <td class="align-middle"><?php if($newdate3 == 0 and $newdate4 == 0){ echo '0%'; }
                                    else{ echo number_format((float)(($newdate3/$newdate4)*100), 2, '.', ''), '%'; } ?></td>
                            </tr>
                            <?php
                                ;}                    
                                include("cerrar.php");
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-5 text-center">
                    <div class="border border-secondary">
                        <h3 class="pt-2">Avance por Red</h3>
                        <div style="height: 250px;" class="mb-4">
                            <canvas id="myChartRed"></canvas>
                        </div>
                    </div><br>
                </div>
                <div class="col-md-3 text-center">
                    <div class="border border-secondary">
                        <h3 class="pt-2">Avance Regional</h3>
                        <div class="col-md-12 text-center align-self-center position-sticky" id="grafico">
                            <h1 class="font-light avance mb-3 text-primary"><?php 
                                if($num_reg == 0 and $den_reg == 0){ echo '0 %'; }else{
                                echo number_format((float)(($num_reg/$den_reg)*100), 2, '.', ''), '%'; } 
                            ?></h1>
                            <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php 
                                if($num_reg == 0 and $den_reg == 0){ echo '0'; }else{
                                echo number_format((float)(($num_reg/$den_reg)*100), 0, '.', ''); }
                            ?>"><i class="mdi mdi-receipt"></i></div>
                        </div>    
                    </div><br>
                </div>
            </div>
        </div>
    </div>
   
    <script src="./js/records_menu.js"></script>
    <script src="./js/select2.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="./js/chartjs-plugin-datalabels.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        $('#provincia').select2();
        $('#pueblo').select2();
        $('#anio').select2();
        $('#mes').select2();
        function cargarProvincias() {
            var array = ["DANIEL ALCIDES CARRION", "OXAPAMPA", "PASCO"];
            // array.sort();
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
                danielalcidescarrion: ["CHACAYAN","GOYLLARISQUIZGA","PAUCAR","SAN PEDRO DE PILLAO","SANTA ANA DE TUSI","TAPUC","VILCABAMBA","YANAHUANCA", "TODOS"],
                oxapampa: ["CHONTABAMBA","CONSTITUCIÓN","HUANCABAMBA","OXAPAMPA","PALCAZU","POZUZO","PUERTO BERMUDEZ","VILLA RICA", "TODOS"],
                pasco: ["CHAUPIMARCA","HUACHON","HUARIACA","HUAYLLAY","NINACACA","PALLANCHACRA","PAUCARTAMBO","SAN FRANCISCO DE ASIS DE YARUSYACAN","SIMON BOLIVAR","TICLACAYAN","TINYAHUARCO","VICCO","YANACANCHA", "TODOS"]
            }
            
            var provincias = document.getElementById('provincia')
            var pueblos = document.getElementById('pueblo')
            var provinciaSeleccionada = provincias.value            
            // Se limpian los pueblos
            pueblos.innerHTML = '<option value="">Seleccione un Distrito...</option>'            
            if(provinciaSeleccionada !== ''){
                // Se seleccionan los pueblos y se ordenan
                provinciaSeleccionada = listaPueblos[provinciaSeleccionada]
                // provinciaSeleccionada.sort()                
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
        // $("#carga").html('<div class="lds-roller mt-5"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
        var ctx_province= document.getElementById("myChartDistrict").getContext("2d");
        var myChartProvince= new Chart(ctx_province,{
            type: 'bar',
            data: {
                labels:[ 
                    <?php
                        include('query_ficha2.php');
                        $list_dists = array();
                        while ($con = sqlsrv_fetch_array($consulta6)){
                            if($con['NOMBRE_DIST'] == "SAN FCO DE ASIS DE YARUSYACAN"){ $list_dists[] = "YARUSYACAN"; }
                            else if($con['NOMBRE_DIST'] == "SAN PEDRO DE PILLAO"){ $list_dists[] = "PILLAO"; }
                            else if($con['NOMBRE_DIST'] == "SANTA ANA DE TUSI"){ $list_dists[] = "TUSI"; }
                            else if($con['NOMBRE_DIST'] == "PUERTO BERMUDEZ"){ $list_dists[] = "P. BERMUDEZ"; }
                            else if($con['NOMBRE_DIST'] == "GOYLLARISQUIZGA"){ $list_dists[] = "GOYLLAR"; }
                            else{ $list_dists[] = $con['NOMBRE_DIST']; }
                        }
                        $num_dists = sizeof($list_dists);         
                        for ($i = 0; $i < $num_dists; $i++) {
                            $data = ($list_dists[$i]);
                            echo "'$data', ";
                        }
                    ?>
                ],
                datasets:[
                    {
                        label:'Avance',
                        data:[
                            <?php
                                include('query_ficha2.php');
                                $list_total = array();
                                while ($con = sqlsrv_fetch_array($consulta6)){
                                    if($con['NUMERADOR1'] == 0 and $con['DENOMINADOR1'] == 0){ $nov = 0; }
                                    else{  $nov = number_format((float)(($con['NUMERADOR1']/$con['DENOMINADOR1'])*100), 2, '.', ''); }
                                    $list_total[] = $nov;
                                }
                                $datos = sizeof($list_total);         
                                for ($i = 0; $i < $datos; $i++) {
                                    $data = ($list_total[$i]);
                                    echo "'$data', ";
                                }
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
                // indexAxis: 'y',
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let percentage = value+"%";
                            //console.log(percentage);
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

        var ctx_red= document.getElementById("myChartRed").getContext("2d");
        var myChartProvince= new Chart(ctx_red,{
            type: 'doughnut',
            data: {
                labels:[ 
                    <?php
                        include('query_ficha2.php');
                        $list_dists = array();
                        while ($con = sqlsrv_fetch_array($consulta9)){
                            if($con['NOMBRE_PROV'] == "DANIEL ALCIDES CARRION"){ $list_dists[] = "DANIEL A. CARRION"; }
                            else{ $list_dists[] = $con['NOMBRE_PROV']; }
                        }
                        $num_dists = sizeof($list_dists);         
                        for ($i = 0; $i < $num_dists; $i++) {
                            $data = ($list_dists[$i]);
                            echo "'$data', ";
                        }
                    ?>
                ],
                datasets:[
                    {
                        label:'Avance',
                        data:[
                            <?php
                                include('query_ficha2.php');
                                $list_total = array();
                                while ($con = sqlsrv_fetch_array($consulta9)){
                                    if($con['NUMERADOR1'] == 0 and $con['DENOMINADOR1'] == 0){ $nov = 0; }
                                    else{  $nov = number_format((float)(($con['NUMERADOR1']/$con['DENOMINADOR1'])*100), 2, '.', ''); }
                                    $list_total[] = $nov;
                                }
                                $datos = sizeof($list_total);         
                                for ($i = 0; $i < $datos; $i++) {
                                    $data = ($list_total[$i]);
                                    echo "'$data', ";
                                }
                            ?>
                        ],
                        backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                        ],
                        hoverOffset: 4
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
                            let percentage = value+"%";
                            return percentage;
                        },
                        color: 'black',
                    }
                },
            },
        });
    </script>
    <script>
        function misDistricts(){
            var distrito = $("#pueblo").val();
            if(distrito != "TODOS"){
                $(".divmes").hide();
            }else{
                $(".divmes").show();
            }
        }

        $("#btn_buscar").click(function(){
            var red = $("#provincia").val();
            var distrito = $("#pueblo").val();
            var anio = $("#anio").val();
            var mes = $("#mes").val();
            console.log("ME DISTE red", red);
            console.log("ME DISTE CLICK", distrito);
            console.log("ME DISTE ------", mes);

            if(mes == '-'){
                $(".name_red").text(red);
                canvas = document.getElementById("myChartDistrict");
                ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                $('canvas#myChartDistrict').remove();

                $.ajax({
                    url: 'query_ficha2.php?distrito='+distrito+'&anio='+anio+'&mes='+mes+'&red='+red,
                    method: 'GET',
                    success: function(data) {
                        // $("#province").show();
                        // $("#district").hide();
                        // $("#carga").html('<div class="lds-roller mt-5"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
                        $('#carga').append("<canvas id='myChartDistrict'></canvas>");
                        console.log('SOY DATA', data);
                        var establecimiento = data;
                        var expresionRegular = /\s*---\s*/;
                        var lista_id =establecimiento.split(expresionRegular);
                        var id = [];
                        for(i=0;i<lista_id.length;i++){
                            id.push(lista_id[i]);
                        }
                        console.log('+++', id);
                        
                        //POR DISTRITO
                        var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
                        var myChartProvince= new Chart(ctx_district,{
                            type: 'bar',
                            data: {
                                labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                                datasets:[
                                    {
                                        label: 'Avance',
                                        data: id,
                                        backgroundColor: '#1d3f74',
                                    },
                                ]
                            },
                            plugins: [ChartDataLabels],
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                // indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let percentage = value+"%";
                                            //console.log(percentage);
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
            }else{
                $(".name_red").text(red);
                canvas = document.getElementById("myChartDistrict");
                ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                $('canvas#myChartDistrict').remove();

                $.ajax({
                    url: 'query_ficha2.php?distrito='+distrito+'&anio='+anio+'&mes='+mes+'&red='+red,
                    method: 'GET',
                    success: function(data) {
                        // $("#province").show();
                        // $("#district").hide();
                        // $("#carga").html('<div class="lds-roller mt-5"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
                        $('#carga').append("<canvas id='myChartDistrict'></canvas>");
                        console.log('SOY DATA', data);
                        var establecimiento = data;
                        var expresionRegular = /\s*---\s*/;
                        var lista_id =establecimiento.split(expresionRegular);
                        var id = []; var names = [];
                        for(i=0;i<lista_id.length;i++){
                            if(i % 2 == 0){
                                id.push(lista_id[i]);
                            }else{
                                names.push(lista_id[i]);
                            }
                        }
                        //POR DISTRITO
                        var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
                        var myChartProvince= new Chart(ctx_district,{
                            type: 'bar',
                            data: {
                                labels: names,
                                datasets:[
                                    {
                                        label: 'Avance',
                                        data: id,
                                        backgroundColor: '#1d3f74',
                                    },
                                ]
                            },
                            plugins: [ChartDataLabels],
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                // indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let percentage = value+"%";
                                            //console.log(percentage);
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
            }
        });
    </script>
</body>
</html>