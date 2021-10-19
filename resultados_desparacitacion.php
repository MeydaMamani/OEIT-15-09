<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
    header('Content-Type: text/html; charset=UTF-8');
    include('./base.php'); 
    include('consulta_desparacitacion.php');
    $row_cont=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){
        $row_cont++;
    }
?>
        <div class="container">
            <div class="text-center p-3">
              <h3>Desparacitación </h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <!-- <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Cumplen <span class="badge bg-success rounded-pill cumple"><?php echo $cumple; ?></span></li>
                    <li class="list-group-item font-14">No Cumplen <span class="badge bg-danger rounded-pill no_cumple"><?php echo $no_cumple; ?></span></li>
                    <li class="list-group-item font-14">Observados <span class="badge bg-warning rounded-pill observado"><?php echo $observado; ?> </span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                      <?php 
                        if($cumple == 0 and $row_cont == 0){
                            echo '0 %';
                          }else{
                            echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%';
                          }
                      ?> </span>
                    </li>
                  </ul>
                </div> -->
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='desparacitacion.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <div class="d-flex">
                <form action="impresion_4_meses.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                </form>
            </div>
            <!-- <div class="col-lg-12 col-md-12 justify-content-center p-t-20" style="display: flex;">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="input-group">
                            <input type="date" class="form-control" id="start" onchange="filterdatedespara()" aria-label="Default select example">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-5">
                        <div class="input-group">
                            <input type="date" class="form-control" id="end" onchange="filterdatedespara()" aria-label="Default select example">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 m-t--5">
                        <button class="btn btn-outline-secondary btn-round btn-sm">Mes Actual</button>
                    </div>
                </div>
            </div> -->
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Cantidad</th>
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
                            include('consulta_desparacitacion.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){
                                if(is_null ($consulta['Provincia_Establecimiento']) ){
                                    $newdate = '  -'; }
                                else{
                                    $newdate = $consulta['Provincia_Establecimiento'] ;}
                        
                                if(is_null ($consulta['Distrito_Establecimiento']) ){
                                    $newdate2 = '  -'; }
                                else{
                                    $newdate2 = $consulta['Distrito_Establecimiento'];}

                                $newdate3 = $consulta['CANTIDAD_PROV'];
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                        </tr>
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5">
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
        // function filterdatedespara() {
        //     const start = $('#start').val();
        //     const end = $('#end').val();
        //     console.log(start);
        //     console.log(end);
                // axios.get('/external/filterdateoutpatient/', { params: { id_start: start, id_end: end, docid: numdoc } })
                //     .then(response => {
                //         setTimeout(() =>{ $('table').trigger('footable_redraw'); },120)
                //         setTimeout(() => $('.show-tick').selectpicker('refresh'));
                //         this.lists = response.data;
                //     });
        // }

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