<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Renta</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Tramo</th>      
                                    <th style="text-align:center;">Desde</th>
                                    <th style="text-align:center;">Hasta</th>
                                    <th style="text-align:center;">Porcentaje</th>
                                    <th style="text-align:center;">Sobre  el exceso</th>
                                    <th style="text-align:center;">Cuota Fija</th>
                                    <th style="text-align:center;">Pagadas a</th>
                                    <th style="text-align: center;">Acciones</th>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Tramo de Renta</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tramo:</label>
                    <div class="col-md-10">
                        <input type="text" name="tramo_name" id="tramo_name" class="form-control" placeholder="Ingrese el nuevo tramo">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>
            

           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Desde:</label>
                    <div class="col-md-10">
                        <input type="text" name="desde_name" id="desde_name" class="form-control" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                </div>
            </div>
            
            
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta:</label>
                    <div class="col-md-10">
                        <input type="text" name="hasta_name" id="hasta_name" class="form-control" placeholder="0.00">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>
           

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Porcentaje:</label>
                    <div class="col-md-10">
                        <input type="text" name="porcentaje_name" id="porcentaje_name" class="form-control" placeholder="0.00">
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>
           
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Sobre  el exceso:</label>
                    <div class="col-md-10">
                        <input type="text" name="sobre_name" id="sobre_name" class="form-control" placeholder="0.00">
                        <div id="validacion5" style="color:red"></div>
                    </div>
                </div>
           

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuota Fija:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuota_name" id="cuota_name" class="form-control" placeholder="0.00">
                        <div id="validacion6" style="color:red"></div>
                    </div>
                </div>
            
            
             
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pagadas a:</label>
                    <div class="col-md-10">
                         <select name="pagadas_name" id="pagadas_name" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($tiempo as $a){
                        
                        ?>
                            <option id="<?= ($a->id_tiempo);?>"><?php echo($a->nombre);?></option>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Tramo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="renta_code_edit" id="renta_code_edit" class="form-control" placeholder="Product Code" readonly>
                    <input type="hidden" name="nombre_edit" id="nombre_edit" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-md-2 col-form-label">Tramo:</label>
                <div class="col-md-10">
                    <input type="text" name="tramo_edit" id="tramo_edit" class="form-control" placeholder="Ingresa cambio de descuentos">
                    <div id="validacion_edit" style="color:red"></div>
                </div>
            </div>


             <div class="form-group row">
                <label class="col-md-2 col-form-label">Desde:</label>
                <div class="col-md-10">
                    <input type="text" name="desde_edit" id="desde_edit" class="form-control" placeholder="0.00">
                    <div id="validacion2_edit" style="color:red"></div>
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Hasta:</label>
                <div class="col-md-10">
                    <input type="text" name="hasta_edit" id="hasta_edit" class="form-control" placeholder="0.00">
                    <div id="validacion3_edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Porcentaje:</label>
                <div class="col-md-10">
                    <input type="text" name="porcentaje_edit" id="porcentaje_edit" class="form-control" placeholder="0.00">
                    <div id="validacion4_edit" style="color:red"></div>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Sobre:</label>
                <div class="col-md-10">
                    <input type="text" name="sobre_edit" id="sobre_edit" class="form-control" placeholder="0.00">
                    <div id="validacion5_edit" style="color:red"></div>
                </div>
            </div>

             <div class="form-group row">
                <label class="col-md-2 col-form-label">Cuota:</label>
                <div class="col-md-10">
                    <input type="text" name="cuota_edit" id="cuota_edit" class="form-control" placeholder="0.00">
                    <div id="validacion6_edit" style="color:red"></div>
                </div>
            </div>

            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Pagadas a:</label>
                    <div class="col-md-10">
                         <select name="pagadas_edit" id="pagadas_edit" class="form-control" placeholder="Price">
                        <?php
                        $i=0;
                        foreach($tiempo as $a){
                        
                        ?>
                            <option id="<?= ($tiempo[$i]->id_tiempo);?>" value="<?= ($tiempo[$i]->id_tiempo);?>"><?php echo($tiempo[$i]->nombre);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                        </select>
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

<!--MODAL DELETE-->
<form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Renta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="renta_code_delete" id="renta_code_delete" class="form-control" readonly>
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

        show_data();
    function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('renta/listaRenta')?>',
                async : false,
                dataType : 'JSON',
                data : {},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.tramo+'</td>'+//Agencia
                                '<td>'+registro.desde+'</td>'+//Agencia
                                '<td>'+registro.hasta+'</td>'+//Agencia
                                '<td>'+registro.porcentaje+'</td>'+//Agencia
                                '<td>'+registro.sobre+'</td>'+//Agencia
                                '<td>'+registro.cuota+'</td>'+//Agencia
                                '<td>'+registro.nombre+'</td>'+//Agencia
                                '<td style="text-align:right;">'+
                                    '<a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'+registro.id_renta+'">Editar</a>'+' '+'<a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'+registro.id_renta+'">Eliminar</a>'+                                    
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
        //Metooo para e ingreso 
        $('#btn_save').on('click',function(){
            var tramo_name = $('#tramo_name').val();
            var desde_name = $('#desde_name').val();
            var hasta_name = $('#hasta_name').val();
            var porcentaje_name = $('#porcentaje_name').val();
            var sobre_name = $('#sobre_name').val();
            var cuota_name = $('#cuota_name').val();
            var pagadas_name = $('#pagadas_name').children(":selected").attr("id");

            
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/saveRenta')?>",
                dataType : "JSON",
                data : {tramo_name:tramo_name,desde_name:desde_name,hasta_name:hasta_name,porcentaje_name:porcentaje_name,sobre_name:sobre_name,cuota_name:cuota_name,pagadas_name:pagadas_name},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        $('[name="tramo_name"]').val("");
                        $('[name="desde_name"]').val("");
                        $('[name="hasta_name"]').val("");
                        $('[name="porcentaje_name"]').val("");
                        $('[name="sobre_name"]').val("");
                        $('[name="cuota_name"]').val("");
                        $('[name="pagadas_name"]').val("");

                        show_data();
                        this.disabled=false;
                    }else{

                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Tramo";
                            }else if(data[i] == 13){
                                document.getElementById('validacion').innerHTML += "El Nombre del Tramo ya existe";
                            }

                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar Desde donde Aplica la Renta";
                            }else if(data[i] == 7){
                                document.getElementById('validacion2').innerHTML += "Ingrese Desde donde Aplica la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 3){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar Hasta donde Aplica la Renta";
                            }else if(data[i] == 8){
                                document.getElementById('validacion3').innerHTML += "Ingrese Hasta donde Aplica la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 4){
                                document.getElementById('validacion4').innerHTML += "Debe de Ingresar el Porcentaje de la Renta";
                            }else if(data[i] == 9){
                                document.getElementById('validacion4').innerHTML += "Ingrese el Porcentaje de la Renta en forma correcta (0.00)";
                            }else if(data[i] == 12){
                                document.getElementById('validacion4').innerHTML += "Solo se permiten porcentaje del 0% al 100%";
                            }

                            if(data[i] == 5){
                                document.getElementById('validacion5').innerHTML += "Debe de Ingresar Sobre el Exceso de la Renta";
                            }else if(data[i] == 10){
                                document.getElementById('validacion5').innerHTML += "Ingrese Sobre el Exceso de la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 6){
                                document.getElementById('validacion6').innerHTML += "Debe de Ingresar la Cuota Fija de la Renta";
                            }else if(data[i] == 11){
                                document.getElementById('validacion6').innerHTML += "Ingrese Sla Cuota Fija de la Renta en forma correcta (0.00)";
                            }

                        }//Fin For
                    }//Fin if else
                                
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
            });
            return false;

           
                
        });//fin de insercionde 


        //Metodo para llenar los campos de modificar
        //$('.item_edit').on('click',function(){
        //fin llenado de modal editar

        //metodo para modificar 
        $('#btn_update').on('click',function(){
            var code = $('#renta_code_edit').val();
            var tramo = $('#tramo_edit').val();
            var nombre = $('#nombre_edit').val();
            var desde = $('#desde_edit').val();
            var hasta = $('#hasta_edit').val();
            var porcentaje = $('#porcentaje_edit').val();
            var sobre = $('#sobre_edit').val();
            var cuota = $('#cuota_edit').val();
            var pagadas = $('#pagadas_edit').children(":selected").attr("id");
            
            
             $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/updateRenta')?>",
                dataType : "JSON",
                data : {code:code,tramo:tramo,nombre:nombre,desde:desde,hasta:hasta,porcentaje:porcentaje,sobre:sobre,cuota:cuota,pagadas:pagadas},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';

                        $('[name="renta_code_edit"]').val("");
                        $('[name="tramo_edit"]').val("");
                        $('[name="nombre_edit"]').val("");
                        $('[name="desde_edit"]').val("");
                        $('[name="hasta_edit"]').val("");
                        $('[name="porcentaje_edit"]').val("");
                        $('[name="sobre_edit"]').val("");
                        $('[name="cuota_edit"]').val("");
                        $('[name="pagadas_edit"]').val("");

                        $('#Modal_Edit').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                        show_data();
                    }else{

                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre del Tramo";
                            }else if(data[i] == 13){
                                document.getElementById('validacion_edit').innerHTML += "El Nombre del Tramo ya existe";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar Desde donde Aplica la Renta";
                            }else if(data[i] == 7){
                                document.getElementById('validacion2_edit').innerHTML += "Ingrese Desde donde Aplica la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 3){
                                document.getElementById('validacion3_edit').innerHTML += "Debe de Ingresar Hasta donde Aplica la Renta";
                            }else if(data[i] == 8){
                                document.getElementById('validacion3_edit').innerHTML += "Ingrese Hasta donde Aplica la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 4){
                                document.getElementById('validacion4_edit').innerHTML += "Debe de Ingresar el Porcentaje de la Renta";
                            }else if(data[i] == 9){
                                document.getElementById('validacion4_edit').innerHTML += "Ingrese el Porcentaje de la Renta en forma correcta (0.00)";
                            }else if(data[i] == 12){
                                document.getElementById('validacion4_edit').innerHTML += "Solo se permiten porcentaje del 0 al 100";
                            }

                            if(data[i] == 5){
                                document.getElementById('validacion5_edit').innerHTML += "Debe de Ingresar Sobre el Exceso de la Renta";
                            }else if(data[i] == 10){
                                document.getElementById('validacion5_edit').innerHTML += "Ingrese Sobre el Exceso de la Renta en forma correcta (0.00)";
                            }

                            if(data[i] == 6){
                                document.getElementById('validacion6_edit').innerHTML += "Debe de Ingresar la Cuota Fija de la Renta";
                            }else if(data[i] == 11){
                                document.getElementById('validacion6_edit').innerHTML += "Ingrese Sla Cuota Fija de la Renta en forma correcta (0.00)";
                            }

                        }//Fin For
                    }//fin if else data == null
                    
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
                $('[name="renta_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#renta_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/deleteRenta')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="renta_code_delete"]').val("");
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

function editar(codigo){
                    
           var code = codigo.id;

          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('renta/llenarEdit')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    $('[name="renta_code_edit"]').val(data[0].id_renta);
                    $('[name="tramo_edit"]').val(data[0].tramo);
                    $('[name="nombre_edit"]').val(data[0].tramo);
                    $('[name="desde_edit"]').val(data[0].desde);
                    $('[name="hasta_edit"]').val(data[0].hasta);
                    $('[name="porcentaje_edit"]').val(data[0].porcentaje);
                    $('[name="sobre_edit"]').val(data[0].sobre);
                    $('[name="cuota_edit"]').val(data[0].cuota);
                    $('[name="pagadas_edit"]').val(data[0].id_tiempo);

                    document.getElementById('validacion_edit').innerHTML = '';
                    document.getElementById('validacion2_edit').innerHTML = '';
                    document.getElementById('validacion3_edit').innerHTML = '';
                    document.getElementById('validacion4_edit').innerHTML = '';
                    document.getElementById('validacion5_edit').innerHTML = '';
                    document.getElementById('validacion6_edit').innerHTML = '';
                    
                    $('#Modal_Edit').modal('show');

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });

         };
</script>
</body>

</html> 