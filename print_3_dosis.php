<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        // header('Content-Type: text/html; charset=UTF-8');
        
        $resultado = "SELECT V.TIPO_DOC, V.NUM_DOC,
                    CASE WHEN (V.PRIMERA_PACIEN IS NULL) THEN V.SEGUNDA_PACIEN ELSE V.PRIMERA_PACIEN END AS 'NOMBRE_PACIENTE',
                    CASE WHEN (V.SEGUNDA_EDAD IS NULL) THEN V.PRIMERA_EDAD ELSE V.SEGUNDA_EDAD END AS 'EDAD_PACIENTE',
                    CASE WHEN (V.PRIMERA IS NULL) THEN VN.PRIMERA ELSE V.PRIMERA END AS 'FECHA_PRIMERA_DOSIS',
                    CASE WHEN (V.SEGUNDA IS NULL) THEN VN.SEGUNDA ELSE V.SEGUNDA END AS 'FECHA_SEGUNDA_DOSIS',
                    CASE WHEN (V.SEGUNDA IS NULL) THEN DATEADD(DAY,180,VN.SEGUNDA) ELSE DATEADD(DAY,180,V.SEGUNDA) END AS 'FECHA_PARA_3RA_DOSIS'
                    INTO T1 FROM VACUNADOS V
                    LEFT JOIN BD_VACUNADOS_NACIONAL.dbo.VACUNADOS VN 
                    ON V.NUM_DOC=VN.NUM_DOC AND V.TIPO_DOC = VN.TIPO_DOC";

        $resultado2 = "SELECT * FROM T1 WHERE FECHA_PARA_3RA_DOSIS <GETDATE() AND EDAD_PACIENTE >59";
            
        $consulta2 = sqlsrv_query($conn6, $resultado);
        $consulta3 = sqlsrv_query($conn6, $resultado2);

        if(!empty($consulta3)){
            $ficheroExcel="DEIT_PASCO APTOS_PARA_TERCERA_DOSIS "._date("d-m-Y", false, 'America/Lima').".xls";
            header('Content-Type: application/vnd.ms-excel');
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment;filename=".$ficheroExcel);
            header("Cache-Control: max-age=0");

?>
            <table>
                <thead>
                    <tr class="text-center">
                        <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">DEIT PASCO</th>
                    </tr>
                    <tr></tr>
                    <tr class="text-center">
                        <th colspan="8" style="font-size: 30px; border: 1px solid #3A3838;">APTOS PARA TERCERA DOSIS</th>
                    </tr>
                    <tr></tr>
                </thead>
            </table>    
            <table>
                <thead>
                  <tr class="text-center font-14">
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">#</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Tipo de Documento</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">N° Documento</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Nombres y Apellidos</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Edad</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Fecha Primera Dosis</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Fecha Segunda Dosis</th>
                    <th style="background: #c9d0e2; border: 1px solid #3A3838;">Fecha Tercera Dosis</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    include('query_3_dosis.php');
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta3)){  
                        if(is_null ($consulta['TIPO_DOC']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['TIPO_DOC'];}

                        if(is_null ($consulta['NUM_DOC']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['NUM_DOC'];}

                        if(is_null ($consulta['NOMBRE_PACIENTE']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['NOMBRE_PACIENTE'];}

                        if(is_null ($consulta['EDAD_PACIENTE']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['EDAD_PACIENTE'];}

                        if(is_null ($consulta['FECHA_PRIMERA_DOSIS']) ){
                            $newdate5 = '  -'; }
                        else{
                            $newdate5 = $consulta['FECHA_PRIMERA_DOSIS'] -> format('d/m/y');}
                        
                        if(is_null ($consulta['FECHA_SEGUNDA_DOSIS']) ){
                            $newdate6 = '  -'; }
                        else{
                            $newdate6 = $consulta['FECHA_SEGUNDA_DOSIS'] -> format('d/m/y');}

                        if(is_null ($consulta['FECHA_PARA_3RA_DOSIS']) ){
                            $newdate7 = '  -'; }
                        else{
                            $newdate7 = $consulta['FECHA_PARA_3RA_DOSIS'] -> format('d/m/y');}
   
                  ?>
                    <tr class="text-center font-12" id="table_fed">
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $i++; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate2; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo utf8_encode($newdate3); ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate4; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate5; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate6; ?></td>
                        <td style="text-align: center; border: 1px solid #3A3838;"><?php echo $newdate7; ?></td>
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