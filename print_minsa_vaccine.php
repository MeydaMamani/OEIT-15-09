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
        
        $resultado = "SELECT P.*,
                        CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                        CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS'
                        INTO TBDOSIS FROM PADRON_MAYOR_12_ANIOS_19_11  P
                        LEFT JOIN VACUNADOS V
                        ON P.NUM_DOC=V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC
                        LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN
                        ON P.NUM_DOC=VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT CONCAT(P.APELLIDO_PATERNO, ' ', P.APELLIDO_MATERNO, ' ', P.NOMBRES) AS FULL_NAME, P.*, 
                            CASE WHEN (V.FECHA_VACUNACION IS NULL) THEN VN.FECHA_VACUNACION 
                            ELSE V.FECHA_VACUNACION END AS 'TERCERA DOSIS'
                            FROM TBDOSIS P 
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V ON 
                            P.NUM_DOC = V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC AND V.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN
                            ON P.NUM_DOC = VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC AND VN.DOSIS_APLICADA='3ª dosis'
                            WHERE PROVINCIA = '$red'
                            DROP TABLE TBDOSIS";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT CONCAT(P.APELLIDO_PATERNO, ' ', P.APELLIDO_MATERNO, ' ', P.NOMBRES) AS FULL_NAME, P.*, 
                            CASE WHEN (V.FECHA_VACUNACION IS NULL) THEN VN.FECHA_VACUNACION 
                            ELSE V.FECHA_VACUNACION END AS 'TERCERA DOSIS'
                            FROM TBDOSIS P 
                            LEFT JOIN T_CONSOLIDADO_VACUNA_COVID_PASCO V ON 
                            P.NUM_DOC = V.NUM_DOC AND P.TIPO_DOC = V.TIPO_DOC AND V.DOSIS_APLICADA='3ª dosis'
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.T_CONSOLIDADO_VACUNA_COVID VN
                            ON P.NUM_DOC = VN.NUM_DOC AND P.TIPO_DOC = VN.TIPO_DOC AND VN.DOSIS_APLICADA='3ª dosis'
                            WHERE PROVINCIA = '$red' AND DISTRITO = '$dist'
                            DROP TABLE TBDOSIS";

        }

        $consulta1 = sqlsrv_query($conn6, $resultado);
        $consulta2 = sqlsrv_query($conn6, $resultado2);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO VACUNA PADRON MINSA "._date("d-m-Y", false, 'America/Lima').".xls";
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
            <th colspan="13" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="13" style="font-size: 28px; border: 1px solid #3A3838;">VACUNAS POR PADRÓN MINSA</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="13" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
        </tr>
        <tr></tr>
    </thead>
</table>
<table class="table table-hover">
    <thead>
        <tr class="text-center font-12" style="background: #c9d0e2;">
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Número Documento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Paciente</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Edad</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Nacimiento</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Celular</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Ubigeo Reniec</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Primera Dosis</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Segunda Dosis</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Tercera Dosis</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                if(is_null ($consulta['PROVINCIA']) ){
                    $newdate3 = '  -'; }
                    else{
                $newdate3 = $consulta['PROVINCIA'] ;}
    
                if(is_null ($consulta['DISTRITO']) ){
                    $newdate4 = '  -'; }
                    else{
                $newdate4 = $consulta['DISTRITO'];}
    
                if(is_null ($consulta['TIPO_DOC']) ){
                    $newdate5 = '  -'; }
                    else{
                $newdate5 = $consulta['TIPO_DOC'];}
    
                if(is_null ($consulta['NUM_DOC']) ){
                    $newdate6 = '  -'; }
                    else{
                $newdate6 = $consulta['NUM_DOC'];}
    
                if(is_null ($consulta['FULL_NAME']) ){
                    $newdate7 = '  -'; }
                    else{
                $newdate7 = $consulta['FULL_NAME'];}
    
                if(is_null ($consulta['EDAD']) ){
                    $newdate8 = '  -'; }
                    else{
                $newdate8 = $consulta['EDAD'];}
    
                if(is_null ($consulta['FECHA_NACIMIENTO']) ){
                    $newdate9 = '  -'; }
                    else{
                $newdate9 = $consulta['FECHA_NACIMIENTO'] -> format('d/m/y');}
    
                if(is_null ($consulta['CELULAR']) ){
                    $newdate10 = '  -'; }
                    else{
                $newdate10 = $consulta['CELULAR'] ;}
    
                if(is_null ($consulta['UBIGEO_RENIEC']) ){
                    $newdate11 = '  -'; }
                    else{
                    $newdate11 = $consulta['UBIGEO_RENIEC'];}
    
                if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) ){
                    $newdate12 = '  -'; }
                else{
                    $newdate12 = $consulta['FECHA_PRIMERA_DOSIS'] -> format('d/m/y');}
    
                if(is_null ($consulta['FECHA_SEGUNDA_DOSIS']) ){
                    $newdate13 = '  -'; }
                else{
                    $newdate13 = $consulta['FECHA_SEGUNDA_DOSIS'] -> format('d/m/y');}
    
                if(is_null ($consulta['TERCERA DOSIS']) ){
                    $newdate14 = '  -'; }
                else{
                    $newdate14 = $consulta['TERCERA DOSIS'] -> format('d/m/y');}
     
                // CONDICIONAL
                if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) || is_null($consulta['FECHA_SEGUNDA_DOSIS']) || is_null($consulta['TERCERA DOSIS'])){

        ?>
        <tr class="text-center font-12">
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate3; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate4); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate5); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate7); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate10); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
        </tr>
        <?php
                }
            ;}
            include("cerrar.php");
        ?>
    </tbody>
</table>
<?php
        }
    }
?>