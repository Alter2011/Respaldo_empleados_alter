<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->
        <div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
            <div class="text-center well text-white blue print-blue">
                <h2>Historial Academico</h2>
                <input type="button" class="no-print" onclick="window.print();" value="Print Invoice" />
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                        <nav class="float-right">                   
                        </nav>
                        <form action="<?= base_url();?>index.php/Empleado/update/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <img src="../../../../Produccion/PHP/user_images/<?= strtolower(@$fProspectos[0]->usuarioP);?>.png" class="img-circle" width="150" heigth="150">
                                    <div class="row">
                                        <div class="col-sm-3 text-center"></div>
                                        <div class="col-sm-2 text-center no-print">
                                            <?php if($ver){?>
                                            <a href="<?= base_url();?>index.php/Empleado/update/<?= $empleado[0]->id_empleado;?>" class="btn btn-success" ><span class="fa fa-user"></span> Ver Datos</a> 
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-sm-9">
                                    <div clas="form-row">
                                        <input type="hidden" readonly name="empleado_id" id="empleado_id" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->id_empleado;?>">
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label for="inputEmail4">Nombres</label>
                                            <input type="text" disabled name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->nombre." ". $empleado[0]->apellido;?>">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                            <label for="inputCity">Correo Empresarial</label>
                                            <input type="text" disabled name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com" value="<?= $empleado[0]->correo_empresa?>">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                            <label for="inputState">Telefono Empresarial</label>
                                            <input type="text" disabled name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####" value="<?= $empleado[0]->tel_empresa;?>">
                                        </div>
                                    <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                        <label for="inputState">Nivel Academico</label>
                                            <select name="empleado_nivel" disabled id="empleado_nivel" class="form-control" placeholder="Price">
                                                <?php
                                                
                                                $i=0;
                                                foreach($nivel as $a){
                                                    if($empleado[0]->id_nivel==$nivel[$i]->id_nivel)
                                                    {
                                                        ?>
                                                        <option selected id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                                        <?php
                                                    }else
                                                    {
                                                        ?>
                                                        <option id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                                        <?php
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                    </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                            <label for="empleado_activo">Empleado Activo</label>
                                            <br>
                                            <?php
                                            if($empleado[0]->activo==1){
                                                ?>
                                                <input disabled class="form-check-input form-control" type="checkbox" id="empleado_activo" name="empleado_activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-offstyle="danger" checked>
                                                <?php
                                            }else{
                                                ?>
                                                <input disabled class="form-check-input form-control" type="checkbox" id="empleado_activo" name="empleado_activo" data-toggle="toggle" data-on="Activo" data-off="Inactivo" data-offstyle="danger">
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>    
                            <div class="row">
                                <br>
                                <div class="panel-group col-sm-12">

                                    <?php
                                    $i=0;
                                    foreach($historial_academico as $a){       
                                    ?>
                                    <div class="panel panel-primary ">
                                        <div class="panel-heading print-blue">Nivel: <label><?php echo($historial_academico[$i]->nivel);?></label></div>
                                        <div class="panel-body">
                                            <div class="col-sm-6"><label>Institucion: </label><?php echo($historial_academico[$i]->institucion);?> </div>
                                            <div class="col-sm-6"><label>Titulo: </label><?php echo($historial_academico[$i]->titulo);?> </div>
                                        </div>
                                    </div>           

                                    <?php
                                    $i++;
                                }
                                ?>
                                <img src="<?= base_url();?>/assets/images/watermark.png" alt="Marca de agua" class="only-print logo">
                                                                            <?php if($editar){?>

                                <div class="panel panel-default no-print">
                                    <div class="panel-heading"><label>Opciones</label></div>
                                    <div class="panel-body">
                                        <div class="col-sm-8">
                                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#Modal_Add">
                                                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Nuevo Registro
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                                                            <?php }?>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Nuevo historial academico</h3>
                </div>
                <div class="modal-body">
                <?php
                    //if($this->session->userdata('rol')=="Administrador"){ 
                ?>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <input type="hidden" name="emp_code" id="emp_code" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                            <input type="hidden" name="emp_nivel" id="emp_nivel" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_nivel;?>>
                        </div>
                    </div>
                    <div class="form-group row">
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Nivel</label>
                        <div class="col-md-10">


                            <select name="contrato_nivel" id="contrato_nivel" class="form-control" placeholder="Price">
                                <?php
                                $i=0;
                                foreach($nivel as $a){

                                    //validacion de grado menor ingresado ya no permitido
                                    $validador=true;
                                    $j=0;
                                    foreach($historial_academico as $a){ 
                                        if (strcmp($historial_academico[$j]->nivel,$nivel[$i]->nivel)==0) {
                                            $validador=false;
                                        }
                                        if ($nivel[$i]->nivel=="Universitario") {
                                         //el grado universitario se permiten muchos 
                                         $validador=true;
                                         break;
                                     }
                                     $j++;
                                 }



                                 if ($validador ) {

                                    ?>
                                    <option id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                                    <?php

                                }
                                $i++;
                            }
                            ?>
                        </select>
                    </div>
                </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Institucion</label>
                        <div class="col-md-10">
                            <input type="text" name="contrato_institucion" id="contrato_institucion" class="form-control" placeholder="Intitucion">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Titulo</label>
                        <div class="col-md-10">
                             <input type="text" name="contrato_titulo" id="contrato_titulo" class="form-control" placeholder="Titulo">
                        </div>
                    </div>
                    
                    
                <?php //}else{?>
                <?php // }?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <?php
                        //if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    <button type="button" type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
                    <?php
                    // }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->
<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Ver Registro Actual</h3>
                </div>
                <div class="modal-body">
                <?php

                    //if($this->session->userdata('rol')=="Administrador"){ 
                ?>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <input type="hidden" name="product_code" id="product_code" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-2 col-form-label">Area</label>
                    <div class="col-md-10">
                    <select name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                    
                    <?php
                    $i=0;
                    foreach($cargos as $a){
                        if($contratos[0]->id_cargo==$cargos[$i]->id_cargo)
                        {
                        ?>
                            <option selected id="<?= ($cargos[$i]->id_cargo);?>" value="<?= ($cargos[$i]->id_cargo);?>"><?php echo($cargos[$i]->cargo);?></option>
                            <?php
                        }else
                        {
                            ?>
                            <option id="<?= ($cargos[$i]->id_cargo);?>" value="<?= ($cargos[$i]->id_cargo);?>"><?php echo($cargos[$i]->cargo);?></option>
                        <?php
                        }
                        $i++;
                    }
                    ?>
                    </select>
                    </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Agencia</label>
                        <div class="col-md-10">
                        <select disabled name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($agencias as $a){
                            if($contratos[0]->id_agencia==$agencias[$i]->id_agencia){
                                ?>
                                    <option selected id="<?= ($agencias[$i]->id_agencia);?>" value="<?= ($agencias[$i]->id_agencia);?>"><?php echo($agencias[$i]->agencia);?></option>
                                <?php
                            }else{
                                ?>
                                <option id="<?= ($agencias[$i]->id_agencia);?>" value="<?= ($agencias[$i]->id_agencia);?>"><?php echo($agencias[$i]->agencia);?></option>
                                <?php
                            }
                            $i++;
                        }
                        ?>
                    </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Fecha de Inicio</label>
                        <div class="col-md-10">
                            <input disabled type="date" name="agn_tel" id="agn_tel" class="form-control" placeholder="Telefono agencia" value=<?= date("Y-m-d",strtotime($contratos[0]->fecha_inicio));//$contratos[$a]->fecha_inicio?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Estado</label>
                        <div class="col-md-10">
                        <select name="contrato_tipo_mod" id="contrato_tipo_mod" class="form-control" placeholder="Price">     
                            <option id="1" value="1">Nuevo</option>
                            <option id="2" value="2">Cambio/Ascenso</option>
                        </select>
                        </div>
                    </div>
                    
                    
                <?php //}else{?>
                <?php // }?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <?php
                        //if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    
                    <?php
                    // }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->
<!-- MODAL DELETE -->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Finalizacion de Registro</h3>
                </div>
                <div class="modal-body">
                <?php
                    //if($this->session->userdata('rol')=="Administrador"){ 
                ?>
                    <div class="form-group row">
                        <div class="col-md-10">
                           </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="empleado_code_de" id="empleado_code_de" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                        </div>
                    </div>
                    <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fecha Fin</label>
                    <div class="col-md-10">
                        <input type="date" name="contrato_fin" id="contrato_fin" class="form-control" placeholder="Product Code">
                    </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Estado</label>
                        <div class="col-md-10">
                        <select name="contrato_tipo_de" id="contrato_tipo_de" class="form-control" placeholder="Price">     
                            <option id="1" value="0">Despido</option>
                            <option id="2" value="4">Renuncia</option>
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Razon de Salida</label>
                        <div class="col-md-10">
                        <textarea class="form-control" rows="3" placeholder="Razon por la cual deja de ser empleado de la empresa..." name="contrato_razon" id="contrato_razon"></textarea>
                        </div>
                    </div>
                
                    
                <?php //}else{?>
                <?php // }?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <?php
                        //if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    <button type="button" type="submit" id="btn_Delete" class="btn btn-primary">Eliminar</button>
                    <?php
                    // }
                    ?>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->
<script type="text/javascript">
i = 0;

    $(document).ready(function(){
        
        //Save product
        $('#btn_Delete').on('click',function(){
            this.disabled=true;
            var employee_code = $('#contrato_code_de').val();
            var contrato_fin = $('#contrato_fin').val();
            var contrato_razon = $('#contrato_razon').val();
            var empleado = $('#empleado_code_de').val();
            var tipo = $('#contrato_tipo_de').val();

            //var area_name = $('#area_name').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/delete')?>",
                dataType : "JSON",
                data : { employee_code:employee_code, contrato_fin:contrato_fin, contrato_razon:contrato_razon, empleado:empleado, tipo:tipo},
                success: function(data){
                    //$('[name="area_name"]').val("");
                    //$('#Modal_Add').modal('hide');
                    location.reload();
                    this.disabled=false;
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });
        
        //Save product
        $('#btn_save').on('click',function(){
            this.disabled=true;
            var employee_code = $('#emp_code').val();
            var employee_nivel = $('#emp_nivel').val();
            var contrato_nivel = $('#contrato_nivel').val();
            var contrato_institucion = $('#contrato_institucion').val();
            var contrato_titulo = $('#contrato_titulo').val();
            //var area_name = $('#area_name').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Academico/save_h')?>",
                dataType : "JSON",
                data : {  employee_code:employee_code, employee_nivel:employee_nivel,contrato_nivel:contrato_nivel, contrato_institucion:contrato_institucion, contrato_titulo:contrato_titulo},
                success: function(data){
                    //$('[name="area_name"]').val("");
                    //$('#Modal_Add').modal('hide');
                    location.reload();
                    this.disabled=false;
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });


    });//Fin Jquery
</script>
</body>
</html>