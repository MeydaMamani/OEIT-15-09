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

        if (strlen($mes) == 1){
            $mes2 = '0'.$mes;
        }else{
            $mes2 = $mes;
        }

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
        
        $resultado = "SELECT Sector,FINANCIADOR,Provnacido,Distnacido, Numcnv,FECNACIDO,Provdommadre
                        into BDHIS_MINSA.dbo.nacidoscnv
                        FROM NOMINAL_TRAMA_CNV
                        WHERE YEar(FECNACIDO)='2021'";

        $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item--, Fecha_Modificacion 
                        into atencionesneonatal
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.numcnv=a.Numero_Documento_Paciente
                            where n.fecnacido>'2021-$mes2-01' AND Provnacido='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.numcnv=a.Numero_Documento_Paciente
                            where n.fecnacido>'2021-$mes2-01'";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado3 = "SELECT n.*,a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            from nacidoscnv n left join atencionesneonatal a 
                            on N.numcnv=a.Numero_Documento_Paciente
                            where n.fecnacido>'2021-$mes2-01' AND Provnacido='$red' AND Distnacido='$dist'";
        }

        $consulta1 = sqlsrv_query($conn3, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        

        if(!empty($consulta3)){
            $ficheroExcel="SEGUIMIENTO_TMZ_NEONATAL ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;SECTOR;FINANCIADOR;PROVINCIA;DISTRITO;NUMERO_CNV;FECHA_NACIDO;PROVINCIA_MADRE;FECHA_ATENCION;ATENDIDO\n";
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta3)){
                echo $i++.";";
                if(is_null ($consulta['Sector']) ){ echo ' - '.";"; }
                else{ echo $consulta['Sector'].";"; }

                if(is_null ($consulta['FINANCIADOR']) ){ echo ' - '.";"; }
                else{ echo $consulta['FINANCIADOR'].";" ; }

                if(is_null ($consulta['Provnacido']) ){ echo ' - '.";"; }
                else{ echo utf8_encode($consulta['Provnacido']).";"; }

                if(is_null ($consulta['Distnacido']) ){ echo ' - '.";"; }
                else{ echo $consulta['Distnacido'].";" ; }

                if(is_null ($consulta['Numcnv']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numcnv'].";" ; }

                if(is_null ($consulta['FECNACIDO']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECNACIDO']-> format('d/m/y').";" ; }

                if(is_null ($consulta['Provdommadre']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provdommadre'].";" ; }

                if(is_null ($consulta['Fecha_Atencion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Atencion']-> format('d/m/y').";" ; }

                if(is_null ($consulta['ATENDIDO_EN']) ){ echo ' - '."\n"; }
                else{ echo $consulta['ATENDIDO_EN']."\n" ; }

            }   
        }
    }
?>