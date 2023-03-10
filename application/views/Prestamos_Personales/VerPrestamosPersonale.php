<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Prestamos de Personales</h2>
            </div>
            <div class="row">
                 <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Ordenar Por:</label>
                                    <select class="form-control" name="orden" id="orden" class="form-control">
                                         <option value="1">Vigente</option>
                                         <option value="0">No Vigente</option>
                                         <option value="2">Solicitados</option>
                                         <option value="3">Rechazados</option>
                                         <option value="4">Congelados</option>
                                         <option value="5">Todos</option>
                                    </select>
                                </div>
                            </div>
                        </nav>
                        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
                        <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                                
                    </div>
                </div>
            </div>
            <div class="row">
                
            </div>
        </div>
    </div>
</div>


<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Abonar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Abonar a prestamo personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <!--<label class="col-md-2 col-form-label">Product Code</label>-->
                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 col-form-label">Cantidad a cancelar$:</label>
                <div class="col-md-9">
                    <input readonly type="text" name="cancelar" id="cancelar" class="form-control" placeholder="0.00">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label">Cantidad a abonar:</label>
                <div class="col-md-9">
                    <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="0.00">
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label">Fecha de abono:</label>
                <div class="col-md-9">
                    <input type="date" name="fecha_abono" id="fecha_abono" class="form-control" value="<?= date('Y-m-d') ?>">
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>

            </div>           
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_abono" class="btn btn-primary">Abonar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--Modal refinanciamiento-->
<form>
    <div class="modal fade" id="Modal_Refi" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Refinanciamiento prestamo personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div id="validacion6" style="color:red"></div>
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_refi" id="code_refi" class="form-control" placeholder="Product Code" readonly>
                    <input type="hidden" name="user_sesion" id="user_sesion" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Cantidad del Refinanciamiento:</label>
                    <div class="col-md-9">
                        <input type="text" name="cantidad_refi" id="cantidad_refi" class="form-control prestamo" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tiempo a Pagar </label>
                    <div class="col-md-9">
                        <input type="text" name="tiempo_refi" id="tiempo_refi" class="form-control prestamo" placeholder="0">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha Otorgado</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_refi" id="fecha_refi" class="form-control prestamo" placeholder="0">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrar" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_refinanciamiento" class="btn btn-primary btn_refinanciamiento" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            <!--Se utiliza para cuando se alguien que no sea admin pida una aprobacion de prestamos-->
            <center><div id="validacion5" style="color:red"></div>
            <button type="button" type="submit" id="btn_solicitud" class="btn btn-success solicitud" style="display: none;">Hacer Solicitud</button>
            <button type="button" class="btn btn-danger cancelar" id="btn_cancelar" style="display: none;">Cancelar</button></center>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--Modal refinanciamiento-->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de prestamos personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este prestamo?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="prestamo_code_cancelar" id="prestamo_code_cancelar" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!--Modal Desembolso-->
