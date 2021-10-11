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
	<link rel="stylesheet" href="https://i.icomoon.io/public/temp/bb9dd4d651/UntitledProject/style.css">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
	
	<!-- bootstrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>

	<!-- JQUERY -->
	<script src="./js/jquery-3.6.0.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>	
	
	<!-- archivos creados -->
	<link rel="stylesheet" href="./css/estilos.css">
	<link rel="stylesheet" href="./css/fonts.css">
	<link rel="stylesheet" href="./css/ventana_inicio.css">
	<script src="./js/main.js"></script>
	
	<!-- link paginacion -->
	<link rel="stylesheet" href="./plugin/footable/css/footable.core.css">
	<link rel="stylesheet" href="./css/style_footable.css">
	
	<!-- link chartjs -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
	

	<!-- notificaciones toastr -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body>
	<header>
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
		<div class="menu_bar">
			<a href="#" class="bt-menu"><span class="icon-menu"></span>Menu</a>
		</div>
		<nav>
			<ul>
				<li><a href="inicio.php"><span class="icon-home"></span>Inicio</a></li>
				<li class="submenu">
					<a href="#"><span class="icon-reddit"></span>Niño<span class="caret icon-arrow-down6"></span></a>
					<ul class="children">
						<li><a href="prematuros.php">Niños Prematuros (CG SI-03)<span class="icon-dot"></span></a></li>
						<li><a href="tamizaje_neonatal.php">TMZ Neonatal (CG SI-02)<span class="icon-dot"></span></a></li>
						<li><a href="4_meses.php">4 Meses (CG SI-04)<span class="icon-dot"></span></a></li>
						<li><a href="6-8_meses.php">6 - 8 Meses (CG SI-05)<span class="icon-dot"></span></a></li>
						<li><a href="cred.php">CRED (SI-CG06)<span class="icon-dot"></span></a></li>
						<li><a href="paquete_nino.php">Paquete<span class="icon-dot"></span></a></li>
					</ul>
				</li>
				<li class="submenu">
					<a href="#"><i class="fa fa-female"></i> Gestante<span class="caret icon-arrow-down6"></span></a>
					<ul class="children">
						<li><a href="bateria_completa.php">Bateria Completa (CG SI-01)<span class="icon-dot"></span></a></li>
						<li><a href="gestante_tratamiento.php">Gestante con TMZ e Inicio de Tratamiento por Violencia (CG VI-01)<span class="icon-dot"></span></a></li>
						<li><a href="gestante_usuarias_nuevas.php">Gestante Usuarias Nuevas con TMZ de Violencia (CG VI-02)<span class="icon-dot"></span></a></li>
					</ul>
				</li>
				<li class="submenu">
					<a href="#"><span class="icon-svg"></span>Covid-19<span class="caret icon-arrow-down6"></span></a>
					<ul class="children">
						<li><a href="vacuna_covid.php">Consulta tu Vacunación<span class="icon-dot"></span></a></li>
						<li><a href="#">Consulta Padrón <span class="icon-dot"></span></a></li>
						<li><a href="https://drive.google.com/file/d/1qR2KiCh3DRyp1OyiJZ2xjBJMpZQxmaSi/view" target="_blank">Descargue su Consentimiento <span class="icon-dot"></span></a></li>
						<li><a href="sis_covid.php">Sis-Covid<span class="icon-dot"></span></a></li>
					</ul>
				</li>
				<li class="submenu">
					<a href="#"><span class="icon-user"></span>Paciente<span class="caret icon-arrow-down6"></span></a>
					<ul class="children">
						<li><a href="detalle_paciente.php">Detalle Paciente<span class="icon-dot"></span></a></li>
					</ul>
				</li>
				<li class="submenu">
					<a href="acerca.php"><i class="fa fa-cog"></i> Acerca de<span class="caret icon-arrow-down6"></span></a>
				</li>	
			</ul>
		</nav>
	</header>