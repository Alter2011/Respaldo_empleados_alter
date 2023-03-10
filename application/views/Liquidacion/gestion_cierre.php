<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Tipo de Gestion de Cierre de Año</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
            <!--<nav class="float-right"><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><br><br></nav>-->    
                <table class="table table-striped table-bordered" id="mydata">
                    <thead>
                        <tr class="success">
                            <th style="text-align:center;">Nombre gestion</th>      
                            <th style="text-align:center;">Inicio</th>
                            <th style="text-align:center;">Fin</th>
                            <th style="text-align:center;">Aplica Años</th>
                            <th style="text-align:center;">Retencion</th>
                            <th style="text-align:center;">Sal Minimo</th>
                            <th style="text-align:center;">Cant Salarios</th>
                            <th style="text-align:center;">Fecha Max</th>
                            <th style="text-align:center;">Fecha Aplicar</th>
                            <!--<th style="text-align: center">Aplicado a</th>-->
                            <th style="text-align: center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="show_data">
                      <?php 
                          foreach ($gestion as $key) {
                            if($key->aplica_anios == 1){
                                $aplica = 'Si';
                            }else{
                                $aplica = 'No';
                            }

                            if($key->aplicado == 1){
                                $aplicado = '<span class="label label-success">Aguinaldo</span>';
                            }else if($key->aplicado == 2){
                                $aplicado = '<span class="label label-primary">Liquidacion</span>';
                            }
                              echo "<tr>";
                              echo "<td>".$key->nombre_gestion."</td>";
                              echo "<td>".$key->fecha_inicio."</td>";
                              echo "<td>".$key->fecha_fin."</td>";
                              echo "<td>".$aplica."</td>";
                              echo "<td>".$key->couta_retencion."</td>";
                              echo "<td>$".number_format($key->salario_min,2)."</td>";
                              echo "<td>".$key->cant_salario."</td>";
                              echo "<td>".$key->fecha_max."</td>";
                              echo "<td>".$key->fecha_aplicacion."</td>";
                              //echo "<td>".$aplicado."</td>";
                              echo '<td style="text-align:center;"><a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_gestion="'.$key->id_gestion.'"><span class="glyphicon glyphicon-edit"></span> Editar </a>';
                              //echo ' <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-id_gestion="'.$key->id_gestion.'"> Eliminar </a>';
                              echo '</td>';
                              echo "</tr>";
                          } 
                      ?>          
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <center><h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Gestion</h3></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
           <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre:</label>
                    <div class="col-md-9">
                        <input type="text" name="nombre_gestion" id="nombre_gestion" class="form-control" placeholder="Nombre de ">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha de Inicio:</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha fin:</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Aplica para años:</label>
                    <div class="col-md-9">
                       <select class="form-control" name="aplica_anio" id="aplica_anio" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Cuota a retener:</label>
                    <div class="col-md-9">
                        <input type="number" name="cuota_retener" id="cuota_retener" class="form-control" placeholder="0">
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Aplica para:</label>
                    <div class="col-md-9">
                       <select class="form-control" name="aplica_para" id="aplica_para" class="form-control">
                            <option value="1">Aguinaldo</option>
                            <option value="2">Liquidacion</option>
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


