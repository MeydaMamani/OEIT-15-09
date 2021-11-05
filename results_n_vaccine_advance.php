<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

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
                <div class="col-8 d-flex justify-content-end">

                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <form action="print_vaccine_advance.php" method="POST">
                            <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                            <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                            <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                        </form>
                        <button class="btn btn-outline-secondary btn-sm m-2" onclick="location.href='nominal_vaccine_advance.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
                    </div>
                </div>
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Documento</th> 
                            <th class="align-middle">Paciente</th> 
                            <th class="align-middle">Tipo Vacuna</th>
                            <th class="align-middle">Primera Dosis</th>
                            <th class="align-middle">Grupo de Edad</th>
                            <th class="align-middle">Edad</th>
                            <th class="align-middle">Tipo Vacuna</th>
                            <th class="align-middle">Segunda Dosis</th> 
                            <th class="align-middle">Grupo de Edad</th>
                            <th class="align-middle">Edad</th>
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
                                if(is_null ($consulta['PRIMERA_PROV']) ){
                                    $newdate = $consulta['SEGUNDA_PROV'] ; }
                                else{
                                    $newdate = $consulta['PRIMERA_PROV'] ;}
                        
                                if(is_null ($consulta['PRIMERA_DIST']) ){
                                    $newdate2 = $consulta['SEGUNDA_DIST'] ; }
                                else{
                                    $newdate2 = $consulta['PRIMERA_DIST'];}
                        
                                if(is_null ($consulta['TIPO_DOC']) ){
                                    $newdate3 = '  -'; }
                                else{
                                    $newdate3 = $consulta['TIPO_DOC'];}
                        
                                if(is_null ($consulta['NUM_DOC']) ){
                                    $newdate4 = '  -'; }
                                else{
                                    $newdate4 = $consulta['NUM_DOC'];}
                        
                                if(is_null ($consulta['PRIMERA_PACIEN']) ){
                                    $newdate5 = $consulta['SEGUNDA_PACIEN']; }
                                else{
                                    $newdate5 = $consulta['PRIMERA_PACIEN'];}

                                if(is_null ($consulta['PRIMERA_FAB']) ){
                                    $newdate6 = '    -'; }
                                else{
                                    $newdate6 = $consulta['PRIMERA_FAB'];}    
                        
                                if(is_null ($consulta['PRIMERA']) ){
                                    $newdate7 = '   -'; }
                                else{
                                    $newdate7 = $consulta['PRIMERA'] -> format('d/m/y');;}
                    
                                if(is_null ($consulta['PRIMERA_GRUPO']) ){
                                    $newdate8 = '   -';}
                                else{
                                    $newdate8 = $consulta['PRIMERA_GRUPO'];}
                        
                                if(is_null ($consulta['PRIMERA_EDAD']) ){
                                    $newdate9 = '   -';}
                                else{
                                    $newdate9 = $consulta['PRIMERA_EDAD'];}
                        
                                if(is_null ($consulta['SEGUNDA_FAB']) ){
                                    $newdate10 = '    -'; }
                                else{
                                    $newdate10 = $consulta['SEGUNDA_FAB'];}    
                            
                                if(is_null ($consulta['SEGUNDA']) ){
                                    $newdate11 = '   -'; }
                                else{
                                    $newdate11 = $consulta['SEGUNDA'] -> format('d/m/y');;}
                        
                                if(is_null ($consulta['SEGUNDA_GRUPO']) ){
                                    $newdate12 = '   -';}
                                else{
                                    $newdate12 = $consulta['SEGUNDA_GRUPO'];}
                            
                                if(is_null ($consulta['SEGUNDA_EDAD']) ){
                                    $newdate13 = '   -';}
                                else{
                                    $newdate13 = $consulta['SEGUNDA_EDAD'];}
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