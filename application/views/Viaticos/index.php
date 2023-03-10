        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Viaticos/Mantenimiento para Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                <?php if($ver==1){ ?>
                                 <div class="form-group col-md-3">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_prestamo" id="agencia_prestamo" class="form-control">
                                         <?php
                                            $i=0;
                                            foreach($agencia as $a){
                                        ?>
                                            <option id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            $i++;
                                        }
                                        ?>
                                    </select>
                                </div>
                            <?php }else{ ?>

                                <input type="hidden" name="agencia_prestamo" id="agencia_prestamo" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                            <?php } ?>
                                <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            </div>
                        </nav>
                        <table class="table table-striped" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Viatico</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo de Viatico:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_viatico" id="tipo_viatico" class="form-control">
                            <?php
                                $i=0;
                                foreach($tipos as $a){
                            ?>
                            <option id="<?= ($tipos[$i]->id_tipo_viaticos);?>"><?php echo($tipos[$i]->nombre);?></option>
                            <?php
                                    $i++;
                                }
                            ?>
                        </select>
                        <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad del Viatico:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_viatico" id="cantidad_viatico" class="form-control" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Forma del Viatico:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="forma_viatico" id="forma_viatico" class="form-control">
                            <option value="Permanente">Permanente</option>
                            <option value="Temporal">Temporal</option>
                        </select>
                    </div>
                </div>

                 <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fecha de Aplicacion:</label>
                    <div class="col-md-10">
                        <input type="date" name="fecha_viatico" id="fecha_viatico" class="form-control" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad de Quincenas:</label>
                    <div class="col-md-10">
                        <input type="text" name="quincenas" id="quincenas" class="form-control" placeholder="00" disabled>
                        <div id="validacion3" style="color:red"></div>
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


<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
       
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_prestamo').change(function(){

            show_data();
        });
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_prestamo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_prestamo').val();
            }
            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/empleados_data')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+//Agencia
                                '<td>'+registro.apellido+'</td>'+//nombrePlaza
                                '<td>'+registro.dui+'</td>'+//estado
                                '<td>'+registro.cargo+'</td>'+//agencia
                                '<td style="text-align:right;">'+
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_empleado+'">Agregar Viatico</a><?php } ?>'+' '+'<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Viaticos/verViaticos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Ver</a><?php } ?>'+                                    
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

        $('#forma_viatico').change(function(){
            var forma_viatico = $('#forma_viatico').val();

            if(forma_viatico == "Temporal"){
                $("#quincenas").prop('disabled', false);
            }else{
                $("#quincenas").prop('disabled', true);
                $('[name="quincenas"]').val("");
                document.getElementById('validacion3').innerHTML = '';
            }
        });

        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
           var code = $(this).data('codigo');
           document.getElementById('validacion').innerHTML = '';
           document.getElementById('validacion2').innerHTML = '';
            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
            $('[name="cantidad_viatico"]').val("");
            $('[name="forma_viatico"]').val("Permanente");
            $('[name="fecha_viatico"]').val("");
            $("#tipo_viatico option:first").attr('selected','selected'); 
            $('[name="quincenas"]').val("");
            $("#quincenas").prop('disabled', true);

            
        });
       
         //Save Plazas
         $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var cantidad_viatico = $('#cantidad_viatico').val();
            var forma_viatico = $('#forma_viatico').val();
            var fecha_viatico = $('#fecha_viatico').val();
            var quincena = '';
            var quincenas = $('#quincenas').val();
            var tipo_viatico = $('#tipo_viatico').children(":selected").attr("id");
             var autorizado = $('#user').val();

            if($('#quincenas').is(':disabled')){
                quincena = 'deshabilitada';
            }else{
                quincena = 'hablitada';
                
            }

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('viaticos/saveViatico')?>",
                dataType : "JSON",
                data : {code:code,cantidad_viatico:cantidad_viatico,forma_viatico:forma_viatico,fecha_viatico:fecha_viatico,quincena:quincena,quincenas:quincenas,tipo_viatico:tipo_viatico,autorizado:autorizado},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                         $('[name="code_user"]').val("");
                         $('[name="cantidad_viatico"]').val("");
                         $('[name="forma_viatico"]').val("Permanente");
                         $('[name="fecha_viatico"]').val("");
                         $("#tipo_viatico option:first").attr('selected','selected'); 
                         $('[name="fecha_fin"]').val("");
                         $("#fecha_fin").prop('disabled', true);
                         
                         alert("El ingreso se Realizo Correctamente");
                         $(".modal:visible").modal('toggle');
                        
                         this.disabled=false;
                         show_area();
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad de los Viaticos";
                            }else if(data[i] == 3){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad de los Viaticos en Forma Correcta (0.00)";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar la Fecha de Aplicacion";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion3').innerHTML += "Debe de Ingresar la cantidad de quincenas";

                            }else if(data[i] ==5){
                                document.getElementById('validacion3').innerHTML += "Solo se Aceptan Numeros Enteros en las quincenas";

                            }
                        }
                    }
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
          
        });

    });
</script>
</body>

</html>