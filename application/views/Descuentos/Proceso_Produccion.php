	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Procesos Produccion</h1>
    </div>
    <div class="panel-body">

        <?php if(isset($this->data["seccion_39"]) or isset($this->data["seccion_40"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Seguimiento/presupuestoClientesP">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-sort-by-attributes fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Perdida de Clientes</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_157"]) or isset($this->data["seccion_158"]) or isset($this->data["seccion_159"]) or isset($this->data["seccion_160"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Seguimiento/asignar_region">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-resize-small fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Asignaciones</label>
                        </div> 
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_155"]) or isset($this->data["seccion_156"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/seguimiento/filtro_reporte_rc">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-list-alt fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Reporte RC</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <!-- <?php //if(isset($this->data["seccion_33"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?//= base_url();?>index.php/seguimiento">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-log-in fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Seguimiento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php //} ?> -->

         <?php if(isset($this->data["seccion_33"]) and ($_SESSION['login']['perfil']=='admin' or $_SESSION['login']['cargo']=='Gerente de produccion')){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Reportes">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-book fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Reporte</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

    </div>
	</div>