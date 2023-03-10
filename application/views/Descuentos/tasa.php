 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Tasa y Primas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">

                       <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre</th>      
                                    <th style="text-align:center;">Tipo</th>      
                                    <th style="text-align:center;">Porcentaje</th>
                                    <th style="text-align:center;">Fecha de Cracion</th>
                                    <th style="text-align:center;">Fecha de Actualizacion</th>
                                    <th style="text-align:center;">Descripcion</th>
                                    <th style="text-align:center;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php
                              $i = 0;
                                foreach ($tasas as $tasa) {
                                   
                                   if($tasa->tipo_tasa == 1){
                                        $type = 'Prestamo';
                                   }else if($tasa->tipo_tasa == 2){
                                        $type = 'Horas Extras Diurnas';
                                   }else if($tasa->tipo_tasa == 3){
                                        $type = 'Horas Extras Nocturnas';
                                   }else if($tasa->tipo_tasa == 4){
                                        $type = 'Vacacion';
                                   }

                                   echo "<tr>";
                                   echo "<td>".$tasa->nombre."</td>";
                                   echo "<td>".$type."</td>";
                                   echo "<td>".number_format($tasa->tasa*100,2)."%</td>";
                                   echo "<td>".$tasa->fecha."</td>";
                                   echo "<td>".$tasa->fecha_modificacion."</td>";
                                   echo "<td>".$tasa->descripcion."</td>";
                                   echo '<td style="text-align:right;">';
                                   echo '<a data-toggle="modal" id='.$tasa->tipo_tasa.' class="btn btn-info btn-sm item_edit" data-id_descuentos="'.$tasa->id_tasa.'"> Editar </a>';
                                   if($tasa->tipo_tasa != 4){ 
                                   echo ' <a  data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$tasa->id_tasa.'"> Eliminar </a>'; 
                                   }
                                   echo '</td>';
                                   echo "</tr>";

                                   $i++;
                                };


                                 ?>
                            </tbody>
                        </table>

                    </div>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Tasa o Prima</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre Tasa/Prima:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_tasa" id="nombre_tasa" class="form-control" placeholder="Ingrese Tasa/Prima">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_tasa" id="tipo_tasa" class="form-control">
                            <option value="1">Prestamo</option>
                            <option value="2">Horas Extras Diurnas</option>
                            <option value="3">Horas Extras Nocturnas</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje de Interes:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_tasa" id="porcentaje_tasa" class="form-control" placeholder="Ingrese Porcentaje de Interes">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
           
                 <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripcion:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control" id="descripcion_tasa" name="descripcion_tasa"></textarea>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Tasa/Prima</h3>
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
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" readonly>
                    <input type="hidden" name="nombre_hide" id="nombre_hide" class="form-control" readonly>
                    <input type="hidden" name="tipo_hide" id="tipo_hide" class="form-control" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre Tasa/Prima:</label>
                <div class="col-md-10">
                    <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Nombre de Tasa/Prima">
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row" id="tipo">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_edit" id="tipo_edit" class="form-control">
                            <option value="1">Prestamo</option>
                            <option value="2">Horas Extras Diurnas</option>
                            <option value="3">Horas Extras Nocturnas</option>
                        </select>
                    </div>
                </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Porcentaje de Interes:</label>
                <div class="col-md-10">
                    <input type="text" name="tasa_edit" id="tasa_edit" class="form-control" placeholder="0.00">
                     <div id="validacion1_Edit" style="color:red"></div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Descripcion:</label>
                <div class="col-md-10">
                    <textarea class="md-textarea form-control" name="decripcion_edit" id="decripcion_edit"></textarea>
                     <div id="validacion2_Edit" style="color:red"></div>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Tasa/Prima</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="tasa_code_delete" id="tasa_code_delete" class="form-control" readonly>
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
            var nombre_tasa = $('#nombre_tasa').val();
            var tipo_tasa = $('#tipo_tasa').val();
            var porcentaje_tasa = $('#porcentaje_tasa').val();
            var descripcion_tasa = $('#descripcion_tasa').val();
            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('tasa/saveTasa')?>",
                dataType : "JSON",
                data : {nombre_tasa:nombre_tasa,tipo_tasa:tipo_tasa,porcentaje_tasa:porcentaje_tasa,descripcion_tasa:descripcion_tasa},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        $('[name="nombre_tasa"]').val("");
                        $('[name="porcentaje_tasa"]').val("");
                        $('[name="descripcion_tasa"]').val("");

                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{

                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el nombre de la Tasa/Prima";

                            }else if(data[i] == 7){
                                document.getElementById('validacion').innerHTML += "Esta Tasa/Prima ya existe";

                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Tasa/Prima";
                            }else if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML = "Debe de Ingresar la Tasa/Prima de Forma Correcta (0.00)";
                            }else if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML = "Solo se Permite la Tasa/Prima del 0 al 100 %";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar la descripcion de la Tasa/Prima";
                            }else if(data[i] == 6){
                                document.getElementById('validacion3').innerHTML += "Solo se permiten un maximo de 300 carracteres (cuentan los espacios)";
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
         $('.item_edit').click(function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            document.getElementById('validacion1_Edit').innerHTML = '';
            document.getElementById('validacion2_Edit').innerHTML = '';
            var code   = $(this).data('id_descuentos');
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('tasa/llanarEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="code_edit"]').val(data[0].id_tasa);
                    $('[name="nombre_edit"]').val(data[0].nombre);
                    $('[name="nombre_hide"]').val(data[0].nombre);
                    $('[name="tasa_edit"]').val(data[0].tasa);
                    $('[name="decripcion_edit"]').val(data[0].descripcion);
                    $('[name="tipo_edit"]').val(data[0].tipo_tasa);

                    if(data[0].tipo_tasa == 4){
                        $("#tipo").css("display", "none");
                        $('[name="tipo_hide"]').val(1);
                    }else{
                        $("#tipo").css("display", "block");
                        $('[name="tipo_hide"]').val(0);
                    }
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            
        });

         //metodo para modificar los descuentos
        $('#btn_update').on('click',function(){
            var code = $('#code_edit').val();
            var tasa_edit = $('#tasa_edit').val();
            var nombre_edit = $('#nombre_edit').val();
            var decripcion_edit = $('#decripcion_edit').val();
            var nombre_hide = $('#nombre_hide').val();
            var tipo_edit = $('#tipo_edit').val();
            var tipo_hide = $('#tipo_hide').val();

            var estado = 0;
            if(nombre_edit == nombre_hide){
                estado = 1;
            }
            //alert(tasa_edit);
                        $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('tasa/updateTasa')?>",
                        dataType : "JSON",
                        data : {code:code,tasa_edit:tasa_edit,nombre_edit:nombre_edit,decripcion_edit:decripcion_edit,estado:estado,tipo_edit:tipo_edit,tipo_hide:tipo_hide},
                        success: function(data){
                            console.log(data);
                            if(data==null){
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion1_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';

                                $('[name="code_edit"]').val("");
                                $('[name="nombre_edit"]').val("");
                                $('[name="tasa_edit"]').val("");
                                $('[name="decripcion_edit"]').val("");
                                $('[name="nombre_hide"]').val("");
                                $('[name="tipo_edit"]').val(1);

                                $('#Modal_Edit').modal('toggle');
                                $('.modal-backdrop').remove();
                                location.reload();

                                show_data();
                            }else{
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion1_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';

                                for (i = 0; i <= data.length-1; i++){
                                    if(data[i] == 1){
                                        document.getElementById('validacion1_Edit').innerHTML += "Debe de Ingresar la Tasa/Prima";

                                    }

                                    if(data[i] == 2){
                                        document.getElementById('validacion1_Edit').innerHTML = "Debe de Ingresar la Tasa/Prima de Forma Correcta (0.00)";
                                    }
                                     if(data[i] == 3){
                                        document.getElementById('validacion1_Edit').innerHTML = "Solo se Permite la Tasa/Prima del 0 al 100 %";
                                    }
                                    if(data[i] == 4){
                                        document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar el nombre de la Tasa/Prima";
                                    }else if(data[i] == 7){
                                        document.getElementById('validacion_Edit').innerHTML += "Esta Tasa/Prima ya existe";

                                    }
                                    if(data[i] == 5){
                                        document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar la descripcion de la Tasa/Prima";
                                    }
                                    if(data[i] == 6){
                                        document.getElementById('validacion2_Edit').innerHTML += "Solo se permiten un maximo de 300 carracteres (cuentan los espacios)";
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
                $('[name="tasa_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#tasa_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('tasa/deleteTasa')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="tasa_code_delete"]').val("");
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