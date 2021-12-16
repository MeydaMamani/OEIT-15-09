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
        
        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO'; }
        elseif ($red_1 == 4) { $redt = 'PASCO'; }
    
        if($dist_1 == 'CONSTITUCIÓN') {
            $dist_1 = 'CONSTITUCION';
        }
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.TIPO_DOC,V.NUM_DOC,V.SEGUNDA_PACIEN,
                            V.SEGUNDA_EDAD,V.SEGUNDA_CEL,V.SEGUNDA,V.SEGUNDA_GRUPO,V.SEGUNDA_FAB,
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_3RA_DOSIS',
                            CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FELLECIDO',
                            CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO 3RA DOSIS' END AS 'RECHAZO',
                            CASE WHEN (V.TERCERA_DEP IS NULL) THEN VN.TERCERA_DEP ELSE V.TERCERA_DEP END AS 'DEPARTAMENTO',
                            CASE WHEN (V.TERCERA_PROV IS NULL) THEN VN.TERCERA_PROV ELSE V.TERCERA_PROV END AS 'PROVINCIA',
                            CASE WHEN (V.TERCERA_DIST IS NULL) THEN VN.TERCERA_DIST ELSE V.TERCERA_DIST END AS 'DISTRITO',
                            CASE WHEN (V.TERCERA_EESS IS NULL) THEN VN.TERCERA_EESS ELSE V.TERCERA_EESS END AS 'ESTABLECIMIENTO',
                            CASE WHEN (V.TERCERA_GRUPO IS NULL) THEN VN.TERCERA_GRUPO ELSE V.TERCERA_GRUPO END AS 'GRUPO DE RIESGO',
                            CASE WHEN (V.TERCERA_FAB IS NULL) THEN VN.TERCERA_FAB ELSE V.TERCERA_FAB END AS 'FABRICANTE'
                            FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC = VN.NUM_DOC AND V.TIPO_DOC=VN.TIPO_DOC AND VN.TERCERA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '3 DOSIS'
                            WHERE V.SEGUNDA IS NOT NULL AND DATEADD(DAY,150,V.SEGUNDA) < GETDATE()
                            AND V.SEGUNDA_PROV='$red' 
                            ORDER BY V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.SEGUNDA_PACIEN";

}
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.TIPO_DOC,V.NUM_DOC,V.SEGUNDA_PACIEN,
                            V.SEGUNDA_EDAD,V.SEGUNDA_CEL,V.SEGUNDA,V.SEGUNDA_GRUPO,V.SEGUNDA_FAB,
                            CASE WHEN (V.TERCERA IS NULL) THEN VN.TERCERA ELSE V.TERCERA END AS 'FECHA_3RA_DOSIS',
                            CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FELLECIDO',
                            CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO 3RA DOSIS' END AS 'RECHAZO',
                            CASE WHEN (V.TERCERA_DEP IS NULL) THEN VN.TERCERA_DEP ELSE V.TERCERA_DEP END AS 'DEPARTAMENTO',
                            CASE WHEN (V.TERCERA_PROV IS NULL) THEN VN.TERCERA_PROV ELSE V.TERCERA_PROV END AS 'PROVINCIA',
                            CASE WHEN (V.TERCERA_DIST IS NULL) THEN VN.TERCERA_DIST ELSE V.TERCERA_DIST END AS 'DISTRITO',
                            CASE WHEN (V.TERCERA_EESS IS NULL) THEN VN.TERCERA_EESS ELSE V.TERCERA_EESS END AS 'ESTABLECIMIENTO',
                            CASE WHEN (V.TERCERA_GRUPO IS NULL) THEN VN.TERCERA_GRUPO ELSE V.TERCERA_GRUPO END AS 'GRUPO DE RIESGO',
                            CASE WHEN (V.TERCERA_FAB IS NULL) THEN VN.TERCERA_FAB ELSE V.TERCERA_FAB END AS 'FABRICANTE'
                            FROM VACUNADOS V
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC = VN.NUM_DOC AND V.TIPO_DOC=VN.TIPO_DOC AND VN.TERCERA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '3 DOSIS'
                            WHERE V.SEGUNDA IS NOT NULL AND DATEADD(DAY,150,V.SEGUNDA) < GETDATE()
                            AND V.SEGUNDA_PROV='$red' AND V.SEGUNDA_DIST='$dist'
                            ORDER BY V.SEGUNDA_PROV,V.SEGUNDA_DIST,V.SEGUNDA_EESS,V.SEGUNDA_PACIEN";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);

        if(!empty($consulta1)){
            $ficheroExcel="DEIT_PASCO CRUCE 2DA Y 3ERA DOSIS "._date("d-m-Y", false, 'America/Lima').".xls";
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
            <th colspan="19" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="19" style="font-size: 28px; border: 1px solid #3A3838;">CRUCE DE SEGUNDA Y TERCERA DOSIS</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="19" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
        </tr>
        <tr></tr>
    </thead>
</table> 
<table class="table table-hover">
    <thead>
        <tr class="text-center font-13 border" style="background: #e0eff5;">
            <th id="patient"></th>
            <th colspan="5" class="border" id="patient">Paciente</th>
            <th colspan="6" class="border" id="first_dose">Segunda Dosis</th>
            <th colspan="7" class="border" id="second_dose">Tercera Dosis</th>
        </tr>
        <tr class="text-center font-12" style="background: #e0eff5;">
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">#</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Tipo Documento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Documento</th> 
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Paciente</th> 
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Edad</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="patient">Celular</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Provincia</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Distrito</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Establecimiento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Fecha de Vacunación</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Nombre Vacuna</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="first_dose">Grupo de Riesgo</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Provincia</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Distrito</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Establecimiento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Fecha de Vacunación</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Nombre Vacuna</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Fallecido</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="second_dose">Rechazo</th>            
        </tr>
    </thead>
    <tbody>
        <?php 
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta1)){  
                if(is_null ($consulta['TIPO_DOC']) ){
                    $newdate = '  -'; }
                else{
                    $newdate = $consulta['TIPO_DOC'];}
    
                if(is_null ($consulta['NUM_DOC']) ){
                    $newdate2 = '  -'; }
                else{
                    $newdate2 = $consulta['NUM_DOC'];}
    
                if(is_null ($consulta['SEGUNDA_PACIEN']) ){
                    $newdate3 = '  -'; }
                else{
                    $newdate3 = $consulta['SEGUNDA_PACIEN'];}
    
                if(is_null ($consulta['SEGUNDA_EDAD']) ){
                    $newdate4 = '  -'; }
                else{
                    $newdate4 = $consulta['SEGUNDA_EDAD'];}
    
                if(is_null ($consulta['SEGUNDA_CEL']) ){
                    $newdate5 = '  -'; }
                else{
                    $newdate5 = $consulta['SEGUNDA_CEL'];}
    
                if(is_null ($consulta['SEGUNDA_PROV']) ){
                    $newdate6 = '  -'; }
                else{
                    $newdate6 = $consulta['SEGUNDA_PROV'];}
    
                if(is_null ($consulta['SEGUNDA_DIST']) ){
                    $newdate7 = '  -'; }
                else{
                    $newdate7 = $consulta['SEGUNDA_DIST'];}
    
                if(is_null ($consulta['SEGUNDA_EESS']) ){
                    $newdate8 = '  -'; }
                else{
                    $newdate8 = $consulta['SEGUNDA_EESS'];}
                
                if(is_null ($consulta['SEGUNDA']) ){
                    $newdate9 = '  -'; }
                else{
                    $newdate9 = $consulta['SEGUNDA']  -> format('d/m/y');}
    
                if(is_null ($consulta['SEGUNDA_FAB']) ){
                    $newdate10 = '  -'; }
                else{
                    $newdate10 = $consulta['SEGUNDA_FAB'];}
    
                if(is_null ($consulta['SEGUNDA_GRUPO']) ){
                    $newdate11 = '  -'; }
                else{
                    $newdate11 = $consulta['SEGUNDA_GRUPO'];}
    
                if(is_null ($consulta['PROVINCIA']) ){
                    $newdate12 = '  -'; }
                else{
                    $newdate12 = $consulta['PROVINCIA'];}
    
                if(is_null ($consulta['DISTRITO']) ){
                    $newdate13 = '  -'; }
                else{
                    $newdate13 = $consulta['DISTRITO'];}
    
                if(is_null ($consulta['ESTABLECIMIENTO']) ){
                    $newdate14 = '  -'; }
                else{
                    $newdate14 = $consulta['ESTABLECIMIENTO'];}
    
                if(is_null ($consulta['FECHA_3RA_DOSIS']) ){
                    $newdate15 = '  -'; }
                else{
                    $newdate15 = $consulta['FECHA_3RA_DOSIS'] -> format('d/m/y');}
    
                if(is_null ($consulta['FABRICANTE']) ){
                    $newdate16 = '  -'; }
                else{
                    $newdate16 = $consulta['FABRICANTE'];}
    
                if(is_null ($consulta['FELLECIDO']) ){
                    $newdate17 = '  -'; }
                else{
                    $newdate17 = $consulta['FELLECIDO'];}
    
                if(is_null ($consulta['RECHAZO']) ){
                    $newdate18 = '  -'; }
                else{
                    $newdate18 = $consulta['RECHAZO'];}
    
        ?>
        <tr class="text-center font-12" id="table_fed">
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate2; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate6; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate8); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php  
                $resultado = str_replace("anios", "años", $newdate11);
                echo $resultado;
            ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate13; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate14); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate15); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate16; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate17; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate18; ?></td>
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