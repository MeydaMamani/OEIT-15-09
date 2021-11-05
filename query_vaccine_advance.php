<?php 
    require('abrir.php');
    require('abrir6.php');

    if (isset($_POST['Buscar'])) {
        global $conex;
        
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];

        if ($red_1 == 1) {
        $red = 'DANIEL ALCIDES CARRION';
        }
        elseif ($red_1 == 2) {
        $red = 'OXAPAMPA';
        }
        elseif ($red_1 == 3) {
        $red = 'PASCO';
        }
        elseif ($red_1 == 4) {
        $redt = 'PASCO';
        }
    
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT * FROM VACUNADOS WHERE PRIMERA_PROV='$red' or SEGUNDA_PROV='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT * FROM VACUNADOS";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT * FROM VACUNADOS WHERE (PRIMERA_PROV='$red' or SEGUNDA_PROV='$red') AND (PRIMERA_DIST='$dist' OR SEGUNDA_DIST='$dist')";
        }

        $consulta1 = sqlsrv_query($conn6, $resultado);
    }
?>