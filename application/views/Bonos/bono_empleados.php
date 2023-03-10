<div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Bonos de Pagos Empleados</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">

                        <nav class="float-right" >
                            <div class="col-sm-8">
                                <div class="form-row">
                                <?php if($ver==1){ ?>
                                    <div class="form-group col-md-3">
                                        <label for="inputState" class="nameAgencia">Agencia</label>
                                        <select class="form-control" name="agencia" id="agencia" class="form-control" onchange="show_data()">
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

                                <input type="hidden" name="agencia" id="agencia" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>

                            <?php } ?>
                                <input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
                            </div>
                        </div>
                        </nav>


                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados</a></li>
                            <li><a data-toggle="tab" href="#menu1" id="pag2">Total Bonos</a></li>
                        </ul>

                        <div class="tab-content">

                            <div id="home" class="tab-pane active"><br>
                                
                                <table class="table table-striped" id="mydata">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">Cliente</th>  
                                            <th style="text-align:center;">Agencia</th>
                                            <th style="text-align:center;">Empleado ingresado</th>
                                            <th style="text-align:center;">Comprobante</th>
                                            <th style="text-align:center;">Pago</th>
                                            <th style="text-align:center;">Bono 1</th>
                                            <th style="text-align:center;">Bono 2</th>

                                            <th style="text-align:center;">Accion</th>
                            </tr>
                                    </thead>
                                    <tbody id="show_data" class="tabla1"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                                    </tbody>
            
                                </table>

                            </div>

                        

                        </div>

                    </div>
                </div>

            <div class="row">

            </div>

        

<!--MODAL PARA CONFIRMAR BONOS-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel"><strong>Eliminar Bonos</strong></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seleccione que bono eliminar?</strong>
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
       
 
    });

        //Se Reutiliza este metodo para mostrar usuarios
        function show_data(){
            console.log("Entre");
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia = $('#agencia').children(":selected").attr("id");
            if(agencia == null){
                agencia = $('#agencia').val();
            }
            var bono=0;
            var j = 0;

            $('.tabla1').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('bono/capturar_bonos')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia:agencia},
                success : function(data){
                   
                    console.log(data);
                    
                    $('.tabla1').append(
                        '<tr>'+
                                '<td>'+data.cliente+'</td>'+//Nombre del cliente
                                '<td>'+data.agencia+'</td>'+//Cajero ingresado
                                '<td>'+data.empleado+'</td>'+//Cajero ingresado
                                '<td>'+data.comprobante+'</td>'+//Numero de comprobante
                                '<td>'+data.id_agencia+'</td>'+//estado
                                '<td>$'+data.pago+'</td>'+//agencia
                                '<td>'+data.mes+'</td>'+//agencia
                                '<td>'+data.fecha_ingreso+'</td>'+//agencia

                                '</tr>'
                        );
                  
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


</script>
</body>

</html>