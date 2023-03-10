<style type="text/css" media="print">
    @page { 
        size: landscape;
    }
    .espacio{
        width: 50px;
        height: 50px;
    }
    .container{
        margin-top: 15px;
        margin-left: 10px;
        margin-right: 10px
    }
    .ocultar{
    display: none;
    }
    table{font-size:12px}
    #tabla{font-size:12px;}

    @media print {
        .logo_gob{
            width: 80px;
            height: 80px;
        }
    }
</style>

<?php
    if(!empty($descuento_personal)){
        $descuento_personal1=json_encode($descuento_personal);
    }else{
        $descuento_personal1="";
    }
    if(!empty($bonos)){
        $bonos1=json_encode($bonos);
    }else{
        $bonos1="";
    }
    if(!empty($horas_descuento)){
        $horas_descuento1=json_encode($horas_descuento);
    }else{
        $horas_descuento1="";
    }
    if(!empty($incapacidad)){
        $incapacidad1=json_encode($incapacidad);
    }else{
        $incapacidad1="";
    }
    if(!empty($prestamo_interno)){
        $prestamo_interno1=json_encode($prestamo_interno);
    }else{
        $prestamo_interno1="";
    }
    if(!empty($prestamo_per)){
        $prestamo_per1=json_encode($prestamo_per);
    }else{
        $prestamo_per1="";
    }
    if(!empty($anticipo)){
        $anticipo1=json_encode($anticipo);
    }else{
        $anticipo1="";
    }
    if(!empty($horas_extras)){
        $horas_extras1=json_encode($horas_extras);
    }else{
        $horas_extras1="";
    }
    if(!empty($descuenta_herramienta)){
        $descuenta_herramienta1=json_encode($descuenta_herramienta);
    }else{
        $descuenta_herramienta1="";
    }
    if(!empty($faltante)){
        $faltante1=json_encode($faltante);
    }else{
        $faltante1="";
    }
    if(!empty($orden_descuento)){
        $orden_descuento1=json_encode($orden_descuento);
    }else{
        $orden_descuento1="";
    }
    if(!empty($viaticos)){
        $viaticos1=json_encode($viaticos);
    }else{
        $viaticos1="";
    }
    if(!empty($prestamos_siga)){
        $prestamos_siga1=json_encode($prestamos_siga);
    }else{
        $prestamos_siga1="";
    }
    if(!empty($planilla)){
        $planilla1=json_encode($planilla);
    }else{
        $planilla1="";
    }

