 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Orden de descuento</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                <?php if($ver==1){ ?>
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_prestamo" id="agencia_prestamo" class="form-control">
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
                            <?php }else{ ?>

                                <input type="hidden" name="agencia_prestamo" id="agencia_prestamo" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                            <?php } ?>
                                <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            </div>
                        </nav>
                        <div id="validacion9" style="color:red"></div>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Accion</th>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="div1"></div>    
            </div>
        </div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Orden de Descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <div class="col-md-8">
                        <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                    </div>
                </div>
                    <div class="form-group row" >
                        <label class="col-md-3 col-form-label">Nombre del banco: </label>
                        <div class="col-md-5">
                            <select class="form-control" name="nombre_banco" id="nombre_banco" class="form-control">
                            <option value="0">Seleccione un banco</option>
                            <?php
                                $i=0;
                                    foreach($bancos as $banco){       
                            ?>
                            <option value="<?= ($bancos[$i]->id_banco);?>"><?=($bancos[$i]->nombre_banco);?></option>
                            <?php
                                $i++;
                                }
                            ?>
                            </select>
                            <div id="validacion" style="color:red"></div>
                            <div id="validacion7" style="color:red"></div>
                        </div>
                        <div class="col-md-5">
                        <input type="hidden" name="numero_cuenta" id="numero_cuenta" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row" id="ingreso_cuenta">
                        <label class="col-md-3 col-form-label">numero de cuenta: </label>
                        <div class="col-md-5">
                            <input type="text" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="numero_cuenta_ingresado" name="numero_cuenta_ingresado" placeholder="numero de cuenta" > 
                            <div id="validacion2" style="color:red"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row" style="display: none">
                        <label class="col-md-3 col-form-label">Tipo de periodo:</label>
                        <div class="col-md-5">
                            <select class="form-control cambiar_label" name="tipo_periodo" id="tipo_periodo" class="form-control">
                                <option value="1">Mensual</option>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group row" >
                     <label class="col-md-3 col-form-label" id="periodo_label">Cantidad de meses a descontar:</label>
                        <div class="col-md-5">
                            <input type="text" name="total_periodo" id="total_periodo"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control">
                            <div id="validacion5" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Monto a descontar: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="monto" name="monto" placeholder="$0.00" > 
                            <div id="validacion3" style="color:red"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" id="label_cuota">Cuota Mensual: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="cuota" name="cuota" placeholder="$0.00" > 
                            <div id="validacion4" style="color:red"></div>
                        </div>
                    </div>

                <div class="form-group row" >
                    <label class="col-md-3 col-form-label">Motivo de descuento:</label>
                    <div class="col-md-5">
                       <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del descuento" ></textarea>
                       <div id="validacion6" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer" style="text-align: center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-success" data-backdrop="false" data-dismiss="modal" >Crear Orden</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL Edit -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Orden de Descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                    <div class="col-md-8">
                        <input type="hidden" name="code_user_edit" id="code_user_edit" class="form-control" placeholder="Product Code" readonly>
                    </div>

                    <div class="col-md-8">
                        <input type="hidden" name="id_orden_descuento_edit" id="id_orden_descuento_edit" class="form-control" placeholder="Product Code" readonly>
                    </div>


                <div class="form-group row">
                    <div class="col-md-8">
                        <input type="hidden" name="fecha_edit" id="fecha_edit" class="form-control" readonly>
                    </div>
                </div>
                

                    <div class="form-group row" >
                        <label class="col-md-3 col-form-label">Nombre del banco: </label>
                            <div class="col-md-5">
                                <select class="form-control" name="nombre_banco_editar" id="nombre_banco_editar" class="form-control">
                                </select>
                                <div id="validacion_banco_edit" style="color:red"></div>
                            </div>
                    </div>

                    <div class="form-group row" id="periodo_opcion" style="display: none">
                        <label class="col-md-3 col-form-label">Tipo de periodo:</label>
                        <div class="col-md-5">
                            <select class="form-control cambiar_label" name="tipo_periodo_editar" id="tipo_periodo_editar" class="form-control">
                                <option value="1">Mensual</option>
                            </select>
                        </div>
                    </div> 

                    <div class="form-group row" id="quincena_opcion">
                     <label class="col-md-3 col-form-label" id="periodo_label">Cantidad de meses a descontar:</label>
                        <div class="col-md-5">
                            <input type="text" name="total_periodo_editar" id="total_periodo_editar"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control">
                            <div id="periodo_edit" style="color:red"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row" id="cuota_opcion">
                        <label class="col-md-3 col-form-label" id="label_cuota">Cuota Mensual: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="cuota_editar" name="cuota_editar" placeholder="$0.00" > 
                            <div id="cuota_edit" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row" id="cuota_opcion">
                        <label class="col-md-3 col-form-label" id="label_cuota">Monto Total: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="monto_editar" name="monto_editar" placeholder="$0.00" disabled="true"> 
                            <div id="cuota_edit" style="color:red"></div>
                        </div>
                    </div>


                    <div class="col-md-5">
                       <textarea style="display:none" class="form-control" id="descripcion_editar" name="descripcion_editar" placeholder="Descripción del descuento" ></textarea>
                       <div id="descripcion_edit" style="color:red"></div>
                    </div>
       

            </div>
            
            <div class="modal-footer" style="text-align: center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_edit" class="btn btn-success" data-backdrop="false" data-dismiss="modal" >Editar Orden</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL Edit-->

