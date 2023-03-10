<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Asignacion de Agencias</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <?php if($crear == 1){ ?>
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <a  class="btn btn-success crear ocultar" id="btn_insertar"><span class="fa fa-plus"></span> Crear nueva Asignacion</a>
                            </div>
                            
                        </div>
                    </div>
                </nav>
                <?php } ?>

                <table class="table table-striped table-bordered" id="mydata">
                    <thead>
                        <tr class="success">
                            <th style="text-align:center;">Perfil</th>      
                            <th style="text-align:center;">Fecha</th>
                            <th style="text-align:center;">Nombre</th>
                            <th style="text-align:center;">Accion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for ($i=0; $i < count($datos) ; $i++) {
                           echo "<tr>";
                            echo "<td>".$datos[$i]->perfil."</td>";
                            echo "<td>".$datos[$i]->fecha_creacion."</td>";
                            echo "<td>".$datos[$i]->nombre."</td>";
                            echo "<td><a class='btn btn-primary btn-sm item_add' href='#'><span class='glyphicon glyphicon-search'></span> Ver</a> ";
                            echo "<a class='btn btn-success btn-sm item_add' data-codigo=".$datos[$i]->codigo." onclick='cargar_editar(this)'><span class='glyphicon glyphicon-pencil'></span> Editar</a></td>";
                           echo "</tr>";

                         } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
                
    </div>
</div>


<!-- Modal insertar-->
<div class="modal fade" id="insertar" role="dialog">
    <div class="modal-dialog modal-lg">    
        <!-- Modal content-->
        <div class="modal-content">
        
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title"><center>Crear asignacion</center></h3>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6"><div id="validacion" style="color:red"></div></div>
                    <div class="col-md-3"></div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Perfil:</label>
                    <div class="col-md-8">  
                        <select class='form-control' id='perfil' name='perfil'>
                            <?php
                                foreach($perfiles as $perfil){                             
                            ?>
                                <option  value="<?= ($perfil->id_perfil);?>"><?= $perfil->nombre;?></option>
                            <?php           
                                } 
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">  
                    </div>
                </div>  
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Usar:</label>
                    <div class="col-md-8">  
                        <select class='form-control' id='uso' name='uso'>
                            <option value="1">Regiones</option>
                            <option value="2">Jefes especiales</option>
                        </select>
                    </div>
                    <div class="col-md-2">  
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-md-2">  
                    <label>Nombre:</label>
                    </div>
                    <div class="col-md-8">  
                        <input type="text" name="nombre_asignacion" id="nombre_asignacion" class="form-control" placeholder="Region #">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-10">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <tr>
                                <td colspan="4"><center><strong>Agencias a asignar</strong></center></td>
                                <td colspan="5"> 
                                 
                                    <a id="check_all" style="text-decoration: none; cursor: pointer;">Marcar todos</a>
                                    /
                                    <a id="uncheck_all" style="text-decoration: none; cursor: pointer;">Desmarcar todos</a>
                             
                                </td>
                            </tr>
                            <?php 
                                $bandera=0;
                                for ($i=0; $i < count($agencias) ; $i++) { 
                                    if ($bandera==0) {
                                        echo  "<tr>";
                                    }
                                    echo  "<td style='text-align: left;' colspan='2'><div style='padding: 0.3em;'><input type='checkbox' name='checkbox_".$agencias[$i]->id_agencia."' id='checkbox_".$agencias[$i]->id_agencia."' class='mdl-checkbox__input' ><span class='mdl-checkbox__label'> ".$agencias[$i]->agencia."</span></div></td>";  

                                    if(($i+1)%5==0){
                                        echo "</tr>";
                                        $bandera=0;
                                    }
                            $bandera++;
                            } ?>
                      
                        </table>
                    </div>
                </div>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="insertar()"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><span class="  fa fa-times"></span> Cancelar</button>
            </div>
        </div>
    </div>
</div>
<!--fin insertar-->

