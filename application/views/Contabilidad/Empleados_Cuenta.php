        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Cuentas Personales</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados Activos</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Empleados Inactivos</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_activo" id="empresa_activo" class="form-control">
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
                                <select class="form-control" name="agencia_activo" id="agencia_activo" class="form-control">
                                    
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
                                        <th style="text-align:center;">Empleado</th>
                                        <th style="text-align:center;">N° de Cuentas</th>  
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
                                <select class="form-control" name="empresa_inactivo" id="empresa_inactivo" class="form-control">
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
                                <select class="form-control" name="agencia_inactivo" id="agencia_inactivo" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar2" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>


                        <table class="table table-bordered table-hover" id="mydata2" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Empresa</th> 
                                    <th style="text-align:center;">Empleado</th>
                                    <th style="text-align:center;">N° de Cuentas</th>  
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
<input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add_Per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Cuenta Contable Personal (Empleado Activo)</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_per" id="aplica_per" class="form-control">
                            
                        </select>
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_per" id="cuenta_per" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
                <input type="hidden" name="id_empleado" id="id_empleado" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add_Inac" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Cuenta Contable Personal (Empleado Inactivo)</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_perIna" id="aplica_perIna" class="form-control">
                            
                        </select>
                        <div id="validacion_inactivo" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_perIna" id="cuenta_perIna" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2_inactivo" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
                <input type="hidden" name="id_empleado_inac" id="id_empleado_inac" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save_Ina" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->


