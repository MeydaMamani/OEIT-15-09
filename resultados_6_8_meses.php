<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");
    include('./base.php');
    include('zone_setting.php');
    include('consulta_6_8_meses.php');
    $row_cont=0; $cumple=0; $no_cumple=0;
    while ($consulta = sqlsrv_fetch_array($consulta4)){
        $row_cont++;
        if(!is_null ($consulta['HEMOGLOBINA']) && !is_null ($consulta['D50X']) && !is_null ($consulta['U310_SF1']) && is_null ($consulta['SUPLE'])){
            if($consulta['HEMOGLOBINA'] == $consulta['D50X'] && $consulta['HEMOGLOBINA'] == $consulta['U310_SF1']){
                $cumple++;
            }else{
                $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                $nuevo_formato_anemia = date_format($consulta['D50X'], "d-m-Y");
                $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                $fecha_anemia = strtotime(date_format($consulta['D50X'], "d-m-Y"));
                $fecha_tratamiento = strtotime(date_format($consulta['U310_SF1'], "d-m-Y"));
                $fecha_anemia_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_anemia."+ 7 days")));

                if($fecha_anemia < $fecha_hemoglobina_7_dias && $fecha_anemia > $nuevo_formato_hemoglobina) {
                    $cumple++;
                }
                else{
                    $no_cumple++;
                }
            }
        }
        else if(!is_null ($consulta['HEMOGLOBINA']) && is_null ($consulta['D50X']) && is_null ($consulta['U310_SF1']) && !is_null ($consulta['SUPLE'])){
            if($consulta['HEMOGLOBINA'] == $consulta['SUPLE']){
                $cumple++;
            }
            else{
                $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                $fecha_suplementacion = strtotime(date_format($consulta['SUPLE'], "d-m-Y"));
                if($fecha_suplementacion < $fecha_hemoglobina_7_dias && $fecha_suplementacion > $nuevo_formato_hemoglobina) {
                    $cumple++;
                }
            }
        }
        else{
            $no_cumple++;
        }
    }
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <marquee width="100%" direction="left" height="18px">
                        <p class="font-14 text-primary"><b>Fuente: </b> BD Padr??n Nominal con Fecha <?php echo $date_modify; ?> y BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</p>
                    </marquee>
                </div>
            </div>
            <div class="text-center mb-3">
                <h3 class="mb-4">Ni??os de 6 a 8 Meses CG05 - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="mb-3">
                <div class="row m-2">
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cantidad Registros</p>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/user_cant.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 total"> <?php echo $row_cont; ?></b> <i class="mdi mdi-plus font-49 text-secondary"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <p class="card-title text-secondary text-center font-18 pt-2">Cumplen</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 cumple"> <?php echo $cumple; ?></b> <i class="mdi mdi-check font-49 text-success"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-0">
                        <p class="card-title text-secondary text-center font-18 pt-3">No Cumplen</h4>
                            <div class="justify-content-center">
                                <div class="align-self-center">
                                    <h4 class="font-medium mb-3 justify-content-center d-flex">
                                        <div class="col-md-5 text-end">
                                            <img src="./img/boy_x.png" width="90" alt="">
                                        </div>
                                        <div class="mt-3 col-md-7 text-center">
                                            <b class="font-49 no_cumple"> <?php echo $no_cumple; ?></b> <i class="mdi mdi-close font-49 text-danger"></i>
                                        </div>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card col-md-3 datos_avance">
                        <div class="card-body p-1">
                            <div class="row pt-4">
                                <div class="col-md-8 p-0 text-center">
                                    <h1 class="font-light avance mb-3"><?php
                                        if($cumple == 0 and $no_cumple == 0){ echo '0 %'; }else{
                                            echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%'; }
                                        ?> 
                                    </h1>
                                    <h4 class="text-muted">Avance</h4></div>
                                <div class="col-md-4 p-0 text-center align-self-center position-sticky">
                                    <div id="chart" class="css-bar m-b-0 css-bar-info css-bar-<?php if($cumple == 0 and $no_cumple == 0){ echo '0'; }else{
                                            echo number_format((float)(($cumple/$row_cont)*100), 0, '.', ''); }
                                        ?>"><i class="mdi mdi-receipt"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-md-5 d-flex">
                    <button class="btn btn-outline-dark btn-sm  m-2 btn_fed"><i class="mdi mdi-checkbox-multiple-blank"></i> FED</button>
                    <button class="btn btn-outline-primary btn-sm  m-2 btn_all"><i class="mdi mdi-checkbox-blank-circle"></i> Todo</button>
                </div>
                <div class="col-md-7 d-flex">
                    <form action="impresion_68_meses.php" method="POST">
                        <input hidden name="red" value="<?php echo $_POST['red']; ?>">
                        <input hidden name="distrito" value="<?php echo $_POST['distrito']; ?>">
                        <input hidden name="mes" value="<?php echo $_POST['mes']; ?>">
                        <input hidden name="anio" value="<?php echo $_POST['anio']; ?>">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir Excel</button>
                    </form>
                    <button type="submit" name="Limpiar" class="btn btn-outline-danger m-2 btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="mdi mdi-format-list-bulleted"></i> Informacion</button>
                    <button type="submit" name="Limpiar" class="btn btn-outline-secondary m-2 btn-sm 1btn_buscar" onclick="location.href='6-8_meses.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
                </div>
            </div><br>
            <div class="col-12 table-responsive table_no_fed" id="seis_ocho_meses">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle" id="fields_68_meses_head">Menor Visitado</th> 
                            <th class="align-middle" id="fields_68_meses_head">Menor Encontrado</th>
                            <th class="align-middle" id="fields_68_meses_head">N??mero CNV</th>
                            <th class="align-middle">Fecha de Nacimiento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="fields_68_meses_head">Tipo de Seguro</th> 
                            <th class="align-middle" id="fields_68_meses_head">PN ??ltimo Lugar</th>
                            <th class="align-middle">Actividad Establecimiento (HIS)</th>
                            <th class="align-middle">Dosaje de Hemoglobina</th>
                            <th class="align-middle">DX Anemia</th>
                            <th class="align-middle">Tratamiento</th>
                            <th class="align-middle">Suplementaci??n</th>
                            <th class="align-middle">Cumple</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_no_fed">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php  
                            include('consulta_6_8_meses.php');
                            $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta4)){                        
                                if(is_null ($consulta['PROVINCIA']) ){ $newdate3 = '  -'; }
                                else{ $newdate3 = $consulta['PROVINCIA'] ;}

                                if(is_null ($consulta['DISTRITO']) ){ $newdate4 = '  -'; }
                                else{ $newdate4 = $consulta['DISTRITO'];}
                    
                                if(is_null ($consulta['MENOR_VISITADO']) ){ $newdate5 = '  -'; }
                                else{ $newdate5 = $consulta['MENOR_VISITADO'];}
                    
                                if(is_null ($consulta['MENOR_ENCONTRADO']) ){ $newdate6 = '  -'; }
                                else{ $newdate6 = $consulta['MENOR_ENCONTRADO'];}
                    
                                if(is_null ($consulta['NUM_CNV']) ){ $newdate8 = '  -'; }
                                else{ $newdate8 = $consulta['NUM_CNV'];}
                
                                if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ $newdate9 = '  -'; }
                                else{ $newdate9 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
                    
                                if(is_null ($consulta['DOCUMENTO']) ){ $newdate10 = '  -'; }
                                else{ $newdate10 = $consulta['DOCUMENTO'];}
                                            
                                if(is_null ($consulta['TIPO_DOC']) ){ $newdate11 = '  -'; }
                                else{ $newdate11 = $consulta['TIPO_DOC'];}
                    
                                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ 
                                    $newdate12 = '  -'; }
                                else{ $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
                    
                                if(is_null ($consulta['TIPO_SEGURO']) ){ $newdate13 = '  -'; }
                                else{ $newdate13 = $consulta['TIPO_SEGURO'];}
                    
                                if(is_null ($consulta['PN_ULTIMO_LUGAR']) ){ $newdate14 = '  -'; }
                                else{ $newdate14 = $consulta['PN_ULTIMO_LUGAR'];}
                    
                                if(is_null ($consulta['ESTAB_ACTIVIDAD']) ){ $newdate15 = '  -'; }
                                else{ $newdate15 = $consulta['ESTAB_ACTIVIDAD'];}
                
                                if(is_null ($consulta['HEMOGLOBINA']) ){ $newdate16 = '  -'; }
                                else{ $newdate16 = $consulta['HEMOGLOBINA'] -> format('d/m/y');}
                
                                if(is_null ($consulta['D50X']) ){ $newdate17 = '  -'; }
                                else{ $newdate17 = $consulta['D50X'] -> format('d/m/y');}
                        
                                if(is_null ($consulta['U310_SF1']) ){ $newdate18 = '  -'; }
                                else{ $newdate18 = $consulta['U310_SF1'] -> format('d/m/y');}
                        
                                if(is_null ($consulta['SUPLE']) ){ $newdate19 = '  -'; }
                                else{ $newdate19 = $consulta['SUPLE'] -> format('d/m/y');}
                                
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle" id="fields_68_meses_body"><?php echo $newdate5; ?></td>
                            <td class="align-middle" id="fields_68_meses_body"><?php echo $newdate6; ?></td>
                            <td class="align-middle" id="fields_68_meses_body"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php
                                $findme = "+??"; $findme2 = "+??"; $findme3 = "+??"; $findme4 = "+??";
                                $data = utf8_encode($newdate12); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle" id="fields_68_meses_body"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="fields_68_meses_body"><?php
                                $findme = "+??"; $findme2 = "+??"; $findme3 = "+??"; $findme4 = "+??";
                                $data = utf8_encode($newdate14); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate15); ?></td>
                            <td class="align-middle"><?php echo $newdate16; ?></td>
                            <td class="align-middle"><?php echo $newdate17; ?></td>
                            <td class="align-middle"><?php echo $newdate18; ?></td>
                            <td class="align-middle"><?php echo $newdate19; ?></td>
                            <td class="align-middle">
                                <?php
                                    // SUPLEMENTACION      D50X     U3010_SF1
                                    if(!is_null ($consulta['HEMOGLOBINA']) && !is_null ($consulta['D50X']) && !is_null ($consulta['U310_SF1']) && is_null ($consulta['SUPLE'])){
                                        if($consulta['HEMOGLOBINA'] == $consulta['D50X'] && $consulta['HEMOGLOBINA'] == $consulta['U310_SF1']){
                                            echo "<span class='badge bg-correct'>Si</span>";
                                        }else{
                                            $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                            $nuevo_formato_anemia = date_format($consulta['D50X'], "d-m-Y");
                                            $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                            $fecha_anemia = strtotime(date_format($consulta['D50X'], "d-m-Y"));
                                            $fecha_tratamiento = strtotime(date_format($consulta['U310_SF1'], "d-m-Y"));
                                            $fecha_anemia_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_anemia."+ 7 days")));

                                            if($fecha_anemia < $fecha_hemoglobina_7_dias && $fecha_anemia > $nuevo_formato_hemoglobina) {
                                                echo "<span class='badge bg-correct'>Si</span>";
                                            }
                                            else{
                                                echo "<span class='badge bg-incorrect'>No</span>";
                                            }
                                        }
                                    }
                                    // SUPLEMENTACION     Y     HEMOGLOBINA
                                    else if(!is_null ($consulta['HEMOGLOBINA']) && is_null ($consulta['D50X']) && is_null ($consulta['U310_SF1']) && !is_null ($consulta['SUPLE'])){
                                        if($consulta['HEMOGLOBINA'] == $consulta['SUPLE']){
                                            echo "<span class='badge bg-correct'>Si</span>";
                                        }
                                        else{
                                            $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                            $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                            $fecha_suplementacion = strtotime(date_format($consulta['SUPLE'], "d-m-Y"));
                                            if($fecha_suplementacion < $fecha_hemoglobina_7_dias && $fecha_suplementacion > $nuevo_formato_hemoglobina) {
                                                echo "<span class='badge bg-correct'>Si</span>";
                                            }
                                            else{
                                                echo "<span class='badge bg-incorrect'>No</span>";
                                            }
                                        }
                                    }
                                    else{
                                        echo "<span class='badge bg-incorrect'>No</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="18">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <!-- TABLA FEDDD -->
            <div class="col-12 table-responsive table_fed" style="display: none;">
                <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #d9d9d9;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle" id="color_fed_head">Menor Visitado</th> 
                            <th class="align-middle" id="color_fed_head">Menor Encontrado</th>
                            <th class="align-middle" id="color_fed_head">N??mero CNV</th>
                            <th class="align-middle">Fecha de Nacimiento</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle" id="color_fed_head">Tipo de Seguro</th> 
                            <th class="align-middle" id="color_fed_head">PN ??ltimo Lugar</th>
                            <th class="align-middle">Actividad Establecimiento (HIS)</th>
                            <th class="align-middle">Dosaje de Hemoglobina</th>
                            <th class="align-middle">DX Anemia</th>
                            <th class="align-middle">Tratamiento</th>
                            <th class="align-middle">Suplementaci??n</th>
                            <th class="align-middle">Cumple</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-1 col-md-3 table_fed" style="display: none;">
                        <div class="mb-3">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search" type="text" placeholder="Buscar por Nombres o DNI..." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                        <?php  
                            include('consulta_6_8_meses.php');
                            $i_fed=1; $cumple_fed=0; $no_cumple_fed=0; $observado_fed=0;
                            while ($consulta = sqlsrv_fetch_array($consulta4)){
                                $tipo = strval($consulta['TIPO_SEGURO']);
                                $tipo2 = strpos($tipo, '2');
                                $tipo0 = strpos($tipo, '0');
                                $tipo1 = strpos($tipo, '1');
                                $tipo3 = strpos($tipo, '3');
                                $tipo4 = strpos($tipo, '4');

                                if(($tipo2 === 0 || $tipo2 > 0) && (($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))
                                        || (($tipo == '') || ($tipo0 > 0 || $tipo0 === 0) || ($tipo1 > 0 || $tipo1 === 0) || ($tipo3 > 0 || $tipo3 === 0) || ($tipo4 > 0 || $tipo4 === 0))){
                            
                                    if(is_null ($consulta['PROVINCIA']) ){ $newdate3 = '  -'; }
                                    else{ $newdate3 = $consulta['PROVINCIA'] ;}

                                    if(is_null ($consulta['DISTRITO']) ){ $newdate4 = '  -'; }
                                    else{ $newdate4 = $consulta['DISTRITO'];}
                        
                                    if(is_null ($consulta['MENOR_VISITADO']) ){ $newdate5 = '  -'; }
                                    else{ $newdate5 = $consulta['MENOR_VISITADO'];}
                        
                                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){ $newdate6 = '  -'; }
                                    else{ $newdate6 = $consulta['MENOR_ENCONTRADO'];}
                        
                                    if(is_null ($consulta['NUM_CNV']) ){ $newdate8 = '  -'; }
                                    else{ $newdate8 = $consulta['NUM_CNV'];}
                    
                                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ $newdate9 = '  -'; }
                                    else{ $newdate9 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
                        
                                    if(is_null ($consulta['DOCUMENTO']) ){ $newdate10 = '  -'; }
                                    else{ $newdate10 = $consulta['DOCUMENTO'];}
                                                
                                    if(is_null ($consulta['TIPO_DOC']) ){ $newdate11 = '  -'; }
                                    else{ $newdate11 = $consulta['TIPO_DOC'];}
                        
                                    if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ 
                                        $newdate12 = '  -'; }
                                    else{ $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
                        
                                    if(is_null ($consulta['TIPO_SEGURO']) ){ $newdate13 = '  -'; }
                                    else{ $newdate13 = $consulta['TIPO_SEGURO'];}
                        
                                    if(is_null ($consulta['PN_ULTIMO_LUGAR']) ){ $newdate14 = '  -'; }
                                    else{ $newdate14 = $consulta['PN_ULTIMO_LUGAR'];}
                        
                                    if(is_null ($consulta['ESTAB_ACTIVIDAD']) ){ $newdate15 = '  -'; }
                                    else{ $newdate15 = $consulta['ESTAB_ACTIVIDAD'];}
                    
                                    if(is_null ($consulta['HEMOGLOBINA']) ){ $newdate16 = '  -'; }
                                    else{ $newdate16 = $consulta['HEMOGLOBINA'] -> format('d/m/y');}
                    
                                    if(is_null ($consulta['D50X']) ){ $newdate17 = '  -'; }
                                    else{ $newdate17 = $consulta['D50X'] -> format('d/m/y');}
                            
                                    if(is_null ($consulta['U310_SF1']) ){ $newdate18 = '  -'; }
                                    else{ $newdate18 = $consulta['U310_SF1'] -> format('d/m/y');}
                            
                                    if(is_null ($consulta['SUPLE']) ){ $newdate19 = '  -'; }
                                    else{ $newdate19 = $consulta['SUPLE'] -> format('d/m/y');}
                                    
                        ?>
                        <tr class="text-center font-12">
                            <td class="align-middle"><?php echo $i_fed++; ?></td>
                            <td class="align-middle"><?php echo $newdate3; ?></td>
                            <td class="align-middle"><?php echo $newdate4; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate5; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate6; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate8; ?></td>
                            <td class="align-middle"><?php echo $newdate9; ?></td>
                            <td class="align-middle"><?php echo $newdate10; ?></td>
                            <td class="align-middle"><?php echo $newdate11; ?></td>
                            <td class="align-middle"><?php
                                $findme = "+??"; $findme2 = "+??"; $findme3 = "+??"; $findme4 = "+??";
                                $data = utf8_encode($newdate12); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle" id="color_fed_body"><?php echo $newdate13; ?></td>
                            <td class="align-middle" id="color_fed_body"><?php 
                                $findme = "+??"; $findme2 = "+??"; $findme3 = "+??"; $findme4 = "+??";
                                $data = utf8_encode($newdate14); 
                                $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                                if($pos == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos2 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos3 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else if($pos4 == true){
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }else{
                                    $resultado = str_replace("+??", "??", $data);
                                    echo $resultado;
                                }
                            ?></td>
                            <td class="align-middle"><?php echo utf8_encode($newdate15); ?></td>
                            <td class="align-middle"><?php echo $newdate16; ?></td>
                            <td class="align-middle"><?php echo $newdate17; ?></td>
                            <td class="align-middle"><?php echo $newdate18; ?></td>
                            <td class="align-middle"><?php echo $newdate19; ?></td>
                            <td class="align-middle">
                                <?php
                                    if(!is_null ($consulta['HEMOGLOBINA']) && !is_null ($consulta['D50X']) && !is_null ($consulta['U310_SF1']) && is_null ($consulta['SUPLE'])){
                                        if($consulta['HEMOGLOBINA'] == $consulta['D50X'] && $consulta['HEMOGLOBINA'] == $consulta['U310_SF1']){
                                            echo "<span class='badge bg-correct'>Si</span>";
                                            $cumple_fed++;
                                        }else{
                                            $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                            $nuevo_formato_anemia = date_format($consulta['D50X'], "d-m-Y");
                                            $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                            $fecha_anemia = strtotime(date_format($consulta['D50X'], "d-m-Y"));
                                            $fecha_tratamiento = strtotime(date_format($consulta['U310_SF1'], "d-m-Y"));
                                            $fecha_anemia_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_anemia."+ 7 days")));
                                            if($fecha_anemia < $fecha_hemoglobina_7_dias && $fecha_anemia > $nuevo_formato_hemoglobina) {
                                                echo "<span class='badge bg-correct'>Si</span>";
                                                $cumple_fed++;
                                            }
                                            else{
                                                echo "<span class='badge bg-incorrect'>No</span>";
                                                $no_cumple_fed++;
                                            }
                                        }
                                    }
                                    else if(!is_null ($consulta['HEMOGLOBINA']) && is_null ($consulta['D50X']) && is_null ($consulta['U310_SF1']) && !is_null ($consulta['SUPLE'])){
                                        if($consulta['HEMOGLOBINA'] == $consulta['SUPLE']){
                                            echo "<span class='badge bg-correct'>Si</span>";
                                            $cumple_fed++;
                                        }
                                        else{
                                            $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                            $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                            $fecha_suplementacion = strtotime(date_format($consulta['SUPLE'], "d-m-Y"));
                                            if($fecha_suplementacion < $fecha_hemoglobina_7_dias && $fecha_suplementacion > $nuevo_formato_hemoglobina) {
                                                echo "<span class='badge bg-correct'>Si</span>";
                                                $cumple_fed++;
                                            }
                                        }
                                    }
                                    else{
                                        echo "<span class='badge bg-incorrect'>No</span>";
                                        $no_cumple_fed++;
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php
                            }
                            ;}                    
                            include("cerrar.php");
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="18">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    
    <!-- MODAL INFORMACION-->
    <div class="modal fade" id="ModalInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="col-12 text-end"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div>
                    <img src="./img/inf_68meses.png" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <script src="./js/records_menu.js"></script>
    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script>
        $(function(){
            $(".btn_fed").click(function(){
                $(".total").text(<?php echo $i_fed-1; ?>);
                $(".cumple").text(<?php echo $cumple_fed; ?>);
                $(".no_cumple").text(<?php echo $no_cumple_fed; ?>);
                $(".avance").text(<?php if($cumple_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($cumple_fed/($i_fed-1))*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $("#chart").removeClass("css-bar-<?php if($cumple == 0 and $no_cumple == 0){ echo '0'; }else{
                                                echo number_format((float)(($cumple/$row_cont)*100), 0, '.', ''); }
                                            ?>");
                $("#chart").addClass("css-bar-<?php if($cumple_fed==0 && $no_cumple_fed == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($cumple_fed/($i_fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
                $(".table_fed").show();
                $(".table_no_fed").hide();
            });
            $(".btn_all").click(function(){
                $(".total").text(<?php echo $row_cont; ?>);
                $(".cumple").text(<?php echo $cumple; ?>);
                $(".no_cumple").text(<?php echo $no_cumple; ?>);
                $(".avance").text(<?php if($cumple == 0 and $row_cont == 0){ echo "'0 %'"; }
                    else{ $porcentaje = number_format((float)(($cumple/$row_cont)*100), 2, '.', '');
                            echo "'$porcentaje %'"; }?>);
                $("#chart").removeClass("css-bar-<?php if($cumple_fed==0 && $no_cumple_fed == 0){ echo "0"; }
                    else{ $porcentaje = number_format((float)(($cumple_fed/($i_fed-1))*100), 0, '.', '');
                            echo "$porcentaje"; }?>");
                $("#chart").addClass("css-bar-<?php if($cumple == 0 and $no_cumple == 0){ echo '0'; }else{
                                                echo number_format((float)(($cumple/$row_cont)*100), 0, '.', ''); }
                                            ?>");
                $(".table_fed").hide();
                $(".table_no_fed").show();
            });
        });

        $('#demo-input-search').on('input', function (e) {
            e.preventDefault();
            addrow2.trigger('footable_filter', {filter: $(this).val()});
        });
                
        var addrow2 = $('#demo-foo-addrow');
        addrow2.footable().on('click', '.delete-row-btn', function() {
            var footable = addrow.data('footable');
            var row = $(this).parents('tr:first');
            footable.removeRow(row);
        });
    </script>
</body>
</html>