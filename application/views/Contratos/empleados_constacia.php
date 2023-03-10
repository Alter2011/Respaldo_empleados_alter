        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Constacias Laborales y Salariales</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados Activos</a></li>
                                <li><a data-toggle="tab" href="#menu1" id="pag2">Empleados Inactivos</a></li>
                            </ul>

                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active"><br>

                                     <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_constacia" id="agencia_constacia" class="form-control">
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
                               
                                    <input type="hidden" name="perfin_user" id="perfin_user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>
                                    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            
                        <table class="table table-bordered" id="mydata">
                            <thead>
                                <tr class="success">
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" class="tabla1"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>
                        </div>
                        <div id="menu1" class="tab-pane fade"><br>
                            <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_inac" id="agencia_inac" class="form-control">
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
                               
                                    <input type="hidden" name="perfin_user" id="perfin_user" value="<?php echo ($_SESSION['login']['perfil']); ?>" readonly>
                                    <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            
                        <table class="table table-bordered" id="mydata2">
                            <thead>
                                <tr class="danger">
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Apellidos</th>
                                    <th style="text-align:center;">DUI</th>
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data" class="tabla2"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                        </table>
                        </div>
                    </div>
                    </div>
                    </div>
            </div>
            </div>
            <div class="row">

            </div>
            </div>
        </div>
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
       
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_constacia').change(function(){
            show_data();
        });
        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_constacia = $('#agencia_constacia').children(":selected").attr("id");
            if(agencia_constacia == null){
                agencia_constacia = $('#agencia_constacia').val();
            }
            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('contratacion/empleadosContancia')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_constacia:agencia_constacia},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.nombre+'</td>'+//Agencia
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//estado
                            '<td>'+registro.cargo+'</td>'+//agencia
                            '<td style="text-align:right;">'+
                                '<a href="<?php echo base_url();?>index.php/Contratacion/constaciaLaboral/'+registro.id_empleado+'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check"></span> Constacia Laboral</a>'+' '+
                                '<a href="<?php echo base_url();?>index.php/Contratacion/constanciaSalarial/'+registro.id_empleado+'" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-usd"></span> Constacia Salarial</a>'+                                    
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
                "order": [[ 4, "asc" ]],
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        };

        $('#pag2').on('click',function(){
            constancia_terminada();
        });
        
        function constancia_terminada(){
            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();
            
            var agencia_constacia = $('#agencia_inac').children(":selected").attr("id");
            if(agencia_constacia == null){
                agencia_constacia = $('#agencia_inac').val();
            }
            var estado = 1;
            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('contratacion/empleadosContancia')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_constacia:agencia_constacia,estado:estado},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('.tabla2').append(
                        '<tr>'+
                            '<td>'+registro.nombre+'</td>'+//Agencia
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//estado
                            '<td>'+registro.cargo+'</td>'+//agencia
                            '<td style="text-align:right;">'+
                                '<a href="<?php echo base_url();?>index.php/Contratacion/constaciaLaboralTer/'+registro.id_empleado+'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-check"></span> Constacia Laboral</a>'+' '+
                                                             
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
             $('#mydata2').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "order": [[ 4, "asc" ]],
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        };
    });
</script>
</body>

</html>