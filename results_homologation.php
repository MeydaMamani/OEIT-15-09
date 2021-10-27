<?php

use function PHPSTORM_META\type;

require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
    include('query_homologation.php');
    $row_cnt=0;
    while ($consulta = sqlsrv_fetch_array($consulta1)){
        $row_cnt++;
    }
?>
    <div class="container">
        <div class="homologation">
            <div class="text-center p-3">
              <h4>Homologación - <?php echo $nombre_mes; ?></h4>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4"><b class="align-middle">Cantidad de Registros: <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                    <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='homologation.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
                </div>
            </div>
            <div class="row mb-3">
              <div class="d-flex">
                <!-- <form action="impresion_gestante_tratamiento.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                </form> -->
            </div>
            <div class="row">
                <div class="col-6 table-responsive">
                    <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                        <thead>
                            <tr class="text-light font-12 text-center" style="background: #0f81db;">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Provincia</th>
                                <th class="align-middle">Distrito</th>
                                <th class="align-middle">Total</th>
                                <th class="align-middle">DNI Nulos</th>
                                <th class="align-middle">Eje Vial 1</th>
                                <th class="align-middle">Descripción</th>
                                <th class="align-middle">Referencia Descripción</th>
                                <th class="align-middle">Niño Visitado</th>
                            </tr>
                        </thead>
                        <div class="float-end pb-4">
                            <div class="form-group">
                                <div id="inputbus" class="input-group input-group-sm">
                                    <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                    <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                                </div>
                            </div>
                        </div>
                        <tbody>
                        <?php  
                            include('query_homologation.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta1)){  
                                // CAMBIO AQUI
                                if(is_null ($consulta['NOMBRE_PROV']) ){
                                  $newdate1 = '  -'; }
                                  else{
                                $newdate1 = $consulta['NOMBRE_PROV'] ;}
                
                                if(is_null ($consulta['NOMBRE_DIST']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['NOMBRE_DIST'] ;}
                    
                                if(is_null ($consulta['TOTAL']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['TOTAL'];}
                
                                if(is_null ($consulta['Nulosdni']) ){
                                  $newdate4 = '  -'; }
                                  else{
                                $newdate4 = $consulta['Nulosdni'];}
                                  
                                if(is_null ($consulta['NulosEJEVIAL1']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['NulosEJEVIAL1'];}
                    
                                if(is_null ($consulta['NuloDESCRIPCION']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['NuloDESCRIPCION'];}
                
                                if(is_null ($consulta['NULOREFERENCIADESCRIPCION']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['NULOREFERENCIADESCRIPCION'];}
                
                                if(is_null ($consulta['Nino_visitdo']) ){
                                  $newdate8 = '  -'; }
                                  else{
                                $newdate8 = $consulta['Nino_visitdo'];}
                
                                ?>
                                <tr style="font-size: 12px; text-align: center;">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                    <td class="align-middle"><?php echo $newdate3; ?></td>
                                    <td class="align-middle"><?php echo $newdate4; ?></td>
                                    <td class="align-middle"><?php echo $newdate5; ?></td>
                                    <td class="align-middle"><?php echo $newdate6; ?></td>
                                    <td class="align-middle"><?php echo $newdate7; ?></td>
                                    <td class="align-middle"><?php echo $newdate8; ?></td>
                                </tr>
                            <?php
                                ;}                    
                                include("cerrar.php");
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="">
                                        <ul class="pagination"></ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="col-1"></div>
                <div class="col-5 mt-5 text-center">
                    <canvas id="myChartProvince"></canvas>
                    <br>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-dark btn-sm m-2 btn_dac" name="province" value="DANIEL ALCIDES CARRION"> DANIEL ALCIDES CARRION</button>
                        <button class="btn btn-outline-primary btn-sm m-2 btn_oxa" name="province"> OXAPAMPA</button>
                        <button class="btn btn-outline-danger btn-sm m-2 btn_pasco" name="province"> PASCO</button>
                    </div><br>
                    <canvas id="myChartDistrict"></canvas>
                    <?php
                        include('query_homologation_graph_dist.php');
                        while ($consul = sqlsrv_fetch_array($con_red)){
                            echo 'ESTOY AQUI';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    
  <script src="./plugin/footable/js/footable-init.js"></script>
  <script src="./plugin/footable/js/footable.all.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
  <script>
    // grafico para provincia
    var ctx_province= document.getElementById("myChartProvince").getContext("2d");
    var myChartProvince= new Chart(ctx_province,{
        type: "bar",
        data:{
            labels:[
                <?php
                    include('query_homologation_graph.php');
                    $list_provinces = array();
                    $list_total = array();
                    while ($con = sqlsrv_fetch_array($consulta_red)){
                        $list_provinces[] = $con['NOMBRE_PROV'];
                        $list_total[] = $con['TOTAL'];
                    }
                    $num_prov = sizeof($list_provinces);         
                    $num_total = sizeof($list_total);

                    for ($i = 0; $i < $num_prov; $i++) {
                        $data = $list_provinces[$i];
                        if($data == 'DANIEL ALCIDES CARRION'){
                            $data = 'DANIEL A. CARRION';
                        }
                        echo "'$data', ";
                    }
                ?>
            ],
            datasets:[{
                label:'Niños Homologados',
                data:[
                    <?php
                        include('query_homologation_graph.php');
                        $list_provinces = array();
                        $list_total = array();
                        while ($con = sqlsrv_fetch_array($consulta_red)){
                            $list_provinces[] = $con['NOMBRE_PROV'];
                            $list_total[] = $con['TOTAL'];
                        }

                        $num_prov = sizeof($list_provinces);         
                        $num_total = sizeof($list_total);
                        for ($i = 0; $i < $num_total; $i++) {
                            $data = ($list_total[$i]);
                            echo "'$data', ";
                        }
                    ?>
                ],
                fill: false,
                backgroundColor: '#36a2eb',
            }]
        },
        options:{
            indexAxis: 'y',
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    $("button[name='province'").click(function(){
        var btn_dac = $(".btn_dac").val();
        var btn_oxa = $(".btn_oxa").val();
        var btn_pasco = $(".btn_pasco").val();
        $.ajax({
            url: 'query_homologation_graph_dist.php?red='+btn_dac,
            method: 'GET',
            success: function(data){
                console.log(data);
                // grafico para distrito
                var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
                var myChartDistrict= new Chart(ctx_district,{
                    type: "line",
                    data:{
                        labels:[
                            <?php
                                // echo 'TOY AQUI';
                                include('query_homologation_graph_dist.php');
                                while ($consul = sqlsrv_fetch_array($con_red)){
                                    echo $consul['NOMBRE_DIST'];
                                }
                                // $num_dist = sizeof($list_dist);
                                // for ($i = 0; $i < $num_dist; $i++) {
                                //     $data = $list_dist[$i];
                                //     echo "'$data', ";
                                // }
                            ?>
                        ],
                        datasets:[{
                            label:'Niños Homologados',
                            data:[
                                <?php
                                    include('query_homologation_graph_dist.php');
                                    $list_tot = array();
                                    while ($consul = sqlsrv_fetch_array($con_red)){
                                        $list_tot[] = $consul['TOTAL'];
                                    }
                                    $num_tot = sizeof($list_tot);    
                                    for ($i = 0; $i < $num_tot; $i++) {
                                        $data = ($list_tot[$i]);
                                        echo "'$data', ";
                                    }
                                ?>
                            ],
                            fill: false,
                            backgroundColor: '#36a2eb',
                            // borderColor: 'red',
                            tension: 0.1
                        }]
                    },
                    options:{
                        indexAxis: 'y',
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        })
    });

</script>
</body>
</html>