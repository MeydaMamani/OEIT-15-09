<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
    global $conex;
    header('Content-Type: text/html; charset=UTF-8');
    include('./base.php'); 
    include('consulta_sis_covid.php');
    $row_cont=0; $row_cont_p=0; $no_cumple=0; $observado=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){
        $row_cont++;
    }
    while ($consulta = sqlsrv_fetch_array($consulta4)){
        $row_cont_p++;
    }
?>
        <div class="container">
            <div class="text-center p-3">
              <h3>SIS COVID</h3><br>
            </div>
            <!-- TABS -->
            <!-- <ul class="nav nav-tabs justify-content-center" role="tablist">
                <li class="nav-item text-center"><a class="nav-link active" data-toggle="tab" href="#sospechoso"> <i class="fa fa-calendar"></i> CASOS SOSPECHOSOS F0</a></li>
                <li class="nav-item text-center"><a class="nav-link" data-toggle="tab" href="#prueba"><i class="fa fa-calendar-check"></i> CASOS SOSPECHOSOS F100</a></li>
            </ul> -->
            <nav>
                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#sospechoso" type="button" role="tab" aria-controls="nav-sospechoso" aria-selected="true">
                        <img src="./img/icon-virus.png" width="30" alt=""> CASOS SOSPECHOSOS F0</button>
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#prueba" type="button" role="tab" aria-controls="nav-prueba" aria-selected="false">
                        <img src="./img/icons-virus2.png" width="30" alt=""> CASOS SOSPECHOSOS F100</button>
                </div>
            </nav>
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="sospechoso">
                    <div class="col-lg-12 col-md-12 justify-content-center p-t-20">
                        <div class="row mb-3 mt-3">
                            <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12 text-center">
                                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button> -->
                                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='sis_covid.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="fa fa-clone"></i> FED</button>
                            <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="fa fa-circle"></i> Todo</button>
                            <form action="impresion_68_meses.php" method="POST">
                                <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                                <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                                <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                                <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                            </form>
                        </div>    
                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table footable m-b-0" data-paging="true" data-page-size="10" data-limit-navigation="10">
                                <thead>
                                    <tr class="text-center font-12" style="background: #21abab2e;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Provincia</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">Tipo Documento</th>
                                        <th class="align-middle">Número Documento</th> 
                                        <th class="align-middle">Apellidos y Nombres</th> 
                                        <th class="align-middle">Dirección</th>
                                        <th class="align-middle">DNI</th>
                                        <th class="align-middle">Usuario Nombre</th>
                                        <th class="align-middle">usuario Procedencia</th>
                                        <th class="align-middle">Fecha Registro</th> 
                                        <th class="align-middle">Fecha Seguimiento</th>
                                        <th class="align-middle">Fecha Entrega</th>                                        
                                        <th class="align-middle">Cumple</th>
                                    </tr>
                                </thead>
                                <div class="float-end pb-4">
                                    <div class="form-group">
                                        <div id="inputbus" class="input-group input-group-sm">
                                            <input id="demo-input-search" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                            <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <tbody>
                                    <?php  
                                        include('consulta_sis_covid.php');
                                        $i=1;
                                        while ($consulta = sqlsrv_fetch_array($consulta2)){  
                                            if(is_null ($consulta['RESIDENCIA_PROVINCIA']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consulta['RESIDENCIA_PROVINCIA'] ;}
                                    
                                            if(is_null ($consulta['RESIDENCIA_DISTRITO']) ){
                                                $newdate4 = '  -'; }
                                                else{
                                            $newdate4 = $consulta['RESIDENCIA_DISTRITO'];}
                                    
                                            if(is_null ($consulta['TIPO_DOCUMENTO']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consulta['TIPO_DOCUMENTO'];}
                                    
                                            if(is_null ($consulta['NUMERO_DOCUMENTO']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consulta['NUMERO_DOCUMENTO'];}
                                    
                                            if(is_null ($consulta['full_name']) ){
                                                $newdate7 = '  -'; }
                                                else{
                                            $newdate7 = $consulta['full_name'];}
                                    
                                            if(is_null ($consulta['DIRECCION']) ){
                                                $newdate8 = '  -'; }
                                                else{
                                            $newdate8 = $consulta['DIRECCION'];}
                                
                                            if(is_null ($consulta['USUARIO_DNI']) ){
                                                $newdate9 = '  -'; }
                                                else{
                                            $newdate9 = $consulta['USUARIO_DNI'];}
                                    
                                            if(is_null ($consulta['USUARIO_NOMBRE']) ){
                                                $newdate10 = '  -'; }
                                                else{
                                            $newdate10 = $consulta['USUARIO_NOMBRE'];}
                                    
                                            if(is_null ($consulta['USUARIO_PROCEDENCIA']) ){
                                                $newdate11 = '  -'; }
                                                else{ 
                                                $newdate11 = $consulta['USUARIO_PROCEDENCIA'];}
                                                            
                                            if(is_null ($consulta['FECHA_REGISTRO']) ){
                                                $newdate12 = '  -'; }
                                            else{
                                                $newdate12 = $consulta['FECHA_REGISTRO'] -> format('d/m/y');}
                                    
                                            if(is_null ($consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO']) ){
                                                $newdate13 = '  -'; }
                                                else{
                                                $newdate13 = $consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO']-> format('d/m/y');}
                                    
                                            if(is_null ($consulta['FECHA_ENTREGA']) ){
                                                $newdate14 = '  -'; }
                                                else{
                                                $newdate14 = $consulta['FECHA_ENTREGA']  -> format('d/m/y');}
                                    
                                            if(is_null ($consulta['C_AMBOS']) ){
                                                $newdate19 = '  -'; }
                                            else{
                                                $newdate19 = $consulta['C_AMBOS'];}

                                    ?>
                                    <tr class="text-center font-12">
                                        <td class="align-middle"><?php echo $i++; ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                                        <td class="align-middle"><?php echo $newdate6; ?></td>
                                        <td class="align-middle"><?php echo $newdate7; ?></td>
                                        <td class="align-middle"><?php echo $newdate8; ?></td>
                                        <td class="align-middle"><?php echo $newdate9; ?></td>
                                        <td class="align-middle"><?php echo $newdate10; ?></td>
                                        <td class="align-middle"><?php echo $newdate11; ?></td>
                                        <td class="align-middle"><?php echo $newdate12; ?></td>
                                        <td class="align-middle"><?php echo $newdate13; ?></td>
                                        <td class="align-middle"><?php echo $newdate14; ?></td>
                                        <td class="align-middle"><?php 
                                            if($newdate19 == 1){
                                               echo "<span class='badge bg-correct'>CORECTO</span>";
                                            }else{
                                                echo "<span class='badge bg-incorrect'>INCORECTO</span>";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="20">
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
                <div role="tabpanel" class="tab-pane" id="prueba">
                    <div class="col-lg-12 col-md-12 justify-content-center p-t-20">
                        <div class="row mb-3 mt-3">
                            <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont_p; ?></b></div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-12 text-center">
                                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button> -->
                                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='sis_covid.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="demo-foo-addrow2" class="table footable m-b-0" data-paging="true" data-page-size="10" data-limit-navigation="10">
                                <thead>
                                    <tr class="text-center font-12" style="background: #c9d0e2;">
                                        <th class="align-middle">#</th>
                                        <th class="align-middle">Provincia</th>
                                        <th class="align-middle">Distrito</th>
                                        <th class="align-middle">Tipo Documento</th>
                                        <th class="align-middle">Número Documento</th> 
                                        <th class="align-middle">Apellidos y Nombres</th> 
                                        <th class="align-middle">Resultado 1</th>
                                        <th class="align-middle">clasificación Clínica</th>
                                        <th class="align-middle">Registrador</th>
                                        <th class="align-middle">Documento Registrador</th>
                                        <th class="align-middle">Resultado 2</th> 
                                        <th class="align-middle">Código Establecimiento</th>
                                        <th class="align-middle">Establecimiento</th> 
                                        <th class="align-middle">Fecha Prueba</th>
                                        <th class="align-middle">Fecha Seguimiento</th>
                                        <th class="align-middle">Fecha Entrega</th>
                                        <th class="align-middle">Cumple</th>
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
                                        include('consulta_sis_covid.php');
                                        $i=1;
                                        while ($consultas = sqlsrv_fetch_array($consulta4)){  
                                            if(is_null ($consultas['PROVINCIA']) ){
                                                $newdate3 = '  -'; }
                                                else{
                                            $newdate3 = $consultas['PROVINCIA'] ;}
                                    
                                            if(is_null ($consultas['DISTRITO']) ){
                                                $newdate4 = '  -'; }
                                                else{
                                            $newdate4 = $consultas['DISTRITO'];}
                                    
                                            if(is_null ($consultas['TIPO_DOCUMENTO']) ){
                                                $newdate5 = '  -'; }
                                                else{
                                            $newdate5 = $consultas['TIPO_DOCUMENTO'];}
                                    
                                            if(is_null ($consultas['NUMERO_DOCUMENTO']) ){
                                                $newdate6 = '  -'; }
                                                else{
                                            $newdate6 = $consultas['NUMERO_DOCUMENTO'];}
                                    
                                            if(is_null ($consultas['full_name']) ){
                                                $newdate7 = '  -'; }
                                                else{
                                            $newdate7 = $consultas['full_name'];}
                                    
                                            if(is_null ($consultas['RESULTADO_1']) ){
                                                $newdate8 = '  -'; }
                                                else{
                                            $newdate8 = $consultas['RESULTADO_1'];}
                                
                                            if(is_null ($consultas['CLASIFICACION_CLINICA_SEVERIDAD']) ){
                                                $newdate9 = '  -'; }
                                                else{
                                            $newdate9 = $consultas['CLASIFICACION_CLINICA_SEVERIDAD'];}
                                    
                                            if(is_null ($consultas['REGISTRADOR']) ){
                                                $newdate10 = '  -'; }
                                                else{
                                            $newdate10 = $consultas['REGISTRADOR'];}
                                    
                                            if(is_null ($consultas['DOC_REGISTRADOR']) ){
                                                $newdate11 = '  -'; }
                                                else{ 
                                                $newdate11 = $consultas['DOC_REGISTRADOR'];}
                                                            
                                            if(is_null ($consultas['RESULTADO_2']) ){
                                                $newdate12 = '  -'; }
                                            else{
                                                $newdate12 = $consultas['RESULTADO_2'];}
                                    
                                            if(is_null ($consultas['COD_ESTABLECIMIENTO_EJECUTA']) ){
                                                $newdate13 = '  -'; }
                                                else{
                                                $newdate13 = $consultas['COD_ESTABLECIMIENTO_EJECUTA'];}
                                    
                                            if(is_null ($consultas['ESTABLECIMIENTO_EJECUTA']) ){
                                                $newdate14 = '  -'; }
                                                else{
                                                $newdate14 = $consultas['ESTABLECIMIENTO_EJECUTA'];}
                                    
                                            if(is_null ($consultas['FECHA_EJECUCION_PRUEBA']) ){
                                                $newdate15 = '  -'; }
                                                else{
                                                $newdate15 = $consultas['FECHA_EJECUCION_PRUEBA'] -> format('d/m/y');}
                                    
                                            if(is_null ($consultas['FICHA_300_FECHA_DEL_SEGUIMIENTO']) ){
                                                $newdate16 = '  -'; }
                                            else{
                                                $newdate16 = $consultas['FICHA_300_FECHA_DEL_SEGUIMIENTO'] -> format('d/m/y');}

                                            if(is_null ($consultas['FECHA_ENTREGA']) ){
                                                $newdate17 = '  -'; }
                                            else{
                                                $newdate17 = $consultas['FECHA_ENTREGA'] -> format('d/m/y');}

                                            if(is_null ($consultas['C_AMBOS']) ){
                                                $newdate22 = '  -'; }
                                            else{
                                                $newdate22 = $consultas['C_AMBOS'];}     

                                    ?>
                                    <tr class="text-center font-12">
                                        <td class="align-middle"><?php echo $i++; ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                        <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
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
                                        <td class="align-middle"><?php echo $newdate16; ?></td>
                                        <td class="align-middle"><?php echo $newdate17; ?></td>
                                        <td class="align-middle"><?php 
                                            if($newdate22 == 1){
                                                echo "<span class='badge bg-correct'>CORECTO</span>";
                                            }else{
                                                echo "<span class='badge bg-incorrect'>INCORECTO</span>";
                                            } ?>
                                        </td>
                                    </tr>
                                    <?php
                                        ;}                    
                                        include("cerrar.php");
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="20">
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
            </div>    
        </div>

    <?php } ?>
    
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