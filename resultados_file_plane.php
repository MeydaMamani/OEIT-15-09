<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');

    include('consulta_file_plane.php');
    $t=0; $v=0;
    while ($consulta = sqlsrv_fetch_array($consulta1)){
      if(!is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){
        $t++;
      }
      if(!is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){
        $v++;
      }
    }
?>

        <div class="container">
            <div class="text-center p-3">
              <h4>Archivo Plano - <?php echo $nombre_mes; ?></h4>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4"><b class="align-middle">Cantidad de Registros: <?php echo $row_cnt; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                  <!-- <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Tratamiento <span class="badge bg-success rounded-pill"><?php echo $t; ?></span></li>
                    <li class="list-group-item font-14">Violencia <span class="badge bg-danger rounded-pill"><?php echo $v; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill">
                      <?php 
                        if($t == 0 and $v == 0){
                          echo '0 %';
                        }else{
                          echo number_format((float)(($t/$v)*100), 2, '.', ''), '%';
                        }
                        ?></span>
                    </li>
                  </ul> -->
                </div>
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='arch_plano.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>            
              <div class="d-flex">
                <form action="impresion_gestante_tratamiento.php" method="POST">
                    <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                    <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                    <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                    <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="fa fa-print"></i> Imprimir CSV</button>
                </form>
            </div>
            <div class="col-12 table-responsive">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-light font-12 text-center" style="background: #44688c;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Documento Paciente</th>
                            <th class="align-middle">Gestantes Atendidas</th>
                            <th class="align-middle">N° Control</th>
                            <th class="align-middle" id="fields_gestante_tratamiento_head">Tamizaje Violencia</th>
                            <th class="align-middle" id="fields_gestante_tratamiento_head">Problemas relacionados con violencia</th> 
                            <th class="align-middle" id="fields_gestante_tratamiento_head">Diagnóstico Inicio de Tratamiento</th>
                            <th class="align-middle">Día Atención</th>
                            <th class="align-middle">Atendido</th>
                            <th class="align-middle">Cumple</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_file_plane.php');
                        $i=1;
                        while ($consulta = sqlsrv_fetch_array($consulta1)){  
                            // CAMBIO AQUI
                            if(is_null ($consulta['Provincia_Establecimiento']) ){
                              $newdate1 = '  -'; }
                              else{
                            $newdate1 = $consulta['Provincia_Establecimiento'] ;}

                            if(is_null ($consulta['Distrito_Establecimiento']) ){
                                $newdate2 = '  -'; }
                                else{
                            $newdate2 = $consulta['Distrito_Establecimiento'] ;}
                
                            if(is_null ($consulta['Numero_Documento_Paciente']) ){
                                $newdate3 = '  -'; }
                                else{
                            $newdate3 = $consulta['Numero_Documento_Paciente'];}

                            if(is_null ($consulta['GESTANTES_ATENDIDAS']) ){
                              $newdate4 = '  -'; }
                              else{
                            $newdate4 = $consulta['GESTANTES_ATENDIDAS'] -> format('d/m/y');}
                              
                            if(is_null ($consulta['nro_control']) ){
                                $newdate5 = '  -'; }
                                else{
                            $newdate5 = $consulta['nro_control'];}
                
                            if(is_null ($consulta['TAMIZAJE_VIOLENCIA']) ){
                                $newdate6 = '  -'; }
                                else{
                            $newdate6 = $consulta['TAMIZAJE_VIOLENCIA'] -> format('d/m/y');}

                            if(is_null ($consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA']) ){
                                $newdate7 = '  -'; }
                                else{
                            $newdate7 = $consulta['TMZ_POSTIVO_PROBLEMAS_VIOLENCIA'] -> format('d/m/y');}

                            if(is_null ($consulta['DIAGNOSTICO_INICIO_TRATAMIENTO']) ){
                              $newdate8 = '  -'; }
                              else{
                            $newdate8 = $consulta['DIAGNOSTICO_INICIO_TRATAMIENTO'] -> format('d/m/y');}

                            if(is_null ($consulta['DIAS_ATENCION']) ){
                              $newdate9 = '  -'; }
                              else{
                            $newdate9 = $consulta['DIAS_ATENCION'];}

                            if(is_null ($consulta['ATENDIO']) ){
                              $newdate10 = '  -'; }
                              else{
                            $newdate10 = $consulta['ATENDIO'];}
                            ?>
                            <tr style="font-size: 12px; text-align: center;">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                <td class="align-middle"><?php echo $newdate3; ?></td>
                                <td class="align-middle"><?php echo $newdate4; ?></td>
                                <td class="align-middle"><?php echo $newdate5; ?></td>
                                <td class="align-middle"><?php echo $newdate6; ?></td>
                                <td class="align-middle"><?php echo $newdate7; ?></td>
                                <td class="align-middle"><?php echo $newdate8; ?></td>
                                <td class="align-middle"><?php echo $newdate9; ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                                <td class="align-middle"><?php 
                                  if($consulta['DIAS_ATENCION'] <= 7 && $consulta['DIAS_ATENCION'] >= 0 && !is_null ($consulta['DIAS_ATENCION'])){
                                    echo "<span class='badge bg-correct'>Si</span>";
                                  }else if($consulta['DIAS_ATENCION'] > 7){
                                    echo "<span class='badge bg-observed'>Observado</span>";
                                  }else if(is_null ($consulta['DIAS_ATENCION'])){
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
                            <td colspan="11">
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
    
  <script src="./js/jquery-3.6.0.min.js"></script>
  <script src="./plugin/footable/js/footable-init.js"></script>
  <script src="./plugin/footable/js/footable.all.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
</body>
</html>