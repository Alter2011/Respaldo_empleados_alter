<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Paises</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right"><?php ?><a href="#" class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus"></span> Agregar Nuevo</a><?php ?><br><br></nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombre</th>      
                                    <th style="text-align:center;">Continente</th>
                                    <th style="text-align:center;">Region</th>
                                    <th style="text-align: center">Fecha Cracion</th>
                                    <th style="text-align: center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="show_data">
                                <?php
                              
                                foreach ($paises as $pais) {
                                   
                                   echo "<tr>";
                                   echo "<td class='pais'>".$pais->nombre_pais."</td>";
                                   echo "<td class='continente'>".$pais->continente."</td>";
                                   echo "<td class='region'>".$pais->region."</td>";
                                   echo "<td>".$pais->fecha_creacion."</td>";
                                   echo '<td style="text-align:right;"><a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-id_pais="'.$pais->id_pais.'"> Editar </a>';
                                   echo ' <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="'.$pais->id_pais.'"> Eliminar </a></td>';
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Pais</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
           <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" name="pais_nombre" id="pais_nombre" class="form-control" placeholder="Nombre del Pais">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Continente:</label>
                    <div class="col-md-10">
                       <select name="pais_continente" id="pais_continente" class="form-control" placeholder="Price">
                            <option id="América">América</option>
                            <option id="Europa">Europa</option>
                            <option id="Asia">Asia</option>
                            <option id="Africa">Africa</option>
                            <option id="Oceania">Oceania</option>
                        </select>

                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Region:</label>
                    <div class="col-md-10">
                        <input type="text" name="pais_region" id="pais_region" class="form-control" placeholder="Ejemplo: América Central">
                        <div id="validacion2" style="color:red"></div>
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
            <h3 class="modal-title" id="exampleModalLabel">Editar Pais</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
             <div class="col-md-10">
                    <input type="hidden" name="pais_code_edit" id="pais_code_edit" class="form-control" readonly>
                    <input type="hidden" name="paises_nombre" id="paises_nombre" class="form-control" readonly>
                </div>
            </div>
             <div class="modal-body">
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Nombre:</label>
                    <div class="col-md-10">
                        <input type="text" name="pais_nombre_edit" id="pais_nombre_edit" class="form-control" placeholder="Nombre del Pais">
                        <div id="validacion_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Continente:</label>
                    <div class="col-md-10">
                       <select name="pais_continente_edit" id="pais_continente_edit" class="form-control" placeholder="Price">
                            <option id="América">América</option>
                            <option id="Europa">Europa</option>
                            <option id="Asia">Asia</option>
                            <option id="Africa">Africa</option>
                            <option id="Oceania">Oceania</option>
                        </select>

                    </div>
                </div>
            
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Region:</label>
                    <div class="col-md-10">
                        <input type="text" name="pais_region_edit" id="pais_region_edit" class="form-control" placeholder="Ejemplo: América Central">
                        <div id="validacion2_edit" style="color:red"></div>
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

        <!--MODAL DELETE-->
        <form>
        <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Pais</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="pais_code_delete" id="pais_code_delete" class="form-control" readonly>
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
            var pais_nombre = $('#pais_nombre').val();
            var pais_continente = $('#pais_continente').val();
            var pais_region = $('#pais_region').val();
            //alert('Hola');
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/sevePais')?>",
                dataType : "JSON",
                data : {pais_nombre:pais_nombre,pais_continente:pais_continente,pais_region:pais_region},
                success: function(data){
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';

                        $('[name="pais_nombre"]').val("");
                        $('[name="pais_continente"]').val("América");
                        $('[name="pais_region"]').val("");
                        
                        location.reload();
                        this.disabled=false;
                        show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar el Nombre del Pais";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Regioan al que Pertenece el Pais";
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
            document.getElementById('validacion_edit').innerHTML = '';
            document.getElementById('validacion2_edit').innerHTML = '';
            var pais = "";
            var continente = "";
            var region = "";
            var code   = $(this).data('id_pais');

            $(this).parents("tr").find(".pais").each(function() {
              pais += $(this).html();
            });
            $(this).parents("tr").find(".continente").each(function() {
              continente += $(this).html();
            });
            $(this).parents("tr").find(".region").each(function() {
              region += $(this).html();
            });

            $('[name="pais_code_edit"]').val(code);
            $('[name="paises_nombre"]').val(pais);
            $('[name="pais_nombre_edit"]').val(pais);
            $('[name="pais_continente_edit"]').val(continente);
            $('[name="pais_region_edit"]').val(region);

            $('#Modal_Edit').modal('show');
        });

         //metodo para modificar los descuentos
        $('#btn_update').on('click',function(){
            var code = $('#pais_code_edit').val();
            var pais_nombre = $('#pais_nombre_edit').val();
            var pais_continente = $('#pais_continente_edit').val();
            var pais_region = $('#pais_region_edit').val();

            /*var estado = 0;
            if(nombre_edit == nombre_hide){
                estado = 1;
            }*/
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/updatePais')?>",
                dataType : "JSON",
                data : {code:code,pais_nombre:pais_nombre,pais_continente:pais_continente,pais_region:pais_region},
                success: function(data){
                    console.log(data);
                    if(data==null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';

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

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de Ingresar el Nombre del Pais";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de Ingresar la Regioan al que Pertenece el Pais";
                            }
                            
                        }
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
            $('[name="pais_code_delete"]').val(code);
        });//fin metodo llenado

        //Metodo para eliminar 
         $('#btn_delete').on('click',function(){
            var code = $('#pais_code_delete').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Agencias/deletePais')?>",
                dataType : "JSON",
                data : {code:code},
    
                success: function(data){
                    $('[name="pais_code_delete"]').val("");
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