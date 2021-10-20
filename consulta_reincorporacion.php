<?php 
    require('abrir6.php');
        
    global $conex;
    ini_set("default_charset", "UTF-8");
    mb_internal_encoding("UTF-8");

    $resultado = "SELECT d.NUM_DOC,VALIDADO_RENIEC, CONCAT(d.APELLIDO_PATERNO, ' ', d.APELLIDO_MATERNO, ' ', d.NOMBRES) AS FULL_NAME, d.PROVINCIA,d.DISTRITO,d.COD_ESTUDIANTE,d.FECHA_NACIMIENTO,
                    d.sexo,d.NIV_MOD,d.PAIS_NACIMIENTO,d.ID_GRADO,DESC_GRADO,d.CEN_EDU,d.D_COD_CAR,D_DREUGEL,d.DAREACENSO,d.PADRE, a.FECHAATENCION, 
                    a.distrito_establecimiento,a.nombre_establecimiento
                    from dre_pasco d left join bdhis_minsa.dbo.atenciones_menores19 a
	                on d.NUM_DOC=a.Numero_Documento_Paciente";
           
    $consulta2 = sqlsrv_query($conn6, $resultado);

?>