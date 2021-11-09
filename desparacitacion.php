<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-3 col-sm-2"></div> <!--#169d98-->
            <div class="col-lg-6 col-sm-8 p-4"><br><br> <!--style="background-image: linear-gradient(-109deg, #d1c89b 0%, #169d98 81%);" -->
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Desparacitación</h5>
                    <div class="card-body">
                        <form name="f1" action="resultados_desparacitacion.php" method="post" class="_form_gestante">
                            <div class="row">
                                <div class="col-md">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione una Red: </b></p>
                                    <select class="select_gestante form-select" name="red" id="red" onchange="cambia_distrito()" aria-label="Default select example">
                                        <option value="0" selected>Seleccione Red</option>
                                        <option value="1">DANIEL ALCIDES CARRION</option> 
                                        <option value="2">OXAPAMPA</option>
                                        <option value="3">PASCO</option>
                                        <option value="4">TODOS</option>
                                    </select>
                                </div>
                                <div class="col-md text-mobile">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione un Distrito: </b></p>
                                    <select class="select_gestante form-select" name="distrito" id="distrito" aria-label="Default select example">
                                        <option value="-">-</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-center">
                                <button name="Buscar" class="btn text-white" type="button" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
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
</body>
</html>