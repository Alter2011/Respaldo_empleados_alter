<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Modificar Solicitud de Prestamo Interno</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                    <nav class="float-right">
                        <div class="col-sm-10"><a href="<?= base_url();?>index.php/Prestamo/index/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Nuevo Prestamo Interno</a></div>
                        <div class="col-sm-2"><a href="<?= base_url();?>index.php/Prestamo/verSolicitudInterno/" class="btn btn-success" ><span class="fa fa-search"></span> Ver Solicitudes</a></div>

                    </nav><br><br><br>
                    <?php if($solicitud != null){?>

                    <form enctype="multipart/form-data" accept-charset="utf-8">
                            <div clas="form-row">
                                    <div id="validacion_edit" style="color:red"></div>

                            <input type="hidden" readonly name="prestamo_id" id="prestamo_id" class="form-control" value="<?= $solicitud[0]->id_prestamo;?>">

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Nombres</label>
                                    <input readonly type="text" name="empleado_nombre" id="empleado_nombre" class="form-control" value="<?= $solicitud[0]->nombre;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Apellidos</label>
                                    <input readonly type="text" name="empleado_apellido" id="empleado_apellido" class="form-control" value="<?= $solicitud[0]->apellido;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Numero de Dui</label>
                                    <input readonly type="text" name="dui" id="dui" class="form-control" value="<?= $solicitud[0]->dui;?>">
                                </div>
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Numero de Telefono</label>
                                    <input readonly type="text" name="telefono" id="telefono" class="form-control" value="<?= $solicitud[0]->tel_personal;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Agencia</label>
                                    <input readonly type="text" name="agencia" id="agencia" class="form-control" value="<?= $solicitud[0]->agencia;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Cargo</label>
                                    <input readonly type="text" name="cargo" id="cargo" class="form-control" value="<?= $solicitud[0]->cargo;?>">
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Cantidad Solicitada $</label>
                                    <input type="text" name="cantidad" id="cantidad" class="form-control" value="<?= $solicitud[0]->cantidad;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Cuota $</label>
                                    <input readonly type="text" name="cuota" id="cuota" class="form-control" value="<?= $solicitud[0]->cuota;?>">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Tiempo a pagar(Quincenas)</label>
                                    <input type="text" name="tiempo_prestamo" id="tiempo_prestamo" class="form-control" value="<?= $solicitud[0]->plazo_quincena;?>">
                                </div>

                                
                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Pedido en</label>
                                    <select class="form-control" name="pedido" id="pedido" class="form-control">
                                    <?php
                                    if($solicitud[0]->nombre_plazo=='Quincena'){
                                        ?>
                                        <option selected value="1">Quincena</option>
                                        <option value="2">Meses</option>
                                        <option value="3">Años</option>
                                    <?php
                                    }else if($solicitud[0]->nombre_plazo=='Meses'){
                                    ?>
                                        <option value="1">Quincena</option>
                                        <option selected value="2">Meses</option>
                                        <option value="3">Años</option>
                                    <?php
                                    }else if($solicitud[0]->nombre_plazo=='Años'){
                                    ?>
                                        <option value="1">Quincena</option>
                                        <option value="2">Meses</option>
                                        <option selected value="3">Años</option>
                                    <?php
                                    }
                                    ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                <label for="inputState">Tipo de Prestamo</label>
                                    <select name="tipo" id="tipo" class="form-control" >
                                        <?php
                                        $i=0;
                                        foreach($tipos as $a){
                                            if($solicitud[0]->id_tipo_prestamo==$tipos[$i]->id_tipo_prestamo)
                                            {
                                            ?>
                                                <option selected id="<?= ($tipos[$i]->id_tipo_prestamo);?>" value="<?= ($tipos[$i]->id_tipo_prestamo);?>"><?php echo($tipos[$i]->nombre_prestamo);?></option>
                                                <?php
                                            }else
                                            {
                                                ?>
                                                <option id="<?= ($tipos[$i]->id_tipo_prestamo);?>" value="<?= ($tipos[$i]->id_tipo_prestamo);?>"><?php echo($tipos[$i]->nombre_prestamo);?></option>
                                            <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Fecha Solicitado</label>
                                    <input readonly type="text" name="fecha" id="fecha" class="form-control" value="<?= $solicitud[0]->fecha_solicitado;?>">
                                </div>
                                
                            </div>

                             <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label for="inputEmail4">Enviado Por</label>
                                    <input readonly type="text" name="enviado" id="enviado" class="form-control" value="<?= $autorizacion[0]->nombre;?> <?= $autorizacion[0]->apellido;?>">
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="inputEmail4">Descripcion del Prestamo</label>
                                    <textarea readonly class="md-textarea form-control prestamo" id="justificacion" name="justificacion"><?php echo($solicitud[0]->descripcion_prestamo);?></textarea>
                                </div>

                             </div>
                            
                            <div class="form-group col-md-12">
                                <div class="form-group col-md-10">
                                    <!--Vacio-->
                                </div>
                                <div class="form-group col-md-1">
                                    
                                </div>
                                <div class="form-group col-md-1">
                                    <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
                                </div>
                            </div>

                        </form>                       

                    <?php }else{ ?>
                        <div class="panel panel-danger">
                          <div class="panel-heading">Solicitud no Encontrada</div>
                          <div class="panel-body">Esta solicituda no se encontro, por favor verifique si existe</div>
                        </div>
                    <?php

                    } ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
         //metodo para modificar 
        $('#btn_update').on('click',function(){
            var code = $('#prestamo_id').val();
            var cantidad = $('#cantidad').val();
            var tiempo_prestamo = $('#tiempo_prestamo').val();
            var pedido = $('#pedido').val();
            var tipo = $('#tipo').children(":selected").attr("id");
            
            if(confirm("¿Desea Modificar esta solicitud?")){
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/updateInterno')?>",
                dataType : "JSON",
                data : {code:code,cantidad:cantidad,tiempo_prestamo:tiempo_prestamo,pedido:pedido,tipo:tipo},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion_edit').innerHTML = '';

                        $('[name="prestamo_id"]').val("");
                        $('[name="cantidad"]').val("");
                        $('[name="tiempo_prestamo"]').val("");
                        window.location.href = "<?php echo site_url('Prestamo/verSolicitudInterno'); ?>";

                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        
                        for (i = 0; i <= data.length-1; i++){
                           
                            document.getElementById('validacion_edit').innerHTML += data[i];
                           
                        }//Fin For
                    }//fin if else data == null 
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
            }
            
        });//Fin metodo modificar
    });
</script>