<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Modelos Telefonos</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a onclick="limpiar()" href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo Modelo</a><?php ?><br><br></nav>

                         <div>
                        <label class="col-md-2 col-form-label">Buscar Marca:</label>
                        <div class="col-md-3">
                        <select class="form-control" id="marca" name="marca" >                                       
                        <?php
                        foreach($ver_marcas as $fila){
                            echo "<option value=".$fila->id_marca.">".$fila->nombre_marca."</option>";
                        }  
                        ?>
                        </select>
                        </div>  
                        <button type="button" title="Seleccionar marca" onclick="seleccionar_marca()" class="btn btn-default">
                        <span class="glyphicon glyphicon-time"></span> 
                        </button>
                        </div>
                        <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>
                                   <th style="text-align:left;">Marca</th>
                                   <th style="text-align:left;">Modelo</th>
                                   <th style="text-align:left;">Peso (g)</th>
                                   <th style="text-align:left;">Tamaño (in)</th>
                                   <th style="text-align:left;">RAM</th>
                                   <th style="text-align:left;">Memoria interna</th>
                                   <th style="text-align:left;">Precio</th>
                                   <th style="text-align:left;">Bateria</th>
                                   <th style="text-align:left;">Camaras</th>
                                   <th style="text-align:left;">Gama</th>            

                                   <th style="text-align:left;">Acciones</th>

                                </tr>
                            </thead>
                            <tbody class="show_data" id="show_data">
                                <?php

                               foreach ($tipos as $tipo) {

                                 if($tipo->gama == '1'){
                                    $tipo->gama = 'Baja';
                                }elseif($tipo->gama == '2'){
                                    $tipo->gama = 'Media-Baja';
                                }elseif($tipo->gama == '3'){
                                    $tipo->gama = 'Media';
                                }elseif($tipo->gama == '4'){
                                    $tipo->gama = 'Media-Alta';
                                }elseif($tipo->gama == '5'){
                                    $tipo->gama = 'Alta';
                                }elseif($tipo->gama == '6'){
                                    $tipo->gama = 'Ultra';
                                }elseif($tipo->gama == '7'){
                                    $tipo->gama = 'Ultra Plus';
                                }


                                   echo "<tr>";
                                   echo "<td class='marca' style='text-align: left;'>".$tipo->nombre_marca."</td>";
                                   echo "<td class='modelo' style='text-align: left;'>".$tipo->nombre_modelo."</td>";
                                   echo "<td class='peso' style='text-align: left;'>".$tipo->peso." gramos</td>";
                                   echo "<td class='peso' style='text-align: left;'>".$tipo->tamaño." pulgadas</td>";
                                   echo "<td class='peso' style='text-align: left;'>".$tipo->ram."</td>";
                                   echo "<td class='peso' style='text-align: center;'>".$tipo->rom."</td>";
                                   echo "<td class='peso' style='text-align: left;'>" . '$' .$tipo->precio."</td>";

                                   echo "<td class='peso' style='text-align: left;'>".$tipo->bateria."</td>";
                                   echo "<td class='peso' style='text-align: left;'>".$tipo->camaras."</td>";
                                   echo "<td class='peso' style='text-align: left;'>".$tipo->gama."</td>";
                        

                                   echo '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->id_modelo.'">Editar</a></td>';

                                   //echo '<td><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_delete" id="'.$tipo->id_modelo.'">Eliminar</a></td>';
    
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

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Modelo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            
            <div id="validacion1" style="color:red"></div>
            <div id="validacion2" style="color:red"></div>
            <div id="validacion3" style="color:red"></div>
            <div id="validacion4" style="color:red"></div>
            <div id="validacion5" style="color:red"></div>
            <div id="validacion6" style="color:red"></div>
            <div id="validacion7" style="color:red"></div>
            <div id="validacion8" style="color:red"></div>
            <div id="validacion9" style="color:red"></div>
            <div id="validacion10" style="color:red"></div>
            <div id="validacion11" style="color:red"></div>
            <div id="validacion12" style="color:red"></div>
            <div id="validacion13" style="color:red"></div>
            <div id="validacion14" style="color:red"></div>
            <div id="validacion15" style="color:red"></div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Marca:</label>
                    <div class="col-md-7">
                    <select class="form-control" id="telefonos" name="telefonos" >                                       
                     <?php
                        foreach($ver_marcas as $fila){
                            echo "<option value=".$fila->id_marca.">".$fila->nombre_marca."</option>";
                        }  
                        ?>
                        </select>
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Modelo:</label>
                    <div class="col-md-7">
                    <input type="text" name="modelo" id="modelo" class="form-control" placeholder="Ingrese el modelo">
                </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Peso (g):</label>
                    <div class="col-md-7">
                    <input type="text" name="peso" id="peso" class="form-control" placeholder="Ingrese el peso en gramos">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tamaño (in):</label>
                    <div class="col-md-7">
                    <input type="text" name="tamaño" id="tamaño" class="form-control" placeholder="Ingrese el tamaño en pulgadas">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">RAM:</label>
                    <div class="col-md-7">
                    <input type="text" name="ram" id="ram" class="form-control" placeholder="Ingresa la memoria RAM">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Memoria interna:</label>
                    <div class="col-md-7">
                    <input type="text" name="rom" id="rom" class="form-control" placeholder="Ingrese la memoria interna">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Precio ($):</label>
                    <div class="col-md-7">
                    <input type="text" name="precio" id="precio" class="form-control" placeholder="Ingrese el precio">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Bateria:</label>
                    <div class="col-md-7">
                    <input type="text" name="bateria" id="bateria" class="form-control" placeholder="Ingrese la bateria">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Camaras:</label>
                    <div class="col-md-7">
                    <input type="text" name="camaras" id="camaras" class="form-control" placeholder="Ingrese la o las camaras (principal, frontal, secundarias) ">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Gama:</label>
                    <div class="col-md-7">
                    <select class="form-control" name="gama" id="gama">
                        <option value="">--- Elige una opcion ---</option>
                        <option value="1">Baja</option>
                        <option value="2">Media-Baja</option>
                        <option value="3">Media</option>
                        <option value="4">Media-Alta</option>
                        <option value="5">Alta</option>
                        <option value="6">Ultra</option>
                        <option value="7">Ultra Plus</option>
                    </select>
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
        </div>

</form>
<!--END MODAL ADD-->


 <!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Modelo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div id="validacion_edit" style="color:red"></div>
            <div id="validacion2_edit" style="color:red"></div>
            <div id="validacion3_edit" style="color:red"></div>
            <div id="validacion4_edit" style="color:red"></div>
            <div id="validacion5_edit" style="color:red"></div>
            <div id="validacion6_edit" style="color:red"></div>
            <div id="validacion7_edit" style="color:red"></div>
            <div id="validacion8_edit" style="color:red"></div>
            <div id="validacion9_edit" style="color:red"></div>
            <div id="validacion10_edit" style="color:red"></div>
            <div id="validacion11_edit" style="color:red"></div>
            <div id="validacion12_edit" style="color:red"></div>
            <div id="validacion13_edit" style="color:red"></div>
            <div id="validacion14_edit" style="color:red"></div>
            <div id="validacion15_edit" style="color:red"></div>

             <input type="hidden" name="tipo_code_edit" id="tipo_code_edit" class="form-control" readonly>

            <div class="modal-body">
            <div class="form-group row">
                    <label class="col-md-3 col-form-label">Marca:</label>
                    <div class="col-md-7">
                    <select class="form-control" id="telefonos_mod" name="telefonos_mod" >                                       
                     <?php
                        foreach($ver_marcas as $fila){
                            echo "<option value=".$fila->id_marca.">".$fila->nombre_marca."</option>";
                        }  
                        ?>
                        </select>
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Modelo:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_modelo" id="edit_modelo" class="form-control" placeholder="Ingrese el modelo">
                    </div>
                </div>

                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Peso (g):</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_peso" id="edit_peso" class="form-control" placeholder="Ingrese el peso en gramos">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tamaño (in):</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_tamaño" id="edit_tamaño" class="form-control" placeholder="Ingrese el tamaño en pulgadas">

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">RAM:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_ram" id="edit_ram" class="form-control" placeholder="Ingrese la memoria RAM">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Memoria interna:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_rom" id="edit_rom" class="form-control" placeholder="Ingrese la memoria interna">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Precio ($):</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_precio" id="edit_precio" class="form-control" placeholder="Ingrese el precio">
                </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Bateria:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_bateria" id="edit_bateria" class="form-control" placeholder="Ingrese la bateria">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Camaras:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_camara" id="edit_camara" class="form-control" placeholder="Ingrese la o las camaras">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Gama:</label>
                <div class="col-md-7">
                    <select class="form-control" name="edit_gama" id="edit_gama">
                        <option value="">--- Elige una opcion ---</option>
                        <option value="1">Baja</option>
                        <option value="2">Media-Baja</option>
                        <option value="3">Media</option>
                        <option value="4">Media-Alta</option>
                        <option value="5">Alta</option>
                        <option value="6">Ultra</option>
                        <option value="7">Ultra Plus</option>
                    </select>
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

        <!--MODAL DELETE
        <form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Modelo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
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
        END MODAL DELETE-->


<script type="text/javascript">
      $(document).ready(function(){

    $('#mydata').dataTable( {
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
        } );

        //Metodo para el ingreso 
        $('#btn_save').on('click',function(){
            var marca = $('#telefonos').val();
            var modelo = $('#modelo').val();
            var peso = $('#peso').val();
            var tamaño = $('#tamaño').val();
            var ram = $('#ram').val();
            var rom = $('#rom').val();
            var precio = $('#precio').val();
            var bateria = $('#bateria').val();
            var camaras = $('#camaras').val();
            var gama = $('#gama').val();
           
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/save_modelo')?>",
                dataType : "JSON",
                data : {marca:marca,modelo:modelo,peso:peso,tamaño:tamaño,ram:ram,rom:rom,precio:precio,bateria:bateria,camaras:camaras,gama:gama},
                success: function(data){

                    if(data == null){
                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';
                    document.getElementById('validacion4').innerHTML = '';
                    document.getElementById('validacion5').innerHTML = '';
                    document.getElementById('validacion6').innerHTML = '';
                    document.getElementById('validacion7').innerHTML = '';
                    document.getElementById('validacion8').innerHTML = '';
                    document.getElementById('validacion9').innerHTML = '';
                    document.getElementById('validacion10').innerHTML = '';
                    document.getElementById('validacion11').innerHTML = '';
                    document.getElementById('validacion12').innerHTML = '';
                    document.getElementById('validacion13').innerHTML = '';
                    document.getElementById('validacion14').innerHTML = '';
                    document.getElementById('validacion15').innerHTML = '';

                        $('[name="marca"]').val("");
                        $('[name="modelo"]').val("");

                        $('#Modal_Add').modal('toggle');
                    
                        Swal.fire('Se ha agregado el registro con exito','','success')
                        .then(() => {
                            // Aquí la alerta se ha cerrado
                            location.reload();

                        });
               
                    }else{
                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';
                    document.getElementById('validacion4').innerHTML = '';
                    document.getElementById('validacion5').innerHTML = '';
                    document.getElementById('validacion6').innerHTML = '';
                    document.getElementById('validacion7').innerHTML = '';
                    document.getElementById('validacion8').innerHTML = '';
                    document.getElementById('validacion9').innerHTML = '';
                    document.getElementById('validacion10').innerHTML = '';
                    document.getElementById('validacion11').innerHTML = '';
                    document.getElementById('validacion12').innerHTML = '';
                    document.getElementById('validacion13').innerHTML = '';
                    document.getElementById('validacion14').innerHTML = '';
                    document.getElementById('validacion15').innerHTML = '';


                        for (i = 0; i <= data.length-1; i++){
                              if(data[i] == 1){
                                document.getElementById('validacion1').innerHTML += "Debe de ingresar un nombre de modelo";
                            }
                            
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe ingresar un peso";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3').innerHTML += "El peso debe ser un numero";
                            }if(data[i] == 4){
                                document.getElementById('validacion4').innerHTML += "El peso debe ser mayor a cero";
                            }if(data[i] == 5){
                                document.getElementById('validacion5').innerHTML += "Debe de ingresar un tamaño";
                            }if(data[i] == 6){
                                document.getElementById('validacion6').innerHTML += "El tamaño debe ser un numero ";
                            }if(data[i] == 7){
                                document.getElementById('validacion7').innerHTML += "El tamaño debe ser mayor a cero";
                            }if(data[i] == 8){
                                document.getElementById('validacion8').innerHTML += "Debe ingresar la memoria RAM";
                            }if(data[i] == 9){
                                document.getElementById('validacion9').innerHTML += "Debe ingresar la memoria interna";
                            }if(data[i] == 10){
                                document.getElementById('validacion10').innerHTML += "Debe ingresar un precio";
                            }if(data[i] == 11){
                                document.getElementById('validacion11').innerHTML += "El precio debe ser un numero";
                            }if(data[i] == 12){
                                document.getElementById('validacion12').innerHTML += "El precio debe ser mayor a cero";
                            }if(data[i] == 13){
                                document.getElementById('validacion13').innerHTML += "Debe ingresar la duracion de la bateria";
                            }if(data[i] == 14){
                                  document.getElementById('validacion14').innerHTML += "Debe de ingresar la capacidad de las camaras";
                            }if(data[i] == 15){
                                document.getElementById('validacion15').innerHTML += "Debe de ingresar la gama";
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


  
        //metodo para modificar 
        $('#btn_update').on('click',function(){

            var code = $('#tipo_code_edit').val();

            var marca = $('#telefonos_mod').val();
            var modelo = $('#edit_modelo').val();
            var peso = $('#edit_peso').val();
            var tamaño = $('#edit_tamaño').val();
            var ram = $('#edit_ram').val();
            var rom = $('#edit_rom').val();
            var precio = $('#edit_precio').val();
            var bateria = $('#edit_bateria').val();
            var camaras = $('#edit_camara').val();
            var gama = $('#edit_gama').val();


            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/update_modelo')?>",
                dataType : "JSON",
                data : {code:code,marca:marca,modelo:modelo,peso:peso,tamaño:tamaño,ram:ram,rom:rom,precio:precio,bateria:bateria,camaras:camaras,gama:gama},
                success: function(data){
                    if(data == null){
                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';
                    document.getElementById('validacion4_edit').innerHTML = '';
                    document.getElementById('validacion5_edit').innerHTML = '';
                    document.getElementById('validacion6_edit').innerHTML = '';
                    document.getElementById('validacion7_edit').innerHTML = '';
                    document.getElementById('validacion8_edit').innerHTML = '';
                    document.getElementById('validacion9_edit').innerHTML = '';
                    document.getElementById('validacion10_edit').innerHTML = '';
                    document.getElementById('validacion11_edit').innerHTML = '';
                    document.getElementById('validacion12_edit').innerHTML = '';
                    document.getElementById('validacion13_edit').innerHTML = '';
                    document.getElementById('validacion14_edit').innerHTML = '';
                    document.getElementById('validacion15_edit').innerHTML = '';

                    $('[name="telefonos_mod"]').val("");
                    $('[name="edit_modelo"]').val("");
        
                    $('.modal-backdrop').remove();
                    $('#Modal_Edit').modal('toggle');
                    

                        Swal.fire('Se ha modificado el registro con exito','','success')
                        .then(() => {
                            // Aquí se recarga la pagina
                            location.reload();

                        });

           
                    }else{
                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';
                    document.getElementById('validacion4_edit').innerHTML = '';
                    document.getElementById('validacion5_edit').innerHTML = '';
                    document.getElementById('validacion6_edit').innerHTML = '';
                    document.getElementById('validacion7_edit').innerHTML = '';
                    document.getElementById('validacion8_edit').innerHTML = '';
                    document.getElementById('validacion9_edit').innerHTML = '';
                    document.getElementById('validacion10_edit').innerHTML = '';
                    document.getElementById('validacion11_edit').innerHTML = '';
                    document.getElementById('validacion12_edit').innerHTML = '';
                    document.getElementById('validacion13_edit').innerHTML = '';
                    document.getElementById('validacion14_edit').innerHTML = '';
                    document.getElementById('validacion15_edit').innerHTML = '';

    
                          for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de ingresar un nombre de modelo";
                            }
                            
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe ingresar un peso";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3_edit').innerHTML += "El peso debe ser un numero";
                            }if(data[i] == 4){
                                document.getElementById('validacion4_edit').innerHTML += "El peso debe ser mayor a cero";
                            }if(data[i] == 5){
                                document.getElementById('validacion5_edit').innerHTML += "Debe de ingresar un tamaño";
                            }if(data[i] == 6){
                                document.getElementById('validacion6_edit').innerHTML += "El tamaño debe ser un numero ";
                            }if(data[i] == 7){
                                document.getElementById('validacion7_edit').innerHTML += "El tamaño debe ser mayor a cero";
                            }if(data[i] == 8){
                                document.getElementById('validacion8_edit').innerHTML += "Debe ingresar la memoria RAM";
                            }if(data[i] == 9){
                                document.getElementById('validacion9_edit').innerHTML += "Debe ingresar la memoria interna";
                            }if(data[i] == 10){
                                document.getElementById('validacion10_edit').innerHTML += "Debe ingresar un precio";
                            }if(data[i] == 11){
                                document.getElementById('validacion11_edit').innerHTML += "El precio debe ser un numero";
                            }if(data[i] == 12){
                                document.getElementById('validacion12_edit').innerHTML += "El precio debe ser mayor a cero";
                            }if(data[i] == 13){
                                document.getElementById('validacion13_edit').innerHTML += "Debe ingresar la duracion de la bateria";
                            }if(data[i] == 14){
                                  document.getElementById('validacion14_edit').innerHTML += "Debe de ingresar la capacidad de las camaras";
                            }if(data[i] == 15){
                                document.getElementById('validacion15_edit').innerHTML += "Debe de ingresar la gama";
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


        //Metodo para eliminar 
        /* $('#btn_delete').on('click',function(){

            var code = $('#tipo_code_delete').val();

            $.ajax({
                type : "POST",
                url  : "<//?php echo site_url('Tesoreria/deleteModelo')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="tipo_code_delete"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();

                      Swal.fire('Se ha eliminado el registro','','success')
                        .then(() => {
                            // Aquí se recarga la pagina
                            location.reload();

                        });


                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo eliminar */



});

/* function eliminar(codigo){
                    
           var code = codigo.id;
    
            $('#Modal_Delete').modal('show');
            $('[name="tipo_code_delete"]').val(code);
}*/

function editar(codigo){
           var code = codigo.id;

          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/llenarModelo')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){

                    $('[name="tipo_code_edit"]').val(data[0].id_modelo);
                    $('[name="telefonos_mod"]').val(data[0].id_marca);
                    $('[name="edit_modelo"]').val(data[0].nombre_modelo);
                    $('[name="edit_peso"]').val(data[0].peso);
                    $('[name="edit_tamaño"]').val(data[0].tamaño);
                    $('[name="edit_ram"]').val(data[0].ram);
                    $('[name="edit_rom"]').val(data[0].rom);
                    $('[name="edit_precio"]').val(data[0].precio);
                    $('[name="edit_bateria"]').val(data[0].bateria);
                    $('[name="edit_camara"]').val(data[0].camaras);
                    $('[name="edit_gama"]').val(data[0].gama);

                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';
                    document.getElementById('validacion4_edit').innerHTML = '';
                    document.getElementById('validacion5_edit').innerHTML = '';
                    document.getElementById('validacion6_edit').innerHTML = '';
                    document.getElementById('validacion7_edit').innerHTML = '';
                    document.getElementById('validacion8_edit').innerHTML = '';
                    document.getElementById('validacion9_edit').innerHTML = '';
                    document.getElementById('validacion10_edit').innerHTML = '';
                    document.getElementById('validacion11_edit').innerHTML = '';
                    document.getElementById('validacion12_edit').innerHTML = '';
                    document.getElementById('validacion13_edit').innerHTML = '';
                    document.getElementById('validacion14_edit').innerHTML = '';
                    document.getElementById('validacion15_edit').innerHTML = '';

                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         }

            function limpiar(){
            document.getElementById('validacion1').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacion3').innerHTML = '';
            document.getElementById('validacion4').innerHTML = '';
            document.getElementById('validacion5').innerHTML = '';
            document.getElementById('validacion6').innerHTML = '';
            document.getElementById('validacion7').innerHTML = '';
            document.getElementById('validacion8').innerHTML = '';
            document.getElementById('validacion9').innerHTML = '';
            document.getElementById('validacion10').innerHTML = '';
            document.getElementById('validacion11').innerHTML = '';
            document.getElementById('validacion12').innerHTML = '';
            document.getElementById('validacion13').innerHTML = '';
            document.getElementById('validacion14').innerHTML = '';
            document.getElementById('validacion15').innerHTML = '';

            document.getElementById('validacion_edit').innerHTML = '';
            document.getElementById('validacion2_edit').innerHTML = '';
            document.getElementById('validacion3_edit').innerHTML = '';
            document.getElementById('validacion4_edit').innerHTML = '';
            document.getElementById('validacion5_edit').innerHTML = '';
            document.getElementById('validacion6_edit').innerHTML = '';
            document.getElementById('validacion7_edit').innerHTML = '';
            document.getElementById('validacion8_edit').innerHTML = '';
            document.getElementById('validacion9_edit').innerHTML = '';
            document.getElementById('validacion10_edit').innerHTML = '';
            document.getElementById('validacion11_edit').innerHTML = '';
            document.getElementById('validacion12_edit').innerHTML = '';
            document.getElementById('validacion13_edit').innerHTML = '';
            document.getElementById('validacion14_edit').innerHTML = '';
            document.getElementById('validacion15_edit').innerHTML = '';

             $('[name="modelo"]').val("");
             $('[name="peso"]').val("");
             $('[name="tamaño"]').val("");
             $('[name="ram"]').val("");
             $('[name="rom"]').val("");
             $('[name="bateria"]').val("");
             $('[name="camaras"]').val("");
             $('[name="precio"]').val("");

             $('[name="gama"]').val("");

             $('[name="edit_modelo"]').val("");
             $('[name="edit_peso"]').val("");
             $('[name="edit_tamaño"]').val("");
             $('[name="edit_ram"]').val("");
             $('[name="edit_rom"]').val("");
             $('[name="edit_precio"]').val("");
             $('[name="edit_bateria"]').val("");
             $('[name="edit_camaras"]').val("");
             $('[name="edit_gama"]').val("");
                    
         }

             //funcion que se ejecuta para cambiar la marca
     function seleccionar_marca(){
      //capturo la agencia del combobox
    marca = $('#marca').val();

    $('#mydata').DataTable().destroy();
    $('#mydata .show_data').empty();
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Tesoreria/seleccionar_marca')?>",
        dataType : "JSON",
        data : {marca:marca},
        success: function(data){

           for (var i = 0 ; i <data.length; i++) {

            if(data[i].gama == '1'){
                data[i].gama = 'Baja';
            }else if(data[i].gama == '2'){
                data[i].gama = 'Media-Baja';
            }else if(data[i].gama== '3'){
                data[i].gama = 'Media';
            }else if(data[i].gama == '4'){
                data[i].gama = 'Media-Alta';
            }else if(data[i].gama == '5'){
                data[i].gama = 'Alta';
            }else if(data[i].gama == '6'){
                data[i].gama = 'Ultra';
            }else if(data[i].gama == '7'){
                data[i].gama = 'Ultra Plus';
            }

          //creo la tabla con mis datos
           $(".show_data").append('<tr>' + 

           '<td style="text-align: left;">'+data[i].nombre_marca+'</td>'+
           '<td style="text-align: left;">'+data[i].nombre_modelo +'</td>'+
            '<td style="text-align: left;">'+data[i].peso +' gramos</td>'+
            '<td style="text-align: left;">'+data[i].tamaño +' pulgadas</td>'+
            '<td style="text-align: left;">'+data[i].ram +'</td>'+
            '<td style="text-align: left;">'+data[i].rom +'</td>'+
            '<td style="text-align: left;">'+ '$' + data[i].precio +'</td>'+
            '<td style="text-align: left;">'+data[i].bateria +'</td>'+
            '<td style="text-align: left;">'+data[i].camaras +'</td>'+
            '<td style="text-align: left;">'+data[i].gama +'</td>'+


            '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'+data[i].id_modelo+'">Editar</a></td>'+

            '</tr>');
         }
       

       $('#mydata').DataTable({
           "bAutoWidth": false,
                 "oLanguage": {
                     "sSearch": "Buscador: "
                 }
         });
     },

     error: function(data){
      var a =JSON.stringify(data['responseText']);
      alert(a);
    }
  });

  }
</script>
 