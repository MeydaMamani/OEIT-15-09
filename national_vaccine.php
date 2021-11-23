<?php
    include('./base.php');
    include('query_national_vaccine.php');
?>
<div class="page-wrapper">
    <div class="container">
        <div class="text-center p-3">
            <h3>Vacuna Nacional</h3>
        </div>
        <div class="row mb-4">
            <div class="col-md-3"></div>
            <div class="col-md-5">
                <div class="input-group mb-3">
                    <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                    <input id="demo-input-search2" type="text" placeholder="Realice su búsqueda por nombre paciente..." autocomplete="off" class="form-control busqueda" name="busqueda">
                </div>
            </div>
            <div class="col-md-2">
                <button name="Buscar" class="btn text-white" id="btn_buscar" style="background: #337ab7;"> Buscar</button>
                <button class="btn btn-outline-secondary" id="btn_cleaning"><i class="mdi mdi-broom"></i></button>
            </div>
        </div>
        <div id="cuatro_meses" class="text-center">
        </div>
    </div>
</div>

<script src="./js/records_menu.js"></script>
<script>
    function obtener_registro(datos){
        $.ajax({
            url: "query_national_vaccine.php",
            type: 'POST',
            data: { datos: datos },
        })
        .done(function(resultado){
            $("#cuatro_meses").html(resultado);
            var addrow2 = $('#demo-foo-addrow');
                addrow2.footable().on('click', '.delete-row-btn', function() {
                var footable = addrow.data('footable');
                var row = $(this).parents('tr:first');
                footable.removeRow(row);
            });
        })
    }
    
    $("#btn_buscar").click(function(){
        $("#cuatro_meses").html('<div class="lds-roller mt-5"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>');
        var valor = $(".busqueda").val();
        obtener_registro(valor);
    });

    $("#btn_cleaning").click(function(){
        $(".busqueda").val("");
        $("#cuatro_meses").html("");
    });
    
</script>    
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>