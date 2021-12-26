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
        $anio = $_POST['anio'];

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
            $mes = '0'.$mes;
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

        $resultado = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                            WHEN pn.NUM_DNI IS NOT NULL
                            THEN pn.NUM_DNI
                            ELSE pn.NUM_CNV
                            END,
                        CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_MADRE,' ', pn.NOMBRE_NINO) AS APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.NOMBRE_EESS AS ULTIMA_ATE_PN
                            into BDHIS_MINSA.dbo.PADRON_EVALUAR6
                        from NOMINAL_PADRON_NOMINAL AS pn
                        where YEAR (DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='$anio' and month(DATEADD(DAY,269,FECHA_NACIMIENTO_NINO))='$mes'
                        and mes='$anio$mes';
                        with c as ( select DOCUMENTO, nombre_dist, ROW_NUMBER() over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA.dbo.PADRON_EVALUAR6)
                        delete  from c
                        where duplicado >1";	

        $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                        A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,
                        Min(CASE WHEN (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='$anio' AND  EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'85018',
                        Min(CASE WHEN (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'D50X',
                        Min(CASE WHEN (Codigo_Item ='U310' AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'U310_SF1',
                        Min(CASE WHEN (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('6','7','8') AND Tipo_Edad='M' )THEN A.Fecha_Atencion ELSE NULL END)'SUPLE'
                        into BDHIS_MINSA.dbo.suple6
                        --select * from BDHIS_MINSA.dbo.suple6
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA AS A
                        WHERE
                            ((a.fecha_atencion> '$anio-05-01') and (a.fecha_atencion<= CONCAT('$anio-$mes-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes/$anio'),0)))))) AND
                            ( (Codigo_Item ='85018' AND Tipo_Diagnostico='D' AND ANIO='$anio' AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                            (Codigo_Item IN ('D509','D500','D649','D508') AND Tipo_Diagnostico='D'  AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) OR
                            (Codigo_Item IN('U310','99199.17') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) or
                            (Codigo_Item  IN('Z298','99199.17','99199.19') AND Tipo_Diagnostico='D' AND VALOR_LAB IN ('SF1','PO1','P01','1') AND EDAD_REG IN ('5','6','7','8') AND Tipo_Edad='M' ) )
                        GROUP BY A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento,
                        A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente				
                        ORDER BY Numero_Documento_Paciente asc, A.Nombre_Establecimiento";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                            pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                            pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                            s.D50X,s.U310_SF1,s.SUPLE
                            FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                            on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red'
                            order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                            DROP TABLE BDHIS_MINSA.dbo.suple6
                            DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO, pn.MENOR_VISITADO, PN.MENOR_ENCONTRADO, pn.NUM_DNI, pn.NUM_CNV,
                            pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente AS TIPO_DOC, APELLIDOS_NOMBRES,
                            pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN AS PN_ULTIMO_LUGAR, S.Nombre_Establecimiento AS ESTAB_ACTIVIDAD, s.[85018] HEMOGLOBINA,
                            s.D50X, s.U310_SF1, s.SUPLE
                            FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 AS s
                            on pn.DOCUMENTO=s.Numero_Documento_Paciente
                            order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO	   
                            DROP TABLE BDHIS_MINSA.dbo.suple6
                            DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";   
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT pn.NOMBRE_PROV PROVINCIA, pn.NOMBRE_DIST DISTRITO,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,DOCUMENTO, s.Abrev_Tipo_Doc_Paciente TIPO_DOC,APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.ULTIMA_ATE_PN PN_ULTIMO_LUGAR,S.Nombre_Establecimiento ESTAB_ACTIVIDAD,s.[85018] HEMOGLOBINA,
                        s.D50X,s.U310_SF1,s.SUPLE
                        FROM BDHIS_MINSA.dbo.PADRON_EVALUAR6 PN LEFT JOIN suple6 s
                        on pn.DOCUMENTO=s.Numero_Documento_Paciente where pn.NOMBRE_PROV='$red' AND pn.NOMBRE_DIST='$dist'
                        order by NOMBRE_PROV,NOMBRE_DIST,DOCUMENTO
                        DROP TABLE BDHIS_MINSA.dbo.suple6
                        DROP TABLE BDHIS_MINSA.dbo.PADRON_EVALUAR6";
        }
         
        $consulta2 = sqlsrv_query($conn2, $resultado);
        $consulta3 = sqlsrv_query($conn, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);
        
        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta4)){
            $ficheroExcel="DEIT_PASCO CG_FT_INICIO_OPORTUNO "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="18" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="18" style="font-size: 28px; border: 1px solid #3A3838;">Niños 6 a 8 Meses CG05 - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="18" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD Padrón Nominal con Fecha <?php echo $date_modify; ?> y BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
            </tr>
            <tr></tr>
        </thead>
    </table>
    <table class="table table-hover">
        <thead>
            <tr class="font-12 text-center" style="background: #e0eff5;">
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Provincia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Distrito</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #94cbe1;">Menor Visitado</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #94cbe1;">Menor Encontrado</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #94cbe1;">Número CNV</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha de Nacimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Apellidos y Nombres</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #94cbe1;">Tipo de Seguro</th> 
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #94cbe1;">PN Último Lugar</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Actividad Establecimiento (HIS)</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Dosaje de Hemoglobina</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">DX Anemia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tratamiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Suplementación</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta4)){                        
                    if(is_null ($consulta['PROVINCIA']) ){ $newdate3 = '  -'; }
                    else{ $newdate3 = $consulta['PROVINCIA'] ;}
    
                    if(is_null ($consulta['DISTRITO']) ){ $newdate4 = '  -'; }
                    else{ $newdate4 = $consulta['DISTRITO'];}
        
                    if(is_null ($consulta['MENOR_VISITADO']) ){ $newdate5 = '  -'; }
                    else{ $newdate5 = $consulta['MENOR_VISITADO'];}
        
                    if(is_null ($consulta['MENOR_ENCONTRADO']) ){ $newdate6 = '  -'; }
                    else{ $newdate6 = $consulta['MENOR_ENCONTRADO'];}
        
                    if(is_null ($consulta['NUM_CNV']) ){ $newdate8 = '  -'; }
                    else{ $newdate8 = $consulta['NUM_CNV'];}
    
                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ $newdate9 = '  -'; }
                    else{ $newdate9 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}                      
        
                    if(is_null ($consulta['DOCUMENTO']) ){ $newdate10 = '  -'; }
                    else{ $newdate10 = $consulta['DOCUMENTO'];}
                                
                    if(is_null ($consulta['TIPO_DOC']) ){ $newdate11 = '  -'; }
                    else{ $newdate11 = $consulta['TIPO_DOC'];}
        
                    if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ 
                        $newdate12 = '  -'; }
                    else{ $newdate12 = $consulta['APELLIDOS_NOMBRES'];}
        
                    if(is_null ($consulta['TIPO_SEGURO']) ){ $newdate13 = '  -'; }
                    else{ $newdate13 = $consulta['TIPO_SEGURO'];}
        
                    if(is_null ($consulta['PN_ULTIMO_LUGAR']) ){ $newdate14 = '  -'; }
                    else{ $newdate14 = $consulta['PN_ULTIMO_LUGAR'];}
        
                    if(is_null ($consulta['ESTAB_ACTIVIDAD']) ){ $newdate15 = '  -'; }
                    else{ $newdate15 = $consulta['ESTAB_ACTIVIDAD'];}
    
                    if(is_null ($consulta['HEMOGLOBINA']) ){ $newdate16 = '  -'; }
                    else{ $newdate16 = $consulta['HEMOGLOBINA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['D50X']) ){ $newdate17 = '  -'; }
                    else{ $newdate17 = $consulta['D50X'] -> format('d/m/y');}
            
                    if(is_null ($consulta['U310_SF1']) ){ $newdate18 = '  -'; }
                    else{ $newdate18 = $consulta['U310_SF1'] -> format('d/m/y');}
            
                    if(is_null ($consulta['SUPLE']) ){ $newdate19 = '  -'; }
                    else{ $newdate19 = $consulta['SUPLE'] -> format('d/m/y');}
                    
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate3; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate4; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_68_meses_body"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_68_meses_body"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_68_meses_body"><?php echo $newdate8; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php
                    $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                    $data = utf8_encode($newdate12); 
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
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="fields_68_meses_body"><?php echo $newdate13; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_68_meses_body"><?php
                    $findme = "+ë"; $findme2 = "+ì"; $findme3 = "+ô"; $findme4 = "+ü";
                    $data = utf8_encode($newdate14); 
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
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate15); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate16; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate17; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate18; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate19; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;">
                    <?php
                        // SUPLEMENTACION      D50X     U3010_SF1
                        if(!is_null ($consulta['HEMOGLOBINA']) && !is_null ($consulta['D50X']) && !is_null ($consulta['U310_SF1']) && is_null ($consulta['SUPLE'])){
                            if($consulta['HEMOGLOBINA'] == $consulta['D50X'] && $consulta['HEMOGLOBINA'] == $consulta['U310_SF1']){
                                echo "Si";
                            }else{
                                $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                $nuevo_formato_anemia = date_format($consulta['D50X'], "d-m-Y");
                                $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                $fecha_anemia = strtotime(date_format($consulta['D50X'], "d-m-Y"));
                                $fecha_tratamiento = strtotime(date_format($consulta['U310_SF1'], "d-m-Y"));
                                $fecha_anemia_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_anemia."+ 7 days")));
    
                                if($fecha_anemia < $fecha_hemoglobina_7_dias && $fecha_anemia > $nuevo_formato_hemoglobina) {
                                    echo "Si";
                                }
                                else{
                                    echo "No";
                                }
                            }
                        }
                        // SUPLEMENTACION     Y     HEMOGLOBINA
                        else if(!is_null ($consulta['HEMOGLOBINA']) && is_null ($consulta['D50X']) && is_null ($consulta['U310_SF1']) && !is_null ($consulta['SUPLE'])){
                            if($consulta['HEMOGLOBINA'] == $consulta['SUPLE']){
                                echo "Si";
                            }
                            else{
                                $nuevo_formato_hemoglobina = date_format($consulta['HEMOGLOBINA'], "d-m-Y");
                                $fecha_hemoglobina_7_dias = strtotime(date("d-m-Y", strtotime($nuevo_formato_hemoglobina."+ 7 days")));
                                $fecha_suplementacion = strtotime(date_format($consulta['SUPLE'], "d-m-Y"));
                                if($fecha_suplementacion < $fecha_hemoglobina_7_dias && $fecha_suplementacion > $nuevo_formato_hemoglobina) {
                                    echo "Si";
                                }
                                else{
                                    echo "No";
                                }
                            }
                        }
                        else{
                            echo "No";
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