<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
        <div class="col-sm-10 col-xs-12 print-col-sm-10" id="imprimir">
            <div class="text-center well text-white blue print-blue">
                <h2>Historial Laboral</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                        <nav class="float-right">                   
                        </nav>
                        <form action="<?= base_url();?>index.php/Empleado/update/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="col-sm-3 text-center">
                                    <iframe src="<?= $empleado[0]->foto?>" class="img-circle" width="150" heigth="150">
                                    </iframe>
                                    <div class="row">
                                    <div class="col-sm-3 text-center"></div>
                                        <div class="col-sm-2 text-center no-print">
                                            <?php if ($ver) { ?>
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
                            <h2 class="text-center no-print">Historial Laboral</div></h2>
                            <div class="panel-group col-sm-12">
                                <img src="<?= base_url();?>/assets/images/watermark.png" alt="Marca de agua" class="only-print logo">
                            <?php
                            $a = 0;
                            $b = 0;
                                if (empty($contratos) && empty($actual)) {
                             ?>
                                   <div class="panel panel-danger ">
                                    <div class="panel-heading"><label>No existen datos</label></div>
                                    <div class="panel-body">
                                        <div class="col-sm-8">
                                            <p>No se han ingresado datos de historial laboral</p>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        
                                    </div>
                                </div>
                             <?php
                                }
                            foreach ($actual as $act) {
                               if($actual[$b]->estado == 1){
                                    $est = "Activo";
                               }else if($actual[$b]->estado == 3){
                                        $est = "Recontratado";
                               }
                            ?>
                                <div class="panel panel-primary">
                                    <div class="panel-heading print-blue"><label><?= $actual[$b]->cargo?></label></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-3"><label>Inicio: </label> <?= $actual[$b]->fecha_inicio?></div>
                                            <div class="col-sm-3"><label>Estado: </label> <?= $est?></div>
                                            <div class="col-sm-3"><label>Agencia: </label> <?= $actual[$b]->agencia?></div>
                                            <div class="col-sm-3"><label>Plaza: </label> <?= $actual[$b]->nombrePlaza?></div>
                                        </div>
                                        <div class="row"><hr>
                                            <div class="col-sm-3"><label>Empresa: </label> <?= $actual[$b]->nombre_empresa?></div>
                                            <div class="col-sm-3"><label>Cargo: </label> <?= $actual[$b]->cargo?></div>.
                                            <?php if($salario == 1){ ?>
                                            <div class="col-sm-3"><label>Salario: $</label> <?= $actual[$b]->Sbase?></div>
                                            <?php }else if($salario == 0 && $actual[$b]->id_agencia != 00 && $salarios_agencia == 1){ ?>
                                                <div class="col-sm-3"><label>Salario: $</label> <?= $actual[$b]->Sbase?></div>
                                            <?php } ?>
                                        </div>

                                    </div>
                                    <?php if($editar){?>
                                    <div class="panel-footer no-print">
                                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#Modal_Edit">
                                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Ver Registro Actual
                                    </button>
                                        <?php if ($actual[0]->forma==1 or $actual[0]->forma==3) { ?>
                                    <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#Modal_Cambio">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Cambiar Contrato
                                    </button>
                                       <?php }?>

                                    <button type="button" class="btn  btn-lg" data-toggle="modal" data-target="#Modal_Delete">
                                            <span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span> Finalizar Registro Actual
                                    </button>

                                    
                                    <a href="<?php echo base_url();?>index.php/Contratacion/imprimir_contrato/<?php echo $actual[$b]->id_contrato?>" class="btn btn-success crear">Imprimir Contrato</a>
                                    </div>
                                <?php } ?>
                                </div>
                            <?php 
                            $b++;
                            }
                            foreach($contratos as $contra){
                                if($contratos[$a]->estado == 10 && $maternidad != null){ 
                                    $est = "Maternidad";
                                    ?>
                                    <div class="panel panel-info">
                                    <div class="panel-heading print-skyblue">
                                        <label><?= $maternidad[0]->cargo?></label>
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-3"><label>Razon: </label> <?= $est?></div>
                                            <div class="col-sm-3"><label>Inicio: </label> <?= $maternidad[0]->fecha_inicio?></div>
                                            <div class="col-sm-3"><label>Fin: </label> <?= $maternidad[0]->fecha_fin?></div>
                                            <div class="col-sm-3"><label>Agencia: </label> <?= $maternidad[0]->agencia?></div>
                                        </div><hr>
                                        <div class="row">
                                            <div class="col-sm-3"><label>Plaza: </label> <?= $maternidad[0]->nombrePlaza?></div>
                                            <div class="col-sm-3"><label>Empresa: </label> <?= $maternidad[0]->nombre_empresa?></div>
                                            <?php if($salario == 1){ ?>
                                                <div class="col-sm-3"><label>Sueldo: $</label> <?= $maternidad[0]->Sbase?></div>
                                            <?php }else if($salario == 0 && $maternidad[0]->id_agencia != 00 && $salarios_agencia == 1){ ?>
                                                <div class="col-sm-3"><label>Sueldo: $</label> <?= $maternidad[0]->Sbase?></div>
                                            <?php } ?>
                                        </div>
                                        <br>
                                        <div class="panel-footer no-print" style="text-align: center;">
                                            
                                            <button type="button" class="btn btn-default btn-lg" data-toggle="modal" data-target="#Modal_Activar">
                                                <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Activar
                                            </button>
                                            <a href="<?php echo base_url();?>index.php/Contratacion/imprimir_contrato/<?php echo $maternidad[0]->id_contrato?>" class="btn btn-success btn-lg crear">
                                                <span class="glyphicon glyphicon-print"></span> Imprimir Contrato
                                            </a>

                                        </div>
                                    
                                    </div>
                                </div>

                                <?php
                                }else if($contratos[$a]->estado == 0 || $contratos[$a]->estado == 4 || $contratos[$a]->estado == 6){
                                        $marcar_sin_dias=  '';
                                        if($contratos[$a]->estado == 0){
                                            $est = "Despido";
                                        }else if($contratos[$a]->estado == 4){
                                            $est = "Renuncia";
                                            if($contratos[$a]->tipo_des_ren != 6){
                                            $marcar_sin_dias = '<a class="btn btn-warning" style="float: right; margin-top: 20px" onclick="marcar_dias('.$contratos[$a]->id_contrato.')">Marcar como incumplimiento de dias</a>';
                                            }
                                        }else if($contratos[$a]->estado == 6){
                                            $est = "Jubilación y Retiro";
                                        }
                                        $activa = '';
                                        if(empty($actual) && $activar == 1){
                                            $activa = '<a class="btn btn-primary" style="float: right;" onclick="activar_empleado('.$contratos[$a]->id_contrato.')"><span  class="glyphicon glyphicon-ok"></span> Activar empleado</a>';
                                        }
                                    ?>

                                    <div class="panel panel-danger">
                                        <div class="panel-heading print-red">
                                            <div class="row">
                                                <div class="col-sm-4"><label><?= $contratos[$a]->cargo?></label></div>
                                                <div class="col-sm-4"><label></label></div>
                                                <div class="col-sm-4">
                                                    <?= $activa ?>
                                                    <?= $marcar_sin_dias ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-sm-3"><label>Inicio: </label> <?= $contratos[$a]->fecha_inicio?></div>
                                                <div class="col-sm-3"><label>Finalizo: </label> <?= $contratos[$a]->fecha_fin?></div>
                                                <div class="col-sm-3"><label>Estado: </label> <?= $est?></div>
                                                <div class="col-sm-3"><label>Agencia: </label> <?= $contratos[$a]->agencia?></div>
                                            </div>
                                            <div class="row"><hr>
                                                <div class="col-sm-3"><label>Empresa: </label> <?= $contratos[$a]->nombre_empresa?></div>
                                                <div class="col-sm-3"><label>Plaza: </label> <?= $contratos[$a]->nombrePlaza?></div>
                                                <div class="col-sm-3"><label>Cargo: </label> <?= $contratos[$a]->cargo?></div>
                                                <?php if($salario == 1){ ?>
                                                    <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                                <?php }else if($salario == 0 && $contratos[$a]->id_agencia != 00 && $salarios_agencia == 1){ ?>
                                                    <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                                <?php } ?>
                                                </div>

                                        </div>
                                        <div class="panel-footer">
                                        <label>Razon: </label> <?= $contratos[$a]->razon?>
                                        <a href="<?php echo base_url();?>index.php/Contratacion/imprimir_contrato/<?php echo $contratos[$a]->id_contrato ?>" class="btn btn-success crear" style="float: right;">Imprimir Contrato</a><br><br>
                                        </div>
                                    </div>

                                <?php }else if($contratos[$a]->estado == 2 || $contratos[$a]->estado == 5 || $contratos[$a]->estado == 6 || $contratos[$a]->estado == 7 || $contratos[$a]->estado == 8 || $contratos[$a]->estado == 9){ 
                                        if ($contratos[$a]->estado==5) {
                                            $est = "Cambio de Plaza";

                                         }else if ($contratos[$a]->estado==2) {
                                            $est = "Cambio de Cargo/Categoria";
     
                                         }else if ($contratos[$a]->estado==7) {
                                            $est = "Cambio de Categoria";
     
                                         }else if ($contratos[$a]->estado==8) {
                                            $est = "Cambio de Agencia/Plaza";
     
                                         }else if ($contratos[$a]->estado==6) {
                                            $est = "Jubilación Flexible";
     
                                         }else if ($contratos[$a]->estado==9) {
                                            $est = "Interinato";
     
                                         }
                                    ?>

                                    <div class="panel panel-info">
                                    <div class="panel-heading print-skyblue"><label><?= $contratos[$a]->cargo?></label></div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-3"><label>Inicio: </label> <?= $contratos[$a]->fecha_inicio?></div>
                                            <div class="col-sm-3"><label>Razon: </label> <?= $est?></div>
                                            <div class="col-sm-3"><label>Agencia: </label> <?= $contratos[$a]->agencia?></div>
                                            <div class="col-sm-3"><label>Plaza: </label> <?= $contratos[$a]->nombrePlaza?></div>
                                        </div><hr>
                                        <div class="row">
                                            <div class="col-sm-3"><label>Empresa: </label> <?= $contratos[$a]->nombre_empresa?></div>
                                            <div class="col-sm-3"><label>Cargo: </label> <?= $contratos[$a]->cargo?></div>
                                            <?php if($salario == 1){ ?>
                                                <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                            <?php }else if($salario == 0 && $contratos[$a]->id_agencia != 00 && $salarios_agencia == 1){ ?>
                                                <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12" style="text-align: center;"><a href="<?php echo base_url();?>index.php/Contratacion/imprimir_contrato/<?php echo $contratos[$a]->id_contrato ?>" class="btn btn-success crear">Imprimir Contrato</a></div>  
                                        </div>
                                    
                                    </div>
                                </div>

                            <?php }else if($contratos[$a]->estado == 11){ 
                                if ($contratos[$a]->estado==11) {
                                    $est = "Cesantía";
                                }
                            ?>
                            <div class="panel panel-warning">
                            <div class="panel-heading"><label><?= $contratos[$a]->cargo?></label></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-sm-3"><label>Inicio: </label> <?= $contratos[$a]->fecha_inicio?></div>
                                        <div class="col-sm-3"><label>Razon: </label> <?= $est?></div>
                                        <div class="col-sm-3"><label>Agencia: </label> <?= $contratos[$a]->agencia?></div>
                                        <div class="col-sm-3"><label>Plaza: </label> <?= $contratos[$a]->nombrePlaza?></div>
                                    </div><hr>
                                    <div class="row">
                                        <div class="col-sm-3"><label>Empresa: </label> <?= $contratos[$a]->nombre_empresa?></div>
                                        <div class="col-sm-3"><label>Cargo: </label> <?= $contratos[$a]->cargo?></div>
                                        <?php if($salario == 1){ ?>
                                            <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                        <?php }else if($salario == 0 && $contratos[$a]->id_agencia != 00 && $salarios_agencia == 1){ ?>
                                            <div class="col-sm-3"><label>Salario: $</label> <?= $contratos[$a]->Sbase?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12" style="text-align: center;">
                                            <a class="btn btn-default btn-lg item_activar" data-toggle="modal" data-codigo="<?= $contratos[$a]->id_contrato?>" data-control="<?= $Cesantia[0]->id_control_contrato?>">
                                            <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Activar
                                            </a>
                                            <a href="<?php echo base_url();?>index.php/Contratacion/imprimir_contrato/<?php echo $contratos[$a]->id_contrato?>" class="btn btn-success btn-lg crear">
                                            <span class="glyphicon glyphicon-print"></span> Imprimir Contrato
                                            </a>
                                                
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <?php
                            }//Fin de los if ani
                            $a++;
                            }//fin foreach
                            ?>
                            
                            <?php if($editar){
                                    if((empty($contratos) && empty($actual) && empty($maternidad)) || $ultimo[0]->estado == 4 || $ultimo[0]->estado == 9 || $ultimo[0]->estado == 0){
                                ?>
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
                            <?php }else if($contratos != null){
                                    if($cantida[0]->conteo == 0){
                            ?>

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
                                
                            <?php } }else if($actual[0]->estado == 4){ ?>

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

                            <?php } } ?>
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
                    <h3 class="modal-title text-center" id="exampleModalLabel">Contrato Nuevo</h3>
                </div>
                <div class="modal-body">
                <?php
                    //if($this->session->userdata('rol')=="Administrador"){ 
                ?>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <input type="hidden" name="emp_code" id="emp_code" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                            <input type="hidden" name="contrato_code" id="contrato_code" class="form-control" placeholder="Product Code" value=<?= @$actual[0]->id_contrato;?>>
                        </div>
                    </div>

                    <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cargo</label>
                    <div class="col-md-10">
                    <select name="contrato_cargo" id="contrato_cargo" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($cargos as $a){
                        
                        ?>
                            <option id="<?= ($cargos[$i]->id_cargo);?>" value="<?= ($cargos[$i]->id_cargo);?>"><?php echo($cargos[$i]->cargo);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                    </select>
                    </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Categoria</label>
                        <div class="col-md-10">
                        <select name="contrato_categoria" id="contrato_categoria" class="form-control" placeholder="">
                        </select>
                        <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Empresa</label>
                        <div class="col-md-10">
                        <select name="contrato_empresa" id="contrato_empresa" class="form-control" placeholder="">
                            <?php
                        $i=0;
                        foreach($empresas as $a){
                        ?>
                            <option id="<?= ($empresas[$i]->id_empresa);?>" value="<?= ($empresas[$i]->id_empresa);?>"><?php echo($empresas[$i]->nombre_empresa);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                        </select>
                        <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Agencia</label>
                        <div class="col-md-10">
                        <select name="contrato_agencia" id="contrato_agencia" class="form-control" placeholder="Price">
                       
                    </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Plaza</label>
                        <div class="col-md-10">
                        <select name="contrato_plaza" id="contrato_plaza" class="form-control" placeholder="">
                        </select>
                        <div id="validacion2" style="color:red"></div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Fecha de Inicio</label>
                        <div class="col-md-10">
                            <input type="date" name="contrato_inicio" id="contrato_inicio" class="form-control" placeholder="Telefono agencia">
                            <div id="validacion3" style="color:red"></div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tipo</label>
                        <div class="col-md-10">
                        <select name="contrato_tipo" id="contrato_tipo" class="form-control" placeholder="Price">     
                            <?php 
                            if($ultimo[0]->estado == 0 or $ultimo[0]->estado == 4){
                            ?>
                            <option id="1" value="1">Nuevo</option>
                            <option id="3" value="3">Reingreso</option>
                            
                            <?php
                                }else{
                            ?>
                            <option id="2" value="2">Cambio de cargo</option>
                            <option id="2" value="5">Ascenso</option>
                            <option id="2" value="6">Nivelacion salarial</option>
                            <option id="2" value="7">Cambio de categoria</option>
                            <option id="2" value="8">Cambio de agencia</option>


                            <?php
                                }
                            ?>
                            
                        </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Tipo de contrato</label>
                        <div class="col-md-10">
                        <select name="contrato_forma" id="contrato_forma" class="form-control" id="forma">     
                            <option id="1" value="1">Permanente</option>
                            <option id="2" value="2">Temporal</option>
                            <option id="3" value="3">Interinato</option>
                        </select>
                        </div>
                    </div>

                    <div class="form-group row" id="tipo_interinato">
                        <label class="col-md-2 col-form-label">Tipo de interinato</label>
                        <div class="col-md-2">
                            <input type="radio" name="tipo_inter" value="Maternidad"> Maternidad
                        </div>
                        <div class="col-md-2">
                            <input type="radio" name="tipo_inter" value="Incapacidad"> Incapacidad
                        </div>
                        <div class="col-md-2">
                            <input type="radio" name="tipo_inter" value="Prorroga"> Prórroga
                        </div>
                         <div id="validacion6" style="color:red"></div>
                    </div>

                    <div class="form-group row" id="forma">
                        <label class="col-md-2 col-form-label">Descripcion</label>
                        <div class="col-md-10">
                             <textarea class="md-textarea form-control" id="descripcion_temporal" name="descripcion_temporal"></textarea>
                             <div id="validacion4" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row" id="forma1">
                        <label class="col-md-2 col-form-label">Finalizacion de contrato</label>
                        <div class="col-md-10">
                             <input type="date" name="final_temporal" id="final_temporal" class="form-control" placeholder="">
                             <div id="validacion5" style="color:red"></div>
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
                    <label class="col-md-2 col-form-label">Cargo</label>
                    <div class="col-md-10">
                    <select name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price" disabled>
                    
                    <?php
                    $i=0;
                    foreach($cargos as $a){
                        if($actual[0]->id_cargo==$cargos[$i]->id_cargo)
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
                        <label class="col-md-2 col-form-label">Categoria</label>
                        <div class="col-md-10">
                        <select disabled name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($categorias as $a){
                            if($actual[0]->id_categoria==$categorias[$i]->id_categoria){
                                ?>
                                    <option selected id="<?= ($categorias[$i]->id_categoria);?>" value="<?= ($categorias[$i]->id_categoria);?>"><?php echo($categorias[$i]->categoria." $". $categorias[$i]->Sbase)?></option>
                                <?php
                            }else{
                                ?>
                                <option id="<?= ($categorias[$i]->id_categoria);?>" value="<?= ($categorias[$i]->id_categoria);?>"><?php echo($categorias[$i]->categoria." $". $categorias[$i]->Sbase)?></option>
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
                            if($actual[0]->id_agencia==$agencias[$i]->id_agencia){
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
                        <label class="col-md-2 col-form-label">Plaza</label>
                        <div class="col-md-10">
                        <select disabled name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($plaza as $a){
                            if($actual[0]->id_plaza==$plaza[$i]->id_plaza){
                                ?>
                                    <option selected id="<?= ($plaza[$i]->id_plaza);?>" value="<?= ($plaza[$i]->id_plaza);?>"><?php echo($plaza[$i]->nombrePlaza);?></option>
                                <?php
                            }else{
                                ?>
                                <option id="<?= ($plaza[$i]->id_plaza);?>" value="<?= ($plaza[$i]->id_plaza);?>"><?php echo($plaza[$i]->nombrePlaza);?></option>
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
                            <input disabled type="date" name="agn_tel" id="agn_tel" class="form-control" placeholder="Telefono agencia" value=<?= date("Y-m-d",strtotime($actual[0]->fecha_inicio));//$contratos[$a]->fecha_inicio?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Estado</label>
                        <div class="col-md-10">
                    <select name="contrato_tipo_mod" id="contrato_tipo_mod" class="form-control" placeholder="Price">     
                        <option id="1" value="1" <?php if($actual[0]->estado == "1") {
        echo "selected";        }  ?>>Nuevo</option>
                        <option id="2" value="2" <?php if($actual[0]->estado == "2") {
        echo "selected";        }  ?>>Cambio de cargo</option>
                        <option id="3" value="3" <?php if($actual[0]->estado == "3") {
        echo "selected";        }  ?>>Reingreso</option>
                        <option id="2" value="8" <?php if($actual[0]->estado == "8") {
        echo "selected";        }  ?>>Cambio de agencia</option>
                        <option id="2" value="5" <?php if($actual[0]->estado == "5") {
        echo "selected";        }  ?>>Ascenso</option>

                        <option id="6" value="6" <?php if($actual[0]->estado == "6") {
        echo "selected";        }  ?>>Nivelacion salarial</option>
                        <option id="2" value="7" <?php if($actual[0]->estado == "7") {
        echo "selected";        }  ?>>Cambio de categoria</option>

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

<!-- MODAL COMBIO -->
<?php if($actual != null){ ?>
<form>
    <div class="modal fade" id="Modal_Cambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Cambio de Contrato</h3>
                </div>
                <div class="modal-body">
                <?php

                    //if($this->session->userdata('rol')=="Administrador"){ 
                ?>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label"></label>
                        <div class="col-md-10">
                            <input type="hidden" readonly name="id_contrato_cambio" id="id_contrato_cambio" class="form-control" value=<?= @$actual[0]->id_contrato;?>>

                            <input type="hidden" readonly name="empleado_cambio" id="empleado_cambio" class="form-control" value=<?= $empleado[0]->id_empleado;?>>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2 col-form-label">Accion a Realizar:</label>
                         <div class="col-md-10">
                        <select class="form-control" name="cambio_contrato" id="cambio_contrato">
                            <option value="0">Cambio de Cargo</option>
                            <option value="1">Cambio de Categoria</option>
                            <option value="2">Cambio de Empresa</option>
                            <option value="3">Cambio de Plaza</option>
                            <option value="4">Jubilación flexible</option>
                            <?php if($empleado[0]->genero == 1){ ?>
                            <option value="5">Maternidad</option>
                            <?php } ?>
                            <option value="6">Cesantía</option>
                        </select>
                    </div>
                    </div>

                    <div class="form-group row" id="cargo_actual" style="display: none;">
                        <label class="col-md-2 col-form-label">Cargo Actual:</label>
                        <div class="col-md-10">
                            <?php
                            $i=0;
                            foreach($cargos as $a){
                                if($actual[0]->id_cargo==$cargos[$i]->id_cargo){
                                    ?>
                                    <input readonly type="text" name="cargob" id="cargob" class="form-control" value="<?php echo($cargos[$i]->cargo);?>">

                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row" id="cargo" >
                    <label class="col-md-2 col-form-label">Cargo:</label>
                    <div class="col-md-10">
                    <select name="cambio_cargo" id="cambio_cargo" class="form-control" placeholder="Price" >
                    
                    <?php
                    $i=0;
                    
                    foreach($cargos as $a){
                        if($actual[0]->id_cargo==$cargos[$i]->id_cargo)
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
                     <div id="validacion_cambio" style="color:red"></div>
                    </div>
                    </div>

                    <div class="form-group row" id="categoria" style="display: none;">
                        <label class="col-md-2 col-form-label">Categoria:</label>
                        <div class="col-md-10">
                        <input type="hidden" name="cargo_hide" id="cargo_hide" class="form-control" value="<?php echo $actual[0]->id_cargo; ?>" readonly>
                        <input type="hidden" name="cate_hide" id="cate_hide" class="form-control" readonly value="<?php echo $actual[0]->id_categoria; ?>">
                       
                        <select name="cambio_categoria" id="cambio_categoria" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($categorias as $a){
                            if($actual[0]->id_categoria==$categorias[$i]->id_categoria){
                                ?>
                                    <option selected id="<?= ($categorias[$i]->id_categoria);?>" value="<?= ($categorias[$i]->id_categoria);?>"><?php echo($categorias[$i]->Sbase." $". $categorias[$i]->Sbase);?></option>
                                <?php
                            }else{
                                ?>
                                <option id="<?= ($categorias[$i]->id_categoria);?>" value="<?= ($categorias[$i]->id_categoria);?>"> <?php echo("prueba".$categorias[$i]->Sbase." $". $categorias[$i]->Sbase)?></option>
                                <?php
                            }
                            $i++;
                        }
                        ?>
                    </select>
                    <div id="validacion2_cambio" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row" id="empresa_actual">
                        <label class="col-md-2 col-form-label">Empresa</label>
                        <div class="col-md-10">
                        <select name="cambio_empresa" id="cambio_empresa" class="form-control" placeholder="">
                            <?php
                        $i=0;
                        foreach($empresas as $a){
                        ?>
                            <option id="<?= ($empresas[$i]->id_empresa);?>" value="<?= ($empresas[$i]->id_empresa);?>"><?php echo($empresas[$i]->nombre_empresa);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                        </select>
                        <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row" id="agencia" style="display: none;">
                        <label class="col-md-2 col-form-label">Agencias:</label>
                        <div class="col-md-10">
                        <select name="cambio_agencia" id="cambio_agencia" class="form-control" placeholder="Price">
                        
                    </select>
                    <div id="validacion3_cambio" style="color:red"></div>

                        </div>
                    </div>

                    <div class="form-group row" id="agencia_actual" style="display: none;">
                        <label class="col-md-2 col-form-label">Agencia Actual:</label>
                        <div class="col-md-10">
                            <?php
                            $i=0;
                            foreach($agencias as $a){
                                if($actual[0]->id_agencia==$agencias[$i]->id_agencia){
                                    ?>
                                    <input readonly type="text" name="agenciab" id="agenciab" class="form-control" value="<?php echo($agencias[$i]->agencia);?>">

                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row" id="plaza_actual" style="display: none;">
                        <label class="col-md-2 col-form-label">Plaza Actual:</label>
                        <div class="col-md-10">
                            <?php
                            $i=0;
                            foreach($plaza as $a){
                                if($actual[0]->id_plaza==$plaza[$i]->id_plaza){
                                    ?>
                                    <input readonly type="text" name="plazab" id="plazab" class="form-control" value="<?php echo($plaza[$i]->nombrePlaza);?>">

                                    <?php
                                }
                                $i++;
                            }
                            ?>
                        </div>
                    </div>

                    <div class="form-group row" id="plaza" style="display: none;">
                        <label class="col-md-2 col-form-label">Plazas Disponibles:</label>
                        <div class="col-md-10">
                        <input type="hidden" name="agencia_hide" id="agencia_hide" class="form-control" value="<?php echo $actual[0]->id_agencia; ?>" readonly>
                        <input type="hidden" name="estado_hide" id="estado_hide" class="form-control" readonly>
                        
                            <select name="cambio_plaza" id="cambio_plaza" class="form-control" placeholder="Price">
                            </select>
                            <div id="validacion4_cambio" style="color:red"></div>

                        </div>
                    </div>

                    <div class="form-group row" id="maternidad" style="display: none;">
                        <label class="col-md-2 col-form-label">Fecha de Inicio:</label>
                        <div class="col-md-10">
                            <input type="date" name="fMaternidad" id="fMaternidad" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            <div id="validacion5_cambio" style="color:red"></div>

                        </div>
                    </div>

                    <div class="form-group row" id="cesantia" style="display: none;">
                        <label class="col-md-2 col-form-label">Fecha de Inicio:</label>
                        <div class="col-md-10">
                            <input type="date" name="fcesantia" id="fcesantia" class="form-control" value="<?php echo date('Y-m-d') ?>">
                            <div id="validacion6_cambio" style="color:red"></div>

                        </div>
                    </div>
                    
                <?php //}else{?>
                <?php // }?>
                </div>
                <div class="modal-footer">
                    <button type="button" type="submit" id="btn_cambio" class="btn btn-primary">Guardar</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>
<!--END MODAL COMBIO-->


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
                            <input type="hidden" name="emp_code" id="emp_code" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                            <input type="hidden" name="contrato_code_de" id="contrato_code_de" class="form-control" placeholder="Product Code" value=<?= $actual[0]->id_contrato;?>>
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
                            <option id="2" value="9">Jubilación y Retiro</option>
                            

                        </select>
                        </div>
                    </div>

                    <div class="form-group row" id="despidos">
                        <label class="col-md-2 col-form-label">Tipo de despido</label>
                        <div class="col-md-10">
                        <select name="tipo_des" id="tipo_des" class="form-control" placeholder="Price">     
                            <option value="1">Sin responsabilidad de la empresa</option>
                            <option value="2">Con responsabilidad de la empresa</option>
                            <option value="3">No aprobo periodo de prueba</option>
                            

                        </select>
                        </div>
                    </div>

                    <div class="form-group row" id="renuncias">
                        <label class="col-md-2 col-form-label">Tipo de renuncia</label>
                        <div class="col-md-10">
                        <select name="tipo_ren" id="tipo_ren" class="form-control" placeholder="Price">     
                            <option id="4" value="4">Con Preaviso</option>
                            <option id="5" value="5">Abandono de puesto</option>
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


<!--MODAL RECHAZAR-->
<form>
    <div class="modal fade" id="Modal_Activar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel"><strong>Activar Contrato</strong></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <div class="modal-body">
                    ¿Seguro/a que Desea Activar Este Contrato?
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_contrato" id="code_contrato" class="form-control" readonly value="<?php echo $maternidad[0]->id_contrato ?>">
                 <input type="hidden" name="code_maternidad" id="code_maternidad" class="form-control" readonly value="<?php echo $maternidad[0]->id_maternidad ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_activar" class="btn btn-primary">Activar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL RECHAZAR-->

<form>
    <div class="modal fade" id="Modal_act" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel"><strong>Activar Contrato en Cesantía</strong></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <div class="modal-body">
                    <b>¿Seguro/a que Desea Activar Este Contrato en Cesantía?</b><br><br>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="col-form-label">Fecha de Finalizacion:</label>
                        </div>
                        <div class="col-md-5">
                            <input type="date" name="fecha_finc" id="fecha_finc" class="form-control">
                        </div>
                    </div>
                    <div id="validacion_cesantia" style="color:red"></div>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="id_cesantia" id="id_cesantia" class="form-control" readonly>
                <input type="hidden" name="id_control" id="id_control" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_act" class="btn btn-primary">Activar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="modal fade" id="Modal_activar_empleado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">Activar empleado</h4>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <strong>¿Seguro/a que desea activar a este empleado?</strong><br><br>
            </div>
                        
            <div class="modal-footer">
                <input type="hidden" name="id_contrato_activar" id="id_contrato_activar" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="btn_rechazar"  class="btn btn-success" onclick="activar_contratos()">Aceptar</a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
i = 0;
    function marcar_dias(id_contrato){
        console.log(id_contrato)
        Swal.fire({
          title: 'Confirmación',
          text: '¿Estás seguro de realizar esta acción?',
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/marcar_dias')?>",
                dataType : "JSON",
                data : { id_contrato:id_contrato},
                success: function(data){
                    if(data == null){
                        location.reload();
                    }else{
                        alert("Error al marcar los dias");
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            Swal.fire('¡Confirmado!', 'La acción ha sido confirmada.', 'success');
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            // Acción a realizar si se cancela
            Swal.fire('Cancelado', 'La acción ha sido cancelada.', 'error');
          }
        });
    }   
    $(document).ready(function(){
        /*$('#contrato_tipo').change(function() {
        
        if ($('#contrato_tipo').val() == 6)
        {
            $(".nivelacion").css("display","block");
            $(".com").css("display","none");
        };
        
        if ($('#contrato_tipo').val() != 6)
        {
            $(".nivelacion").css("display","none");
            $(".com").css("display","block");
        };
        
    });*/

        $('#btn_Delete').on('click',function(){
            this.disabled=true;
            var employee_code = $('#emp_code').val();
            var contrato_fin = $('#contrato_fin').val();
            var contrato_razon = $('#contrato_razon').val();
            var empleado = $('#empleado_code_de').val();
            var id_contrato = $('#contrato_code_de').val();
            var tipo = $('#contrato_tipo_de').val();
            var tipo_des = $('#tipo_des').val();
            var tipo_ren = $('#tipo_ren').val();

            if(tipo == 0){
                tipo_ren = null;
            }else if(tipo == 4){
                tipo_des = null;
            }else if(tipo == 9){
                tipo_ren = null;
                tipo_des = null;
            }

            //var area_name = $('#area_name').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/delete')?>",
                dataType : "JSON",
                data : { employee_code:employee_code, contrato_fin:contrato_fin, contrato_razon:contrato_razon, empleado:empleado, tipo:tipo, id_contrato:id_contrato,tipo_des:tipo_des,tipo_ren:tipo_ren},
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
            var employee_code = $('#emp_code').val();
            var contrato_code = $('#contrato_code').val();
            var contrato_cargo = $('#contrato_cargo').val();
            var contrato_agencia = $('#contrato_agencia').val();
            var contrato_inicio = $('#contrato_inicio').val();
            var contrato_tipo = $('#contrato_tipo').val();
            var contrato_plaza = $('#contrato_plaza').val();
            var contrato_categoria = $('#contrato_categoria').val();
            var contrato_empresa = $('#contrato_empresa').val();
            var contrato_forma = $('#contrato_forma').val();
            var descripcion_temporal = $('#descripcion_temporal').val();
            var final_temporal = $('#final_temporal').val();
            this.disabled=true;
           // var contrato_tipo = $('#contrato_tipo').val();
            //var area_name = $('#area_name').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/save')?>",
                dataType : "JSON",
                data : { contrato_code:contrato_code, employee_code:employee_code, contrato_cargo:contrato_cargo, contrato_agencia:contrato_agencia, contrato_inicio:contrato_inicio, contrato_tipo:contrato_tipo, contrato_plaza:contrato_plaza,contrato_categoria:contrato_categoria,contrato_forma:contrato_forma,descripcion_temporal:descripcion_temporal,contrato_empresa:contrato_empresa,final_temporal:final_temporal},
                success: function(data){
                    if(data == null){
                        //$('[name="area_name"]').val("");
                        //$('#Modal_Add').modal('hide');

                        location.reload();
                        
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "No hay categorias disponibles, Por favor crear una nueva en este cargo";
                            }
                            if(data[i] == 2){
                                 document.getElementById('validacion2').innerHTML += "No hay plazas disponibles, Por favor crear una nueva en esta agencia";
                            }
                            if(data[i] == 3){
                                 document.getElementById('validacion3').innerHTML += "Por favor ingrese la fecha de inicio";
                            }
                            if(data[i] == 4){
                                 document.getElementById('validacion4').innerHTML += "Debe de ingresar una descripcion de este tipo de contrato";
                            }
                            if(data[i] == 5){
                                 document.getElementById('validacion5').innerHTML += "Debe de ingresar una fecha de finalizacion para este tipo de contrato";
                            }
                             if(data[i] == 6){
                                 document.getElementById('validacion6').innerHTML += "Seleccione un tipo de interinato";
                            }
                        }
                    }

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });


        agencia();
        $( "#contrato_empresa" ).change(function() {
              agencia();
        });

        function agencia(){
             var contrato_empresa = $('#contrato_empresa').children(":selected").attr("id");

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarAgencia')?>",
                dataType : "JSON",
                data : {contrato_empresa:contrato_empresa},
                success: function(data){
                    $("#contrato_agencia").empty();
                    $.each(data.agencia,function(key, registro) {

                         $("#contrato_agencia").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                    });
                   load();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        //cambio de las plazas
        $( "#contrato_agencia" ).change(function() {
              load();
        });

        function load(){
             var contrato_plaza = $('#contrato_agencia').val();
             //alert(contrato_plaza);
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarPlaza')?>",
                dataType : "JSON",
                data : {contrato_plaza:contrato_plaza},
                success: function(data){
                    $("#contrato_plaza").empty();
                    $.each(data.plaza,function(key, registro) {

                         $("#contrato_plaza").append('<option value='+registro.id_plaza+'>'+registro.nombrePlaza+'</option>');
                    });

                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        //Cmabio de Categoria
        categoria();
        $("#contrato_cargo").change(function(){
            categoria();
        });

        function categoria(){
             var contrato_cargo = $('#contrato_cargo').children(":selected").attr("id");

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarCategoria')?>",
                dataType : "JSON",
                data : {contrato_cargo:contrato_cargo},
                success: function(data){
                    console.log(data)
                    $("#contrato_categoria").empty();
                    $.each(data.categoria,function(key, registro) {

                         $("#contrato_categoria").append('<option value='+registro.id_categoria+'>'+registro.categoria+'</option>');
                    });
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        forma();
        $("#contrato_forma").change(function(){
            forma();
        });

                $("input[name=tipo_inter]").change(function () {   
            $('[name="descripcion_temporal"]').val($(this).val());
            });

        function forma(){
            var cambio = $('#contrato_forma').val();

            if(cambio == 1 ){
                $('#forma').hide();
                $('#forma1').hide();
                $('#tipo_interinato').hide();
                $('[name="descripcion_temporal"]').val("");
                $('[name="final_temporal"]').val("");
                $('[name="tipo_interinato"]').val("");
            }else if(cambio == 2 ){
                $('#forma').hide();
                $('#forma1').show();
                $('#tipo_interinato').hide();
                $('[name="descripcion_temporal"]').val("");
                $('[name="tipo_interinato"]').val("");
            }else if(cambio == 3 ){//interinato
                $('#forma').hide();
                $('#forma1').show();
                $('#tipo_interinato').show();
                //$('[name="descripcion_temporal"]').val("");
                $('[name="final_temporal"]').val("");
            }

        };
        //Aqui se cambiara el contrato
        accion();
        $("#cambio_contrato").change(function(){
            accion();
        });
        
        function accion(){
            var cambio = $('#cambio_contrato').val();

            //CAMBIO DE CARGO
            if(cambio == 0){
                $('#cargo').show();
                $('#categoria').show();
                $('#cargo_actual').show();
                $('#agencia').hide();
                $('#plaza').hide();
                $('#agencia_actual').hide();
                $('#plaza_actual').hide();
                $('[name="estado_hide"]').val(3);
                $('#empresa_actual').hide();
                $('#maternidad').hide();
                $('#cesantia').hide();
                cambioCategoria();

                //CAMBIO DE CATEGORIA
            }else if(cambio == 1){
                $('#cargo').hide();
                $('#categoria').show();
                $('#cargo_actual').hide();
                $('#agencia').hide();
                $('#plaza').hide();
                $('#agencia_actual').hide();
                $('#plaza_actual').hide();
                $('[name="estado_hide"]').val(4);
                $('#empresa_actual').hide();
                $('#maternidad').hide();
                $('#cesantia').hide();
                cambioCategoria();

                //CAMBIO DE EMPRESA
            }else if(cambio == 2){
                $('#cargo').hide();
                $('#categoria').hide();
                $('#cargo_actual').hide();
                $('#agencia').show();
                $('#plaza').show();
                $('#agencia_actual').show();
                $('#plaza_actual').show();
                $('#empresa_actual').show();
                $('[name="estado_hide"]').val(0);
                $('#maternidad').hide();
                $('#cesantia').hide();
                cambio_agencia();
                cambioPlaza();

                //CAMBIO DE PLAZA
            }else if(cambio == 3){
                $('#cargo').hide();
                $('#categoria').hide();
                $('#cargo_actual').hide();
                $('#agencia').hide();
                $('#plaza').show();
                $('#agencia_actual').hide();
                $('#plaza_actual').show();
                $('[name="estado_hide"]').val(1);
                $('#empresa_actual').hide();
                $('#maternidad').hide();
                $('#cesantia').hide();
                cambioPlaza();

                //JUBILACION FLEXIBLE
            }else if(cambio == 4){
                $('#cargo').hide();
                $('#categoria').hide();
                $('#cargo_actual').hide();
                $('#agencia').hide();
                $('#plaza').hide();
                $('#agencia_actual').hide();
                $('#plaza_actual').hide();
                $('[name="estado_hide"]').val(5);
                $('#empresa_actual').hide();
                $('#maternidad').hide();
                $('#cesantia').hide();

                //MATERNIDAD
            }else if(cambio == 5){
                $('#cargo').hide();
                $('#categoria').hide();
                $('#cargo_actual').hide();
                $('#agencia').hide();
                $('#plaza').hide();
                $('#agencia_actual').hide();
                $('#plaza_actual').hide();
                $('[name="estado_hide"]').val(6);
                $('#empresa_actual').hide();
                $('#maternidad').show();
                $('#cesantia').hide();

                //CESANTIA
            }else if(cambio == 6){
                $('#cargo').hide();
                $('#categoria').hide();
                $('#cargo_actual').hide();
                $('#agencia').hide();
                $('#plaza').hide();
                $('#agencia_actual').hide();
                $('#plaza_actual').hide();
                $('[name="estado_hide"]').val(6);
                $('#empresa_actual').hide();
                $('#maternidad').hide();
                $('#cesantia').show();
            }
        };

        function cambio_agencia(){
             var contrato_empresa = $('#cambio_empresa').children(":selected").attr("id");
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarAgencia')?>",
                dataType : "JSON",
                data : {contrato_empresa:contrato_empresa},
                success: function(data){
                    $("#cambio_agencia").empty();
                    $.each(data.agencia,function(key, registro) {

                         $("#cambio_agencia").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                    });
                   load();
                   cambioPlaza();

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        $( "#cambio_empresa" ).change(function() {
              cambio_agencia();
        });

        $("#cambio_agencia").change(function(){
            cambioPlaza();
        });

        function cambioPlaza(){
            var estado_hide = $('#estado_hide').val();

            if(estado_hide == 0){
                var contrato_plaza = $('#cambio_agencia').val();
                //alert(contrato_plaza);

            }else if(estado_hide == 1){
                var contrato_plaza = $('#agencia_hide').val();

            }

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarPlaza')?>",
                dataType : "JSON",
                data : {contrato_plaza:contrato_plaza},
                success: function(data){
                    $("#cambio_plaza").empty();
                    $.each(data.plaza,function(key, registro) {

                         $("#cambio_plaza").append('<option value='+registro.id_plaza+'>'+registro.nombrePlaza+'</option>');
                    });
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        $("#cambio_cargo").change(function(){
            cambioCategoria();
        });

        function cambioCategoria(){
            var estado_hide = $('#estado_hide').val();
            var categoria = $('#cate_hide').val();

            if(estado_hide == 3){
                var contrato_cargo = $('#cambio_cargo').children(":selected").attr("id");

            }else if(estado_hide == 4){
                var contrato_cargo = $('#cargo_hide').val();

            }

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/cambiarCategoria')?>",
                dataType : "JSON",
                data : {contrato_cargo:contrato_cargo},
                success: function(data){
                    $("#cambio_categoria").empty();
                    $.each(data.categoria,function(key, registro) {
                        console.log(data.categoria)
                         $("#cambio_categoria").append('<option value='+registro.id_categoria+'>'+registro.categoria+" $ "+registro.Sbase+'</option>');
                    });
                   $("#cambio_categoria option[value='"+categoria+"']").attr("selected",true);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };

        $('#btn_cambio').on('click',function(){
            var employee_code = $('#empleado_cambio').val();
            var id_contrato = $('#id_contrato_cambio').val();
            var cambio = $('#cambio_contrato').val();
            var cambio_cargo = $('#cambio_cargo').children(":selected").attr("id");
            var cambio_categoria = $('#cambio_categoria').val();
            var cambio_empresa = $('#cambio_empresa').children(":selected").attr("id");
            var cambio_agencia = $('#cambio_agencia').children(":selected").attr("id");
            var contrato_plaza = $('#cambio_plaza').val();
            var fMaternidad = $('#fMaternidad').val();
            var fcesantia = $('#fcesantia').val();
            var user = $('#user').val();

            if(confirm("¿Desea cambiar este contrato?")){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('contratacion/cambioContrato')?>",
                    dataType : "JSON",
                    data : {employee_code:employee_code,id_contrato:id_contrato,cambio:cambio,cambio_cargo:cambio_cargo,cambio_categoria:cambio_categoria,cambio_agencia:cambio_agencia,contrato_plaza:contrato_plaza,cambio_empresa:cambio_empresa,fMaternidad:fMaternidad,fcesantia:fcesantia,user:user},
                    success: function(data){
                        console.log(data);
                        if(data == null){
                            alert('El Cambio se realizo con exito');
                            location.reload();
                            this.disabled=false;
                        }else{
                           document.getElementById('validacion_cambio').innerHTML = '';
                           document.getElementById('validacion2_cambio').innerHTML = '';
                           document.getElementById('validacion3_cambio').innerHTML = '';
                           document.getElementById('validacion4_cambio').innerHTML = '';
                           document.getElementById('validacion5_cambio').innerHTML = '';
                           document.getElementById('validacion6_cambio').innerHTML = '';

                            for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion_cambio').innerHTML += "No hay Cargos disponibles";
                                }
                                if(data[i] == 2){
                                    document.getElementById('validacion2_cambio').innerHTML += "No hay Categorias disponibles en este Cargo";
                                }
                                if(data[i] == 3){
                                    document.getElementById('validacion2_cambio').innerHTML += "No hay Categorias disponibles";
                                }
                                if(data[i] == 4){
                                    document.getElementById('validacion3_cambio').innerHTML += "Ingrese la agencia del Cambio";
                                }
                                if(data[i] == 5){
                                    document.getElementById('validacion4_cambio').innerHTML += "No hay Plazas disponibles en esta Agencia";
                                }
                                if(data[i] == 6){
                                    document.getElementById('validacion4_cambio').innerHTML += "No hay Plazas disponibles";
                                }
                                if(data[i] == 7){
                                    document.getElementById('validacion5_cambio').innerHTML += "Debe de Ingresar la Fecha de Inicio de la Maternidad";
                                }
                                if(data[i] == 8){
                                    document.getElementById('validacion6_cambio').innerHTML += "Debe de Ingresar la Fecha de Inicio de la Cesantía";
                                }
                            } 
                        }
                        
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });
                return false;
            }

        });

        $('#btn_activar').on('click',function(){
            var code_contrato = $('#code_contrato').val();
            var code_maternidad = $('#code_maternidad').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/actContrato')?>",
                dataType : "JSON",
                data : {code_contrato:code_contrato,code_maternidad:code_maternidad},
                success: function(data){
                    
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

        $('.row').on('click','.item_activar',function(){ 
        //$('.item_activar').click(function(){
            var code   = $(this).data('codigo');
            var control   = $(this).data('control');
            $('#Modal_act').modal('show');
            $('[name="id_cesantia"]').val(code);
            $('[name="id_control"]').val(control);
        });

        //Metodo para eliminar 
        $('#btn_act').on('click',function(){
            var code = $('#id_cesantia').val();
            var control = $('#id_control').val();
            var fecha_finc = $('#fecha_finc').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('contratacion/activarCesantia')?>",
                dataType : "JSON",
                data : {code:code,control:control,fecha_finc:fecha_finc},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion_cesantia').innerHTML = '';
                        $('[name="id_cesantia"]').val("");
                        $('#Modal_act').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{
                        document.getElementById('validacion_cesantia').innerHTML = '';
                        for (i = 0; i <= data.length-1; i++){
                            document.getElementById('validacion_cesantia').innerHTML += data[i];
                        }
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo eliminar

        despido();
        $("#contrato_tipo_de").change(function(){
            despido();
        });

        function despido(){
            var cambio = $('#contrato_tipo_de').val();

            if(cambio == 0){
                $('#despidos').show();
                $('#renuncias').hide();

            }else if(cambio == 4){
                $('#despidos').hide();
                $('#renuncias').show();
            }else if(cambio == 9){
                $('#despidos').hide();
                $('#renuncias').hide();
            }
        };

    });//Fin Jquery

    function activar_empleado(id_contrato){
        $('[name="id_contrato_activar"]').val(id_contrato);
        $('#Modal_activar_empleado').modal('show');
    }

    function activar_contratos(){
        this.disabled=false;
        id_contrato = $('#id_contrato_activar').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('contratacion/activar_contratos')?>",
            dataType : "JSON",
            data : {id_contrato:id_contrato},
            success: function(data){
                Swal.fire(
                    'El contrato se activo con exito!',
                    '',
                    'success'
                ).then(function () {
                    location.reload();
                })                     
            },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }
</script>
</body>
</html>