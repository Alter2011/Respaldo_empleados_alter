<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Asignacion de telefono</h2>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a onclick="limpiar()" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Asignar nuevo telefono</a><?php ?><br><br></nav>


                       <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Nombre linea</th>
                                    <th style="text-align:left;">Plan que pertenece</th>          
                                    <th style="text-align:left;">Numero de telefono</th>
                                    <th style="text-align:left;">Marca telefono</th>
                                    <th style="text-align:left;">Modelo telefono</th>
                                               
          
                                    <th style="text-align:left;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" class="show_data">
                                <?php

                               foreach ($ver_lineas as $tipo) {
                                   echo "<tr>";
                                   echo "<td style='text-align: left;' class='nombre'>".$tipo->nombre_linea."</td>";
                                   echo "<td style='text-align: left;' class='nombre_p'>".$tipo->nombre_plan."</td>";
                                   echo "<td style='text-align: left;' class='numero'>".$tipo->numero_telefono."</td>";
                                   echo "<td style='text-align: left;' class='marca'>".$tipo->nombre_marca."</td>";
                                   echo "<td style='text-align: left;' class='modelo'>".$tipo->nombre_modelo."</td>";

                                   echo '<td style="text-align: left;"><a data-toggle="modal" onClick="llenar_linea(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->id_linea.'" >Editar</a></td>';

                                   //echo '<td style="text-align: left;"><a data-toggle="modal" onClick="eliminar(this)" class="btn btn-info btn-sm item_delete" id="'.$tipo->id_marca.'">Eliminar</a></td>';

                                   echo "</tr>";
                                };


                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

             <!-- Modal Add -->
        <form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Nueva Linea</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            
            <div id="validacion3" style="color:red"></div>

            <div class="modal-body">

                <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Nombre de la linea:</label>
              <input type="text" name="linea" id="linea" class="form-control" placeholder="Nombre de la linea">
            </div>

            <div class="col-md-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Numero Telefono:</label>
              <input type="text" name="numero" id="numero" class="form-control" placeholder="Numero de telefono">
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-8">

            <div class="pretty p-switch p-fill">
            <input type="checkbox" name="switch1" id="asignar" />
            <div class="state p-success">
                <label>¿Se asignara telefono?</label>
            </div>
            </div>

          
            </div>
        </div>
           


            <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-form-label">Telefono Asignado:</label>
              <select class="form-control" id="telefonos" name="telefonos" disabled="true" >                                       
                        <?php
                        foreach($ver_telefonos as $fila){
                            echo "<option value=".$fila->id_telefono.">".$fila->nombre_marca. " " . $fila->nombre_modelo."</option>";
                        }  
                        ?>
                        </select>
            </div>
            <div class="col-md-5">
            <label class="col-form-label">Planes disponibles:</label>
              <select class="form-control" id="planes" name="planes" >                                       
                        <?php
                        foreach($ver_planes as $fila){
                            echo "<option value=".$fila->id_plan.">".$fila->nombre_plan."</option>";
                        }  
                        ?>
                        </select>
            </div>
            </div>

            <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-md-3 col-form-label">Agencia:</label>
              <select class="form-control" id="agencia" name="agencia" onchange="seleccionar_agencia()">         
                        <?php
                        foreach($ver_agencias as $fila){
                            echo "<option value=".$fila->id_agencia.">".$fila->agencia. "</option>";
                        }  
                        ?>
                        </select>
            </div>
            <div class="col-md-5">
            <label class="col-md-3 col-form-label">Empleado:</label>
              <select class="form-control" id="empleado" name="empleado">                                       
                    
                        </select>
            </div>
            </div>
  

            </div>

            <div class="modal-footer">
                 <input type="button" name="btn_submit" id="btn_submit" class="btn btn-info" value="Guardar" />

                 <input type="button" name="btn_close" id="btn_close" class="btn btn-danger" value="Salir" />

            </div>
        </div>
        </div>
    </div>

</form>

     <!-- Modal Edit -->
        <form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Modificar Linea</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="edit_codigo" id="edit_codigo" class="form-control" placeholder="Product Code" readonly>

            
            <div id="validacion_edit" style="color:red"></div>

            <div class="modal-body">

                <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Nombre de la linea:</label>
              <input type="text" name="edit_linea" id="edit_linea" class="form-control" placeholder="Nombre de la linea">
            </div>

              <div class="col-md-5">
            <label class="col-form-label">Planes disponibles:</label>
              <select class="form-control" id="edit_planes" name="edit_planes" >                                       
                        <?php
                        foreach($ver_planes as $fila){
                            echo "<option value=".$fila->id_plan.">".$fila->nombre_plan."</option>";
                        }  
                        ?>
                        </select>
            </div>

            </div>


            <div class="form-group row">
               <div class="col-md-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Numero Telefono:</label>
              <input type="text" name="edit_numero" id="edit_numero" class="form-control" placeholder="Numero de telefono">
            </div>

            <div class="col-sm-5">
            <label class="col-form-label">Telefono Asignado:</label>
              <select class="form-control" id="edit_telefonos" name="edit_telefonos">                                       
                        <?php
                        foreach($ver_telefonos as $fila){
                            echo "<option value=".$fila->id_telefono.">".$fila->nombre_marca. " " . $fila->nombre_modelo."</option>";
                        }  
                        ?>
                        </select>
            </div>
          
            </div>

   
  

            </div>

            <div class="modal-footer">
                 <input type="button" name="btn_submit_edit" id="btn_submit_edit" class="btn btn-info" value="Editar" />

                 <input type="button" name="btn_close_edit" id="btn_close_edit" class="btn btn-danger" value="Salir" />

            </div>
        </div>
        </div>
    </div>

