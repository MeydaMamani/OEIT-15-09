<?php 
    require('abrir7.php');
        
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

    if(isset($_POST['datos'])){
        $tabla = "";
        $q = $_POST['datos'];
        
        $resultado = "SELECT TOP (20) TIPO_DOC, NUM_DOC, PACIENTE, ETNIA, FECHA_NACIMIENTO, ANIOS_EDAD_ATENCION, DESCRIPCION_VACUNA, DOSIS_APLICADA,
                        GRUPO_RIESGO, NOMBRE_ESTABLECIMIENTO, DEPARTAMENTO_ESTABLECIMIENTO, PROVINCIA_ESTABLECIMIENTO, DISTRITO_ESTABLECIMIENTO
                        FROM T_CONSOLIDADO_VACUNA_COVID
                        WHERE PACIENTE LIKE '%$q%'
                        ORDER BY PACIENTE";
               
        $consulta2 = sqlsrv_query($conn7, $resultado);
        $tabla .= '<div class="col-12 table-responsive">
                    <table id="demo-foo-addrow" class="table table-hover" data-page-size="20" data-limit-navigation="10">
                    <thead>
                        <tr class="text-center font-12" style="background: #c9d0e2;">
                            <th class="align-middle">#</th>
                            <th class="align-middle">Departamento</th>
                            <th class="align-middle">Provincia</th>
                            <th class="align-middle">Distrito</th>
                            <th class="align-middle">Nombre Establecimiento</th>
                            <th class="align-middle">Tipo Documento</th>
                            <th class="align-middle">Número Documento</th>
                            <th class="align-middle">Paciente</th>
                            <th class="align-middle">Etnia</th>
                            <th class="align-middle">Fecha Nacimiento</th>
                            <th class="align-middle">Edad</th>
                            <th class="align-middle">Descripción Vacuna</th>
                            <th class="align-middle">Dosis Aplicada</th>
                            <th class="align-middle">Grupo Riesgo</th>
                        </tr>
                    </thead>
                    <tbody>';
        $i=1;
        while ($consulta = sqlsrv_fetch_array($consulta2)){  
            if(is_null ($consulta["DEPARTAMENTO_ESTABLECIMIENTO"]) ){
                $newdate = '  -'; }
            else{
                $newdate = $consulta["DEPARTAMENTO_ESTABLECIMIENTO"];}
    
            if(is_null ($consulta["PROVINCIA_ESTABLECIMIENTO"]) ){
                $newdate2 = "  -"; }
            else{
                $newdate2 = $consulta["PROVINCIA_ESTABLECIMIENTO"];}
    
            if(is_null ($consulta["DISTRITO_ESTABLECIMIENTO"]) ){
                $newdate3 = "  -"; }
            else{
                $newdate3 = $consulta["DISTRITO_ESTABLECIMIENTO"];}
    
            if(is_null ($consulta["NOMBRE_ESTABLECIMIENTO"]) ){
                $newdate4 = "  -"; }
            else{
                $newdate4 = $consulta["NOMBRE_ESTABLECIMIENTO"];}
    
            if(is_null ($consulta["TIPO_DOC"]) ){
                $newdate5 = "  -"; }
            else{
                $newdate5 = $consulta["TIPO_DOC"];}
    
            if(is_null ($consulta["NUM_DOC"]) ){
                $newdate6 = "  -"; }
            else{
                $newdate6 = $consulta["NUM_DOC"];}
    
            if(is_null ($consulta["PACIENTE"]) ){
                $newdate7 = "  -"; }
            else{
                $newdate7 = $consulta["PACIENTE"];}
    
            if(is_null ($consulta["ETNIA"]) ){
                $newdate8 = "  -"; }
            else{
                $newdate8 = $consulta["ETNIA"];}
    
            if(is_null ($consulta["FECHA_NACIMIENTO"]) ){
                $newdate9 = "  -"; }
            else{
                $newdate9 = $consulta["FECHA_NACIMIENTO"]  -> format("d/m/y");}
    
            if(is_null ($consulta["ANIOS_EDAD_ATENCION"]) ){
                $newdate10 = "  -"; }
            else{
                $newdate10 = $consulta["ANIOS_EDAD_ATENCION"];}
    
            if(is_null ($consulta["DESCRIPCION_VACUNA"]) ){
                $newdate11 = "  -"; }
            else{
                $newdate11 = $consulta["DESCRIPCION_VACUNA"];}
    
            if(is_null ($consulta["DOSIS_APLICADA"]) ){
                $newdate12 = "  -"; }
            else{
                $newdate12 = $consulta["DOSIS_APLICADA"];}
    
            if(is_null ($consulta["GRUPO_RIESGO"]) ){
                $newdate13 = "  -"; }
            else{
                $newdate13 = $consulta["GRUPO_RIESGO"];}

        $tabla .= '
                    <tr class="text-center font-12" id="table_fed">
                    <td class="align-middle">'. $i++ .'</td>
                    <td class="align-middle">'. utf8_encode($newdate) .'</td>
                    <td class="align-middle">'. utf8_encode($newdate2) .'</td>
                    <td class="align-middle">'. utf8_encode($newdate3) .'</td>
                    <td class="align-middle">'. utf8_encode($newdate4) .'</td>
                    <td class="align-middle">'. $newdate5 .'</td>
                    <td class="align-middle">'. $newdate6 .'</td>
                    <td class="align-middle">'. utf8_encode($newdate7) .'</td>
                    <td class="align-middle">'. $newdate8 .'</td>
                    <td class="align-middle">'. $newdate9 .'</td>
                    <td class="align-middle">'. $newdate10 .'</td>
                    <td class="align-middle">'. $newdate11 .'</td>
                    <td class="align-middle">'. utf8_encode($newdate12) .'</td>
                    <td class="align-middle">'. $dato = utf8_encode($newdate13);
                                                $resultado = str_replace("a±os", "años", $dato);
                                                echo $resultado   .'</td>
                    </tr>';
              }              
              sqlsrv_close($conn7);
        $tabla .= '</tbody>
                    <tfoot>
                        <tr>
                            <td colspan="20">
                                <div class="">
                                    <ul class="pagination"></ul>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                </div>';

        echo $tabla;
    }
?>