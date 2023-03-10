  <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Comisiones asignadas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_comision" id="agencia_comision" class="form-control">
                                        <option value="">Todos</option>
                                         <?php
                                            $i=0;
                                            foreach($agencia as $a){
                                        ?>
                                            <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Cargo</label>
                                    <select class="form-control" name="cargo_comision" id="cargo_comision" class="form-control">
                                        <option value="">Todos</option>
                                        <option value="2">Coordinador</option>
                                        <option value="3">Jefe</option>
                                        <option value="4">Asesor</option>
                                        <option value="6">Jefa de Operaciones</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Mes de Bono</label>
                                    <input type="month" class="form-control" id="mes_comision" name="mes_comision">
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                                </div>
                            </div>
                        </div>
                        </nav>
                        <nav class="float-right aceptar" style="margin-top: 23px;"><a class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus" ></span> Agregar Nuevo</a><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Bono</th>
                                    <th style="text-align:center;">Accion</th>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>

                        <div class="form-group col-sm-10" >
                        
                        </div> 
                        <div class="form-group col-sm-2" >
                            <strong><h4 id="total"></h4></strong>
                        </div>
                    <br>

                    </div>
                    <input type="hidden" name="fecha_comision" id="fecha_comision" class="form-control" placeholder="Product Code" readonly>
                     <a href="#" class="btn btn-success btn-lg" id="aprobar_comision" data-toggle="modal" data-target="#Modal_Apro" style="float: right; display: none;">Aprobar todos los bonos</a>
                </div>
            </div>
            <div class="row" >

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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Bono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_bono" id="cantidad_bono" class="form-control" placeholder="Ingrese la cantidad">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Agencia:</label>
                <div class="col-md-10">
                    
                     <select class="form-control" name="agencia_bono" id="agencia_bono" class="form-control">
                        <?php
                        $i=0;
                        foreach($agencia as $a){
                        ?>
                            <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                 <label class="col-md-2 col-form-label">Empleado</label>
                    <div class="col-md-10">
                        <select name="empleado_bono" id="empleado_bono" class="form-control" placeholder="">

                        </select>
                    </div>
            </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!--MODAL PARA CONFIRMAR BONOS-->
<form>
        <div class="modal fade" id="Modal_Apro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Aprobacion de Bonos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea aprobar todos los bonos?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="fecha_aprobar" id="fecha_aprobar" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
</form>
<!--FIN MODAL BONOS-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Reasignacion de Bono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">

                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" placeholder="Product Code" readonly>
                    <input type="hidden" name="empleado_hide" id="empleado_hide" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Cantidad:</label>
                <div class="col-md-10">
                    <input type="text" name="cantidad_edit" id="cantidad_edit" class="form-control" placeholder="Ingrese Nueva cantidad" >
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Agencia:</label>
                <div class="col-md-10">
                    
                     <select class="form-control" name="agencia_empleado" id="agencia_empleado" class="form-control">
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

            <div class="form-group row">
                 <label class="col-md-2 col-form-label">Empleado</label>
                    <div class="col-md-10">
                        <select name="empleado_comision" id="empleado_comision" class="form-control" placeholder="">

                        </select>
                    </div>
            </div>


            </div>           
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Reasignar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL PARA CONFIRMAR BONOS-->
<form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Bonos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Eliminar este bono?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="eliminar_bono" id="eliminar_bono" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
</form>
<!--FIN MODAL BONOS-->

<!-- Llamar JavaScript -->


<script type="text/javascript">
    $(document).ready(function(){
       
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();

        $('#filtrar').on('click',function(){ 
            show_data();
        });    

        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia = $('#agencia_comision').children(":selected").attr("id");
            var cargo = $('#cargo_comision').val();
            var mes = $('#mes_comision').val();
            var fecha = '';
            var total = 0;

            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('comisiones/empleadosComisiones')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia:agencia,cargo:cargo,mes:mes},
                success : function(data){
                   $.each(data,function(key, registro){
                    
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+'</td>'+
                                '<td>'+registro.apellido+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>$'+registro.cantidad+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<a id="reasignar" class="btn btn-primary btn-sm item_rea" data-codigo="'+registro.id_comisiones+'" >Reasignar</a>'+
                                    ' <a id="eliminar" class="btn btn-danger btn-sm item_eli" data-codigo="'+registro.id_comisiones+'" >Eliminar</a>'+
                                    '<a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" id="reasignar" class="btn btn-success btn-sm item_con" style="display: none;">Ver Contrato</a>'+                          
                                '</td>'+
                                '</tr>'
                        );

                    //if para saber la el mes del bono
                    if(fecha != registro.mes){
                        fecha = registro.mes;
                    }
                    //Oculta y muestra los botones
                    if(parseInt(registro.estado) == 1 || parseInt(registro.estado) == 2){
                       $(".item_eli").hide();
                       $(".item_rea").hide();
                       $("#aprobar_comision").hide();
                       $(".aceptar").hide();
                       $(".item_con").show();
                    }else if(parseInt(registro.estado) == 0){

                        $(".item_eli").show();
                        $(".item_rea").show();
                        $("#aprobar_comision").show();
                        $(".aceptar").show();
                    }
                    total += parseFloat(registro.cantidad);
                   });

                   document.getElementById('total').innerHTML ="Total: "+total.toFixed(2);
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
                "paging":   false,
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        $('[name="fecha_comision"]').val(fecha);

        };

        //METODO PARA APROBAR TODOS LOS BONOS
        $('#btn_aprobar').on('click',function(){
            var mes = $('#fecha_comision').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/aprobarTodo')?>",
                dataType : "JSON",
                data : {mes:mes},
            
                success: function(data){
                    $('[name="fecha_comision"]').val("");
                    $('#Modal_Apro').modal('toggle');
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
        });//fin metodo aprobar todos los bonos

        //Sirve para llenar el combobox de el ingreso de nuevos bonos
        empleados();
        $( "#agencia_bono" ).on('change',function(){
              empleados();
        });
        //se llena el combobox de los nuevos bonos
        function empleados(){
             var agencia_bono = $('#agencia_bono').children(":selected").attr("id");

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/getAllEmpleados')?>",
                dataType : "JSON",
                data : {agencia_bono:agencia_bono},
                success: function(data){
                    $("#empleado_bono").empty();
                    $.each(data.all,function(key, registro) {

                         $("#empleado_bono").append('<option value='+registro.id_contrato+'>'+registro.nombre+' '+registro.apellido+'</option>');
                    });
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };//Fin empleados que carga el combobox de empleados

        $('#btn_save').on('click',function(){
            var cantidad_bono = $('#cantidad_bono').val();
            var contrato_bono = $('#empleado_bono').val();
            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/insertComision')?>",
                dataType : "JSON",
                data : {cantidad_bono:cantidad_bono,contrato_bono:contrato_bono},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';

                        $('[name="cantidad_bono"]').val("");
                        $('[name="empleado_bono"]').val("");
                        
                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Bono";
                            }
                             if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Ingrese la cantidad en forma correcta (0.00)";
                            }
                            
                        }//Fin For

                    }
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        });

         //Inicion para llenado de modal
        $('#show_data').on('click','.item_rea',function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            var code = $(this).data('codigo');

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/llenarComision')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="code_edit"]').val(code);
                    $('[name="cantidad_edit"]').val(data[0].cantidad);
                    $('[name="agencia_empleado"]').val(data[0].id_agencia);
                    $('[name="empleado_hide"]').val(data[0].id_contrato);
                     load();

                    $('#Modal_Edit').modal('show');
                   

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

        });//fin llanado de modal

        //Se utiliza para hacer el cambio del combobox de los empleados
        //se usa cuando cambia el combobox de agencias
        $( "#agencia_empleado" ).on('change',function(){
              load();
        });

        function load(){
             var agencia_comision = $('#agencia_empleado').children(":selected").attr("id");
             var empleado = $('#empleado_hide').val();

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/getEmpleados')?>",
                dataType : "JSON",
                data : {agencia_comision:agencia_comision},
                success: function(data){
                    $("#empleado_comision").empty();
                    $.each(data.empl,function(key, registro) {

                         $("#empleado_comision").append('<option value='+registro.id_contrato+'>'+registro.nombre+' '+registro.apellido+'</option>');
                    });

                    $("#empleado_comision option[value='"+empleado+"']").attr("selected",true);
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
        };//Fin load que carga el combobox de empleados

        //update record to database
        $('#btn_update').on('click',function(){
            var code = $('#code_edit').val();
            var cantidad = $('#cantidad_edit').val();
            var contrato_empleado = $('#empleado_comision').val();
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/cambioBono')?>",
                dataType : "JSON",
                data : {code:code,cantidad:cantidad,contrato_empleado:contrato_empleado},
                success: function(data){
                    if(data == null){
                        $('[name="code_edit"]').val("");
                        $('[name="cantidad_edit"]').val("");
                        $('[name="empleado_comision"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{
                        document.getElementById('validacion_Edit').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar la Cantidad del Bono";
                            }
                             if(data[i] == 2){
                                document.getElementById('validacion_Edit').innerHTML += "Ingrese la cantidad en forma correcta (0.00)";
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
        });

        //Inicion para llenado de modal
        $('#show_data').on('click','.item_eli',function(){
            var code   = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="eliminar_bono"]').val(code);

        });//fin llanado de modal

        $('#btn_delete').on('click',function(){
            var code = $('#eliminar_bono').val();
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('comisiones/deleteBono')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                        $('[name="eliminar_bono"]').val("");
                    
                        $('#Modal_Delete').modal('toggle');
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

    });
</script>

</body>

</html>