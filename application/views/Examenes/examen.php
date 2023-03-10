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
            <div class="text-center well text-white blue no-print">
                <h2>Examenes </h2>
                <input type="button" onclick="window.print();" value="Print Invoice" />
            </div>
            <div class="row">
                <div class="col-sm-12 col-xs-12 print-col-md-10">
                    <div class="well col-sm-12 col-xs-12 print-col-md-10">   
                        <nav class="float-right">                   
                        </nav>
                        <form action="<?= base_url();?>index.php/Empleado/update/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                            <div class="row">
                                <div class="col-sm-3 text-center ">
                                    <img src="../../../../Produccion/PHP/user_images/<?= strtolower(@$fProspectos[0]->usuarioP);?>.png" class="img-circle" width="150" heigth="150" class="foto">
                                    <div class="row">
                                    <div class="col-sm-2 text-center"></div>
                                        <div class="col-sm-2 no-print">
                                        <?php 
                                            if(empty($examenes)){//Si NO esta vacio el arreglo de datos de examenes, se muestra todo
                                        ?>
                                        <a  href="" class="btn btn-success" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_read"><span class="fa fa-user"></span> Agregar Resultados</a>
                                        <?php 
                                            }else{
                                        ?>
                                        <?php  if($editar){ ?>
                                       
                                        <a href="" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Edit" ><span class="fa fa-cog"></span> Modificar Resultados</a>
                                    <?php } ?>
                                        <?php 
                                            }
                                        ?>
                                        </div>
                                    </div>
                                </div>    
                                <div class="col-sm-9">
                                    <div clas="form-row">
                                        <input type="hidden" readonly name="empleado_id" id="empleado_id" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->id_empleado;?>">
                                            <div class="form-group col-md-6 col-sm-612 col-xs-12">
                                                <label for="inputEmail4">Nombres</label>
                                                <input type="text" disabled name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin" value="<?= $empleado[0]->nombre." ". $empleado[0]->apellido;?>">
                                            </div>
                                            <div class="form-group col-md-6 col-sm-6 col-xs-6 no-print">
                                            <label for="inputCity">Correo Empresarial</label>
                                                <input type="text" disabled name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com" value="<?= $empleado[0]->correo_empresa?>">
                                            </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-4 col-sm-4 col-xs-4">
                                            <label for="inputState">Telefono Empresarial</label>
                                            <input type="text" disabled name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####" value="<?= $empleado[0]->tel_empresa;?>">
                                        </div>
                                        <div class="form-group col-md-4 col-sm-4 col-xs-4 ">
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
                            <h3 class="text-center h3">Examenes de ingreso</h3>
                            <div class="panel-group col-sm-12">
                            <?php 
                                if(!empty($examenes)){//Si NO esta vacio el arreglo de datos de examenes, se muestra todo
                            ?>
                                <div class="panel panel-primary ">
                                    <div class="panel-heading print-blue"><label class="print-text-white">Perfil de Personalidad</label></div>
                                    
                                    <div class="panel-body">
                                        
                                        <div class="col-sm-12">
                                            <div class="col-sm-4 col-md-4 col-xs-4 no-print">
                                                <div class="caption text-center">
                                                    <h4>DISC</h4>
                                                    <p><b>Resultado:</b> <?=$examenes[0]->DISC;?></p>
                                                </div>
                                                <div class="thumbnail ">
                                                    <canvas id="chart" width="250" height="300"></canvas>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-md-4 col-xs-4 only-print">
                                                <div class="caption text-center">
                                                    <h4>DISC</h4>
                                                    <p><b>Resultado:</b> <?=$examenes[0]->DISC;?>
                                                    <br>D:<?= @$examenes[0]->nota_disc1;?> - I:<?= @$examenes[0]->nota_disc2;?> - S:<?= @$examenes[0]->nota_disc3;?> - C:<?= @$examenes[0]->nota_disc4;?></p>
                                                </div>
                                                <div class="thumbnail ">
                                                    <?php
                                                    if($examenes[0]->DISC=="D/I" or $examenes[0]->DISC=="I/D"){
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\DI.png"" alt="">
                                                    <?php
                                                    }elseif($examenes[0]->DISC=="D/S" or $examenes[0]->DISC=="S/D"){
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\DS.png"" alt="">
                                                    <?php
                                                    }elseif ($examenes[0]->DISC=="I/S" or $examenes[0]->DISC=="S/I") {
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\IS.png"" alt="">
                                                    <?php # code...
                                                    }elseif ($examenes[0]->DISC=="I/C" or $examenes[0]->DISC=="C/I") {
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\IC.png"" alt="">
                                                    <?php    # code...
                                                    }elseif ($examenes[0]->DISC=="S/C" or $examenes[0]->DISC=="C/S") {
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\CS.png"" alt="">
                                                    <?php    # code...
                                                    }elseif ($examenes[0]->DISC=="C/D" or $examenes[0]->DISC=="D/C") {
                                                    ?>
                                                        <img src="<?= base_url();?>\assets\images\DC.png"" alt="">
                                                    <?php   # code...
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="caption text-center">
                                                    <h4>Patron</h4>
                                                </div>
                                                <div class="alert alert-success well well-print pointer" role="alert"  href="javascript:void(0);" id="mostrar_vista" data-toggle="modal" data-target="#Modal_View2"> <a class="alert-success"><label class="print-text-white"><strong><?=$examenes[0]->patron1;?></strong></label></a></div>
                                                <div class="alert alert-info well well-print pointer" role="alert"  href="javascript:void(0);" id="mostrar_vista" data-toggle="modal" data-target="#Modal_View"><a class="alert-info"> <label class="print-text-white"><strong><?=$examenes[0]->patron2;?></strong></label></a> </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="caption text-center">
                                                    <h4>Tetramap</h4>
                                                    
                                                </div>
                                                <div class="row">
                                                    <?php
                                                    $MayorMenor = array($examenes[0]->nota_tetramap1, $examenes[0]->nota_tetramap2, $examenes[0]->nota_tetramap3, $examenes[0]->nota_tetramap4);
                                                    rsort($MayorMenor);
                                                    ?>
                                                    
                                                    <div class="col-xs-6 col-md-6 col-lg-6 col-sm-6">
                                                    <?php
                                                            switch ($MayorMenor) {
                                                                case $MayorMenor[0]==$examenes[0]->nota_tetramap1:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Tierra</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\earth.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;
                                                                case $MayorMenor[0]==$examenes[0]->nota_tetramap2:
                                                                    ?>
                                                                <div class="caption text-center">
                                                                    <h3>Aire</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\air.png"" alt="">
                                                                </a>
                                                                    <?php
                                                                    break;
                                                                case $MayorMenor[0]==$examenes[0]->nota_tetramap3:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Agua</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\water.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;
                                                                case $MayorMenor[0]==$examenes[0]->nota_tetramap4:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Fuego</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\fire.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;

                                                                default:
                                                                ?>
                                                                
                                                                <?php
                                                                    break;
                                                            }
                                                    ?>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6 col-lg-6 col-sm-6">
                                                    <?php
                                                            switch ($MayorMenor) {
                                                                case $MayorMenor[1]==$examenes[0]->nota_tetramap1:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Tierra</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\earth.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;
                                                                case $MayorMenor[1]==$examenes[0]->nota_tetramap2:
                                                                    ?>
                                                                <div class="caption text-center">
                                                                    <h3>Aire</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\air.png"" alt="">
                                                                </a>
                                                                    <?php
                                                                    break;
                                                                case $MayorMenor[1]==$examenes[0]->nota_tetramap3:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Agua</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\water.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;
                                                                case $MayorMenor[1]==$examenes[0]->nota_tetramap4:
                                                                ?>
                                                                <div class="caption text-center">
                                                                    <h3>Fuego</h3>
                                                                </div>
                                                                <a href="#" class="thumbnail">
                                                                <img src="<?= base_url();?>\assets\images\fire.png"" alt="">
                                                                </a>
                                                                <?php
                                                                    break;

                                                                default:
                                                                ?>
                                                                
                                                                <?php
                                                                    break;
                                                            }
                                                    ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="progress" >
                                                        <?php
                                                        @$total = $examenes[0]->nota_tetramap1+ $examenes[0]->nota_tetramap2+$examenes[0]->nota_tetramap3+$examenes[0]->nota_tetramap4;
                                                        @$tierra = ($examenes[0]->nota_tetramap1 * 100)/$total;
                                                        @$aire =($examenes[0]->nota_tetramap2 * 100)/$total;
                                                        @$agua = ($examenes[0]->nota_tetramap3 * 100)/$total;
                                                        @$fuego = ($examenes[0]->nota_tetramap4 *100)/$total;
                                                        
                                                        ?>
                                                        <div class="progress-bar progress-bar-warning" style="width: <?=$tierra;?>%">
                                                            <b><?=$examenes[0]->nota_tetramap1;?></b><span class="sr-only">15% Complete (success)</span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-success progress-bar-striped" style="width: <?=$aire;?>%">
                                                            <b><?=$examenes[0]->nota_tetramap2;?></b><span class="sr-only">20% Complete (warning)</span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-primary" style="width: <?=$agua;?>%">
                                                            <b><?=$examenes[0]->nota_tetramap3;?></b><span class="sr-only">10% Complete (danger)</span>
                                                        </div>
                                                        <div class="progress-bar progress-bar-danger" style="width: <?=$fuego;?>%">
                                                            <b><?=$examenes[0]->nota_tetramap4;?></b><span class="sr-only">10% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <img src="<?= base_url();?>/assets/images/watermark.png" alt="Marca de agua" class="only-print logo">
                                
                                <div class="panel panel-primary ">
                                    <div class="panel-heading print-blue print-text-white"><label  class="print-text-white">Calificaciones tecnicas</label></div>
                                    <div class="panel-body">
                                        <div class="col-sm-12">
                                            <div class="row text-center">
                                                <div class="col-sm-4 text-center">
                                                    <div class="alert  well" role="alert"> 
                                                        <strong>Ortografia</strong>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-warning" role="rogressbar" aria-valuenow="<?= @$examenes[0]->nota_disc1;?>" aria-valuemin="0" aria-valuemax="10" style="width: <?= @$examenes[0]->ortografia;?>0%;">
                                                                <label class="text-center" for=""><?= @$examenes[0]->ortografia;?></label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="alert well" role="alert"> 
                                                        <strong>EXCEL</strong>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?= @$examenes[0]->excel;?>" aria-valuemin="0" aria-valuemax="10" style="width: <?= @$examenes[0]->excel;?>0%;">
                                                                <label class="text-center" for=""><?= @$examenes[0]->excel;?></label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="alert well" role="alert"> <strong>Ejercicios</strong> <p><?= @$examenes[0]->ejercicios;?></p></div>
                                                </div>
                                            </div>
                                            <div class="row text-center">
                                                <div class="col-sm-4"> 
                                                    <div class="alert well" role="alert"> 
                                                        <strong>Test Alter</strong>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?= @$examenes[0]->test_alter;?>" aria-valuemin="0" aria-valuemax="10" style="width: <?= @$examenes[0]->test_alter;?>0%;">
                                                                <label class="text-center" for=""><?= @$examenes[0]->test_alter;?></label>
                                                            </div>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="alert well" role="alert"> 
                                                        <strong>Dictado</strong>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="<?=$examenes[0]->dictado;?>0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$examenes[0]->dictado;?>0%;">
                                                            <label class="text-center text-white" for=""><?=$examenes[0]->dictado;?></label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-sm-4">                                            
                                                    <div class="alert well" role="alert"> 
                                                        <strong>WORD</strong>
                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="<?=$examenes[0]->word;?>0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$examenes[0]->word;?>0%;">
                                                            <label class="text-center" for=""><?=$examenes[0]->word;?></label>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-info ">
                                    <div class="panel-heading print-blue print-text-white"><label  class="print-text-white">Entrevistador: </label><?=$examenes[0]->entrevistador;?></div>
                                    <div class="panel-body">
                                        <div class="col-sm-8">
                                            <label for="">Observaciones:</label>
                                            <p><?=$examenes[0]->observacion;?></p>
                                        </div>
                                        <div class="col-sm-4">
                                        <label>Nota de entrevista:</label>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="<?=$examenes[0]->nota_entrevista;?>0" aria-valuemin="0" aria-valuemax="100" style="width: <?=$examenes[0]->nota_entrevista;?>0%;">
                                            <?=$examenes[0]->nota_entrevista;?>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        AlterCredit 
                                        
                                    </div>
                                </div>
                                
                            <?php 
                                }else{//En caso de estar vacio
                            ?>
                                <div class="panel panel-danger ">
                                    <div class="panel-heading"><label>No existen datos</label></div>
                                    <div class="panel-body">
                                        <div class="col-sm-8">
                                            <p>No se han ingresado datos de examenes internos</p>
                                        </div>
                                    </div>
                                    <div class="panel-footer">
                                        
                                    </div>
                                </div>
                            <?php 
                                }//Fin del IF si existe o no datos
                            ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    if(empty($examenes)){//Si NO esta vacio el arreglo de datos de examenes, se muestra todo
?>
<!-- MODAL ADD -->
<form >
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Datos Examen</h3>
                </div>
                <div class="modal-body">
                    <div class="panel panel-primary ">
                        <div class="panel-heading"><label>Perfil de Personalidad</label></div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="col-md-4">
                                    <input type="hidden" name="emp_code" id="emp_code" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                                    <input type="hidden" name="contrato_code" id="contrato_code" class="form-control" placeholder="Product Code" value=<?= @$contratos[0]->id_contrato;?>>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">DISC:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_disc" id="empleado_disc" class="form-control" placeholder="Price">
                                                <option selected id="" value="D/I">D/I</option>
                                                <option id="" value="D/S">D/S</option>
                                                <option id="" value="D/C">D/C</option>
                                                <option id="" value="I/D">I/D</option>
                                                <option id="" value="I/C">I/C</option>
                                                <option id="" value="I/S">I/S</option>
                                                <option id="" value="S/D">S/D</option>
                                                <option id="" value="S/I">S/I</option>
                                                <option id="" value="S/C">S/C</option>
                                                <option id="" value="C/D">C/D</option>
                                                <option id="" value="C/I">C/I</option>
                                                <option id="" value="C/S">C/S</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">Notas DISC:</label>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">D:</label>
                                        <input type="text"  class="form-control"  name="empleado_d" id="empleado_d">
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">I:</label>
                                        <input type="text"  class="form-control" name="empleado_i" id="empleado_i">
                                        </div>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">S:</label></br>
                                        <input type="text"  class="form-control" name="empleado_s" id="empleado_s">
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">C:</label></br>
                                        <input type="text"  class="form-control" name="empleado_c" id="empleado_c">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <label class="col-md-12 col-form-label text-center">PATRON</label>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">PRINCIPAL:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_patron1" id="empleado_patron1" class="form-control">
                                                <option selected id="" value="Agente">Agente</option>
                                                <option id="" value="Alentador">Alentador</option>
                                                <option id="" value="Consejero">Consejero</option>
                                                <option id="" value="Creativo">Creativo</option>
                                                <option id="" value="Especialista">Especialista</option>
                                                <option id="" value="Evaluador">Evaluador</option>
                                                <option id="" value="Persuasivo">Persuasivo</option>
                                                <option id="" value="Objetivo">Objetivo</option>
                                                <option id="" value="Orientado a Resultados">Orientado a Resultados</option>
                                                <option id="" value="Profesional">Profesional</option>
                                                <option id="" value="Perfeccionista">Perfeccionista</option>
                                                <option id="" value="Investigador">Investigador</option>
                                                <option id="" value="Promotor">Promotor</option>
                                                <option id="" value="Realizador">Realizador</option>
                                                <option id="" value="Resolutivo">Resolutivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">SECUNDARIO:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_patron2" id="empleado_patron2" class="form-control">
                                            <option selected id="" value="Objetivo">Objetivo</option>
                                            <option selected id="" value="Agente">Agente</option>
                                                <option id="" value="Alentador">Alentador</option>
                                                <option id="" value="Consejero">Consejero</option>
                                                <option id="" value="Creativo">Creativo</option>
                                                <option id="" value="Especialista">Especialista</option>
                                                <option id="" value="Evaluador">Evaluador</option>
                                                <option id="" value="Persuasivo">Persuasivo</option>
                                                <option id="" value="Objetivo">Objetivo</option>
                                                <option id="" value="Orientado a Resultados">Orientado a Resultados</option>
                                                <option id="" value="Profesional">Profesional</option>
                                                <option id="" value="Perfeccionista">Perfeccionista</option>
                                                <option id="" value="Investigador">Investigador</option>
                                                <option id="" value="Promotor">Promotor</option>
                                                <option id="" value="Realizador">Realizador</option>
                                                <option id="" value="Resolutivo">Resolutivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <label class="col-md-12 col-form-label text-center">TETRAMAP:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <select name="empleado_tetramap1" id="empleado_tetramap1" class="form-control">
                                                <option selected id="" value="Tierra">Tierra</option>
                                                <option  id="" value="Aire">Aire</option>
                                                <option  id="" value="Agua">Agua</option>
                                                <option  id="" value="Fuego">Fuego</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <select name="empleado_tetramap2" id="empleado_tetramap2" class="form-control">
                                                <option selected id="" value="Tierra">Tierra</option>
                                                <option  id="" value="Aire">Aire</option>
                                                <option  id="" value="Agua">Agua</option>
                                                <option  id="" value="Fuego">Fuego</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">Notas:</label>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">TIERRA:</label>
                                        <input type="NUMBER"  class="form-control" name="empleado_ti" id="empleado_ti">
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">AIRE:</label>
                                        <input type="number"  class="form-control" name="empleado_ai" id="empleado_ai">
                                        </div>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">AGUA:</label></br>
                                        <input type="number"  class="form-control" name="empleado_au" id="empleado_au">
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">FUEGO:</label></br>
                                        <input type="number"  class="form-control" name="empleado_fu" id="empleado_fu">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary ">
                        <div class="panel-heading"><label>Examenes Tecnicos</label></div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Ortografia</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empelado_ortografia" id="empleado_ortografia">
                                </div>
                                <div class="col-md-4">
                                    <label>Excel</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_excel" id="empleado_excel">
                                </div>
                                <div class="col-md-4">
                                    <label>Ejercicios</label>
                                    <select name="empleado_ejercicio" id="empleado_ejercicio" class="form-control">
                                        <option selected id="" value="9P, Termino Medio">9P, Termino Medio</option>
                                        <option  id="" value="10P, Termino Bien">10P, Termino Bien</option>
                                        <option  id="" value="11P, Termino Excelente">11P, Termino Excelente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Test Alter</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_alter" id="empleado_alter">
                                </div>
                                <div class="col-md-4">
                                    <label>Dictado</label>
                                    <input  class="form-control" type="number" min=0 max=10 name="empleado_dictado" id="empleado_dictado">
                                </div>
                                <div class="col-md-4">
                                    <label>WORD</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_word" id="empleado_word">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info ">
                        <div class="panel-heading"><label>Datos Generales</label></div>
                        <div class="panel-body">
                            <div class="col-md-8">
                                <label>Entrevistador:</label>   
                                <input class="form-control" type="text" name="empleado_entrevistador" id="empleado_entrevistador">
                            </div>
                            <div class="col-md-4">
                                <label>Nota entrevista</label>
                                <input class="form-control" type="number" min=0 max=10 name="empleado_nota" id="empleado_nota">
                            </div>
                            <div class="col-md-12">
                                <label for="comment">Observaciones:</label>
                                <textarea class="form-control" rows="5" name="empleado_observacion" id="empleado_observacion"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" id="btn_save" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->
<?php 
    }else{
?>

<!-- MODAL EDIT -->
<form action="<?= base_url();?>index.php/Contratacion/modificar_examen" enctype="multipart/form-data" method="post" accept-charset="utf-8">
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Modificar Registro Actual</h3>
                </div>
                <div class="modal-body">
                <div class="panel panel-primary ">
                        <div class="panel-heading"><label>Perfil de Personalidad</label></div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <div class="col-md-4">
                                    <input type="hidden" name="emp_code_edit" id="emp_code_edit" class="form-control" placeholder="Product Code" value=<?= $empleado[0]->id_empleado;?>>
                                    <input type="hidden" name="contrato_code" id="contrato_code_edit" class="form-control" placeholder="Product Code" value=<?= @$contratos[0]->id_contrato;?>>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">DISC:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_disc_edit" id="empleado_disc_edit" class="form-control" placeholder="Price">
                                                <option <?php if($examenes[0]->DISC=="D/I"){echo "selected";}?>id="" value="D/I">D/I</option>
                                                <option <?php if($examenes[0]->DISC=="D/S"){echo "selected";}?> id="" value="D/S">D/S</option>
                                                <option <?php if($examenes[0]->DISC=="D/C"){echo "selected";}?> id="" value="D/C">D/C</option>
                                                <option <?php if($examenes[0]->DISC=="I/D"){echo "selected";}?> id="" value="I/D">I/D</option>
                                                <option <?php if($examenes[0]->DISC=="I/C"){echo "selected";}?> id="" value="I/C">I/C</option>
                                                <option <?php if($examenes[0]->DISC=="I/S"){echo "selected";}?> id="" value="I/S">I/S</option>
                                                <option <?php if($examenes[0]->DISC=="S/D"){echo "selected";}?> id="" value="S/D">S/D</option>
                                                <option <?php if($examenes[0]->DISC=="S/I"){echo "selected";}?> id="" value="S/I">S/I</option>
                                                <option <?php if($examenes[0]->DISC=="S/C"){echo "selected";}?> id="" value="S/C">S/C</option>
                                                <option <?php if($examenes[0]->DISC=="C/D"){echo "selected";}?> id="" value="C/D">C/D</option>
                                                <option <?php if($examenes[0]->DISC=="C/I"){echo "selected";}?> id="" value="C/I">C/I</option>
                                                <option <?php if($examenes[0]->DISC=="C/S"){echo "selected";}?> id="" value="C/S">C/S</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">Notas DISC:</label>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">D:</label>
                                        <input type="number"  class="form-control"  name="empleado_d_edit" id="empleado_d_edit" value=<?=$examenes[0]->nota_disc1;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">I:</label>
                                        <input type="number"  class="form-control" name="empleado_i_edit" id="empleado_i_edit" value=<?=$examenes[0]->nota_disc2;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">S:</label></br>
                                        <input type="number"  class="form-control" name="empleado_s_edit" id="empleado_s_edit" value=<?=$examenes[0]->nota_disc3;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">C:</label></br>
                                        <input type="number"  class="form-control" name="empleado_c_edit" id="empleado_c_edit" value=<?=$examenes[0]->nota_disc4;?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <label class="col-md-12 col-form-label text-center">PATRON</label>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">PRINCIPAL:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_patron1_edit" id="empleado_patron1_edit" class="form-control">
                                                <option id="" value="Agente"                 <?php if($examenes[0]->patron1=="Agente"                 ){echo "selected";}?>>Agente                </option>
                                                <option id="" value="Alentador"              <?php if($examenes[0]->patron1=="Alentador"              ){echo "selected";}?>>Alentador             </option>
                                                <option id="" value="Consejero"              <?php if($examenes[0]->patron1=="Consejero"              ){echo "selected";}?>>Consejero             </option>
                                                <option id="" value="Creativo"               <?php if($examenes[0]->patron1=="Creativo"               ){echo "selected";}?>>Creativo              </option>
                                                <option id="" value="Especialista"           <?php if($examenes[0]->patron1=="Especialista"           ){echo "selected";}?>>Especialista          </option>
                                                <option id="" value="Evaluador"              <?php if($examenes[0]->patron1=="Evaluador"              ){echo "selected";}?>>Evaluador             </option>
                                                <option id="" value="Persuasivo"             <?php if($examenes[0]->patron1=="Investigador"           ){echo "selected";}?>>Persuasivo            </option>
                                                <option id="" value="Objetivo"               <?php if($examenes[0]->patron1=="Objetivo"               ){echo "selected";}?>>Objetivo              </option>
                                                <option id="" value="Orientado a Resultados" <?php if($examenes[0]->patron1=="Orientado a Resultados" ){echo "selected";}?>>Orientado a Resultados</option>
                                                <option id="" value="Profesional"            <?php if($examenes[0]->patron1=="Profesional"            ){echo "selected";}?>>Profesional           </option>
                                                <option id="" value="Perfeccionista"         <?php if($examenes[0]->patron1=="Perfeccionista"         ){echo "selected";}?>>Perfeccionista        </option>
                                                <option id="" value="Investigador"           <?php if($examenes[0]->patron1=="Investigador"           ){echo "selected";}?>>Investigador          </option>
                                                <option id="" value="Promotor"               <?php if($examenes[0]->patron1=="Promotor"               ){echo "selected";}?>>Promotor              </option>
                                                <option id="" value="Realizador"             <?php if($examenes[0]->patron1=="Realizador"             ){echo "selected";}?>>Realizador            </option>
                                                <option id="" value="Resolutivo"             <?php if($examenes[0]->patron1=="Resolutivo"             ){echo "selected";}?>>Resolutivo            </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">SECUNDARIO:</label>
                                        <div class="col-md-12">
                                            <select name="empleado_patron2_edit" id="empleado_patron2_edit" class="form-control">
                                                <option id="" value="Agente"                 <?php if($examenes[0]->patron2=="Agente"                 ){echo "selected";}?>>Agente                </option>
                                                <option id="" value="Alentador"              <?php if($examenes[0]->patron2=="Alentador"              ){echo "selected";}?>>Alentador             </option>
                                                <option id="" value="Consejero"              <?php if($examenes[0]->patron2=="Consejero"              ){echo "selected";}?>>Consejero             </option>
                                                <option id="" value="Creativo"               <?php if($examenes[0]->patron2=="Creativo"               ){echo "selected";}?>>Creativo              </option>
                                                <option id="" value="Especialista"           <?php if($examenes[0]->patron2=="Especialista"           ){echo "selected";}?>>Especialista          </option>
                                                <option id="" value="Evaluador"              <?php if($examenes[0]->patron2=="Evaluador"              ){echo "selected";}?>>Evaluador             </option>
                                                <option id="" value="Persuasivo"             <?php if($examenes[0]->patron2=="Investigador"           ){echo "selected";}?>>Persuasivo            </option>
                                                <option id="" value="Objetivo"               <?php if($examenes[0]->patron2=="Objetivo"               ){echo "selected";}?>>Objetivo              </option>
                                                <option id="" value="Orientado a Resultados" <?php if($examenes[0]->patron2=="Orientado a Resultados" ){echo "selected";}?>>Orientado a Resultados</option>
                                                <option id="" value="Profesional"            <?php if($examenes[0]->patron2=="Profesional"            ){echo "selected";}?>>Profesional           </option>
                                                <option id="" value="Perfeccionista"         <?php if($examenes[0]->patron2=="Perfeccionista"         ){echo "selected";}?>>Perfeccionista        </option>
                                                <option id="" value="Investigador"           <?php if($examenes[0]->patron2=="Investigador"           ){echo "selected";}?>>Investigador          </option>
                                                <option id="" value="Promotor"               <?php if($examenes[0]->patron2=="Promotor"               ){echo "selected";}?>>Promotor              </option>
                                                <option id="" value="Realizador"             <?php if($examenes[0]->patron2=="Realizador"             ){echo "selected";}?>>Realizador            </option>
                                                <option id="" value="Resolutivo"             <?php if($examenes[0]->patron2=="Resolutivo"             ){echo "selected";}?>>Resolutivo            </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <label class="col-md-12 col-form-label text-center">TETRAMAP:</label>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <select name="empleado_tetramap1_edit" id="empleado_tetramap1_edit" class="form-control">
                                                <option <?php if($examenes[0]->tetramap1=="Tierra"){echo "selected";}?> value="Tierra">Tierra</option>
                                                <option <?php if($examenes[0]->tetramap1=="Aire"){echo "selected";}?> value="Aire">Aire</option>
                                                <option <?php if($examenes[0]->tetramap1=="Agua"){echo "selected";}?> id="" value="Agua">Agua</option>
                                                <option <?php if($examenes[0]->tetramap1=="Fuego"){echo "selected";}?> id="" value="Fuego">Fuego</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <select name="empleado_tetramap2_edit" id="empleado_tetramap2_edit" class="form-control">
                                                <option <?php if($examenes[0]->tetramap2=="Tierra"){echo "selected";}?> id="" value="Tierra">Tierra</option>
                                                <option <?php if($examenes[0]->tetramap2=="Aire"){echo "selected";}?> id="" value="Aire">Aire</option>
                                                <option <?php if($examenes[0]->tetramap2=="Agua"){echo "selected";}?> id="" value="Agua">Agua</option>
                                                <option <?php if($examenes[0]->tetramap2=="Fuego"){echo "selected";}?> id="" value="Fuego">Fuego</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-12 col-form-label text-center">Notas:</label>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">TIERRA:</label>
                                        <input type="NUMBER"  class="form-control" name="empleado_ti_edit" id="empleado_ti_edit" value=<?=$examenes[0]->nota_tetramap1;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">AIRE:</label>
                                        <input type="number"  class="form-control" name="empleado_ai_edit" id="empleado_ai_edit" value=<?=$examenes[0]->nota_tetramap2;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class=" col-form-label">AGUA:</label></br>
                                        <input type="number"  class="form-control" name="empleado_au_edit" id="empleado_au_edit" value=<?=$examenes[0]->nota_tetramap3;?>>
                                        </div>
                                        <div class="col-md-6">
                                        <label class="col-form-label">FUEGO:</label></br>
                                        <input type="number"  class="form-control" name="empleado_fu_edit" id="empleado_fu_edit" value=<?=$examenes[0]->nota_tetramap4;?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-primary ">
                        <div class="panel-heading"><label>Examenes Tecnicos</label></div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Ortografia</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_ortografia_edit" id="empleado_ortografia_edit" value=<?=$examenes[0]->ortografia;?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Excel</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_excel_edit" id="empleado_excel_edit" value=<?=$examenes[0]->excel;?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Ejercicios</label>
                                    <select name="empleado_ejercicio_edit" id="empleado_ejercicio_edit" class="form-control">
                                        <option selected id="" value="9P, Termino Medio">9P, Termino Medio</option>
                                        <option  id="" value="10P, Termino Bien">10P, Termino Bien</option>
                                        <option  id="" value="11P, Termino Excelente">11P, Termino Excelente</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Test Alter</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_alter_edit" id="empleado_alter_edit" value=<?=$examenes[0]->test_alter;?>>
                                </div>
                                <div class="col-md-4">
                                    <label>Dictado</label>
                                    <input  class="form-control" type="number" min=0 max=10 name="empleado_dictado_edit" id="empleado_dictado_edit" value=<?=$examenes[0]->dictado;?>>
                                </div>
                                <div class="col-md-4">
                                    <label>WORD</label>
                                    <input class="form-control" type="number" min=0 max=10 name="empleado_word_edit" id="empleado_word_edit" value=<?=$examenes[0]->word;?>>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info ">
                        <div class="panel-heading"><label>Datos Generales</label></div>
                        <div class="panel-body">
                            <div class="col-md-8">
                                <label>Entrevistador:</label>   
                                <input class="form-control" type="text" name="empleado_entrevistador_edit" id="empleado_entrevistador_edit"  value="<?=$examenes[0]->entrevistador;?>">
                            </div>
                            <div class="col-md-4">
                                <label>Nota entrevista</label>
                                <input class="form-control" type="number" min=0 max=10 name="empleado_nota_edit" id="empleado_nota_edit" value=<?=$examenes[0]->nota_entrevista;?>>
                            </div>
                            <div class="col-md-12">
                                <label for="comment">Observaciones:</label>
                                <textarea class="form-control" rows="5" name="empleado_observacion_edit" id="empleado_observacion_edit"><?=$examenes[0]->observacion;?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="btn_update" class="btn btn-primary" >Modificar</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!-- MODAL VIEW -->
    <div class="modal fade" id="Modal_View" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Datos de Patron</h3>
                    <div class="col-md-2 text-center"></div>
                    <div class="col-md-10"><img src="<?= base_url();?>\assets\images\<?=$examenes[0]->patron2;?>.PNG" width="550" heigth="500" class="foto"></div>
                      

                </div>
                                      <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

                </div>
            </div>
    </div>
<!-- MODAL VIEW -->
<!-- ELIMINAR -->
<div class="modal fade" id="Modal_View2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-center" id="exampleModalLabel">Datos de Patron</h3>
                    <div class="col-md-2"></div>
                    <div class="col-md-10"><img src="<?= base_url();?>\assets\images\<?=$examenes[0]->patron1;?>.PNG" width="600" heigth="400" class="foto"></div>
                      

                </div>
                                      <div class="modal-footer">

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>

                </div>
            </div>
    </div>
<!-- MODAL VIEW -->
<?php 
    }
?>
<script type="text/javascript">   
    $(document).ready(function(){
        $('#btn_update').on('click',function(){
            
                location.reload();
                
        });
        //Save product
        $('#btn_save').on('click',function(){
            this.disabled=true;
            var employee_code          = $('#emp_code'              ).val();
            var contrato_code          = $('#contrato_code'         ).val();
            var empleado_disc          = $('#empleado_disc'         ).val();
            var empleado_d             = $('#empleado_d'             ).val();
            var empleado_i             = $('#empleado_i'             ).val();
            var empleado_s             = $('#empleado_s'             ).val();
            var empleado_c             = $('#empleado_c'             ).val();
            var empleado_patron1        = $('#empleado_patron1'       ).val();
            var empleado_patron2        = $('#empleado_patron2'      ).val();
            var empleado_tetramap1      =$('#empleado_tetramap1'       ).val();
            var empleado_tetramap2      =$('#empleado_tetramap2').val();
            var empleado_ti             = $('#empleado_ti'           ).val();
            var empleado_ai             = $('#empleado_ai'            ).val();
            var empleado_au             = $('#empleado_au'            ).val();
            var empleado_fu             = $('#empleado_fu'            ).val();
            var empleado_ortografia     = $('#empleado_ortografia'    ).val();
            var empleado_excel         = $('#empleado_excel'         ).val();
            var empleado_ejercicio      = $('#empleado_ejercicio'     ).val();
            var empleado_alter          = $('#empleado_alter'         ).val();
            var empleado_dictado        = $('#empleado_dictado'       ).val();
            var empleado_word          = $('#empleado_word'          ).val();
            var empleado_entrevistador = $('#empleado_entrevistador' ).val();
            var empleado_nota          = $('#empleado_nota'          ).val();
            var empleado_observacion    = $('#empleado_observacion'   ).val();
            //var area_name = $('#area_name').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/saveExamen')?>",
                dataType : "JSON",
                data : { employee_code:employee_code, empleado_disc:empleado_disc, empleado_d:empleado_d, empleado_i:empleado_i, empleado_s:empleado_s, empleado_c:empleado_c,empleado_patron1:empleado_patron1, empleado_patron2:empleado_patron2, empleado_tetramap1:empleado_tetramap1, empleado_tetramap2,empleado_tetramap2, empleado_ti:empleado_ti, empleado_ai:empleado_ai, empleado_au:empleado_au, empleado_fu:empleado_fu, empleado_ortografia:empleado_ortografia, empleado_excel:empleado_excel, empleado_ejercicio:empleado_ejercicio, empleado_alter:empleado_alter, empleado_dictado:empleado_dictado, empleado_word:empleado_word,empleado_entrevistador: empleado_entrevistador, empleado_nota:empleado_nota, empleado_observacion:empleado_observacion},
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
    });
</script>
 <!-- echart -->
 <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript">
    
        $(document).ready(function(){
            var Notas = <?= @$examenes[0]->nota_disc1;?> + 200;
        if ( Notas != 200) {
         /*Inicio de grafico dona*/
        var ctx = document.getElementById("chart");

        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                
                labels: ["D - <?= @$examenes[0]->nota_disc1;?>", " I  -  <?= @$examenes[0]->nota_disc2;?>", "S  - <?= @$examenes[0]->nota_disc3;?>", "C  - <?= @$examenes[0]->nota_disc4;?>"],
                datasets: [{
                    label: 'Nota',
                    data: [<?= @$examenes[0]->nota_disc1;?>, <?= @$examenes[0]->nota_disc2;?>, <?= @$examenes[0]->nota_disc3;?>, <?= @$examenes[0]->nota_disc4;?>],
                    backgroundColor: [
                        'rgba(0, 0, 0, 0)',
                        
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        
                    ],
                    borderWidth: 1,
                    lineTension: 0
                }]
            },
            options:{
                responsive:true,
                legend:{
                    position:'bottom',
                },
                title:{
                    display:false,
                    text: 'Grafico DISC'
                },
                animation:{
                    animateScale:true,
                    animateRotate:true
                },
                tooltips: {
                    mode: 'nearest'
                }
            }
        });
        /*Grafico dona fin*/   
        }

    });//Fin Jquery
</script>
</body>
</html>