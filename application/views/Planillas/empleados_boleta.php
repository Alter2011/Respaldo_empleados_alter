<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Boletas de Pago</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="well">
                <nav class="float-right">
                    <div class="col-sm-10">
                        <div class="form-row">

                        <form action="<?php echo base_url('index.php/planillas/hojasPlanilla/'); ?>"  method="post" >
                            <?php if($ver==1 or $verPlinillas == 1) { ?>
                            <div class="form-group col-md-3">
                                <label for="inputState">Agencia</label>
                                <select class="form-control" name="agencia_boleta" id="agencia_boleta" class="form-control">
                                    <?php
                                        $i=0;
                                        foreach($agencia as $a){
                                            if(($admin == 0 && $agencia[$i]->id_agencia != 00) || $admin == 1){
                                    ?>
                                            <option value="<?= ($agencia[$i]->id_agencia);?>" id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                    <?php
                                            }
                                        $i++;
                                    }
                                    ?>
                                </select>
                            </div>
                            <?php }else{ ?>
                                <input type="hidden" name="agencia_boleta" id="agencia_boleta" value="<?php echo ($_SESSION['login']['agencia']); ?>" readonly>
                            <?php } ?>
                            
                            <div class="form-group col-md-3">
                                <center>
                                    <button type="submit" class="btn btn-success item_filtrar" style="margin-top: 23px;"><span class="fa fa-file-text"></span> Hoja de Firmas</button>
                                </center>
                            </div>
                        </form>

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
                    <tbody><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
                
    </div>
</div>

<!-- Llamar JavaScript -->
<script type="text/javascript">
    $(document).ready(function(){

        show_data();    
        $('#agencia_boleta').change(function(){
            show_data();
        });
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_boleta').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_boleta').val();
            }
            var i = 0;
            $('tbody').empty();

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
                                '<td>'+registro.cargo+'</td>'+//estado
                                '<td style="text-align:center;">'+
                                    '<a href="<?php echo base_url();?>index.php/planillas/reciboBoleta/'+registro.id_empleado+'" class="btn btn-success btn-sm item_add"><span class="fa fa-pencil-square-o"></span> Ver Boleta</a>'+
                                    '</a> '+
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
                "bAutoWidth": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
        }

    });
</script>
</body>
</html>