<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="container border">
        <h3 class="mb-3 text-center mt-4">Avance Convenios de Gestión</h3>
        <div class="d-flex">
            <div class="row mb-3">
                <div class="col-md-4 text-center">
                    <a href="ficha2.php" class="btn btn-outline">
                        <img src="./img/baby_boy.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="250">
                        <h4 class="text-secondary">Ficha 2 - Niños Menores de 18 meses</h4>
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button" data-bs-toggle="modal" data-bs-target="#ModalFilters4Meses">
                        <img src="./img/bb.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="165">
                        <h4 class="text-secondary">4 MESES</h4></button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button"  data-bs-toggle="modal" data-bs-target="#ModalFilters6Meses">
                        <img src="./img/bebe2.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="190">
                        <h4 class="text-secondary" > 6 MESES </h4></button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button">
                    <img src="./img/ges1.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="150" >
                    <h4 class="text-secondary" > GESTANTE </h4></button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button" data-bs-toggle="modal" data-bs-target="#ModalFiltersHabitosLimpieza">
                    <img src="./img/M.jpg" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="280">
                    <h4 class="text-secondary"> ESTILOS DE VIDA </h4></button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button" data-bs-toggle="modal" data-bs-target="#ModalFiltersHigeneManos">
                    <img src="./img/manos1.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="280">
                    <h4 class="text-secondary"> HIGENE DE MANOS </h4></button>
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-outline" type="button">
                    <img src="./img/puerpuera1.png" class="img-user mt-2 mb-4" alt="Imagen Usuario" width="260">
                    <h4 class="text-secondary" > PUERPUERAS </h4></button>
                </div>
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
<script>
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

    function cambia_distrito1(){ 
        $("#distrito1").empty(); 
        $("#establecimiento1").empty();
        var red1 
        red1 = document.f2.red1[document.f2.red1.selectedIndex].value 
        if (red1 != 0) { 
            mis_distritos=todasDistritos[red1]
            num_distritos = mis_distritos.length 
            document.f2.distrito1.length = num_distritos 

            for(i=0;i<num_distritos;i++){ 
            document.f2.distrito1.options[i].value=mis_distritos[i] 
            document.f2.distrito1.options[i].text=mis_distritos[i] 
            } 

            var distrito1 = $("#distrito1").val();
            if(distrito1 == 'TODOS'){
                $("#establecimiento1").empty();
                document.f2.establecimiento1.length = 1 
                document.f2.establecimiento1.options[0].value = "TODOS" 
                document.f2.establecimiento1.options[0].text = "TODOS" 
            }
        }
        else{ 
            document.f2.distrito1.length = 1 
            document.f2.distrito1.options[0].value = "-" 
            document.f2.distrito1.options[0].text = "-" 
        } 

        document.f2.distrito1.options[0].selected = true 
    }

    function cambia_establecimiento1(){
        $("#establecimiento1").empty();
        var red = $("#red1").val();
        var distrito = $("#distrito1").val();
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
                document.f2.establecimiento1.length = num_distritos
                for(i=0;i<num_distritos;i++){ 
                    document.f2.establecimiento1.options[i].value=listaEstablecimiento[i] 
                    document.f2.establecimiento1.options[i].text=listaEstablecimiento[i] 
                } 
            }
        })
    }

    function cambia_distrito2(){ 
        $("#distrito2").empty(); 
        $("#establecimiento2").empty();
        var red2 
        red2 = document.f3.red2[document.f3.red2.selectedIndex].value 
        if (red2 != 0) { 
            mis_distritos=todasDistritos[red2]
            num_distritos = mis_distritos.length 
            document.f3.distrito2.length = num_distritos 

            for(i=0;i<num_distritos;i++){ 
            document.f3.distrito2.options[i].value=mis_distritos[i] 
            document.f3.distrito2.options[i].text=mis_distritos[i] 
            } 

            var distrito2 = $("#distrito2").val();
            if(distrito2 == 'TODOS'){
                $("#establecimiento2").empty();
                document.f3.establecimiento2.length = 1 
                document.f3.establecimiento2.options[0].value = "TODOS" 
                document.f3.establecimiento2.options[0].text = "TODOS" 
            }
        }
        else{ 
            document.f3.distrito2.length = 1 
            document.f3.distrito2.options[0].value = "-" 
            document.f3.distrito2.options[0].text = "-" 
        } 

        document.f3.distrito2.options[0].selected = true 
    }

    function cambia_establecimiento2(){
        $("#establecimiento2").empty();
        var red = $("#red2").val();
        var distrito = $("#distrito2").val();
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
                document.f3.establecimiento2.length = num_distritos
                for(i=0;i<num_distritos;i++){ 
                    document.f3.establecimiento2.options[i].value=listaEstablecimiento[i] 
                    document.f3.establecimiento2.options[i].text=listaEstablecimiento[i] 
                } 
            }
        })
    }

    function cambia_distrito3(){ 
        $("#distrito3").empty(); 
        $("#establecimiento3").empty();
        var red3 
        red3 = document.f4.red3[document.f4.red3.selectedIndex].value 
        if (red3 != 0) { 
            mis_distritos=todasDistritos[red3]
            num_distritos = mis_distritos.length 
            document.f4.distrito3.length = num_distritos 

            for(i=0;i<num_distritos;i++){ 
            document.f4.distrito3.options[i].value=mis_distritos[i] 
            document.f4.distrito3.options[i].text=mis_distritos[i] 
            } 

            var distrito3 = $("#distrito3").val();
            if(distrito3 == 'TODOS'){
                $("#establecimiento3").empty();
                document.f4.establecimiento3.length = 1 
                document.f4.establecimiento3.options[0].value = "TODOS" 
                document.f4.establecimiento3.options[0].text = "TODOS" 
            }
        }
        else{ 
            document.f4.distrito3.length = 1 
            document.f4.distrito3.options[0].value = "-" 
            document.f4.distrito3.options[0].text = "-" 
        } 

        document.f4.distrito3.options[0].selected = true 
    }

    function cambia_establecimiento3(){
        $("#establecimiento3").empty();
        var red = $("#red3").val();
        var distrito = $("#distrito3").val();
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
                document.f4.establecimiento3.length = num_distritos
                for(i=0;i<num_distritos;i++){ 
                    document.f4.establecimiento3.options[i].value=listaEstablecimiento[i] 
                    document.f4.establecimiento3.options[i].text=listaEstablecimiento[i] 
                } 
            }
        })
    }
</script>
</body>
</html>