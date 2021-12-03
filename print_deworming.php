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
  
        $resultado = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Numero_Documento_Paciente,
                          m.apellido_paterno_paciente, m.Apellido_Materno_Paciente, m.Nombres_Paciente, a.Grupo_Edad, A.Edad_Reg, A.Fecha_Nacimiento_Paciente,
                          Min(CASE WHEN (anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND Valor_Lab='1')THEN A.Fecha_Atencion ELSE NULL END)'PRIMERA',
                          Min(CASE WHEN (anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND Valor_Lab='2')THEN A.Fecha_Atencion ELSE NULL END)'SEGUNDA',
                          Min(CASE WHEN (anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND (Valor_Lab IS NULL OR Valor_Lab > '2'))THEN A.Fecha_Atencion ELSE NULL END)'EN_BLANCO'
                          into dbo.DESPARACITACION
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A left join MAESTRO_PACIENTE m
                            on a.Numero_Documento_Paciente=m.Numero_Documento_Paciente 
                            WHERE 
                              ANIO='2021' AND ((anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND Valor_Lab='1') OR
                              (anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND Valor_Lab='2') OR
                              (anio='2021' and Tipo_Diagnostico='D' and Codigo_Item in ('99199.28','Z292') AND (Valor_Lab IS NUll or vALOR_LAB >'2')) )
                          GROUP BY
                          A.Provincia_Establecimiento, A.Abrev_Tipo_Doc_Paciente, A.Edad_Reg, m.apellido_paterno_paciente, m.Apellido_Materno_Paciente, m.Nombres_Paciente,
                          A.Numero_Documento_Paciente, A.Distrito_Establecimiento, A.Nombre_Establecimiento,a.Grupo_Edad, A.Fecha_Nacimiento_Paciente 
                          ORDER BY a.Numero_Documento_Paciente";
  
      
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.CANTIDAD_PROV
                            FROM (SELECT Provincia_Establecimiento, Distrito_Establecimiento,
                            SUM(CASE WHEN (Provincia_Establecimiento='$red') THEN 1 ELSE 0 END) AS CANTIDAD_PROV
                                FROM dbo.DESPARACITACION WHERE Provincia_Establecimiento='$red'
                            GROUP BY Provincia_Establecimiento, Distrito_Establecimiento) A 
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento
                            DROP TABLE dbo.DESPARACITACION";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, CANTIDAD_PROV
                            FROM (SELECT Provincia_Establecimiento, Distrito_Establecimiento, COUNT(Provincia_Establecimiento) AS CANTIDAD_PROV
                            FROM dbo.DESPARACITACION  
                            GROUP BY Provincia_Establecimiento, Distrito_Establecimiento) A
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento
                            DROP TABLE dbo.DESPARACITACION";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado2 = "SELECT A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.CANTIDAD_PROV
                            FROM (SELECT Provincia_Establecimiento, Distrito_Establecimiento,
                            SUM(CASE WHEN (Provincia_Establecimiento='$red') THEN 1 ELSE 0 END) AS CANTIDAD_PROV,
                            SUM(CASE WHEN (Distrito_Establecimiento='$dist') THEN 1 ELSE 0 END) AS CANTIDAD_DIST
                                FROM dbo.DESPARACITACION WHERE Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            GROUP BY Provincia_Establecimiento, Distrito_Establecimiento) A
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento
                            DROP TABLE dbo.DESPARACITACION";
        }
  
        $consulta = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO DESPARACITACIÓN "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="4" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="4" style="font-size: 28px; border: 1px solid #3A3838;">Desparacitación</th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="4" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cantidad</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $i=1;
                while ($consulta = sqlsrv_fetch_array($consulta2)){
                    if(is_null ($consulta['Provincia_Establecimiento']) ){
                        $newdate = '  -'; }
                    else{
                        $newdate = $consulta['Provincia_Establecimiento'] ;}
            
                    if(is_null ($consulta['Distrito_Establecimiento']) ){
                        $newdate2 = '  -'; }
                    else{
                        $newdate2 = $consulta['Distrito_Establecimiento'];}
    
                    $newdate3 = $consulta['CANTIDAD_PROV'];
            ?>
            <tr class="text-center font-12">
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate3; ?></td>
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