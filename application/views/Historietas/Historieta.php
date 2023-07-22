<!--

Carga primero header.php
Carga primero menus.php
Luego comienza a mostrar el contenido de la pagina

<div class="container-fluid">
    <div class="row content">
        <div class="col-sm-3 sidenav hidden-xs">
        </div>
--> <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

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
                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nivel de la historieta</label>
                    <div class="col-md-10">
                    <select class="form-control" id = "nivel_historieta">
                    <option >Selecciona una opcion</option>
                    <option value="1">Basico</option>
                    <option value="2">Intermedio</option>
                    <option value="3">Avanzado</option>
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

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nivel de la historieta</label>
                <div class="col-md-10">
                <select class="form-control" id = "nivel_historieta_edit">

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

 <!-- MODAL AGREGAR -->
 <form>
    <div class="modal fade" id="Modal_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <center><h2 class="modal-title" id="exampleModalLabel">Agregar capitulo</h2>
</center>
            <table class="table table-striped" id="historial_ponderacion">
                <thead>
                    <tr>
                        <th class="text-center">Capitulo</th>
                        <th class="text-center">Ponderacion</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="historietas_data">
                   
                </tbody>
                <tfoot id="acumulado">
                    <tr>
                    <td colspan="3" class="text-center">Total</td>
                    </tr>
                </tfoot>
            </table>


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
                    <input type="hidden" name="historieta_agregar" id="historieta_agregar" class="form-control" placeholder="Product Code" readonly >
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre del capitulo</label>
                <div class="col-md-10">
                    <input type="text" name="capitulo_nombre" id="capitulo_nombre" class="form-control" placeholder="Capitulo ###">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Ponderacion</label>
                <div class="col-md-10">
                    <input type="number" name="ponderacion" id="ponderacion" class="form-control" placeholder="0.00">
                </div>
            </div>
            <input type="hidden" name="acumulado_val" id="acumulado_val">
            

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" class="btn btn-primary" onclick="agregarChap()">Agregar</button>
            </div>
        </div>
        </div>
    </div>
</form>
        <!--END MODAL AGREGAR-->

  <!--MODAL EDITAR CAPITULO-->
 


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

        <!-- EDITAR MODAL -->
        <form>
        <div class="modal fade" id="Modal_editar_cap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar capitulo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">

                <div class="form-group row">
                <label class="col-md-2 col-form-label">Nombre del capitulo</label>
                <div class="col-md-10">
                    <input type="text" name="capitulo_nombre_editar" id="capitulo_nombre_editar" class="form-control" placeholder="Capitulo ###">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Ponderacion</label>
                <div class="col-md-10">
                    <input type="number" name="ponderacion_editar" id="ponderacion_editar" class="form-control" placeholder="0.00">
                    <input type="hidden" name="ponderacion_original" id="ponderacion_original">
                </div>
            </div>

                </div>
                <div class="modal-footer">
                <input type="hidden" name="capitulo_code_editar" id="capitulo_code_editar" class="form-control">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_editar" class="btn btn-primary" onclick="sendEditar()">Editar</button>
                </div>
            </div>
            </div>
        </div>
        </form>
    <!--END MODAL EDITAR CAPITULO-->
