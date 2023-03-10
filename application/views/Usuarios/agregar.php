<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<form action="<?php if($accion=='insertar'){echo base_url("index.php/usuarios/insertar");}else if($accion=='editar'){echo base_url("index.php/usuarios/editar");} ?>" method="POST" enctype="multipart/form-data">
    <div class="col-sm-10">
        <div class="text-center well text-white blue">
            <h2>Administración de usuarios</h2>
        </div>
        <div clas="form-row">
                              <p style="color:red"><?php if(isset($mensaje)) echo $mensaje; ?></p>
                                 <?php $incorrecto = $this->session->flashdata('incorrecto');
                     if ($incorrecto){ ?>
                       <div class="alert alert-danger" id="registroCorrecto"><?= $incorrecto ?></div>
                     <?php } ?>

            <div class="well col-sm-12 ">
                <div class="form-group col-md-6">
                    <label>Usuario</label>
                    <input type="text" name="usuario" value="<?php if(isset($usuario)){echo($usuario->usuario);}?>" class="form-control"> 
                </div>
                <div class="form-group col-md-6">
                    <label>Usuario Produccion</label>
                    <input type="text" name="usuarioP" value="<?php if(isset($usuario)){echo($usuario->usuarioP);}?>" class="form-control"> 
                </div>
                <div class="form-group col-md-6">
                    <label>Empleado</label>
                    <?php if($accion=='editar'){ 
                        ?>
                        <input type="hidden" name="emp" value="<?= $this->uri->segment(3); ?>">
                        <?php
                    } ?>
                        <select class='form-control mi-selector' <?php if($accion=='editar'){ echo "disabled";} ?> name='empleado'>
                        <?php

                            foreach($empleados as $empleado){
                                if($empleado->id_empleado==$usuario->id_empleado){
                                     ?>
                                <option selected value="<?= ($empleado->id_empleado);?>"><?= $empleado->apellido.' '.$empleado->nombre;?></option>
                        <?php
                                 
                            }else{


                        ?>
                                <option  value="<?= ($empleado->id_empleado);?>"><?= $empleado->apellido.' '.$empleado->nombre;?></option>
                        <?php
                                 }
                            } 
                        ?>
                        </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Perfil</label>
                    <select class='form-control mi-selector' name='perfil' id="perfil">
                        <?php
                        
                        foreach($perfiles as $perfil){
                                 if($perfil->id_perfil==$usuario->id_perfil){
                                     ?>
                                <option selected value="<?= ($perfil->id_perfil);?>"><?= $perfil->nombre;?></option>
                        <?php
                                 
                            }else{


                        ?>
                            <option  value="<?= ($perfil->id_perfil);?>"><?= $perfil->nombre;?></option>
                            <?php
                            }
                            
                        } 
                        ?>
                    </select>

                </div>

                <div class="form-group col-md-6">
                    <label for="inputState">Asignacion</label>
                    <select class="form-control" name="asignacion" id="asignacion" class="form-control">
                        
                    </select>
                </div>

                <div class="form-group col-md-6" id="div_agencia">
                    <label for="inputState">Agencia</label>
                    <select class="form-control" name="agencia" id="agencia" class="form-control">
                        
                    <?php
                        foreach($agencia as $agn){
                            if($agn->id_agencia==$usuario->id_agencia){
                    ?>
                        <option selected value="<?= ($agn->id_agencia);?>"><?php echo($agn->agencia);?></option>
                    <?php
                        }else{
                    ?>
                        <option value="<?= ($agn->id_agencia);?>"><?php echo($agn->agencia);?></option>
                    <?php
                        }
                     }
                    ?>
                    </select>
                </div>


            </div>
        </div>
        <div clas="row">
            <div class="form-group col-md-4"></div>
            <div class="form-group col-md-6">
                <div class="form-group col-md-4">
                    <?php if($accion=='insertar'){
                        ?>
                        <button name="guardar_cliente" id="save_agn_controller" class="btn btn-primary"><span class="fa fa-plus"></span> Agregar Nuevo</button>
                        <?php
                    }else if($accion=='editar'){
                        ?>
                        <button name="guardar_cliente" id="save_agn_controller" class="btn btn-primary"><span class="fa fa-plus"></span> Editar usuario</button>
                        <?php
                    } ?>
                               
                </div>
                <div class="form-group col-md-2">
                    <a href="<?= base_url();?>index.php/usuarios/ver/" class="btn btn-danger"><span class="fa fa-arrow-left"></span> Cancelar</a>
                </div>
            </div>
        </div>
    </div>
</form>

<script >
    jQuery(document).ready(function($){

        $(document).ready(function() {
            $('.mi-selector').select2();

            var valor = $('#perfil').val();
             if (valor==27){
                $('#div_agencia').show();
            }else{
                $('#div_agencia').hide();
            }

        });
        accion = <?php echo json_encode($accion); ?>;
                if(accion == 'insertar'){
                    asignacion();
                }else if(accion == 'editar'){
                    asignacion_edit();
                }

        $('#perfil').change(function(){
            var valor = $(this).val();
            if (valor==27){
                document.ready = document.getElementById("agencia").value = '00';
                $('#div_agencia').show();
            }else{
                document.ready = document.getElementById("agencia").value = '0';
                $('#div_agencia').hide();
            }

            <?php if($accion=='insertar'){ ?>
                asignacion();
            <?php }else if($accion=='editar'){ ?>
                asignacion_edit();
            <?php } ?>
            
            //alert(val_agn);
        });

        $("#asignacion").prop('disabled', true);
        function asignacion(){
            //var perfil = $('#perfil').val();
            var perfil = $('#perfil').children(":selected").attr("value");
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('usuarios/buscar_asignacion')?>",
                dataType : "JSON",
                data : {perfil:perfil},
                success: function(data){
                    console.log(data);
                    $("#asignacion").empty();
                    if(data != null){
                        $("#asignacion").prop('disabled', false);
                        $.each(data,function(key, registro) {
                            $("#asignacion").append('<option id='+registro.codigo+' value='+registro.codigo+'>'+registro.nombre+'</option>');
                        });
                    }else{
                        $("#asignacion").prop('disabled', true);
                        $("#asignacion").append('<option value=NULL>No posee asignacion este perfil</option>');
                    }

                },
                error: function(data){
                  var a =JSON.stringify(data['responseText']);
                  alert(a);
                }
            });
        };

        function asignacion_edit(){
            <?php if (isset($usuario)) { ?>
                usuario = <?php echo json_encode($usuario); ?>;
            <?php } ?>
            var perfil = $('#perfil').children(":selected").attr("value");

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('usuarios/buscar_asignacion')?>",
                dataType : "JSON",
                data : {perfil:perfil},
                success: function(data){
                    console.log(data);
                    $("#asignacion").empty();
                    if(data != null){
                        $("#asignacion").prop('disabled', false);
                        $.each(data,function(key, registro) {
                            $("#asignacion").append('<option id='+registro.codigo+' value='+registro.codigo+'>'+registro.nombre+'</option>');
                        });
                        $("#asignacion option[value='"+usuario[0].codigo+"'").attr("selected",true);
                    }else{
                        $("#asignacion").prop('disabled', true);
                        $("#asignacion").append('<option value=NULL>No posee asignacion este perfil</option>');
                    }

                },
                error: function(data){
                  var a =JSON.stringify(data['responseText']);
                  alert(a);
                }
            });
        }

    });
</script>