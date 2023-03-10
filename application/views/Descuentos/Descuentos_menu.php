	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Descuentos</h1>
    </div>
    <div class="panel-body">

        <?php if(isset($this->data["seccion_39"]) or isset($this->data["seccion_40"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Prestamo/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-log-in fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Prestamo Interno</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_42"]) or isset($this->data["seccion_43"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Faltantes/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-remove-circle fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Faltante</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_60"]) or isset($this->data["seccion_61"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Descuentos_horas/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-tag fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Descuento de horas</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_63"]) or isset($this->data["seccion_64"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Anticipos/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-credit-card fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Anticipos/Herramienta</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_70"]) or isset($this->data["seccion_71"])or isset($this->data["seccion_72"]) or isset($this->data["seccion_73"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Orden_descuentos/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-circle-arrow-down fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Orden de descuentos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_85"]) or isset($this->data["seccion_86"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Descuentos_herramientas/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon glyphicon-open fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Descuento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


           <?php if(isset($this->data["seccion_175"]) or isset($this->data["seccion_175"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Descuentos_herramientas/descuentos_empleados">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon glyphicon-open fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Descuentos de empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>
        

    </div>
	</div>