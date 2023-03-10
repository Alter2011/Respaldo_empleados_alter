        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Reporte de empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-row" id="reporte">
                        <div class="form-group col-md-3">
                            <label for="inputState">Empresa</label>
                            <select class="form-control" name="empresa_empleados" id="empresa_empleados" class="form-control">
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

                        <div class="form-group col-md-3">
                            <label for="inputState">Fecha inicio</label>
                            <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                    </div>

                    <div class="form-row" id="reporte4">
                        <div class="form-group col-md-3">
                            <label for="inputState">Estado</label>
                            <select class="form-control" name="estado" id="estado" class="form-control">
                                <option value="0">Todos</option>
                                <option value="1">Activo</option>
                                <option value="2">Inactivo</option>
                                <option value="3">Maternidad</option>
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
                                <th style="text-align:center;">Empresa</th> 
                                <th style="text-align:center;">Agencia</th> 
                                <th style="text-align:center;">Nombre</th> 
                                <th style="text-align:center;">Apellido</th> 
                                <th style="text-align:center;">DUI</th> 
                                <th style="text-align:center;">NIT</th> 
                                <th style="text-align:center;">Salario</th> 
                                <th style="text-align:center;">Fecha Inicio</th> 
                                <th style="text-align:center;">Estado</th> 
                            </tr>
                        </thead>
                        <tbody class="tabla1">
                            <?php
                                for ($i=0; $i < count($empleados) ; $i++) {

                                    echo "<tr>";
                                        echo "<td>".$empleados[$i]->nombre_empresa."</td>";
                                        echo "<td>".$empleados[$i]->agencia."</td>";
                                        echo "<td>".$empleados[$i]->nombre."</td>";
                                        echo "<td>".$empleados[$i]->apellido."</td>";
                                        echo "<td>".$empleados[$i]->dui."</td>";
                                        echo "<td>".$empleados[$i]->nit."</td>";
                                        echo "<td>".$empleados[$i]->Sbase."</td>";
                                        echo "<td>".$empleados[$i]->fecha_ingreso."</td>";
                                        echo "<td>".$empleados[$i]->estado."</td>";
                                    echo "</tr>";

                                }
                            ?>                 
                        </tbody> 
                    </table>
                        
                </div>
                </div><!--Fin <div class="col-sm-12">-->
            </div><!--Fin <div class="row">-->

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

    $('.item_filtrar').on('click',function(){
        show_data();
    });

    function show_data(){
        var empresa_empleados = $('#empresa_empleados').children(":selected").attr("value");
        var fecha_inicio = $('#fecha_inicio').val();
        var estado = $('#estado').val();
        
        $('#mydata').dataTable().fnDestroy();
        $('.tabla1').empty()
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Empleado/reporte_emplado')?>',
            async : false,
            dataType : 'JSON',
            data : {empresa_empleados:empresa_empleados,fecha_inicio:fecha_inicio,estado:estado},
            success : function(data){
                console.log(data);
                $.each(data,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.empresa+'</td>'+//Agencia
                            '<td>'+registro.agencia+'</td>'+//Agencia
                            '<td>'+registro.nombre+'</td>'+//nombrePlaza
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//nombrePlaza
                            '<td>'+registro.nit+'</td>'+//nombrePlaza
                            '<td>'+registro.Sbase+'</td>'+//nombrePlaza
                            '<td>'+registro.fecha_ingreso+'</td>'+//nombrePlaza
                            '<td>'+registro.estado+'</td>'+//nombrePlaza
                        '</tr>'
                    );
                });
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

});//Fin jQuery
</script>
</body>


</html>