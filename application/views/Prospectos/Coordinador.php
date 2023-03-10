<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
    -->
    <?php 

    $mes = date('Y').'-12';
    $aux = date('Y-m-d', strtotime("{$mes} + 1 month"));
    $ultimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
    ?>
    <div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
        <div class="text-center well text-white blue no-print">
            <h2>Presupuesto Region #</h2>

        </div>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script type="text/javascript">
            $( function() {
    // An array of dates
    var eventDates = {};
    <?php for ($i=0; $i < count($fechas_cartera); $i++) { 

        $anio=substr($fechas_cartera[$i]->fecha, 0,4);
        $mes=substr($fechas_cartera[$i]->fecha, 5,2);
        $dia=substr($fechas_cartera[$i]->fecha, 8,2);
        $fecha=$anio."/".$mes."/".$dia;
        ?>
        eventDates[ new Date('<?php echo date($fecha)?>')] = new Date('<?php echo date($fecha)?>');

    <?php  }  ?>

    // datepicker
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function( date ) {
            var highlight = eventDates[date];
            if( highlight ) {
               return [true, "event", 'Tooltip text'];
           } else {
               return [true, '', ''];
           }
       }
   });
});



</script>
<style type="text/css">
    .event a {



        background-color: #5FBA7D !important;
        color: #ffffff !important;
    }
</style>
<div class="row">
 <div class="col-md-2" style="margin:  0em 0em 12px 0em;">
   <input type="hidden" name="segmento" id="segmento" class="form-control" placeholder="Product Code" value=<?= $segmento;?> >

