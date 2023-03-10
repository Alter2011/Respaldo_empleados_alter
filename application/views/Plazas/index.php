<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
-->

        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Plazas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th>      
                                    <th style="text-align:center;">Nombre Plaza</th>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;">Fecha</th>
                                    <th style="text-align:right;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Plaza</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre de la Plaza:</label>
                    <div class="col-md-10">
                        <input type="text" name="plaza_name" id="plaza_name" class="form-control" placeholder="Ingrese la nueva plaza">
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                         <select name="plaza_agencia" id="plaza_agencia" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($agencia as $a){
                        
                        ?>
                            <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                        <?php
                            $i++;
                        }
                        ?>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Plaza</h3>
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
                    <input type="hidden" name="nom_code_edit" id="nom_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <!--
                <label class="col-md-2 col-form-label">Product Code</label>
-->
                <div class="col-md-10">
                    <input type="hidden" name="nombre_plaza" id="nombre_plaza" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombres</label>
                <div class="col-md-10">
                    <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Ingresa cambio">
                </div>
            </div>
            </div>

            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Agencia:</label>
                    <div class="col-md-10">
                         <select name="plaza_agencia_edit" id="plaza_agencia_edit" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($agencia as $a){
                        
                        ?>
                            <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                        <?php
                            $i++;
                        }
                        ?>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Plaza</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="cap_code_delete" id="cap_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->
<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var plazas_edit;
        show_data();	//call function show all product

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

        //function show all product
        function show_data(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('plazas/plazas_data')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
                    
		            var html = '';
		            var i;
                    plazas_edit=data;
		            for(i=0; i<data.length; i++){                 
		                html += '<tr>'+
                                '<td>'+data[i].agencia+'</td>'+//Agencia
                                '<td>'+data[i].nombrePlaza+'</td>'+//nombrePlaza
                                '<td>'+data[i].estado_empleado+'</td>'+//estado
                                '<td>'+data[i].fecha+'</td>'+//agencia
		                        '<td style="text-align:right;">'+
                                    '<a href="#" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].id_plaza+'" data-nombre="'+data[i].nombrePlaza+'" data-agencia="'+data[i].id_agencia+'">Edit</a>'+'<a href="#" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-codigo="'+data[i].id_plaza+'">Delete</a>'+
                                    
                                '</td>'+
		                        '</tr>';
		            }
		            $('#show_data').html(html);
		        },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
		    });
		}


         //Save Plazas
         $('#btn_save').on('click',function(){
           var plaza_name = $('#plaza_name').val();
           var plaza_agencia = $('#plaza_agencia').children(":selected").attr("id");
           var agencia = $('#plaza_agencia').val();

           if(plaza_name == ""){

            alert("Debe de Ingresar el Nombre de la Plaza");
            $('#Modal_Add').modal('show');
          
           }else{
                
                $.ajax({
                type  : "POST",
                url   : "<?php echo site_url('plazas/validarExistencias')?>",
                dataType : "JSON",
                 data : {plaza_name:plaza_name,plaza_agencia:plaza_agencia},

                 success : function(data){
                        if (data[0].conteo==0){

                        validarInsert();

                        }else{
                           alert("La plaza ya existe en "+ agencia);
                        }//fin data.length
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

           }//fin if validar si esta vacio
          
            
        });

         //se usa para validar la cantidad de plazas disponible
         function validarInsert(){
            var plaza_name = $('#plaza_name').val();
            var plaza_agencia = $('#plaza_agencia').children(":selected").attr("id");
            
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('plazas/validar')?>',
                dataType : 'JSON',
                data : {plaza_agencia:plaza_agencia},

                 success : function(data){
                        if (data.length==0) {
                        insertar();
                        }else{
                           if(parseInt(data[0].plazas) < parseInt(data[0].total_plaza)){
                            insertar();
                            
                            }else{
                              alert('Las plazas ya estan cubiertas');  
                            }  
                        }//fin data.length
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

         };

         function insertar(){
            var plaza_name = $('#plaza_name').val();
            var plaza_agencia = $('#plaza_agencia').children(":selected").attr("id");
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('plazas/save')?>",
                dataType : "JSON",
                data : {plaza_name:plaza_name,plaza_agencia:plaza_agencia},
                success: function(data){
                    $('[name="plaza_name"]').val("");
                    $('[name="plaza_agencia"]').val("");
                    location.reload();
                    this.disabled=false;
                    show_area();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
           
         };

         
        //get data for update record
         $('#show_data').on('click','.item_edit',function(){
           
            var code   = $(this).data('codigo');
            var plaza_name   = $(this).data('nombre');
            var agencia = $(this).data('agencia');
            var nombre = $(this).data('nombre');
          
            $('#Modal_Edit').modal('show');
            $('[name="nom_code_edit"]').val(code);
            $('[name="nombre_edit"]').val(plaza_name);
            $('[name="plaza_agencia_edit"]').val(agencia);
            $('[name="nombre_plaza"]').val(nombre);
            
            
        });

        //update record to database
        $('#btn_update').on('click',function(){
           var plaza_agencia = $('#plaza_agencia_edit').children(":selected").attr("id");
           var plaza_name = $('#nombre_edit').val(); 
           var nombre = $('#nombre_plaza').val();
           var agencia = $('#nom_code_edit').val();
           var nombre_agencia = $('#plaza_agencia_edit').val();

           if(plaza_name == nombre && agencia == plaza_agencia){
                update();
           }else{
                $.ajax({
                type  : "POST",
                url   : "<?php echo site_url('plazas/validarExistencias')?>",
                dataType : "JSON",
                  data : {plaza_name:plaza_name,plaza_agencia:plaza_agencia},
                 success : function(data){
                        if (data[0].conteo==0){

                       update();

                        }else{
                           alert("La plaza ya existe en la agencia selecionada");
                        }//fin data
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

           }//fin if
        });

        function validarUpdate(){
            var plaza_agencia = $('#plaza_agencia_edit').children(":selected").attr("id");
           $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('plazas/validar')?>',
                dataType : 'JSON',
                data : { plaza_agencia:plaza_agencia},

                 success : function(data){
                    
                    if (data.length==0) {
                        update();
                    }else{
                        
                        var agencia = $('#nom_code_edit').val();
                        var plazaAgencia = $('#plaza_agencia_edit').val();
                        
                       if((parseInt(data[0].plazas) < parseInt(data[0].total_plaza)) || agencia==plazaAgencia){
                        update();
                        
                        }else{
                         alert('Las plazas ya estan cubiertas');   
                        }  
                    }
                    
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };

        function update(){
            var code = $('#nom_code_edit').val();
            var plazaNombre = $('#nombre_edit').val();
            var plaza_agencia = $('#plaza_agencia_edit').children(":selected").attr("id");
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('plazas/update')?>",
                dataType : "JSON",
                data : {code:code, plazaNombre:plazaNombre,plaza_agencia:plaza_agencia},
                success: function(data){
                    $('[name="nom_code_edit"]').val("");
                    $('[name="nombre_edit"]').val("");
                     $('[name="plaza_agencia_edit"]').val("");


                    $('#Modal_Edit').modal('toggle');
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
        };
        //get data for delete record
       $('#show_data').on('click','.item_delete',function(){
                var code   = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="cap_code_delete"]').val(code);
        });

        //delete record to database
        $('#btn_delete').on('click',function(){
            var code = $('#cap_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('plazas/quitarEstado')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="cap_code_delete"]').val("");
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
        });



    });
</script>
</body>

</html>