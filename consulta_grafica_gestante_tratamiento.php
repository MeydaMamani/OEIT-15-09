<?php
    require ('abrir.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;

        include('consulta_resumen_gestante_tratamiento.php'); 
    
        $lista_distritos = array();
        $lista_violencia = array();
        $lista_tratamiento = array();
        while ($consulta = sqlsrv_fetch_array($consulta2)){
            $lista_distritos[] = utf8_encode($consulta['Distrito_Establecimiento']);
            $lista_violencia[]=$consulta['PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA'];
            $lista_tratamiento[]=$consulta['DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO'];
        }
        $numero = sizeof($lista_distritos);
        $n = sizeof($lista_violencia);         
    }    
?>