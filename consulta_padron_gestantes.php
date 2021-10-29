<?php 
    require('abrir.php');
        
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

    $resultado = "SELECT Provincia_Establecimiento PROVINCIA,Distrito_Establecimiento DISTRITO,
    Abrev_Tipo_Doc_Paciente TIPO_DOC,Numero_Documento_Paciente DOCUMENTO,
    Fecha_Nacimiento_Paciente FECHA_NACIMIENTO_G, concat(Apellido_Paterno_Paciente,' ',Apellido_Materno_Paciente,' ',Nombres_Paciente)APELLIDOS_NOMBRES,EDAD_CAPTADA,
    GES_CAPT_OPO CAPTADA,TMZ_ANEMIA,TMZ_VIF, SIFILIS, VIH,BACTERIURIA,PERFILOBST,SEG_CONTROL SEGUNDO_CONTROL,
    TER_CONTROL TERCER_CONTROL,CUA_CONTROL CUARTO_CONTROL,QUI_CONTROL QUINTO_CONTROL,SEX_OCONTROL SEXTO_CONTROL,
    SEP_CONTROL,OCT_CONTROL,ACIDOFOLICO1, ACIDOFOLICO2,ACIDOFOLICO3, SULFATO1,SULFATO2,SULFATO3,SULFATO4,SULFATO5,SULFATO6,
    CALCIO1,CALCIO2,IVA,PAP_SOLI,PAP_ENTR,DXANEMIA,
CASE WHEN ((GES_CAPT_OPO IS NOT NULL AND TMZ_ANEMIA IS NOT NULL)) THEN 'CUMPLE' ELSE 'NO CUMPLE' END as CUMPLE
FROM (
    SELECT
    A.Provincia_Establecimiento,  A.Distrito_Establecimiento,  
    A.Abrev_Tipo_Doc_Paciente,
    A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente, A.Apellido_Paterno_Paciente, A.Apellido_Materno_Paciente, A.Nombres_Paciente,
Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.EDAD_REG ELSE NULL END)'EDAD_CAPTADA',
Min(CASE WHEN ((a.Codigo_Item IN('Z3491','Z3591') AND Tipo_Diagnostico='D' AND Valor_Lab='1') )THEN A.Fecha_Atencion ELSE NULL END)'GES_CAPT_OPO',
Min(CASE WHEN (a.Codigo_Item IN('Z3591','Z3592','Z3491','Z3492') AND Tipo_Diagnostico='D' AND Valor_Lab='2')THEN A.Fecha_Atencion ELSE NULL END)'SEG_CONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3591','Z3592','Z3491','Z3492') AND Tipo_Diagnostico='D' AND Valor_Lab='3') THEN A.Fecha_Atencion ELSE NULL END)'TER_CONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3591','Z3592','Z3491','Z3492') AND Tipo_Diagnostico='D' AND Valor_Lab='4' )THEN A.Fecha_Atencion ELSE NULL END)'CUA_CONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3592','Z3492','Z3593','Z3493') AND Tipo_Diagnostico='D' AND Valor_Lab='5' )THEN A.Fecha_Atencion ELSE NULL END)'QUI_CONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3592','Z3593','Z3492','Z3493') AND Tipo_Diagnostico='D' AND Valor_Lab='6' )THEN A.Fecha_Atencion ELSE NULL END)'SEX_OCONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3593','Z3493') AND Tipo_Diagnostico='D' AND Valor_Lab='7' )THEN A.Fecha_Atencion ELSE NULL END)'SEP_CONTROL',
Min(CASE WHEN (a.Codigo_Item IN('Z3593','Z3493') AND Tipo_Diagnostico='D' AND Valor_Lab='8' )THEN A.Fecha_Atencion ELSE NULL END)'OCT_CONTROL',

Min(CASE WHEN (a.Codigo_Item ='85018' AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_ANEMIA',
Min(CASE WHEN (a.Codigo_Item in ('86780','86593','86592') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'SIFILIS',
Min(CASE WHEN (a.Codigo_Item in('86703','87389') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'VIH',
Min(CASE WHEN (a.Codigo_Item in('81007','81002','82004') AND a.Tipo_Diagnostico='D')THEN A.Fecha_Atencion ELSE NULL END)'BACTERIURIA',
Min(CASE WHEN (a.Codigo_Item in('80055.01','Z0177') AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'PERFILOBST',
Min(CASE WHEN (a.Codigo_Item ='96150' AND a.Tipo_Diagnostico='D' AND VALOR_LAB='VIF')THEN A.Fecha_Atencion ELSE NULL END)'TMZ_VIF',
-------para convenios de gestion entrega en el primer trimestre
Min(CASE WHEN (a.Codigo_Item in('59401.03') AND a.Tipo_Diagnostico='D' AND Valor_Lab='1')THEN A.Fecha_Atencion ELSE NULL END)'ACIDOFOLICO1',
Min(CASE WHEN (a.Codigo_Item in('59401.03') AND a.Tipo_Diagnostico='D' AND Valor_Lab='2')THEN A.Fecha_Atencion ELSE NULL END)'ACIDOFOLICO2',
Min(CASE WHEN (a.Codigo_Item in('59401.03') AND a.Tipo_Diagnostico='D' AND Valor_Lab='3')THEN A.Fecha_Atencion ELSE NULL END)'ACIDOFOLICO3',
---------
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='1')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO1',
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='2')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO2',
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='3')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO3',
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='4')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO4',
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='5')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO5',
Min(CASE WHEN (a.Codigo_Item in('59401.04') AND a.Tipo_Diagnostico='D' AND Valor_Lab='6')THEN A.Fecha_Atencion ELSE NULL END)'SULFATO6',

Min(CASE WHEN (a.Codigo_Item in('59401.05') AND a.Tipo_Diagnostico='D' AND Valor_Lab='1')THEN A.Fecha_Atencion ELSE NULL END)'CALCIO1',
Min(CASE WHEN (a.Codigo_Item in('59401.05') AND a.Tipo_Diagnostico='D' AND Valor_Lab='2')THEN A.Fecha_Atencion ELSE NULL END)'CALCIO2',

Min(CASE WHEN (a.Codigo_Item in('88141.01') AND a.Tipo_Diagnostico='D' AND Valor_Lab IN('N','A'))THEN A.Fecha_Atencion ELSE NULL END)'IVA',
Min(CASE WHEN (a.Codigo_Item in('88141') AND a.Tipo_Diagnostico='D' AND Valor_Lab IS NULL)THEN A.Fecha_Atencion ELSE NULL END)'PAP_SOLI',
Min(CASE WHEN (a.Codigo_Item in('88141') AND a.Tipo_Diagnostico='D' AND Valor_Lab IN('N','A'))THEN A.Fecha_Atencion ELSE NULL END)'PAP_ENTR',
Min(CASE WHEN (a.Codigo_Item in('O990') AND a.Tipo_Diagnostico='D' )THEN A.Fecha_Atencion ELSE NULL END)'DXANEMIA'
    FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA A
    WHERE
    (anio='2021'and Genero='f' )
    GROUP BY
    A.Provincia_Establecimiento, A.Distrito_Establecimiento, A.Nombre_Establecimiento, A.Abrev_Tipo_Doc_Paciente,
    A.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente, A.Apellido_Paterno_Paciente, A.Apellido_Materno_Paciente,
    A.Nombres_Paciente
    
) a

WHERE GES_CAPT_OPO IS NOT NULL
ORDER BY Distrito_Establecimiento, CAPTADA ASC";
           
    $consulta2 = sqlsrv_query($conn, $resultado);
?>