<?php
    include('./base.php');
    include('consulta_reincorporacion.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){  
        $row_cont++;
    }  
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
                <h3>Reincorporación</h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                    <!-- <form action="impresion_reincorporacion.php" method="POST">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir CSV</button>
                    </form> -->
                </div>
            </div>
            <div class="row mb-3">
              <div class="d-flex">
                <form action="impresion_reincorporacion.php" method="POST">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir CSV</button>
                </form>
            </div>            
            <div class="col-12 table-responsive">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                <thead>
                  <tr class="text-center font-12" style="background: #c9d0e2;">
                    <th class="align-middle">#</th>
                    <th class="align-middle">N° Documento</th>
                    <th class="align-middle">Validado Reniec</th>
                    <th class="align-middle">Apellidos y Nombres</th>
                    <th class="align-middle">Código Estudiante</th>
                    <th class="align-middle">Fecha Nacimiento</th>
                    <th class="align-middle">Sexo</th>
                    <th class="align-middle">NIV MOD</th>
                    <th class="align-middle">Pais Nacimiento</th>
                    <th class="align-middle">Id Grado</th>
                    <th class="align-middle">Desc Grado</th>
                    <th class="align-middle">Cen Edu</th>
                    <th class="align-middle">Cod Car</th>
                    <th class="align-middle">Dreugel</th>
                    <th class="align-middle">Dar Acenso</th>
                    <th class="align-middle">Datos Padre</th>
                    <th class="align-middle" id="fields_bateria_head">Fecha Atención</th>
                    <th class="align-middle" id="fields_bateria_head">Distrito Establecimiento</th>
                    <th class="align-middle" id="fields_bateria_head">Nombre Establecimiento</th>
                  </tr>
                </thead>
                <div class="float-end pb-3">
                    <div class="form-group">
                      <div id="inputbus" class="input-group input-group-sm">
                        <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                        <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                      </div>
                    </div>
                </div>
                <tbody>
                  <?php 
                    include('consulta_reincorporacion.php');
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){  
                        if(is_null ($consulta['NUM_DOC']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['NUM_DOC'];}

                        if(is_null ($consulta['VALIDADO_RENIEC']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['VALIDADO_RENIEC'];}

                        if(is_null ($consulta['FULL_NAME']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['FULL_NAME'];}

                        if(is_null ($consulta['COD_ESTUDIANTE']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['COD_ESTUDIANTE'];}

                        if(is_null ($consulta['FECHA_NACIMIENTO']) ){
                            $newdate5 = '  -'; }
                        else{
                            $newdate5 = $consulta['FECHA_NACIMIENTO'] -> format('d/m/y');}
                        
                        if(is_null ($consulta['sexo']) ){
                            $newdate6 = '  -'; }
                        else{
                            $newdate6 = $consulta['sexo'];}

                            if(is_null ($consulta['NIV_MOD']) ){
                                $newdate18 = '  -'; }
                            else{
                                $newdate18 = $consulta['NIV_MOD'];}    

                        if(is_null ($consulta['PAIS_NACIMIENTO']) ){
                            $newdate7 = '  -'; }
                        else{
                            $newdate7 = $consulta['PAIS_NACIMIENTO'];}

                        if(is_null ($consulta['ID_GRADO']) ){
                            $newdate8 = '  -'; }
                        else{
                            $newdate8 = $consulta['ID_GRADO'];}

                        if(is_null ($consulta['DESC_GRADO']) ){
                            $newdate9 = '  -'; }
                        else{
                            $newdate9 = $consulta['DESC_GRADO'];}

                            if(is_null ($consulta['CEN_EDU']) ){
                                $newdate10 = '  -'; }
                            else{
                                $newdate10 = $consulta['CEN_EDU'];}

                                if(is_null ($consulta['D_COD_CAR']) ){
                                    $newdate11 = '  -'; }
                                else{
                                    $newdate11 = $consulta['D_COD_CAR'];}

                                    if(is_null ($consulta['D_DREUGEL']) ){
                                        $newdate12 = '  -'; }
                                    else{
                                        $newdate12 = $consulta['D_DREUGEL'];}


                                        if(is_null ($consulta['DAREACENSO']) ){
                                            $newdate13 = '  -'; }
                                        else{
                                            $newdate13 = $consulta['DAREACENSO'];}

                                            if(is_null ($consulta['PADRE']) ){
                                                $newdate14 = '  -'; }
                                            else{
                                                $newdate14 = $consulta['PADRE'];}

                                                if(is_null ($consulta['FECHAATENCION']) ){
                                                    $newdate15 = '  -'; }
                                                else{
                                                    $newdate15 = $consulta['FECHAATENCION'] -> format('d/m/y');}


                                                    
                                            if(is_null ($consulta['distrito_establecimiento']) ){
                                                $newdate16 = '  -'; }
                                            else{
                                                $newdate16 = $consulta['distrito_establecimiento'];}


                                                if(is_null ($consulta['nombre_establecimiento']) ){
                                                    $newdate17 = '  -'; }
                                                else{
                                                    $newdate17 = $consulta['nombre_establecimiento'];}
    
                  ?>
                    <tr class="text-center font-12" id="table_fed">
                      <td class="align-middle"><?php echo $i++; ?></td>
                      <td class="align-middle"><?php echo $newdate; ?></td>
                      <td class="align-middle"><?php echo $newdate2; ?></td>
                      <td class="align-middle"><?php echo $newdate3; ?></td>
                      <td class="align-middle"><?php echo $newdate4; ?></td>
                      <td class="align-middle"><?php echo $newdate5; ?></td>
                      <td class="align-middle"><?php echo $newdate6; ?></td>
                      <td class="align-middle"><?php echo $newdate18; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
                      <td class="align-middle"><?php echo $newdate8; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate9); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                      <td class="align-middle"><?php echo $newdate11; ?></td>
                      <td class="align-middle"><?php echo $newdate12; ?></td>
                      <td class="align-middle"><?php echo $newdate13; ?></td>                      
                      <td class="align-middle"><?php echo $newdate14; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo $newdate15; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo utf8_encode($newdate16); ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo utf8_encode($newdate17); ?></td>
                    </tr>
                  <?php
                      ;}              
                    //   include("cerrar.php");
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

<script src="./js/records_menu.js"></script>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>