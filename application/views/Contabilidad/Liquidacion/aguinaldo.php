
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Aguinaldo/Liquidacion para Empleados</h2>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="enunciado_aprobar" style="color:blue; display: none;" class="alert alert-info aprobar" role="alert">
                        <b id="taprobar"></b>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Empleados</a></li>
                        <li><a data-toggle="tab" href="#menu1" id="pag2">Aguinaldo</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active"><br>

                            <nav class="float-right">
                                <div class="col-sm-12">
                                    <div class="form-group col-md-3">
                                        <label for="inputState">Agencia</label>
                                        <select class="form-control" name="agencia_aguinaldo" id="agencia_aguinaldo" class="form-control">
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
                                <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                                </tbody>
                            </table>

                        </div><!--Fin <div id="home" class="tab-pane fade in active">-->

                        <div id="menu1" class="tab-pane fade"><br><br>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Agencia:</label>
                                    <select class="form-control" name="agencia_agui" id="agencia_agui" class="form-control">
                                        <?php
                                            $i=0;
                                            foreach($agencia as $a){
                                        ?>
                                            <option id="<?= ($agencia[$i]->id_agencia);?>" value="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                                        <?php
                                            $i++;
                                            }
                                        ?>
                                    </select>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="inputState">Año:</label>
                                    <select class="form-control" name="anio_agui" id="anio_agui" class="form-control">
                                        <?php 
                                            $year = date("Y");
                                            for ($i= $year; $i > 2019; $i--){
                                        ?>
                                            <option id="<?= $i;?>" value="<?= $i;?>"><?php echo($i);?></option>
                                        <?php 
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <center>
                                        <a id="filtrar" class="btn btn-success item_filtrar" style="margin-top: 23px;">
                                            <i class="fas fa-clipboard-list"></i> Generar
                                        </a>
                                    </center>
                                </div>
                            </div>

                            <table class="table table-striped table-bordered" id="myaguinaldo">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;" colspan="4">
                                            <a class="btn btn-primary item_aprobar" id="aprobar_aguinaldo">
                                                <i class="glyphicon glyphicon-check"></i> Aprobar</a> 
                                            <a class="btn btn-danger item_rechazar">
                                                <i class="glyphicon glyphicon-remove"></i> Rechazar</a>
                                        </th>      
                                        
                                    </tr>
                                    <tr class="success">
                                        <th style="text-align:center;">Empleado</th>      
                                        <th style="text-align:center;">Empresa</th>
                                        <th style="text-align:center;">DUI</th>
                                        <th style="text-align:center;">Monto</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="taguinaldo">

                                </tbody>
                                <tfoot id="totalAguinaldo">
                                    
                                </tfoot>
                            </table>

                            <input type="hidden" name="agencia_accion" id="agencia_accion" readonly>
                            <input type="hidden" name="anio_accion" id="anio_accion" readonly>

                        </div><!--Fin <div id="menu1" class="tab-pane fade">-->

                    </div>
                </div>
            </div>
        </div><!--Fin <div class="col-sm-12">-->
    </div><!--Fin <div class="row">-->
</div><!--Fin <div class="col-sm-10">-->

<!--MODAL APROBAR-->
<form>
    <div class="modal fade" id="Modal_Aprobar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Aprobacion de Pago de Aguinaldo</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro/a de Aprobar Estos Aguinaldos?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" type="submit" id="btn_aprobar" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL APROBAR-->

<form>
    <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Rechazo de Pago de Aguinaldo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea Rechazar estos Aguinaldos?</strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Modal GIF-->
  <div class="modal fade" id="modalGif" tabindex="-1" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-sm">

      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title text-center">Cargando Por Favor Espere</h4>
        </div>
        <div class="modal-body" >
          <center><div class="lds-dual-ring"></div></center>
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

        //se usa para cambiar la tabla cada vez que se selecciona una agencia
        show_data();    
        $('#agencia_aguinaldo').change(function(){
            show_data();
        });
        function show_data(){
            //Se usa para destruir la tabla 
            $('#mydata').dataTable().fnDestroy();
            
            var agencia_prestamo = $('#agencia_aguinaldo').children(":selected").attr("id");
            if(agencia_prestamo == null){
                agencia_prestamo = $('#agencia_aguinaldo').val();
            }
            $('#show_data').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('prestamo/empleados_data')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_prestamo:agencia_prestamo},
                success : function(data){
                   $.each(data,function(key, registro){
                    $('#show_data').append(
                        '<tr>'+
                            '<td>'+registro.nombre+'</td>'+//Agencia
                            '<td>'+registro.apellido+'</td>'+//nombrePlaza
                            '<td>'+registro.dui+'</td>'+//estado
                            '<td>'+registro.cargo+'</td>'+//agencia
                            '<td style="text-align:center;">'+
                                '<a  href="<?php echo base_url();?>index.php/Liquidacion/reciboAguinaldo/'+registro.id_empleado+'" class="btn btn-default btn-sm item_add" ><span class="glyphicon glyphicon-tree-conifer"></span> Aguinaldo</a>'+
                                '</a> '+
                                '<a href="<?php echo base_url();?>index.php/Contratacion/regristoIncapacidad/'+registro.id_empleado+'" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-gift"></span> Liquidacion</a>'+
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
        };
        
        //POR FAVOR NO QUITAR 
         function resolver1Seg() {
          return new Promise(resolve => {
            setTimeout(() => {
              resolve(aguinaldos());
            }, 1000);
          });
        }

        async function llamadoAsincrono() {
          $('#modalGif').modal('show');
          await resolver1Seg();
          
        }

        $('.item_filtrar').on('click',function(){
            llamadoAsincrono();
         });
        function aguinaldos(){
            //Se usa para destruir la tabla 
            $('#myaguinaldo').dataTable().fnDestroy();
            
            var agencia_ingreso = $('#agencia_agui').children(":selected").attr("id");
            var anio = $('#anio_agui').children(":selected").attr("id");
            var total = 0;
            var estado = '';
            $('#taguinaldo').empty()
            $('#totalAguinaldo').empty()
            $.ajax({
                type  : 'POST',
                url   : '<?php echo site_url('Liquidacion/generaraAguinaldo')?>',
                async : false,
                dataType : 'JSON',
                data : {agencia_ingreso:agencia_ingreso,anio:anio},
                success : function(data){
                    console.log(data);
                   //$("#modalGif").modal('toggle');
                   $('#modalGif' ).modal( 'hide' ).data('bs.modal', null);
                   //$("#modalGif").removeClass('fade').modal('hide');
                   //$("#modalGif").modal("dispose");

                   $('[name="agencia_accion"]').val(data.datos[0].id_agencia);
                   $('[name="anio_accion"]').val(data.datos[0].anio_aplicar);
                   if(data.datos[0].estado == 1){
                        $('#aprobar_aguinaldo').hide();
                   }else{
                        $('#aprobar_aguinaldo').show();
                   }


                   $.each(data.datos,function(key, registro){
                    total += parseFloat(registro.cantidad);

                    $('#taguinaldo').append(
                        '<tr>'+
                            '<td style="text-align:left;">'+registro.nombre+' '+registro.apellido+'</td>'+
                            '<td>'+registro.nombre_empresa+'</td>'+
                            '<td>'+registro.dui+'</td>'+
                            '<td>$ '+parseFloat(registro.cantidad).toFixed(2)+'</td>'+
                        '</tr>'
                        );
                   });

                   $('#totalAguinaldo').append(
                        '<tr>'+
                            '<td><b>TOTAL</b></td>'+
                            '<td><b></b></td>'+
                            '<td><b></b></td>'+
                            '<td><b>$ '+total.toFixed(2)+'</b></td>'+

                        '</tr>'
                    );
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });

            //Se genera la paguinacion cada ves que se ejeucuta la funcion
            $('#myaguinaldo').dataTable({
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
        };
        
        //$('#row').on('click','.item_aprobar',function(){ 
        $('.item_aprobar').click(function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }else{
                $('#Modal_Aprobar').modal('show');
            }
        });

        //Metodo para aprobar una vacacion
        $('#btn_aprobar').on('click',function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/apronarAguinaldo')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Aprobar").modal('toggle');
                    cuteAlert({
                      type: "success",
                      title: "Aguinaldo",
                      message: "Se ha aprobado con exito los aguinaldos",
                      buttonText: "Ok"
                    })
                    aguinaldos();
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar 

        //$('#row').on('click','.item_aprobar',function(){ 
        $('.item_rechazar').click(function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();

            if(agencia.length == 0 || anio.length == 0){
                alert('No se detecto agencia generada');
            }else{
                $('#Modal_Eliminar').modal('show');
            }
        });

        //Metodo para aprobar una vacacion
        $('#btn_eliminar').on('click',function(){
            var agencia   = $('#agencia_accion').val();
            var anio   = $('#anio_accion').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Liquidacion/rechazarAguinaldo')?>",
                dataType : "JSON",
                data : {anio:anio,agencia:agencia},
                success: function(data){
                    $("#Modal_Eliminar").modal('toggle');
                    cuteAlert({
                      type: "error",
                      title: "Aguinaldo",
                      message: "Se ha rechazado con exito los aguinaldos",
                      buttonText: "Ok"
                    })
                    $('#taguinaldo').empty();
                    $('#totalAguinaldo').empty();
                    $('[name="agencia_accion"]').val("");
                   $('[name="anio_accion"]').val("");
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo para aprobar 

    });//Fin jQuery
</script>
</body>
</html>