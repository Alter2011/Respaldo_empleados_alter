        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Liquidaciones de empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">

                    <?php if($aprobar == 1){ ?>
                        <div class="form-row" id="reporte">
                            <div class="form-group col-md-2">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_liqui" id="empresa_liqui" class="form-control">
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

                        <div class="form-row" id="reporte">

                            <div class="form-group col-md-2">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_liqui" id="agencia_liqui" class="form-control">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte4">
                            <div class="form-group col-md-2">
                                <label for="inputState">Liquidacion</label>
                                <select class="form-control" name="tipo_cesantia" id="tipo_cesantia" class="form-control">
                                    <option value="0">Todas</option>
                                    <option value="1">Sin cesantía</option>
                                    <option value="2">Con cesantía</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row" id="reporte5">
                            <div class="form-group col-md-2">
                                <center><a id="filtrar" class="btn btn-primary btn-sm item_filtrar" style="margin-top: 23px;">Aceptar</a></center>
                            </div>
                        </div>

                    <?php }else{ ?>
                        <input type="hidden" name="agencia_liqui" id="agencia_liqui" value="<?php echo ($_SESSION['login']['agencia']); ?>">
                    <?php } ?>

                        <div class="col-sm-1">&nbsp;</div>
                        <div class="col-sm-10">
                            <?php
                            if (isset($_SESSION['aprobar'][0])) {?>
                            <center>
                                <div id="validacion_user" class="alert alert-info aprobar" role="alert" style="color:blue">
                                    <?php echo $_SESSION['aprobar'][0];?>
                                            
                                </div>
                            </center>
                            <?php }else if(isset($_SESSION['validar'][0])){ ?> 
                                <center>
                                    <div id="validacion_user" class="alert alert-info aprobar" role="alert" style="color:blue">
                                        <?php echo $_SESSION['validar'][0];?>
                                                
                                    </div>
                                </center>
                            <?php }else{ ?> 
                                <center>
                                    <div id="validacion_user" style="color:red"></div>
                                </center>
                            <?php } ?>
                        </div>

                            <table class="table table-bordered" id="mydata" >
                                <thead>
                                    <tr class="success">
                                        <th style="text-align:center;">Agencia</th> 
                                        <th style="text-align:center;">Empresa</th> 
                                        <th style="text-align:center;">Nombre</th> 
                                        <th style="text-align:center;">Apellido</th> 
                                        <th style="text-align:center;">DUI</th> 
                                        <th style="text-align:center;">Fecha Fin</th> 
                                        <th style="text-align:center;">Accion</th> 
                                    </tr>
                                </thead>
                                <tbody class="tabla1">
                                                  
                                </tbody> 
                            </table>
                        
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
    setTimeout(function(){
        $(".aprobar").fadeOut(1500);
    },3000);

    show_data();
    $('.item_filtrar').on('click',function(){
        show_data();
    });
    function show_data(){
        var empresa_liqui = $('#empresa_liqui').children(":selected").attr("value");
        if(empresa_liqui == undefined){
            empresa_liqui = 'todas';
        }
        var agencia_liqui = $('#agencia_liqui').children(":selected").attr("value");
        if(agencia_liqui == undefined){
            agencia_liqui = $('#agencia_liqui').val();
        }
        var tipo_cesantia = $('#tipo_cesantia').val();
        console.log(tipo_cesantia);
        $('#mydata').dataTable().fnDestroy();
        $('.tabla1').empty()
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Liquidacion/ruptura_laboral')?>',
            async : false,
            dataType : 'JSON',
            data : {empresa_liqui:empresa_liqui,agencia_liqui:agencia_liqui,tipo_cesantia:tipo_cesantia},
            success : function(data){
                console.log(data);
                $.each(data,function(key, registro){
                $('.tabla1').append(
                    '<tr>'+
                        '<td>'+registro.agencia+'</td>'+//Agencia
                        '<td>'+registro.nombre_empresa+'</td>'+//Agencia
                        '<td>'+registro.nombre+'</td>'+//nombrePlaza
                        '<td>'+registro.apellido+'</td>'+//nombrePlaza
                        '<td>'+registro.dui+'</td>'+//nombrePlaza
                        '<td>'+registro.fecha_fin+'</td>'+//nombrePlaza
                        '<td style="text-align:center;">'+
                            '<a href="<?php echo base_url();?>index.php/Liquidacion/revisar_empleado/'+registro.id_contrato+'" class="btn btn-default btn-sm item_activar">'+
                                '<span class="glyphicon glyphicon-phone"></span> Calcular'+
                            '</a>'+
                            ' <a href="<?php echo base_url();?>index.php/Contratacion/contrato/'+registro.id_empleado+'" class="btn btn-success btn-sm">'+
                            '<span class="glyphicon glyphicon-file"></span> Ver Contrato</a>'+ 

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

        agencia();
        $("#empresa_liqui").change(function(){
            agencia();
        });
        function agencia(){
            var empresa = $('#empresa_liqui').children(":selected").attr("value");
            $("#agencia_liqui").empty();
            if(empresa != 'todas'){
                $("#agencia_liqui").removeAttr('disabled');
                $.ajax({
                        type : "POST",
                        url  : "<?php echo site_url('Contratacion/agencias_maternidad')?>",
                        dataType : "JSON",
                        data : {empresa:empresa},
                        success: function(data){
                        
                            $("#agencia_liqui").append('<option id="todas" value="todas">Todas</option>');

                            $.each(data.agencia,function(key, registro) {

                                 $("#agencia_liqui").append('<option id='+registro.id_agencia+' value='+registro.id_agencia+'>'+registro.agencia+'</option>');
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
                $("#agencia_liqui").append('<option id="todas" value="todas">Todas</option>');
                $("#agencia_liqui").attr('disabled','disabled');
            }

         };
});//Fin jQuery
</script>
</body>


</html>