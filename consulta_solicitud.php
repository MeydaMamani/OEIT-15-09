<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');  

    if (isset($_POST['Buscar'])) {
        global $conex;        
        $red = $_POST['red'];
        $distrito = $_POST['distrito'];
        $establecimiento = $_POST['establecimiento'];
        $dni_user = $_POST['dni_user'];
        $password = $_POST['password'];
        $app = $_POST['app'];
        $dni_paciente = $_POST['dni_paciente'];
        $fecha_atencion = $_POST['fecha_atencion'];
        $mig_eli = $_POST['mig_eli'];
        $select_type = $_POST['select_type'];
        $description = $_POST['description'];

        if($red == 1){
            $red = 'DANIEL ALCIDES CARRION';
        }else if($red == 2){
            $red = 'OXAPAMPA';
        }else if($red == 3){
            $red = 'PASCO';
        }else if($red == 4){
            $red = 'TODOS';
        }
     
        $resultado = "INSERT INTO USER_REQUEST (provincia, distrito, establecimiento, dni_usuario, password_usuario, aplicativo, dni_paciente, fecha_atencion, soporte, 
                    tipo_soporte, description)  VALUES ('$red', '$distrito', '$establecimiento', '$dni_user', '$password', '$app', '$dni_paciente', '$fecha_atencion', 
                    '$mig_eli', '$select_type', '$description')";
       
        $consulta1 = sqlsrv_query($conn, $resultado);
     
        
    }

    if(isset($_GET['editar'])){
        $id_edit = $_GET['editar'];
        echo $id_edit;
        $consulta = "SELECT * FROM USER_REQUEST WHERE id = '$id_edit";
        $ejecutar = sqlsrv_query($conn, $consulta);
        $fila = sqlsrv_fetch_array($ejecutar);
        echo $fila;
        $red = $fila['red'];
        $distrito = $fila['distrito'];
        $establecimiento = $fila['establecimiento'];
        $dni_user = $fila['dni_user'];
        $password = $fila['password'];
        $app = $fila['app'];
        $dni_paciente = $fila['dni_paciente'];
        $fecha_atencion = $fila['fecha_atencion'];
        $mig_eli = $fila['mig_eli'];
        $select_type = $fila['select_type'];
        $description = $fila['description'];

   }    
?>
            <!-- Modal -->
            <div class="modal fade" id="modal_solicitud" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Agregar Solicitud</h5>
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
                                        <input type="text" class="form-control" id="establecimiento" name="establecimiento" value="<?php echo $establecimiento; ?>">
                                    </div>
                                    <div class="col-md p-2">
                                        <p class="font-13 text-start"><b>DNI Usuario: </b></p>
                                        <input type="text" class="form-control" id="dni_user" name="dni_user" value="<?php echo $dni_user; ?>">
                                    </div>
                                </div>
                                    <div class="d-flex">
                                        <div class="col-md p-2">
                                            <p class="font-13 text-start"><b>Password: </b></p>
                                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
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
                                            <p class="font-13 text-start"><b>DNI Paciente: </b></p>
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
                                                <input class="form-check-input" type="radio" name="mig_eli" id="mig_eli">
                                                <label class="form-check-label" for="flexRadioDefault1">Migrar</label>
                                            </div>
                                            <div class="form-check col-md-8 col-sm-6">
                                                <input class="form-check-input" type="radio" name="mig_eli" id="mig_eli">
                                                <label class="form-check-label" for="flexRadioDefault2">Eliminar</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex p-2">
                                        <p class="font-13 text-start col-3"><b>¿Qué soporte desea?: </b></p>
                                        <div class="form-check col-2 text-start">
                                            <input class="form-check-input" type="radio" value="todos" id="select_type" name="select_type">
                                            <label class="form-check-label" for="defaultCheck1"> Todos</label>
                                        </div>
                                        <div class="form-check col-2 text-start">
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
                                    </div><br><br>
                                    <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"> Registrar</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancelar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>