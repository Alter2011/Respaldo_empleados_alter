      <?php 

    $mes = date('Y').'-12';
    $aux = date('Y-m-d', strtotime("{$mes} + 1 month"));
    $ultimo_dia = date('Y-m-d', strtotime("{$aux} - 1 day"));
    ?>

    <div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">

    <div class="text-center well text-white blue no-print">
            <h2>Indicadores Operaciones</h2>

        </div>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>
        <script type="text/javascript">
    </script>

<div class="row">
 
<div class="col-sm-12 col-xs-12 print-col-md-10">
    <div class="well col-sm-12 col-xs-12 print-col-md-10">   
        <nav class="float-right"></nav>
        <div class="row">
        
              <div class="panel-group col-sm-12">
                <div class="panel panel-success ">
                    <div class="panel-heading"><label>Indicadores</label></div>

                        <div class="panel-body">
                              
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active"><br>

                                    
                                    <div>
                                        <label>Desde:</label>
                                        <input type="date" id="dDesde" value="<?php echo date('Y'); ?>-01-01">
                                        <label>Hasta:</label>
                                        <input type="date" id="dHasta" value="<?php echo $ultimo_dia; ?>">
                                        <button onclick="load()" value="Cargar">Cargar</button>
                                    </div>
                                 
                                </div>
                              
                            </div>
                        </div>
          
        </div>
    </div>
    

           
              <div class="panel-group col-sm-12">
                <?php 
        
                foreach ($info as $indic) {
                    

               ?>
                          
               <div class="panel-group col-sm-4">
            

               <div class="panel panel-success ">
                <div class="panel-heading">
                    <label>Agencia: <?php echo ($indic->agencia) ; ?></label>
                </div>
                <div class="panel-body">

                    <div class="col-sm-12">

                        <div class="panel panel-default">
                      


                          <div class="panel-body">
                            

                            <label>Inactivos</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->inactivos?>%;">
                                    <label class="text-center" for=""><?= $indic->inactivos?></label>
                                </div>
                            </div>

                            <label>Mora 8</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->mora_8?>%;">
                                    <label class="text-center" for=""><?= $indic->mora_8?></label>
                                </div>
                            </div>


                            <label>Mora 15</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-<?= @$colEF?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->mora_15?>%;">
                                    <label class="text-center" for=""><?= $indic->mora_15?></label>
                                </div>
                            </div>

                            <label>Colocacion nuevos</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->colocacion_nuevos?>%;">
                                    <label class="text-center" for=""><?= $indic->colocacion_nuevos?></label>
                                </div>
                            </div>


                            <label>Reproceso</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->reproceso?>%;">
                                    <label class="text-center" for=""><?= $indic->reproceso?></label>
                                </div>
                            </div>


                            <label>Reconsideraciones</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->reconsideraciones?>%;">
                                    <label class="text-center" for=""><?= $indic->reconsideraciones?></label>
                                </div>
                            </div>


                            <label>Acuerdos</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->acuerdos?>%;">
                                    <label class="text-center" for=""><?= $indic->acuerdos?></label>
                                </div>
                            </div>

                            <label>Vencidos Historicos</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->vencidos_historicos?>%;">
                                    <label class="text-center" for=""><?= $indic->vencidos_historicos?></label>
                                </div>
                            </div>

                            <label>Vencidos año actual</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->vencidos_actual?>%;">
                                    <label class="text-center" for=""><?= $indic->vencidos_actual?></label>
                                </div>
                            </div>

                            <label>Vencidos nuevos</label>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indic->vencidos_nuevos?>%;">
                                    <label class="text-center" for=""><?= $indic->vencidos_nuevos?></label>
                                </div>
                            </div>

                        </div>
                    </div>

                 
                </div>
            </div>
          
        </div>
    </div>
    <?php 
    } 
    ?>


</div>
</div>
</div>
</div>
</div>
</div>


</body>
</html>