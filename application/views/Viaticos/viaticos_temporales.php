<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Viaticos temporales</h2>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="form-group col-md-3">
                <label for="inputState">Agencia:</label>
                <select class="form-control" name="agencia_viatico" id="agencia_viatico" class="form-control">
                    <?php
                        foreach($agencias as $agencia){
                    ?>
                        <option value="<?= ($agencia->id_agencia);?>" data-estado="0"><?php echo($agencia->agencia);?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="inputState">Mes:</label>
                <input type="month" name="mes_viatico" id="mes_viatico"  class="form-control" value="<?= date('Y-m') ?>">
            </div>

            <div class="form-group col-md-3">
                <label for="inputState">Quincena:</label>
                <select class="form-control" name="quincena_viatico" id="quincena_viatico" class="form-control">
                    <option value="1" <?php if($quincena == 1){echo 'selected';} ?>>Primera quincena</option>
                    <option value="2" <?php if($quincena == 2){echo 'selected';} ?>>Segunda quincena</option>
                </select>
            </div>

            <div class="form-group col-md-3">
                <label for="inputState">Filtrar</label><br>
                <a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_viaticos()"><span class="glyphicon glyphicon-search"></span></a>
            </div>

        </div>
    </div><br>


    <div class="row">
        <div class="col-sm-12">
            <table class="table table-bordered" id="mydata">
                <thead>
                    <tr class="success">
                        <th style="text-align:center;">Agencia</th>         
                        <th style="text-align:center;">Empleado</th>      
                        <th style="text-align:center;">Cargo</th>      
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
                <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                    <?php 
                        foreach($empleados as $empleado){
                            echo '<tr>';
                            echo '<td>'.$empleado->agencia.'</td>';
                            echo '<td>'.$empleado->nombre.'</td>';
                            echo '<td>'.$empleado->cargo.'</td>';
                            echo '<td>$'.number_format($empleado->consumo_ruta,2).'</td>';
                            echo '<td>$'.number_format($empleado->depreciacion,2).'</td>';
                            echo '<td>$'.number_format($empleado->llanta_del,2).'</td>';
                            echo '<td>$'.number_format($empleado->llanta_tra,2).'</td>';
                            echo '<td>$'.number_format($empleado->mant_gral,2).'</td>';
                            echo '<td>$'.number_format($empleado->aceite,2).'</td>';
                            echo '<td>$'.number_format($empleado->total,2).'</td>';
                            echo '<td>';
                            echo '<a class="btn btn-success" title="Agregar viatico" onclick="ingresar_datos('.$empleado->id_empleado.')"><span class="glyphicon glyphicon-plus-sign"></span></a>';
                            echo '<a class="btn btn-primary" href="'.base_url('index.php/Viaticos/viaticos_detalle/'.$empleado->id_empleado).'" title="Revisar viatico" ><span class="glyphicon glyphicon-check"></span></a>';
                            echo '</td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_agregar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel"><center>Agregar viatico</center></h3>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                  <div class="col-md-12">
                    <div id="validacion" style="color:red"></div>
                    <input type="hidden" name="codigo_empleado" id="codigo_empleado" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Tipo de anticipo:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="tipo_viatico" id="tipo_viatico" onchange="seleccionar_tipo()">
                            <option value="1">Viatico total</option>
                            <option value="2">Viatico parcial</option>
                            <option value="3">Viatico adicional</option>
                            <option value="4">Viatico extra</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Mes aplicar:</label>
                    <div class="col-md-9">
                        <input type="month" name="mes_ingreso" id="mes_ingreso"  class="form-control" value="<?= date('Y-m') ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3 col-form-label">Quincena aplicar:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="quincena_viatico_temp" id="quincena_viatico_temp">
                            <option value="1">Primera quincena</option>
                            <option value="2">Segunda quincena</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="agencia_div">
                    <label class="col-md-3 col-form-label">agencia:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="agencia_ingreso" id="agencia_ingreso" onchange="seleccionar_moto()">
                            <?php
                                foreach($agencias as $agencia){
                                    if($agencia->id_agencia != '00'){
                            ?>
                                    <option value="<?= ($agencia->id_agencia);?>"><?php echo($agencia->agencia);?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="cartera_div">
                    <label class="col-md-3 col-form-label">Cartera:</label>
                    <div class="col-md-9">
                        <select class="form-control" name="cartera_viatico" id="cartera_viatico">
                            
                        </select>
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="dias_cobertura">
                    <label class="col-md-3 col-form-label">Dias cobertura:</label>
                    <div class="col-md-9">
                        <input type="number" name="cobertura_dias" id="cobertura_dias" min="1" class="form-control number-only">
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="por_cobertura">
                    <label class="col-md-3 col-form-label">% cobertura:</label>
                    <div class="col-md-9">
                        <input type="text" name="cobertura_por" id="cobertura_por"  class="form-control">
                    </div>
                </div>

                <div class="form-group row" style="display: none;" id="dinero_cantidad">
                    <label class="col-md-3 col-form-label">Cantidad ($):</label>
                    <div class="col-md-9">
                        <input type="text" name="cantidad_dinero" id="cantidad_dinero"  class="form-control">
                    </div>
                </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" onclick="insert_viaticos()">Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

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

<script type="text/javascript">
    $(function(){
        $('#cobertura_por').maskMoney();
        $('#cantidad_dinero').maskMoney();
    })
    $('#mydata').dataTable({
        "bAutoWidth": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        }
    });

    function seleccionar_tipo(){
        tipo_viatico = $('#tipo_viatico').val();

        if(tipo_viatico == 1 || tipo_viatico == 3){
            $('#dias_cobertura').hide();
            $('#por_cobertura').hide();
            $('#dinero_cantidad').hide();
            $('#agencia_div').show();
            $('#cartera_div').show();

        }else if(tipo_viatico == 2){
            $('#dinero_cantidad').hide();
            $('#dias_cobertura').show();
            $('#por_cobertura').show();
            $('#agencia_div').show();
            $('#cartera_div').show();

        }else if(tipo_viatico == 4){
            $('#dinero_cantidad').show();
            $('#dias_cobertura').hide();
            $('#por_cobertura').hide();
            $('#agencia_div').hide();
            $('#cartera_div').hide();

        }

    }

    function ingresar_datos(id_empleado){
        document.getElementById('validacion').innerHTML = '';
        $('[name="codigo_empleado"]').val(id_empleado);
        $('#Modal_agregar').modal('show');
    }

    seleccionar_moto();
    function seleccionar_moto(){
        agencia = $('#agencia_ingreso').val();
        $('#cartera_viatico').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/carteras_agencia')?>",
          dataType : "JSON",
          data : {agencia:agencia},
          success: function(data){
              $.each(data,function(key, registro){
                $("#cartera_viatico").append(
                  '<option value="'+registro.id_cartera+'">'+registro.cartera+'</option>'
                );
              });                          
          },

          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
    }

    function seleccionar_viaticos(){
        agencia = $('#agencia_viatico').val();
        mes = $('#mes_viatico').val();
        quincena = $('#quincena_viatico').val();

        $('#mydata').DataTable().destroy();
        $('#mydata #show_data').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Viaticos/get_viaticos_temp')?>",
          dataType : "JSON",
          data : {agencia:agencia,mes:mes,quincena:quincena},
          success: function(data){
              $.each(data,function(key, registro){
                $("#show_data").append(
                  '<tr>'+
                    '<td>'+registro.agencia+'</td>'+  
                    '<td>'+registro.nombre+'</td>'+  
                    '<td>'+registro.cargo+'</td>'+  
                    '<td>'+parseFloat(registro.consumo_ruta).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.depreciacion).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_del).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.llanta_tra).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.mant_gral).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.aceite).toFixed(2)+'</td>'+ 
                    '<td>'+parseFloat(registro.total).toFixed(2)+'</td>'+ 
                    '<td>'+
                    '<a class="btn btn-success" title="Agregar viatico" onclick=ingresar_datos('+registro.id_empleado+')><span class="glyphicon glyphicon-plus-sign"></span></a>'+
                    '<a href="<?php echo base_url();?>index.php/Viaticos/viaticos_detalle/'+registro.id_empleado+'" class="btn btn-primary" title="Revisar viatico"><span class="glyphicon glyphicon-check"></span></a>'+
                    '</td>'+ 
                  '</tr>'
                );
              }); 

            $('#mydata').dataTable({
                "bAutoWidth": false,
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
    }

    function insert_viaticos(){
        var empleado = $('#codigo_empleado').val();
        var tipo_viatico = $('#tipo_viatico').val();
        var mes = $('#mes_ingreso').val();
        var quincena = $('#quincena_viatico_temp').val();
        var agencia = $('#agencia_ingreso').val();
        var cartera = $('#cartera_viatico').val();
        var cobertura_dias = $('#cobertura_dias').val();
        var cobertura_por = $('#cobertura_por').val();
        var cantidad_dinero = $('#cantidad_dinero').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Viaticos/insert_temporal')?>",
            dataType : "JSON",
            data : {empleado:empleado,tipo_viatico:tipo_viatico,mes:mes,quincena:quincena,agencia:agencia,cartera:cartera,cobertura_dias:cobertura_dias,cobertura_por:cobertura_por,cantidad_dinero:cantidad_dinero},
            success: function(data){
                if(data == null){
                    Swal.fire(
                        'Depreciacion editada correctamente!',
                        '',
                        'success'
                    )
                    document.getElementById('validacion').innerHTML = '';
                    $('[name="cobertura_dias"]').val("");
                    $('[name="cobertura_por"]').val("");
                    $('[name="cantidad_dinero"]').val("");
                    $('[name="tipo_viatico"]').val(1);
                    $("#Modal_agregar").modal('toggle');
                    seleccionar_tipo();
                    seleccionar_viaticos();
                }else{
                    document.getElementById('validacion').innerHTML = data;
                }
            },
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
    }

    // mascara para los input que deben contener unicamente numeros, solo se debe añadir la clase numbers o number-only
    $("input.numbers").keypress(function(event) {
      return /\d/.test(String.fromCharCode(event.keyCode));
    });

    $(function(){
        $('.number-only').keypress(function(e) {
            if(isNaN(this.value+""+String.fromCharCode(e.charCode))) return false;
        })

    });
    $('number-only').keypress(function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
    $('#cobertura_dias').bind('paste', function (e) { e.preventDefault(); });
</script>