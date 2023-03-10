	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Pagos</h1>
    </div>
    <div class="panel-body">


        <?php if(isset($this->data["seccion_58"]) or isset($this->data["seccion_59"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Horas_extras/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-floppy-disk fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Horas Extras</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


       
        <?php if(isset($this->data["seccion_77"]) or isset($this->data["seccion_112"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Vacaciones/empleadosVacacion">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-header fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Historial de Vacaciones</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_80"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Planillas/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-stats fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Generar Planilla</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_81"]) or isset($this->data["seccion_82"]) or isset($this->data["seccion_83"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Planillas/empleadosBoletas">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-folder-close fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Boleta de Pagos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_116"]) or isset($this->data["seccion_117"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Dias_trabajados/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-briefcase fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Ingreso de dias trabajados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_134"]) or isset($this->data["seccion_135"]) or isset($this->data["seccion_136"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Liquidacion/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-piggy-bank fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Liquidacion para empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_140"]) or isset($this->data["seccion_141"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contratacion/empleadosIncapacidad">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-plus-sign fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Incapacidad para Empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_146"]) or isset($this->data["seccion_147"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Liquidacion/empleadosAguinaldo">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-gift fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Gestiones de Fin de Año</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>
        

        <?php if(isset($this->data["seccion_154"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Planillas/empleado_gob">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-screenshot fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Subsidio para empleados</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_172"]) or isset($this->data["seccion_173"]) or isset($this->data["seccion_174"])){ ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/viaticos_rutas">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-road fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Viaticos carteras</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_178"])  ){ ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/ver_calculadora">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-road fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Calculadora viaticos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

    </div>
	</div>