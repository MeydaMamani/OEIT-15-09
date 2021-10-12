<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');  

    if (isset($_POST['Buscar'])) {
        global $conex;        
        $red = $_POST['red'];
        $distrito = $_POST['distrito'];
        $establecimiento = $_POST['establecimiento'];
        $dni_user = $_POST['dni_user'];
        $password = $_POST['password'];
        $app = $_POST['app'];
        $dni_paciente = $_POST['dni_paciente'];
        $fecha_atencion = $_POST['fecha_atencion'];
        $mig_eli = $_POST['mig_eli'];
        $select_type = $_POST['select_type'];
        $description = $_POST['description'];

        if($red == 1){
            $red = 'DANIEL ALCIDES CARRION';
        }else if($red == 2){
            $red = 'OXAPAMPA';
        }else if($red == 3){
            $red = 'PASCO';
        }else if($red == 4){
            $red = 'TODOS';
        }
     
        $resultado = "INSERT INTO USER_REQUEST (provincia, distrito, establecimiento, dni_usuario, password_usuario, aplicativo, dni_paciente, fecha_atencion, soporte, 
                    tipo_soporte, description)  VALUES ('$red', '$distrito', '$establecimiento', '$dni_user', '$password', '$app', '$dni_paciente', '$fecha_atencion', 
                    '$mig_eli', '$select_type', '$description')";
       
        $consulta1 = sqlsrv_query($conn, $resultado);
        if($consulta1){
            header("Location: solicitud.php");
        }
        exit;        
    }

    if(isset($_GET['eliminar'])){
        $id_delete = $_GET['eliminar'];
        $consulta = "DELETE FROM USER_REQUEST WHERE id='$id_delete'";
        $ejecutar = sqlsrv_query($conn, $consulta);
        if($ejecutar){
            header("Location: solicitud.php");
        }
        exit;
    }
?>
