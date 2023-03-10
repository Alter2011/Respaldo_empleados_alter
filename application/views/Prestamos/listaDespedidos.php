        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Prestamos de Empleados Despedidos/Renuncia</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Prestamos Personales</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Prestamos Internos</a></li>
                        <li><a data-toggle="tab" href="#menu2" id="pag3">Descuentos</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_per" id="empresa_per" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencias</label>
                                <select class="form-control" name="agencia_per" id="agencia_per" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-bordered" id="mydata" >
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Agencia</th> 
                                        <th style="text-align:center;">Empresa</th>
                                        <th style="text-align:center;">Nombre</th> 
                                        <th style="text-align:center;">Apellido</th> 
                                        <th style="text-align:center;">DUI</th> 
                                        <th style="text-align:center;">Accion</th> 
                                    </tr>
                                </thead>
                                <tbody class="tabla1">
                                                  
                                </tbody> 
                            </table>
                        
                    </div>
                    <div id="menu1" class="tab-pane fade"><br><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_int" id="empresa_int" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencias</label>
                                <select class="form-control" name="agencia_int" id="agencia_int" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar2" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>


                        <table class="table table-bordered" id="mydata2" >
                            <thead>
                                <tr class="success">
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Empresa</th>
                                    <th style="text-align:center;">Nombre</th> 
                                    <th style="text-align:center;">Apellido</th> 
                                    <th style="text-align:center;">DUI</th> 
                                    <th style="text-align:center;">Accion</th> 
                                </tr>
                            </thead>
                            <tbody class="tabla2">
                                              
                            </tbody> 
                        </table>
                        
                    </div>

                    <div id="menu2" class="tab-pane fade"><br><br>
                        <div class="form-row" id="reporte">
                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_des" id="empresa_des" class="form-control">
                                    <option value="todas">Todas</option>
                                        <?php
                                        $i=0;
                                            foreach($empresa as $a){
                                                    
                                        ?>
                                            <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                </select>
                                
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Agencias</label>
                                <select class="form-control" name="agencia_des" id="agencia_des" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar3" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                          <table class="table table-bordered" id="mydata3" >
                            <thead>
                                <tr class="success">
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Empresa</th>
                                    <th style="text-align:center;">Nombre</th> 
                                    <th style="text-align:center;">Apellido</th> 
                                    <th style="text-align:center;">DUI</th> 
                                    <th style="text-align:center;">Accion</th> 
                                </tr>
                            </thead>
                            <tbody class="tabla3">
                                              
                            </tbody> 
                        </table>
                    </div>

                </div>
                </div>
                </div><!--Fin <div class="col-sm-12">-->
            </div><!--Fin <div class="row">-->

            <div class="row" id="row">

            </div>
    
            </div>
        </div>
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){
        show_data();
        $('.item_filtrar').on('click',function(){
            show_data();
        });
        function show_data(){
            var empresa_per = $('#empresa_per').children(":selected").attr("value");
            var agencia_per = $('#agencia_per').children(":selected").attr("value");
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/lista_empleados')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa_per:empresa_per,agencia_per:agencia_per},
                success : function(data){

                   $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//Agencia
                            '<td>'+registro.nombre+'</td>'+//nombrePlaza
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//nombrePlaza
                            '<td style="text-align:center;">'+
                                '<a href="<?php echo base_url();?>index.php/PrestamosPersonales/verPrestamos/'+registro.id_empleado+'" class="btn btn-success btn-sm item_activar">'+
                                '<span class="glyphicon glyphicon-search"></span> Revisar</a>'+
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
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }

        agenciaPer();
        $("#empresa_per").change(function(){
            agenciaPer();
        });
        function agenciaPer(){
            var empresa = $('#empresa_per').children(":selected").attr("value");
            $("#agencia_per").empty();
            if(empresa != 'todas'){
                $("#agencia_per").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_per").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_per").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });

                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_per").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_per").attr('disabled','disabled');
            }

         };
         
         $('#pag2').on('click',function(){
            show_data2();
            agenciaInt();
         });
         $('.item_filtrar2').on('click',function(){
            show_data2();
        });
         function show_data2(){
            var empresa_int = $('#empresa_int').children(":selected").attr("value");
            var agencia_int = $('#agencia_int').children(":selected").attr("value");
            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();

            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/listar_internos')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa_int:empresa_int,agencia_int:agencia_int},
                success : function(data){

                   $.each(data,function(key, registro){
                    $('.tabla2').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//Agencia
                            '<td>'+registro.nombre+'</td>'+//nombrePlaza
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//nombrePlaza
                            '<td style="text-align:center;">'+
                                '<a href="<?php echo base_url();?>index.php/Prestamo/verPrestamo/'+registro.id_empleado+'" class="btn btn-success btn-sm item_activar">'+
                                '<span class="glyphicon glyphicon-search"></span> Revisar</a>'+
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
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }


        $("#empresa_int").change(function(){
            agenciaInt();
        });
        function agenciaInt(){
            var empresa = $('#empresa_int').children(":selected").attr("value");
            $("#agencia_int").empty();
            if(empresa != 'todas'){
                $("#agencia_int").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_int").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_int").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });

                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_int").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_int").attr('disabled','disabled');
            }

         };
         agencia_des();
        $("#empresa_des").change(function(){
            agencia_des();
        });
        function agencia_des(){
            var empresa = $('#empresa_des').children(":selected").attr("value");
            var agencia = $('#agencia_des').children(":selected").attr("value");


            $("#agencia_des").empty();
            if(empresa != 'todas'){
                $("#agencia_des").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa, agencia:agencia},
                        success: function(data){
                        
                            $("#agencia_des").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_des").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
                            });

                        },  
                        error: function(data){
                            var a =JSON.stringify(data['responseText']);
                            alert(a);
                            this.disabled=false;
                        }
                });
                return false;
            }else{
                $("#agencia_des").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_des").attr('disabled','disabled');
            }

         };

             $('#pag3').on('click',function(){
            show_data3();
            agencia_des();
         });
         $('.item_filtrar3').on('click',function(){
            show_data3();
        });
         function show_data3(){
            var empresa_des = $('#empresa_des').children(":selected").attr("value");
            var agencia_des = $('#agencia_des').children(":selected").attr("value");
            //Se usa para destruir la tabla 
            $('#mydata3').dataTable().fnDestroy();

            $('.tabla3').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Descuentos/lista_descuentos')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa_des:empresa_des,agencia_des:agencia_des},
                success : function(data){

                   $.each(data,function(key, registro){
                    $('.tabla3').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre_empresa+'</td>'+//Agencia
                            '<td>'+registro.nombre+'</td>'+//nombrePlaza
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//nombrePlaza
                            '<td style="text-align:center;">'+
                                '<a href="<?php echo base_url();?>index.php/Descuentos_herramientas/verDescuentos/'+registro.id_empleado+'" class="btn btn-success btn-sm item_activar">'+
                                '<span class="glyphicon glyphicon-search"></span> Revisar</a>'+
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
             $('#mydata3').dataTable({
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
                "bInfo" : false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }


    });//Fin jQuery
</script>
</body>


</html>