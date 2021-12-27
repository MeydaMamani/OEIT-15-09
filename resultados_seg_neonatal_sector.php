<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    if (isset($_POST['Buscar'])) {
        header("Content-Type: text/html; charset=UTF-16LE");
        header('Content-Type: text/html; charset=UTF-8');
        global $conex;
        include('./base.php');
        include('zone_setting.php');
        include('consulta_seg_neonatal_sector.php');
        $row_cnt=0; $correctos=0; $incorrectos=0;
        while ($consulta = sqlsrv_fetch_array($consulta4)){
            $row_cnt++;
        }

        $monday = date( 'd/m/Y', strtotime( 'monday this week' ) );
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-12 text-primary"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> y BD CNV con Fecha: <?php echo $monday; ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center pb-3">
              <h3>Seguimiento Tamizaje Neonatal - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-1">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"> <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                </div>
            </div>
            <div class="col-12 mb-2">
                <div class="d-flex justify-content-center">
                    <form action="impresion_seg_neonatal_sector.php" method="POST">
                         <input hidden name="sector" value="<?php echo $_POST['sector']; ?>">
                         <input hidden name="establecimiento" value="<?php echo $_POST['establecimiento']; ?>">
                         <input hidden name="mes2" value="<?php echo $_POST['mes2']; ?>">
                         <input hidden name="anio2" value="<?php echo $_POST['anio2']; ?>">
                         <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                     </form>
                    <button class="btn btn-outline-secondary btn-sm  m-2 btn_all" onclick="location.href='seguimiento_neonatal.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div>
            <div class="col-12 table-responsive" id="cuatro_meses">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #b5c2d6;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Institución</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Nombre ESS</th>
                            <th class="align-middle">Número CNV</th>
                            <th class="align-middle">Lugar de Nacimiento</th>
                            <th class="align-middle">Fecha Nacimiento</th>
                            <th class="align-middle">Fecha Atención</th>
                            <th class="align-middle">Lugar de Atendido</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_seg_neonatal_sector.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta4)){
                                if(is_null ($consulta['Institucion']) ){
                                    $newdate = '  -'; }
                                    else{
                                $newdate = $consulta['Institucion'];}

                                if(is_null ($consulta['PROV_EESS']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['PROV_EESS'] ;}

                                if(is_null ($consulta['DIST_EESS']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['DIST_EESS'];}

                                if(is_null ($consulta['Nombre_EESS']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['Nombre_EESS'];}

                                if(is_null ($consulta['Nu_cnv']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['Nu_cnv'];}

                                if(is_null ($consulta['Lugar_Nacido']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['Lugar_Nacido'];}

                                if(is_null ($consulta['fecnacido']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['fecnacido'] -> format('d/m/y');}

                                if(is_null ($consulta['Fecha_Atencion']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['Fecha_Atencion'] -> format('d/m/y');}

                                if(is_null ($consulta['ATENDIDO_EN']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['ATENDIDO_EN'];}

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php
                                $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                                $data = utf8_encode($newdate4); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+ë", "É", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+ì", "Í", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+ô", "Ó", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+ü", "Á", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+æ", "Ñ", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php
                                $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                                $data = utf8_encode($newdate9); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+ë", "É", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+ì", "Í", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+ô", "Ó", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+ü", "Á", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+æ", "Ñ", $data);
                                    echo $resultado;
                                }
                            ?></td>
                        </tr>
                        <?php
                            ;}
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="15">
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
    <?php } ?>
    
    <script src="./js/records_menu.js"></script>
    <script src="./js/select2.js"></script>
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
    </script>
</body>
</html>