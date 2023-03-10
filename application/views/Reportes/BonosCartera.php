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
                <h2>Reporte de Bonificacion de Cartera</h2>
        
            </div>
            <h4>Inicio: <?php echo $inicio ?> Fin: <?php echo $fin ?></h4>
            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">
               <?php  for ($k=1; $k <= count($regiones) ; $k++) {  
                            echo "<h1>Region ".$k.'</h1>'; 

                            ?>
                    <table class="table" class="tablesorter" id="myTable">
                        <thead class="text-center">
                            <tr>
                                <th>Agencia</th>
                                <th>Nombre</th>
                                <th>Cartera</th>
                                <th>Cartera Media</th>
                                <th>Indice</th>
                                 <th>Colocacion Nuevos</th>
                                <th>Bono Asesor</th>
                                <th>B.Consuelo Asesor</th>
                                <th>B. Jefe</th>
                                <th>B.Jefa</th>
                                <th>B.Coord</th> 
                                <th>B.C.nuevos</th>                               
                                <th>B.Referente Cartera</th>
                                <th>Total</th>
                                <th>M.Operaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                        
                            //print_r($Datos[6]);
                            $contador=0;
                            $color="";
                            $tot3=0;
                            $totCarT=0;
                            $totOPT=0;
                             $totNCT=0;

                           $tot2=0;
                            $tot1=0; 
                            $agencia='';
                            $totOP=0;  
                            $totNC=0;
                            $totCar=0;
                             $totales=0;           

                            foreach ($Datos as $key) {
                                    $agenc=substr($key->car, 0,2);
   
                            if (in_array($agenc,$regiones[$k],false)) {    
                                if ($color!=$key->agencia) {
                                    $color=$key->agencia;
                                    $contador++;
                                
                                    if ($contador!=1) {
                            ?>
                            <tr class="table-light">
                                <td>SUB TOTALES</td>
                                <td><?=$agencia;?></td>
                                
                                <td></td>
                                <td> <?=(number_format(abs($totCar), 2, '.', ',')) ; ?> </td>
                                <td></td>
                                <td> <?=(number_format(abs($totNC), 2, '.', ',')) ; ?> </td>
                                <td></td>
                                 <td></td>
                                <td><?=round($tot1, 2, PHP_ROUND_HALF_DOWN); ?></td>
                                <td><?=round($tot2, 2, PHP_ROUND_HALF_DOWN); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> <?=(number_format(abs($totOP), 2, '.', ',')) ; ?> </td>
                            </tr> 
                            <?php
                            $tot2=0;
                           $tot1=0;
                           $agencia=''; 
                           $totOP=0; 
                           $totNC=0;
                           $totCar=0; 
        

                        }
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

                                $bono=0;//asesor
                                $bono2=0;//bono jefe
                                $bono3=0;//bono jefe y bono coordinador (misma formula)
                                $bono4=0;//bonififacion referente de cartera
                                $bono5=0;//bono de carteras nuevos
                                $bonoc=0;//asesor consuelo    
                                
                                 $totales=
                                $inc=0;$inc2=0;$inc3=0;$inc4=0;
                                $cm=16000;
                                //bono de asesor
                                $mora=abs(number_format(($key->mora), 2, '.', ' '));
                               // print_r($key);
                                for ($i=0; $i <= 10; $i++) { 
                                    if ($key->cartera2>=$cm && ($key->mora<=25)) {
                                        $bono=$inc-(500/3)*($key->mora/100)+(125/3);


                                        $bono2=$inc2-(50)*($key->mora/100)+(12.5);
                                        $bono3=$inc3-(16.67)*($key->mora/100)+(4.17);
                                        $bono4=$inc4-(23.33)*($key->mora/100)+(5.83);
                                         $totales=$bono+$bono2+$bono3+$bono3+$bono4;   
                                         //echo "mora ".$key->mora.' '.$bono3;
                                         //echo "<br>";
                                    }
                                    $cm=$cm+2000;
                                    $inc=$inc+25;
                                    $inc2=$inc2+7.50;
                                    $inc3=$inc3+2.50;
                                    $inc4=$inc4+3.50;

                                }
                              
                                if ($key->cartera2>=10000 && $key->cartera2<=15000 && $key->mora<=15 && $key->nuevos>=2000) {
                                    $bono5=20;
                                    
                                }
                                 if ($key->cartera2>=15000 && $key->cartera2<=18000 && $key->mora<=15 && $key->nuevos>=1500) {
                                    $bono5=20;
                                    
                                }
                                 if ($bono==0) {
                                     if ($key->cartera2>=20000 && ($key->mora<=30)) {
                                         $bonoc=25;   
                                        }
                                       if ($key->cartera2>=25000 && ($key->mora<=30)) {
                                         $bonoc=50;   
                                        }  
                                           
                                    }
                                     $totales +=$bonoc+$bono5; 
                                 $tot3 +=$bono2;
                                $tot2+=$bono3;
                                $tot1+=$bono2; 
                                $agencia=$key->agencia;           
                                $totCar+=$key->cartera2;
                                $montOp=$key->cartera2*((100-$key->mora)/100);
                                   $totCarT+=$key->cartera2;
                                    $totOPT+=$montOp;
                                $totOP+=$montOp;
                                $totNC+=$key->nuevos;
                                $totNCT+=$key->nuevos;
                           

                            ?>
                            <tr class="<?=$clase;?>">
                                <td><?=$key->agencia;?></td>
                                <td><?=$key->nombre;?></td>
                                
                                <td><?=$key->cartera;?></td>
                                <!--<td><?=$key->car;?></td>-->
                                <td><?= number_format($key->cartera2, 2, '.', ',');?></td>
                                <td><?=$mora.'%';?></td><!--sacar promedio -->
                                <td><?= number_format($key->nuevos, 2, '.', ',');?></td>
                                <td> <?=(number_format(($bono), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(($bonoc), 2, '.', ',')) ; ?> </td>

                                <!--<td><?=$key->fecha;?></td>-->
                                <td> <?=(number_format(($bono2), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(($bono3), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(($bono3), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(($bono5), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(($bono4), 2, '.', ',')) ; ?> </td>
                                 <td> <?=(number_format(($totales), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($montOp), 2, '.', ',')) ; ?> </td>
                            </tr>

                            <?php
                            
                                }

                            }
                      
                        
                            ?>
                        
                            
                        
                    <?php  
                    ?>  
                              <tr class="table-light">
                                <td>SUB TOTALES</td>
                                <td><?=$agencia;?></td>
                                
                                <td></td>
                                <td> <?=(number_format(abs($totCar), 2, '.', ',')) ; ?> </td>
                                <td></td>
                                <td> <?=(number_format(abs($totNC), 2, '.', ',')) ; ?> </td>
                                <td></td>
                                 <td></td>
                                <td><?=round($tot1, 2, PHP_ROUND_HALF_DOWN); ?></td>
                                <td><?=round($tot2, 2, PHP_ROUND_HALF_DOWN); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> <?=(number_format(abs($totOP), 2, '.', ',')) ; ?> </td>
                            </tr> 
                          <tr class="table-light">
                                <td>TOTALES</td>
                                <td></td>
                                <td></td>
                                <td> <?=(number_format(abs($totCarT), 2, '.', ',')) ; ?> </td>
                                <td></td>
                                <td> <?=(number_format(abs($totNCT), 2, '.', ',')) ; ?> </td>

                                <td></td>
                                <td></td>
                                <td><?=round($tot3, 2, PHP_ROUND_HALF_DOWN); ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td> <?=(number_format(abs($totOPT), 2, '.', ',')) ; ?> </td>
                                
                            </tr> 
                  </tbody>
                    </table>
                    <?php
                        } ?>
                </div>
                <div class="col-sm-3 col-md-6" >

                </div>
                <div class="col-sm-9 col-md-6" >
                    
                </div>
                
            </div>
        </div>
    </body>
</html>
