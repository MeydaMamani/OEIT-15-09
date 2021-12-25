<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        // header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        
        if ($red_1 == 1) {
            $red = 'DANIEL ALCIDES CARRION';
        }
        elseif ($red_1 == 2) {
            $red = 'OXAPAMPA';
        }
        elseif ($red_1 == 3) {
            $red = 'PASCO';
        }
        elseif ($red_1 == 4) {
            $redt = 'PASCO';
        }
    
        if($dist_1 == 'CONSTITUCIÓN') {
            $dist_1 = 'CONSTITUCION';
        }
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT CASE WHEN (V.PRIMERA_PROV IS NULL) THEN VN.PRIMERA_PROV ELSE V.PRIMERA_PROV END AS 'PROVINCIA_UNO',
                            CASE WHEN (V.PRIMERA_DIST IS NULL) THEN VN.PRIMERA_DIST ELSE V.PRIMERA_DIST END AS 'DISTRITO_UNO',
                            CASE WHEN (V.SEGUNDA_PROV IS NULL) THEN VN.SEGUNDA_PROV ELSE V.SEGUNDA_PROV END AS 'PROVINCIA_DOS',
                            CASE WHEN (V.SEGUNDA_DIST IS NULL) THEN VN.SEGUNDA_DIST ELSE V.SEGUNDA_DIST END AS 'DISTRITO_DOS', V.TIPO_DOC, V.NUM_DOC,
                            CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                            CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_TERCERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN DATEADD(DAY,90,VN.SEGUNDA) ELSE DATEADD(DAY,90,V.SEGUNDA) END AS 'FECHA_PARA_3RA_DOSIS',
                            CASE WHEN (V.SEGUNDA_CEL IS NULL) THEN V.PRIMERA_CEL ELSE V.SEGUNDA_CEL END AS 'NUM_CELULAR',
                            CASE WHEN (V.PRIMERA_FAB IS NULL) THEN VN.PRIMERA_FAB ELSE V.PRIMERA_FAB END AS 'NOMBRE_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_FAB IS NULL) THEN VN.SEGUNDA_FAB ELSE V.SEGUNDA_FAB END AS 'NOMBRE_SEGUNDA_DOSIS',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN VN.SEGUNDA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD',
                            CASE WHEN (V.SEGUNDA_GRUPO IS NULL) THEN VN.SEGUNDA_GRUPO ELSE V.SEGUNDA_GRUPO END AS 'GRUPO_RIESGO'
                            INTO T1 FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC
                            WHERE (V.PRIMERA_PROV = '$red' or V.SEGUNDA_PROV = '$red')";

            $resultado2 = "SELECT * FROM T1 WHERE FECHA_PARA_3RA_DOSIS < DATEADD(DAY,7,GETDATE())  AND FECHA_TERCERA_DOSIS IS NULL
                            ORDER BY TIPO_DOC, NUM_DOC, NOMBRE_PACIENTE
                            DROP TABLE T1";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT CASE WHEN (V.PRIMERA_PROV IS NULL) THEN VN.PRIMERA_PROV ELSE V.PRIMERA_PROV END AS 'PROVINCIA_UNO',
                            CASE WHEN (V.PRIMERA_DIST IS NULL) THEN VN.PRIMERA_DIST ELSE V.PRIMERA_DIST END AS 'DISTRITO_UNO',
                            CASE WHEN (V.SEGUNDA_PROV IS NULL) THEN VN.SEGUNDA_PROV ELSE V.SEGUNDA_PROV END AS 'PROVINCIA_DOS',
                            CASE WHEN (V.SEGUNDA_DIST IS NULL) THEN VN.SEGUNDA_DIST ELSE V.SEGUNDA_DIST END AS 'DISTRITO_DOS', V.TIPO_DOC, V.NUM_DOC,
                            CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                            CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_TERCERA_DOSIS',
                            CASE WHEN (V.SEGUNDA IS NULL) THEN DATEADD(DAY,90,VN.SEGUNDA) ELSE DATEADD(DAY,90,V.SEGUNDA) END AS 'FECHA_PARA_3RA_DOSIS',
                            CASE WHEN (V.SEGUNDA_CEL IS NULL) THEN V.PRIMERA_CEL ELSE V.SEGUNDA_CEL END AS 'NUM_CELULAR',
                            CASE WHEN (V.PRIMERA_FAB IS NULL) THEN VN.PRIMERA_FAB ELSE V.PRIMERA_FAB END AS 'NOMBRE_PRIMERA_DOSIS',
                            CASE WHEN (V.SEGUNDA_FAB IS NULL) THEN VN.SEGUNDA_FAB ELSE V.SEGUNDA_FAB END AS 'NOMBRE_SEGUNDA_DOSIS',
                            CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN VN.SEGUNDA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD',
                            CASE WHEN (V.SEGUNDA_GRUPO IS NULL) THEN VN.SEGUNDA_GRUPO ELSE V.SEGUNDA_GRUPO END AS 'GRUPO_RIESGO'
                            INTO T1 FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC
                            WHERE (V.PRIMERA_DIST = '$dist' or V.SEGUNDA_DIST = '$dist')";

            $resultado2 = "SELECT * FROM T1 WHERE FECHA_PARA_3RA_DOSIS < DATEADD(DAY,7,GETDATE())  AND FECHA_TERCERA_DOSIS IS NULL
                            ORDER BY TIPO_DOC, NUM_DOC, NOMBRE_PACIENTE
                            DROP TABLE T1";
        }

        $consulta2 = sqlsrv_query($conn6, $resultado);
        $consulta3 = sqlsrv_query($conn6, $resultado2);

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO APTOS_PARA_TERCERA_DOSIS "._date("d-m-Y", false, 'America/Lima').".xls";
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");