</div>
<div class="col-sm-12 col-xs-12 print-col-md-10">
    <div class="well col-sm-12 col-xs-12 print-col-md-10">   
        <nav class="float-right"></nav>
        <div class="row">
           <?php 
           $pos2=strpos($_SESSION['login']['cargo'], 'Jefe de Producción');

           if ($pos2!==false) {

           }else{
              ?>
              <div class="panel-group col-sm-12">
                <div class="panel panel-success ">
                    <div class="panel-heading"><label>Presupuesto</label></div>

                        <div class="panel-body">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home" id="pag1">Grafico puntuado</a></li>
                                    <li><a data-toggle="tab" href="#menu1" id="pag2">Grafico de pastel</a></li>
                                </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active"><br>

                                      <?php 
                                      $pos2=strpos($_SESSION['login']['cargo'], 'Jefe de Producción');

                                      if ($pos2 !== false) {
                                         echo(' <input type="hidden" id="nap" name="mes">');
                                     }else{
                                      ?>
                                      <div>
                                        <label>Desde:</label>
                                        <input type="date" id="dDesde" value="<?php echo date('Y'); ?>-01-01">
                                        <label>Hasta:</label>
                                        <input type="date" id="dHasta" value="<?php echo $ultimo_dia; ?>">
                                        <button onclick="load()" value="Cargar">Cargar</button>
                                    </div>
                                    <?php  
                                } ?>  

                                    <div id="curve_chart" style="width: 100%; height: 500px"></div>
                                </div>
                                <div id="menu1" class="tab-pane fade"><br>
                                    <div>
                                        <label>Desde:</label>
                                        <input type="month" id="mes_grafico" value="2022-01">
                                            
                                        <button onclick="grafico_pastel()" value="Cargar">Cargar</button>
                                    </div>
                                    <div id="curve_chart2" style="width: 100%; height: 500px"></div>
                                </div>

                            </div>
                        </div>
            <div class="panel-footer">

            </div> 
        </div>
    </div>
    <?php  
} ?>
            <div class="col-md-3">
                <label>Fecha de carteras:</label>
                <input class="form-control" type="text" id="datepicker">

                          <!--<select id="fecha_cartera" class="form-control" selected="true">
                            <option value='0'>Seleccione una fecha</option>
                        <?php for ($i=0; $i < count($fechas_cartera); $i++) { ?>
                    <option value="<?php echo $fechas_cartera[$i]->fecha  ?>"><?php echo $fechas_cartera[$i]->fecha ?></option>
                      <?php  }  ?>
                  </select>-->
                  <br>
            </div>
              <div class="panel-group col-sm-12">
                <?php 
                $EmpresaR = 0;
                $region = 0 ;
                foreach ($agn as $Agencias) {
                    $agencia=substr($Agencias->id_cartera, 0,2);
                    $real = $presupuestado = 0;  
                    @$presupuestado=$presupuestados[intval($agencia)];
                    @$presupuestadoCE=$sumCartEfec[intval($agencia)];

                    @ $Pefic = $eficiencias[intval($agencia)];
                    @$AgenciasCarteras = $AgnCrt[intval($agencia)];
                    
                    @$Pefic = $Pefic/$AgenciasCarteras;
                    $Pefic = number_format($Pefic,2);
                    
                    @ $real= $generales[intval($agencia)];
                    

                    @$EmpresaR += $real;
                    @$iMora=$moro[intval($agencia)];


                    
                    //porque da division 0
                    
                    if ($iMora==0 or $real==0) {
                     $iMora= 1;

                 }

                 if ( $real==0) {

                    $real= 1;
                }
                $iMora = ($iMora/$real)*100;
                if (!isset($real)) {
                   $real = rand(1000,2500);
               }

               @$indice = ($real / $presupuestado) * 100;

               $indice= number_format($indice,2)       ;
                     //echo $iMora=$coordinador->Mora;

               $IEf = 100 - $iMora;
               $carteraEfectiva=($IEf/100)*$real;
               @$indiceCE = ($carteraEfectiva / $presupuestadoCE) * 100;   
               $carteraEfectiva=number_format($carteraEfectiva,2);
               $IEf = number_format($IEf,2);
               $iMora = number_format($iMora,2);

               @$indiceEficiencia = ($IEf/$Pefic)*100;

               /*Semaforo Cartera*/
               if ($indice>=90) {
                $color = "success";
            } else {
                if ($indice>=80) {
                    $color = "warning";
                }else{
                    $color = "danger";
                }
            }
            /*Semaforo Eficiencia*/
            if ($indiceEficiencia>=90) {
                $col = "success";
            } else {
                if ($indiceEficiencia>=80) {
                    $col = "warning";
                }else{
                    $col = "danger";
                }
            }
            /*Semaforo Eficiencia*/
            if ($indiceCE>=90) {
                $colEF = "success";
            } else {
                if ($indiceCE>=80) {
                    $colEF = "warning";
                }else{
                    $colEF = "danger";
                }
            }


            if($presupuestado>$real){
                $total = ($real*100)/$presupuestado;

            }else{
                $total = ($presupuestado*100)/$real;
            }   
            $nombreAgn = null;
            switch ($Agencias->id_cartera) {
             case 9:
             $nombreAgn = 'Quezaltepeque';
             break;
             case 14:
             $nombreAgn = 'Ateos';
             break;
             default:
             $nombreAgn = $Agencias->agencia;
             break;
         } 
         $pos2=strpos($_SESSION['login']['cargo'], 'Jefe de Producción');

         if ($pos2 !== false) {
            ?>
            <div class="panel-group col-sm-12">

                <?php

            }else{
                ?>                    
                <div class="panel-group col-sm-4">
                   <?php 
               }
               ?>


               <div class="panel panel-success ">
                <div class="panel-heading">
                    <label>Agencia: <?php echo ($nombreAgn) ; ?></label>
                    <a href="<?php echo site_url(); ?>/Permisos/Agencia/<?=substr($Agencias->id_cartera,0,2)?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                </div>
                <div class="panel-body">

                    <div class="col-sm-12">

                        <div class="panel panel-default">
                          <label>Fecha: <?php echo date("d/m/Y", strtotime($fechas)) ?></label>

                          <div class="panel-heading">
                              <label>Cumplimiento</label><span class="label label-<?= @$color?> "> <?=$indice?> %</span>

                          </div>

                          <div class="panel-body">
                            <?php                                

                            $real = number_format($real,2);
                            $presupuestado = number_format($presupuestado,2);
                            
                            ?>
                            <label>Cartera Global</label>

                            <div class="progress">
                                <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total?>%;">
                                    <label class="text-center" for="">$<?= $real?></label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Global</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                    <label class="text-center" for="">$<?= $presupuestado?></label>
                                </div>
                            </div>

                            <label>Cumplimiento Cartera Efectiva</label><span class="label label-<?= @$colEF?> "><?= number_format($indiceCE,2);?> %</span>



                            <label>Cartera Efectiva</label>

                            <div class="progress">
                                <div class="progress-bar progress-bar-<?= @$colEF?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indiceCE?>%;">
                                    <label class="text-center" for="">$<?= $carteraEfectiva?></label>
                                </div>
                            </div>
                            <label>Presupuesto Cartera Efectiva</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                    <label class="text-center" for="">$<?= number_format($presupuestadoCE,2);?></label>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading"><label>Indice eficiencia </label></div>
                        <div class="panel-body">
                            <label>Cumplimiento:</label><span class="badge badge-<?= @$col?>"><?= number_format($indiceEficiencia,2)?>%</span>
                            <div class="col-sm-6">
                                <label>Real:</label><span class="label label-<?= @$col?>"><?=$IEf?> %</span>
                            </div>
                            <div class="col-sm-6">
                                <label>Presupuesto:</label><span class="label label-default"><?=$Pefic?> %</span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="panel-footer">
                <label>Encargado: </label><br>
                <div class="btn-group">
                    <a class="btn btn-default" href="#"><i class="fa fa-user fa-fw"></i> <?= @$Agencias->nombre. ' '. @$Agencias->apellido;?></a>
                    <a class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false" href="#">
                        <span class="fa fa-caret-down" title="Toggle dropdown menu"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><i class="fa fa-pencil fa-fw"></i> Ver Informacion</a></li>
                        <li class="divider"></li>
                        <li><a href="#"><i class="fa fa-unlock"></i> Permisos</a></li>
                    </ul>
                </div>
            </div> 
        </div>
    </div>
    <?php 

} ?>

