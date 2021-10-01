<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;
        include('./base.php');
?>

<?php 
  include('consulta_cred.php');
  
?>

        <div class="container">
            <div class="text-center p-3">
              <h3>CRED - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4"><b class="align-middle">Cantidad de Registros: <?php echo $row_cnt; ?></b></div>
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
                <button type="button" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button>
                <button type="button" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="button" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='cred.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <!-- <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todo</button> -->
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0ebd8;">
                            <th class="align-middle">#</th>    
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Establecimiento</th>
                            <th class="align-middle">Tipo Documento</th> 
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Fecha Nacimiento Paciente</th>
                            <th class="align-middle">BCG</th>
                            <th class="align-middle">HVB</th>
                            <th class="align-middle">CRED 1</th>
                            <th class="align-middle">CRED 2</th>
                            <th class="align-middle">CRED 3</th>
                            <th class="align-middle">CRED 4</th>
                            <th class="align-middle">CRED 1 MES</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-3 ">
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
                        while ($consulta = sqlsrv_fetch_array($consulta2)){  
                            if(is_null ($consulta['Provincia_Establecimiento']) ){
                                $newdate = '  -'; }
                            else{
                                $newdate = $consulta['Provincia_Establecimiento'];}

                            if(is_null ($consulta['Distrito_Establecimiento']) ){
                                $newdate2 = '  -'; }
                                else{
                            $newdate2 = $consulta['Distrito_Establecimiento'];}
                
                            if(is_null ($consulta['Nombre_Establecimiento']) ){
                                $newdate3 = '  -'; }
                                else{
                            $newdate3 = $consulta['Nombre_Establecimiento'] ;}
                
                            if(is_null ($consulta['Abrev_Tipo_Doc_Paciente']) ){
                                $newdate4 = '  -'; }
                                else{
                            $newdate4 = $consulta['Abrev_Tipo_Doc_Paciente'];}
                
                            if(is_null ($consulta['Numero_Documento_Paciente']) ){
                                $newdate5 = '  -'; }
                                else{
                            $newdate5 = $consulta['Numero_Documento_Paciente'];}
                
                            if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){
                                $newdate6 = '  -'; }
                                else{
                            $newdate6 = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');}
                
                            if(is_null ($consulta['BCG']) ){
                                $newdate7 = '  -'; }
                                else{
                            $newdate7 = $consulta['BCG'] -> format('d/m/y');}
                
                            if(is_null ($consulta['HVB']) ){
                                $newdate8 = '  -'; }
                                else{
                            $newdate8 = $consulta['HVB'] -> format('d/m/y');}
                
                            if(is_null ($consulta['CRED1']) ){
                                $newdate9 = '  -'; }
                                else{
                            $newdate9 = $consulta['CRED1'] -> format('d/m/y');}

                            if(is_null ($consulta['CRED2']) ){
                                $newdate10 = 'No'; }
                            else{
                                $newdate10 = $consulta['CRED2'] -> format('d/m/y');}

                            if(is_null ($consulta['CRED3']) ){
                                $newdate11 = '  -'; }
                                else{
                            $newdate11 = $consulta['CRED3'] -> format('d/m/y');}

                            if(is_null ($consulta['CRED4']) ){
                                $newdate12 = '  -'; }
                            else{
                                $newdate12 = $consulta['CRED4'] -> format('d/m/y');}

                            if(is_null ($consulta['CRED1MES']) ){
                                $newdate13 = '  -'; }
                                else{
                            $newdate13 = $consulta['CRED1MES'] -> format('d/m/y');}
                
                    ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle"><?php echo $newdate5; ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate7); ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
                            <td class="align-middle"><?php echo $newdate13; ?></td>
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