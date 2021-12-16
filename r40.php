<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-3 col-sm-2"></div>
            <div class="col-lg-6 col-sm-8"><br>
                <div class="card" style="border-color: #198754;">
                    <h5 class="card-header text-white text-center" style="background: #198754;">R40</h5>
                    <div class="card-body">
                        <form name="f1" action="print_r40.php" method="POST" class="">
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione una Red: </b></p>
                                    <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                        <option value="0" selected>Seleccione Red</option>
                                        <option value="1">DANIEL ALCIDES CARRION</option> 
                                        <option value="2">OXAPAMPA</option>
                                        <option value="3">PASCO</option>
                                        <option value="4">TODOS</option>
                                    </select>
                                </div>
                                <div class="col-md-6 text-mobile">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione un Distrito: </b></p>
                                    <select class="select_gestante form-select" name="distrito" id="distrito" onchange="cambia_establecimiento()" aria-label="Default select example">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="text-start font-13"><b>Seleccione Establecimiento: </b></p>
                                    <select class="select_gestante form-select js-example-basic-single" name="establecimiento" id="establecimiento" aria-label="Default select example">
                                        <option value="-">Seleccione Establecimiento</option>
                                    </select>
                                </div>
                                <div class="col-md-6 text-mobile">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione Año: </b></p>
                                    <select class="select_gestante form-select" name="anio" id="anio" aria-label="Default select example">
                                        <option value="-" selected>Seleccione Año</option>
                                        <option value="2016">2016</option>
                                        <option value="2017">2017</option>
                                        <option value="2018">2018</option>
                                        <option value="2019">2019</option>
                                        <option value="2020">2020</option>
                                        <option value="2021">2021</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione mes: </b></p>
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
                                <div class="col-md-6 text-mobile">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione Profesión: </b></p>
                                    <select class="select_gestante form-select js-example-basic-single" name="profession" id="profession" aria-label="Default select example">
                                        <!-- <option value="-">Seleccione Profesión</option> -->
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-center">
                                <button type="button" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2"><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
        </div>
    </div>
</div>
<script src="./js/records_menu.js"></script>
<script src="./js/select2.js"></script>

<script>
    $("#export_data").click(function(){
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var anio = $("#anio").val();
        var establecimiento =$("#establecimiento").val();
        if (red != 0 && distrito!='-' && anio != '-'){
            document.getElementById("export_data").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }else if(establecimiento == '-'){
            toastr.error('Seleccione un Establecimiento', null, {"closeButton": true, "progressBar": true});
        }else if(anio == '-'){
            toastr.error('Seleccione un año', null, {"closeButton": true, "progressBar": true});
        }
    });
</script>
<script>
    $(document).ready(function(){
        $('#red').select2();
		$('#distrito').select2();
        $('#establecimiento').select2();
        $('#anio').select2();
        $('#mes').select2();
        $('#profession').select2();
	});
</script>
<script language="javascript">  
    var distritos_1=new Array("-","CHACAYAN","GOYLLARISQUIZGA","PAUCAR","SAN PEDRO DE PILLAO","SANTA ANA DE TUSI","TAPUC","VILCABAMBA","YANAHUANCA","TODOS");
    var distritos_2=new Array("-","CHONTABAMBA","CONSTITUCIÓN","HUANCABAMBA","OXAPAMPA","PALCAZU","POZUZO","PUERTO BERMUDEZ","VILLA RICA","TODOS");
    var distritos_3=new Array("-","CHAUPIMARCA","HUACHON","HUARIACA","HUAYLLAY","NINACACA","PALLANCHACRA","PAUCARTAMBO","SAN FRANCISCO DE ASIS DE YARUSYACAN","SIMON BOLIVAR","TICLACAYAN","TINYAHUARCO","VICCO","YANACANCHA","TODOS");
    var distritos_4=new Array("TODOS");

    var todasDistritos = [
        [],
        distritos_1,
        distritos_2,
        distritos_3,
        distritos_4,
    ];

    function cambia_distrito(){
        $("#distrito").empty(); 
        $("#establecimiento").empty();
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

            var distrito = $("#distrito").val();
            if(distrito == 'TODOS'){
                $("#establecimiento").empty();
                document.f1.establecimiento.length = 1 
                document.f1.establecimiento.options[0].value = "TODOS" 
                document.f1.establecimiento.options[0].text = "TODOS" 
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
<script>
    function cambia_establecimiento(){
        $("#establecimiento").empty();
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        $.ajax({
            url: 'establecimiento.php?red='+red+'&dist='+distrito,
            method: 'GET',
            success: function(data) {
                var establecimiento = data;
                var expresionRegular = /\s*,\s*/;
                var listaEstablecimiento = establecimiento.split(expresionRegular);
                var indice = listaEstablecimiento.length-1;
                listaEstablecimiento[indice] = 'TODOS';
                num_distritos = listaEstablecimiento.length 
                document.f1.establecimiento.length = num_distritos
                for(i=0;i<num_distritos;i++){ 
                    document.f1.establecimiento.options[i].value=listaEstablecimiento[i] 
                    document.f1.establecimiento.options[i].text=listaEstablecimiento[i] 
                } 
            }
        })
    }
</script>
<script>
    $.ajax({
        url: 'query_profession.php',
        method: 'GET',
        success: function(data) {
            var profession = data;
            var expresionRegular = /\s*---\s*/;
            var lista_id =profession.split(expresionRegular);
            var id = [];
            var names = [];
            for(i=0;i<lista_id.length;i++){
                if(i % 2 == 0){
                    id.push(lista_id[i]);
                }else{
                    names.push(lista_id[i]);
                }
            }
            
            id.pop();
            num_prof = id.length 
            document.f1.profession.length = num_prof
            for(i=0;i<num_prof;i++){ 
                document.f1.profession.options[i].value=id[i] 
                document.f1.profession.options[i].text=names[i] 
            } 
        }
    })
</script>
</body>
</html>