        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Descuentos</h2>
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
                                         <option value="2">Todos</option>
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

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de Descuentos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este Descuento?</strong>
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


<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Abonar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Abono de descuento</h3>
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
                    <input type="hidden" name="code_abono" id="code_abono" class="form-control" readonly>
                </div>
            </div>
             <div class="form-group row">
                  <div class="col-md-12">
                    <div id="validacion" style="color:red"></div>
                  </div>
              </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Saldo $:</label>
                <div class="col-md-10">
                    <input readonly type="text" name="cancelar" id="cancelar" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Abono $:</label>
                <div class="col-md-10">
                    <input type="text" name="cantidad_abono" id="cantidad_abono" class="form-control" placeholder="0.00">
                </div>
            </div>

            </div>           
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_abono" class="btn btn-primary" onclick="save_abono()">Abonar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!-- Llamar JavaScript -->

<script type="text/javascript">
     $(function() {
        $('#cantidad_abono').maskMoney();
    })
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
            //alert(orden);
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Descuentos_herramientas/descuentosData')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado},
                success : function(data){
                    
                    for (i = 0; i <= data.autorizacion.length - 1; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                    console.log(data);
                   $.each(data.descuentos,function(key, registro){
                    if (registro.estado == 1) {
                        $('#mostrar').append(
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><h4>Descuentos Vigente</h4></div>'+
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
                            '<div class="col-md-4"><strong>Cantidad a Descontar:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota Asignada:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_ingreso+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.quincenas+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.pedido+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Descripcion:</strong> '+registro.descripcion+'</div>'+
                            '</div>'+
                            
                            '<?php if ($cancelar==1 || $estado==1 || $abono==1) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<?php if ($abono==1) { ?>'+
                            '<a id="abonar" class="btn btn-primary btn-lg item_abonar" data-codigo="'+registro.id_descuento_herramienta+'">Agregar abono</a> '+
                            '<?php } ?>'+
                            '<?php if ($cancelar==1) { ?>'+
                            '<a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_descuento_herramienta+'">Cancelar Descuento</a>'+
                            '<?php } ?>'+
                            '<?php if ($estado==1) { ?>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Descuentos_herramientas/pagos_descuentos/'+registro.id_descuento_herramienta+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '</center>'+
                            '</div>'+
                            '<?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado==0) {
                        $('#mostrar').append(
                            '<div class="panel panel-danger">'+
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
                            '<div class="col-md-4"><strong>Cantidad a Descontar:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Cuota Asignada:</strong> $'+registro.couta+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_ingreso+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Tipo de Prestamo:</strong> '+registro.nombre_tipo+'</div>'+
                            '<div class="col-md-4"><strong>Plazo en Quincenas:</strong> '+registro.quincenas+'</div>'+
                            '<div class="col-md-4"><strong>Pedido en:</strong> '+registro.pedido+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Descripcion:</strong> '+registro.descripcion+'</div>'+
                            '</div>'+
                            '<?php if ($estado==1 ) { ?>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<?php if ($estado==1) { ?>'+
                            ' <a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Descuentos_herramientas/pagos_descuentos/'+registro.id_descuento_herramienta+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '</center>'+
                            '</div>'+
                            '<?php } ?>'+
                            '</div>'+
                            '<br>'
                        );
                    }
                    j++;
                   });

                   if(data['descuentos'] == 0){
                     $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading">Descuentos</div>'+
                            '<div class="panel-body">No Posee Descuentos de este Tipo Actualmente</div>'+
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
                url  : "<?php echo site_url('Descuentos_herramientas/cancelarDescuento')?>",
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
            var code   = $(this).data('codigo');
           
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Descuentos_herramientas/datos_descuento')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    document.getElementById('validacion').innerHTML = '';
                    $('[name="code_abono"]').val(code);
                    $('[name="cantidad_abono"]').val('');
                    $('[name="cancelar"]').val(parseInt(data[0].saldo_actual).toFixed(2));
                    $('#Modal_Abonar').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

         });//Fin jQuery

        function save_abono(){
            var code_abono = $('#code_abono').val();
            var cantidad_abono = $('#cantidad_abono').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Descuentos_herramientas/guardar_abono')?>",
                dataType : "JSON",
                data : {code_abono:code_abono,cantidad_abono:cantidad_abono},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        $('[name="cantidad_abono"]').val('');
                        Swal.fire(
                            'Proveedor ingresado correctamente!',
                            '',
                            'success'
                        )
                        $("#Modal_Abonar").modal('toggle');
                    }else{
                        document.getElementById('validacion').innerHTML = data;
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;

        }
</script>
</body>


</html>