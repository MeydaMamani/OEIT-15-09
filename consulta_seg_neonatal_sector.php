<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
    if (isset($_POST['Buscar'])) {
        global $conex;
        ini_set("default_charset", "UTF-8");
        mb_internal_encoding("UTF-8");
        
        $sector = $_POST['sector'];
        $establecimiento = $_POST['establecimiento'];
        $mes = $_POST['mes2'];
        $anio = $_POST['anio2'];

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

        $resultado = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item, Codigo_Unico 
                            into BDHIS_MINSA.dbo.atencionesneonatal1
                            FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            WHERE ANIO='$anio' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";
        
        if(($sector != 'TODOS') and $establecimiento == 'TODOS'){
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND MONTH(FE_NACIDO)='$mes' AND Institucion='$sector'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";

        }
        else if ($establecimiento == 'TODOS' and $sector == 'TODOS') {
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND MONTH(FE_NACIDO)='$mes'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";
           
        }
        else if($establecimiento != 'TODOS'){
            $resultado2 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, CAST(FE_NACIDO as date)fecnacido
                            into BDHIS_MINSA.dbo.nacidoscnv1
                            FROM CNV_LUGARNACIDO_PASCO
                            WHERE YEAR(FE_NACIDO)='$anio' AND Ipress='$establecimiento' AND MONTH(FE_NACIDO)='$mes'";

            $resultado3 = "SELECT Institucion, PROV_EESS,DIST_EESS, Nombre_EESS,Nu_cnv,Lugar_Nacido, fecnacido, 
                            a.Fecha_Atencion,a.Nombre_Establecimiento ATENDIDO_EN
                            INTO BDHIS_MINSA.dbo.TEMPORAL001
                            from BDHIS_MINSA.dbo.nacidoscnv1 n left join BDHIS_MINSA.dbo.atencionesneonatal1 a 
                            on N.NU_CNV=a.Numero_Documento_Paciente;
                            with c as ( select Nu_cnv,  ROW_NUMBER() 
                                over(partition by Nu_cnv order by Nu_cnv) as duplicado
                                from BDHIS_MINSA.dbo.TEMPORAL001 )
                                delete  from c
                                where duplicado >1";

        }

        $resultado4 = "SELECT * FROM BDHIS_MINSA.dbo.TEMPORAL001 
                        ORDER BY Institucion, PROV_EESS,DIST_EESS, Nombre_EESS
                        DROP TABLE BDHIS_MINSA.dbo.atencionesneonatal1
                        DROP TABLE BDHIS_MINSA.dbo.nacidoscnv1
                        DROP TABLE BDHIS_MINSA.dbo.TEMPORAL001";


        $consulta1 = sqlsrv_query($conn, $resultado);
        $consulta2 = sqlsrv_query($conn3, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
    }
?>