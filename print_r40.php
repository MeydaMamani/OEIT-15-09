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
        $establecimiento = $_POST['establecimiento'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        $profession = $_POST['profession'];

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

        if($red_1 == 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS'){
            $resultado = "SELECT rp.Descripcion_Sector AS SECTOR, rp.Descripcion_Disa AS DISA, rp.Provincia_Establecimiento AS RED, rp.Distrito_Establecimiento AS MICRORED, rp.Nombre_Establecimiento AS EESS,
                            rp.Abrev_Tipo_Doc_Personal AS TIPO_DOC, rp.Numero_Documento_Personal AS NUM_DOC, CONCAT(rp.Apellido_Paterno_Personal, ' ', rp.Apellido_Materno_Personal, ', ', rp.Nombres_Personal)
                            AS full_name, rp.Fecha_Nacimiento_Personal AS FECHA_NACIMIENTO, rp.Descripcion_Condicion AS CONDICION, rp.Descripcion_Profesion AS PROFESION,
                            rp.Descripcion_Colegio AS COLEGIO, rp.Descripcion_Ups AS UPS, rp.ANIO, rp.MES, RP.DIA, RP.FECHA_ATENCION,	
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Establecimiento IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R', 'C') ) THEN 1 ELSE 0 END) ATENC,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND_SER_TOTAL,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N') ) THEN 1 ELSE 0 END) NUEVO,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('C') ) THEN 1 ELSE 0 END) CONTI,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('R') ) THEN 1 ELSE 0 END) REING,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'APP%' ) THEN 1 ELSE 0 END) APP,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'AAA%' ) THEN 1 ELSE 0 END) AAA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA rp WHERE rp.Id_Correlativo_Item=1 AND rp.Id_Correlativo_Lab=1  
                            AND YEAR(Fecha_Atencion)='$anio' AND MONTH(Fecha_Atencion)='$mes' AND Id_Profesion='$profession'
                            GROUP BY rp.Descripcion_Sector, rp.Descripcion_Disa, rp.Provincia_Establecimiento, rp.Distrito_Establecimiento, rp.Nombre_Establecimiento, rp.Abrev_Tipo_Doc_Personal, rp.Numero_Documento_Personal,
                            rp.Apellido_Paterno_Personal, rp.Apellido_Materno_Personal, rp.Nombres_Personal, rp.Fecha_Nacimiento_Personal, rp.Descripcion_Condicion, rp.Descripcion_Profesion,
                            rp.Descripcion_Colegio, rp.Descripcion_Ups, rp.Anio, rp.Mes, rp.Dia, RP.Fecha_Atencion
                            ORDER BY Descripcion_Sector, Descripcion_Disa, Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS') {
            $resultado = "SELECT rp.Descripcion_Sector AS SECTOR, rp.Descripcion_Disa AS DISA, rp.Provincia_Establecimiento AS RED, rp.Distrito_Establecimiento AS MICRORED, rp.Nombre_Establecimiento AS EESS,
                            rp.Abrev_Tipo_Doc_Personal AS TIPO_DOC, rp.Numero_Documento_Personal AS NUM_DOC, CONCAT(rp.Apellido_Paterno_Personal, ' ', rp.Apellido_Materno_Personal, ', ', rp.Nombres_Personal)
                            AS full_name, rp.Fecha_Nacimiento_Personal AS FECHA_NACIMIENTO, rp.Descripcion_Condicion AS CONDICION, rp.Descripcion_Profesion AS PROFESION,
                            rp.Descripcion_Colegio AS COLEGIO, rp.Descripcion_Ups AS UPS, rp.ANIO, rp.MES, RP.DIA, RP.FECHA_ATENCION,	
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Establecimiento IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R', 'C') ) THEN 1 ELSE 0 END) ATENC,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND_SER_TOTAL,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N') ) THEN 1 ELSE 0 END) NUEVO,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('C') ) THEN 1 ELSE 0 END) CONTI,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('R') ) THEN 1 ELSE 0 END) REING,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'APP%' ) THEN 1 ELSE 0 END) APP,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'AAA%' ) THEN 1 ELSE 0 END) AAA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA rp WHERE rp.Id_Correlativo_Item=1 AND rp.Id_Correlativo_Lab=1  
                            AND YEAR(Fecha_Atencion)='$anio' AND MONTH(Fecha_Atencion)='$mes' AND Id_Profesion='$profession' AND Provincia_Establecimiento='$red'
                            GROUP BY rp.Descripcion_Sector, rp.Descripcion_Disa, rp.Provincia_Establecimiento, rp.Distrito_Establecimiento, rp.Nombre_Establecimiento, rp.Abrev_Tipo_Doc_Personal, rp.Numero_Documento_Personal,
                            rp.Apellido_Paterno_Personal, rp.Apellido_Materno_Personal, rp.Nombres_Personal, rp.Fecha_Nacimiento_Personal, rp.Descripcion_Condicion, rp.Descripcion_Profesion,
                            rp.Descripcion_Colegio, rp.Descripcion_Ups, rp.Anio, rp.Mes, rp.Dia, RP.Fecha_Atencion
                            ORDER BY Descripcion_Sector, Descripcion_Disa, Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
        }
        else if($dist_1 != 'TODOS' and $establecimiento == 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT rp.Descripcion_Sector AS SECTOR, rp.Descripcion_Disa AS DISA, rp.Provincia_Establecimiento AS RED, rp.Distrito_Establecimiento AS MICRORED, rp.Nombre_Establecimiento AS EESS,
                            rp.Abrev_Tipo_Doc_Personal AS TIPO_DOC, rp.Numero_Documento_Personal AS NUM_DOC, CONCAT(rp.Apellido_Paterno_Personal, ' ', rp.Apellido_Materno_Personal, ', ', rp.Nombres_Personal)
                            AS full_name, rp.Fecha_Nacimiento_Personal AS FECHA_NACIMIENTO, rp.Descripcion_Condicion AS CONDICION, rp.Descripcion_Profesion AS PROFESION,
                            rp.Descripcion_Colegio AS COLEGIO, rp.Descripcion_Ups AS UPS, rp.ANIO, rp.MES, RP.DIA, RP.FECHA_ATENCION,	
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Establecimiento IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R', 'C') ) THEN 1 ELSE 0 END) ATENC,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND_SER_TOTAL,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N') ) THEN 1 ELSE 0 END) NUEVO,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('C') ) THEN 1 ELSE 0 END) CONTI,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('R') ) THEN 1 ELSE 0 END) REING,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'APP%' ) THEN 1 ELSE 0 END) APP,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'AAA%' ) THEN 1 ELSE 0 END) AAA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA rp WHERE rp.Id_Correlativo_Item=1 AND rp.Id_Correlativo_Lab=1  
                            AND YEAR(Fecha_Atencion)='$anio' AND MONTH(Fecha_Atencion)='$mes' AND Id_Profesion='$profession' AND Distrito_Establecimiento='$dist'
                            GROUP BY rp.Descripcion_Sector, rp.Descripcion_Disa, rp.Provincia_Establecimiento, rp.Distrito_Establecimiento, rp.Nombre_Establecimiento, rp.Abrev_Tipo_Doc_Personal, rp.Numero_Documento_Personal,
                            rp.Apellido_Paterno_Personal, rp.Apellido_Materno_Personal, rp.Nombres_Personal, rp.Fecha_Nacimiento_Personal, rp.Descripcion_Condicion, rp.Descripcion_Profesion,
                            rp.Descripcion_Colegio, rp.Descripcion_Ups, rp.Anio, rp.Mes, rp.Dia, RP.Fecha_Atencion
                            ORDER BY Descripcion_Sector, Descripcion_Disa, Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";

        }
        else if($dist_1 != 'TODOS' and $establecimiento != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT rp.Descripcion_Sector AS SECTOR, rp.Descripcion_Disa AS DISA, rp.Provincia_Establecimiento AS RED, rp.Distrito_Establecimiento AS MICRORED, rp.Nombre_Establecimiento AS EESS,
                            rp.Abrev_Tipo_Doc_Personal AS TIPO_DOC, rp.Numero_Documento_Personal AS NUM_DOC, CONCAT(rp.Apellido_Paterno_Personal, ' ', rp.Apellido_Materno_Personal, ', ', rp.Nombres_Personal)
                            AS full_name, rp.Fecha_Nacimiento_Personal AS FECHA_NACIMIENTO, rp.Descripcion_Condicion AS CONDICION, rp.Descripcion_Profesion AS PROFESION,
                            rp.Descripcion_Colegio AS COLEGIO, rp.Descripcion_Ups AS UPS, rp.ANIO, rp.MES, RP.DIA, RP.FECHA_ATENCION,	
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Establecimiento IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R', 'C') ) THEN 1 ELSE 0 END) ATENC,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N', 'R') ) THEN 1 ELSE 0 END) ATEND_SER_TOTAL,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('N') ) THEN 1 ELSE 0 END) NUEVO,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('C') ) THEN 1 ELSE 0 END) CONTI,
                            SUM(CASE WHEN (rp.Id_Paciente IS NOT NULL AND rp.Id_Condicion_Servicio IN ('R') ) THEN 1 ELSE 0 END) REING,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'APP%' ) THEN 1 ELSE 0 END) APP,
                            SUM(CASE WHEN (rp.Id_Paciente LIKE 'AAA%' ) THEN 1 ELSE 0 END) AAA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA rp WHERE rp.Id_Correlativo_Item=1 AND rp.Id_Correlativo_Lab=1  
                            AND YEAR(Fecha_Atencion)='$anio' AND MONTH(Fecha_Atencion)='$mes' AND Id_Profesion='$profession' AND Distrito_Establecimiento='$dist' AND Provincia_Establecimiento='$red' AND Nombre_Establecimiento='$establecimiento'
                            GROUP BY rp.Descripcion_Sector, rp.Descripcion_Disa, rp.Provincia_Establecimiento, rp.Distrito_Establecimiento, rp.Nombre_Establecimiento, rp.Abrev_Tipo_Doc_Personal, rp.Numero_Documento_Personal,
                            rp.Apellido_Paterno_Personal, rp.Apellido_Materno_Personal, rp.Nombres_Personal, rp.Fecha_Nacimiento_Personal, rp.Descripcion_Condicion, rp.Descripcion_Profesion,
                            rp.Descripcion_Colegio, rp.Descripcion_Ups, rp.Anio, rp.Mes, rp.Dia, RP.Fecha_Atencion
                            ORDER BY Descripcion_Sector, Descripcion_Disa, Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
        }
  
        $consulta2 = sqlsrv_query($conn, $resultado);

        $consult_profession = "SELECT distinct(Id_Profesion), Descripcion_Profesion from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Id_Profesion is not null
                                ORDER BY Id_Profesion, Descripcion_Profesion";
    
        $result_profession = sqlsrv_query($conn, $consult_profession);

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO R40 "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
            header('Content-Type: text/html; charset=UTF-8');
