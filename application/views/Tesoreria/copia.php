
      
    <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Asignacion de telefono</h2>
            </div>    

    <form action="<?php echo base_url("index.php/Tesoreria/asignar_linea"); ?>" method="POST" enctype="multipart/form-data">

    <div class="panel panel-body" id="cuerpo">
       
            <div class="form-group row">
                      <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-4">
                         <select class="form-control" id="agencia" name="agencia" onchange="seleccionar_agencia()">         
                        <?php
                        foreach($ver_agencias as $fila){
                            echo "<option value=".$fila->id_agencia.">".$fila->agencia. "</option>";
                        }  
                        ?>
                        </select>
                    </div>
             
                    <label class="col-md-2 col-form-label">Empleado:</label>
                    <div class="col-md-4">
                        <select class="form-control" id="empleado" name="empleado">                                       
                    
                        </select>
                  </div>
              </div>
          </div>

        <div class="panel panel-body" id="cuerpo">


            <div class="form-group row">
                     <label class="col-md-3 col-form-label">Seleccionar Plan:</label>  
                    <div class="col-md-3">
                         <select class="form-control" id="planes" name="planes" onchange="seleccionar_plan()">                                       
                        <?php
                        foreach($ver_planes as $fila){
                            echo "<option value=".$fila->id_plan.">".$fila->nombre_plan."</option>";
                        }  
                        ?>
                        </select>
                    </div>

                    <label class="col-md-3 col-form-label">Numero:</label>
                    <div class="col-md-3">

                <input  type="text" class="form-control" autocomplete="off" name="numero" id="numero" onchange="numeros()" list="lista_numeros"  <?php if (isset($numeros)) { echo ' value="'.$numeros->id_tel_numero.'" '; } ?> placeholder='Numero telefono'>
                <datalist id="lista_numeros" >
                  <?php
                  
                    foreach($ver_info_linea as $numeros){
                  ?>


                  <option value="<?= ($numeros->numero_telefono);?>"><?= ($numeros->numero_telefono);?></option>
                  <?php
                
                  } 
                  ?>
                </datalist>
                </div>
                        
                    </div>
            

                <div class="form-group row">
                      <label class="col-md-3 col-form-label">Cantidad de planes disponible:</label>
                    <div class="col-md-3">
                        <input type="text" name="cantidad" id="cantidad" class="form-control" readonly>
                    </div>
             
                    <label class="col-md-3 col-form-label">Precio del plan:</label>
                    <div class="col-md-3">
                       <input type="text" name="precio" id="precio" class="form-control" readonly> 
                  </div>
              </div>

                 <div class="form-group row">
                     <label class="col-md-3 col-form-label">Cantidad de llamadas (minutos):</label>  
                    <div class="col-md-3">
                       <input type="text" name="llamadas" id="llamadas" class="form-control" readonly>
                    </div>

                    <label class="col-md-3 col-form-label">Cantidad de redes (megas):</label>
                    <div class="col-md-3">
                         <input type="text" name="redes" id="redes" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                     <label class="col-md-3 col-form-label">Cantidad de mensajes:</label>  
                    <div class="col-md-3">
                       <input type="text" name="mensajes" id="mensajes" class="form-control" readonly>
                    </div>

                    <label class="col-md-3 col-form-label">Extras:</label>
                    <div class="col-md-3">
                         <input type="text" name="extras" id="extras" class="form-control" readonly>
                    </div>
                </div>

                <nav class="float-right"><?php ?><a class="btn btn-primary" data-toggle="modal" data-target="#Modal_Asignacion"><span class="fa fa-plus"></span> Asignar nuevo plan</a><?php ?><br><br></nav>


              

                  

          

              <button type="button" id="btn_submit" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

          </div>
          
    </form>
      </div>



