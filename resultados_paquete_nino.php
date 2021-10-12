<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');
    
    if (isset($_POST['Buscar'])) {
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");
    include('./base.php');
    include('consulta_paquete_nino.php');
    $row_cont=0; $cumple=0; $no_cumple=0;
    while ($consulta = sqlsrv_fetch_array($consulta27)){
        $row_cont++;
    }
?>

        <div class="container">
            <div class="text-center p-3">
              <h3>Paquete Niño - <?php echo $nombre_mes; ?></h3>
            </div>
            <div class="row mb-3 mt-3">
                <div class="col-4 align-middle"><b>Cantidad de Registros: </b><b class="total"><?php echo $row_cont; ?></b></div>
                <!-- <div class="col-8 d-flex justify-content-end">
                  <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item font-14">Cumple <span class="badge bg-success rounded-pill cumple"><?php echo $cumple; ?></span></li>
                    <li class="list-group-item font-14">No Cumple <span class="badge bg-danger rounded-pill no_cumple"><?php echo $no_cumple; ?></span></li>
                    <li class="list-group-item font-14">Avance <span class="badge bg-primary rounded-pill avance">
                        <?php 
                            if($cumple == 0 and $row_cont == 0){ echo '0 %'; }
                            else{  echo number_format((float)(($cumple/$row_cont)*100), 2, '.', ''), '%';
                            }
                        ?>
                        </span>
                    </li>
                  </ul>
                </div> -->
            </div>
            <div class="row mb-3">
              <div class="col-lg-12 text-center">
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ModalResumen"><i class="fa fa-pie-chart"></i> Cuadro Resumen</button> -->
                <!-- <button type="submit" name="Limpiar" class="btn btn-outline-danger btn-sm btn_information" data-bs-toggle="modal" data-bs-target="#ModalInformacion"><i class="fa fa-list"></i> Informacion</button> -->
                <button type="submit" name="Limpiar" class="btn btn-outline-secondary btn-sm 1btn_buscar" onclick="location.href='paquete_nino.php';"><i class="fa fa-arrow-left"></i> Regresar</button>
              </div>
            </div>
            <!-- <button class="btn btn-outline-dark btn-sm btn_fed"><i class="fa fa-clone"></i> FED</button>
            <button class="btn btn-outline-success btn-sm btn_all"><i class="fa fa-circle"></i> Todo</button> -->
            <div class="col-12 table-responsive table_no_fed">
                <table id="demo-foo-addrow2" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="font-12 text-center" style="background: #afd3b5;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Menor Encontrado</th>
                            <th class="align-middle">Apellidos y Nombres</th>
                            <th class="align-middle">Documento</th>
                            <th class="align-middle">Tipo Seguro</th>
                            <th class="align-middle">Fecha Nacimiento Niño</th>
                            <th class="align-middle">Primer Control</th> 
                            <th class="align-middle">Segundo Control</th>
                            <th class="align-middle">Cumple 1 Mes</th>
                            <th class="align-middle">Tercer Control</th>
                            <th class="align-middle">Cuarto Control</th>
                            <th class="align-middle">Primer Control Mes</th>
                            <th class="align-middle">Segundo Control Mes</th>
                            <th class="align-middle">Tercer Control Mes</th>
                            <th class="align-middle">Cuarto Control Mes</th>
                            <th class="align-middle">Quinto Control Mes</th>
                            <th class="align-middle">Sexto Control Mes</th>
                            <th class="align-middle">Séptimo Control Mes</th>
                            <th class="align-middle">Octavo Control Mes</th>
                            <th class="align-middle">Noveno Control Mes</th>
                            <th class="align-middle">Décimo Control Mes</th>
                            <th class="align-middle">Onceavo Control Mes</th>
                        </tr>
                    </thead>
                    <div class="float-end pb-4 table_no_fed">
                        <div class="form-group">
                            <div id="inputbus" class="input-group input-group-sm">
                                <input id="demo-input-search2" type="text" placeholder="Buscar.." autocomplete="off" class="form-control">
                                <span class="input-group-text bg-light" id="basic-addon1"><i class="fa fa-search" style="font-size:15px"></i></span>
                            </div>
                        </div>
                    </div>
                    <tbody>
                    <?php  
                        include('consulta_paquete_nino.php');
                        $i=1;
                        while ($consulta = sqlsrv_fetch_array($consulta27)){
                        
                            if(is_null ($consulta['NOMBRE_PROV']) ){ $newdate = '  -'; }
                            else{ $newdate = $consulta['NOMBRE_PROV'] ;}

                            if(is_null ($consulta['NOMBRE_DIST']) ){ $newdate2 = '  -'; }
                            else{ $newdate2 = $consulta['NOMBRE_DIST'];}
                
                            if(is_null ($consulta['MENOR_ENCONTRADO']) ){ $newdate3 = '  -'; }
                            else{ $newdate3 = $consulta['MENOR_ENCONTRADO'];}
                
                            if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ $newdate4 = '  -'; }
                            else{ $newdate4 = $consulta['APELLIDOS_NOMBRES'];}
                
                            if(is_null ($consulta['DOCUMENTO']) ){ $newdate5 = '  -'; }
                            else{ $newdate5 = $consulta['DOCUMENTO'];}
               
                            if(is_null ($consulta['TIPO_SEGURO']) ){ $newdate6 = '  -'; }
                            else{ $newdate6 = $consulta['TIPO_SEGURO'];}                      
                
                            if(is_null ($consulta['FECHA_NACIMIENTO_NINO']) ){ $newdate7 = '  -'; }
                            else{ $newdate7 = $consulta['FECHA_NACIMIENTO_NINO'] -> format('d/m/y');}
                                        
                            if(is_null ($consulta['PRIMER_CNTRL']) ){ $newdate8 = '  -'; }
                            else{ $newdate8 = $consulta['PRIMER_CNTRL']-> format('d/m/y');}
                
                            if(is_null ($consulta['SEG_CNTRL']) ){ 
                                $newdate9 = '  -'; }
                            else{ $newdate9 = $consulta['SEG_CNTRL']-> format('d/m/y');}
                
                            if(is_null ($consulta['CUMPLE_1']) ){ $newdate10 = '  -'; }
                            else{ $newdate10 = $consulta['CUMPLE_1'];}
                
                            if(is_null ($consulta['TERCER_CNTRL']) ){ $newdate11 = '  -'; }
                            else{ $newdate11 = $consulta['TERCER_CNTRL']-> format('d/m/y');}
                
                            if(is_null ($consulta['CUARTO_CNTRL']) ){ $newdate12 = '  -'; }
                            else{ $newdate12 = $consulta['CUARTO_CNTRL']-> format('d/m/y');}
            
                            if(is_null ($consulta['PRIMER_CNTRL_MES']) ){ $newdate13 = '  -'; }
                            else{ $newdate13 = $consulta['PRIMER_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['SEGUNDO_CNTRL_MES']) ){ $newdate14 = '  -'; }
                            else{ $newdate14 = $consulta['SEGUNDO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['TERCER_CNTRL_MES']) ){ $newdate15 = '  -'; }
                            else{ $newdate15 = $consulta['TERCER_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['CUARTO_CNTRL_MES']) ){ $newdate16 = '  -'; }
                            else{ $newdate16 = $consulta['CUARTO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['QUINTO_CNTRL_MES']) ){ $newdate17 = '  -'; }
                            else{ $newdate17 = $consulta['QUINTO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['SEXTO_CNTRL_MES']) ){ $newdate18 = '  -'; }
                            else{ $newdate18 = $consulta['SEXTO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['SEPTIMO_CNTRL_MES']) ){ $newdate19 = '  -'; }
                            else{ $newdate19 = $consulta['SEPTIMO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['OCTAVO_CNTRL_MES']) ){ $newdate20 = '  -'; }
                            else{ $newdate20 = $consulta['OCTAVO_CNTRL_MES']-> format('d/m/y');}

                            if(is_null ($consulta['NOVENO_CNTRL_MES']) ){ $newdate21 = '  -'; }
                            else{ $newdate21 = $consulta['NOVENO_CNTRL_MES']-> format('d/m/y');}
                            
                            if(is_null ($consulta['DECIMO_CNTRL_MES']) ){ $newdate22 = '  -'; }
                            else{ $newdate22 = $consulta['DECIMO_CNTRL_MES']-> format('d/m/y');}
                            
                            if(is_null ($consulta['ONCEAVO_CNTRL_MES']) ){ $newdate23 = '  -'; }
                            else{ $newdate23 = $consulta['ONCEAVO_CNTRL_MES']-> format('d/m/y');}

                            ?>
                            <tr class="text-center font-12">
                                <td class="align-middle"><?php echo $i++; ?></td>
                                <td class="align-middle"><?php echo $newdate; ?></td>
                                <td class="align-middle"><?php echo $newdate2; ?></td>
                                <td class="align-middle"><?php echo $newdate3; ?></td>
                                <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                <td class="align-middle"><?php echo $newdate5; ?></td>
                                <td class="align-middle"><?php echo $newdate6; ?></td>
                                <td class="align-middle"><?php echo $newdate8; ?></td>
                                <td class="align-middle"><?php echo $newdate9; ?></td>
                                <td class="align-middle"><?php echo $newdate10; ?></td>
                                <td class="align-middle"><?php echo $newdate11; ?></td>
                                <td class="align-middle"><?php echo $newdate12; ?></td>
                                <td class="align-middle"><?php echo $newdate13; ?></td>
                                <td class="align-middle"><?php echo $newdate14; ?></td>
                                <td class="align-middle"><?php echo $newdate15; ?></td>
                                <td class="align-middle"><?php echo $newdate16; ?></td>
                                <td class="align-middle"><?php echo $newdate17; ?></td>
                                <td class="align-middle"><?php echo $newdate18; ?></td>
                                <td class="align-middle"><?php echo $newdate19; ?></td>
                                <td class="align-middle"><?php echo $newdate20; ?></td>
                                <td class="align-middle"><?php echo $newdate21; ?></td>
                                <td class="align-middle"><?php echo $newdate22; ?></td>
                                <td class="align-middle"><?php echo $newdate23; ?></td>
                            </tr>
                            <?php
                                ;}                    
                                include("cerrar.php");
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="18">
                                    <div class="">
                                        <ul class="pagination"></ul>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                </table>
            </div>
        </div>

    <?php } ?>

    <script src="./plugin/footable/js/footable-init.js"></script>
    <script src="./plugin/footable/js/footable.all.min.js"></script>
    <script>
        $(function(){
            // $(".btn_fed").click(function(){
            //     $(".total").text(<?php echo $i_fed-1; ?>);
            //     $(".cumple").text(<?php echo $cumple_fed; ?>);
            //     $(".no_cumple").text(<?php echo $no_cumple_fed; ?>);
            //     $(".avance").text(<?php if($cumple_fed==0 && $i_fed-1 == 0){ echo "'0 %'"; }
            //         else{ $porcentaje = number_format((float)(($cumple_fed/($i_fed-1))*100), 2, '.', '');
            //                 echo "'$porcentaje %'"; }?>);
            //     $(".table_fed").show();
            //     $(".table_no_fed").hide();
            // });
            // $(".btn_all").click(function(){
            //     $(".total").text(<?php echo $row_cont; ?>);
            //     $(".cumple").text(<?php echo $cumple; ?>);
            //     $(".no_cumple").text(<?php echo $no_cumple; ?>);
            //     $(".avance").text(<?php if($cumple == 0 and $row_cont == 0){ echo "'0 %'"; }
            //         else{ $porcentaje = number_format((float)(($cumple/$row_cont)*100), 2, '.', '');
            //                 echo "'$porcentaje %'"; }?>);
            //     $(".table_fed").hide();
            //     $(".table_no_fed").show();
            // });
        });

        $('#demo-input-search').on('input', function (e) {
            e.preventDefault();
            addrow2.trigger('footable_filter', {filter: $(this).val()});
        });
                
        var addrow2 = $('#demo-foo-addrow');
        addrow2.footable().on('click', '.delete-row-btn', function() {
            var footable = addrow.data('footable');
            var row = $(this).parents('tr:first');
            footable.removeRow(row);
        });
    </script>
</body>
</html>