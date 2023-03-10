        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Tipos de Prestamos</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Tipo de Prestamo</th>
                                    <th style="text-align: center;">Tasa/Prima</th>      
                                    <th style="text-align: right;">Acciones</th>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tipo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_prestamo" id="nombre_prestamo" class="form-control" placeholder="Ingrese el nuevo prestamo">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tasa/Prima:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tasa_prestamo" id="tasa_prestamo" class="form-control">
                            <?php
                                $i=0;
                                foreach($tasas as $a){
                            ?>
                            <option id="<?= ($tasas[$i]->id_tasa);?>"><?php echo($tasas[$i]->nombre);?></option>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Tipo de Prestamo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" placeholder="Product Code" readonly>
                    <input type="hidden" name="nombre_tipo" id="nombre_tipo" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre del Prestamo:</label>
                <div class="col-md-10">
                    <input type="text" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Ingresa cambio">
                    <div id="validacion_edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tasa/Prima:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tasa_edit" id="tasa_edit" class="form-control">
                            <?php
                                $i=0;
                                foreach($tasas as $a){
                            ?>
                            <option id="<?= ($tasas[$i]->id_tasa);?>" value="<?= ($tasas[$i]->id_tasa);?>"><?php echo($tasas[$i]->nombre);?></option>
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
		        url   : '<?php echo site_url('Prestamo/tipoPrestamoData')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
                    
		            var html = '';
		            var i;
                    plazas_edit=data;
		            for(i=0; i<data.length; i++){                 
		                html += '<tr>'+
                                '<td>'+data[i].nombre_prestamo+'</td>'+
                                '<td>'+data[i].nombre+'</td>'+
		                        '<td style="text-align:right;">'+
                                    '<a href="#" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].id_tipo_prestamo+'">Edit</a>'+' '+'<a href="#" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-codigo="'+data[i].id_tipo_prestamo+'">Delete</a>'+
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

            var nombre_prestamo = $('#nombre_prestamo').val();
            var tasa = $('#tasa_prestamo').children(":selected").attr("id");
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/saveTipo')?>",
                dataType : "JSON",
                data : {nombre_prestamo:nombre_prestamo,tasa:tasa},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';

                        $('[name="nombre_prestamo"]').val("");
                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Tipo de Prestamo";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Este Tipo de Prestamo Ya Existe";
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
          
        });
        
        //get data for update record
         $('#show_data').on('click','.item_edit',function(){
            document.getElementById('validacion_edit').innerHTML = '';
            var code = $(this).data('codigo');

             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/editTipo')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="code_edit"]').val(code);
                    $('[name="nombre_edit"]').val(data[0].nombre_prestamo);
                    $('[name="tasa_edit"]').val(data[0].id_tasa);
                    $('[name="nombre_tipo"]').val(data[0].nombre_prestamo);
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            
        });

        //update record to database
        $('#btn_update').on('click',function(){
            var code = $('#code_edit').val();
            var nombre_prestamo = $('#nombre_edit').val();
            var nombre_tipo = $('#nombre_tipo').val();
            var tasa = $('#tasa_edit').children(":selected").attr("id");


             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/updateTipo')?>",
                dataType : "JSON",
                data : {code:code,nombre_prestamo:nombre_prestamo,nombre_tipo:nombre_tipo,tasa:tasa},
                success: function(data){

                    if(data==null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        $('[name="code_edit"]').val("");
                        $('[name="nombre_edit"]').val("");
                        $('[name="nombre_tipo"]').val("");
                        $('[name="tasa_edit"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre del Tipo de Prestamo";
                            }else if(data[i] == 2){
                                document.getElementById('validacion_edit').innerHTML += "Este Tipo de Prestamo Ya Existe";
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
        });


       
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
                url  : "<?php echo site_url('Prestamo/deleteTipo')?>",
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