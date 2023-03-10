<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Estado de Cuenta de Orden de Descuento</h2>
                <?php //<a class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br> ?>
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
                              <td><b>Cuota Quincenal</b></td>
                              <td><b>Fecha Otorgado</b></td>
                              <td><b>Nombre del Prestamo</b></td>
                              <td><b>Plazo Quincena</b></td>
                              <td><b>Descripcion</b></td>
                            </tr>
                            <tr>
                              <td><?php echo($personal[0]->nombre);?> <?php echo($personal[0]->apellido);?></td>
                              <td><?php echo($personal[0]->agencia);?></td>
                              <td> $ <?php echo number_format(($personal[0]->monto_total),2);?></td>
                              <td>$ <?php echo number_format(($personal[0]->cuota),2);?></td>
                              <td><?php echo($personal[0]->fecha_inicio);?></td>
                              <td><?php echo($personal[0]->nombre_banco);?></td>
                              <td><?php echo($personal[0]->total_quincenas);?></td>
                              <td><?php echo($personal[0]->descripcion);?></td>
                            </tr>
                          </tbody>
                        </table>

                        <?php if($amortizaciones != null){ ?>
                        <table class="table table-bordered" id="tabla_boleta">
                          <tbody>
                            <tr class="success">
                              <td><b>Meses</b></td>
                              <td><b>Saldo Anterior</b></td>
                              <td><b>Cantidad Abonada</b></td>
                              <td><b>Saldo Actual</b></td>
                              <td><b>Fecha</b></td>
                            </tr>
                        <?php
                          foreach ($amortizaciones as $key){
                        ?>
                            <tr>
                                  <td><?php echo(substr($key->fecha_abono,0,7));?></td>
                                  <td> $ <?php echo number_format(($key->monto_anterior),2); ?></td>
                                  <td> $ <?php echo number_format(($key->cantidad_abonada),2);?></td>
                                  <td> $ <?php echo number_format(($key->saldo),2);?></td>
                                  <td><?php echo $key->fecha_abono;?></td>
                            </tr>

                        <?php } ?>
                          </tbody>
                        </table>
                    <?php }else{ ?>
                        <div class="panel panel-success">
                                <div class="panel-heading"><center><h4>Pagos de Orden de Descuento a <?php echo($personal[0]->nombre_banco);?></h4></center></div>
                                <div class="panel-body"><center><h5>No sean realizados pagos en la orden de descuento</h5></center></div>
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