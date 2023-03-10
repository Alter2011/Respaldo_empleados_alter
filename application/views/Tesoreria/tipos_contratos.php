    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <div class="col-sm-10">
                <div class="text-center well text-white blue">
                    <h2>Tipos Contratos</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="well">
                            <nav class="float-right"><?php ?><a onclick="limpiar()" href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo Contrato</a><?php ?><br><br></nav>
                            <table class="table table-striped" id="mydata" name="mydata">
                                <thead>
                                    <tr>
                                        <th style="text-align:left;">Contrata</th>
                                        <th style="text-align:left;">Proveedor</th>      
                                        <th style="text-align:left;">Fecha inicio relación</th>
                                        <th style="text-align:left;">Fecha fin relación</th>
                                        <th style="text-align:left;">Monto</th>
                                        <th style="text-align:left;">Descripcion</th>
                                        <th style="text-align:left;">Estado</th>


                                        <th style="text-align:left;">Acciones</th>

                                    </tr>
                                </thead>
                                <tbody id="show_data">
                                    <?php

                                   foreach ($tipos as $tipo) {
                                    if($tipo->estado == 0){
                                        $estado = "Inactivo";
                                    }else{
                                        $estado = "Activo";
                                    }
                                       echo "<tr>";
                                       echo '<td style="text-align: left;">'.$tipo->nombre_empresa."</td>";
                                       echo '<td style="text-align: left;">'.$tipo->nombre_proveedor."</td>";
                                       echo '<td style="text-align: left;">'.date("d-m-Y", strtotime($tipo->Fecha_inicio))."</td>";
                                       echo '<td style="text-align: left;">'.date("d-m-Y", strtotime($tipo->Fecha_fin))."</td>";
                                       echo '<td style="text-align: left;">'. '$' .round($tipo->Monto,2)."</td>";
                                       echo '<td style="text-align: left;">'.$tipo->Descripcion."</td>";
                                       echo '<td style="text-align: left;">'.$estado."</td>";


                                       echo '<td style="text-align: left;"><a data-toggle="modal" onClick="editar(this)" class="btn btn-info btn-sm item_edit" id="'.$tipo->Id_contrato.'">Editar</a> <a data-toggle="modal" onClick="eliminar(this)" class="btn btn-danger btn-sm item_delete" id="'.$tipo->Id_contrato.'">Eliminar</a></td>';

        
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

    <!-- MODAL ADD -->
    <form>
        <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Contrato</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <input type="hidden" name="codigo" id="codigo" class="form-control" placeholder="Product Code" readonly>
                
                <div id="validacion1" style="color:red"></div>
                <div id="validacion2" style="color:red"></div>
                <div id="validacion3" style="color:red"></div>
                <div id="validacion4" style="color:red"></div>
                <div id="validacion5" style="color:red"></div>
                <div id="validacion6" style="color:red"></div>
                <div id="validacion7" style="color:red"></div>


                <div class="modal-body">

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Contrata:</label>
                        <div class="col-md-7">
                            <select class="form-control" id="empresa" name="empresa" >                                       
                            <?php
                            foreach($ver_empresas as $fila){
                                echo "<option value=".$fila->id_empresa.">".$fila->nombre_empresa."</option>";
                            }  
                            ?>
                            </select>
                            </div>
                    </div>

                      <div class="form-group row">
                    <label class="col-md-3 col-form-label">Proveedor:</label>
                      <div class="col-md-7">
                        <select class="form-control" name="proveedor" id="proveedor" class="form-control">
                            <?php
                            foreach($ver_proveedores as $fila){
                                echo "<option value=".$fila->id_proveedor.">".$fila->nombre_proveedor."</option>";
                            }  
                            ?>
                        </select>
                    </div>
                </div>
               
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fecha inicio Relacion:</label>
                        <div class="col-md-7">
                            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" placeholder="Ingresar fecha inicio de contrato">
                        </div>
                    </div>

                     <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fecha fin relacion:</label>
                         <div class="col-md-7">
                            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" placeholder="Ingresar fecha fin de contrato">   
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Monto:</label>
                        <div class="col-md-7">
                        <input type="text" name="monto" id="monto" class="form-control" placeholder="0.00">
                    </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Descripcion:</label>
                        <div class="col-md-7">
                            <textarea class="md-textarea form-control" id="descripcion" name="descripcion"></textarea>
                        </div>
                    </div>
                </div>

            

                <div class="modal-footer">
                <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
          
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            </div>
        </div>
     
    </form>
    <!--END MODAL ADD-->


     <!-- MODAL EDIT -->
    <form>
        <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">Editar Contrato</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                <div id="validacion1_edit" style="color:red"></div>
                <div id="validacion2_edit" style="color:red"></div>
                <div id="validacion3_edit" style="color:red"></div>
                <div id="validacion4_edit" style="color:red"></div>
                <div id="validacion5_edit" style="color:red"></div>
                <div id="validacion6_edit" style="color:red"></div>
                <div id="validacion7_edit" style="color:red"></div>
                <div class="modal-body">
                <div class="form-group row">
                    <div class="col-md-6">
                        <input type="hidden" name="tipo_code_edit" id="tipo_code_edit" class="form-control" placeholder="Product Code" readonly>
                    </div>
                </div>

                 <div class="form-group row">
                        <label class="col-md-3 col-form-label">Contrata:</label>
                        <div class="col-md-7">
                             <select class="form-control" id="empresa_edit" name="empresa_edit" >                                       
                            <?php
                            foreach($ver_empresas as $fila){
                                echo "<option value=".$fila->id_empresa.">".$fila->nombre_empresa."</option>";
                            }  
                            ?>
                            </select>
                        </div>
                    </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Proveedor:</label>
                    <div class="col-md-7">
                        <select class="form-control" name="proveedor_edit" id="proveedor_edit" class="form-control">
                              <?php
                            foreach($ver_proveedores as $fila){
                                echo "<option value=".$fila->id_proveedor.">".$fila->nombre_proveedor."</option>";
                            }  
                            ?>
                        </select>
                    </div>
                </div>

                 <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fecha inicio relacion:</label>
                        <div class="col-md-7">
                            <input type="date" name="fecha_ini_edit" id="fecha_ini_edit" class="form-control" placeholder="Ingresar nueva fecha de inicio de contrato">
                        </div>
                    </div>

                    <div id="mensaje" style="color:red"></div>

                     <div class="form-group row">
                        <label class="col-md-3 col-form-label">Fecha fin relacion:</label>
                         <div class="col-md-7">
                            <input type="date" name="fecha_fin_edit" id="fecha_fin_edit" class="form-control" placeholder="Ingresar nueva fecha de fin de contrato">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Monto:</label>
                        <div class="col-md-7">
                        <input type="text" name="monto_edit" id="monto_edit" class="form-control" placeholder="Ingresar nuevo monto de contrato">
                    </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Descripcion:</label>
                        <div class="col-md-7">
                            <textarea class="md-textarea form-control" id="edit_descrip" name="edit_descrip" placeholder="Ingresar nueva descripcion"></textarea>
                        </div>
                    </div>

                <div class="modal-footer">
                <button type="button" type="submit" id="btn_update" class="btn btn-primary">Modificar</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Contrato</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <strong>¿Seguro que desea eliminar?</strong>
                    </div>
                    <div class="modal-footer">
                    <input type="hidden" name="tipo_code_delete" id="tipo_code_delete" class="form-control" readonly>
                    <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Si</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    </div>
                </div>
                </div>
            </div>
            </form>
            <!--END MODAL DELETE-->


    <script type="text/javascript">
          $(document).ready(function(){

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

            //Metodo para el ingreso 
            $('#btn_save').on('click',function(){

                var empresa = $('#empresa').val();
                var proveedor = $('#proveedor').val();
                var fecha_inicio = $('#fecha_inicio').val();
                var fecha_fin = $('#fecha_fin').val();
                var monto = $('#monto').val();
                var descripcion = $('#descripcion').val();
                var fecha_ingreso = $('#fecha_ingreso').val();

                
                    $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Tesoreria/save_contratos')?>",
                    dataType : "JSON",
                    data : {empresa:empresa,proveedor:proveedor,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,monto:monto,descripcion:descripcion,fecha_ingreso,fecha_ingreso},
                    success: function(data){


                        if(data == null){

                        document.getElementById('validacion1').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';
                        document.getElementById('validacion7').innerHTML = '';



                            $('[name="empresa"]').val("");
                            $('[name="proveedor"]').val("");

                            $('#Modal_Add').modal('toggle');
                        
                            Swal.fire('Se ha agregado el registro con exito','','success')
                            .then(() => {
                                // Aquí la alerta se ha cerrado
                                location.reload();

                            });
                   
                        }else{
                        document.getElementById('validacion1').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion5').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';
                        document.getElementById('validacion7').innerHTML = '';



                            for (i = 0; i <= data.length-1; i++){
                                
                                if(data[i] == 1){
                                    document.getElementById('validacion1').innerHTML += "Debe de seleccionar la fecha de inicio";
                                }

                                if(data[i] == 2){
                                    document.getElementById('validacion2').innerHTML += "Debe de seleccionar la fecha de fin";
                                }

                                if(data[i] == 3){
                                    document.getElementById('validacion3').innerHTML += "Debe de ingresar el monto";
                                }

                                if(data[i] == 4){
                                    document.getElementById('validacion4').innerHTML += "Debe de ingresar unicamente numeros";
                                }

                                if(data[i] == 5){
                                    document.getElementById('validacion5').innerHTML += "Debe de ingresar un monto positivo";
                                }
                                if(data[i] == 6){
                                    document.getElementById('validacion6').innerHTML += "Debe de ingresar una descripcion";
                                }
                                if(data[i] == 7){
                                    document.getElementById('validacion7').innerHTML += "Debe de ingresar una descripcion menor a 300 caracteres";
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


      
            //metodo para modificar 
            $('#btn_update').on('click',function(){

                var code = $('#tipo_code_edit').val();


                var empresa = $('#empresa_edit').val();
                var proveedor = $('#proveedor_edit').val();
                var fecha_inicio = $('#fecha_ini_edit').val();
                var fecha_fin = $('#fecha_fin_edit').val();
                var monto = $('#monto_edit').val();
                var descripcion = $('#edit_descrip').val();

                 $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Tesoreria/update_contratos')?>",
                    dataType : "JSON",
                    data : {code:code,empresa:empresa,proveedor:proveedor,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,monto:monto,descripcion:descripcion},
                    success: function(data){
                        

                        if(data == null){
                        document.getElementById('validacion1_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';
                        document.getElementById('validacion7_edit').innerHTML = '';

                        $('[name="fecha_ini_edit"]').val("");
                        $('[name="fecha_fin_edit"]').val("");
                        $('[name="monto_edit"]').val("");
                        $('[name="edit_descrip"]').val("");

                        $('.modal-backdrop').remove();
                        $('#Modal_Edit').modal('toggle');
                        

                            Swal.fire('Se ha modificado el registro con exito','','success')
                            .then(() => {
                                // Aquí se recarga la pagina
                                location.reload();

                            });

               
                        }else{
                        document.getElementById('validacion1_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';
                        document.getElementById('validacion7_edit').innerHTML = '';
        

                           for (i = 0; i <= data.length-1; i++){
                                
                                if(data[i] == 1){
                                document.getElementById('validacion1_edit').innerHTML += "Debe de seleccionar la fecha de inicio";
                                }

                                if(data[i] == 2){
                                    document.getElementById('validacion2_edit').innerHTML += "Debe de seleccionar la fecha de fin";
                                }

                                if(data[i] == 3){
                                    document.getElementById('validacion3_edit').innerHTML += "Debe de ingresar el monto";
                                }

                                if(data[i] == 4){
                                    document.getElementById('validacion4_edit').innerHTML += "Debe de ingresar unicamente numeros";
                                }

                                if(data[i] == 5){
                                    document.getElementById('validacion5_edit').innerHTML += "Debe de ingresar un monto positivo";
                                }
                                if(data[i] == 6){
                                    document.getElementById('validacion6_edit').innerHTML += "Debe de ingresar una descripcion";
                                }
                                if(data[i] == 7){
                                    document.getElementById('validacion7_edit').innerHTML += "Debe de ingresar una descripcion menor a 300 caracteres";
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


            //Metodo para eliminar 
             $('#btn_delete').on('click',function(){

                var code = $('#tipo_code_delete').val();

                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Tesoreria/deleteContrato')?>",
                    dataType : "JSON",
                    data : {code:code},
        
                    success: function(data){
                        $('[name="tipo_code_delete"]').val("");
                        $('#Modal_Delete').modal('toggle');
                        $('.modal-backdrop').remove();

                          Swal.fire('Se ha eliminado el registro','','success')
                            .then(() => {
                                // Aquí se recarga la pagina
                                location.reload();

                            });


                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;
            });//Fin metodo eliminar

    });

    function eliminar(codigo){
                        
               var code = codigo.id;
        
                $('#Modal_Delete').modal('show');
                $('[name="tipo_code_delete"]').val(code);
    }

    function editar(codigo){
                        
               var code = codigo.id;

              $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Tesoreria/llenarEdit')?>",
                    dataType : "JSON",
                    data : {code:code},
                    success: function(data){

                        $('[name="tipo_code_edit"]').val(data[0].Id_contrato);
                        $('[name="empresa_edit"]').val(data[0].Empresa);
                        $('[name="proveedor_edit"]').val(data[0].Tipo_proveedor);
                        $('[name="fecha_ini_edit"]').val(data[0].Fecha_inicio);
                        $('[name="fecha_fin_edit"]').val(data[0].Fecha_fin);
                        $('[name="monto_edit"]').val(Math.round(data[0].Monto * 100) / 100);
                        $('[name="edit_descrip"]').val(data[0].Descripcion);


                        document.getElementById('validacion1_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';
                        document.getElementById('validacion3_edit').innerHTML = '';
                        document.getElementById('validacion4_edit').innerHTML = '';
                        document.getElementById('validacion5_edit').innerHTML = '';
                        document.getElementById('validacion6_edit').innerHTML = '';
                        document.getElementById('validacion7_edit').innerHTML = '';
                        
                        $('#Modal_Edit').modal('show');

                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                        this.disabled=false;
                    }
                });

             }

             //funcion para limpiar los errores
             function limpiar(){
                document.getElementById('validacion1').innerHTML = '';
                document.getElementById('validacion2').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';
                document.getElementById('validacion4').innerHTML = '';
                document.getElementById('validacion5').innerHTML = '';
                document.getElementById('validacion6').innerHTML = '';
                document.getElementById('validacion7').innerHTML = '';

                $('[name="fecha_inicio"]').val("");
                $('[name="fecha_fin"]').val("");
                $('[name="monto"]').val("");
                $('[name="descripcion"]').val("");
             }

    </script>
     