?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table>
    <thead>
        <tr></tr>
        <tr class="text-center">
            <th colspan="20" style="font-size: 28px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="20" style="font-size: 26px; border: 1px solid #3A3838;">R40</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <td colspan="2" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><b> Provincia / Distrito: </b></td>
            <td colspan="2" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><?php echo $red, ' / ', $dist_1; ?></td>
            <td colspan="1"></td>
            <td colspan="2" style="font-size: 15px; text-align: center; border: 1em solid #ddd;"><b>Establecimiento: </b></td>
            <td colspan="2" style="font-size: 15px; text-align: center; border: 1em solid #ddd;"><?php echo $establecimiento; ?></td>
            <td colspan="1"></td>
            <td colspan="1" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><b>Año / Mes: </b></td>
            <td colspan="1" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><?php echo $anio, ' / ', $nombre_mes; ?></td>
            <td colspan="1"></td>
            <td colspan="2" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><b>Profesión:</b></td>
            <td colspan="5" style="font-size: 15px; text-align: center; border: 1px solid #ddd;"><?php 
                while ($consulta = sqlsrv_fetch_array($result_profession)){
                    $id = $consulta['Id_Profesion'];
                    if($id == $profession){
                        echo utf8_encode($consulta['Descripcion_Profesion']);
                    }
                }
            ?></td>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="20" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
        </tr>
        <tr></tr>
    </thead>
