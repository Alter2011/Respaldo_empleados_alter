<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Empresas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre Abreviado</th>
                                    <th style="text-align:center;">Nombre Completo</th>      
                                    <th style="text-align:center;">Codigo</th>
                                    <th style="text-align:center;">Casa Matriz</th>
                                    <th style="text-align: center">Giro</th>
                                    <th style="text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php
                              
                                foreach ($empresas as $empresa) {
                                   
                                   echo "<tr>";
                                   echo "<td>".$empresa->nombre_empresa."</td>";
                                   echo "<td>".$empresa->nombre_completo."</td>";
                                   echo "<td>".$empresa->codigo."</td>";
                                   echo "<td>".$empresa->casa_matriz."</td>";
                                   echo "<td>".$empresa->giro."</td>";
                                   echo '<td style="text-align:right;"><a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_empresa="'.$empresa->id_empresa.'"> Editar </a> ';
                                   echo ' <a data-toggle="modal" class="btn btn-primary btn-sm item_ver" data-id_empresa="'.$empresa->id_empresa.'"> Ver </a>';
                                   echo ' <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$empresa->id_empresa.'"> Eliminar </a></td>';
                                   echo "</tr>";
                                };


                                 ?>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Empresa</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
           <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre Abreviado:</label>
                    <div class="col-md-10">
                        <input type="text" name="empresa_nombre" id="empresa_nombre" class="form-control" placeholder="Ej. Altercredit">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre Completo:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_completo" id="nombre_completo" class="form-control" placeholder="Ej. Altercredit">
                        <div id="validacion7" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Codigo:</label>
                    <div class="col-md-10">
                        <input type="text" name="codigo_empresa" id="codigo_empresa" class="form-control" placeholder="Ej. #########">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Registro Civil:</label>
                    <div class="col-md-10">
                        <input type="text" name="registro_empresa" id="registro_empresa" class="form-control" placeholder="Ej. ######-#">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Casa Matriz:</label>
                    <div class="col-md-10">
                        <input type="text" name="casa_empresa" id="casa_empresa" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">NIT:</label>
                    <div class="col-md-10">
                        <input type="text" name="nit_empresa" id="nit_empresa" class="form-control" placeholder="####-######-###-#">
                        <div id="validacion5" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Giro:</label>
                    <div class="col-md-10">
                        <input type="text" name="giro_empresa" id="giro_empresa" class="form-control" placeholder="Ej. Creditos">
                        <div id="validacion6" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Categoria Contribuyente:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="categoria_empresa" id="categoria_empresa" class="form-control">
                            <option value="Grande">Grande</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Pequeño">Pequeño</option>
                        </select>
                    </div>
                </div>
                
            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

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
            <h3 class="modal-title" id="exampleModalLabel">Editar Empresa</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
             <div class="col-md-10">
                    <input type="hidden" name="empresa_code_edit" id="empresa_code_edit" class="form-control" readonly>
                    <input type="hidden" name="empresas_nombre" id="empresas_nombre" class="form-control" readonly>
                </div>
            </div>
             <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre Abreviado:</label>
                    <div class="col-md-10">
                        <input type="text" name="empresa_nombre_edit" id="empresa_nombre_edit" class="form-control" placeholder="Ej. Altercredit">
                        <div id="validacion_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre Completo:</label>
                    <div class="col-md-10">
                        <input type="text" name="nombre_completo_edit" id="nombre_completo_edit" class="form-control" placeholder="Ej. Altercredit">
                        <div id="validacion7_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Codigo:</label>
                    <div class="col-md-10">
                        <input type="text" name="codigo_empresa_edit" id="codigo_empresa_edit" class="form-control" placeholder="Ej. #########">
                        <div id="validacion2_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Registro Civil:</label>
                    <div class="col-md-10">
                        <input type="text" name="registro_empresa_edit" id="registro_empresa_edit" class="form-control" placeholder="Ej. ######-#">
                        <div id="validacion3_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Casa Matriz:</label>
                    <div class="col-md-10">
                        <input type="text" name="casa_empresa_edit" id="casa_empresa_edit" class="form-control" placeholder="Ej: Calle la mascota, avenida Roosevelt, Casa #27">
                        <div id="validacion4_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">NIT:</label>
                    <div class="col-md-10">
                        <input type="text" name="nit_empresa_edit" id="nit_empresa_edit" class="form-control" placeholder="####-######-###-#">
                        <div id="validacion5_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Giro:</label>
                    <div class="col-md-10">
                        <input type="text" name="giro_empresa_edit" id="giro_empresa_edit" class="form-control" placeholder="Ej. Creditos">
                        <div id="validacion6_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Categoria Contribuyente:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="categoria_empresa_edit" id="categoria_empresa_edit" class="form-control">
                            <option value="Grande">Grande</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Pequeño">Pequeño</option>
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
    </div>
