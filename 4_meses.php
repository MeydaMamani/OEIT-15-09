<?php
    include('./base.php');
?>
<div class="col-12 text-center mb-4">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-3 col-sm-2"></div>
            <div class="col-lg-6 col-sm-8 p-4"><br><br>
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white" style="background: #337ab7;">Niños de 4 meses</h5>
                    <div class="card-body">
                        <form name="f1" action="resultados_4_meses.php" method="post" class="_form_gestante">
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
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione mes de evaluación: </b></p>
                                    <select class="select_gestante form-select" name="mes" id="mes" aria-label="Default select example">
                                        <option value="1">ENERO</option>
                                        <option value="2">FEBRERO</option>
                                        <option value="3">MARZO</option>
                                        <option value="4">ABRIL</option>
                                        <option value="5">MAYO</option>
                                        <option value="6">JUNIO</option>
                                        <option value="7">JULIO</option>
                                        <option value="8">AGOSTO</option>
                                        <option value="9">SETIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-center">
                                <button type="button" name="Buscar" class="btn text-white" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
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