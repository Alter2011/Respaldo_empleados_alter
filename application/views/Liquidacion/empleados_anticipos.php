<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Anticipos de Prestaciones</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">

                            <div class="form-group col-md-3">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_anticipo" id="agencia_anticipo" class="form-control">
                                    <!--<option value="todas">Todas</option>-->
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
                            <th style="text-align:center;" WIDTH="120">Anticipo</th>
                            <th style="text-align:center;">Accion</th>
                        </tr>
                    </thead>
                    <tbody><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

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
            <h3 class="modal-title" id="exampleModalLabel">Agregar Anticipo</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="contrato_user" id="contrato_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>

                <div id="validacion1" style="color:red"></div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Anticipo:</label>
                    <div class="col-md-10">
                        <input type="text" name="anticipo_prestacion" id="anticipo_prestacion" class="form-control" placeholder="0.00">
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Fechas de aplicacion:</label>
                    <div class="col-md-10">
                        <input type="date" name="fecha_aplicacion" id="fecha_aplicacion" class="form-control" value="<?php echo date('Y-m-d'); ?>">
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

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_anticipo').change(function(){
            show_data();
        });
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_anticipo = $('#agencia_anticipo').children(":selected").attr("id");
            if(agencia_anticipo == null){
                agencia_anticipo = $('#agencia_anticipo').val();
            }
            var i = 0;

            $('tbody').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/empleados_anticipo')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_anticipo:agencia_anticipo},
                success : function(data){
                    console.log(data);
                   $.each(data.datos,function(key, registro){
                    $('tbody').append(
                        '<tr>'+
                            '<td>'+registro.nombre+'</td>'+//Agencia
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//estado
                            '<td>'+registro.cargo+'</td>'+//estado
                            '<td WIDTH="120">$'+parseFloat(data.cantidad[i]).toFixed(2)+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                '<a href="#" data-toggle="modal" data-target="#Modal_Add" class="btn btn-success btn-sm item_add" data-codigo="'+registro.id_contrato+'" onclick="codigo(this)"><span class="glyphicon glyphicon-plus-sign"></span> Ingresar Anticipo</a> '+
                                '<a href="<?php echo base_url();?>index.php/Liquidacion/anticiposPrestaciones/'+registro.id_empleado+'" class="btn btn-primary btn-sm"><span class="fa fa-clone"></span> Revisar</a>'+
                                '</a> '+
                            '</td>'+
                        '</tr>'
                        );
                    i++;
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
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }

        $('.item_add').on('click',function(){
            var d = new Date();
            var dia = 0;
            if(d.getDate() >= 1 && d.getDate() <= 9){
                dia = '0'+d.getDate();
            }else{
                dia = d.getDate();
            }
            var fecha = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + dia;
            console.log(fecha);
            $('[name="fecha_aplicacion"]').val(fecha);
            $('[name="anticipo_prestacion"]').val("");
        });
        
         //Save Plazas
         $('#btn_save').on('click',function(){
            var code = $('#contrato_user').val();
            var anticipo = $('#anticipo_prestacion').val();
            var fecha = $('#fecha_aplicacion').val();
            
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/saveAnticipoG')?>",
                dataType : "JSON",
                data : {code:code,anticipo:anticipo,fecha:fecha},
                success: function(data){
                    console.log(data);

                    if(data == null){
                        document.getElementById('validacion').innerHTML = '';
                        
                        $('[name="salario_inicio"]').val("");
            
                        Swal.fire(
                          'El anticipo de prestacion se ingreso con exito!',
                          '',
                          'success'
                        )
                        $("#Modal_Add").modal('toggle');
                        show_data();
                    }else{
                        document.getElementById('validacion').innerHTML = '';
                        document.getElementById('validacion1').innerHTML = '';
                        document.getElementById('validacion2').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion').innerHTML += "Debe de ingresar el anticipo";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion').innerHTML += "Debe de ingresar el anticipo de forma correcta 0.00";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion').innerHTML += "El anticipo debe de ser mayor a cero";
                            }
                            if(data[i] == 4){
                                document.getElementById('validacion2').innerHTML += "Tiene que ingresar la fecha de aplicacion";
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
    
    function codigo(boton){
        var code = boton.dataset.codigo;
        
        document.getElementById('validacion').innerHTML = '';
        document.getElementById('validacion1').innerHTML = '';
        document.getElementById('validacion2').innerHTML = '';
        $('#Modal_add').modal('show');
        $('[name="contrato_user"]').val(code);
    }

</script>
</body>
</html>