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
    while ($consulta = sqlsrv_fetch_array($consulta2)){
        $row_cnt++;
    }
?>
    <div class="page-wrapper">
        <div class="homologation">
            <div class="text-center p-1">
              <h4>HOMOLOGACIÓN - <?php echo $nombre_mes; ?></h4>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-md-4"><b class="align-middle">Cantidad de Registros: <?php echo $row_cnt; ?></b></div>
                <div class="col-md-8 d-flex justify-content-end">
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
                <div class="col-md-6 table-responsive">
                    <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                        <thead>
                            <tr class="text-light font-12 text-center" style="background: #0f81db;">
                                <th class="align-middle">#</th>
                                <th class="align-middle">Provincia</th>
                                <th class="align-middle">Distrito</th>
                                <th class="align-middle">Total Niños</th>
                                <th class="align-middle">DNI Homologado</th>
                                <th class="align-middle" id="color_homologado_head">Eje Vial</th>
                                <th class="align-middle" id="color_homologado_head">Descripción</th>
                                <th class="align-middle" id="color_homologado_head">Referencia Descripción</th>
                                <th class="align-middle" id="color_homologado_head">Niño Visitado</th>
                            </tr>
                        </thead>
                        <div class="float-end pb-1">
                            <div class="form-group">
                                <div id="inputbus" class="input-group">
                                    <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                    <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                                </div>
                            </div>
                        </div>
                        <tbody>
                            <?php  
                            include('query_homologation.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){  
                                // CAMBIO AQUI
                                if(is_null ($consulta['NOMBRE_PROV']) ){
                                  $newdate1 = '  -'; }
                                else{
                                    $newdate1 = $consulta['NOMBRE_PROV'] ;
                                    if($newdate1 == 'DANIEL ALCIDES CARRION'){
                                        $newdate1 = 'DANIEL A. CARRION';
                                    }
                                }
                
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
                                <tr style="font-size: 11px; text-align: center;">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                    <td class="align-middle"><?php echo $newdate3; ?></td>
                                    <td class="align-middle"><?php echo $newdate4; ?></td>
                                    <td class="align-middle" id="color_homologado_body"><?php echo $newdate5; ?></td>
                                    <td class="align-middle" id="color_homologado_body"><?php echo $newdate6; ?></td>
                                    <td class="align-middle" id="color_homologado_body"><?php echo $newdate7; ?></td>
                                    <td class="align-middle" id="color_homologado_body"><?php echo $newdate8; ?></td>
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
                <div class="col-1 p-0" style="width: 5%;"></div>
                <div class="col-md-5 p-0 text-center">
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
<?php } ?>
    
    <script src="./js/records_menu.js"></script>
    <script src="./js/select2.js"></script>
    <script src="./js/district.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.0/Chart.bundle.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.0.0-rc.1/chartjs-plugin-datalabels.min.js" integrity="sha512-+UYTD5L/bU1sgAfWA0ELK5RlQ811q8wZIocqI7+K0Lhh8yVdIoAMEs96wJAIbgFvzynPm36ZCXtkydxu1cs27w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <?php include('homolgation_chart.php'); ?>
    <script>
        $( document ).ready(function() {
            $("#btn_dac").click();
        });
    </script>
</body>
</html>