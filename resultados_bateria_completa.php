<?php 
  require ('abrir.php');    
  if (isset($_POST['Buscar'])) {
    global $conex;
    include('./base.php');
    include('zone_setting.php');
    include('consulta_bateria_completa.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){  
		$row_cont++;
		if ($consulta['CAPTADA'] == $consulta['TMZ_ANEMIA'] AND $consulta['CAPTADA'] == $consulta['SIFILIS'] AND $consulta['CAPTADA'] == $consulta['VIH'] AND $consulta['CAPTADA'] == $consulta['BACTERIURIA']) {
			$correctos++;
		} 
		else{
			$incorrectos++;
		}
    }  
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
                <h3 class="mb-4">Gestantes de Bateria Completa (Indicador 1 - CG01) - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="mb-3">
                <div class="row m-2">
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
                </div>
            </div>
            <div class="row mb-3">
				<div class="col-lg-12 justify-content-center d-flex">
					<form action="impresion_bateria_completa.php" method="POST">
						<input hidden name="red" value="<?php echo $_POST['red']; ?>">
						<input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
						<input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
						<input hidden name="anio" value="<?php echo $_POST['anio']; ?>">
						<button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
					</form>
					<button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm m-2" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-line-chart"></i> Cuadro Resumen</button>
					<button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information m-2" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Informacion</button>
					<button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar m-2" onclick="location.href='bateria_completa.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
				</div>
				<div class="d-flex">
					<button class="btn btn-outline-dark btn-sm m-2 btn_fed"><i class="mdi mdi-checkbox-multiple-blank"></i> FED</button>
					<button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="mdi mdi-checkbox-blank-circle"></i> Todo</button>
				</div>	
            </div>            
            <div class="col-12 table-responsive table_no_fed" id="bateria_completa">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                <thead>
					<tr class="text-center font-12" style="background: #c9d0e2;">
						<th class="align-middle">#</th>
						<th class="align-middle">Provincia</th>
						<th class="align-middle">Distrito</th>
						<th class="align-middle">Ipress</th>
						<th class="align-middle">Tipo Documento</th>
						<th class="align-middle">Documento</th>
						<th class="align-middle">Fecha Nacimiento Paciente</th>
						<th class="align-middle">Captada</th>
						<th class="align-middle">TMZ VIF</th>
						<th class="align-middle" id="fields_bateria_head">TMZ Anemia</th>
						<th class="align-middle" id="fields_bateria_head">Sifilis</th>
						<th class="align-middle" id="fields_bateria_head">VIH</th>
						<th class="align-middle" id="fields_bateria_head">Bacteriuria</th>
						<th class="align-middle">Cumple</th>
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
						include('consulta_bateria_completa.php');
						$i=1;
						while ($consulta = sqlsrv_fetch_array($consulta2)){  
							$newdate = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');
							$newdate2 = $consulta['CAPTADA'] -> format('d/m/y');
							if(is_null ($consulta['TMZ_ANEMIA']) ){
								$newdate3 = '  -'; }
								else{
							$newdate3 = $consulta['TMZ_ANEMIA'] -> format('d/m/y');}

							if(is_null ($consulta['SIFILIS']) ){
								$newdate4 = '  -'; }
								else{
							$newdate4 = $consulta['SIFILIS'] -> format('d/m/y');}

							if(is_null ($consulta['VIH']) ){
								$newdate5 = '  -'; }
								else{
							$newdate5 = $consulta['VIH'] -> format('d/m/y');}

							if(is_null ($consulta['BACTERIURIA']) ){
								$newdate6 = '  -'; }
								else{
							$newdate6 = $consulta['BACTERIURIA'] -> format('d/m/y');}

							if(is_null ($consulta['TMZ_VIF']) ){
								$newdate7 = '  -'; }
								else{
							$newdate7 = $consulta['TMZ_VIF'] -> format('d/m/y');}

							if ($consulta['CAPTADA'] == $consulta['TMZ_ANEMIA'] AND $consulta['CAPTADA'] == $consulta['SIFILIS'] AND $consulta['CAPTADA'] == $consulta['VIH'] AND $consulta['CAPTADA'] == $consulta['BACTERIURIA']) {
								$resultado = 'CORRECTO';
							} 
							else{
								$resultado = 'INCORRECTO';
							}
					?>
                    <tr class="text-center font-12" id="table_fed">
                      <td class="align-middle"><?php echo $i++; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($consulta['PROVINCIA']); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($consulta['DISTRITO']); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($consulta['IPRESS']); ?></td>
                      <td class="align-middle"><?php echo $consulta['TIPO_DOC']; ?></td>
                      <td class="align-middle"><?php echo $consulta['DOCUMENTO']; ?></td>
                      <td class="align-middle"><?php echo $newdate; ?></td>
                      <td class="align-middle"><?php echo $newdate2; ?></td>                      
                      <td class="align-middle"><?php echo $newdate7; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo $newdate3; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo $newdate4; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo $newdate5; ?></td>
                      <td class="align-middle" id="fields_bateria_body"><?php echo $newdate6; ?></td>
                      <td class="align-middle"><?php 
                        if ($resultado == 'CORRECTO'){
                          echo "<span class='badge bg-correct'>$resultado</span>"; 
                        }else{
                          echo "<span class='badge bg-incorrect'>$resultado</span>"; 
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
						<td colspan="15">
						<div class="">
							<ul class="pagination"></ul>
						</div>
						</td>
					</tr>
                </tfoot>
              </table>
            </div>
            <!-- tabla fed -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
				<table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
					<thead>
						<tr class="font-12 text-center" style="background: #d9d9d9;">
							<th class="align-middle">#</th>
							<th class="align-middle">Provincia</th>
							<th class="align-middle">Distrito</th>
							<th class="align-middle">Ipress</th>
							<th class="align-middle">Tipo Documento</th>
							<th class="align-middle">Documento</th>
							<th class="align-middle">Fecha Nacimiento Paciente</th>
							<th class="align-middle">Captada</th>
							<th class="align-middle">TMZ VIF</th>
							<th class="align-middle" id="color_fed_head">TMZ Anemia</th>
							<th class="align-middle" id="color_fed_head">Sifilis</th>
							<th class="align-middle" id="color_fed_head">VIH</th>
							<th class="align-middle" id="color_fed_head">Bacteriuria</th>
							<th class="align-middle">Cumple</th>
						</tr>
					</thead>
					<div class="float-end pb-1 col-md-3 table_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
					<tbody>
						<?php 
							include('consulta_fed_bateria_completa.php');
							$i_fed=1; $correctos_fed=0; $incorrectos_fed=0;
							while ($consulta_fed = sqlsrv_fetch_array($consulta_fed2)){  
							
								// $resultado = 'CORRECTO';
								if($consulta_fed['TIPO_DOC'] == 'DNI'){
								$newdate = $consulta_fed['Fecha_Nacimiento_Paciente'] -> format('d/m/y');
			
								$newdate2 = $consulta_fed['CAPTADA'] -> format('d/m/y');
								if(is_null ($consulta_fed['TMZ_ANEMIA']) ){
									$newdate3 = '  -'; }
									else{
								$newdate3 = $consulta_fed['TMZ_ANEMIA'] -> format('d/m/y');}
			
								if(is_null ($consulta_fed['SIFILIS']) ){
									$newdate4 = '  -'; }
									else{
								$newdate4 = $consulta_fed['SIFILIS'] -> format('d/m/y');}
			
								if(is_null ($consulta_fed['VIH']) ){
									$newdate5 = '  -'; }
									else{
								$newdate5 = $consulta_fed['VIH'] -> format('d/m/y');}
			
								if(is_null ($consulta_fed['BACTERIURIA']) ){
									$newdate6 = '  -'; }
									else{
								$newdate6 = $consulta_fed['BACTERIURIA'] -> format('d/m/y');}
			
								if(is_null ($consulta_fed['TMZ_VIF']) ){
									$newdate7 = '  -'; }
									else{
								$newdate7 = $consulta_fed['TMZ_VIF'] -> format('d/m/y');}

								if ($consulta_fed['CAPTADA'] == $consulta_fed['TMZ_ANEMIA'] AND $consulta_fed['CAPTADA'] == $consulta_fed['SIFILIS'] AND $consulta_fed['CAPTADA'] == $consulta_fed['VIH'] AND $consulta_fed['CAPTADA'] == $consulta_fed['BACTERIURIA']) {
									$resultado = 'CORRECTO';
									$correctos_fed++;
								} 
								else{
									$resultado = 'INCORRECTO';
									$incorrectos_fed++;
								}
		
						?>
						<tr class="text-center font-12" id="table_fed">
							<td class="align-middle" id="cantidad"><?php echo $i_fed++; ?></td>
							<td class="align-middle"><?php echo utf8_encode($consulta_fed['PROVINCIA']); ?></td>
							<td class="align-middle"><?php echo utf8_encode($consulta_fed['DISTRITO']); ?></td>
							<td class="align-middle"><?php echo utf8_encode($consulta_fed['IPRESS']); ?></td>
							<td class="align-middle"><?php echo $consulta_fed['TIPO_DOC']; ?></td>
							<td class="align-middle"><?php echo $consulta_fed['DOCUMENTO']; ?></td>
							<td class="align-middle"><?php echo $newdate; ?></td>
							<td class="align-middle"><?php echo $newdate2; ?></td>                      
							<td class="align-middle"><?php echo $newdate7; ?></td>
							<td class="align-middle" id="color_fed_body"><?php echo $newdate3; ?></td>
							<td class="align-middle" id="color_fed_body"><?php echo $newdate4; ?></td>
							<td class="align-middle" id="color_fed_body"><?php echo $newdate5; ?></td>
							<td class="align-middle" id="color_fed_body"><?php echo $newdate6; ?></td>
							<td class="align-middle"><?php 
								if ($resultado == 'CORRECTO'){
								echo "<span class='badge bg-correct'>$resultado</span>"; 
								}else{
								echo "<span class='badge bg-incorrect'>$resultado</span>"; 
								}
								?>
							</td>
						</tr>
						<?php							
								}
							}              
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
									<th>Captada</th>
									<th>Bacteriuria</th>
									<th>Anemia</th>
									<th>Sifilis</th>
									<th>VIH</th>
									<th>Cumple</th>
									<th style="background: white;">Avance</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										include('consulta_resumen_bateria.php'); 
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
					<img src="./img/UNO.png" style="width: 100%;">
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<script src="./js/records_menu.js"></script>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
<script>
   $(function(){
		$(".btn_fed").click(function(){
			$(".total").text(<?php echo $i_fed-1; ?>);
			$(".correcto").text(<?php echo $correctos_fed; ?>);
			$(".incorrecto").text(<?php echo $incorrectos_fed; ?>);
			$(".avance").text(<?php if($correctos_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
				else{ $porcentaje = number_format((float)(($correctos_fed/($i_fed-1))*100), 2, '.', '');
						echo "'$porcentaje %'"; }?>);
				$("#chart").removeClass("css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
														echo number_format((float)(($correctos/$row_cont)*100), 0, '.', ''); }
													?>");
				$("#chart").addClass("css-bar-<?php if($correctos_fed==0 && $incorrectos_fed == 0){ echo "0"; }
							else{ $porcentaje = number_format((float)(($correctos_fed/($i_fed-1))*100), 0, '.', '');
									echo "$porcentaje"; }?>");
			$(".table_fed").show();
			$(".table_no_fed").hide();
		});
		$(".btn_all").click(function(){
			$(".total").text(<?php echo $row_cont; ?>);
			$(".correcto").text(<?php echo $correctos; ?>);
			$(".incorrecto").text(<?php echo $incorrectos; ?>);
			$(".avance").text(<?php if($correctos == 0 and $row_cont == 0){ echo "'0 %'"; }
				else{ $porcentaje = number_format((float)(($correctos/$row_cont)*100), 2, '.', '');
						echo "'$porcentaje %'"; }?>);
				$("#chart").removeClass("css-bar-<?php if($correctos_fed==0 && $incorrectos_fed == 0){ echo "0"; }
							else{ $porcentaje = number_format((float)(($correctos_fed/($i_fed-1))*100), 0, '.', '');
									echo "$porcentaje"; }?>");
						$("#chart").addClass("css-bar-<?php if($correctos == 0 and $incorrectos == 0){ echo '0'; }else{
														echo number_format((float)(($correctos/$row_cont)*100), 0, '.', ''); }
													?>");
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