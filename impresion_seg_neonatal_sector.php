<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');   
    require('abrir4.php'); 
 
    if(isset($_POST["exportarCSV"])) {
        global $conex;
        ini_set("default_charset", "UTF-8");
        mb_internal_encoding("UTF-8");
        include('zone_setting.php');
        
        $sector = $_POST['sector'];
        $establecimiento = $_POST['establecimiento'];
        $mes = $_POST['mes2'];
        $anio = $_POST['anio2'];

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
        
        if (strlen($mes) == 1){
            $mes2 = '0'.$mes;
        }else{
            $mes2 = $mes;
        }

        $resultado = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item, Codigo_Unico 
                            into BDHIS_MINSA.dbo.atencionesneonatal1
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE ANIO='$anio' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";
        
        if(($sector != 'TODOS') and $establecimiento == 'TODOS'){
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND MONTH(FE_NACIDO)='$mes' AND Institucion='$sector'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";

        }
        else if ($establecimiento == 'TODOS' and $sector == 'TODOS') {
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND MONTH(FE_NACIDO)='$mes'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";
           
        }
        else if($establecimiento != 'TODOS'){
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND Ipress='$establecimiento' AND MONTH(FE_NACIDO)='$mes'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";

        }

        $resultado4 = "SELECT * FROM BDHIS_MINSA.dbo.TEMPORAL001
                        ORDER BY Institucion, PROV_EESS,DIST_EESS, Nombre_EESS
                        DROP TABLE BDHIS_MINSA.dbo.atencionesneonatal1
                        DROP TABLE BDHIS_MINSA.dbo.nacidoscnv1
                        DROP TABLE BDHIS_MINSA.dbo.TEMPORAL001";

        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta4)){
            $ficheroExcel="DEIT_PASCO SEGUIMIENTO_NEONATAL "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="10" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="10" style="font-size: 28px; border: 1px solid #3A3838;">Seguimiento Tamizaje Neonatal - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="10" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> y BD CNV con Fecha: <?php echo $monday; ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </thead>
    </table> 
    <table class="table table-hover">
        <thead>
            <tr class="font-12 text-center" style="background: #b5c2d6;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Institución</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Nombre ESS</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Número CNV</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Lugar de Nacimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Nacimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Lugar de Atendido</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta4)){
                    if(is_null ($consulta['Institucion']) ){
                        $newdate = '  -'; }
                        else{
                    $newdate = $consulta['Institucion'];}
    
                    if(is_null ($consulta['PROV_EESS']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['PROV_EESS'] ;}
    
                    if(is_null ($consulta['DIST_EESS']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['DIST_EESS'];}
    
                    if(is_null ($consulta['Nombre_EESS']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['Nombre_EESS'];}
    
                    if(is_null ($consulta['Nu_cnv']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['Nu_cnv'];}
    
                    if(is_null ($consulta['Lugar_Nacido']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['Lugar_Nacido'];}
    
                    if(is_null ($consulta['fecnacido']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['fecnacido'] -> format('d/m/y');}
    
                    if(is_null ($consulta['Fecha_Atencion']) ){
                        $newdate8 = '  -'; }
                        else{
                    $newdate8 = $consulta['Fecha_Atencion'] -> format('d/m/y');}
    
                    if(is_null ($consulta['ATENDIDO_EN']) ){
                        $newdate9 = '  -'; }
                        else{
                    $newdate9 = $consulta['ATENDIDO_EN'];}
    
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo
                    $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                    $data = utf8_encode($newdate4); 
                    $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                    if($pos == true){
                        $resultado = str_replace("+ë", "É", $data);
                        echo $resultado;
                    }else if($pos2 == true){
                        $resultado = str_replace("+ì", "Í", $data);
                        echo $resultado;
                    }else if($pos3 == true){
                        $resultado = str_replace("+ô", "Ó", $data);
                        echo $resultado;
                    }else if($pos4 == true){
                        $resultado = str_replace("+ü", "Á", $data);
                        echo $resultado;
                    }else{
                        $resultado = str_replace("+æ", "Ñ", $data);
                        echo $resultado;
                    }
                ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php
                    $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                    $data = utf8_encode($newdate9); 
                    $pos = strpos($data, $findme); $pos2 = strpos($data, $findme2); $pos3 = strpos($data, $findme3); $pos4 = strpos($data, $findme4);
                    if($pos == true){
                        $resultado = str_replace("+ë", "É", $data);
                        echo $resultado;
                    }else if($pos2 == true){
                        $resultado = str_replace("+ì", "Í", $data);
                        echo $resultado;
                    }else if($pos3 == true){
                        $resultado = str_replace("+ô", "Ó", $data);
                        echo $resultado;
                    }else if($pos4 == true){
                        $resultado = str_replace("+ü", "Á", $data);
                        echo $resultado;
                    }else{
                        $resultado = str_replace("+æ", "Ñ", $data);
                        echo $resultado;
                    }
                ?></td>
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