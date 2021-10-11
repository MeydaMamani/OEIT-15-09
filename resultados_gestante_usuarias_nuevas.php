<?php 
  require ('abrir.php');    
  if (isset($_POST['Buscar'])) {
    global $conex;
  include('./base.php');
?>
      <?php 
        include('consulta_gestante_usuarias_nuevas.php');
        $row_cont=0; $cumple=0; $no_cumple=0;
        while ($consulta = sqlsrv_fetch_array($consulta2)){  
          $row_cont++;
          if($consulta['Codigo_Item'] != '' and !is_null ($consulta['Codigo_Item'])){
            $cumple++;
          }else{
            $no_cumple++;
          }
        }  
      ?>
        <div class="container">
            <div class="text-center p-3">
              <h3>Gestantes Usuarias Nuevas con TMZ Violencia - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Cumple <span class="badge bg-success rounded-pill cumple"><?php echo $cumple; ?></span></li>
                    <li class="list-group-item font-14">No Cumple <span class="badge bg-danger rounded-pill no_cumple"><?php echo $no_cumple; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                        <?php 
                            if($cumple == 0 and $row_cont == 0){ echo '0 %'; }
                            else{  echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%';
                            }
                        ?> </span>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-bar-chart"></i> Cuadro Resumen</button> -->
                <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='gestante_usuarias_nuevas.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>


              <div class="d-flex">
                <!--<button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="fa fa-clone"></i> FED</button>
                <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="fa fa-circle"></i> Todo</button>-->
                <form action="impresion_gestante_usuarias_nuevas.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir Excel</button>
                </form>
            </div>
           
            <div class="col-12 table-responsive table_no_fed">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="20">
                <thead>
                  <tr class="text-center font-12" style="background: #c9d0e2;">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Provincia</th>
                    <th class="align-middle">Distrito</th>
                    <th class="align-middle">Establecimiento</th>
                    <th class="align-middle">Tipo Documento</th>
                    <th class="align-middle">Documento</th>
                    <th class="align-middle">Fecha Nacimiento Paciente</th>
                    <th class="align-middle">Edad</th>
                    <th class="align-middle">Fecha Atención</th>
                    <th class="align-middle">Código</th>
                    <th class="align-middle">Cumple</th>
                  </tr>
                </thead>
                <div>
                  <div class="float-end pb-3 table_no_fed">
                    <div class="form-group">
                      <div id="inputbus" class="input-group input-group-sm">
                        <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                        <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                      </div>
                    </div>
                  </div>
                </div>
                <tbody>
                  <?php 
                    include('consulta_gestante_usuarias_nuevas.php');
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){  
                      if(is_null ($consulta['Provincia_Establecimiento']) ){
                          $newdate = '  -'; }
                      else{
                        $newdate = $consulta['Provincia_Establecimiento'];}

                      if(is_null ($consulta['distrito_establecimiento']) ){
                        $newdate2 = '  -'; }
                      else{
                        $newdate2 = $consulta['distrito_establecimiento'];}
 
                      if(is_null ($consulta['Abrev_Tipo_Doc_Paciente']) ){
                          $newdate3 = '  -'; }
                        else{
                      $newdate3 = $consulta['Abrev_Tipo_Doc_Paciente'];}

                      if(is_null ($consulta['Nombre_Establecimiento']) ){
                          $newdate4 = '  -'; }
                        else{
                      $newdate4 = $consulta['Nombre_Establecimiento'];}

                      if(is_null ($consulta['Numero_Documento_Paciente']) ){
                          $newdate5 = '  -'; }
                        else{
                      $newdate5 = $consulta['Numero_Documento_Paciente'];}

                      if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){
                          $newdate6 = '  -'; }
                        else{
                      $newdate6 = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');}

                      if(is_null ($consulta['Edad_Reg']) ){
                          $newdate7 = '  -'; }
                        else{
                      $newdate7 = $consulta['Edad_Reg'];}

                      if(is_null ($consulta['Fecha_Atencion']) ){
                        $newdate8 = '  -'; }
                      else{
                        $newdate8 = $consulta['Fecha_Atencion']-> format('d/m/y');}

                      if(is_null ($consulta['Codigo_Item']) ){
                            $newdate9 = '  -'; }
                      else{
                        $newdate9 = $consulta['Codigo_Item'];}

                  ?>
                    <tr class="text-center font-12" id="table_fed">
                      <td class="align-middle"><?php echo $i++; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                      <td class="align-middle"><?php echo $newdate3; ?></td>
                      <td class="align-middle"><?php echo $newdate5; ?></td>
                      <td class="align-middle"><?php echo $newdate6; ?></td>
                      <td class="align-middle"><?php echo $newdate7; ?></td>                      
                      <td class="align-middle"><?php echo $newdate8; ?></td>
                      <td class="align-middle"><?php echo $newdate9; ?></td>
                      <td class="align-middle"><?php 
                        if($consulta['Codigo_Item'] != '' and !is_null ($consulta['Codigo_Item'])){
                          echo "<span class='badge bg-correct'>Si</span>";
                        }else{
                          echo "<span class='badge bg-incorrect'>No</span>";
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
        <!-- MODAL CUADRO RESUMEN-->
        <div class="modal fade" id="ModalResumen" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1300px;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cuadro Resumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr style="font-size: 12px; background: #d7d8d8; text-align: center;">
                          <th>#</th>
                          <th>Provincia</th>
                          <th>Distrito</th>
                          <th>Establecimiento</th>
                          <th>Número Documento</th>
                          <th>Fecha Nacimiento Paciente</th>
                          <th>Edad</th>
                          <th>Fecha Atención</th>
                          <th>Código</th>
                          <th style="background: white;">Avance</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          include('consulta_gestante_usuarias_nuevas.php'); 
                          $i=1;
                          while ($consulta = sqlsrv_fetch_array($resum2)){  
                        ?>
                          <tr style="font-size: 11px; text-align: center;">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($consulta['Provincia']); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($consulta['Distrito']); ?></td>
                            <td class="align-middle"><?php echo $consulta['captada']; ?></td>
                            <td class="align-middle"><?php echo $consulta['bacteriuria']; ?></td>
                            <td class="align-middle"><?php echo $consulta['t_anemia']; ?></td>
                            <td class="align-middle"><?php echo $consulta['sifilis']; ?></td>
                            <td class="align-middle"><?php echo $consulta['vih']; ?></td>
                            <td class="align-middle"><?php echo $consulta['cumple']; ?></td>
                            <td class="align-middle"><?php echo number_format((float)($consulta['AVANCE']), 2, '.', ''), ' %'; ?></td>
                          </tr>
                          <?php
                          }
                          include('cerrar2.php');
                          ?>
                      </tbody>
                    </table>
                  </div>
                  <div class="col-md">
                      <canvas id="myChart" style="width: 500px !important; height: 350px !important;"></canvas>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              </div>
            </div>
          </div>
        </div>
        <!-- MODAL INFORMACION-->
        <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
              <div class="modal-body">
                <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <img src="./img/informacion_usuarias_nuevas.png" style="width: 100%;">
              </div>
            </div>
          </div>
        </div>
<?php } ?>

<script src="./js/jquery-3.6.0.min.js"></script>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
   $(function(){
    $(".btn_fed").click(function(){
      console.log('me diste click fed');
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
<script>
    var ctx= document.getElementById("myChart").getContext("2d");
        var myChart= new Chart(ctx,{
            type: "bar",
            data:{
                labels:[
                  <?php
                    include('consulta_grafica_bateria_completa.php');
                    $numero = sizeof($lista_distritos);
                    for ($i = 0; $i < $numero; $i++) {
                        $data = strval($lista_distritos[$i]);
                        echo "'$data', ";
                    }
                  ?>
                 ],
                datasets:[{
                        label:'Num datos',
                        data:[
                          <?php
                            include('consulta_grafica_bateria_completa.php');
                            $numero = sizeof($lista_captadas);
                            for ($i = 0; $i < $numero; $i++) {
                              echo number_format((float)($lista_avances[$i]), 2, '.', ''), ', ';
                            }
                          ?>
                        ],
                        backgroundColor:[
                            'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)', '#a0e53280',
                            'rgb(74, 135, 72,0.5)', '#98f2c4', '#98ddf2', '#d9daf9',
                            '#f298bd', '#ce9898', 'rgb(66, 134, 244,0.5)', '#e5b63280',
                            'rgb(229, 89, 50,0.5)', '#a0e53280', 'rgb(74, 135, 72,0.5)', '#98f2c4',
                            '#98ddf2', '#d9daf9', '#f298bd', '#ce9898', 
                            'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)', '#a0e53280',
                            'rgb(66, 134, 244,0.5)', '#e5b63280', 'rgb(229, 89, 50,0.5)',
                        ]
                }]
            },
            options:{
                scales:{
                    yAxes:[{
                            ticks:{
                                beginAtZero:true
                            }
                    }]
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                size: 12,
                            }
                        }
                    }
                }
            }
        });
</script>
</body>
</html>