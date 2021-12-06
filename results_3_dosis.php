<?php
    include('./base.php');
    include('zone_setting.php');
    include('query_3_dosis.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta3)){  
        $row_cont++;
    }  
?>

    <div class="page-wrapper">
        <div class="container">
            <div class="modal-img text-center">
                <div class="contenido">
                    <img src="./img/text_3_dose.png" width="600" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center pt-2">
                <h3>Aptos Para Tercera Dosis</h3>
            </div>
            <!-- <p>El presente reporte muestra todas las personas al día de hoy aptos para Tercera dosis, esto según procedimiento aprobado por el Ministerio de Salud, a los 150 días desde su segunda dosis.</p> -->
            <div class="col-md-12 d-flex mb-3 mt-3 justify-content-center">
                <form action="print_3_dosis.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                </form>
                <button type="button" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='standart_3_dose.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
            <div class="col-12 table-responsive" id="cuatro_meses">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-13 border" style="background: #c9d0e2;">
                            <th id="patient"></th>
                            <th colspan="4" class="border" id="patient">Paciente</th>
                            <th colspan="4" class="border" id="first_dose">Primera Dosis</th>
                            <th colspan="6" class="border" id="second_dose">Segunda Dosis</th>
                            <th colspan="1" class="border">3era Dosis</th>
                        </tr>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle border" id="patient">#</th>
                            <th class="align-middle border" id="patient">Tipo Documento</th>
                            <th class="align-middle border" id="patient">Documento</th> 
                            <th class="align-middle border" id="patient">Paciente</th> 
                            <th class="align-middle border" id="patient">Celular</th>
                            <th class="align-middle border" id="first_dose">Provincia</th>
                            <th class="align-middle border" id="first_dose">Distrito</th>
                            <th class="align-middle border" id="first_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="first_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="second_dose">Provincia</th>
                            <th class="align-middle border" id="second_dose">Distrito</th>
                            <th class="align-middle border" id="second_dose">Fecha de Vacunación</th>
                            <th class="align-middle border" id="second_dose">Nombre Vacuna</th>
                            <th class="align-middle border" id="second_dose">Edad</th>
                            <th class="align-middle border" id="second_dose">Grupo de Riesgo</th>
                            <th class="align-middle border">Fecha de Vacunación</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
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

                                if(is_null ($consulta['NUM_CELULAR']) ){
                                    $newdate4 = '  -'; }
                                else{
                                    $newdate4 = $consulta['NUM_CELULAR'];}

                                if(is_null ($consulta['PROVINCIA_UNO']) ){
                                    $newdate5 = '  -'; }
                                else{
                                    $newdate5 = $consulta['PROVINCIA_UNO'];}

                                if(is_null ($consulta['DISTRITO_UNO']) ){
                                    $newdate6 = '  -'; }
                                else{
                                    $newdate6 = $consulta['DISTRITO_UNO'];}

                                if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) ){
                                    $newdate7 = '  -'; }
                                else{
                                    $newdate7 = $consulta['FECHA_PRIMERA_DOSIS'] -> format('d/m/y');}

                                if(is_null ($consulta['NOMBRE_PRIMERA_DOSIS']) ){
                                    $newdate8 = '  -'; }
                                else{
                                    $newdate8 = $consulta['NOMBRE_PRIMERA_DOSIS'];}
                                
                                if(is_null ($consulta['PROVINCIA_DOS']) ){
                                    $newdate9 = '  -'; }
                                else{
                                    $newdate9 = $consulta['PROVINCIA_DOS'];}

                                if(is_null ($consulta['DISTRITO_DOS']) ){
                                    $newdate10 = '  -'; }
                                else{
                                    $newdate10 = $consulta['DISTRITO_DOS'];}

                                if(is_null ($consulta['FECHA_SEGUNDA_DOSIS']) ){
                                    $newdate11 = '  -'; }
                                else{
                                    $newdate11 = $consulta['FECHA_SEGUNDA_DOSIS'] -> format('d/m/y');}

                                if(is_null ($consulta['NOMBRE_SEGUNDA_DOSIS']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['NOMBRE_SEGUNDA_DOSIS'];}

                                if(is_null ($consulta['EDAD']) ){
                                    $newdate13 = '  -'; }
                                else{
                                    $newdate13 = $consulta['EDAD'];}

                                if(is_null ($consulta['GRUPO_RIESGO']) ){
                                    $newdate14 = '  -'; }
                                else{
                                    $newdate14 = $consulta['GRUPO_RIESGO'];}

                                if(is_null ($consulta['FECHA_PARA_3RA_DOSIS']) ){
                                    $newdate15 = '  -'; }
                                else{
                                    $newdate15 = $consulta['FECHA_PARA_3RA_DOSIS'] -> format('d/m/y');}

        
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
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate14); ?></td>
                            <td class="align-middle" id="fields_brechas_body"><?php echo utf8_encode($newdate15); ?></td>
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