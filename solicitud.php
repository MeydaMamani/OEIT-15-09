<?php
    include('./base.php');
    require('abrir.php');
?>

<div class="container text-center mb-4">
    <div class="bd-example">
        <br>
        <button type="button" class="btn btn-outline-primary mb-4" data-bs-toggle="modal" data-bs-target="#ModalSolicitud"><i class="fa fa-plus"></i> Agregar Solicitud</button>
        <div class="table-responsive">
            <table id="demo-foo-addrow2" class="table footable m-b-0" data-paging="true" data-page-size="10" data-limit-navigation="10">
                <thead>
                    <tr class="text-center font-12" style="background: #c9d0e2;">
                        <th class="align-middle">#</th>
                        <th class="align-middle">Provincia</th>
                        <th class="align-middle">Distrito</th>
                        <th class="align-middle">TOTAL</th>
                    </tr>
                </thead>
                <div>
                    <div class="float-end pb-3 table_no_fed">
                        <div class="form-group">
                        <div id="inputbus" class="input-group input-group-sm">
                            <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                            <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                        </div>
                        </div>
                    </div>
                </div>
                <tbody>
                <?php 
                    $resultado2 = "SELECT Provincia, distrito, COUNT(distrito) as total FROM USER_REQUEST
                    GROUP BY Provincia, distrito";
                    $consulta2 = sqlsrv_query($conn, $resultado2);
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){ 
                        $newdate = $consulta['Provincia'];
                        $newdate2 = $consulta['distrito'];
                        $newdate3 = $consulta['total'];

                ?>
                    <tr class="text-center font-12">
                        <td class="align-middle"><?php echo $i++; ?></td>
                        <td class="align-middle"><?php echo $newdate; ?></td>
                        <td class="align-middle"><?php echo $newdate2; ?></td>
                        <td class="align-middle"><?php echo $newdate3; ?></td>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalSolicitud" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Solicitud de Registro de Migración EQhali</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="consulta_solicitud.php" method="POST" name="f1" id="form_solicitud">
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12 solicitud">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione una Red: </b></p>
                            <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                <option value="0" selected>Seleccione Red</option>
                                <option value="1">DANIEL ALCIDES CARRION</option> 
                                <option value="2">OXAPAMPA</option>
                                <option value="3">PASCO</option>
                                <option value="4">TODOS</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 solicitud text-mobile">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione un Distrito: </b></p>
                            <select class="select_gestante form-select" name="distrito" id="distrito" onchange="cambia_establecimiento()" aria-label="Default select example">
                                <option value="-">-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6 solicitud">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione Establecimiento: </b></p>
                            <select class="select_gestante form-select js-example-basic-single" name="establecimiento" id="establecimiento" aria-label="Default select example">
                                <option value="-">Seleccione Establecimiento</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-mobile">
                            <p class="font-13 text-start"><b>Dni Usuario: </b></p>
                            <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md">
                            <p class="font-13 text-start"><b>Password: </b></p>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="col-md text-mobile">
                            <p class="font-13 text-start" ><b>Ingrese Aplicativo:  </b></p>
                            <select class="select_gestante form-select" name="app" id="app" required>
                                <option value="-"  selected>Seleccione Aplicativo</option>
                                <option value="CRED">CRED</option> 
                                <option value="INMUNIZACIONES">INMUNIZACIONES</option>
                                <option value="WAWARED">WAWARED</option>
                                <option value="C-EXT">C-EXT</option>
                                <option value="REFCON">REFCON</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md">
                            <p class="font-13 text-start"><b>Dni Paciente: </b></p>
                            <input type="text" class="form-control validanumericos2" id="dni_paciente" name="dni_paciente" maxlength="8" required>
                        </div>
                        <div class="col-md text-mobile">
                            <p class="font-13 text-start"><b>Fecha Atención: </b></p>
                            <input type="date" class="form-control" id="fecha_atencion" name="fecha_atencion">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <p class="font-13 text-start"><b>¿Qué soporte desea?: </b></p>
                        <div class="row m-1">
                            <div class="col-md-2 col-sm-1"></div>
                            <div class="form-check col-md-3 col-sm-6">
                                <input class="form-check-input" type="radio" value="migrar" name="mig_eli" id="mig_eli">
                                <label class="form-check-label" for="flexRadioDefault1">Migrar</label>
                            </div>
                            <div class="form-check col-md-3 col-sm-6">
                                <input class="form-check-input" type="radio" value="eliminar" name="mig_eli" id="mig_eli">
                                <label class="form-check-label" for="flexRadioDefault2">Eliminar</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 m-1">
                        <div class="col-md-2 col-sm-1"></div>
                        <div class="form-check col-md-3 col-sm-6">
                            <input class="form-check-input" type="radio" value="todos" id="select_type" name="select_type">
                            <label class="form-check-label" for="defaultCheck1"> Todos</label>
                        </div>
                        <div class="form-check col-md-3 col-sm-6">
                            <input class="form-check-input" type="radio" value="parcial" id="select_type" name="select_type">
                            <label class="form-check-label" for="defaultCheck2">Parcial</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <p class="font-13 text-start"><b>Ingrese detalle: </b></p>
                        <textarea class="form-control" placeholder="Ingrese detalles de su solicitud" id="description" name="description" required></textarea>
                    </div><br>
                    <div class="modal-footer">
                        <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"> Registrar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script>
    $("#btn_buscar").click(function(){
        // $("#form_solicitud")[0].reset();
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var establecimiento = $("#establecimiento").val();
        var app = $("#app").val();
        var dni_user = $("#dni_user").val();
        var dni_paciente = $("#dni_paciente").val();

        if (red != 0 && distrito!='-' && app!='-' && dni_user.length == 8 && dni_paciente.length == 8){
            document.getElementById("btn_buscar").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }else if(app == '-'){
            toastr.error('Seleccione una aplicación', null, {"closeButton": true, "progressBar": true});
        }else if(dni_user.length != 8 || dni_paciente.length != 8){
            toastr.error('Ingrese DNI correcto', null, {"closeButton": true, "progressBar": true});
        }
    });

    $(document).ready(function(){
        $('#red').select2({
            dropdownParent: $('#ModalSolicitud')
        });
		$('#distrito').select2({
            dropdownParent: $('#ModalSolicitud')
        });
        $('#establecimiento').select2({
            dropdownParent: $('#ModalSolicitud')
        });
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
<script language="javascript">  
  onload = function(){ 
    var ele = document.querySelectorAll('.validanumericos')[0];
    ele.onkeypress = function(e) {
      if(isNaN(this.value+String.fromCharCode(e.charCode)))
        return false;
    }
    ele.onpaste = function(e){
      e.preventDefault();
    }

    var ele2 = document.querySelectorAll('.validanumericos2')[0];
    ele2.onkeypress = function(e) {
      if(isNaN(this.value+String.fromCharCode(e.charCode)))
        return false;
    }
    ele2.onpaste = function(e){
      e.preventDefault();
    }
  }
</script>
</body>
</html>