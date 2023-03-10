        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Maternidad</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Maternidades Activas</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Maternidades Inactivas</a></li>
                    </ul>

                    <div class="tab-content">
                    <div id="home" class="tab-pane fade in active"><br>

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_mate" id="empresa_mate" class="form-control">
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
                                <select class="form-control" name="agencia_mate" id="agencia_mate" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes</label>
                                <input type="month" class="form-control" id="inicio_mate" name="inicio_mate" disabled>
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Tipo Fecha</label>
                                <select class="form-control" name="tipo_fecha" id="tipo_fecha" class="form-control">
                                    <option value="0">Todas</option>
                                    <option value="1">Inicio</option>
                                    <option value="2">Fin</option>
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
                                    <tr>
                                        <th style="text-align:center;">Agencia</th> 
                                        <th style="text-align:center;">Nombre</th> 
                                        <th style="text-align:center;">Fecha de Inicio</th> 
                                        <th style="text-align:center;">Fecha Fin</th>
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
                                <select class="form-control" name="empresa_terminada" id="empresa_terminada" class="form-control">
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
                                <select class="form-control" name="agencia_terminada" id="agencia_terminada" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte3">
                            <div class="form-group col-md-2">
                                <label for="inputState">Mes</label>
                                <input type="month" class="form-control" id="mes_terminada" name="mes_terminada" disabled>
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Tipo Fecha</label>
                                <select class="form-control" name="tipo_terminada" id="tipo_terminada" class="form-control">
                                    <option value="0">Todas</option>
                                    <option value="1">Inicio</option>
                                    <option value="2">Fin</option>
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
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombre</th> 
                                    <th style="text-align:center;">Fecha de Inicio</th> 
                                    <th style="text-align:center;">Fecha Fin</th>
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
                 <input type="hidden" name="code_maternidad" id="code_maternidad" class="form-control" readonly >
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

        $('#tipo_fecha').change(function(){
            var tipo_fecha = $('#tipo_fecha').val();

            if(tipo_fecha == 0){
                $("#inicio_mate").attr('disabled','disabled');
                $('[name="inicio_mate"]').val("");
            }else{
                $("#inicio_mate").removeAttr('disabled');
            }
        });

        function show_data(){
            var estado = 1;
            var empresa_mate = $('#empresa_mate').children(":selected").attr("value");
            var agencia_mate = $('#agencia_mate').children(":selected").attr("value");
            var inicio_mate = $('#inicio_mate').val();
            var tipo_fecha = $('#tipo_fecha').val();
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contratacion/personas_maternido')?>',
                async : false,
                dataType : 'JSON',
                data : {estado:estado,empresa_mate:empresa_mate,agencia_mate:agencia_mate,inicio_mate:inicio_mate,tipo_fecha:tipo_fecha},
                success : function(data){
                    console.log(data);
                   $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr class="'+registro.id_maternidad+'">'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.fecha_inicio+'</td>'+//estado
                            '<td>'+registro.fecha_fin+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                '<a data-toggle="modal" id="'+registro.id_maternidad+'" class="btn btn-default btn-sm item_activar" data-id_maternidad="'+registro.id_maternidad+'" data-id_contrato="'+registro.id_contrato+'">'+
                                '<span class="glyphicon glyphicon-ok"></span> Activar</a>'+
                                ' <a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success btn-sm">'+
                                '<span class="glyphicon glyphicon-file"></span> Ver contrato</a>'+ 

                            '</td>'+
                        '</tr>'
                        );
                    if(registro.estado == 1){
                        $("."+registro.id_maternidad).addClass("info");
                    }else if(registro.estado == 0){
                        //$("."+registro.id_maternidad).addClass("danger");
                        $("#"+registro.id_maternidad).remove();
                    }


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

        $('.tabla1').on('click','.item_activar',function(){
       //$('#activar').on('click',function()
            var code_maternidad   = $(this).data('id_maternidad');
            var code_contrato   = $(this).data('id_contrato');
            $('#Modal_Activar').modal('show');
            $('[name="code_maternidad"]').val(code_maternidad);
            $('[name="code_contrato"]').val(code_contrato);
        });

        //Metodo para activar
        $('#btn_activar').on('click',function(){
            var code_maternidad = $('#code_maternidad').val();
            var code_contrato = $('#code_contrato').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/actContrato')?>",
                dataType : "JSON",
                data : {code_contrato:code_contrato,code_maternidad:code_maternidad},
    
                success: function(data){
                    $('[name="code_maternidad"]').val("");
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

        agencia();
        $("#empresa_mate").change(function(){
            agencia();
        });
        function agencia(){
            var empresa = $('#empresa_mate').children(":selected").attr("value");
            $("#agencia_mate").empty();
            if(empresa != 'todas'){
                $("#agencia_mate").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_mate").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_mate").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_mate").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_mate").attr('disabled','disabled');
            }

         };

        $('#pag2').on('click',function(){
            maternidad_terminad();
            agencia_ter();
         });
        function maternidad_terminad(){
            var estado = 0;
            var empresa_mate = $('#empresa_terminada').children(":selected").attr("value");
            var agencia_mate = $('#agencia_terminada').children(":selected").attr("value");
            var inicio_mate = $('#mes_terminada').val();
            var tipo_fecha = $('#tipo_terminada').val();
            //Se usa para destruir la tabla 
            $('#mydata2').dataTable().fnDestroy();

            $('.tabla2').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Contratacion/personas_maternido')?>',
                async : false,
                dataType : 'JSON',
                data : {estado:estado,empresa_mate:empresa_mate,agencia_mate:agencia_mate,inicio_mate:inicio_mate,tipo_fecha:tipo_fecha},
                success : function(data){
                    console.log(data);
                   $.each(data,function(key, registro){
                    $('.tabla2').append(
                        '<tr class="'+registro.id_maternidad+'">'+
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre+' '+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.fecha_inicio+'</td>'+//estado
                            '<td>'+registro.fecha_fin+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                ' <a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success btn-sm">'+
                                '<span class="glyphicon glyphicon-file"></span> Ver contrato</a>'+ 

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
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });

        }

        $("#empresa_terminada").change(function(){
            agencia_ter();
        });
        function agencia_ter(){
            var empresa = $('#empresa_terminada').children(":selected").attr("value");
            $("#agencia_terminada").empty();
            if(empresa != 'todas'){
                $("#agencia_terminada").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_terminada").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_terminada").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_terminada").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_terminada").attr('disabled','disabled');
            }

         };
    });//Fin jQuery
</script>
</body>


</html>