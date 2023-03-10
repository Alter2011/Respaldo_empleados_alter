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
if($_SESSION['login']['cargo']!='Jefe de Produccion'){

}

/* Que dia es viernes */
//echo $ActualMonth;



//$Se      =date('N',mktime(0, 0, 0, $MesActual  , $i , $anio));
  //  $Sen     =date('d',mktime(0, 0, 0, $MesActual  , $i , $anio));
    $ActualMonth = date("n", strtotime($General['ActualMonth']));
    
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

<div class="col-sm-12 col-xs-12 print-col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Comparacion de Carteras - <?=$General['AgenciaActual'];?></h2>
        
    </div>
    <div class="row">

        <div class="col-sm-12 col-xs-12 print-col-md-10">
            <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                <nav class="float-right"></nav>
                
                <div class="row">
                <!-- Inicia Empresa-->
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-primary ">
                            <div class="panel-heading">
                                <label style="margin-right: 70%"><?=$General['AgenciaActual'];?></label>  <label>Mes: <?= $General['MesActual'];?>  </label>
                                
                            </div>
                            <div class="panel-body table-responsive">
                            
                                <?php //print_r($General);?>
                                <?php //echo "asd".$General['semanas'][1];?>
                            
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home">Home</a></li>
                                <li><a data-toggle="tab" href="#menu1">Semana 1</a></li>
                                <li><a data-toggle="tab" href="#menu2">Semana 2</a></li>
                                <li><a data-toggle="tab" href="#menu3">Semana 3</a></li>
                                <li><a data-toggle="tab" href="#menu4">Semana 4</a></li>
                                <li><a data-toggle="tab" href="#menu5">Semana 5</a></li>
                             
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active">
                                    <h3>Mensual</h3>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Colocacion Nueva</th>
                                                <th scope="col"><?= $General['MesAnterior'];?></th>
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
                                                <td><?= number_format($General['totalMesAnt'],2)?></td>

                                                <?php 
                                                //print_r($General);
                                                for ($i=1; $i <=5 ; $i++) { 
                                                    
                                                    if (isset($General['semanas'][$i])) {
                                                        
                                                    echo "<td>".number_format($General['semanas'][$i],2)."</td>";
                                                    }else{
                                                        
                                                        $General['semanas'][$i]=0.00;
                                                        echo "<td>".number_format($General['semanas'][$i],2)."</td>";
                                                }
                                                }  ?>
                                                
                                                <!--<td><?php if (isset($semanas[1])) {
                                                    //echo $semanas[1];
                                                }else{
                                                    echo "0.00";
                                                } ?></td>
                                                <td><?php if (isset($semanas[2])) {
                                                    //echo $semanas[2];
                                                }else{
                                                    echo "0";
                                                } ?></td>
                                                <td><?php if (isset($semanas[3])) {
                                                // echo $semanas[3];
                                                }else{
                                                    echo "0";
                                                } ?></td>
                                                <td><?php if (isset($semanas[4])) {
                                                // echo $semanas[4];
                                                }else{
                                                    echo "0";
                                                } ?></td>
                                                <td><?php if (isset($semanas[5])) {
                                                    //echo $semanas[5];
                                                }else{
                                                    echo "0";
                                                } ?></td>-->
                                                <td><?= number_format($General['totalMesAct'],2)?></td>
                                                <td><?= number_format($General['totalAcumulado'],2)?></td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                            
                                                <td><?= number_format($General['Acolocado'],2)?></td>
                                                <td><?= number_format($General['colocadosem1'],2)?></td>
                                                <td><?= number_format($General['colocadosem2'],2)?></td>
                                                <td><?= number_format($General['colocadosem3'],2)?></td>
                                                <td><?= number_format($General['colocadosem4'],2)?></td>
                                                <td><?= number_format($General['colocadosem5'],2)?></td>
                                                <td><?= number_format($General['acumcolocado']=$General['colocadosem1']+$General['colocadosem2']+$General['colocadosem3']+$General['colocadosem4']+$General['colocadosem5'],2)?></td>
                                                <td><?= number_format($General['totalcolocado']=$General['acumcolocado']+$General['Acolocado'],2)?></td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Deudas</th>
                                            <td><?=number_format(@$General['Acolocado']-$General['totalMesAnt'],2)?></td>
                                                <td><?=number_format(@$General['colocadosem1']-$General['semanas'][1],2)?></td>
                                                <td><?=number_format(@$General['colocadosem2']-$General['semanas'][2],2)?></td>
                                                <td><?=number_format(@$General['colocadosem3']-$General['semanas'][3],2)?></td>
                                                <td><?=number_format(@$General['colocadosem4']-$General['semanas'][4],2)?></td>
                                                <td><?=number_format(@$General['colocadosem5']-$General['semanas'][5],2)?></td>
                                                <td><?=number_format(@$General['acumcolocado']-$General['totalMesAct'],2)?></td>
                                                <td><?=number_format(@$General['totalcolocado']-$General['totalAcumulado'],2)?></td>
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
                                                <td> <?php echo (@$General['Semana1Ppto']['Sabado']) != (0) ? number_format($General['Semana1Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Ppto']['Lunes']) != (0) ? number_format($General['Semana1Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Ppto']['Martes']) != (0) ?number_format( $General['Semana1Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Ppto']['Miercoles']) != (0) ? number_format($General['Semana1Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Ppto']['Jueves']) != (0) ? number_format($General['Semana1Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Ppto']['Viernes'] != (0)) ?  number_format($General['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana1Ppto']['Sabado']+$General['Semana1Ppto']['Lunes']+$General['Semana1Ppto']['Martes']+$General['Semana1Ppto']['Miercoles']+$General['Semana1Ppto']['Jueves']+$General['Semana1Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana1Fact']['Sabado']) != (0) ? number_format($General['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Lunes']) != (0) ? number_format($General['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Martes']) != (0) ?number_format( $General['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Miercoles']) != (0) ? number_format($General['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Jueves']) != (0) ? number_format($General['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Viernes'] != (0)) ?  number_format($General['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana1Fact']['Sabado']+$General['Semana1Fact']['Lunes']+$General['Semana1Fact']['Martes']+$General['Semana1Fact']['Miercoles']+$General['Semana1Fact']['Jueves']+$General['Semana1Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($General['Semana1']['Sabado']) != (0) ? number_format($General['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Lunes']) != (0) ? number_format($General['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Martes']) != (0) ?number_format( $General['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Miercoles']) != (0) ? number_format($General['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Jueves']) != (0) ? number_format($General['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Viernes'] != (0)) ?  number_format($General['Semana1']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($dese =$General['Semana1']['Sabado']+$General['Semana1']['Lunes']+$General['Semana1']['Martes']+$General['Semana1']['Miercoles']+$General['Semana1']['Jueves']+$General['Semana1']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($General['Semana1']['Sabado']-$General['Semana1Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Lunes']-$General['Semana1']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Martes']-$General['Semana1Fact']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Miercoles']-$General['Semana1Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Jueves']-$General['Semana1Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana1']['Viernes']-$General['Semana1Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>
                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($General['Semana1']['Sabado']-$General['Semana1Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Lunes']-$General['Semana1Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Martes']-$General['Semana1Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Miercoles']-$General['Semana1Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana1']['Jueves']-$General['Semana1Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana1']['Viernes']-$General['Semana1Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$General['Semana1Ppto']['Sabado']) != (0) ? $s[1] = number_format($General['Semana1']['Sabado']/$General['Semana1Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$General['Semana1Ppto']['Lunes']) != (0) ? $s[2] = number_format($General['Semana1']['Lunes']/$General['Semana1Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$General['Semana1Ppto']['Martes']) != (0) ? $s[3] = number_format($General['Semana1']['Martes']/$General['Semana1Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$General['Semana1Ppto']['Miercoles']) != (0) ? $s[4] = number_format($General['Semana1']['Miercoles']/$General['Semana1Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$General['Semana1Ppto']['Jueves']) != (0) ? $s[5] = number_format($General['Semana1']['Jueves']/$General['Semana1Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$General['Semana1Ppto']['Viernes']) != (0) ? $s[6] = number_format($General['Semana1']['Viernes']/$General['Semana1Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$General['Semana1Ppto']['Sabado']) != (0) ? number_format($General['Semana1']['Sabado']/$General['Semana1Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$General['Semana1Ppto']['Lunes']) != (0) ? number_format($General['Semana1']['Lunes']/$General['Semana1Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$General['Semana1Ppto']['Martes']) != (0) ?number_format( $General['Semana1']['Martes']/$General['Semana1Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$General['Semana1Ppto']['Miercoles']) != (0) ? number_format($General['Semana1']['Miercoles']/$General['Semana1Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$General['Semana1Ppto']['Jueves']) != (0) ? number_format($General['Semana1']['Jueves']/$General['Semana1Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana1Ppto']['Viernes'] != (0)) ?  number_format($General['Semana1']['Viernes']/$General['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
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
                                                <td> <?php echo (@$General['Semana2Ppto']['Sabado']) != (0) ? number_format($General['Semana2Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Ppto']['Lunes']) != (0) ? number_format($General['Semana2Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Ppto']['Martes']) != (0) ?number_format( $General['Semana2Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Ppto']['Miercoles']) != (0) ? number_format($General['Semana2Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Ppto']['Jueves']) != (0) ? number_format($General['Semana2Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Ppto']['Viernes'] != (0)) ?  number_format($General['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana2Ppto']['Sabado']+$General['Semana2Ppto']['Lunes']+$General['Semana2Ppto']['Martes']+$General['Semana2Ppto']['Miercoles']+$General['Semana2Ppto']['Jueves']+$General['Semana2Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana2Fact']['Sabado']) != (0) ? number_format($General['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Lunes']) != (0) ? number_format($General['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Martes']) != (0) ?number_format( $General['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Miercoles']) != (0) ? number_format($General['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Jueves']) != (0) ? number_format($General['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Viernes'] != (0)) ?  number_format($General['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana2Fact']['Sabado']+$General['Semana2Fact']['Lunes']+$General['Semana2Fact']['Martes']+$General['Semana2Fact']['Miercoles']+$General['Semana2Fact']['Jueves']+$General['Semana2Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($General['Semana2']['Sabado']) != (0) ? number_format($General['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Lunes']) != (0) ? number_format($General['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Martes']) != (0) ?number_format( $General['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Miercoles']) != (0) ? number_format($General['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Jueves']) != (0) ? number_format($General['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Viernes'] != (0)) ?  number_format($General['Semana2']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($dese =$General['Semana2']['Sabado']+$General['Semana2']['Lunes']+$General['Semana2']['Martes']+$General['Semana2']['Miercoles']+$General['Semana2']['Jueves']+$General['Semana2']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($General['Semana2']['Sabado']-$General['Semana2Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Lunes']-$General['Semana2']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Martes']-$General['Semana2Fact']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Miercoles']-$General['Semana2Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Jueves']-$General['Semana2Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana2']['Viernes']-$General['Semana2Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>
                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($General['Semana2']['Sabado']-$General['Semana2Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Lunes']-$General['Semana2Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Martes']-$General['Semana2Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Miercoles']-$General['Semana2Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana2']['Jueves']-$General['Semana2Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana2']['Viernes']-$General['Semana2Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$General['Semana2Ppto']['Sabado']) != (0) ? $s[1] = number_format($General['Semana2']['Sabado']/$General['Semana2Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$General['Semana2Ppto']['Lunes']) != (0) ? $s[2] = number_format($General['Semana2']['Lunes']/$General['Semana2Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$General['Semana2Ppto']['Martes']) != (0) ? $s[3] = number_format($General['Semana2']['Martes']/$General['Semana2Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$General['Semana2Ppto']['Miercoles']) != (0) ? $s[4] = number_format($General['Semana2']['Miercoles']/$General['Semana2Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$General['Semana2Ppto']['Jueves']) != (0) ? $s[5] = number_format($General['Semana2']['Jueves']/$General['Semana2Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$General['Semana2Ppto']['Viernes']) != (0) ? $s[6] = number_format($General['Semana2']['Viernes']/$General['Semana2Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$General['Semana2Ppto']['Sabado']) != (0) ? number_format($General['Semana2']['Sabado']/$General['Semana2Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$General['Semana2Ppto']['Lunes']) != (0) ? number_format($General['Semana2']['Lunes']/$General['Semana2Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$General['Semana2Ppto']['Martes']) != (0) ?number_format( $General['Semana2']['Martes']/$General['Semana2Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$General['Semana2Ppto']['Miercoles']) != (0) ? number_format($General['Semana2']['Miercoles']/$General['Semana2Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$General['Semana2Ppto']['Jueves']) != (0) ? number_format($General['Semana2']['Jueves']/$General['Semana2Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana2Ppto']['Viernes'] != (0)) ?  number_format($General['Semana2']['Viernes']/$General['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
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
                                                <td> <?php echo ($General['Semana3Ppto']['Sabado']) != (0) ? number_format($General['Semana3Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3Ppto']['Lunes']) != (0) ? number_format($General['Semana3Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3Ppto']['Martes']) != (0) ?number_format( $General['Semana3Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3Ppto']['Miercoles']) != (0) ? number_format($General['Semana3Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3Ppto']['Jueves']) != (0) ? number_format($General['Semana3Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3Ppto']['Viernes'] != (0)) ?  number_format($General['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana3Ppto']['Sabado']+$General['Semana3Ppto']['Lunes']+$General['Semana3Ppto']['Martes']+$General['Semana3Ppto']['Miercoles']+$General['Semana3Ppto']['Jueves']+$General['Semana3Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana3Fact']['Sabado']) != (0) ? number_format($General['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Lunes']) != (0) ? number_format($General['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Martes']) != (0) ?number_format( $General['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Miercoles']) != (0) ? number_format($General['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Jueves']) != (0) ? number_format($General['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Viernes'] != (0)) ?  number_format($General['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana3Fact']['Sabado']+$General['Semana3Fact']['Lunes']+$General['Semana3Fact']['Martes']+$General['Semana3Fact']['Miercoles']+$General['Semana3Fact']['Jueves']+$General['Semana3Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana3']['Sabado']) != (0) ?  number_format($General['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Lunes']) != (0) ?  number_format($General['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Martes']) != (0) ?  number_format($General['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Miercoles']) != (0) ?  number_format($General['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Jueves']) != (0) ?  number_format($General['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Viernes'] != (0)) ?   number_format($General['Semana3']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $General['Semana3']['Sabado']+$General['Semana3']['Lunes']+$General['Semana3']['Martes']+$General['Semana3']['Miercoles']+$General['Semana3']['Jueves']+$General['Semana3']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($General['Semana3']['Sabado']-$General['Semana3Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Lunes']-$General['Semana3Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Martes']-$General['Semana3Fact']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Miercoles']-$General['Semana3Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Jueves']-$General['Semana3Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana3']['Viernes']-$General['Semana3Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($General['Semana3']['Sabado']-$General['Semana3Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Lunes']-$General['Semana3Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Martes']-$General['Semana3Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Miercoles']-$General['Semana3Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana3']['Jueves']-$General['Semana3Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana3']['Viernes']-$General['Semana3Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$General['Semana3Ppto']['Sabado']) != (0) ? $s[1] = number_format($General['Semana3']['Sabado']/$General['Semana3Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$General['Semana3Ppto']['Lunes']) != (0) ? $s[2] = number_format($General['Semana3']['Lunes']/$General['Semana3Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$General['Semana3Ppto']['Martes']) != (0) ? $s[3] = number_format($General['Semana3']['Martes']/$General['Semana3Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$General['Semana3Ppto']['Miercoles']) != (0) ? $s[4] = number_format($General['Semana3']['Miercoles']/$General['Semana3Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$General['Semana3Ppto']['Jueves']) != (0) ? $s[5] = number_format($General['Semana3']['Jueves']/$General['Semana3Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$General['Semana3Ppto']['Viernes']) != (0) ? $s[6] = number_format($General['Semana3']['Viernes']/$General['Semana3Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$General['Semana3Ppto']['Sabado']) != (0) ? number_format($General['Semana3']['Sabado']/$General['Semana3Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$General['Semana3Ppto']['Lunes']) != (0) ? number_format($General['Semana3']['Lunes']/$General['Semana3Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$General['Semana3Ppto']['Martes']) != (0) ?number_format( $General['Semana3']['Martes']/$General['Semana3Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$General['Semana3Ppto']['Miercoles']) != (0) ? number_format($General['Semana3']['Miercoles']/$General['Semana3Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$General['Semana3Ppto']['Jueves']) != (0) ? number_format($General['Semana3']['Jueves']/$General['Semana3Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana3Ppto']['Viernes'] != (0)) ?  number_format($General['Semana3']['Viernes']/$General['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
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
                                                <td> <?php echo ($General['Semana4Ppto']['Sabado']) != (0) ? number_format($General['Semana4Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4Ppto']['Lunes']) != (0) ? number_format($General['Semana4Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4Ppto']['Martes']) != (0) ?number_format( $General['Semana4Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4Ppto']['Miercoles']) != (0) ? number_format($General['Semana4Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4Ppto']['Jueves']) != (0) ? number_format($General['Semana4Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4Ppto']['Viernes'] != (0)) ?  number_format($General['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$General['Semana4Ppto']['Sabado']+$General['Semana4Ppto']['Lunes']+$General['Semana4Ppto']['Martes']+$General['Semana4Ppto']['Miercoles']+$General['Semana4Ppto']['Jueves']+$General['Semana4Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana4Fact']['Sabado']) != (0) ? number_format($General['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Lunes']) != (0) ? number_format($General['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Martes']) != (0) ?number_format( $General['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Miercoles']) != (0) ? number_format($General['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Jueves']) != (0) ? number_format($General['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Viernes'] != (0)) ?  number_format($General['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana4Fact']['Sabado']+$General['Semana4Fact']['Lunes']+$General['Semana4Fact']['Martes']+$General['Semana4Fact']['Miercoles']+$General['Semana4Fact']['Jueves']+$General['Semana4Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana4']['Sabado']) != (0) ?  number_format($General['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Lunes']) != (0) ?  number_format($General['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Martes']) != (0) ?  number_format($General['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Miercoles']) != (0) ?  number_format($General['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Jueves']) != (0) ?  number_format($General['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Viernes'] != (0)) ?   number_format($General['Semana4']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $General['Semana4']['Sabado']+$General['Semana4']['Lunes']+$General['Semana4']['Martes']+$General['Semana4']['Miercoles']+$General['Semana4']['Jueves']+$General['Semana4']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($General['Semana4']['Sabado']-$General['Semana4Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Lunes']-$General['Semana4Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Martes']-$General['Semana4Fact']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Miercoles']-$General['Semana4Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Jueves']-$General['Semana4Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana4']['Viernes']-$General['Semana4Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($General['Semana4']['Sabado']-$General['Semana4Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Lunes']-$General['Semana4Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Martes']-$General['Semana4Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Miercoles']-$General['Semana4Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana4']['Jueves']-$General['Semana4Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana4']['Viernes']-$General['Semana4Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$General['Semana4Ppto']['Sabado']) != (0) ? $s[1] = number_format($General['Semana4']['Sabado']/$General['Semana4Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$General['Semana4Ppto']['Lunes']) != (0) ? $s[2] = number_format($General['Semana4']['Lunes']/$General['Semana4Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$General['Semana4Ppto']['Martes']) != (0) ? $s[3] = number_format($General['Semana4']['Martes']/$General['Semana4Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$General['Semana4Ppto']['Miercoles']) != (0) ? $s[4] = number_format($General['Semana4']['Miercoles']/$General['Semana4Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$General['Semana4Ppto']['Jueves']) != (0) ? $s[5] = number_format($General['Semana4']['Jueves']/$General['Semana4Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$General['Semana4Ppto']['Viernes']) != (0) ? $s[6] = number_format($General['Semana4']['Viernes']/$General['Semana4Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$General['Semana4Ppto']['Sabado']) != (0) ? number_format($General['Semana4']['Sabado']/$General['Semana4Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$General['Semana4Ppto']['Lunes']) != (0) ? number_format($General['Semana4']['Lunes']/$General['Semana4Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$General['Semana4Ppto']['Martes']) != (0) ?number_format( $General['Semana4']['Martes']/$General['Semana4Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$General['Semana4Ppto']['Miercoles']) != (0) ? number_format($General['Semana4']['Miercoles']/$General['Semana4Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$General['Semana4Ppto']['Jueves']) != (0) ? number_format($General['Semana4']['Jueves']/$General['Semana4Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana4Ppto']['Viernes'] != (0)) ?  number_format($General['Semana4']['Viernes']/$General['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
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
                                                <td> <?php echo ($General['Semana5Ppto']['Sabado']) != (0) ? number_format($General['Semana5Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5Ppto']['Lunes']) != (0) ? number_format($General['Semana5Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5Ppto']['Martes']) != (0) ?number_format( $General['Semana5Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5Ppto']['Miercoles']) != (0) ? number_format($General['Semana5Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5Ppto']['Jueves']) != (0) ? number_format($General['Semana5Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5Ppto']['Viernes'] != (0)) ?  number_format($General['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$General['Semana5Ppto']['Sabado']+$General['Semana5Ppto']['Lunes']+$General['Semana5Ppto']['Martes']+$General['Semana5Ppto']['Miercoles']+$General['Semana5Ppto']['Jueves']+$General['Semana5Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana5Fact']['Sabado']) != (0) ? number_format($General['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Lunes']) != (0) ? number_format($General['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Martes']) != (0) ?number_format( $General['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Miercoles']) != (0) ? number_format($General['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Jueves']) != (0) ? number_format($General['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Viernes'] != (0)) ?  number_format($General['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana5Fact']['Sabado']+$General['Semana5Fact']['Lunes']+$General['Semana5Fact']['Martes']+$General['Semana5Fact']['Miercoles']+$General['Semana5Fact']['Jueves']+$General['Semana5Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana5']['Sabado']) != (0) ?  number_format($General['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Lunes']) != (0) ?  number_format($General['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Martes']) != (0) ?  number_format($General['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Miercoles']) != (0) ?  number_format($General['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Jueves']) != (0) ?  number_format($General['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Viernes'] != (0)) ?   number_format($General['Semana5']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $General['Semana5']['Sabado']+$General['Semana5']['Lunes']+$General['Semana5']['Martes']+$General['Semana5']['Miercoles']+$General['Semana5']['Jueves']+$General['Semana5']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($General['Semana5']['Sabado']-$General['Semana5Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Lunes']-$General['Semana5Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Martes']-$General['Semana5Fact']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Miercoles']-$General['Semana5Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Jueves']-$General['Semana5Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana5']['Viernes']-$General['Semana5Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($General['Semana5']['Sabado']-$General['Semana5Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Lunes']-$General['Semana5Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Martes']-$General['Semana5Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Miercoles']-$General['Semana5Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($General['Semana5']['Jueves']-$General['Semana5Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($General['Semana5']['Viernes']-$General['Semana5Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$General['Semana5Ppto']['Sabado']) != (0) ? $s[1] = number_format($General['Semana5']['Sabado']/$General['Semana5Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$General['Semana5Ppto']['Lunes']) != (0) ? $s[2] = number_format($General['Semana5']['Lunes']/$General['Semana5Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$General['Semana5Ppto']['Martes']) != (0) ? $s[3] = number_format($General['Semana5']['Martes']/$General['Semana5Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$General['Semana5Ppto']['Miercoles']) != (0) ? $s[4] = number_format($General['Semana5']['Miercoles']/$General['Semana5Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$General['Semana5Ppto']['Jueves']) != (0) ? $s[5] = number_format($General['Semana5']['Jueves']/$General['Semana5Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$General['Semana5Ppto']['Viernes']) != (0) ? $s[6] = number_format($General['Semana5']['Viernes']/$General['Semana5Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$General['Semana5Ppto']['Sabado']) != (0) ? number_format($General['Semana5']['Sabado']/$General['Semana5Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$General['Semana5Ppto']['Lunes']) != (0) ? number_format($General['Semana5']['Lunes']/$General['Semana5Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$General['Semana5Ppto']['Martes']) != (0) ?number_format( $General['Semana5']['Martes']/$General['Semana5Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$General['Semana5Ppto']['Miercoles']) != (0) ? number_format($General['Semana5']['Miercoles']/$General['Semana5Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$General['Semana5Ppto']['Jueves']) != (0) ? number_format($General['Semana5']['Jueves']/$General['Semana5Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana5Ppto']['Viernes'] != (0)) ?  number_format($General['Semana5']['Viernes']/$General['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
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
                <!-- Fin Empresa-->
                
                <?php 
                //print_r($General['agn']);
                foreach ($General['agn'] as $key) {
                    //echo $key->id_cartera;
                    $codigo = $key->id_cartera;
                ?>
                <!-- Inicia Region-->
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <label style="margin-right: 70%"><?= $retval =($codigo == 14) ? "Ateos" : $key->cartera;?></label>  <label>Mes: <?= $General['MesActual'];?>   </label>
                                
                            </div>
                            <div class="panel-body table-responsive">
                                
                                    <?php //print_r($General['agn']);?>
                                    <?php //echo "asd".${'Agn'.$codigo}['semanas'][1];?>
                                
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home<?= $key->id_cartera;?>">Home</a></li>
                                    <li><a data-toggle="tab" href="#menu1<?= $key->id_cartera;?>">Semana 1</a></li>
                                    <li><a data-toggle="tab" href="#menu2<?= $key->id_cartera;?>">Semana 2</a></li>
                                    <li><a data-toggle="tab" href="#menu3<?= $key->id_cartera;?>">Semana 3</a></li>
                                    <li><a data-toggle="tab" href="#menu4<?= $key->id_cartera;?>">Semana 4</a></li>
                                    <li><a data-toggle="tab" href="#menu5<?= $key->id_cartera;?>">Semana 5</a></li>
                                    
                                </ul>

                                <div class="tab-content">
                                    <div id="home<?=$codigo?>" class="tab-pane fade in active">
                                        <h3>Mensual</h3>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Colocacion Nueva</th>
                                                    <th scope="col"><?= $General['MesAnterior'];?> </th>
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
                                                    <td><?= number_format(${'Agn'.$codigo}['totalMesAnt'],2)?></td>
                                                            
                                                    <?php 
                                                    //print_r($semanas);
                                                    for ($i=1; $i <=5 ; $i++) { 
                                                        if (isset(${'Agn'.$codigo}['semanas'][$i])) {
                                                        echo "<td>".number_format(${'Agn'.$codigo}['semanas'][$i],2)."</td>";
                                                        }else{
                                                            ${'Agn'.$codigo}['semanas'][$i]=0.00;
                                                    }
                                                    }  ?>
                                                    <!--<td><?php if (isset($semanas[1])) {
                                                        //echo $semanas[1];
                                                    }else{
                                                        echo "0.00";
                                                    } ?></td>
                                                    <td><?php if (isset($semanas[2])) {
                                                        //echo $semanas[2];
                                                    }else{
                                                        echo "0";
                                                    } ?></td>
                                                    <td><?php if (isset($semanas[3])) {
                                                    // echo $semanas[3];
                                                    }else{
                                                        echo "0";
                                                    } ?></td>
                                                    <td><?php if (isset($semanas[4])) {
                                                    // echo $semanas[4];
                                                    }else{
                                                        echo "0";
                                                    } ?></td>
                                                    <td><?php if (isset($semanas[5])) {
                                                        //echo $semanas[5];
                                                    }else{
                                                        echo "0";
                                                    } ?></td>-->
                                                    <td><?= number_format(${'Agn'.$codigo}['totalMesAct'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['totalAcumulado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td><?= number_format(${'Agn'.$codigo}['Acolocado'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['colocadosem1'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['colocadosem2'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['colocadosem3'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['colocadosem4'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['colocadosem5'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['acumcolocado']=${'Agn'.$codigo}['colocadosem1']+${'Agn'.$codigo}['colocadosem2']+${'Agn'.$codigo}['colocadosem3']+${'Agn'.$codigo}['colocadosem4']+${'Agn'.$codigo}['colocadosem5'],2)?></td>
                                                    <td><?= number_format(${'Agn'.$codigo}['totalcolocado']=${'Agn'.$codigo}['acumcolocado']+${'Agn'.$codigo}['Acolocado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Deudas</th>
                                                <td><?=number_format(@${'Agn'.$codigo}['Acolocado']-${'Agn'.$codigo}['totalMesAnt'],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['colocadosem1']-${'Agn'.$codigo}['semanas'][1],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['colocadosem2']-${'Agn'.$codigo}['semanas'][2],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['colocadosem3']-${'Agn'.$codigo}['semanas'][3],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['colocadosem4']-${'Agn'.$codigo}['semanas'][4],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['colocadosem5']-${'Agn'.$codigo}['semanas'][5],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['acumcolocado']-${'Agn'.$codigo}['totalMesAct'],2)?></td>
                                                    <td><?=number_format(@${'Agn'.$codigo}['totalcolocado']-${'Agn'.$codigo}['totalAcumulado'],2)?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu1<?=$codigo?>" class="tab-pane fade">
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
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana1Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = ${'Agn'.$codigo}['Semana1Ppto']['Sabado']+${'Agn'.$codigo}['Semana1Ppto']['Lunes']+${'Agn'.$codigo}['Semana1Ppto']['Martes']+${'Agn'.$codigo}['Semana1Ppto']['Miercoles']+${'Agn'.$codigo}['Semana1Ppto']['Jueves']+${'Agn'.$codigo}['Semana1Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana1Fact']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = ${'Agn'.$codigo}['Semana1Fact']['Sabado']+${'Agn'.$codigo}['Semana1Fact']['Lunes']+${'Agn'.$codigo}['Semana1Fact']['Martes']+${'Agn'.$codigo}['Semana1Fact']['Miercoles']+${'Agn'.$codigo}['Semana1Fact']['Jueves']+${'Agn'.$codigo}['Semana1Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana1']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana1']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =${'Agn'.$codigo}['Semana1']['Sabado']+${'Agn'.$codigo}['Semana1']['Lunes']+${'Agn'.$codigo}['Semana1']['Martes']+${'Agn'.$codigo}['Semana1']['Miercoles']+${'Agn'.$codigo}['Semana1']['Jueves']+${'Agn'.$codigo}['Semana1']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Sabado']-${'Agn'.$codigo}['Semana1Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Lunes']-${'Agn'.$codigo}['Semana1']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Martes']-${'Agn'.$codigo}['Semana1Fact']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Miercoles']-${'Agn'.$codigo}['Semana1Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Jueves']-${'Agn'.$codigo}['Semana1Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Viernes']-${'Agn'.$codigo}['Semana1Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Sabado']-${'Agn'.$codigo}['Semana1Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Lunes']-${'Agn'.$codigo}['Semana1Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Martes']-${'Agn'.$codigo}['Semana1Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Miercoles']-${'Agn'.$codigo}['Semana1Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Jueves']-${'Agn'.$codigo}['Semana1Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana1']['Viernes']-${'Agn'.$codigo}['Semana1Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Sabado']) != (0) ? $s[1] = number_format(${'Agn'.$codigo}['Semana1']['Sabado']/${'Agn'.$codigo}['Semana1Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Lunes']) != (0) ? $s[2] = number_format(${'Agn'.$codigo}['Semana1']['Lunes']/${'Agn'.$codigo}['Semana1Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Martes']) != (0) ? $s[3] = number_format(${'Agn'.$codigo}['Semana1']['Martes']/${'Agn'.$codigo}['Semana1Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Miercoles']) != (0) ? $s[4] = number_format(${'Agn'.$codigo}['Semana1']['Miercoles']/${'Agn'.$codigo}['Semana1Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Jueves']) != (0) ? $s[5] = number_format(${'Agn'.$codigo}['Semana1']['Jueves']/${'Agn'.$codigo}['Semana1Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@${'Agn'.$codigo}['Semana1Ppto']['Viernes']) != (0) ? $s[6] = number_format(${'Agn'.$codigo}['Semana1']['Viernes']/${'Agn'.$codigo}['Semana1Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Sabado']/${'Agn'.$codigo}['Semana1Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Lunes']/${'Agn'.$codigo}['Semana1Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana1']['Martes']/${'Agn'.$codigo}['Semana1Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Miercoles']/${'Agn'.$codigo}['Semana1Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana1']['Jueves']/${'Agn'.$codigo}['Semana1Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@${'Agn'.$codigo}['Semana1Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana1']['Viernes']/${'Agn'.$codigo}['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu2<?=$codigo?>" class="tab-pane fade">
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
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana2Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = ${'Agn'.$codigo}['Semana2Ppto']['Sabado']+${'Agn'.$codigo}['Semana2Ppto']['Lunes']+${'Agn'.$codigo}['Semana2Ppto']['Martes']+${'Agn'.$codigo}['Semana2Ppto']['Miercoles']+${'Agn'.$codigo}['Semana2Ppto']['Jueves']+${'Agn'.$codigo}['Semana2Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana2Fact']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = ${'Agn'.$codigo}['Semana2Fact']['Sabado']+${'Agn'.$codigo}['Semana2Fact']['Lunes']+${'Agn'.$codigo}['Semana2Fact']['Martes']+${'Agn'.$codigo}['Semana2Fact']['Miercoles']+${'Agn'.$codigo}['Semana2Fact']['Jueves']+${'Agn'.$codigo}['Semana2Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana2']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana2']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =${'Agn'.$codigo}['Semana2']['Sabado']+${'Agn'.$codigo}['Semana2']['Lunes']+${'Agn'.$codigo}['Semana2']['Martes']+${'Agn'.$codigo}['Semana2']['Miercoles']+${'Agn'.$codigo}['Semana2']['Jueves']+${'Agn'.$codigo}['Semana2']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Sabado']-${'Agn'.$codigo}['Semana2Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Lunes']-${'Agn'.$codigo}['Semana2']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Martes']-${'Agn'.$codigo}['Semana2Fact']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Miercoles']-${'Agn'.$codigo}['Semana2Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Jueves']-${'Agn'.$codigo}['Semana2Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Viernes']-${'Agn'.$codigo}['Semana2Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Sabado']-${'Agn'.$codigo}['Semana2Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Lunes']-${'Agn'.$codigo}['Semana2Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Martes']-${'Agn'.$codigo}['Semana2Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Miercoles']-${'Agn'.$codigo}['Semana2Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Jueves']-${'Agn'.$codigo}['Semana2Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana2']['Viernes']-${'Agn'.$codigo}['Semana2Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Sabado']) != (0) ? $s[1] = number_format(${'Agn'.$codigo}['Semana2']['Sabado']/${'Agn'.$codigo}['Semana2Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Lunes']) != (0) ? $s[2] = number_format(${'Agn'.$codigo}['Semana2']['Lunes']/${'Agn'.$codigo}['Semana2Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Martes']) != (0) ? $s[3] = number_format(${'Agn'.$codigo}['Semana2']['Martes']/${'Agn'.$codigo}['Semana2Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Miercoles']) != (0) ? $s[4] = number_format(${'Agn'.$codigo}['Semana2']['Miercoles']/${'Agn'.$codigo}['Semana2Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Jueves']) != (0) ? $s[5] = number_format(${'Agn'.$codigo}['Semana2']['Jueves']/${'Agn'.$codigo}['Semana2Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@${'Agn'.$codigo}['Semana2Ppto']['Viernes']) != (0) ? $s[6] = number_format(${'Agn'.$codigo}['Semana2']['Viernes']/${'Agn'.$codigo}['Semana2Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Sabado']/${'Agn'.$codigo}['Semana2Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Lunes']/${'Agn'.$codigo}['Semana2Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana2']['Martes']/${'Agn'.$codigo}['Semana2Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Miercoles']/${'Agn'.$codigo}['Semana2Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana2']['Jueves']/${'Agn'.$codigo}['Semana2Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@${'Agn'.$codigo}['Semana2Ppto']['Viernes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana2']['Viernes']/${'Agn'.$codigo}['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu3<?=$codigo?>" class="tab-pane fade">
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
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana3Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = ${'Agn'.$codigo}['Semana3Ppto']['Sabado']+${'Agn'.$codigo}['Semana3Ppto']['Lunes']+${'Agn'.$codigo}['Semana3Ppto']['Martes']+${'Agn'.$codigo}['Semana3Ppto']['Miercoles']+${'Agn'.$codigo}['Semana3Ppto']['Jueves']+${'Agn'.$codigo}['Semana3Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana3Fact']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = ${'Agn'.$codigo}['Semana3Fact']['Sabado']+${'Agn'.$codigo}['Semana3Fact']['Lunes']+${'Agn'.$codigo}['Semana3Fact']['Martes']+${'Agn'.$codigo}['Semana3Fact']['Miercoles']+${'Agn'.$codigo}['Semana3Fact']['Jueves']+${'Agn'.$codigo}['Semana3Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Sabado']) != (0) ?  number_format(${'Agn'.$codigo}['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Lunes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Martes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Miercoles']) != (0) ?  number_format(${'Agn'.$codigo}['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Jueves']) != (0) ?  number_format(${'Agn'.$codigo}['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana3']['Viernes'] != (0)) ?   number_format(${'Agn'.$codigo}['Semana3']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = ${'Agn'.$codigo}['Semana3']['Sabado']+${'Agn'.$codigo}['Semana3']['Lunes']+${'Agn'.$codigo}['Semana3']['Martes']+${'Agn'.$codigo}['Semana3']['Miercoles']+${'Agn'.$codigo}['Semana3']['Jueves']+${'Agn'.$codigo}['Semana3']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Sabado']-${'Agn'.$codigo}['Semana3Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Lunes']-${'Agn'.$codigo}['Semana3Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Martes']-${'Agn'.$codigo}['Semana3Fact']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Miercoles']-${'Agn'.$codigo}['Semana3Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Jueves']-${'Agn'.$codigo}['Semana3Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Viernes']-${'Agn'.$codigo}['Semana3Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Sabado']-${'Agn'.$codigo}['Semana3Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Lunes']-${'Agn'.$codigo}['Semana3Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Martes']-${'Agn'.$codigo}['Semana3Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Miercoles']-${'Agn'.$codigo}['Semana3Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Jueves']-${'Agn'.$codigo}['Semana3Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana3']['Viernes']-${'Agn'.$codigo}['Semana3Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Sabado']) != (0) ? $s[1] = number_format(${'Agn'.$codigo}['Semana3']['Sabado']/${'Agn'.$codigo}['Semana3Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Lunes']) != (0) ? $s[2] = number_format(${'Agn'.$codigo}['Semana3']['Lunes']/${'Agn'.$codigo}['Semana3Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Martes']) != (0) ? $s[3] = number_format(${'Agn'.$codigo}['Semana3']['Martes']/${'Agn'.$codigo}['Semana3Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Miercoles']) != (0) ? $s[4] = number_format(${'Agn'.$codigo}['Semana3']['Miercoles']/${'Agn'.$codigo}['Semana3Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Jueves']) != (0) ? $s[5] = number_format(${'Agn'.$codigo}['Semana3']['Jueves']/${'Agn'.$codigo}['Semana3Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@${'Agn'.$codigo}['Semana3Ppto']['Viernes']) != (0) ? $s[6] = number_format(${'Agn'.$codigo}['Semana3']['Viernes']/${'Agn'.$codigo}['Semana3Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana3']['Sabado']/${'Agn'.$codigo}['Semana3Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana3']['Lunes']/${'Agn'.$codigo}['Semana3Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana3']['Martes']/${'Agn'.$codigo}['Semana3Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana3']['Miercoles']/${'Agn'.$codigo}['Semana3Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana3']['Jueves']/${'Agn'.$codigo}['Semana3Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@${'Agn'.$codigo}['Semana3Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana3']['Viernes']/${'Agn'.$codigo}['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu4<?=$codigo?>" class="tab-pane fade">
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
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana4Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =${'Agn'.$codigo}['Semana4Ppto']['Sabado']+${'Agn'.$codigo}['Semana4Ppto']['Lunes']+${'Agn'.$codigo}['Semana4Ppto']['Martes']+${'Agn'.$codigo}['Semana4Ppto']['Miercoles']+${'Agn'.$codigo}['Semana4Ppto']['Jueves']+${'Agn'.$codigo}['Semana4Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana4Fact']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = ${'Agn'.$codigo}['Semana4Fact']['Sabado']+${'Agn'.$codigo}['Semana4Fact']['Lunes']+${'Agn'.$codigo}['Semana4Fact']['Martes']+${'Agn'.$codigo}['Semana4Fact']['Miercoles']+${'Agn'.$codigo}['Semana4Fact']['Jueves']+${'Agn'.$codigo}['Semana4Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Sabado']) != (0) ?  number_format(${'Agn'.$codigo}['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Lunes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Martes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Miercoles']) != (0) ?  number_format(${'Agn'.$codigo}['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Jueves']) != (0) ?  number_format(${'Agn'.$codigo}['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana4']['Viernes'] != (0)) ?   number_format(${'Agn'.$codigo}['Semana4']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = ${'Agn'.$codigo}['Semana4']['Sabado']+${'Agn'.$codigo}['Semana4']['Lunes']+${'Agn'.$codigo}['Semana4']['Martes']+${'Agn'.$codigo}['Semana4']['Miercoles']+${'Agn'.$codigo}['Semana4']['Jueves']+${'Agn'.$codigo}['Semana4']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Sabado']-${'Agn'.$codigo}['Semana4Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Lunes']-${'Agn'.$codigo}['Semana4Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Martes']-${'Agn'.$codigo}['Semana4Fact']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Miercoles']-${'Agn'.$codigo}['Semana4Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Jueves']-${'Agn'.$codigo}['Semana4Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Viernes']-${'Agn'.$codigo}['Semana4Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Sabado']-${'Agn'.$codigo}['Semana4Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Lunes']-${'Agn'.$codigo}['Semana4Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Martes']-${'Agn'.$codigo}['Semana4Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Miercoles']-${'Agn'.$codigo}['Semana4Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Jueves']-${'Agn'.$codigo}['Semana4Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana4']['Viernes']-${'Agn'.$codigo}['Semana4Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Sabado']) != (0) ? $s[1] = number_format(${'Agn'.$codigo}['Semana4']['Sabado']/${'Agn'.$codigo}['Semana4Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Lunes']) != (0) ? $s[2] = number_format(${'Agn'.$codigo}['Semana4']['Lunes']/${'Agn'.$codigo}['Semana4Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Martes']) != (0) ? $s[3] = number_format(${'Agn'.$codigo}['Semana4']['Martes']/${'Agn'.$codigo}['Semana4Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Miercoles']) != (0) ? $s[4] = number_format(${'Agn'.$codigo}['Semana4']['Miercoles']/${'Agn'.$codigo}['Semana4Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Jueves']) != (0) ? $s[5] = number_format(${'Agn'.$codigo}['Semana4']['Jueves']/${'Agn'.$codigo}['Semana4Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@${'Agn'.$codigo}['Semana4Ppto']['Viernes']) != (0) ? $s[6] = number_format(${'Agn'.$codigo}['Semana4']['Viernes']/${'Agn'.$codigo}['Semana4Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana4']['Sabado']/${'Agn'.$codigo}['Semana4Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana4']['Lunes']/${'Agn'.$codigo}['Semana4Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana4']['Martes']/${'Agn'.$codigo}['Semana4Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana4']['Miercoles']/${'Agn'.$codigo}['Semana4Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana4']['Jueves']/${'Agn'.$codigo}['Semana4Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@${'Agn'.$codigo}['Semana4Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana4']['Viernes']/${'Agn'.$codigo}['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?php echo (@$ppto != (0)) ?  number_format($dese/$ppto*100,2).'%' : '-' ;  ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu5<?=$codigo?>" class="tab-pane fade">
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
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana5Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =${'Agn'.$codigo}['Semana5Ppto']['Sabado']+${'Agn'.$codigo}['Semana5Ppto']['Lunes']+${'Agn'.$codigo}['Semana5Ppto']['Martes']+${'Agn'.$codigo}['Semana5Ppto']['Miercoles']+${'Agn'.$codigo}['Semana5Ppto']['Jueves']+${'Agn'.$codigo}['Semana5Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@${'Agn'.$codigo}['Semana5Fact']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = ${'Agn'.$codigo}['Semana5Fact']['Sabado']+${'Agn'.$codigo}['Semana5Fact']['Lunes']+${'Agn'.$codigo}['Semana5Fact']['Martes']+${'Agn'.$codigo}['Semana5Fact']['Miercoles']+${'Agn'.$codigo}['Semana5Fact']['Jueves']+${'Agn'.$codigo}['Semana5Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Sabado']) != (0) ?  number_format(${'Agn'.$codigo}['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Lunes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Martes']) != (0) ?  number_format(${'Agn'.$codigo}['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Miercoles']) != (0) ?  number_format(${'Agn'.$codigo}['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Jueves']) != (0) ?  number_format(${'Agn'.$codigo}['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (${'Agn'.$codigo}['Semana5']['Viernes'] != (0)) ?   number_format(${'Agn'.$codigo}['Semana5']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = ${'Agn'.$codigo}['Semana5']['Sabado']+${'Agn'.$codigo}['Semana5']['Lunes']+${'Agn'.$codigo}['Semana5']['Martes']+${'Agn'.$codigo}['Semana5']['Miercoles']+${'Agn'.$codigo}['Semana5']['Jueves']+${'Agn'.$codigo}['Semana5']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Sabado']-${'Agn'.$codigo}['Semana5Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Lunes']-${'Agn'.$codigo}['Semana5Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Martes']-${'Agn'.$codigo}['Semana5Fact']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Miercoles']-${'Agn'.$codigo}['Semana5Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Jueves']-${'Agn'.$codigo}['Semana5Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Viernes']-${'Agn'.$codigo}['Semana5Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Sabado']-${'Agn'.$codigo}['Semana5Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Lunes']-${'Agn'.$codigo}['Semana5Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Martes']-${'Agn'.$codigo}['Semana5Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Miercoles']-${'Agn'.$codigo}['Semana5Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Jueves']-${'Agn'.$codigo}['Semana5Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format(${'Agn'.$codigo}['Semana5']['Viernes']-${'Agn'.$codigo}['Semana5Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Sabado']) != (0) ? $s[1] = number_format(${'Agn'.$codigo}['Semana5']['Sabado']/${'Agn'.$codigo}['Semana5Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Lunes']) != (0) ? $s[2] = number_format(${'Agn'.$codigo}['Semana5']['Lunes']/${'Agn'.$codigo}['Semana5Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Martes']) != (0) ? $s[3] = number_format(${'Agn'.$codigo}['Semana5']['Martes']/${'Agn'.$codigo}['Semana5Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Miercoles']) != (0) ? $s[4] = number_format(${'Agn'.$codigo}['Semana5']['Miercoles']/${'Agn'.$codigo}['Semana5Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Jueves']) != (0) ? $s[5] = number_format(${'Agn'.$codigo}['Semana5']['Jueves']/${'Agn'.$codigo}['Semana5Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@${'Agn'.$codigo}['Semana5Ppto']['Viernes']) != (0) ? $s[6] = number_format(${'Agn'.$codigo}['Semana5']['Viernes']/${'Agn'.$codigo}['Semana5Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Sabado']) != (0) ? number_format(${'Agn'.$codigo}['Semana5']['Sabado']/${'Agn'.$codigo}['Semana5Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Lunes']) != (0) ? number_format(${'Agn'.$codigo}['Semana5']['Lunes']/${'Agn'.$codigo}['Semana5Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Martes']) != (0) ?number_format( ${'Agn'.$codigo}['Semana5']['Martes']/${'Agn'.$codigo}['Semana5Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Miercoles']) != (0) ? number_format(${'Agn'.$codigo}['Semana5']['Miercoles']/${'Agn'.$codigo}['Semana5Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Jueves']) != (0) ? number_format(${'Agn'.$codigo}['Semana5']['Jueves']/${'Agn'.$codigo}['Semana5Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@${'Agn'.$codigo}['Semana5Ppto']['Viernes'] != (0)) ?  number_format(${'Agn'.$codigo}['Semana5']['Viernes']/${'Agn'.$codigo}['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
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
                <!-- Fin Region-->    
                <?php
                }
                ?>
                

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
    $("#nap").change(function () {
        valor= $("#nap").val();
        //    valor=valor.substr(5, 2);
         window.location.href = "<?php echo site_url() ?>/Seguimiento/index/"+valor;

            return false;          
        //load();

    });
</script>