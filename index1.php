<?php 
    require('abrir.php');
    if (isset($_POST['Buscar'])) {
    global $conex;
    // include('consulta_gestante_tratamiento.php');
    $user = $_POST['usuario'];
    $pass = $_POST['password'];
    $role = $_POST['role'];

    $resultado = "SELECT * FROM USER_LOGIN WHERE users='$user' and passwords='$pass' and roles='$role'";
    $consulta1 = sqlsrv_query($conn, $resultado);

    $params = array(); 
    $options = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
    $consulta1 = sqlsrv_query($conn, $resultado, $params, $options);
    $row_count = sqlsrv_num_rows($consulta1);   
    // echo $row_count;
    if ($row_count == 0){
        
        header("location:index.php");
     } else{
        // echo $row_count;
        header("location:index2.php");
     }
    // $v2=0; $row_cont1=0;
    // while ($consulta = sqlsrv_fetch_array($consulta1)){
    //     $row_cont1++;
    //     if(!is_null ($consulta['R456']) ){ $v2++; }
    }
?>
