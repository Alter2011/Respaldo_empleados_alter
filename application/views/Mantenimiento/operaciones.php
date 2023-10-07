
	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Mantenimientos de Operaciones</h1>
    </div>
    <div class="panel-body">

        <?php if(isset($this->data["seccion_36"]) ){  ?>
            <!--5.1 manual de empleados-->
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Descuentos/descuentosLey">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-minus-sign fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Descuentos de Ley</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_37"]) ){  ?>
            <!--5.2 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Renta/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-home fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Renta</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_37"]) ){  ?>
            <!--5.3 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/TiempoRenta/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-time fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tiempo para la Renta</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_38"]) ){  ?>
            <!--5.4 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Prestamo/listaPrestamos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-book fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Prestamo</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_45"])){  ?>
            <!--5.5 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Observacion/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-edit fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Observaciones de Codigo</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_46"])){  ?>
            <!--5.6 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/tipoViaticos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-th-large fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Viaticos/Mantenimiento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_53"])){  ?>
            <!--5.7 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Tasa/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-share-alt fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tasa y Primas</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_62"])){  ?>
            <!--5.8 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Anticipos/tipoAnticipos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-list-alt fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Anticipos/Herramienta</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_66"])){  ?>
            <!--5.9 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/PrestamosPersonales/tipoPrestamos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-folder-open fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipos de Prestamos Personales</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_84"])){  ?>
            <!--5.10 manual de empleados-->
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Descuentos_herramientas/verTipo">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon glyphicon-list fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Descuento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <!--Bancos-->
        <?php if(isset($this->data["seccion_91"])){  ?>
            <!--5.11 manual de empleados-->
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/bancos/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-usd fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Bancos</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

     <?php if(isset($this->data["seccion_102"])){  ?>
        <!--5.12 manual de empleados-->
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Agencias/empresas">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-lock fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Empresas</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <?php if(isset($this->data["seccion_171"])){  ?>
        <!--5.13 manual de empleados-->
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/precio_gasolina">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-wrench fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Mantenimientos de viaticos</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <?php if(isset($this->data["seccion_171"])){  ?>
        <!--5.13 manual de empleados-->
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/precio_gasolina">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-wrench fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Mantenimientos de viaticos</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    

    </div>
	</div>