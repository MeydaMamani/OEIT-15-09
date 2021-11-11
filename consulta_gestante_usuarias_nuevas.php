<?php
    require ('abrir.php');    
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
          $red = 'TODOS';
        }

        $resultado1 = "SELECT Provincia_Establecimiento, Distrito_Establecimiento, Codigo_Unico, Codigo_Item, Tipo_Diagnostico, Fecha_Atencion, Numero_Documento_Paciente, Tipo_Doc_Paciente, Valor_Lab 
                      into bdhis_minsa.dbo.TRAMAHIS 
                      from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                      where ltrim(rtrim(Codigo_Item)) in ('99208','96150','96150.01')
                      and isnumeric(Numero_Documento_Paciente)=1
                      and ltrim(rtrim(Genero))='F'
                      ANd Tipo_Edad='A' AND edad_reg>=18
                      AND [Id_Condicion_Servicio] in ('N','R')";

        $resultado2 = "SELECT Codigo_Unico, Categoria_Establecimiento 
                      into bdhis_minsa.dbo.RENAES 
                      from MAESTRO_HIS_ESTABLECIMIENTO";

        $resultado3 = "SELECT distinct try_convert(int,r.Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, den=1
                      into bdhis_minsa.dbo.DEN 
                      from bdhis_minsa.dbo.TRAMAHIS h
                      left join bdhis_minsa.dbo.RENAES r ON TRY_CONVERT(INT,h.Codigo_Unico) = TRY_CONVERT(INT,R.Codigo_Unico)
                      where ltrim(rtrim(Codigo_Item)) in ('99208') and ltrim(rtrim(Tipo_Diagnostico)) in ('D')
                      and month(try_convert(date,Fecha_Atencion))='10' and year(try_convert(date,Fecha_Atencion))='2021'
                      and Numero_Documento_Paciente is not null
                      AND Categoria_Establecimiento IN ('I-1','I-2','I-3','I-4')";

        $resultado4 = "SELECT distinct try_convert(int,Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, num=1
                      into bdhis_minsa.dbo.NUM
                      from bdhis_minsa.dbo.TRAMAHIS
                      where (
                        (	ltrim(rtrim(Codigo_Item)) = '96150' and ltrim(rtrim(Tipo_Diagnostico)) ='D' and ltrim(rtrim(valor_lab)) ='VIF'	)
                        or 
                        ( 	ltrim(rtrim(Codigo_Item)) = '96150.01' and ltrim(rtrim(Tipo_Diagnostico)) = 'D' )
                      ) and month(try_convert(date,Fecha_Atencion))='10' and year(try_convert(date,Fecha_Atencion))='2021'";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado5 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          WHERE Provincia='$red'
                          ORDER BY Provincia, Distrito, Nombre_Establecimiento
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado5 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          ORDER BY Provincia, Distrito, Nombre_Establecimiento
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN";
          
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado5 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          WHERE Provincia='$red' AND Distrito='$dist'
                          ORDER BY Provincia, Distrito, Nombre_Establecimiento
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
  }    
?>