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
                <div class=" col-sm-6 ">
                    Fecha 
                </div>

                <div class=" col-sm-6 ">
                    Fecha de impresion
                </div>
            </div>
            <div class="text-center well text-white blue no-print">
                <!--
                <div class=" col-sm-3 ">
                    Desde: $<?=$filtro[0]?> - Hasta: $<?=$filtro[1]?>
                </div>
                -->
                <div class=" col-sm-6 ">
                    Desde:<?=$filtro[0]?> 
                     - Hasta:<?=$filtro[1]?> 
                </div>
                
                <div class=" col-sm-6 ">
                    <?= Date("Y-m-d H:m:s")?>
                </div>
            </div>
            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">
                    <table class="table" class="tablesorter" id="myTable">
                        <thead >
                            <tr class="text-center">
                                
                                <th class="text-center">Asesor</th>
                                <th class="text-center">Cartera</th>
                                <th class="text-center">Agencia</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        
                        $contador = 0;
                        $color="";
                        foreach ($NoColoco as $key) {
                            
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
                                    <?= $key->Nombre?>
                                </td>
                                <td>
                                    <?= $key->cartera?>
                                </td>
                                <td>
                                    <?= $key->agencia?>
                                </td>
                               
                            </tr>
                        <?php
                        
                        
                        
                        }
                        ?>
                        <tfoot>
                            <tr class="table-dark">
                                <td>
                                    <h3>Total</h3>
                                </td>
                                <td>
                                    <h4><?= count($NoColoco)?></h4>
                                </td>
                            </tr>
                        </tfoot>
                            
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-3 col-md-6" >

                </div>
                <div class="col-sm-9 col-md-6" >
                    
                </div>
                
            </div>
        </div>
    </body>
</html>
