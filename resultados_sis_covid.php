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
    // $row_cont=0; $cumple=0; $no_cumple=0; $observado=0;
    // while ($consulta = sqlsrv_fetch_array($consulta5)){
    //     $row_cont++;
    //     if($consulta['PREMATURO'] != 'PREMATURO'){ 
    //         foreach (range(110, 130) as $numero) {
    //             if($numero == $consulta['SUPLEMENTADO']){
    //                 $cumple++;
    //             }
    //         }
    //         if(is_null ($consulta['SUPLEMENTADO'])){
    //             $no_cumple++;
    //         }
    //         if(!is_null ($consulta['SUPLEMENTADO']) && ($consulta['SUPLEMENTADO']<110 || $consulta['SUPLEMENTADO']>130)){
    //             $observado++;
    //          }
    //     }
    // }
?>
        <div class="container">
            <div class="text-center p-3">
              <h3>Niños de 4 Meses CG04 - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo '$row_cont'; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <!-- <li class="list-group-item font-14">Cumplen <span class="badge bg-success rounded-pill cumple"><?php echo $cumple; ?></span></li>
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
                    </li> -->
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button> -->
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='4_meses.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>

            <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todos</button>
        
            <div class="col-12 table-responsive table_no_fed">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Número Documento</th> 
                            <th class="align-middle">Apellidos y Nombres</th> 
                            <th class="align-middle">Resultado 1</th>
                            <th class="align-middle">Clasificación Clínica</th>
                            <th class="align-middle">Registrador</th>
                            <th class="align-middle">Documento Registrador</th>
                            <th class="align-middle">Resultado 2</th> 
                            <th class="align-middle">Código Establecimiento</th>
                            <th class="align-middle">Establecimiento</th> 
                            <th class="align-middle">Fecha Prueba</th>
                            <th class="align-middle">Fecha Seguimiento</th>
                            <th class="align-middle">Fecha Entrega</th>
                            <th class="align-middle">Días Seguimiento</th>
                            <th class="align-middle">Días MED</th>
                            <th class="align-middle">CF 300</th>
                            <th class="align-middle">CMED</th>
                            <th class="align-middle">C AMBOS</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4 table_no_fed">
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
                            while ($consulta = sqlsrv_fetch_array($consulta3)){  
                                if(is_null ($consulta['PROVINCIA']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['PROVINCIA'] ;}
                        
                                if(is_null ($consulta['DISTRITO']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['DISTRITO'];}
                        
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
                        
                                if(is_null ($consulta['RESULTADO_1']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['RESULTADO_1'];}
                    
                                if(is_null ($consulta['CLASIFICACION_CLINICA_SEVERIDAD']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['CLASIFICACION_CLINICA_SEVERIDAD'];}
                        
                                if(is_null ($consulta['REGISTRADOR']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['REGISTRADOR'];}
                        
                                if(is_null ($consulta['DOC_REGISTRADOR']) ){
                                    $newdate11 = '  -'; }
                                    else{ 
                                    $newdate11 = $consulta['DOC_REGISTRADOR'];}
                                                
                                if(is_null ($consulta['RESULTADO_2']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['RESULTADO_2'];}
                        
                                if(is_null ($consulta['COD_ESTABLECIMIENTO_EJECUTA']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                    $newdate13 = $consulta['COD_ESTABLECIMIENTO_EJECUTA'];}
                        
                                if(is_null ($consulta['ESTABLECIMIENTO_EJECUTA']) ){
                                    $newdate14 = '  -'; }
                                    else{
                                    $newdate14 = $consulta['ESTABLECIMIENTO_EJECUTA'];}
                        
                                if(is_null ($consulta['FECHA_EJECUCION_PRUEBA']) ){
                                    $newdate15 = '  -'; }
                                    else{
                                    $newdate15 = $consulta['FECHA_EJECUCION_PRUEBA'] -> format('d/m/y');}
                        
                                if(is_null ($consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO']) ){
                                    $newdate16 = '  -'; }
                                    else{
                                    $newdate16 = $consulta['FICHA_300_FECHA_DEL_SEGUIMIENTO'] -> format('d/m/y');}

                                if(is_null ($consulta['FECHA_ENTREGA']) ){
                                    $newdate17 = '  -'; }
                                else{
                                    $newdate17 = $consulta['FECHA_ENTREGA'] -> format('d/m/y');}

                                if(is_null ($consulta['DIAS_SEGUIMIENTO']) ){
                                    $newdate18 = '  -'; }
                                else{
                                    $newdate18 = $consulta['DIAS_SEGUIMIENTO'];}

                                if(is_null ($consulta['DIAS_MED']) ){
                                    $newdate19 = '  -'; }
                                else{
                                    $newdate19 = $consulta['DIAS_MED'];}

                                if(is_null ($consulta['CF300']) ){
                                    $newdate20 = '  -'; }
                                else{
                                    $newdate20 = $consulta['CF300'];}
                                    
                                if(is_null ($consulta['CMED']) ){
                                    $newdate21 = '  -'; }
                                else{
                                    $newdate21 = $consulta['CMED'];}
    
                                if(is_null ($consulta['C_AMBOS']) ){
                                    $newdate22 = '  -'; }
                                else{
                                     $newdate22 = $consulta['C_AMBOS'];}            

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
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
                            <td class="align-middle"><?php echo $newdate18; ?></td>
                            <td class="align-middle"><?php echo $newdate19; ?></td>
                            <td class="align-middle"><?php echo $newdate20; ?></td>
                            <td class="align-middle"><?php echo $newdate21; ?></td>
                            <td class="align-middle"><?php echo $newdate22; ?></td>
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

    <?php } ?>
    
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script>
        $(function(){
            $(".btn_fed").click(function(){
                $(".total").text(<?php echo $i_fed-1; ?>);
                $(".cumple").text(<?php echo $cumple_fed; ?>);
                $(".no_cumple").text(<?php echo $no_cumple_fed; ?>);
                $(".observado").text(<?php echo $observado_fed; ?>);
                $(".avance").text(<?php if($cumple_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($cumple/($i_fed-1))*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $(".table_fed").show();
                $(".table_no_fed").hide();
            });
            $(".btn_all").click(function(){
                $(".total").text(<?php echo $row_cont; ?>);
                $(".cumple").text(<?php echo $cumple; ?>);
                $(".no_cumple").text(<?php echo $no_cumple; ?>);
                $(".observado").text(<?php echo $observado; ?>);
                $(".avance").text(<?php if($cumple == 0 and $row_cont == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($cumple/$row_cont)*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $(".table_fed").hide();
                $(".table_no_fed").show();
            });
        });

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