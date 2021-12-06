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


// DISTRITOS SIN TODO
var distritos_01=new Array("-","CHACAYAN","GOYLLARISQUIZGA","PAUCAR","SAN PEDRO DE PILLAO","SANTA ANA DE TUSI","TAPUC","VILCABAMBA","YANAHUANCA");
var distritos_02=new Array("-","CHONTABAMBA","CONSTITUCIÓN","HUANCABAMBA","OXAPAMPA","PALCAZU","POZUZO","PUERTO BERMUDEZ","VILLA RICA");
var distritos_03=new Array("-","CHAUPIMARCA","HUACHON","HUARIACA","HUAYLLAY","NINACACA","PALLANCHACRA","PAUCARTAMBO","SAN FRANCISCO DE ASIS DE YARUSYACAN","SIMON BOLIVAR","TICLACAYAN","TINYAHUARCO","VICCO","YANACANCHA");

var todasDistritos = [
    [],
    distritos_01,
    distritos_02,
    distritos_03,
];

function cambia_distrito(){ 
    var red 
    red = document.f0.red[document.f0.red.selectedIndex].value 
    $("#distrito").empty();
    if (red != 0) { 
        mis_distritos=todasDistritos[red]
        num_distritos = mis_distritos.length 
        document.f0.distrito.length = num_distritos 
        for(i=0;i<num_distritos;i++){ 
          document.f0.distrito.options[i].value=mis_distritos[i] 
          document.f0.distrito.options[i].text=mis_distritos[i] 
        } 
    }else{ 
        document.f0.distrito.length = 1 
        document.f0.distrito.options[0].value = "-" 
        document.f0.distrito.options[0].text = "-" 
    } 
    document.f0.distrito.options[0].selected = true 
}