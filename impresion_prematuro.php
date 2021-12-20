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
        
        $resultado = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,NOMBRE_EESS, NUM_CNV,NUM_DNI,
                        CASE WHEN (NUM_CNV IS NULL AND NUM_DNI IS NULL)  THEN 'NO TIENE'
                                WHEN NUM_CNV=NUM_DNI                        THEN NUM_DNI
                                WHEN NUM_CNV<>NUM_DNI                       THEN NUM_DNI
                                WHEN (NUM_DNI IS NULL)                      THEN NUM_CNV
                                WHEN (NUM_CNV IS NULL)                      THEN NUM_DNI  Else ' '
                        END AS CNV_O_DNI, APELLIDO_MATERNO_NINO,APELLIDO_PATERNO_NINO,NOMBRE_NINO,FECHA_NACIMIENTO_NINO,DATEADD(DAY,59,FECHA_NACIMIENTO_NINO) AS 'CUMPLE_59_DIAS',
                        MENOR_VISITADO,MENOR_ENCONTRADO,TIPO_SEGURO,MES
                        INTO BDHIS_MINSA.dbo.FED_PADRON_NINO_PREMATURO FROM NOMINAL_PADRON_NOMINAL A 
                        WHERE ((TIPO_SEGURO IN  ('0,', '0, 1,', '0, 1, 2,', '0, 1, 4,', '1,', '1, 2,', '1, 2, 3,', '1, 2, 4,', '1, 3,', '1, 3, 4,', '1, 4,')) OR TIPO_SEGURO IS NULL) 
                        AND (MES IN ('2021$mes2'))";

        $resultado2 = "SELECT PERIODO,Institucion,DPTO_EESS,PROV_EESS,DIST_EESS,CO_LOCAL,Nombre_EESS AS Establecimiento, NU_CNV,FE_NACIDO,Financiador_Parto,PESO_NACIDO,DUR_EMB_PARTO  FED_CNV_PREMATURO 
                        INTO BDHIS_MINSA.dbo.FED_CNV_PREMATURO
                        FROM CNV_LUGARNACIDO_PASCO 
                        WHERE ((DUR_EMB_PARTO BETWEEN 34 AND 36) OR (PESO_NACIDO BETWEEN 1500 AND 2499)) ";

        $resultado3 = "SELECT A.Numero_Documento_Paciente, A.Tipo_Doc_Paciente, A.Fecha_Nacimiento_Paciente, A.Fecha_Atencion 
                        INTO BDHIS_MINSA.dbo.MIPASO1  
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A LEFT JOIN MAESTRO_PACIENTE B ON A.Id_Paciente = B.Id_Paciente
                        LEFT JOIN MAESTRO_HIS_TIPO_DOC C ON B.Id_Tipo_Documento_Paciente = C.Id_Tipo_Documento
                        WHERE (A.Edad_Dias_Paciente_FechaAtencion BETWEEN 0 AND 59) AND (A.Abrev_Tipo_Doc_Paciente IN ('DNI','CNV')) AND
                        (A.Codigo_Item IN ('D500','D509','D508','D649')) AND (A.Tipo_Diagnostico IN ('D','R'))";

        $resultado4 = "SELECT A.Numero_Documento_Paciente, A.Tipo_Doc_Paciente, A.Fecha_Nacimiento_Paciente, A.Fecha_Atencion 
                        INTO BDHIS_MINSA.dbo.MIPASO2
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        LEFT JOIN MAESTRO_PACIENTE B ON A.Id_Paciente=B.Id_Paciente
                        LEFT JOIN MAESTRO_HIS_TIPO_DOC C ON B.Id_Tipo_Documento_Paciente=C.Id_Tipo_Documento
                        WHERE (A.Edad_Dias_Paciente_FechaAtencion BETWEEN 0 AND 59) AND
                        (A.Numero_Documento_Paciente in (select Numero_Documento_Paciente from BDHIS_MINSA.dbo.MIPASO1) )AND
                        (Codigo_Item='U310' AND(Valor_Lab IN ('SF1','PO1','P01','1')))";

        $resultado5 = "SELECT A.Numero_Documento_Paciente, A.Tipo_Doc_Paciente, A.Fecha_Nacimiento_Paciente, MIN(Fecha_Atencion) AS FECHA_ATENCION 
                        INTO BDHIS_MINSA.dbo.SUPLEMENTACION_PREMATUROS
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        LEFT JOIN MAESTRO_PACIENTE B ON A.Id_Paciente=B.Id_Paciente
                        LEFT JOIN MAESTRO_HIS_TIPO_DOC C ON B.Id_Tipo_Documento_Paciente=C.Id_Tipo_Documento
                        WHERE (Edad_Dias_Paciente_FechaAtencion BETWEEN 0 AND 59)AND 
                        (C.Abrev_Tipo_Doc IN ('DNI','CNV')) AND
                        (Codigo_Item IN ('Z298','99199.17')) AND
                        (Valor_Lab IN ('SF1','P01','PO1'))
                        GROUP BY A.Numero_Documento_Paciente, A.Tipo_Doc_Paciente, A.Fecha_Nacimiento_Paciente UNION ALL  SELECT * FROM BDHIS_MINSA.dbo.MIPASO2";

        $resultado6 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.NOMBRE_EESS, A.FECHA_NACIMIENTO_NINO, c.Tipo_Doc_Paciente,
                        A.CNV_O_DNI,B.Establecimiento, CONCAT(A.APELLIDO_PATERNO_NINO, ' ', A.APELLIDO_MATERNO_NINO, ' ', A.NOMBRE_NINO) as full_name,
                        A.MENOR_VISITADO,A.MENOR_ENCONTRADO,A.TIPO_SEGURO,A.MES AS CORTE_PADRON,
                            CASE
                                WHEN (Numero_Documento_Paciente IS NULL)  THEN 'NO'  
                                WHEN (Numero_Documento_Paciente IS NOT  NULL)  THEN 'SI'  
                            Else ' ' END AS SUPLEMENTADO,    
                            CASE
                                WHEN (B.NU_CNV IS NULL)  THEN 'NO'
                                WHEN (B.NU_CNV IS NOT  NULL)  THEN 'SI'
                            Else ' ' END AS 'BAJO_PESO_PREMATURO' 
                        INTO BDHIS_MINSA.dbo.MIPASO3
                        FROM BDHIS_MINSA.dbo.FED_PADRON_NINO_PREMATURO A 
                        LEFT JOIN BDHIS_MINSA.dbo.FED_CNV_PREMATURO B ON A.CNV_O_DNI=B.NU_CNV
                        LEFT JOIN BDHIS_MINSA.dbo.SUPLEMENTACION_PREMATUROS C ON A.CNV_O_DNI=C.Numero_Documento_Paciente
                        WHERE YEAR(A.CUMPLE_59_DIAS)='2021' AND MONTH(A.CUMPLE_59_DIAS)='$mes'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado7 = "SELECT * FROM BDHIS_MINSA.dbo.MIPASO3 WHERE BAJO_PESO_PREMATURO='SI'
                        AND NOMBRE_PROV='$red'
                        ORDER BY NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS
                        DROP TABLE BDHIS_MINSA.dbo.FED_PADRON_NINO_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.FED_CNV_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO1
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO2
                        DROP TABLE BDHIS_MINSA.dbo.SUPLEMENTACION_PREMATUROS
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO3";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado7 = "SELECT * FROM BDHIS_MINSA.dbo.MIPASO3 WHERE BAJO_PESO_PREMATURO='SI'
                        ORDER BY NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS
                        DROP TABLE BDHIS_MINSA.dbo.FED_PADRON_NINO_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.FED_CNV_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO1
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO2
                        DROP TABLE BDHIS_MINSA.dbo.SUPLEMENTACION_PREMATUROS
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO3";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado7 = "SELECT * FROM BDHIS_MINSA.dbo.MIPASO3 WHERE BAJO_PESO_PREMATURO='SI'
                        AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                        ORDER BY NOMBRE_PROV, NOMBRE_DIST, NOMBRE_EESS
                        DROP TABLE BDHIS_MINSA.dbo.FED_PADRON_NINO_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.FED_CNV_PREMATURO
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO1
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO2
                        DROP TABLE BDHIS_MINSA.dbo.SUPLEMENTACION_PREMATUROS
                        DROP TABLE BDHIS_MINSA.dbo.MIPASO3";
        }

        $consulta1 = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);
        $consulta7 = sqlsrv_query($conn, $resultado7);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }

        if(!empty($consulta7)){
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7;">Fecha Nacido</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Tipo Seguro</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Menor Visitado</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Suplementado</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Prematuro</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px; background: #a3c8d7">Se Atiende</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta7)){
                    if(is_null ($consulta['NOMBRE_PROV']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['NOMBRE_PROV'];}

                    if(is_null ($consulta['NOMBRE_DIST']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['NOMBRE_DIST'] ;}

                    if(is_null ($consulta['NOMBRE_EESS']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['NOMBRE_EESS'];}

                    if(is_null ($consulta['Tipo_Doc_Paciente']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['Tipo_Doc_Paciente'];}

                    if(is_null ($consulta['CNV_O_DNI']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['CNV_O_DNI'];}

                    if(is_null ($consulta['full_name']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['full_name'];}

                    if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){
                        $newdate8 = '  -'; }
                        else{
                    $newdate8 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}

                    if(is_null ($consulta['TIPO_SEGURO']) ){
                        $newdate9 = '  -'; }
                        else{
                    $newdate9 = $consulta['TIPO_SEGURO'];}

                    if(is_null ($consulta['MENOR_VISITADO']) ){
                        $newdate10 = '  -'; }
                        else{
                    $newdate10 = $consulta['MENOR_VISITADO'];}

                    if(is_null ($consulta['SUPLEMENTADO']) ){
                        $newdate11 = '  -'; }
                        else{
                    $newdate11 = $consulta['SUPLEMENTADO'];}

                    if(is_null ($consulta['BAJO_PESO_PREMATURO']) ){
                        $newdate12 = '  -'; }
                        else{
                    $newdate12 = $consulta['BAJO_PESO_PREMATURO'];}

                    if(is_null ($consulta['Establecimiento']) ){
                        $newdate13 = '  -'; }
                        else{
                    $newdate13 = $consulta['Establecimiento'];}

            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate4); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo utf8_encode($newdate7); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo utf8_encode($newdate8); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate9; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo $newdate10; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate11; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate12; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;" id="color_prematuro_body"><?php echo utf8_encode($newdate13); ?></td>
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