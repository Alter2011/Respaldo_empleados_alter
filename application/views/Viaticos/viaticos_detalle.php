<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Viaticos de empleado</h2>
                <a class="btn btn-success crear" id="btn_permiso" style="float: right;" >Imprimir</a><br>
            </div>
            
                        
                <div class="col-sm-12">
                        <table class="table table-bordered" id="tabla_boleta">
                            <thead>
                                <tr class="success">
                                  <td><b>Nombre de empleado</b></td>
                                  <td><b>Agencia</b></td>
                                  <td><b>Dui</b></td>
                                  <td><b>Cargo</b></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                  <td><?php echo($empleado[0]->nombre);?></td>
                                  <td><?php echo($empleado[0]->agencia);?></td>
                                  <td><?php echo($empleado[0]->dui);?></td>
                                  <td><?php echo($empleado[0]->cargo);?></td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-bordered" id="viaticos">
                            <thead>
                                <tr>
                                   <th scope="col" colspan="9">
                                       <div class="col-sm-12">
                                           <div class="form-group col-md-3">
                                                <label for="inputState">Mes</label>
                                                <input type="month" name="mes_viatico" id="mes_viatico"  class="form-control" value="<?php if(isset($mes)){echo $mes;}else{echo date('Y-m');} ?>">
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputState">Quincena</label>
                                                 <select class="form-control" name="quincena_viatico" id="quincena_viatico" class="form-control">
                                                    <option value="0">Todas</option>
                                                    <option value="1">Primera quincena</option>
                                                    <option value="2">Segunda quincena</option>
                                                </select>
                                            </div>

                                            <div class="form-group col-md-3">
                                                <label for="inputState">Filtrar</label><br>
                                                <a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_viaticos()"><span class="glyphicon glyphicon-search"></span></a>
                                            </div>
                                       </div>
                                   </th> 
                                </tr>
                                <tr class="success">      
                                    <th style="text-align:center;">Tipo viatico</th>      
                                    <th style="text-align:center;">Comusumo ruta</th>      
                                    <th style="text-align:center;">Depreciaciòn</th>      
                                    <th style="text-align:center;">Llanta delantera</th>      
                                    <th style="text-align:center;">Llanta tracera</th>      
                                    <th style="text-align:center;">Mant. Gral</th>      
                                    <th style="text-align:center;">Aceite</th>      
                                    <th style="text-align:center;">Total</th>      
                                    <th style="text-align:center;">Accion</th> 
                                </tr>
                            </thead>
                            <tbody class="viatico_tbody">   
                            <?php 
                            $consumo_ruta=0;
                            $depreciacion=0;
                            $llanta_del=0;
                            $llanta_tra=0;
                            $mant_gral=0;
                            $aceite=0;
                            $total=0;
                            if(!empty($viaticos)){ 
                              foreach ($viaticos as $key){
                                $tipo = '';
                                if($key->estado == 1){
                                    $tipo = 'Ruta';
                                }else if($key->estado == 2){
                                    $tipo = 'Total';
                                }else if($key->estado == 3){
                                    $tipo = 'Parcial';
                                }else if($key->estado == 4){
                                    $tipo = 'Adicional';
                                }else if($key->estado == 5){
                                    $tipo = 'Extra';
                                }else if($key->estado == 6){
                                    $tipo = 'Permanente';
                                }else if($key->estado == 9){
                                    $tipo = 'Compartido';
                                }
                            ?>
                                <tr>
                                    <td><?php echo $tipo;?></td>
                                    <td>$<?php echo(number_format($key->consumo_ruta,2));?></td>
                                    <td>$<?php echo(number_format($key->depreciacion,2));?></td>
                                    <td>$<?php echo(number_format($key->llanta_del,2));?></td>
                                    <td>$<?php echo(number_format($key->llanta_tra,2));?></td>
                                    <td>$<?php echo(number_format($key->mant_gral,2));?></td>
                                    <td>$<?php echo(number_format($key->aceite,2));?></td>
                                    <td>$<?php echo(number_format($key->total,2));?></td>
                                    <td>
                                        <a class="btn btn-danger" onclick="eliminar_viatico(<?= $key->id_viaticos_cartera;?>,<?= $key->estado;?>)" title="Eliminar viatico" ><span class="glyphicon glyphicon-trash"></span></a>
                                    </td>
                                </tr>

                            <?php 
                                    $consumo_ruta+=$key->consumo_ruta;
                                    $depreciacion+=$key->depreciacion;
                                    $llanta_del+=$key->llanta_del;
                                    $llanta_tra+=$key->llanta_tra;
                                    $mant_gral+=$key->mant_gral;
                                    $aceite+=$key->aceite;
                                    $total+=$key->total;
                                }
                            } 
                            ?>
                            </tbody>
                            <tfoot class="viatico_tfoot">
                                <tr>
                                    <td><b>Total</b></td>
                                    <td><b>$<?php echo(number_format($consumo_ruta,2));?></b></td>
                                    <td><b>$<?php echo(number_format($depreciacion,2));?></b></td>
                                    <td><b>$<?php echo(number_format($llanta_del,2));?></b></td>
                                    <td><b>$<?php echo(number_format($llanta_tra,2));?></b></td>
                                    <td><b>$<?php echo(number_format($mant_gral,2));?></b></td>
                                    <td><b>$<?php echo(number_format($aceite,2));?></b></td>
                                    <td><b>$<?php echo(number_format($total,2));?></b></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                </div>
        </div>
    </div>
