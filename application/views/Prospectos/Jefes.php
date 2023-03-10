<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->

<div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Presupuesto &lt;&lt;Regional/Agencia/Personal&gt;&gt;</h2>
        
    </div>
    <div class="row">
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

        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                <div class="row">
                    <div class="col-md-2" style="margin:  0em 0em 12px 0em;">

             <input type="hidden" name="segmento" id="segmento" class="form-control" placeholder="Product Code" value=<?= $segmento;?>>

            <?php
             $pos2=strpos($_SESSION['login']['cargo'], 'Asesor');

             if ($pos2 !== false){ ?>
            <input type="hidden" id="nap" name="mes">
                               <?php }else{ ?>
                                 <input type="month" id="nap" name="mes">
            <?php } ?>
               
                    </div>
                    <?php
                     $pos2=strpos($_SESSION['login']['cargo'], 'Asesor');
                     
                     if ($pos2 !== false){ ?>
                          <div class="panel-group col-sm-12">
                        <div hidden="true" class="panel panel-success ">
                            <div class="panel-heading"><label>Presupuesto</label></div>
                            <div class="panel-body">
                                <div  id="curve_chart" style="width: 100%; height: 500px"></div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <?php }else{ ?>
                          <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading"><label>Presupuesto</label></div>
                            <div class="panel-body">
                                <div  id="curve_chart" style="width: 100%; height: 500px"></div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <?php } ?>
                  
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
                    
                     //echo "<pre>";
                     //print_r( $agn);
                    // echo "</pre>";
                    foreach ($agn as $Agencias) 
                    {
                         $sumPres=0;
                     $total=0;
                     $real=0;
                                            $presupuestado=null;
                     $carteraEfectivaPresu=null;

                        for ($i=0; $i <count($general) ; $i++) 
                        { 
                            if (((int) $Agencias->id_cartera)==$general[$i]->sucursal) 
                            {
                              $fecha=$general[$i]->fecha;

                              $real=  $general[$i]->cartera;
                              $iMora = $general[$i]->mora;
                    
                              @$iMora = ($iMora/$real)*100;
                            }
                        }

                     for ($i=0; $i <count($presupue) ; $i++) 
                     { 
                            if (((int) $Agencias->id_cartera)==$presupue[$i]->cartera) 
                            {
                             $presupuestado=$presupue[$i]->presupuestado;
                             $carteraEfectivaPresu=$presupue[$i]->cartera_efectiva;

                             $sumPres+=$presupue[$i]->presupuestado;
                             $ipresu = $presupue[$i]->indice_eficiencia;
                            }
                      }

                       /* if (!isset($real)) 
                        {
                             $real = rand(1000,2500);
                        }*/
                         if (!isset($presupuestado)) 
                        {
                            @$presupuestado = 1;
                             $ipresu= rand(1,100);
                        }

                        @$indice = ($real / $presupuestado) * 100;   
                        @$indice= number_format($indice,2)       ;
                        
                        @$IEf = 100 - $iMora;
                    
       
                        $carteraEfectiva=($IEf/100)*$real;
                     @$indiceCE = ($carteraEfectiva / $carteraEfectivaPresu) * 100;   
                        $carteraEfectiva=number_format($carteraEfectiva,2);



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
                        $IEf = number_format($IEf,2);
                        @$iMora = number_format($iMora,2);
                        @$indiceEficiencia = ($IEf/$ipresu)*100;
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

                        if($presupuestado>@$real){
                            @$total = ($real*100)/$presupuestado;
                             $total2=100;

                        }else{ 
                             $total=100;

                            $total2 = ($presupuestado*100)/$real;
                        }
                        // $presupuestado = 0;
                    ?>
                    <div class="panel-group col-sm-4">
                        <div class="panel panel-success ">
                            <div class="panel-heading">
                            <label>Cartera: <?= $Agencias->cartera?> </label>

                            <a href="<?php echo site_url(); ?>/Permisos/Agencia/<?=$Agencias->id_cartera?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                                
                                
                            </div>
                            <div class="panel-body">
                                
                                <div class="col-sm-12">
                                <label>Fecha: <?php echo date("d/m/Y", strtotime(@$fecha)) ?></label>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                      <label>Cumplimiento</label><span class="label label-<?= @$color?> "><?=$indice?> %</span><br>
           
                                    </div>
                                    <div class="panel-body">
                    
                                    <label>Cartera Actual</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total?>%;">
                                            <label class="text-center" for="">$<?= number_format($real,2)?></label>
                                        </div>
                                    </div>
                                    <label>Presupuesto</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total2?>%;">
                                            <label class="text-center" for="">$<?= number_format($presupuestado,2)?></label>
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
                                                <label class="text-center" for="">$<?= number_format($carteraEfectivaPresu,2);?></label>
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
                                            <label>Presupuesto:</label><span class="label label-default"><?=$ipresu?> %</span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <label>Encargado: </label></br>
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
                    
                    <?php  
                    $resul=0;
                    $sumatoria[0]=0;
                    for ($k=1; $k <=12 ; $k++) { 
                
                        for ($i=0; $i <count($general) ; $i++) { 
                          /*

                          $jd=gregoriantojd(substr($general[$i]->fecha, 5, 2),substr($general[$i]->fecha, 8, 2),substr($general[$i]->fecha, 0, 4));
                            $resulta=jddayofweek($jd,0);//toma el valor numerico del dia del mes
                            echo $resulta .'  ';
                            */
                           $resultado = substr($general[$i]->fecha, 5, 2);
                           if ($k==$resultado) {
                              $resul += $general[$i]->cartera;

                          }
                      }
                      if ($resul==0) {
                        $sumatoria[$k]=$sumatoria[$k-1];         
                    }else{ $sumatoria[$k]=$resul;}
                    
                    $resul=0;
                }
                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">

          google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawCurveTypes);

   var f = new Date();
        var valor=(f.getMonth() +1);
        var anio = f.getFullYear();
       
        function load() {
                 var segmento = $('#segmento').val();
                 var nap = $('#nap').val();
                 if (segmento.length>2) {
                  segmento=segmento.substr(0,2);
                 }
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/cargarGrafico')?>",
                dataType : "JSON",
                data : { segmento:segmento, valor:valor,nap:nap},
                success: function(data){
                 //alert(data[1][1]);
                 drawCurveTypes(data);

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
      }
      window.onload = load;
 
      $(document).ready(function(){
   
        if (valor<=9) {
            document.ready = document.getElementById("nap").value = anio+'-0'+valor;
        } else {
            document.ready = document.getElementById("nap").value = anio+'-'+valor;
        }
    document.ready = document.getElementById("datepicker").value = 'Seleccione una fecha';

        $("#datepicker").change(function () {
                             var segmento = $('#segmento').val();

                    date= $("#datepicker").val();
         window.location.href = "<?php echo site_url() ?>/Permisos/fecha_carteras/"+date+'/'+segmento;

            return false;          
        });
        $("#nap").change(function () {
            valor= $("#nap").val();
            valor=valor.substr(5, 2);
          load();

       
         });

    });



    function drawCurveTypes(datos) {
        var data = new google.visualization.DataTable();
        fecha_actual=document.getElementById("nap").value;
        data.addColumn('date', 'X');
        if (fecha_actual<='2021-12') {

            data.addColumn('number', 'Presupuesto Cartera Global');

            data.addColumn('number', 'Cartera Global');
            data.addColumn('number', 'Cartera efectiva');
            data.addColumn('number', 'Presupuesto Cartera Efectiva');
        }else if(fecha_actual>='2022-01'){
            data.addColumn('number', 'Presupuesto Cartera Activa');

            data.addColumn('number', 'Cartera Activa');
            data.addColumn('number', 'Presupuesto Cartera en Recuperacion');
            data.addColumn('number', 'Cartera en Recuperacion');
            data.addColumn('number', 'Presupuesto Cartera Efectiva');
            data.addColumn('number', 'Cartera Efectiva');


        }

        console.log(datos);
        anio=fecha_actual.substr(0,4);
        mes=fecha_actual.substr(5,2);
                //or cartera like '03%' or cartera like '04%' or cartera like '07%' or cartera like '08%' or cartera like '10%' or cartera like '22%'

                for (var i = 1; i <= 31; i++) {
                  if (i==i) { 
                   if (datos[0][i]!=null) {
                        data.addRows([
                    [new Date(anio,mes-1, i),   datos[0][i] , datos[1][i],datos[2][i],null,datos[4][i],datos[5][i]],
        
                    ]);
                    }
                }
                    }
                     
                
            

        var options = {
            pointSize: 5,
            hAxis: {
                title: 'Mes'
            },
            vAxis: {
                //title: 'Popularity'
            },
            legend: { position: 'bottom' },
            //curveType: 'function'
            chartArea : { left: 120, top:50, right:120 },
                    language: 'spanish',
                    width: 965,
                    height: 500
        };


            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
            chart.draw(data, options);
            
    }
     
    </script>
    </script>

</body>
</html>