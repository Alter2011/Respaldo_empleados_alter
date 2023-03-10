<!--
<html>
    <body>    
-->
<?php
    /*if (in_array('03',$regiones[1],false)) {
        echo "hola";
    }*/
   
    /*for ($i=1; $i <= count($regiones) ; $i++) { 
         echo "<h1>Region ".$i.'</h1>';
       for ($j=0; $j <count($regiones[$i]) ; $j++) { 

           echo $regiones[$i][$j].' ';
       }
       echo "<br>";
       TENGO HAMBRE
    }*/
  ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script> 
        <div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">
            <div class="text-center well text-white blue no-print">
                <h2>Reporte de Nueva Colocacion</h2>
        <br>
        <!--
                <div class=" col-sm-3 ">
                    Presupuesto
                </div>
        -->
                <div class=" col-sm-4 ">
                    Colocacion
                </div>
                <div class=" col-sm-4 ">
                    Fecha
                </div>
                <div class=" col-sm-4 ">
                    Fecha impreso
                </div>
            </div>
            <div class="text-center well text-white blue no-print">
                <!--
                <div class=" col-sm-3 ">
                    Desde: $<?=$filtro[0]?> - Hasta: $<?=$filtro[1]?>
                </div>
                -->
                <div class=" col-sm-4 ">
                    Desde: $<?=$filtro[2]?> 
                    <?php if ($filtro[3]>0) {
                    ?>
                    - Hasta: $<?=$filtro[3]?>
                    <?php    
                    }
                    ?>
                    
                </div>
                <div class=" col-sm-4 ">
                    <?php if ($filtro[4]!=" ") {
                    ?>
                    Desde: <?=$filtro[4]?>
                    <?php    
                    }
                    ?>
                    <?php if ($filtro[5]!="") {
                    ?>
                    - Hasta: <?=$filtro[5]?>
                    <?php    
                    }
                    ?>
                </div>
                <div class=" col-sm-4 ">
                    <?= Date("Y-m-d H:m:s")?>
                </div>
            </div>
            <?php
            if ($filtro[6]=="Detalle") {
            ?>
            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">
                    <table class="table" class="tablesorter" id="myTable">
                        <thead class="text-center">
                            <tr>
                                <th>Codigo Cliente</th>
                                <th>Codigo Prospecto</th>
                                <th>Monto Colocado</th>
                                <!--<th>Num Cartera</th>-->
                                <th>Asesor</th>
                                <th>Cartera</th>
                                <th>Agencia</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalColocado= 0;
                        $totalProspectado=0;
                        $contador = 0;
                        $color="";
                        foreach ($ColocacionNueva as $key) {

                            
                            
                            if ($color!=$key->agencia) {
                                $color=$key->agencia;
                                $contador++;

                            }
                        
                            switch ($contador) {
                                case 1:
                                $clase="success";
                                    break;
                                case 2:
                                $clase="danger";
                                    break;
                                case 3:
                                $clase="info";
                                    break;
                                case 4:
                                $clase="warning";
                                    break;
                                case 5:
                                $clase="active";
                                    break;
                                default:
                                    $contador=1;
                                    $clase="success";
                                break;
                            }
                        ?>
                            <tr class="<?=$clase;?>">
                                <td>
                                    <?= $key->codigoFox?>
                                </td>
                                <td>
                                    <?= $key->codigoProspecto?>
                                </td>
                                <td>
                                    <?= $key->MontoColocado?>
                                </td>
                                <td>
                                    <?= $key->asesor?>
                                </td>
                                <td>
                                    <?= $key->cartera?>
                                </td>
                                <td>
                                    <?= $key->agencia?>
                                </td>
                                <td>
                                    <?= $key->fecha?>
                                </td>
                            </tr>
                        <?php
                        $totalColocado += floatval($key->MontoColocado);
                        
                        
                        }
                        ?>
                            <tr>
                                <td>
                                    Totales:
                                </td>
                                <td colspan="5">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    Total: <?=count($ColocacionNueva)?>
                                </td>
                                <td>
                                    <?=number_format($totalColocado,2)?>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-md-6" >

                </div>
                <div class="col-sm-9 col-md-6" >
                    
                </div>
                
            </div>
            <?php
            }else{
            ?>
            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">
                    <table class="table" class="tablesorter" id="myTable">
                        <thead class="text-center">
                            <tr>
                                <th class="text-center">Agencia</th>
                                <th class="text-center">Cartera</th>
                                <th class="text-center">Asesor</th>
                                <th class="text-center">Monto Colocado</th>
                                <!--<th>Num Cartera</th>-->
                                
                                
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $totalColocado= 0;
                        $totalProspectado=0;
                        $contador = 0;
                        $color="";
                        foreach ($ColocacionNueva as $key) {
                            //echo $key->MontoColocado."-".$filtro[3]."<br>";
                            if($key->MontoColocado>=$filtro[3]){
                                continue;
                            }
                            if ($color!=$key->agencia) {
                                $color=$key->agencia;
                                $contador++;

                            }
                        
                            switch ($contador) {
                                case 1:
                                $clase="success";
                                    break;
                                case 2:
                                $clase="danger";
                                    break;
                                case 3:
                                $clase="info";
                                    break;
                                case 4:
                                $clase="warning";
                                    break;
                                case 5:
                                $clase="active";
                                    break;
                                default:
                                    $contador=1;
                                    $clase="success";
                                break;
                            }
                        ?>
                            <tr class="<?=$clase;?>">
                                <td>
                                    <?= $key->agencia?>
                                </td>
                                <td>
                                    <?= $key->cartera?>
                                </td>
                                <td>
                                    <?= $key->asesor?>
                                </td>
                                <td>
                                    <?= $key->MontoColocado?>
                                </td>
                                
                                
                                
                               
                            </tr>
                        <?php
                        $totalColocado += floatval($key->MontoColocado);
                        
                        
                        }
                        ?>
                            <tr>
                                <td>
                                    Totales:
                                </td>
                                <td colspan="5">
                                    
                                </td>
                            </tr>
                            <tr>
                                <td colspan=2>
                                    Total: <?=count($ColocacionNueva)?>
                                </td>
                                <td>
                                    <?=number_format($totalColocado,2)?>
                                </td>
                                <td>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-md-6" >

                </div>
                <div class="col-sm-9 col-md-6" >
                    
                </div>
                
            </div>
            <?php
            }
            ?>
        </div>
    </body>
</html>
