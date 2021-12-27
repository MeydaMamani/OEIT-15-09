<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php'); 

    if (isset($_POST['Buscar'])) {        
        global $conex;

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];

        if($mes == 1){ $nombre_mes = 'Enero'; }
        else if($mes == 2){ $nombre_mes = 'Febrero'; }
        else if($mes == 3){ $nombre_mes = 'Marzo'; }
        else if($mes == 4){ $nombre_mes = 'Abril'; }
        else if($mes == 5){ $nombre_mes = 'Mayo'; }
        else if($mes == 6){ $nombre_mes = 'Junio'; }
        else if($mes == 7){ $nombre_mes = 'Julio'; }
        else if($mes == 8){ $nombre_mes = 'Agosto'; }
        else if($mes == 9){ $nombre_mes = 'Setiembre'; }
        else if($mes == 10){ $nombre_mes = 'Octubre'; }
        else if($mes == 11){ $nombre_mes = 'Noviembre'; }
        else if($mes == 12){ $nombre_mes = 'Diciembre'; }

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
          $red = 'TODOS';
        }

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='$anio' AND Provincia_Establecimiento='$red'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='$anio' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='$anio'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='$anio' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='$anio' AND Provincia_Establecimiento='$red' AND  Distrito_Establecimiento='$dist'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='$anio' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        
        $consulta1 = sqlsrv_query($conn, $resultado);
    }
?>