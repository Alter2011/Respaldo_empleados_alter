<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Orden de descuentos</h2>
    </div>
        <div class="row">
            <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
            <input type="hidden" name="id_agencia" id="id_agencia" value="<?php echo $this->uri->segment(4); ?>" readonly>
            <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                <nav class="float-right">
                    <div class="col-sm-12">
                        <div class="form-row">
                            <div class="form-group col-md-4" id="filtro">
                                <label for="inputState" id="label_banco">Banco</label>
                                <select class="form-control item_filtrar" name="filtro_banco" id="filtro_banco" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                            </div>
                             <div class="form-group col-md-2">
                            <a id="btn_cancelados" class="btn btn-warning btn-sm">Cancelados</a>
                            <a id="btn_pendientes" class="btn btn-success btn-sm">Pendientes</a>
                            </div>
                            </div>
                </div>
                        </nav>
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                         
                    </div>
                    <div class="well" id="mostrar_cancelados">
                         
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
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion de Orden de Descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar esta Orden de Descuento?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="prestamo_code_cancelar" id="prestamo_code_cancelar" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary" onclick="eliminar()">Si</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->


<script type="text/javascript">

         function eliminar(){
            var id_orden = $('#prestamo_code_cancelar').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Orden_descuentos/eliminar_orden')?>",
                dataType : "JSON",
                data : {id_orden:id_orden},
                success: function(data){
                    $('[name="prestamo_code_cancelar"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();
                    alert("Se ha eliminado la orden de descuento Correctamente");
                    location.reload();
                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        };//Fin metodo eliminar 

   $(document).ready(function(){
        $('#mostrar_cancelados').hide();
        $('#btn_pendientes').hide();
        //calculo_descuentos();
        traer_bancos_abonados();

        $('.item_filtrar').on('change',function(){
            show_data();
        });

        function traer_bancos_abonados(){
            var id_empleado = $('#id_empleado').val();
            var agencia_prestamo = $('#id_agencia').val();
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Orden_descuentos/bancos_abonados')?>',
            dataType : 'JSON',
            data : {id_empleado:id_empleado,agencia_prestamo:agencia_prestamo},
            success : function(data){
                if (data!=null) {
                for (var i = data.length - 1; i >= 0; i--) {   
                    $('#filtro_banco').append(
                    '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                    );
                }
                }else{

                    $('#filtro_banco').append(
                    '<option value="0"></option>'
                    );
                    $('#filtro_banco').hide();
                    $('#label_banco').hide();
                    
                }
                show_data();
                

                },  
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

        function traer_bancos_cancelados(){
            var id_empleado = $('#id_empleado').val();
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Orden_descuentos/bancos_abonos')?>',
            dataType : 'JSON',
            data : {id_empleado:id_empleado},
            success : function(data){
                if (data!=null) {

                for (var i = data.length - 1; i >= 0; i--) {   
                    $('#filtro_banco').append(
                    '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                    );
                }
                }else{

                    $('#filtro_banco').append(
                    '<option value="0"></option>'
                    );
                    $('#filtro_banco').hide();
                    $('#label_banco').hide();
                    
                }
                show_data();

                },  
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }

         $('#btn_pendientes').on('click',function(){
            $('#btn_pendientes').hide();
            $('#btn_cancelados').show();
            $('#mostrar_cancelados').hide();
            $('#mostrar').show();
            $('#label_banco').show();
            $('#filtro_banco').show();
            show_data();
         });

        $('#btn_cancelados').on('click',function(){
            var id_contrato = $('#id_empleado').val();
            var id_agencia = $('#id_agencia').val();
            var cancel=[];
             var bancos=[];
            var j=0;
            $('#mostrar').hide();
            $('#label_banco').hide();
            $('#filtro_banco').hide();
            $('#mostrar_cancelados').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Orden_descuentos/ordenes_canceladas')?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato,id_agencia:id_agencia},
                success : function(data){
                console.log(data);
                $('#btn_pendientes').show();
                $('#btn_cancelados').hide();
                $('#mostrar_cancelados').show();
                if(data == null){
                     $('#mostrar_cancelados').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Orden de descuento</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no tiene ordenes de descuento canceladas</div>'+
                            '</div>'
                        );
                }else if(data.cancelados == ''){
                    $('#mostrar_cancelados').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Orden de descuento</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no tiene ordenes de descuento canceladas</div>'+
                            '</div>'
                        );
                }else{
                    var deudor = data.deudor[0];
                    for (i = 0; i <= data.cancelados.length - 1; i++) {
                        cancel[i] = data.cancelados[i];//contiene bancos que ya fueron cancelados
                        bancos[i] = data.bancos[i];//contiene el nombre de los bancos se usa solo para el encabezado

                    }
                    j=0;
                $.each(data.cancelados,function(key, registro){
                    monto_total=parseFloat(cancel[j].monto_total).toFixed(2);
                    cuota=parseFloat(cancel[j].cuota).toFixed(2);
                    $('#mostrar_cancelados').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-danger" style="text-align: center;">'+
                            '<h3 class="modal-title">Orden de descuento '+bancos[j].nombre_banco+'</h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre: </strong>'+deudor.nombre+ ' '+deudor.apellido+' </div>'+
                            '<div class="col-md-4"><strong>Numero de Dui: </strong> '+deudor.dui+'</div>'+
                            '<div class="col-md-4"><strong>Agencia: </strong>'+deudor.agencia+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong>'+deudor.cargo+' </div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong>'+deudor.nombrePlaza+' </div>'+
                            '<div class="col-md-4"><strong>Ult. fecha de finalizacion:</strong> '+cancel[j].fecha_finalizacion+' </div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Total quincenas pagadas:</strong> '+cancel[j].total_quincenas+'</div>'+
                            '<div class="col-md-4"><strong>Monto del prestamo: </strong>$ '+monto_total+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad de la cuota:</strong> $ '+cuota+'</div>'+
                            '<hr>'+
                            '<div class="row">'+
                                '<div class="col-md-12" style="text-align:center;">'+
                            '<?php  if ($estadoCuentaOrden==1) { ?>'+//hacer la variable del permiso
                            '<a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Orden_descuentos/estadoOrden/'+cancel[j].id_orden_descuento+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                                '</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>' 
                           
                        );
                    j++;
                   });
                  }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        });

        function show_data(data=null){

            var id_contrato = $('#id_empleado').val();
            var id_agencia = $('#id_agencia').val();
            var id_banco = $('#filtro_banco').val();
            var faltante=0;
            var pagado=0;
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Orden_descuentos/calculo_descuentos')?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato,id_banco:id_banco,id_agencia:id_agencia},
                success : function(data){
                console.log(data);
                $('#mostrar').show();
                if(data == null){
                    $('#btn_cancelados').show();
                    $('#filtro').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Orden de descuento</h4></div>'+
                            '<div class="panel-body">El empleado actualmente no tiene ninguna orden de descuento</div>'+
                            '</div>'
                        );
                   }else if(data.mostrar == 'si'){
                    monto_total=parseFloat(data.monto_prestamo).toFixed(2);
                    cuota=parseFloat(data.cuota_quin).toFixed(2);
                        $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info" style="text-align: center;">'+
                            '<h3 class="modal-title">Detalles orden de descuento '+data.nombre_banco+'</h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-5"><strong></strong></div>'+
                            '<div class="col-md-4"><strong></strong></div>'+
                            '</div>'+
                            '<br>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre: </strong>'+data.nombre+' '+data.apellido+' </div>'+
                            '<div class="col-md-4"><strong>Numero de Dui: </strong>'+data.dui+' </div>'+
                            '<div class="col-md-4"><strong>Agencia: </strong>'+data.agencia+' </div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+data.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong> '+data.nombrePlaza+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de inicio:</strong> '+data.fecha_inicio+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Monto del prestamo: </strong>$'+monto_total+'</div>'+
                            '<div class="col-md-4"><strong>Num. de quincenas: </strong> '+data.num_quin+' </div>'+
                            '<div class="col-md-4"><strong>Cuota Quincenal: </strong>$'+cuota+' </div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-12" >'+
                            '<?php if ($estadoCuentaOrden==1) { ?>'+//hacer la variable del permiso
                            '<a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Orden_descuentos/estadoOrden/'+data.id_orden+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '<?php if ($eliminar_orden==1) { ?>'+
                            ' <a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+data.id_orden+'">Cancelar Orden</a>'+
                            '<?php } ?>'+
                            '<div class="col-md-4"></div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'
                        );
                   }else{
                     if (data.prestamo % 1 == 0) {
                        prestamo=data.prestamo+'.00';
                    }else{
                        prestamo=data.prestamo;
                    }
                    if (data.cantidad_total_faltante % 1 == 0) {
                        faltante=data.cantidad_total_faltante+'.00';
                    }else{
                        faltante=data.cantidad_total_faltante+'0';
                    }
                    if (data.cantidad_total_pagada % 1 == 0) {
                        pagado=data.cantidad_total_pagada+'.00';
                    }else{
                        pagado=data.cantidad_total_pagada;
                    }
                    faltante=parseFloat(data.cantidad_total_faltante).toFixed(2);
                    prestamo=parseFloat(data.prestamo).toFixed(2);
                    pagado=parseFloat(data.cantidad_total_pagada).toFixed(2);
                    $('#mostrar').append(
                            '<div class="modal-content">'+
                            '<div class="modal-header alert alert-info" style="text-align: center;">'+
                            '<h3 class="modal-title">Orden de descuento '+data.nombre_banco+'</h3>'+
                            '</div>'+
                            '<div class="modal-body">'+
                            '<div class="row">'+
                            '<div class="col-md-5"><strong></strong></div>'+
                            '<div class="col-md-4"><strong></strong></div>'+
                            '<div class="col-md-3" style="margin-top:-25px"><strong>Cuotas Pagadas: </strong>'+data.cuotas_pagadas+' de '+data.cuotas_totales+' </div>'+
                            '</div>'+
                            '<br>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre: </strong>'+data.nombre+' '+data.apellido+' </div>'+
                            '<div class="col-md-4"><strong>Numero de Dui: </strong>'+data.dui+' </div>'+
                            '<div class="col-md-4"><strong>Agencia: </strong>'+data.agencia+' </div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Cargo:</strong> '+data.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Plaza:</strong> '+data.nombrePlaza+'</div>'+
                            '<div class="col-md-4"><strong>Ult. cuota pagada:</strong> '+data.fecha_ultimo_abono+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Monto del prestamo: </strong>$ '+prestamo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Pendiente:</strong> $ '+faltante+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad Pagada:</strong> $ '+pagado+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-12" style="text-align:center;">'+
                            '<?php if ($estadoCuentaOrden==1) { ?>'+
                            '<a id="estado" class="btn btn-success btn-lg" href="<?php echo base_url();?>index.php/Orden_descuentos/estadoOrden/'+data.id_orden+'">Estado de Cuenta</a>'+
                            '<?php } ?>'+
                            '<?php if ($eliminar_orden==1) { ?>'+
                            ' <a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+data.id_orden+'">Cancelar Orden</a>'+
                            '<?php } ?>'+
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

        $('#mostrar').on('click','.item_delete',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="prestamo_code_cancelar"]').val(code);
            //eliminar();
        });

        //Metodo para eliminar 



         });//Fin jQuery

    
</script>
</body>


</html>