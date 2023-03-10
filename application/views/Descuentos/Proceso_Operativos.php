	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Procesos Operativos</h1>
    </div>
    <div class="panel-body">


        <?php if(isset($this->data["seccion_54"]) or isset($this->data["seccion_55"])){  ?>
            <!--8.1 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/PermisosEmpleados/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ok-circle fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Permisos de Empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_67"]) or isset($this->data["seccion_68"])){  ?>
            <!--8.2 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/PrestamosPersonales/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-download-alt fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Prestamos Personales</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>



        <?php if(isset($this->data["seccion_115"])){  ?>
            <!--8.3 manual de empleados-->
              <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Prestamo/empleadosPrestamos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-usd fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Estado actual de los prestamos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        
        <?php if(isset($this->data["seccion_25"]) or isset($this->data["seccion_26"]) or isset($this->data["seccion_27"]) or isset($this->data["seccion_28"])){  ?>
            <!--8.4 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/usuarios/ver/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon glyphicon-user fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Usuarios</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_21"]) or isset($this->data["seccion_22"]) or isset($this->data["seccion_23"]) or isset($this->data["seccion_24"])){  ?>
            <!--8.5 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/historial/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-credit-card fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Historial laboral</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

    
    </div>
	</div>