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
        <h2>Metas &lt;&lt;General/Regional/Agencia/Personal&gt;&gt;</h2>
        <input type="button" onclick="window.print();" value="Print Invoice" />
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                <div class="row">
                <!--Inicio Script para Gantt-->
                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['gantt']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                    var data = new google.visualization.DataTable();
                    data.addColumn('string', 'Task ID');
                    data.addColumn('string', 'Task Name');
                    data.addColumn('string', 'Resource');
                    data.addColumn('date', 'Start Date');
                    data.addColumn('date', 'End Date');
                    data.addColumn('number', 'Duration');
                    data.addColumn('number', 'Percent Complete');
                    data.addColumn('string', 'Dependencies');

                    data.addRows([
                        ['MC1', 'MC Produccion', 'spring',
                        new Date(2018, 11, 31), new Date(2019, 11, 31), null, 100, null],
                            ['ML12', 'ML Produccion 11', 'autumn',
                            new Date(2019, 4, 15), new Date(2019, 10, 27), null, 100, 'MC1'],
                            ['ML11', 'ML Produccion 12', 'summer',
                            new Date(2019, 5, 15), new Date(2019, 10, 31), null, 100, 'MC1'],
                            
                        ['MC2', 'MC2 Produccion', 'winter',
                        new Date(2018, 11, 31), new Date(2019, 11, 31), null, 100, null],
                            ['ML21', 'Spring 2015', 'spring',
                            new Date(2019, 2, 22), new Date(2019, 5, 20), null, 50, 'MC2'],
                            ['ML22', 'Summer 2015', 'summer',
                            new Date(2019, 5, 21), new Date(2019, 8, 20), null, 0, 'MC2'],
                            ['ML23', 'Autumn 2015', 'autumn',
                            new Date(2019, 8, 21), new Date(2019, 11, 20), null, 0, 'MC2'],
                        ['MC3', 'MC3 Produccion', 'winter',
                        new Date(2018, 11, 31), new Date(2019, 11, 31), null, 0, null],
                            ['ML31', 'ML33', 'sports',
                            new Date(2019, 10, 4), new Date(2019, 11, 1), null, 100, 'MC3'],
                            ['ML32', 'Baseball Season', 'sports',
                            new Date(2019, 7, 31), new Date(2019, 9, 20), null, 14, 'MC3'],
                            ['ML33', 'Baseball', 'sports',
                            new Date(2019, 8, 31), new Date(2019, 9, 20), null, 64, 'MC3']
                    ]);

                    var options = {
                        height: 400,
                        gantt: {
                            barCornerRadius:10,
                        trackHeight: 30,
                        arrow: {
              angle: 100,
              width: 0,
              color: 'green',
              radius: 1000
            }
                        }
                    };

                    var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

                    chart.draw(data, options);
                    }
                </script>
                <!--Fin Script para Gantt-->
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-primary ">
                            <div class="panel-heading text-center"><label>Produccion</label></div>
                            <div class="panel-body">
                                <div id="chart_div"></div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading text-center"><label>Informatica</label></div>
                            <div class="panel-body">
                                <div class="panel-group col-sm-12">
                                    <div class="panel panel-primary ">
                                        <div class="panel-heading text-center"><label>MC 1</label></div>
                                        <div class="panel-body">
                                            <div class="col-sm-4">
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 1</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:84%;">
                                                                    <label class="text-center" for="">84</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 2</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                        <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:65%;">
                                                                    <label class="text-center" for="">65</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 3</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:90%;">
                                                                    <label class="text-center" for="">90</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <label>MC Completada</label>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:79.6%;">
                                                    <label class="text-center" for="">79.6%</label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="panel panel-primary ">
                                        <div class="panel-heading text-center"><label>MC 2</label></div>
                                        <div class="panel-body">
                                        <div class="col-sm-4">
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 1</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:84%;">
                                                                    <label class="text-center" for="">84</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 2</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                        <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:65%;">
                                                                    <label class="text-center" for="">65</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 3</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:90%;">
                                                                    <label class="text-center" for="">90</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <label>MC Completada</label>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:79.6%;">
                                                    <label class="text-center" for="">79.6%</label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="panel panel-primary ">
                                        <div class="panel-heading text-center"><label>MC 3</label></div>
                                        <div class="panel-body">
                                        <div class="col-sm-4">
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 1</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> 
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:84%;">
                                                                    <label class="text-center" for="">84</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 2</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> 
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                        <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:65%;">
                                                                    <label class="text-center" for="">65</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                            
                                                <div class="panel-group col-sm-12">
                                                    <div class="panel panel-success ">
                                                        <div class="panel-heading text-center"><label>ML 3</label></div>
                                                        <div class="panel-body">
                                                            <div class="alert alert-info">
                                                                <strong>Compromiso</strong> 
                                                            </div>
                                                        </div>
                                                        <div class="panel-footer">
                                                            <label>ML Completada</label>
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:90%;">
                                                                    <label class="text-center" for="">90</label>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="panel-footer">
                                            <label>MC Completada</label>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:79.6%;">
                                                    <label class="text-center" for="">79.6%</label>
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading text-center"><label>Recursos Humanos</label></div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <strong>Compromiso</strong> 
                                </div>
                                <div class="alert alert-warning">
                                    <strong>Medida de Logro!</strong> Meta Critica descrita por cada departamento
                                </div>
                                <div class="alert alert-warning">
                                    <strong>Medida de Logro!</strong> Meta Critica descrita por cada departamento
                                </div>
                                <div class="alert alert-info">
                                    <strong>Compromiso</strong>
                                </div>
                                <div class="alert alert-warning">
                                    <strong>Medida de Logro!</strong> Meta Critica descrita por cada departamento
                                </div>
                                <div class="alert alert-warning">
                                    <strong>Medida de Logro!</strong> Meta Critica descrita por cada departamento
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading text-center"><label>Tesoreria</label></div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <strong>Compromiso</strong> 
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading text-center"><label>Operaciones</label></div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <strong>Compromiso</strong> 
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-success ">
                            <div class="panel-heading text-center"><label>Comunicaciones</label></div>
                            <div class="panel-body">
                                <div class="alert alert-info">
                                    <strong>Compromiso</strong> Meta Critica descrita por cada departamento
                                </div>
                            </div>
                            <div class="panel-footer">
                                
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                    <?php 
                    
                    $region = 0 ;
                    foreach ($permisos as $coordinador) {
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
                            <label>Region #<?= $region?></label>
                            <a href="<?php echo site_url(); ?>/Permisos/Region/<?=$coordinador->id_usuarios?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                                
                                
                            </div>
                            <div class="panel-body">
                                
                                <div class="col-sm-12">
                                <?php 
                                if ($presupuestado>$real) {
                                    ?>
                                    <label>Presupuesto Real</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $total?>%;">
                                            <label class="text-center" for="">$<?= $real?></label>
                                        </div>
                                    </div>
                                    <label>Presupuesto Esperado</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $presupuestado?></label>
                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <label>Presupuesto Real</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $real?></label>
                                        </div>
                                    </div>
                                    <label>Presupuesto Esperado</label>
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
                                <label>Encargado: </label>
                                <div class="btn-group">
                                    <a class="btn btn-default" href="#"><i class="fa fa-user fa-fw"></i> <?= $coordinador->nombre.' '.$coordinador->apellido;?></a>
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

</body>
</html>