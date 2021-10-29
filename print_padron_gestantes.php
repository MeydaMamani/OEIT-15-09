<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        // header('Content-Type: text/html; charset=UTF-8');
        
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

        if(!empty($consulta2)){
            $ficheroExcel="PADRON_GESTANTES "._date("d-m-Y", false, 'America/Lima').".csv";
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;PROVINCIA;DISTRITO;TIPO_DOCUMENTO;DOCUMENTO;FECHA_NACIMIENTO;APELLIDOS_NOMBRES;EDAD_CAPTADA;CAPTADA;TAMIZAJE_ANEMIA;TAMIZAJE_VIF;SIFILIS;VIH;BACTERIURIA;PERFIL_LOBST;SEGUNDO_CONTROL;TERCER_CONTROL;CUARTO_CONTROL;QUINTO_CONTROL;SEXTO_CONTROL;SEPTIMO_CONTROL;OCTAVO_CONTROL;ACIDO_FOLICO_1;ACIDO_FOLICO_2;ACIDO_FOLICO_3;SULFATO_1;SULFATO_2;SULFATO_3;SULFATO_4;SULFATO_5;SULFATO_6;CALCIO_1;CALCIO_2;IVA;PAP_SOLI;PAP_ENTR;DX_ANEMIA;CUMPLE\n";
            // Recorremos la consulta SQL y lo mostramos44
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['PROVINCIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['PROVINCIA'].";"; }

                if(is_null ($consulta['DISTRITO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DISTRITO'].";" ; }

                if(is_null ($consulta['TIPO_DOC']) ){ echo ' - '.";"; }
                else{ echo $consulta['TIPO_DOC'].";"; }

                if(is_null ($consulta['DOCUMENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DOCUMENTO'].";"; }

                if(is_null ($consulta['FECHA_NACIMIENTO_G']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECHA_NACIMIENTO_G'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['APELLIDOS_NOMBRES']) ){ echo ' - '.";"; }
                else{ echo $consulta['APELLIDOS_NOMBRES'].";"; }

                if(is_null ($consulta['EDAD_CAPTADA']) ){ echo ' - '.";"; }
                else{ echo $consulta['EDAD_CAPTADA'].";"; }

                if(is_null ($consulta['CAPTADA']) ){ echo ' - '.";"; }
                else{ echo $consulta['CAPTADA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['TMZ_ANEMIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['TMZ_ANEMIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['TMZ_VIF']) ){ echo ' - '.";"; }
                else{ echo $consulta['TMZ_VIF'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SIFILIS']) ){ echo ' - '.";"; }
                else{ echo $consulta['SIFILIS'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['VIH']) ){ echo ' - '.";"; }
                else{ echo $consulta['VIH'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['BACTERIURIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['BACTERIURIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['PERFILOBST']) ){ echo ' - '.";"; }
                else{ echo $consulta['PERFILOBST'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SEGUNDO_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEGUNDO_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['TERCER_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['TERCER_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['CUARTO_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['CUARTO_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['QUINTO_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['QUINTO_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SEXTO_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEXTO_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SEP_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['SEP_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['OCT_CONTROL']) ){ echo ' - '.";"; }
                else{ echo $consulta['OCT_CONTROL'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['ACIDOFOLICO1']) ){ echo ' - '.";"; }
                else{ echo $consulta['ACIDOFOLICO1'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['ACIDOFOLICO2']) ){ echo ' - '.";"; }
                else{ echo $consulta['ACIDOFOLICO2'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['ACIDOFOLICO3']) ){ echo ' - '.";"; }
                else{ echo $consulta['ACIDOFOLICO3'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO1']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO1'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO2']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO2'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO3']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO3'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO4']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO4'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO5']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO5'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['SULFATO6']) ){ echo ' - '.";"; }
                else{ echo $consulta['SULFATO6'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['CALCIO1']) ){ echo ' - '.";"; }
                else{ echo $consulta['CALCIO1'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['CALCIO2']) ){ echo ' - '.";"; }
                else{ echo $consulta['CALCIO2'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['IVA']) ){ echo ' - '.";"; }
                else{ echo $consulta['IVA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['PAP_SOLI']) ){ echo ' - '.";"; }
                else{ echo $consulta['PAP_SOLI'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['PAP_ENTR']) ){ echo ' - '.";"; }
                else{ echo $consulta['PAP_ENTR'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['DXANEMIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['DXANEMIA'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['CUMPLE']) ){ echo ' - '."\n"; }
                else{ echo $consulta['CUMPLE']."\n" ; }
            }   
        }
    }
?>