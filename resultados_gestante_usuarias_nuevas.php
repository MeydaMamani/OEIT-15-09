<?php 
  require ('abrir.php');    
  if (isset($_POST['Buscar'])) {
    global $conex;
  include('./base.php');
?>
      <?php 
        include('consulta_gestante_usuarias_nuevas.php');
        $row_cont=0; $cumple=0; $no_cumple=0;
        while ($consulta = sqlsrv_fetch_array($consulta8)){  
          $row_cont++;
        }  
      ?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
              <h3>Usuarias Nuevas en el Servicio de Planificación Familiar con DX Violencia - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-1">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
            </div>
            <div class="row mb-1">
                <div class="col-lg-12 text-center">
                    <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-view-headline"></i> Información</button>
                    <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='gestante_usuarias_nuevas.php';"><i class="mdi mdi-keyboard-backspace"></i> Regresar</button>
                </div>
                <div class="d-flex">
                    <form action="impresion_gestante_usuarias_nuevas.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir CSV</button>
                    </form>
                </div>    
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Ate Planificación</th>
                            <th class="align-middle">Tmz VIF</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php 
                            include('consulta_gestante_usuarias_nuevas.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta8)){ 
                                if(is_null ($consulta['Provincia']) ){
                                    $newdate = '  -'; }
                                else{
                                    $newdate = $consulta['Provincia'];}

                                if(is_null ($consulta['Distrito']) ){
                                    $newdate2 = '  -'; }
                                else{
                                    $newdate2 = $consulta['Distrito'];}
            
                                if(is_null ($consulta['Nombre_Establecimiento']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['Nombre_Establecimiento'];}

                                if(is_null ($consulta['documento']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['documento'];}

                                if(is_null ($consulta['ATE_PLANIFICACION']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['ATE_PLANIFICACION'] -> format('d/m/y');}

                                if(is_null ($consulta['TMZ_VIF']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['TMZ_VIF'] -> format('d/m/y');}

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>                      
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

    <!-- MODAL INFORMACION-->
    <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <img src="./img/informacion_usuarias_nuevas.png" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
<?php } ?>

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
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