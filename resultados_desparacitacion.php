<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php'); 
        include('zone_setting.php');
        include('consulta_desparacitacion.php');
        $row_cont=0;
        while ($consulta = sqlsrv_fetch_array($consulta2)){
            $row_cont++;
        }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center p-2">
                <h3>Desparacitación </h3>
            </div>
            <div class="row mb-1">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
            </div>
            <div class="d-flex justify-content-center mb-3">
                <form action="print_deworming.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                </form>
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm m-2" onclick="location.href='desparacitacion.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
            <div class="col-12 table-responsive" id="cuatro_meses">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Cantidad</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
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
    </div>
    <?php } ?>
    
    <script src="./js/records_menu.js"></script>
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