</form>

       

        <!-- Modal Asignacion -->
        <form>
    <div class="modal fade" id="Modal_Asignacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Asignacion de Lineas</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            

            <div id="validacion1" style="color:red"></div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Linea:</label>
                    <div class="col-md-7">
                         <select class="form-control" id="linea" name="linea">                                       
                        <?php
                        foreach($ver_lineas as $fila){
                            echo "<option value=".$fila->id_linea.">".$fila->nombre_linea."</option>";
                        }  
                        ?>
                        </select>
                    </div>
                </div>
            

                  <div class="form-group row">
                    <label class="col-md-3 col-form-label">Agencia:</label>
                    <div class="col-md-7">
                         <select class="form-control" id="agencia" name="agencia" onchange="seleccionar_agencia()">                                       
                        <?php
                        foreach($ver_agencias as $fila){
                            echo "<option value=".$fila->id_agencia.">".$fila->agencia. "</option>";
                        }  
                        ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Empleado:</label>
                    <div class="col-md-7">
                        <select class="form-control" id="empleado" name="empleado">                                       
                    
                        </select>
                    </div>
                </div>




                <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
<button type="button" id="btn_submit" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            <?php
                //}
            ?>
            </div>

            </div>
            </div>
        </div>
        </div>

</form>


<script type="text/javascript">
      $(document).ready(function(){

         $('#mydata').dataTable( {
          
        } );

        seleccionar_agencia();

         $('#btn_close').on('click',function(){
            $('#Modal_Add').modal('toggle');
         } );

         $('#btn_close_edit').on('click',function(){
            $('#Modal_Edit').modal('toggle');
         } );

         $('#asignar').on('click', function() {
            check();
        });

        function check(){
            if( $('#asignar').is(':checked') ) {

                $("#telefonos").prop('disabled', false);

            }else{
                $("#telefonos").prop('disabled', true);
            }
        };//fin check


         $('#btn_submit').on('click',function(){
            var linea = $('#linea').val();
            var numero = $('#numero').val();
            var planes = $('#planes').val();


            if( $('#asignar').is(':checked') ) {
            var telefonos = $('#telefonos').val();
            }else{
                telefonos = null;
            }


        $.ajax({
            type : "POST",
             url  : "<?php echo site_url('Tesoreria/add_linea')?>",
             dataType : "JSON",

             data : {linea:linea,numero:numero,telefonos:telefonos,planes:planes},
           
            success:function(data)
            {

                console.log(data);

               if(data == null){
                    document.getElementById('validacion3').innerHTML = '';
   
                        $('[name="linea"]').val("");
                        $('[name="numero"]').val("");
             
                        Swal.fire('Se ha agregado el registro con exito','','success')
                        .then(() => {
                            // Aquí la alerta se ha cerrado
                           location.reload();

                        });
               
                    }else{
                    document.getElementById('validacion3').innerHTML = '';
                    document.getElementById('validacion3').innerHTML += data;

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
        
    });


        //metodo para modificar las lineas
        $('#btn_submit_edit').on('click',function(){
            var code = $('#edit_codigo').val();
            var linea = $('#edit_linea').val();
            var numero = $('#edit_numero').val();
            var planes = $('#edit_planes').val();
            var telefonos = $('#edit_telefonos').val();


            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/update_linea')?>",
                dataType : "JSON",
                data : {code:code,linea:linea,numero:numero,planes:planes,telefonos:telefonos},
                success: function(data){

                    if(data == null){
                    document.getElementById('validacion_edit').innerHTML = '';

                    $('[name="edit_numero"]').val("");

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


      function llenar_linea(boton){
    var codigo = boton.id;


          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/llenarLinea')?>",
                dataType : "JSON",
                data : {codigo:codigo},
                success: function(data){
                    $('[name="edit_codigo"]').val(data[0].id_linea);
                    $('[name="edit_linea"]').val(data[0].nombre_linea);
                    $('[name="edit_planes"]').val(data[0].id_plan);
                    $('[name="edit_numero"]').val(data[0].numero_telefono);
                    $('[name="edit_telefonos"]').val(data[0].id_telefono);


                    //seleccionar_marca_edit(data[0].id_modelo);

                    //document.getElementById('validacion_edit').innerHTML = '';
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         }

         function seleccionar_agencia($agencia){

            var agencia = document.getElementById('agencia').value;


             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiar_agencia')?>",
                dataType : "JSON",
                data : {agencia:agencia},
                success: function(data){


                $('#empleado').empty();

                for (i = 0; i <= data.length-1; i++){
                $("#empleado").append('<option value=' + data[i].id_empleado+ ">" + data[i].nombre + " " + data[i].apellido);

                }

                 $("#empleado option[value='"+agencia+"']").attr("selected",true);
    

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         }



</script>
 