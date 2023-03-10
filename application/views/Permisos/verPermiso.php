<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Permisos de Empleados</h2>
            </div>
            <div class="row">
                 <nav class="float-right">
                            <div class="col-sm-10">
                                <div id="validacion_delete" style="color:red"></div>
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Desde:</label>
                                    <input type="date" name="desde" id="desde" class="form-control">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Hasta:</label>
                                    <input type="date" name="hasta" id="hasta" class="form-control">
                                </div>

                                 <div class="form-group col-md-3">
                                    <label for="inputState">Estado</label>
                                    <select class="form-control" name="estado" id="estado" class="form-control">
                                        <option value="todo">Todos</option>
                                        <option value="1">Aceptados</option>
                                        <option value="0">Cancleados</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <center>
                                        <a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a>

                                        <a id="filtrar" class="btn btn-success btn-sm item_todo" style="margin-top: 23px;">Todos</a>
                                    </center>
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
            <div class="row" id="row">
                
            </div>
        </div>
    </div>
</div>

<!--MODAL APROBAR-->
<form>
    <div class="modal fade" id="Modal_Cancelar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelar Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a que desea Cancelar este Permiso?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="delete_code" id="delete_code" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR-->
<!-- Llamar JavaScript -->

<script type="text/javascript">
    $(document).ready(function(){  

        show_data();
        $('.item_filtrar').click(function(){
            
            show_data();
            
         });
        $('.item_todo').click(function(){
            
            $('[name="desde"]').val("");
            $('[name="hasta"]').val("");
            $("#estado option[value='todo'").attr("selected",true);

            show_data();
            
         });
        function show_data(){
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            var estado = $('#estado').val();
            var id_empleado = $('#id_empleado').val();
            var tipo_permiso='';
            var nombreAuto=[];
            var j = 0;
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('PermisosEmpleados/getPermisos')?>',
                dataType : 'JSON',
                data : {id_empleado:id_empleado,desde:desde,hasta:hasta,estado:estado},
                success : function(data){
                    if(data.validacion.length > 0){
                        document.getElementById('validacion_delete').innerHTML = '';
                        document.getElementById('validacion_delete').innerHTML = data.validacion[0];
                    }else{
                        document.getElementById('validacion_delete').innerHTML = '';

                    }
                    console.log(data);
                    for (i = 0; i < data.autorizacion.length; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                   $.each(data.permiso,function(key, registro){
                    if (registro.tipo_permiso=='1') {
                        tipo_permiso='Permiso Con Goce de sueldo';
                    }else if (registro.tipo_permiso=='2') {
                        tipo_permiso='Mision Oficial';
                    }else if (registro.tipo_permiso=='3') {
                        tipo_permiso='Ausencia injustificada';
                    }else if (registro.tipo_permiso=='4') {
                        tipo_permiso='Compensatorio=4';
                    }else if (registro.tipo_permiso=='5') {
                        tipo_permiso='Permiso Sin Goce de sueldo';
                    }else if (registro.tipo_permiso=='6') {
                        tipo_permiso='Capacitacion=6';
                    }else if (registro.tipo_permiso=='7') {
                        tipo_permiso='Incapacidad';
                    }else if (registro.tipo_permiso=='8') {
                        tipo_permiso='Vacaciones';
                    }else if (registro.tipo_permiso=='9') {
                        tipo_permiso='Otros';
                    }

                    if(registro.estado == 1){
                        $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info">'+
                            '<h3 class="modal-title">Permiso Aceptado</h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Area:</strong> '+registro.area+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Permiso:</strong> '+tipo_permiso+'</div>'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Fecha Solicitud:</strong> '+registro.fecha_solicitud+'</div>'+
                            '</div>'+
                            '<hr>'+

                            '<?php if ($imprimir==1 or $Cancelar==1) { ?>'+
                            '<div class="row">'+
                            '<center>'+
                            '<?php if($imprimir==1){ ?>'+
                            '<a href="<?php echo base_url();?>index.php/PermisosEmpleados/imprimirBoletaAntigua/'+registro.id_permiso+'" class="btn btn-success crear" id="btn_permiso" >Ver Permiso</a>'+
                            '<?php } ?>'+

                            '<?php if($Cancelar==1){ ?>'+
                            ' <a id="aprobar" class="btn btn-danger item_cancelar" data-codigo="'+registro.id_permiso+'">Cancelar Permiso</a>'+
                            '<?php } ?>'+

                            '<br></center>'+
                            '</div>'+
                            '<?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'                           
                        );//fin del primer forech

                    }else if(registro.estado == 0){
                        $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-danger">'+
                            '<h3 class="modal-title">Permiso Cancelado</h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Area:</strong> '+registro.area+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Permiso:</strong> '+tipo_permiso+'</div>'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Fecha Solicitud:</strong> '+registro.fecha_solicitud+'</div>'+
                            '</div>'+
                            '<hr>'+

                            '<?php if ($imprimir==1) { ?>'+
                            '<div class="row">'+
                            '<center>'+
                            '<a href="<?php echo base_url();?>index.php/PermisosEmpleados/imprimirBoletaAntigua/'+registro.id_permiso+'" class="btn btn-success crear" id="btn_permiso" >Ver Permiso</a>'+
                            '<br></center>'+
                            '</div>'+
                            '<?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'                           
                        );//fin del primer forech
                    }

                    j++;
                   });

                   if(data['permiso']  == 0){
                         $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-success">'+
                            '<h3 class="modal-title">Permiso del Empleado:</h3>'+
                            '</div>'+
                            '<div class="row">'+
                            '<center><h3>Este Empleado No Posee Este Tipo de Permisos</h3><br></center>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'                           
                        );
                   }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data


         $('#mostrar').on('click','.item_cancelar',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Cancelar').modal('show');
            $('[name="delete_code"]').val(code);
        });

         $('#btn_delete').on('click',function(){
            var code = $('#delete_code').val();
            var user = $('#user').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PermisosEmpleados/deletePermiso')?>",
                dataType : "JSON",
                data : {code:code,user:user},
                success: function(data){
                    this.disabled=false;
                    location.reload();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

    });//Fin jQuery
</script>
</body>


</html>