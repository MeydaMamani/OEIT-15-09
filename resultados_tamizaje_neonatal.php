<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
?>
<?php
  include('consulta_tamizaje_neonatal.php');
  $row_cont=0; $cumple=0; $no_cumple=0; $observado=0; 
  while ($consulta = sqlsrv_fetch_array($consulta3)){
    $row_cont++;
    if(is_null($consulta['Fecha_Atencion']) || is_null($consulta['fecha_nacimiento_nino'])){
      $observado++;
    }else {
      $fecha_atencion  = new DateTime(date_format($consulta['Fecha_Atencion'], "d-m-Y"));
      $fecha_nacimiento = new DateTime(date_format($consulta['fecha_nacimiento_nino'], "d-m-Y"));
      $intvl = $fecha_nacimiento->diff($fecha_atencion);
        if($intvl->days <= 6 && $intvl->days >=0){
          $cumple++;
        }else if($intvl->days > 6){
          $no_cumple++;
        }
    }
  }
?>

        <div class="container">
            <div class="text-center p-3">
              <h4>Tamizaje Neonatal (CG02) - <?php echo $nombre_mes; ?> </h4>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Cumple <span class="badge bg-success rounded-pill cumple"><?php echo $cumple; ?></span></li>
                    <li class="list-group-item font-14">No Cumple <span class="badge bg-danger rounded-pill no_cumple"><?php echo $no_cumple; ?></span></li>
                    <li class="list-group-item font-14">Observado <span class="badge bg-warning rounded-pill observado"><?php echo $observado; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                        <?php 
                            if($cumple == 0 and $row_cont == 0){ echo '0 %'; }
                            else{  echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%';
                            }
                        ?>
                        </span>
                    </li>
                  </ul>
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button>
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='tamizaje_neonatal.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todo</button>
            <div class="col-12 table-responsive table_no_fed">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #AED6F1;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle" id="color_neonatal_head">Tipo de Seguro</th>
                            <th class="align-middle">Fecha de Nacimiento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_neonatal_head">Menor Encontrado</th>
                            <th class="align-middle">Nombre ESS</th>
                            <th class="align-middle">Fecha Atención</th>
                            <th class="align-middle">Lugar de Tamizaje (HIS)</th>
                            <th class="align-middle">Cumple</th>
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
                        include('consulta_tamizaje_neonatal.php');
                        $i=1;
                        while ($consulta = sqlsrv_fetch_array($consulta3)){  
                            if(is_null ($consulta['nombre_prov']) ){
                              $newdate = '  -'; }
                              else{
                            $newdate = $consulta['nombre_prov'] ;}
                            if(is_null ($consulta['nombre_dist']) ){
                                $newdate1 = '  -'; }
                                else{
                            $newdate1 = $consulta['nombre_dist'] ;}
                
                            if(is_null ($consulta['num_dni']) ){
                                $newdate2 = '  -'; }
                                else{
                            $newdate2 = $consulta['num_dni'];}

                            if(is_null ($consulta['tipo_seguro']) ){
                              $newdate3 = '  -'; }
                              else{
                            $newdate3 = $consulta['tipo_seguro'];}
                              
                            if(is_null ($consulta['fecha_nacimiento_nino']) ){
                                $newdate4 = '  -'; }
                                else{
                            $newdate4 = $consulta['fecha_nacimiento_nino'] -> format('d/m/y');}
                
                            if(is_null ($consulta['apellidos_nino']) ){
                               $newdate6 = '  -'; }
                               else{
                            $newdate6 = $consulta['apellidos_nino'];}

                            if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                              $newdate7 = '  -'; }
                              else{
                            $newdate7 = $consulta['MENOR_ENCONTRADO'];}

                            if(is_null ($consulta['NOMBRE_EESS']) ){
                                $newdate8 = '  -'; }
                                else{
                            $newdate8 = $consulta['NOMBRE_EESS'];}

                            if(is_null ($consulta['Fecha_Atencion']) ){
                                $newdate9 = '  -'; }
                                else{
                            $newdate9 = $consulta['Fecha_Atencion'] -> format('d/m/y');}

                            if(is_null ($consulta['Lugar_TMZ']) ){
                              $newdate10 = '  -'; }
                              else{
                            $newdate10 = $consulta['Lugar_TMZ'];}

                            ?>
                            <tr class="font-12 text-center">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle"><?php echo $newdate; ?></td>
                                <td class="align-middle"><?php echo $newdate1; ?></td>
                                <td class="align-middle"><?php echo $newdate2; ?></td>
                                <td class="align-middle" id="color_neonatal_body"><?php echo $newdate3; ?></td>
                                <td class="align-middle"><?php echo $newdate4; ?></td>                               
                                <td class="align-middle"><?php echo $newdate6; ?></td>
                                <td class="align-middle" id="color_neonatal_body"><?php echo $newdate7; ?></td>
                                <td class="align-middle"><?php echo $newdate8; ?></td>
                                <td class="align-middle"><?php echo $newdate9; ?></td>
                                <td class="align-middle"><?php echo $newdate10; ?></td>
                                <td class="align-middle">
                                  <?php
                                    if(is_null($consulta['Fecha_Atencion']) || is_null($consulta['fecha_nacimiento_nino'])){
                                      echo "<span class='badge bg-observed'>Observado</span>";
                                    }else {
                                      $fecha_atencion  = new DateTime(date_format($consulta['Fecha_Atencion'], "d-m-Y"));
                                      $fecha_nacimiento = new DateTime(date_format($consulta['fecha_nacimiento_nino'], "d-m-Y"));
                                      $intvl = $fecha_nacimiento->diff($fecha_atencion);
                                      // echo $intvl->days . " days ";
                                        if($intvl->days <= 6 && $intvl->days >=0){
                                          echo "<span class='badge bg-correct'>Si</span>";
                                        }else if($intvl->days > 6){
                                          echo "<span class='badge bg-incorrect'>No</span>";
                                        }
                                    }
                                  ?>
                                </td>
                            </tr>
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- TABLA FEDDD -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #d9d9d9;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle" id="color_fed_head">Tipo de Seguro</th>
                            <th class="align-middle">Fecha de Nacimiento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_fed_head">Menor Encontrado</th>
                            <th class="align-middle">Nombre ESS</th>
                            <th class="align-middle">Fecha Atención</th>
                            <th class="align-middle">Lugar de Tamizaje (HIS)</th>
                            <th class="align-middle">Cumple</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4 table_fed" style="display: none;">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_tamizaje_neonatal.php');
                        $i_fed=1; $cumple_fed=0; $no_cumple_fed=0; $observado_fed=0;
                        while ($consulta = sqlsrv_fetch_array($consulta3)){  
                          $tipo = strval($consulta['tipo_seguro']);
                          $tipo2 = strpos($tipo, '2');
                          $tipo0 = strpos($tipo, '0');
                          $tipo1 = strpos($tipo, '1');
                          $tipo3 = strpos($tipo, '3');
                          $tipo4 = strpos($tipo, '4');

                          if(($tipo2 === 0 || $tipo2 > 0) && (($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))
                              || (($tipo == '') || ($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))){
                        
                              if(is_null ($consulta['nombre_prov']) ){
                                $newdate = '  -'; }
                                else{
                              $newdate = $consulta['nombre_prov'] ;}
                              if(is_null ($consulta['nombre_dist']) ){
                                  $newdate1 = '  -'; }
                                  else{
                              $newdate1 = $consulta['nombre_dist'] ;}
                  
                              if(is_null ($consulta['num_dni']) ){
                                  $newdate2 = '  -'; }
                                  else{
                              $newdate2 = $consulta['num_dni'];}

                              if(is_null ($consulta['tipo_seguro']) ){
                                $newdate3 = '  -'; }
                                else{
                              $newdate3 = $consulta['tipo_seguro'];}
                                
                              if(is_null ($consulta['fecha_nacimiento_nino']) ){
                                  $newdate4 = '  -'; }
                                  else{
                              $newdate4 = $consulta['fecha_nacimiento_nino'] -> format('d/m/y');}
                  
                              if(is_null ($consulta['apellidos_nino']) ){
                                $newdate6 = '  -'; }
                                else{
                              $newdate6 = $consulta['apellidos_nino'];}

                              if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                                $newdate7 = '  -'; }
                                else{
                              $newdate7 = $consulta['MENOR_ENCONTRADO'];}

                              if(is_null ($consulta['NOMBRE_EESS']) ){
                                  $newdate8 = '  -'; }
                                  else{
                              $newdate8 = $consulta['NOMBRE_EESS'];}

                              if(is_null ($consulta['Fecha_Atencion']) ){
                                  $newdate9 = '  -'; }
                                  else{
                              $newdate9 = $consulta['Fecha_Atencion'] -> format('d/m/y');}

                              if(is_null ($consulta['Lugar_TMZ']) ){
                                $newdate10 = '  -'; }
                                else{
                              $newdate10 = $consulta['Lugar_TMZ'];}

                            ?>
                            <tr class="font-12 text-center">
                                <td class="align-middle"><?php echo $i_fed++; ?></td>
                                <td class="align-middle"><?php echo $newdate; ?></td>
                                <td class="align-middle"><?php echo $newdate1; ?></td>
                                <td class="align-middle"><?php echo $newdate2; ?></td>
                                <td class="align-middle" id="color_fed_body"><?php echo $newdate3; ?></td>
                                <td class="align-middle"><?php echo $newdate4; ?></td>                               
                                <td class="align-middle"><?php echo $newdate6; ?></td>
                                <td class="align-middle" id="color_fed_body"><?php echo $newdate7; ?></td>
                                <td class="align-middle"><?php echo $newdate8; ?></td>
                                <td class="align-middle"><?php echo $newdate9; ?></td>
                                <td class="align-middle"><?php echo $newdate10; ?></td>
                                <td class="align-middle">
                                  <?php
                                    if(is_null($consulta['Fecha_Atencion']) || is_null($consulta['fecha_nacimiento_nino'])){
                                      $observado_fed++;
                                    }else {
                                      $fecha_atencion  = new DateTime(date_format($consulta['Fecha_Atencion'], "d-m-Y"));
                                      $fecha_nacimiento = new DateTime(date_format($consulta['fecha_nacimiento_nino'], "d-m-Y"));
                                      $intvl = $fecha_nacimiento->diff($fecha_atencion);
                                        if($intvl->days <= 6 && $intvl->days >=0){
                                          $cumple_fed++;
                                        }else if($intvl->days > 6){
                                          $no_cumple_fed++;
                                        }
                                    }
                                  ?>
                                </td>
                            </tr>
                        <?php
                              }
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">
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
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1250px;">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cuadro Resumen</h5>
                <h5 class="modal-title" id="exampleModalLabel">Precondición </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <div class="row">
                  <div class="col-md table-responsive">
                    <table class="table table-bordered table-hover">
                      <thead>
                        <tr class="text-light text-center" style="font-size: 12px; background: #5a6a77;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Gestantes Atendidas</th>
                            <th class="align-middle">Tamizaje Violencia</th>
                            <th class="align-middle">Problemas relacionados con violencia</th> 
                            <th class="align-middle">Diagnóstico de Tratamiento</th>
                            <th class="align-middle">Avance</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          include('consulta_resumen_gestante_tratamiento.php'); 
                          $i=1;
                          while ($consulta = sqlsrv_fetch_array($consulta2)){  
                            $violencia=$consulta['PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA'];
                            $tratamiento=$consulta['DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO'];
                        ?>
                          <tr style="font-size: 11px; text-align: center;">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($consulta['Provincia_Establecimiento']); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($consulta['Distrito_Establecimiento']); ?></td>
                            <td class="align-middle"><?php echo $consulta['GESTANTES_ATENDIDAS']; ?></td>
                            <td class="align-middle"><?php echo $consulta['TAMIZAJE_VIOLENCIA']; ?></td>
                            <td class="align-middle"><?php echo $violencia; ?></td>
                            <td class="align-middle"><?php echo $tratamiento; ?></td>
                            <td class="align-middle"><?php 
                                if($tratamiento == 0 and $violencia == 0){
                                  echo '0 %';
                                }else{
                                  echo ($tratamiento/$violencia)* 100, ' %';
                                }                                
                              ?>
                            </td>
                          </tr>
                          <?php
                          ;}
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
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-body">
                <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                <img src="./img/Screenshot_94.png" width="465" alt="">
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
          var ctx= document.getElementById("myChart").getContext("2d");
          var myChart= new Chart(ctx,{
              type: "bar",
              data:{
                  labels:[
                    <?php
                      include('consulta_grafica_gestante_tratamiento.php');
                      for ($i = 0; $i < $numero; $i++) {
                        $data = $lista_distritos[$i];
                        echo "'$data', ";
                      }
                    ?>
                  ],
                  datasets:[{
                          label:'Num datos',
                          data:[
                            <?php
                              include('consulta_grafica_gestante_tratamiento.php');
                              for ($i = 0; $i < $n; $i++) {
                                if($lista_tratamiento[$i] == 0 and $lista_violencia[$i] == 0){
                                  echo "'0', ";
                                }else{
                                  $data = (($lista_tratamiento[$i]/$lista_violencia[$i])*100);
                                  echo "'$data', ";
                                }
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
  <script>
        $(function(){
            $(".btn_fed").click(function(){
                $(".total").text(<?php echo $i_fed-1; ?>);
                $(".cumple").text(<?php echo $cumple_fed; ?>);
                $(".no_cumple").text(<?php echo $no_cumple_fed; ?>);
                $(".observado").text(<?php echo $observado_fed; ?>);
                $(".avance").text(<?php if($cumple_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($cumple_fed/($i_fed-1))*100), 2, '.', '');
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