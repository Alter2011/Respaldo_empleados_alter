        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Vacaciones</h2>
            </div>
            <div class="row">
                 <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Ordenar Por:</label>
                                    <select class="form-control" name="orden" id="orden" class="form-control">
                                         <option value="1">Aprobadas</option>
                                         <option value="0">Eliminadas</option>
                                         <option value="2">Todas</option>
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

            //alert(orden);

            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Vacaciones/listarVacaciones')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado},
                success : function(data){
                    console.log(data);

                   $.each(data,function(key, registro){
                    if (registro.aprobado == 1 && (registro.estado == 1 || registro.estado == 2)) {
                        $('#mostrar').append(
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><h4>Vacaciones Aprobadas</h4></div>'+
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
                            '<div class="col-md-4"><strong>Plaza:</strong> '+registro.nombrePlaza+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-4"><strong>Fecha a Pagar:</strong> '+registro.fecha_aplicacion+'</div>'+
                            '<div class="col-md-4"><strong>Fecha de Aprobacion:</strong> '+registro.fecha_aprobado+'</div>'+
                            '</div>'+
                            '<br><br>'+
                            '<div class="panel-footer">'+
                            '<center>'+
                            '<a id="aprobar" class="btn btn-success btn-lg item_aprobar" href="<?php echo base_url();?>index.php/Vacaciones/verBoleta/'+registro.id_vacacion+'">Imprimir Boleta</a>'+
                            '</center>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }else if (registro.estado == 0 && registro.aprobado == 0) {
                        $('#mostrar').append(
                            '<div class="panel panel-danger">'+
                            '<div class="panel-heading"><h4>Vacaciones Eliminadas</h4></div>'+
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
                            '<div class="col-md-4"><strong>Plaza:</strong> '+registro.nombrePlaza+'</div>'+
                            '</div>'+
                            '<div class="col-md-4"><strong>Fecha de Eliminacion:</strong> '+registro.fecha_eliminado+'</div>'+
                            '</div>'+
                            '</div>'+
                            '</div>'+
                            '<br>'
                        );
                    }
                   });

                   if(data == 0){
                     $('#mostrar').append(
                            '<div class="panel panel-success">'+
                            '<div class="panel-heading">Vacaciones</div>'+
                            '<div class="panel-body">No Posee Vacaciones de este Tipo Actualmente</div>'+
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


         });//Fin jQuery
</script>
</body>


</html>