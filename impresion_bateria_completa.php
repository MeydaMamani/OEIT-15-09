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
        
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                            FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                  A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)')  OR NOT Valor_Lab='')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red')
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                          Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          where GES_CAPT_OPO is not null
                          ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
  
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                          Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                          GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                        
                          FROM (SELECT
                              A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                              A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,                     
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                          Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                          Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                          Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                          Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                          Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)') OR NOT Valor_Lab='')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                          Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                          Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                          Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                          Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                              FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes')                    
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                                Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          WHERE GES_CAPT_OPO is not null
                          ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
  
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL                          
                            FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                                  A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,       
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','81000.02') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)')  OR NOT Valor_Lab='')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                          FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                          WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist')
                          GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                          Numero_Documento_Paciente, Fecha_Nacimiento_Paciente ) b
                          where GES_CAPT_OPO is not null
                          ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento";
        }
  
        $consulta2 = sqlsrv_query($conn, $resultado);

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO CG_FT_BATERIA_COMPLETA "._date("d-m-Y", false, 'America/Lima').".xls";        
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
                <th colspan="14" style="font-size: 26px; border: 1px solid #3A3838;">DIRESA PASCO DEIT</th>
            </tr>
            <tr></tr>
            <tr class="text-center">
                <th colspan="14" style="font-size: 28px; border: 1px solid #3A3838;">Gestantes de Bateria Completa (Indicador 1 - CG01) - <?php echo $nombre_mes; ?></th>
            </tr>
            <tr></tr>
            <tr>
                <th colspan="14" style="font-size: 15px; border: 1px solid #ddd; text-align: left;"><b>Fuente: </b> BD HisMinsa con Fecha: <?php echo _date("d/m/Y", false, 'America/Lima'); ?> a las 08:30 horas</th>
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
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Ipress</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Tipo Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Documento</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Fecha Nacimiento Paciente</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Captada</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">TMZ VIF</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_head">TMZ Anemia</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_head">Sifilis</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_head">VIH</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_head">Bacteriuria</th>
                <th style="border: 1px solid #DDDDDD; font-size: 15px;">Cumple</th>
            </tr>
        </thead>
        <tbody>
          <?php 
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){  
              $newdate = $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y');
              $newdate2 = $consulta['CAPTADA'] -> format('d/m/y');
              if(is_null ($consulta['TMZ_ANEMIA']) ){
                  $newdate3 = '  -'; }
                else{
              $newdate3 = $consulta['TMZ_ANEMIA'] -> format('d/m/y');}
    
              if(is_null ($consulta['SIFILIS']) ){
                  $newdate4 = '  -'; }
                else{
              $newdate4 = $consulta['SIFILIS'] -> format('d/m/y');}
    
              if(is_null ($consulta['VIH']) ){
                  $newdate5 = '  -'; }
                else{
              $newdate5 = $consulta['VIH'] -> format('d/m/y');}
    
              if(is_null ($consulta['BACTERIURIA']) ){
                  $newdate6 = '  -'; }
                else{
              $newdate6 = $consulta['BACTERIURIA'] -> format('d/m/y');}
    
              if(is_null ($consulta['TMZ_VIF']) ){
                  $newdate7 = '  -'; }
                else{
              $newdate7 = $consulta['TMZ_VIF'] -> format('d/m/y');}
    
              if ($consulta['CAPTADA'] == $consulta['TMZ_ANEMIA'] AND $consulta['CAPTADA'] == $consulta['SIFILIS'] AND $consulta['CAPTADA'] == $consulta['VIH'] AND $consulta['CAPTADA'] == $consulta['BACTERIURIA']) {
                $resultado = 'CORRECTO';
              } 
              else{
                $resultado = 'INCORRECTO';
              }
          ?>
            <tr class="text-center font-12" id="table_fed">
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $i++; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($consulta['PROVINCIA']); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($consulta['DISTRITO']); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo utf8_encode($consulta['IPRESS']); ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $consulta['TIPO_DOC']; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $consulta['DOCUMENTO']; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate2; ?></td>                      
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php echo $newdate7; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_body"><?php echo $newdate3; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_body"><?php echo $newdate4; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_body"><?php echo $newdate5; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;" id="fields_bateria_body"><?php echo $newdate6; ?></td>
              <td style="border: 1px solid #DDDDDD; font-size: 15px;"><?php 
                if ($resultado == 'CORRECTO'){
                  echo "<span class='badge bg-correct'>$resultado</span>"; 
                }else{
                  echo "<span class='badge bg-incorrect'>$resultado</span>"; 
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