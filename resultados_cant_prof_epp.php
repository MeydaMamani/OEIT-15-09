<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    if (isset($_POST['Buscar'])) {
        header("Content-Type: text/html; charset=UTF-16LE");
        header('Content-Type: text/html; charset=UTF-8');
        global $conex;
        include('./base.php');

    include('consulta_cant_prof_epp.php');
    $row_cnt=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta1)){
        $row_cnt++;
    }
?>

        <div class="container">
            <div class="text-center p-3">
              <h3>Cantidad de Profesionales EPP (2020 FED) - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"> <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <!-- <li class="list-group-item font-14">Suplementados <span class="badge bg-success rounded-pill correcto"><?php echo $correctos; ?></span></li>
                    <li class="list-group-item font-14">No Suplementados <span class="badge bg-danger rounded-pill incorrecto"><?php echo $incorrectos; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                      <?php
                        if($correctos == 0 and $incorrectos == 0){
                            echo '0 %';
                          }else{
                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%';
                          }
                      ?> </span>
                    </li> -->
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="button" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <!-- <button type="button" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Información</button> -->
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='cant_prof_epp.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <div class="d-flex">
                <form action="impresion_profesionales.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="exportarCSV" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                </form>
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #f1f5e0;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Código Ipress</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Personal</th>
                            <th class="align-middle">Profesión</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-3">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php
                            include('consulta_cant_prof_epp.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta1)){
                                if(is_null ($consulta['Provincia_Establecimiento']) ){
                                    $newdate = '  -'; }
                                    else{
                                $newdate = $consulta['Provincia_Establecimiento'];}

                                if(is_null ($consulta['Distrito_Establecimiento']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['Distrito_Establecimiento'] ;}

                                if(is_null ($consulta['Codigo_Unico']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['Codigo_Unico'] ;}

                                if(is_null ($consulta['Nombre_Establecimiento']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['Nombre_Establecimiento'];}

                                if(is_null ($consulta['Numero_Documento_Personal']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['Numero_Documento_Personal'];}

                                if(is_null ($consulta['PERSONAL']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['PERSONAL'];}

                                if(is_null ($consulta['Descripcion_Profesion']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Descripcion_Profesion'];}

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
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

    <?php } ?>
    
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>