<!-- MODAL EDIT-->
<form>
    <div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <center><h3 class="modal-title" id="exampleModalLabel">Editar Gestion</h3></center>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
           <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Nombre:</label>
                    <div class="col-md-9">
                        <input type="text" name="nombre_gestion_edit" id="nombre_gestion_edit" class="form-control" placeholder="Nombre de " readonly>
                        <div id="validacion_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha de Inicio:</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_inicio_edit" id="fecha_inicio_edit" class="form-control">
                        <div id="validacion2_Edit" style="color:red"></div>
                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha fin:</label>
                    <div class="col-md-9">
                        <input type="date" name="fecha_fin_edit" id="fecha_fin_edit" class="form-control">
                        <div id="validacion3_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Aplica para años:</label>
                    <div class="col-md-9">
                       <select class="form-control" name="aplica_anio_edit" id="aplica_anio_edit" class="form-control">
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Cuota a retener:</label>
                    <div class="col-md-9">
                        <input type="number" name="cuota_retener_edit" id="cuota_retener_edit" class="form-control" placeholder="0">
                        <div id="validacion4_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Salario Minimo:</label>
                    <div class="col-md-9">
                        <input type="text" name="salario_min_edit" id="salario_min_edit" class="form-control" placeholder="0">
                        <div id="validacion5_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Cantidad de salarios:</label>
                    <div class="col-md-9">
                        <input type="number" name="cantidad_sal_edit" id="cantidad_sal_edit" class="form-control">
                        <div id="validacion7_Edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha Maxima:</label>
                    <div class="col-md-9">
                        <input type="date" name="aplica_fecha_max" id="aplica_fecha_max" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Fecha Aplicar:</label>
                    <div class="col-md-9">
                        <input type="date" name="aplica_fecha_apl" id="aplica_fecha_apl" class="form-control">
                        <div id="validacion6_Edit" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <input type="hidden" name="id_gestion" id="id_gestion" readonly>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="button" type="submit" id="btn_edit" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
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
                <center><h4 class="modal-title" id="exampleModalLabel">Eliminar Gestion</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="id_gestion_delete" id="id_gestion_delete" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<script type="text/javascript">
    //Metooo para e ingreso de los descuentos
     $('#btn_save').on('click',function(){
        var nombre_gestion = $('#nombre_gestion').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var aplica_anio = $('#aplica_anio').val();
        var cuota_retener = $('#cuota_retener').val();
        var aplica_para = $('#aplica_para').val();
        
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Liquidacion/ingresarGestion')?>",
            dataType : "JSON",
            data : {nombre_gestion:nombre_gestion,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,aplica_anio:aplica_anio,cuota_retener:cuota_retener,aplica_para:aplica_para},
            success: function(data){
                if(data==null){
                    document.getElementById('validacion').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';
                    document.getElementById('validacion4').innerHTML = '';
                    
                    $('[name="nombre_gestion"]').val("");
                    $('[name="fecha_inicio"]').val("");
                    $('[name="fecha_fin"]').val("");
                    $('[name="aplica_anio"]').val("1");
                    $('[name="cuota_retener"]').val("");
                    $('[name="aplica_para"]').val("1");

                    location.reload();
                }else{
                    document.getElementById('validacion').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';
                    document.getElementById('validacion4').innerHTML = '';

                    for (i = 0; i <= data.length-1; i++){
                        if(data[i] == 1){
                            document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre de la Gestion";
                        }
                        if(data[i] == 2){
                            document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Fecha de Inicio";
                        }
                        if(data[i] == 3){
                            document.getElementById('validacion3').innerHTML += "Debe de Ingresar la Fecha Fin";
                        }
                        if(data[i] == 4){
                            document.getElementById('validacion2').innerHTML += "La fecha de Inico debe de ser menor que la fecha fin";
                        }
                        if(data[i] == 5){
                            document.getElementById('validacion4').innerHTML += "Debe de ingresar la couta a retener";
                        }
                        if(data[i] == 6){
                            document.getElementById('validacion4').innerHTML += "La couta tene que ser menor o igual a cero";
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
    });//fin de insercionde descuentos

     $('.item_edit').click(function(){
        document.getElementById('validacion_Edit').innerHTML = '';
        document.getElementById('validacion2_Edit').innerHTML = '';
        document.getElementById('validacion3_Edit').innerHTML = '';
        document.getElementById('validacion4_Edit').innerHTML = '';
        document.getElementById('validacion5_Edit').innerHTML = '';
        document.getElementById('validacion6_Edit').innerHTML = '';
        document.getElementById('validacion7_Edit').innerHTML = '';

        var code = $(this).data('id_gestion');
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Liquidacion/llenarGestion')?>",
            dataType : "JSON",
            data : {code:code},
            success: function(data){
                $('[name="id_gestion"]').val(code);
                $('[name="nombre_gestion_edit"]').val(data[0].nombre_gestion);
                $('[name="nombre_gestion2"]').val(data[0].nombre_gestion);
                $('[name="fecha_inicio_edit"]').val(data[0].fecha_inicio);
                $('[name="fecha_fin_edit"]').val(data[0].fecha_fin);
                $('[name="aplica_anio_edit"]').val(data[0].aplica_anios);
                $('[name="cuota_retener_edit"]').val(data[0].couta_retencion);
                $('[name="salario_min_edit"]').val(parseFloat(data[0].salario_min).toFixed(2));
                $('[name="aplica_fecha_max"]').val(data[0].fecha_max);
                $('[name="aplica_fecha_apl"]').val(data[0].fecha_aplicacion);
                $('[name="cantidad_sal_edit"]').val(data[0].cant_salario);
                        
                $('#Modal_Edit').modal('show');
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });

    });

     //metodo para modificar los descuentos
    $('#btn_edit').on('click',function(){
        var code = $('#id_gestion').val();
        var nombre_gestion = $('#nombre_gestion_edit').val();
        var nombre_gestion2 = $('#nombre_gestion2').val();
        var fecha_inicio = $('#fecha_inicio_edit').val();
        var fecha_fin = $('#fecha_fin_edit').val();
        var aplica_anio = $('#aplica_anio_edit').val();
        var cuota_retener = $('#cuota_retener_edit').val();
        var salario = $('#salario_min_edit').val();
        var aplica_fecha = $('#aplica_fecha_max').val();
        var fecha_aplicar = $('#aplica_fecha_apl').val();
        var cantidad_sal = $('#cantidad_sal_edit').val();
            
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Liquidacion/modificarGestion')?>",
            dataType : "JSON",
            data : {code:code,nombre_gestion:nombre_gestion,fecha_inicio:fecha_inicio,fecha_fin:fecha_fin,aplica_anio:aplica_anio,cuota_retener:cuota_retener,nombre_gestion2:nombre_gestion2,salario:salario,aplica_fecha:aplica_fecha,fecha_aplicar:fecha_aplicar,cantidad_sal:cantidad_sal},
            success: function(data){
                if(data == null){
                    location.reload();
                }else{
                    document.getElementById('validacion_Edit').innerHTML = '';
                    document.getElementById('validacion2_Edit').innerHTML = '';
                    document.getElementById('validacion3_Edit').innerHTML = '';
                    document.getElementById('validacion4_Edit').innerHTML = '';
                    document.getElementById('validacion5_Edit').innerHTML = '';
                    document.getElementById('validacion6_Edit').innerHTML = '';
                    document.getElementById('validacion7_Edit').innerHTML = '';

                    for (i = 0; i <= data.length-1; i++){
                        if(data[i] == 1){
                            document.getElementById('validacion_Edit').innerHTML += "Debe de Ingresar el Nombre de la Gestion";
                        }
                        if(data[i] == 2){
                            document.getElementById('validacion2_Edit').innerHTML += "Debe de Ingresar la Fecha de Inicio";
                        }
                        if(data[i] == 3){
                            document.getElementById('validacion3_Edit').innerHTML += "Debe de Ingresar la Fecha Fin";
                        }
                        if(data[i] == 4){
                            document.getElementById('validacion2_Edit').innerHTML += "La fecha de Inico debe de ser menor que la fecha fin";
                        }
                        if(data[i] == 5){
                            document.getElementById('validacion4_Edit').innerHTML += "Debe de ingresar la couta a retener";
                        }
                        if(data[i] == 6){
                            document.getElementById('validacion4_Edit').innerHTML += "La couta tene que ser menor o igual a cero";
                        }
                        if(data[i] == 7){
                            document.getElementById('validacion5_Edit').innerHTML += "Debe de ingresar el salario minimo";
                        }
                        if(data[i] == 8){
                            document.getElementById('validacion5_Edit').innerHTML += "Debe de ingresar el salario minimo de forma correcta (0:00)";
                        }
                        if(data[i] == 9){
                            document.getElementById('validacion6_Edit').innerHTML += "Debe de ingresar la fecha que se aplicara";
                        }
                        if(data[i] == 10){
                            document.getElementById('validacion7_Edit').innerHTML += "Debe de ingresar un la cantidad de salarios";
                        }
                        if(data[i] == 11){
                            document.getElementById('validacion7_Edit').innerHTML += "La cantidad de salarios no puede ser negativa";
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
        var code   = $(this).data('id_gestion');
        $('#Modal_Delete').modal('show');
        $('[name="id_gestion_delete"]').val(code);
    });//fin metodo llenado

    //Metodo para eliminar 
    $('#btn_delete').on('click',function(){
        var code = $('#id_gestion_delete').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Liquidacion/eliminarGestion')?>",
            dataType : "JSON",
            data : {code:code},
    
            success: function(data){
                $('[name="id_gestion_delete"]').val("");
                $('#Modal_Delete').modal('toggle');
                $('.modal-backdrop').remove();
                location.reload();
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
        return false;
    });//Fin metodo eliminar

</script>