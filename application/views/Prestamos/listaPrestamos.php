        <input type="hidden" name="permiso" id="permiso" value="<?php echo  $reporte; ?>" readonly>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Estado actual de prestamos</h2>
            </div>
            <div class="row">
                <div class="form-row"  id="reportep">

                    <div class="form-group col-md-2">
                        <label for="inputState">Empresa</label>
                        <select class="form-control" name="empresa_vacacionp" id="empresa_vacacionp" class="form-control">
                            <option value="todo">Todas</option>
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

                <div class="form-row"  id="reportep2">
                    <div class="form-group col-md-2">
                        <label for="inputState">Agencia</label>
                        <select class="form-control" name="agencia_vacacionp" id="agencia_vacacionp" class="form-control">
                            
                        </select>
                        
                        
                    </div>
                </div>

                <div class="form-row"  id="reportep3">
                    <div class="form-group col-md-2">
                        <label for="inputState">Estado de Prestamos</label>
                        <select class="form-control" name="estado_personal" id="estado_personal" class="form-control">
                            <option value="todos">Todos</option>
                            <option value="1">Activos</option>
                            <option value="2">Inactivos</option>
                        </select>
                    </div>
                </div>

            

                <div class="form-row"  id="reportep5">
                    <div class="form-group col-md-2">
                        <center><a id="filtrarp" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                </div>

                <!-- prestamos internos -->
                <div class="form-row" style="display: none;" id="reporte">

                    <div class="form-group col-md-2">
                        <label for="inputState">Empresa</label>
                        <select class="form-control" name="empresa_vacacion" id="empresa_vacacion" class="form-control">
                            <option value="todo">Todas</option>
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

                <div class="form-row" style="display: none;" id="reporte2">
                    <div class="form-group col-md-2">
                        <label for="inputState">Agencia</label>
                        <select class="form-control" name="agencia_vacacion" id="agencia_vacacion" class="form-control">

                        </select>

                        
                    </div>
                </div>

                <div class="form-row" style="display: none;"  id="reporte3">
                    <div class="form-group col-md-2">
                        <label for="inputState">Estado de Prestamos</label>
                        <select class="form-control" name="estado_internos" id="estado_internos" class="form-control">
                            <option value="todos">Todos</option>
                            <option value="1">Activos</option>
                            <option value="2">Inactivos</option>
                        </select>
                    </div>
                </div>

                

                <div class="form-row" style="display: none;" id="reporte5">
                    <div class="form-group col-md-2">
                        <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                </div>

                <!-- orden de descuento -->
                  <div class="form-row" style="display: none;" id="reporteOd">

                    <div class="form-group col-md-2">
                        <label for="inputState">Empresa</label>
                        <select class="form-control" name="empresa_vacacionOd" id="empresa_vacacionOd" class="form-control">
                            <option value="todo">Todas</option>
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

                <div class="form-row" style="display: none;" id="reporteOd2">
                    <div class="form-group col-md-2">
                        <label for="inputState">Agencia</label>
                        <select class="form-control" name="agencia_vacacionOd" id="agencia_vacacionOd" class="form-control">

                        </select>

                        
                    </div>
                </div>

                <div class="form-row" style="display: none;" id="reporteOd3">
                    <div class="form-group col-md-2">
                        <label for="inputState">Estado de Orden</label>
                       <select class="form-control" name="estado_orden" id="estado_orden" class="form-control">
                            <option value="todos">Todos</option>
                            <option value="1">Activos</option>
                            <option value="2">Inactivos</option>
                        </select>
                    </div>
                </div>


                <div class="form-row" style="display: none;" id="reporteOd5">
                    <div class="form-group col-md-2">
                        <center><a id="filtrarOd" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                    </div>
                </div>

            </div>

            <div class="row" id="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                          <?php if($reporte == 1){ ?>
                          <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home" id="pag1">Prestamos personales</a></li>
                            <li><a data-toggle="tab" href="#menu1" id="pag2">Prestamos internos</a></li>
                              <li><a data-toggle="tab" href="#menu2" id="pag3">Ordenes de descuento</a></li>
                          </ul>  
                          <?php } ?>

                          <div class="tab-content">
                            <div id="home" class="tab-pane fade in active"><br>
                                <table class="table table-striped table-bordered" id="mydata">
                                    <thead>
                                        <tr>
                                           <th style="text-align:center;">Agencia</th> 
                                           <th style="text-align:center;">Nombre</th> 
                                           <th style="text-align:center;">Cargo</th> 
                                           <th style="text-align:center;">Monto otorgado</th> 
                                           <th style="text-align:center;">cuota</th> 
                                           <th style="text-align:center;">Saldo</th> 
                                           <th style="text-align:center;">Plazo (Qna.)</th> 
                                           <th style="text-align:center;">Plazo (Meses)</th> 
                                           <th style="text-align:center;">Fecha otorgado</th>
                                           <th style="text-align:center;">Estado empledado</th>
                                           <th style="text-align:center;">Estado</th>
                                           <th style="text-align:center;">acciones</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="tabla1">
                                       
                                    </tbody> 
                                </table>
                            </div>

                            <div id="menu1" class="tab-pane fade"><br>

                                
                                <table class="table table-striped table-bordered" id="mydatos">
                                    <thead>
                                        <tr>
                                           <th style="text-align:center;">Agencia</th> 
                                           <th style="text-align:center;">Nombre</th> 
                                           <th style="text-align:center;">Cargo</th> 
                                           <th style="text-align:center;">Monto otorgado</th> 
                                           <th style="text-align:center;">cuota</th> 
                                           <th style="text-align:center;">Saldo</th> 
                                           <th style="text-align:center;">Plazo (Qna.)</th> 
                                           <th style="text-align:center;">Plazo (Meses)</th> 
                                           <th style="text-align:center;">Fecha otorgado</th>
                                           <th style="text-align:center;">Estado empledado</th>
                                           <th style="text-align:center;">Estado</th>
                                           <th style="text-align:center;">acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tabla2">
                                        
                                    </tbody> 
                                </table>
                            </div>

                            <div id="menu2" class="tab-pane fade"><br>

                                
                                <table class="table table-striped table-bordered" id="ordenDescuento">
                                    <thead>
                                        <tr>
                                           <th style="text-align:center;">Agencia</th> 
                                           <th style="text-align:center;">Nombre</th> 
                                           <th style="text-align:center;">Cargo</th> 
                                           <th style="text-align:center;">cuota</th> 
                                           <th style="text-align:center;">Fecha otorgado</th>
                                           <th style="text-align:center;">Estado</th>
                                           <th style="text-align:center;">acciones</th> 
                                        </tr>
                                    </thead>
                                    <tbody class="tabla3">
                                        
                                    </tbody> 
                                </table>
                            </div>
                             <div class="col-sm-12">
                                <div class="col-sm-10">
                                </div>  
                                <div class="col-sm-2">
                                <input type="button" class="form-control btn btn-primary" name="recoger" id="recoger1" value="Activar/Desactivar" onclick="recogerPe()">
                                
                                <input type="button" style="display: none;" class="form-control btn btn-primary" name="recoger2" id="recoger2" value="Activar/Desactivar" onclick="recoger()">
                                  <input type="button" style="display: none;" class="form-control btn btn-primary" name="recoger3" id="recoger3" value="Activar/Desactivar" onclick="recogerOd()">
                                </div>  
                                
                            </div>
                          </div>

                        </div>
                </div>

            </div>
    
            </div>


        </div>


