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

        $resultado1 = "SELECT * 
                        INTO bdhis_minsa.dbo.tramahis 
                        from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                        where ltrim(rtrim(Codigo_Item)) in ('99208','96150','96150.01')
                        and isnumeric(Numero_Documento_Paciente)=1
                        and ltrim(rtrim(Genero))='F'
                        ANd Tipo_Edad='A' AND edad_reg>=18
                        AND [Id_Condicion_Servicio] in ('N','R')";

        $resultado2 = "SELECT * 
                        INTO bdhis_minsa.dbo.renaes
                        from MAESTRO_HIS_ESTABLECIMIENTO";

        $resultado3 = "DECLARE @year int, @mes_eval int , @mes_final int 
                        set @year=2021
                        set @mes_eval=1
                        set @mes_final=12
                      
                        while @mes_eval <= @mes_final
                        begin
                            -- Denominador. 
                            select distinct try_convert(int,r.Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, den=1
                            into den 
                            from bdhis_minsa.dbo.tramahis  h
                            left join bdhis_minsa.dbo.renaes r ON TRY_CONVERT(INT,h.Codigo_Unico) = TRY_CONVERT(INT,R.Codigo_Unico)
                            where ltrim(rtrim(Codigo_Item)) in ('99208') and ltrim(rtrim(Tipo_Diagnostico)) in ('D')
                            and month(try_convert(date,Fecha_Atencion))=@mes_eval and year(try_convert(date,Fecha_Atencion))=@year
                            and Numero_Documento_Paciente is not null
                            AND Categoria_Establecimiento IN ('I-1','I-2','I-3','I-4')
                            -- Numerador. 
                            select distinct try_convert(int,Codigo_Unico) renaes, try_convert(date,Fecha_Atencion) fecha_cita, convert(varchar,Tipo_Doc_Paciente)+convert(varchar,Numero_Documento_Paciente) id, num=1
                            into num 
                            from bdhis_minsa.dbo.tramahis 
                            where 
                            (
                              (	ltrim(rtrim(Codigo_Item)) = '96150' and ltrim(rtrim(Tipo_Diagnostico)) ='D' and ltrim(rtrim(valor_lab)) ='VIF'	)
                              or 
                              ( 	ltrim(rtrim(Codigo_Item)) = '96150.01' and ltrim(rtrim(Tipo_Diagnostico)) = 'D' )
                            )
                            and month(try_convert(date,Fecha_Atencion))=@mes_eval and year(try_convert(date,Fecha_Atencion))=@year
      
                            select a.*, month(a.fecha_cita) mes, year(a.fecha_cita) año,isnull(b.num,0) num 
                            into report
                            from den a
                            left join num b on a.fecha_cita=b.fecha_cita and a.renaes=b.renaes and a.id=b.id
                        
                            select año, mes, renaes, id, max(den) den, max(num) num
                            into report_final
                            from report
                            group by año, mes, renaes, id
                        
                            insert into TRAMAHIS_FED2021_VI02_NOMINAL
                            select año, mes, renaes, convert(varchar(20),id) id, den, num 
                            from report_final
                        
                            drop table report
                            drop table report_final
                        
                            set @mes_eval = @mes_eval + 1
                        end";

        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                          a.Fecha_Atencion, t.Codigo_Item
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                          (select t.Provincia_Establecimiento,t.Distrito_Establecimiento, t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                              t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                          where  t.anio='2021' and t.mes='$mes' AND  ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                              (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                              t.Id_Cita IN
                                (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                                t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                                AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                          on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                          where  a.anio='2021' AND a.MES='$mes' AND a.Provincia_Establecimiento='$red' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                          AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981'))";

        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
          $dist = '';
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                            a.Fecha_Atencion, t.Codigo_Item from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                            (select t.Provincia_Establecimiento,t.Distrito_Establecimiento,t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                                    t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                            where  t.anio='2021' and t.mes='$mes' and ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                                    (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                                    t.Id_Cita IN
                              (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                              where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                              t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                              AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                            on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                            where  a.anio='2021' AND a.MES='$mes' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                            AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981')) ";
        }
        else if($dist_1 != 'TODOS'){
          $dist=$dist_1;
          $resultado = "SELECT a.Provincia_Establecimiento, a.distrito_establecimiento, a.Abrev_Tipo_Doc_Paciente, a.Nombre_Establecimiento,a.Numero_Documento_Paciente, A.Fecha_Nacimiento_Paciente,t.Edad_Reg,
                          a.Fecha_Atencion, t.Codigo_Item
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA a  left join
                          (select t.Provincia_Establecimiento,t.Distrito_Establecimiento, t.Nombre_Establecimiento,t.Descripcion_Ups, t.Numero_Documento_Paciente,
                              t.Tipo_Diagnostico,t.Codigo_Item, t.Valor_Lab, t.Edad_Reg,t.Fecha_Atencion
                          from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                          where  t.anio='2021' and t.mes='$mes' AND  ((t.Codigo_Item='96150' and t.Valor_Lab='VIF' AND t.Tipo_Diagnostico='D') OR
                              (t.Codigo_Item='96150.01' AND t.Tipo_Diagnostico='D')) AND t.Edad_Reg>17 AND t.Tipo_Edad='A' AND
                              t.Id_Cita IN
                                (select t.Id_Cita from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA t
                                where  t.anio='2021' AND t.MES='$mes' and t.Codigo_Item='99208' and t.Tipo_Diagnostico='D' and t.Id_Ups='301612' and 
                                t.Id_Condicion_Establecimiento in ('N','R') and (Codigo_Unico NOT IN ('000000979','000000980','000000981'))
                                AND t.Edad_Reg>17 AND t.Tipo_Edad='A')   ) t
                          on a.Numero_Documento_Paciente=t.Numero_Documento_Paciente
                          where  a.anio='2021' AND a.MES='$mes' AND a.Provincia_Establecimiento='$red' AND a.distrito_establecimiento='$dist' and a.Codigo_Item='99208' and a.Tipo_Diagnostico='D' and a.Id_Ups='301612' and a.Id_Condicion_Establecimiento in ('N','R')
                          AND (a.Edad_Reg>17 AND a.Tipo_Edad='A') and (a.Codigo_Unico NOT IN ('000000979','000000980','000000981'))";
        }

        $consulta1 = sqlsrv_query($conn, $resultado1);
        $consulta2 = sqlsrv_query($conn, $resultado2);
        $consulta3 = sqlsrv_query($conn, $resultado3);
  }    
?>