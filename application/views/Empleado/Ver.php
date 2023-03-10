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
                <h2>Ver Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                    <nav class="float-right">
                        <div class="col-sm-10">
                            <?php if ($crear==1){ ?>
                                <a href="<?= base_url();?>index.php/Empleado/Agregar/" class="btn btn-primary" ><span class="fa fa-plus"></span> Agregar Nuevo</a>
                            <?php } ?>
                        </div>
                        <!--<div class="col-sm-2"><a href="<?= base_url();?>index.php/Empleado/Ver/" class="btn btn-success" ><span class="fa fa-search"></span> Ver Empleados</a></div>-->

                    </nav>
                        <table class="table table-striped table-responsive display nowrap" id="mydata" style="width:100%">
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
                                    <th>Estado</th>
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
            <h3 class="modal-title text-center" id="exampleModalLabel">Ver Empleado</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">Nombres</label>
                    <input type="text" name="empleado_nombre" id="empleado_nombre" class="form-control" placeholder="Ej: Armando Benjamin">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Apellidos</label>
                    <input type="text" name="empleado_apellido" id="empleado_apellido" class="form-control" placeholder="Ej: Valladares Quezada">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Fecha Nacimiento</label>
                    <input type="date" name="empleado_fecha" id="empleado_fecha" class="form-control">
                </div>
                    <div class="form-group col-md-3">
                       <label for="inputState">Nacionalidad</label>
                        <select name="nacionalidad" id="nacionalidad" class="form-control" placeholder="Price">
                           <?php
                           $i=0;
                           foreach($nacionalidad as $a){
                               if ($empleado[0]->nacionalidad==$nacionalidad[$i]->gentilicio_nac)
                               {
                               ?>
                        <option selected id="<?= ($nacionalidad[$i]->id_nacionalidad);?>" value="<?= ($nacionalidad[$i]->gentilicio_nac);?>"><?php echo($nacionalidad[$i]->pais_nac);?></option>
                        <?php 
                                }else{
                        ?>
                        <option id="<?= ($nacionalidad[$i]->id_nacionalidad);?>" value="<?= ($nacionalidad[$i]->gentilicio_nac);?>"><?php echo($nacionalidad[$i]->pais_nac);?></option>
                        <?php
                            }
                                $i++;
                            }
                            ?>
                        </select>
                    </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Estado Civil</label>
                    <select class="form-control" name="empleado_civil" id="empleado_civil" class="form-control">
                        <option value=0>Soltero/a</option>
                        <option value=1>Casado/a</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Profesion u Oficio</label>
                    <input type="text" name="profesion" id="profesion" class="form-control" placeholder="Ej: Estudiante">
                </div>

            <div class="form-group col-md-3">
                <label for="inputPassword4">Genero</label>
                    <select class="form-control" name="genero" id="genero" class="form-control">
                            <option value="0">Masculino</option>
                            <option value="1">Femenino</option>
                    </select>
            </div>

                <div class="form-group col-md-3">
                    <label for="inputEmail4">DUI</label>                             
                    <input type="text" data-grouplength="8," name="empleado_dui" id="empleado_dui" class="form-control " placeholder="Ej: #########-#">
                </div>

                <div class="form-group col-md-3">
                    <label for="inputPassword4">Lugar de expedicion</label>
                    <input type="text" name="dui_expedicion" id="dui_expedicion" class="form-control" placeholder="Ej: Sonsonate,Sonsonate  ">
                </div>
                               
                <div class="form-group col-md-3">
                    <label for="inputPassword4">Fecha de expedicion</label>
                    <input type="date" name="dui_fecha_expedicion" id="dui_fecha_expedicion" class="form-control">
                </div>
            </div>
            <div class="form-row">


                <div class="form-group col-md-3">
                    <label for="inputPassword4">NIT</label>
                    <input type="text" name="empleado_nit" id="empleado_nit" class="form-control" placeholder="Ej: ####-######-###-#">
                </div>
                <div class="form-group col-md-3" id="afp">
                    <label for="inputEmail4">AFP</label>
                    <input type="text" name="empleado_afp" id="empleado_afp" class="form-control" placeholder="Ej: ##########">
                </div>
                <div class="form-group col-md-3" id="ipsfa">
                    <label for="inputEmail4">IPSFA</label>
                    <input type="text" name="empleado_ipsfa" id="empleado_ipsfa" class="form-control" placeholder="Ej: ##########">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputPassword4">ISSS</label>
                    <input type="text" name="empleado_isss" id="empleado_isss" class="form-control" placeholder="Ej: ##########">
                </div>

                <div class="form-group col-md-9">
                    <label for="inputAddress">Direccion</label>
                    <input type="text" name="empleado_dir" id="empleado_dir" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputAddress2">Domicilio</label>
                    <input type="text" name="domicilio" id="domicilio" class="form-control" placeholder="Ej: San Salvador,San Salvador">
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-9">
                    <label for="inputAddress2">Direccion 2</label>
                    <input type="text" name="empleado_dir2" id="empleado_dir2" class="form-control" placeholder="Ej: Direccion opcional">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                <label for="inputCity">Correo Electronico</label>
                <input type="text" name="empleado_correo" id="empleado_correo" class="form-control" placeholder="Ej: armamin@mail.com">
                </div>
                <div class="form-group col-md-3">
                <label for="inputCity">Correo Empresarial</label>
                <input type="text" name="empleado_correo_emp" id="empleado_correo_emp" class="form-control" placeholder="Ej: altercredit.armamin@mail.com">
                </div>
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
            </div>
            <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputState">Telefono</label>
                <input type="text" name="empleado_cel" id="empleado_cel" class="form-control" placeholder="Ej: ####-####">
            </div>

                <div class="form-group col-md-3">
                    <label for="inputState">Telefono Emergencia</label>
                    <input type="text" name="empleado_cel_eme" id="empleado_cel_eme" class="form-control" placeholder="Ej: ####-####">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Telefono Empresa</label>
                    <input type="text" name="empleado_cel_emp" id="empleado_cel_emp" class="form-control" placeholder="Ej: ####-####">
                </div>

                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="inputState">Persona Dependiente 1</label>
                        <input type="text" name="depen_uno_emp" id="depen_uno_emp" class="form-control" placeholder="Ej: Maria Sophia Valladares Quezada">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="inputState">Parentesco 1</label>
                            <select name="paren_uno_emp" id="paren_uno_emp" class="form-control" placeholder="Price">
                                <?php
                                $i=0;
                                foreach($parentesco as $a){
                                
                                ?>
                                <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                <?php
                                $i++;
                                }
                                ?>
                            </select>
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputState">Direccion Dependiente 1</label>
                        <input type="text" name="depen_direc1" id="depen_direc1" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                    </div>

                    <div class="form-group col-md-3">
                        <label for="inputState">Persona Dependiente 2</label>
                        <input type="text" name="depen_dos_emp" id="depen_dos_emp" class="form-control" placeholder="Ej: Jose Rodrigo Garcia Lopez">
                    </div>
                </div>

                                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 2</label>
                                    <select name="paren_dos_emp" id="paren_dos_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                        
                                        ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>

                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 2</label>
                                    <input type="text" name="depen_direc2" id="depen_direc2" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Persona Dependiente 3</label>
                                    <input type="text" name="depen_tres_emp" id="depen_tres_emp" class="form-control" placeholder="Ej: Leonel Antonio Lopez Carranza">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="inputState">Parentesco 3</label>
                                     <select name="paren_tres_emp" id="paren_tres_emp" class="form-control" placeholder="Price">
                                        <?php
                                        $i=0;
                                        foreach($parentesco as $a){
                                        
                                        ?>
                                            <option id="<?= ($parentesco[$i]->id_parentesco);?>" value="<?= ($parentesco[$i]->parentesco);?>"><?php echo($parentesco[$i]->parentesco);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="inputState">Direccion Dependiente 3</label>
                                    <input type="text" name="depen_direc3" id="depen_direc3" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                                </div>

                            </div>

                <div class="form-group col-md-3">
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
          
            responsive: true
        } );
        
        //function show all product
        function show_area(){
            var act = 'Activo';
		    $.ajax({
		        type  : 'ajax',
		        url   : '<?php echo site_url('Empleado/empleados_data')?>',
		        async : false,
		        dataType : 'json',
		        success : function(data){
                    console.log(data);
		            var html = '';
		            var i;
		            for(i=0; i<data.length; i++){
                        act = data[i].activo;
                        if(act==0)
                            act = 'Inactivo';
                        else{
                            act='Activo';
                        }
		                html += '<tr>'+
		                	    '<td>'+data[i].nombre+'</td>'+
                                '<td>'+data[i].apellido+'</td>'+
                                '<td>'+data[i].dui+'</td>'+
                                '<td>'+data[i].tel_personal+'</td>'+
                                '<td>'+data[i].correo_personal+'</td>'+
                                '<td>'+data[i].nivel+'</td>'+
                                '<td>'+act+'</td>'+
		                        '<td style="text-align:right;">'+
                                    '<a class="btn btn-warning" href="<?php echo base_url();?>index.php/Empleado/generarQR/'+data[i].id_empleado+'" style="margin:5px;">Generar QR</a>'+
                                    '<?php if ($editar==1){ ?><a href="<?php echo base_url();?>index.php/Empleado/ver/'+data[i].id_empleado+'" class="btn btn-info btn-sm item_edit" style="margin:5px;">Editar</a><?php } ?>'+
                                    '<?php if ($ver==1){ ?><a href="" data-toggle="modal" data-target="#Modal_Read" class="btn btn-success btn-sm item_read" data-nombre="'+data[i].nombre+'" data-apellido="'+data[i].apellido+'" data-dui="'+data[i].dui+'" data-activo="'+data[i].activo+'"data-afp="'+data[i].afp+'"data-ipsfa="'+data[i].ipsfa+'"data-correo="'+data[i].correo_personal+'"data-dir1="'+data[i].direccion1+'"data-dir2="'+data[i].direccion2+'"data-id_nivel="'+data[i].id_nivel+'"data-isss="'+data[i].isss+'"data-nit="'+data[i].nit+'"data-profesi="'+data[i].profesion_oficio+'"data-dui_exped="'+data[i].lugar_expedicion_dui+'"data-tel="'+data[i].tel_personal+'"data-dui_fecha_exped="'+data[i].fecha_expedicion_dui+'"data-domici="'+data[i].domicilio+'"data-depen1="'+data[i].dependiente1+'"data-paren_uno="'+data[i].parentesco1+'"data-depen_direccion1="'+data[i].dependiente_direccion1+'"data-depen_dos="'+data[i].dependiente2+'"data-paren_dos="'+data[i].parentesco2+'"data-depen_direccion2="'+data[i].dependiente_direccion2+'"data-depen_tres="'+data[i].dependiente3+'"data-paren_tres="'+data[i].parentesco3+'"data-depen_direccion3="'+data[i].dependiente_direccion3+'"data-emp_fecha="'+data[i].fecha_nac+'"data-genero="'+data[i].genero+'"data-nacional="'+data[i].nacionalidad+'">Ver</a><?php } ?>'+' '+
                                    
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
            var afp = $(this).data('afp');
            var ipsfa = $(this).data('ipsfa');

            if($(this).data('afp') == ""){
                $('[name="empleado_ipsfa"]').val($(this).data('ipsfa'));
                $('#afp').hide();
                $('#ipsfa').show();
            }else if($(this).data('ipsfa') == ""){
                $('[name="empleado_afp"]').val($(this).data('afp'));
                $('#afp').show();
                $('#ipsfa').hide();
            }else{
                $('[name="empleado_afp"]').val($(this).data('afp'));
                $('#afp').show();
                $('#ipsfa').hide();
            }   

            //$('#Modal_Read').modal('show');
            $('[name="empleado_nombre"]').val(nombre);
            $('[name="empleado_apellido"]').val($(this).data('apellido'));
            $('[name="empleado_fecha"]').val($(this).data('emp_fecha'));
            $('[name="nacionalidad"]').val($(this).data('nacional'));
            $('[name="profesion"]').val($(this).data('profesi'));
            $('[name="genero"]').val($(this).data('genero'));
            $('[name="empleado_dui"]').val($(this).data('dui'));
            $('[name="dui_expedicion"]').val($(this).data('dui_exped'));
            $('[name="dui_fecha_expedicion"]').val($(this).data('dui_fecha_exped'));
            $('[name="domicilio"]').val($(this).data('domici'));
            $('[name="empleado_nit"]').val($(this).data('nit'));
            
            $('[name="empleado_isss"]').val($(this).data('isss'));
            $('[name="empleado_dir"]').val($(this).data('dir1'));
            $('[name="empleado_dir2"]').val($(this).data('dir2'));
            $('[name="empleado_correo"]').val($(this).data('correo'));
            $('[name="empleado_cel"]').val($(this).data('tel'));

            $('[name="depen_uno_emp"]').val($(this).data('depen1'));
            $('[name="paren_uno_emp"]').val($(this).data('paren_uno'));
            $('[name="depen_direc1"]').val($(this).data('depen_direccion1'));
            $('[name="depen_dos_emp"]').val($(this).data('depen_dos'));
            $('[name="paren_dos_emp"]').val($(this).data('paren_dos'));
            $('[name="depen_direc2"]').val($(this).data('depen_direccion2'));
            $('[name="depen_tres_emp"]').val($(this).data('depen_tres'));
            $('[name="paren_tres_emp"]').val($(this).data('paren_tres'));
            $('[name="depen_direc3"]').val($(this).data('depen_direccion3'));
            
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