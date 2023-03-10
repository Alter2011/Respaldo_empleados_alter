    
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Prestamos Internos</h2>
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
                             <input type="hidden" name="perfin_user" id="perfin_user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>
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
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Solicitud de Prestamo Interno</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div id="validacion6" style="color:red"></div>
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo de Prestamo:</label>
                    <div class="col-md-10">
                        <select name="tipo_prestamo" id="tipo_prestamo" class="form-control" placeholder="Price">
                            <?php
                                $i=0;
                                foreach($tipo as $a){
                            ?>
                                <option id="<?= ($tipo[$i]->id_tipo_prestamo);?>" value="<?= ($tipo[$i]->id_tipo_prestamo);?>"><?php echo($tipo[$i]->nombre_prestamo);?></option>
                            <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad del Prestamo:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_prestamo" id="cantidad_prestamo" class="form-control prestamo" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tiempo a Pagar:</label>
                    <div class="col-md-10">
                        <input type="text" name="tiempo_prestamo" id="tiempo_prestamo" class="form-control prestamo" placeholder="0.00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Periodo:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="periodo_prestano" id="periodo_prestano" class="form-control">
                            <option value="1">Quincena</option>
                            <option value="2">Meses</option>
                            <option value="3">Años</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripcion del Prestamo:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control prestamo" id="descripcion_prestano" name="descripcion_prestano"></textarea>
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>
                

            </div>
            
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary cerrar" data-dismiss="modal">Cerrar</button>
            <?php
                //if($this->session->userdata('rol')=="Administrador"){ 
            ?>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            <!--Se utiliza para cuando se alguien que no sea admin pida una aprobacion de prestamos-->
            <center><div id="validacion5" style="color:red"></div>
            <button type="button" type="submit" id="btn_solicitud" class="btn btn-success solicitud" style="display: none;">Hacer Solicitud</button>
            <button type="button" class="btn btn-danger cancelar" id="btn_cancelar" style="display: none;">Cancelar</button></center>
            <?php
                //}
            ?>
            </div>
        </div>
        </div>
    </div>
</form>


<!--END MODAL ADD-->


<script type="text/javascript">
    $(document).ready(function(){
        var plazas_edit;
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_prestamo').change(function(){

            show_data();
        });
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
                                    '<?php if ($Agregar==1) { ?>'+
                                    '<a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_empleado+'">Agregar'+
                                    '</a><?php } ?>'+' '+'<?php if ($Revisar==1) { ?>'+
                                    '<a href="<?php echo base_url();?>index.php/Prestamo/verPrestamo/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a'+
                                    '><?php } ?>'+                                    
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

        }
        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
           var code = $(this).data('codigo');
           document.getElementById('validacion').innerHTML = '';
           document.getElementById('validacion2').innerHTML = '';
           document.getElementById('validacion3').innerHTML = '';
           document.getElementById('validacion4').innerHTML = '';
           document.getElementById('validacion5').innerHTML = '';
           document.getElementById('validacion6').innerHTML = '';
          
            $('[name="code_user"]').val(code);
            $('[name="cantidad_prestamo"]').val("");
            $('[name="tiempo_prestamo"]').val("");
            $('[name="descripcion_prestano"]').val("");
            $('#periodo_prestano').val(1);
            $("#tipo_prestamo option:first").attr('selected','selected');
             $(".solicitud").css("display", "none");
            $(".cancelar").css("display", "none");
            $("#btn_save").show();
            $(".cerrar").show();
            $("#periodo_prestano").prop('disabled', false);
            $("#tipo_prestamo").prop('disabled', false);
            $(".prestamo").prop("readonly",false);
            $(".close").show();
            $('#Modal_add').modal('show');
            
        });
       
         //Save Plazas
         $('#btn_save').on('click',function(){
            var code = $('#code_user').val();
            var cantidad_prestamo = $('#cantidad_prestamo').val();
            var tipo_prestamo = $('#tipo_prestamo').children(":selected").attr("id");
            var tiempo = $('#tiempo_prestamo').val();
            var periodo = $('#periodo_prestano').val();
            var descripcion_prestano = $('#descripcion_prestano').val();
            var autorizado = $('#user').val();
            var perfil = $('#perfin_user').val();

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/savePrestamo')?>",
                dataType : "JSON",
                data : {code:code,cantidad_prestamo:cantidad_prestamo,tipo_prestamo:tipo_prestamo,tiempo:tiempo,periodo:periodo,autorizado:autorizado,descripcion_prestano:descripcion_prestano,perfil:perfil},
                success: function(data){

                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                         $('[name="code_user"]').val("");
                         $('[name="cantidad_prestamo"]').val("");
                         $('[name="tiempo_prestamo"]').val("");
                         $('[name="periodo_prestano"]').attr("selected", true);
                         $("#tipo_prestamo option:first").attr('selected','selected');
                         $('[name="descripcion_prestano"]').val("");
                         alert("El ingreso se Realizo Correctamente, Por Favor Cierre La Ventana");
                        
                         this.disabled=false;
                         show_area();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';
                        document.getElementById('validacion6').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Prestamo";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Prestamo en Forma Correcta (0.00)";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacion').innerHTML += "La Cantidad del Prestamo Tiene que ser Mayores a Cero";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Tiempo en que pagara el prestamo";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML += "El Tiempo de Prestamo solo acepta numeros enteros y mayores a cero";
                            }
                            if(data[i] == 6){
                                document.getElementById('validacion3').innerHTML += "Debe de ingresar una Descripcion del Prestamo";
                            }
                            if(data[i] == 7){
                                document.getElementById('validacion3').innerHTML += "Solo puede ingresar un maximo de 500 caracteres(Cuentan los espacios)";
                            }
                            if(data[i] == 8){
                                document.getElementById('validacion4').innerHTML += "Debe de Ingresar el Tipo de Prestamo";
                            }
                            if(data[i] == 10){
                                document.getElementById('validacion6').innerHTML += "Este usuario no posee un registro laboral Activo";
                            }
                            if(data[i] == 9){
                                document.getElementById('validacion5').innerHTML = "Usted no Tiene Los permisos necesarios para aprobar este prestamos<br>¿Desea mandar una solicitud para Aprobacion?<br>";
                                $(".solicitud").show();
                                $(".cancelar").show();
                                $("#btn_save").hide();
                                $(".cerrar").hide();
                                $(".prestamo").prop("readonly",true);
                                $("#tipo_prestamo").prop('disabled', true);
                                $("#periodo_prestano").prop('disabled', true);
                                $(".close").hide();
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

        //Se manda la solicitud
        $('#btn_solicitud').on('click',function(){
            var code = $('#code_user').val();
            var cantidad_prestamo = $('#cantidad_prestamo').val();
            var tipo_prestamo = $('#tipo_prestamo').children(":selected").attr("id");
            var tiempo = $('#tiempo_prestamo').val();
            var periodo = $('#periodo_prestano').val();
            var descripcion_prestano = $('#descripcion_prestano').val();
            var autorizado = $('#user').val();

            var confirmar = confirm("¿Desea Solicitar este Prestamo Interno?");
            if(confirmar){
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Prestamo/solicitudInternos')?>",
                dataType : "JSON",
                data : {code:code,cantidad_prestamo:cantidad_prestamo,tipo_prestamo:tipo_prestamo,tiempo:tiempo,periodo:periodo,descripcion_prestano:descripcion_prestano,autorizado:autorizado},
                success: function(data){
                    console.log(data);
                    
                    document.getElementById('validacion5').innerHTML = '';
                    $('[name="code_user"]').val("");
                    $('[name="cantidad_prestamo"]').val("");
                    $('[name="tiempo_prestamo"]').val("");
                    $('[name="periodo_prestano"]').attr("selected", true);
                    $("#tipo_prestamo option:first").attr('selected','selected');
                    $('[name="descripcion_prestano"]').val("");
                    
                    alert("La solicitud se Realizo Correctamente");
                    $(".modal:visible").modal('toggle');
                        
                    this.disabled=false;
                    show_area();
                   
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
            return false;
            }
        });

         //Se cancela la solicitud de pretsmo
        $('#btn_cancelar').on('click',function(){
            var confirmar = confirm("¿Desea Cancelar esta Solicitud de Prestamo Interno?");

            if(confirmar){
                $(".modal:visible").modal('toggle');
            }
        });
         $('.item_add').click(function(){
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
         });

    });
</script>
</body>

</html>