<!-- MODAL REFINANCIAMIENTO -->
<form>
    <div class="modal fade" id="Modal_Refinanciamiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Refinanciamiento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            
                <div class="form-group row">
                    <div class="col-md-8">
                        <input type="hidden" name="id_empleado_refin" id="id_empleado_refin" class="form-control" placeholder="Product Code" readonly>   
                        <input type="hidden" name="id_orden_descuento" id="id_orden_descuento" class="form-control" placeholder="Product Code" readonly>
                    </div>
                </div>

                <div class="form-group row" >
                    <label class="col-md-3 col-form-label">Nombre del banco: </label>
                        <div class="col-md-5">
                            <select class="form-control item_filtrar" name="filtro_banco_refin" id="filtro_banco_refin" class="form-control">
                            </select>
                            <div id="validacion_" style="color:red"></div>
                        </div>
                </div>

                <div class="form-group row" style="display: none">
                        <label class="col-md-3 col-form-label">Tipo de periodo:</label>
                        <div class="col-md-5">
                            <select class="form-control cambiar_label" name="tipo_periodo_refin" id="tipo_periodo_refin" class="form-control">
                                <option value="1">Mensual</option>
                            </select>

                        </div>
                    </div> 

                    <div class="form-group row" >
                     <label class="col-md-3 col-form-label" id="periodo_label">Cantidad de meses a descontar:</label>
                        <div class="col-md-5">
                            <input type="text" name="total_periodo_refin" id="total_periodo_refin"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="form-control">
                            <div id="validacion_4" style="color:red"></div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Monto a descontar: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="monto_refin" name="monto_refin" placeholder="$0.00" > 
                            <div id="validacion_2" style="color:red"></div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" id="label_cuota">Cuota Quincenal: </label>
                        <div class="col-md-5">
                            <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="cuota_refin" name="cuota_refin" placeholder="$0.00" > 
                            <div id="validacion_3" style="color:red"></div>
                        </div>
                    </div>

            </div>
            
            <div class="modal-footer" style="text-align: center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_update" class="btn btn-success" data-backdrop="false" data-dismiss="modal" >Crear Refinanciamiento</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END REFINANCIAMIENTO-->

