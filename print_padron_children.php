<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
        $edad = $_POST['edad'];

        if($mes == 1){ $nombre_mes = 'ENERO'; }
        else if($mes == 2){ $nombre_mes = 'FEBRERO'; }
        else if($mes == 3){ $nombre_mes = 'MARZO'; }
        else if($mes == 4){ $nombre_mes = 'ABRIL'; }
        else if($mes == 5){ $nombre_mes = 'MAYO'; }
        else if($mes == 6){ $nombre_mes = 'JUNIO'; }
        else if($mes == 7){ $nombre_mes = 'JULIO'; }
        else if($mes == 8){ $nombre_mes = 'AGOSTO'; }
        else if($mes == 9){ $nombre_mes = 'SETIEMBRE'; }
        else if($mes == 10){ $nombre_mes = 'OCTUBRE'; }
        else if($mes == 11){ $nombre_mes = 'NOVIEMBRE'; }
        else if($mes == 12){ $nombre_mes = 'DICIEMBRE'; }

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes; }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $red = 'TODOS'; }

        $edad = intval($edad);

        if($red_1 == 4 and $dist_1 == 'TODOS'){
            $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_CENTRO_POBLA, AREA_CENTRO_POBLA, MENOR_VISITADO, MENOR_ENCONTRADO, FECHA_VISITA, FUENTE_DATOS, FECHA_FUENTE_DATOS,
                            COD_EESS_NACIMIENTO, NOMBRE_EESS_NACIMIENTO, COD_EESS, NOMBRE_EESS, FRECUENCIA_ATENCION, COD_EESS_ADSCRIPCION, NOMBRE_EESS_ADCRIPCION, TIPO_DOC_IDENTIDAD,
                            NUM_CNV, COD_CUI, NUM_DNI, APELLIDO_PATERNO_NINO, APELLIDO_MATERNO_NINO, NOMBRE_NINO, COD_SEXO_NINO, FECHA_NACIMIENTO_NINO, EJE_VIAL, DESCRIPCION, 
                            REFERENCIA_DIREC, TIPO_SEGURO, TIPO_PROGRAMA_SOCIAL, NOMBRE_INSTITUCION_EDUCATIVA, RELACION_APODERADO_MENOR, DNI_MADRE_DEL_MENOR, APELLIDO_PATERNO_MADRE,
                            APELLIDO_MATERNO_MADRE, NOMBRES_MADRE_MENOR, ESTADO_REGISTRO, FECHA_CREACION_REGISTRO, USUARIO_QUE_CREA, FECHA_MODIFICACION_REGISTRO, USUARIO_QUE_MODIFICA, 
                            ENTIDAD, TIPO_REGISTRO
                            FROM NOMINAL_PADRON_NOMINAL
                            WHERE MES='202110' AND MONTH(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='2021'
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";
        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_CENTRO_POBLA, AREA_CENTRO_POBLA, MENOR_VISITADO, MENOR_ENCONTRADO, FECHA_VISITA, FUENTE_DATOS, FECHA_FUENTE_DATOS,
                            COD_EESS_NACIMIENTO, NOMBRE_EESS_NACIMIENTO, COD_EESS, NOMBRE_EESS, FRECUENCIA_ATENCION, COD_EESS_ADSCRIPCION, NOMBRE_EESS_ADCRIPCION, TIPO_DOC_IDENTIDAD,
                            NUM_CNV, COD_CUI, NUM_DNI, APELLIDO_PATERNO_NINO, APELLIDO_MATERNO_NINO, NOMBRE_NINO, COD_SEXO_NINO, FECHA_NACIMIENTO_NINO, EJE_VIAL, DESCRIPCION, 
                            REFERENCIA_DIREC, TIPO_SEGURO, TIPO_PROGRAMA_SOCIAL, NOMBRE_INSTITUCION_EDUCATIVA, RELACION_APODERADO_MENOR, DNI_MADRE_DEL_MENOR, APELLIDO_PATERNO_MADRE,
                            APELLIDO_MATERNO_MADRE, NOMBRES_MADRE_MENOR, ESTADO_REGISTRO, FECHA_CREACION_REGISTRO, USUARIO_QUE_CREA, FECHA_MODIFICACION_REGISTRO, USUARIO_QUE_MODIFICA, 
                            ENTIDAD, TIPO_REGISTRO
                            FROM NOMINAL_PADRON_NOMINAL
                            WHERE MES='202110' AND MONTH(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='2021' AND NOMBRE_PROV='$red'
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT NOMBRE_PROV, NOMBRE_DIST, NOMBRE_CENTRO_POBLA, AREA_CENTRO_POBLA, MENOR_VISITADO, MENOR_ENCONTRADO, FECHA_VISITA, FUENTE_DATOS, FECHA_FUENTE_DATOS,
                            COD_EESS_NACIMIENTO, NOMBRE_EESS_NACIMIENTO, COD_EESS, NOMBRE_EESS, FRECUENCIA_ATENCION, COD_EESS_ADSCRIPCION, NOMBRE_EESS_ADCRIPCION, TIPO_DOC_IDENTIDAD,
                            NUM_CNV, COD_CUI, NUM_DNI, APELLIDO_PATERNO_NINO, APELLIDO_MATERNO_NINO, NOMBRE_NINO, COD_SEXO_NINO, FECHA_NACIMIENTO_NINO, EJE_VIAL, DESCRIPCION, 
                            REFERENCIA_DIREC, TIPO_SEGURO, TIPO_PROGRAMA_SOCIAL, NOMBRE_INSTITUCION_EDUCATIVA, RELACION_APODERADO_MENOR, DNI_MADRE_DEL_MENOR, APELLIDO_PATERNO_MADRE,
                            APELLIDO_MATERNO_MADRE, NOMBRES_MADRE_MENOR, ESTADO_REGISTRO, FECHA_CREACION_REGISTRO, USUARIO_QUE_CREA, FECHA_MODIFICACION_REGISTRO, USUARIO_QUE_MODIFICA, 
                            ENTIDAD, TIPO_REGISTRO
                            FROM NOMINAL_PADRON_NOMINAL
                            WHERE MES='202110' AND MONTH(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,$edad,FECHA_NACIMIENTO_NINO))='2021' 
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                            ORDER BY NOMBRE_PROV, NOMBRE_DIST";

        }
  
        $consulta2 = sqlsrv_query($conn2, $resultado);

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO PADRON NIÑOS 6 MESES "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
            header('Content-Type: text/html; charset=UTF-8');
    ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <table>
            <thead>
                <tr class="text-center">
                    <th colspan="44" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
                </tr>
                <tr></tr>
                <tr class="text-center">
                    <th colspan="44" style="font-size: 26px; border: 1px solid #3A3838;">Padrón Niños 6 Meses - <?php echo $nombre_mes; ?></th>
                </tr>
                <tr></tr>
                <tr class="text-center">
                    <th colspan="2" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PADRON NOMINAL</th>
                </tr>
                <tr></tr>
            </thead>
        </table> 
        <table>
            <thead>
                <tr class="font-15 text-center" style="background: #e0eff5;">
                    <th style="border: 1px solid #DDDDDD;">#</th>
                    <th style="border: 1px solid #DDDDDD;">PROVINCIA</th>
                    <th style="border: 1px solid #DDDDDD;">DISTRITO</th>
                    <th style="border: 1px solid #DDDDDD;">CENTRO POBLADO</th>
                    <th style="border: 1px solid #DDDDDD;">AREA CENTRO POBLADO</th>
                    <th style="border: 1px solid #DDDDDD;">MENOR VISITADO</th>
                    <th style="border: 1px solid #DDDDDD;">MENOR ENCONTRADO</th>
                    <th style="border: 1px solid #DDDDDD;">FECHA DE VISITA</th>
                    <th style="border: 1px solid #DDDDDD;">FUENTE DE DATOS</th>
                    <th style="border: 1px solid #DDDDDD;">FECHA FUENTE DE DATOS</th>
                    <th style="border: 1px solid #DDDDDD;">CÓDIGO DE EESS NACIMIENTO</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRE DE EESS NACIMIENTO</th>
                    <th style="border: 1px solid #DDDDDD;">CÓDIGO DE ESTABLECIMIENTO</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRE DE ESTABLECIMIENTO</th>
                    <th style="border: 1px solid #DDDDDD;">FRECUENCIA ATENCIÓN</th>
                    <th style="border: 1px solid #DDDDDD;">CÓDIGO DE EESS ADSCRIPCIÓN</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRE DE EESS ADSCRIPCIÓN</th>
                    <th style="border: 1px solid #DDDDDD;">TIPO DE DOCUMENTO</th>
                    <th style="border: 1px solid #DDDDDD;">NÚMERO DE CNV</th>
                    <th style="border: 1px solid #DDDDDD;">CÓDIGO CUI</th>
                    <th style="border: 1px solid #DDDDDD;">NÚMERO DE DNI</th>
                    <th style="border: 1px solid #DDDDDD;">APELLIDO PATERNO NIÑO</th>
                    <th style="border: 1px solid #DDDDDD;">APELLIDO MATERNO NIÑO</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRES NIÑO</th>
                    <th style="border: 1px solid #DDDDDD;">CÓDIGO SEXO NIÑO</th>
                    <th style="border: 1px solid #DDDDDD;">FECHA NACIMIENTO NIÑO</th>
                    <th style="border: 1px solid #DDDDDD;">EJE VIAL</th>
                    <th style="border: 1px solid #DDDDDD;">DESCRIPCIÓN</th>
                    <th style="border: 1px solid #DDDDDD;">REFERENCIA DIRECCIÓN</th>
                    <th style="border: 1px solid #DDDDDD;">TIPO DE SEGURO</th>
                    <th style="border: 1px solid #DDDDDD;">TIPO PROGRAMA SOCIAL</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRE INSTITUCIÓN EDUCATIVA</th>
                    <th style="border: 1px solid #DDDDDD;">RELACIÓN APODERADO MENOR</th>
                    <th style="border: 1px solid #DDDDDD;">DNI MADRE</th>
                    <th style="border: 1px solid #DDDDDD;">APELLIDO PATERNO MADRE</th>
                    <th style="border: 1px solid #DDDDDD;">APELLIDO MATERNO MADRE</th>
                    <th style="border: 1px solid #DDDDDD;">NOMBRES DE LA MADRE</th>
                    <th style="border: 1px solid #DDDDDD;">ESTADO REGISTRO</th>
                    <th style="border: 1px solid #DDDDDD;">FECHA CREACIÓN REGISTRO</th>
                    <th style="border: 1px solid #DDDDDD;">USUARIO QUE CREA</th>
                    <th style="border: 1px solid #DDDDDD;">FECHA MODIFICACIÓN REGISTRO</th>
                    <th style="border: 1px solid #DDDDDD;">USUARIO QUE MODIFICA
                    <th style="border: 1px solid #DDDDDD;">ENTIDAD</th>
                    <th style="border: 1px solid #DDDDDD;">TIPO DE REGISTRO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){
                        if(is_null ($consulta['NOMBRE_PROV']) ){
                            $newdate = '  -'; }
                            else{
                        $newdate = $consulta['NOMBRE_PROV'];}

                        if(is_null ($consulta['NOMBRE_DIST']) ){
                            $newdate2 = '  -'; }
                            else{
                        $newdate2 = $consulta['NOMBRE_DIST'];}
                    
                        if(is_null ($consulta['NOMBRE_CENTRO_POBLA']) ){
                            $newdate3 = '  -'; }
                            else{
                        $newdate3 = $consulta['NOMBRE_CENTRO_POBLA'] ;}
                    
                        if(is_null ($consulta['AREA_CENTRO_POBLA']) ){
                            $newdate4 = '  -'; }
                            else{
                        $newdate4 = $consulta['AREA_CENTRO_POBLA'];}
                    
                        if(is_null ($consulta['MENOR_VISITADO']) ){
                            $newdate5 = '  -'; }
                            else{
                        $newdate5 = $consulta['MENOR_VISITADO'];}
                    
                        if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                            $newdate6 = '  -'; }
                            else{
                        $newdate6 = $consulta['MENOR_ENCONTRADO'];}
                    
                        if(is_null ($consulta['FECHA_VISITA']) ){
                            $newdate7 = '  -'; }
                            else{
                        $newdate7 = $consulta['FECHA_VISITA'] -> format('d/m/y');}
                    
                        if(is_null ($consulta['FUENTE_DATOS']) ){
                            $newdate8 = '  -'; }
                            else{
                        $newdate8 = $consulta['FUENTE_DATOS'];}
                    
                        if(is_null ($consulta['FECHA_FUENTE_DATOS']) ){
                            $newdate10 = '  -'; }
                            else{
                        $newdate10 = $consulta['FECHA_FUENTE_DATOS'] -> format('d/m/y');}
                    
                        if(is_null ($consulta['COD_EESS_NACIMIENTO']) ){
                            $newdate11 = '  -'; }
                            else{
                        $newdate11 = $consulta['COD_EESS_NACIMIENTO'];}
                    
                        if(is_null ($consulta['NOMBRE_EESS_NACIMIENTO']) ){
                            $newdate12 = '  -'; }
                            else{
                        $newdate12 = $consulta['NOMBRE_EESS_NACIMIENTO'];}
                    
                        if(is_null ($consulta['COD_EESS']) ){
                            $newdate13 = '  -'; }
                            else{
                        $newdate13 = $consulta['COD_EESS'];}
                    
                        if(is_null ($consulta['NOMBRE_EESS']) ){
                            $newdate14 = '  -'; }
                            else{
                        $newdate14 = $consulta['NOMBRE_EESS'];}

                        if(is_null ($consulta['FRECUENCIA_ATENCION']) ){
                            $newdate15 = '  -'; }
                            else{
                        $newdate15 = $consulta['FRECUENCIA_ATENCION'];}

                        if(is_null ($consulta['COD_EESS_ADSCRIPCION']) ){
                            $newdate16 = '  -'; }
                            else{
                        $newdate16 = $consulta['COD_EESS_ADSCRIPCION'];}

                        if(is_null ($consulta['NOMBRE_EESS_ADCRIPCION']) ){
                            $newdate17 = '  -'; }
                            else{
                        $newdate17 = $consulta['NOMBRE_EESS_ADCRIPCION'];}

                        if(is_null ($consulta['TIPO_DOC_IDENTIDAD']) ){
                            $newdate18 = '  -'; }
                            else{
                        $newdate18 = $consulta['TIPO_DOC_IDENTIDAD'];}

                        if(is_null ($consulta['NUM_CNV']) ){
                            $newdate19 = '  -'; }
                            else{
                        $newdate19 = $consulta['NUM_CNV'];}

                        if(is_null ($consulta['COD_CUI']) ){
                            $newdate20 = '  -'; }
                            else{
                        $newdate20 = $consulta['COD_CUI'];}

                        if(is_null ($consulta['NUM_DNI']) ){
                            $newdate21 = '  -'; }
                            else{
                        $newdate21 = $consulta['NUM_DNI'];}

                        if(is_null ($consulta['APELLIDO_PATERNO_NINO']) ){
                            $newdate22 = '  -'; }
                            else{
                        $newdate22 = $consulta['APELLIDO_PATERNO_NINO'];}

                        if(is_null ($consulta['APELLIDO_MATERNO_NINO']) ){
                            $newdate23 = '  -'; }
                            else{
                        $newdate23 = $consulta['APELLIDO_MATERNO_NINO'];}

                        if(is_null ($consulta['NOMBRE_NINO']) ){
                            $newdate24 = '  -'; }
                            else{
                        $newdate24 = $consulta['NOMBRE_NINO'];}

                        if(is_null ($consulta['COD_SEXO_NINO']) ){
                            $newdate25 = '  -'; }
                            else{
                        $newdate25 = $consulta['COD_SEXO_NINO'];}

                        if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                            $newdate26 = '  -'; }
                            else{
                        $newdate26 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}

                        if(is_null ($consulta['EJE_VIAL']) ){
                            $newdate27 = '  -'; }
                            else{
                        $newdate27 = $consulta['EJE_VIAL'];}

                        if(is_null ($consulta['DESCRIPCION']) ){
                            $newdate28 = '  -'; }
                            else{
                        $newdate28 = $consulta['DESCRIPCION'];}

                        if(is_null ($consulta['REFERENCIA_DIREC']) ){
                            $newdate29 = '  -'; }
                            else{
                        $newdate29 = $consulta['REFERENCIA_DIREC'];}

                        if(is_null ($consulta['TIPO_SEGURO']) ){
                            $newdate30 = '  -'; }
                            else{
                        $newdate30 = $consulta['TIPO_SEGURO'];}

                        if(is_null ($consulta['TIPO_PROGRAMA_SOCIAL']) ){
                            $newdate31 = '  -'; }
                            else{
                        $newdate31 = $consulta['TIPO_PROGRAMA_SOCIAL'];}

                        if(is_null ($consulta['NOMBRE_INSTITUCION_EDUCATIVA']) ){
                            $newdate32 = '  -'; }
                            else{
                        $newdate32 = $consulta['NOMBRE_INSTITUCION_EDUCATIVA'];}

                        if(is_null ($consulta['RELACION_APODERADO_MENOR']) ){
                            $newdate33 = '  -'; }
                            else{
                        $newdate33 = $consulta['RELACION_APODERADO_MENOR'];}

                        if(is_null ($consulta['DNI_MADRE_DEL_MENOR']) ){
                            $newdate34 = '  -'; }
                            else{
                        $newdate34 = $consulta['DNI_MADRE_DEL_MENOR'];}

                        if(is_null ($consulta['APELLIDO_PATERNO_MADRE']) ){
                            $newdate35 = '  -'; }
                            else{
                        $newdate35 = $consulta['APELLIDO_PATERNO_MADRE'];}

                        if(is_null ($consulta['APELLIDO_MATERNO_MADRE']) ){
                            $newdate36 = '  -'; }
                            else{
                        $newdate36 = $consulta['APELLIDO_MATERNO_MADRE'];}

                        if(is_null ($consulta['NOMBRES_MADRE_MENOR']) ){
                            $newdate37 = '  -'; }
                            else{
                        $newdate37 = $consulta['NOMBRES_MADRE_MENOR'];}

                        if(is_null ($consulta['ESTADO_REGISTRO']) ){
                            $newdate38 = '  -'; }
                            else{
                        $newdate38 = $consulta['ESTADO_REGISTRO'];}

                        if(is_null ($consulta['FECHA_CREACION_REGISTRO']) ){
                            $newdate39 = '  -'; }
                            else{
                        $newdate39 = $consulta['FECHA_CREACION_REGISTRO'] -> format('d/m/y');}

                        if(is_null ($consulta['USUARIO_QUE_CREA']) ){
                            $newdate40 = '  -'; }
                            else{
                        $newdate40 = $consulta['USUARIO_QUE_CREA'];}

                        if(is_null ($consulta['FECHA_MODIFICACION_REGISTRO']) ){
                            $newdate41 = '  -'; }
                            else{
                        $newdate41 = $consulta['FECHA_MODIFICACION_REGISTRO'] -> format('d/m/y');}

                        if(is_null ($consulta['USUARIO_QUE_MODIFICA']) ){
                            $newdate42 = '  -'; }
                            else{
                        $newdate42 = $consulta['USUARIO_QUE_MODIFICA'];}

                        if(is_null ($consulta['ENTIDAD']) ){
                            $newdate43 = '  -'; }
                            else{
                        $newdate43 = $consulta['ENTIDAD'];}

                        if(is_null ($consulta['TIPO_REGISTRO']) ){
                            $newdate44 = '  -'; }
                            else{
                        $newdate44 = $consulta['TIPO_REGISTRO'];}
                    
                ?>
                <tr class="text-center font-12">
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo $i++; ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle;"><?php echo utf8_encode($newdate); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle;"><?php echo utf8_encode($newdate2); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle;"><?php echo ($newdate3); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo $newdate4; ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo $newdate5; ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate6); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate7); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate8); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate10); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate11); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate12); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate13); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate14); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate15); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate16); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate17); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate18); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate19); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate20); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate21); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate22); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate23); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate24); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate25); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate26); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate27); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate28); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate29); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate30); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate31); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate32); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate33); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate34); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate35); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate36); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate37); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo ($newdate38); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate39); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate40); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate41); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate42); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate43); ?></td>
                    <td style="border: 1px solid #DDDDDD; vertical-align: middle; text-align:center;"><?php echo utf8_encode($newdate44); ?></td>
                </tr>
                <?php
                    ;}
                    include("cerrar.php");
                ?>
            </tbody>
        </table>
        <?php
        }
    }
?>