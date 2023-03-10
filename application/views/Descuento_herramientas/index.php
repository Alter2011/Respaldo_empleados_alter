        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Descuentos para Empleados</h2>
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
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nuevo Descuento</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <center><div id="validacion_user" style="color:red"></div></center>
                
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_contrato" id="code_contrato" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

            <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo de Descuento:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="tipo_descuento" id="tipo_descuento" class="form-control">
                            <?php
                            $i=0;
                                foreach($descuentos as $a){
                            ?>
                                <option id="<?= ($descuentos[$i]->id_tipo_descuento);?>"><?php echo($descuentos[$i]->nombre_tipo);?></option>
                            <?php
                                $i++;
                            }
                            ?>
                        </select>
                        <div id="validacion4" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad a Descontar:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_descuento" id="cantidad_descuento" class="form-control prestamo" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tiempo a Pagar:</label>
                    <div class="col-md-10">
                        <input type="number" name="tiempo_descuento" id="tiempo_descuento" class="form-control prestamo" placeholder="00">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Periodo:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="periodo_descuento" id="periodo_descuento" class="form-control prestamoSe" >
                            <option value="1">Quincena</option>
                            <option value="2">Meses</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripcion del Prestamo:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control prestamo" id="descripcion_descuento" name="descripcion_descuento"></textarea>
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
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'">Agregar Descuento</a><?php } ?>'+' '+'<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Descuentos_herramientas/verDescuentos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                    
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

        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacion3').innerHTML = '';
            document.getElementById('validacion4').innerHTML = '';

            $('[name="cantidad_descuento"]').val("");
            $('[name="tiempo_descuento"]').val("");
            $('[name="descripcion_descuento"]').val("");

            $('[name="code_contrato"]').val(code);
            $('#Modal_add').modal('show');
            
        });
       
         //Save Prestamos Personales
         $('#btn_save').on('click',function(){
            var code = $('#code_contrato').val();
            var user = $('#user').val();
            var cantidad_descuento = $('#cantidad_descuento').val();
            var tiempo_descuento = $('#tiempo_descuento').val();
            var periodo_descuento = $('#periodo_descuento').val();
            var descripcion_descuento = $('#descripcion_descuento').val();
            var tipo_descuento = $('#tipo_descuento').children(":selected").attr("id");


                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Descuentos_herramientas/saveDec')?>",
                dataType : "JSON",
                data : {code:code,tipo_descuento:tipo_descuento,cantidad_descuento:cantidad_descuento,tiempo_descuento:tiempo_descuento,periodo_descuento:periodo_descuento,descripcion_descuento:descripcion_descuento,user:user},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';

                         $('[name="code_contrato"]').val("");
                         $('[name="cantidad_descuento"]').val("");
                         $('[name="tiempo_descuento"]').val("");
                         $('[name="periodo_descuento"]').val("1");
                         $('[name="descripcion_descuento"]').val("");
                         
                         alert("El ingreso se Realizo Correctamente");
                         $(".modal:visible").modal('toggle');
                        
                         this.disabled=false;
                         show_area();
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacion4').innerHTML = '';


                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion4').innerHTML += "Debe de ingresar el Tipo de Descuento";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Descuento";

                            }else if(data[i] == 3){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad del Descuento de Forma Correcta(0.00)";

                            }else if(data[i] == 4){
                                document.getElementById('validacion').innerHTML += "La Cantidad del Descuento debe de ser Mayor a Cero";

                            }
                            if(data[i] == 5){
                                document.getElementById('validacion2').innerHTML += "Debe de Ingresar el Timpo a Descuento";

                            }else if(data[i] == 6){
                                document.getElementById('validacion2').innerHTML += "Solo se Aceptan Numeros Enteros en el Tiempo a Pagar y Mayores a Cero";

                            }else if(data[i] == 7){
                                document.getElementById('validacion2').innerHTML += "El Tiempo a Pagar Debe de Ser Mayores a Cero";
                            }
                            if(data[i] == 8){
                                document.getElementById('validacion3').innerHTML += "Debe Ingresar Una Descripcion";
                            }
                            if(data[i] == 9){
                                document.getElementById('validacion3').innerHTML += "Solo se aceptan un maximo de 300 caracteres(Incluye los espacio)";

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