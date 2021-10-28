<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');   
    require('abrir4.php'); 
 
    if(isset($_POST["exportarCSV"])) {
        ini_set("default_charset", "UTF-8");
        global $conex;
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
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
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021' AND Provincia_Establecimiento='$red'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT DISTINCT(Numero_Documento_Personal),Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Descripcion_Profesion, mes, 
                            concat(Nombres_Personal,' ',Apellido_Paterno_Paciente) PERSONAL
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where mes='$mes'and anio='2021' AND Provincia_Establecimiento='$red' AND  Distrito_Establecimiento='$dist'
                                and Codigo_Item in('99208','99402.04', 'Z3491','Z3492','Z3493','Z3591','Z3592','Z3593', 'z001',
                                '90585', '90744', '90712', '90713', '90723', '90681', '90670', '90657', '90658','90707', '90717','90701','Z298')
                            AND ID_CITA not IN (SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Codigo_Item in ('99499.01','99499.08','99499.10') 
                            AND ANIO='2021' AND MES='$mes')
                            ORDER BY Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Nombre_Establecimiento, Numero_Documento_Personal";
        }
        
        $consulta1 = sqlsrv_query($conn, $resultado);        

        if(!empty($consulta1)){
            $ficheroExcel="PROFESIONALES_EPP ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;CODIGO_IPRESS;ESTABLECIMIENTO;DOCUMENTO;PERSONAL;PROFESION\n";
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta1)){
                echo $i++.";";
                if(is_null ($consulta['Provincia_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provincia_Establecimiento'].";"; }

                if(is_null ($consulta['Distrito_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Distrito_Establecimiento'].";"; }

                if(is_null ($consulta['Codigo_Unico']) ){ echo ' - '.";"; }
                else{ echo $consulta['Codigo_Unico'].";"; }

                if(is_null ($consulta['Nombre_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Nombre_Establecimiento'].";"; }

                if(is_null ($consulta['Numero_Documento_Personal']) ){ echo ' - '.";"; }
                else{ echo sprintf('%08d', $consulta['Numero_Documento_Personal']).";"; }
                
                if(is_null ($consulta['PERSONAL']) ){ echo ' - '.";"; }
                else{ echo $consulta['PERSONAL'].";"; }

                if(is_null ($consulta['Descripcion_Profesion']) ){ echo ' - '."\n"; }
                else{ echo $consulta['Descripcion_Profesion']."\n"; }

            }   
        }
    }
?>