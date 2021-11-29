<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');   
    require('abrir4.php'); 
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

        if($mes == 1){ $nombre_mes = 'Enero'; }
        else if($mes == 2){ $nombre_mes = 'Febrero'; }
        else if($mes == 3){ $nombre_mes = 'Marzo'; }
        else if($mes == 4){ $nombre_mes = 'Abril'; }
        else if($mes == 5){ $nombre_mes = 'Mayo'; }
        else if($mes == 6){ $nombre_mes = 'Junio'; }
        else if($mes == 7){ $nombre_mes = 'Julio'; }
        else if($mes == 8){ $nombre_mes = 'Agosto'; }
        else if($mes == 9){ $nombre_mes = 'Setiembre'; }
        else if($mes == 10){ $nombre_mes = 'Octubre'; }
        else if($mes == 11){ $nombre_mes = 'Noviembre'; }
        else if($mes == 12){ $nombre_mes = 'Diciembre'; }

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
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021' AND Provincia_Establecimiento='$red'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021' AND Provincia_Establecimiento='$red' AND  Distrito_Establecimiento='$dist'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        
        $consulta1 = sqlsrv_query($conn, $resultado);        

        if(!empty($consulta1)){
            $ficheroExcel="DEIT_PASCO Cantidad de Profesionales EPP(2020 FED) "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="8" style="font-size: 28px; border: 1px solid #3A3838;">Cantidad de Profesionales EPP (2020 FED) - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="8" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </thead>
    </table> 
    <table class="table table-hover">
        <thead>
            <tr class="font-12 text-center" style="background: #f1f5e0;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Código Ipress</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Establecimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Personal</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Profesión</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta1)){
                    if(is_null ($consulta['Provincia_Establecimiento']) ){
                        $newdate = '  -'; }
                        else{
                    $newdate = $consulta['Provincia_Establecimiento'];}
    
                    if(is_null ($consulta['Distrito_Establecimiento']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['Distrito_Establecimiento'] ;}
    
                    if(is_null ($consulta['Codigo_Unico']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['Codigo_Unico'] ;}
    
                    if(is_null ($consulta['Nombre_Establecimiento']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['Nombre_Establecimiento'];}
    
                    if(is_null ($consulta['Numero_Documento_Personal']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['Numero_Documento_Personal'];}
    
                    if(is_null ($consulta['PERSONAL']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['PERSONAL'];}
    
                    if(is_null ($consulta['Descripcion_Profesion']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['Descripcion_Profesion'];}
    
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate3); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate4; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
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