<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">


        function agregar_capitulo(e){
            historieta = e.dataset.codigo
            $("#historieta_agregar").val(historieta)
            console.log(historieta)
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Historietas/capitulos_data')?>',
                dataType : 'JSON',
                data : {historieta:historieta},
                success : function(data){
                    console.log(data)
                    var html = '';
                    var i;
                    $('#historial_ponderacion').DataTable().destroy()
                    var acumulado = 0
                    for(i=0; i<data.length; i++){
                        acumulado += parseFloat(data[i].ponderacion)
                        html += '<tr>'+
                                '<td>'+data[i].capitulo+'</td>'+
                                '<td>'+data[i].ponderacion+'</td>'+
                                '<td><a  data-target="#Modal_editar_cap"  data-toggle="modal" class="btn btn-warning" onclick="handleEditar(' + "'" + data[i].id_capitulos + "'" + ',' + "'" + data[i].capitulo + "'" + ',' + data[i].ponderacion + ')">Editar</a> <a class="btn  btn-danger" onclick ="eliminarCapitulo('+data[i].id_capitulos+')">Eliminar</a></td>'+
                                '</tr>';
                    }
                    $("#acumulado").html('<tr><td colspan="3" class="text-center">Total: '+acumulado+'</td></tr>')
                    $("#acumulado_val").val(acumulado)
                    $('#historietas_data').html(html);
                        $('#historial_ponderacion').dataTable( {
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
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        };

        function handleEditar(id_capitulo, capitulo, ponderacion){
            $("#capitulo_nombre_editar").val(capitulo)
            $("#ponderacion_editar").val(ponderacion)
            $("#ponderacion_original").val(ponderacion)
            $("#capitulo_code_editar").val(id_capitulo)
        }
        function sendEditar(){
            capitulo = $("#capitulo_nombre_editar").val()
            ponderacion = $("#ponderacion_editar").val()
            ponderacion_original = $("#ponderacion_original").val()
            codigo_capitulo = $("#capitulo_code_editar").val()
            let acumulado = $("#acumulado_val").val()
            let suma = (parseFloat(acumulado)-parseFloat(ponderacion_original)+parseFloat(ponderacion))
            console.log(suma)
            if(suma > 1){
                Swal.fire(
                'Ponderacion es mayor al 100%',
                '',
                'error'
                )
            }else{
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Historietas/editar_capitulos')?>',
                dataType : 'JSON',
                data : {capitulo:capitulo, ponderacion:ponderacion, id_capitulo:codigo_capitulo},
                success : function(data){
                    if(data === null){
                Swal.fire({
                    title: 'Capitulo editado',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
                                    
                    }else{
                        Swal.fire(
                            'Ocurrio un error',
                            '',
                            'error'
                            )
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
        }
        function eliminarCapitulo(id_capitulo){
            Swal.fire({
                title: '¿Seguro que desea eliminar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'No, cancelar',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type  : 'POST',
                        url   : '<?php echo site_url('Historietas/eliminar_capitulos')?>',
                        dataType : 'JSON',
                        data : {id_capitulo:id_capitulo},
                        success : function(data){
                            if(data === null){
                        Swal.fire({
                            title: 'Capitulo eliminado',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                                            
                            }else{
                                Swal.fire(
                                    'Ocurrio un error',
                                    '',
                                    'error'
                                    )
                            }
                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                        }
                    });
                }
            });
        }

        function agregarChap(){
            let historieta = $("#historieta_agregar").val()
            let capitulo = $("#capitulo_nombre").val()
            let ponderacion = $("#ponderacion").val()
            let acumulado = $("#acumulado_val").val()
            let suma = (parseFloat(acumulado)+parseFloat(ponderacion))
            if(suma > 1){
                Swal.fire(
                'Ponderacion es mayor al 100%',
                '',
                'error'
                )
            }else{      
            if(ponderacion == 0 || ponderacion == ''){
            Swal.fire(
                'Ponderacion esta vacio o es 0',
                '',
                'error'
                )
           }else if(capitulo == ''){
            Swal.fire(
                'Capitulo esta vacio',
                '',
                'error'
                )
           }else{
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Historietas/guardar_capitulos')?>',
                dataType : 'JSON',
                data : {historieta:historieta, capitulo: capitulo, ponderacion:ponderacion},
                success : function(data){
                    if(data === null){
                Swal.fire({
                    title: 'Capitulo agregado',
                    icon: 'success'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload();
                    }
                });
                                    
                    }else{
                        Swal.fire(
                            'Ocurrio un error',
                            '',
                            'error'
                            )
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
           }
            }
        }

        function handleedit(e){
            console.log(e)
            var nivel = e.dataset.nivel
            console.log(nivel)
            var options = ''
            if(nivel === "null"){
            
                options = '<option selected>Selecciona el nivel</option> <option value="1">Basico</option> <option value="2">Intermedio</option> <option value="3">Avanzado</option>'
            }else if (nivel == 1){
                options = '<option >Selecciona el nivel</option> <option value="1" selected>Basico</option> <option value="2">Intermedio</option> <option value="3">Avanzado</option>'
            }else if(nivel == 2){
                options = '<option selected>Selecciona el nivel</option> <option value="1">Basico</option> <option value="2" selected>Intermedio</option> <option value="3">Avanzado</option>'
            }else if(nivel == 3){
                options = '<option selected>Selecciona el nivel</option> <option value="1">Basico</option> <option value="2">Intermedio</option> <option value="3" selected>Avanzado</option>'
            }
            $("#nivel_historieta_edit").empty()
           $("#nivel_historieta_edit").append(options)

        }


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
                    console.log(data)
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html += '<tr>'+
                                '<td>'+data[i].historieta+'</td>'+
                                '<td style="text-align:right;">'+

                                    '<a onclick="agregar_capitulo(this)" href="javascript:void(0);" data-toggle="modal" data-target="#Modal_agregar" class="btn btn-warning btn-sm item_edit" data-codigo="'+data[i].id_historieta+'" data-nombre="'+data[i].historieta+'">Agregar capitulo</a>'+' '+

                                    '<a href="javascript:void(0);" data-toggle="modal" data-target="#Modal_Edit" class="btn btn-info btn-sm item_edit" data-codigo="'+data[i].id_historieta+'" data-nombre="'+data[i].historieta+'" data-nivel="'+data[i].nivel+'" onclick="handleedit(this)">Edit</a>'+' '+
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
            var nivel = $("#nivel_historieta").val();
            
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Historietas/save')?>",
                dataType : "JSON",
                data : { name:name, nivel: nivel},
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
            var nivel = $("#nivel_historieta_edit").val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Historietas/update')?>",
                dataType : "JSON",
                data : {code:code,name:name, nivel: nivel},
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