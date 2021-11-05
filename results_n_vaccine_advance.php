<?php 
    require('abrir.php');
    require('abrir6.php');

    if (isset($_POST['Buscar'])) {
        global $conex;
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php'); 
        include('query_vaccine_advance.php');
        $row_cont=0;
        while ($consulta = sqlsrv_fetch_array($consulta1)){
            $row_cont++;
        }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
              <h3>Avance Vacunación Nominal</h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <form action="print_vaccine_advance.php" method="POST">
                            <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                            <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                            <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir Excel</button>
                        </form>
                        <button class="btn btn-outline-secondary btn-sm m-2" onclick="location.href='nominal_vaccine_advance.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
                    </div>
                </div>
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-13 border" style="background: #c9d0e2;">
                            <th></th>
                            <th colspan="3" class="border">Paciente</th>
                            <th colspan="5" class="border">Primera Dosis</th>
                            <th colspan="5" class="border">Segunda Dosis</th>
                        </tr>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle border">#</th>
                            <th class="align-middle border">Tipo Documento</th>
                            <th class="align-middle border">Documento</th> 
                            <th class="align-middle border">Paciente</th> 
                            <th class="align-middle border">Provincia</th>
                            <th class="align-middle border">Distrito</th>
                            <th class="align-middle border">Establecimiento</th>
                            <th class="align-middle border">Fecha de Vacunación</th>
                            <th class="align-middle border">Vacuna</th>
                            <th class="align-middle border">Provincia</th>
                            <th class="align-middle border">Distrito</th>
                            <th class="align-middle border">Establecimiento</th>
                            <th class="align-middle border">Fecha de Vacunación</th>
                            <th class="align-middle border">Vacuna</th>
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
                            include('query_vaccine_advance.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta1)){  
                                if(is_null ($consulta['TIPO_DOC']) ){
                                    $newdate = '   -'; }
                                else{
                                    $newdate = $consulta['TIPO_DOC'] ;}
                        
                                if(is_null ($consulta['NUM_DOC']) ){
                                    $newdate2 = '   -'; }
                                else{
                                    $newdate2 = $consulta['NUM_DOC'];}
                        
                                if(is_null ($consulta['PRIMERA_PACIEN']) ){
                                    $newdate3 = '  -'; }
                                else{
                                    $newdate3 = $consulta['PRIMERA_PACIEN'];}
                        
                                if(is_null ($consulta['PRIMERA_PROV']) ){
                                    $newdate4 = '  -'; }
                                else{
                                    $newdate4 = $consulta['PRIMERA_PROV'];}
                        
                                if(is_null ($consulta['PRIMERA_DIST']) ){
                                    $newdate5 = '   -'; }
                                else{
                                    $newdate5 = $consulta['PRIMERA_DIST'];}

                                if(is_null ($consulta['PRIMERA_EESS']) ){
                                    $newdate6 = '    -'; }
                                else{
                                    $newdate6 = $consulta['PRIMERA_EESS'];}    
                        
                                if(is_null ($consulta['PRIMERA']) ){
                                    $newdate7 = '   -'; }
                                else{
                                    $newdate7 = $consulta['PRIMERA'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['PRIMERA_FAB']) ){
                                    $newdate8 = '   -';}
                                else{
                                    $newdate8 = $consulta['PRIMERA_FAB'];}
                        
                                if(is_null ($consulta['SEGUNDA_PROV']) ){
                                    $newdate9 = '   -';}
                                else{
                                    $newdate9 = $consulta['SEGUNDA_PROV'];}
                        
                                if(is_null ($consulta['SEGUNDA_DIST']) ){
                                    $newdate10 = '    -'; }
                                else{
                                    $newdate10 = $consulta['SEGUNDA_DIST'];}    
                            
                                if(is_null ($consulta['SEGUNDA_EESS']) ){
                                    $newdate11 = '   -'; }
                                else{
                                    $newdate11 = $consulta['SEGUNDA_EESS'];}
                        
                                if(is_null ($consulta['SEGUNDA']) ){
                                    $newdate12 = '   -';}
                                else{
                                    $newdate12 = $consulta['SEGUNDA'] -> format('d/m/y');;}
                            
                                if(is_null ($consulta['SEGUNDA_FAB']) ){
                                    $newdate13 = '   -';}
                                else{
                                    $newdate13 = $consulta['SEGUNDA_FAB'];}
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate6); ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate12); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate13); ?></td>
                        </tr>
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="16">
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
</body>
</html>