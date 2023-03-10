 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Bancos</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                <table id="id_amortizacion" class="table table-bordered table-striped">
                <a href="#" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Modal_Add" >Añadir Banco</a><br><br>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>numero de cuenta</th>
                            <th>Empresa asociada</th>
                            <th>Fecha creacion</th>
                            <th>Fecha modificacion</th>
                            <th>Acciones</th>
                        </tr>
                        <tbody>
                            <?php
                            for ($i=0; $i <count($bancos) ; $i++) { 
                                
                                echo "<tr>";
                                echo "<td id='nombre_banco'>".$bancos[$i]->nombre_banco."</td>";
                                echo "<td id='num_cuenta'>".$bancos[$i]->numero_cuenta."</td>";
                                echo "<td id='num_cuenta'>".$empresa[$i]."</td>";
                                echo "<td id='fecha_creacion'>".$bancos[$i]->fecha_creacion."</td>";
                                echo "<td id='fecha_modificacion'>".$bancos[$i]->fecha_modificacion."</td>";
                                echo '<td><button id="editar" data-toggle="modal" data-target="#Modal_Edit" onclick="llenar_bancos('.$bancos[$i]->id_banco.')" class="btn btn-info btn-sm item_edit">Editar</button>
                                    <button id="eliminar" data-toggle="modal" data-target="#Modal_Delete" onclick="llenar_bancos('.$bancos[$i]->id_banco.')" class="btn btn-danger btn-sm item_delete">Eliminar</button></td>';
                                echo "</tr>"; 
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
                    </div>
                </div>
            </div>
        </div>
<!-- MODAL ADD -->
        <form>
            <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <center><h3 class="modal-title" id="exampleModalLabel">Agregar Banco</h3></center>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                     </button>
                  </div>
                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Nombre del banco:</label>
                        <div class="col-md-6">
                            <input type="text" name="nombre_banco_crear"  id='nombre_banco_crear' class="form-control" autocomplete="off">
                            <div id="validacion" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Numero de cuenta:</label>
                        <div class="col-md-6">
                            <input type="text" name="num_cuenta_crear"  id='num_cuenta_crear' onkeypress='return event.charCode >= 45 && event.charCode <= 57' class="form-control" autocomplete="off" >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Empresa asignada:</label>
                        <div class="col-md-6">
                            <select class="form-control" name="empresa_banco" id="empresa_banco" class="form-control">
                            <option value="0">No asignar</option>
                                <?php
                                    $i=0;
                                    foreach($empresas as $a){
                                                        
                                ?>
                                    <option id="<?= ($empresas[$i]->id_empresa);?>" value="<?= ($empresas[$i]->id_empresa);?>"><?php echo($empresas[$i]->nombre_empresa);?></option>
                                <?php
                                    $i++;
                                    }
                                ?>
                            </select>
                        </div>
                    </div>

                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" type="submit" id="btn_agregar" onclick="crear_banco()" class="btn btn-primary">Guardar</button>
                    <?php
                       // }
                    ?>
                  </div>
                </div>
              </div>
            </div>
            </form>
<!--END MODAL ADD-->
<!--MODAL EDIT-->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modificar Banco</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group row">
            
                    <div class="col-md-10">
                        <input type="hidden" name="id_banco_edit" id="id_banco_edit" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre de Banco:</label>
                    <div class="col-md-6">
                        <input type="text" name="nombre_banco_edit"  id='nombre_banco_edit' class="form-control" autocomplete="off">
                        <div id="validacion_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Numero de cuenta:</label>
                    <div class="col-md-6">
                        <input type="text" name="num_cuenta_edit"  id='num_cuenta_edit' onkeypress='return event.charCode >= 45 && event.charCode <= 57' class="form-control" autocomplete="off">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Empresa asignada:</label>
                    <div class="col-md-6">
                        <select class="form-control" name="empresa_banco_edit" id="empresa_banco_edit" class="form-control">
                            <option value="0">No asignar</option>
                            <?php
                                $i=0;
                                foreach($empresas as $a){
                                                        
                            ?>
                                <option id="<?= ($empresas[$i]->id_empresa);?>" value="<?= ($empresas[$i]->id_empresa);?>"><?php echo($empresas[$i]->nombre_empresa);?></option>
                            <?php
                                $i++;
                                }
                            ?>
                        </select>
                    </div>
                </div> 

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" onclick="update_banco()" class="btn btn-primary">Modificar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->
<!--MODAL DELETE-->

<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar Asueto</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <strong>¿Seguro que desea eliminar?</strong>
            </div>
            <div class="modal-footer">
            <input type="hidden" name="id_banco_delete" id="id_banco_delete" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
            <button type="button" type="submit" id="btn_delete" onclick="delete_banco()" class="btn btn-primary">Si</button>
            </div>
        </div>
        </div>
    </div>
</form>

<!--END MODAL DELETE-->

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">


    $(document).ready(function(){
        $('#id_amortizacion').DataTable();
    });


   function crear_banco(){

        var nombre_banco = $('#nombre_banco_crear').val();
        var num_cuenta = $('#num_cuenta_crear').val();
        var empresa_banco = $('#empresa_banco').val();

        $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Bancos/crear_bancos')?>",
        dataType : "JSON",//de data quite puntu_garantias
        data : {nombre_banco:nombre_banco,num_cuenta:num_cuenta,empresa_banco:empresa_banco},
        success: function(data){
            if ((data==null)) {
                document.getElementById('validacion').innerHTML = '';
                Swal.fire(
                'Datos Agregados Correctamente!',
                '',
                'success'
                )
                setTimeout('document.location.reload()',1200);
                
            }else{
                    document.getElementById('validacion').innerHTML = '';
                    for (i = 0; i <= data.length; i++) {
                        if(data[i] == 1){
                            document.getElementById('validacion').innerHTML += "Ingrese nombre del banco";
                        }
                    }
                }
            },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
    };//fin de la funcion crear_banco

    function llenar_bancos(id){
        document.getElementById('validacion_edit').innerHTML = '';
        $('#id_banco_edit').val(id);
        $('#id_banco_delete').val(id); 
            <?php foreach ($bancos as $key => $value): ?>
                if ('<?=$value->id_banco; ?>'==id) {
                    $('#nombre_banco_edit').val('<?=$value->nombre_banco; ?>'); 
                    $('#num_cuenta_edit').val('<?=$value->numero_cuenta; ?>');
                    $('#empresa_banco_edit').val('<?=$value->id_empresa; ?>');
                }
            <?php endforeach ?> 
    }

     function update_banco(){
        var id_banco = $('#id_banco_edit').val();
        var nombre_banco = $('#nombre_banco_edit').val();
        var num_cuenta = $('#num_cuenta_edit').val();
        var empresa_banco = $('#empresa_banco_edit').val();

        $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Bancos/update_bancos')?>",
                dataType : "JSON",
                data : {id_banco:id_banco,nombre_banco:nombre_banco,num_cuenta:num_cuenta,empresa_banco:empresa_banco},
                success: function(data){
                    if ((data==null)) {
                        document.getElementById('validacion_edit').innerHTML = '';
                        Swal.fire(
                        'Datos Modificados Correctamente!',
                        '',
                        'success'
                        )
                        setTimeout('document.location.reload()',1200);

                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        for (i = 0; i <= data.length; i++) {
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Ingrese nombre del banco";
                            }
                        }
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
    }

     function delete_banco(){
        var id_banco= $('#id_banco_delete').val();
        $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Bancos/delete_bancos')?>",
                dataType : "JSON",
                data : {id_banco:id_banco},
                success: function(data){
                    if (data==null) {
                        document.getElementById('validacion_edit').innerHTML = '';
                        Swal.fire(
                        'Datos Eliminados Correctamente!',
                        '',
                        'error'
                        )
                        setTimeout('document.location.reload()',1200);
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
    }

</script>
</body>

</html>