</div>

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center>
                    <h4 class="modal-title" id="exampleModalLabel">Eliminacion de viaticos</h5>
                </center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                  <strong>¿Seguro/a que desea eliminar este viatico?</strong><br><br>
                </div>
                <input type="hidden" name="codigo_delete" id="codigo_delete" class="form-control" readonly>
                <input type="hidden" name="estado_delete" id="estado_delete" class="form-control" readonly>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a id="btn_eliminar"  class="btn btn-danger" onclick="delete_viatico()">Aceptar</a>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->


<script type="text/javascript">
    $('#viaticos').dataTable({
        "bAutoWidth": false,
        "paging": false,
        "searching": false,
    });
   function seleccionar_viaticos(){
        mes = $('#mes_viatico').val();
        quincena = $('#quincena_viatico').val();
        empleado = <?php echo $this->uri->segment(3);?>;
        tipo = '';
        consumo_ruta=0;
        depreciacion=0;
        llanta_del=0;
        llanta_tra=0;
        mant_gral=0;
        aceite=0;
        total=0;

        $('#viaticos').DataTable().destroy();
        $('#viaticos .viatico_tbody').empty();
        $('#viaticos .viatico_tfoot').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/mes_viaticos')?>",
          dataType : "JSON",
          data : {mes:mes,quincena:quincena,empleado:empleado},
          success: function(data){
              $.each(data,function(key, registro){
                if(registro.estado == 1){
                    tipo = 'Ruta';
                }else if(registro.estado == 2){
                    tipo = 'Total';
                }else if(registro.estado == 3){
                    tipo = 'Parcial';
                }else if(registro.estado == 4){
                    tipo = 'Adicional';
                }else if(registro.estado == 5){
                    tipo = 'Extra';
                }else if(registro.estado == 6){
                    tipo = 'Permanente';
                }else if(registro.estado == 9){
                    tipo = 'Compartido';
                }
                consumo_ruta+=parseFloat(registro.consumo_ruta);
                depreciacion+=parseFloat(registro.depreciacion);
                llanta_del+=parseFloat(registro.llanta_del);
                llanta_tra+=parseFloat(registro.llanta_tra);
                mant_gral+=parseFloat(registro.mant_gral);
                aceite+=parseFloat(registro.aceite);
                total+=parseFloat(registro.total);
                $(".viatico_tbody").append(
                  '<tr>'+
                    '<td>'+tipo+'</td>'+  
                    '<td>'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.mant_gral).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                    '<td>'+
                    '<a class="btn btn-danger" onclick=eliminar_viatico('+registro.id_viaticos_cartera+','+registro.estado+') title="Eliminar viatico" ><span class="glyphicon glyphicon-trash"></span></a>'+
                    '</td>'+ 
                  '</tr>'
                );
              });

              $(".viatico_tfoot").append(
                  '<tr>'+
                    '<td><b>Total</b></td>'+  
                    '<td><b>'+consumo_ruta.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+depreciacion.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+llanta_del.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+llanta_tra.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+mant_gral.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+aceite.toFixed(2)+'</b></td>'+ 
                    '<td><b>'+total.toFixed(2)+'</b></td>'+ 
                    '<td></td>'+
                  '</tr>'
                );
            $('#viaticos').dataTable({
                "bAutoWidth": false,
                "paging": false,
                "searching": false,
            });                          
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    function eliminar_viatico(viatico,estado){
        $('[name="codigo_delete"]').val(viatico);
        $('[name="estado_delete"]').val(estado);
        $('#Modal_Delete').modal('show');
    }

    function delete_viatico(){
        var id_viatico = $('#codigo_delete').val();
        var estado = $('#estado_delete').val();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/delete_viatico')?>",
          dataType : "JSON",
          data : {id_viatico:id_viatico,estado:estado},
          success: function(data){
            if(data == null){
              Swal.fire(
                'Viatico se eliminado correctamente!',
                '',
                'success'
              )
              $("#Modal_Delete").modal('toggle');
              seleccionar_viaticos();
            }
          },
          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

</script>