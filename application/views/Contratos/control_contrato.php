        <input type="hidden" name="salario" id="salario" value="<?php echo  $salario; ?>" readonly>
        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Control de Contrato</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Cesantía</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Control de contratos</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_cesa" id="empresa_cesa" class="form-control">
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
                                <select class="form-control" name="agencia_cesa" id="agencia_cesa" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes</label>
                                <input type="month" class="form-control" id="mes_cesa" name="mes_cesa">
                            </div>
                        </div>

                       

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                            <table class="table table-bordered" id="mydata" >
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">Agencia</th> 
                                        <th style="text-align:center;">Nombre Empleado</th> 
                                        <th style="text-align:center;">Fecha de Inicio</th> 
                                        <th style="text-align:center;">Autorizante</th>
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
                                <select class="form-control" name="control_empresa" id="control_empresa" class="form-control">
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
                                <select class="form-control" name="control_agencia" id="control_agencia" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes</label>
                                <input type="month" class="form-control" id="control_mes" name="control_mes">
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar2" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>


                        <table class="table table-bordered" id="mydata2" >
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombre Empleado</th> 
                                    <th style="text-align:center;">Fecha de Inicio</th> 
                                    <th style="text-align:center;">Autorizante</th>
                                    <th style="text-align:center;">Estado</th>
                                    <th style="text-align:center;">Cant Contratos</th>
                                    <th style="text-align:center;">Categoria</th>
                                    <th style="text-align:center;">Sueldo</th>
                                    <th style="text-align:center;">Accion</th> 
                                </tr>
                            </thead>
                            <tbody class="tabla2">
                                              
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

