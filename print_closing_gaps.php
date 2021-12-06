<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php'); 
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        header('Content-Type: text/html; charset=UTF-8');

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
    
        $resultado = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                        V.PRIMERA_GRUPO,V.PRIMERA,VN.SEGUNDA,VN.SEGUNDA_DEP, V.PRIMERA_CEL,
                        CASE WHEN (V.PRIMERA_FAB ='ASTRAZENECA') THEN DATEADD(DAY,27,V.PRIMERA) ELSE DATEADD(DAY,20,V.PRIMERA) END AS 'FECHA_PARA_SEGUNDA',
                        CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN NULL ELSE 'FALLECIDO' END AS 'FALLECIDOS',
                        CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN NULL ELSE 'RECHAZO' END AS 'RECHAZO'
                        INTO TEMPORAL1 FROM VACUNADOS V
                        LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC
                        LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                        LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                        WHERE V.SEGUNDA IS NULL";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA, V.PRIMERA_CEL FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            AND V.PRIMERA_PROV = '$red'
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                            WHERE V.PRIMERA_PROV='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA, V.PRIMERA_CEL FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            AND V.PRIMERA_PROV='$red' AND V.PRIMERA_DIST='$dist'
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'";
     
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT V.PRIMERA_PROV,V.PRIMERA_DIST,V.TIPO_DOC, V.NUM_DOC,V.PRIMERA_PACIEN,V.PRIMERA_EDAD,V.PRIMERA_FAB,
                            V.PRIMERA_GRUPO,V.PRIMERA,V.FECHA_PARA_SEGUNDA, V.PRIMERA_CEL FROM TEMPORAL1 V WHERE FALLECIDOS IS NULL AND RECHAZO IS NULL AND SEGUNDA IS NULL
                            AND V.PRIMERA_PROV='$red' AND V.PRIMERA_DIST='$dist'
                            ORDER BY V.PRIMERA_PROV,V.PRIMERA_DIST
                            DROP TABLE TEMPORAL1";

            $resultado3 = "SELECT SUM (CASE WHEN (V.PRIMERA IS NULL) THEN 0 ELSE 1 END) AS 'CONTEO_TOTAL_PRIMERAS',
                            SUM (CASE WHEN (V.PRIMERA IS NOT NULL AND V.SEGUNDA IS NOT NULL) THEN 1 ELSE 0 END) AS 'DOSIS_COMPLETA',
                            SUM (CASE WHEN (VN.SEGUNDA IS NULL) THEN 0 ELSE 1 END) AS 'SEGUNDA_FUERA_REGION',
                            SUM (CASE WHEN (N.NUMERO_DOCUMENTO_FALLECIDO IS NULL) THEN 0 ELSE 1 END) AS 'FALLECIDOS',
                            SUM (CASE WHEN (R.NUM_DOC_PACIENTE IS NULL) THEN 0 ELSE 1 END) AS 'RECHAZO'
                            FROM VACUNADOS V 
                            LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC= VN.TIPO_DOC 
                            AND VN.SEGUNDA_DEP NOT IN('PASCO') AND VN.SEGUNDA IS NOT NULL
                            LEFT JOIN BD_DEFUNCION.dbo.NOMINAL_DEFUNCIONES N ON V.NUM_DOC = N.NUMERO_DOCUMENTO_FALLECIDO
                            LEFT JOIN RECHAZOS R ON V.NUM_DOC = R.NUM_DOC_PACIENTE AND R.RECHAZO = '2 DOSIS'
                            WHERE V.PRIMERA_PROV = '$red' AND V.PRIMERA_DIST='$dist'";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);
        $consulta2 = sqlsrv_query($conn6, $resultado2);
        $consulta3 = sqlsrv_query($conn6, $resultado3);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO CIERRE_BRECHAS "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
            $monday = date( 'd/m/Y', strtotime( 'monday this week' ) );

    ?>
     
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <table>
        <thead>
            <tr></tr>
            <tr class="text-center">
                <th colspan="12" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="12" style="font-size: 28px; border: 1px solid #3A3838;">Cierre de Brechas - Segunda Dosis</th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="12" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Celular</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Nombre Vacuna</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Grupo Edad</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Primera Dosis</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #e19f9f">Segunda Dosis Pendiente (Debio inmunizarse)</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta2)){
                    if(is_null ($consulta['PRIMERA_PROV']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['PRIMERA_PROV'] ;}
    
                    if(is_null ($consulta['PRIMERA_DIST']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['PRIMERA_DIST'];}
    
                    if(is_null ($consulta['TIPO_DOC']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['TIPO_DOC'];}
    
                    if(is_null ($consulta['NUM_DOC']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['NUM_DOC'];}
    
                    if(is_null ($consulta['PRIMERA_PACIEN']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['PRIMERA_PACIEN'];}
    
                    if(is_null ($consulta['PRIMERA_EDAD']) ){
                        $newdate8 = '  -'; }
                        else{
                    $newdate8 = $consulta['PRIMERA_EDAD'];}
    
                    if(is_null ($consulta['PRIMERA_FAB']) ){
                        $newdate9 = '  -'; }
                        else{
                    $newdate9 = $consulta['PRIMERA_FAB'];}
    
                    if(is_null ($consulta['PRIMERA_GRUPO']) ){
                        $newdate10 = '  -'; }
                        else{
                    $newdate10 = $consulta['PRIMERA_GRUPO'] ;}
    
                    if(is_null ($consulta['PRIMERA']) ){
                        $newdate11 = '  -'; }
                        else{
                        $newdate11 = $consulta['PRIMERA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['FECHA_PARA_SEGUNDA']) ){
                        $newdate12 = '  -'; }
                    else{
                        $newdate12 = $consulta['FECHA_PARA_SEGUNDA'] -> format('d/m/y');}

                    if(is_null ($consulta['PRIMERA_CEL']) ){
                        $newdate13 = '  -'; }
                    else{
                        $newdate13 = $consulta['PRIMERA_CEL'] ;}
    
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate3; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate4); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate5); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate7); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate13; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate10); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center; background: #e19f9f36;"><?php echo $newdate12; ?></td>
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