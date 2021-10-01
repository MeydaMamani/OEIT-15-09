<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
    global $conex;
    header('Content-Type: text/html; charset=UTF-8');
    include('./base.php');
?>

    <?php 
        include('consulta_4_meses.php');
        $cont=0;
        $cumple=0;
        $no_cumple=0;
        $observado=0;
        while ($consulta = sqlsrv_fetch_array($consulta5)){
            $cont++;
            if($consulta['PREMATURO'] != 'PREMATURO'){ 
                foreach (range(110, 130) as $numero) {
                    if($numero == $consulta['SUPLEMENTADO']){
                        $cumple++;
                    }
                }
                if(is_null ($consulta['SUPLEMENTADO'])){
                    $no_cumple++;
                }
                if(!is_null ($consulta['SUPLEMENTADO']) && ($consulta['SUPLEMENTADO']<110 || $consulta['SUPLEMENTADO']>130)){
                    $observado++;
                 }
            }
            else{
                $observado++;
            }
        }
    ?>
        <div class="container">
            <div class="text-center p-3">
              <h3>Niños de 4 Meses - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4"><b class="align-middle">Cantidad de Registros: <?php echo $cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Cumple <span class="badge bg-success rounded-pill"><?php echo $cumple; ?></span></li>
                    <li class="list-group-item font-14">No Cumplen <span class="badge bg-danger rounded-pill"><?php echo $no_cumple; ?></span></li>
                    <li class="list-group-item font-14">Observados <span class="badge bg-warning rounded-pill"><?php echo $observado; ?> </span></li>
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button>
                <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='4_meses.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="10" data-limit-navigation="10">
                    <thead>
                        <tr style="font-size: 12px; background: #c9d0e2; text-align: center;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle" id="fields_4_meses_head">Menor Visitado</th> 
                            <th class="align-middle" id="fields_4_meses_head">Menor Encontrado</th> 
                            <th class="align-middle" id="fields_4_meses_head">DNI</th>
                            <th class="align-middle" id="fields_4_meses_head">Nùmero CNV</th>
                            <th class="align-middle">Fecha de Nacimiento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle" id="fields_4_meses_head">Tipo Seguro</th> 
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle">Prematuro</th> 
                            <th class="align-middle">Suplementado (días)</th>
                            <th class="align-middle" id="fields_4_meses_head">Ultima Ate PN</th>
                            <th class="align-middle">Cumple</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4">
                        <div class="form-group">
                            <div id="inputbus" class="input-group">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_4_meses.php');
                        $i=1;
                        while ($consulta = sqlsrv_fetch_array($consulta5)){  
                            // CAMBIO AQUI
                            if(is_null ($consulta['NOMBRE_PROV']) ){
                                $newdate3 = '  -'; }
                                else{
                            $newdate3 = $consulta['NOMBRE_PROV'] ;}
                
                            if(is_null ($consulta['NOMBRE_DIST']) ){
                                $newdate4 = '  -'; }
                                else{
                            $newdate4 = $consulta['NOMBRE_DIST'];}
                
                            if(is_null ($consulta['EESS_ATENCION']) ){
                                $newdate5 = '  -'; }
                                else{
                            $newdate5 = $consulta['EESS_ATENCION'];}
                
                            if(is_null ($consulta['MENOR_VISITADO']) ){
                                $newdate6 = '  -'; }
                                else{
                            $newdate6 = $consulta['MENOR_VISITADO'];}
                
                            if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                $newdate7 = '  -'; }
                                else{
                            $newdate7 = $consulta['MENOR_ENCONTRADO'];}
                
                            if(is_null ($consulta['NUM_DNI']) ){
                                $newdate8 = '  -'; }
                                else{
                            $newdate8 = $consulta['NUM_DNI'];}
            
                            if(is_null ($consulta['NUM_CNV']) ){
                                $newdate9 = '  -'; }
                                else{
                            $newdate9 = $consulta['NUM_CNV'];}
                
                            if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                $newdate10 = '  -'; }
                                else{
                            $newdate10 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
                
                            if(is_null ($consulta['DOCUMENTO']) ){
                                $newdate11 = '  -'; }
                                else{ 
                                $newdate11 = $consulta['DOCUMENTO'];}
                                        
                            if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                                $newdate12 = '  -'; }
                            else{
                                $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
                
                            if(is_null ($consulta['PREMATURO']) ){
                                $newdate13 = '  -'; }
                                else{
                                $newdate13 = $consulta['PREMATURO'];}
                
                            if(is_null ($consulta['SUPLEMENTADO']) ){
                                $newdate14 = '  -'; }
                                else{
                                $newdate14 = $consulta['SUPLEMENTADO'];}
                
                            if(is_null ($consulta['ULTIMA_ATE_PN']) ){
                                $newdate15 = '  -'; }
                                else{
                                $newdate15 = $consulta['ULTIMA_ATE_PN'];}
                
                            if(is_null ($consulta['TIPO_SEGURO']) ){
                                $newdate16 = '  -'; }
                                else{
                                $newdate16 = $consulta['TIPO_SEGURO'];}            
                            ?>
                            <tr style="font-size: 12px; text-align: center;">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle"><?php echo $newdate3; ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                                <td class="align-middle" id="fields_4_meses_body"><?php echo $newdate6; ?></td>
                                <td class="align-middle" id="fields_4_meses_body"><?php if ($newdate7 == 'SI') {
                                        echo "<span class='badge bg-correct'>Si</span>";
                                    }else{ echo "<span class='badge bg-incorrect'>No</span>"; }                                                                                          
                                  ?>
                                </td>
                                <td class="align-middle" id="fields_4_meses_body"><?php echo $newdate8; ?></td>
                                <td class="align-middle" id="fields_4_meses_body"><?php echo $newdate9; ?></td>
                                <td class="align-middle"><?php echo $newdate10; ?></td>
                                <td class="align-middle"><?php echo $newdate11; ?></td>
                                <td class="align-middle" id="fields_4_meses_body"><?php echo $newdate16; ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate12); ?></td>
                                <td class="align-middle"><?php echo $newdate13; ?></td>
                                <td class="align-middle"><?php echo $newdate14; ?></td>
                                <td class="align-middle" id="fields_4_meses_body"><?php echo utf8_encode($newdate15); ?></td>
                                <td class="align-middle"><?php
                                    if($newdate13 != 'PREMATURO'){ 
                                        foreach (range(110, 130) as $numero) {
                                            if($numero == $newdate14){
                                                echo "<span class='badge bg-correct'>Si</span>";
                                            }
                                        }
                                        if(is_null ($consulta['SUPLEMENTADO'])){
                                            echo "<span class='badge bg-incorrect'>No</span>";
                                        }
                                        if(!is_null ($consulta['SUPLEMENTADO']) && ($newdate14<110 || $newdate14>130)){
                                            echo "<span class='badge bg-observed'>Observado</span>";
                                         }
                                    }
                                    else{
                                        echo "<span class='badge bg-observed'>Observado</span>";
                                    }                                    
                                ?></td>
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