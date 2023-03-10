
            <div class="col-sm-10">
                <div class="text-center well text-white blue ocultar">
                    <h2>Descuento de empleados</h2>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel" id="contenido">
                        <div class="panel-body">

                        <div class="tab-content">

                                <div class="form-group col-md-3">
                                <label for="inputState">Empresa</label>
                                <select class="form-control" name="empresa_desc" id="empresa_desc" class="form-control">
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
                           
                                <div class="row">
                                     <div class="form-row"  id="reportep2">
                                        <div class="form-group col-md-2">
                                            <label for="inputState">Agencia</label>
                                            <select class="form-control" name="agencia_descuento" id="agencia_descuento" class="form-control">
                                            
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-row ocultar" id="reporte3">
                                        <div class="form-group col-md-3">
                                            <label for="inputState">Mes de Prestamo</label>
                                            <input type="month" class="form-control" id="mes_entrada" name="mes_entrada" value="<?php echo date('Y-m')?>">
                                        </div>
                                    </div>

                                    <div class="form-row ocultar" id="reporte5">
                                        <div class="form-group col-md-2">
                                            <center><a id="filtrar" class="btn btn-primary buscar" style="margin-top: 23px;">Aceptar</a></center>
                                        </div>
                                    </div>
                                </div>

                               
                                <br>
                                    <div class="col-sm-10" id="texto_entrada" style="text-align: justify;">Descuento correspondiente al mes de: <b><?php echo $mes_correspondiente;?></b></div>
                                <br>

                                 <div class="row">
                                <div class="col-sm-12">
                                 
                                        
                            <table class="table table-bordered" id="mydata">
                            <thead>
                                <tr class="success">
                                  <td><b>Empleado</b></td>
                                  <td><b>Agencia</b></td>
                                  <td><b>Observaciones</b></td>
                                  <td><b>1° Q</b></td>
                                  <td><b>2° Q</b></td>
                                  <td><b>Total</b></td>
                                </tr>
                            </thead>
                              <tbody>
                                
                            <?php
                              foreach ($Descuentos as $key){
                            ?>
                                <tr>
                                      <td><?php echo($key['nombre']);?></td>
                                      <td><?php echo($key['agencia']);?></td>
                                      <td><?php echo($key['tipo']);?></td>
                                      <td><?php echo('$'.number_format($key['pago_Q1'],2));?></td>
                                      <td><?php echo('$'.number_format($key['pago_Q2'],2));?></td>
                                      <td><?php echo('$'.number_format($key['total'],2));?></td>
                                </tr>

                            <?php } ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                    <td><b></b></td>
                                    <td><b></b></td>
                                    <td><b>Total</b></td>
                                    <td><b><?php echo('$'.number_format($Total_Q1,2));?></b></td>
                                    <td><b><?php echo('$'.number_format($Total_Q2,2));?></b></td>
                                    <td><b><?php echo('$'.number_format($total_quincenas,2));?></b></td>

                                </tr>
                            </tfoot>
                            </table>
                                   
                                </div>
                            </div>

                       

                        </div>
                        </div>
                        </div>
                    </div>
                </div>
        
            </div>

            <script type="text/javascript">

                 $(document).ready(function(){

                agencia();

                 $('#mydata').dataTable({
                   
                    "iDisplayLength": 10,
                    "oLanguage": {
                        "sLengthMenu": "Your words here _MENU_ and/or here",
                    },
                    "paging":false,
                    "oLanguage": {
                        "sSearch": "Buscador: "
                    }
                });

                 });

                  $('.buscar').on('click',function(){
                buscar_descuentos();
                });



                function buscar_descuentos(){
                var agencia = $('#agencia_descuento').children(":selected").attr("id");
                var mes_entrada = $('#mes_entrada').val();
                var empresa = $('#empresa_desc').children(":selected").attr("id");

                var i = 1, j = 0, m = 0, n = 0;
                var subtotalq1 = 0, subtotalq2 = 0, total = 0;

                //console.log(agencia);
         
                
                $('#mydata').dataTable().fnDestroy();
                $('tbody').empty();
                $('tfoot').empty();

                $('#texto_entrada').empty();


                 //document.getElementById('tabla_entrada').innerHTML = "";
                $.ajax({
                    type : "POST",
                    url  : "<?php echo site_url('Descuentos_herramientas/descuentos')?>",
                    dataType : "JSON",
                    data : {agencia:agencia,mes_entrada:mes_entrada, empresa:empresa},
                    success: function(data){
                        //console.log(data);
                     
        
                        n = data.Descuentos.length;
                        $.each(data.Descuentos,function(key, registro){
                            subtotalq1 += parseFloat(registro.pago_Q1);
                            subtotalq2 += parseFloat(registro.pago_Q2);
                            total += parseFloat(registro.total);

                        
                                $('tbody').append(
                                    
                                '<tr>'+
                                    '<td>'+registro.nombre+'</td>'+
                                    '<td>'+registro.agencia+'</td>'+
                                    '<td>'+registro.tipo+'</td>'+
                                    '<td>$'+parseFloat(registro.pago_Q1).toFixed(2)+'</td>'+
                                    '<td>$'+parseFloat(registro.pago_Q2).toFixed(2)+'</td>'+
                                    '<td>$'+parseFloat(registro.total).toFixed(2)+'</td>'+
                                '</tr>'
                                );
                     
                        });

                        $('tfoot').append(
                            '<tr>'+
                                '<td><b></b></td>'+
                                '<td><b></b></td>'+
                                '<td><b>Total</b></td>'+
                                '<td><b>$'+subtotalq1.toFixed(2)+'</b></td>'+
                                '<td><b>$'+subtotalq2.toFixed(2)+'</b></td>'+
                                '<td><b>$'+total.toFixed(2)+'</b></td>'+
                            '</tr>'
                        );

                        $('#texto_entrada').append(
                            'Descuento correspondiente al mes de: <b>' + data.mes_correspondiente + '</b>'
                            );

                        $('#mydata').dataTable({
                   
                    "iDisplayLength": 10,
                    "oLanguage": {
                        "sLengthMenu": "Your words here _MENU_ and/or here",
                    },
                    "paging":false,
                    "oLanguage": {
                        "sSearch": "Buscador: "
                            }
                        });

                       
                    },  
                    error: function(data){
                        var a =JSON.stringify(data['responseText']);
                        alert(a);
                    }
                });
                return false;

                }

                 $("#empresa_desc").change(function(){
                    agencia();
                });

                  function agencia(){
                var empresa = $('#empresa_desc').children(":selected").attr("value");
                $("#agencia_descuento").empty();
                if(empresa != 'todo'){
              
                $("#agencia_descuento").removeAttr('disabled');

                    $.ajax({
                            type : "POST",
                            url  : "<?php echo site_url('Planillas/agenciasPlanilla')?>",
                            dataType : "JSON",
                            data : {empresa:empresa},
                            success: function(data){
                                $("#agencia_descuento").append(
                                    '<option id="todas" value="todas">Todas'+
                                    '</option>');
                                $.each(data.agencia,function(key, registro) {

                                     $("#agencia_descuento").append(
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
                    $("#agencia_descuento").attr('disabled','disabled');
                    $("#agencia_descuento").append('<option id="todas" value="todas">Todas</option>');
                }

             };



            </script>