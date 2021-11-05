<?php 
    require('abrir.php');
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
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT * FROM VACUNADOS WHERE PRIMERA_PROV='$red' or SEGUNDA_PROV='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT * FROM VACUNADOS";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT * FROM VACUNADOS WHERE (PRIMERA_PROV='$red' or SEGUNDA_PROV='$red') AND (PRIMERA_DIST='$dist' OR SEGUNDA_DIST='$dist')";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);

        if(!empty($consulta1)){
            $ficheroExcel="DEIT_PASCO AVANCE_VACUNACION_NOMINAL "._date("d-m-Y", false, 'America/Lima').".xls";        
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");
    ?>
        <table>
            <thead>
                <tr class="text-center">
                    <th colspan="13" style="font-size: 28px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
                </tr>
                <tr></tr>
                <tr class="text-center">
                    <th colspan="13" style="font-size: 30px; border: 1px solid #3A3838;">AVANCE VACUNACIÓN NOMINAL</th>
                </tr>
                <tr></tr>
            </thead>
        </table> 
        <table>
            <thead>
                <tr class="font-12 text-center" style="background: #c9d0e2;">
                    <th style="border: 1px solid #DDDDDD;">#</th>
                    <th style="border: 1px solid #DDDDDD;">Provincia</th>
                    <th style="border: 1px solid #DDDDDD;">Distrito</th>
                    <th style="border: 1px solid #DDDDDD;">Tipo Documento</th>
                    <th style="border: 1px solid #DDDDDD;">Documento</th> 
                    <th style="border: 1px solid #DDDDDD;">Paciente</th> 
                    <th style="border: 1px solid #DDDDDD;">Tipo Vacuna</th>
                    <th style="border: 1px solid #DDDDDD;">Primera Dosis</th>
                    <th style="border: 1px solid #DDDDDD;">Grupo de Edad</th>
                    <th style="border: 1px solid #DDDDDD;">Edad</th>
                    <th style="border: 1px solid #DDDDDD;">Tipo Vacuna</th>
                    <th style="border: 1px solid #DDDDDD;">Segunda Dosis</th> 
                    <th style="border: 1px solid #DDDDDD;">Grupo de Edad</th>
                    <th style="border: 1px solid #DDDDDD;">Edad</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta1)){  
                        if(is_null ($consulta['PRIMERA_PROV']) ){
                            $newdate = $consulta['SEGUNDA_PROV'] ; }
                        else{
                            $newdate = $consulta['PRIMERA_PROV'] ;}
                
                        if(is_null ($consulta['PRIMERA_DIST']) ){
                            $newdate2 = $consulta['SEGUNDA_DIST'] ; }
                        else{
                            $newdate2 = $consulta['PRIMERA_DIST'];}
                
                        if(is_null ($consulta['TIPO_DOC']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['TIPO_DOC'];}
                
                        if(is_null ($consulta['NUM_DOC']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['NUM_DOC'];}
                
                        if(is_null ($consulta['PRIMERA_PACIEN']) ){
                            $newdate5 = $consulta['SEGUNDA_PACIEN']; }
                        else{
                            $newdate5 = $consulta['PRIMERA_PACIEN'];}
    
                        if(is_null ($consulta['PRIMERA_FAB']) ){
                            $newdate6 = '    -'; }
                        else{
                            $newdate6 = $consulta['PRIMERA_FAB'];}    
                
                        if(is_null ($consulta['PRIMERA']) ){
                            $newdate7 = '   -'; }
                        else{
                            $newdate7 = $consulta['PRIMERA'] -> format('d/m/y');;}
            
                        if(is_null ($consulta['PRIMERA_GRUPO']) ){
                            $newdate8 = '   -';}
                        else{
                            $newdate8 = $consulta['PRIMERA_GRUPO'];}
                
                        if(is_null ($consulta['PRIMERA_EDAD']) ){
                            $newdate9 = '   -';}
                        else{
                            $newdate9 = $consulta['PRIMERA_EDAD'];}
                
                        if(is_null ($consulta['SEGUNDA_FAB']) ){
                            $newdate10 = '    -'; }
                        else{
                            $newdate10 = $consulta['SEGUNDA_FAB'];}    
                    
                        if(is_null ($consulta['SEGUNDA']) ){
                            $newdate11 = '   -'; }
                        else{
                            $newdate11 = $consulta['SEGUNDA'] -> format('d/m/y');;}
                
                        if(is_null ($consulta['SEGUNDA_GRUPO']) ){
                            $newdate12 = '   -';}
                        else{
                            $newdate12 = $consulta['SEGUNDA_GRUPO'];}
                    
                        if(is_null ($consulta['SEGUNDA_EDAD']) ){
                            $newdate13 = '   -';}
                        else{
                            $newdate13 = $consulta['SEGUNDA_EDAD'];}
                ?>
                <tr class="text-center font-12">
                    <td style="border: 1px solid #DDDDDD;"><?php echo $i++; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate2); ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate3); ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate4; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate5; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate6); ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate7; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate8); ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate9; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate10; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo $newdate11; ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate12); ?></td>
                    <td style="border: 1px solid #DDDDDD;"><?php echo utf8_encode($newdate13); ?></td>
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