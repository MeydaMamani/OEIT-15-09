<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-4 col-sm-2"></div>
            <div class="col-lg-4 col-sm-8 p-4"><br><br>
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Consulta tu vacunación</h5>
                    <div class="card-body">
                    <form name="f1" action="consulta_vacuna_covid.php" method="post" class="form_covid">
                        <p style="font-size: 13px;" class="text-start"><b>Ingrese DNI: </b></p>
                        <div class="row">
                          <div class="col-md">
                            <input class="form-control validanumericos" type="text" name="doc" id="doc" placeholder="DNI" maxlength="8">
                          </div>
                        </div><br>
                        <div class="col-12 text-center">
                          <button type="submit" name="Buscar" id="btn_buscar" class="btn text-white" style="background: #337ab7;" placeholder="Buscar"><i class="mdi mdi-magnify"></i> Buscar</button>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="./js/records_menu.js"></script>
<script src="./js/select2.js"></script>
<script>
  $("#btn_buscar").click(function(){
        var doc = $("#doc").val();
        if(doc.length == 8) {
          document.getElementById("btn_buscar").type = "submit";
        }
        else if(doc.length != 8) {
          toastr.warning('La cantidad de dígitos es incorrecto', null, { "closeButton": true, "progressBar": true });
          document.getElementById("btn_buscar").type = "button";
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