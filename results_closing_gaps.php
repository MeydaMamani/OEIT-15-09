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
                <h3 class="mb-4">Cierre de Brechas</h3>
            </div>
            <div class="mb-3">
				<div class="row m-2">
                    <div class="card col-md-2 datos_avance">
						<div class="card-body p-1">
							<p class="card-title text-secondary text-center font-18 pt-2">Total Primera Dosis</p>
							<div class="justify-content-center">
								<div class="align-self-center">
									<h4 class="font-medium mb-3 justify-content-center d-flex">
										<div class="mt-3 col-md-12 text-center">
											<b class="total font-49 text-secondary"><?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
										</div>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-md-2 datos_avance">
						<div class="card-body p-1">
							<p class="card-title text-secondary text-center font-18 pt-2">Dosis Completa</p>
							<div class="justify-content-center">
								<div class="align-self-center">
									<h4 class="font-medium mb-3 justify-content-center d-flex">
										<div class="mt-3 col-md-12 text-center">
											<b class="total font-49 text-secondary"><?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
										</div>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-md-2 datos_avance">
						<div class="card-body p-0">
							<p class="card-title text-secondary text-center font-18 pt-3">Segunda Fuera Región</h4>
							<div class="justify-content-center">
								<div class="align-self-center">
									<h4 class="font-medium mb-3 justify-content-center d-flex">
										<div class="mt-3 ms-2 col-md-12 text-center">
											<b class="font-34 text-success cumple"><?php echo $cumple; ?></b> <i class="mdi mdi-check font-34 text-success" style="margin-left: -6px;"></i>
										</div>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-md-2 datos_avance">
						<div class="card-body p-0">
						    <p class="card-title text-secondary text-center font-18 pt-3">Fallecidos</h4>
							<div class="justify-content-center">
								<div class="align-self-center">
									<h4 class="font-medium mb-3 justify-content-center d-flex">
										<div class="mt-3 ms-2 col-md-12 text-center">
											<b class="font-34 text-danger no_cumple"><?php echo $no_cumple; ?></b><i class="mdi mdi-close font-34 text-danger" style="margin-left: -6px;"></i>
										</div>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-md-2 datos_avance">
						<div class="card-body p-0">
						    <p class="card-title text-secondary text-center font-18 pt-3">Rechazo</h4>
							<div class="justify-content-center">
								<div class="align-self-center">
									<h4 class="font-medium mb-3 justify-content-center d-flex">
										<div class="mt-3 ms-2 col-md-12 text-center">
											<b class="font-34 text-warning observado"><?php echo $observado; ?></b> <i class="mdi mdi-alert-circle font-34 text-warning" style="margin-left: -6px;"></i>
										</div>
									</h4>
								</div>
							</div>
						</div>
					</div>
					<div class="card col-md-2 datos_avance">
						<div class="card-body p-1">
							<div class="row pt-4">
								<div class="col-md-12 p-0 text-center">
									<h1 class="font-light avance mb-3 text-primary"><?php
											if($cumple == 0 and $row_cont == 0){ echo '0 %'; }
											else{ echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%'; }
										?>
									</h1>
									<h4 class="text-muted">Avance</h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <div class="d-flex">
                <div class="col-md-7 d-flex">
                    <form action="impresion_4_meses.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="submit" name="Limpiar" class="btn btn-outline-danger m-2 btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Informacion</button>
                    <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='closing_gaps.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div><br>
            <div class="col-12 table-responsive table_no_fed" id="cuatro_meses">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">N° Documento</th>
                            <th class="align-middle">Paciente</th>
                            <th class="align-middle">Edad</th>
                            <th class="align-middle">Nombre Vacuna</th>
                            <th class="align-middle">Grupo Edad</th>
                            <th class="align-middle">Primera Dosis</th>
                            <th class="align-middle">Segunda Dosis</th>
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

                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate5); ?></td>
                            <td class="align-middle"><?php echo $newdate6; ?></td>
                            <td class="align-middle"><?php echo $newdate7; ?></td>
                            <td class="align-middle"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php echo $newdate12; ?></td>
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