<form>
    <div class="modal fade" id="Modal_Desem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <center><h3 class="modal-title" id="exampleModalLabel">Desembolso de prestamo</h3></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div id="validacion6" style="color:red"></div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <div id="validacion_desem" style="color:red"></div>
                        <input type="hidden" name="code_desem" id="code_desem" class="form-control" placeholder="Product Code" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tipo de Desembolso</label>
                    <div class="col-md-8">
                        <select class="form-control" name="tipo_desem" id="tipo_desem" class="form-control">
                            <option value="1">Cheque</option>
                            <option value="2">Efectivo</option>
                            <option value="3">Transferencia</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha Otorgado</label>
                    <div class="col-md-8">
                        <input type="date" name="fecha_desem" id="fecha_desem" class="form-control">
                    </div>
                </div>

                <?php if($ver==1) { ?>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Agencia de Desembolso</label>
                        <div class="col-md-8">
                            <select class="form-control" name="id_agencia_pres" id="id_agencia_pres" class="form-control">
                                <?php
                                    $i=0;
                                    foreach($agencia as $a){
                                ?>
                                    <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                <?php
                                    $i++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                <?php }else{ ?>
                    <input type="hidden" name="id_agencia_pres" id="id_agencia_pres" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
                <?php } ?>

            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrar" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn_desembolso" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--Modal Desembolso-->

<!-- Llamar JavaScript -->

<script type="text/javascript">
    $(document).ready(function(){
        
        show_data();
        $('#orden').change(function(){
            show_data();
        });
        function show_data(){
            var orden = $('#orden').val();
            var id_empleado = $('#id_empleado').val();
            var desembolso = "";
            //alert(orden);
            var nombreAuto=[];
            var j = 0;
            var k = 0;
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('PrestamosPersonales/listarPrestamos')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado},
                success : function(data){
                    console.log(data);
                    for (i = 0; i < data.autorizacion.length; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                   $.each(data.prestamo,function(key, registro){
                    if(data.desembolso[k].conteo == 0){
                        desembolso = ' <a id="refi" class="btn btn-default btn-lg item_desem" data-codigo="'+registro.id_prestamo_personal+'">Desembolso</a>';
                    }else{
                        desembolso = '';
                    }

                    if (registro.estado == 1 && registro.aprobado == 1) {
                        $('#mostrar').append(
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading">'+
                            '<div class="col-md-11"><h4>Prestamo Vigente</h4></div>'+
                            '<a class="btn btn-default btn-sm item_eliminar" title="Autorizacion de Descuento/Orden de Descuento" href="<?php echo base_url();?>index.php/PrestamosPersonales/autorizacionDes/'+registro.id_prestamo_personal+'">'+
                            '<em class="glyphicon glyphicon-duplicate"></em>'+
                            '</a><br><br>'+                                  
                            '</div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Otorgada:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota Asignada:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Concesión:</strong> '+registro.fecha_otorgado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipos+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.plazo_quincenas+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Descripcion del Prestamo:</strong> '+registro.descripcion_prestamo+'</div>'+
                            '</div>'+
                            '<?php if ($cancelar==1 or $abono==1 or $estado==1 or $refinanciamiento==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<?php if ($estado==1) { ?>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/PrestamosPersonales/estadoPersonal/'+registro.id_prestamo_personal+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '<?php if ($abono==1) { ?>'+
                            ' <a id="abonar" class="btn btn-primary btn-lg item_abonar" data-codigo="'+registro.id_prestamo_personal+'">Agregar Abono</a>'+
                            '<?php } ?>'+
                            '<?php if ($cancelar==1) { ?>'+
                            ' <a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_prestamo_personal+'">Cancelar Prestamo</a>'+
                            '<?php } ?>'+
                             '<?php if ($refinanciamiento==1) { ?>'+
                            ' <a id="refi" class="btn btn-info btn-lg item_refi" data-codigo="'+registro.id_prestamo_personal+'">Refinanciamiento</a>'+
                            '<?php } ?>'+
                            ''+desembolso+''+
                            
                            '</center>'+

                            '</div><?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado == 0 && registro.aprobado == 1) {
                        $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading">'+
                            '<div class="col-md-11"><h4>Prestamo Cancelado</h4></div>'+
                            '<a class="btn btn-default btn-sm item_eliminar" title="Autorizacion de Descuento/Orden de Descuento" href="<?php echo base_url();?>index.php/PrestamosPersonales/autorizacionDes/'+registro.id_prestamo_personal+'">'+
                            '<em class="glyphicon glyphicon-duplicate"></em>'+
                            '</a><br><br>'+
                            '</div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Otorgada:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota Asignada:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Concesión:</strong> '+registro.fecha_otorgado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Fecha Finalizado:</strong> '+registro.fecha_fin+'</div>'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipos+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.plazo_quincenas+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Descripcion del Prestamo:</strong> '+registro.descripcion_prestamo+'</div>'+
                            '</div>'+
                            '<?php if ($cancelar==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/PrestamosPersonales/estadoPersonal/'+registro.id_prestamo_personal+'">Estado de Cuenta</a>'+
                            '</center>'+
                            '</div><?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.aprobado == 0) {
                        $('#mostrar').append(
                            '<div class="panel panel-warning">'+
                            '<div class="panel-heading"><h4>Prestamo pendiente de Aprobacion</h4></div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Solicitada:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Enviado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Solicitado:</strong> '+registro.fecha_solicitado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipos+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.plazo_quincenas+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Meses:</strong> '+registro.meses+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Descripcion del Prestamo:</strong> '+registro.descripcion_prestamo+'</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.aprobado == 2) {
                        var rechazo = '';
                        if(registro.descripcion_rechazo == null || registro.descripcion_rechazo == ""){
                            rechazo = '-------------';
                        }else{
                            rechazo = registro.descripcion_rechazo;
                        }
                        $('#mostrar').append(
                            '<div class="panel panel-danger">'+
                            '<div class="panel-heading"><h4>Prestamo Rechazado</h4></div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Solicitada:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Enviado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Solicitado:</strong> '+registro.fecha_solicitado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Fecha de Rechazo:</strong> '+registro.fecha_fin+'</div>'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipos+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.plazo_quincenas+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Plazo en Meses:</strong> '+registro.meses+'</div>'+
                            '<div class="col-md-4"><strong>Descripcion del Prestamo:</strong> '+registro.descripcion_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Justificacion del Rechazo:</strong> '+rechazo+'</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado == 2 && registro.aprobado == 1) {
                        $('#mostrar').append(
                            '<div class="panel panel-info">'+
                            '<div class="panel-heading"><h4>Prestamo Congelado</h4></div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Otorgada:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota Asignada:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Concesión:</strong> '+registro.fecha_otorgado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Fecha Finalizado:</strong> '+registro.fecha_fin+'</div>'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipos+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.plazo_quincenas+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Descripcion del Prestamo:</strong> '+registro.descripcion_prestamo+'</div>'+
                            '</div><br>'+
                            '<?php if ($cancelar==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/PrestamosPersonales/estadoPersonal/'+registro.id_prestamo_personal+'">Estado de Cuenta</a>'+
                            '</center>'+
                            '</div><?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }
                    j++;
                    k++;
                   });

                   if(data['prestamo'] == 0){
                     $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading">Prestamos</div>'+
                            '<div class="panel-body">No Posee Prestamos de este Tipo Actualmente</div>'+
                            '</div>'
                        );
                   }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data

        $('#mostrar').on('click','.item_delete',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="prestamo_code_cancelar"]').val(code);
        });


        //Metodo para eliminar 
        $('#btn_delete').on('click',function(){
            var code = $('#prestamo_code_cancelar').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/cancelarPrestPersonal')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="prestamo_code_cancelar"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();
                    location.reload();

                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo eliminar

        $('#mostrar').on('click','.item_abonar',function(){ 
        //$('.item_abonar').click(function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            var cantidad = $('#cantidad').val('');
            var code   = $(this).data('codigo');
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/montoCancelarPer')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){

                    $('#Modal_Abonar').modal('show');
                    $('[name="code_edit"]').val(code);
                    $('[name="cancelar"]').val(data.cantidad);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

        });//fin metodo llenado


        //Metodo para eliminar 
        $('#btn_abono').on('click',function(){
            var code = $('#code_edit').val();
            var cantidad = $('#cantidad').val();
            var cancelar = $('#cancelar').val();
            var fecha_abono = $('#fecha_abono').val();

            var confirmar = confirm("¿Esta Seguro que desea abonar a este prestamo?");
            if(confirmar){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('PrestamosPersonales/abonarPrestamoPer')?>",
                    dataType : "JSON",
                    data : {code:code,cantidad:cantidad,cancelar:cancelar,fecha_abono:fecha_abono},
        
                    success: function(data){
                        if(data == null){
                            document.getElementById('validacion_Edit').innerHTML = '';

                            $('[name="code_edit"]').val("");
                            $('#Modal_Abonar').modal('toggle');
                            $('.modal-backdrop').remove();
                            Swal.fire(
                                'Abono ingresado correctamente!',
                                '',
                                'success'
                            )
                            show_data();
                        }else{
                            document.getElementById('validacion_Edit').innerHTML = data[0];
                            document.getElementById('validacion_Edit').innerHTML = data[0];
                        }
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;
            }
        });//Fin metodo eliminar


        $('#mostrar').on('click','.item_refi',function(){         
            var code   = $(this).data('codigo');
            var user_sesion = $('#user').val();
            $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('PrestamosPersonales/infoPrest')?>",
                    dataType : "JSON",
                    data : {code:code},
                    success: function(data){
                        if(data != null){
                            $('#Modal_Refi').modal('show');
                            $('[name="code_refi"]').val(code);
                            $('[name="user_sesion"]').val(user_sesion);
                        }
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                    
            });
        });


        $('#btn_refinanciamiento').on('click',function(){
            var code_refi = $('#code_refi').val();
            var cantidad = $('#cantidad_refi').val();
            var tiempo = $('#tiempo_refi').val();
            var fecha = $('#fecha_refi').val();
            var user_sesion = $('#user_sesion').val();
            var confirmar = confirm("¿Esta Seguro que desea hacer refinanciamiento a este prestamo?");
            if(confirmar){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('PrestamosPersonales/refiPrestPersonal')?>",
                    dataType : "JSON",
                    data : {code_refi:code_refi,cantidad:cantidad,tiempo:tiempo,user_sesion:user_sesion,fecha:fecha},
                    success: function(data){
                        if (data==null){
                            document.getElementById('validacion').innerHTML = '';
                            document.getElementById('validacion2').innerHTML = '';
                            document.getElementById('validacion3').innerHTML = '';
                            alert('refinanciamiento hecho correctamente');
                            location.reload();
                            show_data();
                        }else{
                            document.getElementById('validacion').innerHTML = '';
                            document.getElementById('validacion2').innerHTML = '';
                            document.getElementById('validacion3').innerHTML = '';
                            for (i = 0; i <= data.length; i++) {

                                if(data[i] == 1){
                                    document.getElementById('validacion').innerHTML += "El campo de cantidad no puede quedar vacio";
                                }else if (data[i] == 2) {
                                     document.getElementById('validacion').innerHTML += "ingrese una cantidad valido";
                                }else if (data[i] == 3) {
                                     document.getElementById('validacion').innerHTML += "El campo de cantidad no puede ser cero";
                                }else if (data[i] == 4) {
                                     document.getElementById('validacion2').innerHTML += "El campo de tiempo no puede quedar vacio";
                                }else if (data[i] == 5) {
                                     document.getElementById('validacion2').innerHTML += "ingrese un periodo de tiempo valido";
                                }else if (data[i] == 6) {
                                     document.getElementById('validacion').innerHTML += "La Cantidad ingresada no puede ser menos a su saldo actual";
                                }else if (data[i] == 7) {
                                     document.getElementById('validacion').innerHTML += "No se ha abonado a esta cuenta por lo cual no puede haber refinanciamiento";
                                }
                                if (data[i] == 8) {
                                     document.getElementById('validacion3').innerHTML += "Debe de Ingresar la fecha en que se otorgo";
                                }
                            }
                        }
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;
            }
        });

        $('#mostrar').on('click','.item_desem',function(){ 
            var f = new Date();
            var fecha = f.getFullYear() +"-"+(f.getMonth() +1)+"-"+f.getDate();
            var code   = $(this).data('codigo');
            $('#Modal_Desem').modal('show');
            $('[name="code_desem"]').val(code);
            $('[name="fecha_desem"]').val(fecha);
            $('[name="tipo_desem"]').val(1);

        });

        //Metodo para desembolsar 
        $('#btn_desembolso').on('click',function(){
            var code = $('#code_desem').val();
            var user = $('#user').val();
            var id_agencia = $('#id_agencia_pres').val();
            var tipo_desem = $('#tipo_desem').val();
            var fecha_desem = $('#fecha_desem').val();

            var confirmar = confirm("¿Esta Seguro que desea desembolsar este prestamo?");
            if(confirmar){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('PrestamosPersonales/desembolsar_per')?>",
                    dataType : "JSON",
                    data : {code:code,user:user,tipo_desem:tipo_desem,fecha_desem:fecha_desem,id_agencia:id_agencia},
        
                    success: function(data){
                        if(data == null){
                            document.getElementById('validacion_desem').innerHTML = '';
                            $('#Modal_Desem').modal('toggle');
                            show_data();
                        }else{
                            document.getElementById('validacion_desem').innerHTML = data[0];
                        }
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;
            }
        });//Fin metodo desembolsar



        });//Fin jQuery
</script>
</body>


</html>