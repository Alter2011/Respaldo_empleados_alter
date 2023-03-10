        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Anticipos de Empleado</h2>
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
                <h5 class="modal-title" id="exampleModalLabel">Cancelacion Anticipo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este anticipo?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="anticipo_code_cancelar" id="anticipo_code_cancelar" class="form-control" readonly>
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
            var j = 0
            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Anticipos/anticiposData')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado},
                success : function(data){
                    //console.log(data);
                    for (i = 0; i <= data.autorizacion.length - 1; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }
                   $.each(data.anticipo,function(key, registro){
                    if (registro.estado==1) {
                        $('#mostrar').append(
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><h4>Anticipos Vigente</h4></div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                            '<div class="col-md-4"><strong>Numero de Telefono:</strong> '+registro.tel_personal+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                            '<div class="col-md-4"><strong>Cargo:</strong>'+registro.cargo+'</div>'+
                            '<div class="col-md-4"><strong>Cantidad a Pagar:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_aplicacion+'</div>'+
                            '<div class="col-md-4"><strong>Tipo de Anticipo:</strong> '+registro.nombre_tipo+'</div>'+
                            '</div>'+
                            '<?php if ($cancelar==1) { ?><div class="panel-footer">'+
                            '<center><a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_anticipos+'">Cancelar Anticipo</a></center>'+
                            '</div><?php } ?>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado==0) {
                        $('#mostrar').append(
                            '<div class="panel panel-danger">'+
                            '<div class="panel-heading"><h4>Anticipo Cancelado</h4></div>'+
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
                            '<div class="col-md-4"><strong>Cantidad a Pagar:</strong> $'+registro.cantidad+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                            '<div class="col-md-4"><strong>Fecha Otorgado:</strong> '+registro.fecha_otorgado+'</div>'+
                            '<div class="col-md-4"><strong>Tipo de Anticipo:</strong> '+registro.nombre_tipo+'</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }
                    j++;
                   });

                   if(data.anticipo == 0){
                     $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading">Anticipos</div>'+
                            '<div class="panel-body">No Posee Anticipos de este Tipo Actualmente</div>'+
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
            $('[name="anticipo_code_cancelar"]').val(code);
        });


        //Metodo para eliminar 
        $('#btn_delete').on('click',function(){
            var code = $('#anticipo_code_cancelar').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Anticipos/cancelarAnticipo')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="anticipo_code_cancelar"]').val("");
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

         });//Fin jQuery
</script>
</body>


</html>