
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

/* Que dia es viernes */
//echo $ActualMonth;



//$Se      =date('N',mktime(0, 0, 0, $MesActual  , $i , $anio));
  //  $Sen     =date('d',mktime(0, 0, 0, $MesActual  , $i , $anio));
    $ActualMonth = date("n", strtotime($ActualMonth));
    
$anio=date("Y");
$mes=$ActualMonth;
$viernes = array();
$c=1;
for ($i=1; $i <= 32; $i++) { 
    $Seno      =date('N',mktime(0, 0, 0, $mes  , $i , $anio));
    $Senos     =date('d',mktime(0, 0, 0, $mes  , $i , $anio));
    
    if ($Seno == 5) {
        $viernes[$c]=$Senos;
        $c++;
    }

}
if (count($viernes)==4) {
    for ($i=1; $i <= 5; $i++) { 
        $Seno      =date('N',mktime(0, 0, 0, $mes+1  , $i , $anio));
        $Senos     =date('d',mktime(0, 0, 0, $mes+1  , $i , $anio));
        
        
        if ($Seno == 5) {
            
            array_push($viernes,$Senos);
            //$c++;
        }
    
    }
    
}
//print_r($viernes);
/* Que dia es viernes */
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>

<div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Seguimiento de Clientes - Empresa</h2>
        
    </div>
    <div class="row">
