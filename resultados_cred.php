<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;
        include('./base.php');

    include('consulta_cred.php');
    $row_cont=0;
    while ($consulta = sqlsrv_fetch_array($consulta15)){
        $row_cont ++;
    }
?>

        <div class="container">
            <div class="text-center p-3">
              <h3>CRED CG06 - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <!-- <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Correctos <span class="badge bg-success rounded-pill"><?php echo $correctos; ?></span></li>
                    <li class="list-group-item font-14">Incorrectos <span class="badge bg-danger rounded-pill"><?php echo $incorrectos; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill">
                      </span>
                    </li>
                  </ul> -->
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="button" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <button type="button" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='cred.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todo</button>
            <div class="col-12 table-responsive table_no_fed">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0ebd8;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Menor Encontrado</th>
                            <th class="align-middle">Apellidos y Nombres</th> 
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Seguro</th>
                            <th class="align-middle">Fecha Nacimiento Niño</th>
                            <th class="align-middle">Primer Control</th>
                            <th class="align-middle">Segundo Control</th>
                            <th class="align-middle">Cumple</th>
                            <th class="align-middle">Tercer Control</th>
                            <th class="align-middle">Cuarto Control</th>
                            <th class="align-middle">Primer Control Mes</th>
                            <th class="align-middle">Segundo Control Mes</th>
                            <th class="align-middle">Tercero Control Mes</th>
                            <th class="align-middle">Cuarto Control Mes</th>
                            <th class="align-middle">Quinto Control Mes</th>
                            <th class="align-middle">Sexto Control Mes</th>
                            <th class="align-middle">Séptimo Control Mes</th>
                            <th class="align-middle">Octavo Control Mes</th>
                            <th class="align-middle">Noveno Control Mes</th>
                            <th class="align-middle">Decimo Control Mes</th>
                            <th class="align-middle">Onceavo Control Mes</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-3 table_no_fed">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php  
                            include('consulta_cred.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta15)){
                                if(is_null ($consulta['NOMBRE_PROV']) ){
                                    $newdate = '  -'; }
                                else{
                                    $newdate = $consulta['NOMBRE_PROV'];}

                                if(is_null ($consulta['NOMBRE_DIST']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['NOMBRE_DIST'];}
                    
                                if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['MENOR_ENCONTRADO'] ;}
                    
                                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['APELLIDOS_NOMBRES'];}
                    
                                if(is_null ($consulta['DOCUMENTO']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['DOCUMENTO'];}
                    
                                if(is_null ($consulta['TIPO_SEGURO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['TIPO_SEGURO'];}
                    
                                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['PRIMER_CNTRL']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['PRIMER_CNTRL'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['SEG_CNTRL']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['SEG_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['CUMPLE_1']) ){
                                    $newdate10 = '  -'; }
                                else{
                                    $newdate10 = $consulta['CUMPLE_1'];}

                                if(is_null ($consulta['TERCER_CNTRL']) ){
                                    $newdate11 = '  -'; }
                                    else{
                                $newdate11 = $consulta['TERCER_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['CUARTO_CNTRL']) ){
                                    $newdate12 = '  -'; }
                                else{
                                    $newdate12 = $consulta['CUARTO_CNTRL'] -> format('d/m/y');}

                                if(is_null ($consulta['PRIMER_CNTRL_MES']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                $newdate13 = $consulta['PRIMER_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){
                                    $newdate14 = '  -'; }
                                    else{
                                $newdate14 = $consulta['SEGUNDO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['TERCER_CNTRL_MES']) ){
                                    $newdate15 = '  -'; }
                                    else{
                                $newdate15 = $consulta['TERCER_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['CUARTO_CNTRL_MES']) ){
                                    $newdate16 = '  -'; }
                                    else{
                                $newdate16 = $consulta['CUARTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['QUINTO_CNTRL_MES']) ){
                                    $newdate17 = '  -'; }
                                    else{
                                $newdate17 = $consulta['QUINTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEXTO_CNTRL_MES']) ){
                                    $newdate18 = '  -'; }
                                    else{
                                $newdate18 = $consulta['SEXTO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){
                                    $newdate19 = '  -'; }
                                    else{
                                $newdate19 = $consulta['SEPTIMO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){
                                    $newdate20 = '  -'; }
                                    else{
                                $newdate20 = $consulta['OCTAVO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['NOVENO_CNTRL_MES']) ){
                                    $newdate21 = '  -'; }
                                    else{
                                $newdate21 = $consulta['NOVENO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['DECIMO_CNTRL_MES']) ){
                                    $newdate22 = '  -'; }
                                    else{
                                $newdate22 = $consulta['DECIMO_CNTRL_MES'] -> format('d/m/y');}

                                if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){
                                    $newdate23 = '  -'; }
                                    else{
                                $newdate23 = $consulta['ONCEAVO_CNTRL_MES'] -> format('d/m/y');}                    
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
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
                            <td class="align-middle"><?php echo $newdate23; ?></td>
                        </tr>                        
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="24">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- TBALA FEDDD -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #d9d9d9;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Menor Encontrado</th>
                            <th class="align-middle">Apellidos y Nombres</th> 
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Seguro</th>
                            <th class="align-middle">Fecha Nacimiento Niño</th>
                            <th class="align-middle">Primer Control</th>
                            <th class="align-middle">Segundo Control</th>
                            <th class="align-middle">Cumple</th>
                            <th class="align-middle">Tercer Control</th>
                            <th class="align-middle">Cuarto Control</th>
                            <th class="align-middle">Primer Control Mes</th>
                            <th class="align-middle">Segundo Control Mes</th>
                            <th class="align-middle">Tercero Control Mes</th>
                            <th class="align-middle">Cuarto Control Mes</th>
                            <th class="align-middle">Quinto Control Mes</th>
                            <th class="align-middle">Sexto Control Mes</th>
                            <th class="align-middle">Séptimo Control Mes</th>
                            <th class="align-middle">Octavo Control Mes</th>
                            <th class="align-middle">Noveno Control Mes</th>
                            <th class="align-middle">Decimo Control Mes</th>
                            <th class="align-middle">Onceavo Control Mes</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-3 table_fed" style="display: none;">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php  
                            include('consulta_cred.php');
                            $i_fed=1;
                            while ($consulta = sqlsrv_fetch_array($consulta15)){
                                $tipo = strval($consulta['TIPO_SEGURO']);
                                $tipo2 = strpos($tipo, '2');
                                $tipo0 = strpos($tipo, '0');
                                $tipo1 = strpos($tipo, '1');
                                $tipo3 = strpos($tipo, '3');
                                $tipo4 = strpos($tipo, '4');

                                if(($tipo2 === 0 || $tipo2 > 0) && (($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))
                                    || (($tipo == '') || ($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))){

                                    if(is_null ($consulta['NOMBRE_PROV']) ){
                                        $newdate = '  -'; }
                                    else{
                                        $newdate = $consulta['NOMBRE_PROV'];}

                                    if(is_null ($consulta['NOMBRE_DIST']) ){
                                        $newdate2 = '  -'; }
                                        else{
                                    $newdate2 = $consulta['NOMBRE_DIST'];}
                        
                                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                        $newdate3 = '  -'; }
                                        else{
                                    $newdate3 = $consulta['MENOR_ENCONTRADO'] ;}
                        
                                    if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                                        $newdate4 = '  -'; }
                                        else{
                                    $newdate4 = $consulta['APELLIDOS_NOMBRES'];}
                        
                                    if(is_null ($consulta['DOCUMENTO']) ){
                                        $newdate5 = '  -'; }
                                        else{
                                    $newdate5 = $consulta['DOCUMENTO'];}
                        
                                    if(is_null ($consulta['TIPO_SEGURO']) ){
                                        $newdate6 = '  -'; }
                                        else{
                                    $newdate6 = $consulta['TIPO_SEGURO'];}
                        
                                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                                        $newdate7 = '  -'; }
                                        else{
                                    $newdate7 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                        
                                    if(is_null ($consulta['PRIMER_CNTRL']) ){
                                        $newdate8 = '  -'; }
                                        else{
                                    $newdate8 = $consulta['PRIMER_CNTRL'] -> format('d/m/y');}
                        
                                    if(is_null ($consulta['SEG_CNTRL']) ){
                                        $newdate9 = '  -'; }
                                        else{
                                    $newdate9 = $consulta['SEG_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUMPLE_1']) ){
                                        $newdate10 = '  -'; }
                                    else{
                                        $newdate10 = $consulta['CUMPLE_1'];}

                                    if(is_null ($consulta['TERCER_CNTRL']) ){
                                        $newdate11 = '  -'; }
                                        else{
                                    $newdate11 = $consulta['TERCER_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUARTO_CNTRL']) ){
                                        $newdate12 = '  -'; }
                                    else{
                                        $newdate12 = $consulta['CUARTO_CNTRL'] -> format('d/m/y');}

                                    if(is_null ($consulta['PRIMER_CNTRL_MES']) ){
                                        $newdate13 = '  -'; }
                                        else{
                                    $newdate13 = $consulta['PRIMER_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){
                                        $newdate14 = '  -'; }
                                        else{
                                    $newdate14 = $consulta['SEGUNDO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['TERCER_CNTRL_MES']) ){
                                        $newdate15 = '  -'; }
                                        else{
                                    $newdate15 = $consulta['TERCER_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['CUARTO_CNTRL_MES']) ){
                                        $newdate16 = '  -'; }
                                        else{
                                    $newdate16 = $consulta['CUARTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['QUINTO_CNTRL_MES']) ){
                                        $newdate17 = '  -'; }
                                        else{
                                    $newdate17 = $consulta['QUINTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEXTO_CNTRL_MES']) ){
                                        $newdate18 = '  -'; }
                                        else{
                                    $newdate18 = $consulta['SEXTO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){
                                        $newdate19 = '  -'; }
                                        else{
                                    $newdate19 = $consulta['SEPTIMO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){
                                        $newdate20 = '  -'; }
                                        else{
                                    $newdate20 = $consulta['OCTAVO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['NOVENO_CNTRL_MES']) ){
                                        $newdate21 = '  -'; }
                                        else{
                                    $newdate21 = $consulta['NOVENO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['DECIMO_CNTRL_MES']) ){
                                        $newdate22 = '  -'; }
                                        else{
                                    $newdate22 = $consulta['DECIMO_CNTRL_MES'] -> format('d/m/y');}

                                    if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){
                                        $newdate23 = '  -'; }
                                        else{
                                    $newdate23 = $consulta['ONCEAVO_CNTRL_MES'] -> format('d/m/y');}
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i_fed++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
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
                            <td class="align-middle"><?php echo $newdate23; ?></td>
                        </tr>
                        <?php
                                }
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="24">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- MODAL INFORMACION-->
        <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-body">
                <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <img src="./img/CRED.png" style="width: 100%;">
              </div>
            </div>
          </div>
        </div>
    <?php } ?>

<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script>
   $(function(){
    $(".btn_fed").click(function(){
      $(".total").text(<?php echo $i_fed-1; ?>);
      $(".table_fed").show();
      $(".table_no_fed").hide();
    });
    $(".btn_all").click(function(){
      $(".total").text(<?php echo $row_cont ?>);
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