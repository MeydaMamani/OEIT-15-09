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
        
        $resultado = "SELECT num_cnv,nombre_prov,nombre_dist,tipo_seguro,fecha_nacimiento_nino, apellido_paterno_nino,
                        apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                        into  padron_nino_cnv1
                        from nominal_padron_nominal
                        where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2';
                        with c as ( select num_cnv, nombre_dist, ROW_NUMBER() 
                                over(partition by num_cnv order by num_cnv) as duplicado
                        from dbo.padron_nino_cnv1)
                        delete  from c
                        where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' AND Provnacido in ('PASCO', 'OXAPAMPA', 'DANIEL ALCIDES CARRION')
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT C.Periodo, DATEADD(DAY,59,C.FECNACIDO) mide, C.SECTOR, C.Provnacido, C.Distnacido,C.Establecimiento, 
                                p.MENOR_ENCONTRADO,FECNACIDO,Numcnv, CONCAT(P.APELLIDO_PATERNO_NINO,' ',P.APELLIDO_MATERNO_NINO,' ',P.NOMBRE_NINO)NOMBRES_MENOR,C.PESO, C.SEMANAGESTACION, 'SI' PREMATURO,
                                T.Fecha_Atencion SUPLEMENTADO,T.Tipo_Doc_Paciente, P.TIPO_SEGURO, p.NOMBRE_EESS SE_ATIENDE               
                                from BD_CNV.dbo.nominal_trama_cnv c INNER JOIN BD_PADRON_NOMINAL.dbo.padron_nino_cnv1 p
                                ON  C.NUMCNV=p.num_cnv
                                AND (c.SEMANAGESTACION IN ('34','35','36') OR (c.PESO>'1499' AND c.PESO<'2500')) AND YEAR(c.FECNACIDO)='2021' 
                                    AND MONTH(DATEADD(DAY,59,c.FECNACIDO))='$mes' and Provnacido = '$red' and Distnacido = '$dist'
                                LEFT join BDHIS_MINSA.dbo.T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                on c.Numcnv=t.Numero_Documento_Paciente
                                AND edad_reg='1' and t.Tipo_Edad ='M' and
                                            Codigo_Item in ('Z298','U310','99199.17') AND Valor_Lab IN ('SF1','P01','PO1')
                                DROP TABLE  BD_PADRON_NOMINAL.DBO.PADRON_NINO_CNV1
                                DROP TABLE padron_nino_cnv1";
        }

        $consulta1 = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO CG_FT_PREMATUROS "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="13" style="font-size: 28px; border: 1px solid #3A3838;">Niños Prematuros CG03 - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="13" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD CNV con Fecha: <?php echo $monday; ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </thead>
    </table> 
    <table>
        <thead>
            <tr class="font-12 text-center" style="background: #e0eff5;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Establecimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Apellidos y Nombres</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Fecha Nacido</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Menor Encontrado</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Prematuro</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Suplementado</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Tipo Seguro</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Se Atiende</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                if(is_null ($consulta['Provnacido']) ){
                    $newdate2 = '  -'; }
                    else{
                $newdate2 = $consulta['Provnacido'];}
            
                if(is_null ($consulta['Distnacido']) ){
                    $newdate3 = '  -'; }
                    else{
                $newdate3 = $consulta['Distnacido'] ;}
            
                if(is_null ($consulta['Establecimiento']) ){
                    $newdate4 = '  -'; }
                    else{
                $newdate4 = $consulta['Establecimiento'];}
            
                if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                    $newdate5 = '  -'; }
                    else{
                $newdate5 = $consulta['MENOR_ENCONTRADO'];}
            
                if(is_null ($consulta['FECNACIDO']) ){
                    $newdate6 = '  -'; }
                    else{
                $newdate6 = $consulta['FECNACIDO'] -> format('d/m/y');}
            
                if(is_null ($consulta['Numcnv']) ){
                    $newdate7 = '  -'; }
                    else{
                $newdate7 = $consulta['Numcnv'];}
            
                if(is_null ($consulta['NOMBRES_MENOR']) ){
                    $newdate8 = '  -'; }
                    else{
                $newdate8 = $consulta['NOMBRES_MENOR'];}
            
                if(is_null ($consulta['PREMATURO']) ){
                    $newdate10 = '  -'; }
                    else{
                $newdate10 = $consulta['PREMATURO'];}
            
                if(is_null ($consulta['SUPLEMENTADO']) ){
                    $newdate11 = 'No'; }
                    else{
                $newdate11 = 'Si';}
            
                if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                    $newdate12 = '  -'; }
                    else{
                $newdate12 = $consulta['Tipo_Doc_Paciente'];}
            
                if(is_null ($consulta['TIPO_SEGURO']) ){
                    $newdate13 = '  -'; }
                    else{
                $newdate13 = $consulta['TIPO_SEGURO'];}
            
                if(is_null ($consulta['SE_ATIENDE']) ){
                    $newdate14 = '  -'; }
                    else{
                $newdate14 = $consulta['SE_ATIENDE'];}
            
        ?>
        <tr class="text-center font-12">
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo ($newdate4); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate7; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate8); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate6; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate5; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate10; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php if($newdate11 == 'Si'){ echo "<span class='badge bg-correct'>$newdate11</span>"; }
            else{ echo "<span class='badge bg-incorrect'>$newdate11</span>"; } ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate13; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="color_prematuro_body"><?php echo utf8_encode($newdate14); ?></td>
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