?>

        <div class="container col-sm-12 col-xs-12 print-col-sm-12" id="imprimir">
            <div class="text-center well text-white blue no-print">
                
                <?php if($planilla != null){ ?>
                <h2>Planilla de la agencia <?php echo($planilla[0]->agencia); ?></h2>

            <?php }else{
                echo '<h2>Planilla</h2>';
            } ?>
            </div>
             <?php if($planilla != null){ ?>
            <!--PONER VALIDACION PARA NO MOSTRAR ERRORES-->

                       
                            <?php
                            $totalDias=0;
                            $totalSalario=0;
                            $totalPrest=0;
                            $totalDeven=0;
                            $totalIsss=0;
                            $totalAfp=0;
                            $totalIsr=0;
                            $totalPrestH=0;
                            $totalPrestP=0;
                            $totalOrden=0;
                            $totalHorasDes=0;
                            $totalAnticipo=0;
                            $totalFaltante=0;
                            //NO10012023 bono es para comisiones y gratificaciones es para gratificaciones
                            $totalBono=0;
                            $totalGratificaciones = 0;
                            $totalHorasExt=0;
                            $totalViatico=0;
                            $totalVacion=0;
                            $totalPagar=0;


                            $subtotalDias=0;
                            $subtotalSalario=0;
                            $subtotalPrest=0;
                            $subtotalDeven=0;
                            $subtotalIsss=0;
                            $subtotalAfp=0;
                            $subtotalIsr=0;
                            $subtotalPrestH=0;
                            $subtotalPrestP=0;
                            $subtotalOrden=0;
                            $subtotalHorasDes=0;
                            $subtotalAnticipo=0;
                            $subtotalFaltante=0;
                            //NO09012023 bono es para las comisiones y gratificaciones es para lo que su nombre indica
                            $subtotalBono=0;
                            $subtotalGratificaciones = 0;

                            $subtotalHorasExt=0;
                            $subtotalViatico=0;
                            $subtotalVacion=0;
                            $subtotalPagar=0;
                            $i=0;
                            $k=0;
                            $l=0;
                            $aux=count($planilla);
                            foreach ($planilla as $key) {
                                if ($i==0) { ?>
                                     <center>

                <!--<img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso">-->
                <?php 
                    if ($planilla[0]->isss == 0 && $planilla[0]->viaticos == 0 && $planilla[0]->dias > 0) { 
                        $entrega="";
                         if ($key->mes=="2020-11") {
                            $entrega="Primera entrega del subsidio del Gobierno";
                        }else if($key->mes=="2020-12"){
                            $entrega="Segunda entrega del subsidio del Gobierno";
                        }
                ?>
                    <h4>
                        Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento
                        <br>a la ley de Protección del Empleo Salvadoreño otorgado por el Gobierno de El Salvador. 
                        <br>En cumplimiento al DL. N° 641 y el DL. N° 685
                        <?php echo "<br>".$entrega; ?>
                    </h4>
                <?php
                    }else{
                 ?>
                    <h3><?php echo(strtoupper($planilla[0]->nombre_empresa)); ?></h3>
                    <br>
                 <?php 
                    }
                  ?>
                <?php 
                    if ($planilla[0]->isss == 0 && $planilla[0]->viaticos == 0 && $planilla[0]->dias > 0) { 
                    //agregando logo de El Salvador
                ?>
                    <div class="row">
                        <div class="col-sm-4" >
                            <img src="<?= base_url();?>/assets/images/logo_sv.png" width="80px" class="logo_gob">
                        </div>
                        <div class="col-sm-4" >
                            <h4>PLANILLA DE SALARIOS OFICINA <?php echo(strtoupper($planilla[0]->agencia)); ?></h4>
                            <h4><?php echo($tiempo);?></h4>
                        </div>
                        <div class="col-sm-4" >
                            <?php 
                                if ($planilla[0]->id_empresa==1) { ?>
                                    <img src="<?= base_url();?>/assets/images/watermark.png" style="width:140px; margin-top:25px" id="logo_permiso">
                               <?php }else if ($planilla[0]->id_empresa==2) { ?>
                                   <img src="<?= base_url();?>/assets/images/AlterOcci.png" style="width:140px; margin-top:25px" id="logo_permiso">
                                <?php }else if ($planilla[0]->id_empresa==3) { ?>
                                    <img src="<?= base_url();?>/assets/images/secofi_logo.png" style="width:120px; margin-top:10px" id="logo_permiso">
                            <?php
                                }
                             ?>
                        </div>
                    </div>
                <?php
                    }else{
                ?>
                    <h4>PLANILLA DE SALARIOS OFICINA <?php echo(strtoupper($planilla[0]->agencia)); ?></h4>
                    <h4><?php echo($tiempo);?></h4>
                <?php
                    }//else para mostrar la planilla tal y como se ha mostrado siempre
                ?>
                
                <?php if($k == 0){ ?>
                    <br><br>
                <?php if ($imprimir==1) { ?>
                    <a class="btn btn-success btn-lg item_imprimir ocultar" id="imprimir" style="position:relative;bottom:55px;left: 450px">Imprimir</a>
                <?php } ?>

                <?php if($autorizado == 0 && $imprimir==1){ ?>
                    <a class="btn btn-success btn-lg item_autorizacion ocultar" style="position:relative;bottom:55px;left: 450px" data-toggle="modal" data-target="#Modal_aprobar_pla">Autorizar Planilla</a>
                <?php } ?>

                <?php if ($eliminar==1 and $bloqueo ==0 and $autorizado == 1) { ?>
                    <a class="btn btn-danger btn-lg ocultar" style="position:relative;bottom:55px;left: 450px" data-toggle="modal" data-target="#Modal_Eliminar_Re">Rechazar Planilla</a>

                <?php }else if($eliminar==1 and $bloqueo ==0 and $autorizado == 1){ ?>
                    <a class="btn btn-danger btn-lg ocultar" style="position:relative;bottom:55px;left: 450px" data-toggle="modal" data-target="#Modal_Eliminar_Re">Rechazar Planilla</a>
                <?php } ?>


                <?php $k=1; }  ?>
                
            </center>

           

            <div class="row">
                <div class=" col-sm-12 col-md-12 " id="tabla" style="font-size:13px">
                    <table style="font-size:13px" class="table"  id="myTable">
                        <thead class="text-center">
                            <tr>
                              <th rowspan="2">Nombre del Empleado</th>
                              <th rowspan="2">Dias</th>
                              <th rowspan="2">SalQ.</th>
                              <th rowspan="2">Bono</th>
                              <th rowspan="2"><strong>Devengado</strong></th>
                              <th colspan="5"><center>Descuentos Legales</center></th>
                              <th colspan="<?php if($bandera_interno){ echo '6'; }else{ echo '5'; } ?>"><center>Otros Descuentos</center></th>
                              <th rowspan="2" >Gratificaciones</th>
                              
                              <th rowspan="2"><strong>Total Pagar</strong></th>   
                            </tr>

                            <tr>
                                <th></th>
                                <th>ISSS</th>
                                <th>AFP</th>
                                <th>ISR</th>
                                <th></th>
                                <?php if($bandera_interno){ ?>
                                    <th>P. interno.</th>
                                <?php } ?>
                                <th >P. emp</th>
                                <th>Bancos</th>
                                <th>Descuento</th>                               
                                <th>Anticipo</th>
                                <th colspan="">Viaticos</th>
                                
                            </tr>
       
                        </thead>
                            <?php
                                 }
                                 $suel=(($key->salario_quincena/15)*$key->dias);
                                 if(round($suel,2)<=round($key->sueldo_bruto,2)){
                                    $suel = $key->sueldo_bruto+$key->comision+$key->bono;
                                 }else{
                                    $suel = $key->sueldo_bruto;
                                 }
                                ?>
                                 <tbody>

                                <tr class="success">
                                    <td><?=$key->nombre;?> <?=$key->apellido;?></td>
                                    <td><?=(number_format(abs($key->dias),2));?></td>
                                    <td><?=(number_format(abs($key->salario_quincena),2));?></td>
                                    <!-- NO10012023 comisiones -->
                                    <td><?=(number_format(abs($key->comision),2));?></td>

                                    <td><strong><?php echo (number_format(abs($suel),2)); ?></strong></td>
                                    <td></td>
                                    <td><?=(number_format(abs($key->isss),2));?></td>
                                    <td><?=(number_format(abs($key->afp_ipsfa),2));?></td>
                                    <td><?=(number_format(abs($key->isr),2));?></td>
                                    <td></td>
                                    <?php if($bandera_interno){ ?>
                                    <td><?=(number_format(abs($key->prestamo_interno),2));?></td>
                                    <?php } ?>
                                    <td><?=(number_format(abs($key->prestamo_personal),2));?></td>
                                    <td><?=(number_format(abs($key->orden_descuento),2));?></td>
                                    <td><?=(number_format(abs($key->horas_descuento),2));?></td>
                                    <td><?=(number_format(abs($key->anticipos),2));?></td>

                                    <td><?=(number_format(abs($key->viaticos),2));?></td>
                                    <!-- NO10012023 gratificaciones -->
                                    <td><?=(number_format(abs($key->bono),2));?></td>
                                    <td><strong><?=(number_format($key->total_pagar,2));?></strong></td>
                                </tr>

                            <?php
                                $subtotalDias += $key->dias;
                                $subtotalSalario += $key->salario_quincena;
                                $subtotalPrest += $key->comision + $key->bono;
                                //$subtotalDeven += $key->sueldo_bruto+$key->comision+$key->bono;
                                //$subtotalDeven += number_format($key->sueldo_bruto,2);
                                $subtotalDeven += $suel;
                                $subtotalIsss += $key->isss;
                                $subtotalAfp += $key->afp_ipsfa;
                                $subtotalIsr += $key->isr;
                                $subtotalPrestH += $key->prestamo_interno;
                                $subtotalPrestP += $key->prestamo_personal;
                                $subtotalOrden += $key->orden_descuento;
                                $subtotalHorasDes += $key->horas_descuento;
                                $subtotalAnticipo += $key->anticipos + $key->descuentos_faltantes;
                                $subtotalFaltante += $key->descuentos_faltantes;
                                //NO09012023 sumas de todas las comisiones y de todos los bonos
                                $subtotalBono += $key->comision;
                                $subtotalGratificaciones += $key->bono;

                                $subtotalHorasExt += $key->horas_extras;
                                $subtotalViatico += $key->viaticos;
                                //$subtotalPagar += str_replace(',','',number_format($key->total_pagar,2));
                                $subtotalPagar += str_replace(',','',$key->total_pagar);
                                
                                $i++;
                                $l++;
                                if ($i==8 && $l!=$aux) { ?>
                                
                                <tr class="table-light">
                                <td><strong>SUB TOTALES</strong></td>
                                <td><?=(number_format(abs($subtotalDias),2));?></td>
                                <td><?=(number_format(abs($subtotalSalario),2));?></td>
                                 <!-- NO10012023 comisiones -->
                                 <td><?=(number_format(abs($subtotalBono),2));?></td>
                                <td><strong><?=(number_format(abs($subtotalDeven),2));?></strong></td>
                                <td></td>
                                <td><?=(number_format(abs($subtotalIsss),2));?></td>
                                <td><?=(number_format(abs($subtotalAfp),2));?></td>
                                <td><?=(number_format(abs($subtotalIsr),2));?></td>
                                <td></td>
                                <?php if($bandera_interno){ ?>
                                <td><?=(number_format(abs($subtotalPrestH),2));?></td>
                                <?php } ?>
                                <td><?=(number_format(abs($subtotalPrestP),2));?></td>
                                <td><?=(number_format(abs($subtotalOrden),2));?></td>
                                <td><?=(number_format(abs($subtotalHorasDes),2));?></td>
                                <td><?=(number_format(abs($subtotalAnticipo),2));?></td>
                                
                                <td><?=(number_format(abs($subtotalViatico),2));?></td>
                                <!-- NO10012023 gratificaciones -->
                                <td><?=(number_format(abs($subtotalGratificaciones),2));?></td>
                                <td><strong><?=(number_format(abs($subtotalPagar),2));?></strong></td>
                            </tr>   
                  </tbody>
                    </table>
                </div>

            </div>
            <br><br>
                <div class="col-md-12" class="espacio">
                    <center>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Elaborado</b></div>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Autorizado</b></div>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Auditado</b></div>
                    </center>
                </div><br><br>
        </div>
        <div class="col-md-12" class="espacio">
                    <center><br>
                        <div class="col-md-6" style="position: relative; right:75px" id="jefe_inme"><h5><?php echo(strtoupper($planilla[0]->agencia)); ?>, <?php echo($fecha); ?></h5></div>
                        <div class="col-md-6" id="jefe_inme" style="position: relative; left:75px"><b>Creado Por<br><?php echo $usuario ?></b></div>
                    </center>
                </div>
                <div style="margin-top:15px;page-break-before: always">  
                            <?php 
                            $totalDias += $subtotalDias;
                            $totalSalario += $subtotalSalario;
                            $totalPrest += $subtotalPrest;
                            $totalDeven += $subtotalDeven;
                            $totalIsss += $subtotalIsss;
                            $totalAfp += $subtotalAfp;
                            $totalIsr += $subtotalIsr;
                            $totalPrestH += $subtotalPrestH;
                            $totalPrestP += $subtotalPrestP;
                            $totalOrden += $subtotalOrden;
                            $totalHorasDes += $subtotalHorasDes;
                            $totalAnticipo += $subtotalAnticipo + $subtotalFaltante;
                            // NO10012023 total para sacar bono y gratificaciones
                            $totalBono += $subtotalBono;
                            $totalGratificaciones += $subtotalGratificaciones;

                            $totalFaltante += $subtotalFaltante;
                            $totalHorasExt += $subtotalHorasExt;
                            $totalViatico += $subtotalViatico;
                            $totalVacion += $subtotalVacion;
                            $totalPagar += $subtotalPagar;


                            $subtotalDias=0;
                            $subtotalSalario=0;
                            $subtotalPrest=0;
                            $subtotalDeven=0;
                            $subtotalIsss=0;
                            $subtotalAfp=0;
                            $subtotalIsr=0;
                            $subtotalPrestH=0;
                            $subtotalPrestP=0;
                            $subtotalOrden=0;
                            $subtotalHorasDes=0;
                            $subtotalAnticipo=0;
                            //NO09012023
                            $subtotalBono=0;
                            $subtotalGratificaciones = 0;

                            $subtotalFaltante=0;
                            $subtotalHorasExt=0;
                            $subtotalViatico=0;
                            $subtotalVacion=0;
                            $subtotalPagar=0;
                               $i=0; 
                            }//fin del if cuando i==8
                              
                            } //fin del foreach

                            $totalDias += $subtotalDias;
                            $totalSalario += $subtotalSalario;
                            $totalPrest += $subtotalPrest;
                            $totalDeven += $subtotalDeven;
                            $totalIsss += $subtotalIsss;
                            $totalAfp += $subtotalAfp;
                            $totalIsr += $subtotalIsr;
                            $totalPrestH += $subtotalPrestH;
                            $totalPrestP += $subtotalPrestP;
                            $totalOrden += $subtotalOrden;
                            $totalHorasDes += $subtotalHorasDes;
                            $totalAnticipo += $subtotalAnticipo + $subtotalFaltante;
                            // NO10012023 total para bono y gratificaciones
                            $totalBono += $subtotalBono;
                            $totalGratificaciones += $subtotalGratificaciones;

                            $totalFaltante += $subtotalFaltante;
                            $totalHorasExt += $subtotalHorasExt;
                            $totalViatico += $subtotalViatico;
                            $totalVacion += $subtotalVacion;
                            $totalPagar += $subtotalPagar;
                             ?>

                            <tr class="table-light">
                                <td><strong>SUB TOTALES</strong></td>
                                <td><?=$subtotalDias;?></td>
                                <td><?=(number_format(abs($subtotalSalario),2));?></td>
                                <!-- NO10012023 subtotal para bono -->
                                <td><?=(number_format(abs($subtotalBono),2));?></td>

                                <td><strong><?=(number_format(abs($subtotalDeven),2));?></strong></td>
                                <td></td>
                                <td><?=(number_format(abs($subtotalIsss),2));?></td>
                                <td><?=(number_format(abs($subtotalAfp),2));?></td>
                                <td><?=(number_format(abs($subtotalIsr),2));?></td>
                                <td></td>
                                <?php if($bandera_interno){ ?>
                                <td><?=(number_format(abs($subtotalPrestH),2));?></td>
                                <?php } ?>
                                <td><?=(number_format(abs($subtotalPrestP),2));?></td>
                                <td><?=(number_format(abs($subtotalOrden),2));?></td>
                                <td><?=(number_format(abs($subtotalHorasDes),2));?></td>
                                <td><?=(number_format(abs($subtotalAnticipo),2));?></td>
                                

                                <td><?=(number_format(abs($subtotalViatico),2));?></td>
                                <!-- NO10012023 subtotal para gratificaciones -->
                                <td><?=(number_format(abs($subtotalGratificaciones),2));?></td>

                                <td><strong><?=(number_format(abs($subtotalPagar),2));?></strong></td>
                            </tr>

                            <tr class="table-light">
                                <td><strong>TOTALES</strong></td>
                                <td><?=$totalDias;?></td>
                                <td><?=(number_format(abs($totalSalario),2));?></td>
                                 <!-- NO10012023 total para bono -->
                                 <td><?=(number_format(abs($totalBono),2));?></td>

                                <td><strong><?=(number_format(abs($totalDeven),2));?></strong></td>
                                <td></td>
                                <td><?=(number_format(abs($totalIsss),2));?></td>
                                <td><?=(number_format(abs($totalAfp),2));?></td>
                                <td><?=(number_format(abs($totalIsr),2));?></td>
                                <td></td>
                                <?php if($bandera_interno){ ?>
                                <td><?=(number_format(abs($totalPrestH),2));?></td>
                                <?php } ?>
                                <td><?=(number_format(abs($totalPrestP),2));?></td>
                                <td><?=(number_format(abs($totalOrden),2));?></td>
                                <td><?=(number_format(abs($totalHorasDes),2));?></td>
                                <td><?=(number_format(abs($totalAnticipo),2));?></td>
                                

                                <td><?=(number_format(abs($totalViatico),2));?></td>
                                <!-- NO10012023 total para gratificaciones -->
                                <td><?=(number_format(abs($totalGratificaciones),2));?></td>
                                <td><strong><?=(number_format(abs($totalPagar),2));?></strong></td>
                            </tr>   
                  </tbody>
                    </table>
                </div>

            </div>


            <br><br>
                <div class="col-md-12" class="espacio">
                    <center>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Elaborado</b></div>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Autorizado</b></div>
                        <div class="col-md-4" id="jefe_inme"><b>__________________________<br>Auditado</b></div>
                    </center>
                </div><br>
        </div>
        <div class="col-md-12" class="espacio">
                    <center><br><br>
                        <div class="col-md-6" style="position: relative; right:75px" id="jefe_inme"><h5><?php echo(strtoupper($planilla[0]->agencia)); ?>, <?php echo($fecha); ?></h5></div>
                        <div class="col-md-6" id="jefe_inme" style="position: relative; left:75px"><b>Creado Por<br><?php echo $usuario ?></b></div>
                    </center>
                </div>
        <?php }else{ ?>

            <div class="alert alert-success">
                <center><div class="panel-heading"><h4><strong>Esta planilla no esta aprobada</strong></h4></div></center>
            </div>

        <?php 
        }
        ?>
    </body>
