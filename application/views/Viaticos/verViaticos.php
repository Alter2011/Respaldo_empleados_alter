<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Viaticos de Empleados</h2>
    </div>
    <div class="row">
        <nav class="float-right">
            <div class="col-sm-10">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Ordenar Por:</label>
                        <select class="form-control" name="orden" id="orden" class="form-control">
                            <option value="1">Activos</option>
                            <option value="0">Inactivos</option>
                            <option value="2">Todos</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Fecha Inicio:</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                </div>
            </div>
        </nav>
        <input type="hidden" name="id_empleado" id="id_empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>
        <div class="col-sm-12">
            <div class="well" id="mostrar">
                                
            </div>
            <div class="well" id="foo">
                                
            </div>

        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Viatico</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="viatico_code_edit" id="viatico_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo de Viatico:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_viatico" id="tipo_viatico" class="form-control">
                            <?php
                                $i=0;
                                foreach($tipos as $a){
                            ?>
                            <option id="<?= ($tipos[$i]->id_tipo_viaticos);?>" value="<?= ($tipos[$i]->id_tipo_viaticos);?>"><?php echo($tipos[$i]->nombre);?></option>
                            <?php
                                    $i++;
                                }
                            ?>
                        </select>
                    </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Cantidad del Viatico:</label>
                <div class="col-md-10">
                    <input type="text" name="cantidad_viatico" id="cantidad_viatico" class="form-control" placeholder="0.00">
                    <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                    <label class="col-md-2 col-form-label">Forma del Viatico:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="forma_viatico" id="forma_viatico" class="form-control">
                            <option value="Permanente">Permanente</option>
                            <option value="Temporal">Temporal</option>
                        </select>
                    </div>
                </div>

                 <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fecha de Aplicacion:</label>
                    <div class="col-md-10">
                        <input type="date" name="fecha_viatico" id="fecha_viatico" class="form-control" placeholder="0.00">
                        <div id="validacion1_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Quincenas:</label>
                    <div class="col-md-10">
                        <input type="text" name="fecha_fin" id="fecha_fin" class="form-control" placeholder="0.00" disabled>
                        <div id="validacion2_Edit" style="color:red"></div>
                    </div>
                </div>

            </div>
         
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Cancelar Viatico</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea cancelar este viatico?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="viatico_code_delete" id="viatico_code_delete" class="form-control" readonly>
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
        $('.item_filtrar').click(function(){
            show_data();
        });

        function show_data(){
            var orden = $('#orden').val();
            var id_empleado = $('#id_empleado').val();
            var fecha_inicio = $('#fecha_inicio').val();
            var total = 0;
            var nombreAuto=[];
            var j = 0;

            $('#mostrar').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Viaticos/viaticosData')?>',
                dataType : 'JSON',
                data : {orden:orden,id_empleado:id_empleado,fecha_inicio:fecha_inicio},
                success : function(data){
                    for (i = 0; i <= data.autorizacion.length - 1; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }

                   $.each(data.viatico,function(key, registro){ 
                        if (registro.estado == 0 && registro.tipo == 'Temporal') {
                            $('#mostrar').append(
                                '<div class="modal-content">'+
                                '<div class="modal-header alert alert-danger">'+
                                '<h3 class="modal-title">Aumento de Viatico Temporal(Inactivo)</h3>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                                '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                                '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                                '<div class="col-md-4"><strong>Cantidad asignada:</strong> $'+registro.cantidad+'</div>'+
                                '<div class="col-md-4"><strong>Tipo de Viatico:</strong> '+registro.tViatico+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Ingreso:</strong> '+registro.fecha_creacion+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_aplicacion+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Quincenas a Cancelar:</strong> '+registro.quincenas+'</div>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '<br>'                           
                            );
                        }else if (registro.estado == 1 && registro.tipo == 'Temporal'){
                            $('#mostrar').append(
                                '<div class="panel panel-primary">'+
                                '<div class="panel-heading"><h3>Aumento de Viatico Temporal(Activo)</h3></div>'+
                                '<div class="panel-body">'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                                '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                                '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                                '<div class="col-md-4"><strong>Cantidad asignada:</strong> $'+registro.cantidad+'</div>'+
                                '<div class="col-md-4"><strong>Tipo de Viatico:</strong> '+registro.tViatico+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Ingreso:</strong> '+registro.fecha_creacion+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_aplicacion+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Quincenas a Cancelar:</strong> '+registro.quincenas+'</div>'+
                                '</div>'+
                                '<?php if ($cancelar == 1 or $editar==1) { ?><div class="panel-footer">'+
                                '<center><?php if ($editar == 1) { ?><a id="reasignar" class="btn btn-primary btn-lg item_edit" data-codigo="'+registro.id_viaticos+'">Editar</a><?php } ?>'+
                                ' <?php if ($cancelar == 1) { ?><a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_viaticos+'">Cancelar</a><?php } ?></center>'+
                                '</div><?php } ?>'+
                                '</div>'+
                                '</div>'+
                                '<br>'
                            );
                        }else if (registro.estado == 0 && registro.tipo == 'Permanente') {
                             $('#mostrar').append(
                                '<div class="modal-content">'+
                                '<div class="modal-header alert alert-danger">'+
                                '<h3 class="modal-title">Viatico Permanente(Inactivo)</h3>'+
                                '</div>'+
                                '<div class="modal-body">'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                                '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                                '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                                '<div class="col-md-4"><strong>Cantidad asignada:</strong> $'+registro.cantidad+'</div>'+
                                '<div class="col-md-4"><strong>Tipo de Viatico:</strong> '+registro.tViatico+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Ingreso:</strong> '+registro.fecha_creacion+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_aplicacion+'</div>'+
                                '</div>'+
                                '</div>'+
                                '</div>'+
                                '<br>'                           
                            );
                        }else if (registro.estado == 1 && registro.tipo == 'Permanente') {

                            $('#mostrar').append(
                                '<div class="panel panel-primary">'+
                                '<div class="panel-heading"><h3>Viatico Permanente(Activo)</h3></div>'+
                                '<div class="panel-body">'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Nombre:</strong> '+registro.nombre+' '+registro.apellido+'</div>'+
                                '<div class="col-md-4"><strong>Numero de Dui:</strong> '+registro.dui+'</div>'+
                                '<div class="col-md-4"><strong>Agencia:</strong> '+registro.agencia+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Cargo:</strong> '+registro.cargo+'</div>'+
                                '<div class="col-md-4"><strong>Cantidad asignada:</strong> $'+registro.cantidad+'</div>'+
                                '<div class="col-md-4"><strong>Tipo de Viatico:</strong> '+registro.tViatico+'</div>'+
                                '</div>'+
                                '<hr>'+
                                '<div class="row">'+
                                '<div class="col-md-4"><strong>Autorizado Por:</strong> '+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Aplicacion:</strong> '+registro.fecha_aplicacion+'</div>'+
                                '<div class="col-md-4"><strong>Fecha de Ingreso:</strong> '+registro.fecha_creacion+'</div>'+
                                '</div>'+
                                '</div>'+
                                '<?php if ($cancelar == 1 or $editar==1) { ?><div class="panel-footer">'+
                                '<center><?php if ($editar == 1) { ?><a id="reasignar" class="btn btn-primary btn-lg item_edit" data-codigo="'+registro.id_viaticos+'">Editar</a><?php } ?>'+
                                ' <?php if ($cancelar == 1) { ?><a id="eliminar" class="btn btn-danger btn-lg item_delete" data-codigo="'+registro.id_viaticos+'">Cancelar</a><?php } ?></center>'+
                                '</div><?php } ?>'+
                                '</div>'+
                                '<br>'
                            );
                        }
                        total += parseFloat(registro.cantidad);
                        j++;
                   });
                
                    if(total > 0){
                        $('#foo').empty();
                        $('#foo').show();
                        $('#foo').append(
                            '<div class="alert alert-success">'+
                            '<center><div class="panel-heading"><h4><strong>Total de los Viaticos:</strong></h4>$'+total+'</div></center>'+
                            '</div>'
                        );
                    }

                   if(data.viatico == 0){
                    $('#foo').hide();
                     $('#mostrar').append(
                            '<div class="alert alert-warning">'+
                            '<div class="panel-heading"><h4>Viaticos</h4></div>'+
                            '<div class="panel-body">No Posee Viaticos de este Tipo Actualmente</div>'+
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

        $('#forma_viatico').change(function(){
            var forma_viatico = $('#forma_viatico').val();

            if(forma_viatico == "Temporal"){
                $("#fecha_fin").prop('disabled', false);
            }else{
                $("#fecha_fin").prop('disabled', true);
                $('[name="fecha_fin"]').val("");
                document.getElementById('validacion3').innerHTML = '';
            }
        });

        //get data for update record
        $('#mostrar').on('click','.item_edit',function(){ 
         //$('.item_edit').click(function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            document.getElementById('validacion1_Edit').innerHTML = '';
            document.getElementById('validacion2_Edit').innerHTML = '';
            var code   = $(this).data('codigo');
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Viaticos/viaticosEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="viatico_code_edit"]').val(code);
                    $('[name="tipo_viatico"]').val(data[0].id_tipo_viaticos);
                    $('[name="cantidad_viatico"]').val(data[0].cantidad);
                    $('[name="forma_viatico"]').val(data[0].tipo);
                    $('[name="fecha_viatico"]').val(data[0].fecha_aplicacion);

                    if(data[0].tipo == 'Temporal'){
                        $('[name="fecha_fin"]').val(data[0].quincenas);
                        $("#fecha_fin").prop('disabled', false);
                    }else{
                        $("#fecha_fin").prop('disabled', true);
                        $('[name="fecha_fin"]').val("");
                        document.getElementById('validacion2_Edit').innerHTML = '';
                    }
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            
        });

    //metodo para modificar 
        $('#btn_update').on('click',function(){
            var code = $('#viatico_code_edit').val();
            var tipo = $('#tipo_viatico').children(":selected").attr("id");
            var cantidad = $('#cantidad_viatico').val();
            var forma = $('#forma_viatico').val();
            var fecha_aplicacion = $('#fecha_viatico').val();
            var fecha_fin = '';
            var fecha_final = $('#fecha_fin').val();

            if($('#fecha_fin').is(':disabled')){
                fecha_fin = 'deshabilitada';
            }else{
                fecha_fin = 'hablitada';
                
            }
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Viaticos/updateViatico')?>",
                    dataType : "JSON",
                    data : {code:code,tipo:tipo,cantidad,forma:forma,fecha_aplicacion:fecha_aplicacion,fecha_fin:fecha_fin,fecha_final:fecha_final},
                    success: function(data){

                        if(data==null){
                            document.getElementById('validacion_Edit').innerHTML = '';
                            document.getElementById('validacion1_Edit').innerHTML = '';
                            document.getElementById('validacion2_Edit').innerHTML = '';

                            $('[name="viatico_code_edit"]').val("");
                            $('[name="cantidad_viatico"]').val("");
                            $('[name="forma_viatico"]').val("Permanente");
                            $('[name="fecha_viatico"]').val("");
                            $("#tipo_viatico option:first").attr('selected','selected'); 
                            $('[name="fecha_fin"]').val("");
                            $("#fecha_fin").prop('disabled', true);

                            $('#Modal_Edit').modal('toggle');
                            $('.modal-backdrop').remove();
                            location.reload();

                            show_data();
                        }else{
                            document.getElementById('validacion_Edit').innerHTML = '';
                            document.getElementById('validacion1_Edit').innerHTML = '';
                            document.getElementById('validacion2_Edit').innerHTML = '';

                            for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar la Cantidad de los Viaticos";
                                }else if(data[i] == 2){
                                    document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar la Cantidad de los Viaticos en Forma Correcta (0.00)";
                                }
                                if(data[i] == 3){
                                    document.getElementById('validacion1_Edit').innerHTML += "Debe de Ingresar la Fecha de Aplicacion";
                                }
                                if(data[i] == 4){
                                    document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar la Fecha de Finalizacion";
                                }
                            }//Fin For
                        }
                            
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                    return false;
             
        });//Fin metodo modificar

        $('#mostrar').on('click','.item_delete',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="viatico_code_delete"]').val(code);
        });

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#viatico_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Viaticos/deleteViatico')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="viatico_code_delete"]').val("");
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