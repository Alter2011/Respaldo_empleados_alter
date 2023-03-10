
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Ingenieria de la Web</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/bootstrap.css'?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/jquery.dataTables.css'?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/dataTables.bootstrap4.css'?>">
    
</head>
<?php
    if($this->session->userdata('login')){
?>
<body>
<div class="container">
	<!-- Page Heading -->
    <div class="row">
        <div class="col-12">
        
            <div class="col-md-12">
                <h1><center><small>Lista de </small>Empleados</center>
                </h1>
                
                <div class="float-center"><a href="#" class="btn btn-basic"><span class="fa fa-plus"></span> Bienvenido <strong><?php print_r($nombre[0]->nombre. " ". $nombre[0]->apellido);?></strong></a></div>
                <div class="float-left"><a href="<?= base_url();?>index.php/iniciar/logout" class="btn btn-danger"><span class="fa fa-plus"></span> Cerrar Sesion</a></div>
                <div class="float-right"><a href="javascript:void(0);" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a></div>
                
            </div>
            
            <table class="table table-striped" id="mydata">
                <thead>
                    <tr>
                        <!--
                        <th>Codigo</th>
                        -->
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo</th>
                        <th>Clave</th>
                        <th>Celular</th>
                        <th>Direccion</th>
                        <th>Imagen</th>
                        <th>Rol</th>
                        <th style="text-align: right;">Accion</th>
                    </tr>
                </thead>
                <tbody id="show_data">
                    
                </tbody>
            </table>
        </div>
    </div>
        
</div>

		<!-- MODAL ADD -->
            <form>
            <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar Usuario Nuevo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php
                        if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    <!--    
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Product Code</label>
                            <div class="col-md-10">
                              <input type="text" name="product_code" id="product_code" class="form-control" placeholder="Product Code">
                            </div>
                        </div>
                    -->
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nombres</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_name" id="employee_name" class="form-control" placeholder="Nombre usuario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Apellidos</label>
                            <div class="col-md-10">
                            <input type="text" name="employee_last" id="employee_last" class="form-control" placeholder="Apellido usuario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Correo electronico</label>
                            <div class="col-md-10">
                              <input type="mail" name="employee_mail" id="employee_mail" class="form-control" placeholder="Correo Electronico">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Clave</label>
                            <div class="col-md-10">
                              <input type="password" name="clave" id="clave" class="form-control" placeholder="Clave">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Telefono</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_cel" id="employee_cel" class="form-control" placeholder="Numero de telefono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_ad" id="employee_ad" class="form-control" placeholder="Direccion">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Imagen</label>
                            <div class="col-md-10">
                              <input type="file" name="employee_image" id="employee_image" class="form-control" placeholder="Imagen de perfil">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Rol</label>
                            <div class="col-md-10">
                                <select name="rol" id="rol" class="form-control" placeholder="Price">
                                    <option id=1>Administrador</option>
                                    <option id=2>Usuario</option>
                                </select>
                            </div>
                        </div>
                    <?php }else{?>
                        <div class="alert alert-warning">
                            <h2><strong>Informacion</strong> </h2>
                            <br>
                            Su nivel de usuario no le permite ingresar nuevos empleados al sistema.
                        </div>
                    <?php }?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <?php
                        if($this->session->userdata('rol')=="Administrador"){ 
                    ?>
                    <button type="button" type="submit" id="btn_save" class="btn btn-primary">Guardar</button>
                    <?php
                        }
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
                    <h5 class="modal-title" id="exampleModalLabel">Editar Empleado</h5>
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
                              <input type="hidden" name="employee_code_edit" id="employee_code_edit" class="form-control" placeholder="Product Code" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nombres</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_name_edit" id="employee_name_edit" class="form-control" placeholder="Nombre usuario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Apellidos</label>
                            <div class="col-md-10">
                            <input type="text" name="employee_last_edit" id="employee_last_edit" class="form-control" placeholder="Apellido usuario">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Correo electronico</label>
                            <div class="col-md-10">
                              <input type="mail" name="employee_mail_edit" id="employee_mail_edit" class="form-control" placeholder="Correo Electronico">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Clave</label>
                            <div class="col-md-10">
                              <input type="password" name="clave_edit" id="clave_edit" class="form-control" placeholder="Clave">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Telefono</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_cel_edit" id="employee_cel_edit" class="form-control" placeholder="Numero de telefono">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_ad_edit" id="employee_ad_edit" class="form-control" placeholder="Direccion">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Imagen</label>
                            <div class="col-md-10">
                              <input type="file" name="employee_image_edit" id="employee_image_edit" class="form-control" placeholder="Imagen de perfil">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Rol</label>
                            <div class="col-md-10">
                            <?php
                            if($this->session->userdata('rol')=="Administrador"){ 
                            ?>
                                <select name="rol_edit" id="rol_edit" class="form-control" placeholder="Price">
                                    <option id=1>Administrador</option>
                                    <option id=2>Usuario</option>
                                </select>
                            <?php
                            }else{
                            ?>
                                <select name="rol_edit" id="rol_edit" class="form-control" placeholder="Price" disabled='true'>
                                    <option id=1>Administrador</option>
                                    <option id=2>Usuario</option>
                                </select>
                            <?php
                            }
                            ?>
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
                    <input type="hidden" name="employee_code_delete" id="employee_code_delete" class="form-control">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!--END MODAL DELETE-->
        <!--MODAL READ-->
        <form>
            <div class="modal fade" id="Modal_Read" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Datos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Product Code</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_code_read" id="employee_code_read" class="form-control" placeholder="Product Code" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Nombres</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_name_read" id="employee_name_read" class="form-control" placeholder="Nombre usuario" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Apellidos</label>
                            <div class="col-md-10">
                            <input type="text" name="employee_last_read" id="employee_last_read" class="form-control" placeholder="Apellido usuario" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Correo electronico</label>
                            <div class="col-md-10">
                              <input type="mail" name="employee_mail_read" id="employee_mail_read" class="form-control" placeholder="Correo Electronico" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Clave</label>
                            <div class="col-md-10">
                              <input type="password" name="clave_read" id="clave_read" class="form-control" placeholder="Clave" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Telefono</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_cel_read" id="employee_cel_read" class="form-control" placeholder="Numero de telefono" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Direccion</label>
                            <div class="col-md-10">
                              <input type="text" name="employee_ad_read" id="employee_ad_read" class="form-control" placeholder="Direccion" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Imagen</label>
                            <div class="col-md-10">
                                <img name="employee_imagen_read" heigth="50" width="50" src="<?php echo base_url();?>assets/images/<?= rand(0,4);?>.png">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Rol</label>
                            <div class="col-md-10">
                                <select name="rol_read" id="rol_read" class="form-control" placeholder="Price" readonly disabled="true">
                                    <option id=1>Administrador</option>
                                    <option id=2>Usuario</option>
                                </select>
                            </div>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" type="button" id="btn_read" class="btn btn-primary">Aceptar</button>
                  </div>
                </div>
              </div>
            </div>
            </form>
        <!-- END MODAL READ-->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>

