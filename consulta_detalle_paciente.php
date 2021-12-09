<?php 

require ('abrir.php');
   
if (isset($_POST['Buscar'])) {
    global $conex;
    //  header('Content-Type: text/html; charset=ISO-8859-1');
    include('./base.php');
    $doc = $_POST['doc'];
    $resultado = "SELECT distinct(t.Id_Cita), t.Fecha_Atencion, t.Fecha_Nacimiento_Paciente, t.Provincia_Establecimiento, t.Distrito_Establecimiento, t.Nombre_Establecimiento
                    from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t 
                    where Numero_Documento_Paciente='$doc' and anio='2021' and Fecha_Nacimiento_Paciente>='1960-01-01'
                    order by Fecha_Atencion DESC";

    $consulta1 = sqlsrv_query($conn, $resultado); 
    $consulta2 = sqlsrv_query($conn, $resultado);    
?>
<br>
<div class="page-wrapper">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10">
                <h4 class="m-b-30"> INFORMACIÓN </h4>
            </div>
            <div class="col-lg-2 text-end">
                <button type="submit" name="Limpiar" class="btn btn-outline-info btn-sm 1btn_buscar" onclick="location.href='detalle_paciente.php';"><i class="mdi mdi-arrow-left-bold"></i> Regresar</button>
            </div>
        </div>
        <ul class="list-group mb-4">
            <li class="list-group-item d-flex border-primary text-center">
                <div class="col-md-6">
                    <b>Número de DNI: </b><span><?php echo $doc; ?></span>
                </div>
                <div class="col-md-6">
                    <b>Fecha de Nacimiento:</b>
                    <?php while ($consulta = sqlsrv_fetch_array($consulta2)){
                       $fecha_nac =  $consulta['Fecha_Nacimiento_Paciente']-> format('d/m/y');
                    }?>
                    <span><?php echo $fecha_nac; ?></span>
                </div>
            </li>
        </ul>
        <div class="row">
            <?php  
            $cont = 1;
            while ($consulta = sqlsrv_fetch_array($consulta1)){  
            ?>
            <div class="col-md-6">
                <div class="card" style="border: 1px solid #5172a3;">
                    <div class="card-header p-3 text-white text-center" style="background: #5172a3;"> <!-- style="background: #4b0393;" -->
                        <div class="row">
                            <span class="col-md-6"><b>Id Cita:</b> <?php echo $consulta['Id_Cita']; ?> </span>
                            <span class="col-md-6"><b>Fecha Atención:</b> <?php echo $consulta['Fecha_Atencion']-> format('d/m/y'); ?> </span>
                        </div>
                    </div>
                    <div class="card-body mt-1">
                        <div class="mb-3 text-center">
                            <span class="col-md-12"><b><?php echo $consulta['Provincia_Establecimiento']; ?> / <?php echo $consulta['Distrito_Establecimiento']; ?> / <?php echo $consulta['Nombre_Establecimiento']; ?> </b></span>
                        </div>
                        <table class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr class="font-12 text-center">
                                    <th class="align-middle">#</th>
                                    <th class="align-middle">Lote</th>
                                    <th class="align-middle">Tipo Diagnóstico</th>
                                    <th class="align-middle">Código Item</th>
                                    <th class="align-middle">Valor Lab</th>
                                    <th class="align-middle">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $id_cita =  $consulta['Id_Cita'];
                                    $resultado2 = "SELECT t.Provincia_Establecimiento,t.Distrito_Establecimiento,t.Nombre_Establecimiento, t.Tipo_Doc_Paciente, t.Numero_Documento_Paciente, t.Lote,
                                                    t.Fecha_Nacimiento_Paciente, t.Id_Cita, t.Fecha_Atencion,t.Tipo_Diagnostico, t.Codigo_Item, t.Valor_Lab, t.Descripcion_Item
                                                    from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t 
                                                    where Numero_Documento_Paciente='$doc' AND Id_Cita='$id_cita' and anio='2021' and Fecha_Nacimiento_Paciente>='1960-01-01'
                                                    order by Fecha_Atencion DESC,id_cita;";
            
                                    $consulta2 = sqlsrv_query($conn, $resultado2);
                                    $i=1;
                                    while ($consulta = sqlsrv_fetch_array($consulta2)){
                                        if(is_null ($consulta['Lote']) ){
                                            $newdate2 = '  -'; }
                                            else{
                                        $newdate2 = $consulta['Lote'];}
                                        
                                        if(is_null ($consulta['Tipo_Diagnostico']) ){
                                            $newdate3 = '  -'; }
                                            else{
                                        $newdate3 = $consulta['Tipo_Diagnostico'];}
                    
                                        if(is_null ($consulta['Codigo_Item']) ){
                                            $newdate4 = '  -'; }
                                            else{
                                        $newdate4 = $consulta['Codigo_Item'] ;}
                    
                                        if(is_null ($consulta['Valor_Lab']) ){
                                            $newdate5 = '  -'; }
                                            else{
                                        $newdate5 = $consulta['Valor_Lab'];}
                    
                                        if(is_null ($consulta['Descripcion_Item']) ){
                                            $newdate6 = '  -'; }
                                            else{
                                        $newdate6 = $consulta['Descripcion_Item'];}
                                ?>
                                <tr class="text-center font-12">
                                    <td class="align-middle"><?php echo $i++; ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate2); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate3); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate4); ?></td>
                                    <td class="align-middle"><?php echo ($newdate5); ?></td>
                                    <td class="align-middle"><?php echo utf8_encode($newdate6); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <br><br>
            <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
<script src="./js/records_menu.js"></script>
<script>
    $(document).ready(function() {
        for (var i=1; i<=<?php echo $cont; ?>; i++) {
            $("#colors"+i).css("background", "#" +  Math.floor(Math.random()*16777215).toString(16));
        }    
    });
</script>