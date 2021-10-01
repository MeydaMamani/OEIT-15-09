<?php 
    require ('abrir.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;

        $red_1 = $_POST['red'];
        $dist = $_POST['distrito'];
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
            $red = 'TODOS';
        }  

        if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resumen = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO, Mes, Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL
                            into dbo.T_BATERIA FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento, A.Mes, A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                            A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,           
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                            WHERE (anio in ('2021') and Genero='f' and mes ='$mes') 
                                GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Mes, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                                Numero_Documento_Paciente, Fecha_Nacimiento_Paciente) b
                            where GES_CAPT_OPO is not null";

            $resumen2 = "SELECT b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple,
                            CAST(CUMPLE AS DECIMAL(4,2))/CAST (CAPTADA AS DECIMAL(10,2)) *100 AVANCE
                            from ( SELECT Provincia,Distrito,mes,
                            SUM(CASE WHEN(CAPTADA IS NOT NULL )THEN 1 ELSE 0 END)AS captada,
                            SUM(CASE WHEN((BACTERIURIA IS NOT NULL))THEN 1 ELSE 0 END)AS BACTERIURIA,
                            SUM(CASE WHEN((TMZ_ANEMIA IS NOT NULL))THEN 1 ELSE 0 END)AS T_ANEMIA,
                            SUM(CASE WHEN((SIFILIS IS NOT NULL))THEN 1 ELSE 0 END)AS sifilis,
                            SUM(CASE WHEN((VIH IS NOT NULL))THEN 1 ELSE 0 END)AS VIH,
                            SUM(CASE WHEN((VIH=SIFILIS AND TMZ_ANEMIA=BACTERIURIA))THEN 1 ELSE 0 END)AS CUMPLE
                            FROM  dbo.T_BATERIA
                            GROUP BY PROVINCIA,Distrito,mes )b
                            group by b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple
                            DROP TABLE dbo.T_BATERIA";
        }
        else if($red_1 == 1 or $red_1 == 2 or $red_1 == 3 and $dist_1 == 'TODOS'){
            $resumen = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO, Mes, Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL
                            into dbo.T_BATERIA FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento, A.Mes, A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                            A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,           
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                            WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red') 
                                GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Mes, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                                Numero_Documento_Paciente, Fecha_Nacimiento_Paciente) b
                            where GES_CAPT_OPO is not null";

            $resumen2 = "SELECT b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple,
                            CAST(CUMPLE AS DECIMAL(4,2))/CAST (CAPTADA AS DECIMAL(10,2)) *100 AVANCE
                            from ( SELECT Provincia,Distrito,mes,
                            SUM(CASE WHEN(CAPTADA IS NOT NULL )THEN 1 ELSE 0 END)AS captada,
                            SUM(CASE WHEN((BACTERIURIA IS NOT NULL))THEN 1 ELSE 0 END)AS BACTERIURIA,
                            SUM(CASE WHEN((TMZ_ANEMIA IS NOT NULL))THEN 1 ELSE 0 END)AS T_ANEMIA,
                            SUM(CASE WHEN((SIFILIS IS NOT NULL))THEN 1 ELSE 0 END)AS sifilis,
                            SUM(CASE WHEN((VIH IS NOT NULL))THEN 1 ELSE 0 END)AS VIH,
                            SUM(CASE WHEN((VIH=SIFILIS AND TMZ_ANEMIA=BACTERIURIA))THEN 1 ELSE 0 END)AS CUMPLE
                            FROM  dbo.T_BATERIA
                            GROUP BY PROVINCIA,Distrito,mes )b
                            group by b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple
                            DROP TABLE dbo.T_BATERIA";
        }
        else{
            $resumen = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO, Mes, Nombre_Establecimiento IPRESS,
                            Abrev_Tipo_Doc_Paciente TIPO_DOC, Numero_Documento_Paciente DOCUMENTO, Fecha_Nacimiento_Paciente,  
                            GES_CAPT_OPO CAPTADA,TMZ_ANEMIA, SIFILIS, VIH,BACTERIURIA,TMZ_VIF, PLANDEPARTO,PERFILOBSTETRICO,REGISTRADO_EL
                            into dbo.T_BATERIA FROM ( SELECT A.Provincia_Establecimiento,  A.Distrito_Establecimiento, A.Mes, A.Nombre_Establecimiento,  A.Abrev_Tipo_Doc_Paciente,
                            A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,           
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
                            Max(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
                            Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
                            Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
                            Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
                            Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
                            Min(CASE WHEN (a.Codigo_Item IN ('96150','96150.01') AND a.Tipo_Diagnostico='D' AND VALOR_LAB IN ('VIF','G','(G)'))THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
                            Min(CASE WHEN (a.Codigo_Item ='R456' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'VIF_CONFIRMADO',
                            Min(CASE WHEN (a.Codigo_Item ='80055.01' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBSTETRICO',
                            Min(CASE WHEN (a.Codigo_Item ='U1692' AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PLANDEPARTO',
                            Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Registro ELSE NULL END)'REGISTRADO_EL'
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
                            WHERE (anio in ('2021') and Genero='f' and mes ='$mes' and Provincia_Establecimiento='$red' and Distrito_Establecimiento='$dist') 
                                GROUP BY Provincia_Establecimiento, Distrito_Establecimiento, Mes, Nombre_Establecimiento, Abrev_Tipo_Doc_Paciente,
                                Numero_Documento_Paciente, Fecha_Nacimiento_Paciente) b
                            where GES_CAPT_OPO is not null";

            $resumen2 = "SELECT b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple,
                            CAST(CUMPLE AS DECIMAL(4,2))/CAST (CAPTADA AS DECIMAL(10,2)) *100 AVANCE
                            from ( SELECT Provincia,Distrito,mes,
                            SUM(CASE WHEN(CAPTADA IS NOT NULL )THEN 1 ELSE 0 END)AS captada,
                            SUM(CASE WHEN((BACTERIURIA IS NOT NULL))THEN 1 ELSE 0 END)AS BACTERIURIA,
                            SUM(CASE WHEN((TMZ_ANEMIA IS NOT NULL))THEN 1 ELSE 0 END)AS T_ANEMIA,
                            SUM(CASE WHEN((SIFILIS IS NOT NULL))THEN 1 ELSE 0 END)AS sifilis,
                            SUM(CASE WHEN((VIH IS NOT NULL))THEN 1 ELSE 0 END)AS VIH,
                            SUM(CASE WHEN((VIH=SIFILIS AND TMZ_ANEMIA=BACTERIURIA))THEN 1 ELSE 0 END)AS CUMPLE
                            FROM  dbo.T_BATERIA
                            GROUP BY PROVINCIA,Distrito,mes )b
                            group by b.Provincia,Distrito,b.mes,b.captada,b.bacteriuria,b.t_anemia,b.sifilis,b.vih,b.cumple
                            DROP TABLE dbo.T_BATERIA";
        }

        $resum = sqlsrv_query($conn, $resumen);
        $resum2 = sqlsrv_query($conn, $resumen2);
    }
?>
