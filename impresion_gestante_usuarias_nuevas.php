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
          $red = 'TODOS';
        }

        $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Codigo_Item, Tipo_Diagnostico, Fecha_Atencion, Numero_Documento_Paciente, Tipo_Doc_Paciente, Valor_Lab 
                into bdhis_minsa.dbo.TRAMAHIS 
                from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                where ltrim(rtrim(Codigo_Item)) in ('99208','96150','96150.01')
                and isnumeric(Numero_Documento_Paciente)=1
                and ltrim(rtrim(Genero))='F'
                ANd Tipo_Edad='A' AND edad_reg>=18
                AND [Id_Condicion_Servicio] in ('N','R')";

        $resultado2 = "SELECT Codigo_Unico, Categoria_Establecimiento 
                into bdhis_minsa.dbo.RENAES 
                from MAESTRO_HIS_ESTABLECIMIENTO";

        $resultado3 = "SELECT distinct try_convert(int,r.Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, den=1
                into bdhis_minsa.dbo.DEN 
                from bdhis_minsa.dbo.TRAMAHIS h
                left join bdhis_minsa.dbo.RENAES r ON TRY_CONVERT(INT,h.Codigo_Unico) = TRY_CONVERT(INT,R.Codigo_Unico)
                where ltrim(rtrim(Codigo_Item)) in ('99208') and ltrim(rtrim(Tipo_Diagnostico)) in ('D')
                and month(try_convert(date,Fecha_Atencion))='$mes' and year(try_convert(date,Fecha_Atencion))='$anio'
                and Numero_Documento_Paciente is not null
                AND Categoria_Establecimiento IN ('I-1','I-2','I-3','I-4')";

        $resultado4 = "SELECT distinct try_convert(int,Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, num=1
                into bdhis_minsa.dbo.NUM
                from bdhis_minsa.dbo.TRAMAHIS
                where (
                    (	ltrim(rtrim(Codigo_Item)) = '96150' and ltrim(rtrim(Tipo_Diagnostico)) ='D' and ltrim(rtrim(valor_lab)) ='VIF'	)
                    or 
                    ( 	ltrim(rtrim(Codigo_Item)) = '96150.01' and ltrim(rtrim(Tipo_Diagnostico)) = 'D' )
                ) and month(try_convert(date,Fecha_Atencion))='$mes' and year(try_convert(date,Fecha_Atencion))='$anio'";

        $resultado5 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                    intO PADRONINICIO 
                    from den d left join num n 
                    on d.id=n.id
                    left join MAESTRO_HIS_ESTABLECIMIENTO m
                    on d.renaes=cast(m.Codigo_Unico as int)
                    ORDER BY Provincia, Distrito, Nombre_Establecimiento;
                    with c as (
                    select DOCUMENTO,  ROW_NUMBER() 
                        over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                    from BDHIS_MINSA.dbo.PADRONINICIO)
                    delete  from c
                    where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
        $resultado6 = "SELECT * FROM BDHIS_MINSA.dbo.PADRONINICIO WHERE Provincia='$red'
                    ORDER BY Provincia, Distrito, Nombre_Establecimiento
                    DROP TABLE bdhis_minsa.dbo.RENAES
                    DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                    DROP TABLE bdhis_minsa.dbo.NUM 
                    DROP TABLE bdhis_minsa.dbo.DEN
                    DROP TABLE BDHIS_MINSA.dbo.PADRONINICIO";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
        $resultado6 = "SELECT * FROM BDHIS_MINSA.dbo.PADRONINICIO
                    ORDER BY Provincia, Distrito, Nombre_Establecimiento
                    DROP TABLE bdhis_minsa.dbo.RENAES
                    DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                    DROP TABLE bdhis_minsa.dbo.NUM 
                    DROP TABLE bdhis_minsa.dbo.DEN
                    DROP TABLE BDHIS_MINSA.dbo.PADRONINICIO";
        }
        else if($dist_1 != 'TODOS'){
        $dist=$dist_1;
        $resultado6 = "SELECT * FROM BDHIS_MINSA.dbo.PADRONINICIO WHERE Provincia='$red' AND Distrito='$dist'
                    ORDER BY Provincia, Distrito, Nombre_Establecimiento
                    DROP TABLE bdhis_minsa.dbo.RENAES
                    DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                    DROP TABLE bdhis_minsa.dbo.NUM 
                    DROP TABLE bdhis_minsa.dbo.DEN
                    DROP TABLE BDHIS_MINSA.dbo.PADRONINICIO";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);

        if(!empty($consulta6)){
            $ficheroExcel="DEIT_PASCO CG_FT_USUAR_NUEVAS_SERV_PLANIF_FAM - PPFF_CON_DX_VIOLENC (TMZ) "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                    <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
                </tr>
                <tr></tr>
                <tr class="text-center">
                    <th colspan="8" style="font-size: 26px; border: 1px solid #3A3838;">Usuarias Nuevas en el Servicio de Planificaci??n Familiar con DX Violencia - <?php echo $nombre_mes; ?></th>
                </tr>
                <tr></tr>
                <tr>
                    <th colspan="8" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
                </tr>
                <tr></tr>
            </tfoot>
            </thead>
        </table>
        <table>
            <thead>
                <tr class="text-center font-14" style="background: #c9d0e2;">
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">#</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">PROVINCIA</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">DISTRITO</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">ESTABLECIMIENTO</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">DOCUMENTO</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">ATE PLANIFICACI??N</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">TMZ VIF</th>
                    <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta6)){ 
                        if(is_null ($consulta['Provincia']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['Provincia'];}
    
                        if(is_null ($consulta['Distrito']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['Distrito'];}
    
                        if(is_null ($consulta['Nombre_Establecimiento']) ){
                            $newdate3 = '  -'; }
                            else{
                        $newdate3 = $consulta['Nombre_Establecimiento'];}
    
                        if(is_null ($consulta['documento']) ){
                            $newdate4 = '  -'; }
                            else{
                        $newdate4 = $consulta['documento'];}
    
                        if(is_null ($consulta['ATE_PLANIFICACION']) ){
                            $newdate5 = '  -'; }
                            else{
                        $newdate5 = $consulta['ATE_PLANIFICACION'] -> format('d/m/y');}
    
                        if(is_null ($consulta['TMZ_VIF']) ){
                            $newdate6 = '  -'; }
                            else{
                        $newdate6 = $consulta['TMZ_VIF'] -> format('d/m/y');}
    
                ?>
                <tr class="text-center font-14">
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $i++; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate2); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($newdate3); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo str_pad($newdate4, 8, "o", STR_PAD_LEFT); ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate5; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php echo $newdate6; ?></td>
                    <td style="border: 1px solid #DDDDDD; font-size: 15px; text-align: center;"><?php 
                        if(!is_null($consulta['ATE_PLANIFICACION']) && !is_null($consulta['TMZ_VIF'])){
                            if($newdate5 == $newdate6){
                                echo "<span class='badge bg-correct'>CUMPLE</span>";
                            }else{
                                echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                            }
                        }else{
                            echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
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