<!-- MODAL ABONAR -->
<form>
    <div class="modal fade" id="Modal_Abonar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Abono a Orden de Descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
                <div class="col-md-8">
                    <input type="hidden" name="id_empleado_orden" id="id_empleado_orden" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

            <div class="form-group row" >
                <label class="col-md-3 col-form-label">Nombre del banco: </label>
                    <div class="col-md-5">
                        <select class="form-control" name="nombre_banco_abonar" id="nombre_banco_abonar" class="form-control">
                        </select>
                        <div id="validacion_banco1" style="color:red"></div>
                    </div>
            </div>

            <div class="form-group row" >
                    <div class="col-md-5">
                        <input type="hidden" onkeypress='return event.charCode >= 48 && event.charCode <= 57' class="md-textarea form-control" id="id_orden" name="id_orden" placeholder="id" > 
                    <div id="validacion2" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3 col-form-label" id="label_cuota">Cuota a abonar: </label>
                    <div class="col-md-5">
                        <input type="text" onKeyUp="revisaCadena(this)" class="md-textarea form-control" id="cuota_abono" name="cuota_abono" placeholder="$0.00" > 
                        <div id="validacion_cuota1" style="color:red"></div>
                        
                    </div>
            </div>
            
            <div class="modal-footer" style="text-align: center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_abonar" class="btn btn-success" data-backdrop="false" data-dismiss="modal" >Abonar Orden</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>

