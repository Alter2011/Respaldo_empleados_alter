 <style type="text/css">
     .fecha{
        padding-right: 0.5%;
     }
     .campos{
        padding-right: 0.5%; 
        padding-left: 0.5%;
     }
     .gestion{
        padding-right: 0.5%;
     }
 </style>
 <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
 <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Permisos para Empleados</h2>
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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Permiso Nuevo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div id="validacionUser" style="color:red"></div><br>

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="code_user" id="code_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tramite a Realizar:</label>
                    <div class="col-md-9 gestion">
                        <select class="form-control" name="tipo_permiso" id="tipo_permiso" class="form-control">
                            <option value="1">Permiso Con Goce de sueldo</option>
                            <option value="2">Mision Oficial</option>
                            <option value="3">Ausencia injustificada</option>
                            <option value="4">Compensatorio</option>
                            <option value="5">Permiso Sin Goce de sueldo</option>
                            <option value="6">Capacitacion</option>
                            <option value="10">Otros</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-md-2 col-form-label">Desde:</label>
                    <div class="col-md-3 fecha">
                        <input type="date" name="desde" id="desde" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-2 campos">
                        <input type="number" name="hora1" id="hora1" class="form-control" placeholder="Hora">
                    </div>
                    <div class="col-md-2 campos">
                        <input type="number" name="min1" id="min1" class="form-control" placeholder="Minutos">
                    </div>
                    <div class="col-md-2 campos">
                        <select class="form-control" name="tiempo1" id="tiempo1">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-9">
                        <div id="validacion" style="color:red"></div>
                    </div>
                    
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta:</label>
                    <div class="col-md-3 fecha">
                        <input type="date" name="hasta" id="hasta" class="form-control" placeholder="0.00">
                    </div>
                    <div class="col-md-2 campos">
                        <input type="number" name="hora2" id="hora2" class="form-control" placeholder="Hora">
                    </div>
                    <div class="col-md-2 campos">
                        <input type="number" name="min2" id="min2" class="form-control" placeholder="Minutos">
                    </div>
                    <div class="col-md-2 campos">
                        <select class="form-control" name="tiempo2" id="tiempo2">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-9">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                    
                </div>

                <div class="form-group row" id="div_hora_almuerzo">
                    <label class="col-md-2 col-form-label"></label>
                    <input type="checkbox" id="cont_almuerzo" name="cont_almuerzo">
                    <label for="horaAlmuerzo">Contar hora de almuerzo   </label><br> 
                </div>

                <div class="form-group row"> 
                    <label class="col-md-2 col-form-label">Justificacion:</label>
                    <div class="col-md-9 gestion">
                        <textarea class="md-textarea form-control" id="justificacion" name="justificacion"></textarea>
                        <div id="validacion3" style="color:red"></div>
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

        ocultar();

        $('#tipo_permiso').change(function(){
            ocultar();
            //alert(tipo_permiso)
        });
        
        function ocultar(){
            var tipo_permiso = $('#tipo_permiso').val();
            if(tipo_permiso==5){
                total_horas();
            }else{
                $('#div_hora_almuerzo').hide();
                $("#cont_almuerzo").prop("checked", false);
                //$('#btn_save').show();
                //total_horas();
            }
        }

    $("#hasta").change(function(){
	  ocultar();
	});
	$("#desde").change(function(){
	  ocultar();
	});
    $("#hora1").keydown(function(){
	  ocultar();
	});
	$("#hora1").keyup(function(){
	  ocultar();
	});
    $("#hora2").keydown(function(){
	  ocultar();
	});
	$("#hora2").keyup(function(){
	  ocultar();
	});
    $("#min1").keydown(function(){
	  ocultar();
	});
	$("#min1").keyup(function(){
	  ocultar();
	});
    $("#min2").keydown(function(){
	  ocultar();
	});
	$("#min2").keyup(function(){
	  ocultar();
	});

    $("#tiempo1").change(function(){
	  ocultar();
	});
	$("#tiempo2").change(function(){
	  ocultar();
	});

        function total_horas(){
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            var hora1 = $('#hora1').val();
            var min1 = $('#min1').val();
            var hora2 = $('#hora2').val();
            var min2 = $('#min2').val();
            var tiempo1 = $('#tiempo1').val();
            var tiempo2 = $('#tiempo2').val();
            if($('#cont_almuerzo').is(":checked")){
                var conta_almuerzo = 1;
            }else{
                var conta_almuerzo = 0;
            }    

            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('permisosEmpleados/incluirAlmuerzo')?>',
                async : false,
                dataType : 'JSON',
                data : {desde:desde,hasta:hasta,hora1:hora1,min1:min1,tiempo1:tiempo1,hora2:hora2,min2:min2,tiempo2:tiempo2,conta_almuerzo:conta_almuerzo},
                success : function(data){
                    console.log(data);
                    if(data==true){
                        $('#div_hora_almuerzo').show();
                    }else{
                        $('#div_hora_almuerzo').hide();
                    }
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });     
        }

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
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_empleado+'">Agregar Permiso</a><?php } ?>'+' '+'<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/PermisosEmpleados/verPermisos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                    
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
            document.getElementById('validacionUser').innerHTML = '';
            $('[name="desde"]').val("");
            $('[name="hasta"]').val("");
            $('[name="justificacion"]').val("");
            $('[name="hora1"]').val("");
            $('[name="min1"]').val("");
            $('[name="hora2"]').val("");
            $('[name="min2"]').val("");

            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
            
        });
       
       $('#btn_save2').on('click',function(){
            var desde = $('#desde').val();
            var min1 = $('#min1').val();

            alert(min1);
       });

         //Save Plazas
         $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var codigo_empleado = $('#codigo_empleado').val();
            var tipo_permiso = $('#tipo_permiso').val();
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            var justificacion = $('#justificacion').val();
            var autorizado = $('#user').val();
            var hora1 = $('#hora1').val();
            var min1 = $('#min1').val();
            var tiempo1 = $('#tiempo1').val();
            var hora2 = $('#hora2').val();
            var min2 = $('#min2').val();
            var tiempo2 = $('#tiempo2').val();
            if($('#cont_almuerzo').is(":checked")){
                var conta_almuerzo = 1;
            }else{
                var conta_almuerzo = 0;
            }            

                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('PermisosEmpleados/savePermiso')?>",
                dataType : "JSON",
                data : {code:code,codigo_empleado:codigo_empleado,tipo_permiso:tipo_permiso,desde:desde,hasta:hasta,justificacion:justificacion,autorizado:autorizado,hora1:hora1,min1:min1,tiempo1:tiempo1,hora2:hora2,min2:min2,tiempo2:tiempo2,conta_almuerzo:conta_almuerzo},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacionUser').innerHTML = '';
                         $('[name="code_user"]').val("");
                         $('[name="codigo_empleado"]').val("");
                         $('[name="tipo_permiso"]').val("");
                         $('[name="desde"]').val("");
                         $('[name="hasta"]').val("");
                         $('[name="justificacion"]').val("");
                         this.disabled=false;
                        
                         document.location.href ="<?php echo base_url();?>index.php/PermisosEmpleados/imprimirBoleta/"+code+"";
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                        document.getElementById('validacionUser').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "*Debe de Ingresar la Fecha Desde Cuando se Quiere el Permiso<br>";
                            }else if(data[i] == 6){
                                document.getElementById('validacion').innerHTML += "*Debe de Ingresar la Hora Desde Cuando se Quiere el Permiso<br>";
                            }else if(data[i] == 7){
                                document.getElementById('validacion').innerHTML += "*La Hora Debe de Ser Mayor a Cero<br>";

                            }else if(data[i] == 8){
                                document.getElementById('validacion').innerHTML += "*La Hora Debe de Ser Menor o Igual a 12<br>";

                            }else if(data[i] == 9){
                                document.getElementById('validacion').innerHTML += "*Solo se Permiten Horas Enteras<br>";

                            }else if(data[i] == 10){
                                document.getElementById('validacion').innerHTML += "*Debe de Ingresar los Minutos Desde Cuando se Quiere el Permiso<br>";

                            }else if(data[i] == 11){
                                document.getElementById('validacion').innerHTML += "*Los Minutos de Ser Mayor o igual a Cero<br>";

                            }else if(data[i] == 12){
                                document.getElementById('validacion').innerHTML += "*Los Minutos Deben de Ser Menores a 60<br>";

                            }else if(data[i] == 13){
                                document.getElementById('validacion').innerHTML += "*Los Minutos Deben de Ser Enteros<br>";

                            }

                            if(data[i] == 2){
                                document.getElementById('validacion2').innerHTML += "*Debe la Fecha de Ingresar Hasta Cuando se Quiere el Permiso<br>";

                            }else if(data[i] == 14){
                                document.getElementById('validacion2').innerHTML += "*Debe de Ingresar la Hora Hasta Cuando se Quiere el Permiso<br>";

                            }else if(data[i] == 15){
                                document.getElementById('validacion2').innerHTML += "*La Hora Debe de Ser Mayor a Cero<br>";

                            }else if(data[i] == 16){
                                document.getElementById('validacion2').innerHTML += "*La Hora Debe de Ser Menor o Igual a 12<br>";

                            }else if(data[i] == 17){
                                document.getElementById('validacion2').innerHTML += "*Solo se Permiten Horas Enteras<br>";

                            }else if(data[i] == 18){
                                document.getElementById('validacion2').innerHTML += "*Debe de Ingresar los Minutos Hasta Cuando se Quiere el Permiso<br>";

                            }else if(data[i] == 19){
                                document.getElementById('validacion2').innerHTML += "*Los Minutos de Ser Mayor o igual a Cero<br>";

                            }else if(data[i] == 20){
                                document.getElementById('validacion2').innerHTML += "*Los Minutos Deben de Ser Menores a 60<br>";

                            }else if(data[i] == 21){
                                document.getElementById('validacion2').innerHTML += "*Los Minutos Deben de Ser Enteros<br>";

                            }

                            if(data[i] == 3){
                                document.getElementById('validacion3').innerHTML = "*Debe de Ingresar la Justificacion del Permiso";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion3').innerHTML = "*Solo se permiten un maximo de 300 carracteres (cuentan los espacios)";
                            }
                            if(data[i] == 5){
                                document.getElementById('validacionUser').innerHTML = "*Debe de Solicitar el Permiso a su Jefe Inmediato";
                            }
                            if(data[i] == 22){
                                document.getElementById('validacionUser').innerHTML = "*La fecha Desde tiene que ser menor de la fecha Hasta";
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