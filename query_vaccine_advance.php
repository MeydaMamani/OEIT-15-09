<?php 
    require('abrir.php');
    require('abrir7.php');

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
            $resultado = "SELECT TIPO_DOC,NUM_DOC, PRIMERA_PACIEN, PRIMERA_PROV, 
                            PRIMERA_DIST, PRIMERA_EESS, PRIMERA, PRIMERA_FAB, SEGUNDA_PROV,
                            SEGUNDA_DIST,SEGUNDA_EESS, SEGUNDA, SEGUNDA_FAB 
                            FROM VACUNADOS 
                            WHERE (PRIMERA_PROV='$red' OR SEGUNDA_PROV='$red')";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT TIPO_DOC,NUM_DOC, PRIMERA_PACIEN, PRIMERA_PROV, 
                            PRIMERA_DIST, PRIMERA_EESS, PRIMERA, PRIMERA_FAB, SEGUNDA_PROV,
                            SEGUNDA_DIST,SEGUNDA_EESS, SEGUNDA, SEGUNDA_FAB 
                            FROM VACUNADOS";

        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT TIPO_DOC,NUM_DOC, PRIMERA_PACIEN, PRIMERA_PROV, 
                            PRIMERA_DIST, PRIMERA_EESS, PRIMERA, PRIMERA_FAB, SEGUNDA_PROV,
                            SEGUNDA_DIST,SEGUNDA_EESS, SEGUNDA, SEGUNDA_FAB 
                            FROM VACUNADOS 
                            WHERE (PRIMERA_PROV='$red' OR SEGUNDA_PROV='$red') 
                            AND (PRIMERA_DIST = '$dist' OR SEGUNDA_DIST='$dist')";
        }

        $consulta1 = sqlsrv_query($conn7, $resultado);
    }
?>