<?php
    include('./base.php');
    require('abrir.php');
?>

<div class="container text-center mb-4">
    <div class="bd-example">
        <br>
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ModalSolicitud"><i class="fa fa-plus"></i> Agregar Solicitud</button>
        <div class="table-responsive">
            <table id="demo-foo-addrow2" class="table footable m-b-0" data-paging="true" data-page-size="10" data-limit-navigation="10">
                <thead>
                    <tr class="text-center font-12" style="background: #c9d0e2;">
                        <th class="align-middle">#</th>
                        <th class="align-middle">Provincia</th>
                        <th class="align-middle">Distrito</th>
                        <th class="align-middle">Establecimiento</th>
                        <th class="align-middle">DNI Usuario</th>
                        <th class="align-middle">Aplicación</th>
                        <th class="align-middle">DNI Paciente</th>
                        <th class="align-middle">Fecha Atención</th>
                        <th class="align-middle">Soporte</th>
                        <th class="align-middle">Tipo Soporte</th>
                        <th class="align-middle">Descripción</th>
                        <th class="align-middle">Acción</th>
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
                            $resultado2 = "SELECT * FROM USER_REQUEST";
                            $consulta2 = sqlsrv_query($conn, $resultado2);
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta2)){ 
                                $id = $consulta['id'];

                                if(is_null ($consulta['provincia']) ){ $newdate = ' - '; }
                                else{ $newdate = $consulta['provincia'];}

                                if(is_null ($consulta['distrito']) ){ $newdate2 = ' - '; }
                                else{ $newdate2 = $consulta['distrito'];}

                                if(is_null ($consulta['establecimiento']) ){ $newdate3 = ' - '; }
                                else{ $newdate3 = $consulta['establecimiento'];}

                                if(is_null ($consulta['dni_usuario']) ){ $newdate4 = ' - '; }
                                else{ $newdate4 = $consulta['dni_usuario'];}

                                if(is_null ($consulta['aplicativo']) ){ $newdate5 = ' - '; }
                                else{ $newdate5 = $consulta['aplicativo'];}

                                if(is_null ($consulta['dni_paciente']) ){ $newdate6 = ' - '; }
                                else{ $newdate6 = $consulta['dni_paciente'];}

                                if(is_null ($consulta['fecha_atencion']) ){ $newdate7 = ' - '; }
                                else{ $newdate7 = $consulta['fecha_atencion'];}

                                if(is_null ($consulta['soporte']) ){ $newdate8 = ' - '; }
                                else{ $newdate8 = $consulta['soporte'];}

                                if(is_null ($consulta['tipo_soporte']) ){ $newdate9 = ' - '; }
                                else{ $newdate9 = $consulta['tipo_soporte'];}

                                if(is_null ($consulta['description']) ){ $newdate10 = ' - '; }
                                else{ $newdate10 = $consulta['description'];}
                ?>
                    <tr class="text-center font-12">
                        <td class="align-middle"><?php echo $i++; ?></td>
                        <td class="align-middle"><?php echo $newdate; ?></td>
                        <td class="align-middle"><?php echo $newdate2; ?></td>
                        <td class="align-middle"><?php echo $newdate3; ?></td>
                        <td class="align-middle"><?php echo $newdate4; ?></td>
                        <td class="align-middle"><?php echo $newdate5; ?></td>
                        <td class="align-middle"><?php echo $newdate6; ?></td>
                        <td class="align-middle"><?php echo $newdate7; ?></td>
                        <td class="align-middle"><?php echo $newdate8; ?></td>
                        <td class="align-middle"><?php echo $newdate9; ?></td>
                        <td class="align-middle"><?php echo $newdate10; ?></td>
                        <td class="align-middle">
                            <a class="btn btn-sm btn-outline-danger m-2 border-rounded" href="consulta_solicitud.php?eliminar=<?php echo $id;?>"><i class="fa fa-trash"></i></a>
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
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="ModalSolicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Solicitud de registro de Migración EQhali</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="consulta_solicitud.php" method="POST" name="f1" id="form_solicitud">
                    <div class="d-flex">
                        <div class="col-md m-1">
                            <p style="font-size: 13px;" class="text-start"><b>Ingrese Red: </b></p>
                            <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                <option value="0" selected>Seleccione Red</option>
                                <option value="1">DANIEL ALCIDES CARRION</option> 
                                <option value="2">OXAPAMPA</option>
                                <option value="3">PASCO</option>
                                <option value="4">TODOS</option>
                            </select>
                        </div>
                        <div class="col-md m-1 text-mobile">
                            <p style="font-size: 13px;" class="text-start"><b>Ingrese Distrito: </b></p>
                            <select class="select_gestante form-select" name="distrito" id="distrito" aria-label="Default select example">
                                <option value="-">-</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="col-md p-2">
                            <p class="font-13 text-start"><b>Establecimiento: </b></p>
                            <input type="text" class="form-control" id="establecimiento" name="establecimiento">
                        </div>
                        <div class="col-md p-2">
                            <p class="font-13 text-start"><b>Dni Usuario: </b></p>
                            <input type="text" class="form-control" id="dni_user" name="dni_user">
                        </div>
                    </div>
                    <div class="d-flex">
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
                    <div class="d-flex">
                            <div class="col-md p-2">
                                <p class="font-13 text-start"><b>Dni Paciente: </b></p>
                                <input type="text" class="form-control" id="dni_paciente" name="dni_paciente">
                            </div>
                            <div class="col-md p-2">
                                <p class="font-13 text-start"><b>Fecha Atención: </b></p>
                                <input type="date" class="form-control" id="fecha_atencion" name="fecha_atencion">
                            </div>
                    </div>
                    <div class="d-flex p-2">
                            <p class="font-13 text-start"><b>¿Qué soporte desea?: </b></p>
                            <div class="d-flex">
                                <div class="col-md-2 col-sm-1"></div>
                                <div class="form-check col-md-8 col-sm-6">
                                    <input class="form-check-input" type="radio" value="migrar" name="mig_eli" id="mig_eli">
                                    <label class="form-check-label" for="flexRadioDefault1">Migrar</label>
                                </div>
                                <div class="form-check col-md-8 col-sm-6">
                                    <input class="form-check-input" type="radio" value="eliminar" name="mig_eli" id="mig_eli">
                                    <label class="form-check-label" for="flexRadioDefault2">Eliminar</label>
                                </div>
                            </div>
                    </div>
                    <div class="d-flex p-2">
                            <!-- <p class="font-13 text-start col-3"><b>¿Qué soporte desea?: </b></p> -->
                            <div class="form-check col-2 text-start">
                                <input class="form-check-input" type="radio" value="todos" id="select_type" name="select_type">
                                <label class="form-check-label" for="defaultCheck1"> Todos</label>
                            </div>
                            <div class="form-check col-2 text-start">
                                <input class="form-check-input" type="radio" value="parcial" id="select_type" name="select_type">
                                <label class="form-check-label" for="defaultCheck2">Parcial</label>
                            </div>
                    </div>
                    <div class="col-12">
                        <p class="font-13 text-start"><b>Ingrese detalle: </b></p>
                        <textarea class="form-control" placeholder="Ingrese detalles de su solicitud" id="description" name="description"></textarea>
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

<?php
    if(isset($_GET['eliminar'])){
        include('consulta_solicitud.php');
    }
?>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
<script>
    $("#btn_buscar").click(function(){
        // $("#form_solicitud")[0].reset();
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var establecimiento = $("#establecimiento").val();
        var dni_user = $("#dni_user").val();

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