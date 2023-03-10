        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Prestamos Interno</h2>
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
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Abonar a Prestamo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <!--
                <label class="col-md-2 col-form-label">Product Code</label>
-->
                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Cantidad Para Cancelar $:</label>
                <div class="col-md-10">
                    <input readonly type="text" name="cancelar" id="cancelar" class="form-control" placeholder="0.00">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Cantidad a Abonar Interno:</label>
                <div class="col-md-10">
                    <input type="text" name="cantidad" id="cantidad" class="form-control" placeholder="0.00">
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

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de Prestamos de Equipos</h5>
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
            var nombreAuto=[];
            var j = 0;
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/prestamosData')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado},
                success : function(data){
                    console.log(data);
                    for (i = 0; i <= data.autorizacion.length - 1; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                   $.each(data.prestamo,function(key, registro){
                    if (registro.estado==1 && registro.aprobado == 1) {
                        $('#mostrar').append(
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><h4>Prestamo Vigente</h4></div>'+
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
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.tiempo+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.nombre_plazo+'</div>'+
                            '</div>'+
                            '<?php if ($cancelar==1 or $abono==1 or $estado==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<?php if ($estado==1) { ?>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Prestamo/estadoPrestamo/'+registro.id_prestamo+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '<?php if ($abono==1) { ?>'+
                            ' <a id="abonar" class="btn btn-primary btn-lg item_abonar" data-codigo="'+registro.id_prestamo+'">Agregar Abono</a>'+
                            '<?php } ?>'+
                            '<?php if ($cancelar==1) { ?>'+
                            ' <a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_prestamo+'">Cancelar Prestamo</a> '+
                            '<?php } ?>'+
                            '</center>'+
                            '</div><?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado==0 && registro.aprobado == 1){
                        $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading"><h4>Prestamo Cancelado</h4></div>'+
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
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.tiempo+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.nombre_plazo+'</div>'+
                            '</div>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Prestamo/estadoPrestamo/'+registro.id_prestamo+'">Estado de Cuenta</a>'+
                            '</center>'+
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
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.tiempo+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.nombre_plazo+'</div>'+
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
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.tiempo+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.nombre_plazo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Justificacion del Rechazo:</strong> '+rechazo+'</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado==2 && registro.aprobado == 1){
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
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.tiempo+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.nombre_plazo+'</div>'+
                            '</div><br>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Prestamo/estadoPrestamo/'+registro.id_prestamo+'">Estado de Cuenta</a>'+
                            '</center>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }
                    j++;
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
                url  : "<?php echo site_url('prestamo/cancelarPrestamo')?>",
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


        //se obtiene el id para poder eliminar
        $('#mostrar').on('click','.item_abonar',function(){ 
        //$('.item_abonar').click(function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            var cantidad = $('#cantidad').val('');
            var code   = $(this).data('codigo');
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('prestamo/montoCancelar')?>",
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
            var confirmar = confirm("¿Esta Seguro que desea abonar a este prestamo?");
            if(confirmar){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('prestamo/abonarPrestamo')?>",
                    dataType : "JSON",
                    data : {code:code,cantidad:cantidad,cancelar:cancelar},
        
                    success: function(data){
                        if(data == null){
                            document.getElementById('validacion_Edit').innerHTML = '';

                            $('[name="code_edit"]').val("");
                            $('#Modal_Abonar').modal('toggle');
                            $('.modal-backdrop').remove();
                            location.reload();

                            show_data();
                        }else{
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

         });//Fin jQuery
</script>
</body>


</html>