</html>
    <form action="<?= base_url();?>index.php/Planillas/aprobarPlanilla/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobacion de Planilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Aprobar esta Planilla?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="diaUno" id="diaUno" class="form-control" readonly value="<?= ($diaUno);?>">
                <input type="hidden" name="diaUltimo" id="diaUltimo" class="form-control" readonly value="<?= ($diaUltimo);?>">
                <input type="hidden" name="agencia" id="agencia" class="form-control" readonly value="<?= ($agencia);?>">
                <input type="hidden" name="empresa" id="empresaE" class="form-control" readonly value="<?= ($empresa);?>">
                <input type="hidden" name="planillaC" id="planillaC" class="form-control" readonly value="<?= ($planillaC);?>">
                <!--<input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>-->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_aprobar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
    </form>

    <form action="<?= base_url();?>index.php/Planillas/aprobar_planilla/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="modal fade" id="Modal_aprobar_pla" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel">Aprobacion de Planilla</h4></center>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea aprobar esta planilla?.</strong>
                </div>
                <div class="modal-footer">
                <input type='hidden' name='des_personal' id='des_personal' value='<?php echo $descuento_personal1 ?>' class="form-control" readonly>
                <input type='hidden' name='bonos' id='bonos' value='<?php echo $bonos1 ?>' class="form-control" readonly>
                <input type='hidden' name='horas_descuento' id='horas_descuento' value='<?php echo $horas_descuento1 ?>' class="form-control" readonly>
                <input type='hidden' name='incapacidad' id='incapacidad' value='<?php echo $incapacidad1 ?>' class="form-control" readonly>
                <input type='hidden' name='prestamo_interno' id='prestamo_interno' value='<?php echo $prestamo_interno1 ?>' class="form-control" readonly>
                <input type='hidden' name='prestamo_per' id='prestamo_per' value='<?php echo $prestamo_per1 ?>' class="form-control" readonly>
                <input type='hidden' name='anticipo' id='anticipo' value='<?php echo $anticipo1 ?>' class="form-control" readonly>
                <input type='hidden' name='horas_extras' id='horas_extras' value='<?php echo $horas_extras1 ?>' class="form-control" readonly>
                <input type='hidden' name='descuenta_herramienta' id='descuenta_herramienta' value='<?php echo $descuenta_herramienta1 ?>' class="form-control" readonly>
                <input type='hidden' name='faltante' id='faltante' value='<?php echo $faltante1 ?>' class="form-control" readonly>
                <input type='hidden' name='orden_descuento' id='orden_descuento' value='<?php echo $orden_descuento1 ?>' class="form-control" readonly>
                <input type='hidden' name='viaticos' id='viaticos' value='<?php echo $viaticos1 ?>' class="form-control" readonly>
                <input type='hidden' name='prestamos_siga' id='prestamos_siga' value='<?php echo $prestamos_siga1 ?>' class="form-control" readonly>
                <input type='hidden' name='planilla' id='planilla' value='<?php echo $planilla1 ?>' class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_aprobar" class="btn btn-primary" onclick="modal_gif()">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
    </form>

    <form action="<?= base_url();?>index.php/Planillas/elimiarPlanilla/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
        <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminacion de Planilla</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Eliminar esta Planilla?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="diaUnoE" id="diaUnoE" class="form-control" readonly value="<?= ($diaUno);?>">
                <input type="hidden" name="diaUltimoE" id="diaUltimoE" class="form-control" readonly value="<?= ($diaUltimo);?>">
                <input type="hidden" name="agenciaE" id="agenciaE" class="form-control" readonly value="<?= ($agencia);?>">
                <input type="hidden" name="empresaE" id="empresaE" class="form-control" readonly value="<?= ($empresa);?>">
                <input type="hidden" name="planillaC" id="planillaC" class="form-control" readonly value="<?= ($planillaC);?>">
                <!--<input type="hidden" name="userE" id="userE" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>-->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
            </div>
        </div>
    </form>

   <form enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="modal fade" id="Modal_Eliminar_Re" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">Rechazo de Planilla</h5>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea rechazar esta Planilla?</strong><br><br>
                    
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Contraseña:</label>
                    <div class="col-md-10">
                        <input type="password" name="contra" id="contra" class="form-control">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="diaUnoE" id="diaUnoE" class="form-control" readonly value="<?= ($diaUno);?>">
                    <input type="hidden" name="diaUltimoE" id="diaUltimoE" class="form-control" readonly value="<?= ($diaUltimo);?>">
                    <input type="hidden" name="agenciaE" id="agenciaE" class="form-control" readonly value="<?= ($agencia);?>">
                    <input type="hidden" name="empresaE" id="empresaE" class="form-control" readonly value="<?= ($empresa);?>">
                    <input type="hidden" name="planillaCl" id="planillaCl" class="form-control" readonly value="<?= ($planillaC);?>">
                    
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <a id="btn_eliminar2"  class="btn btn-danger" onclick="validar_pass()">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal GIF-->
  <div class="modal fade" id="modalGif" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">Cargando Por Favor Espere</h4>
        </div>
        <div class="modal-body" >
          <center><div class="lds-dual-ring"></div></center>
        </div>
       
      </div>
      
    </div>
  </div>