<!--MODAL RECHAZAR-->
<form>
    <div class="modal fade" id="Modal_Activar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel"><strong>Activar Contrato</strong></h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                 <div class="modal-body">
                    ¿Seguro/a que Desea Activar Este Contrato?
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_contrato" id="code_contrato" class="form-control" readonly>
                 <input type="hidden" name="code_cesantia" id="code_cesantia" class="form-control" readonly >
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_activar" class="btn btn-primary">Activar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL RECHAZAR-->

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){

        show_data();
        $('#pag1').on('click',function(){
            show_data();
         });
        $('.item_filtrar').on('click',function(){
            show_data();
        });

        function show_data(){
            var estado = 1;
            var empresa_cesa = $('#empresa_cesa').children(":selected").attr("value");
            var agencia_cesa = $('#agencia_cesa').children(":selected").attr("value");
            var mes_cesa = $('#mes_cesa').val();
            var nombreAuto=[];
            var j = 0;
            
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contratacion/personas_cesantia')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa_cesa:empresa_cesa,agencia_cesa:agencia_cesa,mes_cesa:mes_cesa,estado:estado},
                success : function(data){
                    for (i = 0; i < data.autorizacion.length; i++) {
                        nombreAuto[i] = data.autorizacion[i];
                    }
                    console.log(data);
                   $.each(data.cesantia,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.fecha_inicio+'</td>'+//estado
                            '<td>'+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                '<a data-toggle="modal" id="'+registro.id_control_contrato+'" class="btn btn-default btn-sm item_activar" data-id_control="'+registro.id_control_contrato+'" data-id_contrato="'+registro.id_contrato+'">'+
                                '<span class="glyphicon glyphicon-ok"></span> Activar</a>'+
                                ' <a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success btn-sm">'+
                                '<span class="glyphicon glyphicon-file"></span> Ver contrato</a>'+ 

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
                 "order": [[ 4, "asc" ]],
                "paging":false,
                "bInfo" : false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }
        agencia();
        $("#empresa_cesa").change(function(){
            agencia();
        });
        function agencia(){
            var empresa = $('#empresa_cesa').children(":selected").attr("value");
            $("#agencia_cesa").empty();
            if(empresa != 'todas'){
                $("#agencia_cesa").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_cesa").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_cesa").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_cesa").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_cesa").attr('disabled','disabled');
            }

         };

         $('.tabla1').on('click','.item_activar',function(){
       //$('#activar').on('click',function()
            var id_control   = $(this).data('id_control');
            var code_contrato   = $(this).data('id_contrato');
            $('#Modal_Activar').modal('show');
            $('[name="code_cesantia"]').val(id_control);
            $('[name="code_contrato"]').val(code_contrato);
        });

         //Metodo para activar
        $('#btn_activar').on('click',function(){
            var code_cesantia = $('#code_cesantia').val();
            var code_contrato = $('#code_contrato').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/actContrato')?>",
                dataType : "JSON",
                data : {code_contrato:code_contrato,code_cesantia:code_cesantia},
    
                success: function(data){
                    $('[name="code_cesantia"]').val("");
                    $('[name="code_contrato"]').val("");
                    $('#Modal_Activar').modal('toggle');
                    $('.modal-backdrop').remove();
                    location.reload();

                    show_data();
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo activar

        $('#pag2').on('click',function(){
            agencia_control();
            control_contrato();
        });

        $("#control_empresa").change(function(){
            agencia_control();
        });

        function agencia_control(){
            var empresa = $('#control_empresa').children(":selected").attr("value");
            $("#control_agencia").empty();
            if(empresa != 'todas'){
                $("#control_agencia").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#control_agencia").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#control_agencia").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#control_agencia").append('<option id="todas" value="todas">Todas</option>');
                $("#control_agencia").attr('disabled','disabled');
            }
        };
        $('.item_filtrar2').on('click',function(){
            control_contrato();
        });

        function control_contrato(){
            var estado = 0;
            var empresa_cesa = $('#control_empresa').children(":selected").attr("value");
            var agencia_cesa = $('#control_agencia').children(":selected").attr("value");
            var mes_cesa = $('#control_mes').val();
            var salario = $('#salario').val();
            var j = 0;
            var texto = '';
            var sueldo = 0;
            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();

            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contratacion/personas_cesantia')?>',
                async : false,
                dataType : 'JSON',
                data : {empresa_cesa:empresa_cesa,agencia_cesa:agencia_cesa,mes_cesa:mes_cesa,estado:estado},
                success : function(data){
                   $.each(data.cesantia,function(key, registro){
                    if(registro.estado_contrato == 2 || registro.estado_contrato == 1 || registro.estado_contrato == 5 || registro.estado_contrato == 7 || registro.estado_contrato == 8){
                        texto = '<div class="alert alert-success" role="alert">'+registro.descripcion+'</div>';
                    }else if(registro.estado_contrato == 6){
                        texto = '<div class="alert alert-warning" role="alert">'+registro.descripcion+'</div>';
                    }else if(registro.estado_contrato == 9){
                        texto = '<div class="alert alert-primary" role="alert">'+registro.descripcion+'</div>';
                    }else if(registro.estado_contrato == 10){
                        texto = '<div class="alert alert-info" role="alert">'+registro.descripcion+'</div>';
                    }else if(registro.estado_contrato == 11){
                        texto = '<div class="alert alert-danger" role="alert">'+registro.descripcion+'</div>';
                    }
                    sueldo = 0;
                    if(salario == 1 || (salario == 0 && registro.id_agencia != '00')){
                        sueldo = registro.Sbase;
                    }

                    $('.tabla2').append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.fecha_inicio+'</td>'+//estado
                            '<td>'+data.autorizacion[j].nombre+' '+data.autorizacion[j].apellido+'</td>'+//agencia
                            '<td>'+texto+'</td>'+
                            '<td>'+data.cantidad[j].cantidad+'</td>'+//agencia
                            '<td>'+registro.categoria+'</td>'+
                            '<td>$'+sueldo+'</td>'+
                            '<td style="text-align:center;">'+
                                ' <a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success btn-sm">'+
                                '<span class="glyphicon glyphicon-file"></span> Ver contrato</a>'+ 

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
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }
        
    });//Fin jQuery
</script>
</body>


</html>