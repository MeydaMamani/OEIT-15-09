<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;        
        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];

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
    }
?>