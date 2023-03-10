 <style type="text/css">
    .checkbox label:after{
  content: '';
  display: table;
  clear: both;
}

.checkbox .cr{
  position: relative;
  display: inline-block;
  border: 1px solid #a9a9a9;
  border-radius: .25em;
  width: 1.3em;
  height: 1.3em;
  float: left;
  margin-right: .5em;
}

.checkbox .cr .cr-icon{
  position: absolute;
  font-size: .8em;
  line-height: 0;
  top: 50%;
  left: 15%;
}

.checkbox label input[type="checkbox"]{
  display: none;
}

.checkbox label input[type="checkbox"]+.cr>.cr-icon{
  opacity: 0;
}

.checkbox label input[type="checkbox"]:checked+.cr>.cr-icon{
  opacity: 1;
}

.checkbox label input[type="checkbox"]:disabled+.cr{
  opacity: .5;
}
</style> 


<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Gratificaciones de los Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">

                        <nav class="float-right" >
                            <div class="col-sm-8">
                                <div class="form-row">
                                <?php if($ver==1){ ?>
                                    <div class="form-group col-md-3">
                                        <label for="inputState" class="nameAgencia">Agencia</label>
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
                        </div>
                        </nav>


                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados</a></li>
                            <li><a data-toggle="tab" href="#menu1" id="pag2">Total Gratificacion</a></li>
                        </ul>

                        <div class="tab-content">

                            <div id="home" class="tab-pane active"><br>
                                
                                <table class="table table-striped" id="mydata">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Nombres</th>      
                                            <th style="text-align:center;">Apellidos</th>
                                            <th style="text-align:center;">DUI</th>
                                            <th style="text-align:center;">Cargo</th>
                                            <th style="text-align:center;">Gratificacion</th>
                                            <th style="text-align:center;">Accion</th>
                            </tr>
                                    </thead>
                                    <tbody id="show_data" class="tabla1"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                                    </tbody>
                                         <button class="btn btn-success crear ocultar" id="btn_imprimir_bonos" style="position: relative; top: 25px;display: none">Imprimir Bonos</button>
                                </table>

                            </div>

                            <div id="menu1" class="tab-pane fade"><br>

                                <table class="table table-striped" id="mydata2">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Agencia</th>      
                                            <th style="text-align:center;">Nombres</th>      
                                            <th style="text-align:center;">Apellidos</th>
                                            <th style="text-align:center;">DUI</th>
                                            <th style="text-align:center;">Cargo</th>
                                            <th style="text-align:center;">Gratificacion</th>
                                            <th style="text-align:center;">Accion</th>
                                        </tr>
                                    </thead>
                                    <tbody id="show_datos" class="tabla2">

                                    </tbody>
                                </table>
                                <div class="form-group col-sm-10" >
                                </div> 
                                <div class="form-group col-sm-2" >
                                    <strong><h4 id="total"></h4></strong>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            <div class="row">

            </div>

        
  
<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Gratificacion</h3>
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
                    <label class="col-md-2 col-form-label">Cantidad del Bono:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_bono" id="cantidad_bono" class="form-control" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fecha de Aplicacion:</label>
                    <div class="col-md-10">
                        <input type="date" name="fecha_bono" id="fecha_bono" class="form-control" placeholder="0.00">
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>


                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Observacion del Bono:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control" id="observacion_bono" name="observacion_bono"></textarea>
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
<!--MODAL PARA CONFIRMAR BONOS-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Eliminar Gratificacion</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seleccione que gratificaciones eliminar?</strong>
                    <div id="check_bono" name="check_bono">
                         
                    </div>
                    <div id="validacion_delete" style="color:red"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_delete" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
 
<!--FIN MODAL BONOS-->


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
            var bono=0;
            var j = 0;

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('bono/empleados_bono')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                   
                    console.log(data);

                   $.each(data.empleados,function(key, registro){
                    
                    $('.tabla1').append(
                        '<tr>'+
                                '<td>'+registro.nombre+'</td>'+//Agencia
                                '<td>'+registro.apellido+'</td>'+//nombrePlaza
                                '<td>'+registro.dui+'</td>'+//estado
                                '<td>'+registro.cargo+'</td>'+//agencia
                                '<td>$'+data.gratificacion[j]+'</td>'+//Agencia
                                '<td>'+
                                    '<?php if ($Agregar==1) { ?><a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_empleado+'">Gratificacion</a><?php } ?>'+' '+
                                    '<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Bono/verBonos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+                                    
                                '</td>'+
                                '</tr>'
                        );
                    j++;
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

        function show_bonos(){
            //Se usa para destruir la tabla
            $('#mydata2').dataTable().fnDestroy();
            var total = 0;
            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('bono/totalBonos')?>',
                async : false,
                dataType : 'JSON',
                data : {},
                success : function(data){
                    console.log(data);
                    $.each(data,function(key, registro){

                        $('.tabla2').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+//Agencia
                                '<td>'+registro.nombre+'</td>'+//Agencia
                                '<td>'+registro.apellido+'</td>'+//nombrePlaza
                                '<td>'+registro.dui+'</td>'+//estado
                                '<td>'+registro.cargo+'</td>'+//agencia
                                '<td>$'+registro.cantidad+'</td>'+//agencia
                                '<td>'+
                                '<?php if ($Revisar==1) { ?><a href="<?php echo base_url();?>index.php/Bono/verBonos/'+registro.id_empleado+'" class="btn btn-primary btn-sm">Revisar</a><?php } ?>'+
                                
                                ' <?php if ($Cancelar==1) { ?><a id="eliminar" class="btn btn-danger btn-sm item_eli" data-codigo="'+registro.id_empleado+'">Eliminar</a><?php } ?>'+                                  
                                '</td>'+
                                '</tr>'
                                );
                        total += parseFloat(registro.cantidad);
                    });
                    document.getElementById('total').innerHTML ="Total: $"+total.toFixed(2);
                    $('#mydata2').dataTable({
                        "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                        "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                        "iDisplayLength": 5,
                        "paging":false,
                        "oLanguage": {
                            "sLengthMenu": "Your words here _MENU_ and/or here",
                        },
                        "oLanguage": {
                            "sSearch": "Buscador: "
                        }
                    });
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            

        };

        $('#pag1').on('click',function(){
            //$("#agencia").show();
            $("#agencia_prestamo").removeAttr('disabled');
            show_data();
        });
        //Es la segunda tabla 
        $('#pag2').on('click',function(){
            //$("#agencia").hide();
            $("#agencia_prestamo").attr('disabled','disabled');
            show_bonos();
        });

        //Inicion para llenado de modal
        $('#show_datos').on('click','.item_eli',function(){
            var code   = $(this).data('codigo');
            var nombreAuto=[];
            var j = 0;
            document.getElementById('validacion_delete').innerHTML = '';

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('bono/bonoEmpleados')?>",
                dataType : "JSON",
                data : {code:code},
                success: function(data){
                    console.log(data);
                    for (i = 0; i <= data.autorizacion.length - 1; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }
                    $("#check_bono").empty();
                    $.each(data.bono,function(key, registro) {
                        $("#check_bono").append(
                            '<div class="checkbox">'+
                            '<label>'+
                            '<input type="checkbox" id="check_bono" value="'+registro.id_bono+'">'+
                            '<span class="cr"><i class="cr-icon glyphicon glyphicon-remove"></i></span><b>$'+
                            registro.cantidad+'</b> asignado por <b>'+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</b>'+
                            '</label>'+
                            '</div>'
                        );
                        j++;
                    });
                    
                $('#Modal_Delete').modal('show');
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });
        });//fin llanado de modal

        //update record to database
         $('#btn_delete').on('click',function(){
            var bono=[];

            //Trae la informacion de los check que estan seleccionados
            $('#check_bono:checked').each(
                function(){
                    //ingresamos los id de los bonos a un arreglo
                    bono.push($(this).val());
                }
            );

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('bono/deleteBono')?>",
                dataType : "JSON",
                data : {bono:bono},
                success: function(data){
                    if (data==null){  
                        document.getElementById('validacion_delete').innerHTML = '';
                        this.disabled=false;
                        location.reload();
                    }else{ 
                        document.getElementById('validacion_delete').innerHTML = '';
                            for (i = 0; i <= data.length-1; i++) {
                                document.getElementById('validacion_delete').innerHTML += data[i]; 
                            }
                    }
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });

        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
           var code = $(this).data('codigo');
           document.getElementById('validacion').innerHTML = '';
           document.getElementById('validacion2').innerHTML = '';
           document.getElementById('validacion3').innerHTML = '';
            $('#Modal_add').modal('show');
            $('[name="code_user"]').val(code);
            $('[name="cantidad_bono"]').val("");
            $('[name="observacion_bono"]').val("");
            $('[name="fecha_bono"]').val("");
            
        });
       
         //Save Plazas
         $('#btn_save').on('click',function(){
            
            var code = $('#code_user').val();
            var cantidad_bono = $('#cantidad_bono').val();
            var observacion_bono = $('#observacion_bono').val();
            var fecha_bono = $('#fecha_bono').val();
            var autorizado = $('#user').val();
            var bono_estado = 2;      //se realizo el cambio para las gratificacion


                $.ajax({
                type : "POST",
                url  : "<?php echo site_url('bono/saveBono')?>",
                dataType : "JSON",
                data : {code:code,cantidad_bono:cantidad_bono,observacion_bono:observacion_bono,fecha_bono:fecha_bono,autorizado:autorizado,bono_estado:bono_estado},
                success: function(data){
                    console.log(data);
                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';
                         $('[name="code_user"]').val("");
                         $('[name="cantidad_bono"]').val("");
                         $('[name="observacion_bono"]').val("");
                         $('[name="fecha_bono"]').val("");
                         $('[name="bono_estado"]').val("");             //se agrego estado

                         alert("El ingreso se realizo con Exito");
                         //$("#Modal_Add").modal('toggle');
                         $("#Modal_Add").modal('toggle');
                         show_data();
                         
                    }else{
                        //alert('Entro');
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad de las Gratificaciones";
                                
                            }else if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Debe de Ingresar la Cantidad de las Gratificaciones en Forma Correcta (0.00)";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2').innerHTML += "Solo se permiten un maximo de 200 carracteres (cuentan los espacios)";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion3').innerHTML += "Debe de ingresar la fecha de aplicacion";

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

          $('#btn_imprimir_bonos').on('click',function(){
          var agencia= $('#agencia_prestamo').val();
          window.location.href = '<?php echo site_url('Bono/reporte_bonos/')?>'+agencia;    
          });//fin de la funcion crear horas extras 
</script>
</body>

</html>