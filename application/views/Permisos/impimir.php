<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Imprimir Boletas de Permisos</h2>
            </div>
            
                        
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                           <table class="table table-bordered" id="tabla_boleta">
                          <thead>
                            <tr>
                              <th scope="col" colspan="8"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td colspan="2"><?php echo($permiso[0]->fecha_solicitud);?></td>
                              <td colspan="4"><?php echo($permiso[0]->nombre);?> <?php echo($permiso[0]->apellido);?></td>
                              <td colspan="2"><?php echo($permiso[0]->codigo_empleado);?></td>
                            </tr>
                            <tr>
                              <td colspan="2"><b>Fecha</b></td>
                              <td colspan="4"><b>Nombre Completo del Empleado</b></td>
                              <td colspan="2"><b>Cod. Empleado</b></td>
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
                              <td colspan="4">&nbsp;</td>
                              <td colspan="4">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="8"><b>Tramite o Gestion a Realizar</b> </td>
                            </tr>
                            <tr>
                                <input type="hidden" name="tramite" id="tramite" class="form-control" placeholder="Product Code" readonly value="<?php echo($permiso[0]->tipo_permiso);?>">
                                <td colspan="2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check1" class="check_imprimir" disabled>Permiso Con Goce de sueldo
                                    </label>
                                </td>
                                <td colspan="2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check2" class="check_imprimir" disabled>Mision Oficial
                                    </label>
                                </td>    
                                <td colspan="2">
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check3" class="check_imprimir" disabled>Ausencia injustificada
                                    </label>
                                </td>    
                                <td>    
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check4" class="check_imprimir" disabled>Compensatorio
                                    </label>
                                </td>
                                <td>    
                                    <label class="checkbox-inline" id="otros">
                                        <input type="checkbox" id="check9" class="check_imprimir" disabled>Otros
                                    </label>
                                </td>     
                            </tr>
                            <tr>    
                                <td colspan="2">    
                                    <label class="checkbox-inline">
                                        <input type="checkbox"id="check5" class="check_imprimir" disabled>Permiso Sin Goce de sueldo
                                    </label>
                                </td>    
                                <td colspan="2">    
                                    <label class="checkbox-inline">
                                        <input type="checkbox" id="check6" class="check_imprimir" disabled>Capacitacion
                                    </label>
                                </td>    
                                <td colspan="2">    
                                    <label class="checkbox-inline" id="incapacidad">
                                        <input type="checkbox" id="check7" class="check_imprimir" disabled>Incapacidad
                                    </label>
                                </td>    
                               
                                <td>    
                                   
                                </td>
                                
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
                                <td><b>Desde las</b></td>
                                <td colspan="3"><?php echo($desde);?></td>

                                <td><b>Hasta las</b></td>
                                <td colspan="3"><?php echo($hasta);?></td>
                            </tr>
                            <tr>
                                <td colspan="8"><b>Justificacion:</b></td>
                            </tr>
                             <tr>
                                <td colspan="8"><?php echo($permiso[0]->Justificacion);?></td>
                            </tr>
                             
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                                <td colspan="3"><b>Firma Empleado</b></td>
                            </tr>
                          </tbody>
                        </table>

                        <div class="row">           
                            <center><div class="col-md-6" id="firma_auto"><b>__________________________<br>Firma Autorizado</b></div></center>
                            <center><div class="col-md-6" id="jefe_inme"><b>__________________________<br>Jefe Inmediato</b></div></center>
                        </div>

                    </div>
                </div>
            
            <a href="#" class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br>
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
         show_data();
            function show_data(){
                var tramite = $('#tramite').val();

                 if(tramite == '1'){
                   $('#check1').prop('checked',true);
                }else if(tramite == '2'){
                    $('#check2').prop('checked',true);
                }else if(tramite == '3'){
                    $('#check3').prop('checked',true);
                }else if(tramite == '4'){
                    $('#check4').prop('checked',true);
                }else if(tramite == '5'){
                    $('#check5').prop('checked',true);
                }else if(tramite == '6'){
                    $('#check6').prop('checked',true);
                }else if(tramite == '7'){
                    $('#check7').prop('checked',true);
                }else if(tramite == '8'){
                    $('#check8').prop('checked',true);
                }else if(tramite == '9'){
                    $('#check9').prop('checked',true);
                }

        };//Fin show_data

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