<div class="modal fade" id="editar" role="dialog">
    <div class="modal-dialog modal-lg">    
        <!-- Modal content-->
        <div class="modal-content">
        
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Editar asignacion</h4>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                      <div id="validacion" style="color:red"></div>
                      <div id="validacion2" style="color:red"></div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Perfil:</label>
                    <div class="col-md-8">  
                        <select class='form-control' disabled id='perfil_edit' name='perfil_edit'>
                            
                        </select>
                    </div>

                    <div class="col-md-2">  
                    </div>
                </div>  
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Usar:</label>
                    <div class="col-md-8">  
                        <select class='form-control' disabled id='usar_edit' name='usar_edit'>
                            
                        </select>
                    </div>
                    
                    <div class="col-md-2">  
                    </div>
                </div> 
                <div class="form-group row">
                    <div class="col-md-2">  
                        <label>Nombre:</label>
                    </div>
                    <div class="col-md-8">  
                        <input type="text" disabled name="nombre_asignacion" id="nombre_asignacion" class="form-control" placeholder="Region #">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-10">
                        <table class="table table-striped table-bordered" style="width:100%">
                            <tr>
                              <td colspan="4"><center><strong>Agencias a asignar</strong></center></td>
                              <td colspan="5"> 
                                <a id="check_all_ed" style="text-decoration: none; cursor: pointer;">Marcar todos</a>
                                /
                                <a id="uncheck_all_ed" style="text-decoration: none; cursor: pointer;">Desmarcar todos</a>
                              </td>
                            </tr>
                            <?php 
                                $bandera=0;
                                for($i=0; $i < count($agencias) ; $i++){ 
                                    if($bandera==0) {
                                        echo  "<tr>";
                                    }
                                    echo  "<td style='text-align: left;' colspan='2'><div style='padding: 0.3em;'><input type='checkbox' name='ed_checkbox_".$agencias[$i]->id_agencia."' id='ed_checkbox_".$agencias[$i]->id_agencia."' class='mdl-checkbox__input editar_check'><span class='mdl-checkbox__label'> ".$agencias[$i]->agencia."</span></div></td>";  

                                    if(($i+1)%5==0){
                                        echo "</tr>";
                                        $bandera=0;
                                    }
                                    $bandera++;
                                } ?>
                      
                        </table>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="editar()">Editar</button>

                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
      
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        $('#mydata').dataTable({
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

        $("#btn_insertar").click(function(){
            document.getElementById('validacion').innerHTML = '';
            $("#insertar").modal();
       })
    });

    document.getElementById('check_all').addEventListener("click", function() {
                   
        <?php for ($i=0; $i < count($agencias) ; $i++) { ?>
            var checkbox = document.getElementById("checkbox_<?php echo $agencias[$i]->id_agencia ?>");
            if (checkbox.checked == false) {
              checkbox.click();
            }
        <?php } ?>
    });

    document.getElementById('uncheck_all').addEventListener("click", function() {
                   
        <?php for ($i=0; $i < count($agencias) ; $i++) { ?>
            var checkbox = document.getElementById("checkbox_<?php echo $agencias[$i]->id_agencia ?>");
            if (checkbox.checked == true) {
              checkbox.click();
            }
        <?php } ?>
    });

    function insertar(){
        var nombre_asignacion = document.getElementById("nombre_asignacion").value;
        var perfil = document.getElementById("perfil").value;
        var uso = document.getElementById("uso").value;

        valores = new Array();

        agencias = <?php echo json_encode($agencias); ?>;

        contador=0;
        for (var n=0; n<agencias.length;n++){
            checkboxes = document.getElementsByName('checkbox_'+agencias[n].id_agencia);//nombre generico de los check
            console.log(checkboxes);
            if (checkboxes[0].checked){
                valores[contador]=agencias[n].id_agencia;

                contador++;
            }
        }

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/insertar_asignacion')?>",
            dataType : "JSON",
            data : {valores:valores,nombre_asignacion:nombre_asignacion,perfil:perfil,uso:uso},
            success: function(data){
                console.log(data);
                if(data == null){
                    location.reload();
                }else{
                    document.getElementById('validacion').innerHTML = '';
                    for(var i = 0; i < data.length; i++){
                        document.getElementById('validacion').innerHTML += data[i];
                    }
                }
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    function cargar_editar(boton){
        //agencias = <?php echo json_encode($agencias); ?>;
        var codigo = boton.dataset.codigo;
        
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/cargar_editar_asignacion')?>",
            dataType : "JSON",
            data : {codigo:codigo},
            success: function(data){
                console.log(data);
                $("#perfil_edit").empty();
                $("#usar_edit").empty();
                $("#nombre_asignacion").empty();

                $("#perfil_edit").append('<option selected  value='+data[0].id_perfil+' >'+data[0].perfil+'</option>');
                $("#usar_edit").append('<option selected  value='+data[0].estado+' >'+data[0].uso+'</option>');
                $('[name="nombre_asignacion"]').val(data[0].nombre);

                n=0;
                $('.editar_check').prop('checked',false);
                    for (var j = 0; j < data.length; j++) {
                     $('#ed_checkbox_'+data[j].id_agencia).prop('checked',true);
                    }

            },
            error: function(data){
              var a =JSON.stringify(data['responseText']);
              alert(a);
            }
        });
        $("#editar").modal();
    }

    document.getElementById('check_all_ed').addEventListener("click", function() {
                   
        <?php for ($i=0; $i < count($agencias) ; $i++) { ?>
            var checkbox = document.getElementById("ed_checkbox_<?php echo $agencias[$i]->id_agencia ?>");
            if (checkbox.checked == false) {
              checkbox.click();
            }
        <?php } ?>
    });

    document.getElementById('uncheck_all_ed').addEventListener("click", function() {
                   
        <?php for ($i=0; $i < count($agencias) ; $i++) { ?>
            var checkbox = document.getElementById("ed_checkbox_<?php echo $agencias[$i]->id_agencia ?>");
            if (checkbox.checked == true) {
              checkbox.click();
            }
        <?php } ?>
    });
</script>
</body>
</html>