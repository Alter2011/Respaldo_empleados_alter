<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->
<?php
    if (isset($_SESSION['login'])) {
            
        }else{
            $this->load->view('Escritorio/header');
                            redirect(base_url()."index.php");

        }

     ?>
         <?php if ($trabajadores !=null){ ?>
             
        <div class="col-sm-10">
            <div class="well text-center blue text-white">
                <h1><?php echo $trabajadores[0]->agencia ?> </h1>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-success">
                    <div class="panel-heading">Operaciones</div>
                    <div class="panel-body">
                    <?php foreach ($trabajadores as $trabaja) {
                    //print_r($trabaja);
                    if ($trabaja->idarea==004) {
                        
                    ?>

                    <div class="col-sm-6">
                        <div class="panel panel-info">
                            <div class="panel-heading"><?= $trabaja->cargo;?></div>
                            <div class="panel-body">
                                <?= $trabaja->nombre." ";?><?= $trabaja->apellido;?></br>
                                <a href="<?php echo site_url(); ?>/Academico/contrato/<?php echo $trabaja->id_empleado?>" title="Historial academico"> <i class="material-icons">school</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Contratacion/contrato/<?php echo $trabaja->id_empleado?>" title="Historial laboral"> <i class="material-icons">work</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Capacitacion/historial/<?php echo $trabaja->id_empleado?>" title="Historial de capacitacion"> <i class="material-icons">library_books</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Academico/examen/<?php echo $trabaja->id_empleado?>" title="Examen de Ingreso"> <i class="material-icons">card_membership</i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php
                        }//END IF
                    } 
                    ?>
                    </div>
                </div>
            </div>
            <!--Fin Operaciones-->
            <div class="col-sm-6">
                <div class="panel panel-warning">
                    <div class="panel-heading">Produccion</div>
                    <div class="panel-body">
                    <?php
                    $cont=0;
                    foreach ($trabajadores as $trabaja) {
                    //print_r($trabaja);
                    if ($trabaja->idarea=='002') {
                        
                    ?>

                    <div class="col-sm-6">

                        <div class="panel panel-info">
                            <div class="panel-heading"><?= $trabaja->cargo;?></div>
                            <div class="panel-body">
                                <?= $trabaja->nombre." ";?><?= $trabaja->apellido;?></br>
                                <a href="<?php echo site_url(); ?>/Academico/contrato/<?php echo $trabaja->id_empleado?>" title="Historial academico"> <i class="material-icons">school</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Contratacion/contrato/<?php echo $trabaja->id_empleado?>" title="Historial laboral"> <i class="material-icons">work</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Capacitacion/historial/<?php echo $trabaja->id_empleado?>" title="Historial de capacitacion"> <i class="material-icons">library_books</i>
                                </a>
                                <a href="<?php echo site_url(); ?>/Academico/examen/<?php echo $trabaja->id_empleado?>" title="Examen de Ingreso"> <i class="material-icons">card_membership</i>
                                </a>

                                <?php
                                $pos=strpos($trabaja->cargo, 'Asesor');
                        
                                 if ($pos !== false): ?>
                                    
                            <a href="<?php echo site_url(); ?>/Presupuestado/index/<?php  if(isset($usuario[$cont]->usuarioP)){echo $usuario[$cont]->usuarioP;}  ?>" title="Presupuesto/Colocacion"> <i class="material-icons">attach_money</i>
                                </a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>

                    <?php
                    $cont++;
                    # code...
                    }//END IF
                } 
                ?>
                    </div>
                </div>
            </div>
            <!--Fin Produccion-->
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Seguridad</div>
                    <div class="panel-body">
                    <?php foreach ($trabajadores as $trabaja) {
                    //print_r($trabaja);
                    if ($trabaja->idarea==007) {
                        
                    ?>
                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading"><?= $trabaja->cargo;?></div>
                                <div class="panel-body">
                                    <?= $trabaja->nombre." ";?><?= $trabaja->apellido;?></br>
                                    <a href="<?php echo site_url(); ?>/Academico/contrato/<?php echo $trabaja->id_empleado?>" title="Historial academico"> <i class="material-icons">school</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Contratacion/contrato/<?php echo $trabaja->id_empleado?>" title="Historial laboral"> <i class="material-icons">work</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Capacitacion/historial/<?php echo $trabaja->id_empleado?>" title="Historial de capacitacion"> <i class="material-icons">library_books</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Academico/examen/<?php echo $trabaja->id_empleado?>" title="Examen de Ingreso"> <i class="material-icons">card_membership</i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    <?php
                        }//END IF
                    } 
                    ?>
                    </div>
                </div>
            </div>
            <!--Fin Seguridad-->
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Administracion</div>
                    <div class="panel-body">
                    <?php foreach ($trabajadores as $trabaja) {
                    //print_r($trabaja);
                    if ($trabaja->idarea=='001' or $trabaja->idarea=='003' or $trabaja->idarea=='005' or $trabaja->idarea=='006' or $trabaja->idarea=='008' or $trabaja->idarea=='010') {
                        
                    ?>
                        <div class="col-sm-6">
                            <div class="panel panel-info">
                                <div class="panel-heading"><?= $trabaja->cargo;?></div>
                                <div class="panel-body">
                                    <?= $trabaja->nombre." ";?><?= $trabaja->apellido;?></br>
                                    <a href="<?php echo site_url(); ?>/Academico/contrato/<?php echo $trabaja->id_empleado?>" title="Historial academico"> <i class="material-icons">school</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Contratacion/contrato/<?php echo $trabaja->id_empleado?>" title="Historial laboral"> <i class="material-icons">work</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Capacitacion/historial/<?php echo $trabaja->id_empleado?>" title="Historial de capacitacion"> <i class="material-icons">library_books</i>
                                    </a>
                                    <a href="<?php echo site_url(); ?>/Academico/examen/<?php echo $trabaja->id_empleado?>" title="Examen de Ingreso"> <i class="material-icons">card_membership</i>
                                    </a>

                                </div>
                            </div>
                        </div>
                    <?php
                        }//END IF
                    } 
                    ?>
                    </div>
                </div>
            </div>
            <!--Fin Administracion-->
        </div>
        
    </div>
        

         <?php }else{ ?>
                 <div class="well text-center blue text-white">
                <h1>No existe ningun empleado con los cargos requeridos, lo sentimos </h1>
            </div>
            <?php } ?>
</body>
</html>