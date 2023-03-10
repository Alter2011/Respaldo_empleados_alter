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

<div class="col-sm-12 col-xs-12 print-col-sm-10" id="imprimir">
    <div class="text-center well text-white blue no-print">
        <h2>Comparacion de regiones</h2>
        
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
                                <label style="margin-right: 70%">Nivel Empresa</label>  <label>Mes: <?= $MesActual;?>  </label>
                                
                            </div>
                            <div class="panel-body table-responsive">
                            
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
                                                <td><?= number_format($General['totalMesAnt'],2)?></td>
                                                        
                                                <?php 
                                                //print_r($semanas);
                                                for ($i=1; $i <=5 ; $i++) { 
                                                    if (isset($General['semanas'][$i])) {
                                                    echo "<td>".number_format($General['semanas'][$i],2)."</td>";
                                                    }else{
                                                        $General['semanas'][$i]=0.00;
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
                                                <td> <?php echo (@$General['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana1Ppto']['Sabado']+$General['Semana1Ppto']['Lunes']+$General['Semana1Ppto']['Martes']+$General['Semana1Ppto']['Miercoles']+$General['Semana1Ppto']['Jueves']+$General['Semana1Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana1Fact']['Sabado']) != (0) ? number_format($General['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Lunes']) != (0) ? number_format($General['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Martes']) != (0) ?number_format( $General['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Miercoles']) != (0) ? number_format($General['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Jueves']) != (0) ? number_format($General['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana1Fact']['Viernes'] != ('0')) ?  number_format($General['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana1Fact']['Sabado']+$General['Semana1Fact']['Lunes']+$General['Semana1Fact']['Martes']+$General['Semana1Fact']['Miercoles']+$General['Semana1Fact']['Jueves']+$General['Semana1Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($General['Semana1']['Sabado']) != (0) ? number_format($General['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Lunes']) != (0) ? number_format($General['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Martes']) != (0) ?number_format( $General['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Miercoles']) != (0) ? number_format($General['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Jueves']) != (0) ? number_format($General['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana1']['Viernes'] != ('0')) ?  number_format($General['Semana1']['Viernes'],2) : '-' ; ?> </td>
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
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana1']['Viernes']/$General['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                                                <td> <?php echo (@$General['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana2Ppto']['Sabado']+$General['Semana2Ppto']['Lunes']+$General['Semana2Ppto']['Martes']+$General['Semana2Ppto']['Miercoles']+$General['Semana2Ppto']['Jueves']+$General['Semana2Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana2Fact']['Sabado']) != (0) ? number_format($General['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Lunes']) != (0) ? number_format($General['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Martes']) != (0) ?number_format( $General['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Miercoles']) != (0) ? number_format($General['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Jueves']) != (0) ? number_format($General['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana2Fact']['Viernes'] != ('0')) ?  number_format($General['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana2Fact']['Sabado']+$General['Semana2Fact']['Lunes']+$General['Semana2Fact']['Martes']+$General['Semana2Fact']['Miercoles']+$General['Semana2Fact']['Jueves']+$General['Semana2Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($General['Semana2']['Sabado']) != (0) ? number_format($General['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Lunes']) != (0) ? number_format($General['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Martes']) != (0) ?number_format( $General['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Miercoles']) != (0) ? number_format($General['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Jueves']) != (0) ? number_format($General['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana2']['Viernes'] != ('0')) ?  number_format($General['Semana2']['Viernes'],2) : '-' ; ?> </td>
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
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana2']['Viernes']/$General['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                                                <td> <?php echo ($General['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $General['Semana3Ppto']['Sabado']+$General['Semana3Ppto']['Lunes']+$General['Semana3Ppto']['Martes']+$General['Semana3Ppto']['Miercoles']+$General['Semana3Ppto']['Jueves']+$General['Semana3Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana3Fact']['Sabado']) != (0) ? number_format($General['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Lunes']) != (0) ? number_format($General['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Martes']) != (0) ?number_format( $General['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Miercoles']) != (0) ? number_format($General['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Jueves']) != (0) ? number_format($General['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana3Fact']['Viernes'] != ('0')) ?  number_format($General['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana3Fact']['Sabado']+$General['Semana3Fact']['Lunes']+$General['Semana3Fact']['Martes']+$General['Semana3Fact']['Miercoles']+$General['Semana3Fact']['Jueves']+$General['Semana3Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana3']['Sabado']) != (0) ?  number_format($General['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Lunes']) != (0) ?  number_format($General['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Martes']) != (0) ?  number_format($General['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Miercoles']) != (0) ?  number_format($General['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Jueves']) != (0) ?  number_format($General['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana3']['Viernes'] != ('0')) ?   number_format($General['Semana3']['Viernes'],2) : '-' ; ?> </td>
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
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana3']['Viernes']/$General['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                                                <td> <?php echo ($General['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$General['Semana4Ppto']['Sabado']+$General['Semana4Ppto']['Lunes']+$General['Semana4Ppto']['Martes']+$General['Semana4Ppto']['Miercoles']+$General['Semana4Ppto']['Jueves']+$General['Semana4Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana4Fact']['Sabado']) != (0) ? number_format($General['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Lunes']) != (0) ? number_format($General['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Martes']) != (0) ?number_format( $General['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Miercoles']) != (0) ? number_format($General['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Jueves']) != (0) ? number_format($General['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana4Fact']['Viernes'] != ('0')) ?  number_format($General['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana4Fact']['Sabado']+$General['Semana4Fact']['Lunes']+$General['Semana4Fact']['Martes']+$General['Semana4Fact']['Miercoles']+$General['Semana4Fact']['Jueves']+$General['Semana4Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana4']['Sabado']) != (0) ?  number_format($General['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Lunes']) != (0) ?  number_format($General['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Martes']) != (0) ?  number_format($General['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Miercoles']) != (0) ?  number_format($General['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Jueves']) != (0) ?  number_format($General['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana4']['Viernes'] != ('0')) ?   number_format($General['Semana4']['Viernes'],2) : '-' ; ?> </td>
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
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana4']['Viernes']/$General['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                                                <td> <?php echo ($General['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$General['Semana5Ppto']['Sabado']+$General['Semana5Ppto']['Lunes']+$General['Semana5Ppto']['Martes']+$General['Semana5Ppto']['Miercoles']+$General['Semana5Ppto']['Jueves']+$General['Semana5Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$General['Semana5Fact']['Sabado']) != (0) ? number_format($General['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Lunes']) != (0) ? number_format($General['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Martes']) != (0) ?number_format( $General['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Miercoles']) != (0) ? number_format($General['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Jueves']) != (0) ? number_format($General['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$General['Semana5Fact']['Viernes'] != ('0')) ?  number_format($General['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $General['Semana5Fact']['Sabado']+$General['Semana5Fact']['Lunes']+$General['Semana5Fact']['Martes']+$General['Semana5Fact']['Miercoles']+$General['Semana5Fact']['Jueves']+$General['Semana5Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($General['Semana5']['Sabado']) != (0) ?  number_format($General['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Lunes']) != (0) ?  number_format($General['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Martes']) != (0) ?  number_format($General['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Miercoles']) != (0) ?  number_format($General['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Jueves']) != (0) ?  number_format($General['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($General['Semana5']['Viernes'] != ('0')) ?   number_format($General['Semana5']['Viernes'],2) : '-' ; ?> </td>
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
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$General['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($General['Semana5']['Viernes']/$General['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                    <!-- Inicia Region-->
                    <div class="panel-group col-sm-12">
                        <div class="panel panel-info ">
                            <div class="panel-heading">
                                <label style="margin-right: 80%">Region #1</label>  <label>Mes: <?= $MesActual;?>  </label>
                                
                            </div>
                            <div class="panel-body table-responsive">
                            
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#homee">Home</a></li>
                                <li><a data-toggle="tab" href="#menu11">Semana 1</a></li>
                                <li><a data-toggle="tab" href="#menu22">Semana 2</a></li>
                                <li><a data-toggle="tab" href="#menu33">Semana 3</a></li>
                                <li><a data-toggle="tab" href="#menu44">Semana 4</a></li>
                                <li><a data-toggle="tab" href="#menu55">Semana 5</a></li>
                             
                            </ul>

                            <div class="tab-content">
                                <div id="homee" class="tab-pane fade in active">
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
                                                <td><?= number_format($Region1['totalMesAnt'],2)?></td>
                                                        
                                                <?php 
                                                //print_r($semanas);
                                                for ($i=1; $i <=5 ; $i++) { 
                                                    if (isset($Region1['semanas'][$i])) {
                                                    echo "<td>".number_format($Region1['semanas'][$i],2)."</td>";
                                                    }else{
                                                        $Region1['semanas'][$i]=0.00;
                                                }
                                                }  ?>
                                               
                                                <td><?= number_format($Region1['totalMesAct'],2)?></td>
                                                <td><?= number_format($Region1['totalAcumulado'],2)?></td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td><?= number_format($Region1['Acolocado'],2)?></td>
                                                <td><?= number_format($Region1['colocadosem1'],2)?></td>
                                                <td><?= number_format($Region1['colocadosem2'],2)?></td>
                                                <td><?= number_format($Region1['colocadosem3'],2)?></td>
                                                <td><?= number_format($Region1['colocadosem4'],2)?></td>
                                                <td><?= number_format($Region1['colocadosem5'],2)?></td>
                                                <td><?= number_format($Region1['acumcolocado']=$Region1['colocadosem1']+$Region1['colocadosem2']+$Region1['colocadosem3']+$Region1['colocadosem4']+$Region1['colocadosem5'],2)?></td>
                                                <td><?= number_format($Region1['totalcolocado']=$Region1['acumcolocado']+$Region1['Acolocado'],2)?></td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Deudas</th>
                                            <td><?=number_format(@$Region1['Acolocado']-$Region1['totalMesAnt'],2)?></td>
                                                <td><?=number_format(@$Region1['colocadosem1']-$Region1['semanas'][1],2)?></td>
                                                <td><?=number_format(@$Region1['colocadosem2']-$Region1['semanas'][2],2)?></td>
                                                <td><?=number_format(@$Region1['colocadosem3']-$Region1['semanas'][3],2)?></td>
                                                <td><?=number_format(@$Region1['colocadosem4']-$Region1['semanas'][4],2)?></td>
                                                <td><?=number_format(@$Region1['colocadosem5']-$Region1['semanas'][5],2)?></td>
                                                <td><?=number_format(@$Region1['acumcolocado']-$Region1['totalMesAct'],2)?></td>
                                                <td><?=number_format(@$Region1['totalcolocado']-$Region1['totalAcumulado'],2)?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu11" class="tab-pane fade">
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
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Sabado']) != (0) ? number_format($Region1['Semana1Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Lunes']) != (0) ? number_format($Region1['Semana1Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Martes']) != (0) ?number_format( $Region1['Semana1Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana1Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Jueves']) != (0) ? number_format($Region1['Semana1Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $Region1['Semana1Ppto']['Sabado']+$Region1['Semana1Ppto']['Lunes']+$Region1['Semana1Ppto']['Martes']+$Region1['Semana1Ppto']['Miercoles']+$Region1['Semana1Ppto']['Jueves']+$Region1['Semana1Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Sabado']) != (0) ? number_format($Region1['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Lunes']) != (0) ? number_format($Region1['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Martes']) != (0) ?number_format( $Region1['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Miercoles']) != (0) ? number_format($Region1['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Jueves']) != (0) ? number_format($Region1['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana1Fact']['Viernes'] != ('0')) ?  number_format($Region1['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $Region1['Semana1Fact']['Sabado']+$Region1['Semana1Fact']['Lunes']+$Region1['Semana1Fact']['Martes']+$Region1['Semana1Fact']['Miercoles']+$Region1['Semana1Fact']['Jueves']+$Region1['Semana1Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($Region1['Semana1']['Sabado']) != (0) ? number_format($Region1['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana1']['Lunes']) != (0) ? number_format($Region1['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana1']['Martes']) != (0) ?number_format( $Region1['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana1']['Miercoles']) != (0) ? number_format($Region1['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana1']['Jueves']) != (0) ? number_format($Region1['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana1']['Viernes'] != ('0')) ?  number_format($Region1['Semana1']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($dese =$Region1['Semana1']['Sabado']+$Region1['Semana1']['Lunes']+$Region1['Semana1']['Martes']+$Region1['Semana1']['Miercoles']+$Region1['Semana1']['Jueves']+$Region1['Semana1']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($Region1['Semana1']['Sabado']-$Region1['Semana1Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Lunes']-$Region1['Semana1']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Martes']-$Region1['Semana1Fact']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Miercoles']-$Region1['Semana1Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Jueves']-$Region1['Semana1Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana1']['Viernes']-$Region1['Semana1Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>
                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($Region1['Semana1']['Sabado']-$Region1['Semana1Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Lunes']-$Region1['Semana1Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Martes']-$Region1['Semana1Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Miercoles']-$Region1['Semana1Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana1']['Jueves']-$Region1['Semana1Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana1']['Viernes']-$Region1['Semana1Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$Region1['Semana1Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region1['Semana1']['Sabado']/$Region1['Semana1Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$Region1['Semana1Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region1['Semana1']['Lunes']/$Region1['Semana1Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$Region1['Semana1Ppto']['Martes']) != (0) ? $s[3] = number_format($Region1['Semana1']['Martes']/$Region1['Semana1Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$Region1['Semana1Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region1['Semana1']['Miercoles']/$Region1['Semana1Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$Region1['Semana1Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region1['Semana1']['Jueves']/$Region1['Semana1Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$Region1['Semana1Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region1['Semana1']['Viernes']/$Region1['Semana1Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region1['Semana1Ppto']['Sabado']) != (0) ? number_format($Region1['Semana1']['Sabado']/$Region1['Semana1Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region1['Semana1Ppto']['Lunes']) != (0) ? number_format($Region1['Semana1']['Lunes']/$Region1['Semana1Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region1['Semana1Ppto']['Martes']) != (0) ?number_format( $Region1['Semana1']['Martes']/$Region1['Semana1Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region1['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana1']['Miercoles']/$Region1['Semana1Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region1['Semana1Ppto']['Jueves']) != (0) ? number_format($Region1['Semana1']['Jueves']/$Region1['Semana1Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region1['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana1']['Viernes']/$Region1['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu22" class="tab-pane fade">
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
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Sabado']) != (0) ? number_format($Region1['Semana2Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Lunes']) != (0) ? number_format($Region1['Semana2Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Martes']) != (0) ?number_format( $Region1['Semana2Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana2Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Jueves']) != (0) ? number_format($Region1['Semana2Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $Region1['Semana2Ppto']['Sabado']+$Region1['Semana2Ppto']['Lunes']+$Region1['Semana2Ppto']['Martes']+$Region1['Semana2Ppto']['Miercoles']+$Region1['Semana2Ppto']['Jueves']+$Region1['Semana2Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Sabado']) != (0) ? number_format($Region1['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Lunes']) != (0) ? number_format($Region1['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Martes']) != (0) ?number_format( $Region1['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Miercoles']) != (0) ? number_format($Region1['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Jueves']) != (0) ? number_format($Region1['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana2Fact']['Viernes'] != ('0')) ?  number_format($Region1['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $Region1['Semana2Fact']['Sabado']+$Region1['Semana2Fact']['Lunes']+$Region1['Semana2Fact']['Martes']+$Region1['Semana2Fact']['Miercoles']+$Region1['Semana2Fact']['Jueves']+$Region1['Semana2Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolsado</th>
                                                <td> <?php echo ($Region1['Semana2']['Sabado']) != (0) ? number_format($Region1['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana2']['Lunes']) != (0) ? number_format($Region1['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana2']['Martes']) != (0) ?number_format( $Region1['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana2']['Miercoles']) != (0) ? number_format($Region1['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana2']['Jueves']) != (0) ? number_format($Region1['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana2']['Viernes'] != ('0')) ?  number_format($Region1['Semana2']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($dese =$Region1['Semana2']['Sabado']+$Region1['Semana2']['Lunes']+$Region1['Semana2']['Martes']+$Region1['Semana2']['Miercoles']+$Region1['Semana2']['Jueves']+$Region1['Semana2']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($Region1['Semana2']['Sabado']-$Region1['Semana2Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Lunes']-$Region1['Semana2']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Martes']-$Region1['Semana2Fact']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Miercoles']-$Region1['Semana2Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Jueves']-$Region1['Semana2Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana2']['Viernes']-$Region1['Semana2Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>
                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($Region1['Semana2']['Sabado']-$Region1['Semana2Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Lunes']-$Region1['Semana2Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Martes']-$Region1['Semana2Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Miercoles']-$Region1['Semana2Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana2']['Jueves']-$Region1['Semana2Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana2']['Viernes']-$Region1['Semana2Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$Region1['Semana2Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region1['Semana2']['Sabado']/$Region1['Semana2Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$Region1['Semana2Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region1['Semana2']['Lunes']/$Region1['Semana2Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$Region1['Semana2Ppto']['Martes']) != (0) ? $s[3] = number_format($Region1['Semana2']['Martes']/$Region1['Semana2Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$Region1['Semana2Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region1['Semana2']['Miercoles']/$Region1['Semana2Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$Region1['Semana2Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region1['Semana2']['Jueves']/$Region1['Semana2Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$Region1['Semana2Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region1['Semana2']['Viernes']/$Region1['Semana2Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region1['Semana2Ppto']['Sabado']) != (0) ? number_format($Region1['Semana2']['Sabado']/$Region1['Semana2Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region1['Semana2Ppto']['Lunes']) != (0) ? number_format($Region1['Semana2']['Lunes']/$Region1['Semana2Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region1['Semana2Ppto']['Martes']) != (0) ?number_format( $Region1['Semana2']['Martes']/$Region1['Semana2Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region1['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana2']['Miercoles']/$Region1['Semana2Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region1['Semana2Ppto']['Jueves']) != (0) ? number_format($Region1['Semana2']['Jueves']/$Region1['Semana2Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region1['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana2']['Viernes']/$Region1['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu33" class="tab-pane fade">
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
                                                <td> <?php echo ($Region1['Semana3Ppto']['Sabado']) != (0) ? number_format($Region1['Semana3Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3Ppto']['Lunes']) != (0) ? number_format($Region1['Semana3Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3Ppto']['Martes']) != (0) ?number_format( $Region1['Semana3Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana3Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3Ppto']['Jueves']) != (0) ? number_format($Region1['Semana3Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto = $Region1['Semana3Ppto']['Sabado']+$Region1['Semana3Ppto']['Lunes']+$Region1['Semana3Ppto']['Martes']+$Region1['Semana3Ppto']['Miercoles']+$Region1['Semana3Ppto']['Jueves']+$Region1['Semana3Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Sabado']) != (0) ? number_format($Region1['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Lunes']) != (0) ? number_format($Region1['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Martes']) != (0) ?number_format( $Region1['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Miercoles']) != (0) ? number_format($Region1['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Jueves']) != (0) ? number_format($Region1['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana3Fact']['Viernes'] != ('0')) ?  number_format($Region1['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $Region1['Semana3Fact']['Sabado']+$Region1['Semana3Fact']['Lunes']+$Region1['Semana3Fact']['Martes']+$Region1['Semana3Fact']['Miercoles']+$Region1['Semana3Fact']['Jueves']+$Region1['Semana3Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($Region1['Semana3']['Sabado']) != (0) ?  number_format($Region1['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3']['Lunes']) != (0) ?  number_format($Region1['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3']['Martes']) != (0) ?  number_format($Region1['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3']['Miercoles']) != (0) ?  number_format($Region1['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3']['Jueves']) != (0) ?  number_format($Region1['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana3']['Viernes'] != ('0')) ?   number_format($Region1['Semana3']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $Region1['Semana3']['Sabado']+$Region1['Semana3']['Lunes']+$Region1['Semana3']['Martes']+$Region1['Semana3']['Miercoles']+$Region1['Semana3']['Jueves']+$Region1['Semana3']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($Region1['Semana3']['Sabado']-$Region1['Semana3Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Lunes']-$Region1['Semana3Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Martes']-$Region1['Semana3Fact']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Miercoles']-$Region1['Semana3Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Jueves']-$Region1['Semana3Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana3']['Viernes']-$Region1['Semana3Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($Region1['Semana3']['Sabado']-$Region1['Semana3Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Lunes']-$Region1['Semana3Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Martes']-$Region1['Semana3Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Miercoles']-$Region1['Semana3Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana3']['Jueves']-$Region1['Semana3Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana3']['Viernes']-$Region1['Semana3Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$Region1['Semana3Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region1['Semana3']['Sabado']/$Region1['Semana3Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$Region1['Semana3Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region1['Semana3']['Lunes']/$Region1['Semana3Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$Region1['Semana3Ppto']['Martes']) != (0) ? $s[3] = number_format($Region1['Semana3']['Martes']/$Region1['Semana3Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$Region1['Semana3Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region1['Semana3']['Miercoles']/$Region1['Semana3Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$Region1['Semana3Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region1['Semana3']['Jueves']/$Region1['Semana3Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$Region1['Semana3Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region1['Semana3']['Viernes']/$Region1['Semana3Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region1['Semana3Ppto']['Sabado']) != (0) ? number_format($Region1['Semana3']['Sabado']/$Region1['Semana3Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region1['Semana3Ppto']['Lunes']) != (0) ? number_format($Region1['Semana3']['Lunes']/$Region1['Semana3Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region1['Semana3Ppto']['Martes']) != (0) ?number_format( $Region1['Semana3']['Martes']/$Region1['Semana3Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region1['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana3']['Miercoles']/$Region1['Semana3Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region1['Semana3Ppto']['Jueves']) != (0) ? number_format($Region1['Semana3']['Jueves']/$Region1['Semana3Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region1['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana3']['Viernes']/$Region1['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu44" class="tab-pane fade">
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
                                                <td> <?php echo ($Region1['Semana4Ppto']['Sabado']) != (0) ? number_format($Region1['Semana4Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4Ppto']['Lunes']) != (0) ? number_format($Region1['Semana4Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4Ppto']['Martes']) != (0) ?number_format( $Region1['Semana4Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana4Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4Ppto']['Jueves']) != (0) ? number_format($Region1['Semana4Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$Region1['Semana4Ppto']['Sabado']+$Region1['Semana4Ppto']['Lunes']+$Region1['Semana4Ppto']['Martes']+$Region1['Semana4Ppto']['Miercoles']+$Region1['Semana4Ppto']['Jueves']+$Region1['Semana4Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Sabado']) != (0) ? number_format($Region1['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Lunes']) != (0) ? number_format($Region1['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Martes']) != (0) ?number_format( $Region1['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Miercoles']) != (0) ? number_format($Region1['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Jueves']) != (0) ? number_format($Region1['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana4Fact']['Viernes'] != ('0')) ?  number_format($Region1['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $Region1['Semana4Fact']['Sabado']+$Region1['Semana4Fact']['Lunes']+$Region1['Semana4Fact']['Martes']+$Region1['Semana4Fact']['Miercoles']+$Region1['Semana4Fact']['Jueves']+$Region1['Semana4Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($Region1['Semana4']['Sabado']) != (0) ?  number_format($Region1['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4']['Lunes']) != (0) ?  number_format($Region1['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4']['Martes']) != (0) ?  number_format($Region1['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4']['Miercoles']) != (0) ?  number_format($Region1['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4']['Jueves']) != (0) ?  number_format($Region1['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana4']['Viernes'] != ('0')) ?   number_format($Region1['Semana4']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $Region1['Semana4']['Sabado']+$Region1['Semana4']['Lunes']+$Region1['Semana4']['Martes']+$Region1['Semana4']['Miercoles']+$Region1['Semana4']['Jueves']+$Region1['Semana4']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($Region1['Semana4']['Sabado']-$Region1['Semana4Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Lunes']-$Region1['Semana4Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Martes']-$Region1['Semana4Fact']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Miercoles']-$Region1['Semana4Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Jueves']-$Region1['Semana4Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana4']['Viernes']-$Region1['Semana4Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($Region1['Semana4']['Sabado']-$Region1['Semana4Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Lunes']-$Region1['Semana4Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Martes']-$Region1['Semana4Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Miercoles']-$Region1['Semana4Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana4']['Jueves']-$Region1['Semana4Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana4']['Viernes']-$Region1['Semana4Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$Region1['Semana4Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region1['Semana4']['Sabado']/$Region1['Semana4Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$Region1['Semana4Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region1['Semana4']['Lunes']/$Region1['Semana4Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$Region1['Semana4Ppto']['Martes']) != (0) ? $s[3] = number_format($Region1['Semana4']['Martes']/$Region1['Semana4Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$Region1['Semana4Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region1['Semana4']['Miercoles']/$Region1['Semana4Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$Region1['Semana4Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region1['Semana4']['Jueves']/$Region1['Semana4Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$Region1['Semana4Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region1['Semana4']['Viernes']/$Region1['Semana4Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region1['Semana4Ppto']['Sabado']) != (0) ? number_format($Region1['Semana4']['Sabado']/$Region1['Semana4Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region1['Semana4Ppto']['Lunes']) != (0) ? number_format($Region1['Semana4']['Lunes']/$Region1['Semana4Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region1['Semana4Ppto']['Martes']) != (0) ?number_format( $Region1['Semana4']['Martes']/$Region1['Semana4Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region1['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana4']['Miercoles']/$Region1['Semana4Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region1['Semana4Ppto']['Jueves']) != (0) ? number_format($Region1['Semana4']['Jueves']/$Region1['Semana4Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region1['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana4']['Viernes']/$Region1['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div id="menu55" class="tab-pane fade">
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
                                                <td> <?php echo ($Region1['Semana5Ppto']['Sabado']) != (0) ? number_format($Region1['Semana5Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5Ppto']['Lunes']) != (0) ? number_format($Region1['Semana5Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5Ppto']['Martes']) != (0) ?number_format( $Region1['Semana5Ppto']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana5Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5Ppto']['Jueves']) != (0) ? number_format($Region1['Semana5Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($ppto =$Region1['Semana5Ppto']['Sabado']+$Region1['Semana5Ppto']['Lunes']+$Region1['Semana5Ppto']['Martes']+$Region1['Semana5Ppto']['Miercoles']+$Region1['Semana5Ppto']['Jueves']+$Region1['Semana5Ppto']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Factibilidad (A Desembolsar)</th>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Sabado']) != (0) ? number_format($Region1['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Lunes']) != (0) ? number_format($Region1['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Martes']) != (0) ?number_format( $Region1['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Miercoles']) != (0) ? number_format($Region1['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Jueves']) != (0) ? number_format($Region1['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo (@$Region1['Semana5Fact']['Viernes'] != ('0')) ?  number_format($Region1['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?= number_format($presu = $Region1['Semana5Fact']['Sabado']+$Region1['Semana5Fact']['Lunes']+$Region1['Semana5Fact']['Martes']+$Region1['Semana5Fact']['Miercoles']+$Region1['Semana5Fact']['Jueves']+$Region1['Semana5Fact']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Desembolso</th>
                                                <td> <?php echo ($Region1['Semana5']['Sabado']) != (0) ?  number_format($Region1['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5']['Lunes']) != (0) ?  number_format($Region1['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5']['Martes']) != (0) ?  number_format($Region1['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5']['Miercoles']) != (0) ?  number_format($Region1['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5']['Jueves']) != (0) ?  number_format($Region1['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                <td> <?php echo ($Region1['Semana5']['Viernes'] != ('0')) ?   number_format($Region1['Semana5']['Viernes'],2) : '-' ; ?> </td>
                                                <td> <?=  number_format($dese = $Region1['Semana5']['Sabado']+$Region1['Semana5']['Lunes']+$Region1['Semana5']['Martes']+$Region1['Semana5']['Miercoles']+$Region1['Semana5']['Jueves']+$Region1['Semana5']['Viernes'],2) ?> </td>
                                            </tr>
                                            <tr>
                                            <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                <td><?=number_format($Region1['Semana5']['Sabado']-$Region1['Semana5Fact']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Lunes']-$Region1['Semana5Fact']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Martes']-$Region1['Semana5Fact']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Miercoles']-$Region1['Semana5Fact']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Jueves']-$Region1['Semana5Fact']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana5']['Viernes']-$Region1['Semana5Fact']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$presu,2)?></td>
                                            </tr>

                                            <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                <td><?=number_format($Region1['Semana5']['Sabado']-$Region1['Semana5Ppto']['Sabado'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Lunes']-$Region1['Semana5Ppto']['Lunes'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Martes']-$Region1['Semana5Ppto']['Martes'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Miercoles']-$Region1['Semana5Ppto']['Miercoles'],2)?></td>
                                                <td><?=number_format($Region1['Semana5']['Jueves']-$Region1['Semana5Ppto']['Jueves'],2)?></td>

                                                <td><?=number_format($Region1['Semana5']['Viernes']-$Region1['Semana5Ppto']['Viernes'],2)?></td>
                                                <td><?=number_format($dese-$ppto,2)?></td>
                                            </tr>

                                            <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                <!-- INICIO color indicador -->
                                                    <?php $indicadorColor[0] = "bg-success";?>
                                                    <?php
                                                    (@$Region1['Semana5Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region1['Semana5']['Sabado']/$Region1['Semana5Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                    (@$Region1['Semana5Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region1['Semana5']['Lunes']/$Region1['Semana5Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                    (@$Region1['Semana5Ppto']['Martes']) != (0) ? $s[3] = number_format($Region1['Semana5']['Martes']/$Region1['Semana5Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                    (@$Region1['Semana5Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region1['Semana5']['Miercoles']/$Region1['Semana5Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                    (@$Region1['Semana5Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region1['Semana5']['Jueves']/$Region1['Semana5Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                    (@$Region1['Semana5Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region1['Semana5']['Viernes']/$Region1['Semana5Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region1['Semana5Ppto']['Sabado']) != (0) ? number_format($Region1['Semana5']['Sabado']/$Region1['Semana5Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region1['Semana5Ppto']['Lunes']) != (0) ? number_format($Region1['Semana5']['Lunes']/$Region1['Semana5Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region1['Semana5Ppto']['Martes']) != (0) ?number_format( $Region1['Semana5']['Martes']/$Region1['Semana5Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region1['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region1['Semana5']['Miercoles']/$Region1['Semana5Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region1['Semana5Ppto']['Jueves']) != (0) ? number_format($Region1['Semana5']['Jueves']/$Region1['Semana5Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region1['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region1['Semana5']['Viernes']/$Region1['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                            
                                                <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                    <!-- Inicia Region-->
                        <div class="panel-group col-sm-12">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <label style="margin-right: 80%">Region #3</label>  <label>Mes: <?= $MesActual;?>  </label>
                                    
                                </div>
                                <div class="panel-body table-responsive">
                                
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#homeee">Home</a></li>
                                    <li><a data-toggle="tab" href="#menu111">Semana 1</a></li>
                                    <li><a data-toggle="tab" href="#menu222">Semana 2</a></li>
                                    <li><a data-toggle="tab" href="#menu333">Semana 3</a></li>
                                    <li><a data-toggle="tab" href="#menu444">Semana 4</a></li>
                                    <li><a data-toggle="tab" href="#menu555">Semana 5</a></li>
                                  
                                </ul>

                                <div class="tab-content">
                                    <div id="homeee" class="tab-pane fade in active">
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
                                                    <td><?= number_format($Region2['totalMesAnt'],2)?></td>
                                                            
                                                    <?php 
                                                    //print_r($semanas);
                                                    for ($i=1; $i <=5 ; $i++) { 
                                                        if (isset($Region2['semanas'][$i])) {
                                                        echo "<td>".number_format($Region2['semanas'][$i],2)."</td>";
                                                        }else{
                                                            $Region2['semanas'][$i]=0.00;
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
                                                    <td><?= number_format($Region2['totalMesAct'],2)?></td>
                                                    <td><?= number_format($Region2['totalAcumulado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td><?= number_format($Region2['Acolocado'],2)?></td>
                                                    <td><?= number_format($Region2['colocadosem1'],2)?></td>
                                                    <td><?= number_format($Region2['colocadosem2'],2)?></td>
                                                    <td><?= number_format($Region2['colocadosem3'],2)?></td>
                                                    <td><?= number_format($Region2['colocadosem4'],2)?></td>
                                                    <td><?= number_format($Region2['colocadosem5'],2)?></td>
                                                    <td><?= number_format($Region2['acumcolocado']=$Region2['colocadosem1']+$Region2['colocadosem2']+$Region2['colocadosem3']+$Region2['colocadosem4']+$Region2['colocadosem5'],2)?></td>
                                                    <td><?= number_format($Region2['totalcolocado']=$Region2['acumcolocado']+$Region2['Acolocado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Deudas</th>
                                                <td><?=number_format(@$Region2['Acolocado']-$Region2['totalMesAnt'],2)?></td>
                                                    <td><?=number_format(@$Region2['colocadosem1']-$Region2['semanas'][1],2)?></td>
                                                    <td><?=number_format(@$Region2['colocadosem2']-$Region2['semanas'][2],2)?></td>
                                                    <td><?=number_format(@$Region2['colocadosem3']-$Region2['semanas'][3],2)?></td>
                                                    <td><?=number_format(@$Region2['colocadosem4']-$Region2['semanas'][4],2)?></td>
                                                    <td><?=number_format(@$Region2['colocadosem5']-$Region2['semanas'][5],2)?></td>
                                                    <td><?=number_format(@$Region2['acumcolocado']-$Region2['totalMesAct'],2)?></td>
                                                    <td><?=number_format(@$Region2['totalcolocado']-$Region2['totalAcumulado'],2)?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu111" class="tab-pane fade">
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
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Sabado']) != (0) ? number_format($Region2['Semana1Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Lunes']) != (0) ? number_format($Region2['Semana1Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Martes']) != (0) ?number_format( $Region2['Semana1Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana1Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Jueves']) != (0) ? number_format($Region2['Semana1Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region2['Semana1Ppto']['Sabado']+$Region2['Semana1Ppto']['Lunes']+$Region2['Semana1Ppto']['Martes']+$Region2['Semana1Ppto']['Miercoles']+$Region2['Semana1Ppto']['Jueves']+$Region2['Semana1Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Sabado']) != (0) ? number_format($Region2['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Lunes']) != (0) ? number_format($Region2['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Martes']) != (0) ?number_format( $Region2['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Miercoles']) != (0) ? number_format($Region2['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Jueves']) != (0) ? number_format($Region2['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana1Fact']['Viernes'] != ('0')) ?  number_format($Region2['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region2['Semana1Fact']['Sabado']+$Region2['Semana1Fact']['Lunes']+$Region2['Semana1Fact']['Martes']+$Region2['Semana1Fact']['Miercoles']+$Region2['Semana1Fact']['Jueves']+$Region2['Semana1Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo ($Region2['Semana1']['Sabado']) != (0) ? number_format($Region2['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana1']['Lunes']) != (0) ? number_format($Region2['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana1']['Martes']) != (0) ?number_format( $Region2['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana1']['Miercoles']) != (0) ? number_format($Region2['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana1']['Jueves']) != (0) ? number_format($Region2['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana1']['Viernes'] != ('0')) ?  number_format($Region2['Semana1']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =$Region2['Semana1']['Sabado']+$Region2['Semana1']['Lunes']+$Region2['Semana1']['Martes']+$Region2['Semana1']['Miercoles']+$Region2['Semana1']['Jueves']+$Region2['Semana1']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region2['Semana1']['Sabado']-$Region2['Semana1Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Lunes']-$Region2['Semana1']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Martes']-$Region2['Semana1Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Miercoles']-$Region2['Semana1Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Jueves']-$Region2['Semana1Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana1']['Viernes']-$Region2['Semana1Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region2['Semana1']['Sabado']-$Region2['Semana1Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Lunes']-$Region2['Semana1Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Martes']-$Region2['Semana1Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Miercoles']-$Region2['Semana1Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana1']['Jueves']-$Region2['Semana1Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana1']['Viernes']-$Region2['Semana1Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region2['Semana1Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region2['Semana1']['Sabado']/$Region2['Semana1Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region2['Semana1Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region2['Semana1']['Lunes']/$Region2['Semana1Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region2['Semana1Ppto']['Martes']) != (0) ? $s[3] = number_format($Region2['Semana1']['Martes']/$Region2['Semana1Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region2['Semana1Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region2['Semana1']['Miercoles']/$Region2['Semana1Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region2['Semana1Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region2['Semana1']['Jueves']/$Region2['Semana1Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region2['Semana1Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region2['Semana1']['Viernes']/$Region2['Semana1Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region2['Semana1Ppto']['Sabado']) != (0) ? number_format($Region2['Semana1']['Sabado']/$Region2['Semana1Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region2['Semana1Ppto']['Lunes']) != (0) ? number_format($Region2['Semana1']['Lunes']/$Region2['Semana1Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region2['Semana1Ppto']['Martes']) != (0) ?number_format( $Region2['Semana1']['Martes']/$Region2['Semana1Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region2['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana1']['Miercoles']/$Region2['Semana1Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region2['Semana1Ppto']['Jueves']) != (0) ? number_format($Region2['Semana1']['Jueves']/$Region2['Semana1Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region2['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana1']['Viernes']/$Region2['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu222" class="tab-pane fade">
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
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Sabado']) != (0) ? number_format($Region2['Semana2Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Lunes']) != (0) ? number_format($Region2['Semana2Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Martes']) != (0) ?number_format( $Region2['Semana2Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana2Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Jueves']) != (0) ? number_format($Region2['Semana2Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region2['Semana2Ppto']['Sabado']+$Region2['Semana2Ppto']['Lunes']+$Region2['Semana2Ppto']['Martes']+$Region2['Semana2Ppto']['Miercoles']+$Region2['Semana2Ppto']['Jueves']+$Region2['Semana2Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Sabado']) != (0) ? number_format($Region2['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Lunes']) != (0) ? number_format($Region2['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Martes']) != (0) ?number_format( $Region2['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Miercoles']) != (0) ? number_format($Region2['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Jueves']) != (0) ? number_format($Region2['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana2Fact']['Viernes'] != ('0')) ?  number_format($Region2['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region2['Semana2Fact']['Sabado']+$Region2['Semana2Fact']['Lunes']+$Region2['Semana2Fact']['Martes']+$Region2['Semana2Fact']['Miercoles']+$Region2['Semana2Fact']['Jueves']+$Region2['Semana2Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo ($Region2['Semana2']['Sabado']) != (0) ? number_format($Region2['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana2']['Lunes']) != (0) ? number_format($Region2['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana2']['Martes']) != (0) ?number_format( $Region2['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana2']['Miercoles']) != (0) ? number_format($Region2['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana2']['Jueves']) != (0) ? number_format($Region2['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana2']['Viernes'] != ('0')) ?  number_format($Region2['Semana2']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =$Region2['Semana2']['Sabado']+$Region2['Semana2']['Lunes']+$Region2['Semana2']['Martes']+$Region2['Semana2']['Miercoles']+$Region2['Semana2']['Jueves']+$Region2['Semana2']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region2['Semana2']['Sabado']-$Region2['Semana2Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Lunes']-$Region2['Semana2']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Martes']-$Region2['Semana2Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Miercoles']-$Region2['Semana2Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Jueves']-$Region2['Semana2Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana2']['Viernes']-$Region2['Semana2Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region2['Semana2']['Sabado']-$Region2['Semana2Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Lunes']-$Region2['Semana2Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Martes']-$Region2['Semana2Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Miercoles']-$Region2['Semana2Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana2']['Jueves']-$Region2['Semana2Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana2']['Viernes']-$Region2['Semana2Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region2['Semana2Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region2['Semana2']['Sabado']/$Region2['Semana2Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region2['Semana2Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region2['Semana2']['Lunes']/$Region2['Semana2Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region2['Semana2Ppto']['Martes']) != (0) ? $s[3] = number_format($Region2['Semana2']['Martes']/$Region2['Semana2Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region2['Semana2Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region2['Semana2']['Miercoles']/$Region2['Semana2Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region2['Semana2Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region2['Semana2']['Jueves']/$Region2['Semana2Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region2['Semana2Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region2['Semana2']['Viernes']/$Region2['Semana2Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region2['Semana2Ppto']['Sabado']) != (0) ? number_format($Region2['Semana2']['Sabado']/$Region2['Semana2Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region2['Semana2Ppto']['Lunes']) != (0) ? number_format($Region2['Semana2']['Lunes']/$Region2['Semana2Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region2['Semana2Ppto']['Martes']) != (0) ?number_format( $Region2['Semana2']['Martes']/$Region2['Semana2Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region2['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana2']['Miercoles']/$Region2['Semana2Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region2['Semana2Ppto']['Jueves']) != (0) ? number_format($Region2['Semana2']['Jueves']/$Region2['Semana2Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region2['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana2']['Viernes']/$Region2['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu333" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Sabado']) != (0) ? number_format($Region2['Semana3Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Lunes']) != (0) ? number_format($Region2['Semana3Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Martes']) != (0) ?number_format( $Region2['Semana3Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana3Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Jueves']) != (0) ? number_format($Region2['Semana3Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region2['Semana3Ppto']['Sabado']+$Region2['Semana3Ppto']['Lunes']+$Region2['Semana3Ppto']['Martes']+$Region2['Semana3Ppto']['Miercoles']+$Region2['Semana3Ppto']['Jueves']+$Region2['Semana3Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Sabado']) != (0) ? number_format($Region2['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Lunes']) != (0) ? number_format($Region2['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Martes']) != (0) ?number_format( $Region2['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Miercoles']) != (0) ? number_format($Region2['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Jueves']) != (0) ? number_format($Region2['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana3Fact']['Viernes'] != ('0')) ?  number_format($Region2['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region2['Semana3Fact']['Sabado']+$Region2['Semana3Fact']['Lunes']+$Region2['Semana3Fact']['Martes']+$Region2['Semana3Fact']['Miercoles']+$Region2['Semana3Fact']['Jueves']+$Region2['Semana3Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region2['Semana3']['Sabado']) != (0) ?  number_format($Region2['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3']['Lunes']) != (0) ?  number_format($Region2['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3']['Martes']) != (0) ?  number_format($Region2['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3']['Miercoles']) != (0) ?  number_format($Region2['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3']['Jueves']) != (0) ?  number_format($Region2['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana3']['Viernes'] != ('0')) ?   number_format($Region2['Semana3']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region2['Semana3']['Sabado']+$Region2['Semana3']['Lunes']+$Region2['Semana3']['Martes']+$Region2['Semana3']['Miercoles']+$Region2['Semana3']['Jueves']+$Region2['Semana3']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region2['Semana3']['Sabado']-$Region2['Semana3Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Lunes']-$Region2['Semana3Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Martes']-$Region2['Semana3Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Miercoles']-$Region2['Semana3Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Jueves']-$Region2['Semana3Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana3']['Viernes']-$Region2['Semana3Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region2['Semana3']['Sabado']-$Region2['Semana3Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Lunes']-$Region2['Semana3Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Martes']-$Region2['Semana3Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Miercoles']-$Region2['Semana3Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana3']['Jueves']-$Region2['Semana3Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana3']['Viernes']-$Region2['Semana3Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region2['Semana3Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region2['Semana3']['Sabado']/$Region2['Semana3Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region2['Semana3Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region2['Semana3']['Lunes']/$Region2['Semana3Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region2['Semana3Ppto']['Martes']) != (0) ? $s[3] = number_format($Region2['Semana3']['Martes']/$Region2['Semana3Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region2['Semana3Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region2['Semana3']['Miercoles']/$Region2['Semana3Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region2['Semana3Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region2['Semana3']['Jueves']/$Region2['Semana3Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region2['Semana3Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region2['Semana3']['Viernes']/$Region2['Semana3Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region2['Semana3Ppto']['Sabado']) != (0) ? number_format($Region2['Semana3']['Sabado']/$Region2['Semana3Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region2['Semana3Ppto']['Lunes']) != (0) ? number_format($Region2['Semana3']['Lunes']/$Region2['Semana3Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region2['Semana3Ppto']['Martes']) != (0) ?number_format( $Region2['Semana3']['Martes']/$Region2['Semana3Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region2['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana3']['Miercoles']/$Region2['Semana3Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region2['Semana3Ppto']['Jueves']) != (0) ? number_format($Region2['Semana3']['Jueves']/$Region2['Semana3Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region2['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana3']['Viernes']/$Region2['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu444" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Sabado']) != (0) ? number_format($Region2['Semana4Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Lunes']) != (0) ? number_format($Region2['Semana4Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Martes']) != (0) ?number_format( $Region2['Semana4Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana4Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Jueves']) != (0) ? number_format($Region2['Semana4Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =$Region2['Semana4Ppto']['Sabado']+$Region2['Semana4Ppto']['Lunes']+$Region2['Semana4Ppto']['Martes']+$Region2['Semana4Ppto']['Miercoles']+$Region2['Semana4Ppto']['Jueves']+$Region2['Semana4Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Sabado']) != (0) ? number_format($Region2['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Lunes']) != (0) ? number_format($Region2['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Martes']) != (0) ?number_format( $Region2['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Miercoles']) != (0) ? number_format($Region2['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Jueves']) != (0) ? number_format($Region2['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana4Fact']['Viernes'] != ('0')) ?  number_format($Region2['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region2['Semana4Fact']['Sabado']+$Region2['Semana4Fact']['Lunes']+$Region2['Semana4Fact']['Martes']+$Region2['Semana4Fact']['Miercoles']+$Region2['Semana4Fact']['Jueves']+$Region2['Semana4Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region2['Semana4']['Sabado']) != (0) ?  number_format($Region2['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4']['Lunes']) != (0) ?  number_format($Region2['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4']['Martes']) != (0) ?  number_format($Region2['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4']['Miercoles']) != (0) ?  number_format($Region2['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4']['Jueves']) != (0) ?  number_format($Region2['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana4']['Viernes'] != ('0')) ?   number_format($Region2['Semana4']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region2['Semana4']['Sabado']+$Region2['Semana4']['Lunes']+$Region2['Semana4']['Martes']+$Region2['Semana4']['Miercoles']+$Region2['Semana4']['Jueves']+$Region2['Semana4']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region2['Semana4']['Sabado']-$Region2['Semana4Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Lunes']-$Region2['Semana4Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Martes']-$Region2['Semana4Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Miercoles']-$Region2['Semana4Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Jueves']-$Region2['Semana4Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana4']['Viernes']-$Region2['Semana4Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region2['Semana4']['Sabado']-$Region2['Semana4Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Lunes']-$Region2['Semana4Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Martes']-$Region2['Semana4Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Miercoles']-$Region2['Semana4Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana4']['Jueves']-$Region2['Semana4Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana4']['Viernes']-$Region2['Semana4Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region2['Semana4Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region2['Semana4']['Sabado']/$Region2['Semana4Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region2['Semana4Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region2['Semana4']['Lunes']/$Region2['Semana4Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region2['Semana4Ppto']['Martes']) != (0) ? $s[3] = number_format($Region2['Semana4']['Martes']/$Region2['Semana4Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region2['Semana4Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region2['Semana4']['Miercoles']/$Region2['Semana4Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region2['Semana4Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region2['Semana4']['Jueves']/$Region2['Semana4Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region2['Semana4Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region2['Semana4']['Viernes']/$Region2['Semana4Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region2['Semana4Ppto']['Sabado']) != (0) ? number_format($Region2['Semana4']['Sabado']/$Region2['Semana4Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region2['Semana4Ppto']['Lunes']) != (0) ? number_format($Region2['Semana4']['Lunes']/$Region2['Semana4Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region2['Semana4Ppto']['Martes']) != (0) ?number_format( $Region2['Semana4']['Martes']/$Region2['Semana4Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region2['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana4']['Miercoles']/$Region2['Semana4Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region2['Semana4Ppto']['Jueves']) != (0) ? number_format($Region2['Semana4']['Jueves']/$Region2['Semana4Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region2['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana4']['Viernes']/$Region2['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu555" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Sabado']) != (0) ? number_format($Region2['Semana5Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Lunes']) != (0) ? number_format($Region2['Semana5Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Martes']) != (0) ?number_format( $Region2['Semana5Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana5Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Jueves']) != (0) ? number_format($Region2['Semana5Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =$Region2['Semana5Ppto']['Sabado']+$Region2['Semana5Ppto']['Lunes']+$Region2['Semana5Ppto']['Martes']+$Region2['Semana5Ppto']['Miercoles']+$Region2['Semana5Ppto']['Jueves']+$Region2['Semana5Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Sabado']) != (0) ? number_format($Region2['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Lunes']) != (0) ? number_format($Region2['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Martes']) != (0) ?number_format( $Region2['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Miercoles']) != (0) ? number_format($Region2['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Jueves']) != (0) ? number_format($Region2['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region2['Semana5Fact']['Viernes'] != ('0')) ?  number_format($Region2['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region2['Semana5Fact']['Sabado']+$Region2['Semana5Fact']['Lunes']+$Region2['Semana5Fact']['Martes']+$Region2['Semana5Fact']['Miercoles']+$Region2['Semana5Fact']['Jueves']+$Region2['Semana5Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region2['Semana5']['Sabado']) != (0) ?  number_format($Region2['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5']['Lunes']) != (0) ?  number_format($Region2['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5']['Martes']) != (0) ?  number_format($Region2['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5']['Miercoles']) != (0) ?  number_format($Region2['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5']['Jueves']) != (0) ?  number_format($Region2['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region2['Semana5']['Viernes'] != ('0')) ?   number_format($Region2['Semana5']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region2['Semana5']['Sabado']+$Region2['Semana5']['Lunes']+$Region2['Semana5']['Martes']+$Region2['Semana5']['Miercoles']+$Region2['Semana5']['Jueves']+$Region2['Semana5']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region2['Semana5']['Sabado']-$Region2['Semana5Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Lunes']-$Region2['Semana5Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Martes']-$Region2['Semana5Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Miercoles']-$Region2['Semana5Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Jueves']-$Region2['Semana5Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana5']['Viernes']-$Region2['Semana5Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region2['Semana5']['Sabado']-$Region2['Semana5Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Lunes']-$Region2['Semana5Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Martes']-$Region2['Semana5Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Miercoles']-$Region2['Semana5Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region2['Semana5']['Jueves']-$Region2['Semana5Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region2['Semana5']['Viernes']-$Region2['Semana5Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region2['Semana5Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region2['Semana5']['Sabado']/$Region2['Semana5Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region2['Semana5Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region2['Semana5']['Lunes']/$Region2['Semana5Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region2['Semana5Ppto']['Martes']) != (0) ? $s[3] = number_format($Region2['Semana5']['Martes']/$Region2['Semana5Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region2['Semana5Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region2['Semana5']['Miercoles']/$Region2['Semana5Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region2['Semana5Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region2['Semana5']['Jueves']/$Region2['Semana5Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region2['Semana5Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region2['Semana5']['Viernes']/$Region2['Semana5Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region2['Semana5Ppto']['Sabado']) != (0) ? number_format($Region2['Semana5']['Sabado']/$Region2['Semana5Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region2['Semana5Ppto']['Lunes']) != (0) ? number_format($Region2['Semana5']['Lunes']/$Region2['Semana5Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region2['Semana5Ppto']['Martes']) != (0) ?number_format( $Region2['Semana5']['Martes']/$Region2['Semana5Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region2['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region2['Semana5']['Miercoles']/$Region2['Semana5Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region2['Semana5Ppto']['Jueves']) != (0) ? number_format($Region2['Semana5']['Jueves']/$Region2['Semana5Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region2['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region2['Semana5']['Viernes']/$Region2['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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
                    <!-- Inicia Region-->
                    <div class="panel-group col-sm-12">
                            <div class="panel panel-info ">
                                <div class="panel-heading">
                                    <label style="margin-right: 80%">Region #2</label>  <label>Mes: <?= $MesActual;?>  </label>
                                    
                                </div>
                                <div class="panel-body table-responsive">
                                
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#homeeee">Home</a></li>
                                    <li><a data-toggle="tab" href="#menu1111">Semana 1</a></li>
                                    <li><a data-toggle="tab" href="#menu2222">Semana 2</a></li>
                                    <li><a data-toggle="tab" href="#menu3333">Semana 3</a></li>
                                    <li><a data-toggle="tab" href="#menu4444">Semana 4</a></li>
                                    <li><a data-toggle="tab" href="#menu5555">Semana 5</a></li>
                                 
                                </ul>

                                <div class="tab-content">
                                    <div id="homeeee" class="tab-pane fade in active">
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
                                                    <td><?= number_format($Region0['totalMesAnt'],2)?></td>
                                                            
                                                    <?php 
                                                    //print_r($semanas);
                                                    for ($i=1; $i <=5 ; $i++) { 
                                                        if (isset($Region0['semanas'][$i])) {
                                                        echo "<td>".number_format($Region0['semanas'][$i],2)."</td>";
                                                        }else{
                                                            $Region0['semanas'][$i]=0.00;
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
                                                    <td><?= number_format($Region0['totalMesAct'],2)?></td>
                                                    <td><?= number_format($Region0['totalAcumulado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td><?= number_format($Region0['Acolocado'],2)?></td>
                                                    <td><?= number_format($Region0['colocadosem1'],2)?></td>
                                                    <td><?= number_format($Region0['colocadosem2'],2)?></td>
                                                    <td><?= number_format($Region0['colocadosem3'],2)?></td>
                                                    <td><?= number_format($Region0['colocadosem4'],2)?></td>
                                                    <td><?= number_format($Region0['colocadosem5'],2)?></td>
                                                    <td><?= number_format($Region0['acumcolocado']=$Region0['colocadosem1']+$Region0['colocadosem2']+$Region0['colocadosem3']+$Region0['colocadosem4']+$Region0['colocadosem5'],2)?></td>
                                                    <td><?= number_format($Region0['totalcolocado']=$Region0['acumcolocado']+$Region0['Acolocado'],2)?></td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Deudas</th>
                                                <td><?=number_format(@$Region0['Acolocado']-$Region0['totalMesAnt'],2)?></td>
                                                    <td><?=number_format(@$Region0['colocadosem1']-$Region0['semanas'][1],2)?></td>
                                                    <td><?=number_format(@$Region0['colocadosem2']-$Region0['semanas'][2],2)?></td>
                                                    <td><?=number_format(@$Region0['colocadosem3']-$Region0['semanas'][3],2)?></td>
                                                    <td><?=number_format(@$Region0['colocadosem4']-$Region0['semanas'][4],2)?></td>
                                                    <td><?=number_format(@$Region0['colocadosem5']-$Region0['semanas'][5],2)?></td>
                                                    <td><?=number_format(@$Region0['acumcolocado']-$Region0['totalMesAct'],2)?></td>
                                                    <td><?=number_format(@$Region0['totalcolocado']-$Region0['totalAcumulado'],2)?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu1111" class="tab-pane fade">
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
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Sabado']) != (0) ? number_format($Region0['Semana1Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Lunes']) != (0) ? number_format($Region0['Semana1Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Martes']) != (0) ?number_format( $Region0['Semana1Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana1Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Jueves']) != (0) ? number_format($Region0['Semana1Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana1Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region0['Semana1Ppto']['Sabado']+$Region0['Semana1Ppto']['Lunes']+$Region0['Semana1Ppto']['Martes']+$Region0['Semana1Ppto']['Miercoles']+$Region0['Semana1Ppto']['Jueves']+$Region0['Semana1Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Sabado']) != (0) ? number_format($Region0['Semana1Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Lunes']) != (0) ? number_format($Region0['Semana1Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Martes']) != (0) ?number_format( $Region0['Semana1Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Miercoles']) != (0) ? number_format($Region0['Semana1Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Jueves']) != (0) ? number_format($Region0['Semana1Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana1Fact']['Viernes'] != ('0')) ?  number_format($Region0['Semana1Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region0['Semana1Fact']['Sabado']+$Region0['Semana1Fact']['Lunes']+$Region0['Semana1Fact']['Martes']+$Region0['Semana1Fact']['Miercoles']+$Region0['Semana1Fact']['Jueves']+$Region0['Semana1Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo ($Region0['Semana1']['Sabado']) != (0) ? number_format($Region0['Semana1']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana1']['Lunes']) != (0) ? number_format($Region0['Semana1']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana1']['Martes']) != (0) ?number_format( $Region0['Semana1']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana1']['Miercoles']) != (0) ? number_format($Region0['Semana1']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana1']['Jueves']) != (0) ? number_format($Region0['Semana1']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana1']['Viernes'] != ('0')) ?  number_format($Region0['Semana1']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =$Region0['Semana1']['Sabado']+$Region0['Semana1']['Lunes']+$Region0['Semana1']['Martes']+$Region0['Semana1']['Miercoles']+$Region0['Semana1']['Jueves']+$Region0['Semana1']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region0['Semana1']['Sabado']-$Region0['Semana1Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Lunes']-$Region0['Semana1']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Martes']-$Region0['Semana1Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Miercoles']-$Region0['Semana1Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Jueves']-$Region0['Semana1Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana1']['Viernes']-$Region0['Semana1Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region0['Semana1']['Sabado']-$Region0['Semana1Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Lunes']-$Region0['Semana1Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Martes']-$Region0['Semana1Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Miercoles']-$Region0['Semana1Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana1']['Jueves']-$Region0['Semana1Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana1']['Viernes']-$Region0['Semana1Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region0['Semana1Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region0['Semana1']['Sabado']/$Region0['Semana1Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region0['Semana1Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region0['Semana1']['Lunes']/$Region0['Semana1Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region0['Semana1Ppto']['Martes']) != (0) ? $s[3] = number_format($Region0['Semana1']['Martes']/$Region0['Semana1Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region0['Semana1Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region0['Semana1']['Miercoles']/$Region0['Semana1Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region0['Semana1Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region0['Semana1']['Jueves']/$Region0['Semana1Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region0['Semana1Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region0['Semana1']['Viernes']/$Region0['Semana1Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region0['Semana1Ppto']['Sabado']) != (0) ? number_format($Region0['Semana1']['Sabado']/$Region0['Semana1Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region0['Semana1Ppto']['Lunes']) != (0) ? number_format($Region0['Semana1']['Lunes']/$Region0['Semana1Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region0['Semana1Ppto']['Martes']) != (0) ?number_format( $Region0['Semana1']['Martes']/$Region0['Semana1Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region0['Semana1Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana1']['Miercoles']/$Region0['Semana1Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region0['Semana1Ppto']['Jueves']) != (0) ? number_format($Region0['Semana1']['Jueves']/$Region0['Semana1Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region0['Semana1Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana1']['Viernes']/$Region0['Semana1Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu2222" class="tab-pane fade">
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
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Sabado']) != (0) ? number_format($Region0['Semana2Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Lunes']) != (0) ? number_format($Region0['Semana2Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Martes']) != (0) ?number_format( $Region0['Semana2Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana2Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Jueves']) != (0) ? number_format($Region0['Semana2Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana2Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region0['Semana2Ppto']['Sabado']+$Region0['Semana2Ppto']['Lunes']+$Region0['Semana2Ppto']['Martes']+$Region0['Semana2Ppto']['Miercoles']+$Region0['Semana2Ppto']['Jueves']+$Region0['Semana2Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Sabado']) != (0) ? number_format($Region0['Semana2Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Lunes']) != (0) ? number_format($Region0['Semana2Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Martes']) != (0) ?number_format( $Region0['Semana2Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Miercoles']) != (0) ? number_format($Region0['Semana2Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Jueves']) != (0) ? number_format($Region0['Semana2Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana2Fact']['Viernes'] != ('0')) ?  number_format($Region0['Semana2Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region0['Semana2Fact']['Sabado']+$Region0['Semana2Fact']['Lunes']+$Region0['Semana2Fact']['Martes']+$Region0['Semana2Fact']['Miercoles']+$Region0['Semana2Fact']['Jueves']+$Region0['Semana2Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolsado</th>
                                                    <td> <?php echo ($Region0['Semana2']['Sabado']) != (0) ? number_format($Region0['Semana2']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana2']['Lunes']) != (0) ? number_format($Region0['Semana2']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana2']['Martes']) != (0) ?number_format( $Region0['Semana2']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana2']['Miercoles']) != (0) ? number_format($Region0['Semana2']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana2']['Jueves']) != (0) ? number_format($Region0['Semana2']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana2']['Viernes'] != ('0')) ?  number_format($Region0['Semana2']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($dese =$Region0['Semana2']['Sabado']+$Region0['Semana2']['Lunes']+$Region0['Semana2']['Martes']+$Region0['Semana2']['Miercoles']+$Region0['Semana2']['Jueves']+$Region0['Semana2']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region0['Semana2']['Sabado']-$Region0['Semana2Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Lunes']-$Region0['Semana2']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Martes']-$Region0['Semana2Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Miercoles']-$Region0['Semana2Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Jueves']-$Region0['Semana2Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana2']['Viernes']-$Region0['Semana2Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>
                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region0['Semana2']['Sabado']-$Region0['Semana2Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Lunes']-$Region0['Semana2Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Martes']-$Region0['Semana2Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Miercoles']-$Region0['Semana2Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana2']['Jueves']-$Region0['Semana2Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana2']['Viernes']-$Region0['Semana2Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region0['Semana2Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region0['Semana2']['Sabado']/$Region0['Semana2Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region0['Semana2Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region0['Semana2']['Lunes']/$Region0['Semana2Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region0['Semana2Ppto']['Martes']) != (0) ? $s[3] = number_format($Region0['Semana2']['Martes']/$Region0['Semana2Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region0['Semana2Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region0['Semana2']['Miercoles']/$Region0['Semana2Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region0['Semana2Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region0['Semana2']['Jueves']/$Region0['Semana2Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region0['Semana2Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region0['Semana2']['Viernes']/$Region0['Semana2Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region0['Semana2Ppto']['Sabado']) != (0) ? number_format($Region0['Semana2']['Sabado']/$Region0['Semana2Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region0['Semana2Ppto']['Lunes']) != (0) ? number_format($Region0['Semana2']['Lunes']/$Region0['Semana2Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region0['Semana2Ppto']['Martes']) != (0) ?number_format( $Region0['Semana2']['Martes']/$Region0['Semana2Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region0['Semana2Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana2']['Miercoles']/$Region0['Semana2Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region0['Semana2Ppto']['Jueves']) != (0) ? number_format($Region0['Semana2']['Jueves']/$Region0['Semana2Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region0['Semana2Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana2']['Viernes']/$Region0['Semana2Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu3333" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Sabado']) != (0) ? number_format($Region0['Semana3Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Lunes']) != (0) ? number_format($Region0['Semana3Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Martes']) != (0) ?number_format( $Region0['Semana3Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana3Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Jueves']) != (0) ? number_format($Region0['Semana3Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana3Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto = $Region0['Semana3Ppto']['Sabado']+$Region0['Semana3Ppto']['Lunes']+$Region0['Semana3Ppto']['Martes']+$Region0['Semana3Ppto']['Miercoles']+$Region0['Semana3Ppto']['Jueves']+$Region0['Semana3Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Sabado']) != (0) ? number_format($Region0['Semana3Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Lunes']) != (0) ? number_format($Region0['Semana3Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Martes']) != (0) ?number_format( $Region0['Semana3Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Miercoles']) != (0) ? number_format($Region0['Semana3Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Jueves']) != (0) ? number_format($Region0['Semana3Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana3Fact']['Viernes'] != ('0')) ?  number_format($Region0['Semana3Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region0['Semana3Fact']['Sabado']+$Region0['Semana3Fact']['Lunes']+$Region0['Semana3Fact']['Martes']+$Region0['Semana3Fact']['Miercoles']+$Region0['Semana3Fact']['Jueves']+$Region0['Semana3Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region0['Semana3']['Sabado']) != (0) ?  number_format($Region0['Semana3']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3']['Lunes']) != (0) ?  number_format($Region0['Semana3']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3']['Martes']) != (0) ?  number_format($Region0['Semana3']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3']['Miercoles']) != (0) ?  number_format($Region0['Semana3']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3']['Jueves']) != (0) ?  number_format($Region0['Semana3']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana3']['Viernes'] != ('0')) ?   number_format($Region0['Semana3']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region0['Semana3']['Sabado']+$Region0['Semana3']['Lunes']+$Region0['Semana3']['Martes']+$Region0['Semana3']['Miercoles']+$Region0['Semana3']['Jueves']+$Region0['Semana3']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region0['Semana3']['Sabado']-$Region0['Semana3Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Lunes']-$Region0['Semana3Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Martes']-$Region0['Semana3Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Miercoles']-$Region0['Semana3Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Jueves']-$Region0['Semana3Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana3']['Viernes']-$Region0['Semana3Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region0['Semana3']['Sabado']-$Region0['Semana3Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Lunes']-$Region0['Semana3Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Martes']-$Region0['Semana3Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Miercoles']-$Region0['Semana3Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana3']['Jueves']-$Region0['Semana3Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana3']['Viernes']-$Region0['Semana3Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region0['Semana3Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region0['Semana3']['Sabado']/$Region0['Semana3Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region0['Semana3Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region0['Semana3']['Lunes']/$Region0['Semana3Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region0['Semana3Ppto']['Martes']) != (0) ? $s[3] = number_format($Region0['Semana3']['Martes']/$Region0['Semana3Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region0['Semana3Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region0['Semana3']['Miercoles']/$Region0['Semana3Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region0['Semana3Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region0['Semana3']['Jueves']/$Region0['Semana3Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region0['Semana3Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region0['Semana3']['Viernes']/$Region0['Semana3Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region0['Semana3Ppto']['Sabado']) != (0) ? number_format($Region0['Semana3']['Sabado']/$Region0['Semana3Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region0['Semana3Ppto']['Lunes']) != (0) ? number_format($Region0['Semana3']['Lunes']/$Region0['Semana3Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region0['Semana3Ppto']['Martes']) != (0) ?number_format( $Region0['Semana3']['Martes']/$Region0['Semana3Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region0['Semana3Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana3']['Miercoles']/$Region0['Semana3Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region0['Semana3Ppto']['Jueves']) != (0) ? number_format($Region0['Semana3']['Jueves']/$Region0['Semana3Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region0['Semana3Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana3']['Viernes']/$Region0['Semana3Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu4444" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Sabado']) != (0) ? number_format($Region0['Semana4Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Lunes']) != (0) ? number_format($Region0['Semana4Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Martes']) != (0) ?number_format( $Region0['Semana4Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana4Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Jueves']) != (0) ? number_format($Region0['Semana4Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana4Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =$Region0['Semana4Ppto']['Sabado']+$Region0['Semana4Ppto']['Lunes']+$Region0['Semana4Ppto']['Martes']+$Region0['Semana4Ppto']['Miercoles']+$Region0['Semana4Ppto']['Jueves']+$Region0['Semana4Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Sabado']) != (0) ? number_format($Region0['Semana4Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Lunes']) != (0) ? number_format($Region0['Semana4Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Martes']) != (0) ?number_format( $Region0['Semana4Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Miercoles']) != (0) ? number_format($Region0['Semana4Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Jueves']) != (0) ? number_format($Region0['Semana4Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana4Fact']['Viernes'] != ('0')) ?  number_format($Region0['Semana4Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region0['Semana4Fact']['Sabado']+$Region0['Semana4Fact']['Lunes']+$Region0['Semana4Fact']['Martes']+$Region0['Semana4Fact']['Miercoles']+$Region0['Semana4Fact']['Jueves']+$Region0['Semana4Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region0['Semana4']['Sabado']) != (0) ?  number_format($Region0['Semana4']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4']['Lunes']) != (0) ?  number_format($Region0['Semana4']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4']['Martes']) != (0) ?  number_format($Region0['Semana4']['Martes'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4']['Miercoles']) != (0) ?  number_format($Region0['Semana4']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4']['Jueves']) != (0) ?  number_format($Region0['Semana4']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana4']['Viernes'] != ('0')) ?   number_format($Region0['Semana4']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region0['Semana4']['Sabado']+$Region0['Semana4']['Lunes']+$Region0['Semana4']['Martes']+$Region0['Semana4']['Miercoles']+$Region0['Semana4']['Jueves']+$Region0['Semana4']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region0['Semana4']['Sabado']-$Region0['Semana4Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Lunes']-$Region0['Semana4Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Martes']-$Region0['Semana4Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Miercoles']-$Region0['Semana4Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Jueves']-$Region0['Semana4Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana4']['Viernes']-$Region0['Semana4Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region0['Semana4']['Sabado']-$Region0['Semana4Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Lunes']-$Region0['Semana4Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Martes']-$Region0['Semana4Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Miercoles']-$Region0['Semana4Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana4']['Jueves']-$Region0['Semana4Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana4']['Viernes']-$Region0['Semana4Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region0['Semana4Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region0['Semana4']['Sabado']/$Region0['Semana4Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region0['Semana4Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region0['Semana4']['Lunes']/$Region0['Semana4Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region0['Semana4Ppto']['Martes']) != (0) ? $s[3] = number_format($Region0['Semana4']['Martes']/$Region0['Semana4Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region0['Semana4Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region0['Semana4']['Miercoles']/$Region0['Semana4Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region0['Semana4Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region0['Semana4']['Jueves']/$Region0['Semana4Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region0['Semana4Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region0['Semana4']['Viernes']/$Region0['Semana4Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region0['Semana4Ppto']['Sabado']) != (0) ? number_format($Region0['Semana4']['Sabado']/$Region0['Semana4Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region0['Semana4Ppto']['Lunes']) != (0) ? number_format($Region0['Semana4']['Lunes']/$Region0['Semana4Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region0['Semana4Ppto']['Martes']) != (0) ?number_format( $Region0['Semana4']['Martes']/$Region0['Semana4Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region0['Semana4Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana4']['Miercoles']/$Region0['Semana4Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region0['Semana4Ppto']['Jueves']) != (0) ? number_format($Region0['Semana4']['Jueves']/$Region0['Semana4Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region0['Semana4Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana4']['Viernes']/$Region0['Semana4Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="menu5555" class="tab-pane fade">
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
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Sabado']) != (0) ? number_format($Region0['Semana5Ppto']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Lunes']) != (0) ? number_format($Region0['Semana5Ppto']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Martes']) != (0) ?number_format( $Region0['Semana5Ppto']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana5Ppto']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Jueves']) != (0) ? number_format($Region0['Semana5Ppto']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana5Ppto']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($ppto =$Region0['Semana5Ppto']['Sabado']+$Region0['Semana5Ppto']['Lunes']+$Region0['Semana5Ppto']['Martes']+$Region0['Semana5Ppto']['Miercoles']+$Region0['Semana5Ppto']['Jueves']+$Region0['Semana5Ppto']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Factibilidad (A Desembolsar)</th>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Sabado']) != (0) ? number_format($Region0['Semana5Fact']['Sabado'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Lunes']) != (0) ? number_format($Region0['Semana5Fact']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Martes']) != (0) ?number_format( $Region0['Semana5Fact']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Miercoles']) != (0) ? number_format($Region0['Semana5Fact']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Jueves']) != (0) ? number_format($Region0['Semana5Fact']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo (@$Region0['Semana5Fact']['Viernes'] != ('0')) ?  number_format($Region0['Semana5Fact']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?= number_format($presu = $Region0['Semana5Fact']['Sabado']+$Region0['Semana5Fact']['Lunes']+$Region0['Semana5Fact']['Martes']+$Region0['Semana5Fact']['Miercoles']+$Region0['Semana5Fact']['Jueves']+$Region0['Semana5Fact']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Desembolso</th>
                                                    <td> <?php echo ($Region0['Semana5']['Sabado']) != (0) ?  number_format($Region0['Semana5']['Sabado'] ,2): '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5']['Lunes']) != (0) ?  number_format($Region0['Semana5']['Lunes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5']['Martes']) != (0) ?  number_format($Region0['Semana5']['Martes'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5']['Miercoles']) != (0) ?  number_format($Region0['Semana5']['Miercoles'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5']['Jueves']) != (0) ?  number_format($Region0['Semana5']['Jueves'],2) : '-' ; ?> </td>
                                                    <td> <?php echo ($Region0['Semana5']['Viernes'] != ('0')) ?   number_format($Region0['Semana5']['Viernes'],2) : '-' ; ?> </td>
                                                    <td> <?=  number_format($dese = $Region0['Semana5']['Sabado']+$Region0['Semana5']['Lunes']+$Region0['Semana5']['Martes']+$Region0['Semana5']['Miercoles']+$Region0['Semana5']['Jueves']+$Region0['Semana5']['Viernes'],2) ?> </td>
                                                </tr>
                                                <tr>
                                                <th scope="row">Pendientes ( Factibilidad - Desembolsado)</th>
                                                    <td><?=number_format($Region0['Semana5']['Sabado']-$Region0['Semana5Fact']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Lunes']-$Region0['Semana5Fact']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Martes']-$Region0['Semana5Fact']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Miercoles']-$Region0['Semana5Fact']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Jueves']-$Region0['Semana5Fact']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana5']['Viernes']-$Region0['Semana5Fact']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$presu,2)?></td>
                                                </tr>

                                                <th scope="row">Deudas (Desembolsado - Presupuestado)</th>
                                                    <td><?=number_format($Region0['Semana5']['Sabado']-$Region0['Semana5Ppto']['Sabado'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Lunes']-$Region0['Semana5Ppto']['Lunes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Martes']-$Region0['Semana5Ppto']['Martes'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Miercoles']-$Region0['Semana5Ppto']['Miercoles'],2)?></td>
                                                    <td><?=number_format($Region0['Semana5']['Jueves']-$Region0['Semana5Ppto']['Jueves'],2)?></td>

                                                    <td><?=number_format($Region0['Semana5']['Viernes']-$Region0['Semana5Ppto']['Viernes'],2)?></td>
                                                    <td><?=number_format($dese-$ppto,2)?></td>
                                                </tr>

                                                <th scope="row">Indicador Deuda (Desembolsado/Presupuestado)</th>
                                                    <!-- INICIO color indicador -->
                                                        <?php $indicadorColor[0] = "bg-success";?>
                                                        <?php
                                                        (@$Region0['Semana5Ppto']['Sabado']) != (0) ? $s[1] = number_format($Region0['Semana5']['Sabado']/$Region0['Semana5Ppto']['Sabado']*100,2) : $s[1]=0 ;
                                                        (@$Region0['Semana5Ppto']['Lunes']) != (0) ? $s[2] = number_format($Region0['Semana5']['Lunes']/$Region0['Semana5Ppto']['Lunes']*100,2) : $s[2]=0 ;
                                                        (@$Region0['Semana5Ppto']['Martes']) != (0) ? $s[3] = number_format($Region0['Semana5']['Martes']/$Region0['Semana5Ppto']['Martes']*100,2) : $s[3]=0 ;
                                                        (@$Region0['Semana5Ppto']['Miercoles']) != (0) ? $s[4] = number_format($Region0['Semana5']['Miercoles']/$Region0['Semana5Ppto']['Miercoles']*100,2) : $s[4]=0 ;
                                                        (@$Region0['Semana5Ppto']['Jueves']) != (0) ? $s[5] = number_format($Region0['Semana5']['Jueves']/$Region0['Semana5Ppto']['Jueves']*100,2) : $s[5]=0 ;
                                                        (@$Region0['Semana5Ppto']['Viernes']) != (0) ? $s[6] = number_format($Region0['Semana5']['Viernes']/$Region0['Semana5Ppto']['Viernes']*100,2) : $s[6]=0 ;
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
                                                    <td class="<?=$indicadorColor[1];?>"> <?php echo (@$Region0['Semana5Ppto']['Sabado']) != (0) ? number_format($Region0['Semana5']['Sabado']/$Region0['Semana5Ppto']['Sabado']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[2];?>"> <?php echo (@$Region0['Semana5Ppto']['Lunes']) != (0) ? number_format($Region0['Semana5']['Lunes']/$Region0['Semana5Ppto']['Lunes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[3];?>"> <?php echo (@$Region0['Semana5Ppto']['Martes']) != (0) ?number_format( $Region0['Semana5']['Martes']/$Region0['Semana5Ppto']['Martes']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[4];?>"> <?php echo (@$Region0['Semana5Ppto']['Miercoles']) != (0) ? number_format($Region0['Semana5']['Miercoles']/$Region0['Semana5Ppto']['Miercoles']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[5];?>"> <?php echo (@$Region0['Semana5Ppto']['Jueves']) != (0) ? number_format($Region0['Semana5']['Jueves']/$Region0['Semana5Ppto']['Jueves']*100,2).'%' : '-' ; ?> </td>
                                                    <td class="<?=$indicadorColor[6];?>"> <?php echo (@$Region0['Semana5Ppto']['Viernes'] != ('0')) ?  number_format($Region0['Semana5']['Viernes']/$Region0['Semana5Ppto']['Viernes']*100,2).'%' : '-' ; ?> </td>

                                                
                                                    <td class="<?=$indicadorColor[7];?>"><?=number_format($dese/$ppto*100,2).'%'?></td>
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