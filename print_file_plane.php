<?php 
    require('abrir.php');
    require('abrir2.php');
    require('abrir3.php');    
 
    if(isset($_POST["exportarCSV"])) {
        ini_set("default_charset", "UTF-8");
        global $conex;
        header('Content-Type: text/html; charset=UTF-8');

        $red_1 = $_POST['red'];
        $dist_1 = $_POST['distrito'];
        $mes = $_POST['mes'];
        // $id_establecimiento = $_POST['id_establecimiento'];

        if($mes == 1){ $nombre_mes = 'ENERO'; }
        else if($mes == 2){ $nombre_mes = 'FEBRERO'; }
        else if($mes == 3){ $nombre_mes = 'MARZO'; }
        else if($mes == 4){ $nombre_mes = 'ABRIL'; }
        else if($mes == 5){ $nombre_mes = 'MAYO'; }
        else if($mes == 6){ $nombre_mes = 'JUNIO'; }
        else if($mes == 7){ $nombre_mes = 'JULIO'; }
        else if($mes == 8){ $nombre_mes = 'AGOSTO'; }
        else if($mes == 9){ $nombre_mes = 'SETIEMBRE'; }
        else if($mes == 10){ $nombre_mes = 'OCTUBRE'; }
        else if($mes == 11){ $nombre_mes = 'NOVIEMBRE'; }
        else if($mes == 12){ $nombre_mes = 'DICIEMBRE'; }

        if (strlen($mes) == 1){ $mes2 = '0'.$mes;  }else{ $mes2 = $mes;
        }

        if ($red_1 == 1) { $red = 'DANIEL ALCIDES CARRION'; }
        elseif ($red_1 == 2) { $red = 'OXAPAMPA'; }
        elseif ($red_1 == 3) { $red = 'PASCO';  }
        elseif ($red_1 == 4) { $redt = 'PASCO'; }
                
        if(($red_1 == 1 or $red_1 == 2 or $red_1 == 3) and $dist_1 == 'TODOS'){
            $resultado = "SELECT Id_Cita, Lote,MES,DIA,Fecha_Atencion, LOTE, NUM_PAG,Num_Reg,Descripcion_Ups,Descripcion_Sector,Descripcion_Red,Provincia_Establecimiento,
                            Descripcion_MicroRed,Distrito_Establecimiento,Codigo_Unico,Nombre_Establecimiento,Abrev_Tipo_Doc_Paciente, Numero_Documento_Paciente,Fecha_Nacimiento_Paciente,Id_Etnia,
                            Descripcion_Etnia,Descripcion_Financiador,Descripcion_Pais,Numero_Documento_Personal, Nombres_Personal,Descripcion_Profesion,
                            Numero_Documento_Registrador, Nombres_Registrador,Id_Condicion_Establecimiento,Id_Condicion_Servicio,Edad_Reg,Tipo_Edad,Grupo_Edad, Id_Turno,
                            Codigo_Item,Tipo_Diagnostico, Descripcion_Item,Valor_Lab,Id_Correlativo_Item,Id_Correlativo_Lab,peso,Talla,Hemoglobina,pac,pc,Id_Otra_Condicion,
                            Descripcion_Otra_Condicion,Descripcion_Centro_Poblado,Fecha_Ultima_Regla,Fecha_Solicitud_Hb,Fecha_Resultado_Hb,Fecha_Registro,Fecha_Modificacion
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and mes='$mes' and Provincia_Establecimiento='$red'";
        }
        else if ($red_1 == 4 and $dist_1 == 'TODOS') {
            $dist = '';
            $resultado = "SELECT Id_Cita, Lote,MES,DIA,Fecha_Atencion, LOTE, NUM_PAG,Num_Reg,Descripcion_Ups,Descripcion_Sector,Descripcion_Red,Provincia_Establecimiento,
                            Descripcion_MicroRed,Distrito_Establecimiento,Codigo_Unico,Nombre_Establecimiento,Abrev_Tipo_Doc_Paciente, Numero_Documento_Paciente,Fecha_Nacimiento_Paciente,Id_Etnia,
                            Descripcion_Etnia,Descripcion_Financiador,Descripcion_Pais,Numero_Documento_Personal, Nombres_Personal,Descripcion_Profesion,
                            Numero_Documento_Registrador, Nombres_Registrador,Id_Condicion_Establecimiento,Id_Condicion_Servicio,Edad_Reg,Tipo_Edad,Grupo_Edad, Id_Turno,
                            Codigo_Item,Tipo_Diagnostico, Descripcion_Item,Valor_Lab,Id_Correlativo_Item,Id_Correlativo_Lab,peso,Talla,Hemoglobina,pac,pc,Id_Otra_Condicion,
                            Descripcion_Otra_Condicion,Descripcion_Centro_Poblado,Fecha_Ultima_Regla,Fecha_Solicitud_Hb,Fecha_Resultado_Hb,Fecha_Registro,Fecha_Modificacion
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and mes='$mes'";
        }
        else if($dist_1 != 'TODOS'){
            $dist=$dist_1;
            $resultado = "SELECT Id_Cita, Lote,MES,DIA,Fecha_Atencion, LOTE, NUM_PAG,Num_Reg,Descripcion_Ups,Descripcion_Sector,Descripcion_Red,Provincia_Establecimiento,
                            Descripcion_MicroRed,Distrito_Establecimiento,Codigo_Unico,Nombre_Establecimiento,Abrev_Tipo_Doc_Paciente, Numero_Documento_Paciente,Fecha_Nacimiento_Paciente,Id_Etnia,
                            Descripcion_Etnia,Descripcion_Financiador,Descripcion_Pais,Numero_Documento_Personal, Nombres_Personal,Descripcion_Profesion,
                            Numero_Documento_Registrador, Nombres_Registrador,Id_Condicion_Establecimiento,Id_Condicion_Servicio,Edad_Reg,Tipo_Edad,Grupo_Edad, Id_Turno,
                            Codigo_Item,Tipo_Diagnostico, Descripcion_Item,Valor_Lab,Id_Correlativo_Item,Id_Correlativo_Lab,peso,Talla,Hemoglobina,pac,pc,Id_Otra_Condicion,
                            Descripcion_Otra_Condicion,Descripcion_Centro_Poblado,Fecha_Ultima_Regla,Fecha_Solicitud_Hb,Fecha_Resultado_Hb,Fecha_Registro,Fecha_Modificacion
                            from T_CONSOLIDADO_NUEVA_TRAMA_HISMINSA
                            where anio='2021' and mes='$mes' and Provincia_Establecimiento='$red' AND Distrito_Establecimiento='$dist'";
        }
  
        $consulta2 = sqlsrv_query($conn, $resultado);

        if(!empty($consulta2)){
            $ficheroExcel="ARCHIVO_PLANO ".date("d-m-Y").".csv";        
            //Indicamos que vamos a tratar con un fichero CSV
            header("Content-type: text/csv");
            header("Content-Disposition: attachment; filename=".$ficheroExcel);
            header("Content-Transfer-Encoding: UTF-8");
            // Vamos a mostrar en las celdas las columnas que queremos que aparezcan en la primera fila, separadas por ; 
            echo "; ; DIRESA PASCO - DEIT\n\n";
            echo "; ; $dist_1 - $nombre_mes\n\n";
            echo "#;ID_CITA;LOTE;MES;DIA;FECHA_ATENCION;NUMERO_PAG;NUMERO_REG;DESCRIPCION_UPS;DESCRIPCION_SECTOR;DESCRIPCION_RED;PROVINCIA;DESCRIPCION_MICRORED;DISTRITO;CODIGO_UNICO;NOMBRE_ESTABLECIMIENTO;TIPO_DOCUMENTO_PACIENTE;DOCUMENTO_PACIENTE;FECHA_NACIMIENTO_PACIENTE;ID_ETNIA;DESCRIPCION_ETNIA;DESCRIPCION_FINANCIADOR;DESCRIPCION_PAIS;DOCUMENTO_PERSONAL;NOMBRES_PERSONAL;DESCRIPCION_PROFESION;DOCUMENTO_REGISTRADOR;NOMBRES_REGISTRADOR;ID_CONDICION_ESTABLECIMIENTO;ID_CONDICION_SERVICIO;EDAD_REGISTRO;TIPO_EDAD;GRUPO_EDAD;ID_TURNO;CODIGO_ITEM;TIPO_DIAGNOSTICO;DESCRIPCION_ITEM;VALOR_LAB;ID_CORRELATIVO_ITEM;ID_CORRELATIVO_LAB;PESO;TALLA;HEMOGLOBINA;PAC;PC;ID_OTRA_CONDICION;DESCRIPCION_OTRA_CONDICION;DESCRIPCION_CENTRO_POBLADO;FECHA_ULTIMA_REGLA;FECHA_SOLICITUD_HB;FECHA_RESULTADO_HB;FECHA_REGISTRO;FECHA_MODIFICACION\n";
            // Recorremos la consulta SQL y lo mostramos
            $i=1;
            while ($consulta = sqlsrv_fetch_array($consulta2)){
                echo $i++.";";
                if(is_null ($consulta['Id_Cita']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Cita'].";"; }

                if(is_null ($consulta['Lote']) ){ echo ' - '.";"; }
                else{ echo $consulta['Lote'].";"; }

                if(is_null ($consulta['MES']) ){ echo ' - '.";"; }
                else{ echo $consulta['MES'].";"; }

                if(is_null ($consulta['DIA']) ){ echo ' - '.";"; }
                else{ echo $consulta['DIA'].";"; }

                if(is_null ($consulta['Fecha_Atencion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Atencion'] -> format('d/m/y').";"; }

                if(is_null ($consulta['NUM_PAG']) ){ echo ' - '.";"; }
                else{ echo $consulta['NUM_PAG'].";"; }

                if(is_null ($consulta['Num_Reg']) ){ echo ' - '.";"; }
                else{ echo $consulta['Num_Reg'].";"; }

                if(is_null ($consulta['Descripcion_Ups']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Ups'].";"; }

                if(is_null ($consulta['Descripcion_Sector']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Sector'].";"; }

                if(is_null ($consulta['Descripcion_Red']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Red'].";"; }

                if(is_null ($consulta['Provincia_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Provincia_Establecimiento'].";"; }

                if(is_null ($consulta['Descripcion_MicroRed']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_MicroRed'].";"; }

                if(is_null ($consulta['Distrito_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Distrito_Establecimiento'].";"; }

                if(is_null ($consulta['Codigo_Unico']) ){ echo ' - '.";"; }
                else{ echo $consulta['Codigo_Unico'].";"; }

                if(is_null ($consulta['Nombre_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Nombre_Establecimiento'].";"; }

                if(is_null ($consulta['Abrev_Tipo_Doc_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Abrev_Tipo_Doc_Paciente'].";"; }

                if(is_null ($consulta['Numero_Documento_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numero_Documento_Paciente'].";"; }

                if(is_null ($consulta['Fecha_Nacimiento_Paciente']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Nacimiento_Paciente'] -> format('d/m/y').";"; }

                if(is_null ($consulta['Id_Etnia']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Etnia'].";"; }

                if(is_null ($consulta['Descripcion_Etnia']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Etnia'].";"; }

                if(is_null ($consulta['Descripcion_Financiador']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Financiador'].";"; }

                if(is_null ($consulta['Descripcion_Pais']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Pais'].";"; }

                if(is_null ($consulta['Numero_Documento_Personal']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numero_Documento_Personal'].";"; }

                if(is_null ($consulta['Nombres_Personal']) ){ echo ' - '.";"; }
                else{ echo $consulta['Nombres_Personal'].";"; }

                if(is_null ($consulta['Descripcion_Profesion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Profesion'].";"; }

                if(is_null ($consulta['Numero_Documento_Registrador']) ){ echo ' - '.";"; }
                else{ echo $consulta['Numero_Documento_Registrador'].";"; }

                if(is_null ($consulta['Nombres_Registrador']) ){ echo ' - '.";"; }
                else{ echo $consulta['Nombres_Registrador'].";"; }

                if(is_null ($consulta['Id_Condicion_Establecimiento']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Condicion_Establecimiento'].";"; }

                if(is_null ($consulta['Id_Condicion_Servicio']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Condicion_Servicio'].";"; }

                if(is_null ($consulta['Edad_Reg']) ){ echo ' - '.";"; }
                else{ echo $consulta['Edad_Reg'].";"; }

                if(is_null ($consulta['Tipo_Edad']) ){ echo ' - '.";"; }
                else{ echo $consulta['Tipo_Edad'].";"; }

                if(is_null ($consulta['Grupo_Edad']) ){ echo ' - '.";"; }
                else{ echo $consulta['Grupo_Edad'].";"; }

                if(is_null ($consulta['Id_Turno']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Turno'].";"; }

                if(is_null ($consulta['Codigo_Item']) ){ echo ' - '.";"; }
                else{ echo $consulta['Codigo_Item'].";"; }

                if(is_null ($consulta['Tipo_Diagnostico']) ){ echo ' - '.";"; }
                else{ echo $consulta['Tipo_Diagnostico'].";"; }

                if(is_null ($consulta['Descripcion_Item']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Item'].";"; }

                if(is_null ($consulta['Valor_Lab']) ){ echo ' - '.";"; }
                else{ echo $consulta['Valor_Lab'].";"; }

                if(is_null ($consulta['Id_Correlativo_Item']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Correlativo_Item'].";"; }

                if(is_null ($consulta['Id_Correlativo_Lab']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Correlativo_Lab'].";"; }

                if(is_null ($consulta['peso']) ){ echo ' - '.";"; }
                else{ echo $consulta['peso'].";"; }

                if(is_null ($consulta['Talla']) ){ echo ' - '.";"; }
                else{ echo $consulta['Talla'].";"; }

                if(is_null ($consulta['Hemoglobina']) ){ echo ' - '.";"; }
                else{ echo $consulta['Hemoglobina'].";"; }

                if(is_null ($consulta['pac']) ){ echo ' - '.";"; }
                else{ echo $consulta['pac'].";"; }

                if(is_null ($consulta['pc']) ){ echo ' - '.";"; }
                else{ echo $consulta['pc'].";"; }

                if(is_null ($consulta['Id_Otra_Condicion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Id_Otra_Condicion'].";"; }

                if(is_null ($consulta['Descripcion_Otra_Condicion']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Otra_Condicion'].";"; }

                if(is_null ($consulta['Descripcion_Centro_Poblado']) ){ echo ' - '.";"; }
                else{ echo $consulta['Descripcion_Centro_Poblado'].";"; }

                if(is_null ($consulta['Fecha_Ultima_Regla']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Ultima_Regla'] -> format('d/m/y').";"; }

                if(is_null ($consulta['Fecha_Solicitud_Hb']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Solicitud_Hb'] -> format('d/m/y').";"; }

                if(is_null ($consulta['Fecha_Resultado_Hb']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Resultado_Hb'] -> format('d/m/y').";"; }

                if(is_null ($consulta['Fecha_Registro']) ){ echo ' - '.";"; }
                else{ echo $consulta['Fecha_Registro'] -> format('d/m/y').";"; }

                if(is_null ($consulta['Fecha_Modificacion']) ){ echo ' - '."\n"; }
                else{ echo $consulta['Fecha_Modificacion'] -> format('d/m/y')."\n"; }
            }   
        }
    }
?>