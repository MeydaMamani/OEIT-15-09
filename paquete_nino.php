<!DOCTYPE HTML>
<html lang="es">
<head> <!--mi Cabecera, icono, titulo y meta-->
    <meta charset="UTF-8">
    <title>OEIT - DIRESA</title>
    <meta name="description" content="PAGINA DIRESA PASCO">
    <meta name="keywords" content="OEIT DIRESA-PASCO">
    <link rel="shortcut icon" href="./img/logo.jpg">
    <link rel="stylesheet" type="text/css" href="./inicio.css" media="screen, handheld">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" media="(max-width: 1100px)" href="max-width-810.css" />
    <link rel="stylesheet" media="(max-width: 700px)" href="max-width-700.css" />
    <link rel="stylesheet" media="(max-width: 612px)" href="max-width-612.css" />
    <link rel="stylesheet" media="(max-width: 450px)" href="max-width-450.css" />
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

</head>
<body>
<header>
  <div class="cajageneral cajaheader">
    <div class="cajavarios">
      <div class="cajageneral3">  <!--Logo y Otros-->
        <div class="cajacolumna">
          <div class="cajacontiene1">
            <div class="cajalogo">
              <img class="logo" src="./img/diresa1.jpeg">
            </div>
            <div class="cajanombre">
              <span class="nomlogo">DIRESA-PASCO</span>
            </div>
          </div>
        </div>
        <div class="cajacolumna">
          <div class="cajacontiene2">
            <div class="cajalogo2">
              <img class="logo2" src="./img/gorepa1.png">
            </div>
          </div><!--Caja Vacia solo para colocar botones de ingreso u otros-->
        </div>
      </div>
    </div>
  </div>
</header>
<main class="menu-content">
  <nav class="content-menu">

      <label for="toggle" class="res-menu">
          <img src="img/menu.png" alt="menu">
      </label>
      <input type="checkbox" id="toggle">
      <div class="menu">
          <ul class="first-deslice">
              <li class="first-iten"><a class="first-link" href="Inicio.php">INICIO</a></li>
              
              <li class="first-iten"><a class="first-link">COVID-19</a>
                  <ul class="second-deslice">
                      <li class="second-iten"><a class="second-link" href="vacuna_covid.php">CONSULTA TU VACUNACION</a></li>
                      <li class="second-iten"><a class="second-link" href="http://200.10.69.226/consultas/inicio_padron.php">CONSULTA PADRON</a></li>
                      <li class="second-iten"><a class="second-link" href="#">DESCARGUE SU CONSENTIMIENTO</a></li>
                      <li class="second-iten"><a class="second-link" href="#">SISCOVID</a></li>
                  </ul>
              </li>
              <li class="first-iten"><a class="first-link">GESTANTE</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="bateria_completa.php">BATERIA COMPLETA</a></li>
                    
                </ul>
              </li>
              <li class="first-iten"><a class="first-link">PACIENTE</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="detalle_paciente.php">DETALLE PACIENTE</a></li>
                    <li class="second-iten"><a class="second-link" href="#"></a></li>
                </ul>
              </li>
              <li class="first-iten"><a class="first-link" href="#">NIÑO</a>
                <ul class="second-deslice">
                    <li class="second-iten"><a class="second-link" href="prematuros.php">NIÑOS PREMATUROS</a></li>
                    <li class="second-iten"><a class="second-link" href="4_meses.php">4 MESES</a></li>
                    <li class="second-iten"><a class="second-link" href="6-8_meses.php">6 - 8 MESES</a></li>
                </ul>
              </li>
          </ul>
      </div>
  </nav>
</main>
<section class="cajaslider"><!--slider*/-->
     <br>
     <br>
     <br>
     <br>
     <br>
     <br>

      <center>
      <form name="f1" action="consulta_paquete_nino.php" method="post" class="form_gestante">
        <font color="white">INGRESE RED Y DISTRITO</font>
        <br>
        <br>
          <select class="select_gestante" name="red" id=red onchange="cambia_distrito()">
            <option value="0" selected>Seleccione Red
            <option value="1">DANIEL ALCIDES CARRION 
            <option value="2">OXAPAMPA
            <option value="3">PASCO
            <option value="4">TODOS
          </select>

          <select name="distrito" id=distrito>
            <option value="-">-
          </select>
          <br>
          <br>  
          <font color="white">SELECCIONE UN MES</font>
          <br>
          <br> 
          <select name="mes" id="mes">
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
          </select>
       <br>
       <br>
        <input type="submit" name="Buscar" class="btn_buscar" value="Buscar" placeholder="Buscar">
      
      </form>
    </center>
</section>

 <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<script language="javascript">
  
  var distritos_1=new Array("-","CHACAYAN","GOYLLARISQUIZGA","PAUCAR","SAN PEDRO DE PILLAO","SANTA ANA DE TUSI","TAPUC","VILCABAMBA","YANAHUANCA","TODOS");
  var distritos_2=new Array("-","CHONTABAMBA","CONSTITUCIÓN","HUANCABAMBA","OXAPAMPA","PALCAZU","POZUZO","PUERTO BERMUDEZ","VILLA RICA","TODOS");
  var distritos_3=new Array("-","CHAUPIMARCA","HUACHON","HUARIACA","HUAYLLAY","NINACACA","PALLANCHACRA","PAUCARTAMBO","SAN FCO DE ASIS DE YARUSYACAN","SIMON BOLIVAR","TICLACAYAN","TINYAHUARCO","VICCO","YANACANCHA","TODOS");
  var distritos_4=new Array("TODOS");

  var todasDistritos = [
    [],
    distritos_1,
    distritos_2,
    distritos_3,
    distritos_4,
  ];

  function cambia_distrito(){ 
    //tomo el valor del select del pais elegido 
    var red 
    red = document.f1.red[document.f1.red.selectedIndex].value 
    //miro a ver si el pais está definido 
    if (red != 0) { 
        //si estaba definido, entonces coloco las opciones de la provincia correspondiente. 
        //selecciono el array de provincia adecuado 
        mis_distritos=todasDistritos[red]
        //calculo el numero de provincias 
        num_distritos = mis_distritos.length 
        //marco el número de provincias en el select 
        document.f1.distrito.length = num_distritos 
        //para cada provincia del array, la introduzco en el select 
        for(i=0;i<num_distritos;i++){ 
          document.f1.distrito.options[i].value=mis_distritos[i] 
          document.f1.distrito.options[i].text=mis_distritos[i] 
        } 
    }else{ 
        //si no había provincia seleccionada, elimino las provincias del select 
        document.f1.distrito.length = 1 
        //coloco un guión en la única opción que he dejado 
        document.f1.distrito.options[0].value = "-" 
        document.f1.distrito.options[0].text = "-" 
    } 
    //marco como seleccionada la opción primera de provincia 
    document.f1.distrito.options[0].selected = true 
}
</script>