</table> 
<table class="table table-hover">
    <thead>
        <tr class="text-center font-12" style="background: #D9E1F2; color: #203764; vertical-align: middle;">
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">DISTRITO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">PROVINCIA</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">ESTABLECIMIENTO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">TIPO DOCUMENTO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">DOCUMENTO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">APELLIDOS Y NOMBRES</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">FECHA NACIMIENTO</th> 
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">CONDICIÓN</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">COLEGIO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">UPS</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">FECHA ATENCIÓN</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">ATENDIDO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">ATENCIÓN</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">ATEN SERV TOTAL</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">NUEVO</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">CONTI</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">REING</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">APP</th>
            <th rowspan="2" style="border: 1px solid #DDDDDD; font-size: 15px;">AAA</th>
        </tr>
    </thead>
    <tbody>
        <tr></tr>
        <?php  
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){  
                if(is_null ($consulta['RED']) ){
                    $newdate1 = '  -'; }
                    else{
                $newdate1 = $consulta['RED'] ;}
        
                if(is_null ($consulta['MICRORED']) ){
                    $newdate2 = '  -'; }
                    else{
                $newdate2 = $consulta['MICRORED'];}
        
                if(is_null ($consulta['EESS']) ){
                    $newdate3 = '  -'; }
                    else{
                $newdate3 = $consulta['EESS'];}
        
                if(is_null ($consulta['TIPO_DOC']) ){
                    $newdate4 = '  -'; }
                    else{
                $newdate4 = $consulta['TIPO_DOC'];}
        
                if(is_null ($consulta['NUM_DOC']) ){
                    $newdate5 = '  -'; }
                    else{
                $newdate5 = $consulta['NUM_DOC'];}
        
                if(is_null ($consulta['full_name']) ){
                    $newdate6 = '  -'; }
                    else{
                $newdate6 = $consulta['full_name'];}
    
                if(is_null ($consulta['FECHA_NACIMIENTO']) ){
                    $newdate7 = '  -'; }
                    else{
                $newdate7 = $consulta['FECHA_NACIMIENTO'] -> format('d/m/y');}
        
                if(is_null ($consulta['CONDICION']) ){
                    $newdate8 = '  -'; }
                    else{
                $newdate8 = $consulta['CONDICION'];}
        
                if(is_null ($consulta['COLEGIO']) ){
                    $newdate10 = '  -'; }
                else{
                    $newdate10 = $consulta['COLEGIO'];}
        
                if(is_null ($consulta['UPS']) ){
                    $newdate11 = '  -'; }
                else{
                    $newdate11 = $consulta['UPS'];}
        
                if(is_null ($consulta['FECHA_ATENCION']) ){
                    $newdate12 = '  -'; }
                else{
                    $newdate12 = $consulta['FECHA_ATENCION'] -> format('d/m/y');}
        
                if(is_null ($consulta['ATEND']) ){
                    $newdate13 = '  -'; }
                else{
                    $newdate13 = $consulta['ATEND'];}
        
                if(is_null ($consulta['ATENC']) ){
                    $newdate14 = '  -'; }
                    else{
                    $newdate14 = $consulta['ATENC'];}

                if(is_null ($consulta['ATEND_SER_TOTAL']) ){
                    $newdate15 = '  -'; }
                else{
                    $newdate15 = $consulta['ATEND_SER_TOTAL'];}

                if(is_null ($consulta['NUEVO']) ){
                    $newdate16 = '  -'; }
                else{
                    $newdate16 = $consulta['NUEVO'];}

                if(is_null ($consulta['CONTI']) ){
                    $newdate17 = '  -'; }
                else{
                    $newdate17 = $consulta['CONTI'];}

                if(is_null ($consulta['REING']) ){
                    $newdate18 = '  -'; }
                else{
                    $newdate18 = $consulta['REING'];}

                if(is_null ($consulta['APP']) ){
                    $newdate19 = '  -'; }
                else{
                    $newdate19 = $consulta['APP'];}

                if(is_null ($consulta['AAA']) ){
                    $newdate20 = '  -'; }
                else{
                    $newdate20 = $consulta['AAA'];}
        ?>
        <tr class="text-center font-12">
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate1; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate6); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate13; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate14; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate15; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate16; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate17; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate18; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate19; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate20; ?></td>
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