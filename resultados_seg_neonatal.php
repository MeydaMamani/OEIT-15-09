<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    if (isset($_POST['Buscar'])) {
        header("Content-Type: text/html; charset=UTF-16LE");
        header('Content-Type: text/html; charset=UTF-8');
        global $conex;
        include('./base.php');

    include('consulta_seg_neonatal.php');
    $row_cnt=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta3)){
        $row_cnt++;
    }
?>
    <div class="page-wrapper">    
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="right" height="15px">
                        <p class="font-12 text-secondary"><b>Fuente: </b> BD HisMinsa y BD CNV con Fecha: 31 de Octubre del 2021 a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center p-2">
              <h3>Seguimiento Tamizaje Neonatal - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"> <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <!-- <li class="list-group-item font-14">Suplementados <span class="badge bg-success rounded-pill correcto"><?php echo $correctos; ?></span></li>
                    <li class="list-group-item font-14">No Suplementados <span class="badge bg-danger rounded-pill incorrecto"><?php echo $incorrectos; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                      <?php
                        if($correctos == 0 and $incorrectos == 0){
                            echo '0 %';
                          }else{
                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%';
                          }
                      ?> </span>
                    </li> -->
                  </ul>
                </div>
            </div>
            <div class="d-flex justify-content-center mb-3">
                <form action="impresion_seg_neonatal.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                </form>
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar m-2" onclick="location.href='seguimiento_neonatal.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
            <div class="col-12 table-responsive" id="prematuro">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;"> 
                            <th class="align-middle">#</th>
                            <th class="align-middle">Financiador</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Número CNV</th>
                            <th class="align-middle">Fecha Nacido</th>
                            <th class="align-middle">Provincia - Madre</th>
                            <th class="align-middle">Fecha Atención</th>
                            <th class="align-middle">Atendido</th>
                        </tr>
                    </thead>
                    <div class="float-end col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_seg_neonatal.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta3)){
                                if(is_null ($consulta['Financiador_Parto']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['Financiador_Parto'] ;}

                                if(is_null ($consulta['PROV_EESS']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['PROV_EESS'];}

                                if(is_null ($consulta['DIST_EESS']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['DIST_EESS'];}

                                if(is_null ($consulta['NU_CNV']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['NU_CNV'];}

                                if(is_null ($consulta['FE_NACIDO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['FE_NACIDO'];}

                                if(is_null ($consulta['Prov_Madre']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Prov_Madre'];}

                                if(is_null ($consulta['Fecha_Atencion']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['Fecha_Atencion']-> format('d/m/y');}

                                if(is_null ($consulta['ATENDIDO_EN']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['ATENDIDO_EN'];}

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate9); ?></td>
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