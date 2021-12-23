<?php 
  require ('abrir.php');    
  if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
    include('zone_setting.php');
    include('query_paquete_gestante.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    // while ($consulta = sqlsrv_fetch_array($consulta4)){  
	// 	$row_cont++;
		
    // }  
  ?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
                <h3 class="mb-4">Paquete Completo Gestante - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="mb-3">
                <!-- <div class="row m-2">
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/user_cant.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 total"> <?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Correctos</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 correcto"> <?php echo $correctos; ?></b> <i class="mdi mdi-check font-49 text-success"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">Incorrectos</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy_x.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 incorrecto"> <?php echo $incorrectos; ?></b> <i class="mdi mdi-close font-49 text-danger"></i>
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
                                    <h2 class="font-light avance mb-3"><?php
                                        if($correctos == 0 and $incorrectos == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($correctos/$row_cont)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h2>
                                    <h4 class="text-muted">Avance</h4></div>
                                <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
                                            echo number_format((float)(($correctos/$row_cont)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="row mb-3">
				<div class="col-lg-12 justify-content-center d-flex">
					<form action="print_paquete_gestante.php" method="POST">
						<input hidden name="red" value="<?php echo $_POST['red']; ?>">
						<input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
						<input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
						<button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
					</form>
					<button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar m-2" onclick="location.href='paquete_gestante.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
				</div>
            </div>            
            <div class="col-12 table-responsive table_no_fed" id="bateria_completa">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                <thead>
					<tr class="text-center font-12" style="background: #c9d0e2;">
						<th class="align-middle">#</th>
						<th class="align-middle">Provincia</th>
						<th class="align-middle">Distrito</th>
						<th class="align-middle">Establecimiento</th>
						<th class="align-middle">Tipo Documento</th>
						<th class="align-middle">Documento</th>
						<th class="align-middle">Duración de Embarazo</th>
						<th class="align-middle">Financiador Parto</th>
                        <th class="align-middle">Dosaje Hemoglobina</th>
                        <th class="align-middle">Tmz Sifilis</th>
						<th class="align-middle">Tmz VIH</th>
                        <th class="align-middle">Tmz Bacteriuria</th>
                        <th class="align-middle">Perfil Obstetrico</th>
                        <th class="align-middle">1er Tri APN Presencial</th>
                        <th class="align-middle">2do Tri APN Presencial</th>
                        <th class="align-middle">3er Tri 1APN Presencial</th>
                        <th class="align-middle">3er Tri 2APN Presencial</th>
                        <th class="align-middle">1era Entrega Suplemento</th>
                        <th class="align-middle">2da Entrega Suplemento</th>
                        <th class="align-middle">3era Entrega Suplemento</th>
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
						include('query_paquete_gestante.php');
						$i=1;
						while ($consulta = sqlsrv_fetch_array($consulta4)){  
							if(is_null ($consulta['Prov_Madre']) ){
								$newdate1 = '  -'; }
								else{
							$newdate1 = $consulta['Prov_Madre'];}

							if(is_null ($consulta['Dist_Madre']) ){
								$newdate2 = '  -'; }
								else{
							$newdate2 = $consulta['Dist_Madre'];}

							if(is_null ($consulta['Nombre_EESS']) ){
								$newdate3 = '  -'; }
								else{
							$newdate3 = $consulta['Nombre_EESS'];}

							if(is_null ($consulta['Tipo_Doc_Madre']) ){
								$newdate4 = '  -'; }
								else{
							$newdate4 = $consulta['Tipo_Doc_Madre'];}

							if(is_null ($consulta['NU_DOC_MADRE']) ){
								$newdate5 = '  -'; }
								else{
							$newdate5 = $consulta['NU_DOC_MADRE'];}

                            if(is_null ($consulta['DUR_EMB_PARTO']) ){
								$newdate6 = '  -'; }
								else{
							$newdate6 = $consulta['DUR_EMB_PARTO'];}

                            if(is_null ($consulta['Financiador_Parto']) ){
								$newdate7 = '  -'; }
								else{
							$newdate7 = $consulta['Financiador_Parto'];}

                            if(is_null ($consulta['DOSAJE_HEMOGLOBINA']) ){
								$newdate8 = '  -'; }
								else{
							$newdate8 = $consulta['DOSAJE_HEMOGLOBINA'] -> format('d/m/y');}

                            if(is_null ($consulta['TAMIZAJE_SIFILIS']) ){
								$newdate9 = '  -'; }
								else{
							$newdate9 = $consulta['TAMIZAJE_SIFILIS'] -> format('d/m/y');}

                            if(is_null ($consulta['TAMIZAJE_VIH']) ){
								$newdate10 = '  -'; }
								else{
							$newdate10 = $consulta['TAMIZAJE_VIH'] -> format('d/m/y');}

                            if(is_null ($consulta['TAMIZAJE_BACTERIURIA']) ){
								$newdate11 = '  -'; }
								else{
							$newdate11 = $consulta['TAMIZAJE_BACTERIURIA'] -> format('d/m/y');}

                            if(is_null ($consulta['PERFIL_OBSTETRICO']) ){
								$newdate19 = '  -'; }
								else{
							$newdate19 = $consulta['PERFIL_OBSTETRICO'] -> format('d/m/y');}

                            if(is_null ($consulta['PRIMER_TRIMESTRE_APN_PRESENCIAL']) ){
								$newdate12 = '  -'; }
								else{
							$newdate12 = $consulta['PRIMER_TRIMESTRE_APN_PRESENCIAL'] -> format('d/m/y');}

                            if(is_null ($consulta['SEGUNDO_TRIMESTRE_APN_PRESENCIAL']) ){
								$newdate13 = '  -'; }
								else{
							$newdate13 = $consulta['SEGUNDO_TRIMESTRE_APN_PRESENCIAL'] -> format('d/m/y');}

                            if(is_null ($consulta['TERCER_TRIMESTRE_1APN_PRESENCIAL']) ){
								$newdate14 = '  -'; }
								else{
							$newdate14 = $consulta['TERCER_TRIMESTRE_1APN_PRESENCIAL'] -> format('d/m/y');}

                            if(is_null ($consulta['TERCER_TRIMESTRE_2APN_PRESENCIAL']) ){
								$newdate15 = '  -'; }
								else{
							$newdate15 = $consulta['TERCER_TRIMESTRE_2APN_PRESENCIAL'] -> format('d/m/y');}

                            if(is_null ($consulta['PRIMER_ENTREGA_SUPLEMENTO']) ){
								$newdate16 = '  -'; }
								else{
							$newdate16 = $consulta['PRIMER_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}

                            if(is_null ($consulta['SEGUNDO_ENTREGA_SUPLEMENTO']) ){
								$newdate17 = '  -'; }
								else{
							$newdate17 = $consulta['SEGUNDO_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}

                            if(is_null ($consulta['TERCERA_ENTREGA_SUPLEMENTO']) ){
								$newdate18 = '  -'; }
								else{
							$newdate18 = $consulta['TERCERA_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}
							
					?>
                    <tr class="text-center font-12" id="table_fed">
                        <td class="align-middle"><?php echo $i++; ?></td>
                        <td class="align-middle"><?php echo utf8_encode($newdate1); ?></td>
                        <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                        <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                        <td class="align-middle"><?php echo $newdate4; ?></td>
                        <td class="align-middle"><?php echo $newdate5; ?></td>                      
                        <td class="align-middle"><?php echo $newdate6; ?></td>
                        <td class="align-middle"><?php echo $newdate7; ?></td>
                        <td class="align-middle"><?php echo $newdate8; ?></td>
                        <td class="align-middle"><?php echo $newdate9; ?></td>
                        <td class="align-middle"><?php echo $newdate10; ?></td>
                        <td class="align-middle"><?php echo $newdate11; ?></td>
                        <td class="align-middle"><?php echo $newdate19; ?></td>
                        <td class="align-middle"><?php echo $newdate12; ?></td>
                        <td class="align-middle"><?php echo $newdate13; ?></td>
                        <td class="align-middle"><?php echo $newdate14; ?></td>
                        <td class="align-middle"><?php echo $newdate15; ?></td>
                        <td class="align-middle"><?php echo $newdate16; ?></td>
                        <td class="align-middle"><?php echo $newdate17; ?></td>
                        <td class="align-middle"><?php echo $newdate18; ?></td>
                        <td class="align-middle"><?php 
                            if(!is_null($consulta['DOSAJE_HEMOGLOBINA']) && !is_null($consulta['TAMIZAJE_SIFILIS']) && !is_null($consulta['TAMIZAJE_VIH']) && !is_null($consulta['TAMIZAJE_BACTERIURIA'])){
                                if(!is_null($consulta['PRIMER_TRIMESTRE_APN_PRESENCIAL']) && !is_null($consulta['SEGUNDO_TRIMESTRE_APN_PRESENCIAL']) && !is_null($consulta['TERCER_TRIMESTRE_1APN_PRESENCIAL']) && 
                                    !is_null ($consulta['TERCER_TRIMESTRE_2APN_PRESENCIAL']) && !is_null($consulta['PRIMER_ENTREGA_SUPLEMENTO']) && !is_null($consulta['SEGUNDO_ENTREGA_SUPLEMENTO']) &&
                                    !is_null ($consulta['TERCERA_ENTREGA_SUPLEMENTO'])){
                                        echo "<span class='badge bg-correct'>CUMPLE</span>";
                                }
                            }
                        ?></td>
                    </tr>
                  <?php
                      }
                      include("cerrar.php");
                  ?>
                </tbody>
                <tfoot>
					<tr>
						<td colspan="30">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

</body>
</html>