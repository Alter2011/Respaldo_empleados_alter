    <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>

	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Mantenimientos de Contabilidad</h1>
    </div>
    <div class="panel-body">

    <?php if(isset($this->data["seccion_130"]) ){  ?>
    	 <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contabilidad/cuentasCargo">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-align-right fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Cuentas de Cargo/Abono</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <?php if(isset($this->data["seccion_131"]) ){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contabilidad/cuentaPersonal">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-user fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Cuentas Personales</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <?php if(isset($this->data["seccion_132"]) ){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contabilidad/index_generar">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-print fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Generar Reportes</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    </div>
	</div>
    

    <script type="text/javascript">
        $(document).ready(function(){

        });
    </script>

