<?php
    include('./base.php');
?>

<div class="container text-center mb-4">
    <div class="bd-example">
        <div class="d-flex">
            <div class="col-lg-5 col-sm-12 p-2"><br>
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white" style="background: #337ab7;">SOLICITUD DE REGISTRO</h5>
                    <div class="card-body p-4">
                        <form action="consulta_solicitud.php" method="POST" name="f1">
                            <div class="row">
                                <div class="col-md">
                                    <p style="font-size: 13px;" class="text-start"><b>Ingrese Red: </b></p>
                                    <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                        <option value="0" selected>Seleccione Red</option>
                                        <option value="1">DANIEL ALCIDES CARRION</option> 
                                        <option value="2">OXAPAMPA</option>
                                        <option value="3">PASCO</option>
                                        <option value="4">TODOS</option>
                                    </select>
                                </div>
                                <div class="col-md text-mobile">
                                    <p style="font-size: 13px;" class="text-start"><b>Ingrese Distrito: </b></p>
                                    <select class="select_gestante form-select" name="distrito" id="distrito" aria-label="Default select example">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md p-2">
                                    <p class="font-13 text-start"><b>Establecimiento: </b></p>
                                    <input type="text" class="form-control" id="establecimiento" name="establecimiento">
                                </div>
                                <div class="col-md p-2">
                                    <p class="font-13 text-start"><b>DNI Usuario: </b></p>
                                    <input type="text" class="form-control" id="dni_user" name="dni_user">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md p-2">
                                    <p class="font-13 text-start"><b>Password: </b></p>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="col-md p-2">
                                    <p class="font-13 text-start" ><b>Ingrese Aplicativo:  </b></p>
                                    <select class="select_gestante form-select" name="app" id="app">
                                        <option value="-"  selected>Seleccione Aplicativo</option>
                                        <option value="CRED">CRED</option> 
                                        <option value="INMUNIZACIONES">INMUNIZACIONES</option>
                                        <option value="WAWARED">WAWARED</option>
                                        <option value="C-EXT">C-EXT</option>
                                        <option value="REFCON">REFCON</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md p-2">
                                    <p class="font-13 text-start"><b>DNI Paciente: </b></p>
                                    <input type="text" class="form-control" id="dni_paciente" name="dni_paciente">
                                </div>
                                <div class="col-md p-2">
                                    <p class="font-13 text-start"><b>Fecha Atención: </b></p>
                                    <input type="date" class="form-control" id="fecha_atencion" name="fecha_atencion">
                                </div>
                            </div>
                            <div class="row p-2">
                                <p class="font-13 text-start"><b>¿Qué soporte desea?: </b></p>
                                <div class="d-flex">
                                    <div class="col-md-2 col-sm-1"></div>
                                    <div class="form-check col-md-4 col-sm-6">
                                        <input class="form-check-input" type="radio" name="mig_eli" id="mig_eli">
                                        <label class="form-check-label" for="flexRadioDefault1">Migrar</label>
                                    </div>
                                    <div class="form-check col-md-4 col-sm-6">
                                        <input class="form-check-input" type="radio" name="mig_eli" id="mig_eli">
                                        <label class="form-check-label" for="flexRadioDefault2">Eliminar</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row p-2">
                                <p class="font-13 text-start"><b>¿Qué soporte desea?: </b></p>
                                <div class="col-1"></div>
                                <div class="form-check col-3 text-start">
                                    <input class="form-check-input" type="radio" value="todos" id="select_type" name="select_type">
                                    <label class="form-check-label" for="defaultCheck1"> Todos</label>
                                </div>
                                <div class="form-check col-3 text-start">
                                    <input class="form-check-input" type="radio" value="parcial" id="select_type" name="select_type">
                                    <label class="form-check-label" for="defaultCheck2">Parcial</label>
                                </div>
                                <div class="form-check col-5 text-start">
                                    <input class="form-check-input" type="radio" value="indicar_c" id="select_type" name="select_type">
                                    <label class="form-check-label" for="defaultCheck2">Indicar Cuales</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <p class="font-13 text-start"><b>Ingrese detalle: </b></p>
                                <textarea class="form-control" placeholder="Ingrese detalles de su solicitud" id="description" name="description"></textarea>
                            </div><br>
                            <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"> Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<script>
    $("#btn_buscar").click(function(){
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var mes =$("#mes").val();
        if (red != 0 && distrito!='-' && mes!=''){
            document.getElementById("btn_buscar").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });
</script>
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
</body>
</html>