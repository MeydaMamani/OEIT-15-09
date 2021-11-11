<?php 
  require ('abrir.php');    
  if (isset($_POST['Buscar'])) {
        global $conex;
        include('./base.php');
        include('zone_setting.php');
        include('consulta_gestante_usuarias_nuevas.php');
        $row_cont=0; $numerador=0;
        while ($consulta = sqlsrv_fetch_array($consulta6)){  
            $row_cont++;
            if(!is_null ($consulta['TMZ_VIF']) ){ $numerador++; }
        }  
?>

    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="15px">
                        <p class="font-12 text-secondary"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo date("d-m-y"); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center p-3">
              <h3>Usuarias Nuevas en el Servicio de Planificación Familiar con DX Violencia - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row">
                <div class="row justify-content-center">
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 text-center d-flex justify-content-center">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/user_cant.png" width="90" alt="">
                                        </div>
                                        <div class="mt-2 col-md-6">
                                            <b class="total font-60"> <?php echo $row_cont; ?></b> <i class="fa fa-plus font-50 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-4">
                                <div class="col-md-7 p-r-0 text-center">
                                    <h2 class="font-light avance mb-3"><?php
                                        if($row_cont == 0 and $numerador == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($numerador/$row_cont)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h2>
                                    <h4 class="text-muted">Avance</h4></div>
                                <div class="col-md-5 text-center align-self-center position-sticky">
                                    <div data-label="<?php
                                        if($numerador == 0 and $row_cont == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($numerador/$row_cont)*100), 2, '.', ''), '%'; }
                                        ?>" class="css-bar m-b-0 css-bar-info css-bar-<?php if($numerador == 0 and $row_cont == 0){ echo '0'; }else{
                                            echo number_format((float)(($numerador/$row_cont)*100), 0, '.', ''); }
                                        ?>"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex justify-content-center">
                    <form action="impresion_gestante_usuarias_nuevas.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <button type="submit" id="exportarCSV" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button class="btn btn-outline-danger btn-sm m-2 btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Información</button>
                    <button class="btn btn-outline-secondary btn-sm m-2" onclick="location.href='gestante_usuarias_nuevas.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div>
            <div class="col-12 table-responsive table_no_fed">
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
                    <div class="float-end pb-1 table_no_fed">
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
                            while ($consulta = sqlsrv_fetch_array($consulta6)){ 
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