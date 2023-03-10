 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Ingreso de dias laborados</h2>
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
            <h3 class="modal-title" id="exampleModalLabel">Ingresar Dia Trabajado</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div id="validacionUser" style="color:red"></div><br>

            <div class="form-group row">
                <div class="col-md-5">
                    <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fecha:</label>
                    <div class="col-md-5">
                        <input type="date" name="fecha" id="fecha" class="form-control">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row" >
                    <label class="col-md-2 col-form-label">Seleccione:</label>
                    <div class="col-md-5">
                    <input type="radio" id="jornada" name="jornada" value="1" checked>
                    <label for="age1">Media Dia: 4 Horas</label><br>
                    <input type="radio" id="jornada" name="jornada" value="2">
                    <label for="age2">Dia Completo: 8 Horas</label><br> 
                    <input type="radio" id="jornada" name="jornada" value="3">
                    <label for="age3">Dia de Vacación</label><br>  
                        <div id="validacion1" style="color:red"></div>
                    </div>
                </div>
<!--
                <div class="form-group row" >
                    <label class="col-md-2 col-form-label">Hora de Entrada:</label>
                    <div class="col-md-5">
                        <input type="time" name="hora1" id="hora1" class="form-control" placeholder="0.00">
                        <div id="validacion1" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row" >
                    <label class="col-md-2 col-form-label">Hora de Salida:</label>
                    <div class="col-md-5">
                        <input type="time" name="hora2" id="hora2" class="form-control">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
-->

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
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>

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
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_empleado+'">Agregar Dia</a><?php } ?>  '+'<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Dias_trabajados/verDias/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                  
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
            //document.getElementById('validacion1').innerHTML = '';
            //document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacionUser').innerHTML = '';
            $('[name="fecha"]').val("");
            //$('[name="hora1"]').val("");
            //$('[name="hora2"]').val("");

            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
            
        });
       
         //Save Plazas
         $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var codigo_empleado = $('#codigo_empleado').val();
            var fecha = $('#fecha').val();
            var jornada = $('input:radio[name=jornada]:checked').val();
            var autorizado = $('#user').val();//usar para guardar quien ingresa esto

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Dias_trabajados/saveDiaTrabajado')?>",
                dataType : "JSON",
                data : {code:code,codigo_empleado:codigo_empleado,fecha:fecha,jornada:jornada,autorizado:autorizado},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        
                        document.getElementById('validacionUser').innerHTML = '';
                         $('[name="code_user"]').val("");
                         $('[name="codigo_empleado"]').val("");
                         $('[name="fecha"]').val("");
                         $('[name="hora1"]').val("");
                         $('[name="hora2"]').val("");

                        this.disabled=false;
                        alert("Se agrego el dia correctamente");
                        location.reload(true);
                        show_area();
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacionUser').innerHTML = '';
                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe ingresar una fecha";
                            } else if(data[i] == 6){
                                document.getElementById('validacion').innerHTML += "El dia ingresado ya existe";
                                alert("El dia ingresado ya existe");
                            }
                        } 
                    }
                   /*else if(data[i] == 4){
                    document.getElementById('validacion').innerHTML += "La fecha ingresada no puede ser dia Domingo";
                    }*/
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