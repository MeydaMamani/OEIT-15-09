<?php
    include('./base.php');
    include('consulta_padron_gestantes.php');
    $row_cont=0; $correctos=0; $incorrectos=0;
    while ($consulta = sqlsrv_fetch_array($consulta2)){  
        $row_cont++;
    }  
?>
    <div class="page-wrapper">
        <div class="container">
            <div class="text-center p-3">
                <h3>Padrón de Gestantes</h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <div class="col-8 d-flex justify-content-end">
                    <form action="print_padron_gestantes.php" method="POST">
                        <button type="submit" id="export_data" name="exportarCSV" class="btn btn-outline-success btn-sm m-2 "><i class="mdi mdi-printer"></i> Imprimir CSV</button>
                    </form>
                </div>
            </div>
            <div class="col-12 table-responsive">
              <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                <thead>
                  <tr class="text-center font-12" style="background: #c9d0e2;">
                    <th class="align-middle">#</th>
                    <th class="align-middle">Provincia</th>
                    <th class="align-middle">Distrito</th>
                    <th class="align-middle">Tipo Documento</th>
                    <th class="align-middle">Documento</th>
                    <th class="align-middle">Fecha Nacimiento</th>
                    <th class="align-middle">Apellidos y Nombres</th>
                    <th class="align-middle">Edad Captada</th>
                    <th class="align-middle">Captada</th>
                    <th class="align-middle">TMZ ANEMIA</th>
                    <th class="align-middle">TMZ VIF</th>
                    <th class="align-middle">SIFILIS</th>
                    <th class="align-middle">VIH</th>
                    <th class="align-middle">BACTERIURIA</th>
                    <th class="align-middle">Perfil Lobst</th>
                    <th class="align-middle">Segundo Control</th>
                    <th class="align-middle">Tercer Control</th>
                    <th class="align-middle">Cuarto Control</th>
                    <th class="align-middle">Quinto Control</th>
                    <th class="align-middle">Sexto Control</th>
                    <th class="align-middle">Séptimo Control</th>
                    <th class="align-middle">Octavo Control</th>
                    <th class="align-middle">Acido Fólico 1</th>
                    <th class="align-middle">Acido Fólico 2</th>
                    <th class="align-middle">Acido Fólico 3</th>
                    <th class="align-middle">Sulfato 1</th>
                    <th class="align-middle">Sulfato 2</th>
                    <th class="align-middle">Sulfato 3</th>
                    <th class="align-middle">Sulfato 4</th>
                    <th class="align-middle">Sulfato 5</th>
                    <th class="align-middle">Sulfato 6</th>
                    <th class="align-middle">Calcio 1</th>
                    <th class="align-middle">Calcio 2</th>
                    <th class="align-middle">IVA</th>
                    <th class="align-middle">PAP SOLI</th>
                    <th class="align-middle">PAP ENTR</th>
                    <th class="align-middle">DX Anemia</th>
                    <th class="align-middle">Cumple</th>
                </tr>
                </thead>
                <div class="float-end pb-3">
                    <div class="form-group">
                      <div id="inputbus" class="input-group">
                        <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                        <span class="input-group-text bg-light" id="basic-addon1"><i class="mdi mdi-magnify" style="font-size:15px"></i></span>
                      </div>
                    </div>
                </div>
                <tbody>
                  <?php 
                    include('consulta_padron_gestantes.php');
                    $i=1;
                    while ($consulta = sqlsrv_fetch_array($consulta2)){  
                        if(is_null ($consulta['PROVINCIA']) ){
                            $newdate = '  -'; }
                        else{
                            $newdate = $consulta['PROVINCIA'];}

                        if(is_null ($consulta['DISTRITO']) ){
                            $newdate2 = '  -'; }
                        else{
                            $newdate2 = $consulta['DISTRITO'];}

                        if(is_null ($consulta['TIPO_DOC']) ){
                            $newdate3 = '  -'; }
                        else{
                            $newdate3 = $consulta['TIPO_DOC'];}

                        if(is_null ($consulta['DOCUMENTO']) ){
                            $newdate4 = '  -'; }
                        else{
                            $newdate4 = $consulta['DOCUMENTO'];}

                        if(is_null ($consulta['FECHA_NACIMIENTO_G']) ){
                            $newdate5 = '  -'; }
                        else{
                            $newdate5 = $consulta['FECHA_NACIMIENTO_G'] -> format('d/m/y');}
                        
                        if(is_null ($consulta['APELLIDOS_NOMBRES']) ){
                            $newdate6 = '  -'; }
                        else{
                            $newdate6 = $consulta['APELLIDOS_NOMBRES'];}

                        if(is_null ($consulta['EDAD_CAPTADA']) ){
                            $newdate7 = '  -'; }
                        else{
                            $newdate7 = $consulta['EDAD_CAPTADA'];}    

                        if(is_null ($consulta['CAPTADA']) ){
                            $newdate8 = '  -'; }
                        else{
                            $newdate8 = $consulta['CAPTADA'] -> format('d/m/y');}

                        if(is_null ($consulta['TMZ_ANEMIA']) ){
                            $newdate9 = '  -'; }
                        else{
                            $newdate9 = $consulta['TMZ_ANEMIA'] -> format('d/m/y');}

                        if(is_null ($consulta['TMZ_VIF']) ){
                            $newdate10 = '  -'; }
                        else{
                            $newdate10 = $consulta['TMZ_VIF'] -> format('d/m/y');}

                        if(is_null ($consulta['SIFILIS']) ){
                            $newdate11 = '  -'; }
                        else{
                            $newdate11 = $consulta['SIFILIS'] -> format('d/m/y');}

                        if(is_null ($consulta['VIH']) ){
                             $newdate12 = '  -'; }
                        else{
                            $newdate12 = $consulta['VIH'] -> format('d/m/y');}

                        if(is_null ($consulta['BACTERIURIA']) ){
                            $newdate13 = '  -'; }
                        else{
                            $newdate13 = $consulta['BACTERIURIA'] -> format('d/m/y');}

                        if(is_null ($consulta['PERFILOBST']) ){
                            $newdate14 = '  -'; }
                        else{
                            $newdate14 = $consulta['PERFILOBST'] -> format('d/m/y');}

                        if(is_null ($consulta['SEGUNDO_CONTROL']) ){
                            $newdate15 = '  -'; }
                        else{
                            $newdate15 = $consulta['SEGUNDO_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['TERCER_CONTROL']) ){
                            $newdate16 = '  -'; }
                        else{
                            $newdate16 = $consulta['TERCER_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['CUARTO_CONTROL']) ){
                            $newdate17 = '  -'; }
                        else{
                            $newdate17 = $consulta['CUARTO_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['QUINTO_CONTROL']) ){
                            $newdate18 = '  -'; }
                        else{
                            $newdate18 = $consulta['QUINTO_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['SEXTO_CONTROL']) ){
                            $newdate19 = '  -'; }
                        else{
                            $newdate19 = $consulta['SEXTO_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['SEP_CONTROL']) ){
                            $newdate20 = '  -'; }
                        else{
                            $newdate20 = $consulta['SEP_CONTROL'] -> format('d/m/y');}

                        if(is_null ($consulta['OCT_CONTROL']) ){
                            $newdate21 = '  -'; }
                        else{
                            $newdate21 = $consulta['OCT_CONTROL'] -> format('d/m/y');}

                                                                        if(is_null ($consulta['ACIDOFOLICO1']) ){
                                                                            $newdate22 = '  -'; }
                                                                        else{
                                                                            $newdate22 = $consulta['ACIDOFOLICO1'] -> format('d/m/y');}

                                                                            if(is_null ($consulta['ACIDOFOLICO2']) ){
                                                                                $newdate23 = '  -'; }
                                                                            else{
                                                                                $newdate23 = $consulta['ACIDOFOLICO2'] -> format('d/m/y');}

                                                                                if(is_null ($consulta['ACIDOFOLICO3']) ){
                                                                                    $newdate24 = '  -'; }
                                                                                else{
                                                                                    $newdate24 = $consulta['ACIDOFOLICO3'] -> format('d/m/y');}


                                                                                    if(is_null ($consulta['SULFATO1']) ){
                                                                                        $newdate25 = '  -'; }
                                                                                    else{
                                                                                        $newdate25 = $consulta['SULFATO1'] -> format('d/m/y');}

                                                                                        if(is_null ($consulta['SULFATO2']) ){
                                                                                            $newdate26 = '  -'; }
                                                                                        else{
                                                                                            $newdate26 = $consulta['SULFATO2'] -> format('d/m/y');}

                                                                                            if(is_null ($consulta['SULFATO3']) ){
                                                                                                $newdate27 = '  -'; }
                                                                                            else{
                                                                                                $newdate27 = $consulta['SULFATO3'] -> format('d/m/y');}

                                                                                                if(is_null ($consulta['SULFATO4']) ){
                                                                                                    $newdate28 = '  -'; }
                                                                                                else{
                                                                                                    $newdate28 = $consulta['SULFATO4'] -> format('d/m/y');}

                                                                                                    if(is_null ($consulta['SULFATO5']) ){
                                                                                                        $newdate29 = '  -'; }
                                                                                                    else{
                                                                                                        $newdate29 = $consulta['SULFATO5'] -> format('d/m/y');}

                                                                                                        if(is_null ($consulta['SULFATO6']) ){
                                                                                                            $newdate30 = '  -'; }
                                                                                                        else{
                                                                                                            $newdate30 = $consulta['SULFATO6'] -> format('d/m/y');}

                                                                                                            if(is_null ($consulta['CALCIO1']) ){
                                                                                                                $newdate31 = '  -'; }
                                                                                                            else{
                                                                                                                $newdate31 = $consulta['CALCIO1'] -> format('d/m/y');}

                                                                                                                if(is_null ($consulta['CALCIO2']) ){
                                                                                                                    $newdate32 = '  -'; }
                                                                                                                else{
                                                                                                                    $newdate32 = $consulta['CALCIO2'] -> format('d/m/y');}

                                                                                                                    if(is_null ($consulta['IVA']) ){
                                                                                                                        $newdate33 = '  -'; }
                                                                                                                    else{
                                                                                                                        $newdate33 = $consulta['IVA'] -> format('d/m/y');}

                                                                                                                        if(is_null ($consulta['PAP_SOLI']) ){
                                                                                                                            $newdate34 = '  -'; }
                                                                                                                        else{
                                                                                                                            $newdate34 = $consulta['PAP_SOLI'] -> format('d/m/y');}

                                                                                                                            if(is_null ($consulta['PAP_ENTR']) ){
                                                                                                                                $newdate35 = '  -'; }
                                                                                                                            else{
                                                                                                                                $newdate35 = $consulta['PAP_ENTR'] -> format('d/m/y');}

                                                                                                                                if(is_null ($consulta['DXANEMIA']) ){
                                                                                                                                    $newdate36 = '  -'; }
                                                                                                                                else{
                                                                                                                                    $newdate36 = $consulta['DXANEMIA'] -> format('d/m/y');}
                                                                    
                                                                    



                                                    
                                            if(is_null ($consulta['CUMPLE']) ){
                                                $newdate37 = '  -'; }
                                            else{
                                                $newdate37 = $consulta['CUMPLE'];}
    
                  ?>
                    <tr class="text-center font-12" id="table_fed">
                      <td class="align-middle"><?php echo $i++; ?></td>
                      <td class="align-middle"><?php echo $newdate; ?></td>
                      <td class="align-middle"><?php echo $newdate2; ?></td>
                      <td class="align-middle"><?php echo $newdate3; ?></td>
                      <td class="align-middle"><?php echo $newdate4; ?></td>
                      <td class="align-middle"><?php echo $newdate5; ?></td>
                      <td class="align-middle"><?php echo $newdate6; ?></td>
                      <td class="align-middle"><?php echo $newdate7; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate8); ?></td>
                      <td class="align-middle"><?php echo $newdate9; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate10); ?></td>
                      <td class="align-middle"><?php echo $newdate11; ?></td>
                      <td class="align-middle"><?php echo $newdate12; ?></td>
                      <td class="align-middle"><?php echo $newdate13; ?></td>                      
                      <td class="align-middle"><?php echo $newdate14; ?></td>
                      <td class="align-middle"><?php echo $newdate15; ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate16); ?></td>
                      <td class="align-middle"><?php echo utf8_encode($newdate17); ?></td>
                      <td class="align-middle"><?php echo $newdate18; ?></td>
                      <td class="align-middle"><?php echo $newdate19; ?></td>
                      <td class="align-middle"><?php echo $newdate20; ?></td>
                      <td class="align-middle"><?php echo $newdate21; ?></td>
                      <td class="align-middle"><?php echo $newdate22; ?></td>
                      <td class="align-middle"><?php echo $newdate23; ?></td>
                      <td class="align-middle"><?php echo $newdate24; ?></td>
                      <td class="align-middle"><?php echo $newdate25; ?></td>
                      <td class="align-middle"><?php echo $newdate26; ?></td>
                      <td class="align-middle"><?php echo $newdate27; ?></td>
                      <td class="align-middle"><?php echo $newdate28; ?></td>
                      <td class="align-middle"><?php echo $newdate29; ?></td>
                      <td class="align-middle"><?php echo $newdate30; ?></td>
                      <td class="align-middle"><?php echo $newdate31; ?></td>
                      <td class="align-middle"><?php echo $newdate32; ?></td>
                      <td class="align-middle"><?php echo $newdate33; ?></td>
                      <td class="align-middle"><?php echo $newdate34; ?></td>
                      <td class="align-middle"><?php echo $newdate35; ?></td>
                      <td class="align-middle"><?php echo $newdate36; ?></td>
                      <td class="align-middle"><?php 
                            if($newdate37 == 'CUMPLE'){
                                echo "<span class='badge bg-correct'>CUMPLE</span>";
                            }else{
                                echo "<span class='badge bg-incorrect'>NO CUMPLE</span>";
                            }
                        ?>
                      </td>
                    </tr>
                  <?php
                      ;}              
                      include("cerrar.php");
                  ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="40">
                        <div class="">
                            <ul class="pagination"></ul>
                        </div>
                        </td>
                    </tr>
                </tfoot>
              </table><br>
            </div>
        </div>
    </div>

<script src="./js/records_menu.js"></script>
<script src="./plugin/footable/js/footable-init.js"></script>
<script src="./plugin/footable/js/footable.all.min.js"></script>
</body>
</html>