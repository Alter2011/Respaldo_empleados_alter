        <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Detalles de Colocacion</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-row" id="reporte">
                        <div class="form-group col-md-3">
                            <label for="inputState">Mes</label>
                            <input type="month" class="form-control" id="mes_colocacion" name="mes_colocacion" value="<?php echo date('Y-m'); ?>">
                        </div>
                    </div>

                    <div class="form-row" id="reporte5">
                        <div class="form-group col-md-2">
                            <center>
                                <a class="btn btn-primary btn-sm" style="margin-top: 23px;" onclick="llamadoAsincrono()"><span class="glyphicon glyphicon-ok"></span> Aceptar</a>
                            </center>
                        </div>
                    </div>

                    <table class="table table-bordered" id="mydata" >
                        <thead>
                            <tr>
                                <th style="text-align:center;" colspan='6'>
                                    <div class="col-sm-5" id="desde"><?=$desde?></div>
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-5" id="hasta"><?=$hasta?></div>
                                </th>
                            </tr>
                            <tr class="success">
                                <th style="text-align:center;">Region</th> 
                                <th style="text-align:center;">Agencia</th> 
                                <th style="text-align:center;">Cartera</th> 
                                <th style="text-align:center;">Asesor</th> 
                                <th style="text-align:center;"># Colocado</th> 
                                <th style="text-align:center;">Total</th> 
                            </tr>
                        </thead>
                            <tbody class="tabla1">
                            <?php          
                                foreach($datos as $key ){ 
                            ?>
                            <tr>
                                <td><?=$key['region'];?></td>
                                <td><?=$key['agencia'];?></td>
                                <td><?=$key['cartera'];?></td>
                                <td><?=$key['nombre'];?></td>
                                <td><?=$key['conteo'];?></td>
                                <td>$<?=$key['total'];?></td>
                            </tr>
                             <?php } ?>                   
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

</body>


</html>
<script type="text/javascript">
    $('#mydata').dataTable({
            "order": [[ 0, "asc" ]],
            "paging":false,
            //"bInfo" : false,
            "bAutoWidth": false,
            "searching": false
        });

    function colocacion(){
        var mes_colocacion = $('#mes_colocacion').val();
        var estado = 1;
            
        //Se usa para destruir la tabla 
        $('#mydata').dataTable().fnDestroy();

        $('.tabla1').empty()
        $.ajax({
            type  : 'POST',
            url   : '<?php echo site_url('Seguimiento/colocado_detalle')?>',
            async : false,
            dataType : 'JSON',
            data : {mes_colocacion:mes_colocacion,estado:estado},
            success : function(data){
                console.log(data);
                document.getElementById('desde').innerHTML = data.desde;
                document.getElementById('hasta').innerHTML = data.hasta;
                $("#modalGif").modal('toggle');
                $.each(data.datos,function(key, registro){
                    $('.tabla1').append(
                        '<tr>'+
                            '<td>'+registro.region+'</td>'+//Agencia
                            '<td>'+registro.agencia+'</td>'+//estado
                            '<td>'+registro.cartera+'</td>'+//estado
                            '<td>'+registro.nombre+'</td>'+//estado
                            '<td>'+registro.conteo+'</td>'+//estado
                            '<td>$'+registro.total+'</td>'+//estado
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
            "order": [[ 0, "asc" ]],
            "paging":false,
            //"bInfo" : false,
            "bAutoWidth": false,
            "searching": false
        });
    }


    //POR FAVOR NO QUITAR 
    function resolver1Seg() {
        return new Promise(resolve => {
            setTimeout(() => {
              resolve(colocacion());
            }, 1000);
        });
    }

    async function llamadoAsincrono() {
        $('#modalGif').modal('show');
        await resolver1Seg();
    }
</script>