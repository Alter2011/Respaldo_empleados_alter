<!--
<html>
    <body>    
-->
<?php


  $m=substr($fechaM, 0,2); 
 //arreglo para saber el mes del año
 $months = array (1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Jul',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'); 
// echo $months[(int)$m]; 

  ?>
  <style type="text/css">
.row{
    overflow:scroll;
    position:absolute;
}
  </style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">
            <div class="text-center well text-white blue no-print">
                <h2> Reporte Consolidado Gerencial</h2>
            </div>
   <form action="<?php echo base_url("index.php/Seguimiento/ReporteRC"); ?>" method="POST">

            <div class="col-sm-12">
                <div class="col-sm-5">
                    <label>Fecha inicio:</label>
                    <input type="date" class="form-control" name="fecha1" value="<?php echo $inicio ?>">
                </div>
                <div class="col-sm-5">
                    <label>Fecha fin:</label>
                     <input type="date" class="form-control" name="fecha2" value="<?php echo $fin ?>">
                </div>
                <div class="col-sm-2">
                    <br>
                     <button type="submit" class="btn btn-warning">Filtrar</button>


                </div>
            </div>
    </form>
            <div class="col-sm-12">
                <br>
            </div>  
            <h4>Inicio: <?php echo $inicio ?> Fin: <?php echo $fin ?></h4>
            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">
                    <table class="table" class="tablesorter" id="myTable">
                        <thead class="text-center">
                            <tr>
                                <th>Region</th>
                                <th>Empresa</th>
                                <th>Agencia</th>
                                <th>Nombre</th>
                                <th>Cartera</th>
                                <th>M.Cartera <?=$fechaMAA;?></th>
                                <th>M.Cartera <?=$fechaMA;?></th>
                                <th>M.Cartera <?=$fechaM;?> </th>
                                <th>Presupuesto <?=$fechaM;?> </th>
                                <th>Cartera Media <?=$months[(int)$m];?></th>
                                <th>M.Operaciones <?=$months[(int)$m];?></th>
                                <th>Cartera efectiva presupuestada  <?=$fechaM;?></th>
                                <th>Cartera efectiva real  <?=$fechaM;?></th>
                                <th>DIF CE real- CE ppto  <?=$fechaM;?></th>

                                <th>#Clientes <?=$fechaM;?></th>
                                <th>#Clientes activos <?=$fechaM;?></th>

                                <th>Total Colocacion Nuevos <?=$months[(int)$m];?></th>
                                <th>Total <br> Colocacion <?=$months[(int)$m];?></th>
                                <th>Capital recuperado <br><?=$fechaM;?></th>
                                <th>Indice mora <?=$fechaMA;?></th>
                                <th>Indice mora <?=$fechaM;?></th>
                                <th>Indice mora proyectado <?=$fechaM;?> </th>

                                <th>Promedio Indice mora <br><?=$fechaM;?></th>
                                <th>Capital en Mora <br><?=$fechaM;?></th>
                                <th>Capital vencido <br><?=$fechaM;?></th>

                                <th>Clientes vencidos <br><?=$fechaM;?> </th>
                                
                            </tr>
                        </thead>

               <?php 
                                if (!empty($Datos)) {

                for ($k=1; $k <= count($regiones) ; $k++) {  
                           

                            ?>
                        <tbody>
                            <?php
                        
                            //print_r($Datos[6]);
                            $contador=0;//contador de los colores
                            $contAG=0;//contador de sumatoria de sucursales por agencia
                            $color="";//variable para poner el color
                            $totCarT=0;//total de carteras (el promedio de carteras)
                            $totOPT=0;
                            $totNC=0;//total nuevos clientes
                            $totNCT=0;//total de totales de clientes
                            $agencia='';
                            $totOP=0;  //total operaciones
                            $totCar=0;//total 
                             $totales=0;           
                             $stotC=0;//sub total cartera actual
                             $stmoraC=0;//sub total de la mora de cartera actual
                             $tmoraC=0;//total de la mora de cartera actual

                             $stotCA=0;//sub total cartera anterior
                             $stmoraCA=0;//sub total de la mora de cartera anterior anterior
                             $tmoraCA=0;//sub total de la mora de cartera anterior anterior

                             $stotCAA=0;//sub total cartera anterior anterior
                             $stotNuC=0;//sub total nuevos clientes
                             $stotNaC=0;//sub total clientes activos

                             $stotM=0;//sub total mora
                             $stotCAV=0;//sub total capital vencido
                             $stotCAR=0;//sub total capital recuperado
                             $stotCLV=0;//sub total clientes vencdiso
                             $stotPA=0;//sub total presupuesto actual
                             $stotPCE=0;//sub total presupuesto cartera efectiva actual
                             $stotCE=0;//sub total presupuesto cartera efectiva actual
                             $stotPCE_CE=0;//sub total presupuesto cartera efectiva actual


                             $stotCL=0;//sub total colocacion

                             $stotIM=0;//sub total indice de mora proyectado
                             $contIMP=0;//contador de agencias para el Indice de Mora Previsto


                             //
                             $totIM=0;//total indice de mora proyectado

                             $totC=0;//total cartera actual
                             $totCA=0;//total cartera anterior
                             $totCAA=0;//total cartera anterior anterior
                             $totPA=0;//total presupuesto anterior 
                             $totPCE=0;//total presupuesto  cartera efectiva anterior 
                             $totCE=0;//total  cartera efectiva anterior 
                             $totPCE_CE=0;//total  cartera efectiva anterior 


                             $TcontIMP=0;
                             $totNuC=0;//total nuevos clientes
                             $totNaC=0;//total  clientes activos

                             $totM=0;//total mora
                             $totCAV=0;//total capital vencido
                             $totCAR=0;//total capital recuperado
                             $totCLV=0;//total clientes vencdiso
                             $totCL=0;//total colocacion

                            foreach ($agencias as $key=>$valor) {
                             @$agenc=substr($valor->id_cartera, 0,2);
                                
                            if (in_array($agenc,$regiones[$k],false)) {   
                                
                           
                                if ($color!=$valor->agencia) {
                                    $color=$valor->agencia;
                                    $contador++;
                                
                                    if ($contador!=1) {
                            ?>
                            <tr class="table-light">
                                <td>REGION <?=$k?></td>
                                 <td><?=$empresas[$k][$agenc]?></td>
                                <td>SUB TOTALES</td>
                                <td><?=$agencia;?></td>
                                <td></td>
                                <td> <?=(number_format(abs($stotCAA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotC), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotPA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totCar), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totOP), 2, '.', ',')) ; ?> </td>
                                <td><?=(number_format(abs($stotPCE), 2, '.', ',')) ; ?> </td>
                                <td><?=(number_format(abs($stotCE), 2, '.', ',')) ; ?> </td>
                                <td><?=(number_format($stotPCE_CE, 2, '.', ',')) ; ?> </td>


                                <td> <?=abs($stotNuC); ?> </td>
                                <td> <?=abs($stotNaC); ?> </td>

                                <td> <?=(number_format(abs($totNC), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCL), 2, '.', ',')) ; ?> </td>
                              
                                <td> <?=(number_format(abs($stotCAR), 2, '.', ',')) ; ?> </td>
                                <td><?=number_format((($stmoraCA/$stotCA)*100), 2, '.', ',').'%' ?></td>
                                <td><?=number_format((($stmoraC/$stotC)*100), 2, '.', ',').'%' ?></td>
                                <td><?=(number_format(abs($stotIM/$contIMP), 2, '.', ',')).'%' ; ?></td>
                                <td><?=number_format((($stotM/$totCar)*100), 2, '.', ',').'%' ?></td>
                                
                                <td> <?=(number_format(abs($stotM), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCAV), 2, '.', ',')) ; ?> </td>
                                
                                <td> <?=$stotCLV ; ?> </td>
                            </tr> 
                            <?php
                           
                           $agencia=''; 
                           $totOP=0; 
                            $totNC=0;
                            $stotC=0;
                            $stotCA=0;
                            $contAG=0;
                            $stotCAA=0;
                            $stmoraCA=0;
                            $stotPA=0;
                            $stotPCE=0;
                            $stotCE=0;
                            $stotPCE_CE=0;


                            $stotPCL=0;

                            $stmoraC=0;
                            $stotNuC=0;
                            $stotNaC=0;

                             $stotM=0;
                             $stotCAV=0;
                             $stotCAR=0;

                             $stotCL=0;
                             $stotIM=0;

                             $contIMP=0;
                             $stotCLV=0; 
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
                                                       
                             
                                $nuevos=0;
                                $clientesn=0;
                                $mora2=0;
                                $mora=0;
                                $capitalv=0;
                                $capitalr=0;
                                 $montOp=0;
                                $clientesv=0;
                                $contAG++;//contador de sumatoria de sucursales por agencia
                                    // code...
                                
                                  for ($j=0; $j < count($Datos) ; $j++) { 
                                    if ($Datos[$j]->car==$valor->id_cartera) {
                                $mora=abs(number_format(($Datos[$j]->mora), 2, '.', ' '));

                                $agencia=$Datos[$j]->agencia;           
                                $totCar+=$Datos[$j]->cartera2;
                                $montOp=$Datos[$j]->cartera2*((100-$Datos[$j]->mora)/100);
                                $totCarT+=$Datos[$j]->cartera2;
                                //colocacion de nuevos clientes
                                        $totNC+=$Datos[$j]->nuevos;

                                        $totNCT+=$Datos[$j]->nuevos;

                                       $nuevos=$Datos[$j]->nuevos;
                                        
                                   @ $totOPT+=$montOp;
                                   //COLOCACION

                                $totOP+=$montOp;
                                    }}      
                                    $agenia_aux=$agenc;   //saber en cual entro por ultima ves                                                    

                            ?>
                            <tr class="<?=$clase;?>">
                                <td>Region <?=$k?></td>
                                <td><?=$empresas[$k][$agenc]?></td>

                                <td><?=@strtoupper($valor->agencia);?></td>
                                       <?php 
                                $aux=0;
                                $cartera2=0;
                                for ($j=0; $j < count($Datos) ; $j++) { 
                                    if ($Datos[$j]->car==$valor->id_cartera) {
                                        $aux++;
                                        $cartera2=$Datos[$j]->cartera2;


                                       ?>
                                <td><?=@$Datos[$j]->nombre;?></td>
                                       <?php
                                    };
                                    }

                                    if ($aux==0) {
                                    echo "<td>".strtoupper($valor->nombre)."</td>";
                                    }
                                ?>
                                <td><?=strtoupper($valor->cartera);?></td>

                            
                                    <?php 
                                $aux=0;

                                for ($j=0; $j < count($cierreMAA) ; $j++) { 
                                    if ($cierreMAA[$j]->sucursal==$valor->id_cartera) {
                                        $aux++;
                                         $stotCAA+=$cierreMAA[$j]->cartera;

                                 $totCAA+=$cierreMAA[$j]->cartera;//total cartera anterior anterior

                                       ?>
                                <td><?= @number_format($cierreMAA[$j]->cartera, 2, '.', ',');?></td>
                                       <?php
                                    };
                                    }

                                    if ($aux==0) {
                                    echo "<td>0</td>";
                                    }
                                ?>
                                <?php 
                                $aux=0;
                                $indiceMA=0;
                                for ($j=0; $j < count($cierreMA) ; $j++) { 
                                    if ($cierreMA[$j]->sucursal==$valor->id_cartera) {
                                        $aux++;
                                        $indiceMA=$cierreMA[$j]->mora;
                                        $stotCA+=$cierreMA[$j]->cartera;
                                        $stmoraCA+=$cierreMA[$j]->mora2;
                                        $tmoraCA+=$cierreMA[$j]->mora2;


                                        $totCA+=$cierreMA[$j]->cartera;//total cartera anterior
                                       ?>
                                <td><?= @number_format($cierreMA[$j]->cartera, 2, '.', ',');?></td>
                                       <?php
                                    };
                                    }

                                    if ($aux==0) {
                                    echo "<td>0</td>";
                                    }
                                ?>
                               <?php 
                                $aux=0;
                                $indiceM=0;
                                $cartera_mes=0;
                                for ($j=0; $j < count($cierreM) ; $j++) { 
                                    if ($cierreM[$j]->sucursal==$valor->id_cartera) {
                                        //DATOS DE MES ACTUAL
                                        $aux++;
                                        $indiceM=$cierreM[$j]->mora;
                                        $stotC+=$cierreM[$j]->cartera;
                                        $stmoraC+=$cierreM[$j]->mora2;
                                        $tmoraC+=$cierreM[$j]->mora2;
                                         $totC+=$cierreM[$j]->cartera;//total cartera actual
                                        $cartera_mes=$cierreM[$j]->cartera;//cartera del mes actual
                                        
                                       //capital vencido del mes actual
                                        $capitalv=$cierreM[$j]->capitalv;
                                        $stotCAV+=$capitalv;
                                        $totCAV+=$capitalv;//total capital vencido
                                        //capital recuperado
                                        $capitalr=$cierreM[$j]->cap_recup;
                                        $stotCAR+=$capitalr;
                                        $totCAR+=$capitalr;//total capital vencido
                                        //mora vencido del mes actual
                                        $mora2=$cierreM[$j]->mora2;
                                        $stotM+=$cierreM[$j]->mora2;
                                        $totM+=$cierreM[$j]->mora2;//total mora

                                        //total de nuevos clientes 
                                        $clientesn=$cierreM[$j]->clientesn;
                                        $stotNuC+=$cierreM[$j]->clientesn;
                                        $totNuC+=$cierreM[$j]->clientesn;//total nuevos clientes



                                        //colocacion
                                        $colocacionA=$cierreM[$j]->colocacion;
                                        //subtotal colocacion
                                        $stotCL+=$cierreM[$j]->colocacion;

                                        /**/
                                        $clientesv=$cierreM[$j]->clientesv;
                                    
                                        $stotCLV+=$cierreM[$j]->clientesv; 

                                         $totCLV+=$cierreM[$j]->clientesv;
                                        $totCL+=$cierreM[$j]->colocacion;

                                           //total de nuevos clientes 
                                        $clientesAct=$cierreM[$j]->clientesn-$cierreM[$j]->clientesv;
                                        $stotNaC+=$cierreM[$j]->clientesn-$cierreM[$j]->clientesv;
                                        $totNaC+=$cierreM[$j]->clientesn-$cierreM[$j]->clientesv;//total nuevos clientes

                             //total clientes vencdiso 
                                        //colocacion de nuevos clientes
                                       /* $totNC+=$cierreM[$j]->nuevos;

                                        $totNCT+=$cierreM[$j]->nuevos;

                                       $nuevos=$cierreM[$j]->nuevos;*/





                                       ?>
                                <td><?= @number_format($cierreM[$j]->cartera, 2, '.', ',');?></td>
                                       <?php
                                    };
                                    }

                                    if ($aux==0) {
                                    echo "<td>0</td>";
                                    }
                                ?>
                            
                                
                        
                                <?php 
                                 $aux=0;
                                 $presupuestoCE=0;
                                for ($j=0; $j < count($presupuestadoM) ; $j++) { 
                                    if ($presupuestadoM[$j]->cartera==$valor->id_cartera) {
                                        $aux++;
                                       $stotPA+=$presupuestadoM[$j]->presupuestado;
                                       $totPA+=$presupuestadoM[$j]->presupuestado;
                                       $indiceE=100-$presupuestadoM[$j]->indice_eficiencia;
                                       $stotIM+=100-$presupuestadoM[$j]->indice_eficiencia;
                                       $contIMP++;
                                       $totIM+=100-$presupuestadoM[$j]->indice_eficiencia;
                                       $TcontIMP++;
                                       $presupuestoCE=$presupuestadoM[$j]->cartera_efectiva;//Presupuesto de la cartera efectiva
                                       $stotPCE+=$presupuestadoM[$j]->cartera_efectiva;

                                        $totPCE+=$presupuestadoM[$j]->cartera_efectiva;//total presupuesto  cartera efectiva anterior 

                                       ?>
                                <td><?= @number_format($presupuestadoM[$j]->presupuestado, 2, '.', ',');?></td>
                                         <?php
                                    };
                                 }
                                $indiceEF=(100-$indiceM)/100;
                                $cartera_efectiva=$cartera_mes*$indiceEF;
                                $dif_CE=$cartera_efectiva-$presupuestoCE;//DIFERENCIA ENTRE CARTERAS EFECTIVAS
                                $stotCE+=$cartera_efectiva;
                                $stotPCE_CE+= $dif_CE;
                                $totCE+=$cartera_efectiva;

                                $totPCE_CE+= $dif_CE;

                                    if ($aux==0) {
                                        echo "<td>0</td>";
                                    }
                                ?>

                                <td><?= @number_format($cartera2, 2, '.', ',');?></td>
                                <td> <?=(number_format(abs($montOp), 2, '.', ',')) ; ?> </td>
                                 <td><?= @number_format($presupuestoCE, 2, '.', ',');?></td>
                                 <td><?= @number_format($cartera_efectiva, 2, '.', ',');?></td>
                                 <td><?= @number_format($dif_CE, 2, '.', ',');?></td>


                                <td><?= @@number_format($clientesn, 0, '.', ',');?></td>
                                <td><?= @@number_format($clientesAct, 0, '.', ',');?></td>

                                <td><?= @number_format($nuevos, 2, '.', ',');?></td>
                                <td><?= @number_format($colocacionA, 2, '.', ',');?></td>
                                
                                <td><?= @number_format($capitalr, 2, '.', ',');?></td>
                                <td><?= @number_format($indiceMA, 2, '.', ',').'%';?></td>
                                <td><?= @number_format($indiceM, 2, '.', ',').'%';?></td>
                                <td><?= @number_format($indiceE, 2, '.', ',').'%';?></td>

                                <td><?=$mora.'%';?></td>
                                <td><?= @number_format($mora2, 2, '.', ',');?></td>
                                <td><?= @number_format($capitalv, 2, '.', ',');?></td>
                                
                                <td><?= @$clientesv;?></td>
                             
                            </tr>

                            <?php
                            
                                }
                            }
                      
                      ?>
                        
                    <?php  
                    ?>  
                            <tr class="table-light">
                                <td>REGION <?=$k?></td>
                                <td><?=$empresas[$k][$agenia_aux]?></td>
                                <td>SUB TOTALES</td>
                                <td><?=$agencia;?></td>
                                <td></td>                             
                                <td> <?=(number_format(abs($stotCAA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotC), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotPA), 2, '.', ',')) ; ?> </td>
                                
                                <td> <?=(number_format(abs($totCar), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totOP), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotPCE), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCE), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format($stotPCE_CE, 2, '.', ',')) ; ?> </td>


                                <td> <?=abs($stotNuC); ?> </td>
                                <td> <?=abs($stotNaC); ?> </td>

                                <td> <?=(number_format(abs($totNC), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCL), 2, '.', ',')) ; ?> </td>
                                
                                <td> <?=(number_format(abs($stotCAR), 2, '.', ',')) ; ?> </td>
                                 <td><?=@number_format((($stmoraCA/$stotCA)*100), 2, '.', ',').'%' ?></td>
                                <td><?=@number_format((($stmoraC/$stotC)*100), 2, '.', ',').'%' ?></td>
                                  <td><?=(number_format(abs($stotIM/$contIMP), 2, '.', ',')).'%' ; ?></td>
                                

                                <td><?=@number_format((($stotM/$totCar)*100), 2, '.', ',').'%' ?></td>
                                <td> <?=(number_format(abs($stotM), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($stotCAV), 2, '.', ',')) ; ?> </td>
                                
                                <td> <?=$stotCLV ; ?> </td>     
                            </tr> 
                          <tr class="table-light">
                                <td>REGION <?=$k?></td>
                                <td></td>
                                <td>TOTALES</td>
                                <td></td>
                                <td></td>
                                <td> <?=(number_format(abs($totCAA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totCA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totC), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totPA), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totCarT), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totOPT), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totPCE), 2, '.', ',')) ; ?> </td>
                                <td><?=(number_format(abs($totCE), 2, '.', ',')) ; ?> </td>
                                <td><?=(number_format($totPCE_CE, 2, '.', ',')) ; ?> </td>
                              



                                <td> <?=abs($totNuC); ?> </td>
                                <td> <?=abs($totNaC); ?> </td>

                                <td> <?=(number_format(abs($totNCT), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totCL), 2, '.', ',')) ; ?> </td>
                                
                                <td> <?=(number_format(abs($totCAR), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format((($tmoraCA/$totCA)*100), 2, '.', ',')).'%'; ?></td>
                                <td> <?=(number_format((($tmoraC/$totC)*100), 2, '.', ',')).'%'; ?></td>
                                <td><?=(number_format(abs($totIM/$TcontIMP), 2, '.', ',')).'%' ; ?></td>
                                <td> <?=(number_format((($totM/$totCarT)*100), 2, '.', ',')).'%'; ?></td>
                                <td> <?=(number_format(abs($totM), 2, '.', ',')) ; ?> </td>
                                <td> <?=(number_format(abs($totCAV), 2, '.', ',')) ; ?> </td>
                               
                                <td> <?=$totCLV ; ?> </td>

                              </tr> 
                    <?php
                }
                        } ?>
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
