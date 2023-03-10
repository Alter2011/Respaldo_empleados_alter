        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Cuenta Cargo/Abono</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">

                    <nav class="float-right" id='inCargo'>
                        <a class="btn btn-primary item_agregar_cargo">
                            <span class="fa fa-plus"></span> Agregar Nuevo
                        </a><?php ?><br><br>
                    </nav>

                    <nav class="float-right" id='inAbono' style="display: none;">
                        <a class="btn btn-primary item_agregar_abono">
                            <span class="fa fa-plus"></span> Agregar Nuevo
                        </a><?php ?><br><br>
                    </nav>

                <div class="panel panel-default">
                <div class="panel-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Cuentas de Cargo</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Cuentas de Abono</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_cargo" id="empresa_cargo" class="form-control">
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

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencias</label>
                                <select class="form-control" name="agencia_cargo" id="agencia_cargo" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-bordered" id="mydata" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">Agencia</th> 
                                        <th style="text-align:center;">Empresa</th> 
                                        <th style="text-align:center;">Descripcion</th> 
                                        <th style="text-align:center;">Cuenta Contable</th> 
                                        <th style="text-align:center;">Accion</th> 
                                    </tr>
                                </thead>
                                <tbody class="tabla1">
                                                  
                                </tbody> 
                            </table>
                        
                    </div>
                    <div id="menu1" class="tab-pane fade"><br><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_abono" id="empresa_abono" class="form-control">
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

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencias</label>
                                <select class="form-control" name="agencia_abono" id="agencia_abono" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar2" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>


                        <table class="table table-bordered" id="mydata2" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Empresa</th> 
                                    <th style="text-align:center;">Descripcion</th> 
                                    <th style="text-align:center;">Cuenta Contable</th> 
                                    <th style="text-align:center;">Accion</th> 
                                </tr>
                            </thead>
                            <tbody class="tabla2">
                                              
                            </tbody> 
                        </table>
                        
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

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Cuanta Contable de Cargo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Empresa:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="empresa_car" id="empresa_car" class="form-control">
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

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="agencia_car" id="agencia_car" class="form-control">
                            
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_car" id="aplica_car" class="form-control">
                            
                        </select>
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_car" id="cuenta_car" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL EDIT-->
<form>
    <div class="modal fade" id="Modal_Edit_C" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Cuanta Contable de Cargo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Empresa:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="empresa_edit_C" id="empresa_edit_C" class="form-control">
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

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="agencia_edit_C" id="agencia_edit_C" class="form-control">
                            
                        </select>
                        <input type="hidden" name="age" id="age" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_edit_C" id="aplica_edit_C" class="form-control">
                            
                        </select>
                        <input type="hidden" name="apl" id="apl" class="form-control" readonly>
                        <div id="validacion_Edit_C" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_edit_C" id="cuenta_edit_C" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2_Edit_C" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_updateC" class="btn btn-primary">Modificar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete_C" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Cuanta Contable de Cargo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar esta cuenta?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="cargo_code_delete" id="cargo_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete_C" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Abono" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Cuanta Contable de Abono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Empresa:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="empresa_abo" id="empresa_abo" class="form-control">
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

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="agencia_abo" id="agencia_abo" class="form-control">
                            
                        </select>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_abo" id="aplica_abo" class="form-control">
                            
                        </select>
                        <div id="validacion_abono" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_abo" id="cuenta_abo" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2_abono" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save_abono" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL EDIT-->