<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Asignacion de Lineas</h2>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a onclick="limpiar()" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Asignacion"><span class="fa fa-plus"></span> Asignar Nueva Linea</a><?php ?><br><br></nav>


                       <table class="table table-striped" id="mydata" name="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:left;">Plan al que pertenece</th>
                                    <th style="text-align:left;">Linea Asignada</th>          
                                    <th style="text-align:left;">Usuario Asignado</th>
                                               
          
                                    <th style="text-align:left;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" class="show_data">
                                <?php

                               foreach ($ver_asignacion as $tipo) {
                                   echo "<tr>";
                                   echo "<td style='text-align: left;' class='nombre'>".$tipo->nombre_marca. " " . $tipo->nombre_modelo.  "</td>";
                                   echo "<td style='text-align: left;' class='nombre_p'>".$tipo->nombre_linea."</td>";
                                    echo "<td style='text-align: left;' class='nombre_p'>"."</td>";


                                   echo '<td style="text-align: left;"><a data-toggle="modal" onClick="editar_linea(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->id_asignacion.'" >Editar</a></td>';

                                   //echo '<td style="text-align: left;"><a data-toggle="modal" onClick="eliminar(this)" class="btn btn-info btn-sm item_delete" id="'.$tipo->id_marca.'">Eliminar</a></td>';

                                   echo "</tr>";
                                };


                                 ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->

             
        <form>
   <div class="modal fade bd-example-modal-lg" id="Modal_Asignacion" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
            <div class="modal-header">
            <h3 class="modal-title" id="Modal_">Asignacion de Lineas</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            

            <div id="validacion1" style="color:red"></div>
            <div class="modal-body" id="prueba">



            <table id="mydata" name="mydata" class="table table-striped table-bordered">
                
                <thead>
                  <tr><th style="text-align:left;">Beneficios\Planes</th>

                   <?php
                     foreach ($ver_planes as $datos) {
                  
                   echo '<th style="text-align: left;">'.$datos->nombre_plan ."</th>";
                   };
              ?>
              </tr> 
                </thead>

                  

                <tbody class="credito">
                <?php
                foreach ($tipos as $datos) {

                echo '<tr>';
                echo '<td class="col-md-3" style="text-align: left;">'.$datos->nombre_servicio."</td>";
                echo '</tr>';

              };
              ?>


               <?php
                foreach ($ver_servicios_asig as $datos) {
                echo '<tr>';

            echo '<td class="col-md-3" style="text-align: left;"><p>'.$datos->cantidad. " " . $datos->abreviatura.'</p></td>';

           
            echo '</tr>';

                 };
              ?>
            
              
              </tbody>
              </table>
 

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

</form> 

       

     <!-- Modal Edit
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

            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
            
            <div id="validacion3" style="color:red"></div>

            <div class="modal-body">

                <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Nombre de la linea:</label>
              <input type="text" name="edit_linea" id="edit_linea" class="form-control" placeholder="Nombre de la linea">
            </div>

            <div class="col-md-5">
            <label class="col-form-label"><span style='color: red;'>* </span>Numero Telefono:</label>
              <input type="text" name="edit_numero" id="edit_numero" class="form-control" placeholder="Numero de telefono">
            </div>
            </div>


            <div class="form-group row">
            <div class="col-sm-5">
            <label class="col-form-label">Telefono Asignado:</label>
              <select class="form-control" id="edit_telefonos" name="edit_telefonos" disabled="true" >                                       
                        <?php
                        foreach($ver_telefonos as $fila){
                            echo "<option value=".$fila->id_telefono.">".$fila->nombre_marca. " " . $fila->nombre_modelo."</option>";
                        }  
                        ?>
                        </select>
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

   
  

            </div>

            <div class="modal-footer">
                 <input type="button" name="btn_submit_edit" id="btn_submit_edit" class="btn btn-info" value="Editar" />

                 <input type="button" name="btn_close_edit" id="btn_close_edit" class="btn btn-danger" value="Salir" />

            </div>
        </div>
        </div>

</form>  -->


<script type="text/javascript">
      $(document).ready(function(){

         $('#mydata').dataTable( {
          
        } );

        seleccionar_agencia();
        seleccionar_plan();

    

         $('#btn_close').on('click',function(){
            $('#Modal_Add').modal('toggle');
         } );


         $('#btn_submit').on('click',function(){
            var linea = $('#linea').val();
            var empleado = $('#empleado').val();


            $.ajax({
            type : "POST",
             url  : "<?php echo site_url('Tesoreria/asignar_linea')?>",
             dataType : "JSON",

             data : {linea:linea,empleado:empleado},
           
            success:function(data)
            {


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

      function editar_linea(boton){
    var codigo = boton.id;


          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/llenarLinea')?>",
                dataType : "JSON",
                data : {codigo:codigo},
                success: function(data){

                    console.log(data);

                    $('[name="edit_linea"]').val(data[0].nombre_linea);
                    $('[name="edit_numero"]').val(data[0].numero_telefono);
                    $('[name="edit_telefonos"]').val(data[0].id_telefono);
                    $('[name="edit_planes"]').val(data[0].id_plan);


                    //seleccionar_marca_edit(data[0].id_modelo);

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

          function numeros(){
              var numero = document.getElementById('numero').id;

        console.log(numero);
         }




         function limpiar(){
            document.getElementById('validacion3').innerHTML = '';
         }

         function seleccionar_plan(){
            var plan = document.getElementById('planes').value;

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarPlan')?>",
                dataType : "JSON",
                data : {plan:plan},
                success: function(data){

                    console.log(data);


                $('[name="cantidad"]').empty();
                $('[name="precio"]').empty();

                for (i=0; i<=data.length-1; i++){
               $('[name="cantidad"]').val(data[0].cantidad);
               $('[name="precio"]').val(data[0].precio_plan);
                }
                

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
         }



</script> 