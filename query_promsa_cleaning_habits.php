<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
        global $conex;
        
        $red_1 = $_POST['red2'];
        $dist_1 = $_POST['distrito2'];
        $establecimiento = $_POST['establecimiento2'];
        $mes = $_POST['mes2'];

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

        if($red_1 == 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS'){
            // echo 'Estoy AQUI TODOS';
            $resultado1 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,ANIO,MES, Codigo_Item, Descripcion_Item,Valor_Lab,COUNT(*)AS TOTAL
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                                        SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE (Anio='2021' AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' )
                                                    )AND  Codigo_Item='99401.13' AND Tipo_Diagnostico='D' and Valor_Lab='RS'
                                            )AND Codigo_Item IN ('99401.13') AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('1','2','3','4'))
                            AND mes='$mes'
                                            GROUP BY Departamento_Establecimiento,Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,Anio,Mes,Codigo_Item,Descripcion_Item,Valor_Lab
                            ";
            $resultado2 = "SELECT a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'TELEORIENTACIÓN' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' and codigo_item='99499.08' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad
                            
                            union all
                            select a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'PRESENCIAL' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' and codigo_item='C0011' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad";

        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS') {
            $dist = '';
            $resultado1 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,ANIO,MES, Codigo_Item, Descripcion_Item,Valor_Lab,COUNT(*)AS TOTAL
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                                        SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE (Anio='2021' AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' )
                                                    )AND  Codigo_Item='99401.13' AND Tipo_Diagnostico='D' and Valor_Lab='RS'
                                            )AND Codigo_Item IN ('99401.13') AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('1','2','3','4'))
                            AND mes='$mes' AND Provincia_Establecimiento='$red'
                                            GROUP BY Departamento_Establecimiento,Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,Anio,Mes,Codigo_Item,Descripcion_Item,Valor_Lab
                            ";
            $resultado2 = "SELECT a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'TELEORIENTACIÓN' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red' and codigo_item='99499.08' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad
                            
                            union all
                            select a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'PRESENCIAL' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red' and codigo_item='C0011' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad";
        }
        else if($dist_1 != 'TODOS' and $establecimiento != 'TODOS'){
            $dist=$dist_1;
            $resultado1 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,ANIO,MES, Codigo_Item, Descripcion_Item,Valor_Lab,COUNT(*)AS TOTAL
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                                        SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE (Anio='2021' AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' )
                                                    )AND  Codigo_Item='99401.13' AND Tipo_Diagnostico='D' and Valor_Lab='RS'
                                            )AND Codigo_Item IN ('99401.13') AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('1','2','3','4'))
                            AND mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                                            GROUP BY Departamento_Establecimiento,Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,Anio,Mes,Codigo_Item,Descripcion_Item,Valor_Lab
                            ";
            $resultado2 = "SELECT a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'TELEORIENTACIÓN' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red'  AND Distrito_Establecimiento='$dist' and codigo_item='99499.08' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad
                            
                            union all
                            select a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'PRESENCIAL' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'  and codigo_item='C0011' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad";
        }
        else if($dist_1 != 'TODOS' and $establecimiento == 'TODOS'){
            $dist=$dist_1;
            $resultado1 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,ANIO,MES, Codigo_Item, Descripcion_Item,Valor_Lab,COUNT(*)AS TOTAL
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                                        SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE (Anio='2021' AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' )
                                                    )AND  Codigo_Item='99401.13' AND Tipo_Diagnostico='D' and Valor_Lab='RS'
                                            )AND Codigo_Item IN ('99401.13') AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('1','2','3','4'))
                            AND mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                                            GROUP BY Departamento_Establecimiento,Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,Anio,Mes,Codigo_Item,Descripcion_Item,Valor_Lab
                            ";
            $resultado2 = "SELECT a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'TELEORIENTACIÓN' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' and codigo_item='99499.08' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad
                            
                            union all
                            select a.*, count(*)Total from (
                            select Provincia_Establecimiento,Distrito_Establecimiento,Nombre_Establecimiento,mes,'PRESENCIAL' Actividad
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSa
                            where anio ='2021' AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' and codigo_item='C0011' and tipo_diagnostico='D' and id_cita in
                            (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Codigo_Item='99401.24' and Tipo_Diagnostico='D' and Valor_Lab='RS'))a
                            group by a.Provincia_Establecimiento,a.distrito_Establecimiento, a.Nombre_Establecimiento, a.mes,a.actividad";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        // $consulta2 = sqlsrv_query($conn, $resultado2);
        // $consulta3 = sqlsrv_query($conn2, $resultado3);
        // $consulta4 = sqlsrv_query($conn2, $resultado4);
        // $consulta5 = sqlsrv_query($conn2, $resultado5);
        // $consulta6 = sqlsrv_query($conn2, $resultado6);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>