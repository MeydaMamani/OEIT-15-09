<!DOCTYPE HTML>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>OEIT - DIRESA</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta name="description" content="PAGINA DIRESA PASCO">
    <meta name="keywords" content="OEIT DIRESA-PASCO">
    <link rel="shortcut icon" href="./img/logo.jpg">

    <!-- link para iconos -->
	<!-- <link rel="stylesheet" href="https://i.icomoon.io/public/temp/bb9dd4d651/UntitledProject/style.css"> -->
    <link rel="stylesheet" href="./css/materialdesignicons.css">
    <link rel="stylesheet" href="./css/materialdesignicons.min.css">
	
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	<!-- JQUERY -->
	<script src="./js/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
	
	<!-- archivos creados -->
	<link rel="stylesheet" href="./css/estilos.css">
	<link rel="stylesheet" href="./css/style.css">
	<link rel="stylesheet" href="./css/fonts.css">
	<link rel="stylesheet" href="./css/ventana_inicio.css">
	<script src="./js/main.js"></script>
	
	<!-- link paginacion -->
	<link rel="stylesheet" href="./plugin/footable/css/footable.core.css">
	<link rel="stylesheet" href="./css/style_footable.css">
	
	<!-- link chartjs -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
	
	<!-- select2 para buscardor -->
	<link rel="stylesheet" type="text/css" href="./css/select2.css">
	<script src="./js/select2.js"></script>

	<!-- notificaciones toastr -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <!-- para cargar archivos -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700,900|Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./css/dropify.min.css">

    <link rel="stylesheet" href="./plugin/chartist-js/chartist.min.css">
    <link rel="stylesheet" href="./plugin/chartist-js/chartist-init.css">
    <link rel="stylesheet" href="./plugin/chartist-js/chartist-plugin-tooltip.min.js">
    <link rel="stylesheet" href="./plugin/chartist-js/css-chart.css">
