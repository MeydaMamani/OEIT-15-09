<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-3 col-sm-2"></div>
            <div class="col-lg-6 col-sm-8 p-4"><br>
                <div class="card" style="border-color: #198754;">
                    <h5 class="card-header text-white text-center" style="background: #198754;">Registros Observados</h5>
                    <div class="card-body">
                        <form name="f1" action="print_observed_records.php" method="POST" class="">
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
                                    <select class="select_gestante form-select" name="distrito" id="distrito">
                                        <option value="-">-</option>
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
<script src="./js/district.js"></script>

<script>
    $("#export_data").click(function(){
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        if (red != 0 && distrito!='-'){
            document.getElementById("export_data").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });
</script>
 
</body>
</html>