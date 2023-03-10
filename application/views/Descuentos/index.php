    <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>

	<div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
		<div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Mantenimientos de los Descuentos</h1>
    </div>
    <div class="panel-body">

    <?php if(isset($this->data["seccion_36"]) ){  ?>
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

        <?php if(isset($this->data["seccion_96"]) or isset($this->data["seccion_97"]) or isset($this->data["seccion_98"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Prestamo/verSolicitudInterno">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ok-sign fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Solicitud de Prestamos Internos <span class="badge badge-danger" id="notificacionInter" style="background: red;"></span></label>
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

        <?php if(isset($this->data["seccion_45"])){  ?>
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

        <?php if(isset($this->data["seccion_47"]) or isset($this->data["seccion_48"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Viaticos/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-sunglasses fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Asignar Viaticos/Mantenimiento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_51"]) or isset($this->data["seccion_52"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Bono/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-usd fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Asignar Bonos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

         <?php if(isset($this->data["seccion_53"])){  ?>
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

         <?php if(isset($this->data["seccion_54"]) or isset($this->data["seccion_55"])){  ?>
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

        <?php if(isset($this->data["seccion_57"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Comisiones/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-save fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Comisones</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

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


        <?php if(isset($this->data["seccion_62"])){  ?>
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

        <?php if(isset($this->data["seccion_66"])){  ?>
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

        <?php if(isset($this->data["seccion_67"]) or isset($this->data["seccion_68"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/PrestamosPersonales/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon glyphicon-user fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agregar Prestamos Personales</label>
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

        <style>

        </style>

        <?php if(isset($this->data["seccion_74"]) or isset($this->data["seccion_75"]) or isset($this->data["seccion_76"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/PrestamosPersonales/verSolicitudes">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ok fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Solicitudes de Prestamos <span class="badge badge-danger" id="notificacion" style="background: red;"></span></label>
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

        <?php if(isset($this->data["seccion_78"]) or isset($this->data["seccion_79"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Vacaciones/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-saved fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Aprobar pago de Vacaciones <span class="badge badge-danger" id="notificacionVaca" style="background: red;"></span></label>
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
                <a href="<?= base_url();?>index.php/Boleta_pago/index">
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

        <?php if(isset($this->data["seccion_84"])){  ?>
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

        <?php if(isset($this->data["seccion_115"])){  ?>
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

        <?php if(isset($this->data["seccion_107"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Cambios/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-level-upglyphicon glyphicon-level-up fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Reportes</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_133"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Prestamo/lista_despedidos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-thumbs-down fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Prestamos despedidos/renuncia</label>
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
                            <span class="fas fa-briefcase-medical fa-5x text-center"></span><br/>
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
                            <span class="fas fa-comments-dollar fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Gestiones de Fin de Año</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_149"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Liquidacion/empleadosAnticipos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="fas fa-file-invoice-dollar fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Anticipo de Prestaciones</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_150"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Liquidacion/tipoGestion">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-cog fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Gestiones</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>



        <!--<?php if(isset($this->data["seccion_85"]) or isset($this->data["seccion_86"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Bloqueo_fechas/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ban-circle fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Bloquedo de Pagos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>-->

    </div>
	</div>
    

    <script type="text/javascript">
        $(document).ready(function(){
           //ESTE METODO SE UTILIZA PARA HACER LAS NOTIFICACIONES DE LAS SOLICITUDES DE PRESTAMOS PERSONALES
           //FAVOR DE NO QUITAR  
           show();
            function show(){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('PrestamosPersonales/notificacion')?>",
                    dataType : "JSON",
                    data : {},
                    success: function(data){
                        if(data[0].conteo > 0){
                            document.getElementById('notificacion').innerHTML = data[0].conteo;
                        }   
                    },
                });
            };

            interno();
            function interno(){
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Prestamo/notificacionInter')?>",
                    dataType : "JSON",
                    data : {},
                    success: function(data){
                        if(data[0].conteo > 0){
                            document.getElementById('notificacionInter').innerHTML = data[0].conteo;
                        }   
                    },
                });
            };

            vacacion();
            function vacacion(){
                var agencia = $('#agencia').val();
                var user = $('#user').val();
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Vacaciones/notiVacacion')?>",
                    dataType : "JSON",
                    data : {agencia:agencia,user:user},
                    success: function(data){
                        console.log(data);
                        if(data[0].conteo > 0){
                            document.getElementById('notificacionVaca').innerHTML = data[0].conteo;
                           
                        }   
                    },
                    error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
                });
            };


        });
    </script>