<!-- Llamar JavaScript -->

<script type="text/javascript">
    function recoger(){
        var checkboxes = document.getElementsByName('cheque');//nombre generico de los check
        var vals = [];


        for (var i=0, n=checkboxes.length;i<n;i++) //propiedad de contar todos los check
        {
            if (checkboxes[i].checked) //solo los que estan chequeado
            {
                vals.push(checkboxes[i].value);

            }
        }
        //if (vals) vals = vals.substring(1);
        if (vals.length==0) {
            alert('Debe seleccionar algun prestamo');
        }else{

                       $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/actualizar_prestamos')?>',
                async : false,
                dataType : 'JSON',
                data : {vals:vals},
                success : function(data){
                     reportePrestamoIn();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
    }
    function recogerPe(){
        var checkboxes = document.getElementsByName('chequep');//nombre generico de los check
        var vals = [];


        for (var i=0, n=checkboxes.length;i<n;i++) //propiedad de contar todos los check
        {
            if (checkboxes[i].checked) //solo los que estan chequeado
            {
                vals.push(checkboxes[i].value);

            }
        }
            console.log(vals);
        //if (vals) vals = vals.substring(1);
        if (vals.length==0) {
            alert('Debe seleccionar algun prestamo');
        }else{

                       $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/actualizar_prestamosp')?>',
                async : false,
                dataType : 'JSON',
                data : {vals:vals},
                success : function(data){
                     reportePrestamoPe();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
    }
     function recogerOd(){
        var checkboxes = document.getElementsByName('chequeOd');//nombre generico de los check
        var vals = [];


        for (var i=0, n=checkboxes.length;i<n;i++) //propiedad de contar todos los check
        {
            if (checkboxes[i].checked) //solo los que estan chequeado
            {
                vals.push(checkboxes[i].value);

            }
        }
            console.log(vals);
        //if (vals) vals = vals.substring(1);
        if (vals.length==0) {
            alert('Debe seleccionar alguna orden de descuento');
        }else{

                       $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/actualizar_odenDesc')?>',
                async : false,
                dataType : 'JSON',
                data : {vals:vals},
                success : function(data){
                     reporteOrdenD();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
        }
    }
        function reportePrestamoIn(){
            var cantidad = 0;
            var sinDes = 0;
            var isss = 0;
            var afp = 0;
            var empresa = $('#empresa_vacacion').children(":selected").attr("value");
            var agencias = $('#agencia_vacacion').children(":selected").attr("value");
            var estado_int = $('#estado_internos').val();


            $('#mydatos').dataTable().fnDestroy();
            
            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/prestamoIn')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencias:agencias,estado_int:estado_int},
                success : function(data){
                   $.each(data,function(key, registro){
                        estado='';
                        if (registro.estado==1) {
                            estado='Activo';
                            texto='<input type="checkbox" name="cheque" class="form-check-input id="cbox1" value="2-'+registro.id_prestamo+'"> <span class="label label-warning">Pausar</span>';
                        }else if(registro.estado==2){
                            estado='Pausado';
                             texto='<input type="checkbox" name="cheque" id="cbox2" value="1-'+registro.id_prestamo+'"> <span class="label label-success">Re activar</span>';
                        }
                        $('.tabla2').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>'+parseFloat(registro.monto_otorgado).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.cuota).toFixed(2)+'</td>'+
                                '<td>'+registro.saldo_actual+'</td>'+
                                '<td>'+registro.plazo_quincena+'</td>'+
                                '<td>'+registro.meses+'</td>'+

                                '<td>'+registro.fecha_otorgado+'</td>'+
                                '<td>'+registro.estado_empleado+'</td>'+
                                '<td>'+estado+'</td>'+
                                '<td>'+
                                texto+
                                '<a href="<?php echo base_url();?>index.php/Prestamo/verPrestamo/'+registro.id_empleado+'" class="btn btn-success btn-sm item_activar" target="_blank">'+
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
             $('#mydatos').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "bAutoWidth": false,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        }
        function reportePrestamoPe(){
            var cantidad = 0;
            var sinDes = 0;
            var isss = 0;
            var afp = 0;
            var empresa = $('#empresa_vacacionp').children(":selected").attr("value");
            var agencias = $('#agencia_vacacionp').children(":selected").attr("value");
            var estado_per = $('#estado_personal').val();


            $('#mydata').dataTable().fnDestroy();
            
            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/prestamoPe')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencias:agencias,estado_per:estado_per},
                success : function(data){
                   $.each(data,function(key, registro){
                        estado='';
                        if (registro.estado==1) {
                            estado='Activo';
                            texto='<input type="checkbox" name="chequep" class="form-check-input id="cbox1" value="2-'+registro.id_prestamo_personal+'"> <span class="label label-warning">Pausar</span>';
                        }else if(registro.estado==2){
                            estado='Pausado';
                             texto='<input type="checkbox" name="chequep" id="cbox2" value="1-'+registro.id_prestamo_personal+'"> <span class="label label-success">Re activar</span>';
                        }
                        $('.tabla1').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>'+parseFloat(registro.monto_otorgado).toFixed(2)+'</td>'+
                                '<td>'+parseFloat(registro.cuota).toFixed(2)+'</td>'+
                                '<td>'+registro.saldo_actual+'</td>'+
                                '<td>'+registro.plazo_quincenas+'</td>'+
                                '<td>'+registro.meses+'</td>'+

                                '<td>'+registro.fecha_otorgado+'</td>'+
                                '<td>'+registro.estado_empleado+'</td>'+
                                '<td>'+
                                estado+
                                '</td>'+
                                '<td>'+
                                texto+
                                '<a href="<?php echo base_url();?>index.php/PrestamosPersonales/verPrestamos/'+registro.id_empleado+'" class="btn btn-success btn-sm item_activar" target="_blank">'+
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
                "paging":false,
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        }
                        function reporteOrdenD(){
            var cantidad = 0;
            var sinDes = 0;
            var isss = 0;
            var afp = 0;
            var empresa = $('#empresa_vacacionOd').children(":selected").attr("value");
            var agencias = $('#agencia_vacacionOd').children(":selected").attr("value");
            var estado_or = $('#estado_orden').val();


            $('#ordenDescuento').dataTable().fnDestroy();
            
            $('.tabla3').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Prestamo/ordenDescuento')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa:empresa,agencias:agencias,estado_or:estado_or},
                success : function(data){
                   $.each(data,function(key, registro){
                        estado='';
                        if (registro.estado==1) {
                            estado='Activo';
                            texto='<input type="checkbox" name="chequeOd" class="form-check-input id="cbox1" value="3-'+registro.id_orden_descuento+'"> <span class="label label-warning">Pausar</span>';
                        }else if(registro.estado==3){
                            estado='Pausado';
                             texto='<input type="checkbox" name="chequeOd" id="cbox2" value="1-'+registro.id_orden_descuento+'"> <span class="label label-success">Re activar</span>';
                        }
                        $('.tabla3').append(
                            '<tr>'+
                                '<td>'+registro.agencia+'</td>'+
                                '<td>'+registro.nombre+' '+registro.apellido+'</td>'+
                                '<td>'+registro.cargo+'</td>'+
                                '<td>'+registro.cuota+'</td>'+

                                '<td>'+registro.fecha_inicio+'</td>'+
                                '<td>'+estado+'</td>'+
                                '<td>'+
                                texto+
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
             $('#ordenDescuento').dataTable({
                "dom": "<'row'<'col-sm-9'l><'col-sm-3'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "aLengthMenu": [[3, 5, 10, -1], [3, 5, 10, "All"]],
                "iDisplayLength": 5,
                "oLanguage": {
                    "sLengthMenu": "Your words here _MENU_ and/or here",
                },
                "paging":false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        }
    $(document).ready(function(){
       reportePrestamoPe();
       var permiso = $('#permiso').val();
        //se usa para cambiar la tabla cada vez que se selecciona una agencia
     
   

          $('#pag3').on('click',function(){
            $("#agencias").hide();
            $("#reporteOd").show();
            $("#reporteOd2").show();
            $("#reporteOd3").show();
            $("#reporteOd5").show();
            $("#recogerOd").show();
            $("#recoger3").show();



            $("#reporte").hide();
            $("#reporte2").hide();
            $("#reporte3").hide();
            $("#reporte5").hide();
            $("#recoger2").hide();


              $("#reportep").hide();
            $("#reportep2").hide();
            $("#reportep3").hide();
            $("#reportep5").hide();
            $("#recoger1").hide();

            reporteOrdenD();
            
        });//fin $('#pag2').on('click',function()
        $('#pag2').on('click',function(){
            $("#agencias").hide();
            $("#reporte").show();
            $("#reporte2").show();
            $("#reporte3").show();
            $("#reporte5").show();
            $("#recoger2").show();


              $("#reportep").hide();
            $("#reportep2").hide();
            $("#reportep3").hide();
            $("#reportep5").hide();
            $("#recoger1").hide();

                $("#reporteOd").hide();
            $("#reporteOd2").hide();
            $("#reporteOd3").hide();
            $("#reporteOd5").hide();
            $("#recogerOd").hide();
            $("#recoger3").hide();


            reportePrestamoIn();
            
        });//fin $('#pag2').on('click',function()
        $('#pag1').on('click',function(){
            $("#agencias").hide();
            $("#reportep").show();
            $("#reportep2").show();
            $("#reportep3").show();
            $("#reportep5").show();
            $("#recoger1").show();


            $("#reporte").hide();
            $("#reporte2").hide();
            $("#reporte3").hide();
            $("#reporte5").hide();
            $("#recoger2").hide();

                     $("#reporteOd").hide();
            $("#reporteOd2").hide();
            $("#reporteOd3").hide();
            $("#reporteOd5").hide();
            $("#recogerOd").hide();
            $("#recoger3").hide();


            reportePrestamoPe();
            
        });
        $('#filtrar').on('click',function(){
            reportePrestamoIn();
            
        });
        $('#filtrarp').on('click',function(){
            reportePrestamoPe();
            
        });
               $('#filtrarOd').on('click',function(){
            reporteOrdenD();
            
        });


        if(permiso == 1){
            agencia();
            agenciap();
            agenciaod();


        }

        $("#empresa_vacacion").change(function(){
            if(permiso == 1){    
                agencia();
            }
        });
        $("#empresa_vacacionp").change(function(){
            if(permiso == 1){    
                agenciap();
            }
        });
        $("#empresa_vacacionOd").change(function(){
            if(permiso == 1){    
                agenciaod();
            }
        });

        function agencia(){
            var empresa = $('#empresa_vacacion').children(":selected").attr("value");
            $("#agencia_vacacion").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia_vacacion").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_vacacion").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_vacacion").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia_vacacion").attr('disabled','disabled');
                $("#agencia_vacacion").append('<option id="todas" value="todas">Todas</option>');
            }

         };

        function agenciap(){
            var empresa = $('#empresa_vacacionp').children(":selected").attr("value");
            $("#agencia_vacacionp").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia_vacacionp").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_vacacionp").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_vacacionp").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia_vacacionp").attr('disabled','disabled');
                $("#agencia_vacacionp").append('<option id="todas" value="todas">Todas</option>');
            }

         };

        function agenciaod(){
            var empresa = $('#empresa_vacacionOd').children(":selected").attr("value");
            $("#agencia_vacacionOd").empty();
            if(empresa != 'todo'){
                //alert(empresa);
            $("#agencia_vacacionOd").removeAttr('disabled');

                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                            $("#agencia_vacacionOd").append(
                                '<option id="todas" value="todas">Todas'+
                                '</option>');
                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_vacacionOd").append(
                                    '<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+''+
                                    '</option>');
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
                $("#agencia_vacacionOd").attr('disabled','disabled');
                $("#agencia_vacacionOd").append('<option id="todas" value="todas">Todas</option>');
            }

         };

    });
</script>
</body>

</html>