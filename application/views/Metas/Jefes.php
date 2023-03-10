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
        <input type="button" onclick="window.print();" value="Print Invoice" />
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                <div class="row">
                    
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading"><label>Presupuesto</label></div>
                            <div class="panel-body">
                                <div id="curve_chart" style="width: 100%; height: 500px"></div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                    <?php 
                    
                    $region = 0 ;
                    foreach ($agn as $Agencias) {
                        //echo $coordinador->nombre;
                        $region++;
                        $presupuestado = rand(2000,3500);
                        $real = rand(1000,2500);
                        if($presupuestado>$real){
                            $total = ($real*100)/$presupuestado;

                        }else{
                            $total = ($presupuestado*100)/$real;
                        }
                        

                    ?>
                    <div class="panel-group col-sm-4">
                        <div class="panel panel-success ">
                            <div class="panel-heading">
                            <label>Cartera: <?= $Agencias->cartera?></label>
                            <a href="<?php echo site_url(); ?>/Permisos/Agencia/<?=$Agencias->id_cartera?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                                
                                
                            </div>
                            <div class="panel-body">
                                
                                <div class="col-sm-12">
                                <?php 
                                if ($presupuestado>$real) {
                                    ?>
                                    <label>Cartera Actual</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total?>%;">
                                            <label class="text-center" for="">$<?= $real?></label>
                                        </div>
                                    </div>
                                    <label>Presupuestado</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $presupuestado?></label>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <label>Cartera Actual</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $real?></label>
                                        </div>
                                    </div>
                                    <label>Presupuestado</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total?>%;">
                                            <label class="text-center" for="">$<?= $presupuestado?></label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                                ?>
                                    
  
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Mes', 'Presupuestado', 'Real'],
          ['Enero'     , 30, 50],
          ['Febrero'   , 90, 100],
          ['Marzo'     , 100, 150],
          ['Abril'     , 162, 190],
          ['Mayo'      , 200, 260],
          ['Junio'     , 260, 270],
          ['Julio'     , 300, 350],
          ['Agosto'    , 325, 400],
          ['Septiembre', 437, 410],
          ['Octubre'   , 487, 483],
          ['Noviembre' , 600, 533],
          ['Diciembre' , 941, 666]
        ]);

        var options = {
          title: 'Presupuesto Altercredit',
          hAxis: {title: 'Mes',  titleTextStyle: {color: '#333'}},
          vAxis: {title: 'Dineros', minValue: 0},
          //curveType: 'function',
          legend: { position: 'bottom' }
        };

        //var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        //chart.draw(data, options);
        var chart = new google.visualization.AreaChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
      }
    </script>

</body>
</html>