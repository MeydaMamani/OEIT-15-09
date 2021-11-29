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

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes;
        }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $redt = 'PASCO';  }
        
        $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, NOMBRE_EESS_NACIMIENTO, 'DOCUMENTO' = CASE 
                            WHEN NUM_DNI IS NOT NULL
                            THEN NUM_DNI
                            ELSE NUM_CNV
                        END,
                       tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                       apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                       into  bdhis_minsa.dbo.padronneonatal
                       from nominal_padron_nominal
                       where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                       AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                       with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                       from bdhis_minsa.dbo.padronneonatal )
                       delete  from c
                       where duplicado >1";

        $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                        into bdhis_minsa.dbo.atenciones
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.NOMBRE_NINO As apellidos_nino, 
                                p.MENOR_ENCONTRADO,p.NOMBRE_EESS_NACIMIENTO, NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red'
                                ORDER BY p.nombre_prov, p.nombre_dist
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.NOMBRE_NINO As apellidos_nino, 
                                p.MENOR_ENCONTRADO, p.NOMBRE_EESS_NACIMIENTO, NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes'
                                ORDER BY p.nombre_prov, p.nombre_dist
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if($dist_1 != 'TODOS'){
	        $dist=$dist_1;
            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.NOMBRE_NINO As apellidos_nino, 
                                p.MENOR_ENCONTRADO,p.NOMBRE_EESS_NACIMIENTO, NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red' AND nombre_dist='$dist'
                                ORDER BY p.nombre_prov, p.nombre_dist
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO CG_FT_TMZ_NEONATAL "._date("d-m-Y", false, 'America/Lima').".xls";
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
                    <th colspan="13" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
                </tr>
                <tr></tr>
                <tr class="text-center">
                    <th colspan="13" style="font-size: 28px; border: 1px solid #3A3838;">Tamizaje Neonatal CG03 - <?php echo $nombre_mes; ?></th>
                </tr>
                <tr></tr>
                <tr>
                    <th colspan="13" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
                </tr>
                <tr></tr>
            </thead>
        </table> 
        <table class="table table-hover">
            <thead>
                <tr class="text-center font-13 border">
                    <th class="border" style="border: 1px solid #DDDDDD; font-size: 15px;"></th>
                    <th colspan="9" class="border" style="background: #AED6F1; border: 1px solid #DDDDDD; font-size: 15px;">Padrón Nominal</th>
                    <th colspan="3" class="border" style="background: #AED6F1; border: 1px solid #DDDDDD; font-size: 15px;">His Minsa</th>
                </tr>
                <tr class="text-center font-12 border" style="background: #AED6F1;">
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Apellidos y Nombres</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha de Nacimiento</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Nombre ESS</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #dae9f3;">Menor Encontrado</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #dae9f3;">Tipo de Seguro</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #91b9d5;">Nombre ESS Nacimiento</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Lugar de Tamizaje (HIS)</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
                </tr>
            </thead>
            <tbody>
                <?php  
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta3)){  
                        if(is_null ($consulta['nombre_prov']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['nombre_prov'] ;}
    
                        if(is_null ($consulta['nombre_dist']) ){
                            $newdate1 = '  -'; }
                        else{
                            $newdate1 = $consulta['nombre_dist'] ;}
            
                        if(is_null ($consulta['documento']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['documento'];}
    
                        if(is_null ($consulta['apellidos_nino']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['apellidos_nino'];}
    
                        if(is_null ($consulta['fecha_nacimiento_nino']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['fecha_nacimiento_nino'] -> format('d/m/y');}
    
                        if(is_null ($consulta['NOMBRE_EESS']) ){
                            $newdate5 = '  -'; }
                        else{
                            $newdate5 = $consulta['NOMBRE_EESS'];}
    
                        if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                            $newdate6 = '  -'; }
                        else{
                            $newdate6 = $consulta['MENOR_ENCONTRADO'];}
    
                        if(is_null ($consulta['tipo_seguro']) ){
                            $newdate7 = '  -'; }
                        else{
                            $newdate7 = $consulta['tipo_seguro'];}
                                            
                        if(is_null ($consulta['NOMBRE_EESS_NACIMIENTO']) ){
                            $newdate8 = '  -'; }
                        else{
                            $newdate8 = $consulta['NOMBRE_EESS_NACIMIENTO'];}
                            
                        if(is_null ($consulta['Lugar_TMZ']) ){
                            $newdate9 = '  -'; }
                        else{
                            $newdate9 = $consulta['Lugar_TMZ'];}
    
                        if(is_null ($consulta['Fecha_Atencion']) ){
                            $newdate10 = '  -'; }
                        else{
                            $newdate10 = $consulta['Fecha_Atencion'] -> format('d/m/y');}
    
                ?>
                <tr class="font-12 text-center">
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate1); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate2; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate4; ?></td>                               
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate5); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_neonatal_body"><?php echo $newdate6; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_neonatal_body"><?php echo $newdate7; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="color_neonatal_body2"><?php echo utf8_encode($newdate8); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate9; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;">
                    <?php
                        if(is_null($consulta['Fecha_Atencion']) || is_null($consulta['fecha_nacimiento_nino'])){
                        echo "<span class='badge bg-incorrect'>No Cumple</span>";
                        }else {
                        $fecha_atencion  = new DateTime(date_format($consulta['Fecha_Atencion'], "d-m-Y"));
                        $fecha_nacimiento = new DateTime(date_format($consulta['fecha_nacimiento_nino'], "d-m-Y"));
                        $intvl = $fecha_nacimiento->diff($fecha_atencion);
                            if($intvl->days <= 6 && $intvl->days >=0){
                            echo "<span class='badge bg-correct'>Cumple</span>";
                            }else if($intvl->days > 6){
                            echo "<span class='badge bg-observed'>Observado</span>";
                            }
                        }
                    ?>
                    </td>
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