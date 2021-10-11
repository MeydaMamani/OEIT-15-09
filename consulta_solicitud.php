<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;        
        $app = $_POST['app'];
        $dni_paciente = $_POST['dni_paciente'];
        $fecha_atencion = $_POST['fecha_atencion'];
        $mig_eli = $_POST['mig_eli'];
        $select_type = $_POST['select_type'];

        $resultado = "";
        
        $consulta1 = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
    }
?>