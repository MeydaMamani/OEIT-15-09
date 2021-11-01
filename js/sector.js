$( document ).ready(function() {
        $('input[name="myradio"]').change(function(e) {
            if($(this).val() == 'r_district'){
                $(".form_district").show();
                $(".form_establishment").hide();
            }
            if($(this).val() == 'r_establishment'){
                $(".form_establishment").show();
                $(".form_district").hide();
            }
        });
    });

    $("#sector").select2();
    $("#red").select2();
    $("#distrito").select2();
    $("#establecimiento").select2();
    $("#mes").select2();
    $("#mes2").select2();

    function change_establishment(){
        $("#establecimiento").empty();
        var sector = $("#sector").val();
        $.ajax({
            url: 'sector_establishment.php?sector='+sector,
            method: 'GET',
            success: function(data) {
                var establecimiento = data;
                var expresionRegular = /\s*---\s*/;
                var lista_id =establecimiento.split(expresionRegular);
                var id = [];
                var names = [];
                for(i=0;i<lista_id.length;i++){
                    if(i % 2 == 0){
                        id.push(lista_id[i]);
                    }else{
                        names.push(lista_id[i]);
                    }
                }
                names.push('TODOS');
                id.pop();
                id.push('TODOS');
                num_sector = id.length 
                document.f2.establecimiento.length = num_sector
                for(i=0;i<num_sector;i++){ 
                    document.f2.establecimiento.options[i].value=id[i] 
                    document.f2.establecimiento.options[i].text=names[i] 
                } 
            }
        })
    }

    $(document).ready(function(){
        $("#btn_buscar1").click(function(){
            var sector = $("#sector").val();
            var establecimiento = $("#establecimiento").val();
            var mes =$("#mes2").val();
            if (sector != 0 && establecimiento!='-' && mes!=''){
                document.getElementById("btn_buscar1").type = "submit";
            }else if(sector == 0){
                toastr.error('Seleccione un Sector', null, {"closeButton": true, "progressBar": true});
            }else if(establecimiento == '-'){
                toastr.error('Seleccione un Establecimiento', null, {"closeButton": true, "progressBar": true});
            }
        });
    });