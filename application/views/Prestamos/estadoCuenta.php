<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Estado de Cuenta</h2>
                <a class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br>
            </div>
            
                        
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                        <table class="table table-bordered" id="tabla_boleta">
                          <thead>
                            <tr>
                              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="success">
                              <td><b>Nombre de Cliente</b></td>
                              <td><b>Agencia</b></td>
                              <td><b>Monto Otorgado</b></td>
                              <td><b>Cuota</b></td>
                              <td><b>Fecha Otorgado</b></td>
                              <td><b>Nombre del Prestamo</b></td>
                              <td><b>Plazo Quincena</b></td>
                              <td><b>Descripcion</b></td>
                            </tr>
                            <tr>
                              <td><?php echo($internos[0]->nombre);?> <?php echo($internos[0]->apellido);?></td>
                              <td><?php echo($internos[0]->agencia);?></td>
                              <td>$<?php echo($internos[0]->cantidad);?></td>
                              <td>$<?php echo($internos[0]->couta);?></td>
                              <td><?php echo($internos[0]->fecha_otorgado);?></td>
                              <td><?php echo($internos[0]->nombre_prestamo);?></td>
                              <td><?php echo($internos[0]->tiempo);?></td>
                              <td><?php echo($internos[0]->descripcion_prestamo);?></td>
                            </tr>
                          </tbody>
                        </table>

                        <?php if($amortizaciones != null){ ?>
                        <table class="table table-bordered" id="tabla_boleta">
                          <tbody>
                            <tr class="success">
                              <td><b>Meses</b></td>
                              <td><b>Saldo Anterior</b></td>
                              <td><b>Abono Capital</b></td>
                              <td><b>Interes Devengado</b></td>
                              <td><b>Abono Interes</b></td>
                              <td><b>Saldo Actual</b></td>
                              <td><b>Interes Pendiente</b></td>
                              <td><b>Fecha</b></td>
                              <td><b>Dias</b></td>
                              <td><b>Pago Total</b></td>
                            </tr>
                        <?php
                          foreach ($amortizaciones as $key){
                        ?>
                            <tr>
                                  <td><?php echo(substr($key->fecha_abono,0,7));?></td>
                                  <td><?php echo(number_format($key->saldo_anterior,2));?></td>
                                  <td><?php echo(number_format($key->abono_capital,2));?></td>
                                  <td><?php echo(number_format($key->interes_devengado,2));?></td>
                                  <td><?php echo(number_format($key->abono_interes,2));?></td>
                                  <td><?php echo(number_format($key->saldo_actual,2));?></td>
                                  <td>$0</td>
                                  <td><?php echo($key->fecha_abono);?></td>
                                  <td><?php echo($key->dias);?></td>
                                  <td><?php echo(number_format($key->pago_total,2));?></td>
                            </tr>

                        <?php } ?>
                          </tbody>
                        </table>
                    <?php }else{ ?>
                        <div class="panel panel-success">
                                <div class="panel-heading"><center><h4>Pagos de Prestamos internos</h4></center></div>
                                <div class="panel-body"><center><h5>No sean realizados pagos en este prestamo</h5></center></div>
                            </div>
                    <?php } ?>
                    </div>
                </div>
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){

        function impresion_bienes() {
            window.print();
        };

        $('.crear').click(function(){
            window.print();
        });
    });//Fin jQuery

</script>
</body>

</style>
</html>