<input type="hidden" name="segmento" id="segmento" class="form-control" placeholder="Product Code" value="<?php echo $this->uri->segment(3);?>">
        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                <div class="col-md-2" style="margin:  0em 0em 12px 0em;">

            <label>Fecha:  </label> 
            <input type="month" id="nap" name="mes">

               
                    </div>
                <div class="row">
                    <?php
                    $usuarioP = null;
                    if (isset($_SESSION['login'])){ $usuarioP = ($_SESSION['login']['prospectos']);}
                    if ($usuarioP!='CM01') {
                        if ( $usuarioP!='JB02') {
                            if ($usuarioP!='MG03') {
                            
                                foreach ($permisos as $coordinador) {
                                    
                                    
                                
                                }

                    ?>
                <div class="panel-group col-sm-12">
                    <div class="panel panel-primary ">
                        <div class="panel-heading">
                            <label style="margin-right: 60%">Colocacion por monto</label>  <label>Mes: <?= $MesActual;?>  </label>
                            <label>
                                <a target="_blank" href="<?php echo site_url(); ?>/seguimiento/Comparacion/Region/<?= $this->uri->segment(3)?>"> 
                                    <button type="button" class="btn btn-info" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </label>
                            <label>
                                <a target="_blank" href="<?php echo site_url(); ?>/Reportes/"> 
                                    <button type="button" class="btn btn-info" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-file" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </label>
                            <label>
                                <a target="_blank" href="<?php echo site_url(); ?>/seguimiento/colocado_detalle/"> 
                                    <button type="button" class="btn btn-info" aria-label="Left Align">
                                        <span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span>
                                    </button>
                                </a>
                            </label>
                        </div>
                        <div class="panel-body table-responsive">
                        
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                            <li><a data-toggle="tab" href="#menu1">Semana 1</a></li>
                            <li><a data-toggle="tab" href="#menu2">Semana 2</a></li>
                            <li><a data-toggle="tab" href="#menu3">Semana 3</a></li>
                            <li><a data-toggle="tab" href="#menu4">Semana 4</a></li>
                            <li><a data-toggle="tab" href="#menu5">Semana 5</a></li>
                            <?php
                            $pos=strpos($_SESSION['login']['cargo'], 'Coordinadora de Operaciones');
                            $pos2=strpos($_SESSION['login']['perfil'], 'Produccion (Gerencia y Region)');    
                            if($pos!==false or $pos2!==false){

                            }else{
                             ?>   

                            <li>
                                <a target="_blank" title="Reporte bonificación" onclick="bonificacion();" > <span aria-hidden="true"><i class="fa fa-dollar"></i></span><span class="sr-only">Bonificaciones</span></a></li>
                            <?php }?>

                            <?php if($rc_completo == 1 || $rc_region == 1){ ?>
                            <li><a target="_blank" title="Reporte RC" onclick="reporteRC();" > <span aria-hidden="true"><i class="glyphicon glyphicon-pushpin"></i></span><span class="sr-only">Reporte RC</span></a></li>.
                            <?php } ?>

                            <?php  
                        $pos=strpos($_SESSION['login']['perfil'], 'admin'); 

                        $pos2=strpos($_SESSION['login']['perfil'], 'Produccion (Gerencia)'); 
                            if($pos!==false or $pos2!==false){
                            
                             ?>
                            <li><a target="_blank" title="Reporte RC por agencias" onclick="ReporteRC_agencias();" > <span aria-hidden="true"><i class="glyphicon glyphicon-list-alt"></i></span><span class="sr-only">Reporte RC</span></a></li>

                     <?php }?>
                        </ul>

                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <h3>Mensual</h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <th scope="col"><?= $MesAnterior;?></th>
                                            <th scope="col">Semana 1</th>
                                            <th scope="col">Semana 2</th>
                                            <th scope="col">Semana 3</th>
                                            <th scope="col">Semana 4</th>
                                            <th scope="col">Semana 5</th>
                                            <th scope="col">Acumulado</th>
                                            <th scope="col">Acumulado a la fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td><?= $totalMesAnt?></td>
                                            <?php 
                                            //print_r($semanas);
                                            for ($i=1; $i <=5 ; $i++) { 
                                                if (isset($semanas[$i])) {
                                                echo "<td>".number_format($semanas[$i],2)."</td>";
                                                }else{
                                                    $semanas[$i]=0.00;
                                            }
                                            }  ?>
                                            
                                            <td><?= number_format($totalMesAct,2)?></td>
                                            <td><?= number_format($totalAcumulado,2)?></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolso</th>
                                            <td><?= number_format($Acolocado,2)?></td>
                                            <td><?= number_format($colocadosem1,2)?></td>
                                            <td><?= number_format($colocadosem2,2)?></td>
                                            <td><?= number_format($colocadosem3,2)?></td>
                                            <td><?= number_format($colocadosem4,2)?></td>
                                            <td><?= number_format($colocadosem5,2)?></td>
                                            <td><?= number_format($acumcolocado=$colocadosem1+$colocadosem2+$colocadosem3+$colocadosem4+$colocadosem5,2)?></td>
                                            <td><?= number_format($colocadoAnual,2)?></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Deudas</th>
                                            <td><?=number_format(@$Acolocado-$totalMesAnt,2)?></td>
                                            <td><?=number_format(@$colocadosem1-$semanas[1],2)?></td>
                                            <td><?=number_format(@$colocadosem2-$semanas[2],2)?></td>
                                            <td><?=number_format(@$colocadosem3-$semanas[3],2)?></td>
                                            <td><?=number_format(@$colocadosem4-$semanas[4],2)?></td>
                                            <td><?=number_format(@$colocadosem5-$semanas[5],2)?></td>
                                            <td><?=number_format(@$acumcolocado-$totalMesAct,2)?></td>
                                            <td><?=number_format(@$colocadoAnual-$totalAcumulado,2)?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <h3>Semana 1  Desde: 01 - Hasta:<?= $viernes[1];?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <?php
                                            for ($i=0; $i <= 6; $i++) { 
                                                if ($i!=1) {
                                                    echo "<th scope='col'>";
                                                    $fecha = $viernes[1]-(6-$i);
                                                    $Sono  =date('d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                    //echo $mes;
                                                    switch ($i) {
                                                        case 0:
                                                        echo "Sabado ".($Sono);
                                                            break;
                                                        case 2:
                                                        echo "Lunes ".($Sono);
                                                            break;
                                                        case 3:
                                                        echo "Martes ".($Sono);
                                                            break;
                                                        case 4:
                                                        echo "Miercoles ".($Sono);
                                                            break;
                                                        case 5:
                                                        echo "Jueves ".($Sono);
                                                            break;
                                                        case 6:
                                                        echo "Viernes ".($Sono);
                                                            break;
                                                        default:
                                                        echo "Dia ".($Sono);
                                                            break;
                                                    }
                                                    $dias_semana1[$i]=$Sono;

                                                    echo "</th>";
                                                }
                                                
                                            }
                                            ?>
                                       
                                           
                                            <th scope="col">Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td> <?php echo (@$Semana1Ppto['Sabado']) != (0) ? number_format($Semana1Ppto['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Ppto['Lunes']) != (0) ? number_format($Semana1Ppto['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Ppto['Martes']) != (0) ?number_format( $Semana1Ppto['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Ppto['Miercoles']) != (0) ? number_format($Semana1Ppto['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Ppto['Jueves']) != (0) ? number_format($Semana1Ppto['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Ppto['Viernes'] != ('0')) ?  number_format($Semana1Ppto['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($ppto = $Semana1Ppto['Sabado']+$Semana1Ppto['Lunes']+$Semana1Ppto['Martes']+$Semana1Ppto['Miercoles']+$Semana1Ppto['Jueves']+$Semana1Ppto['Viernes'],2) ?> </td>
                                        </tr>
                                        <th scope="row">Factibilidad (A Desembolsar)</th>
                                            <td> <?php echo (@$Semana1Fact['Sabado']) != (0) ? number_format($Semana1Fact['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Fact['Lunes']) != (0) ? number_format($Semana1Fact['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Fact['Martes']) != (0) ?number_format( $Semana1Fact['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Fact['Miercoles']) != (0) ? number_format($Semana1Fact['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Fact['Jueves']) != (0) ? number_format($Semana1Fact['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana1Fact['Viernes'] != ('0')) ?  number_format($Semana1Fact['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($presu = $Semana1Fact['Sabado']+$Semana1Fact['Lunes']+$Semana1Fact['Martes']+$Semana1Fact['Miercoles']+$Semana1Fact['Jueves']+$Semana1Fact['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolsado</th>
                                         <td> <?php if (@$Semana1['Sabado'] != 0) {
                                                echo number_format($Semana1['Sabado'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==6) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                           
                                               <td> <?php if (@$Semana1['Lunes'] != 0) {
                                                echo number_format($Semana1['Lunes'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==1) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                              <td> <?php if (@$Semana1['Martes'] != 0) {
                                                echo number_format($Semana1['Martes'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==2) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                           <td> <?php if (@$Semana1['Miercoles'] != 0) {
                                                echo number_format($Semana1['Miercoles'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==3) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                            <td> <?php if (@$Semana1['Jueves'] != 0) {
                                                echo number_format($Semana1['Jueves'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==4) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                                <td> <?php if (@$Semana1['Viernes'] != 0) {
                                                echo number_format($Semana1['Viernes'],2);
                                            }else{
                                                for ($j=0; $j < count($dias_semana1) ; $j++) {

                                                  if ($j!=1) { 
                                                    $dia_semana=date("w", strtotime($anio.'-'.($mes-1).'-'.$dias_semana1[$j]));
                                                        if (isset($Semana11[$dias_semana1[$j]]) and  $dia_semana==5) {
                                                           echo number_format($Semana11[$dias_semana1[$j]],2);
                                                        }
                                                    }
                                                }
                                            }  /* */ ; ?> </td>
                                            
                                            <td> <?= number_format($dese =$Semana1['Sabado']+$Semana1['Lunes']+$Semana1['Martes']+$Semana1['Miercoles']+$Semana1['Jueves']+$Semana1['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                            <td><?=number_format($Semana1['Sabado']-$Semana1Fact['Sabado'],2)?></td>
                                            <td><?=number_format($Semana1['Lunes']-$Semana1['Lunes'],2)?></td>
                                            <td><?=number_format($Semana1['Martes']-$Semana1Fact['Martes'],2)?></td>
                                            <td><?=number_format($Semana1['Miercoles']-$Semana1Fact['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana1['Jueves']-$Semana1Fact['Jueves'],2)?></td>

                                            <td><?=number_format($Semana1['Viernes']-$Semana1Fact['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$presu,2)?></td>
                                        </tr>
                                        <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                            <td><?=number_format($Semana1['Sabado']-$Semana1Ppto['Sabado'],2)?></td>
                                            <td><?=number_format($Semana1['Lunes']-$Semana1Ppto['Lunes'],2)?></td>
                                            <td><?=number_format($Semana1['Martes']-$Semana1Ppto['Martes'],2)?></td>
                                            <td><?=number_format($Semana1['Miercoles']-$Semana1Ppto['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana1['Jueves']-$Semana1Ppto['Jueves'],2)?></td>

                                            <td><?=number_format($Semana1['Viernes']-$Semana1Ppto['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$ppto,2)?></td>
                                        </tr>

                                        <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                            <!-- INICIO color indicador -->
                                                <?php $indicadorColor[0] = "bg-success";?>
                                                <?php
                                                (@$Semana1Ppto['Sabado']) != (0) ? $s[1] = number_format($Semana1['Sabado']/$Semana1Ppto['Sabado']*100,2) : $s[1]=0 ;
                                                (@$Semana1Ppto['Lunes']) != (0) ? $s[2] = number_format($Semana1['Lunes']/$Semana1Ppto['Lunes']*100,2) : $s[2]=0 ;
                                                (@$Semana1Ppto['Martes']) != (0) ? $s[3] = number_format($Semana1['Martes']/$Semana1Ppto['Martes']*100,2) : $s[3]=0 ;
                                                (@$Semana1Ppto['Miercoles']) != (0) ? $s[4] = number_format($Semana1['Miercoles']/$Semana1Ppto['Miercoles']*100,2) : $s[4]=0 ;
                                                (@$Semana1Ppto['Jueves']) != (0) ? $s[5] = number_format($Semana1['Jueves']/$Semana1Ppto['Jueves']*100,2) : $s[5]=0 ;
                                                (@$Semana1Ppto['Viernes']) != (0) ? $s[6] = number_format($Semana1['Viernes']/$Semana1Ppto['Viernes']*100,2) : $s[6]=0 ;
                                                (@$ppto) != (0) ? $s[7] = number_format($dese/$ppto*100,2) : $s[7]=0 ;
                                                $index = 1;
                                                foreach ($s as $key) {
                                                    
                                                    if ($key>95) {
                                                        $indicadorColor[$index] = "bg-success";
                                                    } elseif ($key>87) {
                                                        $indicadorColor[$index] = "bg-warning";
                                                    }elseif ($key>0) {
                                                        $indicadorColor[$index] = "bg-danger";
                                                    }else{
                                                        $indicadorColor[$index] = "";
                                                    }
                                                    
                                                    $index++;
                                                }
                                                ?>
                                            <!-- FIN color indicador-->
                                            <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Semana1Ppto['Sabado']) != (0) ? number_format($Semana1['Sabado']/$Semana1Ppto['Sabado']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Semana1Ppto['Lunes']) != (0) ? number_format($Semana1['Lunes']/$Semana1Ppto['Lunes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Semana1Ppto['Martes']) != (0) ?number_format( $Semana1['Martes']/$Semana1Ppto['Martes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Semana1Ppto['Miercoles']) != (0) ? number_format($Semana1['Miercoles']/$Semana1Ppto['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Semana1Ppto['Jueves']) != (0) ? number_format($Semana1['Jueves']/$Semana1Ppto['Jueves']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Semana1Ppto['Viernes'] != ('0')) ?  number_format($Semana1['Viernes']/$Semana1Ppto['Viernes']*100,2).'%' : '-' ; ?> </td>

                                        
                                            <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <h3>Semana 2  Desde: <?= $viernes[1]+1;?> - Hasta:<?= $viernes[2];?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <?php
                                            for ($i=0; $i <= 6; $i++) { 
                                                if ($i!=1) {
                                                    echo "<th scope='col'>";
                                                    $fecha = $viernes[2]-(6-$i);
                                                    $Sono    =date('d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                    
                                                    
                                                    switch ($i) {
                                                        case 0:
                                                        echo "Sabado ".($Sono);
                                                            break;
                                                        case 2:
                                                        echo "Lunes ".($Sono);
                                                            break;
                                                        case 3:
                                                        echo "Martes ".($Sono);
                                                            break;
                                                        case 4:
                                                        echo "Miercoles ".($Sono);
                                                            break;
                                                        case 5:
                                                        echo "Jueves ".($Sono);
                                                            break;
                                                        case 6:
                                                        echo "Viernes ".($Sono);
                                                            break;
                                                        default:
                                                        echo "Dia ".($Sono);
                                                            break;
                                                    }
                                                    echo "</th>";
                                                }
                                                
                                            }
                                            ?>
                                           <!-- <th scope="col">Sabado 04</th>
                                            <th scope="col">Lunes 06</th>
                                            <th scope="col">Martes 07</th>
                                            <th scope="col">Miercoles 08</th>
                                            <th scope="col">Jueves 09</th>
                                            <th scope="col">Viernes 10</th>
                                        -->
                                            <th scope="col">Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td> <?php echo (@$Semana2Ppto['Sabado']) != (0) ? number_format($Semana2Ppto['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Ppto['Lunes']) != (0) ? number_format($Semana2Ppto['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Ppto['Martes']) != (0) ?number_format( $Semana2Ppto['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Ppto['Miercoles']) != (0) ? number_format($Semana2Ppto['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Ppto['Jueves']) != (0) ? number_format($Semana2Ppto['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Ppto['Viernes'] != ('0')) ?  number_format($Semana2Ppto['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($ppto = $Semana2Ppto['Sabado']+$Semana2Ppto['Lunes']+$Semana2Ppto['Martes']+$Semana2Ppto['Miercoles']+$Semana2Ppto['Jueves']+$Semana2Ppto['Viernes'],2) ?> </td>
                                        </tr>
                                        <th scope="row">Factibilidad (A Desembolsar)</th>
                                            <td> <?php echo (@$Semana2Fact['Sabado']) != (0) ? number_format($Semana2Fact['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Fact['Lunes']) != (0) ? number_format($Semana2Fact['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Fact['Martes']) != (0) ?number_format( $Semana2Fact['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Fact['Miercoles']) != (0) ? number_format($Semana2Fact['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Fact['Jueves']) != (0) ? number_format($Semana2Fact['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana2Fact['Viernes'] != ('0')) ?  number_format($Semana2Fact['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($presu = $Semana2Fact['Sabado']+$Semana2Fact['Lunes']+$Semana2Fact['Martes']+$Semana2Fact['Miercoles']+$Semana2Fact['Jueves']+$Semana2Fact['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolsado</th>
                                            <td> <?php echo ($Semana2['Sabado']) != (0) ? number_format($Semana2['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana2['Lunes']) != (0) ? number_format($Semana2['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana2['Martes']) != (0) ?number_format( $Semana2['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana2['Miercoles']) != (0) ? number_format($Semana2['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana2['Jueves']) != (0) ? number_format($Semana2['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana2['Viernes'] != ('0')) ?  number_format($Semana2['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($dese =$Semana2['Sabado']+$Semana2['Lunes']+$Semana2['Martes']+$Semana2['Miercoles']+$Semana2['Jueves']+$Semana2['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                            <td><?=number_format($Semana2['Sabado']-$Semana2Fact['Sabado'],2)?></td>
                                            <td><?=number_format($Semana2['Lunes']-$Semana2['Lunes'],2)?></td>
                                            <td><?=number_format($Semana2['Martes']-$Semana2Fact['Martes'],2)?></td>
                                            <td><?=number_format($Semana2['Miercoles']-$Semana2Fact['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana2['Jueves']-$Semana2Fact['Jueves'],2)?></td>

                                            <td><?=number_format($Semana2['Viernes']-$Semana2Fact['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$presu,2)?></td>
                                        </tr>
                                        <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                            <td><?=number_format($Semana2['Sabado']-$Semana2Ppto['Sabado'],2)?></td>
                                            <td><?=number_format($Semana2['Lunes']-$Semana2Ppto['Lunes'],2)?></td>
                                            <td><?=number_format($Semana2['Martes']-$Semana2Ppto['Martes'],2)?></td>
                                            <td><?=number_format($Semana2['Miercoles']-$Semana2Ppto['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana2['Jueves']-$Semana2Ppto['Jueves'],2)?></td>

                                            <td><?=number_format($Semana2['Viernes']-$Semana2Ppto['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$ppto,2)?></td>
                                        </tr>

                                        <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                            <!-- INICIO color indicador -->
                                                <?php $indicadorColor[0] = "bg-success";?>
                                                <?php
                                                (@$Semana2Ppto['Sabado']) != (0) ? $s[1] = number_format($Semana2['Sabado']/$Semana2Ppto['Sabado']*100,2) : $s[1]=0 ;
                                                (@$Semana2Ppto['Lunes']) != (0) ? $s[2] = number_format($Semana2['Lunes']/$Semana2Ppto['Lunes']*100,2) : $s[2]=0 ;
                                                (@$Semana2Ppto['Martes']) != (0) ? $s[3] = number_format($Semana2['Martes']/$Semana2Ppto['Martes']*100,2) : $s[3]=0 ;
                                                (@$Semana2Ppto['Miercoles']) != (0) ? $s[4] = number_format($Semana2['Miercoles']/$Semana2Ppto['Miercoles']*100,2) : $s[4]=0 ;
                                                (@$Semana2Ppto['Jueves']) != (0) ? $s[5] = number_format($Semana2['Jueves']/$Semana2Ppto['Jueves']*100,2) : $s[5]=0 ;
                                                (@$Semana2Ppto['Viernes']) != (0) ? $s[6] = number_format($Semana2['Viernes']/$Semana2Ppto['Viernes']*100,2) : $s[6]=0 ;
                                                (@$ppto) != (0) ? $s[7] = number_format($dese/$ppto*100,2) : $s[7]=0 ;
                                                $index = 1;
                                                foreach ($s as $key) {
                                                    
                                                    if ($key>95) {
                                                        $indicadorColor[$index] = "bg-success";
                                                    } elseif ($key>87) {
                                                        $indicadorColor[$index] = "bg-warning";
                                                    }elseif ($key>0) {
                                                        $indicadorColor[$index] = "bg-danger";
                                                    }else{
                                                        $indicadorColor[$index] = "";
                                                    }
                                                    
                                                    $index++;
                                                }
                                                ?>
                                            <!-- FIN color indicador-->
                                            <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Semana2Ppto['Sabado']) != (0) ? number_format($Semana2['Sabado']/$Semana2Ppto['Sabado']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Semana2Ppto['Lunes']) != (0) ? number_format($Semana2['Lunes']/$Semana2Ppto['Lunes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Semana2Ppto['Martes']) != (0) ?number_format( $Semana2['Martes']/$Semana2Ppto['Martes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Semana2Ppto['Miercoles']) != (0) ? number_format($Semana2['Miercoles']/$Semana2Ppto['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Semana2Ppto['Jueves']) != (0) ? number_format($Semana2['Jueves']/$Semana2Ppto['Jueves']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Semana2Ppto['Viernes'] != ('0')) ?  number_format($Semana2['Viernes']/$Semana2Ppto['Viernes']*100,2).'%' : '-' ; ?> </td>

                                        
                                            <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="menu3" class="tab-pane fade">
                                <h3>Semana 3  Desde: <?= $viernes[2]+1;?> - Hasta:<?= $viernes[3];?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <?php
                                            for ($i=0; $i <= 6; $i++) { 
                                                if ($i!=1) {
                                                    echo "<th scope='col'>";
                                                    $fecha = $viernes[3]-(6-$i);
                                                    $Sono    =date('d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                    
                                                    switch ($i) {
                                                        case 0:
                                                        echo "Sabado ".($Sono);
                                                            break;
                                                        case 2:
                                                        echo "Lunes ".($Sono);
                                                            break;
                                                        case 3:
                                                        echo "Martes ".($Sono);
                                                            break;
                                                        case 4:
                                                        echo "Miercoles ".($Sono);
                                                            break;
                                                        case 5:
                                                        echo "Jueves ".($Sono);
                                                            break;
                                                        case 6:
                                                        echo "Viernes ".($Sono);
                                                            break;
                                                        default:
                                                        echo "Dia ".($Sono);
                                                            break;
                                                    }
                                                    echo "</th>";
                                                }
                                                
                                            }
                                            ?>
                                            <th scope="col">Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td> <?php echo ($Semana3Ppto['Sabado']) != (0) ? number_format($Semana3Ppto['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3Ppto['Lunes']) != (0) ? number_format($Semana3Ppto['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3Ppto['Martes']) != (0) ?number_format( $Semana3Ppto['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3Ppto['Miercoles']) != (0) ? number_format($Semana3Ppto['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3Ppto['Jueves']) != (0) ? number_format($Semana3Ppto['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3Ppto['Viernes'] != ('0')) ?  number_format($Semana3Ppto['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($ppto = $Semana3Ppto['Sabado']+$Semana3Ppto['Lunes']+$Semana3Ppto['Martes']+$Semana3Ppto['Miercoles']+$Semana3Ppto['Jueves']+$Semana3Ppto['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Factibilidad (A Desembolsar)</th>
                                            <td> <?php echo (@$Semana3Fact['Sabado']) != (0) ? number_format($Semana3Fact['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana3Fact['Lunes']) != (0) ? number_format($Semana3Fact['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana3Fact['Martes']) != (0) ?number_format( $Semana3Fact['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana3Fact['Miercoles']) != (0) ? number_format($Semana3Fact['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana3Fact['Jueves']) != (0) ? number_format($Semana3Fact['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana3Fact['Viernes'] != ('0')) ?  number_format($Semana3Fact['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($presu = $Semana3Fact['Sabado']+$Semana3Fact['Lunes']+$Semana3Fact['Martes']+$Semana3Fact['Miercoles']+$Semana3Fact['Jueves']+$Semana3Fact['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolso</th>
                                            <td> <?php echo ($Semana3['Sabado']) != (0) ?  number_format($Semana3['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3['Lunes']) != (0) ?  number_format($Semana3['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3['Martes']) != (0) ?  number_format($Semana3['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3['Miercoles']) != (0) ?  number_format($Semana3['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3['Jueves']) != (0) ?  number_format($Semana3['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana3['Viernes'] != ('0')) ?   number_format($Semana3['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?=  number_format($dese = $Semana3['Sabado']+$Semana3['Lunes']+$Semana3['Martes']+$Semana3['Miercoles']+$Semana3['Jueves']+$Semana3['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                            <td><?=number_format($Semana3['Sabado']-$Semana3Fact['Sabado'],2)?></td>
                                            <td><?=number_format($Semana3['Lunes']-$Semana3Fact['Lunes'],2)?></td>
                                            <td><?=number_format($Semana3['Martes']-$Semana3Fact['Martes'],2)?></td>
                                            <td><?=number_format($Semana3['Miercoles']-$Semana3Fact['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana3['Jueves']-$Semana3Fact['Jueves'],2)?></td>

                                            <td><?=number_format($Semana3['Viernes']-$Semana3Fact['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$presu,2)?></td>
                                        </tr>

                                        <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                            <td><?=number_format($Semana3['Sabado']-$Semana3Ppto['Sabado'],2)?></td>
                                            <td><?=number_format($Semana3['Lunes']-$Semana3Ppto['Lunes'],2)?></td>
                                            <td><?=number_format($Semana3['Martes']-$Semana3Ppto['Martes'],2)?></td>
                                            <td><?=number_format($Semana3['Miercoles']-$Semana3Ppto['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana3['Jueves']-$Semana3Ppto['Jueves'],2)?></td>

                                            <td><?=number_format($Semana3['Viernes']-$Semana3Ppto['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$ppto,2)?></td>
                                        </tr>

                                        <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                            <!-- INICIO color indicador -->
                                                <?php $indicadorColor[0] = "bg-success";?>
                                                <?php
                                                (@$Semana3Ppto['Sabado']) != (0) ? $s[1] = number_format($Semana3['Sabado']/$Semana3Ppto['Sabado']*100,2) : $s[1]=0 ;
                                                (@$Semana3Ppto['Lunes']) != (0) ? $s[2] = number_format($Semana3['Lunes']/$Semana3Ppto['Lunes']*100,2) : $s[2]=0 ;
                                                (@$Semana3Ppto['Martes']) != (0) ? $s[3] = number_format($Semana3['Martes']/$Semana3Ppto['Martes']*100,2) : $s[3]=0 ;
                                                (@$Semana3Ppto['Miercoles']) != (0) ? $s[4] = number_format($Semana3['Miercoles']/$Semana3Ppto['Miercoles']*100,2) : $s[4]=0 ;
                                                (@$Semana3Ppto['Jueves']) != (0) ? $s[5] = number_format($Semana3['Jueves']/$Semana3Ppto['Jueves']*100,2) : $s[5]=0 ;
                                                (@$Semana3Ppto['Viernes']) != (0) ? $s[6] = number_format($Semana3['Viernes']/$Semana3Ppto['Viernes']*100,2) : $s[6]=0 ;
                                                (@$ppto) != (0) ? $s[7] = number_format($dese/$ppto*100,2) : $s[7]=0 ;
                                                $index = 1;
                                                foreach ($s as $key) {
                                                    
                                                    if ($key>95) {
                                                        $indicadorColor[$index] = "bg-success";
                                                    } elseif ($key>87) {
                                                        $indicadorColor[$index] = "bg-warning";
                                                    }elseif ($key>0) {
                                                        $indicadorColor[$index] = "bg-danger";
                                                    }else{
                                                        $indicadorColor[$index] = "";
                                                    }
                                                    
                                                    $index++;
                                                }
                                                ?>
                                            <!-- FIN color indicador-->
                                            <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Semana3Ppto['Sabado']) != (0) ? number_format($Semana3['Sabado']/$Semana3Ppto['Sabado']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Semana3Ppto['Lunes']) != (0) ? number_format($Semana3['Lunes']/$Semana3Ppto['Lunes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Semana3Ppto['Martes']) != (0) ?number_format( $Semana3['Martes']/$Semana3Ppto['Martes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Semana3Ppto['Miercoles']) != (0) ? number_format($Semana3['Miercoles']/$Semana3Ppto['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Semana3Ppto['Jueves']) != (0) ? number_format($Semana3['Jueves']/$Semana3Ppto['Jueves']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Semana3Ppto['Viernes'] != ('0')) ?  number_format($Semana3['Viernes']/$Semana3Ppto['Viernes']*100,2).'%' : '-' ; ?> </td>

                                        
                                            <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="menu4" class="tab-pane fade">
                                <h3>Semana 4  <?= $viernes[3]+1;?> - Hasta:<?= $viernes[4];?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <?php
                                            for ($i=0; $i <= 6; $i++) { 
                                                if ($i!=1) {
                                                    echo "<th scope='col'>";
                                                    $fecha = $viernes[4]-(6-$i);
                                                    $Sono    =date('d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                    
                                                    switch ($i) {
                                                        case 0:
                                                        echo "Sabado ".($Sono);
                                                            break;
                                                        case 2:
                                                        echo "Lunes ".($Sono);
                                                            break;
                                                        case 3:
                                                        echo "Martes ".($Sono);
                                                            break;
                                                        case 4:
                                                        echo "Miercoles ".($Sono);
                                                            break;
                                                        case 5:
                                                        echo "Jueves ".($Sono);
                                                            break;
                                                        case 6:
                                                        echo "Viernes ".($Sono);
                                                            break;
                                                        default:
                                                        echo "Dia ".($Sono);
                                                            break;
                                                    }
                                                    echo "</th>";
                                                }
                                                
                                            }
                                            ?>
                                            <th scope="col">Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td> <?php echo ($Semana4Ppto['Sabado']) != (0) ? number_format($Semana4Ppto['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4Ppto['Lunes']) != (0) ? number_format($Semana4Ppto['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4Ppto['Martes']) != (0) ?number_format( $Semana4Ppto['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4Ppto['Miercoles']) != (0) ? number_format($Semana4Ppto['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4Ppto['Jueves']) != (0) ? number_format($Semana4Ppto['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4Ppto['Viernes'] != ('0')) ?  number_format($Semana4Ppto['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($ppto =$Semana4Ppto['Sabado']+$Semana4Ppto['Lunes']+$Semana4Ppto['Martes']+$Semana4Ppto['Miercoles']+$Semana4Ppto['Jueves']+$Semana4Ppto['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Factibilidad (A Desembolsar)</th>
                                            <td> <?php echo (@$Semana4Fact['Sabado']) != (0) ? number_format($Semana4Fact['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana4Fact['Lunes']) != (0) ? number_format($Semana4Fact['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana4Fact['Martes']) != (0) ?number_format( $Semana4Fact['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana4Fact['Miercoles']) != (0) ? number_format($Semana4Fact['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana4Fact['Jueves']) != (0) ? number_format($Semana4Fact['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana4Fact['Viernes'] != ('0')) ?  number_format($Semana4Fact['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($presu = $Semana4Fact['Sabado']+$Semana4Fact['Lunes']+$Semana4Fact['Martes']+$Semana4Fact['Miercoles']+$Semana4Fact['Jueves']+$Semana4Fact['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolso</th>
                                            <td> <?php echo ($Semana4['Sabado']) != (0) ?  number_format($Semana4['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4['Lunes']) != (0) ?  number_format($Semana4['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4['Martes']) != (0) ?  number_format($Semana4['Martes'] ,2): '-' ; ?> </td>
                                            <td> <?php echo ($Semana4['Miercoles']) != (0) ?  number_format($Semana4['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4['Jueves']) != (0) ?  number_format($Semana4['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana4['Viernes'] != ('0')) ?   number_format($Semana4['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?=  number_format($dese = $Semana4['Sabado']+$Semana4['Lunes']+$Semana4['Martes']+$Semana4['Miercoles']+$Semana4['Jueves']+$Semana4['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                            <td><?=number_format($Semana4['Sabado']-$Semana4Fact['Sabado'],2)?></td>
                                            <td><?=number_format($Semana4['Lunes']-$Semana4Fact['Lunes'],2)?></td>
                                            <td><?=number_format($Semana4['Martes']-$Semana4Fact['Martes'],2)?></td>
                                            <td><?=number_format($Semana4['Miercoles']-$Semana4Fact['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana4['Jueves']-$Semana4Fact['Jueves'],2)?></td>

                                            <td><?=number_format($Semana4['Viernes']-$Semana4Fact['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$presu,2)?></td>
                                        </tr>

                                        <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                            <td><?=number_format($Semana4['Sabado']-$Semana4Ppto['Sabado'],2)?></td>
                                            <td><?=number_format($Semana4['Lunes']-$Semana4Ppto['Lunes'],2)?></td>
                                            <td><?=number_format($Semana4['Martes']-$Semana4Ppto['Martes'],2)?></td>
                                            <td><?=number_format($Semana4['Miercoles']-$Semana4Ppto['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana4['Jueves']-$Semana4Ppto['Jueves'],2)?></td>

                                            <td><?=number_format($Semana4['Viernes']-$Semana4Ppto['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$ppto,2)?></td>
                                        </tr>

                                        <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                            <!-- INICIO color indicador -->
                                                <?php $indicadorColor[0] = "bg-success";?>
                                                <?php
                                                (@$Semana4Ppto['Sabado']) != (0) ? $s[1] = number_format($Semana4['Sabado']/$Semana4Ppto['Sabado']*100,2) : $s[1]=0 ;
                                                (@$Semana4Ppto['Lunes']) != (0) ? $s[2] = number_format($Semana4['Lunes']/$Semana4Ppto['Lunes']*100,2) : $s[2]=0 ;
                                                (@$Semana4Ppto['Martes']) != (0) ? $s[3] = number_format($Semana4['Martes']/$Semana4Ppto['Martes']*100,2) : $s[3]=0 ;
                                                (@$Semana4Ppto['Miercoles']) != (0) ? $s[4] = number_format($Semana4['Miercoles']/$Semana4Ppto['Miercoles']*100,2) : $s[4]=0 ;
                                                (@$Semana4Ppto['Jueves']) != (0) ? $s[5] = number_format($Semana4['Jueves']/$Semana4Ppto['Jueves']*100,2) : $s[5]=0 ;
                                                (@$Semana4Ppto['Viernes']) != (0) ? $s[6] = number_format($Semana4['Viernes']/$Semana4Ppto['Viernes']*100,2) : $s[6]=0 ;
                                                (@$ppto) != (0) ? $s[7] = number_format($dese/$ppto*100,2) : $s[7]=0 ;
                                                $index = 1;
                                                foreach ($s as $key) {
                                                    
                                                    if ($key>95) {
                                                        $indicadorColor[$index] = "bg-success";
                                                    } elseif ($key>87) {
                                                        $indicadorColor[$index] = "bg-warning";
                                                    }elseif ($key>0) {
                                                        $indicadorColor[$index] = "bg-danger";
                                                    }else{
                                                        $indicadorColor[$index] = "";
                                                    }
                                                    
                                                    $index++;
                                                }
                                                ?>
                                            <!-- FIN color indicador-->
                                            <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Semana4Ppto['Sabado']) != (0) ? number_format($Semana4['Sabado']/$Semana4Ppto['Sabado']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Semana4Ppto['Lunes']) != (0) ? number_format($Semana4['Lunes']/$Semana4Ppto['Lunes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Semana4Ppto['Martes']) != (0) ?number_format( $Semana4['Martes']/$Semana4Ppto['Martes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Semana4Ppto['Miercoles']) != (0) ? number_format($Semana4['Miercoles']/$Semana4Ppto['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Semana4Ppto['Jueves']) != (0) ? number_format($Semana4['Jueves']/$Semana4Ppto['Jueves']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Semana4Ppto['Viernes'] != ('0')) ?  number_format($Semana4['Viernes']/$Semana4Ppto['Viernes']*100,2).'%' : '-' ; ?> </td>

                                        
                                            <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div id="menu5" class="tab-pane fade">
                                <h3>Semana 5  <?= $viernes[4]+1;?> - Hasta:<?= $d=cal_days_in_month(CAL_GREGORIAN,$mes,$anio); ?></h3>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Colocacion Nueva</th>
                                            <?php
                                            
                                            
                                            for ($i=0; $i <= 6; $i++) { 
                                                if ($i!=1) {
                                                    echo "<th scope='col'>";
                                                    //if($d==31){
                                                      //  $fecha = $viernes[5]-(5-$i);
                                                    //}else{
                                                        
                                                    //}
                                                    
                                                   
                                                    $fecha = $viernes[5]-(6-$i);
                                                    //echo $fecha." ";
                                                    if ($fecha==30 or $fecha==31) {
                                                        $Sono    =date('d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                        //echo date('Y-m-d',mktime(0, 0, 0, $mes  , $fecha , $anio));
                                                    }else{
                                                        $Sono    =date('d',mktime(0, 0, 0, $mes+1  , $fecha , $anio));    
                                                        //echo date('Y-m-d',mktime(0, 0, 0, $mes+1  , $fecha , $anio));
                                                    }
                                                    
                                                    
                                                    //echo $fecha;
                                                    
                                                    switch ($i) {
                                                        case 0:
                                                        echo "Sabado ".($Sono);
                                                            break;
                                                        case 2:

                                                        echo "Lunes ".($Sono);
                                                            break;
                                                        case 3:
                                                        echo "Martes ".($Sono);
                                                            break;
                                                        case 4:
                                                        echo "Miercoles ".($Sono);
                                                            break;
                                                        case 5:
                                                        echo "Jueves ".($Sono);
                                                            break;
                                                        case 6:
                                                        echo "Viernes ".($Sono);
                                                            break;
                                                        default:
                                                        echo "Dia ".($Sono);
                                                            break;
                                                    }
                                                    echo "</th>";
                                                }
                                                
                                            }
                                            ?>
                                            <th scope="col">Acumulado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <th scope="row">Ppto. Colocacion</th>
                                            <td> <?php echo ($Semana5Ppto['Sabado']) != (0) ? number_format($Semana5Ppto['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5Ppto['Lunes']) != (0) ? number_format($Semana5Ppto['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5Ppto['Martes']) != (0) ?number_format( $Semana5Ppto['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5Ppto['Miercoles']) != (0) ? number_format($Semana5Ppto['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5Ppto['Jueves']) != (0) ? number_format($Semana5Ppto['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5Ppto['Viernes'] != ('0')) ?  number_format($Semana5Ppto['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($ppto =$Semana5Ppto['Sabado']+$Semana5Ppto['Lunes']+$Semana5Ppto['Martes']+$Semana5Ppto['Miercoles']+$Semana5Ppto['Jueves']+$Semana5Ppto['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Factibilidad (A Desembolsar)</th>
                                            <td> <?php echo (@$Semana5Fact['Sabado']) != (0) ? number_format($Semana5Fact['Sabado'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana5Fact['Lunes']) != (0) ? number_format($Semana5Fact['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana5Fact['Martes']) != (0) ?number_format( $Semana5Fact['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana5Fact['Miercoles']) != (0) ? number_format($Semana5Fact['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana5Fact['Jueves']) != (0) ? number_format($Semana5Fact['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo (@$Semana5Fact['Viernes'] != ('0')) ?  number_format($Semana5Fact['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?= number_format($presu = $Semana5Fact['Sabado']+$Semana5Fact['Lunes']+$Semana5Fact['Martes']+$Semana5Fact['Miercoles']+$Semana5Fact['Jueves']+$Semana5Fact['Viernes'],2) ?> </td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Desembolso</th>
                                            <td> <?php echo ($Semana5['Sabado']) != (0) ?  number_format($Semana5['Sabado'] ,2): '-' ; ?> </td>
                                            <td> <?php echo ($Semana5['Lunes']) != (0) ?  number_format($Semana5['Lunes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5['Martes']) != (0) ?  number_format($Semana5['Martes'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5['Miercoles']) != (0) ?  number_format($Semana5['Miercoles'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5['Jueves']) != (0) ?  number_format($Semana5['Jueves'],2) : '-' ; ?> </td>
                                            <td> <?php echo ($Semana5['Viernes'] != ('0')) ?   number_format($Semana5['Viernes'],2) : '-' ; ?> </td>
                                            <td> <?=  number_format($dese = $Semana5['Sabado']+$Semana5['Lunes']+$Semana5['Martes']+$Semana5['Miercoles']+$Semana5['Jueves']+$Semana5['Viernes'],2) ?> </td>
                                        </tr>
                                          <tr>
                                        <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                            <td><?=number_format($Semana5['Sabado']-$Semana5Fact['Sabado'],2)?></td>
                                            <td><?=number_format($Semana5['Lunes']-$Semana5Fact['Lunes'],2)?></td>
                                            <td><?=number_format($Semana5['Martes']-$Semana5Fact['Martes'],2)?></td>
                                            <td><?=number_format($Semana5['Miercoles']-$Semana5Fact['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana5['Jueves']-$Semana5Fact['Jueves'],2)?></td>

                                            <td><?=number_format($Semana5['Viernes']-$Semana5Fact['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$presu,2)?></td>
                                        </tr>

                                        <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                            <td><?=number_format($Semana5['Sabado']-$Semana5Ppto['Sabado'],2)?></td>
                                            <td><?=number_format($Semana5['Lunes']-$Semana5Ppto['Lunes'],2)?></td>
                                            <td><?=number_format($Semana5['Martes']-$Semana5Ppto['Martes'],2)?></td>
                                            <td><?=number_format($Semana5['Miercoles']-$Semana5Ppto['Miercoles'],2)?></td>
                                            <td><?=number_format($Semana5['Jueves']-$Semana5Ppto['Jueves'],2)?></td>

                                            <td><?=number_format($Semana5['Viernes']-$Semana5Ppto['Viernes'],2)?></td>
                                            <td><?=number_format($dese-$ppto,2)?></td>
                                        </tr>

                                        <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                            <!-- INICIO color indicador -->
                                                <?php $indicadorColor[0] = "bg-success";?>
                                                <?php
                                                (@$Semana5Ppto['Sabado']) != (0) ? $s[1] = number_format($Semana5['Sabado']/$Semana5Ppto['Sabado']*100,2) : $s[1]=0 ;
                                                (@$Semana5Ppto['Lunes']) != (0) ? $s[2] = number_format($Semana5['Lunes']/$Semana5Ppto['Lunes']*100,2) : $s[2]=0 ;
                                                (@$Semana5Ppto['Martes']) != (0) ? $s[3] = number_format($Semana5['Martes']/$Semana5Ppto['Martes']*100,2) : $s[3]=0 ;
                                                (@$Semana5Ppto['Miercoles']) != (0) ? $s[4] = number_format($Semana5['Miercoles']/$Semana5Ppto['Miercoles']*100,2) : $s[4]=0 ;
                                                (@$Semana5Ppto['Jueves']) != (0) ? $s[5] = number_format($Semana5['Jueves']/$Semana5Ppto['Jueves']*100,2) : $s[5]=0 ;
                                                (@$Semana5Ppto['Viernes']) != (0) ? $s[6] = number_format($Semana5['Viernes']/$Semana5Ppto['Viernes']*100,2) : $s[6]=0 ;
                                                (@$ppto) != (0) ? $s[7] = number_format($dese/$ppto*100,2) : $s[7]=0 ;
                                                $index = 1;
                                                foreach ($s as $key) {
                                                    
                                                    if ($key>95) {
                                                        $indicadorColor[$index] = "bg-success";
                                                    } elseif ($key>87) {
                                                        $indicadorColor[$index] = "bg-warning";
                                                    }elseif ($key>0) {
                                                        $indicadorColor[$index] = "bg-danger";
                                                    }else{
                                                        $indicadorColor[$index] = "";
                                                    }
                                                    
                                                    $index++;
                                                }
                                                ?>
                                            <!-- FIN color indicador-->
                                            <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Semana5Ppto['Sabado']) != (0) ? number_format($Semana5['Sabado']/$Semana5Ppto['Sabado']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Semana5Ppto['Lunes']) != (0) ? number_format($Semana5['Lunes']/$Semana5Ppto['Lunes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Semana5Ppto['Martes']) != (0) ?number_format( $Semana5['Martes']/$Semana5Ppto['Martes']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Semana5Ppto['Miercoles']) != (0) ? number_format($Semana5['Miercoles']/$Semana5Ppto['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Semana5Ppto['Jueves']) != (0) ? number_format($Semana5['Jueves']/$Semana5Ppto['Jueves']*100,2).'%' : '-' ; ?> </td>
                                            <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Semana5Ppto['Viernes'] != ('0')) ?  number_format($Semana5['Viernes']/$Semana5Ppto['Viernes']*100,2).'%' : '-' ; ?> </td>

                                        
                                            <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        
                            
                        </div>
                        <div class="panel-footer">                            
                        </div> 
                    </div>
                </div>
                    
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-primary ">
                            <div class="panel-heading"><label style="margin-right: 70%">Cantidad Prospectos</label>  <label>Mes: <?= $MesActual;?> </label></div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col">Prospectos</th>
                                        <th scope="col"><?= $MesAnterior;?></th>
                                        <th scope="col">Semana 1</th>
                                        <th scope="col">Semana 2</th>
                                        <th scope="col">Semana 3</th>
                                        <th scope="col">Semana 4</th>
                                        <th scope="col">Semana 5</th>
                                        <th scope="col">Acumulado</th>
                                        <th scope="col">Acumulado a la fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Por Gestionar</th>
                                            <td><?= count($ProspectosAnterior) ?></td>
                                            <td><?=$ConteoSe11?></td>
                                            <td><?=$ConteoSe12?></td>
                                            <td><?=$ConteoSe13?></td>
                                            <td><?=$ConteoSe14?></td>
                                            <td><?=$ConteoSe15?></td>
                                            <td><?=$ConteoSe11+$ConteoSe12+$ConteoSe13+$ConteoSe14?></td>
                                            <td><?=$Año1?></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Gestionados</th>
                                            <td><?= count($ProspectadoAnterior) ?></td>
                                            <td><?=$ConteoSe21?></td>
                                            <td><?=$ConteoSe22?></td>
                                            <td><?=$ConteoSe23?></td>
                                            <td><?=$ConteoSe24?></td>
                                            <td><?=$ConteoSe25?></td>
                                            <td><?=$ConteoSe21+$ConteoSe22+$ConteoSe23+$ConteoSe24+$ConteoSe25?></td>
                                            <td><?=$Año2?></td>
                                        </tr>
                                        <tr>
                                        <th scope="row">Clientes</th>
                                            <td><?= count($ClienteAnterior) ?></td>
                                            <td><?=$ConteoSe31?></td>
                                            <td><?=$ConteoSe32?></td>
                                            <td><?=$ConteoSe33?></td>
                                            <td><?=$ConteoSe34?></td>
                                            <td><?=$ConteoSe35?></td>
                                            <td><?=$ConteoSe31+$ConteoSe32+$ConteoSe33+$ConteoSe34?></td>
                                            <td><?=$Año3?></td>
                                        </tr>
                                        <th scope="row">Clientes/Pros. Gestionados</th>
                                            <td><?= @number_format(count($ClienteAnterior)/count($ProspectadoAnterior)*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe31/max($ConteoSe21,1))*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe32/max($ConteoSe22,1))*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe33/max($ConteoSe23,1))*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe34/max($ConteoSe24,1))*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe35/max($ConteoSe25,1))*100,2) ?>%</td>
                                            <td><?= number_format(($ConteoSe31+$ConteoSe32+$ConteoSe33+$ConteoSe34)/(max($ConteoSe21+$ConteoSe22+$ConteoSe23+$ConteoSe24+$ConteoSe25,1))*100,2)?>%</td>
                                            <td><?=@number_format(($ConteoSe31+$ConteoSe32+$ConteoSe33+$ConteoSe34+count($ClienteAnterior))/($ConteoSe21+$ConteoSe22+$ConteoSe23+$ConteoSe24+count($ProspectadoAnterior))*100,2)?>%</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer">                            
                            </div> 
                        </div>
                    </div>
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-primary ">
                            <div class="panel-heading"><label style="margin-right: 70%">Perdida de clientes</label>  <label>Mes: <?= $MesActual;?> </label></div>
                            <div class="panel-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                        <th scope="col"></th>
                                        <th scope="col"><?= $MesAnterior;?></th>
                                        <th scope="col">Semana 1</th>
                                        <th scope="col">Semana 2</th>
                                        <th scope="col">Semana 3</th>
                                        <th scope="col">Semana 4</th>
                                        <th scope="col">Semana 5</th>
                                        <th scope="col">Acumulado</th>
                                        <th scope="col">Acumulado a la fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Presupuestado</th>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Perdida</th>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Inactivos</th>
                                            <td><?= $perdidosAnterior[0]->inactivos;?></td>
                                            <td><?=$ConteoPe11?></td>
                                            <td><?=$ConteoPe12?></td>
                                            <td><?=$ConteoPe13?></td>
                                            <td><?=$ConteoPe14?></td>
                                            <td><?=$ConteoPe15?></td>
                                            <td><?=$ConteoPe11+$ConteoPe12+$ConteoPe13+$ConteoPe14+$ConteoPe15?></td>
                                            <td><?= $perdidosActual[0]->inactivos;?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Activos</th>
                                            <td><?= $perdidosAnterior[0]->activo;?></td>
                                            <td><?=$ConteoPe21?></td>
                                            <td><?=$ConteoPe22?></td>
                                            <td><?=$ConteoPe23?></td>
                                            <td><?=$ConteoPe24?></td>
                                            <td><?=$ConteoPe25?></td>
                                            <td><?=$ConteoPe21+$ConteoPe22+$ConteoPe23+$ConteoPe24+$ConteoPe25?></td>
                                            <td><?= $perdidosActual[0]->activo;?></td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Indice</th>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                            <div class="panel-footer">                            
                            </div> 
                        </div>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>
                     <div class="panel-group col-sm-12">
                     
                    <?php 
                    $region = 0 ;
                    
                    foreach ($permisos as $coordinador) {
                        //echo $coordinador->nombre;
                        if ($usuarioP=='CM01' or $usuarioP=='JB02' or $usuarioP=='MG03') {
                            
                            if ($usuarioP!=$coordinador->id_usuarios){
                                continue;
                            }
                        }
                        //echo "<pre>";
                        //print_r($);
                        //echo"<br>";
                        //print_r(count($ProspectosAnterior));
                        //echo "</pre>";
                        switch ($coordinador->id_usuarios) {

                            case 'CM01':
                              
                                $region=2;
                               
                                break;
                            case 'JB02':
                                
                                $region=1;
                               
                                break;
                            case 'MG03':
                               
                                $region=3;
                                
                                
                                break;                            
                            default:
                                # code...
                                break;
                        }     
                       

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
                            <label style="margin-right: 125px">Region:<?= $region?></label>
                            <a href="<?php echo site_url(); ?>/seguimiento/Region/<?=$coordinador->id_usuarios?>/0/0<?=$region?>" class="close" > <span aria-hidden="true"><i class="fa fa-cog"></i></span><span class="sr-only">Ver Mas</span></a>
                                
                                
                            </div>
                                <div class="panel-body">
                                <h5 class="alert alert-info text-center">
                                        <strong class="text-center">Agencias ingresadas</strong>
                                       
                                        <span class="badge"><?=@$contaCarteras[$coordinador->id_usuarios]?></span>/<span class="badge"><?= @$totalAgn[$coordinador->id_usuarios] ?></span>
                                </h5>
                                <a href="<?php echo site_url(); ?>/seguimiento/Region/<?=$coordinador->id_usuarios?>/0/0<?=$region?>/Comparar" target="iframe_a">Comparar</a>
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

</body>
</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    var f = new Date();
    var valor=(f.getMonth() +1);
    var anio = f.getFullYear();
       function load() {
              $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Seguimiento/index')?>",
                dataType : "JSON",
                data : {  valor:valor},
                success: function(data){
                 console.log(data);
                 //alert(data[1][1]);
                

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
      }
    $(document).ready(function(){
       /* if (valor<=9) {
            document.ready = document.getElementById("nap").value = anio+'-0'+valor;
        } else {
            document.ready = document.getElementById("nap").value = anio+'-'+valor;
        }*/

    });
       function bonificacion(){
             valor= $("#segmento").val();
            window.location.href = "<?php echo site_url(); ?>/seguimiento/Bonificacion/"+valor;
        }
        function reporteRC(){
             valor= $("#segmento").val();
            window.location.href = "<?php echo site_url(); ?>/seguimiento/ReporteRC/"+valor;
        }
        function ReporteRC_agencias(){
             valor= $("#segmento").val();
            window.location.href = "<?php echo site_url(); ?>/seguimiento/ReporteRC_agencias/"+valor;
        }
    $("#nap").change(function () {
        valor= $("#nap").val();
        
         window.location.href = "<?php echo site_url() ?>/Seguimiento/index/"+valor;
         document.getElementById("nap").value =valor;
            return false;          
        //load();

    });
</script>