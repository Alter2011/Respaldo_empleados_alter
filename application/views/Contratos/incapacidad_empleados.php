<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Incapacidades para Empleados</h2>
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
                                <select class="form-control" name="agencia_incapacidad" id="agencia_incapacidad" class="form-control">
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

                                <input type="hidden" name="agencia_incapacidad" id="agencia_incapacidad" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                            <?php } ?>
                            
                            <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                        </div>
                    </div>
                </nav>
                <table class="table table-striped table-bordered" id="mydata">
                    <thead>
                        <tr class="success">
                            <th style="text-align:center;">Nombres</th>      
                            <th style="text-align:center;">Apellidos</th>
                            <th style="text-align:center;">DUI</th>
                            <th style="text-align:center;">Cargo</th>
                            <th style="text-align:center;">Accion</th>
                        </tr>
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
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Incapacidad</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div style="color:red">Ingrese cuidadosamente las fechas a ingresar</div><br>
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="contrato_user" id="contrato_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div id="validacion1" style="color:red"></div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Tipo:</label>
                    <div class="col-md-10">
                        <select class="form-control" id="tipo_incapacidad" name="tipo_incapacidad">
                            <option value="1">Enfermedad común</option>
                            <option value="2">Accidente común</option>
                            <option value="3">Accidente trabajo</option>
                            <option value="4">Enfermedad profesional</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Desde:</label>
                    <div class="col-md-10">
                        <input type="date" name="desde" id="desde" class="form-control">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta:</label>
                    <div class="col-md-10">
                        <input type="date" name="hasta" id="hasta" class="form-control">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripción:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control" id="descripcion" name="descripcion"></textarea>
                        <div id="validacion3" style="color:red"></div>
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

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        var plazas_edit;
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_incapacidad').change(function(){

            show_data();
        });
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_incapacidad').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_incapacidad').val();
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
                            '<td style="text-align:center;">'+
                                '<?php if ($ingresar==1) { ?>'+
                                '<a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'"><span class="glyphicon glyphicon-plus-sign"></span> Agregar</a>'+
                                '</a><?php } ?>'+' '+'<?php if ($revisar==1) { ?>'+
                                '<a href="<?php echo base_url();?>index.php/Contratacion/regristoIncapacidad/'+registro.id_empleado+'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-folder-open"></span> Historial</a>'+
                                '<?php } ?>'+                                   
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
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }
        //Recupera el id del user
        $('#show_data').on('click','.item_add',function(){ 
            var code = $(this).data('codigo');
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion1').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';
            document.getElementById('validacion3').innerHTML = '';
          
            $('#Modal_add').modal('show');
            $('[name="contrato_user"]').val(code);
            
        });
       
         //Save Plazas
         $('#btn_save').on('click',function(){
            var code = $('#contrato_user').val();
            var user = $('#user').val();
            var tipo_incapacidad = $('#tipo_incapacidad').val();
            var desde = $('#desde').val();
            var hasta = $('#hasta').val();
            var descripcion = $('#descripcion').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/saveIncapacidad')?>",
                dataType : "JSON",
                data : {code:code,user:user,tipo_incapacidad:tipo_incapacidad,desde:desde,hasta:hasta,descripcion:descripcion},
                success: function(data){
                    console.log(data);

                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion1').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        $('[name="desde"]').val("");
                        $('[name="hasta"]').val("");
                        $('[name="descripcion"]').val("");
            
                        Swal.fire(
                          'La incapacidad se ingreso con exito!',
                          '',
                          'success'
                        )
                        setTimeout('document.location.reload()',2000);
                        $("#Modal_Add").modal('toggle');
                        show_data();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion1').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';
                        document.getElementById('validacion3').innerHTML = '';

                        for (i = 0; i <= data.error.length-1; i++){
                            if(data.error[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de ingresar desde cuando aplica la Incapacidad";
                            }
                            if(data.error[i] == 2){
                                document.getElementById('validacion2').innerHTML += "Debe de ingresar hasta cuando aplica ia Incapacidad";
                            }
                            if(data.error[i] == 3){
                                document.getElementById('validacion').innerHTML += "La fecha desde tiene que ser menor a la fecha hasta";
                            }
                            if(data.error[i] == 4){
                                document.getElementById('validacion3').innerHTML += "Debe de ingresar la descripcion de la incapacidad";
                            }
                            if(data.error[i] == 5){
                                document.getElementById('validacion3').innerHTML += "La descripcion no puede ser mayor a 500 carracteres (cuentas los espacios)";
                            }
                        }
                        if(data.mensaje != null){
                            document.getElementById('validacion1').innerHTML += data.mensaje;
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