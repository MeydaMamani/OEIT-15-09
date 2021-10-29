<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir6.php');    
 
    if(isset($_POST["exportarCSV"])) {
        include('zone_setting.php');
        global $conex;
        ini_set("default_charset", "UTF-8");
        // header('Content-Type: text/html; charset=UTF-8');
        
        $resultado = "SELECT d.NUM_DOC,VALIDADO_RENIEC, CONCAT(d.APELLIDO_PATERNO, ' ', d.APELLIDO_MATERNO, ' ', d.NOMBRES) AS FULL_NAME, d.PROVINCIA,d.DISTRITO,d.COD_ESTUDIANTE,d.FECHA_NACIMIENTO,
                    d.sexo,d.NIV_MOD,d.PAIS_NACIMIENTO,d.ID_GRADO,DESC_GRADO,d.CEN_EDU,d.D_COD_CAR,D_DREUGEL,d.DAREACENSO,d.PADRE, a.FECHAATENCION, 
                    a.distrito_establecimiento,a.nombre_establecimiento
                    from dre_pasco d left join bdhis_minsa.dbo.atenciones_menores19 a
	                on d.NUM_DOC=a.Numero_Documento_Paciente";
           
        $consulta2 = sqlsrv_query($conn6, $resultado);

        if(!empty($consulta2)){
            $ficheroExcel="DEIT_PASCO REINCORPORACION "._date("d-m-Y", false, 'America/Lima').".csv";
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);            
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "#;DOCUMENTO;VALIDADO_RENIEC;APELLIDOS_NOMBRES;CODIDO_ESTUDIANTE;FECHA_NACIMIENTO;SEXO;NIV_MOD;PAIS_NACIMIENTO;ID_GRADO;DESC_GRADO;CEN_EDU;COD_CAR;DREUGEL;DAR_ACENSO;DATOS_PADRE;FECHA_ATENCION;DISTRITO_ESTABLECIMIENTO;NOMBRE_ESTABLECIMIENTO\n";
            // Recorremos la consulta SQL y lo mostramos44
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['NUM_DOC']) ){ echo ' - '.";"; }
                else{ echo $consulta['NUM_DOC'].";"; }

                if(is_null ($consulta['VALIDADO_RENIEC']) ){ echo ' - '.";"; }
                else{ echo $consulta['VALIDADO_RENIEC'].";" ; }

                if(is_null ($consulta['FULL_NAME']) ){ echo ' - '.";"; }
                else{ echo $consulta['FULL_NAME'].";"; }

                if(is_null ($consulta['COD_ESTUDIANTE']) ){ echo ' - '.";"; }
                else{ echo number_format($consulta['COD_ESTUDIANTE']).";" ; }

                if(is_null ($consulta['FECHA_NACIMIENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECHA_NACIMIENTO'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['sexo']) ){ echo ' - '.";"; }
                else{ echo $consulta['sexo'].";" ; }

                if(is_null ($consulta['NIV_MOD']) ){ echo ' - '.";"; }
                else{ echo $consulta['NIV_MOD'].";" ; }

                if(is_null ($consulta['PAIS_NACIMIENTO']) ){ echo ' - '.";"; }
                else{ echo $consulta['PAIS_NACIMIENTO'].";" ; }

                if(is_null ($consulta['ID_GRADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['ID_GRADO'].";" ; }

                if(is_null ($consulta['DESC_GRADO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DESC_GRADO'].";" ; }

                if(is_null ($consulta['CEN_EDU']) ){ echo ' - '.";"; }
                else{ echo $consulta['CEN_EDU'].";" ; }

                if(is_null ($consulta['D_COD_CAR']) ){ echo ' - '.";"; }
                else{ echo $consulta['D_COD_CAR'].";" ; }

                if(is_null ($consulta['D_DREUGEL']) ){ echo ' - '.";"; }
                else{ echo $consulta['D_DREUGEL'].";" ; }

                if(is_null ($consulta['DAREACENSO']) ){ echo ' - '.";"; }
                else{ echo $consulta['DAREACENSO'].";" ; }

                if(is_null ($consulta['PADRE']) ){ echo ' - '.";"; }
                else{ echo $consulta['PADRE'].";" ; }

                if(is_null ($consulta['FECHAATENCION']) ){ echo ' - '.";"; }
                else{ echo $consulta['FECHAATENCION'] -> format('d/m/y').";" ; }

                if(is_null ($consulta['distrito_establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['distrito_establecimiento'].";" ; }

                if(is_null ($consulta['nombre_establecimiento']) ){ echo ' - '."\n"; }
                else{ echo $consulta['nombre_establecimiento']."\n" ; }
            }   
        }
    }
?>