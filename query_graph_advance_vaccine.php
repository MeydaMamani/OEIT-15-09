<?php 
    require('abrir.php');
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");
    
    $resultadoss = "SELECT T.Anio,Provincia_Establecimiento AS PROVINCIA,
                    -------------------------------------------------------------------------------------------------I-MENORES DE 1 AÑO-------------------------------------------------------------------------------------------------------
                    --BCG
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90585','Z232') ) ) THEN 1 ELSE 0 END) BCG_24_HORAS,
                    --HVB
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90744','Z246') ) ) THEN 1 ELSE 0 END) HVB_12_HORAS,
                    --IPV
                    SUM(CASE WHEN ( ((T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90713' and (T.Valor_Lab in('2','D2')) )) THEN 1 ELSE 0 END) IPV_02_04_MESES_2_DOSIS,
                    --APO
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90712' and (T.Valor_Lab IN ('3','D3'))) THEN 1 ELSE 0 END)  APO_06_MESES_3ra_Dosis,
                    --PENTAVALENTE
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90723','Z276') AND (T.Valor_Lab IN ('3','03','D3')))) THEN 1 ELSE 0 END)  PENTAVALENTE_02_04_06_MESES_3ra_dosis,
                    -- ReaReaccción adversa Dt(p)
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_3ra_dosis,
                    -- Reaccción adversa HvB
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_3ra_dosis,	
                    -- Reaccción adversa Hib
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_3ra_dosis,
                    -- ROTA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_2da_DOSIS,
                    --NEUMOCOCO
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_2da_DOSIS,
                    --INFLUENZA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 6 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) INFLUENZA_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 7 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) INFLUENZA_2da_DOSIS,

                    --NEUMOCOCO 3ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('3','03','D3')))  ) THEN 1 ELSE 0 END) NEUMOCOCO_1_ANIO_3ra_DOSIS,
                    --SPR 1ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90707','Z274') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) SPR_1_ANIO_1ra_DOSIS
                    
                    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                    where (Anio IN ('2021')) and (mes in ('1','2','3','4','5','6','7','8')) AND Provincia_Establecimiento IS NOT NULL
                    GROUP BY
                    T.Anio,Provincia_Establecimiento
                    order by Provincia_Establecimiento";


    $consulta1 = sqlsrv_query($conn, $resultadoss);

    $resultadoss2 = "SELECT T.Anio,Provincia_Establecimiento AS PROVINCIA, Distrito_Establecimiento AS Distrito,
                    -------------------------------------------------------------------------------------------------I-MENORES DE 1 AÑO-------------------------------------------------------------------------------------------------------
                    --BCG
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90585','Z232') ) ) THEN 1 ELSE 0 END) BCG_24_HORAS,
                    --HVB
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90744','Z246') ) ) THEN 1 ELSE 0 END) HVB_12_HORAS,
                    --IPV
                    SUM(CASE WHEN ( ((T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90713' and (T.Valor_Lab in('2','D2')) )) THEN 1 ELSE 0 END) IPV_02_04_MESES_2_DOSIS,
                    --APO
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90712' and (T.Valor_Lab IN ('3','D3'))) THEN 1 ELSE 0 END)  APO_06_MESES_3ra_Dosis,
                    --PENTAVALENTE
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90723','Z276') AND (T.Valor_Lab IN ('3','03','D3')))) THEN 1 ELSE 0 END)  PENTAVALENTE_02_04_06_MESES_3ra_dosis,
                    -- ReaReaccción adversa Dt(p)
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_3ra_dosis,
                    -- Reaccción adversa HvB
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_3ra_dosis,	
                    -- Reaccción adversa Hib
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_3ra_dosis,
                    -- ROTA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_2da_DOSIS,
                    --NEUMOCOCO
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_2da_DOSIS,
                    --INFLUENZA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 6 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) INFLUENZA_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 7 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) INFLUENZA_2da_DOSIS,

                    --NEUMOCOCO 3ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('3','03','D3')))  ) THEN 1 ELSE 0 END) NEUMOCOCO_1_ANIO_3ra_DOSIS,
                    --SPR 1ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90707','Z274') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) SPR_1_ANIO_1ra_DOSIS
                    
                    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                    where (Anio IN ('2021')) and (mes in ('1','2','3','4','5','6','7','8')) AND Provincia_Establecimiento = 'DANIEL ALCIDES CARRION'
                    GROUP BY
                    T.Anio,Provincia_Establecimiento, Distrito_Establecimiento
                    order by Provincia_Establecimiento, Distrito_Establecimiento";


    $consulta2 = sqlsrv_query($conn, $resultadoss2);

    $resultadoss3 = "SELECT T.Anio,Provincia_Establecimiento AS PROVINCIA, Distrito_Establecimiento AS Distrito,
                    -------------------------------------------------------------------------------------------------I-MENORES DE 1 AÑO-------------------------------------------------------------------------------------------------------
                    --BCG
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90585','Z232') ) ) THEN 1 ELSE 0 END) BCG_24_HORAS,
                    --HVB
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90744','Z246') ) ) THEN 1 ELSE 0 END) HVB_12_HORAS,
                    --IPV
                    SUM(CASE WHEN ( ((T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90713' and (T.Valor_Lab in('2','D2')) )) THEN 1 ELSE 0 END) IPV_02_04_MESES_2_DOSIS,
                    --APO
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90712' and (T.Valor_Lab IN ('3','D3'))) THEN 1 ELSE 0 END)  APO_06_MESES_3ra_Dosis,
                    --PENTAVALENTE
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90723','Z276') AND (T.Valor_Lab IN ('3','03','D3')))) THEN 1 ELSE 0 END)  PENTAVALENTE_02_04_06_MESES_3ra_dosis,
                    -- ReaReaccción adversa Dt(p)
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_3ra_dosis,
                    -- Reaccción adversa HvB
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_3ra_dosis,	
                    -- Reaccción adversa Hib
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_3ra_dosis,
                    -- ROTA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_2da_DOSIS,
                    --NEUMOCOCO
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_2da_DOSIS,
                    --INFLUENZA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 6 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) INFLUENZA_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 7 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) INFLUENZA_2da_DOSIS,

                    --NEUMOCOCO 3ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('3','03','D3')))  ) THEN 1 ELSE 0 END) NEUMOCOCO_1_ANIO_3ra_DOSIS,
                    --SPR 1ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90707','Z274') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) SPR_1_ANIO_1ra_DOSIS
                    
                    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                    where (Anio IN ('2021')) and (mes in ('1','2','3','4','5','6','7','8')) AND Provincia_Establecimiento = 'OXAPAMPA'
                    GROUP BY
                    T.Anio,Provincia_Establecimiento, Distrito_Establecimiento
                    order by Provincia_Establecimiento, Distrito_Establecimiento";


    $consulta3 = sqlsrv_query($conn, $resultadoss3);

    $resultadoss4 = "SELECT T.Anio,Provincia_Establecimiento AS PROVINCIA, Distrito_Establecimiento AS Distrito,
                    -------------------------------------------------------------------------------------------------I-MENORES DE 1 AÑO-------------------------------------------------------------------------------------------------------
                    --BCG
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90585','Z232') ) ) THEN 1 ELSE 0 END) BCG_24_HORAS,
                    --HVB
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90744','Z246') ) ) THEN 1 ELSE 0 END) HVB_12_HORAS,
                    --IPV
                    SUM(CASE WHEN ( ((T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90713' and (T.Valor_Lab in('2','D2')) )) THEN 1 ELSE 0 END) IPV_02_04_MESES_2_DOSIS,
                    --APO
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90712' and (T.Valor_Lab IN ('3','D3'))) THEN 1 ELSE 0 END)  APO_06_MESES_3ra_Dosis,
                    --PENTAVALENTE
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90723','Z276') AND (T.Valor_Lab IN ('3','03','D3')))) THEN 1 ELSE 0 END)  PENTAVALENTE_02_04_06_MESES_3ra_dosis,
                    -- ReaReaccción adversa Dt(p)
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_3ra_dosis,
                    -- Reaccción adversa HvB
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_3ra_dosis,	
                    -- Reaccción adversa Hib
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_3ra_dosis,
                    -- ROTA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_2da_DOSIS,
                    --NEUMOCOCO
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_2da_DOSIS,
                    --INFLUENZA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 6 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) INFLUENZA_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 7 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) INFLUENZA_2da_DOSIS,

                    --NEUMOCOCO 3ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('3','03','D3')))  ) THEN 1 ELSE 0 END) NEUMOCOCO_1_ANIO_3ra_DOSIS,
                    --SPR 1ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90707','Z274') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) SPR_1_ANIO_1ra_DOSIS
                    
                    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                    here (Anio IN ('2021')) and (mes in ('1','2','3','4','5','6','7','8')) AND Provincia_Establecimiento = 'PASCO'
                    GROUP BY
                    T.Anio,Provincia_Establecimiento, Distrito_Establecimiento
                    order by Provincia_Establecimiento, Distrito_Establecimiento";


    $consulta4 = sqlsrv_query($conn, $resultadoss4);

    // distrito
    $resultadoss5 = "SELECT T.Anio,Provincia_Establecimiento AS PROVINCIA, Distrito_Establecimiento AS Distrito,
                    -------------------------------------------------------------------------------------------------I-MENORES DE 1 AÑO-------------------------------------------------------------------------------------------------------
                    --BCG
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90585','Z232') ) ) THEN 1 ELSE 0 END) BCG_24_HORAS,
                    --HVB
                    SUM(CASE WHEN ( (T.Tipo_Edad='D' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90744','Z246') ) ) THEN 1 ELSE 0 END) HVB_12_HORAS,
                    --IPV
                    SUM(CASE WHEN ( ((T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90713' and (T.Valor_Lab in('2','D2')) )) THEN 1 ELSE 0 END) IPV_02_04_MESES_2_DOSIS,
                    --APO
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) and	T.Codigo_Item='90712' and (T.Valor_Lab IN ('3','D3'))) THEN 1 ELSE 0 END)  APO_06_MESES_3ra_Dosis,
                    --PENTAVALENTE
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90723','Z276') AND (T.Valor_Lab IN ('3','03','D3')))) THEN 1 ELSE 0 END)  PENTAVALENTE_02_04_06_MESES_3ra_dosis,
                    -- ReaReaccción adversa Dt(p)
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z2781','90702') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_DTP_3ra_dosis,
                    -- Reaccción adversa HvB
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90744','Z246') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HvB_3ra_dosis,	
                    -- Reaccción adversa Hib
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_2ra_dosis,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('Z251','90648') AND (T.Valor_Lab IN ('3','03','D3'))) ) THEN 1 ELSE 0 END) Reacciones_Adversas_pentavalente_HiB_3ra_dosis,
                    -- ROTA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 7) AND (T.Codigo_Item IN ('90681','Z268') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) ROTAVIRUS_02_04_MESES_2da_DOSIS,
                    --NEUMOCOCO
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 2 AND 11) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) NEUMOCOCO_02_04_MESES_2da_DOSIS,
                    --INFLUENZA
                    -- SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 6 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) INFLUENZA_1ra_DOSIS,
                    SUM(CASE WHEN ( (T.Tipo_Edad='M' AND T.Edad_Reg BETWEEN 7 AND 11) AND (T.Codigo_Item IN ('90657','Z2511') AND (T.Valor_Lab IN ('2','02','D2'))) ) THEN 1 ELSE 0 END) INFLUENZA_2da_DOSIS,

                    --NEUMOCOCO 3ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90669','Z238','90670') AND (T.Valor_Lab IN ('3','03','D3')))  ) THEN 1 ELSE 0 END) NEUMOCOCO_1_ANIO_3ra_DOSIS,
                    --SPR 1ra
                    SUM(CASE WHEN ( (T.Tipo_Edad='A' AND T.Edad_Reg=1) AND (T.Codigo_Item IN ('90707','Z274') AND (T.Valor_Lab IN ('1','01','D1'))) ) THEN 1 ELSE 0 END) SPR_1_ANIO_1ra_DOSIS
                    
                    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA T
                    here (Anio IN ('2021')) and (mes in ('1','2','3','4','5','6','7','8')) AND Provincia_Establecimiento = 'PASCO' AND Distrito_Establecimiento='YANACANCHA'
                    GROUP BY
                    T.Anio,Provincia_Establecimiento, Distrito_Establecimiento
                    order by Provincia_Establecimiento, Distrito_Establecimiento";


    $consulta5 = sqlsrv_query($conn, $resultadoss5);
?>