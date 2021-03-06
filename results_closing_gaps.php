<?php
    require('abrir.php');
    require('abrir6.php');

    if (isset($_POST['Buscar'])) {
        header('Content-Type: text/html; charset=UTF-8');
        include('./base.php');
        include('zone_setting.php');
        include('query_closing_gaps.php');
        $row_cont=0; $cumple=0; $no_cumple=0; $observado=0;
        while ($consulta = sqlsrv_fetch_array($consulta2)){
            $row_cont++;
        }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
                <h3 class="mb-4">Cierre de Brechas - Segunda Dosis</h3>
            </div>
            <div class="row m-1">
                <?php
                    include('query_closing_gaps.php');
                    while ($consulta = sqlsrv_fetch_array($consulta3)){
                ?>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-1">
                        <p class="card-title text-secondary text-center font-18 pt-2">Total 1ra Dosis</p>
                        <div class="col-md-12 text-center ">
                            <img src="./img/va_0.png" width="140" aling="center" alt="">
                        </div>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-1 justify-content-center d-flex">
                                    <div class="col-md-12 text-center">
                                        <b class="total font-38 text-secondary"><?php echo $consulta['CONTEO_TOTAL_PRIMERAS']; ?></b> <i class="mdi mdi-plus font-38 text-secondary"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-1">
                        <p class="card-title text-secondary text-center font-18 pt-2">Dosis Completa</p>
                        <div class="col-md-12 text-center ">
                            <img src="./img/va_1.png" width="60" alt="" aling="center">
                        </div>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-1 justify-content-center d-flex"> 
                                    <div class="mt-3 col-md-12 text-center">
                                        <b class="total font-38 text-success"><?php echo $consulta['DOSIS_COMPLETA']; ?></b> <i class="mdi mdi-check font-38 text-success"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">2da Fuera Regi??n</h4>
                        <div class="col-md-12 text-center " text-success>
                            <img src="./img/va_2.png" width="90" aling="center">
                        </div>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-1 justify-content-center d-flex">
                                    <div class="ms-2 col-md-12 text-center">
                                        <b class="font-38 cumple"><?php echo $consulta['SEGUNDA_FUERA_REGION']; ?></b> <i class="mdi mdi-plus font-38"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">Fallecidos</h4>
                        <div class="col-md-12 text-center " aling="center">
                            <img src="./img/at.png" width="80"  alt="" >
                        </div>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-1 justify-content-center d-flex">
                                    <div class="mt-2 ms-2 col-md-12 text-center">
                                        <b class="font-38 no_cumple"><?php echo $consulta['FALLECIDOS']; ?></b> <i class="mdi mdi-plus font-38"></i>
                                    </div>
                                </h4>
                            </div>  
                        </div>
                    </div>
                </div>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">Rechazo a Dosis</h4>
                        <div class="col-md-12 text-center ">
                            <img src="./img/va_7.png" width="80" aling="center">
                        </div>
                        <div class="justify-content-center">
                            <div class="align-self-center">
                                <h4 class="font-medium mb-1 justify-content-center d-flex">
                                    <div class="mt-2 ms-2 col-md-12 text-center">
                                        <b class="font-38 text-danger observado"><?php echo $consulta['RECHAZO']; ?></b><i class="mdi mdi-close font-38 text-danger"></i>
                                    </div>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card col-md-2 datos_avance">
                    <div class="card-body p-1">
                        <div class="row pt-2">
                            <div class="col-md-12 p-0 text-center">
                                <h4 class="text-muted">Avance</h4>
                                <h1 class="font-light avance mb-2 text-primary"><?php
                                        $num = $consulta['RECHAZO'] + $consulta['FALLECIDOS'] + $consulta['SEGUNDA_FUERA_REGION'] + $consulta['DOSIS_COMPLETA'];
                                        $den = $consulta['CONTEO_TOTAL_PRIMERAS'];
                                        echo number_format((float)(($num/$den)*100), 2, '.', ''), '%';
                                    ?>
                                </h1>
                                <div class="col-md-12 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php 
                                        $num = $consulta['RECHAZO'] + $consulta['FALLECIDOS'] + $consulta['SEGUNDA_FUERA_REGION'] + $consulta['DOSIS_COMPLETA'];
                                        $den = $consulta['CONTEO_TOTAL_PRIMERAS'];
                                        echo number_format((float)(($num/$den)*100), 0, '.', '');
                                    ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
            <div class="d-flex mb-3">
                <div class="col-md-12 d-flex justify-content-center">
                    <form action="print_closing_gaps.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='closing_gaps.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div>
            <div class="col-12 table-responsive table_no_fed" id="cierre_brechas">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">N??mero Documento</th>
                            <th class="align-middle">Paciente</th>
                            <th class="align-middle">Edad</th>
                            <th class="align-middle">Celular</th>
                            <th class="align-middle">Nombre Vacuna</th>
                            <th class="align-middle">Grupo Edad</th>
                            <th class="align-middle">Primera Dosis</th>
                            <th class="align-middle" id="fields_brechas">Segunda Dosis Pendiente (Debio inmunizarse)</th>
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
                            include('query_closing_gaps.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){
                                if(is_null ($consulta['PRIMERA_PROV']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['PRIMERA_PROV'] ;}

                                if(is_null ($consulta['PRIMERA_DIST']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['PRIMERA_DIST'];}

                                if(is_null ($consulta['TIPO_DOC']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['TIPO_DOC'];}

                                if(is_null ($consulta['NUM_DOC']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['NUM_DOC'];}

                                if(is_null ($consulta['PRIMERA_PACIEN']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['PRIMERA_PACIEN'];}

                                if(is_null ($consulta['PRIMERA_EDAD']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['PRIMERA_EDAD'];}

                                if(is_null ($consulta['PRIMERA_FAB']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['PRIMERA_FAB'];}

                                if(is_null ($consulta['PRIMERA_GRUPO']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['PRIMERA_GRUPO'] ;}

                                if(is_null ($consulta['PRIMERA']) ){
                                    $newdate11 = '  -'; }
                                    else{
                                    $newdate11 = $consulta['PRIMERA'] -> format('d/m/y');}

                                if(is_null ($consulta['FECHA_PARA_SEGUNDA']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['FECHA_PARA_SEGUNDA'] -> format('d/m/y');}

                                if(is_null ($consulta['PRIMERA_CEL']) ){
                                    $newdate13 = '  -'; }
                                else{
                                    $newdate13 = $consulta['PRIMERA_CEL'] ;}

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle" id="fields_brechas_body"><?php echo $newdate12; ?></td>
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