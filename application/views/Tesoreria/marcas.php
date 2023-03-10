<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Marcas Telefonos</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a onclick="limpiar()" href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nueva Marca</a><?php ?><br><br></nav>

               

                        <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Nombre Marca</th>
                                   
                                    <th style="text-align:left;">Descripcion</th>            
                                    <th style="text-align:left;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php

                               foreach ($tipos as $tipo) {
                                   echo "<tr>";
                                   echo "<td style='text-align: left;' class='nombre'>".$tipo->nombre_marca."</td>";
                                   echo "<td style='text-align: left;' class='descripcion'>".$tipo->descripcion."</td>";
                        

                                   echo '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->id_marca.'">Editar</a></td>';

                                   //echo '<td style="text-align: left;"><a data-toggle="modal" onClick="eliminar(this)" class="btn btn-info btn-sm item_delete" id="'.$tipo->id_marca.'">Eliminar</a></td>';

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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Marca</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            
            <div id="validacion1" style="color:red"></div>
            <div id="validacion2" style="color:red"></div>
            <div id="validacion3" style="color:red"></div>

            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre:</label>
                    <div class="col-md-7">
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="nombre marca">  
                </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Descripcion:</label>
                    <div class="col-md-7">
                        <textarea class="md-textarea form-control" id="descripcion" name="descripcion"></textarea>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Marca</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div id="validacion_edit" style="color:red"></div>
            <div id="validacion2_edit" style="color:red"></div>
            <div id="validacion3_edit" style="color:red"></div>

            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <input type="hidden" name="tipo_code_edit" id="tipo_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

              <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_nombre" id="edit_nombre" class="form-control" placeholder="nombre marca">
                </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Descripcion:</label>
                    <div class="col-md-7">
                        <textarea class="md-textarea form-control" id="edit_descripcion" name="edit_descripcion"></textarea>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Marca</h5>
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
            var nombre = $('#nombre').val();
            var descripcion = $('#descripcion').val();
           
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/save_marca')?>",
                dataType : "JSON",
                data : {nombre:nombre,descripcion:descripcion},
                success: function(data){


                    if(data == null){

                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';



                        $('[name="nombre"]').val("");
                        $('[name="descripcion"]').val("");

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


                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion1').innerHTML += "Debe de ingresar un nombre de marca";
                            }
                            
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar una descripcion";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3').innerHTML += "La descripcion no debe ser mayor a 300 caracteres";
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


            var nombre = $('#edit_nombre').val();
            var descripcion = $('#edit_descripcion').val();
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/update_marca')?>",
                dataType : "JSON",
                data : {code:code,nombre:nombre,descripcion:descripcion},
                success: function(data){
                    if(data == null){
                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';

  
                    $('[name="edit_nombre"]').val("");
                    $('[name="edit_descripcion"]').val("");

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

    
                        for (i = 0; i <= data.length-1; i++){
                           if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de ingresar un nombre de marca";
                            }
                            
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de ingresar una descripcion";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion3_edit').innerHTML += "La descripcion no debe ser mayor a 300 caracteres";
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
                url  : "<//?php echo site_url('Tesoreria/deleteMarca')?>",
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
                url  : "<?php echo site_url('Tesoreria/llenarMarca')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){

                    $('[name="tipo_code_edit"]').val(data[0].id_marca);
                    $('[name="edit_nombre"]').val(data[0].nombre_marca);
                    $('[name="edit_descripcion"]').val(data[0].descripcion);


                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         }

           //funcion para limpiar los errores
         function limpiar(){
            document.getElementById('validacion1').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacion3').innerHTML = '';

            $('[name="nombre"]').val("");
            $('[name="descripcion"]').val("");
                    
         }


</script>
 