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
          $red = 'TODOS';
        }

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
            $resultado = "SELECT nombre_prov,nombre_dist,num_cnv,NUM_DNI, 'DOCUMENTO' = CASE 
                                                WHEN NUM_DNI IS NOT NULL
                                                THEN NUM_DNI
                                                ELSE NUM_CNV
                                        END,
                                        tipo_seguro,fecha_nacimiento_nino, DATEADD(DAY,28,FECHA_NACIMIENTO_NINO) A_medir, apellido_paterno_nino,
                            apellido_materno_nino, nombre_nino, MENOR_ENCONTRADO,NOMBRE_EESS    
                            into  bdhis_minsa.dbo.padronneonatal
                            from nominal_padron_nominal
                            where year(fecha_nacimiento_nino)='2021' AND MES='2021$mes2'
                            AND YEAR(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='2021' AND MONTH(DATEADD(DAY,28,FECHA_NACIMIENTO_NINO))='$mes' ;
                            with c as ( select documento, ROW_NUMBER() over(partition by documento order by documento) as duplicado
                            from bdhis_minsa.dbo.padronneonatal )
                            delete  from c
                            where duplicado >1";

            $resultado2 = "SELECT Nombre_Establecimiento, Numero_Documento_Paciente,Fecha_Atencion,Codigo_Item 
                                into bdhis_minsa.dbo.atenciones
                                FROM T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                                WHERE ANIO='2021' AND Codigo_Item ='36416' AND Tipo_Diagnostico='D'";

            $resultado3 = "SELECT p.nombre_prov, p.nombre_dist, p.documento, p.num_cnv, p.num_dni,p.tipo_seguro,p.fecha_nacimiento_nino, p.A_medir, 
                                p.apellido_paterno_nino + ' '+ p.apellido_materno_nino + ' ' + p.apellido_materno_nino As apellidos_nino, 
                                p.MENOR_ENCONTRADO,NOMBRE_EESS, a.Fecha_Atencion, a.Nombre_Establecimiento Lugar_TMZ    
                                from bdhis_minsa.dbo.padronneonatal p left join bdhis_minsa.dbo.atenciones a 
                                        on p.documento=a.Numero_Documento_Paciente
                                where month(p.a_medir)='$mes' AND nombre_prov='$red' AND nombre_dist='$dist'
                                DROP TABLE bdhis_minsa.dbo.padronneonatal
                                DROP TABLE bdhis_minsa.dbo.atenciones";
        }
        
        $consulta = sqlsrv_query($conn2, $resultado);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);

    }    
?>