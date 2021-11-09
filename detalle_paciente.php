<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-4 col-sm-2"></div>
            <div class="col-lg-4 col-sm-8 p-4"><br><br>
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Detalle Paciente</h5>
                    <div class="card-body">
                      <form name="f1" action="consulta_detalle_paciente.php" method="post" class="_form_gestante" style="position: relative;">
                        <p style="font-size: 13px;" class="text-start"><b>Ingrese DNI: </b></p>
                        <div class="row">
                          <div class="col-md">
                            <input class="form-control validanumericos" type="text" name="doc" id="doc" placeholder="DNI" maxlength="8">
                          </div>
                        </div><br>
                        <div class="col-12 text-center">
                          <button type="button" name="Buscar" class="btn text-white" id="btn_buscar" style="background: #337ab7;" placeholder="Buscar"><i class="mdi mdi-magnify"></i> Buscar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
            <div class="col-4"></div>
        </div>
    </div>
</div>
<script src="./js/records_menu.js"></script>
<script>
   $(document).on('keypress',function(e) {
    if(e.which == 13) {
        var doc = $("#doc").val();
        if(doc.length == 8) {
          document.getElementById("btn_buscar").type = "submit";
        }
        else{
          toastr.warning('La cantidad de dígitos es incorrecto', null, { "closeButton": true, "progressBar": true });
        }
    }
  });

  $("#btn_buscar").click(function(){
    var doc = $("#doc").val();
    if(doc.length == 8) {
      document.getElementById("btn_buscar").type = "submit";
    }
    else{
      toastr.warning('La cantidad de dígitos es incorrecto', null, { "closeButton": true, "progressBar": true });
    }
  });
</script>
<script language="javascript">  
  onload = function(){ 
    var ele = document.querySelectorAll('.validanumericos')[0];
    ele.onkeypress = function(e) {
      if(isNaN(this.value+String.fromCharCode(e.charCode)))
        return false;
    }
    ele.onpaste = function(e){
      e.preventDefault();
    }
  }
</script>
</body>
</html>