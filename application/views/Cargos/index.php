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
                <h2>Cargos</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php if($crear){?><a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php }?> </nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <!--
                                    <th>Codigo</th>
                                    -->
                                    <th style="text-align: center;">Cargo</th>
                                    <th style="text-align: center;">Area</th>
                                    <th style="text-align: right;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Cargo Nuevo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <!--    
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Product Code</label>
                    <div class="col-md-10">
                        <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                    </div>
                </div>
            -->
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cargo</label>
                    <div class="col-md-10">
                        <input type="text" name="cargo_name" id="cargo_name" class="form-control" placeholder="Nombre cargo">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripción Cargo</label>
                    <div class="col-md-10">
                        <textarea name="descripcion" id="descripcion" class="form-control" placeholder="Descripción de las funciones del cargo"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Area</label>
                    <div class="col-md-10">
                        <select name="cargo_area" id="cargo_area" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($areas as $a){
                        
                        ?>
                            <option id="<?= ($areas[$i]->id_area);?>"><?php echo($areas[$i]->area);?></option>
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
            <button type="button" type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

        <!--MODAL DELETE-->
        <form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="cargo_salario_delete" id="cargo_salario_delete" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->

 <!-- MODAL EDIT -->
 <form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editar</h5>
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
                    <input type="hidden" name="cargo_code_edit" id="cargo_code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Cargo</label>
                <div class="col-md-10">
                    <input type="text" name="cargo_name_edit" id="cargo_name_edit" class="form-control" placeholder="Ingresa cambio">
                </div>
            </div>
            <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripción Cargo</label>
                    <div class="col-md-10">
                        <textarea name="descripcion_edit" id="descripcion_edit" class="form-control" placeholder="Descripción de las funciones del cargo"></textarea>
                    </div>
                </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Area</label>
                <div class="col-md-10">
                    <select name="cargo_area_edit" id="cargo_area_edit" class="form-control" placeholder="Price">

                        <?php
                        $i=0;
                        foreach($areas as $a){
        
                                ?>
                                <option id="<?= ($areas[$i]->id_area);?>" value="<?= ($areas[$i]->id_area);?>"><?php echo($areas[$i]->area);?></option>
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
<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        show_cargos();	//call function show all product

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
        function show_cargos(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('cargos/cargos_data')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
                    console.log(data);
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
		                html += '<tr>'+
		                	    '<td>'+data[i].cargo+'</td>'+
		                        '<td>'+data[i].area+'</td>'+
		                        '<td style="text-align:right;">'+
                                    '<?php if($editar){?><a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-id_cargo="'+data[i].id_cargo+'" data-cargo="'+data[i].cargo+'" data-id_area="'+data[i].id_area+'" data-descripcion="'+data[i].descripcion+'">Edit</a><?php } ?>'+' '+
                                  '<?php if($eliminar){ ?><a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-codigo="'+data[i].id_cargo+'">Delete</a><?php } ?>'+' '+
                                     /* '<?php if($ver){?><a href="javascript:void(0);" class="btn btn-success btn-sm item_ver" data-product_code="'+data[i].product_code+'">Ver</a><?php } ?>'+*/
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
            //Save cargo
            $('#btn_save').on('click',function(){
            this.disabled=true;
            //var employee_code = $('#employee_code').val();
            var cargo_name = $('#cargo_name').val();
            var descripcion = $('#descripcion').val();
            var cargo_area = $('#cargo_area').children(":selected").attr("id");
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('cargos/save')?>",
                dataType : "JSON",
                data : { cargo_name:cargo_name,cargo_area:cargo_area,descripcion:descripcion},
                success: function(data){
                    $('[name="cargo_name"]').val("");
                    $('[name="descripcion"]').val("");
                    $('[name="cargo_area"]').val("");
                    location.reload();
                    this.disabled=false;
                    show_cargos();
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
            var code   = $(this).data('id_cargo');
            var cargo   = $(this).data('cargo');
            var area   = $(this).data('id_area');
            var descripcion   = $(this).data('descripcion');
            $('#Modal_Edit').modal('show');
            $('[name="cargo_code_edit"]').val(code);
            $('[name="descripcion_edit"]').val(descripcion);
            $('[name="cargo_name_edit"]').val(cargo);
            $('[name="cargo_area_edit"]').val(area);

        });

        //update record to database
        $('#btn_update').on('click',function(){
            var code = $('#cargo_code_edit').val();
            var descripcion = $('#descripcion_edit').val();
            var name = $('#cargo_name_edit').val();
            var cargo_area = $('#cargo_area_edit').children(":selected").attr("id");
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Cargos/update')?>",
                dataType : "JSON",
                data : {code:code,name:name,cargo_area:cargo_area,descripcion:descripcion},
                success: function(data){
                    $('[name="cap_code_edit"]').val("");
                    $('[name="cap_name_edit"]').val("");
                    $('[name="cap_name_edit"]').val("");
                    $('[name="descripcion_edit"]').val("");


                    $('#Modal_Edit').modal('toggle');
                    $('.modal-backdrop').remove();
                    //location.reload();

                    show_cargos();
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
                $('[name="cargo_salario_delete"]').val(code);
        });

        //delete record to database
        $('#btn_delete').on('click',function(){
            var code = $('#cargo_salario_delete').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Cargos/delete')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="cargo_salario_delete"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();

                    show_cargos();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

    });//marca fin 
</script>
</body>
</html>