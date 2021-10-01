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
           
        if($red_1 == 1 or $red_1 == 2 or $red_1 == 3 and $dist_1 == 'TODOS'){
            $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'PROBLEMAS_RELACIONADOS_CON_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_TRATAMIENTO'
                            INTO PASO1
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))  OR                                    
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                            gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";
                            
            $resultado2 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,
                                SUM(CASE WHEN(GESTANTES_ATENDIDAS IS NOT NULL )THEN 1 ELSE 0 END)AS GESTANTES_ATENDIDAS,
                                SUM(CASE WHEN((TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS TAMIZAJE_VIOLENCIA,
                                SUM(CASE WHEN(([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA,
                                SUM(CASE WHEN(([DIAGNOSTICO_TRATAMIENTO]IS NOT NULL) AND ([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO
                                FROM PASO1
                                GROUP BY Provincia_Establecimiento,Distrito_Establecimiento
                                DROP TABLE PASO1";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'PROBLEMAS_RELACIONADOS_CON_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_TRATAMIENTO'
                            INTO PASO1
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE
                            ( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))  OR                                    
                            ( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                            ( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                            ( (Anio='2021' AND Mes='$mes') and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                            gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";
                            
            $resultado2 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,
                                SUM(CASE WHEN(GESTANTES_ATENDIDAS IS NOT NULL )THEN 1 ELSE 0 END)AS GESTANTES_ATENDIDAS,
                                SUM(CASE WHEN((TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS TAMIZAJE_VIOLENCIA,
                                SUM(CASE WHEN(([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA,
                                SUM(CASE WHEN(([DIAGNOSTICO_TRATAMIENTO]IS NOT NULL) AND ([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO
                                FROM PASO1
                                GROUP BY Provincia_Establecimiento,Distrito_Establecimiento
                                DROP TABLE PASO1";
        }
        else{
            $dist=$dist_1;
            $resultado = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente,
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))                                      THEN Fecha_Atencion ELSE NULL END )AS 'GESTANTES_ATENDIDAS',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))THEN Fecha_Atencion ELSE NULL END )AS 'TAMIZAJE_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) )                                                                          THEN Fecha_Atencion ELSE NULL END )AS 'PROBLEMAS_RELACIONADOS_CON_VIOLENCIA',
                            MIN(CASE WHEN( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')))THEN Fecha_Atencion ELSE NULL END )AS 'DIAGNOSTICO_TRATAMIENTO'
                            INTO PASO1
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item IN ('Z3491','Z3492','Z3493','Z3591','Z3592','Z3593')))  OR                                    
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item ='96150' AND TIPO_Diagnostico='D' AND Valor_Lab='VIF' )OR (Codigo_Item='96150.01' AND Tipo_Diagnostico='D')))OR
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  (Codigo_Item ='R456' AND TIPO_Diagnostico='D' ) ) OR 
                            ( (Anio='2021' AND Mes='$mes') AND Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist' and Descripcion_Sector='GOBIERNO REGIONAL' AND  (Codigo_Unico NOT IN ('000000979','000000980','000000981') ) AND  ((Codigo_Item IN ('T741','T742','T743','T748','T749','Y070','Y078'))or (Codigo_Item like 'X85%')OR(Codigo_Item like 'X86%')OR(Codigo_Item like 'X87%')OR(Codigo_Item like 'X88%')OR(Codigo_Item like 'X89%')
                            OR(Codigo_Item like 'X90%')OR(Codigo_Item like 'X91%')OR(Codigo_Item like 'X92%')OR(Codigo_Item like 'X93%')OR(Codigo_Item like 'X94%')OR(Codigo_Item like 'X95%')OR(Codigo_Item like 'X96%')OR(Codigo_Item like 'X97%')OR(Codigo_Item like 'X98%')OR(Codigo_Item like 'X99%')OR(Codigo_Item like 'X97%')) )                                                                       
                            gROUP BY Provincia_Establecimiento,Distrito_Establecimiento,Numero_Documento_Paciente";
                            
            $resultado2 = "SELECT Provincia_Establecimiento,Distrito_Establecimiento,
                                SUM(CASE WHEN(GESTANTES_ATENDIDAS IS NOT NULL )THEN 1 ELSE 0 END)AS GESTANTES_ATENDIDAS,
                                SUM(CASE WHEN((TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS TAMIZAJE_VIOLENCIA,
                                SUM(CASE WHEN(([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS PROBLEMAS_RELACIONADOS_CON_LA_VIOLENCIA,
                                SUM(CASE WHEN(([DIAGNOSTICO_TRATAMIENTO]IS NOT NULL) AND ([PROBLEMAS_RELACIONADOS_CON_VIOLENCIA] IS NOT NULL) AND (TAMIZAJE_VIOLENCIA IS NOT NULL)  AND (GESTANTES_ATENDIDAS IS NOT NULL))THEN 1 ELSE 0 END)AS DIAGNOSTICO_E_INICIO_DE_TRATAMIENTO
                                FROM PASO1
                                GROUP BY Provincia_Establecimiento,Distrito_Establecimiento
                                ORDER BY Provincia_Establecimiento
                                DROP TABLE PASO1";
        }
        
        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);

    }    
?>