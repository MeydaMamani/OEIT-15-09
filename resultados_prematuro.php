<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
?>

<?php 
  include('consulta_prematuro.php');
  $row_cnt=0;
  $correctos=0;
  $incorrectos=0;
  while ($consulta = sqlsrv_fetch_array($consulta2)){
    $row_cnt++;
    if(is_null ($consulta['SUPLEMENTADO']) ){ $incorrectos++; }    
    else{ $correctos++; }
  }
?>

        <div class="container">
            <div class="text-center p-3">
              <h3>Niños Prematuros - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4"><b class="align-middle">Cantidad de Registros: <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Correctos <span class="badge bg-success rounded-pill"><?php echo $correctos; ?></span></li>
                    <li class="list-group-item font-14">Incorrectos <span class="badge bg-danger rounded-pill"><?php echo $incorrectos; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill">
                      <?php 
                        if($correctos == 0 and $incorrectos == 0){
                            echo '0 %';
                          }else{
                            echo number_format((float)(($correctos/$row_cnt)*100), 2, '.', ''), '%';
                          }
                      ?> </span>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <button type="button" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button>
                <button type="button" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='prematuros.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todo</button>
            <div class="col-12 table-responsive table_no_fed">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="20">
                    <thead>
                        <tr style="font-size: 12px; background: #e0eff5; text-align: center;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Menor Encontrado</th> 
                            <th class="align-middle">Fecha Nacido</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle">Prematuro</th>
                            <th class="align-middle">Suplementado</th>
                            <th class="align-middle">Tipo Documento Paciente</th>
                            <th class="align-middle">Tipo Seguro</th> 
                            <th class="align-middle">Se Atiende</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4 table_no_fed">
                        <div class="form-group">
                            <div id="inputbus" class="input-group">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_prematuro.php');
                        $i=1;
                        while ($consulta = sqlsrv_fetch_array($consulta2)){  
                            if(is_null ($consulta['Provnacido']) ){
                                $newdate2 = '  -'; }
                                else{
                            $newdate2 = $consulta['Provnacido'];}
                
                            if(is_null ($consulta['Distnacido']) ){
                                $newdate3 = '  -'; }
                                else{
                            $newdate3 = $consulta['Distnacido'] ;}
                
                            if(is_null ($consulta['Establecimiento']) ){
                                $newdate4 = '  -'; }
                                else{
                            $newdate4 = $consulta['Establecimiento'];}
                
                            if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                $newdate5 = '  -'; }
                                else{
                            $newdate5 = $consulta['MENOR_ENCONTRADO'];}
                
                            if(is_null ($consulta['FECNACIDO']) ){
                                $newdate6 = '  -'; }
                                else{
                            $newdate6 = $consulta['FECNACIDO'] -> format('d/m/y');}
                
                            if(is_null ($consulta['Numcnv']) ){
                                $newdate7 = '  -'; }
                                else{
                            $newdate7 = $consulta['Numcnv'];}
                
                            if(is_null ($consulta['NOMBRES_MENOR']) ){
                                $newdate8 = '  -'; }
                                else{
                            $newdate8 = $consulta['NOMBRES_MENOR'];}
                
                            if(is_null ($consulta['PREMATURO']) ){
                                $newdate10 = '  -'; }
                                else{
                            $newdate10 = $consulta['PREMATURO'];}

                            if(is_null ($consulta['SUPLEMENTADO']) ){
                                $newdate11 = 'No'; }
                                else{
                            $newdate11 = 'Si';}

                            if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                                $newdate12 = '  -'; }
                                else{
                            $newdate12 = $consulta['Tipo_Doc_Paciente'];}

                            if(is_null ($consulta['TIPO_SEGURO']) ){
                                $newdate13 = '  -'; }
                                else{
                            $newdate13 = $consulta['TIPO_SEGURO'];}

                            if(is_null ($consulta['SE_ATIENDE']) ){
                                $newdate14 = '  -'; }
                                else{
                            $newdate14 = $consulta['SE_ATIENDE'];}
                
                    ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php if($newdate11 == 'Si'){ echo "<span class='badge bg-correct'>$newdate11</span>"; }
                            else{ echo "<span class='badge bg-incorrect'>$newdate11</span>"; } ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate14); ?></td>
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
            <!-- TABLA FED -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="20">
                    <thead>
                        <tr class="text-center font-12" style="background: #e0eff5;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Menor Encontrado</th> 
                            <th class="align-middle">Fecha Nacido</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle">Prematuro</th>
                            <th class="align-middle">Suplementado</th>
                            <th class="align-middle">Tipo Documento Paciente</th>
                            <th class="align-middle">Tipo Seguro</th> 
                            <th class="align-middle">Se Atiende</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4 table_fed" style="display: none;">
                        <div class="form-group">
                            <div id="inputbus" class="input-group">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_prematuro.php');
                        $i=1;

                        while ($consulta = sqlsrv_fetch_array($consulta2)){  
                            // ojo ver si en caso no es dos numeros------------------------------------------OJOOOOOO
                            // echo gettype($consulta['TIPO_SEGURO']);
                            if($consulta['TIPO_SEGURO'] === '2,') {
                                echo 'SOYYYYY -----', $consulta['TIPO_SEGURO'], '<br>';
                            }

                            if($consulta['TIPO_SEGURO'] != 2){

                                if(is_null ($consulta['Provnacido']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['Provnacido'];}
                    
                                if(is_null ($consulta['Distnacido']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['Distnacido'] ;}
                    
                                if(is_null ($consulta['Establecimiento']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['Establecimiento'];}
                    
                                if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['MENOR_ENCONTRADO'];}
                    
                                if(is_null ($consulta['FECNACIDO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['FECNACIDO'] -> format('d/m/y');}
                    
                                if(is_null ($consulta['Numcnv']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Numcnv'];}
                    
                                if(is_null ($consulta['NOMBRES_MENOR']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['NOMBRES_MENOR'];}
                    
                                if(is_null ($consulta['PREMATURO']) ){
                                    $newdate10 = '  -'; }
                                    else{
                                $newdate10 = $consulta['PREMATURO'];}

                                if(is_null ($consulta['SUPLEMENTADO']) ){
                                    $newdate11 = 'No'; }
                                    else{
                                $newdate11 = 'Si';}

                                if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                                    $newdate12 = '  -'; }
                                    else{
                                $newdate12 = $consulta['Tipo_Doc_Paciente'];}

                                if(is_null ($consulta['TIPO_SEGURO']) ){
                                    $newdate13 = '  -'; }
                                    else{
                                $newdate13 = $consulta['TIPO_SEGURO'];}

                                if(is_null ($consulta['SE_ATIENDE']) ){
                                    $newdate14 = '  -'; }
                                    else{
                                $newdate14 = $consulta['SE_ATIENDE'];}
                
                    ?>
                        <tr style="font-size: 12px; text-align: center;">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php if($newdate11 == 'Si'){ echo "<span class='badge bg-correct'>$newdate11</span>"; }
                            else{ echo "<span class='badge bg-incorrect'>$newdate11</span>"; } ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate14); ?></td>
                        </tr>                        
                        <?php
                            }
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
<script>
   $(function(){
    $(".btn_fed").click(function(){
      console.log('me diste click fed');
      var data = $(".datos").text();
      console.log('MIS DATOS ', data);
      // $(".datos").text('260');
      $(".table_fed").show();
      $(".table_no_fed").hide();
    });
    $(".btn_all").click(function(){
      console.log('Me diste click boton todo');
      // $(".datos").text('283');
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