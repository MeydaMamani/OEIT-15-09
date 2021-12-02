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
    
        $resultado = "SELECT distinct(Numero_Documento_Paciente), 'PREMATURO' PREMATURO
                        INTO bdhis_minsa_externo.dbo.PREMATURO1
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where anio='2021' and codigo_item in ('P0711','P0712','P0713','P073')";

        $resultado2 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO, 'DOCUMENTO' = CASE 
                            WHEN pn.NUM_DNI IS NOT NULL
                            THEN pn.NUM_DNI
                            ELSE pn.NUM_CNV
                        END,
                        CONCAT(pn.APELLIDO_PATERNO_NINO,' ',pn.APELLIDO_MATERNO_NINO,' ', pn.NOMBRE_NINO) APELLIDOS_NOMBRES,
                        pn.TIPO_SEGURO, pn.NOMBRE_EESS ULTIMA_ATE_PN INTO BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                        from NOMINAL_PADRON_NOMINAL pn
                        where YEAR  (DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='2021' and month(DATEADD(DAY,130,FECHA_NACIMIENTO_NINO))='$mes'
                        and mes='2021$mes2';
                        with c as ( select DOCUMENTO,  ROW_NUMBER() 
                                over(partition by DOCUMENTO order by DOCUMENTO) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 )
                        delete  from c
                        where duplicado >1";

        $resultado3 = "SELECT Numero_Documento_Paciente, Fecha_Atencion, Tipo_Doc_Paciente,Edad_Dias_Paciente_FechaAtencion
                        INTO BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        -- WHERE ANIO='2021' AND (Fecha_Atencion>='2021-07-20' and Fecha_Atencion<='2021-08-31')
                        WHERE ANIO='2021' AND (Fecha_Atencion >= CONVERT(DATE, DATEADD(dd, -110, CONCAT('2021$mes2', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))) 
                        and Fecha_Atencion<=CONCAT('2021-$mes2-', DAY(DATEADD(DD,-1,DATEADD(MM,DATEDIFF(MM,-1,'01/$mes2/2021'),0)))))
                        AND Tipo_Diagnostico='D' AND (Codigo_Item IN ('Z298','99199.17') AND VALOR_LAB IN ('SF1','PO1','P01')) AND EDAD_REG in ('3','4') AND Tipo_Edad='M'
                        ORDER BY Fecha_Atencion;
                        with c as ( select numero_documento_paciente,  ROW_NUMBER() 
                                over(partition by numero_documento_paciente order by numero_documento_paciente) as duplicado
                        from BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41)
                        delete  from c
                        where duplicado >1";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 pn
                    LEFT JOIN bdhis_minsa_externo.dbo.PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red'
                    ORDER BY pn.NOMBRE_PROV, pn.NOMBRE_DIST
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                                pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                                P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                            from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 pn
                            LEFT JOIN bdhis_minsa_externo.dbo.PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                            LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente
                            ORDER BY pn.NOMBRE_PROV, pn.NOMBRE_DIST
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                            DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado4 = "SELECT pn.NOMBRE_PROV, pn.NOMBRE_DIST,pn.NOMBRE_EESS EESS_ATENCION,pn.MENOR_VISITADO,PN.MENOR_ENCONTRADO,pn.NUM_DNI,pn.NUM_CNV,
                        pn.FECHA_NACIMIENTO_NINO,PN.DOCUMENTO,PN.APELLIDOS_NOMBRES,
                        P.PREMATURO, S.Edad_Dias_Paciente_FechaAtencion SUPLEMENTADO ,pn.NOMBRE_EESS ULTIMA_ATE_PN, pn.TIPO_SEGURO
                    from BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41 pn
                    LEFT JOIN bdhis_minsa_externo.dbo.PREMATURO1 P ON PN.DOCUMENTO=P.NUMERO_DOCUMENTO_PACIENTE
                    LEFT JOIN BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41 S ON PN.DOCUMENTO=S.Numero_Documento_Paciente WHERE pn.NOMBRE_PROV ='$red' AND pn.NOMBRE_DIST ='$dist'
                    ORDER BY pn.NOMBRE_PROV, pn.NOMBRE_DIST
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PREMATURO1
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.PADRON_EVALUAR41
                    DROP TABLE BDHIS_MINSA_EXTERNO.dbo.SUPLEMENTADO41";
        }

        $consulta2 = sqlsrv_query($conn, $resultado);
        $consulta3 = sqlsrv_query($conn2, $resultado2);
        $consulta4 = sqlsrv_query($conn, $resultado3);
        $consulta5 = sqlsrv_query($conn4, $resultado4);

        $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        $consult = sqlsrv_query($conn2, $my_date_modify);
        while ($cons = sqlsrv_fetch_array($consult)){
            $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        }
    }
?>