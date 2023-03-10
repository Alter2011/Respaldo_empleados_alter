<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Tipos de Prestamos Personales</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre Prestamo</th>
                                    <th style="text-align:center;">Porcentaje</th>
                                    <th style="text-align:center;">Desde</th>
                                    <th style="text-align:center;">Hasta</th>
                                    <th style="text-align:center;">Fecha de Creacion</th>
                                    <th style="text-align:center;">Fecha de Actualizacion</th>      
                                    <th style="text-align: right;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php
                              
                                foreach ($personales as $personal) {
                                   if($personal->fecha_actualizacion == null){
                                    $fecha = "No Actualizada";
                                   }else{
                                    $fecha = $personal->fecha_actualizacion;
                                   }
                                   echo "<tr>";
                                   echo "<td>".$personal->nombre_tipos."</td>";
                                   echo "<td>".number_format($personal->porcentaje*100,2)."%</td>";
                                   echo "<td>$".number_format($personal->desde,2)."</td>";
                                   echo "<td>$".number_format($personal->hasta,2)."</td>";
                                   echo "<td>".$personal->fecha_creacion."</td>";
                                   echo "<td>".$fecha."</td>";
                                   echo '<td style="text-align:right;"><a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_tipo="'.$personal->id_prest_personales.'"> Editar </a>';
                                   echo ' <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$personal->id_prest_personales.'"> Eliminar </td></a>';
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tipo de Prestamos Personales</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_prestamo" id="nombre_prestamo" class="form-control" placeholder="Ingrese Tipo de Prestamos Personal">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_prestamo" id="porcentaje_prestamo" class="form-control" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Desde donde Aplica:</label>
                    <div class="col-md-10">
                        <input type="text" name="desde_prestamo" id="desde_prestamo" class="form-control" placeholder="0.00">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta donde Aplica:</label>
                    <div class="col-md-10">
                        <input type="text" name="hasta_prestamo" id="hasta_prestamo" class="form-control" placeholder="0.00">
                        <div id="validacion4" style="color:red"></div>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Tipo de Prestamo Personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <!--
                <label class="col-md-2 col-form-label">Product Code</label>
-->
                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
           <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Ingrese Tipo de Prestamos Personal">
                        <div id="validacion_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_edit" id="porcentaje_edit" class="form-control" placeholder="0.00">
                        <div id="validacion2_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Desde donde Aplica:</label>
                    <div class="col-md-10">
                        <input type="text" name="desde_edit" id="desde_edit" class="form-control" placeholder="0.00">
                        <div id="validacion3_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta donde Aplica:</label>
                    <div class="col-md-10">
                        <input type="text" name="hasta_edit" id="hasta_edit" class="form-control" placeholder="0.00">
                        <div id="validacion4_edit" style="color:red"></div>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Tipo de Prestamo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que Desea Eliminar Este Tipo de Prestamos?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="tipo_code_delete" id="tipo_code_delete" class="form-control" readonly>
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

        //Metooo para e ingreso 
        $('#btn_save').on('click',function(){
            var nombre = $('#nombre_prestamo').val();
            var porcentaje = $('#porcentaje_prestamo').val();
            var desde = $('#desde_prestamo').val();
            var hasta = $('#hasta_prestamo').val();
            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/insertTipoPrest')?>",
                dataType : "JSON",
                data : {nombre:nombre,porcentaje:porcentaje,desde:desde,hasta:hasta},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';

                        $('[name="nombre_prestamo"]').val("");
                        $('[name="porcentaje_prestamo"]').val("");
                        $('[name="desde_prestamo"]').val("");
                        $('[name="hasta_prestamo"]').val("");

                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Tipo de Prestamo Personal";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Porcentaje del Tipo de Prestamo";

                            }else if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Porcentaje del Tipo de Prestamo de Forma correcta(0.00)";

                            }else if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML += "Solo se aceptan porcetanjes de 0 a 100";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar Desde Donde Aplica";
                            }else if(data[i] == 6){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar Desde Donde Aplica de Forma Correcta(0.00)";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion4').innerHTML += "Debe de Ingresar Hasta Donde Aplica";

                            }else if(data[i] == 8){
                                document.getElementById('validacion4').innerHTML += "Debe de Ingresar Hasta Donde Aplica de Forma Correcta(0.00)";

                            }else if(data[i] == 9){
                                document.getElementById('validacion3').innerHTML += "El Desde donde aplica Tine que ser Menor que el Hasta";

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


        //Metodo para llenar los campos de modificar
        $('.item_edit').click(function(){
           var code = $(this).data('id_tipo');
          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/buscarTipos')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="code_edit"]').val(code);
                    $('[name="nombre_edit"]').val(data[0].nombre_tipos);
                    $('[name="porcentaje_edit"]').val(data[0].porcentaje);
                    $('[name="desde_edit"]').val(data[0].desde);
                    $('[name="hasta_edit"]').val(data[0].hasta);

                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';
                    document.getElementById('validacion4_edit').innerHTML = '';
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
         });//fin llenado de modal editar

        //metodo para modificar 
        $('#btn_update').on('click',function(){
            var code = $('#code_edit').val();
            var nombre = $('#nombre_edit').val();
            var porcentaje = $('#porcentaje_edit').val();
            var desde = $('#desde_edit').val();
            var hasta = $('#hasta_edit').val();
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/updateTipoPrest')?>",
                dataType : "JSON",
                data : {code:code,nombre:nombre,porcentaje:porcentaje,desde:desde,hasta:hasta},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';

                        $('[name="code_edit"]').val("");
                        $('[name="nombre_edit"]').val("");
                        $('[name="porcentaje_edit"]').val("");
                        $('[name="desde_edit"]').val("");
                        $('[name="hasta_edit"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';

                       for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre del Tipo de Prestamo Personal";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar el Porcentaje del Tipo de Prestamo";

                            }else if(data[i] == 3){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar el Porcentaje del Tipo de Prestamo de Forma correcta(0.00)";

                            }else if(data[i] == 4){
                                document.getElementById('validacion2_edit').innerHTML += "Solo se aceptan porcetanjes de 0 a 100";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion3_edit').innerHTML += "Debe de Ingresar Desde Donde Aplica";
                            }else if(data[i] == 6){
                                document.getElementById('validacion3_edit').innerHTML += "Debe de Ingresar Desde Donde Aplica de Forma Correcta(0.00)";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion4_edit').innerHTML += "Debe de Ingresar Hasta Donde Aplica";

                            }else if(data[i] == 8){
                                document.getElementById('validacion4_edit').innerHTML += "Debe de Ingresar Hasta Donde Aplica de Forma Correcta(0.00)";

                            }else if(data[i] == 9){
                                document.getElementById('validacion3_edit').innerHTML += "El Desde donde aplica Tine que ser Menor que el Hasta";

                            }
                        }//Fin For
                    }//fin if else data == null
                    
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
                $('[name="tipo_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#tipo_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PrestamosPersonales/deleteTipoPrest')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="tipo_code_delete"]').val("");
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
        });//Fin metodo eliminar 

    });
</script>
</body>

</html> 