</head>
<body>	
	<div id="main-wrapper">
        <header class="topbar">
			<div style="margin: 10px 30px;">
				<div class="row">
				<div class="col-2">
					<img src="./img/diresa1.jpg" class="img_diresa" alt="Logotipo Diresa">
				</div>
				<div class="col-10 text-end">
					<img src="./img/oeit.png" class="img_oeit" width="240" alt="Logotipo OEIT">
				</div>
				</div>
			</div>
			<nav class="navbar top-navbar navbar-expand-md p-0" style="background: #07032e;">
                <div class="navbar-collapse">
                    <ul class="navbar-nav col-12">
                        <li class="nav-item col-12">
							<a class="nav-link nav-toggler hidden-md-up waves-effect text-light col-12" href="javascript:void(0)" style="font-size: 23px;">
								<b>MENU</b><i class="mdi mdi-menu float-end"></i>
							</a>
						</li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">PERSONAL</li>
                        <li><a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-home text-white pb-1 m-r-2"></i><span class="hide-menu ml-6"> Home</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="index2.php">Inicio</a></li>
								<li><a href="index.php">Cerrar Sesion</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-account text-white pb-1"></i><span class="hide-menu ml-6"> FED</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Ni??os</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="prematuros.php">Ni??os Prematuros (CG SI-03)</a></li>
                                        <li><a href="tamizaje_neonatal.php">TMZ Neonatal (CG SI-02)</a></li>
                                        <li><a href="4_meses.php">Suplementaci??n 4 meses (CG SI-04)</a></li>
										<li><a href="6-8_meses.php">Inicio Oportuno (CG SI-05)</a></li>
                                        <li><a href="cred_x_mes.php">Cred Avance Mensual</a></li>
										<li><a href="cred.php">CRED (CG SI-06)</a></li>
										<li><a href="paquete_nino.php">Paquete Completo</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Gestantes</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="bateria_completa.php">Bateria Completa (CG SI-01)</a></li>
                                        <li><a href="gestante_tratamiento.php">Gestantes con TMZ e Inicio de Tratamiento por Violencia (CG VI-01)</a></li>
                                        <li><a href="gestante_usuarias_nuevas.php">Usuarias Nuevas con TMZ de Violencia (CG VI-02)</a></li>
										<li><a href="paquete_gestante.php">Paquete Completo</a></li>
                                    </ul>
                                </li>
								<li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Medicamentos</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="cant_prof_EPP.php">Cantidad de Profesionales EPP (2020 FED)</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
						<li> <a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-file-document text-white pb-1"></i><span class="hide-menu ml-6"> Solicitud</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="solicitud.php">Mi Solicitud</a></li>
                                <!-- <li><a href="solicitude2.php">Mi Solicitud 2</a></li> -->
                            </ul>
                        </li>
						<li> <a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-calendar-check text-white pb-1"></i><span class="hide-menu ml-6"> Seguimiento</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="detalle_paciente.php">Detalle Paciente</a></li>
								<li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Ni??os</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="seguimiento_neonatal.php">Tamizaje Neonatal</a></li>
                                    </ul>
                                </li>
								<li><a href="desparacitacion.php">Desparacitaci??n</a></li>
								<li><a href="homologation.php">Homologaci??n</a></li>
								<li><a href="arch_plane.php">Archivos Planos</a></li>
								<li><a href="promsa.php">Promsa</a></li>
                                <li><a href="r40.php">R40</a></li>
								<!-- <li><a href="#">Promsa (Visitas-Ni??os)</a></li>
								<li><a href="#">Promsa (Visitas-Gestantes)</a></li> -->
                            </ul>
                        </li>
						<li> <a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-multiplication-box text-white pb-1"></i><span class="hide-menu ml-6"> Covid-19</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="vacuna_covid.php">Consulta tu Vacunaci??n</a></li>
								<li><a href="vacuna_padron.php">Consulta Padr??n</a></li>
								<li><a href="https://drive.google.com/file/d/1qR2KiCh3DRyp1OyiJZ2xjBJMpZQxmaSi/view" target="_blank">Descargue Consentimiento</a></li>
                                <li><a href="standart_3_dose.php">Aptos para Tercera Dosis</a></li>
                                <li><a href="nominal_vaccine_advance.php">Avance de Tercera Dosis</a></li>
                                <li><a href="closing_gaps.php">Cierre de Brechas</a></li>
                                <li><a href="observed_records.php">Registros Observados</a></li>
                                <li><a href="cruce_2_3_dosis.php">Cruce 2da y 3ra dosis</a></li>
                                <li>
                                    <a class="has-arrow" href="#" aria-expanded="false">SIS-COVID</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="sis_covid.php">SIS-COVID</a></li>
                                    </ul>
                                </li>
                                <!-- <li><a href="standard_minsa_vaccines.php">Vacunas Padr??n Minsa</a></li> -->
                            </ul>
                        </li>
						<li> <a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-format-list-bulleted text-white pb-1"></i><span class="hide-menu ml-6"> Padr??n Nominal</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="padron_children.php">Padr??n Ni??os</a></li>
								<li><a href="padron_gestantes.php">Padr??n Gestantes</a></li>
                            </ul>
                        </li>
						<!-- <li> <a class="has-arrow waves-effect" aria-expanded="false" style="color: #d8e24e;"><i class="mdi mdi-school pb-1" style="color: #d8e24e;"></i><span class="hide-menu ml-6"> Educaci??n</span></a>
                            <ul aria-expanded="false" class="collapse">
								<li><a href="reincorporacion.php">Reincorporaci??n</a></li>
                            </ul>
                        </li> -->
						<li><a class="has-arrow waves-effect" aria-expanded="false"><i class="mdi mdi-chart-bar text-white pb-1"></i><span class="hide-menu ml-6">Tableros</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">Avance de Convenios de Gesti??n</a></li>
								<li><a href="#">Avance ESNI Regular</a></li>
                                <li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Ni??o Sello</a>
                                    <ul aria-expanded="false" class="collapse">
                                        <li><a href="https://app.powerbi.com/view?r=eyJrIjoiYjlhNDlmNzItYTdlYS00ZjEwLWFhNjktOGZjOTUxMDA4MmZkIiwidCI6IjE2ZWJhMGRlLTYwNDktNDczNS1iMGE3LWIwOGE3YWE4YjdhNSJ9" target="_blank">Avance Covid</a></li>
                                        <!-- <li><a href="fed_indicator_board.php">Avance Indicadores FED</a></li> -->
                                    </ul>
                                </li>
                                <!-- <li>
                                    <a class="has-arrow" href="#" aria-expanded="false">Gestante</a>
                                </li> -->
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
    </div>
