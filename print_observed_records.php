<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
 
    if(isset($_POST["exportarCSV"])) {

        global $conex;
        include('zone_setting.php');
        ini_set("default_charset", "UTF-8");
         header('Content-Type: text/html; charset=ISO-8859-1');
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $red = 'TODOS'; }
                
        if($red_1 == 4 and $dist_1 == 'TODOS'){
            $resultado = "SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'OTROS_GRUPOS' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Brigadistas','Casa Reposo de Rehabilitacion y Albergues',
                            'Obesidad Tipo II (IMC de 35 a 39.9)','Obesidad Tipo III (IMC mayor o igual a 40)','Olimpicos o Paraolimpicos',
                            'Otros grupos de riesgo','Pacientes con Hemodialisis y Enfermedad Cronica Renal','Personas con TBC',
                            'Personas Privadas de su Libertad (INPE)','Psoriasis Artritis Psoriasica Artritis Reumatoide',
                            'Zonas Altoandinas')
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Adulto Mayor','60 anios a mas Adulto Mayor') AND ANIOS_EDAD_ATENCION < 59
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 50 a 59 anios') AND (ANIOS_EDAD_ATENCION > 59
                            OR ANIOS_EDAD_ATENCION < 49)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 40 a 49 anios') AND (ANIOS_EDAD_ATENCION > 49
                            OR ANIOS_EDAD_ATENCION < 39)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 30 a 39 anios') AND (ANIOS_EDAD_ATENCION > 39
                            OR ANIOS_EDAD_ATENCION < 29)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 20  a 29 anios') AND (ANIOS_EDAD_ATENCION > 29
                            OR ANIOS_EDAD_ATENCION < 19)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 18  a 19 anios') AND (ANIOS_EDAD_ATENCION > 19
                            OR ANIOS_EDAD_ATENCION < 17)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE GRUPO_RIESGO IN('Personas de 12  a 17 anios') AND (ANIOS_EDAD_ATENCION > 17
                            OR ANIOS_EDAD_ATENCION < 11)
                            ORDER BY PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO";

        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS'){
            $resultado = "SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'OTROS_GRUPOS' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Brigadistas','Casa Reposo de Rehabilitacion y Albergues',
                            'Obesidad Tipo II (IMC de 35 a 39.9)','Obesidad Tipo III (IMC mayor o igual a 40)','Olimpicos o Paraolimpicos',
                            'Otros grupos de riesgo','Pacientes con Hemodialisis y Enfermedad Cronica Renal','Personas con TBC',
                            'Personas Privadas de su Libertad (INPE)','Psoriasis Artritis Psoriasica Artritis Reumatoide',
                            'Zonas Altoandinas')
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Adulto Mayor','60 anios a mas Adulto Mayor') AND ANIOS_EDAD_ATENCION < 59
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 50 a 59 anios') AND (ANIOS_EDAD_ATENCION > 59
                            OR ANIOS_EDAD_ATENCION < 49)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 40 a 49 anios') AND (ANIOS_EDAD_ATENCION > 49
                            OR ANIOS_EDAD_ATENCION < 39)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 30 a 39 anios') AND (ANIOS_EDAD_ATENCION > 39
                            OR ANIOS_EDAD_ATENCION < 29)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 20  a 29 anios') AND (ANIOS_EDAD_ATENCION > 29
                            OR ANIOS_EDAD_ATENCION < 19)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 18  a 19 anios') AND (ANIOS_EDAD_ATENCION > 19
                            OR ANIOS_EDAD_ATENCION < 17)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE PROVINCIA_ESTABLECIMIENTO='$red' AND GRUPO_RIESGO IN('Personas de 12  a 17 anios') AND (ANIOS_EDAD_ATENCION > 17
                            OR ANIOS_EDAD_ATENCION < 11)
                            ORDER BY PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'OTROS_GRUPOS' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Brigadistas','Casa Reposo de Rehabilitacion y Albergues',
                            'Obesidad Tipo II (IMC de 35 a 39.9)','Obesidad Tipo III (IMC mayor o igual a 40)','Olimpicos o Paraolimpicos',
                            'Otros grupos de riesgo','Pacientes con Hemodialisis y Enfermedad Cronica Renal','Personas con TBC',
                            'Personas Privadas de su Libertad (INPE)','Psoriasis Artritis Psoriasica Artritis Reumatoide',
                            'Zonas Altoandinas')
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Adulto Mayor','60 anios a mas Adulto Mayor') AND ANIOS_EDAD_ATENCION < 59
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 50 a 59 anios') AND (ANIOS_EDAD_ATENCION > 59
                            OR ANIOS_EDAD_ATENCION < 49)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 40 a 49 anios') AND (ANIOS_EDAD_ATENCION > 49
                            OR ANIOS_EDAD_ATENCION < 39)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 30 a 39 anios') AND (ANIOS_EDAD_ATENCION > 39
                            OR ANIOS_EDAD_ATENCION < 29)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 20  a 29 anios') AND (ANIOS_EDAD_ATENCION > 29
                            OR ANIOS_EDAD_ATENCION < 19)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 18  a 19 anios') AND (ANIOS_EDAD_ATENCION > 19
                            OR ANIOS_EDAD_ATENCION < 17)
                            
                            UNION ALL
                            SELECT PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO,
                            VACUNADOR, TIPO_DOC, NUM_DOC, ANIOS_EDAD_ATENCION, GRUPO_RIESGO FECHA_VACUNACION,'GRUPO ETARIO ERRONEO' AS 'RAZON_OBSERVACION'
                            FROM T_CONSOLIDADO_VACUNA_COVID_PASCO WHERE DISTRITO_ESTABLECIMIENTO='$dist' AND GRUPO_RIESGO IN('Personas de 12  a 17 anios') AND (ANIOS_EDAD_ATENCION > 17
                            OR ANIOS_EDAD_ATENCION < 11)
                            ORDER BY PROVINCIA_ESTABLECIMIENTO,DISTRITO_ESTABLECIMIENTO, NOMBRE_ESTABLECIMIENTO";
        }
  
        $consulta2 = sqlsrv_query($conn6, $resultado);
        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO REGISTROS OBSERVADOS "._date("d-m-Y", false, 'America/Lima').".xls";
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
            <th colspan="10" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
        </tr>
        <tr></tr>
        <tr class="text-center">
            <th colspan="10" style="font-size: 28px; border: 1px solid #3A3838;">REGISTROS OBSERVADOS</th>
        </tr>
        <tr></tr>
        <tr>
            <th colspan="10" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD PadronCovid con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
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
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Vacunador</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Edad</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Vacunación</th>
            <th style="border: 1px solid #DDDDDD; font-size: 15px;">Razón de Observación</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                if(is_null ($consulta['PROVINCIA_ESTABLECIMIENTO']) ){
                    $newdate2 = '  -'; }
                    else{
                $newdate2 = $consulta['PROVINCIA_ESTABLECIMIENTO'];}
            
                if(is_null ($consulta['DISTRITO_ESTABLECIMIENTO']) ){
                    $newdate3 = '  -'; }
                    else{
                $newdate3 = $consulta['DISTRITO_ESTABLECIMIENTO'] ;}
            
                if(is_null ($consulta['NOMBRE_ESTABLECIMIENTO']) ){
                    $newdate4 = '  -'; }
                    else{
                $newdate4 = $consulta['NOMBRE_ESTABLECIMIENTO'];}
            
                if(is_null ($consulta['TIPO_DOC']) ){
                    $newdate5 = '  -'; }
                    else{
                $newdate5 = $consulta['TIPO_DOC'];}
            
                if(is_null ($consulta['NUM_DOC']) ){
                    $newdate6 = '  -'; }
                    else{
                $newdate6 = $consulta['NUM_DOC'];}
            
                if(is_null ($consulta['VACUNADOR']) ){
                    $newdate7 = '  -'; }
                    else{
                $newdate7 = $consulta['VACUNADOR'];}
            
                if(is_null ($consulta['ANIOS_EDAD_ATENCION']) ){
                    $newdate8 = '  -'; }
                    else{
                $newdate8 = $consulta['ANIOS_EDAD_ATENCION'];}
            
                if(is_null ($consulta['FECHA_VACUNACION']) ){
                    $newdate9 = '  -'; }
                    else{
                $newdate9 = $consulta['FECHA_VACUNACION'];}
            
                if(is_null ($consulta['RAZON_OBSERVACION']) ){
                    $newdate10 = '  -'; }
                    else{
                $newdate10 = $consulta['RAZON_OBSERVACION'];}
            
        ?>
        <tr class="text-center font-12">
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo ($newdate4); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo ($newdate6); ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate8; ?></td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php 
                $resultado = str_replace("anios", "años", $newdate9);
                echo $resultado; ?>
            </td>
            <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate10; ?></td>
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