<?php
    require('abrir.php');
   
    global $conex;
    include('./base.php');
?>
    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
              <h4>AVANCE DE VACUNACIÓN</h4>
            </div><br>
            <div class="row">
                <div class="col-md-9 p-0 text-center">
                    <div class="border border-secondary">
                        <div class="x_province">
                            <h4 class="p-2">Avance Regional</h4>
                            <div class="dac" style="height: 300px;">
                                <canvas id="myChartProvince"></canvas>
                            </div>
                        </div>
                    </div><br><br>
                    <div class="table-responsive" id="no_graph_district">
                        <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                            <thead>
                                <tr class="text-light font-12 text-center" style="background: #0f81db;">
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
                            <tbody class="tbdac">
                                <?php 
                                    include('query_graph_advance_vaccine.php');
                                    $i=1;
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
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle" id="my_district"><?php echo utf8_encode($newdate2); ?></td>
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
                            <tbody class="tboxa" style="display: none;">
                                <?php 
                                    include('query_graph_advance_vaccine.php');
                                    $i=1;
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
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
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
                            <tbody class="tbpas" style="display: none;">
                                <?php 
                                    include('query_graph_advance_vaccine.php');
                                    $i=1;
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
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
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
                    <div id="graph_district">
                        <h4 class="p-2">Avance Distrital</h4>
                        <div class="dac" style="height: 410px;">
                            <canvas id="myChartDistrict"></canvas>
                        </div>
                    </div>
                    <div class="x_district">
                        <h4 class="p-2">Avance Distrital</h4>
                        <div class="dac" style="height: 300px; display: none;">
                            <canvas id="myChartDistrict"></canvas>
                        </div>
                        <div class="oxa" style="height: 300px; display: none;">
                            <canvas id="myChartDistrict1"></canvas>
                        </div>
                        <div class="pasco" style="height: 300px; display: none;">
                            <canvas id="myChartDistrict2"></canvas>
                        </div>
                    </div>
                    <div class="border border-secondary">
                        <div class="col-12" style="width: 110%;">
                            <div class="d-flex justify-content-center">
                                <button class="btn-sm btn_dac" id="btn_dac" name="province" value="DANIEL ALCIDES CARRION"> DANIEL A. CARRION</button>
                                <button class="btn-sm btn_pasco" name="province"> PASCO</button>
                                <button class="btn-sm btn_oxa" name="province"> OXAPAMPA</button>
                            </div>
                        </div><br>
                    </div><br>
                </div>
            </div>
        </div>
    </div>
    
    <script src="./js/records_menu.js"></script>
    <!-- <script src="./js/select2.js"></script> -->
    <!-- <script src="./js/district.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- <script>
        $( document ).ready(function() {
            $("#btn_dac").click();
        });
    </script> -->
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
                    // {
                    //     label:'IPV',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $IPV_04 = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $IPV_04[] = $con['IPV_02_04_MESES_2_DOSIS'];
                    //             }
                    //             $num_total = sizeof($IPV_04);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $IPV_04[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'APO',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $APO = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $APO[] = $con['APO_06_MESES_3ra_Dosis'];
                    //             }
                    //             $num_total = sizeof($APO);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $APO[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Pentavalente',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $penta_meses = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $penta_meses[] = $con['PENTAVALENTE_02_04_06_MESES_3ra_dosis'];
                    //             }
                    //             $num_total = sizeof($penta_meses);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $penta_meses[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Reacción Pentavalente DPT',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $penta_dpt = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $penta_dpt[] = $con['Reacciones_Adversas_pentavalente_DTP_3ra_dosis'];
                    //             }
                    //             $num_total = sizeof($penta_dpt);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $penta_dpt[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Reacción Pentavalente HVB',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $penta_hvb = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $penta_hvb[] = $con['Reacciones_Adversas_pentavalente_HvB_3ra_dosis'];
                    //             }
                    //             $num_total = sizeof($penta_hvb);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $penta_hvb[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Reacción Pentavalente HIB',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $penta_hib = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $penta_hib[] = $con['Reacciones_Adversas_pentavalente_HiB_3ra_dosis'];
                    //             }
                    //             $num_total = sizeof($penta_hib);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $penta_hib[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Rotavirus',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $rotavirus = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $rotavirus[] = $con['ROTAVIRUS_02_04_MESES_2da_DOSIS'];
                    //             }
                    //             $num_total = sizeof($rotavirus);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $rotavirus[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Neumococo Meses',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $neumococo = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $neumococo[] = $con['NEUMOCOCO_02_04_MESES_2da_DOSIS'];
                    //             }
                    //             $num_total = sizeof($neumococo);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $neumococo[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Influenza',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $influenza = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $influenza[] = $con['INFLUENZA_2da_DOSIS'];
                    //             }
                    //             $num_total = sizeof($influenza);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $influenza[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'Neumococo Año',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $neumo_anio = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $neumo_anio[] = $con['NEUMOCOCO_1_ANIO_3ra_DOSIS'];
                    //             }
                    //             $num_total = sizeof($neumo_anio);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $neumo_anio[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
                    // {
                    //     label:'SPR',
                    //     data:[
                    //         <?php
                    //             include('query_graph_advance_vaccine.php');
                    //             $spr = array();
                    //             while ($con = sqlsrv_fetch_array($consulta1)){
                    //                 $spr[] = $con['SPR_1_ANIO_1ra_DOSIS'];
                    //             }
                    //             $num_total = sizeof($spr);
                    //             for ($i = 0; $i < $num_total; $i++) {
                    //                 $data = $spr[$i];
                    //                 echo "$data, ";
                    //             }
                    //         ?>
                    //     ],
                    //     backgroundColor: '#1d3f74',
                    // },
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
                            if(mydata == 1){
                                var data2 = ctx.chart.data.datasets[0].data;
                                let percentage = (value*100 / data2[mydata1]).toFixed(2)+"%";
                                return percentage;
                            }
                            if(mydata == 0){
                                let dataArr = ctx.chart.data.datasets[0].data;
                                let percentage = (1*100 ).toFixed(0)+"%";
                                return percentage;
                            }
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
        $(".btn_dac").click(function(){
            console.log('ME DISTE CLICK DAC')
            $(".tbdac").show();
            $(".tboxa").hide();
            $(".tbpas").hide();
        });
        $(".btn_oxa").click(function(){
            console.log('ME DISTE CLICK OXA')
            $(".tbdac").hide();
            $(".tboxa").show();
            $(".tbpas").hide();
        });
        $(".btn_pasco").click(function(){
            console.log('ME DISTE CLICK PASCO')
            $(".tbdac").hide();
            $(".tboxa").hide();
            $(".tbpas").show();
        });

        $("#my_district").click(function(){
            console.log('ME DISTE CLIK CLICK');
            $("#no_graph_district").hide();
            var mylabels = [
                <?php 
                    include('query_graph_advance_vaccine.php');
                    while ($con1 = sqlsrv_fetch_array($consulta5)){
                        echo utf8_encode($con1['Distrito']); 
                    }
                ?>
            ]
            var datos1 = {
                label:'BCG',
                data: [
                    <?php
                        include('query_graph_advance_vaccine.php');
                        while ($con = sqlsrv_fetch_array($consulta5)){
                            echo $con['BCG_24_HORAS'];
                        }
                    ?>
                ],
                backgroundColor: '#1d3f74',
                borderColor: '#1d3f74',
            };
            var datos2 = {
                label:'HVB',
                data:[
                    <?php
                        include('query_graph_advance_vaccine.php');
                        while ($con = sqlsrv_fetch_array($consulta1)){
                            echo $con['HVB_12_HORAS'];
                        }
                    ?>
                ],
                backgroundColor: '#1d3f74',
                borderColor: '#1d3f74',
            };
            
            var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
            var myChartDistrict= new Chart(ctx_district,{
                type: "bar",
                data:{
                    labels: mylabels,
                    datasets: [ {
                        label: 'My First Dataset',
                        data: [ datos1, datos2 ],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderWidth: 1
                    } ]
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
                            offset: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>