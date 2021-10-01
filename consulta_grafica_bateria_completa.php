<?php
    require ('abrir.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;

        include('consulta_resumen_bateria.php'); 
    
        $lista_distritos = array();
        $lista_captadas = array();
        $lista_avances = array();
        while ($consulta = sqlsrv_fetch_array($resum2)){
            $lista_distritos[] = utf8_encode($consulta['Distrito']);
            $lista_captadas[] = $consulta['captada'];
            $lista_avances[] = $consulta['AVANCE'];
        }

        $numero = sizeof($lista_captadas);
    }    
?>