?>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<table>
    <thead>
        <tr></tr>
        <tr class="text-center">
            <th colspan="16" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="16" style="font-size: 28px; border: 1px solid #3A3838;">APTOS PARA TERCERA DOSIS</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="16" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
        </tr>
        <tr></tr>
    </thead>
</table> 
<table class="table table-hover">
    <thead>
        <tr class="text-center font-13 border" style="background: #c9d0e2;">
            <th id="patient"></th>
            <th colspan="4" style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Paciente</th>
            <th colspan="4" style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Primera Dosis</th>
            <th colspan="6" style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Segunda Dosis</th>
            <th colspan="1" style="border: 1px solid #DDDDDD; font-size: 15px;">3era Dosis</th>
        </tr>
        <tr class="text-center font-12" style="background: #c9d0e2;">
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">#</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Tipo Documento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Documento</th> 
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Paciente</th> 
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Celular</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Provincia</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Distrito</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Fecha de Vacunación</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Nombre Vacuna</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Provincia</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Distrito</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Fecha de Vacunación</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Nombre Vacuna</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Edad</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Grupo de Riesgo</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha de Vacunación</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta3)){  
                if(is_null ($consulta['TIPO_DOC']) ){
                    $newdate = '  -'; }
                else{
                    $newdate = $consulta['TIPO_DOC'];}
    
                if(is_null ($consulta['NUM_DOC']) ){
                    $newdate2 = '  -'; }
                else{
                    $newdate2 = $consulta['NUM_DOC'];}
    
                if(is_null ($consulta['NOMBRE_PACIENTE']) ){
                    $newdate3 = '  -'; }
                else{
                    $newdate3 = $consulta['NOMBRE_PACIENTE'];}
    
                if(is_null ($consulta['NUM_CELULAR']) ){
                    $newdate4 = '  -'; }
                else{
                    $newdate4 = $consulta['NUM_CELULAR'];}
    
                if(is_null ($consulta['PROVINCIA_UNO']) ){
                    $newdate5 = '  -'; }
                else{
                    $newdate5 = $consulta['PROVINCIA_UNO'];}
    
                if(is_null ($consulta['DISTRITO_UNO']) ){
                    $newdate6 = '  -'; }
                else{
                    $newdate6 = $consulta['DISTRITO_UNO'];}
    
                if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) ){
                    $newdate7 = '  -'; }
                else{
                    $newdate7 = $consulta['FECHA_PRIMERA_DOSIS'] -> format('d/m/y');}
    
                if(is_null ($consulta['NOMBRE_PRIMERA_DOSIS']) ){
                    $newdate8 = '  -'; }
                else{
                    $newdate8 = $consulta['NOMBRE_PRIMERA_DOSIS'];}
                
                if(is_null ($consulta['PROVINCIA_DOS']) ){
                    $newdate9 = '  -'; }
                else{
                    $newdate9 = $consulta['PROVINCIA_DOS'];}
    
                if(is_null ($consulta['DISTRITO_DOS']) ){
                    $newdate10 = '  -'; }
                else{
                    $newdate10 = $consulta['DISTRITO_DOS'];}
    
                if(is_null ($consulta['FECHA_SEGUNDA_DOSIS']) ){
                    $newdate11 = '  -'; }
                else{
                    $newdate11 = $consulta['FECHA_SEGUNDA_DOSIS'] -> format('d/m/y');}
    
                if(is_null ($consulta['NOMBRE_SEGUNDA_DOSIS']) ){
                    $newdate12 = '  -'; }
                else{
                    $newdate12 = $consulta['NOMBRE_SEGUNDA_DOSIS'];}
    
                if(is_null ($consulta['EDAD']) ){
                    $newdate13 = '  -'; }
                else{
                    $newdate13 = $consulta['EDAD'];}
    
                if(is_null ($consulta['GRUPO_RIESGO']) ){
                    $newdate14 = '  -'; }
                else{
                    $newdate14 = $consulta['GRUPO_RIESGO'];}
    
                if(is_null ($consulta['FECHA_PARA_3RA_DOSIS']) ){
                    $newdate15 = '  -'; }
                else{
                    $newdate15 = $consulta['FECHA_PARA_3RA_DOSIS'] -> format('d/m/y');}
    
        ?>
        <tr class="text-center font-12" id="table_fed">
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate2; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate13; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate14); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_brechas_body"><?php echo utf8_encode($newdate15); ?></td>
        </tr>
        <?php
            ;}              
            sqlsrv_close($conn6);
        ?>
    </tbody>
</table>
<?php
        }
    }
?>