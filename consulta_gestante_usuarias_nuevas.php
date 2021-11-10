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

        $resultado3 = "CREATE TABLE DEN (
                          renaes int, 
                          fecha_cita date, 
                          id VARCHAR(30), 
                          den int,
                      )";

        $resultado4 = "CREATE TABLE NUM (
                          renaes int, 
                          fecha_cita date, 
                          id VARCHAR(30), 
                          num int,
                      )";

        $resultado5 = "CREATE TABLE TRAMAHIS_FED2021_VI02_NOMINAL (
                          anio int,
                          mes int,
                          renaes int,
                          id VARCHAR(20),
                          den INT,
                          num INT,
                      )";

        $resultado6 = "DECLARE @year int, @mes_eval int , @mes_final int 
                        set @year=2021
                        set @mes_eval=1
                        set @mes_final=12
                      
                      while @mes_eval <= @mes_final
                      begin
                              PRINT 'The counter value is = ' + CONVERT(VARCHAR,@mes_eval)
                              -- Denominador. 
                            INSERT into DEN 
                          select distinct convert(int,r.Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, den=1
                          from bdhis_minsa.dbo.TRAMAHIS h
                          left join bdhis_minsa.dbo.RENAES r ON TRY_CONVERT(INT,h.Codigo_Unico) = TRY_CONVERT(INT,R.Codigo_Unico)
                          where ltrim(rtrim(Codigo_Item)) in ('99208') and ltrim(rtrim(Tipo_Diagnostico)) in ('D')
                          and month(try_convert(date,Fecha_Atencion))=@mes_eval and year(try_convert(date,Fecha_Atencion))=@year
                          and Numero_Documento_Paciente is not null
                          AND Categoria_Establecimiento IN ('I-1','I-2','I-3','I-4')
                      
                              -- Numerador. 
                          INSERT INTO NUM
                          select distinct try_convert(int,Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, num=1
                          from bdhis_minsa.dbo.TRAMAHIS
                          where (
                            (	ltrim(rtrim(Codigo_Item)) = '96150' and ltrim(rtrim(Tipo_Diagnostico)) ='D' and ltrim(rtrim(valor_lab)) ='VIF'	)
                            or 
                            ( 	ltrim(rtrim(Codigo_Item)) = '96150.01' and ltrim(rtrim(Tipo_Diagnostico)) = 'D' )
                          ) and month(try_convert(date,Fecha_Atencion))=@mes_eval and year(try_convert(date,Fecha_Atencion))=@year
                      
                              
                              --CONVERT(datetime, '2017-08-25')
                              select a.*, month(a.fecha_cita) mes, year(a.fecha_cita) anio,isnull(b.num,0) num 
                          into bdhis_minsa.dbo.REPORTS
                          from bdhis_minsa.dbo.DEN a
                          left join bdhis_minsa.dbo.NUM b on a.fecha_cita=b.fecha_cita and a.renaes=b.renaes and a.id=b.id
                      
                              select anio, mes, renaes, id, max(den) den, max(num) num
                          into bdhis_minsa.dbo.REPORTS_FINAL
                          from REPORTS
                          group by anio, mes, renaes, id
                      
                          insert into TRAMAHIS_FED2021_VI02_NOMINAL
                          select anio, mes, renaes, convert(varchar(20),id) id, den, num 
                          from bdhis_minsa.dbo.REPORTS_FINAL
                      
                              DROP TABLE bdhis_minsa.dbo.REPORTS
                              DROP TABLE bdhis_minsa.dbo.REPORTS_FINAL
                          
                          set @mes_eval = @mes_eval + 1
                      end";

        $resultado7 = "SELECT anio, mes, renaes, sum(den) den, sum(num) num
                      into TRAMAHIS_FED2021_VI02_consolidado
                      from TRAMAHIS_FED2021_VI02_NOMINAL
                      group by anio, mes, renaes ";


        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado8 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          WHERE MONTH(d.fecha_cita)=$mes2 AND Provincia='$red'
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE DEN
                          DROP TABLE NUM
                          DROP TABLE TRAMAHIS_FED2021_VI02_NOMINAL
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN
                          DROP TABLE bdhis_minsa.dbo.REPORTS
                          DROP TABLE bdhis_minsa.dbo.REPORTS_FINAL
                          DROP TABLE TRAMAHIS_FED2021_VI02_consolidado";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $resultado8 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          WHERE MONTH(d.fecha_cita)=$mes2
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE DEN
                          DROP TABLE NUM
                          DROP TABLE TRAMAHIS_FED2021_VI02_NOMINAL
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN
                          DROP TABLE bdhis_minsa.dbo.REPORTS
                          DROP TABLE bdhis_minsa.dbo.REPORTS_FINAL
                          DROP TABLE TRAMAHIS_FED2021_VI02_consolidado";
          
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado8 = "SELECT  m.Provincia,m.Distrito,m.Nombre_Establecimiento,SUBSTRING(d.id,2,10)documento,d.fecha_cita ATE_PLANIFICACION,n.fecha_cita TMZ_VIF
                          from den d left join num n 
                          on d.id=n.id
                          left join MAESTRO_HIS_ESTABLECIMIENTO m
                          on d.renaes=cast(m.Codigo_Unico as int)
                          WHERE MONTH(d.fecha_cita)=$mes2 AND Provincia='$red' AND Distrito='$dist'
                          DROP TABLE bdhis_minsa.dbo.TRAMAHIS
                          DROP TABLE bdhis_minsa.dbo.RENAES
                          DROP TABLE DEN
                          DROP TABLE NUM
                          DROP TABLE TRAMAHIS_FED2021_VI02_NOMINAL
                          DROP TABLE bdhis_minsa.dbo.NUM 
                          DROP TABLE bdhis_minsa.dbo.DEN
                          DROP TABLE bdhis_minsa.dbo.REPORTS
                          DROP TABLE bdhis_minsa.dbo.REPORTS_FINAL
                          DROP TABLE TRAMAHIS_FED2021_VI02_consolidado";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
        $consulta4 = sqlsrv_query($conn, $resultado4);
        $consulta5 = sqlsrv_query($conn, $resultado5);
        $consulta6 = sqlsrv_query($conn, $resultado6);
        $consulta7 = sqlsrv_query($conn, $resultado7);
        $consulta8 = sqlsrv_query($conn, $resultado8);
  }    
?>