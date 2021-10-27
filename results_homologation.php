<?php
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
                
                                if(is_null ($consulta['CUMPLE_DNI']) ){
                                  $newdate4 = '  -'; }
                                  else{
                                $newdate4 = $consulta['CUMPLE_DNI'];}
                                  
                                if(is_null ($consulta['CUMPLE_EJEVIAL']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['CUMPLE_EJEVIAL'];}
                    
                                if(is_null ($consulta['CUMPLEDESCRIPCION']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['CUMPLEDESCRIPCION'];}
                
                                if(is_null ($consulta['CUMPLE_REFERENCIA']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['CUMPLE_REFERENCIA'];}
                
                                if(is_null ($consulta['Nino_VISITADO']) ){
                                  $newdate8 = '  -'; }
                                  else{
                                $newdate8 = $consulta['Nino_VISITADO'];}
                
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
                <div class="col-1 p-0"></div>
                <div class="col-5 mt-5 text-center">
                    <div class="border border-secondary">
                        <canvas id="myChartProvince"></canvas>
                    </div><br>
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-outline-dark btn-sm m-2 btn_dac" name="province" value="DANIEL ALCIDES CARRION"> DANIEL ALCIDES CARRION</button>
                        <button class="btn btn-outline-primary btn-sm m-2 btn_oxa" name="province"> OXAPAMPA</button>
                        <button class="btn btn-outline-danger btn-sm m-2 btn_pasco" name="province"> PASCO</button>
                    </div><br>
                    <div>
                        <canvas id="myChartDistrict"></canvas>
                    </div>
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
                label:'Niños Homologados TOTAL',
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
            },
            {
                label:'Niños Homologados AVANCE',
                data:[
                    <?php
                        include('query_homologation_graph.php');
                        $resul_menor = "WITH A AS( Select NOMBRE_PROV,NOMBRE_DIST,
                                        COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                                        count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                                        count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                                        count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                                        count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                                        count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                                        from sellomunicipal
                                        where MES_A_MEDIR='SETIEMBRE' 
                                        group by NOMBRE_PROV,NOMBRE_DIST) SELECT NOMBRE_PROV,NOMBRE_DIST, TOTAL, 
                                        CASE 
                                            WHEN CUMPLE_DNI<CUMPLE_EJEVIAL AND CUMPLE_DNI<CUMPLEDESCRIPCION AND CUMPLE_DNI<CUMPLE_REFERENCIA AND CUMPLE_DNI<Nino_VISITADO THEN CUMPLE_DNI 
                                            WHEN CUMPLE_EJEVIAL<CUMPLE_DNI AND CUMPLE_EJEVIAL<CUMPLEDESCRIPCION AND CUMPLE_EJEVIAL<CUMPLE_REFERENCIA AND CUMPLE_EJEVIAL<Nino_VISITADO THEN CUMPLE_DNI 
                                            WHEN CUMPLE_EJEVIAL<CUMPLE_DNI AND CUMPLE_EJEVIAL<CUMPLEDESCRIPCION AND CUMPLE_EJEVIAL<CUMPLE_REFERENCIA AND CUMPLE_EJEVIAL<Nino_VISITADO THEN CUMPLE_DNI 
                                            WHEN CUMPLE_REFERENCIA<CUMPLE_DNI AND CUMPLE_REFERENCIA<CUMPLE_EJEVIAL AND CUMPLE_REFERENCIA<CUMPLE_EJEVIAL AND CUMPLE_REFERENCIA<Nino_VISITADO THEN CUMPLE_DNI 
                                            ELSE Nino_VISITADO END AS 'MENOR'
                                        FROM A                        
                                        DROP TABLE sellomunicipal";
                        $list_provinces = array();
                        $list_total = array();
                        $consulta = sqlsrv_query($conn2, $resultado);
                        $consulta1 = sqlsrv_query($conn2, $resul_menor);
                        while ($con = sqlsrv_fetch_array($consulta1)){
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
                backgroundColor: '#ffcd56',
            },
            ]
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

        $(".btn_dac").click(function(){
            var mylabels = [<?php 
                include('query_homologation.php');
                $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                            count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='DANIEL ALCIDES CARRION'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";

                $consulta = sqlsrv_query($conn2, $resultado);
                $consulta1 = sqlsrv_query($conn2, $resultado2);    
                $list_dists = array();
                $list_tots = array();
                while ($con = sqlsrv_fetch_array($consulta1)){
                    $list_dists[] = $con['NOMBRE_DIST'];
                    $list_tots[] = $con['TOTAL'];
                }

                $num_dists = sizeof($list_dists);         
                $num_total = sizeof($list_tots);
                for ($i = 0; $i < $num_dists; $i++) {
                    $data = ($list_dists[$i]);
                    echo "'$data', ";
                }
             ?>
            ]
            var datos1 = {
                label:'Niños Homologados',
                data: [<?php 
                    include('query_homologation.php');
                    $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                                count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                                count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                                count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                                count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                                count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                                from sellomunicipal
                                where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='DANIEL ALCIDES CARRION'
                                group by NOMBRE_PROV,NOMBRE_DIST
                                ORDER BY NOMBRE_PROV, NOMBRE_DIST
                                DROP TABLE sellomunicipal";

                    $consulta = sqlsrv_query($conn2, $resultado);
                    $consulta1 = sqlsrv_query($conn2, $resultado2);    
                    $list_dists = array();
                    $list_tots = array();
                    while ($con = sqlsrv_fetch_array($consulta1)){
                        $list_prov[] = $con['NOMBRE_DIST'];
                        $list_tots[] = $con['TOTAL'];
                    }

                    $num_dists = sizeof($list_dists);         
                    $num_total = sizeof($list_tots);
                    for ($i = 0; $i < $num_total; $i++) {
                        $data = ($list_tots[$i]);
                        echo "'$data', ";
                    }
                ?>],
                backgroundColor: '#4bc0c0',// Color de fondo
                borderColor: '#4bc0c0',
                fill: false,
                tension: 0.1
            };

            var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
            var myChartDistrict= new Chart(ctx_district,{
                type: "line",
                data:{
                    labels: mylabels,
                    datasets:[datos1 ]
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
        });
        $(".btn_oxa").click(function(){
            var mylabels = [<?php 
                include('query_homologation.php');
                $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                            count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='OXAPAMPA'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";

                $consulta = sqlsrv_query($conn2, $resultado);
                $consulta1 = sqlsrv_query($conn2, $resultado2);    
                $list_dists = array();
                $list_tots = array();
                while ($con = sqlsrv_fetch_array($consulta1)){
                    $list_dists[] = $con['NOMBRE_DIST'];
                    $list_tots[] = $con['TOTAL'];
                }

                $num_dists = sizeof($list_dists);         
                $num_total = sizeof($list_tots);
                for ($i = 0; $i < $num_dists; $i++) {
                    $data = ($list_dists[$i]);
                    echo "'$data', ";
                }
             ?>
            ]
            var datos1 = {
                label:'Niños Homologados',
                data: [<?php 
                    include('query_homologation.php');
                    $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                                count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                                count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                                count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                                count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                                count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                                from sellomunicipal
                                where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='OXAPAMPA'
                                group by NOMBRE_PROV,NOMBRE_DIST
                                ORDER BY NOMBRE_PROV, NOMBRE_DIST
                                DROP TABLE sellomunicipal";

                    $consulta = sqlsrv_query($conn2, $resultado);
                    $consulta1 = sqlsrv_query($conn2, $resultado2);    
                    $list_dists = array();
                    $list_tots = array();
                    while ($con = sqlsrv_fetch_array($consulta1)){
                        $list_prov[] = $con['NOMBRE_DIST'];
                        $list_tots[] = $con['TOTAL'];
                    }

                    $num_dists = sizeof($list_dists);         
                    $num_total = sizeof($list_tots);
                    for ($i = 0; $i < $num_total; $i++) {
                        $data = ($list_tots[$i]);
                        echo "'$data', ";
                    }
                ?>],
                backgroundColor: '#4bc0c0',// Color de fondo
                borderColor: '#4bc0c0',
                fill: false,
                tension: 0.1
            };
            var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
            var myChartDistrict= new Chart(ctx_district,{
                type: "line",
                data:{
                    labels: mylabels,
                    datasets:[datos1 ]
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
        });
        $(".btn_pasco").click(function(){
            var mylabels = [<?php 
                include('query_homologation.php');
                $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                            count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                            count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                            count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                            count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                            count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                            from sellomunicipal
                            where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='PASCO'
                            group by NOMBRE_PROV,NOMBRE_DIST
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST
                            DROP TABLE sellomunicipal";

                $consulta = sqlsrv_query($conn2, $resultado);
                $consulta1 = sqlsrv_query($conn2, $resultado2);    
                $list_dists = array();
                $list_tots = array();
                while ($con = sqlsrv_fetch_array($consulta1)){
                    $list_dists[] = $con['NOMBRE_DIST'];
                    $list_tots[] = $con['TOTAL'];
                }

                $num_dists = sizeof($list_dists);         
                $num_total = sizeof($list_tots);
                for ($i = 0; $i < $num_dists; $i++) {
                    $data = ($list_dists[$i]);
                    echo "'$data', ";
                }
             ?>
            ]
            var datos1 = {
                label:'Niños Homologados',
                data: [<?php 
                    include('query_homologation.php');
                    $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
                                count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
                                count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
                                count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
                                count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
                                count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
                                from sellomunicipal
                                where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='PASCO'
                                group by NOMBRE_PROV,NOMBRE_DIST
                                ORDER BY NOMBRE_PROV, NOMBRE_DIST
                                DROP TABLE sellomunicipal";

                    $consulta = sqlsrv_query($conn2, $resultado);
                    $consulta1 = sqlsrv_query($conn2, $resultado2);    
                    $list_dists = array();
                    $list_tots = array();
                    while ($con = sqlsrv_fetch_array($consulta1)){
                        $list_prov[] = $con['NOMBRE_DIST'];
                        $list_tots[] = $con['TOTAL'];
                    }

                    $num_dists = sizeof($list_dists);         
                    $num_total = sizeof($list_tots);
                    for ($i = 0; $i < $num_total; $i++) {
                        $data = ($list_tots[$i]);
                        echo "'$data', ";
                    }
                ?>],
                backgroundColor: '#4bc0c0',// Color de fondo
                borderColor: '#4bc0c0',
                fill: false,
                tension: 0.1
            };
            var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
            var myChartDistrict= new Chart(ctx_district,{
                type: "line",
                data:{
                    labels: mylabels,
                    datasets:[datos1 ]
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
        });

</script>
</body>
</html>