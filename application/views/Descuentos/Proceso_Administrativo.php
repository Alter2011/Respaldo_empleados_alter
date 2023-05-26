    <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>

    <div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
        <div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Procesos Administrativos</h1>
    </div>
    <div class="panel-body">

        <?php if(isset($this->data["seccion_96"]) or isset($this->data["seccion_97"]) or isset($this->data["seccion_98"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.1 manual de empleados-->
                <a href="<?= base_url();?>index.php/Prestamo/verSolicitudInterno">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ok-sign fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Solicitud prestamos internos <span class="badge badge-danger" id="notificacionInter" style="background: red;"></span></label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_47"]) or isset($this->data["seccion_48"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.2 manual de empleados-->
                <a href="<?= base_url();?>index.php/Viaticos/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-sunglasses fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Asignar viaticos/mantenimiento</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


        <?php if(isset($this->data["seccion_51"]) or isset($this->data["seccion_52"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.3 manual de empleados-->
                <a href="<?= base_url();?>index.php/Bono/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-usd fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Asignar Gratificaion</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

         <?php if(isset($this->data["seccion_116"]) or isset($this->data["seccion_117"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.4 manual de empleados-->
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


        <?php if(isset($this->data["seccion_57"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.5 manual de empleados-->
                <a href="<?= base_url();?>index.php/Comisiones/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-save fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Comisiones 2021</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_57"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.6 manual de empleados-->
                <a href="<?= base_url();?>index.php/seguimiento/calculo_bonificacion">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-heart-empty fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Comisiones 2022</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_74"]) or isset($this->data["seccion_75"]) or isset($this->data["seccion_76"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.7 manual de empleados-->
                <a href="<?= base_url();?>index.php/PrestamosPersonales/verSolicitudes">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-ok fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Solicitudes de prestamos <span class="badge badge-danger" id="notificacion" style="background: red;"></span></label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>
        <!--Este metodo se usuaba para aprobar las vacaciones pero se realizo un nuevo modulo-->
        <!--asi que ya no esta en uso-->
        <?php /*if(isset($this->data["seccion_78"]) or isset($this->data["seccion_79"])){  ?>
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
        <?php }*/ ?>

        <?php if(isset($this->data["seccion_115"])){  ?>
              <div class="panel-group col-sm-4">
                <!--7.8 manual de empleados-->
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
                <!--7.9 manual de empleados-->
                <a href="<?= base_url();?>index.php/Cambios/index">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-level-upglyphicon glyphicon-level-up fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Reportes ISSS/AFP</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_133"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.10 manual de empleados-->
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

        <?php if(isset($this->data["seccion_149"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.11 manual de empleados-->
                <a href="<?= base_url();?>index.php/Liquidacion/empleadosAnticipos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-log-out fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Anticipo prestaciones</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_122"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.12 manual de empleados-->
                <a href="<?= base_url();?>index.php/Contratacion/maternidad">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-heart fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Maternidad </label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_129"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.13 manual de empleados-->
                <a href="<?= base_url();?>index.php/Contratacion/reporte">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-list-alt fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Control contrato</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_138"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.14 manual de empleados-->
                <a href="<?= base_url();?>index.php/Contratacion/constacias">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-folder-open fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Constancia laboral/salarial</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_163"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.15 manual de empleados-->
                <a href="<?= base_url();?>index.php/seguimiento/colocado_detalle">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-briefcase fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Detalle colocacion</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>
            <!-- NO18052023 -->
        <!-- FALTA PERMISOS -->
        <?php if(isset($this->data["seccion_47"]) or isset($this->data["seccion_48"])){  ?>
            <div class="panel-group col-sm-4">
                <!--7.2 manual de empleados-->
                <a href="<?= base_url();?>index.php/Empleado/plazas">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-user fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Control de plazas</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>


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

            /*vacacion();
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
            };*/


        });
    </script>

