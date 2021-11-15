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

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes;
        }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $redt = 'PASCO';  }
        
        $resultado = "SELECT distinct(Numero_Documento_Paciente), 'PREMATURO' PREMATURO
                        INTO bdhis_minsa_externo.dbo.PREMATURO1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where anio='2021' and codigo_item in ('P0711','P0712','P0713','P073')";

        $resultado2 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                            WHEN pn.NUM_DNI IS NOT NULL
                            THEN pn.NUM_DNI
                            ELSE pn.NUM_CNV
                        END,
                        CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.NOMBRE_EESS ULTIMA_ATE_PN INTO BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                        from NOMINAL_PADRON_NOMINAL pn
                        where YEAR  (DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='$mes'
                        and mes='2021$mes2';
                        with c as ( select DOCUMENTO,  ROW_NUMBER() 
                                over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 )
                        delete  from c
                        where duplicado >1";

        $resultado3 = "SELECT Numero_Documento_Paciente, Fecha_Atencion, Tipo_Doc_Paciente,Edad_Dias_Paciente_FechaAtencion
                        INTO BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        -- WHERE ANIO='2021' AND (Fecha_Atencion>='2021-07-20' and Fecha_Atencion<='2021-08-31')
                        WHERE ANIO='2021' AND (Fecha_Atencion >= CONVERT(DATE, DATEADD(dd, -110, CONCAT('2021$mes2', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))) 
                        and Fecha_Atencion<=CONCAT('2021-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))
                        AND Tipo_Diagnostico='D' AND (Codigo_Item IN ('Z298','99199.17') AND VALOR_LAB IN ('SF1','PO1','P01')) AND EDAD_REG in ('3','4') AND Tipo_Edad='M'
                        ORDER BY Fecha_Atencion;
                        with c as ( select numero_documento_paciente,  ROW_NUMBER() 
                                over(partition by numero_documento_paciente order by numero_documento_paciente) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41)
                        delete  from c
                        where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from PADRON_EVALUAR41 pn
                    LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red'
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                                pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                                P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                            from PADRON_EVALUAR41 pn
                            LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                            LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from PADRON_EVALUAR41 pn
                    LEFT JOIN PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red' AND pn.NOMBRE_DIST ='$dist'
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }

        $consulta2 = sqlsrv_query($conn, $resultado);
        $consulta3 = sqlsrv_query($conn2, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);
        $consulta5 = sqlsrv_query($conn4, $resultado4);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta5)){
            $ficheroExcel="DEIT_PASCO CG_FT_SUPLEMENTACION_NIÑOS_4_MESES "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="16" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="16" style="font-size: 28px; border: 1px solid #3A3838;">Niños 4 Meses CG04 - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="16" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> y BD Padrón Nominal con Fecha <?php echo $date_modify; ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </thead>
    </table> 
    <table class="table table-hover">
        <thead>
            <tr class="text-center font-12" style="background: #c9d0e2; vertical-align: middle;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Establecimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">Menor Visitado</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">Menor Encontrado</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">DNI</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">Nùmero CNV</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha de Nacimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">Tipo Seguro</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Apellidos y Nombres</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Prematuro</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Suplementado (días)</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #638bb3;">Ultima Ate PN</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta5)){  
                    if(is_null ($consulta['NOMBRE_PROV']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['NOMBRE_PROV'] ;}
            
                    if(is_null ($consulta['NOMBRE_DIST']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['NOMBRE_DIST'];}
            
                    if(is_null ($consulta['EESS_ATENCION']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['EESS_ATENCION'];}
            
                    if(is_null ($consulta['MENOR_VISITADO']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['MENOR_VISITADO'];}
            
                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['MENOR_ENCONTRADO'];}
            
                    if(is_null ($consulta['NUM_DNI']) ){
                        $newdate8 = '  -'; }
                        else{
                    $newdate8 = $consulta['NUM_DNI'];}
        
                    if(is_null ($consulta['NUM_CNV']) ){
                        $newdate9 = '  -'; }
                        else{
                    $newdate9 = $consulta['NUM_CNV'];}
            
                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                        $newdate10 = '  -'; }
                        else{
                    $newdate10 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
            
                    if(is_null ($consulta['DOCUMENTO']) ){
                        $newdate11 = '  -'; }
                        else{ 
                        $newdate11 = $consulta['DOCUMENTO'];}
                                    
                    if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                        $newdate12 = '  -'; }
                    else{
                        $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
            
                    if(is_null ($consulta['PREMATURO']) ){
                        $newdate13 = '  -'; }
                        else{
                        $newdate13 = $consulta['PREMATURO'];}
            
                    if(is_null ($consulta['SUPLEMENTADO']) ){
                        $newdate14 = '  -'; }
                        else{
                        $newdate14 = $consulta['SUPLEMENTADO'];}
            
                    if(is_null ($consulta['ULTIMA_ATE_PN']) ){
                        $newdate15 = '  -'; }
                        else{
                        $newdate15 = $consulta['ULTIMA_ATE_PN'];}
            
                    if(is_null ($consulta['TIPO_SEGURO']) ){
                        $newdate16 = '  -'; }
                        else{
                        $newdate16 = $consulta['TIPO_SEGURO'];}
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate3; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate4); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate5); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_4_meses_body"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_4_meses_body"><?php if ($newdate7 == 'SI') {
                        echo "Si"; }else{ echo "No"; }                                                                                          
                  ?>
                </td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_4_meses_body"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_4_meses_body"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_4_meses_body"><?php echo $newdate16; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate12); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate13; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate14; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_4_meses_body"><?php echo utf8_encode($newdate15); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php
                    if($newdate13 != 'PREMATURO'){ 
                        foreach (range(110, 130) as $numero) {
                            if($numero == $newdate14){
                                echo "Si";
                            }
                        }
                        if(is_null($consulta['SUPLEMENTADO'])){
                            echo "No";
                        }
                        if(!is_null($consulta['SUPLEMENTADO']) && ($newdate14<110 || $newdate14>130)){
                            echo "Observado";
                         }
                    }
                    else{
                        echo "No Mide";
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