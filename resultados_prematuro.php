<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    if (isset($_POST['Buscar'])) {
        header("Content-Type: text/html; charset=UTF-16LE");
        header('Content-Type: text/html; charset=UTF-8');
        global $conex;
        include('./base.php');

    include('zone_setting.php');
    include('consulta_prematuro.php');
    $row_cnt=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta7)){
        $row_cnt++;
        if($consulta['SUPLEMENTADO'] == 'SI' ){ 
            $correctos++; 
        }
        else{ $incorrectos++; }
    }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-12 text-primary"><b>Fuente: </b> BD Padrón Nominal y BD CNV con Fecha: <?php echo date("d-m-y"); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
              <h3 class="mb-4">Niños Prematuros CG03 - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row">
                <div class="row justify-content-center">
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 text-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/user_cant.png" width="90" alt="">
                                        </div>
                                        <div class="mt-2 col-md-6">
                                            <b class="total font-60"> <?php echo $row_cnt; ?></b> <i class="mdi mdi-plus font-50 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Suplementados</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 text-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy.png" width="90" alt="">
                                        </div>
                                        <div class="mt-2 col-md-6">
                                            <b class="total font-60"> <?php echo $correctos; ?></b> <i class="mdi mdi-check font-50 text-success
                                             text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">No Suplementados</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 text-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy_x.png" width="90" alt="">
                                        </div>
                                        <div class="mt-2 col-md-6">
                                            <b class="total font-60"> <?php echo $incorrectos; ?></b> <i class="mdi mdi-close font-50 text-danger text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-4">
                                <div class="col-md-8 p-r-0 text-center">
                                    <h1 class="font-light avance mb-3"><?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h1>
                                    <h4 class="text-muted">Avance</h4></div>
                                <div class="col-md-4 mt-2 text-center align-self-center position-sticky p-0">
                                    <div data-label="<?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%'; }
                                        ?>" class="css-bar m-b-0 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                            echo number_format((float)(($correctos/$row_cnt)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex mb-3">
                <div class="col-md-12 d-flex justify-content-center">
                    <form action="impresion_prematuro.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <input hidden name="anio" value="<?php echo $_POST['anio']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="button" name="Limpiar" class="btn btn-outline-danger m-2 btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Información</button>
                    <button type="button" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='prematuros.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div>
            <div class="col-12 table-responsive table_no_fed" id="prematuro">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_prematuro_head">Fecha Nacido</th>
                            <th class="align-middle" id="color_prematuro_head">Tipo Seguro</th>
                            <th class="align-middle" id="color_prematuro_head">Menor Visitado</th>
                            <th class="align-middle">Suplementado</th>
                            <th class="align-middle">Prematuro</th>
                            <th class="align-middle" id="color_prematuro_head">Se Atiende</th>
                        </tr>
                    </thead>
                    <div class="float-end col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_prematuro.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta7)){
                                if(is_null ($consulta['NOMBRE_PROV']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['NOMBRE_PROV'];}
                
                                if(is_null ($consulta['NOMBRE_DIST']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['NOMBRE_DIST'] ;}
                
                                if(is_null ($consulta['NOMBRE_EESS']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['NOMBRE_EESS'];}
                
                                if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['Tipo_Doc_Paciente'];}
                
                                if(is_null ($consulta['CNV_O_DNI']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['CNV_O_DNI'];}
                
                                if(is_null ($consulta['full_name']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['full_name'];}
                
                                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                
                                if(is_null ($consulta['TIPO_SEGURO']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['TIPO_SEGURO'];}
                
                                if(is_null ($consulta['MENOR_VISITADO']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['MENOR_VISITADO'];}
                
                                if(is_null ($consulta['SUPLEMENTADO']) ){
                                    $newdate11 = '  -'; }
                                    else{
                                $newdate11 = $consulta['SUPLEMENTADO'];}
                
                                if(is_null ($consulta['BAJO_PESO_PREMATURO']) ){
                                    $newdate12 = '  -'; }
                                    else{
                                $newdate12 = $consulta['BAJO_PESO_PREMATURO'];}
                
                                if(is_null ($consulta['Establecimiento']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                $newdate13 = $consulta['Establecimiento'];}
                
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php 
                                $findme2 = "+ü";
                                $data = utf8_encode($newdate4); 
                                $pos2 = strpos($data, $findme2);
                                if($pos2 == true){
                                    $resultado = str_replace("+ü", "Á", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+æ", "Ñ", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle"><?php 
                                if($newdate5 == 1) { echo 'DNI'; }
                                else if($newdate5 == 2) { echo 'CE'; }
                                else if($newdate5 == 3) { echo 'PASS'; }
                                else if($newdate5 == 4) { echo 'DIE'; }
                                else if($newdate5 == 5) { echo 'SIN DOCUMENTO'; }
                                else if($newdate5 == 6) { echo 'CNV'; }
                             ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php 
                                $findme2 = "+ü";
                                $data = utf8_encode($newdate7); 
                                $pos2 = strpos($data, $findme2);
                                if($pos2 == true){
                                    $resultado = str_replace("+ü", "Á", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+æ", "Ñ", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo $newdate9; ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle" id="color_prematuro_body"><?php 
                                $findme = "+ô"; $findme2 = "+ü";
                                $data = utf8_encode($newdate13); 
                                $pos = strpos($data, $findme);
                                $pos2 = strpos($data, $findme2);
                                if($pos == true){
                                    $resultado = str_replace("+ô", "Ó", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+ü", "Á", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+æ", "Ñ", $data);
                                    echo $resultado;
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
                    <img src="./img/inf_prematuros.png" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script src="./plugin/chartist-js/jquery.sparkline.min.js"></script>

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