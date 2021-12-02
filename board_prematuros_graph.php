<script>
    // grafico para provincia
    var ctx_province= document.getElementById("myChartProvince").getContext("2d");
    var myChartProvince= new Chart(ctx_province,{
        type: "bar",
        data:{
            label: 'My First Dataset',
            datasets: [{
                label: "Ventas por mes",
                data: [5000, 1500, 8000, 5102],
            }]
        },
        plugins: [ChartDataLabels],
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                },
                datalabels: {
                    formatter: (value, ctx) => {
                        let mydata = ctx.datasetIndex;
                        var mydata1 = ctx.dataIndex;
                        if(mydata == 1){
                            var data2 = ctx.chart.data.datasets[0].data;
                            let percentage = (value*100 / data2[mydata1]).toFixed(2)+"%";
                            return percentage;
                        }
                        if(mydata == 0){
                            let dataArr = ctx.chart.data.datasets[0].data;
                            let percentage = (1*100 ).toFixed(0)+"%";
                            return percentage;
                        }
                    },
                    color: 'black',
                    anchor: 'end',
                    align: 'top',
                    offset: 3
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });
    // grafico para DISTRITO
    // $(".btn_dac").click(function(){
    //     $(".dac").show();
    //     $(".oxa").hide();
    //     $(".pasco").hide();
    //     $(".btn_dac").addClass('active');
    //     $(".btn_oxa").removeClass('active');
    //     $(".btn_pasco").removeClass('active');
    //     var mylabels = [
    //         <?php 
    //             include('query_homologation.php');
    //             $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                             sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
    //                             sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='DANIEL ALCIDES CARRION'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //             $consulta = sqlsrv_query($conn2, $resultado);
    //             $consulta1 = sqlsrv_query($conn2, $resultado2);
    //             $consulta3 = sqlsrv_query($conn2, $resultado3);
    //             $list_dists = array();
    //             while ($con = sqlsrv_fetch_array($consulta3)){
    //                 if($con['NOMBRE_DIST'] == "SANTA ANA DE TUSI"){ 
    //                     $list_dists[] = "TUSI"; 
    //                 }else if($con['NOMBRE_DIST'] == "SAN PEDRO DE PILLAO"){ 
    //                     $list_dists[] = "PILLAO"; 
    //                 }else if($con['NOMBRE_DIST'] == "GOYLLARISQUIZGA"){ 
    //                     $list_dists[] = "GOYLLAR"; 
    //                 }
    //                 else{
    //                     $list_dists[] = $con['NOMBRE_DIST']; 
    //                 }
    //             }
    //             $num_dists = sizeof($list_dists);         
    //             for ($i = 0; $i < $num_dists; $i++) {
    //                 $data = ($list_dists[$i]);
    //                 echo "'$data', ";
    //             }
    //         ?>
    //     ]
    //     var datos1 = {
    //         label: 'Total Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
    //                             count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                             count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='DANIEL ALCIDES CARRION'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);    
    //                 $list_dists = array();
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta1)){
    //                     $list_prov[] = $con['NOMBRE_DIST'];
    //                     $list_tots[] = $con['TOTAL'];
    //                 }

    //                 $num_dists = sizeof($list_dists);         
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#1d3f74',
    //         borderColor: '#1d3f74',
    //         fill: false,
    //         tension: 0.1
    //     };
    //     var datos2 = {
    //         label:'Avance Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado3 = "WITH A AS ( Select NOMBRE_PROV, NOMBRE_DIST,
    //                                 COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                                 sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                                 sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                                 sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                                 sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                                 sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                                 from sellomunicipal
    //                                 where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='DANIEL ALCIDES CARRION'
    //                                 group by NOMBRE_PROV, NOMBRE_DIST)
    //                                 SELECT NOMBRE_PROV, NOMBRE_DIST,
    //                                 CASE 
    //                                     WHEN CUMPLE_DNI <= CUMPLE_EJEVIAL AND CUMPLE_DNI <= CUMPLEDESCRIPCION AND CUMPLE_DNI <= CUMPLE_REFERENCIA AND CUMPLE_DNI <= Nino_VISITADO THEN CUMPLE_DNI 
    //                                     WHEN CUMPLE_EJEVIAL <= CUMPLE_DNI AND CUMPLE_EJEVIAL <= CUMPLEDESCRIPCION AND CUMPLE_EJEVIAL <= CUMPLE_REFERENCIA AND CUMPLE_EJEVIAL <= Nino_VISITADO THEN CUMPLE_EJEVIAL 
    //                                     WHEN CUMPLEDESCRIPCION <= CUMPLE_EJEVIAL AND CUMPLEDESCRIPCION <= CUMPLE_DNI AND CUMPLEDESCRIPCION <= CUMPLE_REFERENCIA AND CUMPLEDESCRIPCION <= Nino_VISITADO THEN CUMPLEDESCRIPCION 
    //                                     WHEN CUMPLE_REFERENCIA <= CUMPLE_EJEVIAL AND CUMPLE_REFERENCIA <= CUMPLEDESCRIPCION AND CUMPLE_REFERENCIA <= CUMPLE_DNI AND CUMPLE_REFERENCIA <= Nino_VISITADO THEN CUMPLE_REFERENCIA 
    //                                     WHEN Nino_VISITADO <= CUMPLE_EJEVIAL AND Nino_VISITADO <= CUMPLEDESCRIPCION AND Nino_VISITADO <= CUMPLE_REFERENCIA AND Nino_VISITADO <= CUMPLE_DNI THEN Nino_VISITADO 
    //                                 END AS 'MENOR' FROM A";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);
    //                 $consulta_menor = sqlsrv_query($conn2, $resultado3);
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta_menor)){
    //                     $list_tots[] = $con['MENOR'];
    //                 }
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#6c92c8',
    //         borderColor: '#6c92c8',
    //         fill: false,
    //         tension: 0.1
    //     };
        
    //     var ctx_district= document.getElementById("myChartDistrict").getContext("2d");
    //     var myChartDistrict= new Chart(ctx_district,{
    //         type: "bar",
    //         data:{
    //             labels: mylabels,
    //             datasets: [datos1, datos2, ]
    //         },
    //         plugins: [ChartDataLabels],
    //         options:{
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             indexAxis: 'y',
    //             plugins: {
    //                 legend: {
    //                     display: true
    //                 },
    //                 datalabels: {
    //                     formatter: (value, ctx) => {
    //                         let mydata = ctx.datasetIndex;
    //                         var mydata1 = ctx.dataIndex;
    //                         if(mydata == 1){
    //                             var data2 = ctx.chart.data.datasets[0].data;
    //                             let percentage = (value*100 / data2[mydata1]);
    //                             if (percentage - Math.floor(percentage) == 0) {
    //                                 percentage = percentage.toFixed(0)+"%";
    //                             } else {
    //                                 percentage = percentage.toFixed(2)+"%";
    //                             }
    //                             return percentage;
    //                         }
    //                     },
    //                     color: 'black',
    //                     anchor: 'end',
    //                     align: 'right',
    //                     offset: 10
    //                 }
    //             },
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     });
    // });
    // $(".btn_oxa").click(function(){
    //     $(".oxa").show();
    //     $(".dac").hide();
    //     $(".pasco").hide();
    //     $(".btn_oxa").addClass('active');
    //     $(".btn_dac").removeClass('active');
    //     $(".btn_pasco").removeClass('active');
    //     var mylabels = [
    //         <?php 
    //             include('query_homologation.php');
    //             $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                             sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
    //                             sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='OXAPAMPA'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //             $consulta = sqlsrv_query($conn2, $resultado);
    //             $consulta1 = sqlsrv_query($conn2, $resultado2);
    //             $consulta3 = sqlsrv_query($conn2, $resultado3);
    //             $list_dists = array();
    //             while ($con = sqlsrv_fetch_array($consulta3)){
    //                 $list_dists[] = $con['NOMBRE_DIST'];
    //             }
    //             $num_dists = sizeof($list_dists);         
    //             for ($i = 0; $i < $num_dists; $i++) {
    //                 $data = ($list_dists[$i]);
    //                 echo "'$data', ";
    //             }
    //         ?>
    //     ]
    //     var datos1 = {
    //         label: 'Total Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
    //                             count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                             count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='OXAPAMPA'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);    
    //                 $list_dists = array();
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta1)){
    //                     $list_prov[] = $con['NOMBRE_DIST'];
    //                     $list_tots[] = $con['TOTAL'];
    //                 }

    //                 $num_dists = sizeof($list_dists);         
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#1d3f74',
    //         borderColor: '#1d3f74',
    //         fill: false,
    //         tension: 0.1
    //     };
    //     var datos2 = {
    //         label:'Avance Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado3 = "WITH A AS ( Select NOMBRE_PROV, NOMBRE_DIST,
    //                                 COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                                 sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                                 sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                                 sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                                 sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                                 sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                                 from sellomunicipal
    //                                 where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='OXAPAMPA'
    //                                 group by NOMBRE_PROV, NOMBRE_DIST)
    //                                 SELECT NOMBRE_PROV, NOMBRE_DIST,
    //                                 CASE 
    //                                     WHEN CUMPLE_DNI <= CUMPLE_EJEVIAL AND CUMPLE_DNI <= CUMPLEDESCRIPCION AND CUMPLE_DNI <= CUMPLE_REFERENCIA AND CUMPLE_DNI <= Nino_VISITADO THEN CUMPLE_DNI 
    //                                     WHEN CUMPLE_EJEVIAL <= CUMPLE_DNI AND CUMPLE_EJEVIAL <= CUMPLEDESCRIPCION AND CUMPLE_EJEVIAL <= CUMPLE_REFERENCIA AND CUMPLE_EJEVIAL <= Nino_VISITADO THEN CUMPLE_EJEVIAL 
    //                                     WHEN CUMPLEDESCRIPCION <= CUMPLE_EJEVIAL AND CUMPLEDESCRIPCION <= CUMPLE_DNI AND CUMPLEDESCRIPCION <= CUMPLE_REFERENCIA AND CUMPLEDESCRIPCION <= Nino_VISITADO THEN CUMPLEDESCRIPCION 
    //                                     WHEN CUMPLE_REFERENCIA <= CUMPLE_EJEVIAL AND CUMPLE_REFERENCIA <= CUMPLEDESCRIPCION AND CUMPLE_REFERENCIA <= CUMPLE_DNI AND CUMPLE_REFERENCIA <= Nino_VISITADO THEN CUMPLE_REFERENCIA 
    //                                     WHEN Nino_VISITADO <= CUMPLE_EJEVIAL AND Nino_VISITADO <= CUMPLEDESCRIPCION AND Nino_VISITADO <= CUMPLE_REFERENCIA AND Nino_VISITADO <= CUMPLE_DNI THEN Nino_VISITADO 
    //                                 END AS 'MENOR' FROM A";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);
    //                 $consulta_menor = sqlsrv_query($conn2, $resultado3);
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta_menor)){
    //                     $list_tots[] = $con['MENOR'];
    //                 }
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#6c92c8',
    //         borderColor: '#6c92c8',
    //         fill: false,
    //         tension: 0.1
    //     };
        
    //     var ctx_district= document.getElementById("myChartDistrict1").getContext("2d");
    //     var myChartDistrict= new Chart(ctx_district,{
    //         type: "bar",
    //         data:{
    //             labels: mylabels,
    //             datasets: [datos1, datos2, ]
    //         },
    //         plugins: [ChartDataLabels],
    //         options:{
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             indexAxis: 'y',
    //             plugins: {
    //                 legend: {
    //                     display: true
    //                 },
    //                 datalabels: {
    //                     formatter: (value, ctx) => {
    //                         let mydata = ctx.datasetIndex;
    //                         var mydata1 = ctx.dataIndex;
    //                         if(mydata == 1){
    //                             var data2 = ctx.chart.data.datasets[0].data;
    //                             let percentage = (value*100 / data2[mydata1]);
    //                             if (percentage - Math.floor(percentage) == 0) {
    //                                 percentage = percentage.toFixed(0)+"%";
    //                             } else {
    //                                 percentage = percentage.toFixed(2)+"%";
    //                             }
    //                             return percentage;
    //                         }
    //                     },
    //                     color: 'black',
    //                     anchor: 'end',
    //                     align: 'right',
    //                     offset: 10
    //                 }
    //             },
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     }); 
    // });
    // $(".btn_pasco").click(function(){
    //     $(".pasco").show();
    //     $(".dac").hide();
    //     $(".oxa").hide();
    //     $(".btn_pasco").addClass('active');
    //     $(".btn_dac").removeClass('active');
    //     $(".btn_oxa").removeClass('active');
    //     var mylabels = [
    //         <?php 
    //             include('query_homologation.php');
    //             $resultado3 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                             sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS 'CUMPLE_DNI',
    //                             sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='PASCO'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //             $consulta = sqlsrv_query($conn2, $resultado);
    //             $consulta1 = sqlsrv_query($conn2, $resultado2);
    //             $consulta3 = sqlsrv_query($conn2, $resultado3);
    //             $list_dists = array();
    //             while ($con = sqlsrv_fetch_array($consulta3)){
    //                 if($con['NOMBRE_DIST'] == "SAN FRANCISCO DE ASIS DE YARUSYACAN"){ 
    //                     $list_dists[] = "YARUSYACAN"; 
    //                 }else if($con['NOMBRE_DIST'] == "SAN PEDRO DE PILLAO"){ 
    //                     $list_dists[] = "PILLAO"; 
    //                 }else if($con['NOMBRE_DIST'] == "GOYLLARISQUIZGA"){ 
    //                     $list_dists[] = "GOYLLAR"; 
    //                 }
    //                 else{
    //                     $list_dists[] = $con['NOMBRE_DIST']; 
    //                 }
    //             }
    //             $num_dists = sizeof($list_dists);         
    //             for ($i = 0; $i < $num_dists; $i++) {
    //                 $data = ($list_dists[$i]);
    //                 echo "'$data', ";
    //             }
    //         ?>
    //     ]
    //     var datos1 = {
    //         label: 'Total Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado2 = "SELECT NOMBRE_PROV,NOMBRE_DIST,
    //                             COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS TOTAL,
    //                             count(CASE WHEN NUM_DNI is not null THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                             count(CASE WHEN (EJE_VIAL is not null AND AREA_CENTRO_POBLA='URBANA') OR (EJE_VIAL is null AND AREA_CENTRO_POBLA='RURAL') THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                             count(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                             count(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                             count(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                             from sellomunicipal
    //                             where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='PASCO'
    //                             group by NOMBRE_PROV,NOMBRE_DIST
    //                             ORDER BY NOMBRE_PROV, NOMBRE_DIST
    //                             DROP TABLE sellomunicipal";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);    
    //                 $list_dists = array();
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta1)){
    //                     $list_prov[] = $con['NOMBRE_DIST'];
    //                     $list_tots[] = $con['TOTAL'];
    //                 }

    //                 $num_dists = sizeof($list_dists);         
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#1d3f74',
    //         borderColor: '#1d3f74',
    //         fill: false,
    //         tension: 0.1
    //     };
    //     var datos2 = {
    //         label:'Avance Niños Homologados',
    //         data: [
    //             <?php 
    //                 include('query_homologation.php');
    //                 $resultado3 = "WITH A AS ( Select NOMBRE_PROV, NOMBRE_DIST,
    //                                 COUNT(CASE WHEN NOMBRE_PROV is not null THEN 1 ELSE 0 END) AS 'TOTAL',
    //                                 sum(CASE WHEN NUM_DNI <> 0 THEN 1 ELSE 0 END) AS CUMPLE_DNI,
    //                                 sum(CASE WHEN ((EJE_VIAL<>'0' AND AREA_CENTRO_POBLA='URBANA')OR (EJE_VIAL='0' AND AREA_CENTRO_POBLA='RURAL')) THEN 1 ELSE 0 END) AS CUMPLE_EJEVIAL,
    //                                 sum(CASE WHEN DESCRIPCION is not null THEN 1 ELSE 0 END) AS CUMPLEDESCRIPCION,
    //                                 sum(CASE WHEN REFERENCIA_DIREC is not null THEN 1 ELSE 0 END) AS CUMPLE_REFERENCIA,
    //                                 sum(CASE WHEN MENOR_ENCONTRADO is not null THEN 1 ELSE 0 END) AS Nino_VISITADO
    //                                 from sellomunicipal
    //                                 where MES_A_MEDIR='$nombre_mes' AND NOMBRE_PROV='PASCO'
    //                                 group by NOMBRE_PROV, NOMBRE_DIST)
    //                                 SELECT NOMBRE_PROV, NOMBRE_DIST,
    //                                 CASE 
    //                                     WHEN CUMPLE_DNI <= CUMPLE_EJEVIAL AND CUMPLE_DNI <= CUMPLEDESCRIPCION AND CUMPLE_DNI <= CUMPLE_REFERENCIA AND CUMPLE_DNI <= Nino_VISITADO THEN CUMPLE_DNI 
    //                                     WHEN CUMPLE_EJEVIAL <= CUMPLE_DNI AND CUMPLE_EJEVIAL <= CUMPLEDESCRIPCION AND CUMPLE_EJEVIAL <= CUMPLE_REFERENCIA AND CUMPLE_EJEVIAL <= Nino_VISITADO THEN CUMPLE_EJEVIAL 
    //                                     WHEN CUMPLEDESCRIPCION <= CUMPLE_EJEVIAL AND CUMPLEDESCRIPCION <= CUMPLE_DNI AND CUMPLEDESCRIPCION <= CUMPLE_REFERENCIA AND CUMPLEDESCRIPCION <= Nino_VISITADO THEN CUMPLEDESCRIPCION 
    //                                     WHEN CUMPLE_REFERENCIA <= CUMPLE_EJEVIAL AND CUMPLE_REFERENCIA <= CUMPLEDESCRIPCION AND CUMPLE_REFERENCIA <= CUMPLE_DNI AND CUMPLE_REFERENCIA <= Nino_VISITADO THEN CUMPLE_REFERENCIA 
    //                                     WHEN Nino_VISITADO <= CUMPLE_EJEVIAL AND Nino_VISITADO <= CUMPLEDESCRIPCION AND Nino_VISITADO <= CUMPLE_REFERENCIA AND Nino_VISITADO <= CUMPLE_DNI THEN Nino_VISITADO 
    //                                 END AS 'MENOR' FROM A";

    //                 $consulta = sqlsrv_query($conn2, $resultado);
    //                 $consulta1 = sqlsrv_query($conn2, $resultado2);
    //                 $consulta_menor = sqlsrv_query($conn2, $resultado3);
    //                 $list_tots = array();
    //                 while ($con = sqlsrv_fetch_array($consulta_menor)){
    //                     $list_tots[] = $con['MENOR'];
    //                 }
    //                 $num_total = sizeof($list_tots);
    //                 for ($i = 0; $i < $num_total; $i++) {
    //                     $data = ($list_tots[$i]);
    //                     echo "'$data', ";
    //                 }
    //             ?>
    //         ],
    //         backgroundColor: '#6c92c8',
    //         borderColor: '#6c92c8',
    //         fill: false,
    //         tension: 0.1
    //     };
        
    //     var ctx_district= document.getElementById("myChartDistrict2").getContext("2d");
    //     var myChartDistrict= new Chart(ctx_district,{
    //         type: "bar",
    //         data:{
    //             labels: mylabels,
    //             datasets: [datos1, datos2, ]
    //         },
    //         plugins: [ChartDataLabels],
    //         options:{
    //             responsive: true,
    //             maintainAspectRatio: false,
    //             indexAxis: 'y',
    //             plugins: {
    //                 legend: {
    //                     display: true
    //                 },
    //                 datalabels: {
    //                     formatter: (value, ctx) => {
    //                         let mydata = ctx.datasetIndex;
    //                         var mydata1 = ctx.dataIndex;
    //                         if(mydata == 1){
    //                             var data2 = ctx.chart.data.datasets[0].data;
    //                             let percentage = (value*100 / data2[mydata1]);
    //                             if (percentage - Math.floor(percentage) == 0) {
    //                                 percentage = percentage.toFixed(0)+"%";
    //                             } else {
    //                                 percentage = percentage.toFixed(2)+"%";
    //                             }
    //                             return percentage;
    //                         }
    //                     },
    //                     color: 'black',
    //                     anchor: 'end',
    //                     align: 'right',
    //                     offset: 10
    //                 }
    //             },
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     })
    // });
</script>