<script type="text/javascript">
	$(document).ready(function(){
		show_employee();	//call function show all product
		$('#mydata').dataTable( {
            "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
            "iDisplayLength": 3
        } );
		//$('#mydata').dataTable();
		 

         <?php
         if($this->session->userdata('rol')=="Administrador"){ 
         ?>
		//function show all product
		function show_employee(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('employee/employee_data')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
                    var ran;
                    <?php $ran = 0; ?>
		            for(i=0; i<data.length; i++){
                        <?php $ran = rand(0,4); ?>
                        ran = Math.floor(Math.random() * 4); 
		                html += '<tr>'+
		                  		//'<td>'+data[i].codigo+'</td>'+
		                        '<td>'+data[i].nombre+'</td>'+
		                        '<td>'+data[i].apellido+'</td>'+
                                '<td>'+data[i].email+'</td>'+
		                        '<td>*****</td>'+
		                        '<td>'+data[i].telefono+'</td>'+
                                '<td>'+data[i].direccion+'</td>'+
		                        '<td><img name="employee_imagen_read" heigth="50" width="50" src="<?php echo base_url();?>assets/images/'+ran+'.png"></td>'+
		                        '<td>'+data[i].rol+'</td>'+
		                        '<td style="text-align:right;">'+
                                    '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].codigo+'" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-email="'+data[i].email+'"data-clave="'+data[i].clave+'"data-tel="'+data[i].telefono+'"data-dir="'+data[i].direccion+'"data-imagen="'+data[i].imagen+'"data-rol="'+data[i].rol+'">Editar</a>'+' '+
                                    '<a href="javascript:void(0);" class="btn btn-danger btn-sm item_delete" data-codigo="'+data[i].codigo+'">Delete</a>'+' '+
                                    '<a href="javascript:void(0);" class="btn btn-success btn-sm item_read" data-codigo="'+data[i].codigo+'" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-email="'+data[i].email+'"data-clave="'+data[i].clave+'"data-tel="'+data[i].telefono+'"data-dir="'+data[i].direccion+'"data-imagen="'+data[i].imagen+'"data-rol="'+data[i].rol+'">Ver</a>'+' '+
                                '</td>'+
		                        '</tr>';
		            }
                    
		            $('#show_data').html(html);
		        }
		    });
		}
        <?php
         }else{ 
         ?>
         function show_employee(){
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('employee/employee_data')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
		            var html = '';
		            var i;
                    var id_php = <?php echo $nombre[0]->codigo;?>;
                    ran = Math.floor(Math.random() * 4); 
		            for(i=0; i<data.length; i++){
                        if(id_php==data[i].codigo){
                            html += '<tr>'+
                                //'<td>'+data[i].codigo+'</td>'+
                                '<td>'+data[i].nombre+'</td>'+
                                '<td>'+data[i].apellido+'</td>'+
                                '<td>'+data[i].email+'</td>'+
                                '<td>*****</td>'+
                                '<td>'+data[i].telefono+'</td>'+
                                '<td>'+data[i].direccion+'</td>'+
                                '<td><img name="employee_imagen_read" heigth="50" width="50" src="<?php echo base_url();?>assets/images/'+ran+'.png"></td>'+
                                '<td>'+data[i].rol+'</td>'+
                                '<td style="text-align:right;">'+
                                '<a href="javascript:void(0);" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].codigo+'" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-email="'+data[i].email+'"data-clave="'+data[i].clave+'"data-tel="'+data[i].telefono+'"data-dir="'+data[i].direccion+'"data-imagen="'+data[i].imagen+'"data-rol="'+data[i].rol+'">Editar</a>'+' '+
                                '<a href="javascript:void(0);" class="btn btn-success btn-sm item_read" data-codigo="'+data[i].codigo+'" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-email="'+data[i].email+'"data-clave="'+data[i].clave+'"data-tel="'+data[i].telefono+'"data-dir="'+data[i].direccion+'"data-imagen="'+data[i].imagen+'"data-rol="'+data[i].rol+'">Ver</a>'+' '+
                                '</td>'+
                                '</tr>';
                        }else{
		                html += '<tr>'+
		                  		//'<td>'+data[i].codigo+'</td>'+
		                        '<td>'+data[i].nombre+'</td>'+
		                        '<td>'+data[i].apellido+'</td>'+
                                '<td>'+data[i].email+'</td>'+
		                        '<td>*****</td>'+
		                        '<td>'+data[i].telefono+'</td>'+
                                '<td>'+data[i].direccion+'</td>'+
		                        '<td><img name="employee_imagen_read" heigth="50" width="50" src="<?php echo base_url();?>assets/images/'+ran+'.png"></td>'+
		                        '<td>'+data[i].rol+'</td>'+
		                        '<td style="text-align:right;">'+
                                '<a href="javascript:void(0);" class="btn btn-success btn-sm item_read" data-codigo="'+data[i].codigo+'" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-email="'+data[i].email+'"data-clave="'+data[i].clave+'"data-tel="'+data[i].telefono+'"data-dir="'+data[i].direccion+'"data-imagen="'+data[i].imagen+'"data-rol="'+data[i].rol+'">Ver</a>'+' '+
                                '</td>'+
                                '</tr>';
                        }
		            }
		            $('#show_data').html(html);
		        }
		    });
		}
         <?php
         }
         ?>
        //Save product
        $('#btn_save').on('click',function(){
            //var employee_code = $('#employee_code').val();
            var employee_name = $('#employee_name').val();
            var employee_last = $('#employee_last').val();
            var employee_mail = $('#employee_mail').val();
            var employee_cel  = $('#employee_cel').val();
            var employee_ad   = $('#employee_ad').val();
            var employee_image= $('#employee_image').val();
            var rol           = $('#rol').val();
            var clave         = $('#clave').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('employee/save')?>",
                dataType : "JSON",
                data : { employee_name:employee_name, employee_last:employee_last , employee_mail:employee_mail, employee_cel:employee_cel, employee_ad:employee_ad, employee_image:employee_image,rol:rol,clave:clave},
                success: function(data){
                    $('[name="employee_name"]').val("");
                    $('[name="employee_last"]').val("");
                    $('[name="employee_mail"]').val("");
                    $('[name="employee_cel"]').val("");
                    $('[name="employee_ad"]').val("");
                    $('[name="employee_image"]').val("");
                    $('[name="clave"]').val("");
                    $('#Modal_Add').modal('hide');
                    show_employee();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

        //Captura informacion para ver
        $('#show_data').on('click','.item_read',function(){
            var employee_code   = $(this).data('codigo');
            var employee_name   = $(this).data('nombre');
            var employee_last   = $(this).data('apellido');
            var employee_mail   = $(this).data('email');
            var employee_clave  = $(this).data('clave');
            var employee_tel    = $(this).data('tel');
            var employee_dir    = $(this).data('dir');
            var employee_imagen = $(this).data('imagen');
            var employee_rol    = $(this).data('rol');
            
            $('#Modal_Read').modal('show');
            $('[name="employee_code_read"]').val(employee_code);
            $('[name="employee_name_read"]').val(employee_name);
            $('[name="employee_last_read"]').val(employee_last);
            $('[name="employee_mail_read"]').val(employee_mail);
            $('[name="clave_read"]').val(employee_clave);
            $('[name="employee_cel_read"]').val(employee_tel);
            $('[name="employee_ad_read"]').val(employee_dir);
            //$('[name="employee_imagen_read"]').attr('src',employee_imagen);
            $('[name="rol_read"]').val(employee_rol);
        });

        //get data for update record
        $('#show_data').on('click','.item_edit',function(){
            var employee_code   = $(this).data('codigo');
            var employee_name   = $(this).data('nombre');
            var employee_last   = $(this).data('apellido');
            var employee_mail   = $(this).data('email');
            var employee_clave  = $(this).data('clave');
            var employee_tel    = $(this).data('tel');
            var employee_dir    = $(this).data('dir');
            //var employee_imagen = $(this).data('imagen');
            var employee_rol    = $(this).data('rol');
            
            $('#Modal_Edit').modal('show');
            $('[name="employee_code_edit"]').val(employee_code);
            $('[name="employee_name_edit"]').val(employee_name);
            $('[name="employee_last_edit"]').val(employee_last);
            $('[name="employee_mail_edit"]').val(employee_mail);
            //$('[name="clave_edit"]').val(employee_clave);
            $('[name="employee_cel_edit"]').val(employee_tel);
            $('[name="employee_ad_edit"]').val(employee_dir);
            //$('[name="employee_imagen_edit"]').val(employee_imagen);
            $('[name="rol_edit"]').val(employee_rol);
        });

        //update record to database
         $('#btn_update').on('click',function(){
            var employee_code = $('#employee_code_edit').val();
            var employee_name = $('#employee_name_edit').val();
            var employee_last = $('#employee_last_edit').val();
            var employee_mail = $('#employee_mail_edit').val();
            var employee_cel  = $('#employee_cel_edit').val();
            var employee_ad   = $('#employee_ad_edit').val();
            var employee_image= $('#employee_image_edit').val();
            var rol           = $('#rol_edit').val();
            var clave         = $('#clave_edit').val();
            
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('employee/update')?>",
                dataType : "JSON",
                data : {employee_code:employee_code,employee_name:employee_name, employee_last:employee_last , employee_mail:employee_mail, employee_cel:employee_cel, employee_ad:employee_ad, employee_image:employee_image,rol:rol,clave:clave},
                success: function(data){
                    $('[name="employee_code_edit"]').val("");
                    $('[name="employee_name_edit"]').val("");
                    $('[name="employee_last_edit"]').val("");
                    $('[name="employee_mail_edit"]').val("");
                    $('[name="employee_cel_edit"]').val("");
                    $('[name="employee_ad_edit"]').val("");
                    $('[name="employee_image_edit"]').val("");
                    $('[name="clave_edit"]').val("");
                    $('#Modal_Edit').modal('hide');
                    show_employee();
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
            var product_code = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="employee_code_delete"]').val(product_code);
        });

        //delete record to database
         $('#btn_delete').on('click',function(){
            var employee_code = $('#employee_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('employee/delete')?>",
                dataType : "JSON",
                data : {employee_code:employee_code},
                success: function(data){
                    $('[name="employee_code_delete"]').val("");
                    $('#Modal_Delete').modal('hide');
                    show_employee();
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
<?php
    }else{
        header("Location:". base_url()."index.php/employee/login");
    }
?>
</html>