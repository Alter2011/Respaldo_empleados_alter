<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Agregar Nuevo Plan</h2>
            </div>
       

                <?php
             $nombres = [];

            if (isset($_POST["nombres"])) {
                $nombres = $_POST["nombres"];
            }
          
            if (isset($_POST["guardar"])) {
                print_r($nombres);
                exit;
            }
            ?>
            <form method="post" name="add_planes" id="add_planes" action="planes" align="left">
            <?php foreach ($nombres as $nombre) { ?>
            <input value="<?php echo $nombre ?>" type="text" name="nombres[]">
            <br><br>
            <?php } ?>
         
            <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>

            <br>
            <div id="validacion1" style="color:red"></div><br>

            <table id="mitabla1">
                 <div id="validacion1">
            <h4>Informacion Planes:<h4><hr>
            </div> 
            <tr><td>
           
            <div class="form-group row">
            <label class="col-md-2 col-form-label">Disponibilidad de planes:</label>
            <div class="col-sm-2">
              <input type="text" name="cantidad" id="cantidad" value="1" class="form-control" placeholder="Cantidad de planes">
            </div>
            <label class="col-md-3 col-form-label">Nombre del plan:</label>
            <div class="col-md-4">
              <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre Plan">
            </div>
            </div>

             <div class="form-group row">
            <label class="col-md-2 col-form-label">Costo del plan: ($)</label>
            <div class="col-md-2">
              <input type="text" name="monto" id="monto" class="form-control" placeholder="0.00">
            </div>

                <label class="col-md-3 col-form-label">Empresa proveedora:</label>
              <div class="col-sm-4">
              <select class="form-control" id="contrata" name="contrata" >                                       
                        <?php
                        foreach($ver_empresas as $fila){
                            echo "<option value=".$fila->id_empresa.">".$fila->nombre_empresa."</option>";
                        }  
                        ?>
                        </select>
            </div>
            </div>
            </td></tr>
            </table>

            <br>
        <div id="validacion1">
        <h4>Informacion Servicio/s:<h4><hr>
        </div>    
     
        <table id="mitabla2">
        <tr class="espacio"><td>
            <div class="form-group row">
                 <label class="col-md-2 col-form-label">Tipo del servicio:</label>
                 <div class="col-sm-2">
                <select class="form-control" id="tipo_servicios" onchange="seleccionar_servicio()" name="tipo_servicios[]" >                                       
                     <?php
                        foreach($ver_tipos as $fila){
                            echo "<option value=".$fila->id_tipo_servicio.">".$fila->nombre_servicio."</option>";
                        }  
                        ?>
                        </select>
                    </div>
                <label class="col-md-2 col-form-label">Nombre del servicio:</label>
                <div class="col-md-4">
                <input type="text" name="nombre_servicio[]" id="nombre_servicio[]" placeholder="Ingrese nombre del servicio" class="form-control name_list" />
                </div>
                <div class="col-md-1">
                    <button type="button" name="add" id="add" class="btn btn-success">Agregar Servicio</button>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label" id="servicio" name="servicio"><?php
                        foreach($ver_servicios as $fila){
                            echo "<option value=".$fila->id_tipo_servicio.">".$fila->tipo_de_uso."</option>";
                        }  
                        ?></label>
                <div class="col-md-2">
                <input type="text" name="cantidad_servicio[]" placeholder="Ingrese la cantidad del servicio" class="form-control name_list" /></div>
                
            </div>
            
            

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Descripcion del servicio:</label>
                <div class="col-md-8">
                <textarea class="md-textarea form-control" placeholder="Ingrese la descripcion del servicio" id="descripcion" name="descripcion[]"></textarea>
                </div>

              
            </div>

        <hr></td></tr>

        </table>

        <div id="boton1">
        <input type="button" name="submit" id="submit" class="btn btn-info" value="Guardar" /></div>

        
  
      
        </form>
        </div>


<script type="text/javascript">
      $(document).ready(function(){

        var i=1;


        $('#add').click(function(){
       

    
        $('#mitabla2').append('<tr id="row'+i+'"><td><div class="form-group row"><label class="col-md-2 col-form-label">Tipo del servicio:</label><div class="col-md-2"> <select class="form-control" id="tipo_servicios_'+i+'" onchange="seleccionar_servicio_add('+i+')" name="tipo_servicios[]" ><?php foreach($ver_tipos as $fila){
            echo "<option value=".$fila->id_tipo_servicio.">".$fila->nombre_servicio."</option>";} ?>
            </select></div><label class="col-md-2 col-form-label">Nombre del servicio:</label><div class="col-md-4"><input type="text" name="nombre_servicio[]" placeholder="Ingrese nombre del servicio" class="form-control name_list" /></div></div> <div class="form-group row"><label class="col-md-2 col-form-label" id="servicios'+i+'" name="servicios"><?php foreach($ver_servicios as $fila){
                echo "<option value=".$fila->id_tipo_servicio.">".$fila->tipo_de_uso."</option>";}  ?></label><div class="col-md-2"><input type="text" name="cantidad_servicio[]" placeholder="Ingrese la cantidad del servicio" class="form-control name_list" /></div></div> <div class="form-group row"><label class="col-md-2 col-form-label">Descripcion del servicio: </label> <div class="col-md-8"><textarea class="md-textarea form-control" placeholder="Ingrese la descripcion del servicio" id="descripcion" name="descripcion[]"></textarea></div><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div><hr><tr>');

         i++;
        });

        $(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id");


        $('#row'+button_id+'').remove();
        $('#row'+button+'').remove();

        });

         $('#submit').on('click',function(){
            var cantidad = $('#cantidad').val();
            var nombre = $('#nombre').val();
            var monto = $('#monto').val();
            var contrata = $('#contrata').val();

            var add_plan = $('#add_planes').serialize();


        $.ajax({
            type : "POST",
             url  : "<?php echo site_url('Tesoreria/save_planes')?>",
             dataType : "JSON",

             data : {cantidad:cantidad,nombre:nombre,monto:monto,contrata:contrata,add_plan:add_plan},
           
            success:function(data)
            {

               if(data == null){
                    document.getElementById('validacion1').innerHTML = '';
   
                        $('[name="nombre"]').val("");
                        $('[name="cantidad"]').val("");
                        $('[name="monto"]').val("");
                    
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


        
    });

       function seleccionar_servicio(){

            var servicio = document.getElementById('tipo_servicios').value;


             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarServicios')?>",
                dataType : "JSON",
                data : {servicio:servicio},
                success: function(data){


                $('#servicio').empty();

                for (i = 0; i <= data.length-1; i++){
                $("#servicio").append('<value=' + data[i].id_tipo_servicio+ ">" + data[i].tipo_de_uso);

                }
    

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         }

         function seleccionar_servicio_add(i){

            var servicio = document.getElementById('tipo_servicios_'+i).value;

            console.log("#servicios"+i);


             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Tesoreria/cambiarServicios')?>",
                dataType : "JSON",
                data : {servicio:servicio},
                success: function(data){


                $('#servicios'+i).empty();


                $("#servicios"+i).append('<value=' + data[0].id_tipo_servicio+ ">" + data[0].tipo_de_uso);

    

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });



      
         }

</script>
 