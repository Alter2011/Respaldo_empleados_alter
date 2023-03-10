<?php
header('content-type application/vnd.ms-excel');
header("Content-Disposition: attachment; Filename=ISSS.xls");
?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script type="text/javascript" src="jquery.tablesorter.js"></script> 
        <div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">

            <div class="row">
                <div class=" col-sm-12 col-md-12 table-responsive">

                    <table class="table table-bordered" id="myTable" border="1">
                        <thead class="text-center">
                            <tr>
                                <th><center>Agencia</center></th>
                                <th><center>Numero Patronal</center></th>
                                <th><center>Periodo</center></th>
                                <th><center>Cor</center></th>
                                <th><center>Num Afiliacion</center></th>
                                <th><center>Nombre de Afiliado</center></th>
                                <th><center>Salario</center></th>
                                <th><center>5 Ceros</center></th>
                                <th><center>Vacaciones</center></th>
                                <th><center>Dias</center></th>
                                <th><center>Horas</center></th>
                                <th><center>D. Vacacion</center></th> 
                                <th><center>Cod</center></th>                               
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php          
                            foreach($isss as $key ){ 
                                ?>

                            <tr>
                                <td><?=$key['agencia'];?></td>
                                <td><?=$key['empresa'];?></td>
                                <td><?=$key['periodo'];?></td>
                                
                                <td style="mso-number-format:'000';"><?php echo "001";?></td>
                                <td><?=$key['isss'];?></td>
                                <td><?=(strtoupper($key['empleado']));?></td>

                                <td style="mso-number-format:'000000000';"><?=str_pad(number_format($key['sueldo'], 2, '', ''), 9, '0', STR_PAD_LEFT);?></td>

                                <td style="mso-number-format:'000000000';">000000000</td>

                                <td style="mso-number-format:'000000000';"><?=str_pad(number_format($key['vacacion'], 2, '', ''), 9, '0', STR_PAD_LEFT);?></td>

                                <td style="mso-number-format:'00';"><?=str_pad($key['dias'], 2, '0', STR_PAD_LEFT);?></td>
                                <td style="mso-number-format:'00';"><?=$key['horas'];?></td>
                                <td style="mso-number-format:'00';"><?=str_pad($key['diasVaca'], 2, '0', STR_PAD_LEFT);?></td>
                                <td style="mso-number-format:'00';"><?=$key['codigo'];?></td>
                            </tr>
                             
                             <?php } ?>
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