<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        agencia();
        $("#empresa_activo").change(function(){
            agencia();
        });
        show_data();
        $('#pag1').on('click',function(){
            show_data();
         });
        $('.item_filtrar').on('click',function(){
            show_data();
        });

        if(window.location.hash) {
            var hash = window.location.hash.substring(1);
            if(hash == 'pag2'){
                agenciaInactivos();
                show_inactivo();
                $("#pag2").click();
            }else{
                show_data();
            }
        }else{
            show_data();
        }

        function agencia(){
            var empresa = $('#empresa_activo').children(":selected").attr("value");
            $("#agencia_activo").empty();
            if(empresa != 'todas'){
                $("#agencia_activo").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_activo").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_activo").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_activo").attr('disabled','disabled');
                $("#agencia_activo").append('<option id="todas" value="todas">Todas</option>');
            }
        };

        function show_data(){
            var estado = 1;
            var empresa = $('#empresa_activo').children(":selected").attr("value");
            var agencia = $('#agencia_activo').children(":selected").attr("value");
            var i = 0;

            console.log(agencia);
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contabilidad/allEmpleadoActivos')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencia:agencia,estado:estado},
                success : function(data){
                   $.each(data.datos,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//nombrePlaza
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//estado
                            '<td>'+data.cantidad[i].conteo+'</td>'+//estado
                            '<td style="text-align:center;">'+
                            '<a data-toggle="modal" class="btn btn-primary btn-sm item_agregar" data-codigo="'+registro.id_empleado+'"> Agregar </a>'+
                            ' <a id="estado" class="btn btn-success btn-sm" href="<?php echo base_url();?>index.php/Contabilidad/cuentasPer/'+registro.id_empleado+'"> Revisar </a>'+
                            '</td>'+
                        '</tr>'
                        );
                    i++;
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
                 "order": [[ 3, "asc" ]],
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };

        $(document).on( "click",".item_agregar", function(event){
            var code   = $(this).data('codigo');
            $("#aplica_per").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/cuentasPersonales')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $.each(data,function(key, registro) {
                        $("#aplica_per").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                    });
                    $('[name="id_empleado"]').val(code);
                    $('#Modal_Add_Per').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
 
        });

        //Metooo para e ingreso 
        $('#btn_save').on('click',function(){
            var descripcion = $('select[name="aplica_per"] option:selected').text();
            var aplica_per = $('#aplica_per').children(":selected").attr("value");
            var cuenta_per = $('#cuenta_per').val();
            var code = $('#id_empleado').val();
            var autorizado = $('#user').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/saveCuentaPer')?>",
                dataType : "JSON",
                data : {code:code,descripcion:descripcion,aplica_per:aplica_per,cuenta_per:cuenta_per,autorizado:autorizado},
                success: function(data){
                    console.log(data);
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
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuanta";
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

        agenciaInactivos();
        $("#empresa_inactivo").change(function(){
            agenciaInactivos();
        });
        function agenciaInactivos(){
            var empresa = $('#empresa_inactivo').children(":selected").attr("value");
            $("#agencia_inactivo").empty();
            if(empresa != 'todas'){
                $("#agencia_inactivo").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_inactivo").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_inactivo").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_inactivo").attr('disabled','disabled');
                $("#agencia_inactivo").append('<option id="todas" value="todas">Todas</option>');
            }
        };

        $('#pag2').on('click',function(){
            show_inactivo();
         });

        $('.item_filtrar2').on('click',function(){
            show_inactivo();
        });
        function show_inactivo(){
            var estado = 2;
            var empresa = $('#empresa_inactivo').children(":selected").attr("value");
            var agencia = $('#agencia_inactivo').children(":selected").attr("value");
            var i = 0;

            console.log(agencia);
            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();

            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contabilidad/allEmpleadoActivos')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencia:agencia,estado:estado},
                success : function(data){
                   $.each(data.datos,function(key, registro){
                    $('.tabla2').append(
                        '<tr class="'+registro.id_empleado+'">'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//nombrePlaza
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//estado
                            '<td>'+data.cantidad[i].conteo+'</td>'+//estado
                            '<td style="text-align:center;">'+
                            '<a data-toggle="modal" class="btn btn-primary btn-sm item_agregar_Inac" data-codigo="'+registro.id_empleado+'"> Agregar </a>'+
                            ' <a id="estado" class="btn btn-success btn-sm" href="<?php echo base_url();?>index.php/Contabilidad/cuentasPer/'+registro.id_empleado+'"> Revisar </a>'+
                            '</td>'+
                        '</tr>'
                        );
                    if(registro.estado == 10){
                        $("."+registro.id_empleado).addClass("info");
                    }else{
                        $("."+registro.id_empleado).addClass("danger");
                    }
                    i++;
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
                 "order": [[ 3, "asc" ]],
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };

        $(document).on( "click",".item_agregar_Inac", function(event){
            var code   = $(this).data('codigo');
            $("#aplica_perIna").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/cuentasPersonales')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $.each(data,function(key, registro) {
                        $("#aplica_perIna").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                    });
                    $('[name="id_empleado_inac"]').val(code);
                    $('#Modal_Add_Inac').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
 
        });

        //Metooo para e ingreso 
        $('#btn_save_Ina').on('click',function(){
            var descripcion = $('select[name="aplica_perIna"] option:selected').text();
            var aplica_per = $('#aplica_perIna').children(":selected").attr("value");
            var cuenta_per = $('#cuenta_perIna').val();
            var code = $('#id_empleado_inac').val();
            var hash = '#pag2';

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/saveCuentaPer')?>",
                dataType : "JSON",
                data : {code:code,descripcion:descripcion,aplica_per:aplica_per,cuenta_per:cuenta_per},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion_inactivo').innerHTML = '';
                        document.getElementById('validacion2_inactivo').innerHTML = '';

                        if(window.location.hash){
                            location.reload();
                        }else{
                            window.location.href = '<?php echo site_url('Contabilidad/cuentaPersonal/')?>'+hash;
                        }
                        this.disabled=false;
                    }else{
                        document.getElementById('validacion_inactivo').innerHTML = '';
                        document.getElementById('validacion2_inactivo').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_inactivo').innerHTML += "Debe de ingresar donde aplica la cuanta";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_inactivo').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2_inactivo').innerHTML += "Debe de ingresar la cuanta";
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

    });//Fin jQuery

</script>
</body>


</html>