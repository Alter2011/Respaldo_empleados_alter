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
                <h2>Perfil de Usuario</h2>
                
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well col-sm-12 ">
                        <nav class="float-right">   
                        <h4 class="alert alert-success " >Informacion extra:    <?php echo $_SESSION['login']['cargo']; ?>    </h4>            
                        </nav>
                        
                        <div class="row">
                            <div class="col-sm-3 text-center">
                                <img src="../../../../Produccion/PHP/user_images/<?= $_SESSION['login']['prospectos'] ?>.png"  class="img-circle" width="150" heigth="150">
                                <div class="row">
                                    <div class="col-sm-3 text-center"></div>
                                    <div class="col-sm-2 text-center no-print">
                                        
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
                        <h4 class="alert alert-warning " ><?php echo $_SESSION['login']['cargo']; ?> </h4>      
                        <div class="row">
                            <br>

                            <div class="panel-group col-sm-4">
                                <a href="<?= base_url();?>index.php/Permisos/">
                                    <div class="panel panel-primary " role="button">
                                        <div class="panel-heading print-blue text-center" >
                                            <span class="glyphicon glyphicon-calendar fa-5x text-center"></span> <br/>
                                        </div>
                                        <div class="panel-footer text-center">
                                        <label> Presupuesto Mensual</label>
                                        </div>
                                    </div> 
                                </a>          
                            </div>
                            
                            <div class="panel-group col-sm-4">
                                <a href="<?= base_url();?>index.php/Presupuestado/">
                                    <div class="panel panel-info " role="button">
                                        <div class="panel-heading print-blue text-center" >
                                            <span class="glyphicon glyphicon-stats fa-5x text-center"></span> <br/>
                                        </div>
                                        <div class="panel-footer text-center">
                                        <label> Colocacion Mensual</label>
                                        </div>
                                    </div> 
                                </a>          
                            </div>

                            <div class="panel-group col-sm-4">
                                <a href="<?= base_url();?>index.php/Academico/contrato/<?= $_SESSION['login']['id_empleado'] ?>">
                                    <div class="panel panel-info " role="button">
                                        <div class="panel-heading print-blue text-center" >
                                            <span class="glyphicon glyphicon-education fa-5x text-center"></span> <br/>
                                        </div>
                                        <div class="panel-footer text-center">
                                        <label> Historial Academico</label>
                                        </div>
                                    </div> 
                                </a>          
                            </div>

                            <div class="panel-group col-sm-4">
                                <a href="<?= base_url();?>index.php/Contratacion/contrato/<?= $_SESSION['login']['id_empleado'] ?>">
                                    <div class="panel panel-info " role="button">
                                        <div class="panel-heading print-blue text-center" >
                                            <span class="glyphicon glyphicon-briefcase fa-5x text-center"></span> <br/>
                                        </div>
                                        <div class="panel-footer text-center">
                                        <label> Historial Laboral</label>
                                        </div>
                                    </div> 
                                </a>          
                            </div>


                            
                        </div>
                            
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>