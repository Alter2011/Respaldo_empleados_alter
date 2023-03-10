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
                <h2>Historial Laboral</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <!--
                                    <th>Codigo</th>
                                    -->
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DUI</th>
                                    <th>Telefono</th>
                                    <th>Correo</th>
                                    <th>Nivel</th>
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
 <!-- MODAL EDIT -->
 <form>
    <div class="modal fade" id="Modal_Read" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Ver Empleado</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Nombres</label>
                    <input type="text" name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Apellidos</label>
                    <input type="text" name="empleado_apellido" id="empleado_apellido" class="form-control" placeholder="Ej: Valladares Quezada">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">DUI</label>                             
                    <input type="text" data-grouplength="8," name="empleado_dui" id="empleado_dui" class="form-control " placeholder="Ej: #########-#">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">NIT</label>
                    <input type="text" name="empleado_nit" id="empleado_nit" class="form-control" placeholder="Ej: ####-######-###-#">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">AFP</label>
                    <input type="text" name="empleado_afp" id="empleado_afp" class="form-control" placeholder="Ej: ##########">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">ISSS</label>
                    <input type="text" name="empleado_isss" id="empleado_isss" class="form-control" placeholder="Ej: ##########">
                </div>
            </div>
            <div class="form-group col-md-12">
                <label for="inputAddress">Direccion</label>
                <input type="text" name="empleado_dir" id="empleado_dir" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
            </div>
            <div class="form-group col-md-12">
                <label for="inputAddress2">Direccion 2</label>
                <input type="text" name="empleado_dir2" id="empleado_dir2" class="form-control" placeholder="Ej: Direccion opcional">
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputCity">Correo Electronico</label>
                <input type="text" name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com">
                </div>
                <div class="form-group col-md-6">
                <label for="inputState">Telefono</label>
                <input type="text" name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####">

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                <label for="inputState">Nivel Academico</label>
                    <select name="empleado_nivel" id="empleado_nivel" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($nivel as $a){
                        
                        ?>
                            <option id="<?= ($nivel[$i]->id_nivel);?>" value="<?= ($nivel[$i]->id_nivel);?>"><?php echo($nivel[$i]->nivel);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="empleado_activo">Activo</label><br>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" id="empleado_activo" class="btn btn-secondary">Activo</button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
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
        show_area();	//call function show all product

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
            },
            "search": {
                "caseInsensitive": false
            }
        } );

        //function show all product
        function show_area(){
            var act = 'Activo';
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('Empleado/empleados_contrato')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
                    //console.log(data);
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
		                html += '<tr>'+
		                	    '<td>'+data[i].nombre+'</td>'+
                                '<td>'+data[i].apellido+'</td>'+
                                '<td>'+data[i].dui+'</td>'+
                                '<td>'+data[i].tel_personal+'</td>'+
                                '<td>'+data[i].correo_personal+'</td>'+
                                '<td>'+data[i].nivel+'</td>'+
		                        '<td style="text-align:right;">'+
                                    '<a href="historial/'+data[i].id_empleado+'" class="btn btn-info btn-sm item_edit">Historial</a>'+
                                    '<a href="Examen/'+data[i].id_empleado+'" class="btn btn-warning btn-sm item_edit">Examen Ingreso</a>'+
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


        //Captura informacion para ver
        $('#show_data').on('click','.item_read',function(){

            var nombre   = $(this).data('nombre');

            //$('#Modal_Read').modal('show');
            $('[name="empleado_nombre"]').val(nombre);
            $('[name="empleado_apellido"]').val($(this).data('apellido'));
            $('[name="empleado_dui"]').val($(this).data('dui'));
            $('[name="empleado_nit"]').val($(this).data('nit'));
            $('[name="empleado_afp"]').val($(this).data('afp'));
            $('[name="empleado_isss"]').val($(this).data('isss'));
            $('[name="empleado_dir"]').val($(this).data('dir1'));
            $('[name="empleado_dir2"]').val($(this).data('dir2'));
            $('[name="empleado_correo"]').val($(this).data('correo'));
            $('[name="empleado_cel"]').val($(this).data('tel'));
            
            $('[name="empleado_cargo"]').val($(this).data('id_cargo'));
            $('[name="empleado_nivel"]').val($(this).data('id_nivel'));
            if($(this).data('activo')==1){
                $("#empleado_activo").text('Activo');
                $( "#empleado_activo" ).removeClass().addClass( "btn btn-primary" );
            }else{
                $("#empleado_activo").text('Inactivo');
                $( "#empleado_activo" ).removeClass().addClass( "btn btn-danger" );
            }
        });

    });
</script>
</body>
</html>