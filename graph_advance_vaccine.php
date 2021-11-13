<?php
    require('abrir.php');
   
    global $conex;
    include('./base.php');
?>

    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
              <h2 style="color: #0d6cb8;">AVANCE DE VACUNACIÓN</h2>
            </div><br>
            <div class="row">
                <div class="col-md-8 p-0 text-center">
                    <div class="border border-secondary">
                        <div class="x_province">
                            <h4 class="p-2">AVANCE REGIONAL</h4>
                            <div class="dac" style="height: 300px;">
                                <canvas id="myChartProvince"></canvas>
                            </div>
                        </div>
                    </div><br><br>
                    <div class="row">
                        <div class="border border-secondary col-md-4">
                            <div class="col-12" style="display: none;">
                            </div>
                            <div class="col-md-12">
                                <div class="justify-content-center position-absolute" style="margin-top: 8%; margin-left: 65px; display: grid;">
                                    <button class="btn-sm btn_dac1" id="btn_dac" name="province" style="font-size: 11px;"> DANIEL A. CARRION</button><br>
                                    <button class="btn-sm btn_pasco1" name="province" style="font-size: 11px;"> PASCO</button><br>
                                    <button class="btn-sm btn_oxa1" name="province" style="font-size: 11px;"> OXAPAMPA</button>
                                </div>
                                <img src="./img/mapa_peru.png" alt="" style="width: 105%;">
                            </div>
                        </div>                    
                        <div class="table-responsive col-md-8" id="no_graph_district">    
                            <table id="demo-foo-addrow2" class="table table-hover table-bordered tbdac">
                                <thead>
                                    <tr class="text-light font-12 text-center" style="background: #0d6cb8;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">BGC 24 Horas</th>
                                        <th class="align-middle">HVB 12 Horas</th>
                                        <th class="align-middle">IPV 2da Dosis</th>
                                        <th class="align-middle">APO 3era Dosis</th>
                                        <th class="align-middle">Penta 3era Dosis</th>
                                        <th class="align-middle">Penta DTP 3era Dosis</th>
                                        <th class="align-middle">Penta HVB 3era Dosis</th>
                                        <th class="align-middle">Penta HIB 3era Dosis</th>
                                        <th class="align-middle">Rotavirus 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2da Dosis</th>
                                        <th class="align-middle">Influenza 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2ra Dosis</th>
                                        <th class="align-middle">SPR 1ra Dosis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include('query_graph_advance_vaccine.php');
                                        $i_dac=0;
                                        while ($consulta = sqlsrv_fetch_array($consulta2)){ 
                                            // CAMBIO AQUI                    
                                            if(is_null ($consulta['Distrito']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Distrito'] ;}
                                
                                            if(is_null ($consulta['BCG_24_HORAS']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['BCG_24_HORAS'];}
                            
                                            if(is_null ($consulta['HVB_12_HORAS']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                            $newdate4 = $consulta['HVB_12_HORAS'];}
                                            
                                            if(is_null ($consulta['IPV_02_04_MESES_2_DOSIS']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['IPV_02_04_MESES_2_DOSIS'];}
                                
                                            if(is_null ($consulta['APO_06_MESES_3ra_Dosis']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['APO_06_MESES_3ra_Dosis'];}
                            
                                            if(is_null ($consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis']) ){
                                                $newdate7 = '  -'; }
                                            else{
                                                $newdate7 = $consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis'];}
                            
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis']) ){
                                                $newdate8 = '  -'; }
                                            else{
                                                $newdate8 = $consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis']) ){
                                                $newdate9 = '  -'; }
                                            else{
                                                $newdate9 = $consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis']) ){
                                                $newdate10 = '  -'; }
                                            else{
                                                $newdate10 = $consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis'];}
                                            
                                            if(is_null ($consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS']) ){
                                                $newdate11 = '  -'; }
                                            else{
                                                $newdate11 = $consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS'];}                
                            
                                            if(is_null ($consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS']) ){
                                                $newdate12 = '  -'; }
                                            else{
                                                $newdate12 = $consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['INFLUENZA_2da_DOSIS']) ){
                                                $newdate13 = '  -'; }
                                            else{
                                                $newdate13 = $consulta['INFLUENZA_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS']) ){
                                                $newdate14 = '  -'; }
                                            else{
                                                $newdate14 = $consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS'];}
                        
                                            if(is_null ($consulta['SPR_1_ANIO_1ra_DOSIS']) ){
                                                $newdate15 = '  -'; }
                                            else{
                                                $newdate15 = $consulta['SPR_1_ANIO_1ra_DOSIS'];}
                                    ?>
                                    <tr style="font-size: 11px; text-align: center;">
                                        <td class="align-middle"><?php echo ++$i_dac; ?></td>
                                        <td class="align-middle" style="cursor: pointer;" id="tb_district_dac<?php echo $i_dac; ?>"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle"><?php echo $newdate3; ?></td>
                                        <td class="align-middle"><?php echo $newdate4; ?></td>
                                        <td class="align-middle"><?php echo $newdate5; ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>
                                        <td class="align-middle"><?php echo $newdate8; ?></td>
                                        <td class="align-middle"><?php echo $newdate9; ?></td>
                                        <td class="align-middle"><?php echo $newdate10; ?></td>
                                        <td class="align-middle"><?php echo $newdate11; ?></td>
                                        <td class="align-middle"><?php echo $newdate12; ?></td>
                                        <td class="align-middle"><?php echo $newdate13; ?></td>
                                        <td class="align-middle"><?php echo $newdate14; ?></td>
                                        <td class="align-middle"><?php echo $newdate15; ?></td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                            </table>
                            <table id="demo-foo-addrow2" class="table table-hover table-bordered tboxa" style="display: none;">
                                <thead>
                                    <tr class="text-light font-12 text-center" style="background: #0d6cb8;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">BGC 24 Horas</th>
                                        <th class="align-middle">HVB 12 Horas</th>
                                        <th class="align-middle">IPV 2da Dosis</th>
                                        <th class="align-middle">APO 3era Dosis</th>
                                        <th class="align-middle">Penta 3era Dosis</th>
                                        <th class="align-middle">Penta DTP 3era Dosis</th>
                                        <th class="align-middle">Penta HVB 3era Dosis</th>
                                        <th class="align-middle">Penta HIB 3era Dosis</th>
                                        <th class="align-middle">Rotavirus 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2da Dosis</th>
                                        <th class="align-middle">Influenza 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2ra Dosis</th>
                                        <th class="align-middle">SPR 1ra Dosis</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        include('query_graph_advance_vaccine.php');
                                        $i_oxa=0;
                                        while ($consulta = sqlsrv_fetch_array($consulta3)){ 
                                            // CAMBIO AQUI                    
                                            if(is_null ($consulta['Distrito']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Distrito'] ;}
                                
                                            if(is_null ($consulta['BCG_24_HORAS']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['BCG_24_HORAS'];}
                            
                                            if(is_null ($consulta['HVB_12_HORAS']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                            $newdate4 = $consulta['HVB_12_HORAS'];}
                                            
                                            if(is_null ($consulta['IPV_02_04_MESES_2_DOSIS']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['IPV_02_04_MESES_2_DOSIS'];}
                                
                                            if(is_null ($consulta['APO_06_MESES_3ra_Dosis']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['APO_06_MESES_3ra_Dosis'];}
                            
                                            if(is_null ($consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis']) ){
                                                $newdate7 = '  -'; }
                                            else{
                                                $newdate7 = $consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis'];}
                            
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis']) ){
                                                $newdate8 = '  -'; }
                                            else{
                                                $newdate8 = $consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis']) ){
                                                $newdate9 = '  -'; }
                                            else{
                                                $newdate9 = $consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis']) ){
                                                $newdate10 = '  -'; }
                                            else{
                                                $newdate10 = $consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis'];}
                                            
                                            if(is_null ($consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS']) ){
                                                $newdate11 = '  -'; }
                                            else{
                                                $newdate11 = $consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS'];}                
                            
                                            if(is_null ($consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS']) ){
                                                $newdate12 = '  -'; }
                                            else{
                                                $newdate12 = $consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['INFLUENZA_2da_DOSIS']) ){
                                                $newdate13 = '  -'; }
                                            else{
                                                $newdate13 = $consulta['INFLUENZA_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS']) ){
                                                $newdate14 = '  -'; }
                                            else{
                                                $newdate14 = $consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS'];}
                        
                                            if(is_null ($consulta['SPR_1_ANIO_1ra_DOSIS']) ){
                                                $newdate15 = '  -'; }
                                            else{
                                                $newdate15 = $consulta['SPR_1_ANIO_1ra_DOSIS'];}
                                    ?>
                                    <tr style="font-size: 11px; text-align: center;">
                                        <td class="align-middle"><?php echo ++$i_oxa; ?></td>
                                        <td class="align-middle" style="cursor: pointer;" id="tb_district_oxa<?php echo $i_oxa; ?>"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle"><?php echo $newdate3; ?></td>
                                        <td class="align-middle"><?php echo $newdate4; ?></td>
                                        <td class="align-middle"><?php echo $newdate5; ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>
                                        <td class="align-middle"><?php echo $newdate8; ?></td>
                                        <td class="align-middle"><?php echo $newdate9; ?></td>
                                        <td class="align-middle"><?php echo $newdate10; ?></td>
                                        <td class="align-middle"><?php echo $newdate11; ?></td>
                                        <td class="align-middle"><?php echo $newdate12; ?></td>
                                        <td class="align-middle"><?php echo $newdate13; ?></td>
                                        <td class="align-middle"><?php echo $newdate14; ?></td>
                                        <td class="align-middle"><?php echo $newdate15; ?></td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                            </table> 
                            <table id="demo-foo-addrow2" class="table table-hover table-bordered tbpas" style="display: none;">
                                <thead>
                                    <tr class="text-light font-12 text-center" style="background: #0d6cb8;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">BGC 24 Horas</th>
                                        <th class="align-middle">HVB 12 Horas</th>
                                        <th class="align-middle">IPV 2da Dosis</th>
                                        <th class="align-middle">APO 3era Dosis</th>
                                        <th class="align-middle">Penta 3era Dosis</th>
                                        <th class="align-middle">Penta DTP 3era Dosis</th>
                                        <th class="align-middle">Penta HVB 3era Dosis</th>
                                        <th class="align-middle">Penta HIB 3era Dosis</th>
                                        <th class="align-middle">Rotavirus 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2da Dosis</th>
                                        <th class="align-middle">Influenza 2da Dosis</th>
                                        <th class="align-middle">Neumococo 2ra Dosis</th>
                                        <th class="align-middle">SPR 1ra Dosis</th>
                                    </tr>
                                </thead>  
                                <tbody>
                                    <?php 
                                        include('query_graph_advance_vaccine.php');
                                        $i_pas=0;
                                        while ($consulta = sqlsrv_fetch_array($consulta4)){ 
                                            // CAMBIO AQUI                    
                                            if(is_null ($consulta['Distrito']) ){
                                                $newdate2 = '  -'; }
                                                else{
                                            $newdate2 = $consulta['Distrito'] ;}
                                
                                            if(is_null ($consulta['BCG_24_HORAS']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['BCG_24_HORAS'];}
                            
                                            if(is_null ($consulta['HVB_12_HORAS']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                            $newdate4 = $consulta['HVB_12_HORAS'];}
                                            
                                            if(is_null ($consulta['IPV_02_04_MESES_2_DOSIS']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['IPV_02_04_MESES_2_DOSIS'];}
                                
                                            if(is_null ($consulta['APO_06_MESES_3ra_Dosis']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['APO_06_MESES_3ra_Dosis'];}
                            
                                            if(is_null ($consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis']) ){
                                                $newdate7 = '  -'; }
                                            else{
                                                $newdate7 = $consulta['PENTAVALENTE_02_04_06_MESES_3ra_dosis'];}
                            
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis']) ){
                                                $newdate8 = '  -'; }
                                            else{
                                                $newdate8 = $consulta['Reacciones_Adversas_pentavalente_DTP_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis']) ){
                                                $newdate9 = '  -'; }
                                            else{
                                                $newdate9 = $consulta['Reacciones_Adversas_pentavalente_HvB_3ra_dosis'];}
                        
                                            if(is_null ($consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis']) ){
                                                $newdate10 = '  -'; }
                                            else{
                                                $newdate10 = $consulta['Reacciones_Adversas_pentavalente_HiB_3ra_dosis'];}
                                            
                                            if(is_null ($consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS']) ){
                                                $newdate11 = '  -'; }
                                            else{
                                                $newdate11 = $consulta['ROTAVIRUS_02_04_MESES_2da_DOSIS'];}                
                            
                                            if(is_null ($consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS']) ){
                                                $newdate12 = '  -'; }
                                            else{
                                                $newdate12 = $consulta['NEUMOCOCO_02_04_MESES_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['INFLUENZA_2da_DOSIS']) ){
                                                $newdate13 = '  -'; }
                                            else{
                                                $newdate13 = $consulta['INFLUENZA_2da_DOSIS'];}
                        
                                            if(is_null ($consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS']) ){
                                                $newdate14 = '  -'; }
                                            else{
                                                $newdate14 = $consulta['NEUMOCOCO_1_ANIO_3ra_DOSIS'];}
                        
                                            if(is_null ($consulta['SPR_1_ANIO_1ra_DOSIS']) ){
                                                $newdate15 = '  -'; }
                                            else{
                                                $newdate15 = $consulta['SPR_1_ANIO_1ra_DOSIS'];}
                                    ?>
                                    <tr style="font-size: 11px; text-align: center;">
                                        <td class="align-middle"><?php echo ++$i_pas; ?></td>
                                        <td class="align-middle" style="cursor: pointer;" id="tb_district_pasco<?php echo $i_pas; ?>"><?php echo utf8_encode($newdate2); ?></td>
                                        <td class="align-middle"><?php echo $newdate3; ?></td>
                                        <td class="align-middle"><?php echo $newdate4; ?></td>
                                        <td class="align-middle"><?php echo $newdate5; ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>
                                        <td class="align-middle"><?php echo $newdate8; ?></td>
                                        <td class="align-middle"><?php echo $newdate9; ?></td>
                                        <td class="align-middle"><?php echo $newdate10; ?></td>
                                        <td class="align-middle"><?php echo $newdate11; ?></td>
                                        <td class="align-middle"><?php echo $newdate12; ?></td>
                                        <td class="align-middle"><?php echo $newdate13; ?></td>
                                        <td class="align-middle"><?php echo $newdate14; ?></td>
                                        <td class="align-middle"><?php echo $newdate15; ?></td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody> 
                            </table>    
                        </div>
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
                <div class="col-1"></div>
                <div class="col-md-3 text-center">
                    <div id="chart_div" style="width: 400px; height: 120px;"></div>
                    <br>
                    <canvas id="myPieChart" width="600" height="400"></canvas>
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
   <script type="text/javascript">
      google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Memory', 80],
        ]);

        var options = {
          width: 400, height: 120,
          redFrom: 90, redTo: 100,
          yellowFrom:75, yellowTo: 90,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
          chart.draw(data, options);
        }, 13000);
      }
</script>

    <script>
        var ctx = document.getElementById("myPieChart").getContext('2d');
        var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ["Makassar", "Bulukumba", "Gowa"],
            datasets: [{
            label: 'Avance de Vacunación',
            data:[4000, 3000, 2000, 5000],
            backgroundColor: ['#007bff', '#ffc107', '#28a745'],
            }],
        },
        options:{
                tooltips:{
                callbacks:{
                    label: (ttItem) => (`${ttItem.label}: Rp. ${ttItem.parsed}`)
                }
                }
            }
        });

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
                    {
                        label:'IPV',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $IPV_04 = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $IPV_04[] = $con['IPV_02_04_MESES_2_DOSIS'];
                                }
                                $num_total = sizeof($IPV_04);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $IPV_04[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'APO',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $APO = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $APO[] = $con['APO_06_MESES_3ra_Dosis'];
                                }
                                $num_total = sizeof($APO);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $APO[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Pentavalente',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $penta_meses = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $penta_meses[] = $con['PENTAVALENTE_02_04_06_MESES_3ra_dosis'];
                                }
                                $num_total = sizeof($penta_meses);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $penta_meses[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Reacción Pentavalente DPT',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $penta_dpt = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $penta_dpt[] = $con['Reacciones_Adversas_pentavalente_DTP_3ra_dosis'];
                                }
                                $num_total = sizeof($penta_dpt);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $penta_dpt[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Reacción Pentavalente HVB',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $penta_hvb = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $penta_hvb[] = $con['Reacciones_Adversas_pentavalente_HvB_3ra_dosis'];
                                }
                                $num_total = sizeof($penta_hvb);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $penta_hvb[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Reacción Pentavalente HIB',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $penta_hib = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $penta_hib[] = $con['Reacciones_Adversas_pentavalente_HiB_3ra_dosis'];
                                }
                                $num_total = sizeof($penta_hib);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $penta_hib[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Rotavirus',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $rotavirus = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $rotavirus[] = $con['ROTAVIRUS_02_04_MESES_2da_DOSIS'];
                                }
                                $num_total = sizeof($rotavirus);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $rotavirus[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Neumococo Meses',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $neumococo = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $neumococo[] = $con['NEUMOCOCO_02_04_MESES_2da_DOSIS'];
                                }
                                $num_total = sizeof($neumococo);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $neumococo[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Influenza',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $influenza = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $influenza[] = $con['INFLUENZA_2da_DOSIS'];
                                }
                                $num_total = sizeof($influenza);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $influenza[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'Neumococo Año',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $neumo_anio = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $neumo_anio[] = $con['NEUMOCOCO_1_ANIO_3ra_DOSIS'];
                                }
                                $num_total = sizeof($neumo_anio);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $neumo_anio[$i];
                                    echo "$data, ";
                                }
                            ?>
                        ],
                        backgroundColor: '#1d3f74',
                    },
                    {
                        label:'SPR',
                        data:[
                            <?php
                                include('query_graph_advance_vaccine.php');
                                $spr = array();
                                while ($con = sqlsrv_fetch_array($consulta1)){
                                    $spr[] = $con['SPR_1_ANIO_1ra_DOSIS'];
                                }
                                $num_total = sizeof($spr);
                                for ($i = 0; $i < $num_total; $i++) {
                                    $data = $spr[$i];
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
        $(".btn_dac1").click(function(){
            console.log('ME DISTE CLICK DAC')
            $(".tbdac").show();
            $(".tboxa").hide();
            $(".tbpas").hide();
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

        var i_dac = <?php echo $i_dac; ?>;
        for (i = 1; i <= i_dac; i++) {
            $("#tb_district_dac"+i).click(function(){ saludar(this); });
            function saludar(e){
                console.log(e.innerText);
                var dist = e.innerText;
                $('.district_dac').append("<canvas id='myChartDistrict'></canvas>");                
                $("#no_graph_district").hide();
                $(".x_district").show();
                $(".name_dist").text(dist);
                $.ajax({
                    url: 'query_graph_advance_vaccine_district.php?dist='+dist,
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
        }

        var i_oxa = <?php echo $i_oxa; ?>;
        for (i = 1; i <= i_oxa; i++) {
            $("#tb_district_oxa"+i).click(function(){ saludar(this); });
            function saludar(e){
                console.log(e.innerText);
                var dist = e.innerText;
                $('.district_dac').append("<canvas id='myChartDistrict1'></canvas>");                
                $("#no_graph_district").hide();
                $(".x_district").show();
                $(".name_dist").text(dist);
                $.ajax({
                    url: 'query_graph_advance_vaccine_district.php?dist='+dist,
                    method: 'GET',
                    success: function(data) {
                        console.log('SOY DATA', data);
                        var mylist = data.split(', ');
                        console.log(mylist);

                        const ctx = document.getElementById('myChartDistrict1').getContext('2d');
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
        }

        var i_pas = <?php echo $i_pas; ?>;
        for (i = 1; i <= i_pas; i++) {
            $("#tb_district_pasco"+i).click(function(){ saludar(this); });
            function saludar(e){
                console.log(e.innerText);
                var dist = e.innerText;
                $('.district_dac').append("<canvas id='myChartDistrict2'></canvas>");                
                $("#no_graph_district").hide();
                $(".x_district").show();
                $(".name_dist").text(dist);
                $.ajax({
                    url: 'query_graph_advance_vaccine_district.php?dist='+dist,
                    method: 'GET',
                    success: function(data) {
                        console.log('SOY DATA', data);
                        var mylist = data.split(', ');
                        console.log(mylist);

                        const ctx = document.getElementById('myChartDistrict2').getContext('2d');
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
        }

        $("#return").click(function(){
            $("#no_graph_district").show();
            $(".x_district").hide();
            $(".district_dac").empty();
        });
    </script>
</body>
</html>