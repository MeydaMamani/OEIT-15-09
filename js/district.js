// PARA NOTIFICAR SI NO SELECCIONA
$(document).ready(function(){
    $('#red').select2();
    $('#distrito').select2();
    $('#mes').select2();
    $("#btn_buscar").click(function(){
        var red = $("#red").val();
        var distrito = $("#distrito").val();
        var mes =$("#mes").val();
        if (red != 0 && distrito!='-' && mes!=''){
            document.getElementById("btn_buscar").type = "submit";
        }else if(red == 0){
            toastr.error('Seleccione una Red', null, {"closeButton": true, "progressBar": true});
        }else if(distrito == '-'){
            toastr.error('Seleccione un Distrito', null, {"closeButton": true, "progressBar": true});
        }
    });
});

// PARA SELECCIONAR DISTRITOS

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
    var red 
    red = document.f1.red[document.f1.red.selectedIndex].value 
    $("#distrito").empty();
    if (red != 0) { 
        if(red == 4){
            $("#distrito").empty();
            document.f1.distrito.length = 2
            document.f1.distrito.options[0].value = "TODOS" 
            document.f1.distrito.options[0].text = "TODOS" 
        }else{
            mis_distritos=todasDistritos[red]
            num_distritos = mis_distritos.length 
            document.f1.distrito.length = num_distritos 
            for(i=0;i<num_distritos;i++){ 
              document.f1.distrito.options[i].value=mis_distritos[i] 
              document.f1.distrito.options[i].text=mis_distritos[i] 
            } 
        }
    }else{ 
        document.f1.distrito.length = 1 
        document.f1.distrito.options[0].value = "-" 
        document.f1.distrito.options[0].text = "-" 
    } 
    document.f1.distrito.options[0].selected = true 
}