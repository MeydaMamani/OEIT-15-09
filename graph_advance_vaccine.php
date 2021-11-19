<?php
    require('abrir.php');
   
    global $conex;
    include('./base.php');
?>

    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-1">
              <h2>Avance de Vacunación</h2>
            </div><br>
            <div class="col-md-12">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Vacuna RN - Menor 1 Año</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Vacuna 1 Año - 4 Años</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <br><br>
                        <div class="row justify-content-center">
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/baby.png" width="60" alt="">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 500</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">BCG</p>
                                </div>
                            </div>
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/baby.png" width="60" alt="">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 234</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">HVB</h4>
                                </div>
                            </div>
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/feeding_bottle.png" width="60" alt="Imagen 1 año" class="mt-3">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 500</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">Influenza</p>
                                </div>
                            </div>
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/feeding_bottle.png" width="60" alt="Imagen 1 año" class="mt-3">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 234</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">Pentavalente</h4>
                                </div>
                            </div>
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/feeding_bottle.png" width="60" alt="Imagen 1 año" class="mt-3">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 500</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">Rotavirus</p>
                                </div>
                            </div>
                            <div class="card col-md-2 datos_avance">
                                <div class="card-body p-1">
                                    <div class="justify-content-center">
                                        <div class="align-self-center">
                                            <h4 class="font-medium mb-1 text-center d-flex">
                                                <div class="col-md-5 text-end">
                                                    <img src="./img/feeding_bottle.png" width="60" alt="Imagen 1 año" class="mt-3">
                                                </div>
                                                <div class="mt-2 col-md-7 d-flex align-items-center justify-content-end">
                                                    <b class="total font-40"> 234</b>
                                                </div>
                                            </h4>
                                        </div>
                                    </div>
                                    <p class="card-title text-secondary text-center font-23 p-0">Neumococo</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- RECIEN NACIDOS -->
                            <div class="col-md-6">
                                <div class="card" style="border-color: #337ab7;">
                                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Recién Nacido</h5>
                                    <div class="card-body">
                                        <div class="dac" style="height: 300px;">
                                            <canvas id="myChartProvince"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <div class="d-flex">
                                        <button class="btn-sm btn_dac1" id="btn_red" name="province" style="font-size: 11px;"> DANIEL A. CARRION</button><br>
                                        <button class="btn-sm btn_pasco1" id="btn_red" name="province" style="font-size: 11px;"> PASCO</button><br>
                                        <button class="btn-sm btn_oxa1" id="btn_red" name="province" style="font-size: 11px;"> OXAPAMPA</button>
                                    </div>
                                </div>
                                <div class="card" style="border-color: #337ab7;">
                                    <div class="x_district border border-secondary col-md-8" style="display: none;">
                                        <h4 class="p-2 text-capitalize">AVANCE DISTRITO DE <span class="name_dist"></span></h4>
                                        <div class="text-end m-r-30">
                                            <button class="btn btn-outline-secondary btn-sm" id="return"><i class="mdi mdi-keyboard-return"></i> Volver</button>
                                        </div>
                                        <div class="district_dac" style="height: 410px;">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- RECIEN NACIDOS -->
                            <div class="col-md-6">
                                <div class="card" style="border-color: #337ab7;">
                                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Menores de 1 Año</h5>
                                    <div class="card-body">
                                        <form name="f1" action="resultados_4_meses.php" method="post" class="_form_gestante">
                                            <div class="row">
                                                <div class="col-md">
                                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione una Red: </b></p>
                                                    <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                                        <option value="0" selected>Seleccione Red</option>
                                                        <option value="1">DANIEL ALCIDES CARRION</option> 
                                                        <option value="2">OXAPAMPA</option>
                                                        <option value="3">PASCO</option>
                                                        <option value="4">TODOS</option>
                                                    </select>
                                                </div>
                                                <div class="col-md text-mobile">
                                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione un Distrito: </b></p>
                                                    <select class="select_gestante form-select" name="distrito" id="distrito" aria-label="Default select example">
                                                        <option value="-">-</option>
                                                    </select>
                                                </div>
                                            </div><br>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione mes a evaluar: </b></p>
                                                    <select class="select_gestante form-select" name="mes" id="mes" aria-label="Default select example">
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
                                            </div><br>
                                            <div class="col-12 text-center">
                                                <button type="button" name="Buscar" class="btn text-white" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">.2..</div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script src="./js/Chart.min.js"></script>
    <script src="./js/chartjs-plugin-datalabels.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        // grafico para provincia
        var ctx_province= document.getElementById("myChartProvince").getContext("2d");
        var myChartProvince= new Chart(ctx_province,{
            type: "bar",
            data:{
                labels:[ "DANIEL A. CARRION", "OXAPAMPA", "PASCO" ],
                datasets:[
                    {
                        label:'BCG',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $BCG_24 = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $BCG_24[] = $con['BCG_24_HORAS'];
                                }
                                $num_total = sizeof($BCG_24);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $BCG_24[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'HVB',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $HVB_12 = array(); 
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $HVB_12[] = $con['HVB_12_HORAS'];
                                }
                                $num_total = sizeof($HVB_12);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $HVB_12[$i];
                                    echo "$data, ";
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
                plugins: {
                    legend: {
                        display: true
                    },
                    datalabels: {
                        formatter: (value, ctx) => {
                            let mydata = ctx.datasetIndex;
                            var mydata1 = ctx.dataIndex;
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

        // grafico para DISTRITO
        $("#btn_red").click(function(){
            $("#btn_red").click(function(){ saludar(this); });
            function saludar(e){
                console.log(e.innerText);
                var red = e.innerText;
                $('.district_dac').append("<canvas id='myChartDistrict'></canvas>");
                $.ajax({
                    url: 'query_graph_advance_vaccine.php?red='+red,
                    method: 'GET',
                    success: function(data) {
                        console.log('SOY DATA', data);
                        var mylist = data.split(', ');
                        console.log(mylist);
                        const ctx = document.getElementById('myChartDistrict').getContext('2d');
                        const myChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: ['BCG 24H', 'HVB 12H', 'IPV 2° DOSIS', 'APO 3° DOSIS', 'PENTAVALENTE 3° DOSIS', 'PENTAVALENTE DTP 3° DOSIS', 'PENTAVALENTE HVB 3° DOSIS', 'PENTAVALENTE HIV 3° DOSIS', 'ROTAVIRUS 2° DOSIS', 'NEOMOCOCO 2° DOSIS', 'INFLUENZA 2° DOSIS', 'NEUMOCOCO 3° DOSIS', 'SPR 1° DOSIS'],
                                datasets: [{
                                    label: 'Avance de Vacunación',
                                    data: mylist,
                                    backgroundColor: [ '#1d3f74' ],
                                    borderWidth: 1
                                }]
                            },
                            plugins: [ChartDataLabels],
                            options:{
                                responsive: true,
                                maintainAspectRatio: false,
                                indexAxis: 'y',
                                plugins: {
                                    legend: {
                                        display: true
                                    },
                                    datalabels: {
                                        formatter: (value, ctx) => {
                                            let mydata = ctx.datasetIndex;
                                            var mydata1 = ctx.dataIndex;
                                            if(mydata == 1){
                                                var data2 = ctx.chart.data.datasets[0].data;
                                                let percentage = (value*100 / data2[mydata1]);
                                                if (percentage - Math.floor(percentage) == 0) {
                                                    percentage = percentage.toFixed(0)+"%";
                                                } else {
                                                    percentage = percentage.toFixed(2)+"%";
                                                }
                                                return percentage;
                                            }
                                        },
                                        color: 'black',
                                        anchor: 'end',
                                        align: 'right',
                                        offset: 5
                                    }
                                },
                                scales: {
                                    y: {
                                    beginAtZero: true
                                    }
                                }
                            }
                        });                       
                    }
                })
            }    
        });
        $(".btn_oxa1").click(function(){
            console.log('ME DISTE CLICK OXA')
            $(".tbdac").hide();
            $(".tboxa").show();
            $(".tbpas").hide();
        });
        $(".btn_pasco1").click(function(){
            console.log('ME DISTE CLICK PASCO')
            $(".tbdac").hide();
            $(".tboxa").hide();
            $(".tbpas").show();
        });

   </script>
</body>
</html>