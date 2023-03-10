
<nav class=" navbar-inverse visible-xs no-print">
    <div class="container-fluid no-print">
        <div class="navbar-header no-print">
            <button type="button" class="navbar-toggle no-print" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand fixed no-print" href="<?= base_url();?>"><img src="<?= base_url();?>\assets\images\logo.png" width="150" heigth="150"></a>

        </div>    
        <div class="collapse navbar-collapse no-print" id="myNavbar">
            <ul class="nav navbar-nav no-print">
                <li <?php if($activo=="Index"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/dashboard/">Dashboard</a></li> <!--esta puesto enlace por archivo routes.php -->
                <?php if(isset($this->data["seccion_33"])) :  ?>  
                <li <?php if($activo=="Prospectos"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/permisos/">Presupuesto</a></li> <!--esta puesto enlace por archivo routes.php -->
                <?php endif ?>

                <?php if(isset($this->data["seccion_33"])) :  ?>  
                <li <?php if($activo=="Seguimiento"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/seguimiento/">Seguimiento</a></li> <!--esta puesto enlace por archivo routes.php -->
                <?php endif ?>
                <!--<li <?php if($activo=="Metas"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/metas/">Metas</a></li> esta puesto enlace por archivo routes.php -->
                <li <?php if($activo=="Reportes"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/Reportes/">Reportes</a></li> <!--esta puesto enlace por archivo routes.php -->

                <?php if(isset($this->data["seccion_17"]) or isset($this->data["seccion_18"]) or isset($this->data["seccion_19"]) or isset($this->data["seccion_20"])){  ?>
                    <li <?php if($activo=="Empleado"){ ?>class="active"<?php } ?> class="dropdown">
                        <a href="javascript:void(0)" class="dropbtn">Empleados</a>
                        <div class="dropdown-content">
                            <a href="<?= base_url();?>index.php/Empleado/Ver/">Ver</a>
                            <?php if(isset($this->data["seccion_17"]) ) {  ?>
                               <a href="<?= base_url();?>index.php/Empleado/Agregar/">Nuevo</a>
                           <?php } ?>
                       </div>
                   </li>
                       <?php } ?>
                       <!-- <li <?php if($activo=="Contratos"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/contratacion/">Historial Laboral</a></li> -->

                       <?php if(isset($this->data["seccion_21"]) or isset($this->data["seccion_22"]) or isset($this->data["seccion_23"]) or isset($this->data["seccion_24"])){  ?>

                        <li <?php if($activo=="Historial"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/historial/">Historial</a></li>
                    <?php } ?>


                      <?php if(isset($this->data["seccion_25"]) or isset($this->data["seccion_26"]) or isset($this->data["seccion_27"]) or isset($this->data["seccion_28"])) :  ?>

                    <li <?php if($activo=="login"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/usuarios/ver/">Usuarios</a></li>   
                <?php endif ?>

                <?php if(isset($this->data["seccion_29"]) or isset($this->data["seccion_30"]) or isset($this->data["seccion_31"]) or isset($this->data["seccion_32"])) :  ?>    
                <li <?php if($activo=="perfiles"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/perfiles/">Perfiles</a></li>
                 <?php endif ?>

                <!-- <li <?php if($activo=="HCapacitacion"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>  index.php/capacitacion/historial">Historial de capacitaciones</a></li> -->
                <li ><a href="<?= base_url();?>index.php/iniciar/logout">Cerrar sesion</a></li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row content">
        <div class="col-md-2 col-sm-2 sidenav hidden-xs no-print print-md-2">
            <ul class="nav nav-pills nav-stacked menu no-print">
                <center>
                    <h2><a href="<?= base_url();?>"><img src="<?= base_url();?>\assets\images\logo.png" width="150" heigth="150"></a></h2>

                    <a style="color: #3E5F8A" data-toggle="modal" href="javascript:void(0);" data-target="#Modal_pass">
                        Bienvenid@  <?php  if (isset($_SESSION['login'])){ echo ($_SESSION['login']['usuario']); }                 ?><i class="material-icons">vpn_key</i>
                    </a>
                    <?PHP //print_r($this->data);?>
                </center>
                <li <?php if($activo=="Index"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/dashboard/">Dashboard</a></li> <!--esta puesto enlace por archivo routes.php -->
                
                <?php if(isset($this->data["seccion_33"])) :  ?>  
                <li <?php if($activo=="Prospectos"){ ?>class="active"<?php } ?>>
                       <a id="secDes" href="#" class="dropdown-toggle" data-toggle="dropdown" >Presupuesto <span class="glyphicon glyphicon-chevron-down"></span></a>
                        <ul class="dropdown-menu" id="ulDes">

                             <?php if(isset($this->data["seccion_168"]) or isset($this->data["seccion_169"]) or isset($this->data["seccion_170"])) :  ?>  

                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/permisos/filtro_tablero_global"><span class="glyphicon glyphicon-inbox"></span>Tablero</a>
                            </li>
                            <?php endif ?>


                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/permisos/"><span class="glyphicon glyphicon-th-list"></span> Tablero 2021</a>
                            </li>
               

                        </ul>


                </li> <!--esta puesto enlace por archivo routes.php -->

                    <?php endif ?>
                 <?php if(isset($this->data["seccion_34"]) ) :  ?>  

                    <li <?php if($activo=="Presupuestado"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/Presupuestado/">Presupuesto/Colocacion</a></li> <!--esta puesto enlace por archivo routes.php -->
                                        <?php endif ?>

                <?php if(isset($this->data["seccion_17"]) or isset($this->data["seccion_18"]) or isset($this->data["seccion_19"]) or isset($this->data["seccion_20"])){  ?>
                    <li <?php if($activo=="Empleado"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/Empleado/">Empleados</a></li>
                    
                <?php } ?>
                       <!-- <li <?php if($activo=="Contratos"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/contratacion/">Historial Laboral</a></li> -->
                    
                    <?php 
                    $validar=false;
                    for ($i=1; $i <=16 ; $i++) { 
                        if (isset($this->data["seccion_".$i])) {
                            $validar=true;
                        }
                    } ?>

                    <?php if(isset($this->data["seccion_122"])){ ?>
                                <input type="hidden" name="control_mate" id="control_mate" value="1" readonly>
                        <?php }else{ ?>
                                <input type="hidden" name="control_mate" id="control_mate" value="0" readonly>
                        <?php
                            }
                        ?>

                    <?php if($validar or isset($this->data["seccion_36"]) or isset($this->data["seccion_37"]) or isset($this->data["seccion_38"]) or isset($this->data["seccion_45"]) or isset($this->data["seccion_46"]) or isset($this->data["seccion_53"]) or isset($this->data["seccion_62"]) or isset($this->data["seccion_66"]) or isset($this->data["seccion_84"]) or isset($this->data["seccion_89"]) or isset($this->data["seccion_90"]) or isset($this->data["seccion_91"]) or isset($this->data["seccion_95"]) or isset($this->data["seccion_101"]) or isset($this->data["seccion_102"]) or isset($this->data["seccion_148"]) or isset($this->data["seccion_17"]) or isset($this->data["seccion_18"]) or isset($this->data["seccion_19"]) or isset($this->data["seccion_20"])): ?>
                        
                     <li class="dropdown <?php if($activo=="Mantenimientos"){ ?>active<?php } ?>">
                        <!--<a href="<?= base_url();?>index.php/Mantenimiento/">Mantenimientos</a>-->
                        <a id="secDes" href="#" class="dropdown-toggle" data-toggle="dropdown" >Mantenimientos <span class="glyphicon glyphicon-chevron-down"></span></a>
                        <ul class="dropdown-menu" id="ulDes">

                            <?php if($validar or isset($this->data["seccion_89"]) or isset($this->data["seccion_90"]) or isset($this->data["seccion_95"]) or isset($this->data["seccion_101"]) or isset($this->data["seccion_148"]) or isset($this->data["seccion_17"]) or isset($this->data["seccion_18"]) or isset($this->data["seccion_19"]) or isset($this->data["seccion_20"])){ ?>

                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/Mantenimiento/rrhh"><span class="glyphicon glyphicon-th-list"></span> RRHH</a>
                            </li>
                            <?php } ?>

                            <?php if(isset($this->data["seccion_36"]) or isset($this->data["seccion_37"]) or isset($this->data["seccion_38"]) or isset($this->data["seccion_45"]) or isset($this->data["seccion_46"]) or isset($this->data["seccion_53"]) or isset($this->data["seccion_62"]) or isset($this->data["seccion_66"]) or isset($this->data["seccion_84"]) or isset($this->data["seccion_91"]) or isset($this->data["seccion_102"])){ ?>
                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/Mantenimiento/operaciones"><span class="glyphicon glyphicon-inbox"></span> Operaciones</a>
                            </li>
                            <?php } ?>
                        </ul>
                        
                    </li>

                    <?php endif ?>

                <?php if(isset($this->data["seccion_29"]) or isset($this->data["seccion_30"]) or isset($this->data["seccion_31"]) or isset($this->data["seccion_32"])) :  ?>    
                <li <?php if($activo=="perfiles"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/perfiles/">Perfiles</a></li>
                 <?php endif ?>

                   <?php if(isset($this->data["seccion_21"]) or isset($this->data["seccion_22"]) or isset($this->data["seccion_23"]) or isset($this->data["seccion_24"]) or isset($this->data["seccion_25"]) or isset($this->data["seccion_26"]) or isset($this->data["seccion_27"]) or isset($this->data["seccion_28"]) or isset($this->data["seccion_39"]) or isset($this->data["seccion_40"]) or isset($this->data["seccion_42"]) or isset($this->data["seccion_43"]) or isset($this->data["seccion_47"]) or isset($this->data["seccion_48"]) or isset($this->data["seccion_51"]) or isset($this->data["seccion_52"]) or isset($this->data["seccion_57"]) or isset($this->data["seccion_58"]) or isset($this->data["seccion_59"]) or isset($this->data["seccion_60"]) or isset($this->data["seccion_61"]) or isset($this->data["seccion_63"]) or isset($this->data["seccion_64"]) or isset($this->data["seccion_67"]) or isset($this->data["seccion_68"]) or isset($this->data["seccion_70"]) or isset($this->data["seccion_71"]) or isset($this->data["seccion_72"]) or isset($this->data["seccion_73"]) or isset($this->data["seccion_74"]) or isset($this->data["seccion_75"]) or isset($this->data["seccion_76"]) or isset($this->data["seccion_77"]) or isset($this->data["seccion_78"]) or isset($this->data["seccion_79"]) or isset($this->data["seccion_80"]) or isset($this->data["seccion_81"]) or isset($this->data["seccion_82"]) or isset($this->data["seccion_83"]) or isset($this->data["seccion_85"]) or isset($this->data["seccion_86"]) or isset($this->data["seccion_96"]) or isset($this->data["seccion_97"]) or isset($this->data["seccion_98"]) or isset($this->data["seccion_107"]) or isset($this->data["seccion_115"]) or isset($this->data["seccion_116"]) or isset($this->data["seccion_117"]) or isset($this->data["seccion_122"]) or isset($this->data["seccion_129"]) or isset($this->data["seccion_133"]) or isset($this->data["seccion_134"]) or isset($this->data["seccion_135"]) or isset($this->data["seccion_136"]) or isset($this->data["seccion_138"]) or isset($this->data["seccion_140"]) or isset($this->data["seccion_141"]) or isset($this->data["seccion_146"]) or isset($this->data["seccion_147"]) or isset($this->data["seccion_149"]) or isset($this->data["seccion_154"]) or isset($this->data["seccion_33"]) or isset($this->data["seccion_155"]) or isset($this->data["seccion_156"]) or isset($this->data["seccion_157"]) or isset($this->data["seccion_158"]) or isset($this->data["seccion_159"]) or isset($this->data["seccion_160"])){  ?>

                    <li class="dropdown <?php if($activo=="Descuentos"){ ?>active<?php } ?>">
                        <!--<a href="<?= base_url();?>index.php/Descuentos/">Procesos</a>-->
                        <a id="secDes2" href="#" class="dropdown-toggle" data-toggle="dropdown" >Procesos <span class="glyphicon glyphicon-chevron-down"></span></a>
                        <ul class="dropdown-menu" id="ulDes">

                            <?php if(isset($this->data["seccion_47"]) or isset($this->data["seccion_48"]) or isset($this->data["seccion_51"]) or isset($this->data["seccion_52"]) or isset($this->data["seccion_57"]) or isset($this->data["seccion_74"]) or isset($this->data["seccion_75"]) or isset($this->data["seccion_76"]) or isset($this->data["seccion_78"]) or isset($this->data["seccion_79"]) or isset($this->data["seccion_96"]) or isset($this->data["seccion_97"]) or isset($this->data["seccion_98"]) or isset($this->data["seccion_107"]) or isset($this->data["seccion_115"]) or isset($this->data["seccion_122"]) or isset($this->data["seccion_129"]) or isset($this->data["seccion_133"]) or isset($this->data["seccion_138"]) or isset($this->data["seccion_149"])){ ?>

                            <li class="liDesp">
                                <a id="despegable2" href="<?= base_url();?>index.php/Descuentos/procesos_administrativos"><span class="glyphicon glyphicon-paste"></span> Administrativos</a>
                            </li>
                            <?php } ?>
                             

                             <?php if(isset($this->data["seccion_21"]) or isset($this->data["seccion_22"]) or isset($this->data["seccion_23"]) or isset($this->data["seccion_24"]) or isset($this->data["seccion_25"]) or isset($this->data["seccion_26"]) or isset($this->data["seccion_27"]) or isset($this->data["seccion_28"]) or isset($this->data["seccion_39"]) or isset($this->data["seccion_40"]) or isset($this->data["seccion_42"]) or isset($this->data["seccion_43"]) or isset($this->data["seccion_58"]) or isset($this->data["seccion_59"]) or isset($this->data["seccion_60"]) or isset($this->data["seccion_61"]) or isset($this->data["seccion_63"]) or isset($this->data["seccion_64"]) or isset($this->data["seccion_67"]) or isset($this->data["seccion_68"]) or isset($this->data["seccion_70"]) or isset($this->data["seccion_71"]) or isset($this->data["seccion_72"]) or isset($this->data["seccion_73"]) or isset($this->data["seccion_77"]) or isset($this->data["seccion_80"]) or isset($this->data["seccion_81"]) or isset($this->data["seccion_82"]) or isset($this->data["seccion_83"]) or isset($this->data["seccion_85"]) or isset($this->data["seccion_86"]) or isset($this->data["seccion_154"])){ ?>

                            <li class="liDesp">
                                <a id="despegable2" href="<?= base_url();?>index.php/Descuentos/procesos_operativos"><span class="glyphicon glyphicon-paperclip"></span> Operativos</a>
                            </li>

                            <li class="liDesp">
                                <a id="despegable2" href="<?= base_url();?>index.php/Descuentos/descuentos_menu"><span class="glyphicon glyphicon-circle-arrow-down"></span> Descuentos</a> 
                            </li>

                            <li class="liDesp">
                                <a id="despegable2" href="<?= base_url();?>index.php/Descuentos/pagos_menu"><span class="glyphicon glyphicon-folder-close"></span> Pagos</a>
                            </li>
                            <?php } ?>
                            <?php if(isset($this->data["seccion_33"]) or isset($this->data["seccion_155"]) or isset($this->data["seccion_156"]) or isset($this->data["seccion_157"]) or isset($this->data["seccion_158"]) or isset($this->data["seccion_159"]) or isset($this->data["seccion_160"])){  ?>
                            <li class="liDesp">
                                <a id="despegable2" href="<?= base_url();?>index.php/Descuentos/procesos_poduccion"><span class="glyphicon glyphicon-cog"></span> Producción</a>
                            </li>
                            <?php } ?>
                        </ul>

                    </li>

                    <?php } ?>
                    
                    <?php if(isset($this->data["seccion_130"]) or isset($this->data["seccion_131"]) or isset($this->data["seccion_132"])){  ?>
                     <li <?php if($activo=="Contabilidad"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/Contabilidad/">Contabilidad</a></li>
                     <?php } ?>
                     <?php if(isset($this->data["seccion_179"])){  ?>

                     <li class="dropdown <?php if($activo=="examen"){ ?>active<?php } ?>">
                        <!--<a href="<?= base_url();?>index.php/Mantenimiento/">Mantenimientos</a>-->
                        <a id="secDes" href="#" class="dropdown-toggle" data-toggle="dropdown" >Exámenes <span class="glyphicon glyphicon-chevron-down"></span></a>
                        <ul class="dropdown-menu" id="ulDes">
                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/Empleado/ver_examenes"><span class="glyphicon glyphicon-inbox"></span> Realizar examen</a>
                            </li>
                            <li class="liDesp">
                                <a id="despegable" href="<?= base_url();?>index.php/Empleado/control_examenes"><span class="glyphicon glyphicon-inbox"></span> Control exámenes</a>
                            </li>
                        </ul>
                        
                    </li>
                    <?php } ?>

                     <li <?php if($activo=="Tesoreria_menu"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>index.php/Tesoreria/Tesoreria_menu">Tesoreria</a></li>
            
     

                <!-- <li <?php if($activo=="HCapacitacion"){ ?>class="active"<?php } ?>><a href="<?= base_url();?>  index.php/capacitacion/historial">Historial de capacitaciones</a></li> -->
                <li ><a href="<?= base_url();?>index.php/iniciar/logout">Cerrar sesion</a></li>
            </ul>
<br><br><br>
</div>
    <br>
    
<script type="text/javascript">
    $(document).ready(function(){
        //Save agencia
 $('#save_agn_controllers').on('click',function(){
            //var product_code = $('#product_code').val();
            var actual_pass = $('#actual_pass').val();
            var nueva_pass = $('#nueva_pass').val();
            var repetir_pass  = $('#repetir_pass').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Base/cambiar_contra')?>",
                dataType : "JSON",
                data : { actual_pass:actual_pass, nueva_pass:nueva_pass , repetir_pass:repetir_pass},
                success: function(data){
                    //$('[name="product_code"]').val("");
                    $('[name="actual_pass"]').val("");
                    $('[name="nueva_pass"]').val("");
                    $('[name="repetir_pass"]').val("");
                    $('#Modal_pass').modal('toggle');
                    $('.modal-backdrop').remove();
                    this.disabled=false;
                            alert("Contraseña cambiada correctamente");
               },  
                error: function(data){
                    this.disabled=false;
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

        if(control_mate == 1){    
            maternidad();
        }
        function maternidad(){
                
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/notiMaternidad')?>",
                dataType : "JSON",
                data : {},
                success: function(data){
                    console.log(data);
                    if(data[0].conteo > 0){
                        document.getElementById('notificacionMate').innerHTML = data[0].conteo;
                           
                    }   
                },
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };

       //function show all product
        function show_contra(){
        }

            });

</script>

<!-- MODAL ADD -->
<form>
            <div class="modal fade" id="Modal_pass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cambiar contraseña</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
    

                    
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Contraseña actual:</label>
                            <div class="col-md-10">
                              <input type="password" name="actual_pass" id="actual_pass" class="form-control" placeholder="contraseña vieja">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Contraseña nueva:</label>
                            <div class="col-md-10">
                            <input type="password" name="nueva_pass" id="nueva_pass" class="form-control" placeholder="Contraseña nueva">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Repetir contraseña:</label>
                            <div class="col-md-10">
                              <input type="password" name="repetir_pass" id="repetir_pass" class="form-control" placeholder="Repetir contraseña nueva">
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                    <button type="button" type="submit" id="save_agn_controllers" class="btn btn-primary">Guardar</button>

                  </div>
                </div>
              </div>
            </div>
            </form>
<!--END MODAL ADD-->

