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
        elseif ($red_1 == 4) { $redt = 'PASCO'; }
        
        $resultado = "SELECT Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item,ROW_NUMBER()OVER(PARTITION BY NUMERO_DOCUMENTO_PACIENTE ORDER BY FECHA_ATENCION)AS ORDEN
                        INTO BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where (CODIGO_ITEM IN ('59401.04','99199.26'))";

        $resultado2 = "SELECT Numero_Documento_Paciente,
                        MAX(CASE WHEN(ORDEN='1')THEN Fecha_Atencion ELSE NULL END)AS PRIMER_ENTREGA_SUPLEMENTO,
                        MAX(CASE WHEN(ORDEN='2')THEN Fecha_Atencion ELSE NULL END)AS SEGUNDO_ENTREGA_SUPLEMENTO,
                        MAX(CASE WHEN(ORDEN='3')THEN Fecha_Atencion ELSE NULL END)AS TERCERA_ENTREGA_SUPLEMENTO
                        INTO BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                        FROM SULFATO_FERROSO_AND_ACIDO_FOLICO
                        GROUP BY Numero_Documento_Paciente";

        $resultado3 = "SELECT A.NUMERO_DOCUMENTO_PACIENTE,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND ((CODIGO_ITEM IN ('85018','85018.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS DOSAJE_HEMOGLOBINA,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86780','86592','86593','86318.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_SIFILIS,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86703','86703.02','87389','86318.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_VIH,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('81007','81002','81000.02'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS TAMIZAJE_BACTERIURIA,
                        MIN(CASE WHEN(FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('80055.01'))AND Tipo_Diagnostico='D'))THEN FECHA_ATENCION ELSE NULL END)AS PERFIL_OBSTETRICO,
                        MIN(CASE WHEN((FECHA_ATENCION>='2020-10-01')AND((CODIGO_ITEM IN ('Z3491','Z3591'))))THEN FECHA_ATENCION ELSE NULL END)AS PRIMER_TRIMESTRE_APN_PRESENCIAL,
                        MIN(CASE WHEN((FECHA_ATENCION>='2021-01-07')AND((CODIGO_ITEM IN ('Z3492','Z3592'))))THEN FECHA_ATENCION ELSE NULL END)AS SEGUNDO_TRIMESTRE_APN_PRESENCIAL,
                        MIN(CASE WHEN((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))THEN FECHA_ATENCION ELSE NULL END)AS TERCER_TRIMESTRE_1APN_PRESENCIAL,
                        MAX(CASE WHEN((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))THEN FECHA_ATENCION ELSE NULL END)AS TERCER_TRIMESTRE_2APN_PRESENCIAL,B.PRIMER_ENTREGA_SUPLEMENTO,B.SEGUNDO_ENTREGA_SUPLEMENTO,B.TERCERA_ENTREGA_SUPLEMENTO
                        INTO BDHIS_MINSA.dbo.PASO1 FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        LEFT JOIN BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO B ON A.Numero_Documento_Paciente=B.Numero_Documento_Paciente
                        WHERE (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('85018','85018.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86780','86592','86593','86318.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('86703','86703.02','87389','86318.01'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('81007','81002','81000.02'))AND Tipo_Diagnostico='D'))OR
                        (FECHA_ATENCION>='2020-10-01' AND((CODIGO_ITEM IN ('80055.01'))AND Tipo_Diagnostico='D'))OR
                        ((FECHA_ATENCION>='2020-10-01')AND((CODIGO_ITEM IN ('Z3491','Z3591'))))OR
                        ((FECHA_ATENCION>='2021-01-07')AND((CODIGO_ITEM IN ('Z3492','Z3592'))))OR
                        ((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))OR
                        ((FECHA_ATENCION>='2021-04-15')AND((CODIGO_ITEM IN ('Z3493','Z3593'))))
                        GROUP BY A.NUMERO_DOCUMENTO_PACIENTE,B.PRIMER_ENTREGA_SUPLEMENTO,B.SEGUNDO_ENTREGA_SUPLEMENTO,B.TERCERA_ENTREGA_SUPLEMENTO";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='2021$mes2'
                            AND Prov_Madre='$red'
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='2021$mes2'
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado4 = "SELECT Dpto_Madre,Prov_Madre,Dist_Madre,
                            case when  (Dist_Madre IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '1'
                            when (Dist_Madre NOT IN ('YANAHUANCA','VILCABAMBA','SANTA ANA DE TUSI','SAN PEDRO DE PILLAO','CHACAYAN','TAPUC','PAUCAR','HUACHON','NINACACA','PALLANCHACRA','TICLACAYAN','PALCAZU','POZUZO','PUERTO BERMUDEZ'))then '0'
                            ELSE NULL END AS DISTRITO_QUINTILES
                            ,CO_LOCAL,Nombre_EESS,PERIODO,DUR_EMB_PARTO,Financiador_Parto,Tipo_Doc_Madre,NU_DOC_MADRE,B.DOSAJE_HEMOGLOBINA,B.TAMIZAJE_SIFILIS,B.TAMIZAJE_VIH,B.TAMIZAJE_BACTERIURIA,B.PERFIL_OBSTETRICO,
                            B.PRIMER_TRIMESTRE_APN_PRESENCIAL,SEGUNDO_TRIMESTRE_APN_PRESENCIAL,TERCER_TRIMESTRE_1APN_PRESENCIAL,TERCER_TRIMESTRE_2APN_PRESENCIAL,PRIMER_ENTREGA_SUPLEMENTO,SEGUNDO_ENTREGA_SUPLEMENTO,TERCERA_ENTREGA_SUPLEMENTO
                            from CNV_DOM_MADRE_PASCO A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO1 B ON A.NU_DOC_MADRE=B.NUMERO_DOCUMENTO_PACIENTE where
                            Lugar_Nacido='ESTABLECIMIENTO DE SALUD' AND DUR_EMB_PARTO>='37' AND 
                            (Institucion in ('GOBIERNO REGIONAL','MINSA')) AND Tipo_Doc_Madre='DNI/LE' AND PERIODO='2021$mes2'
                            AND Dist_Madre='$dist'
                            DROP TABLE BDHIS_MINSA.dbo.SULFATO_FERROSO_AND_ACIDO_FOLICO
                            DROP TABLE BDHIS_MINSA.dbo.ENTREGA_SUPLEMENTO
                            DROP TABLE BDHIS_MINSA.dbo.PASO1";

        }

        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn3, $resultado4);

        if(!empty($consulta4)){
            $ficheroExcel="DEIT_PASCO PAQUETE COMPLETO "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="20" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="20" style="font-size: 28px; border: 1px solid #3A3838;">Paquete Gestante - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="20" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Establecimiento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Duración de Embarazo</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Financiador Parto</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Dosaje Hemoglobina</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tmz Sifilis</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tmz VIH</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tmz Bacteriuria</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Perfil Obstetrico</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">1er Tri APN Presencial</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">2do Tri APN Presencial</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">3er Tri 1APN Presencial</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">3er Tri 2APN Presencial</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">1era Entrega Suplemento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">2da Entrega Suplemento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">3era Entrega Suplemento</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta4)){  
                    if(is_null ($consulta['Prov_Madre']) ){
                        $newdate1 = '  -'; }
                        else{
                    $newdate1 = $consulta['Prov_Madre'];}
    
                    if(is_null ($consulta['Dist_Madre']) ){
                        $newdate2 = '  -'; }
                        else{
                    $newdate2 = $consulta['Dist_Madre'];}
    
                    if(is_null ($consulta['Nombre_EESS']) ){
                        $newdate3 = '  -'; }
                        else{
                    $newdate3 = $consulta['Nombre_EESS'];}
    
                    if(is_null ($consulta['Tipo_Doc_Madre']) ){
                        $newdate4 = '  -'; }
                        else{
                    $newdate4 = $consulta['Tipo_Doc_Madre'];}
    
                    if(is_null ($consulta['NU_DOC_MADRE']) ){
                        $newdate5 = '  -'; }
                        else{
                    $newdate5 = $consulta['NU_DOC_MADRE'];}
    
                    if(is_null ($consulta['DUR_EMB_PARTO']) ){
                        $newdate6 = '  -'; }
                        else{
                    $newdate6 = $consulta['DUR_EMB_PARTO'];}
    
                    if(is_null ($consulta['Financiador_Parto']) ){
                        $newdate7 = '  -'; }
                        else{
                    $newdate7 = $consulta['Financiador_Parto'];}
    
                    if(is_null ($consulta['DOSAJE_HEMOGLOBINA']) ){
                        $newdate8 = '  -'; }
                        else{
                    $newdate8 = $consulta['DOSAJE_HEMOGLOBINA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TAMIZAJE_SIFILIS']) ){
                        $newdate9 = '  -'; }
                        else{
                    $newdate9 = $consulta['TAMIZAJE_SIFILIS'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TAMIZAJE_VIH']) ){
                        $newdate10 = '  -'; }
                        else{
                    $newdate10 = $consulta['TAMIZAJE_VIH'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TAMIZAJE_BACTERIURIA']) ){
                        $newdate11 = '  -'; }
                        else{
                    $newdate11 = $consulta['TAMIZAJE_BACTERIURIA'] -> format('d/m/y');}
    
                    if(is_null ($consulta['PERFIL_OBSTETRICO']) ){
                        $newdate19 = '  -'; }
                        else{
                    $newdate19 = $consulta['PERFIL_OBSTETRICO'] -> format('d/m/y');}
    
                    if(is_null ($consulta['PRIMER_TRIMESTRE_APN_PRESENCIAL']) ){
                        $newdate12 = '  -'; }
                        else{
                    $newdate12 = $consulta['PRIMER_TRIMESTRE_APN_PRESENCIAL'] -> format('d/m/y');}
    
                    if(is_null ($consulta['SEGUNDO_TRIMESTRE_APN_PRESENCIAL']) ){
                        $newdate13 = '  -'; }
                        else{
                    $newdate13 = $consulta['SEGUNDO_TRIMESTRE_APN_PRESENCIAL'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TERCER_TRIMESTRE_1APN_PRESENCIAL']) ){
                        $newdate14 = '  -'; }
                        else{
                    $newdate14 = $consulta['TERCER_TRIMESTRE_1APN_PRESENCIAL'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TERCER_TRIMESTRE_2APN_PRESENCIAL']) ){
                        $newdate15 = '  -'; }
                        else{
                    $newdate15 = $consulta['TERCER_TRIMESTRE_2APN_PRESENCIAL'] -> format('d/m/y');}
    
                    if(is_null ($consulta['PRIMER_ENTREGA_SUPLEMENTO']) ){
                        $newdate16 = '  -'; }
                        else{
                    $newdate16 = $consulta['PRIMER_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}
    
                    if(is_null ($consulta['SEGUNDO_ENTREGA_SUPLEMENTO']) ){
                        $newdate17 = '  -'; }
                        else{
                    $newdate17 = $consulta['SEGUNDO_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}
    
                    if(is_null ($consulta['TERCERA_ENTREGA_SUPLEMENTO']) ){
                        $newdate18 = '  -'; }
                        else{
                    $newdate18 = $consulta['TERCERA_ENTREGA_SUPLEMENTO'] -> format('d/m/y');}
                    
            ?>
            <tr class="text-center font-12" id="table_fed">
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $i++; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate1); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate4; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate5; ?></td>                      
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate6; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate8; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate9; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate10; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate11; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate19; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate12; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate13; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate14; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate15; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate16; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate17; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate18; ?></td>
            </tr>
          <?php
              }
              include("cerrar.php");
          ?>
        </tbody>
    </table>
<?php
        }
    }
?>