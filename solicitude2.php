<?php
    include('./base.php');
    require('abrir.php');
?>

<div class="page-wrapper">
    <div class="container text-center mb-2">
        <div class="bd-example">
            <div class="row">
                <div class="col-lg-1 col-sm-2"></div>
                <div class="col-lg-10 col-sm-8"><br>
                    <div class="card" style="border-color: #337ab7;">
                        <h5 class="card-header text-white text-center" style="background: #337ab7;">Formulario Mesa de Partes</h5>
                        <div class="card-body">
                            <form name="f1" action="#" method="post" class="_form_gestante">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md">
                                                <p style="font-size: 13px;" class="text-start"><b>Seleccione Tipo de Documento: </b></p>
                                                <select class="select_gestante form-select" name="type_doc" id="type_doc">
                                                    <option value="0" selected>Seleccione Red</option>
                                                    <option value="1">DNI</option>
                                                    <option value="1">CARNET DE EXTRANJERIA</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <p style="font-size: 13px;" class="text-start"><b>Ingrese su Documento: </b></p>
                                                <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                            <div class="col-md">
                                                <p style="font-size: 13px;" class="text-start"><b>Ingrese Apellido Paterno: </b></p>
                                                <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md text-mobile">
                                                <p style="font-size: 13px;" class="text-start"><b>Ingrese Apellido Materno: </b></p>
                                                <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                            <div class="col-md text-mobile">
                                                <p style="font-size: 13px;" class="text-start"><b>Nombres: </b></p>
                                                <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                            <div class="col-md text-mobile">
                                                <p style="font-size: 13px;" class="text-start"><b>Correo: </b></p>
                                                <input type="email" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                        </div><br>
                                        <div class="row">
                                            <div class="col-md text-mobile">
                                                <p style="font-size: 13px;" class="text-start"><b>Celular: </b></p>
                                                <input type="text" class="form-control validanumericos" id="dni_user" name="dni_user" maxlength="8" placeholder="Ingrese su DNI" required>
                                            </div>
                                            <div class="col-md">
                                                <p style="font-size: 13px;" class="text-start"><b>Seleccione Tipo Documento a tramitar: </b></p>
                                                <select class="select_gestante form-select" name="type_doc" id="type_doc">
                                                    <option value="0" selected>Seleccione documento</option>
                                                    <option value="1">OFICIO</option>
                                                    <option value="1">CARTA</option>
                                                    <option value="1">SOLICITUD</option>
                                                    <option value="1">MEMORANDO</option>
                                                    <option value="1">OTROS</option>
                                                </select>
                                            </div>
                                        </div><br>
                                        <div class="col-12 text-center">
                                            <button type="button" name="Buscar" class="btn text-white" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="input-file-max-fs"><b>Cargar su documento</b></label>
                                        <input type="file" id="input-file-max-fs" class="dropify" data-max-file-size="2M" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
</div>

<script src="./js/records_menu.js"></script>
<script src="./js/select2.js"></script>
<script src="./js/dropify.min.js"></script>
<script>
    $("#btn_buscar").click(function(){
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

    $('.dropify').dropify();    
</script>

</body>
</html>