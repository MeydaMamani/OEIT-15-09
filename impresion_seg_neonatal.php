<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');   
    require('abrir4.php'); 
    require('abrir5.php'); 
    require('abrir6.php'); 
 
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

        if (strlen($mes) == 1){
            $mes2 = '0'.$mes;
        }else{
            $mes2 = $mes;
        }

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
        
        $resultado = "SELECT Financiador_Parto, PROV_EESS, DIST_EESS, NU_CNV, FE_NACIDO, Prov_Madre
                        into BDHIS_MINSA.dbo.nacidoscnv
                        FROM CNV_LUGARNACIDO_PASCO 
                        WHERE YEAR(FE_NACIDO)='2021'";

        $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item
                        into atencionesneonatal
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.NU_CNV=a.Numero_Documento_Paciente
                            where n.FE_NACIDO>='2021-$mes2-01' AND Provnacido='$red'
                            DROP TABLE BDHIS_MINSA.dbo.nacidoscnv
                            DROP TABLE BDHIS_MINSA.dbo.atencionesneonatal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.NU_CNV=a.Numero_Documento_Paciente
                            where n.FE_NACIDO>='2021-$mes2-01'
                            DROP TABLE BDHIS_MINSA.dbo.nacidoscnv
                            DROP TABLE BDHIS_MINSA.dbo.atencionesneonatal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.NU_CNV=a.Numero_Documento_Paciente
                            where n.FE_NACIDO>='2021-$mes2-01' AND Provnacido='$red' AND Distnacido='$dist'
                            DROP TABLE BDHIS_MINSA.dbo.nacidoscnv
                            DROP TABLE BDHIS_MINSA.dbo.atencionesneonatal";
        }

        $consulta1 = sqlsrv_query($conn3, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        
        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO SEGUIMIENTO TAMIZAJE NEONATAL "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                        <th colspan="9" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
                    </tr>
                    <tr></tr>
                    <tr class="text-center">
                        <th colspan="9" style="font-size: 28px; border: 1px solid #3A3838;">Seguimiento Tamizaje Neonatal - <?php echo $nombre_mes; ?></th>
                    </tr>
                    <tr></tr>
                    <tr>
                        <th colspan="9" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
                    </tr>
                    <tr></tr>
                </thead>
            </table> 
            <table class="table table-hover">
                    <thead>
                        <tr class="font-12 text-center" style="background: #e0eff5;"> 
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Financiador</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Número CNV</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Nacido</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia - Madre</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Atención</th>
                            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Atendido</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                           $i=1;
                            while ($consulta = sqlsrv_fetch_array($consulta3)){
                                if(is_null ($consulta['Financiador_Parto']) ){
                                    $newdate2 = '  -'; }
                                    else{
                                $newdate2 = $consulta['Financiador_Parto'] ;}

                                if(is_null ($consulta['PROV_EESS']) ){
                                    $newdate3 = '  -'; }
                                    else{
                                $newdate3 = $consulta['PROV_EESS'];}

                                if(is_null ($consulta['DIST_EESS']) ){
                                    $newdate4 = '  -'; }
                                    else{
                                $newdate4 = $consulta['DIST_EESS'];}

                                if(is_null ($consulta['NU_CNV']) ){
                                    $newdate5 = '  -'; }
                                    else{
                                $newdate5 = $consulta['NU_CNV'];}

                                if(is_null ($consulta['FE_NACIDO']) ){
                                    $newdate6 = '  -'; }
                                    else{
                                $newdate6 = $consulta['FE_NACIDO'];}

                                if(is_null ($consulta['Prov_Madre']) ){
                                    $newdate7 = '  -'; }
                                    else{
                                $newdate7 = $consulta['Prov_Madre'];}

                                if(is_null ($consulta['Fecha_Atencion']) ){
                                    $newdate8 = '  -'; }
                                    else{
                                $newdate8 = $consulta['Fecha_Atencion']-> format('d/m/y');}

                                if(is_null ($consulta['ATENDIDO_EN']) ){
                                    $newdate9 = '  -'; }
                                    else{
                                $newdate9 = $consulta['ATENDIDO_EN'];}

                        ?>
                        <tr class="text-center font-12">
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate4; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
                            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate9); ?></td>
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