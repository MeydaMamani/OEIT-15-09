<?php
    include('./base.php');
    include('query_3_dosis.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta3)){  
        $row_cont++;
    }  
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
                <h3>Aptos Para Tercera Dosis</h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-5 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-7">
                    <form action="print_3_dosis.php" method="POST">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                    </form>
                </div>
            </div>
            <div class="col-12 table-responsive">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                <thead>
                  <tr class="text-center font-12" style="background: #c9d0e2;">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Tipo de Documento</th>
                    <th class="align-middle">N° Documento</th>
                    <th class="align-middle">Nombres y Apellidos</th>
                    <th class="align-middle">Edad</th>
                    <th class="align-middle">Fecha Primera Dosis</th>
                    <th class="align-middle">Fecha Segunda Dosis</th>
                    <th class="align-middle">Fecha Tercera Dosis</th>
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
                    include('query_3_dosis.php');
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta3)){  
                        if(is_null ($consulta['TIPO_DOC']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['TIPO_DOC'];}

                        if(is_null ($consulta['NUM_DOC']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['NUM_DOC'];}

                        if(is_null ($consulta['NOMBRE_PACIENTE']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['NOMBRE_PACIENTE'];}

                        if(is_null ($consulta['EDAD_PACIENTE']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['EDAD_PACIENTE'];}

                        if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) ){
                            $newdate5 = '  -'; }
                        else{
                            $newdate5 = $consulta['FECHA_PRIMERA_DOSIS'] -> format('d/m/y');}
                        
                        if(is_null ($consulta['FECHA_SEGUNDA_DOSIS']) ){
                            $newdate6 = '  -'; }
                        else{
                            $newdate6 = $consulta['FECHA_SEGUNDA_DOSIS'] -> format('d/m/y');}

                        if(is_null ($consulta['FECHA_PARA_3RA_DOSIS']) ){
                            $newdate7 = '  -'; }
                        else{
                            $newdate7 = $consulta['FECHA_PARA_3RA_DOSIS'] -> format('d/m/y');}
   
                  ?>
                    <tr class="text-center font-12" id="table_fed">
                      <td class="align-middle"><?php echo $i++; ?></td>
                      <td class="align-middle"><?php echo $newdate; ?></td>
                      <td class="align-middle"><?php echo $newdate2; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                      <td class="align-middle"><?php echo $newdate4; ?></td>
                      <td class="align-middle"><?php echo $newdate5; ?></td>
                      <td class="align-middle"><?php echo $newdate6; ?></td>
                      <td class="align-middle"><?php echo $newdate7; ?></td>
                    </tr>
                  <?php
                      ;}              
                      sqlsrv_close($conn6);
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

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>