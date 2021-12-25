<?php
    include('./base.php');
?>
<div class="page-wrapper">
    <div class="bd-example">
        <div class="row">
            <div class="col-lg-2 col-sm-2"></div>
            <div class="col-lg-8 col-sm-8"><br><br>
                <div class="card" style="border-color: #337ab7;">
                    <h5 class="card-header text-white text-center" style="background: #337ab7;">Seguimiento Tamizaje Neonatal</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-5">
                                <b>Seleccione un filtro:</b>
                            </div>
                            <div class="form-check form-check-inline col-md-3 text-start">
                                <input class="form-check-input" type="radio" name="myradio" id="myradio" value="r_district">
                                <label class="form-check-label" for="myradio">Distrito</label>
                            </div>
                            <div class="form-check form-check-inline col-md-3 text-start">
                                <input class="form-check-input" type="radio" name="myradio" id="myradio" value="r_establishment">
                                <label class="form-check-label" for="myradio">Establecimiento</label>
                            </div>
                        </div><hr>
                        <form name="f1" action="resultados_seg_neonatal.php" method="post" class="form_district mt-4" style="display: none;">
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
                            <div class="row">
                                <div class="col-md-6">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione mes a evaluar: </b></p>
                                    <select class="select_gestante form-select" name="mes" id="mes" aria-label="Default select example">
                                        <option value="1">ENERO</option>
                                        <option value="2">FEBRERO</option>
                                        <option value="3">MARZO</option>
                                        <option value="4">ABRIL</option>
                                        <option value="5">MAYO</option>
                                        <option value="6">JUNIO</option>
                                        <option value="7">JULIO</option>
                                        <option value="8">AGOSTO</option>
                                        <option value="9">SETIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-center">
                                <button type="button" name="Buscar" class="btn text-white" id="btn_buscar" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                            </div>
                        </form>
                        <form name="f2" action="resultados_seg_neonatal_sector.php" method="post" class="form_establishment mt-4" style="display: none;">
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione un Sector: </b></p>
                                    <select class="select_gestante form-select" name="sector" id="sector" onchange="change_establishment()" aria-label="Default select example">
                                        <option value="0" selected>Seleccione un Sector</option>
                                        <option value="ESSALUD">ESSALUD</option> 
                                        <option value="GOBIERNO REGIONAL">GOBIERNO REGIONAL</option>
                                        <!-- <option value="MINSA">MINSA</option> -->
                                        <option value="PRIVADO">PRIVADO</option>
                                        <option value="TODOS">TODOS</option>
                                    </select>
                                </div>
                                <div class="col-md-7">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione un Establecimiento: </b></p>
                                    <select class="select_gestante form-select" name="establecimiento" id="establecimiento">
                                        <option value="0" selected>Seleccione un Establecimiento</option>
                                    </select>
                                </div><br>
                                <div class="col-md-5">
                                    <p style="font-size: 13px;" class="text-start"><b>Seleccione mes a evaluar: </b></p>
                                    <select class="select_gestante form-select" name="mes2" id="mes2" aria-label="Default select example">
                                        <option value="1">ENERO</option>
                                        <option value="2">FEBRERO</option>
                                        <option value="3">MARZO</option>
                                        <option value="4">ABRIL</option>
                                        <option value="5">MAYO</option>
                                        <option value="6">JUNIO</option>
                                        <option value="7">JULIO</option>
                                        <option value="8">AGOSTO</option>
                                        <option value="9">SETIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
                                </div>
                            </div><br>
                            <div class="col-12 text-center">
                                <button type="button" name="Buscar" class="btn text-white" id="btn_buscar1" placeholder="Buscar" style="background: #337ab7;"><i class="mdi mdi-magnify"></i> Buscar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-2"></div>
        </div>
    </div>
</div>
<script src="./js/records_menu.js"></script>
<script src="./js/select2.js"></script>
<script src="./js/district.js"></script>
<script src="./js/sector.js"></script>
</body>
</html>