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
                <h2>Historietas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                       <nav class="float-right">
                           
                        <a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a>
                         
                    </nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th>Historietas</th>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Historieta Nueva</h3>
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
                    <label class="col-md-2 col-form-label">Historieta</label>
                    <div class="col-md-10">
                        <input type="text" name="historieta_name" id="historieta_name" class="form-control" placeholder="Historieta">
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
            <h5 class="modal-title" id="exampleModalLabel">Editar Historieta</h5>
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
                    <input type="hidden" name="historieta_code_edit" id="historieta_code_edit" class="form-control" placeholder="Product Code" readonly >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre historieta</label>
                <div class="col-md-10">
                    <input type="text" name="historieta_name_edit" id="historieta_name_edit" class="form-control" placeholder="Nombre usuario">
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Registro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="historieta_code_delete" id="historieta_code_delete" class="form-control">
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
        show_historieta();    //call function show all product

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
        function show_historieta(){
            $.ajax({
                type  : 'ajax',
                url   : '<?php echo site_url('Historietas/Historietas_data')?>',
                async : false,
                dataType : 'json',
                success : function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].historieta+'</td>'+
                                '<td style="text-align:right;">'+
                                    '<a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].id_historieta+'" data-nombre="'+data[i].historieta+'">Edit</a>'+' '+
                                    '<a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Delete" class="btn btn-danger btn-sm item_delete" data-codigo="'+data[i].id_historieta+'">Delete</a>'+' '+
                                   /* '<?php if($ver){ ?><a href="javascript:void(0);" class="btn btn-success btn-sm item_ver" data-product_code="'+data[i].product_code+'">Ver</a><?php } ?>'+*/
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


        //Save product
        $('#btn_save').on('click',function(){
            this.disabled=true;
            //var employee_code = $('#employee_code').val();
            var name = $('#historieta_name').val();
            
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Historietas/save')?>",
                dataType : "JSON",
                data : { name:name},
                success: function(data){
                    //$('[name="historieta_name"]').val("");
                    //$('#Modal_Add').modal('hide');
                    location.reload();
                    this.disabled=false;
                    show_historieta();
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
            var code   = $(this).data('codigo');
            var name   = $(this).data('nombre');
            
            $('#Modal_Edit').modal('show');
            $('[name="historieta_code_edit"]').val(code);
            $('[name="historieta_name_edit"]').val(name);
            
        });

        //update record to database
        $('#btn_update').on('click',function(){
            var code = $('#historieta_code_edit').val();
            var name = $('#historieta_name_edit').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Historietas/update')?>",
                dataType : "JSON",
                data : {code:code,name:name},
                success: function(data){
                    $('[name="historieta_code_edit"]').val("");
                    $('[name="historieta_name_edit"]').val("");
                    $('#Modal_Edit').modal('toggle');
                    $('.modal-backdrop').remove();
                    //location.reload();

                    show_historieta();
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
                var code = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="historieta_code_delete"]').val(code);
        });

        //delete record to database
        $('#btn_delete').on('click',function(){
            var code = $('#historieta_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Historietas/delete')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="historieta_code_delete"]').val("");
                    $('#Modal_Delete').modal('toggle');
                    $('.modal-backdrop').remove();

                    show_historieta();
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