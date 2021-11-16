<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="container border">
        <h3 class="mb-3 text-center mt-3">Promoción de la Salud</h3>
        <div class="d-flex">
            <div class="col-md-4 text-center">
                <img src="./img/bb.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="190">
                <h4 class="text-secondary">4 MESES</h4>
            </div>
            <!-- <div class="m-4">
                <button class="btn btn-outline-danger d-grid" type="button" data-bs-toggle="modal" data-bs-target="#ModalFilters"><img src="./img/baby_girl4.png" alt=""><span class="font-25">7 DÍAS</span></button>
            </div>
            <div class="m-4">
                <button class="btn btn-outline-danger d-grid" type="button" data-bs-toggle="modal" data-bs-target="#ModalFilters"><img src="./img/baby_girl4.png" alt=""><span class="font-25">4 MESES</span></button>
            </div>
            <div class="m-4">
                <button class="btn btn-outline-primary d-grid"><img src="./img/baby.png" alt=""><span class="font-25">6 MESES</span></button>
            </div> -->
        </div>
    </div>
</div>
<!-- MODAL FILTROSS-->
<div class="modal fade" id="ModalFilters" tabindex="-1" role="dialog" aria-hidden="true" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ingrese Datos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="results_promsa.php" method="POST" name="f1">
                    <div class="row mb-3">
                        <div class="col-md-6 col-sm-12">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione una Red: </b></p>
                            <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                <option value="0" selected>Seleccione Red</option>
                                <option value="1">DANIEL ALCIDES CARRION</option> 
                                <option value="2">OXAPAMPA</option>
                                <option value="3">PASCO</option>
                                <option value="4">TODOS</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 text-mobile">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione un Distrito: </b></p>
                            <select class="select_gestante form-select" name="distrito" id="distrito" onchange="cambia_establecimiento()" aria-label="Default select example">
                                <option value="-">-</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione Establecimiento: </b></p>
                            <select class="select_gestante form-select js-example-basic-single" name="establecimiento" id="establecimiento" aria-label="Default select example">
                                <option value="-">Seleccione Establecimiento</option>
                            </select>
                        </div>
                        <div class="col-md-6 text-mobile">
                            <p style="font-size: 13px;" class="text-start"><b>Seleccione mes a evaluar: </b></p>
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
                    </div>
                    <div class="modal-footer">
                        <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="./js/records_menu.js"></script>
<script src="./js/select2.js"></script>
<script src="./js/district_establishment.js"></script>
<script>
    $("#btn_buscar").click(function(){
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var establecimiento = $("#establecimiento").val();

        if (red != 0 && distrito!='-'){
            document.getElementById("btn_buscar").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });

    $(document).ready(function(){
        $('#red').select2({
            dropdownParent: $('#ModalFilters')
        });
		$('#distrito').select2({
            dropdownParent: $('#ModalFilters')
        });
        $('#establecimiento').select2({
            dropdownParent: $('#ModalFilters')
        });
        $('#mes').select2({
            dropdownParent: $('#ModalFilters')
        });
	});
</script>

</body>
</html>