<!--END MODAL Abonar-->

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">

    $('#ingreso_cuenta').hide();
    var textoAnterior = '';
    
    function cumpleReglas(simpleTexto)
        {
            var expresion = new RegExp("^(|([0-9]{1,100}(\\.([0-9]{1,2})?)?))$"); 
            if(expresion.test(simpleTexto))
                return true;
            return false;
        }//permite solamente el ingreso de numeros
    
    function revisaCadena(textItem)
        {
            if(textItem.value.substring(0,1) == '.') 
                textItem.value = '0' + textItem.value;
            if(!cumpleReglas(textItem.value)){
                textItem.value = textoAnterior;
            }
            else{
                textoAnterior = textItem.value;
            } 
        }//verifica que la cadena ingresada solamente sean numeros y solo acepta un punto decimal 

    $(document).ready(function(){

        $('.item_filtrar').on('change',function(){//select de refinanciamiento
            var id_banco=$('.item_filtrar').val();
            var code = $('#id_empleado_refin').val();
            //$('.item_filtrar').empty();
            $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Orden_descuentos/traer_orden')?>',
            dataType : 'JSON',
            data : {id_banco:id_banco,code:code},
            success : function(data){
                if (data!=null) {
                    $('#id_orden_descuento').val(data);//llena con el id de la orden de descuento que pertenece
                }else{
                     $('#id_orden_descuento').val('0');
                }
            }, 
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        });

    function traer_bancos_abonados(code=null){//continuar aca se debe modificar todo para q sirva con el id_empleado
        var id_empleado = code;
        var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Orden_descuentos/bancos_abonados')?>',
            dataType : 'JSON',
            data : {id_empleado:id_empleado,agencia_prestamo:agencia_prestamo},
            success : function(data){
                console.log(data);
                if (data!=null) {
                    $('#filtro_banco').append(
                        '<option value="0">Seleccione un banco</option>');
                    for (var i = data.length - 1; i >= 0; i--) {   
                        $('#filtro_banco').append(
                        '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                        );
                        $('#id_orden_descuento').val('0');
                    }
                    $('#nombre_banco_abonar').append(
                        '<option value="0">Seleccione un banco</option>');
                    for (var i = data.length - 1; i >= 0; i--) {   
                        $('#nombre_banco_abonar').append(
                        '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                        );
                        $('#id_orden_descuento').val('0');
                    }
                    $('#nombre_banco_editar').append(
                        '<option value="0">Seleccione un banco</option>');
                    for (var i = data.length - 1; i >= 0; i--) {   
                        $('#nombre_banco_editar').append(
                        '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                        );
                        $('#id_orden_descuento').val('0');
                    }
                     $('#filtro_banco_refin').append(
                        '<option value="0">Seleccione un banco</option>');
                    for (var i = data.length - 1; i >= 0; i--) {   
                        $('#filtro_banco_refin').append(
                        '<option value="'+data[i].id_banco+'">'+data[i].nombre_banco+'</option>'
                        );
                        $('#id_orden_descuento').val('0');
                    } 
                }
                show_data();
                },  
                error: function(data){
                    var a = JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }//funcion para poder llenar los select con los bancos a los cuales el empleado tiene alguna orden de descuento

        $('#nombre_banco').on('change',function(){//add
        var id_banco=$('#nombre_banco').val();

        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('orden_descuentos/todos_bancos')?>',
            async : false,
            dataType : 'JSON',
            data : {id_banco:id_banco},
            success : function(data){
                if (id_banco > 0) {
                $('#numero_cuenta').val(data[0].numero_cuenta);
                if (data[0].numero_cuenta==null) {
                    $('#ingreso_cuenta').show();
                }else{
                    $('#ingreso_cuenta').hide();
                }   
                }else if(id_banco==0){
                    $('#numero_cuenta').val('');
                    $('#ingreso_cuenta').hide();
                }
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    });//llena el combo de agregar con todos los bancos que esten disponibles 


    $('.cambiar_label').on('change',function(){
        var tipo_periodo=$('#tipo_periodo').val();
        var tipo_periodo_refin=$('#tipo_periodo_refin').val();
        if (tipo_periodo==0){
            $('#periodo_label').html('Cantidad de quincenas a descontar:');
            $('#label_cuota').html('Cuota Quincenal:');
        }else if (tipo_periodo==1) {
            $('#periodo_label').html('Cantidad de meses a descontar:');
            $('#label_cuota').html('Cuota Mensual:');
        }else if (tipo_periodo==2) {
            $('#periodo_label').html('Cantidad de años a descontar:');
            $('#label_cuota').html('Cuota Anual:');
        }
    });// solamente cambia el texto segun el modal de add

        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data(); 

        $('#agencia_prestamo').change(function(){
            show_data();
        });//funciona para mostrar segun agencia

        function get_orden_empleado(){
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('orden_descuentos/get_orden_empleado')?>',
                async : false,
                dataType : 'JSON',
                data : {},
                success : function(data){
                console.log(data);
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
            var code=[];

            $('tbody').empty();
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Orden_descuentos/empleados')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                    console.log(data);
                    contador=0;
                    for (i = 0; i <= data.ordenes.length - 1; i++) {
                        code[i] = data.ordenes[i];
                    }
                   $.each(data.empleados,function(key, registro){
                    contador++;
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+//nombre
                                '<td>'+registro.apellido+'</td>'+//apellido
                                '<td>'+registro.dui+'</td>'+//dui
                                '<td>'+registro.cargo+'</td>'+//cargo
                                '<td style="text-align:right;">'+
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" id="add" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'">Agregar</a><?php } ?> ' + '<?php if ($editar==1) { ?> <a data-toggle="modal" name="" data-target="#Modal_Edit" class="btn btn-info btn-sm prueba item_edit" id="edit'+contador+'" data-codigo="'+registro.id_contrato+'">Editar</a><?php } ?>  '+'<?php if ($Revisar==1) { ?> <a href="<?php echo base_url();?>index.php/Orden_descuentos/ver_ordenes_descuento/'+registro.id_contrato+'/'+agencia_prestamo+'" class="btn btn-primary btn-sm">Ver</a><?php } ?>'+' '+' '+'<?php if ($refinanciamiento==1) { ?> <a data-toggle="modal" name="" data-target="#Modal_Refinanciamiento" class="btn btn-warning btn-sm prueba item_ref" id="refin'+contador+'" data-codigo="'+registro.id_contrato+'">Refinanciamiento</a><?php } ?>'+
                                '</td>'+
                                '</tr>'
                        );
                  
                    <?php if ($refinanciamiento==1) { ?>
                       document.getElementById('refin'+contador).style.display = 'none';
                   <?php } ?>
                   <?php if ($editar==1) { ?> 
                   if (<?=$editar?>==1) {   
                    document.getElementById('edit'+contador).style.display = 'none'; 
                    }
                   <?php } ?>

                    for (i = 0; i < code.length ; i++) {
                        if( parseInt(registro.id_empleado)==parseInt(code[i].id_empleado)){   
                            if (code[i].estado==1) {

                          <?php if ($refinanciamiento==1) { ?>  
                            document.getElementById('refin'+contador).style.display = '';
                         <?php } ?>
                          <?php if ($editar==1) { ?>
                             document.getElementById('edit'+contador).style.display = '';
                          <?php } ?>
                            }                  
                        }
                    }

                   });  
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            //Se genera la paginacion cada ves que se ejeucuta la funcion
             $('#mydata').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };

        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            //limpiar campos al seleccionar una persona nueva
            $('#total_periodo').val('');
            $('#cuota').val('');
            $('#monto').val('');
            $('#descripcion').val('');

            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
        });

        $('#show_data').on('click','.item_edit',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            //limpiar campos al seleccionar una persona nueva
            $('#total_periodo_editar').val('');
            $('#cuota_editar').val('');
            $('#monto_editar').val('');
            
            $('#Modal_edit').modal('show');
            $('[name="code_user_edit"]').val(code);
            traer_bancos_abonados(code);//manda a llenar con los bancos en los cuales se tiene orden de descuento
            $('#nombre_banco_editar').empty();
        });

        $('#show_data').on('click','.item_ref',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            //limpiar campos al seleccionar una persona nueva
            $('#total_periodo_refin').val('');
            $('#cuota_refin').val('');
            $('#monto_refin').val('');

            $('#Modal_Refinanciamiento').modal('show');
            $('[name="id_empleado_refin"]').val(code);
            traer_bancos_abonados(code);//manda a llenar con los bancos en los cuales se tiene orden de descuento
            $('#filtro_banco_refin').empty();
        });
        //hasta aca se recupera el id que se usa en cada modal

        //Save  
        $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var nombre_banco = $('#nombre_banco').val();
            var numero_cuenta = $('#numero_cuenta').val();
            var numero_cuenta_ingresado = $('#numero_cuenta_ingresado').val();
            var monto = $('#monto').val();
            var cuota = $('#cuota').val();
            var tipo_periodo = $('#tipo_periodo').val();
            var total_periodo = $('#total_periodo').val();
            var descripcion = $('#descripcion').val();

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('orden_descuentos/crear_orden_descuento')?>",
                dataType : "JSON",
                data : {code:code,nombre_banco:nombre_banco,numero_cuenta:numero_cuenta,numero_cuenta_ingresado:numero_cuenta_ingresado,monto:monto,total_periodo:total_periodo,descripcion:descripcion,tipo_periodo:tipo_periodo,cuota:cuota},
                success: function(data){
                if ((data==null)) {
                document.getElementById('validacion').innerHTML = '';
                document.getElementById('validacion2').innerHTML = '';
                alert("El ingreso se Realizo Correctamente, Por Favor Cierre La Ventana");
                this.disabled=false;
                location.reload(true);
                show_area();
                }else{
                document.getElementById('validacion').innerHTML  = '';
                document.getElementById('validacion2').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';
                document.getElementById('validacion4').innerHTML = '';
                document.getElementById('validacion5').innerHTML = '';
                document.getElementById('validacion6').innerHTML = '';
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 1){
                        document.getElementById('validacion').innerHTML += "Seleccione un banco";
                    }
                    if(data[i] == 2){
                        document.getElementById('validacion2').innerHTML += "Ingrese un numero de cuenta";
                    }
                    if(data[i] == 3){
                        document.getElementById('validacion3').innerHTML += "Ingrese un monto";
                    }
                    if (data[i]== 4) {
                        document.getElementById('validacion4').innerHTML += "Ingrese una cuota";
                    }
                    if (data[i]== 5) {
                        document.getElementById('validacion5').innerHTML += "Digite el periodo estipulado";
                    }
                    if (data[i]== 6) {
                        document.getElementById('validacion6').innerHTML += "Escriba el motivo de la orden de descuento";
                    }
                    if (data[i]== 7) {
                        document.getElementById('validacion7').innerHTML += "Ya se tiene una orden de descuento en este banco";
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
          
        });//fin de la funcion crear horas extras 


        $('#btn_update').on('click',function(){//refinanciamiento orden
            
            var code = $('#id_empleado_refin').val();
            var id_banco = $('#filtro_banco_refin').val();
            var id_orden_descuento = $('#id_orden_descuento').val();
            var monto = $('#monto_refin').val();
            var cuota = $('#cuota_refin').val();
            var tipo_periodo = $('#tipo_periodo_refin').val();//mensual
            var total_periodo = $('#total_periodo_refin').val();//cantidad de meses
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('orden_descuentos/crear_refinanciamiento')?>",
                dataType : "JSON",
                data : {code:code,id_banco:id_banco,monto:monto,total_periodo:total_periodo,tipo_periodo:tipo_periodo,cuota:cuota,id_orden_descuento:id_orden_descuento,agencia_prestamo:agencia_prestamo},
                success: function(data){
                    console.log(data);
                if ((data==null)) {
                document.getElementById('validacion_').innerHTML = '';
                document.getElementById('validacion_2').innerHTML = '';
                document.getElementById('validacion_3').innerHTML = '';
                document.getElementById('validacion_4').innerHTML = '';
                alert("El ingreso se Realizo Correctamente, Por Favor Cierre La Ventana");
                this.disabled=false;
                location.reload(true);
                show_area();
                }else{
                document.getElementById('validacion_').innerHTML = '';
                document.getElementById('validacion_2').innerHTML = '';
                document.getElementById('validacion_3').innerHTML = '';
                document.getElementById('validacion_4').innerHTML = '';
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 1){
                        document.getElementById('validacion_').innerHTML += "Seleccione un banco";
                    }
                    if(data[i] == 2){
                        document.getElementById('validacion_3').innerHTML += "Ingrese una cuota";
                    }
                    if(data[i] == 3){
                        document.getElementById('validacion_2').innerHTML += "Ingrese un monto";
                    }
                    if (data[i]== 4) {
                        document.getElementById('validacion_4').innerHTML += "Digite el periodo estipulado";
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
          
        });//fin de la funcion refinanciamiento 

        $('#btn_edit').on('click',function(){//editar orden
            
            var code = $('#code_user_edit').val();
            var id_banco = $('#nombre_banco_editar').val();
            var id_orden_descuento = $('#id_orden_descuento_edit').val();
            var monto = $('#monto_editar').val();
            var cuota = $('#cuota_editar').val();
            var tipo_periodo = $('#tipo_periodo_editar').val();
            var total_periodo = $('#total_periodo_editar').val();
            var descripcion = $('#descripcion_editar').val();
            var fecha = $('#fecha_edit').val();
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('orden_descuentos/editar_orden')?>",
                dataType : "JSON",
                data : {code:code,id_banco:id_banco,monto:monto,total_periodo:total_periodo,descripcion:descripcion,tipo_periodo:tipo_periodo,cuota:cuota,id_orden_descuento:id_orden_descuento,fecha:fecha},
                success: function(data){
                    console.log(data);
                if ((data==null)) {
                document.getElementById('validacion_banco_edit').innerHTML = '';
                document.getElementById('periodo_edit').innerHTML = '';
                document.getElementById('cuota_edit').innerHTML = '';
                alert("El ingreso se Realizo Correctamente, Por Favor Cierre La Ventana");
                this.disabled=false;
                location.reload();
                show_area();
                }else{
                document.getElementById('validacion_banco_edit').innerHTML = '';
                document.getElementById('periodo_edit').innerHTML = '';
                document.getElementById('cuota_edit').innerHTML = '';
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 1){
                        document.getElementById('validacion_banco_edit').innerHTML += "Seleccione un banco";
                    }
                    if(data[i] == 2){
                        document.getElementById('periodo_edit').innerHTML += "Ingrese un periodo";
                    }
                    if(data[i] == 3){
                        document.getElementById('cuota_edit').innerHTML += "Ingrese una cuota";
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
          
        });//fin de la funcion editar orden

        $('#nombre_banco_editar').on('change',function(){
            var id_empleado_orden=$('#code_user_edit').val();
            var nombre_banco_abonar=$('#nombre_banco_editar').val();
            var a = $('#tipo_periodo_editar').val();
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
            //editar
            var a=0;
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('orden_descuentos/todos_desc_empleado')?>',
                async : false,
                dataType : 'JSON',
                data : {id_empleado_orden:id_empleado_orden,nombre_banco_abonar:nombre_banco_abonar,agencia_prestamo:agencia_prestamo},
                success : function(data){
                console.log(data);
                if ($('#nombre_banco_editar').val()==0) {//cuando no haya nada en el select de banco se limpiaran las casillas
                document.getElementById('validacion_banco_edit').innerHTML = '';
                document.getElementById('periodo_edit').innerHTML = '';
                document.getElementById('cuota_edit').innerHTML = '';
                $("#id_orden_descuento_edit").val('');
                $("#fecha_edit").val('');
                $("#total_periodo_editar").val('');
                $("#monto_editar").val('');
                $("#cuota_editar").val('');
                $("#descripcion_editar").val('');
                }else{
                cuota=parseFloat(data.cuota).toFixed(2);
                document.getElementById('validacion_banco_edit').innerHTML = '';
                document.getElementById('periodo_edit').innerHTML = '';
                document.getElementById('cuota_edit').innerHTML = '';
                    $('#total_periodo_editar').val(data.total_quincenas);
                    $('#descripcion_editar').val(data.descripcion);
                    $('#cuota_editar').val(data.cuota);
                    $('#monto_editar').val(data.monto_total);
                    $('#id_orden_descuento_edit').val(data.id_orden_descuento);
                    $('#fecha_edit').val(data.fecha_inicio);
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        });

        $('#nombre_banco_abonar').on('change',function(){
            var id_empleado_orden=$('#id_empleado_orden').val();
            var nombre_banco_abonar=$('#nombre_banco_abonar').val();
            var a=0;
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('orden_descuentos/todos_desc_empleado')?>',
                async : false,
                dataType : 'JSON',
                data : {id_empleado_orden:id_empleado_orden,nombre_banco_abonar:nombre_banco_abonar},
                success : function(data){
                if ($('#nombre_banco_abonar').val()==0) {
                    $('#cuota_abono').val('');
                }else{
                    cuota=parseFloat(data.cuota).toFixed(2);
                    document.getElementById('validacion_banco1').innerHTML = '';
                    document.getElementById('validacion_cuota1').innerHTML = '';
                    $('#cuota_abono').val(cuota);
                    $('#id_orden').val(data.id_orden_descuento); 
                    if (data.id_orden_descuento==3) {
                        document.getElementById('validacion_cuota1').innerHTML += "";
                        document.getElementById('validacion_cuota1').innerHTML += "";
                    } 
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 2){
                        document.getElementById('validacion_banco1').innerHTML += "Seleccione un banco";
                    }
                }
                }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        });

        $('#btn_abonar').on('click',function(){
             var id_contrato = $('#id_empleado_orden').val();
            var cuota_abono = $('#cuota_abono').val();
            var nombre_banco_abonar = $('#nombre_banco_abonar').val();
            var id_orden =$('#id_orden').val();
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('orden_descuentos/abonos')?>",
                dataType : "JSON",
                data : {cuota_abono:cuota_abono,nombre_banco_abonar:nombre_banco_abonar,id_orden:id_orden,id_contrato:id_contrato},
                success: function(data){
                    console.log(data);
                if ((data==null)) {
                document.getElementById('validacion_banco1').innerHTML = '';
                document.getElementById('validacion_cuota1').innerHTML = '';
                alert("El ingreso se Realizo Correctamente, Por Favor Cierre La Ventana");
                this.disabled=false;
                location.reload(true);
                show_area();
            }else{
                document.getElementById('validacion_banco1').innerHTML = '';
                document.getElementById('validacion_cuota1').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 1){
                        document.getElementById('validacion_banco1').innerHTML += "Seleccione un banco";
                    }
                    if(data[i] == 2){
                        document.getElementById('validacion_cuota1').innerHTML += "";
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
        });//fin de la funcion crear horas extras 



    });
</script>
</body>

</html>

