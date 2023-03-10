        <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
        <input type="hidden" name="permiso" id="permiso" value="<?php echo  $aprobar; ?>" readonly>
        <input type="hidden" name="permiso2" id="permiso2" value="<?php echo  $verPlinillas; ?>" readonly>
        <input type="hidden" name="control" id="control" value="<?php echo  $control; ?>" readonly>
        <input type="hidden" name="bloqueo" id="bloqueo" value="<?php echo  $bloqueo; ?>" readonly>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Generar Planilla</h2>
                <center><h4 id="fecha" style="display: none;"></h4></center>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    <?php if($reporte == 1 or $control == 1 or $bloqueo == 1 or $bloqueo_jefa == 1 or $imprimir_pla == 1){ ?>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Planilla</a></li>
                        <li><a data-toggle="tab" href="#menu5" id="pag6">Planilla Gob</a></li>
                    <?php if($reporte == 1){ ?>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Reporte</a></li>
                    <?php } ?>
                    <?php if($control == 1){ ?>
                        <li><a data-toggle="tab" href="#menu2" id="pag3">Aprobado/Eliminado</a></li>
                    <?php } ?>
                    <?php if($bloqueo == 1){ ?>
                        <li><a data-toggle="tab" href="#menu3" id="pag4">Planilla Ejecutada</a></li>
                    <?php } ?>
                    <?php if($bloqueo_jefa == 1 || $revisar == 1){ ?>
                        <li><a data-toggle="tab" href="#menu4" id="pag5">Bloqueo de planilla para Jefas</a></li>
                    <?php } ?>
                    </ul>
                    <?php } ?>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>
                    <nav class="float-right">
                                <div class="col-sm-10">
                                <?php 
                                $reca = $this->uri->segment(3);
                                if (isset($_SESSION['validar'][0])) {?>
                                    <center>
                                        <div id="validacion_user" style="color:red" class="alert alert-danger aprobar" role="alert">
                                            <?php echo $_SESSION['validar'][0];?>
                                        </div>
                                    </center>
                                <?php }else if (!empty($_SESSION['aprobar'])) {?>
                                    <?php if($_SESSION['aprobar'][0] != ""){?>
                                    <center>
                                        <div id="validacion_user" class="alert alert-info aprobar" role="alert" style="color:blue">
                                            <?php echo $_SESSION['aprobar'][0];?>
                                            
                                        </div>
                                    </center>
                                <?php } }else if (isset($_SESSION['aprobar2'])) { ?>
                                    <center>
                                        <div id="validacion_user" class="alert alert-danger aprobar" role="alert" style="color:red">
                                            <?php echo $_SESSION['aprobar'][0];?>
                                            
                                        </div>
                                    </center>

                                <?php }else if($reca == 1){?>
                                    <center>
                                        <div id="validacion_user" class="alert alert-info aprobar" role="alert" style="color:blue">
                                            <p>Se ha eliminado con exito la planilla</p>
                                            
                                        </div>

                                <?php }else{ ?>
                                    <center>
                                        <div id="validacion_user" style="color:red"></div>
                                    </center>
                                <?php } ?>

                                <form action="<?php echo base_url('index.php/Planillas/generar_planilla/'); ?>"  method="post" >

                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label for="inputState">Empresa </label>
                                            <?php if($aprobar == 1){ ?>
                                            <select class="form-control" name="empresaAu" id="empresaAu" class="form-control">
                                                <?php
                                                    $i=0;
                                                    foreach($empresa as $a){
                                                    
                                                    ?>
                                                        <option id="<?= ($a->id_empresa);?>" value="<?= ($a->id_empresa);?>"><?php echo($a->nombre_empresa);?></option>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                        <?php }else if($verPlinillas == 1){ ?> 
                                            <select class="form-control" name="empresaAu" id="empresaAu" class="form-control">
                                                <?php
                                                    $i=0;
                                                    foreach($empresa as $a){
                                                    
                                                    ?>
                                                        <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                                    <?php
                                                        $i++;
                                                    }
                                                    ?>
                                            </select>
                                        <?php }else{ ?> 
                                            <select class="form-control" name="empresa" id="empresa" class="form-control">
                                            </select>
                                        <?php } ?>

                                        </div>
                                    </div>

                                    <div class="form-row">
                                    <?php if($ver==1 or $verPlinillas == 1) { ?>
                                     <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_planilla" id="agencia_planilla" class="form-control">
                                             
                                        </select>
                                    </div>
                                <?php }else{ ?>

                                    <input type="hidden" name="agencia_planilla" id="<?php echo ($_SESSION['login']['agencia']); ?>" value="<?php echo ($_SESSION['login']['agencia']); ?>">

                                <?php } ?>
                                </div>

                                <div class="form-row">
                                     <div class="form-group col-md-3">
                                        <label for="inputState">Quincena</label>
                                        <select class="form-control" name="num_quincena" id="num_quincena" class="form-control">
                                            <option value="1">Primera Quincena</option>
                                            <option value="2">Segunda Quincena</option>
                                        </select>
                                    </div>
                                </div>
                                <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                                <div class="form-row">
                                     <div class="form-group col-md-3">
                                        <label for="inputState">Mes</label>
                                        <input type="month" class="form-control" id="mes_quincena" name="mes_quincena" value="<?php echo date("Y-m"); ?>">
                                    </div>
                                </div>

                                <input type="hidden" name="aprobar" id="aprobar" value="<?php echo $aprobar; ?>" readonly>
                                
                                <div class="form-row">
                                     <div class="form-group col-md-3">
                                        <center><button type="submit" class="btn btn-success btn-lg item_filtrar" style="margin-top: 23px;">Generar Planilla</button></center>
                                    </div>
                                </div>
                            </form>

                            </div>
                    </nav><!--Fin <nav class="float-right">-->
                    </div>


                    <div id="menu5" class="tab-pane fade">
                        <form action="<?php echo base_url('index.php/Planillas/planillaGobierno/'); ?>"  method="post" >
                            <br>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Empresa </label>
                                    <?php if($aprobar == 1){ ?>
                                        <select class="form-control" name="empresa_gob" id="empresa_gob" class="form-control">
                                            <?php
                                            $i=0;
                                            foreach($empresa as $a){
                                                    
                                            ?>
                                                <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    <?php }else if($verPlinillas == 1){ ?> 
                                        <select class="form-control" name="empresa_gob" id="empresa_gob" class="form-control">
                                            <?php
                                            $i=0;
                                            foreach($empresa as $a){
                                                    
                                            ?>
                                                <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                            <?php
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    <?php }else{ ?> 
                                        <select class="form-control" name="empresaGobJ" id="empresaGobJ" class="form-control">
                                        </select>
                                    <?php } ?>

                                </div>
                            </div>

                            <div class="form-row">
                                <?php if($ver==1 or $verPlinillas == 1) { ?>
                                     <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_gob" id="agencia_gob" class="form-control">
                                             
                                        </select>
                                    </div>
                                <?php } ?>
                                    
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Quincena</label>
                                    <select class="form-control" name="num_quincena_gob" id="num_quincena_gob" class="form-control">
                                        <option value="1">Primera Quincena</option>
                                        <option value="2">Segunda Quincena</option>
                                    </select>
                                </div>
                            </div>
                               
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Mes</label>
                                    <input type="month" class="form-control" id="mes_quincena_gob" name="mes_quincena_gob" value="<?php echo date("Y-m"); ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <center><button type="submit" class="btn btn-success btn-lg item_filtrar" style="margin-top: 23px;">Generar Planilla</button></center>
                                </div>
                            </div>
                        </form>
                    </div><!--Fin  <div id="menu5" class="tab-pane fade">-->



                    <div id="menu1" class="tab-pane fade"><br><br>

                         <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_reporte" id="empresa_reporte" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte2">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_reporte" id="agencia_reporte" class="form-control">
                                    
                                </select>
                                            
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes de Planilla</label>
                                <input type="month" class="form-control" id="mes_reporte" name="mes_reporte" value="<?php echo date('Y-m')?>">
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Quincena</label>
                                <select class="form-control" name="num_reporte" id="num_reporte" class="form-control">
                                    <option value="todo">Todas</option>
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                        <table class="table table-striped" id="mydatos" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombre</th> 
                                    <th style="text-align:center;">DUI</th> 
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Monto</th> 
                                    <th style="text-align:center;">ISSS</th> 
                                    <th style="text-align:center;">AFP</th> 
                                    <th style="text-align:center;">Monto Liquido</th> 
                                </tr>
                            </thead>
                                <tbody class="tabla1">
                                              
                                </tbody> 
                                <tfoot class="ultimo">
                                    
                                </tfoot>
                        </table>
                        
                    </div>

                    <div id="menu2" class="tab-pane fade"><br><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_reporte2" id="empresa_reporte2" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte2">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_reporte2" id="agencia_reporte2" class="form-control">
                                    
                                </select>
                                            
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes de Planilla</label>
                                <input type="month" class="form-control" id="mes_reporte2" name="mes_reporte2" value="<?php echo date('Y-m')?>">
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Quincena</label>
                                <select class="form-control" name="num_reporte2" id="num_reporte2" class="form-control">
                                    <option value="todo">Todas</option>
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar_control" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered" id="myreporte" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre</th> 
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Agencia</th>
                                    <th style="text-align:center;">Empresa</th>
                                    <th style="text-align:center;">Fecha Apl</th>
                                    <th style="text-align:center;">Fecha</th>
                                    <th style="text-align:center;">Hora</th>
                                    <th style="text-align:center;">Accion</th>

                                </tr>
                            </thead>
                            <tbody class="tabla2">
                                 
                            </tbody> 
                        </table>
                        
                    </div>

                    <div id="menu3" class="tab-pane fade"><br><br><!--EMPIEZA BLOQUEO-->

                        <div class="form-row">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_bloqueo" id="empresa_bloqueo" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_bloqueo" id="agencia_bloqueo" class="form-control">
                                    
                                </select>
                                            
                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes de Planilla</label>
                                <input type="month" class="form-control" id="mes_bloqueo" name="mes_bloqueo" value="<?php echo date('Y-m')?>">
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Quincena</label>
                                <select class="form-control" name="num_bloqueo" id="num_bloqueo" class="form-control">
                                    <option value="todo">Todas</option>
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar_bloqueo" class="btn btn-primary btn-sm item_filtrar_bloqueo" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered" id="mybloqueo" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Aprobado Por</th> 
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Agencia</th>
                                    <th style="text-align:center;">Empresa</th>
                                    <th style="text-align:center;">Fecha Apl</th>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;">
                                        Accion
                                        <input type="checkbox" name="marcar" id="marcar" class="form-check-input">
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="tabla3">
                                 
                            </tbody> 
                        </table>

                        <div class="col-sm-12">
                                <div class="col-sm-10">
                                </div>  
                                <div class="col-sm-2">
                                    <input type="button" class="form-control btn btn-success" name="bloqueos" id="bloqueos" value="Ejecutar Accion">
                                </div>  
                                
                        </div>
                        
                    </div><!--FIN BLOQUEO-->

                    <div id="menu4" class="tab-pane fade"><br><br><!--EMPIEZA BLOQUEO-->

                        <div class="form-row">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_jefa" id="empresa_jefa" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_jefa" id="agencia_jefa" class="form-control">
                                    
                                </select>
                                            
                                
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes de Planilla</label>
                                <input type="month" class="form-control" id="mes_jefa" name="mes_jefa" value="<?php echo date('Y-m')?>">
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Quincena</label>
                                <select class="form-control" name="num_jefa" id="num_jefa" class="form-control">
                                    <option value="todo">Todas</option>
                                    <option value="1">Primera Quincena</option>
                                    <option value="2">Segunda Quincena</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar_bloqueo" class="btn btn-primary btn-sm item_filtrar_jefa" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                        <table class="table table-striped table-bordered" id="mybloqueoJefa" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Aprobado Por</th> 
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Agencia</th>
                                    <th style="text-align:center;">Empresa</th>
                                    <th style="text-align:center;">Fecha Apl</th>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;">
                                        Accion
                                        <?php if($bloqueo_jefa == 1){ ?>
                                        <input type="checkbox" name="marcar2" id="marcar2" class="form-check-input">
                                        <?php } ?>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="tabla4">
                                 
                            </tbody> 
                        </table>

                        <?php if($bloqueo_jefa == 1){ ?>
                        <div class="col-sm-12">
                            <div class="col-sm-10">
                            </div>  
                            <div class="col-sm-2">
                                <input type="button" class="form-control btn btn-success" name="bloqueos_jefa" id="bloqueos_jefa" value="Ejecutar Accion">
                               
                            </div>  
                                
                        </div>
                        <?php } ?>
                        
                    </div><!--FIN BLOQUEO PLANILLA-->


                    </div>
                </div>
                </div>
                </div><!--Fin <div class="col-sm-12">-->
            </div><!--Fin <div class="row">-->

            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<!-- Modal GIF-->
  <div class="modal fade" id="modalGif" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">Cargando Por Favor Espere</h4>
        </div>
        <div class="modal-body" >
          <center><div class="lds-dual-ring"></div></center>
        </div>
       
      </div>
      
    </div>
  </div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
         var permiso = $('#permiso').val();
         var permiso2 = $('#permiso2').val();
        setTimeout(function(){
            $(".aprobar").fadeOut(1500);
        },3000);

        load();
        function load(){
            if(permiso != 1){
                empresa();
                empresaGob();
            }
        }
         
         function empresa(){
            var permiso = $('#permiso').val();
            var agencia = $('#agencia').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/empresa')?>",
                    dataType : "JSON",
                    data : {permiso:permiso,agencia:agencia},
                    success: function(data){
                        $("#empresa").empty();
                        $.each(data.empresa,function(key, registro) {

                             $("#empresa").append('<option id='+registro.id_empresa+' value='+registro.id_empresa+'>'+registro.nombre_empresa+'</option>');
                        });
                       //alert('Termino');
                       
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };

         function empresaGob(){
                var permiso = $('#permiso').val();
                var agencia = $('#agencia').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/empresa')?>",
                    dataType : "JSON",
                    data : {permiso:permiso,agencia:agencia},
                    success: function(data){
                        $("#empresaGobJ").empty();
                        $.each(data.empresa,function(key, registro) {

                             $("#empresaGobJ").append('<option id='+registro.id_empresa+' value='+registro.id_empresa+'>'+registro.nombre_empresa+'</option>');
                        });
                       //alert('Termino');
                       
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };


         if(permiso == 1 || permiso2 == 1){
            agencia();
         }
        $("#empresaAu").change(function(){
            var permiso = $('#permiso').val();
            if(permiso == 1 || permiso2 == 1){    
                agencia();
            }
        });

         function agencia(){
            var empresa = $('#empresaAu').children(":selected").attr("value");
            //alert(empresa);
            $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_planilla").empty();
                        $.each(data.agencia,function(key, registro) {

                             $("#agencia_planilla").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                    
                        <?php if($admin != 1) { ?>
                            $("#agencia_planilla").find("option[value='00']").remove(); 
                         <?php } ?>

                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

         };

        $('#pag6').on('click',function(){
            agencia_gob();
        });
        $("#empresa_gob").change(function(){
            var permiso = $('#permiso').val();
            if(permiso == 1 || permiso2 == 1){    
                agencia_gob();
            }
        });
         function agencia_gob(){
            var empresa = $('#empresa_gob').children(":selected").attr("value");
            //alert(empresa);
            $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                    dataType : "JSON",
                    data : {empresa:empresa},
                    success: function(data){
                        $("#agencia_gob").empty();
                        $.each(data.agencia,function(key, registro) {

                             $("#agencia_gob").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                        });
                    
                        <?php if($admin != 1){ ?>
                            $("#agencia_gob").find("option[value='00']").remove(); 
                         <?php } ?>

                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

        };


         //METODOS PARA EL REPORTE DE LAS VACACIONES

         //Metodo para validar que el campo del mes quincena este siempre lleno
         $('#mes_reporte').change(function(){
            if($("#mes_reporte").val().length == 0) { 
                var ahora = new Date();
                var mes = ("0" + (ahora.getMonth() + 1)).slice(-2);
                var hoy = ahora.getFullYear()+"-"+(mes);
                $('[name="mes_reporte"]').val(hoy);
            }

        });

         $('#pag1').on('click',function(){
            $("#fecha").hide();
         });

        $('#pag2').on('click',function(){
            reporte();
        });

        $('.item_filtrar').on('click',function(){
            reporte();
        });

        function reporte(){
            var empresa = $('#empresa_reporte').children(":selected").attr("value");
            var agencias = $('#agencia_reporte').children(":selected").attr("value");
            var mes = $('#mes_reporte').val();
            var quincena = $('#num_reporte').val();
            var total_bruto = 0;
            var total_isss = 0;
            var total_afp = 0;
            var total_liq = 0;
            var suel = 0;
            var bruto = 0;

            var i = 0;
            var dias = 15;

            $('#mydatos').dataTable().fnDestroy();
            
            $('.tabla1').empty();
            $('.ultimo').empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Planillas/reportePlanilla')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencias:agencias,mes:mes,quincena:quincena},
                success : function(data){
                    console.log(data.datos.length);

                    $.each(data.datos,function(key, registro){
                        if(registro.conteo == 2){
                            dias = 30;
                        }else{
                            dias = 15;
                        }
                        suel = (registro.quincena/dias)*registro.dias;
                        if(suel <= registro.bruto){
                            bruto = parseFloat(registro.bruto)+parseFloat(registro.bono);
                        }else{
                            bruto = registro.bruto;
                        } 
                        total_bruto += parseFloat(bruto);
                        total_isss += parseFloat(registro.isss);
                        total_afp += parseFloat(registro.afp);
                        total_liq += parseFloat(registro.total);

                        $('.tabla1').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                '<td>'+registro.dui+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>$'+parseFloat(bruto).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(registro.isss).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(registro.afp).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+
                            '</tr>'
                        );
                        i++;
                        if(i == data.datos.length){
                            $('.ultimo').append(
                                '<tr>'+
                                    '<td><b>TOTAL</b></td>'+
                                    '<td>--------</td>'+
                                    '<td>--------</td>'+
                                    '<td>--------</td>'+
                                    '<td><b>$'+total_bruto.toFixed(2)+'</b></td>'+
                                    '<td><b>$'+total_isss.toFixed(2)+'</b></td>'+
                                    '<td><b>$'+total_afp.toFixed(2)+'</b></td>'+
                                    '<td><b>$'+total_liq.toFixed(2)+'</b></td>'+
                                '</tr>'
                            );
                        }
                        
                   });
                    

                    document.getElementById('fecha').innerHTML = data.fecha;
                    $("#fecha").show();

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#mydatos').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
            
        };

        agencia_reporte();
        $("#empresa_reporte").change(function(){
            var permiso = $('#permiso').val();
            if(permiso == 1 || permiso2 == 1){    
                agencia_reporte();
            }
        });

         function agencia_reporte(){
            var empresa = $('#empresa_reporte').children(":selected").attr("value");
            $("#agencia_reporte").empty();
            if(empresa != 'todas'){
                $("#agencia_reporte").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_reporte").append('<option id="todas" value="todas">Todas</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_reporte").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_reporte").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_reporte").attr('disabled','disabled');
            }

         };

         agencia_reporte2();
          $("#empresa_reporte2").change(function(){
            var control = $('#control').val();
            if(control == 1){    
                agencia_reporte2();
            }
        });
         function agencia_reporte2(){
            var empresa = $('#empresa_reporte2').children(":selected").attr("value");
            $("#agencia_reporte2").empty();
            if(empresa != 'todas'){
                $("#agencia_reporte2").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_reporte2").append('<option id="todas" value="todas">Todas</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_reporte2").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_reporte2").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_reporte2").attr('disabled','disabled');
            }

         };

         $('#pag3').on('click',function(){
            eliminada_aprobada();
        });
        $('.item_filtrar_control').on('click',function(){
            eliminada_aprobada();
        });
         function eliminada_aprobada(){
            var empresa = $('#empresa_reporte2').children(":selected").attr("value");
            var agencias = $('#agencia_reporte2').children(":selected").attr("value");
            var mes = $('#mes_reporte2').val();
            var quincena = $('#num_reporte2').val();
            var estado = '';

            $('#myreporte').dataTable().fnDestroy();

            $(".tabla2").empty();
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/reportPlanilla')?>",
                        async : false,
                        dataType : "JSON",
                        data : {empresa:empresa,agencias:agencias,mes:mes,quincena:quincena},
                        success: function(data){
                            console.log(data);
                            $.each(data.datos,function(key, registro) {
                                if(registro.estado == 0){
                                    estado = '<span class="badge badge-danger">Rechazada</span>';
                                }else if(registro.estado == 1 || registro.estado == 3){
                                    estado = '<span class="badge badge-success">Aprobada</span>';
                                }else if(registro.estado == 2){
                                    estado = '<span class="badge badge-info">Generada</span>';
                                }else if(registro.estado == 4){
                                    estado = '<span class="badge badge-danger">Rechazada Gob</span>';
                                }else if(registro.estado == 5 || registro.estado == 7){
                                    estado = '<span class="badge badge-success">Aprobada Gob</span>';
                                }else if(registro.estado == 6){
                                    estado = '<span class="badge badge-info">Generada Gob</span>';
                                }

                                $('.tabla2').append(
                                    '<tr>'+
                                        '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                        '<td>'+registro.cargo+'</td>'+
                                        '<td>'+registro.agencia+'</td>'+
                                        '<td>'+registro.nombre_empresa+'</td>'+
                                        '<td>'+registro.fecha_quincena+'</td>'+
                                        '<td>'+registro.fecha+'</td>'+
                                        '<td>'+registro.hora+'</td>'+
                                        '<td>'+estado+'</td>'+
                                    '</tr>'
                                );

                                document.getElementById('fecha').innerHTML = data.fecha;
                                $("#fecha").show();
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });

                $('#myreporte').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

         };

         agencia_bloqueo();
          $("#empresa_bloqueo").change(function(){
            var bloqueo = $('#bloqueo').val();
            if(bloqueo == 1){    
                agencia_bloqueo();
            }
        });

        function agencia_bloqueo(){
            var empresa = $('#empresa_bloqueo').children(":selected").attr("value");
            $("#agencia_bloqueo").empty();
            if(empresa != 'todas'){
                $("#agencia_bloqueo").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_bloqueo").append('<option id="todas" value="todas">Todas</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_bloqueo").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_bloqueo").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_bloqueo").attr('disabled','disabled');
            }

         };

         $('#bloqueos').on('click',function(){
            var checkboxes = document.getElementsByName('cheque');//nombre generico de los check
            console.log(checkboxes);
            var vals = [];


            for (var i=0, n=checkboxes.length;i<n;i++) //propiedad de contar todos los check
            {
                if (checkboxes[i].checked) //solo los que estan chequeado
                {
                    vals.push(checkboxes[i].value);

                }
            }
            //if (vals) vals = vals.substring(1);
            if (vals.length==0) {
                alert('Debe seleccionar al menos una planilla');
            }else{

                $.ajax({
                    type  : 'POST',
                    url   : '<?php echo site_url('Planillas/bloqueoPlan')?>',
                    async : false,
                    dataType : 'JSON',
                    data : {vals:vals},
                    success : function(data){
                        $("#marcar").prop("checked", false);
                        bloquear_planilla();
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
            }
        });

        $('#pag4').on('click',function(){
            bloquear_planilla();
        });
        $('.item_filtrar_bloqueo').on('click',function(){
            bloquear_planilla();
        });

        function bloquear_planilla(){
            var empresa = $('#empresa_bloqueo').children(":selected").attr("value");
            var agencias = $('#agencia_bloqueo').children(":selected").attr("value");
            var mes = $('#mes_bloqueo').val();
            var quincena = $('#num_bloqueo').val();
            var estado = '';

            $('#mybloqueo').dataTable().fnDestroy();

            $(".tabla3").empty();
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/bloqueoPlanilla')?>",
                        async : false,
                        dataType : "JSON",
                        data : {empresa:empresa,agencias:agencias,mes:mes,quincena:quincena},
                        success: function(data){
                            console.log(data);
                            $.each(data.datos,function(key, registro) {

                                if(registro.bloqueo == 0){
                                    estado = 'Planilla No Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="1-'+registro.id_control+'" onclick="cheque()"> <span class="label label-danger">Bloquear rechazo planilla</span>';

                                }else if(registro.bloqueo == 1){
                                    estado = 'Planilla Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="0-'+registro.id_control+'" onclick="cheque()"> <span class="label label-success">Desbloquear rechazo planilla</span>';

                                }else if(registro.bloqueo == 2){
                                    estado = 'Planilla No Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="3-'+registro.id_control+'" onclick="cheque()"> <span class="label label-danger">Bloquear rechazo planilla</span>';

                                }else if(registro.bloqueo == 3){
                                    estado = 'Planilla Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="2-'+registro.id_control+'" onclick="cheque()"> <span class="label label-success">Desbloquear rechazo planilla</span>';

                                }else if(registro.bloqueo == 4){
                                    estado = 'Planilla Gob No Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="5-'+registro.id_control+'" onclick="cheque()"> <span class="label label-danger">Bloquear rechazo planilla Gob</span>';

                                }else if(registro.bloqueo == 5){
                                    estado = 'Planilla Gob Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="4-'+registro.id_control+'" onclick="cheque()"> <span class="label label-success">Desbloquear rechazo planilla Gob</span>';

                                }else if(registro.bloqueo == 6){
                                    estado = 'Planilla Gob No Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="7-'+registro.id_control+'" onclick="cheque()"> <span class="label label-danger">Bloquear rechazo planilla</span>';

                                }else if(registro.bloqueo == 7){
                                    estado = 'Planilla Gob Ejecutada';
                                    texto='<input type="checkbox" name="cheque" class="form-check-input cbox" id="cbox" value="6-'+registro.id_control+'" onclick="cheque()"> <span class="label label-success">Desbloquear rechazo planilla</span>';

                                }

                                $('.tabla3').append(
                                    '<tr>'+
                                        '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                        '<td>'+registro.cargo+'</td>'+
                                        '<td>'+registro.agencia+'</td>'+
                                        '<td>'+registro.nombre_empresa+'</td>'+
                                        '<td>'+registro.fecha_quincena+'</td>'+
                                        '<td>'+estado+'</td>'+
                                        '<td>'+texto+'</td>'+
                                    '</tr>'
                                );

                                document.getElementById('fecha').innerHTML = data.fecha;
                                $("#fecha").show();
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });

                $('#mybloqueo').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

         };

        //funcion para marcar todos los check del bloqueo de planillas
        $("#marcar").on("click", function() {
          $(".cbox").prop("checked", this.checked);
        });

        $('#pag5').on('click',function(){
            bloquear_planilla_jefa();
        });
        $('.item_filtrar_jefa').on('click',function(){
            bloquear_planilla_jefa();
        });

        function bloquear_planilla_jefa(){
            var empresa = $('#empresa_jefa').children(":selected").attr("value");
            var agencias = $('#agencia_jefa').children(":selected").attr("value");
            var mes = $('#mes_jefa').val();
            var quincena = $('#num_jefa').val();
            var estado = '';
            var texto = '';

            $('#mybloqueoJefa').dataTable().fnDestroy();

            $(".tabla4").empty();
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/bloqueoPlanilla')?>",
                        async : false,
                        dataType : "JSON",
                        data : {empresa:empresa,agencias:agencias,mes:mes,quincena:quincena},
                        success: function(data){
                            console.log(data);
                            $.each(data.datos,function(key, registro) {
                                texto = '';
                                if(registro.bloqueo == 0){
                                    estado = 'Planilla Bloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto = '<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="2-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-success">Desbloquedar planilla para jefa</span>';
                                }else if(registro.bloqueo == 1){
                                    estado = 'Planilla Bloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto = '<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="3-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-success">Desbloquedar planilla para jefa</span>';
                                }else if(registro.bloqueo == 2){
                                    estado = 'Planilla Desbloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto = '<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="0-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto += ' <span class="label label-danger">Bloquear planilla para jefa</span>';
                                }else if(registro.bloqueo == 3){
                                    estado = 'Planilla Desbloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto='<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="1-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-danger">Bloquear planilla para jefa</span>';
                                }else if(registro.bloqueo == 4){
                                    estado = 'Planilla Gob Bloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto='<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="6-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-success">Desbloquedar planilla Gob para jefa</span>';
                                }else if(registro.bloqueo == 5){
                                    estado = 'Planilla Gob Bloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto='<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="7-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-success">Desbloquedar Gob planilla para jefa</span>';
                                }else if(registro.bloqueo == 6){
                                    estado = 'Planilla Gob Desbloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto='<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="4-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-danger">Bloquear planilla Gob para jefa</span>';
                                }else if(registro.bloqueo == 7){
                                    estado = 'Planilla Gob Desbloqueada';
                                    <?php if($bloqueo_jefa == 1){ ?>
                                    texto='<input type="checkbox" name="checkBloq" class="form-check-input checkBlo" id="checkBlo" value="1-'+registro.id_control+'" onclick="chequeBloq()">';
                                    <?php } ?>
                                    texto +=' <span class="label label-danger">Bloquear Gob planilla para jefa</span>';
                                }

                                $('.tabla4').append(
                                    '<tr>'+
                                        '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                        '<td>'+registro.cargo+'</td>'+
                                        '<td>'+registro.agencia+'</td>'+
                                        '<td>'+registro.nombre_empresa+'</td>'+
                                        '<td>'+registro.fecha_quincena+'</td>'+
                                        '<td>'+estado+'</td>'+
                                        '<td>'+texto+'</td>'+
                                    '</tr>'
                                );

                                document.getElementById('fecha').innerHTML = data.fecha;
                                $("#fecha").show();
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });

                $('#mybloqueoJefa').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

         };

         agencia_bloqueo_jefa();
          $("#empresa_jefa").change(function(){
            var bloqueo = $('#bloqueo').val();
            if(bloqueo == 1){    
                agencia_bloqueo_jefa();
            }
        });

         function agencia_bloqueo_jefa(){
            var empresa = $('#empresa_jefa').children(":selected").attr("value");
            $("#agencia_jefa").empty();
            if(empresa != 'todas'){
                $("#agencia_jefa").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_jefa").append('<option id="todas" value="todas">Todas</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_jefa").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                        
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_jefa").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_jefa").attr('disabled','disabled');
            }

         };

         //POR FAVOR NO QUITAR 
         function resolver1Seg() {
          return new Promise(resolve => {
            setTimeout(() => {
              resolve(bloqueoJefa());
            }, 1000);
          });
        }

        async function llamadoAsincrono() {
          $('#modalGif').modal('show');
          await resolver1Seg();
          
        }

         $('#bloqueos_jefa').on('click',function(){
            llamadoAsincrono();
         });

        
         //$('#bloqueos_jefa').on('click',function(){
            function bloqueoJefa(){
            var checkboxes = document.getElementsByName('checkBloq');//nombre generico de los check
            var vals = [];

            for (var i=0, n=checkboxes.length;i<n;i++) //propiedad de contar todos los check
            {
                if (checkboxes[i].checked) //solo los que estan chequeado
                {
                    vals.push(checkboxes[i].value);

                }
            }
            //if (vals) vals = vals.substring(1);
            if (vals.length==0) {
                $("#modalGif").modal('toggle');
                alert('Debe seleccionar al menos una planilla');
            }else{
                
                $.ajax({
                    type  : 'POST',
                    url   : '<?php echo site_url('Planillas/bloqueoPlan')?>',
                    async : false,
                    dataType : 'JSON',
                    data : {vals:vals},
                    success : function(data){
                        $("#marcar2").prop("checked", false);
                        $("#modalGif").modal('toggle');
                        bloquear_planilla_jefa();
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
            }
        }
        //});

        //funcion para marcar todos los check del bloqueo de planillas
        $("#marcar").on("click", function() {
          $(".cbox").prop("checked", this.checked);
        });

        //funcion para marcar todos los check del bloqueo de planillas
        $("#marcar2").on("click", function() {
          $(".checkBlo").prop("checked", this.checked);
        });
    

    });//Fin jQuery

    //Funcion que se utiliza para saber si todos los check estan marcados
    function cheque(){ 
        if ($(".cbox").length == $(".cbox:checked").length) {  
            $("#marcar").prop("checked", true);  
        } else {  
            $("#marcar").prop("checked", false);
        }  
    }

    //Funcion que se utiliza para saber si todos los check estan marcados
    function chequeBloq(){ 
        if ($(".checkBlo").length == $(".checkBlo:checked").length) {  
            $("#marcar2").prop("checked", true);  
        } else {  
            $("#marcar2").prop("checked", false);
        }  
    }
</script>
</body>


</html>