 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Descuentos de Ley</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Descuento</th>      
                                    <th style="text-align:center;">Porcentaje</th>
                                    <th style="text-align:center;">Aplica</th>
                                    <th style="text-align:center;">Techo</th>
                                    <th style="text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descuento:</label>
                    <div class="col-md-10">
                        <input type="text" name="descuento_name" id="descuento_name" class="form-control" placeholder="Ingrese la nuevo descuento">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_name" id="porcentaje_name" class="form-control numbers" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
            </div>
            
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Techo del Descuento:</label>
                    <div class="col-md-10">
                        <input type="text" name="techo_name" id="techo_name" class="form-control" placeholder="0.00">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>
            </div>

             <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Aplica a:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_name" id="aplica_name" class="form-control">
                            <option value="Empleado">Empleado</option>
                            <option value="Empleador">Empleador</option>
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


 <!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="des_code_edit" id="des_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Descuento:</label>
                <div class="col-md-10">
                    <input type="text" name="descuento_edit" id="descuento_edit" class="form-control" placeholder="Ingresa cambio de descuentos" readonly>
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Porcentaje:</label>
                <div class="col-md-10">
                    <input type="text" name="porcentaje_edit" id="porcentaje_edit" class="form-control" placeholder="Ingresa cambio de porcentaje">
                     <div id="validacion2_Edit" style="color:red"></div>
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Techo del Descuento:</label>
                <div class="col-md-10">
                    <input type="text" name="techo_edit" id="techo_edit" class="form-control" placeholder="Ingresa cambio de techo">
                     <div id="validacion3_Edit" style="color:red"></div>
                </div>
            </div>

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Aplica a:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_edit" id="aplica_edit" class="form-control">
                            <option value="Empleado">Empleado</option>
                            <option value="Empleador">Empleador</option>
                        </select>
                    </div>
                </div>

            </div>           
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Descuento</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="des_code_delete" id="des_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->

