
    <div class="Panel with panel-primary class col-sm-9" style="margin: 4%">
        <div class="panel panel-heading ">
     <!--Titulo de la pagina en donde esta -->
     <h1>Mantenimientos de RRHH</h1>
    </div>
    <div class="panel-body">

    <?php if(isset($this->data["seccion_1"]) or isset($this->data["seccion_2"]) or isset($this->data["seccion_3"]) or isset($this->data["seccion_4"])){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/agencias/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-home fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Agencias</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

        <?php if(isset($this->data["seccion_5"]) or isset($this->data["seccion_6"]) or isset($this->data["seccion_7"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/areas/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-th-large fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Areas</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_8"]) or isset($this->data["seccion_9"]) or isset($this->data["seccion_10"])){  ?>              
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/cargos/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-user fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Cargos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_11"]) or isset($this->data["seccion_12"]) or isset($this->data["seccion_13"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/academico/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-education fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Nivel Academico</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_14"]) or isset($this->data["seccion_15"]) or isset($this->data["seccion_16"]) ){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/capacitacion/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-blackboard fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Tipo de Capacitacion</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

       <!--plazas -->
       <?php if(isset($this->data["seccion_89"])) {  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/plazas/">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-tasks fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Plazas</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <!--Prestacines legales-->
         <?php if(isset($this->data["seccion_90"])){  ?>
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Mantenimiento/categoria">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-th-list fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Categoria de Cargos</label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

        <?php if(isset($this->data["seccion_95"])){  ?>              
            <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contratacion/contratos_vencer">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-briefcase fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Contratos a vencer <span class="badge badge-danger" id="notificacionVencer" style="background: red;"></span></label>
                        </div>
                    </div> 
                </a>          
            </div>
        <?php } ?>

    <?php if(isset($this->data["seccion_101"])){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Agencias/paises">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-globe fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Paises</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <?php if(isset($this->data["seccion_148"])){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Contratacion/empleadosSalario">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="fas fa-donate fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Primer Salario</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    <div class="panel-group col-sm-4">
        <a href="<?= base_url();?>index.php/Historietas/Agregar">
            <div class="panel-info " role="button">
                <div class="panel-heading print-blue text-center" >
                    <span class="glyphicon glyphicon-book fa-5x text-center"></span> <br/>
                </div>
                <div class="panel-footer text-center">
                <label>Mantenimiento capacitacion</label>
                </div>
            </div> 
        </a>          
    </div>
    <?php if(isset($this->data["seccion_17"]) ) {  ?>
    <div class="panel-group col-sm-4">
        <a href="<?= base_url();?>index.php/Historietas/Capitulo">
            <div class="panel-info " role="button">
                <div class="panel-heading print-blue text-center" >
                    <span class="glyphicon glyphicon-bookmark fa-5x text-center"></span> <br/>
                </div>
                <div class="panel-footer text-center">
                    <label>Grupo de capacitaciones</label>
                </div>
            </div> 
        </a>          
    </div>
    <?php } ?>
    <!-- FALTA PERMISO NO25042023 -->
    <?php if(isset($this->data["seccion_1"]) or isset($this->data["seccion_2"]) or isset($this->data["seccion_3"]) or isset($this->data["seccion_4"])){  ?>
         <div class="panel-group col-sm-4">
                <a href="<?= base_url();?>index.php/Mantenimiento/test_prospectos">
                    <div class="panel-info" role="button">
                        <div class="panel-heading print-blue text-center" >
                            <span class="glyphicon glyphicon-book fa-5x text-center"></span><br/>
                        </div>
                        <div class="panel-footer text-center">
                        <label>Test para prospectos</label>
                        </div>
                    </div> 
                </a>          
            </div>
    <?php } ?>

    </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){  

            vencimiento_contrato();
                function vencimiento_contrato(){
                    estado=1;
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/mostrar_contratos_vencer')?>",
                        dataType : "JSON",
                        data : {estado:estado},
                        success: function(data){
                        console.log(data);
                            if(data > 0){
                                document.getElementById('notificacionVencer').innerHTML = data;
                            }   
                        },
                    });
            };

        });
    </script>