<form>
    <div class="modal fade" id="Modal_Edit_A" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Cuanta Contable de Abono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Empresa:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="empresa_edit_A" id="empresa_edit_A" class="form-control">
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

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="agencia_edit_A" id="agencia_edit_A" class="form-control">
                            
                        </select>
                        <input type="hidden" name="agen" id="agen" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_edit_A" id="aplica_edit_A" class="form-control">
                            
                        </select>
                        <input type="hidden" name="code_apl" id="code_apl" class="form-control" readonly>
                        <div id="validacion_Edit_A" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_edit_A" id="cuenta_edit_A" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2_Edit_A" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_updateA" class="btn btn-primary">Modificar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete_A" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Cuanta Contable de Abono</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar esta cuenta?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="abono_code_delete" id="abono_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete_A" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        agencia();
        $("#empresa_cargo").change(function(){
            agencia();
        });

        if(window.location.hash) {
            var hash = window.location.hash.substring(1);
            if(hash == 'pag2'){
                $("#inCargo").hide();
                $("#inAbono").show();
                agencia_abono();
                show_abono();
                $( "#pag2" ).click();
            }else{
                show_data();
            }
        }else{
            show_data();
        }
        
        $('#pag1').on('click',function(){
            show_data();
            $("#inCargo").show();
            $("#inAbono").hide();
         });
        $('.item_filtrar').on('click',function(){
            show_data();
        });

        function agencia(){
            var empresa = $('#empresa_cargo').children(":selected").attr("value");
            $("#agencia_cargo").empty();
            if(empresa != 'todas'){
                $("#agencia_cargo").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_cargo").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_cargo").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_cargo").attr('disabled','disabled');
                $("#agencia_cargo").append('<option id="todas" value="todas">Todas</option>');
            }
        };

        function show_data(){
            var estado = 1;
            var empresa = $('#empresa_cargo').children(":selected").attr("value");
            var agencia = $('#agencia_cargo').children(":selected").attr("value");

            console.log(agencia);
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contabilidad/cargo')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencia:agencia,estado:estado},
                success : function(data){
                    
                   $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//nombrePlaza
                            '<td>'+registro.descripcion+'</td>'+//estado
                            '<td>'+registro.cuenta_contable+'</td>'+//estado
                            '<td style="text-align:center;">'+
                            '<a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-codigo="'+registro.id_cuenta+'"> Editar </a>'+
                            ' <a  data-toggle="modal" class="btn btn-danger btn-sm item_deleteC" data-codigo="'+registro.id_cuenta+'"> Eliminar </a>'+
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
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                 "order": [[ 4, "asc" ]],
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }

        $('.item_agregar_cargo').click(function(){
            agencia_ingreso();
            llenar_aplica();
        });

        $("#empresa_car").change(function(){
            agencia_ingreso();
        });

        $("#agencia_car").change(function(){
            llenar_aplica();
        });

        function llenar_aplica(){
            var empresa_car = $('#empresa_car').children(":selected").attr("value");
            var agencia_car = $('#agencia_car').children(":selected").attr("value");
            $("#aplica_car").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/disCargo')?>",
                dataType : "JSON",
                data : {empresa_car:empresa_car,agencia_car:agencia_car},
                success: function(data){
                    $.each(data,function(key, registro) {
                        $("#aplica_car").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                    });
                    $('#Modal_Add').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
        };
         
        function agencia_ingreso(){
            var empresa = $('#empresa_car').children(":selected").attr("value");
            $("#agencia_car").empty();
                $("#agencia_car").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_car").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                            llenar_aplica();
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
        };
        //Metooo para e ingreso 
        $('#btn_save').on('click',function(){
            var empresa_car = $('#empresa_car').children(":selected").attr("value");
            var agencia_car = $('#agencia_car').children(":selected").attr("value");
            var descripcion = $('select[name="aplica_car"] option:selected').text();
            var aplica_car = $('#aplica_car').children(":selected").attr("value");
            var cuenta_car = $('#cuenta_car').val();
            var estado = 1;

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/saveCuentaCargo')?>",
                dataType : "JSON",
                data : {empresa_car:empresa_car,agencia_car:agencia_car,aplica_car:aplica_car,descripcion:descripcion,cuenta_car:cuenta_car,estado:estado},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';

                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de ingresar donde aplica la cuanta";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuanta";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML += "Esta cuenta ya existe, por favor ingrese una diferente";
                            }

                        }//Fin For
                    }//Fin if else
                                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;
                
        });//fin de insercionde

        //get data for update record
        //$('#row').on('click','.item_edit',function(){ 
        $(document).on( "click",".item_edit", function(event){
        //function editarC(){
            document.getElementById('validacion_Edit_C').innerHTML = '';
            document.getElementById('validacion2_Edit_C').innerHTML = '';
            var code   = $(this).data('codigo');
            $("#aplica_edit_C").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/cuantaCargoEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="empresa_edit_C"]').val(data.cargo[0].id_empresa);
                    $('[name="age"]').val(data.cargo[0].id_agencia);
                    $('[name="apl"]').val(code);
                    $('[name="cuenta_edit_C"]').val(data.cargo[0].cuenta_contable);
                    
                    $('#Modal_Edit_C').modal('show');
                    agencia_editC();

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
          //}  
        });

        $("#empresa_edit_C").change(function(){
            agencia_editC();
        });

        $("#agencia_edit_C").change(function(){
            aplica_editC();
        });

        function agencia_editC(){
            var empresa = $('#empresa_edit_C').children(":selected").attr("value");
            var age = $('#age').val();
            $("#agencia_edit_C").empty();
                $("#agencia_edit_C").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $.each(data.agencia,function(key, registro){
                                 $("#agencia_edit_C").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });

                            //$("#agencia_edit_C option[value="+age+"").attr("selected",true);
                            $("#agencia_edit_C option[value='"+ age +"']").attr("selected",true);
                            aplica_editC();
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
        };

        function aplica_editC(){
            var empresa = $('#empresa_edit_C').children(":selected").attr("value");
            var agencia = $('#agencia_edit_C').children(":selected").attr("value");
            var apl = $('#apl').val();
            var estado = 1;
            $("#aplica_edit_C").empty();;
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contabilidad/llenarAplicaC')?>",
                        dataType : "JSON",
                        data : {empresa:empresa,agencia:agencia,apl:apl,estado:estado},
                        success: function(data){
                            $.each(data.forma,function(key, registro){
                                $("#aplica_edit_C").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                            });

                            $("#aplica_edit_C option[value='"+ data.cuenta[0].forma +"']").attr("selected",true);
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
        };

        $('#btn_updateC').on('click',function(){
            var code = $('#apl').val();
            var empresa = $('#empresa_edit_C').children(":selected").attr("value");
            var agencia = $('#agencia_edit_C').children(":selected").attr("value");
            var aplica = $('#aplica_edit_C').children(":selected").attr("value");
            var descripcion = $('select[name="aplica_edit_C"] option:selected').text();
            var cuenta = $('#cuenta_edit_C').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/updateCuentaC')?>",
                dataType : "JSON",
                data : {code:code,empresa:empresa,agencia:agencia,aplica:aplica,descripcion:descripcion,cuenta:cuenta},
                success: function(data){
                    if(data==null){
                        document.getElementById('validacion_Edit_C').innerHTML = '';
                        document.getElementById('validacion2_Edit_C').innerHTML = '';

                        $('#Modal_Edit_C').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                    }else{
                        document.getElementById('validacion_Edit_C').innerHTML = '';
                        document.getElementById('validacion2_Edit_C').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_Edit_C').innerHTML += "Debe de ingresar donde aplica la cuanta";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_Edit_C').innerHTML += "Debe de ingresar la cuanta";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2_Edit_C').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }

                        }//Fin For
                    }
                            
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                    return false;
             
        });//Fin metodo modificar

        $(document).on( "click",".item_deleteC", function(event){
            var code   = $(this).data('codigo');
            $('#Modal_Delete_C').modal('show');
            $('[name="cargo_code_delete"]').val(code);
        });

        $('#btn_delete_C').on('click',function(){
            var code = $('#cargo_code_delete').val();
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/deleteCuentaC')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                        $('[name="cargo_code_delete"]').val("");
                    
                        $('#Modal_Delete_C').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });


        $('#pag2').on('click',function(){
            $("#inCargo").hide();
            $("#inAbono").show();
            show_abono();
         });

        agencia_abono();
        $("#empresa_abono").change(function(){
            agencia_abono();
        });
        function agencia_abono(){
            var empresa = $('#empresa_abono').children(":selected").attr("value");
            $("#agencia_abono").empty();
            if(empresa != 'todas'){
                $("#agencia_abono").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_abono").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_abono").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_abono").attr('disabled','disabled');
                $("#agencia_abono").append('<option id="todas" value="todas">Todas</option>');
            }
        };

        $('.item_filtrar2').on('click',function(){
            show_abono();
        });
        function show_abono(){
            var estado = 2;
            var empresa = $('#empresa_abono').children(":selected").attr("value");
            var agencia = $('#agencia_abono').children(":selected").attr("value");

            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();

            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contabilidad/cargo')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencia:agencia,estado:estado},
                success : function(data){
                    
                   $.each(data,function(key, registro){
                    $('.tabla2').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//nombrePlaza
                            '<td>'+registro.descripcion+'</td>'+//estado
                            '<td>'+registro.cuenta_contable+'</td>'+//estado
                            '<td style="text-align:center;">'+
                            '<a data-toggle="modal" class="btn btn-info btn-sm" onclick="myFunction(this)" data-code="'+registro.id_cuenta+'"> Editar </a>'+
                            ' <a  data-toggle="modal" class="btn btn-danger btn-sm item_delete_a" data-codigo="'+registro.id_cuenta+'"> Eliminar </a>'+
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
             $('#mydata2').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                 "order": [[ 4, "asc" ]],
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }

        $('.item_agregar_abono').click(function(){
            agencia_ingreso_abono();
            llenar_aplica_abono();
        });
        $("#empresa_abo").change(function(){
            agencia_ingreso_abono();
        });

        $("#agencia_abo").change(function(){
            llenar_aplica_abono();
        });


        function llenar_aplica_abono(){
            var empresa_abo = $('#empresa_abo').children(":selected").attr("value");
            var agencia_abo = $('#agencia_abo').children(":selected").attr("value");
            $("#aplica_abo").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/disAbono')?>",
                dataType : "JSON",
                data : {empresa_abo:empresa_abo,agencia_abo:agencia_abo},
                success: function(data){
                    $.each(data,function(key, registro) {
                        $("#aplica_abo").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                    });
                    $('#Modal_Abono').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
        };

        function agencia_ingreso_abono(){
            var empresa = $('#empresa_abo').children(":selected").attr("value");
            $("#agencia_abo").empty();
                $("#agencia_abo").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_abo").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });
                            llenar_aplica_abono();
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
        };

        //Metooo para e ingreso 
        $('#btn_save_abono').on('click',function(){
            var empresa_car = $('#empresa_abo').children(":selected").attr("value");
            var agencia_car = $('#agencia_abo').children(":selected").attr("value");
            var descripcion = $('select[name="aplica_abo"] option:selected').text();
            var aplica_car = $('#aplica_abo').children(":selected").attr("value");
            var cuenta_car = $('#cuenta_abo').val();
            var estado = 2;
            var hash = '#pag2';

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/saveCuentaCargo')?>",
                dataType : "JSON",
                data : {empresa_car:empresa_car,agencia_car:agencia_car,aplica_car:aplica_car,descripcion:descripcion,cuenta_car:cuenta_car,estado:estado},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion_abono').innerHTML = '';
                        document.getElementById('validacion2_abono').innerHTML = '';
                        if(window.location.hash){
                            location.reload();
                        }else{
                            window.location.href = '<?php echo site_url('Contabilidad/cuentasCargo/')?>'+hash;
                        }
                        this.disabled=false;
                    }else{
                        document.getElementById('validacion_abono').innerHTML = '';
                        document.getElementById('validacion2_abono').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_abono').innerHTML += "Debe de ingresar donde aplica la cuanta";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_abono').innerHTML += "Debe de ingresar la cuenta";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2_abono').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion2_abono').innerHTML += "Esta cuenta ya existe, por favor ingrese una diferente";
                            }

                        }//Fin For
                    }//Fin if else
                                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;
                
        });//fin de insercionde

        $(document).on( "click",".item_delete_a", function(event){
            var code   = $(this).data('codigo');
            $('#Modal_Delete_A').modal('show');
            $('[name="abono_code_delete"]').val(code);
        });

        $('#btn_delete_A').on('click',function(){
            var code = $('#abono_code_delete').val();
            var hash = '#pag2';
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/deleteCuentaC')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="abono_code_delete"]').val("");
                    
                    $('#Modal_Delete_A').modal('toggle');
                    $('.modal-backdrop').remove();
                    if(window.location.hash){
                        location.reload();
                    }else{
                        window.location.href = '<?php echo site_url('Contabilidad/cuentasCargo/')?>'+hash;
                    }
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });
        
    });//Fin jQuery

    function myFunction(boton){
        document.getElementById('validacion_Edit_C').innerHTML = '';
        document.getElementById('validacion2_Edit_C').innerHTML = '';
        var code = boton.dataset.code;
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Contabilidad/cuantaCargoEdit')?>",
            dataType : "JSON",
            data : {code:code},
            success: function(data){
                console.log(code);
                $('[name="empresa_edit_A"]').val(data.cargo[0].id_empresa);
                $('[name="agen"]').val(data.cargo[0].id_agencia);
                $('[name="code_apl"]').val(code);
                $('[name="cuenta_edit_A"]').val(data.cargo[0].cuenta_contable);
                    
                $('#Modal_Edit_A').modal('show');
                agencia_editA();

            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });
    }

    $("#empresa_edit_A").change(function(){
        agencia_editA();
    });

    $("#agencia_edit_A").change(function(){
        aplica_editA();
    });

    function agencia_editA(){
        var empresa = $('#empresa_edit_A').children(":selected").attr("value");
        var agen = $('#agen').val();
        $("#agencia_edit_A").removeAttr('disabled');
        $("#agencia_edit_A").empty();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
            dataType : "JSON",
            data : {empresa:empresa},
            success: function(data){
                $.each(data.agencia,function(key, registro){
                    $("#agencia_edit_A").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                });

                $("#agencia_edit_A option[value='"+ agen +"']").attr("selected",true);
                aplica_editA();
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });
        return false;
    }

    function aplica_editA(){
        var empresa = $('#empresa_edit_A').children(":selected").attr("value");
        var agencia = $('#agencia_edit_A').children(":selected").attr("value");
        var apl = $('#code_apl').val();
        var estado = 2;
        $("#aplica_edit_A").empty();;
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Contabilidad/llenarAplicaC')?>",
            dataType : "JSON",
            data : {empresa:empresa,agencia:agencia,apl:apl,estado:estado},
            success: function(data){
                $.each(data.forma,function(key, registro){
                    $("#aplica_edit_A").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                });

                $("#aplica_edit_A option[value='"+ data.cuenta[0].forma +"']").attr("selected",true);
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });
        return false;
    }

    $('#btn_updateA').on('click',function(){
        var code = $('#code_apl').val();
        var empresa = $('#empresa_edit_A').children(":selected").attr("value");
        var agencia = $('#agencia_edit_A').children(":selected").attr("value");
        var aplica = $('#aplica_edit_A').children(":selected").attr("value");
        var descripcion = $('select[name="aplica_edit_A"] option:selected').text();
        var cuenta = $('#cuenta_edit_A').val();
        var hash = '#pag2';

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Contabilidad/updateCuentaC')?>",
            dataType : "JSON",
            data : {code:code,empresa:empresa,agencia:agencia,aplica:aplica,descripcion:descripcion,cuenta:cuenta},
            success: function(data){
                if(data==null){
                    document.getElementById('validacion_Edit_A').innerHTML = '';
                    document.getElementById('validacion2_Edit_A').innerHTML = '';

                    $('#Modal_Edit_C').modal('toggle');
                    $('.modal-backdrop').remove();
                    if(window.location.hash){
                        location.reload();
                    }else{
                        window.location.href = '<?php echo site_url('Contabilidad/cuentasCargo/')?>'+hash;
                    }

                }else{
                    document.getElementById('validacion_Edit_A').innerHTML = '';
                    document.getElementById('validacion2_Edit_A').innerHTML = '';

                    for (i = 0; i <= data.length-1; i++){
                        if(data[i] == 1){
                            document.getElementById('validacion_Edit_A').innerHTML += "Debe de ingresar donde aplica la cuanta";
                        }
                        if(data[i] == 2){
                            document.getElementById('validacion2_Edit_A').innerHTML += "Debe de ingresar la cuanta";
                        }
                        if(data[i] == 3){
                            document.getElementById('validacion2_Edit_A').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                        }

                        }//Fin For
                    }
                            
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
            });
            return false;
             
        });//Fin metodo modificar

</script>
</body>


</html>