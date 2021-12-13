<?php
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');

    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

        $resultado = "SELECT Numero_Documento_Paciente,MIN(Fecha_Atencion)AS FECHA_ATENCION
                        INTO BDHIS_MINSA.dbo.PASO_NUM1
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where
                        ((Codigo_Item in ('D500','D508','D509','D649')) AND (Tipo_Diagnostico IN ('D','R'))) AND
                        (Edad_Dias_Paciente_FechaAtencion BETWEEN 170 AND 364)
                        GROUP BY Numero_Documento_Paciente";

        $resultado2 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,NUM_DNI,APELLIDO_MATERNO_NINO,APELLIDO_PATERNO_NINO,NOMBRE_NINO,FECHA_NACIMIENTO_NINO,DATEADD(DAY,544,FECHA_NACIMIENTO_NINO)AS'CUMPLE_544_DIAS',TIPO_SEGURO,B.Fecha_Atencion AS DX_ANEMIA
                        INTO BDHIS_MINSA.dbo.PASO_NUM2
                        FROM NOMINAL_PADRON_NOMINAL A
                        LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM1 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                        WHERE A.MES='202012' and TIPO_SEGURO='MINSA' AND (NUM_DNI IS NOT NULL)";

        $resultado3 = "SELECT A.Numero_Documento_Paciente,
                        --VACUNAS
                        MAX(CASE WHEN ( (A.Tipo_Edad='M' AND A.Edad_Reg BETWEEN 2 AND 11) and  A.Codigo_Item='90712' and (A.Valor_Lab IN ('3','D3'))) THEN Fecha_Atencion ELSE NULL END)  '3° APO',
                        MAX(CASE WHEN ( (A.Tipo_Edad='M' AND A.Edad_Reg BETWEEN 2 AND 11) AND (A.Codigo_Item IN ('90723','Z276') AND (A.Valor_Lab IN ('3','03','D3'))))  THEN Fecha_Atencion ELSE NULL END)  '3° PENTA',
                        MAX(CASE WHEN ( (A.Tipo_Edad='M' AND A.Edad_Reg BETWEEN 2 AND 7) AND (A.Codigo_Item IN ('90681','Z268') AND (A.Valor_Lab IN ('2','02','D2'))) ) THEN Fecha_Atencion ELSE NULL END) '2° ROTA',
                        MAX(CASE WHEN ( (A.Tipo_Edad='A' AND A.Edad_Reg=1) AND (A.Codigo_Item IN ('90669','Z238','90670') AND (A.Valor_Lab IN ('3','03','D3')))  ) THEN Fecha_Atencion ELSE NULL END) '3° NEUMO',
                        MAX(CASE WHEN ( (A.Tipo_Edad='A' AND A.Edad_Reg=1) AND (A.Codigo_Item IN ('90707','Z274') AND (A.Valor_Lab IN ('1','01','D1'))) ) THEN Fecha_Atencion ELSE NULL END) '1° SPR',
                        MAX(CASE WHEN ( (A.Tipo_Edad='M' AND A.Edad_Reg BETWEEN 6 AND 11) AND (A.Codigo_Item IN ('90657','Z2511') AND (A.Valor_Lab IN ('1','01','D1'))) ) THEN Fecha_Atencion ELSE NULL END) '1° INFLUENZA',
                        --CRED
                        MAX(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 29 AND 59)   AND (A.Codigo_Item='Z001'))THEN A.Fecha_Atencion ELSE NULL END)'1CTRL',
                        MAX(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 60 AND 119)  AND (A.Codigo_Item='Z001'))THEN A.Fecha_Atencion ELSE NULL END)'2CTRL',
                        MAX(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 120 AND 179) AND (A.Codigo_Item='Z001'))THEN A.Fecha_Atencion ELSE NULL END)'3CTRL',
                        MAX(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 180 AND 269) AND (A.Codigo_Item='Z001'))THEN A.Fecha_Atencion ELSE NULL END)'4CTRL',
                        MAX(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 270 AND 364) AND (A.Codigo_Item='Z001'))THEN A.Fecha_Atencion ELSE NULL END)'5CTRL',
                        --DOSAJE
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion BETWEEN 170 AND 269) AND (A.Codigo_Item IN ('85018','Z017'))AND Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'DOSAJE_HEMOGLOBINA',
                        --SUPLEMENTACION
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF1','1','P01','PO1')))THEN A.Fecha_Atencion ELSE NULL END)'1 SUPLE',
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF2','2','P02','PO2')))THEN A.Fecha_Atencion ELSE NULL END)'2 SUPLE',
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF3','3','P03','PO3')))THEN A.Fecha_Atencion ELSE NULL END)'3 SUPLE',
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF4','4','P04','PO4')))THEN A.Fecha_Atencion ELSE NULL END)'4 SUPLE',
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF5','5','P05','PO5')))THEN A.Fecha_Atencion ELSE NULL END)'5 SUPLE',
                        MIN(CASE WHEN ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF6','6','P06','PO6')))THEN A.Fecha_Atencion ELSE NULL END)'6 SUPLE'
                        INTO BDHIS_MINSA.dbo.PASO_NUM3
                        FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                        WHERE
                        (
                            ( (A.Tipo_Edad='M'  AND A.Edad_Reg BETWEEN 2 AND 11) and	A.Codigo_Item='90712' and (A.Valor_Lab IN ('3','D3')))OR
                            ( (A.Tipo_Edad='M'  AND A.Edad_Reg BETWEEN 2 AND 11) AND (A.Codigo_Item IN ('90723','Z276') AND (A.Valor_Lab IN ('3','03','D3'))))OR
                            ( (A.Tipo_Edad='M'  AND A.Edad_Reg BETWEEN 2 AND 7) AND (A.Codigo_Item IN ('90681','Z268') AND (A.Valor_Lab IN ('2','02','D2'))) )OR
                            ( (A.Tipo_Edad='A' AND A.Edad_Reg=1) AND (A.Codigo_Item IN ('90669','Z238','90670') AND (A.Valor_Lab IN ('3','03','D3')))  )OR
                            ( (A.Tipo_Edad='A' AND A.Edad_Reg=1) AND (A.Codigo_Item IN ('90707','Z274') AND (A.Valor_Lab IN ('1','01','D1'))) )OR
                            ( (A.Tipo_Edad='M'  AND A.Edad_Reg BETWEEN 6 AND 11) AND (A.Codigo_Item IN ('90657','Z2511') AND (A.Valor_Lab IN ('1','01','D1'))) )OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 29 AND 59) AND (A.Codigo_Item='Z001'))OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 60 AND 119)  AND (A.Codigo_Item='Z001'))OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 120 AND 179) AND (A.Codigo_Item='Z001'))OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 180 AND 269) AND (A.Codigo_Item='Z001'))OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 270 AND 364) AND (A.Codigo_Item='Z001'))OR
                            ((Edad_Dias_Paciente_FechaAtencion BETWEEN 170 AND 269) AND (A.Codigo_Item IN ('85018','Z017'))AND Tipo_Diagnostico='D')OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF1','1','P01','PO1')))OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF2','2','P02','PO2')))OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF3','3','P03','PO3')))OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF4','4','P04','PO4')))OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF5','5','P05','PO5')))OR
                            ((Edad_Dias_Paciente_FechaAtencion>='170' AND(A.Codigo_Item IN ('Z298','99199.17'))  AND A.Valor_Lab IN('SF6','6','P06','PO6')))
                        )
                        GROUP BY A.Numero_Documento_Paciente";


        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn2, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

        $list_total_pro = array();
        $list_dists_pro = array();

        if($_GET){
            $red = $_GET['red'];
            $distrito = $_GET['distrito'];
            $anio = $_GET['anio'];
            $mes = $_GET['mes'];

            if($red == "danielalcidescarrion"){ $red = "DANIEL ALCIDES CARRION"; }
            $red = strtoupper($red);

            if($mes == '-'){
                $resultado4 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-01-01' AND CUMPLE_544_DIAS<='$anio-01-31' THEN NUM_DNI END) 'DEN_ENE',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-02-01' AND CUMPLE_544_DIAS<='$anio-02-28' THEN NUM_DNI END) 'DEN_FEB',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-03-01' AND CUMPLE_544_DIAS<='$anio-03-31' THEN NUM_DNI END) 'DEN_MAR',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-04-01' AND CUMPLE_544_DIAS<='$anio-04-30' THEN NUM_DNI END) 'DEN_ABR',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-05-01' AND CUMPLE_544_DIAS<='$anio-05-31' THEN NUM_DNI END) 'DEN_MAY',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-06-01' AND CUMPLE_544_DIAS<='$anio-06-30' THEN NUM_DNI END) 'DEN_JUN',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-07-01' AND CUMPLE_544_DIAS<='$anio-07-31' THEN NUM_DNI END) 'DEN_JUL',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-08-01' AND CUMPLE_544_DIAS<='$anio-08-31' THEN NUM_DNI END) 'DEN_AGO',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-09-01' AND CUMPLE_544_DIAS<='$anio-09-30' THEN NUM_DNI END) 'DEN_SET',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-10-01' AND CUMPLE_544_DIAS<='$anio-10-31' THEN NUM_DNI END) 'DEN_OCT',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-11-01' AND CUMPLE_544_DIAS<='$anio-11-30' THEN NUM_DNI END) 'DEN_NOV',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-12-01' AND CUMPLE_544_DIAS<='$anio-12-31' THEN NUM_DNI END) 'DEN_DIC'
                                into BDHIS_MINSA.dbo.denominador
                                FROM BDHIS_MINSA.dbo.PASO_NUM2
                                where (DX_ANEMIA IS NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado5 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-01-01' AND CUMPLE_544_DIAS<='$anio-01-31' THEN NUM_DNI END) 'NUM_ENE',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-02-01' AND CUMPLE_544_DIAS<='$anio-02-28' THEN NUM_DNI END) 'NUM_FEB',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-03-01' AND CUMPLE_544_DIAS<='$anio-03-31' THEN NUM_DNI END) 'NUM_MAR',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-04-01' AND CUMPLE_544_DIAS<='$anio-04-30' THEN NUM_DNI END) 'NUM_ABR',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-05-01' AND CUMPLE_544_DIAS<='$anio-05-31' THEN NUM_DNI END) 'NUM_MAY',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-06-01' AND CUMPLE_544_DIAS<='$anio-06-30' THEN NUM_DNI END) 'NUM_JUN',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-07-01' AND CUMPLE_544_DIAS<='$anio-07-31' THEN NUM_DNI END) 'NUM_JUL',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-08-01' AND CUMPLE_544_DIAS<='$anio-08-31' THEN NUM_DNI END) 'NUM_AGO',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-09-01' AND CUMPLE_544_DIAS<='$anio-09-30' THEN NUM_DNI END) 'NUM_SET',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-10-01' AND CUMPLE_544_DIAS<='$anio-10-31' THEN NUM_DNI END) 'NUM_OCT',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-11-01' AND CUMPLE_544_DIAS<='$anio-11-30' THEN NUM_DNI END) 'NUM_NOV',
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-12-01' AND CUMPLE_544_DIAS<='$anio-12-31' THEN NUM_DNI END) 'NUM_DIC'
                                into BDHIS_MINSA.dbo.NUMERADOR
                                FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                                LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                                where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                                (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                                (B.[6 SUPLE] IS NOT NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado6 = "SELECT B.NOMBRE_DEPAR, B.NOMBRE_PROV, B.NOMBRE_DIST, A.NUM_ENE, B.DEN_ENE, A.NUM_FEB, B.DEN_FEB, A.NUM_MAR, B.DEN_MAR, A.NUM_ABR, B.DEN_ABR,
                                A.NUM_MAY, B.DEN_MAY, A.NUM_JUN, B.DEN_JUN, A.NUM_JUL, B.DEN_JUL, A.NUM_AGO, B.DEN_AGO, A.NUM_SET, B.DEN_SET, A.NUM_OCT, B.DEN_OCT, A.NUM_NOV, B.DEN_NOV,
                                A.NUM_DIC, B.DEN_DIC FROM denominador B LEFT JOIN NUMERADOR A ON A.NOMBRE_DIST=B.NOMBRE_DIST
                                WHERE B.NOMBRE_PROV='$red' AND B.NOMBRE_DIST='$distrito'
                                ORDER BY B.NOMBRE_PROV, B.NOMBRE_DIST
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM1
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM2
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM3
                                    DROP TABLE BDHIS_MINSA.dbo.denominador
                                    DROP TABLE BDHIS_MINSA.dbo.NUMERADOR";

                $consulta4 = sqlsrv_query($conn, $resultado4);
                $consulta5 = sqlsrv_query($conn, $resultado5);
                $consulta6 = sqlsrv_query($conn, $resultado6);

                $ene=0; $feb=0; $mar=0; $abr=0; $may=0; $jun=0; $jul=0; $ago=0; $set=0; $oct=0; $nov=0; $dic=0;
                while ($con = sqlsrv_fetch_array($consulta6)){
                    if($con['NUM_ENE'] == 0 and $con['DEN_ENE'] == 0){ $ene = 0; }
                    else{  $ene = number_format((float)(($con['NUM_ENE']/$con['DEN_ENE'])*100), 2, '.', ''); }

                    if($con['NUM_FEB'] == 0 and $con['DEN_FEB'] == 0){ $feb = 0; }
                    else{  $feb = number_format((float)(($con['NUM_FEB']/$con['DEN_FEB'])*100), 2, '.', ''); }

                    if($con['NUM_MAR'] == 0 and $con['DEN_MAR'] == 0){ $mar = 0; }
                    else{  $mar = number_format((float)(($con['NUM_MAR']/$con['DEN_MAR'])*100), 2, '.', ''); }

                    if($con['NUM_ABR'] == 0 and $con['DEN_ABR'] == 0){ $abr = 0; }
                    else{ $abr = number_format((float)(($con['NUM_ABR']/$con['DEN_ABR'])*100), 2, '.', ''); }

                    if($con['NUM_MAY'] == 0 and $con['DEN_MAY'] == 0){ $may = 0; }
                    else{  $may = number_format((float)(($con['NUM_MAY']/$con['DEN_MAY'])*100), 2, '.', ''); }

                    if($con['NUM_JUN'] == 0 and $con['DEN_JUN'] == 0){ $jun = 0; }
                    else{  $jun = number_format((float)(($con['NUM_JUN']/$con['DEN_JUN'])*100), 2, '.', ''); }

                    if($con['NUM_JUL'] == 0 and $con['DEN_JUL'] == 0){ $jul = 0; }
                    else{  $jul = number_format((float)(($con['NUM_JUL']/$con['DEN_JUL'])*100), 2, '.', ''); }

                    if($con['NUM_AGO'] == 0 and $con['DEN_AGO'] == 0){ $ago = 0; }
                    else{  $ago = number_format((float)(($con['NUM_AGO']/$con['DEN_AGO'])*100), 2, '.', ''); }

                    if($con['NUM_SET'] == 0 and $con['DEN_SET'] == 0){ $set = 0; }
                    else{  $set = number_format((float)(($con['NUM_SET']/$con['DEN_SET'])*100), 2, '.', ''); }

                    if($con['NUM_OCT'] == 0 and $con['DEN_OCT'] == 0){ $oct = 0; }
                    else{  $oct = number_format((float)(($con['NUM_OCT']/$con['DEN_OCT'])*100), 2, '.', ''); }

                    if($con['NUM_NOV'] == 0 and $con['DEN_NOV'] == 0){ $nov = 0; }
                    else{  $nov = number_format((float)(($con['NUM_NOV']/$con['DEN_NOV'])*100), 2, '.', ''); }

                    if($con['NUM_DIC'] == 0 and $con['DEN_DIC'] == 0){ $dic = 0; }
                    else{  $dic = number_format((float)(($con['NUM_DIC']/$con['DEN_DIC'])*100), 2, '.', ''); }

                }

                echo $ene, '---', $feb, '---', $mar, '---', $abr, '---', $may, '---', $jun, '---', $jul, '---', $ago, '---', $set, '---', $oct, '---', $nov, '---', $dic, '---';
            }
            else if($red == 'TODOS' && $distrito == "TODOS"){
                $anio = $_GET['anio'];
                $mes = $_GET['mes'];
                $date = "$anio-$mes-01";
                $date_fines = date("t", strtotime($date));
                // echo $date_fines;
                $resultado4 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$anio-$mes-$date_fines' THEN NUM_DNI END) 'DENOMINADOR1'
                                into BDHIS_MINSA.dbo.denominador
                                FROM BDHIS_MINSA.dbo.PASO_NUM2
                                where (DX_ANEMIA IS NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado5 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$anio-$mes-$date_fines' THEN NUM_DNI END) 'NUMERADOR1'
                                into BDHIS_MINSA.dbo.NUMERADOR
                                FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                                LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                                where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                                (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                                (B.[6 SUPLE] IS NOT NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado6 = "SELECT A.NOMBRE_DEPAR,A.NOMBRE_PROV,A.NOMBRE_DIST, NUMERADOR1, DENOMINADOR1
                                    FROM BDHIS_MINSA.dbo.denominador A
                                    LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                                    ORDER BY NOMBRE_PROV, NOMBRE_DIST";

                $consulta4 = sqlsrv_query($conn, $resultado4);
                $consulta5 = sqlsrv_query($conn, $resultado5);
                $consulta6 = sqlsrv_query($conn, $resultado6);
                while ($con = sqlsrv_fetch_array($consulta6)){
                    if($con['NUMERADOR1'] == 0 and $con['DENOMINADOR1'] == 0){ $nov = 0; }
                    else{  $nov = number_format((float)(($con['NUMERADOR1']/$con['DENOMINADOR1'])*100), 2, '.', ''); }
                    $list_total_pro[] = $nov;
                    // $list_dists_pro = $con['NOMBRE_DIST'];
                    if($con['NOMBRE_DIST'] == "SAN FCO DE ASIS DE YARUSYACAN"){ $list_dists = "YARUSYACAN"; }
                    else if($con['NOMBRE_DIST'] == "SAN PEDRO DE PILLAO"){ $list_dists = "PILLAO"; }
                    else if($con['NOMBRE_DIST'] == "SANTA ANA DE TUSI"){ $list_dists = "TUSI"; }
                    else if($con['NOMBRE_DIST'] == "PUERTO BERMUDEZ"){ $list_dists = "P. BERMUDEZ"; }
                    else if($con['NOMBRE_DIST'] == "GOYLLARISQUIZGA"){ $list_dists = "GOYLLAR"; }
                    else{ $list_dists = $con['NOMBRE_DIST']; }
                    echo $nov, '---', $list_dists, '---';
                }

                $resultado7 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$anio-$mes-$date_fines' THEN NUM_DNI END) 'DENOMINADOR1'
                                into BDHIS_MINSA.dbo.DEN_ALL
                                FROM BDHIS_MINSA.dbo.PASO_NUM2
                                where (DX_ANEMIA IS NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV";

                $resultado8 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$anio-$mes-$date_fines' THEN NUM_DNI END) 'NUMERADOR1'
                                into BDHIS_MINSA.dbo.NUM_ALL
                                FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                                LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                                where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                                (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                                (B.[6 SUPLE] IS NOT NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV";

                $resultado9 = "SELECT A.NOMBRE_DEPAR, A.NOMBRE_PROV, B.NUMERADOR1, A.DENOMINADOR1
                                    FROM BDHIS_MINSA.dbo.DEN_ALL A
                                    LEFT JOIN BDHIS_MINSA.dbo.NUM_ALL B ON A.NOMBRE_PROV=B.NOMBRE_PROV
                                    ORDER BY A.NOMBRE_PROV
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM1
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM2
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM3
                                    DROP TABLE BDHIS_MINSA.dbo.denominador
                                    DROP TABLE BDHIS_MINSA.dbo.NUMERADOR
                                    DROP TABLE BDHIS_MINSA.dbo.DEN_ALL
                                    DROP TABLE BDHIS_MINSA.dbo.NUM_ALL";

                $consulta7 = sqlsrv_query($conn, $resultado7);
                $consulta8 = sqlsrv_query($conn, $resultado8);
                $consulta9 = sqlsrv_query($conn, $resultado9);
                $list_dist1 = array(); $cont = 0;
                while ($conex = sqlsrv_fetch_array($consulta9)){
                    if($conex['NUMERADOR1'] == 0 and $conex['DENOMINADOR1'] == 0){ $data = 0; }
                    else{  $data = number_format((float)(($conex['NUMERADOR1']/$conex['DENOMINADOR1'])*100), 2, '.', ''); }
                    echo $data, '---';
                }
                // $num_dists = sizeof($list_dist1);    
                // echo $num_dists;
                // for ($i = 0; $i < $num_dists; $i++) {
                //     $data = ($list_dist1[$i]);
                //     // echo $data;
                // }
                
            }
            else{
                $date_fin = date("Y-m-t", strtotime($anio-$mes-01));
                $resultado4 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'DENOMINADOR1'
                                into BDHIS_MINSA.dbo.denominador
                                FROM BDHIS_MINSA.dbo.PASO_NUM2
                                where (DX_ANEMIA IS NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado5 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                                COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'NUMERADOR1'
                                into BDHIS_MINSA.dbo.NUMERADOR
                                FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                                LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                                where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                                (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                                (B.[6 SUPLE] IS NOT NULL)
                                GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

                $resultado6 = "SELECT A.NOMBRE_DEPAR,A.NOMBRE_PROV,A.NOMBRE_DIST, NUMERADOR1, DENOMINADOR1
                                    FROM BDHIS_MINSA.dbo.denominador A
                                    LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                                    WHERE A.NOMBRE_PROV='$red'
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM1
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM2
                                    DROP TABLE BDHIS_MINSA.dbo.PASO_NUM3
                                    DROP TABLE BDHIS_MINSA.dbo.denominador
                                    DROP TABLE BDHIS_MINSA.dbo.NUMERADOR";

                $consulta4 = sqlsrv_query($conn, $resultado4);
                $consulta5 = sqlsrv_query($conn, $resultado5);
                $consulta6 = sqlsrv_query($conn, $resultado6);

                while ($con = sqlsrv_fetch_array($consulta6)){
                    if($con['NUMERADOR1'] == 0 and $con['DENOMINADOR1'] == 0){ $nov = 0; }
                    else{  $nov = number_format((float)(($con['NUMERADOR1']/$con['DENOMINADOR1'])*100), 2, '.', ''); }
                    $list_total_pro[] = $nov;
                    // $list_dists_pro = $con['NOMBRE_DIST'];
                    if($con['NOMBRE_DIST'] == "SAN FCO DE ASIS DE YARUSYACAN"){ $list_dists = "YARUSYACAN"; }
                    else if($con['NOMBRE_DIST'] == "SAN PEDRO DE PILLAO"){ $list_dists = "PILLAO"; }
                    else if($con['NOMBRE_DIST'] == "SANTA ANA DE TUSI"){ $list_dists = "TUSI"; }
                    else if($con['NOMBRE_DIST'] == "PUERTO BERMUDEZ"){ $list_dists = "P. BERMUDEZ"; }
                    else if($con['NOMBRE_DIST'] == "GOYLLARISQUIZGA"){ $list_dists = "GOYLLAR"; }
                    else{ $list_dists = $con['NOMBRE_DIST']; }
                    echo $nov, '---', $list_dists, '---';
                }
            }
        }
        else{
            $dist_1 = 'POZUZO';
            $anio = date("Y");
            $mes = date("m");

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

            $dist=$dist_1;

            $date_fin = date("Y-m-t", strtotime($anio-$mes-01));
            $resultado4 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'DENOMINADOR1'
                            into BDHIS_MINSA.dbo.denominador
                            FROM BDHIS_MINSA.dbo.PASO_NUM2
                            where (DX_ANEMIA IS NULL)
                            GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

            $resultado5 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST,
                            COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'NUMERADOR1'
                            into BDHIS_MINSA.dbo.NUMERADOR
                            FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                            where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                            (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                            (B.[6 SUPLE] IS NOT NULL)
                            GROUP BY NOMBRE_DEPAR,NOMBRE_PROV,NOMBRE_DIST";

            $resultado6 = "SELECT A.NOMBRE_DEPAR,A.NOMBRE_PROV,A.NOMBRE_DIST, NUMERADOR1, DENOMINADOR1
                                FROM BDHIS_MINSA.dbo.denominador A
                                LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR B ON A.NOMBRE_DIST=B.NOMBRE_DIST
                                ORDER BY NOMBRE_PROV, NOMBRE_DIST";

            $consulta4 = sqlsrv_query($conn, $resultado4);
            $consulta5 = sqlsrv_query($conn, $resultado5);
            $consulta6 = sqlsrv_query($conn, $resultado6);

            $resultado7 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,
                            COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'DENOMINADOR1'
                            into BDHIS_MINSA.dbo.denominador_pro
                            FROM BDHIS_MINSA.dbo.PASO_NUM2
                            where (DX_ANEMIA IS NULL)
                            GROUP BY NOMBRE_DEPAR,NOMBRE_PROV";

            $resultado8 = "SELECT NOMBRE_DEPAR,NOMBRE_PROV,
                            COUNT(CASE WHEN CUMPLE_544_DIAS>='$anio-$mes-01' AND CUMPLE_544_DIAS<='$date_fin' THEN NUM_DNI END) 'NUMERADOR1'
                            into BDHIS_MINSA.dbo.NUMERADOR_PRO
                            FROM BDHIS_MINSA.dbo.PASO_NUM2 A
                            LEFT JOIN BDHIS_MINSA.dbo.PASO_NUM3 B ON A.NUM_DNI=B.Numero_Documento_Paciente
                            where (DX_ANEMIA IS NULL)AND (B.[3° APO] IS NOT NULL) AND (B.[3° PENTA] IS NOT NULL) AND (B.[2° ROTA] IS NOT NULL)AND (B.[3° NEUMO] IS NOT NULL)AND (B.[1° SPR] IS NOT NULL)AND (B.[1° INFLUENZA] IS NOT NULL) AND (B.[1CTRL] IS NOT NULL)AND (B.[2CTRL] IS NOT NULL)AND
                            (B.[3CTRL] IS NOT NULL)AND (B.[4CTRL] IS NOT NULL)AND (B.[5CTRL] IS NOT NULL)AND (B.[DOSAJE_HEMOGLOBINA] IS NOT NULL)AND (B.[1 SUPLE] IS NOT NULL)AND (B.[2 SUPLE] IS NOT NULL)AND (B.[3 SUPLE] IS NOT NULL)AND (B.[4 SUPLE] IS NOT NULL)AND (B.[5 SUPLE] IS NOT NULL)AND
                            (B.[6 SUPLE] IS NOT NULL)
                            GROUP BY NOMBRE_DEPAR,NOMBRE_PROV";

            $resultado9 = "SELECT A.NOMBRE_PROV, NUMERADOR1, DENOMINADOR1
                                FROM BDHIS_MINSA.dbo.denominador_pro A
                                LEFT JOIN BDHIS_MINSA.dbo.NUMERADOR_PRO B ON A.NOMBRE_PROV=B.NOMBRE_PROV
                                ORDER BY NOMBRE_PROV
                                DROP TABLE BDHIS_MINSA.dbo.PASO_NUM1
                                DROP TABLE BDHIS_MINSA.dbo.PASO_NUM2
                                DROP TABLE BDHIS_MINSA.dbo.PASO_NUM3
                                DROP TABLE BDHIS_MINSA.dbo.denominador
                                DROP TABLE BDHIS_MINSA.dbo.NUMERADOR
                                DROP TABLE BDHIS_MINSA.dbo.denominador_pro
                                DROP TABLE BDHIS_MINSA.dbo.NUMERADOR_PRO";

            $consulta7 = sqlsrv_query($conn, $resultado7);
            $consulta8 = sqlsrv_query($conn, $resultado8);
            $consulta9 = sqlsrv_query($conn, $resultado9);
        }
        // $my_date_modify = "SELECT MAX(FECHA_MODIFICACION_REGISTRO) as DATE_MODIFY FROM NOMINAL_PADRON_NOMINAL";
        // $consult = sqlsrv_query($conn2, $my_date_modify);
        // while ($cons = sqlsrv_fetch_array($consult)){
        //     $date_modify = $cons['DATE_MODIFY'] -> format('d/m/y');
        // }

        // }
    // }
?>

