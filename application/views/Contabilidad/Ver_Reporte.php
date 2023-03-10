<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Reporte de Cuentas Contables</h2>

                <form action="<?php echo base_url('index.php/Contabilidad/download'); ?>"  method="post" >
                  <input type="hidden" class="form-control" id="empresa" name="empresa" value="<?php echo $empresa; ?>">
                  <input type="hidden" class="form-control" id="agencia" name="agencia" value="<?php echo $agencia; ?>">
                  <input type="hidden" class="form-control" id="quincena" name="quincena" value="<?php echo $quincena; ?>">
                  <input type="hidden" class="form-control" id="mes" name="mes" value="<?php echo $mes; ?>">
                  <button type="submit" class="btn btn-success crear" id="btn_permiso" style="float: right;">Imprimir</button><br>
                </form>
            </div>
            
                        
                <div class="col-sm-12">
                    <div class="well">
                        <?php if($cuentas != null){ ?>
                          
                        <table class="table table-bordered" >
                          <tbody>
                            <tr class="success">
                              <td><b>Concepto</b></td>
                              <td><b>Valor</b></td>
                              <td><b>Cuenta</b></td>
                              <td><b>Valor</b></td>
                              <td><b>Cuenta</b></td>
                              
                            </tr>
                        <?php
                          for($i = 0; $i < count($cuentas); $i++){
                        ?>
                            <tr>
                              <td style="text-align: left;"><?php echo($cuentas[$i]['concepto']);?></td>
                              <td><?php echo($cuentas[$i]['cargo']);?></td>
                              <td><?php echo($cuentas[$i]['cuenta1']);?></td>
                              <td><?php echo($cuentas[$i]['abono']);?></td>
                              <td><?php echo($cuentas[$i]['cuenta2']);?></td>
                            </tr>

                        <?php
                      } ?>
                          </tbody>
                        </table>
                    <?php }else{ ?>
                        <div class="panel panel-success">
                                <div class="panel-heading"><center><h4>Reportes de Cuentas Contables</h4></center></div>
                                <div class="panel-body"><center><h5>En este momento no se puede Generar el reporte</h5></center></div>
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
    });//Fin jQuery

</script>
</body>

</style>
</html>