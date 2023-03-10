<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Codigo de Observacion</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><hr></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Codigo</th>      
                                    <th style="text-align:center;">Nombre</th>
                                    <th style="text-align:center;">Fecha de Creacion</th>
                                    <th style="text-align:center;">Accion</th>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Codigo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Codigo:</label>
                    <div class="col-md-10">
                        <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese Nuevo Codigo">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Observacion:</label>
                    <div class="col-md-10">
                        <input type="text" name="observacion" id="observacion" class="form-control" placeholder="Observacion">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

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
            <h3 class="modal-title" id="exampleModalLabel">Editar Codigo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">

                <div class="col-md-10">
                    <input type="hidden" name="code_edit" id="code_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Codigo:</label>
                <div class="col-md-10">
                    <input type="text" name="codigo_edit" id="codigo_edit" class="form-control" placeholder="Ingrese Nuevo Codigo" readonly>
                     <div id="validacion_Edit" style="color:red"></div>
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Observacion:</label>
                <div class="col-md-10">
                    <input type="text" name="observacion_edit" id="observacion_edit" class="form-control" placeholder="Observacion">
                     <div id="validacion2_Edit" style="color:red"></div>
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
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Codigo de Observacion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_delete" id="code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                </div>
            </div>
            </div>
        </div>
        </form>
        <!--END MODAL DELETE-->


<!-- Llamar JavaScript -->
<!--<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?> ">--></script>
<script type="text/javascript">
    $(document).ready(function(){
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
       
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Observacion/codigo_data')?>',
                async : false,
                dataType : 'JSON',

                success : function(data){
                   $.each(data,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.codigo+'</td>'+//Agencia
                                '<td>'+registro.observacion+'</td>'+//nombrePlaza
                                '<td>'+registro.fecha+'</td>'+//estado
                                '<td style="text-align:right;">'+
                                    '<a href="#" data-toggle="modal" class="btn btn-info btn-sm item_edit" data-codigo="'+registro.id_observacion+'">Editar</a>'+' '+'<a href="#" class="btn btn-danger btn-sm item_delete" data-codigo="'+registro.id_observacion+'">Eliminar</a>'+                                    
                                '</td>'+
                                '</tr>'
                        );
                   });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
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

    };

    //Metooo para e ingreso de los descuentos
        $('#btn_save').on('click',function(){
            var codigo = $('#codigo').val();
            var observacion = $('#observacion').val();
            
                    $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('observacion/saveObservacion')?>",
                        dataType : "JSON",
                        data : {codigo:codigo,observacion:observacion},
                        success: function(data){
                            console.log(data);
                        if (data==null) {
                            document.getElementById('validacion').innerHTML = '';
                            document.getElementById('validacion2').innerHTML = '';
                            //alert('La insercion se hizo correctamente');
                            $('[name="codigo"]').val("");
                            $('[name="observacion"]').val("");

                            location.reload();
                            this.disabled=false;
                            show_area();
                        }else{
                            document.getElementById('validacion').innerHTML = '';
                            document.getElementById('validacion2').innerHTML = '';

                             for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion').innerHTML += "Debe de Ingresar el Codigo de Observacion";
                                }else if(data[i] == 3){
                                    document.getElementById('validacion').innerHTML += "Este Codigo de Observacion ya Existe";
                                }

                                if(data[i] == 2){
                                    document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Observacion";
                                }
                                
                            }//Fin For
                        }//fin if else
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                        }
                    });
                    return false;
               
        });//fin de insercionde 

        //Inicion para llnado de modal
        $('.item_edit').click(function(){
            document.getElementById('validacion_Edit').innerHTML = '';
            document.getElementById('validacion2_Edit').innerHTML = '';
            var code = $(this).data('codigo');
            //alert(code);
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('observacion/llenarEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="code_edit"]').val(data[0].id_observacion);
                    $('[name="codigo_edit"]').val(data[0].codigo);
                    $('[name="observacion_edit"]').val(data[0].observacion);
                    

                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
        });//fin llanado de modal


        //metodo para modificar los descuentos
        $('#btn_update').on('click',function(){
            var code = $('#code_edit').val();
            var observacion = $('#observacion_edit').val();
            var codigo = $('#codigo_edit').val();
            
                        $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('observacion/updateObservacion')?>",
                        dataType : "JSON",
                        data : {code:code,codigo:codigo,observacion:observacion},
                        success: function(data){

                            if(data==null){
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';

                                $('[name="code_edit"]').val("");
                                $('[name="codigo_edit"]').val("");
                                $('[name="observacion_edit"]').val("");

                                $('#Modal_Edit').modal('toggle');
                                $('.modal-backdrop').remove();
                                location.reload();

                                show_data();
                            }else{
                                document.getElementById('validacion_Edit').innerHTML = '';
                                document.getElementById('validacion2_Edit').innerHTML = '';

                                for (i = 0; i <= data.length-1; i++){
                                if(data[i] == 1){
                                    document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar el Codigo de Observacion";
                                }

                                if(data[i] == 2){
                                    document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar el Porcentaje";
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

          //se obtiene el id para poder eliminar
        $('.item_delete').click(function(){
            var code   = $(this).data('codigo');
                $('#Modal_Delete').modal('show');
                $('[name="code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('observacion/deleteObservacion')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="code_delete"]').val("");
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