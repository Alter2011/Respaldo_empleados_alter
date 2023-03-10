       <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Aprobacion de Vacaciones</h2>
                <div class="text-left">
                    <a id="actualizar" data-toggle="modal" data-target="#Modal_Actualizar" class="btn btn-success">Actualizar vacaciones a revisar</a>
                </div>
            </div>
            <div class="row">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">
    
                            <?php if($ver==1) { ?>
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia" id="agencia" class="form-control">
                                        <option value="">Todos</option>
                                         <?php
                                            $i=0;
                                            foreach($agencia as $a){
                                        ?>
                                            <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php }else{ ?>

                                <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                            <?php } ?>

                            <div class="form-group col-md-3">
                                    <label for="inputState">Mes</label>
                                    <input type="month" name="mes" id="mes" class="form-control" value="<?php echo date('Y-m'); ?>">
                            </div>

                            <div class="form-group col-md-3">
                                    <label for="inputState">Quincena</label>
                                    <select name="quincena" id="quincena" class="form-control">
                                        <option value="3">Todas</option>
                                        <option value="1">Primera Quincena</option>
                                        <option value="2">Segunda Quincena</option>
                                    </select>
                            </div>

                            <div class="form-row col-md-3">
                                <div class="form-group col-md-2">
                                    <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                                </div>


                            </div>

                        </div>
                    </div>
                </nav>
            </div>
            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<!--MODAL APROBAR-->
<form>
    <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobacion de Pago de Vacaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a de Aprobar Estas Vacaciones?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="aprobacion_code" id="aprobacion_code" class="form-control" readonly>
                <input type="hidden" name="aprobacion_empleado" id="aprobacion_empleado" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary">Si</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR-->


<!--MODAL RECHAZAR-->
<form>
    <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><strong>Eliminacion de Vacaciones</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <div class="modal-body">
                    <strong>¿Seguro/a que Desea Eliminar estas Vacaciones?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="eliminar_code" id="eliminar_code" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_rechazar" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL RECHAZAR-->

<!--MODAL ACTUALIZAR-->
<form>
    <div class="modal fade" id="Modal_Actualizar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar Vacaciones a Revisar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a que desea actualizar?</strong><br><br>
                     <div class="form-group row">
                        <label class="col-md-3 col-form-label">Mes de vacacion:</label>
                        <div class="col-md-5">
                            <input type="month" name="mes_vacacion" id="mes_vacacion" class="form-control">
                            <div id="validacion3" style="color:red"></div>
                        </div>
                    </div>
                     
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_actualizar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL ACTUALIZAR-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        
        show_data();;
        $('#filtrar').on('click',function(){
           show_data();
            
        });

        function show_data(){
            var agencia = $('#agencia').children(":selected").attr("id");
            var mes = $('#mes').val();
            var quincena = $('#quincena').val();
            
            var i = 0;
            $('#row').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Vacaciones/listarAprobacion')?>',
                dataType : 'JSON',
                data : {agencia:agencia,mes:mes,quincena:quincena},
                success : function(data){
                    console.log(data);
                   $.each(data.aprobacion,function(key, registro){
                        $('#row').append(
                            '<div class="col-sm-6">'+
                            '<div class="panel panel-primary">'+
                            '<div class="panel-heading"><strong>Empleado: </strong>'+registro.nombre+' '+registro.apellido+'</div>'+
                            '<div class="panel-body">'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Agencia: </strong>'+registro.agencia+'</div>'+
                            '<div class="col-md-6"><strong>Cargo: </strong>'+registro.cargo+'</div>'+
                            '</div>'+
                            '<hr>'+
                            '<div class="row">'+
                            '<div class="col-md-6"><strong>Plaza: </strong>'+registro.nombrePlaza+'</div>'+
                            '<div class="col-md-6"><strong>Fecha a Cancelar: </strong>'+registro.fecha_aplicacion+'</div>'+
                            '</div>'+
                            '</div>'+
                            '<div class="panel-footer" id="foo'+i+'">'+
                            '<center>'+
                            '<?php if ($aprobar==1) { ?><a id="aprobar'+i+'" class="btn btn-success item_aprobar" data-codigo="'+registro.id_vacacion+'" data-empleado="'+registro.id_empleado+'">Aprobar</a><?php } ?>'+
                            ' <?php if ($eliminar==1) { ?><a id="rechazar'+i+'" class="btn btn-danger item_iliminar" data-codigo="'+registro.id_vacacion+'">Eliminar</a><?php } ?>'+
                            '<?php if ($aprobar==1) { ?> <a class="btn btn-info" href="<?php echo base_url();?>index.php/Vacaciones/verBoleta/'+registro.id_vacacion+'" >Revisar</a><?php } ?>'+
                            '</center>'+
                            '</div>'+
                            '</div>'+
                            '</div>' 
                        );

                    if(data.diaActual <= data.diasDes[i] && data.fechas[i] == 1){
                        $("#foo"+i).hide();
                    }else{
                       if(data.diaActual <= data.diasDes[i] && data.fechas[i] == 16){
                            $("#foo"+i).hide();
                        }else{
                            $("#foo"+i).show();
                        }
                    }

                    i++;
                   });

                   if(data['aprobacion'] == 0){
                     $('#row').append(
                            '<center><div class="col-sm-10">'+
                            '<div class="panel panel-danger">'+
                            '<div class="panel-heading">Vacaciones</div>'+
                            '<div class="panel-body">No se encontraron Empleados pendientes de aprobacion de Vacaciones</div>'+
                            '</div>'+
                            '</div>'+
                            '</div></center>'
                        );
                   }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };//Fin show_data

        $('#row').on('click','.item_aprobar',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            var empleado   = $(this).data('empleado');
            $('#Modal_Aprobar').modal('show');
            $('[name="aprobacion_code"]').val(code);
            $('[name="aprobacion_empleado"]').val(empleado);
        });


        //Metodo para aprobar una vacacion
        $('#btn_aprobar').on('click',function(){
            var code = $('#aprobacion_code').val();
            var empleado = $('#aprobacion_empleado').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/aprobarVacacion')?>",
                dataType : "JSON",
                data : {code:code,empleado:empleado},
                success: function(data){
                    $('[name="aprobacion_code"]').val("");
                    $('#Modal_Aprobar').modal('toggle');
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
        });//Fin metodo para aprobar 

        $('#row').on('click','.item_iliminar',function(){ 
        //$('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Eliminar').modal('show');
            $('[name="eliminar_code"]').val(code);
        });

        //Metodo para eliminar vacaciones
        $('#btn_rechazar').on('click',function(){
            var code = $('#eliminar_code').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Vacaciones/eliminarVacacion')?>",
                    dataType : "JSON",
                    data : {code:code},
                    success: function(data){
                        
                            $('[name="eliminar_code"]').val("");
                            $('#Modal_Eliminar').modal('toggle');
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
            
        });//Fin metodo para eliminar

        //Metodo para ACTUALIZAR vacaciones
        $('#btn_actualizar').on('click',function(){
            var mes_vacacion = $('#mes_vacacion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Vacaciones/recalcularVacacion')?>",
                dataType : "JSON",
                data : {mes_vacacion:mes_vacacion},
                success: function(data){

                    if(data == null){
                        Swal.fire(
                          'Se ha actualizado con exito!!!',
                          '',
                          'success'
                        )
                      setTimeout('document.location.reload()',2000);
                      this.disabled=false;
                    }
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
            
        });//Fin metodo para ACTUALIZAR

         });//Fin jQuery
</script>
</body>


</html>