</div>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
 google.charts.load('current', {packages: ['corechart', 'line'], 'language': 'es'});
 google.charts.setOnLoadCallback(drawCurveTypes);
 var f = new Date();
 var anio = f.getFullYear();
 var valor=(f.getMonth() +1);

 function load() {
    var segmento = $('#segmento').val();
    fdesde = $("#dDesde").val();
    fHasta = $("#dHasta").val();
    if (fdesde!=null) {

      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Permisos/graficoRegion')?>",
        dataType : "JSON",
        data : { desde:fdesde, hasta:fHasta,segmento:segmento},
        success: function(data){
            drawCurveTypes(data);
        },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
        }
    });
  }

}
    function grafico_pastel(){
       // $(document).ready(function(){
      
            mes = $("#mes_grafico").val();
            

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/grafico_pastel_region')?>",
                dataType : "JSON",
                data : { mes:mes},
                success: function(data){
                    drawChart(data);


                },  
                error: function(data){
                    //drawCurveTypes(data);
                    var a =JSON.stringify(data);
                    alert(a);
                }
            });
        //});
    }
window.onload = load;
$(document).ready(function(){
    document.ready = document.getElementById("datepicker").value = 'Seleccione una fecha';






    $("#datepicker").change(function () {
        date= $("#datepicker").val();
        <?php if ($segmento=='CM01') { ?> 
           window.location.href = "<?php echo site_url() ?>/Permisos/fecha_region/"+date+'/CM01';
       <?php }elseif ($segmento=='JB02') { ?>
           window.location.href = "<?php echo site_url() ?>/Permisos/fecha_region/"+date+'/JB02';

       <?php }elseif ($segmento=='MG03') { ?>
           window.location.href = "<?php echo site_url() ?>/Permisos/fecha_region/"+date+'/MG03';

           <?php  
       } ?>

       return false;          
   });

    $("#nap").change(function () {
        valor= $("#nap").val();
        valor=valor.substr(5, 2);

        load();


    });
});

function drawCurveTypes(datos) {
    console.log(datos);
    var data = new google.visualization.DataTable();
    if(datos != undefined){
        arreglo=Object.values(datos.sumatorias);//pasar de objeto a arreglo
        data.addColumn('date', 'X');
        if (arreglo[0].fecha<='2021-12-31') {

            data.addColumn('number', 'Presupuesto Cartera Global');

            data.addColumn('number', 'Cartera Global');
            data.addColumn('number', 'Cartera efectiva');
            data.addColumn('number', 'Presupuesto Cartera Efectiva');
        }else if(arreglo[0].fecha>='2022-01-01'){
            data.addColumn('number', 'Presupuesto Cartera Activa');

            data.addColumn('number', 'Cartera Activa');
            data.addColumn('number', 'Presupuesto Cartera en Recuperacion');
            data.addColumn('number', 'Cartera en Recuperacion');
            data.addColumn('number', 'Cartera Efectiva Presupuestada');
            data.addColumn('number', 'Cartera Efectiva');


        }

        $.each(datos.sumatorias, function(i, item) {
            if(datos.sumatorias[i].presu >0){

                presu = parseFloat(datos.sumatorias[i].presu)
                cart =  parseFloat(datos.sumatorias[i].cart)
                cartera_recuperacion_presu=parseFloat(datos.sumatorias[i].cartera_recuperacion_presu)

                carEfec = parseFloat(datos.sumatorias[i].carEfec)
                car_efectiva_presupuestada = parseFloat(datos.sumatorias[i].car_efectiva_presupuestada)

                //carteraEfectiva=parseFloat(datos.sumatorias[i].carEfec)

       
                if(cart==0){
                    cart=null;
                }

                dddia = new Date(datos.sumatorias[i].fecha);
                dddia.setDate(dddia.getDate()+1);
                dddia.setHours(0,0,0);
                data.addRows([
                    [dddia, presu, cart,cartera_recuperacion_presu,null,car_efectiva_presupuestada,carEfec,]
                    ]);  
            }
        });


        
        var options = {
            pointSize: 5,
            fontSize: 11,
            hAxis: {
                title: 'Mes'
            },
            vAxis: {
                minValue: 0
                //title: 'Popularity'
            },
            chartArea : { left: 120, top:50, right:120 },
            legend: { position: 'bottom' },
            width: 1035,
            height: 500
            //curveType: 'function'
        };
        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
}
</script>


</body>
</html>