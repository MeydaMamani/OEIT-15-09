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

        <div class="container">
            <div class="text-center p-3">
              <h3>Seguimiento Tamizaje Neonatal - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
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
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="button" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <!-- <button type="button" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Información</button> -->
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='seguimiento_neonatal.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="fa fa-clone"></i> FED</button>
                <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="fa fa-circle"></i> Todo</button>
                <form action="impresion_seg_neonatal.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                </form>
            </div>

            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Sector</th>
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
                    <div class="float-end pb-3">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_seg_neonatal.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta3)){
                                if(is_null ($consulta['Sector']) ){
                                    $newdate = '  -'; }
                                    else{
                                $newdate = $consulta['Sector'];}

                                if(is_null ($consulta['FINANCIADOR']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['FINANCIADOR'] ;}

                                if(is_null ($consulta['Provnacido']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['Provnacido'];}

                                if(is_null ($consulta['Distnacido']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['Distnacido'];}

                                if(is_null ($consulta['Numcnv']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['Numcnv'];}

                                if(is_null ($consulta['FECNACIDO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['FECNACIDO']-> format('d/m/y');}

                                if(is_null ($consulta['Provdommadre']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Provdommadre'];}

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
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
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

    <?php } ?>
    
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script>       
        // $(function(){
            // $(".btn_fed").click(function(){
            //     $(".total").text(<?php echo $fed-1; ?>);
            //     $(".correcto").text(<?php echo $fed_supl; ?>);
            //     $(".incorrecto").text(<?php echo $fed_no_supl; ?>);
            //     $(".avance").text(<?php if($fed_supl==0 && $fed_no_supl == 0){ echo "'0 %'"; }
            //         else{ $porcentaje = number_format((float)(($fed_supl/($fed-1))*100), 2, '.', '');
            //                 echo "'$porcentaje %'"; }?>);
            //     $(".table_fed").show();
            //     $(".table_no_fed").hide();
            // });
            // $(".btn_all").click(function(){
            //     $(".total").text(<?php echo $row_cnt; ?>);
            //     $(".correcto").text(<?php echo $correctos; ?>);
            //     $(".incorrecto").text(<?php echo $incorrectos; ?>);
            //     $(".avance").text(<?php if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }
            //         else{ $porcentaje = number_format((float)(($correctos/$row_cnt)*100), 2, '.', '');
            //                 echo "'$porcentaje %'"; }?>);
            //     $(".table_fed").hide();
            //     $(".table_no_fed").show();
            // });
        // });

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