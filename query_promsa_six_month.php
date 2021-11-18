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
            // SIN ANEMIA VISITA
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                    AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND Mes='$mes'";
            
            // CON ANEMIA VISITA
            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            
                            AND MES='$mes'";
            // SIN ANEMIA NOMINAL
            $resultado3 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                            AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND MES ='$mes'";

            $resultado4 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'";
           // SIN ANEMIA RESUMEN
            $resultado5 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado7 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_SIN_ANEMIA A
                            LEFT JOIN NUMERADOR_6_11_MESES_SIN_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST";

            // CON ANEMIA NOMINAL
            $resultado8 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD CON DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND MES ='$mes'";

            $resultado9 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'";
            
            //CON ANEMIA PARA RESUMEN
            $resultado10 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado11 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado12 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_CON_ANEMIA A
                                LEFT JOIN NUMERADOR_6_11_MESES_CON_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST";
        }
        else if ($red_1 != 4 and $dist_1 == 'TODOS' and $establecimiento == 'TODOS') {
            $dist = '';
            // SIN ANEMIA VISITA
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                    AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'";
            
            // CON ANEMIA VISITA
            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            
                            AND MES='$mes' AND Provincia_Establecimiento='$red'";

            // SIN ANEMIA NOMINAL
            $resultado3 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                            AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND MES ='$mes' AND Provincia_Establecimiento='$red'";

            $resultado4 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red'";
           // SIN ANEMIA RESUMEN
            $resultado5 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND p.NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado7 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_SIN_ANEMIA A
                            LEFT JOIN NUMERADOR_6_11_MESES_SIN_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE A.NOMBRE_PROV='$red'";

            // CON ANEMIA NOMINAL
            $resultado8 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD CON DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND MES ='$mes' AND Provincia_Establecimiento='$red'";

            $resultado9 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red'";
            
            //CON ANEMIA PARA RESUMEN
            $resultado10 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND p.NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado11 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado12 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_CON_ANEMIA A
                                LEFT JOIN NUMERADOR_6_11_MESES_CON_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                                WHERE A.NOMBRE_PROV='$red'";
                            
        }
        else if($dist_1 != 'TODOS' and $establecimiento != 'TODOS'){
            $dist=$dist_1;
            // SIN ANEMIA VISITA
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                    AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'";
            
            // CON ANEMIA VISITA
            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            
                            AND MES='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'";

            // SIN ANEMIA NOMINAL
            $resultado3 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                            AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND MES ='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'";

            $resultado4 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist' AND NOMBRE_EESS='$establecimiento'";
           // SIN ANEMIA RESUMEN
            $resultado5 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado7 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_SIN_ANEMIA A
                            LEFT JOIN NUMERADOR_6_11_MESES_SIN_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE A.NOMBRE_PROV='$red'";

            // CON ANEMIA NOMINAL
            $resultado8 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD CON DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND MES ='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist' AND Nombre_Establecimiento='$establecimiento'";

            $resultado9 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist' AND NOMBRE_EESS='$establecimiento'";
            
            //CON ANEMIA PARA RESUMEN
            $resultado10 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado11 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND NOMBRE_PROV='$red'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado12 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_CON_ANEMIA A
                                LEFT JOIN NUMERADOR_6_11_MESES_CON_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                                WHERE A.NOMBRE_PROV='$red'";

        }
        else if($dist_1 != 'TODOS' and $establecimiento == 'TODOS'){
            $dist=$dist_1;
            // SIN ANEMIA VISITA
            $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                    AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";
            
            // CON ANEMIA VISITA
            $resultado2 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            
                            AND MES='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";

            // SIN ANEMIA NOMINAL
            $resultado3 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6')) )
                                            AND  Codigo_Item IN ('99199.17','99199.19') AND Tipo_Diagnostico='D'
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD SIN DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE Anio='2021'  AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                            )
                                            AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                            AND MES ='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";

            $resultado4 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'";
           // SIN ANEMIA RESUMEN
            $resultado5 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_SIN_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_SIN_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND NOMBRE_DIST='$red' AND NOMBRE_DIST='$dist'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado7 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_SIN_ANEMIA A
                            LEFT JOIN NUMERADOR_6_11_MESES_SIN_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                            WHERE NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'";

            // CON ANEMIA NOMINAL
            $resultado8 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion,'PRESENCIAL'ACTIVIDAD,'1'VISITADO 
                            INTO bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='C0011' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND Mes='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            UNION ALL
                            --REGISTRO(13)TELEORIENTACIÓN A NIÑOS DE 6 A 11 MESES DE EDAD CON DX.ANEMIA 
                            SELECT Provincia_Establecimiento, Distrito_Establecimiento, Nombre_Establecimiento,mes,Fecha_Nacimiento_Paciente,Numero_Documento_Paciente,
                            Codigo_Item, Descripcion_Item,Fecha_Atencion, 'TELEORIENTACIÓN' ACTIVIDAD, '1' VISITADO FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA 
                            WHERE Id_Cita IN (
                                            SELECT ID_CITA FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                                    WHERE Id_Cita IN (
                                                    SELECT Id_Cita FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA WHERE  Anio='2021'AND Codigo_Item='99499.08' AND Tipo_Diagnostico='D' AND (Valor_Lab IN ('4','5','6'))
                                                                    )AND  (Codigo_Item IN ('99199.17','99199.19')) AND Tipo_Diagnostico='D'
                                            )AND ((Codigo_Item IN ('D500','D508','D509','D649')) AND Tipo_Diagnostico='R' AND (Valor_Lab IN ('LEV','MOD','SEV')))
                            AND MES ='$mes' AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";

            $resultado9 = "SELECT p.NOMBRE_PROV, P.NOMBRE_DIST, P.MENOR_VISITADO, P.MENOR_ENCONTRADO, P.NOMBRE_EESS_NACIMIENTO, P.NOMBRE_EESS,
                            P.NUM_CNV, P.NUM_DNI, P.APELLIDO_PATERNO_NINO, P.APELLIDO_MATERNO_NINO, P.NOMBRE_NINO, P.FECHA_NACIMIENTO_NINO,
                            P.TIPO_SEGURO, P.TIPO_PROGRAMA_SOCIAL, P.FECHA_MODIFICACION_REGISTRO, '1'BDTOTAL, V.Fecha_Atencion, V.ACTIVIDAD, V.VISITADO
                            FROM NOMINAL_PADRON_NOMINAL p left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V
                            ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes2' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021'
                            AND NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'";
            
            //CON ANEMIA PARA RESUMEN
            $resultado10 = "SELECT p.NOMBRE_PROV,p.NOMBRE_DIST,COUNT(*) AS DENOMINADOR
                            INTO DENOMINADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' 
                            AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST";

            $resultado11 = "SELECT NOMBRE_PROV,NOMBRE_DIST, COUNT(*) AS NUMERADOR 
                            INTO NUMERADOR_6_11_MESES_CON_ANEMIA 
                            FROM [BD_PADRON_NOMINAL].[dbo].[NOMINAL_PADRON_NOMINAL] P
                            left join bd_padron_nominal.dbo.VISITADOS_6_11_CON_ANEMIA V ON P.NUM_DNI=V.Numero_Documento_Paciente
                            WHERE P.MES='2021$mes' AND MONTH(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='$mes' AND  YEAR(DATEADD(DAY,180,P.FECHA_NACIMIENTO_NINO))='2021' AND ACTIVIDAD IS NOT NULL 
                            AND Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'
                            GROUP BY NOMBRE_PROV,NOMBRE_DIST ";

            $resultado12 = "SELECT A.NOMBRE_PROV,A.NOMBRE_DIST,A.DENOMINADOR,B.NUMERADOR FROM DENOMINADOR_6_11_MESES_CON_ANEMIA A
                                LEFT JOIN NUMERADOR_6_11_MESES_CON_ANEMIA B ON  A.NOMBRE_DIST=B.NOMBRE_DIST
                                WHERE NOMBRE_PROV='$red' AND NOMBRE_DIST='$dist'";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn2, $resultado4);
        $consulta5 = sqlsrv_query($conn2, $resultado5);
        $consulta6 = sqlsrv_query($conn2, $resultado6);
        $consulta7 = sqlsrv_query($conn2, $resultado7);
        $consulta8 = sqlsrv_query($conn, $resultado8);
        $consulta9 = sqlsrv_query($conn2, $resultado9);
        $consulta10 = sqlsrv_query($conn2, $resultado10);
        $consulta11 = sqlsrv_query($conn2, $resultado11);
        $consulta12 = sqlsrv_query($conn2, $resultado12);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>