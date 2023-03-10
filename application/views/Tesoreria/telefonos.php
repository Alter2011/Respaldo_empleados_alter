<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Telefonos</h2>
            </div>


            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a onclick="limpiar()" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo Telefono</a><?php ?><br><br></nav>

                         <div>
                        <label class="col-md-2 col-form-label">Buscar Marca:</label>
                        <div class="col-md-3">
                        <select class="form-control" id="buscar_marca" name="buscar_marca" >                                       
                        <?php
                        foreach($ver_marcas as $fila){
                            echo "<option value=".$fila->id_marca.">".$fila->nombre_marca."</option>";
                        }  
                        ?>
                        </select>
                        </div>  
                        <button type="button" title="Seleccionar marca" onclick="seleccionar_marca_tel()" class="btn btn-default">
                        <span class="glyphicon glyphicon-time"></span> 
                        </button>
                        </div>

                        <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Marca</th>
                                    <th style="text-align:left;">Modelo</th>          
                                    <th style="text-align:left;">Imei</th>
                                    <th style="text-align:left;">Descripcion</th>            
          
                                    <th style="text-align:left;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" class="show_data">
                                <?php

                               foreach ($ver_telefonos as $tipo) {

                                   echo "<tr>";
                                   echo "<td style='text-align: left;' class='marca'>".$tipo->nombre_marca."</td>";
                                   echo "<td style='text-align: left;' class='modelo'>".$tipo->nombre_modelo."</td>";
                                   echo "<td style='text-align: left;' class='imei'>".$tipo->imei."</td>";
                                   echo "<td style='text-align: left;' class='descripcion'>".$tipo->descripcion."</td>";


                                   echo '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->id_telefono.'" >Editar</a></td>';

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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Telefono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            
            <div id="validacion1" style="color:red"></div>

            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Marca:</label>
                    <div class="col-md-7">
                         <select class="form-control" id="marca" name="marca" onchange="seleccionar_marca()">                                       
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
                         <select class="form-control" id="modelo" name="modelo" >                                       
                        </select>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Imei:</label>
                    <div class="col-md-7">
                    <input type="text" name="imei" id="imei" class="form-control">  
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Telefono</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <div id="validacion_edit" style="color:red"></div>

            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-6">
                    <input type="hidden" name="tipo_code_edit" id="tipo_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

              <div class="form-group row">
                    <label class="col-md-3 col-form-label">Marca:</label>
                    <div class="col-md-7">
                         <select class="form-control" id="edit_marca" name="edit_marca" onchange="seleccionar_marca_edit()">                                       
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
                        <select class="form-control" id="edit_modelo" name="edit_modelo">                                       
                    
                        </select>
                    </div>
                </div>



                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Imei:</label>
                    <div class="col-md-7">
                    <input type="text" name="edit_imei" id="edit_imei" class="form-control">  
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
            var marca = $('#marca').val();
            var modelo = $('#modelo').val();
            var imei = $('#imei').val();
            var descripcion = $('#descripcion').val();

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/save_telefono')?>",
                dataType : "JSON",
                data : {marca:marca,modelo:modelo,imei:imei,descripcion:descripcion},
                success: function(data){


                    if(data == null){
                    document.getElementById('validacion1').innerHTML = '';

                        $('[name="marca"]').val("");
                        $('[name="modelo"]').val("");
                        $('[name="imei"]').val("");
                        $('[name="descripcion"]').val("");

                        $('#Modal_Add').modal('toggle');
                    
                        Swal.fire('Se ha agregado el registro con exito','','success')
                        .then(() => {
                            // Aquí la alerta se ha cerrado
                            location.reload();

                        });
               
                    }else{

                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion1').innerHTML += data;

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
            var marca = $('#edit_marca').val();
            var modelo = $('#edit_modelo').val();
            var imei = $('#edit_imei').val();
            var descripcion = $('#edit_descripcion').val();

            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/update_telefono')?>",
                dataType : "JSON",
                data : {code:code,marca:marca,modelo:modelo,imei:imei,descripcion:descripcion},
                success: function(data){

                    if(data == null){
                    document.getElementById('validacion_edit').innerHTML = '';

                    $('[name="edit_imei"]').val("");
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
                    document.getElementById('validacion_edit').innerHTML += data;

                    }//fin if else data == null
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
            
        });//Fin metodo modificar

    });



function editar(boton){
    var codigo = boton.id;

          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/llenarTelefono')?>",
                dataType : "JSON",
                data : {codigo:codigo},
                success: function(data){

                    $('[name="tipo_code_edit"]').val(data[0].id_telefono);
                    $('[name="edit_marca"]').val(data[0].marca);

                    $('[name="edit_modelo"]').val(data[0].id_modelo);
                    $('[name="edit_imei"]').val(data[0].imei);
                    $('[name="edit_descripcion"]').val(data[0].descripcion);

                    seleccionar_marca_edit(data[0].id_modelo);

                    document.getElementById('validacion_edit').innerHTML = '';
                    
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

            $('[name="imei"]').val("");

            var marca = document.getElementById('marca').value;

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarModelos')?>",
                dataType : "JSON",
                data : {marca:marca},
                success: function(data){

                $('#modelo').empty();//esto me limpia todo el combobox
                for (i = 0; i <= data.length-1; i++){
                $("#modelo").append('<option value=' + data[i].id_modelo+ ">" + data[i].nombre_modelo + '</option>');
                }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
                    
         }

         function seleccionar_marca(){
            var marca = document.getElementById('marca').value;

            console.log(marca);

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarModelos')?>",
                dataType : "JSON",
                data : {marca:marca},
                success: function(data){


                $('#modelo').empty();//esto me limpia todo el combobox

                for (i = 0; i <= data.length-1; i++){

                $("#modelo").append('<option value=' + data[i].id_modelo+ ">" + data[i].nombre_modelo + '</option>');
                }
                

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
         }

         function seleccionar_marca_edit(modelo){

            var marca = document.getElementById('edit_marca').value;


             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarModelos')?>",
                dataType : "JSON",
                data : {marca:marca},
                success: function(data){

                $('#edit_modelo').empty();//esto me limpia todo el combobox

                for (i = 0; i <= data.length-1; i++){
                $("#edit_modelo").append('<option value=' + data[i].id_modelo+ ">" + data[i].nombre_modelo + '</option>');

                }
                $("#edit_modelo option[value='"+modelo+"']").attr("selected",true);
    

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });



      
         }

         //funcion que se ejecuta para cambiar la marca
     function seleccionar_marca_tel(){
      //capturo la agencia del combobox
    marca = $('#buscar_marca').val();

    $('#mydata').DataTable().destroy();
    $('#mydata .show_data').empty();
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Tesoreria/seleccionar_marca_tel')?>",
        dataType : "JSON",
        data : {marca:marca},
        success: function(data){

           for (var i = 0 ; i <data.length; i++) {

          //creo la tabla con mis datos
           $(".show_data").append('<tr>' + 

           '<td style="text-align: left;">'+data[i].nombre_marca+'</td>'+
           '<td style="text-align: left;">'+data[i].nombre_modelo +'</td>'+
            '<td style="text-align: left;">'+data[i].imei +' </td>'+
            '<td style="text-align: left;">'+data[i].descripcion +' </td>'+


            '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'+data[i].id_telefono+'">Editar</a></td>'+

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
 