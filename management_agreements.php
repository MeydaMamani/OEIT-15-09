<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="container border">
        <h3 class="mb-3 text-center mt-4">Avance Convenios de Gestión</h3><br>
        <div class="one">
            <img src="./img/ejem.png" class="" alt="" style="width: 100%;">
        </div>
        <div class="one_img">
            <a href="ficha2.php" class="button">
                <h1>AAAAAA</h1>
            </a>
        </div>
        <!-- <div class="d-flex">
            <div class="row mb-3">
                <div class="col-md-4 text-center">
                    <a href="ficha2.php" class="btn btn-outline">
                        <img src="./img/baby_boy.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="250">
                        <h4 class="text-secondary">Ficha 2 - Niños Menores de 18 meses</h4>
                    </a>
                </div>
            </div>
        </div> -->
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
        $('#red').select2({ dropdownParent: $('#ModalFilters4Meses') });
		$('#distrito').select2({ dropdownParent: $('#ModalFilters4Meses') });
        $('#establecimiento').select2({ dropdownParent: $('#ModalFilters4Meses') });
        $('#mes').select2({ dropdownParent: $('#ModalFilters4Meses') });

        $('#red1').select2({ dropdownParent: $('#ModalFilters6Meses') });
		$('#distrito1').select2({ dropdownParent: $('#ModalFilters6Meses') });
        $('#establecimiento1').select2({ dropdownParent: $('#ModalFilters6Meses') });
        $('#mes1').select2({ dropdownParent: $('#ModalFilters6Meses') });

        $('#red2').select2({ dropdownParent: $('#ModalFiltersHabitosLimpieza') });
		$('#distrito2').select2({ dropdownParent: $('#ModalFiltersHabitosLimpieza') });
        $('#establecimiento2').select2({ dropdownParent: $('#ModalFiltersHabitosLimpieza') });
        $('#mes2').select2({ dropdownParent: $('#ModalFiltersHabitosLimpieza') });

        $('#red3').select2({ dropdownParent: $('#ModalFiltersHigeneManos') });
		$('#distrito3').select2({ dropdownParent: $('#ModalFiltersHigeneManos') });
        $('#establecimiento3').select2({ dropdownParent: $('#ModalFiltersHigeneManos') });
        $('#mes3').select2({ dropdownParent: $('#ModalFiltersHigeneManos') });
	});

    $("#btn_buscar1").click(function(){
        console.log('ME DISTE CLICK');
        var red1 = $("#red1").val();
        var distrito1 = $("#distrito1").val();
        var establecimiento1 = $("#establecimiento1").val();

        if (red1 != 0 && distrito1 !='-'){
            document.getElementById("btn_buscar1").type = "submit";
        }else if(red1 == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito1 == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });

    $("#btn_buscar2").click(function(){
        var red2 = $("#red2").val();
        var distrito2 = $("#distrito2").val();
        var establecimiento2 = $("#establecimiento2").val();

        if (red2 != 0 && distrito2 !='-'){
            document.getElementById("btn_buscar2").type = "submit";
        }else if(red2 == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito2 == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });

    $("#btn_buscar3").click(function(){
        var red3 = $("#red3").val();
        var distrito3 = $("#distrito3").val();
        var establecimiento3 = $("#establecimiento3").val();

        if (red3 != 0 && distrito3 !='-'){
            document.getElementById("btn_buscar3").type = "submit";
        }else if(red3 == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito3 == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });
</script>
</body>
</html>