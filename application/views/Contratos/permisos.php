<style type="text/css">
    @media print{
        #tabla_incapacidad{
            width: 700px;
            margin-top: 5%;
        }
        #firmas{
            float: left;
            padding-left: 10%;
        }
    }
</style>
<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Imprimir Boletas de Permisos</h2>
            </div>
                        
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                           <table class="table table-bordered" id="tabla_incapacidad">
                          <thead>
                            <?php if($permiso[0]->id_empresa == 1){ ?>
                                <tr>
                                  <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
                                </tr>
                            <?php }else if($permiso[0]->id_empresa == 2){ ?>
                                <tr>
                                  <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_permiso"></center></th>
                                </tr>
                            <?php }else if($permiso[0]->id_empresa == 3){ ?>
                                <tr>
                                  <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_permiso"></center></th>
                                </tr>
                            <?php }else{ ?>
                                <tr>
                                  <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
                                </tr>
                            <?php } ?>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="4"><?php echo($permiso[0]->fecha_ingreso);?></td>
                              <td colspan="6"><?php echo($permiso[0]->nombre);?> <?php echo($permiso[0]->apellido);?></td>
                            </tr>
                            <tr>
                              <td colspan="4"><b>Fecha</b></td>
                              <td colspan="6"><b>Nombre Completo del Empleado</b></td>
                            </tr>
                            <tr>
                              <td colspan="8"><b>Estado Actual del Empleado</b></td>
                            </tr>
                             <tr>
                              <td><b>Agencia:</b></td>
                              <td colspan="3"><?php echo($permiso[0]->agencia);?></td>
                              <td><b>Area:</b></td>
                              <td colspan="3"><?php echo($permiso[0]->area);?></td>
                            </tr>
                            <tr>
                              <td><b>Puesto:</b></td>
                              <td colspan="3"><?php echo($permiso[0]->cargo);?></td>
                              <td colspan="4"></td>
                            </tr>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="8"><b>Tramite o Gestion a Realizar</b> </td>
                            </tr>
                            <tr>
                                <td colspan="9">
                                    <h5>Incapacidad</h5>
                                </td>
                            </tr>

                            <tr>
                                <td rowspan="2"><b>Desde</b></td>
                                <td><?php echo(substr($permiso[0]->desde,8,2));?></td>
                                <td><?php echo(substr($permiso[0]->desde,5,2));?></td>
                                <td><?php echo(substr($permiso[0]->desde,0,4));?></td>

                                <td rowspan="2"><b>Hasta</b></td>
                                <td><?php echo(substr($permiso[0]->hasta,8,2));?></td>
                                <td><?php echo(substr($permiso[0]->hasta,5,2));?></td>
                                <td><?php echo(substr($permiso[0]->hasta,0,4));?></td>
                            </tr>
                            <tr>
                                <td><b>Dia</b></td>
                                <td><b>Mes</b></td>
                                <td><b>Año</b></td>

                                <td><b>Dia</b></td>
                                <td><b>Mes</b></td>
                                <td><b>Año</b></td>
                            </tr>

                            <tr>
                                <td colspan="8"><b>Justificacion:</b></td>
                            </tr>
                             <tr>
                                <td colspan="8"><?php echo($permiso[0]->descripcion);?></td>
                            </tr>
                             
                          </tbody>
                        </table>

                        <br><br><div class="row">           
                            <center>
                                <div class="col-md-4" id="firmas"><b>__________________________<br>Firma Autorizado</b></div>
                                <div class="col-md-4" id="firmas"><b>__________________________<br>Jefe Inmediato</b></div>
                                <div class="col-md-4" id="firmas"><b>__________________________<br>Empleado</b></div></center>
                        </div>

                    </div>
                </div>
            
            <a class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br>
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