<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Tiempo de Renta</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre</th>      
                                    <th style="text-align:center;">Unidad</th>
                                    <th style="text-align:center;">Total a Trabajar</th>
                                    <th style="text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php
                              
                                foreach ($tiempos as $tiempo) {
                                   
                                   echo "<tr>";
                                   echo "<td>".$tiempo->nombre."</td>";
                                   echo "<td>".$tiempo->unidad_basica."</td>";
                                   echo "<td>".$tiempo->total_trabajo."</td>";
                                   echo '<td style="text-align:right;"><a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_tiempo="'.$tiempo->id_tiempo.'"> Editar </a>';
                                   echo ' <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$tiempo->id_tiempo.'"> Eliminar </a></td>';
                                   echo "</tr>";
                                };


                                 ?>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tiempo Para la Renta</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
           <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_name" id="nombre_name" class="form-control" placeholder="Nombre del Tiempo">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Unidad:</label>
                    <div class="col-md-10">
                        <input type="text" name="unidad_name" id="unidad_name" class="form-control" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Total a Trabajar:</label>
                    <div class="col-md-10">
                        <input type="text" name="total_name" id="total_name" class="form-control" placeholder="0.00">
                        <div id="validacion3" style="color:red"></div>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Tiempo de Renta</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
             <div class="col-md-10">
                    <input type="hidden" name="tiempo_code_edit" id="tiempo_code_edit" class="form-control" placeholder="Product Code" readonly>
                    <input type="hidden" name="nombre_Tiempo" id="nombre_Tiempo" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre:</label>
                <div class="col-md-10">
                    <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Ingresa cambio de descuentos">
                    <div id="validacion_edit" style="color:red"></div>
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Unidad:</label>
                <div class="col-md-10">
                    <input type="text" name="unidad_edit" id="unidad_edit" class="form-control" placeholder="Ingresa cambio de porcentaje">
                    <div id="validacion2_edit" style="color:red"></div>
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Total a Trabaja:</label>
                <div class="col-md-10">
                    <input type="text" name="total_edit" id="total_edit" class="form-control" placeholder="Ingresa cambio de techo">
                    <div id="validacion3_edit" style="color:red"></div>
                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
            </div>

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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Tiempo de Renta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="tiempo_code_delete" id="tiempo_code_delete" class="form-control" readonly>
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
        //Metooo para e ingreso de los descuentos
        $('#btn_save').on('click',function(){
            var nombre_name = $('#nombre_name').val();
            var unidad_name = $('#unidad_name').val();
            var total_name = $('#total_name').val();
            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('TiempoRenta/seveTiempo')?>",
                dataType : "JSON",
                data : {nombre_name:nombre_name,unidad_name:unidad_name,total_name:total_name},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        $('[name="nombre_name"]').val("");
                        $('[name="unidad_name"]').val("");
                        $('[name="total_name"]').val("");
                        
                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Tiempo de Renta";
                            }
                             if(data[i] == 4){
                                document.getElementById('validacion').innerHTML += "El Nombre del Tiempo de Renta Ya Existe";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Unidad";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Unidad de Forma Correcta (0.00)";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar el Total a Trabajar";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar el Total a Trabajar en Forma Correcta (0.00)";
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
        });//fin de insercionde descuentos

        //Metodo para llenar los campos de modificar
        $('.item_edit').click(function(){
           var code = $(this).data('id_tiempo');

           document.getElementById('validacion_edit').innerHTML = '';
            document.getElementById('validacion2_edit').innerHTML = '';
            document.getElementById('validacion3_edit').innerHTML = '';

          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('TiempoRenta/llenarEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="tiempo_code_edit"]').val(data[0].id_tiempo);
                    $('[name="nombre_edit"]').val(data[0].nombre);
                    $('[name="nombre_Tiempo"]').val(data[0].nombre);
                    $('[name="unidad_edit"]').val(data[0].unidad_basica);
                    $('[name="total_edit"]').val(data[0].total_trabajo);
                    
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
            var code = $('#tiempo_code_edit').val();
            var nombreTiempo = $('#nombre_edit').val();
            var nombre = $('#nombre_Tiempo').val();
            var unidad = $('#unidad_edit').val();
            var total = $('#total_edit').val();
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('TiempoRenta/updateTiempo')?>",
                dataType : "JSON",
                data : {code:code,nombreTiempo:nombreTiempo,nombre:nombre,unidad:unidad,total:total},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';

                        $('[name="tiempo_code_edit"]').val("");
                        $('[name="nombre_edit"]').val("");
                        $('[name="unidad_edit"]').val("");
                        $('[name="total_edit"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();
                        show_data();
                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre del Tiempo de Renta";
                            }
                             if(data[i] == 4){
                                document.getElementById('validacion_edit').innerHTML += "El Nombre del Tiempo de Renta Ya Existe";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar la Unidad";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar la Unidad de Forma Correcta (0.00)";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3_edit').innerHTML += "Debe de Ingresar el Total a Trabajar";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion3_edit').innerHTML += "Debe de Ingresar el Total a Trabajar en Forma Correcta (0.00)";
                            }
                        }
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
                $('[name="tiempo_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar el descuento
         $('#btn_delete').on('click',function(){
            var code = $('#tiempo_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('TiempoRenta/deleteTiempo')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="tiempo_code_delete"]').val("");
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