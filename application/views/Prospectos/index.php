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
        $fecha2=$anio."/".$mes."/".$dia;
          ?>
     eventDates[ new Date('<?php echo date($fecha2)?>')] = new Date('<?php echo date($fecha2)?>');

                      <?php  }  ?>
   
    // datepicker
    $('#datepicker').datepicker({
        dateFormat: 'yy-mm-dd',
        beforeShowDay: function( date ) {
            var highlight = eventDates[date];
            if( highlight ) {
                 return [true, "event", 'Datos ingresados'];
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
<div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Presupuesto Gerencial</h2>
        
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                <div class="row">
                    <?php
                    $usuarioP = null;
                    if (isset($_SESSION['login'])){ $usuarioP = ($_SESSION['login']['prospectos']);}
        
                                $EmpresaP = 0;
                                $EmpresaR = 0;
                           

                                $EmpresaMora = 0;
                                foreach ($permisos as $coordinador) {
                                    /*echo "<pre>";
                                    print_r($coordinador);
                                    echo "</pre>";*/
                                    
                                    $EmpresaR += $coordinador->Cartera;
                                    $EmpresaMora += $coordinador->Mora;
                                
                                }
                                
                                $EmpresaP = array_sum($sumPres);
                                $EmpresaEficP = array_sum($sumEfic);
                                $SUMEmpresaEficP = array_sum($sumCartEfec);
                                $EmpresaAgn = array_sum($sumAgn);

                                @$EmpresaEficP = $EmpresaEficP/$EmpresaAgn;
                                @$EmpresaEfic =100-($EmpresaMora/$EmpresaR)*100;
                                $EmpresaIE = ($EmpresaEfic/$EmpresaEficP)*100;                  
                                $carteraEfectiva=($EmpresaEfic/100)*$EmpresaR;

                                if ($EmpresaR>$EmpresaP) {
                                    $EmpresaT = ($EmpresaP/$EmpresaR)*100;
                                    
                                }else{
                                    
                                 @   $EmpresaT = ($EmpresaR/$EmpresaP)*100;
                                    
                                }
                                    @$EmpresaCE = ($carteraEfectiva/$SUMEmpresaEficP)*100;

                                
                                if ($EmpresaT>=90) {
                                    $color = "success";
                                } else {
                                    if ($EmpresaT>=80) {
                                        $color = "warning";
                                    }else{
                                        $color = "danger";
                                    }
                                }
                                /*Semaforo Eficiencia*/
                                if ($EmpresaEfic>=90) {
                                    $col = "success";
                                } else {
                                    if ($EmpresaEfic>=80) {
                                        $col = "warning";
                                    }else{
                                        $col = "danger";
                                    }
                                }
                                //SEMAFORO CARTERA EFECTIVA
                                    if ($EmpresaCE>=90) {
                                    $colorEF = "success";
                                } else {
                                    if ($EmpresaCE>=80) {
                                        $colorEF = "warning";
                                    }else{
                                        $colorEF = "danger";
                                    }
                                }
                    
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

                                        <div>
                                            <label>Desde:</label>
                                            <input type="date" id="dDesde" value="2022-01-01">
                                            <label>Hasta:</label>
                                            <input type="date" id="dHasta" value="2022-12-31">
                                            <button onclick="ffecha()" value="Cargar">Cargar</button>
                                        </div>
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
                        <div class="col-md-3">
                                <label>Fecha de carteras:</label>
                               <input class="form-control" type="text" id="datepicker">

                               
                            <br>
                        </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-primary ">
                            <div class="panel-heading"><label style="margin-right: 80%">Empresa</label>  <label>Fecha: <?php echo date("d/m/Y", strtotime(@$fecha)) ?></label></div>
                            <div class="panel-body">
                                <div class="panel panel-default">
                                    <div class="panel-heading"><label>Cartera</label></div>
                                    <div class="panel-body">
                                        <label>Cumplimiento<span class="label label-<?= @$color?> "><?=number_format($EmpresaT,2)?>%</span></label><br>
                             
                                        <label>Cartera Global</label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?=number_format($EmpresaT,2)?>%;">
                                                <label class="text-center" for="">$<?=number_format($EmpresaR,2)?></label>
                                            </div>
                                        </div>
                                        <label>Presupuesto Cartera Global</label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                                <label class="text-center" for="">$<?=number_format($EmpresaP,2)?></label>
                                            </div>
                                        </div>
                                        <label>Cumplimiento Cartera Efectiva<span class="label label-<?= @$colorEF?> "><?=number_format($EmpresaCE,2)?>%</span></label><br>
                                        <label>Cartera Efectiva</label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-<?= @$colorEF?> progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?=number_format($EmpresaCE,2)?>%;">
                                                <label class="text-center" for="">$<?=number_format($carteraEfectiva,2)?></label>
                                            </div>
                                        </div>
                                       <label>Presupuesto Cartera Efectiva</label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                                <label class="text-center" for="">$<?=number_format($SUMEmpresaEficP,2)?></label>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading"><label>Indice Eficiencia</label></div>
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <label>Cumplimiento:</label><span class="badge badge-<?= @$color?>"><?= number_format($EmpresaIE,2)?>%</span>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Global:</label><span class="label label-<?= @$color?>"></span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped active" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= number_format($EmpresaEfic,2)?>%;">
                                                    <label class="text-center" for=""><?= number_format($EmpresaEfic,2)?>%</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label>Esperada:</label><span class="label label-default"></span>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                                    <label class="text-center" for=""><?= number_format($EmpresaEficP,2)?>%</label>
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
                    <?php
                     
                    ?>
                     <div class="panel-group col-sm-12">
                    <?php 
                    $region = 0 ;
                    
                    foreach ($permisos as $coordinador) {
                        //echo $coordinador->nombre;
                        if ($usuarioP=='MG03' or $usuarioP=='CM01' or $usuarioP=='JB02') {
                            
                            if ($usuarioP!=$coordinador->id_usuarios){
                                continue;
                            }
                        }
                        //echo "<pre>";
                        //print_r($graficarP);
                        //echo"<br>";
                        //print_r($graficarG[0]->fecha);
                        //echo "</pre>";
                        switch ($coordinador->id_usuarios) {

                            
                            case 'JB02'://Region 1
                                $presupuestado = $sumPres[1];
                                $agencias = $sumAgn[1];//Total de carteras bajo su cargo
                                $Pefic = $sumEfic[1];
                                $real = $coordinador->Cartera;
                                $iMora=$coordinador->Mora;
                                $region=1;
                                $EficP = $sumCartEfec[1];

                               
                                break;
                            case 'MG03':
                                $presupuestado = $sumPres[2];
                                $agencias = $sumAgn[2];//Total de carteras bajo su cargo
                                $Pefic = $sumEfic[2];
                                $real = $coordinador->Cartera;
                                $iMora=$coordinador->Mora;
                                $region=3;
                                $EficP = $sumCartEfec[2];

                                
                                
                                break; 
                                case 'CM01'://Region 2
                                $presupuestado = $sumPres[0];
                                $agencias = $sumAgn[0];//Total de carteras bajo su cargo
                                $Pefic = $sumEfic[0];
                                $real = $coordinador->Cartera;
                                $iMora=$coordinador->Mora;
                                $region=2;
                                $EficP = $sumCartEfec[0];

                               
                                break;                           
                            default:
                                # code...
                                break;
                        }     
               
                            


                        @$indice = ($real / $presupuestado) * 100;   
                        $indice= number_format($indice,2);
                        //echo $iMora=$coordinador->Mora;
                       // echo $iMora;
                        @$iMora = ($iMora/$real)*100;
                        $IEf = 100 - $iMora;
                        $CarteraEfe=$real*($IEf/100);
                        $IEf = number_format($IEf,2);
                        $iMora = number_format($iMora,2);
                        @$Pefic = $Pefic/$agencias;
                        
                        $Pefic= number_format($Pefic,2)  ;
                        
                        @$indiceEficiencia = ($IEf/$Pefic)*100;


                                $EmpresaIE = ($IEf/$EmpresaEficP)*100;                  

                            

                                    @$regionCE = ($CarteraEfe/$EficP)*100;




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
                            //SEMAFORO CARTERA EFECTIVA
                                    if ($regionCE>=90) {
                                    $colorREF = "success";
                                } else {
                                    if ($regionCE>=80) {
                                        $colorREF = "warning";
                                    }else{
                                        $colorREF = "danger";
                                    }
                                }
                        
                        if($presupuestado>$real){
                            $total = ($real*100)/$presupuestado;

                        }else{
                            @$total = ($presupuestado*100)/$real;
                        }                                                
                        //$real = number_format($real,2);
                        $indiceEficiencia = number_format($indiceEficiencia,2);
                        $presupuestado = number_format($presupuestado,2);

                        if ($usuarioP=='JB02' or $usuarioP=='CM01' or $usuarioP=='MG03') {

                    ?>    
                    <div class="panel-group col-sm-12">
                    <?php
                    }else{
                    ?>
                    <!-- Muestra columnas de coordinadores -->
                    <div class="panel-group col-sm-4">
                    <?php
                    }
                    ?>
                        <div class="panel panel-success ">
                            <div class="panel-heading">
                            <label style="margin-right: 125px">R<?= $region?></label>  <label>Fecha: <?php echo date("d/m/Y", strtotime(@$fecha)) ?></label>
                            <a href="<?php echo site_url(); ?>/Permisos/Region/<?=$coordinador->id_usuarios?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                                
                                
                            </div>
                            <div class="panel-body">
                                <div class="alert alert-info text-center">
                                    <strong class="text-center">Agencias ingresadas</strong> <br>
                                    <span class="badge"><?=($coordinador->AgnUpload);?></span>/<span class="badge"><?=count($coordinador->AgnTotal);?></span>
                                </div>
                                <div class="col-sm-12">
                                
                                <div class="panel panel-default">
                                    <div class="panel-heading"><label>Cartera</label></div>
                                    <div class="panel-body">
                                <?php 
                                if ($presupuestado<$real) {
                                    ?>
                                    <label>Cumplimiento</label>
                                    <span class="label label-<?= @$color?> "><?=$indice?> %</span><br>
                                    <label>Cartera Global</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $indice?>%;">
                                            <label class="text-center" for="">$<?= number_format($real,2)?></label>
                                        </div>
                                    </div>
                                    <label>Presupuesto Cartera Global</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $presupuestado?></label>
                                        </div>
                                    </div>
                                    <label>Cumplimiento Cartera Efectiva<span class="label label-<?= @$colorREF?> "><?=number_format($regionCE,2)?>%</span></label><br>

                                     <label>Cartera Efectiva</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-<?= @$colorREF?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:<?= $regionCE?>%;">
                                            <label class="text-center" for="">$<?= number_format($CarteraEfe,2)?></label>
                                        </div>
                                    </div>
                                     <label>Presupuesto Cartera Efectiva</label>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                                <label class="text-center" for="">$<?=number_format($EficP,2)?></label>
                                            </div>
                                        </div>
                                    <?php
                                } else {
                                    ?>
                                    <label>Cumplimiento</label>
                                    <span class="label label-<?= @$color?> "><?=$indice?> %</span>
                                    
                                    <label>Cartera Global</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-<?= @$color?> progress-bar-striped" role="progressbar" aria-valuenow="6" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= number_format($real,2)?></label>
                                        </div>
                                    </div>
                                    <label>Presupuesto Cartera Global</label>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="8" aria-valuemin="0" aria-valuemax="10" style="width:100%;">
                                            <label class="text-center" for="">$<?= $presupuestado?></label>
                                        </div>
                                    </div>
                                    <?php
                                }
                                
                                ?>
                                    </div>
                                </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading"><label>Indice eficiencia </label></div>
                                        <div class="panel-body">
                                            <div class="col-sm-12">
                                            <label>Cumplimiento:</label><span class="badge badge-<?= @$col?>"><?=$indiceEficiencia?> %</span>
                                            </div>
                                            <div class="col-sm-6">
                                            <label>Real:</label><span class="label label-<?= @$col?>"><?=$IEf?> %</span>
                                            </div>
                                            <div class="col-sm-6">
                                            <label>Esperada:</label><span class="label label-default"><?=$Pefic?> %</span>
                                            </div>

                                        </div>
                                    </div>
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


                        
                        <nav class="float-right">
                            <div class="col-sm-10"><a href="<?= base_url();?>index.php/permisos/Agregar/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Presupuesto</a></div>
                            
                        </nav>
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

    google.charts.setOnLoadCallback(drawChart);
    
         window.onload = grafico_pastel;
         window.onload = ffecha;

      $(document).ready(function(){
          
        document.ready = document.getElementById("datepicker").value = 'Seleccione una fecha';
        $("#datepicker").change(function () {
        date= $("#datepicker").val();
         window.location.href = "<?php echo site_url() ?>/Permisos/fecha_index/"+date;

            return false;          
        });
        
       
    });

    function ffecha(){
       // $(document).ready(function(){
      
            fdesde = $("#dDesde").val();
            fHasta = $("#dHasta").val();
            //fdesde = new Date(fdesde);
            //fHasta = new Date(fHasta);
            ///ddias = Math.abs(fHasta-fdesde);
            //ddias = Math.round(ddias/(1000*60*60*24))
            //alert(fdesde);
            //drawCurveTypes(ddias, fdesde);

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/GraficoTotal')?>",
                dataType : "JSON",
                data : { desde:fdesde, hasta:fHasta},
                success: function(data){
                    
                    drawCurveTypes(data);


                },  
                error: function(data){
                    //drawCurveTypes(data);
                    var a =JSON.stringify(data);
                    alert(a);
                }
            });
        //});
    }
    function grafico_pastel(){
       // $(document).ready(function(){
      
            mes = $("#mes_grafico").val();
            

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Permisos/grafico_pastel')?>",
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


    function drawCurveTypes(datos) {

        var data = new google.visualization.DataTable();
        if (datos!=null) {
        data.addColumn('date', 'X');
        if (datos.graficarP[0].fecha<='2021-12-31') {

        data.addColumn('number', 'Presupuesto Cartera Global');

        data.addColumn('number', 'Cartera Global');
        data.addColumn('number', 'Cartera efectiva');
        data.addColumn('number', 'Presupuesto Cartera Efectiva');
        }else if(datos.graficarP[0].fecha>='2022-01-01'){
            data.addColumn('number', 'Presupuesto Cartera Activa');

            data.addColumn('number', 'Cartera Activa');
            data.addColumn('number', 'Presupuesto Cartera en Recuperacion');
            data.addColumn('number', 'Cartera en Recuperacion');
            data.addColumn('number', 'Presupuesto Cartera Efectiva');
            data.addColumn('number', 'Cartera efectiva');

        }

        for (let i = 0; i < datos.graficarP.length; i++) {
            presu = parseFloat(datos.graficarP[i].presu)
            car_efectiva_presupuestada = parseFloat(datos.graficarP[i].car_efectiva_presupuestada)
            cartera_efectiva = parseFloat(datos.graficarP[i].cartera_efectiva)

            presupuesto_cartera_recuperacion =  parseFloat(datos.graficarP[i].carEfec)

            Cart =  parseFloat(datos.graficarP[i].Cart)
            mora =  parseFloat(datos.graficarP[i].mora)
            
              if(presu==null){
                presu=0;
            }
            if(Cart==null){
                Cart=0;
            }

            dddia = new Date(datos.graficarP[i].fecha);
            dddia.setDate(dddia.getDate()+1);
            dddia.setHours(0,0,0);
            data.addRows([
                [dddia, presu, Cart,presupuesto_cartera_recuperacion,null,car_efectiva_presupuestada,cartera_efectiva,]
            ]);  
        }

        
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


    function drawChart(datos) {
        if (datos!=null) {
                    console.log(datos);


        var data = google.visualization.arrayToDataTable([
          ['Language', 'Speakers (in millions)'],
          ['P C.activa',  parseFloat(datos[0].presu)],
          ['P C.recuperación',  parseFloat(datos[0].carEfec)],



        ]);

      var options = {
        legend: {position: 'top', textStyle: {/*color: 'blue',*/ fontSize: 16}}
,
        pieSliceText: 'label',
        title: 'Tendencia de presupuesto',
        titleTextStyle: {/*color: 'blue',*/ fontSize: 18},
        //pieStartAngle: 100,
        slices: {
            0: { color: '#4351FF' },
            1: { color: '#FF8F00' },



          }
      };

        var chart = new google.visualization.PieChart(document.getElementById('curve_chart2'));
        chart.draw(data, options);
    }
    }
</script>

</body>
</html>