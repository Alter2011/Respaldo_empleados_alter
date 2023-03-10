 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Descuentos de Horas</h2>
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
                                            <option value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
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

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Descuento de Horas </h3>
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
                    <label class="col-md-3 col-form-label">Cantidad de horas a descontar: </label>
                    <div class="col-md-3">
                        <input type="text" class="md-textarea form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="cantidad_horas" name="cantidad_horas" max='1'> 
                        <div id="validacion" style="color:red"></div>
                    </div>
                    <label class="col-md-1 col-form-label">Minutos: </label>
                    <div class="col-md-1">
                        <input type="text" class="md-textarea form-control" onkeypress='return event.charCode >= 48 && event.charCode <= 57' id="cantidad_min" name="cantidad_min" > 
                    </div>
                        <div class="col-sm-3" id="validacion7" style="color:red"></div>
                </div>

                <div class="form-group row" >
            	    <label class="col-md-3 col-form-label">Motivo de descuento:</label>
            	    <div class="col-md-5">
            	       <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Descripción del descuento"></textarea>
            	       <div id="validacion3" style="color:red"></div>
            	    </div>
        		</div>

            <div class="row" >
            <label class="col-md-3 col-form-label">fecha:</label>
                <div class="col-md-5">
                    <input type="date" class="form-control number-only" id="fecha" name="fecha" min="2018-01-01" required>

                    <div id="validacion2" style="color:red"></div>
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
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'">Agregar</a><?php } ?>'+' '+'<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Descuentos_horas/ver_detalles/'+registro.id_contrato+'/'+agencia_prestamo+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                    
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

            //><a href="<?php echo base_url();?>index.php/Descuentos_horas/ver_descuentos_horas/'+registro.id_contrato+'" class="btn btn-primary btn-sm">Revisar</a>
            //<a href="<?php echo base_url();?>index.php/Descuentos_horas/ver_detalles/'+registro.id_contrato+'" class="btn btn-primary btn-sm">Revisar</a>
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
            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
            
        });
       
         //Save descuentos de horas
         $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var autorizado = $('#user').val();
            var cantidad_horas = $('#cantidad_horas').val();
            var cantidad_min = $('#cantidad_min').val();
            var fecha = $('#fecha').val();
            var agencia_prestamo = $('#agencia_prestamo').val();
            var descripcion = $('#descripcion').val();
                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Descuentos_horas/crear_descuentos_horas')?>",
                dataType : "JSON",
                data : {code:code,cantidad_horas:cantidad_horas,cantidad_min:cantidad_min,fecha:fecha,agencia_prestamo:agencia_prestamo,descripcion:descripcion,autorizado:autorizado},
                success: function(data){
                    console.log(data);
                if ((data==null)) {
                document.getElementById('validacion').innerHTML = '';
                document.getElementById('validacion2').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';
                document.getElementById('validacion7').innerHTML = '';
                
                alert("El ingreso se realizo con Exito");
                $("#Modal_Add").modal('toggle');

                this.disabled=false;
                location.reload(true);
                show_area();
            }else{
                document.getElementById('validacion').innerHTML = '';
                document.getElementById('validacion2').innerHTML = '';
                document.getElementById('validacion3').innerHTML = '';
                 document.getElementById('validacion7').innerHTML = '';
                for (i = 0; i <= data.length-1; i++) {
                    if(data[i] == 1){
                        document.getElementById('validacion').innerHTML += "Ingrese una cantidad de horas valida";
                    }
                    if(data[i] == 2){
                        document.getElementById('validacion2').innerHTML += "Ingrese una fecha";
                    }else if (data== 4) {
                        document.getElementById('validacion2').innerHTML += "Esta es una fecha de asueto";
                    }else if (data== 5) {
                        document.getElementById('validacion2').innerHTML += "No se le pueden descontar mas de 8 horas al dia";
                    }
                    if(data[i] == 6){
                        document.getElementById('validacion3').innerHTML += "Ingrese una descripcion";
                    }
                    if(data[i] == 8){
                        document.getElementById('validacion7').innerHTML += "Ingrese una cantidad de minutos validos";
                    }
                    if(data[i] == 9){
                        document.getElementById('validacion7').innerHTML += "no se pueden asignar minutos";
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
          
        });//fin de la funcion crear horas extras 

    });
</script>
</body>

</html>