</form>
        <!--END MODAL EDIT-->

<!-- MODAL VER -->
<form>
    <div class="modal fade" id="Modal_ver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Ver Empresa</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

             <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" name="empresa_nombre_ver" id="empresa_nombre_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Codigo:</label>
                    <div class="col-md-10">
                        <input type="text" name="codigo_empresa_ver" id="codigo_empresa_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Registro Civil:</label>
                    <div class="col-md-10">
                        <input type="text" name="registro_empresa_ver" id="registro_empresa_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Casa Matriz:</label>
                    <div class="col-md-10">
                        <input type="text" name="casa_empresa_ver" id="casa_empresa_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">NIT:</label>
                    <div class="col-md-10">
                        <input type="text" name="nit_empresa_ver" id="nit_empresa_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Giro:</label>
                    <div class="col-md-10">
                        <input type="text" name="giro_empresa_ver" id="giro_empresa_ver" class="form-control" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Categoria Contribuyente:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="categoria_empresa_ver" id="categoria_empresa_ver" disabled>
                            <option value="Grande">Grande</option>
                            <option value="Mediano">Mediano</option>
                            <option value="Pequeño">Pequeño</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Empresa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="empresa_code_delete" id="empresa_code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->

<script type="text/javascript">
    $(document).ready(function(){

        //Se genera la paguinacion cada ves que se ejeucuta la funcion
             $('#mydata').dataTable({
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
            });
        //Metodo para el ingreso de paises
        $('#btn_save').on('click',function(){
            var empresa_nombre = $('#empresa_nombre').val();
            var nombre_completo = $('#nombre_completo').val();
            var codigo_empresa = $('#codigo_empresa').val();
            var registro_empresa = $('#registro_empresa').val();
            var casa_empresa = $('#casa_empresa').val();
            var nit_empresa = $('#nit_empresa').val();
            var giro_empresa = $('#giro_empresa').val();
            var categoria_empresa = $('#categoria_empresa').val();

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/seveEmpresa')?>",
                dataType : "JSON",
                data : {empresa_nombre:empresa_nombre,codigo_empresa:codigo_empresa,registro_empresa:registro_empresa,casa_empresa:casa_empresa,nit_empresa:nit_empresa,giro_empresa:giro_empresa,categoria_empresa:categoria_empresa,nombre_completo:nombre_completo},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        $('[name="empresa_nombre"]').val("");
                        $('[name="codigo_empresa"]').val("");
                        $('[name="registro_empresa"]').val("");
                        $('[name="casa_empresa"]').val("");
                        $('[name="nit_empresa"]').val("");
                        $('[name="giro_empresa"]').val("");
                        $('[name="categoria_empresa"]').val("");
                        
                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre Abreviado de la Empresa";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Codigo de la Empresa";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion5').innerHTML += "Debe de Ingresar el NIT de la Empresa";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion6').innerHTML += "Debe de Ingresar el Giro de la Empresa";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion7').innerHTML += "Debe de Ingresar el Nombre Completo de la Empresa";
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
        });//fin de insercionde descuentos

         //get data for update record
         $('.item_edit').click(function(){
            var code   = $(this).data('id_empresa');
            document.getElementById('validacion_edit').innerHTML = '';
            document.getElementById('validacion2_edit').innerHTML = '';
            document.getElementById('validacion5_edit').innerHTML = '';
            document.getElementById('validacion6_edit').innerHTML = '';
            document.getElementById('validacion7_edit').innerHTML = '';
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/llenarEmpresa')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    console.log(data);

                    $('[name="empresa_code_edit"]').val(data[0].id_empresa);
                    $('[name="empresas_nombre"]').val(data[0].nombre_empresa);
                    $('[name="empresa_nombre_edit"]').val(data[0].nombre_empresa);
                    $('[name="codigo_empresa_edit"]').val(data[0].codigo);
                    $('[name="registro_empresa_edit"]').val(data[0].registro_civil);
                    $('[name="casa_empresa_edit"]').val(data[0].casa_matriz);
                    $('[name="nit_empresa_edit"]').val(data[0].nit);
                    $('[name="giro_empresa_edit"]').val(data[0].giro);
                    $('[name="categoria_empresa_edit"]').val(data[0].categoria_contribuyente);
                    $('[name="nombre_completo_edit"]').val(data[0].nombre_completo);

                    $('#Modal_Edit').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;

        });

         //metodo para modificar los descuentos
        $('#btn_update').on('click',function(){
            var code = $('#empresa_code_edit').val();
            var empresas_nombre = $('#empresas_nombre').val();
            var empresa_nombre_edit = $('#empresa_nombre_edit').val();
            var codigo_empresa_edit = $('#codigo_empresa_edit').val();
            var registro_empresa_edit = $('#registro_empresa_edit').val();
            var casa_empresa_edit = $('#casa_empresa_edit').val();
            var nit_empresa_edit = $('#nit_empresa_edit').val();
            var giro_empresa_edit = $('#giro_empresa_edit').val();
            var categoria_empresa_edit = $('#categoria_empresa_edit').val();
            var nombre_completo_edit = $('#nombre_completo_edit').val();

            /*var estado = 0;
            if(nombre_edit == nombre_hide){
                estado = 1;
            }*/
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/updateEmpresa')?>",
                dataType : "JSON",
                data : {code:code,empresa_nombre_edit:empresa_nombre_edit,codigo_empresa_edit:codigo_empresa_edit,registro_empresa_edit:registro_empresa_edit,casa_empresa_edit:casa_empresa_edit,nit_empresa_edit:nit_empresa_edit,giro_empresa_edit:giro_empresa_edit,categoria_empresa_edit:categoria_empresa_edit,nombre_completo_edit:nombre_completo_edit},
                success: function(data){
                    console.log(data);
                    if(data==null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';
                        document.getElementById('validacion7_edit').innerHTML = '';

                        $('[name="pais_code_edit"]').val("");
                        $('[name="pais_nombre"]').val("");
                        $('[name="pais_continente"]').val("América");
                        $('[name="pais_region"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';
                        document.getElementById('validacion7_edit').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre Abreviado de la Empresa";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar el Codigo de la Empresa";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion5_edit').innerHTML += "Debe de Ingresar el NIT de la Empresa";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion6_edit').innerHTML += "Debe de Ingresar el Giro de la Empresa";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion7_edit').innerHTML += "Debe de Ingresar el Nombre Abreviado de la Empresa";
                            }
                        }//Fin For
                    }
                            
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
             
        });//Fin metodo modificar

        //get data for ver record
         $('.item_ver').click(function(){
            var code   = $(this).data('id_empresa');
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/llenarEmpresa')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    console.log(data);
                    $('[name="empresa_nombre_ver"]').val(data[0].nombre_empresa);
                    $('[name="codigo_empresa_ver"]').val(data[0].codigo);
                    $('[name="registro_empresa_ver"]').val(data[0].registro_civil);
                    $('[name="casa_empresa_ver"]').val(data[0].casa_matriz);
                    $('[name="nit_empresa_ver"]').val(data[0].nit);
                    $('[name="giro_empresa_ver"]').val(data[0].giro);
                    $('[name="categoria_empresa_ver"]').val(data[0].categoria_contribuyente);

                    $('#Modal_ver').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;

        });

        //se obtiene el id para poder eliminar
        $('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            $('#Modal_Delete').modal('show');
            $('[name="empresa_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#empresa_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/deleteEmpresa')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="empresa_code_delete"]').val("");
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
        });//Fin metodo eliminar

    });
</script>
</body>

</html> 