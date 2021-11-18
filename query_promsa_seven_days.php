<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');
    require('abrir4.php');

    if (isset($_POST['Buscar'])) {
        global $conex;
        
        $red_1 = $_POST['red1'];
        $dist_1 = $_POST['distrito1'];
        $establecimiento = $_POST['establecimiento1'];
        $mes = $_POST['mes1'];

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
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'PRESENCIAL' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Tipo_Diagnostico='D' AND Codigo_Item in ('99401.03','99401.04','99401.10','99401.08') 
                            and Edad_Dias_Paciente_FechaAtencion <='7' AND
                            Id_Cita in (Select id_cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                        where anio='2021' and Codigo_Item ='C0011' AND Tipo_Diagnostico='D' 
                                        AND Edad_Dias_Paciente_FechaAtencion<='7'	)
                            AND Mes='$mes'
                            UNION ALL
                            ----  NI�OS CON VISITA HASTA 7 DIAS POR TELEMONITOREO
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento, Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item,'TELEMONITOREO' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Tipo_Diagnostico='D' AND Codigo_Item in ('99401.03','99401.04','99401.10','99401.08') 
                            and Edad_Dias_Paciente_FechaAtencion <='7' AND
                            Id_Cita in (Select id_cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                        where anio='2021' and Codigo_Item ='99499.08' AND Tipo_Diagnostico='D' 
                                        AND Edad_Dias_Paciente_FechaAtencion<='7')
                            AND Mes='$mes'";

        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS') {
            $dist = '';
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'PRESENCIAL' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'TELEMONITOREO' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2') 
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'";

            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL' ACTIVIDAD,'1'VISITADO
                            INTO bd_padron_nominal.dbo.VISITADOS
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item, Fecha_Atencion,'TELEMONITOREO'ACTIVIDAD, '1' VISITADO 
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2')";

            $resultado3 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red'"; 

            $resultado4 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado5 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*)  AS NUMERADOR 
                            INTO NUMERADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST, A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_4_MESES A
                            INNER JOIN NUMERADOR_4_MESES  B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE A.NOMBRE_PROV = '$red'
                            ORDER BY A.NOMBRE_PROV,A.NOMBRE_DIST";
                            
        }
        else if($dist_1 != 'TODOS' and $establecimiento != 'TODOS'){
            $dist=$dist_1;
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'PRESENCIAL' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'TELEMONITOREO' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2') 
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'";

            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL' ACTIVIDAD,'1'VISITADO
                            INTO bd_padron_nominal.dbo.VISITADOS
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item, Fecha_Atencion,'TELEMONITOREO'ACTIVIDAD, '1' VISITADO 
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2')";

            $resultado3 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist' AND NOMBRE_EESS='$establecimiento'
                            DROP TABLE bd_padron_nominal.dbo.VISITADOS";

            $resultado4 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado5 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*)  AS NUMERADOR 
                            INTO NUMERADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST, A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_4_MESES A
                            INNER JOIN NUMERADOR_4_MESES  B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE A.NOMBRE_PROV = '$red'
                            ORDER BY A.NOMBRE_PROV,A.NOMBRE_DIST";

        }
        else if($dist_1 != 'TODOS' and $establecimiento == 'TODOS'){
            $dist=$dist_1;
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'PRESENCIAL' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,MES,Codigo_Item, Descripcion_Item, 'TELEMONITOREO' ACTIVIDAD
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2') 
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";

            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL' ACTIVIDAD,'1'VISITADO
                            INTO bd_padron_nominal.dbo.VISITADOS
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='C0011' and valor_lab='2')
                            UNION ALL
                            --- VIITAS 4 MESES X TELEMONITOREO
                            ----visitas 4 meses
                            select Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item, Fecha_Atencion,'TELEMONITOREO'ACTIVIDAD, '1' VISITADO 
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and Edad_Reg='4' and Tipo_Edad='M' and Codigo_Item in ('Z298','99199.17') and Tipo_Diagnostico='D' and 
                            id_cita in (select Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA where anio='2021'and Codigo_Item='99499.08' and valor_lab='2')";

            $resultado3 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'";

            $resultado4 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado5 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*)  AS NUMERADOR 
                            INTO NUMERADOR_4_MESES
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,120,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST, A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_4_MESES A
                            INNER JOIN NUMERADOR_4_MESES  B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE A.NOMBRE_PROV = '$red'
                            ORDER BY A.NOMBRE_PROV,A.NOMBRE_DIST";            
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
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