<script type="text/javascript">
    function modal_gif() {
        $("#Modal_aprobar_pla").modal('toggle');
        $('#modalGif').modal('show')
    }

    $(document).ready(function(){
        $('.item_imprimir').click(function(){  
            window.print();
        });
    });

    function validar_pass(){
        var contra = $('#contra').val();
        var diaUno = $('#diaUnoE').val();
        var diaUltimo = $('#diaUltimoE').val();
        var agencia = $('#agenciaE').val();
        var empresa = $('#empresaE').val();
        
       $.ajax({
            type  : 'POST',
            url:"<?php echo site_url('Planillas/validarRechazo')?>",
            dataType:"JSON",
            data:{contra:contra,diaUno:diaUno,diaUltimo:diaUltimo,agencia:agencia,empresa:empresa},
            success : function(data){
                console.log(data);
                if(data == null){
                    $("#Modal_Eliminar_Re").modal('toggle');
                    $('#modalGif').modal('show');
                    document.getElementById('validacion').innerHTML = '';
                   rechazar_planillas();

                }else{

                    document.getElementById('validacion').innerHTML = data;
                }
            }

        });
    }

    function rechazar_planillas(){
        var diaUno = $('#diaUnoE').val();
        var diaUltimo = $('#diaUltimoE').val();
        var agencia = $('#agenciaE').val();
        var empresa = $('#empresaE').val();
        var planillaCl = $('#planillaCl').val();

        $.ajax({
            type  : 'POST',
            url:"<?php echo site_url('Planillas/planilla_rechazo')?>",
            dataType:"JSON",
            data:{diaUno:diaUno,diaUltimo:diaUltimo,agencia:agencia,empresa:empresa,planillaCl:planillaCl},
            success : function(data){
                document.location.href ="<?php echo base_url();?>index.php/Planillas/mesaje_eliminar";
            }

        });
    }
</script>