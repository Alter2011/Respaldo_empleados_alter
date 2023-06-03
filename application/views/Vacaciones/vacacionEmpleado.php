<style type="text/css">
    #centrado {text-align: center;}
    .principal > #centrado{
        margin: 15px;
        text-align: center;
    }
</style>
<input type="hidden" name="permiso" id="permiso" value="<?php echo  $reporte; ?>" readonly>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Historia de Vacaciones</h2>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="row" id="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <?php if($aprobar == 1 || $reporte == 1 ){ ?>
                        <?php if(isset($_SESSION['mensaje_exito'])){ ?>
                            <div id="validacion" class="alert alert-success" role="alert" style="text-align:center;">
                                <?php echo $_SESSION['mensaje_exito'];?>     
                            </div>
                        <?php } ?>
                        <form action="<?php echo base_url("index.php/Vacaciones/empleados_vacacion"); ?>" method="POST" enctype="multipart/form-data">
                            <div class="principal" id="principal" style="margin-top: 10px">
                                <div class="row" id="centrado">
                                    <?php if($admin == 1){ ?>
                                    <div class="col-sm-3" style="text-align: center;">
                                        <label for="inputState">Vacaciones de</label>
                                            <select class="form-control" name="agencia_aprobar" id="agencia_aprobar" class="form-control">
                                                <option value="1">Todos</option>
                                                <option value="2">Administración</option>
                                            </select>
                                    </div>
                                    <?php } ?>
                                    <div class="col-sm-3" style="text-align: center;">
                                        <label for="inputState">Quincena</label>
                                            <select class="form-control" name="quin_aprobar" id="quin_aprobar" class="form-control">
                                                <option value="1">Primera Quincena</option>
                                                <option value="2">Segunda Quincena</option>
                                            </select>
                                    </div>
                                    <div class="col-sm-3" style="text-align: center;">
                                        <label for="inputState">Mes de vacación</label>
                                        <input type="month" class="form-control" id="mes_aprobar" name="mes_aprobar" value="<?php echo date('Y-m')?>">
                                    </div>
                                    <div class="col-sm-3" style="text-align: center;">
                                        <br><button class="btn btn-danger" id="btn_bienes" data-toggle="modal" data-target="#Modal_aprobar_vaca"><span class="glyphicon glyphicon-share"></span> Generar vacaciones</button><br><br>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <hr style="border: 0; border-top: 4px double #5D6D7E; width: 95%;">
                        <?php } ?>

                        <div class="panel-body">
                          <?php if($reporte == 1 || $control == 1 || $agendar == 1)   { ?>
                          <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados</a></li>
                            <?php if($reporte == 1){?>
                                <li><a data-toggle="tab" href="#menu1" id="pag2">Reporte</a></li>
                            <?php }  ?>
                            <?php if($control == 1){ ?>
                                <li><a data-toggle="tab" href="#menu2" id="pag3">Control vacaciones</a></li>
                            <?php } ?>

                            <!-- NO27042023 -->
                            <?php if($agendar == 1){ ?>
                                <li><a data-toggle="tab" href="#menu3" id="pag4">Agendar vacaciones</a></li>
                            <?php } ?>
                            <?php if($guardar_vacaciones == 1){ ?>
                                <li><a data-toggle="tab" href="#menu4" id="pag5">Aprobar vacaciones</a></li>
                            <?php } ?>
                              <!-- NO27042023 -->

                          </ul>  
                          <?php } ?>

                          <div class="tab-content">
                            <div id="home" class="tab-pane fade in active"><br>
                                <nav class="float-right">
                                    <div class="col-sm-10">
                                    <div class="form-row" id='agencias'>
                                    <?php if($ver==1) { ?>
                                        <div class="form-group col-md-3">
                                            <label for="inputState">Agencia</label>
                                            <select class="form-control" name="agencia_prestamo" id="agencia_prestamo" class="form-control">
                                                 <?php
                                                    $i=0;
                                                    foreach($agencia as $a){
                                                ?>
                                                    <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                                <?php
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        
                                        <?php }else{ ?>

                                        <input type="hidden" name="agencia_prestamo" id="agencia_prestamo" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                                        <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                </nav>
                                <table class="table table-bordered" id="mydata">
                                    <thead>
                                        <tr class="success">
                                           <th style="text-align:center;">Nombre</th> 
                                           <th style="text-align:center;">Apellido</th> 
                                           <th style="text-align:center;">DUI</th> 
                                           <th style="text-align:center;">Cargo</th>
                                           <th style="text-align:center;">Accion</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="tabla1">
                                       
                                    </tbody> 
                                </table>
                            </div>

                            <div id="menu1" class="tab-pane fade"><br>
                                <div class="form-row" style="display: none;" id="reporte">

                                    <div class="form-group col-md-2">
                                        <label for="inputState">Empresa</label>
                                        <select class="form-control" name="empresa_vacacion" id="empresa_vacacion" class="form-control">
                                            <option value="todo">Todas</option>
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

                                <div class="form-row" style="display: none;" id="reporte2">
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_vacacion" id="agencia_vacacion" class="form-control">
                                            
                                        </select>
                                                    
                                        
                                    </div>
                                </div>

                                <div class="form-row" style="display: none;" id="reporte3">
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Mes de Vacacion</label>
                                        <input type="month" class="form-control" id="mes_vacacion" name="mes_vacacion" value="<?php echo date('Y-m')?>">
                                    </div>
                                </div>

                                <div class="form-row" style="display: none;" id="reporte4">
                                    <div class="form-group col-md-2">
                                        <label for="inputState">Quincena</label>
                                        <select class="form-control" name="num_vacacion" id="num_vacacion" class="form-control">
                                            <option value="todo">Todas</option>
                                            <option value="1">Primera Quincena</option>
                                            <option value="2">Segunda Quincena</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row" style="display: none;" id="reporte5">
                                    <div class="form-group col-md-2">
                                        <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                                    </div>
                                </div>
                                
                                <table class="table table-striped" id="mydatos">
                                    <thead>
                                        <tr>
                                           <th style="text-align:center;">Agencia</th> 
                                           <th style="text-align:center;">Nombre</th> 
                                           <th style="text-align:center;">DUI</th> 
                                           <th style="text-align:center;">Cargo</th>
                                           <th style="text-align:center;">Monto(Sin Des)</th> 
                                           <th style="text-align:center;">ISSS</th> 
                                           <th style="text-align:center;">AFP</th> 
                                           <th style="text-align:center;">ISR</th> 
                                           <th style="text-align:center;">Monto</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="tabla2">
                                        
                                    </tbody> 
                                </table>
                            </div><!--Fin menu1-->

                            <div id="menu2" class="tab-pane fade"><br>


                                <div class="form-row" id="reporte_vacacion">

                                <div class="form-group col-md-2">
                                    <label for="inputState">Empresa</label>
                                    <select class="form-control" name="empresa_vaca" id="empresa_vaca" class="form-control">
                                        <option value="todo">Todas</option>
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

                            <div class="form-row" id="reporte_agencia">
                                <div class="form-group col-md-2">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia" id="agencia" class="form-control">
                                        
                                    </select>
                                                
                                    
                                </div>
                            </div>

                            <div class="form-row" id="año">
                                <div class="form-group col-md-2">
                                    <label for="inputState">Año</label>

                                    <?php $cont = date('Y'); ?>
                                    <select class="form-control" name="año_vaca" id="año_vaca" class="form-control">
                                    <?php while ($cont >= 2010) { ?>
                                        <option value="<?php echo($cont); ?>"><?php echo($cont); ?></option>
                                    <?php $cont = ($cont-1); } ?>
                                    </select>                   
                                    
                                </div>
                            </div>

                            <div class="form-row" id="btn_aceptar">
                                <div class="form-group col-md-2">
                                    <center><a id="filtro_vacacion" class="btn btn-primary btn-sm item_filtrar_dia" style="margin-top: 23px;">Aceptar</a></center>
                                </div>
                            </div>
                                <table class="table table-striped table-bordered" id="tb_vacacion">
                                <thead>
                                    <tr class="success">
                                         <th style="text-align:center;">Agencia</th> 
                                         <th style="text-align:center;">Nombre</th>  
                                         <th style="text-align:center;">Días Ganados</th>  
                                         <th style="text-align:center;">Días Utilizados</th>  
                                         <th style="text-align:center;">Horas Utilizadas</th>
                                         <th style="text-align:center;">Días Adelantados</th>
                                         <th style="text-align:center;">Horas Adelantadas</th>  
                                         <th style="text-align:center;">Tiempo disponible</th>  
                                         <th style="text-align:center;">Detalle</th> 
                                    </tr>
                                </thead>
                                <tbody class="tabla4">
                                                    
                                </tbody> 
                            </table>
                            </div><!--Fin menu2-->



<div id="menu3" class="tab-pane fade"><br>
<div class="form-row" id="reporte_vacacion">

</div>

<div class="form-row" id="reporte_agencia">
<div class="form-group col-md-3">
        <label for="inputState">Agencia</label>
        <?php if($ver){ ?>
            <select class="form-control" name="agencia_agendar" id="agencia_agendar" class="form-control">
            <?php
            $i=0;
            foreach($agencia as $a){
            ?>
            <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
            <?php
            $i++;
            }
            ?>
            </select>
            <?php }else{ ?>
                <input type="hidden" name="agencia_agendar" id="agencia_agendar" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

            <?php }?>                
                                       
</div>
</div>

<div class="form-row" id="año">
<div class="form-group col-md-2">
    <label for="inputState">Año</label>

    <?php $cont = date('Y'); ?>
    <select class="form-control" name="anio_agendar" id="anio_agendar" class="form-control">
    <?php while ($cont >= 2010) { ?>
        <option value="<?php echo($cont); ?>"><?php echo($cont); ?></option>
    <?php $cont = ($cont-1); } ?>
    </select>                   
    
</div>
</div>

<div class="form-row" id="btn_aceptar">
<div class="form-group col-md-2">
    <center><a id="filtro_vacacion" class="btn btn-primary btn-sm item_filtrar_dia" style="margin-top: 23px;" onclick="setData()">Aceptar</a></center>
</div>
</div>
<table class="table table-striped table-bordered" id="agendar_vacacion">
<thead>
    <tr class="success">
         <th style="text-align:center;">Nombre</th> 
         <th style="text-align:center;">Apellido</th>  
         <th style="text-align:center;">Accion</th>  

    </tr>
</thead>
<tbody class="tablaagendar">
                    
</tbody> 
</table>
</div><!--Fin menu3-->

<div id="menu4" class="tab-pane fade"><br>
<div class="form-row" id="reporte_vacacion">

</div>

<div class="form-row" id="reporte_agencia">
<div class="form-group col-md-3">
        <label for="inputState">Agencia</label>
            <select class="form-control" name="agencia_guardar" id="agencia_guardar" class="form-control">
            <?php
            $i=0;
            foreach($agencia as $a){
            ?>
            <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
            <?php
            $i++;
            }
            ?>
            </select>
                                        
                                       
</div>
</div>

<div class="form-row" id="año">
<div class="form-group col-md-2">
    <label for="inputState">Año</label>

    <?php $cont = date('Y'); ?>
    <select class="form-control" name="anio_vaca_guardar" id="anio_vaca_guardar" class="form-control">
    <?php while ($cont >= 2010) { ?>
        <option value="<?php echo($cont); ?>"><?php echo($cont); ?></option>
    <?php $cont = ($cont-1); } ?>
    </select>                   
    
</div>
</div>

<div class="form-row" id="btn_aceptar">
<div class="form-group col-md-2">
    <center><a id="filtro_vacacion" class="btn btn-primary btn-sm item_filtrar_dia" style="margin-top: 23px;" onclick="showAceptar()">Aceptar</a></center>
</div>
</div>
<table class="table table-striped table-bordered" id="guardar_vacacion">
<thead>
    <tr class="success">
    <th style="text-align:center;">Nombre</th> 
    <th style="text-align:center;">Apellido</th>  
    <th style="text-align:center;">Fecha de aplicacion</th>  
    <th style="text-align:center;">Accion</th>  

    </tr>
</thead>
<tbody class="tabla_guardar">
                    
</tbody> 
</table>
</div><!--Fin menu4-->





                          </div>

                        </div>
                </div>

            </div>
    
            </div>

        </div>
    </div>
</div>
<!-- INICIO MODAL AGREGAR VACACION -->
<div class="modal fade" id="modal_agendar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agendar vacaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                <div class="form-group">
                        <label for="horas">Fecha aplicacion:</label>
                        <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        <input type="hidden" name="id_contrato" id="id_contrato">
                        <input type="hidden" name="id_empleado" id="id_empleado">
                        <input type="hidden" name="fecha_inicio_empleado" id="fecha_inicio_empleado">
                    </div>
                    
                </div>
                <div class="modal-footer">
                <input type="hidden" name="aprobacion_code" id="aprobacion_code" class="form-control" readonly>
                <input type="hidden" name="aprobacion_empleado" id="aprobacion_empleado" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary" onclick="send_agendar()">Agendar</button>
                </div>
            </div>
        </div>
    </div>
<!-- FIN MODAL AGREGAR VACACION -->


<!-- INICIO MODAL APROBAR VACACION -->
<div class="modal fade" id="modal_aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobar vacaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                <strong>¿Seguro que desea aprobar estas vacaciones?</strong>
                <input type="hidden" name="id_vacacion" id="id_vacacion">
                <input type="hidden" name="id_empleado" id="id_empleado">
                </div>
                <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary" onclick="send_aprobar()">Aprobar</button>
                </div>
            </div>
        </div>
    </div>
<!-- FIN MODAL APROBAR VACACION -->
    </div>
    <!-- INICIO MODAL Eliminar VACACION -->
<div class="modal fade" id="modal_eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar vacaciones</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                <div class="form-group">
                <strong>¿Seguro que desea eliminar estas vacaciones?</strong>
                <input type="hidden" name="id_vacacion" id="id_vacacion_eliminar">
                </div>
                <div class="modal-footer">
               
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary" onclick="cancelar_vacacion()">Aprobar</button>
                </div>
            </div>
        </div>
    </div>
<!-- FIN MODAL Eliminar VACACION -->

<!-- Llamar JavaScript -->

<script type="text/javascript">
    //NO27042023
    function eliminar_vacacion(id_vacacion){
        console.log(id_vacacion)
        $("#id_vacacion_eliminar").val(id_vacacion)
        $("#modal_eliminar").modal('show')
    }
    function cancelar_vacacion(){
        let id_vacacion = $("#id_vacacion_eliminar").val()
        $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('vacaciones/cancelar_vacacion')?>',
                dataType : 'JSON',
                data : {id_vacacion:id_vacacion},
                success : function(data){
                   console.log(data)
                   if(data == null){
                    alert('ingresado')
                        location.reload()
                    }else{
                        alert('fallo')
                    
                   }                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
    }



    function send_aprobar(){
        let id_vacacion = $("#id_vacacion").val()
        let id_empleado = $("#id_empleado").val()
        $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('vacaciones/save_vacacion')?>',
                dataType : 'JSON',
                data : {id_vacacion:id_vacacion, id_empleado:id_empleado},
                success : function(data){
                   console.log(data)
                   if(data == null){
                    alert('ingresado')
                        location.reload()
                    }else{
                        alert('fallo')
                    
                   }                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
    }
    function aprobar_vacacion(id_vacacion, id_empleado){
        // console.log(id_vacacion, id_empleado)
        $("#id_vacacion").val(id_vacacion)
        $('#id_empleado').val(id_empleado)
        $("#modal_aprobar").modal('show')
        
    }
    function showAceptar(){
        $('#guardar_vacacion').dataTable().fnDestroy();
        $('.tabla_guardar').empty()
        let agencia = $("#agencia_guardar").val()
        let anio = $("#anio_vaca_guardar").val()
        let accion = ""
        $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('vacaciones/get_empleados_vacacion_inactiva')?>',
                dataType : 'JSON',
                data : {agencia:agencia, anio:anio},
                success : function(data){
                //    console.log(data)
                    $.each(data,function(key, registro){
                        if(registro.aprobado == 0){
                                accion = "<td ><a class='btn btn-danger' style='margin-right:5px' onclick='eliminar_vacacion("+registro.id_vacacion+")'>Eliminar vacacion</a><a class='btn btn-success' onclick='aprobar_vacacion("+registro.id_vacacion+","+registro.id_empleado+")'>Aprobar vacacion</a></td>"
                            }else{
                                accion = "<td><p class='success'>Vacacion agendada</p></td>"
                            }
                        
                        $('.tabla_guardar').append(
                           
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.apellido+'</td>'+
                                '<td>'+registro.fecha_aplicacion+'</td>'+
                                
                                  accion+
                               
                                '</tr>'
                        );
                   });
                //Se genera la paguinacion cada ves que se ejeucuta la funcion
                   $('#guardar_vacacion').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 10,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
                });
                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
    }
    function showAgendar(e){
        console.log(e)
        let id_contrato = e.dataset.id_contrato
        let id_empleado = e.dataset.id_empleado
        let fecha_inicio_empleado = e.dataset.id_empleado
        $("#id_empleado").val(id_empleado)
        $("#id_contrato").val(id_contrato)
        $("#fecha_inicio_empleado").val(fecha_inicio_empleado)
        $("#modal_agendar").modal('show')
       

    }
    function send_agendar(){
        let id_empleado = $("#id_empleado").val()
        let id_contrato =   $("#id_contrato").val()
        let fecha_inicio = $("#fecha_inicio").val()
        let fecha_inicio_empleado = $("#fecha_inicio_empleado").val()
        let agencia = $("#agencia_agendar").val()
        $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('vacaciones/agendar_vacacion')?>',
                dataType : 'JSON',
                data : {id_contrato:id_contrato, fecha_inicio:fecha_inicio, id_empleado:id_empleado, fecha_inicio_empleado:fecha_inicio_empleado, agencia:agencia},
                success : function(data){
                    // console.log(data)
                    if(data == null){
                        alert('ingresado')
                        location.reload()
                    }else{
                        alert('fallo')
                    }
                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
    }
    function setTodayDate(){
    // obtener el elemento de entrada de fecha
    const inputStart = document.getElementById("fecha_inicio");
    const inputEnd = document.getElementById("fecha_fin");
    
    // crear una fecha actual
    const today = new Date();
    
    // formatear la fecha en formato yyyy-MM-dd
    const year = today.getFullYear();
    const month = (today.getMonth() + 1).toString().padStart(2, "0");
    const day = today.getDate().toString().padStart(2, "0");
    const formattedDate = `${year}-${month}-${day}`;
    
    // establecer el valor mínimo en la entrada de fecha para evitar fechas anteriores
    inputStart.setAttribute("min", formattedDate);
   
    
    // establecer el valor de la entrada de fecha como la fecha actual
    inputStart.value = formattedDate;
    
}

    function setData(){
        $('#agendar_vacacion').dataTable().fnDestroy();
        $('.tablaagendar').empty()
        let agencia = $("#agencia_agendar").val()
        let anio = $("#anio_agendar").val()
       
        $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('vacaciones/get_empleados_vacacion')?>',
                dataType : 'JSON',
                data : {agencia:agencia, anio:anio},
                success : function(data){
                //    console.log(data)
                // WM01062023 se modifico para obtenga datos de empleadosAgendar
                   $.each(data.empleadosAgendar,function(key, registro){
                        $('.tabla5').empty()
                        $('.tablaagendar').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.apellido+'</td>'+
                                
                                '<td style="text-align:center;">'+
                                   '<a  class="btn btn-success btn-sm" data-id_contrato = '+registro.id_contrato+' data-id_empleado='+registro.id_empleado+' data-fecha_inicio = '+registro.fecha_inicio+' onclick="showAgendar(this)">Agendar vacacion</a>'+                                   
                                '</td>'+
                                '</tr>'
                        );
                   });

                //Se genera la paguinacion cada ves que se ejeucuta la funcion
                   $('#agendar_vacacion').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 10,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
                });
                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        
        
       
    }


    $(document).ready(function(){
        //NO27042023
        setTodayDate()


       var permiso = $('#permiso').val();
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_prestamo').change(function(){

            show_data();
        });
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/empleados_vaca')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.apellido+'</td>'+
                                '<td>'+registro.dui+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td style="text-align:center;">'+
                                   '<a href="<?php echo base_url();?>index.php/Vacaciones/verHistorial/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Historial</a>'+
                                   ' <?php if($registrar==1){ ?><a href="<?php echo base_url();?>index.php/Vacaciones/calendario/'+registro.id_empleado+'" class="btn btn-success btn-sm">Registro de Vacacion</a><?php } ?>'+                                   
                                '</td>'+
                                '</tr>'
                        );
                   });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#mydata').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 10,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };


        $('#pag1').on('click',function(){
            $("#agencias").show();
            $("#reporte").hide();
            $("#reporte2").hide();
            $("#reporte3").hide();
            $("#reporte4").hide();
            $("#reporte5").hide();
            $("#reporte_dia").hide();
            $("#reporte_dia2").hide();
            $("#reporte_dia3").hide();
            $("#reporte_dia4").hide();
            show_data()
        });

        $('#pag2').on('click',function(){
            $("#agencias").hide();
            $("#reporte").show();
            $("#reporte2").show();
            $("#reporte3").show();
            $("#reporte4").show();
            $("#reporte5").show();
            $("#reporte_dia").hide();
            $("#reporte_dia2").hide();
            $("#reporte_dia4").hide();
            $("#reporte_dia3").hide();
            reporteVacacion();
            
        });//fin $('#pag2').on('click',function()

        $('#pag3').on('click',function(){
            controlVacaciones();
        });
        $('#pag4').on('click',function(){
            setData();
        });
        $('#pag5').on('click',function(){
            showAceptar();
        });

        

        $('#filtrar').on('click',function(){
            reporteVacacion();
            
        });


        function reporteVacacion(){
            var cantidad = 0;
            var sinDes = 0;
            var isss = 0;
            var afp = 0;
            var empresa = $('#empresa_vacacion').children(":selected").attr("value");
            var agencias = $('#agencia_vacacion').children(":selected").attr("value");
            var mes = $('#mes_vacacion').val();
            var quincena = $('#num_vacacion').val();


            $('#mydatos').dataTable().fnDestroy();
            
            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Vacaciones/empleadosVa')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencias:agencias,mes:mes,quincena:quincena},
                success : function(data){
                    console.log(data);
                   $.each(data,function(key, registro){
                    cantidad = registro.cantidad_apagar - registro.afp_ipsfa - registro.isss - registro.isr;
                    sinDes = registro.cantidad_apagar;
                    isss = registro.isss;
                    afp = registro.afp_ipsfa;
                    isr = registro.isr;

                    if(cantidad > 0){
                        $('.tabla2').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                '<td>'+registro.dui+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>$'+parseFloat(sinDes).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(isss).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(afp).toFixed(2)+'</td>'+
                                '<td>$'+parseFloat(isr).toFixed(2)+'</td>'+
                                '<td>$'+cantidad.toFixed(2)+'</td>'+
                            '</tr>'
                        );
                    }
                   });
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
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        }

        if(permiso == 1){
            agencia();
        }

        $("#empresa_vacacion").change(function(){
            if(permiso == 1){    
                agencia();
            }
        });

        function agencia(){
            var empresa = $('#empresa_vacacion').children(":selected").attr("value");
            $("#agencia_vacacion").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia_vacacion").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_vacacion").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_vacacion").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia_vacacion").attr('disabled','disabled');
                $("#agencia_vacacion").append('<option id="todas" value="todas">Todas</option>');
            }

         };




        if(permiso == 1){
            agencia_dias();
        }

    
        agencia_dias_vaca();
      

        $("#empresa_dia").change(function(){
            if(permiso == 1){    
                agencia_dias();
            }
        });

         $("#empresa_vaca").change(function(){
           
                agencia_dias_vaca();
            
        });

        function agencia_dias(){
            var empresa = $('#empresa_dia').children(":selected").attr("value");
            $("#agencia_dia").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia_dia").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_dia").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_dia").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia_dia").attr('disabled','disabled');
                $("#agencia_dia").append('<option id="todas" value="todas">Todas</option>');
            }
         };

         function agencia_dias_vaca(){
            var empresa = $('#empresa_vaca').children(":selected").attr("value");
            $("#agencia").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Vacaciones/mostrar_agencias')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia").attr('disabled','disabled');
                $("#agencia").append('<option id="todas" value="todas">Todas</option>');
            }
         };


         $('#filtro_vacacion').on('click',function(){
            controlVacaciones();
            
        });
    

         function controlVacaciones(){
            //Se usa para destruir la tabla 

            $('#tb_vacacion').dataTable().fnDestroy();
            
            var empresa = $('#empresa_vaca').children(":selected").attr("value");
            var agencia = $('#agencia').children(":selected").attr("value");
            var anio = $('#año_vaca').val();

            $('.tabla4').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Vacaciones/empleadoDias')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencia:agencia,anio:anio},
                success : function(data){
                    console.log(data);
                   $.each(data,function(key, registro){
                        $('.tabla4').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.ganados+'</td>'+
                                '<td>'+registro.utilizados+'</td>'+
                                '<td>'+registro.horas_usadas+'</td>'+
                                '<td>'+registro.anticipados+'</td>'+
                                '<td>'+registro.horas_anticipadas+'</td>'+
                                '<td>'+registro.tiempo_disponible+'</td>'+
                                '<td style="text-align:center;">'+
                                   '<a href="<?php echo base_url();?>index.php/Vacaciones/verDetalle/'+registro.id_empleado+'/'+anio+'" class="btn btn-primary btn-sm">Revisar</a>'+                              
                                '</td>'+
                            '</tr>'
                        );
                   });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#tb_vacacion').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };
         

    });
</script>
</body>

</html>