<script type="text/javascript">
    $(document).ready(function(){

        //Metodo para validar numeros decimales
        function validateDecimal(valor) {
            var RE = /^\d*(\.\d{1})?\d{0,5}$/;
            if (RE.test(valor)) {
                return true;
            } else {
                return false;
            }
        }

    
    show_data();
    function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('descuentos/listaDescuentos')?>',
                async : false,
                dataType : 'JSON',
                data : {},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.nombre_descuento+'</td>'+//Agencia
                                '<td>'+registro.porcentaje+'%</td>'+//nombrePlaza
                                '<td>'+registro.aplica+'</td>'+//estado
                                '<td>'+registro.techo+'</td>'+//agencia
                                '<td style="text-align:right;">'+
                                    '<a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_descuentos="'+registro.id_descuentos+'">Editar</a>'+                                   
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
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }
             
    //Metooo para e ingreso de los descuentos
     $('#btn_save').on('click',function(){
        var descuento_name = $('#descuento_name').val();
        var porcentaje_name = $('#porcentaje_name').val();
        var techo_name = $('#techo_name').val();
        var aplica = $('#aplica_name').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('descuentos/saveDes')?>",
                dataType : "JSON",
                data : {descuento_name:descuento_name,porcentaje_name:porcentaje_name,techo_name:techo_name,aplica:aplica},
                success: function(data){
                if ((data==null)) {
                    document.getElementById('validacion').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';
                    //alert('La insercion se hizo correctamente');
                    $('[name="descuento_name"]').val("");
                    $('[name="porcentaje_name"]').val("");
                    $('[name="techo_name"]').val("");
                    $('[name="aplica_name"]').val("");

                    location.reload();
                    this.disabled=false;
                    show_area();
                }else{
                document.getElementById('validacion').innerHTML = '';
                document.getElementById('validacion2').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';

                    for (i = 0; i <= data.length-1; i++){
                    if(data[i] == 1){
                        document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Descuento";
                    }

                    if(data[i] == 2){
                        document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Porcentaje";
                    }
                    if(data[i] == 4){
                        document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Porcentaje en Forma Correcta (0.00)";
                    }
                    if(data[i] == 3){
                        document.getElementById('validacion3').innerHTML += "Debe de Ingresar el Techo del Descuento";
                    }
                        if(data[i] == 5){
                        document.getElementById('validacion3').innerHTML += "Debe de Ingresar el Techo del Descuento de Forma Correcta (0.00)";
                    }
                }//Fin For
            }//fin if else
        },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
            }
        });
        return false;
    });//fin de insercionde descuentos

    //Metodo para llenar los campos de modificar
    $('.item_edit').click(function(){
    document.getElementById('validacion_Edit').innerHTML = '';
    document.getElementById('validacion2_Edit').innerHTML = '';
    document.getElementById('validacion3_Edit').innerHTML = '';
    var code = $(this).data('id_descuentos');
    $.ajax({
        type : "POST",
        url  : "<?php echo site_url('descuentos/llenarEdit')?>",
        dataType : "JSON",
        data : {code:code},
        success: function(data){
            $('[name="des_code_edit"]').val(data[0].id_descuentos);
            $('[name="descuento_edit"]').val(data[0].nombre_descuento);
            $('[name="porcentaje_edit"]').val(data[0].porcentaje);
            $('[name="techo_edit"]').val(data[0].techo);
                    
            if(data[0].aplica == 'Empleado'){
                $("#aplica_edit option[value='Empleado']").attr("selected",true);
                $("#aplica_edit option[value='Empleador']").attr("selected",false);
            }else{
                $("#aplica_edit option[value='Empleador']").attr("selected",true);
                $("#aplica_edit option[value='Empleado']").attr("selected",false);
            }
                    
            $('#Modal_Edit').modal('show');

        },  
        error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
            this.disabled=false;
        }
    });

    });//fin llenado de modal editar

        //metodo para modificar los descuentos
        $('#btn_update').on('click',function(){
            var code = $('#des_code_edit').val();
            var nombreDescuento = $('#descuento_edit').val();
            var porcentaje = $('#porcentaje_edit').val();
            var techo = $('#techo_edit').val().replace(",", "");
            var aplica = $('#aplica_edit').val();
                        $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('descuentos/updateDes')?>",
                        dataType : "JSON",
                        data : {code:code, nombreDescuento:nombreDescuento,porcentaje:porcentaje,techo:techo,aplica:aplica},
                        success: function(data){

                            if(data==null){
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';
                                document.getElementById('validacion3_Edit').innerHTML = '';

                                $('[name="des_code_edit"]').val("");
                                $('[name="descuento_edit"]').val("");
                                $('[name="porcentaje_edit"]').val("");
                                $('[name="techo_edit"]').val("");

                                $('#Modal_Edit').modal('toggle');
                                $('.modal-backdrop').remove();
                                location.reload();

                                show_data();
                            }else{
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';
                                document.getElementById('validacion3_Edit').innerHTML = '';

                                for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar el Nombre del Descuento";
                                }

                                if(data[i] == 2){
                                    document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar el Porcentaje";
                                }
                                if(data[i] == 4){
                                    document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar el Porcentaje en Forma Correcta (0.00)";
                                }
                                if(data[i] == 3){
                                    document.getElementById('validacion3_Edit').innerHTML += "Debe de Ingresar el Techo del Descuento";
                                }
                                 if(data[i] == 5){
                                    document.getElementById('validacion3_Edit').innerHTML += "Debe de Ingresar el Techo del Descuento de Forma Correcta (0.00)";
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

         //se obtiene el id para poder eliminar
        $('.item_delete').click(function(){
            var code   = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="des_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar el descuento
         $('#btn_delete').on('click',function(){
            var code = $('#des_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('descuentos/deleteDes')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="des_code_delete"]').val("");
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
        });//Fin metodo eliminar descuento

    });
</script>
</body>

</html>