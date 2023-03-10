  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
  <div class="col-sm-10">
            <div class="text-center well text-white blue">
                <h2>Comisiones asignadas</h2>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="well">
                        <nav class="float-right">
                            <div class="col-sm-10">
                                <div class="form-row">
                                 <div class="form-group col-md-4">
                                    <label for="inputState">Agencia</label>
                                    <select class="form-control" name="agencia_comision" id="agencia_comision" class="form-control">
                                        <option value="todas">Todas</option>
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
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-4">
                                    <label for="inputState">Mes de Bono</label>
                                    <input type="month" class="form-control" id="mes_comision" name="mes_comision" value="<?php if(!empty($bonos[0]->mes)){echo $bonos[0]->mes;}else{date('Y-m');} ?>">
                                </div>
                            </div>

                            <div class="form-row">
                                 <div class="form-group col-md-3">
                                    <center><a id="filtrar" class="btn btn-primary btn-sm" onclick="seleccionar_comision();" style="margin-top: 23px;">Aceptar</a></center>
                                </div>
                            </div>
                        </div>
                        </nav>
                        <nav class="float-right aceptar" style="margin-top: 23px;"><a class="btn btn-primary" data-toggle="modal" data-target="#Modal_Add"><span class="fa fa-plus" ></span> Agregar Nuevo</a><br><br></nav>

      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Bonos normales</a></li>
        <li><a data-toggle="tab" href="#menu1" id="pag2">Bono colocación</a></li>
        <li><a data-toggle="tab" href="#menu2" id="pag2">Bono recuperación</a></li>
        <li><a data-toggle="tab" href="#menu3" id="pag3">Bono no aplicados</a></li>
        <li><a data-toggle="tab" href="#menu4" id="pag4">Asignacion de referente de cartera</a></li>

      </ul>
      <div class="tab-content">
        <div id="home" class="tab-pane fade in active"><br>
                        <!-- Bonos asesor-->
                        <table class="table table-striped table-bordered" id="mydata">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombres</th> 
                                    <th style="text-align:center;">Tipo de bono</th> 
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Cartera</th>
                                    <th style="text-align:center;">Bono</th>
                                    <th style="text-align:center;">Mes</th>
                                    <th style="text-align:center;">Quincena</th>
                                    <th style="text-align:center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                            <tfoot id="tfoot_total">

                            </tfoot>
                        </table>
                    </div>
        <div id="menu1" class="tab-pane fade"><br>
                        <table class="table table-striped table-bordered" id="mydata2">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Cartera</th>
                                    <th style="text-align:center;">Bono</th>
                                    <th style="text-align:center;">Monto colocado</th>

                                    <th style="text-align:center;">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="colocacion"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

                            </tbody>
                            <tfoot id="tfoot_total2">

                            </tfoot>
                        </table>
        </div>
        <div id="menu2" class="tab-pane fade"><br>
                        <table class="table table-striped table-bordered" id="mydata3">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Bono</th>
                                    <th style="text-align:center;">Numero de pagos</th>
                                    <th style="text-align:center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="recupera"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                              
                            </tbody>
                            <tfoot id="tfoot_total3">

                            </tfoot>
                        </table>
                        <input type='hidden' name='all_recuperados' id='all_recuperados'>
        </div>
        <div id="menu3" class="tab-pane fade"><br>
                        <table class="table table-striped table-bordered" id="mydata4">
                            <thead>
                                <tr>
                                    <th style="text-align:center;">Agencia</th> 
                                    <th style="text-align:center;">Nombres</th>      
                                    <th style="text-align:center;">Cargo</th>
                                    <th style="text-align:center;">Bono</th>
                                    <th style="text-align:center;">Numero de pagos</th>
                                    <th style="text-align:center;">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="recupera_no"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->
                              
                            </tbody>
                            <tfoot id="tfoot_total4">

                            </tfoot>
                        </table>
        </div>
                        <div class=" col-md-9"></div>
                        <div class=" col-md-3">
                            <?php if($aprobar == 1){ ?>
                            <input type="hidden" name="fecha_comision" id="fecha_comision" class="form-control" value="<?=$mes?>" readonly>
                            <a class="btn btn-success btn-lg" id="aprobar_comision" data-toggle="modal" data-target="#Modal_Apro" style="<?php if(true){echo 'display: none;';}?>">Aprobar todos los bonos</a>
                            <!--revisar la condicion del boton-->
                            <?php } ?>
                        </div><br><br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar nueva comision</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                  <div class="col-md-12" id="validacion" style="color:red"></div>
                </div>
           
                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cantidad:</label>
                    <div class="col-md-10">
                        <input type="text" name="cantidad_bono" id="cantidad_bono" class="form-control" placeholder="Ingrese la cantidad">
                    </div>
                </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Agencia:</label>
                <div class="col-md-10">
                    
                     <select class="form-control" name="agencia_bono" id="agencia_bono" class="form-control" onchange="empleados();">
                        <?php
                        $i=0;
                        foreach($agencia as $a){
                        ?>
                            <option value="<?= ($agencia[$i]->id_agencia);?>" id="<?= ($agencia[$i]->id_agencia);?>"><?php echo($agencia[$i]->agencia);?></option>
                        <?php
                            $i++;
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Empleado:</label>
                <div class="col-md-10">
                    <select name="empleado_bono" id="empleado_bono" class="form-control" placeholder="">
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Mes aplicar:</label>
                <div class="col-md-10">
                    <input type="month" name="mes_bono" id="mes_bono" class="form-control" value="<?=date('Y-m')?>">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-2 col-form-label">Quincena:</label>
                <div class="col-md-10">
                    <select name="quincena_bono" id="quincena_bono" class="form-control" placeholder="">
                        <option value='1'>Primera quincena</option>
                        <option value='2'>Segunda quincena</option>
                    </select>
                </div>
            </div>
           
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <a type="button" id="btn_save" class="btn btn-primary" onclick="ingresar_comision()">Guardar</a>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!--MODAL PARA CONFIRMAR BONOS-->
<form>
        <div class="modal fade" id="Modal_Apro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="exampleModalLabel">Aprobacion de comisiones</h4>
                    </center>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea aprobar todos los bonos?</strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a type="button" type="submit" id="btn_aprobar" class="btn btn-primary" onclick="llamadoAsincrono()">Aceptar</a>
                </div>
            </div>
            </div>
        </div>
</form>
<!--FIN MODAL BONOS-->

<!--MODAL PARA CONFIRMAR BONOS-->
<form>
        <div class="modal fade" id="Modal_recal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="exampleModalLabel">Recalcular Comisiones</h4>
                    </center>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea recalcular todos los bonos?</strong>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a type="button" type="submit" id="btn_aprobar" class="btn btn-primary" onclick="recalcular_comision()">Aceptar</a>
                </div>
            </div>
            </div>
        </div>
</form>
<!--FIN MODAL BONOS-->



<!--MODAL PARA CONFIRMAR BONOS-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <center>
                        <h4 class="modal-title" id="exampleModalLabel">Eliminar comision</h4>
                    </center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar esta comision?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="eliminar_bono" id="eliminar_bono" class="form-control" readonly>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary" onclick="delete_comision()">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>

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
      $(document).ready(function() {
        seleccionar_comision();

  } );
      $(function(){
        $('#cantidad_bono').maskMoney();
    })
    $('#mydata').dataTable({
        "bAutoWidth": false,
        "paging": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        }
    });
    $('#mydata2').dataTable({
        "bAutoWidth": false,
        "paging": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        }
    });    $('#mydata3').dataTable({
        "bAutoWidth": false,
        "paging": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        }
    });
    $('#mydata4').dataTable({
        "bAutoWidth": false,
        "paging": false,
        "oLanguage": {
            "sSearch": "Buscador: "
        }
    });
    empleados();
    function empleados(){
        var agencia_bono = $('#agencia_bono').children(":selected").attr("id");

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('comisiones/getAllEmpleados')?>",
            dataType : "JSON",
            data : {agencia_bono:agencia_bono},
            success: function(data){
                $("#empleado_bono").empty();
                $.each(data.all,function(key, registro) {
                    $("#empleado_bono").append('<option value='+registro.id_contrato+'>'+registro.nombre+' '+registro.apellido+'</option>');
                });
                   
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
            }
        });
        return false;
    };

    function seleccionar_comision(){
        agencia = $('#agencia_comision').val();
        mes = $('#mes_comision').val();
        estado = '';
        aprobar = 0;
        total_bono = 0;
        total_bono2 = 0;
        total_bono3 = 0;
        total_bono4 = 0;

        total_coloca = 0;
        total_recupe = 0;

        //tablas bonos asesor
        $('#mydata').DataTable().destroy();
        $('#mydata #show_data').empty();
        $('#mydata #tfoot_total').empty();

       //tablas bonos colocacion
        $('#mydata2').DataTable().destroy();
        $('#mydata2 #colocacion').empty();
        $('#mydata2 #tfoot_total2').empty();

       //tablas bonos recuperacion
        $('#mydata3').DataTable().destroy();
        $('#mydata3 #recupera').empty();
        $('#mydata3 #tfoot_total3').empty();

        //tablas bonos recuperacion no cancelados
        $('#mydata4').DataTable().destroy();
        $('#mydata4 #recupera_no').empty();
        $('#mydata4 #tfoot_total4').empty();

        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Seguimiento/mes_bonificacion')?>",
          dataType : "JSON",
          data : {agencia:agencia,mes:mes},
          success: function(data){
              $.each(data.bonos,function(key, registro){
                    if(registro.estado_control == 1){
                        estado = '<span class="label label-success">Comision aprobada</span>';
                    }else if(registro.estado_control == 2){
                        aprobar++;
                        estado = '<a id="eliminar" class="btn btn-danger btn-sm item_eli" onclick="eliminar_comision('+registro.id_bono+')">Eliminar</a>';
                    }else if(registro.estado_control == 3){
                        estado = '<span class="label label-info">Comision aprobada y en espera</span>';
                    }
                    if(registro.cargo != null){
                        cargo = registro.cargo;
                    }else{
                        cargo = '';
                    }
                    if(registro.cartera != null){
                        cartera = registro.cartera;
                    }else{
                        cartera = '';
                    }
                    if(registro.nombre != null){
                        nombre = registro.nombre;
                    }else if(registro.tipo_bono == 1){
                        nombre = 'Asesor no asignado';

                    }else if(registro.tipo_bono == 2){
                        nombre = 'Jefe no asignado';
                    }else if(registro.tipo_bono == 3){
                        nombre = 'Jefa no asignado';
                    }else if(registro.tipo_bono == 4){
                        nombre = 'Referente de cartera';
                    }else if(registro.tipo_bono == 5){
                        nombre = 'Coordinador no asignado';
                    }
                    //NO23012023 inicio de tipo de bono
                     if(registro.tipo_bono == 1){
                        bono = 'Bono de asesor';

                    }else if(registro.tipo_bono == 2){
                        bono = 'Bono de jefe';
                    }else if(registro.tipo_bono == 3){
                        bono = 'Bono de jefa';
                    }else if(registro.tipo_bono == 4){
                        bono = 'Bono de referente de cartera';
                    }else if(registro.tipo_bono == 5){
                        bono = 'Bono de coordinador';
                    }
                    //NO23012023 fin de tipo de bono
                    if(registro.quincena == 1){
                        quincena = 'Primera';
                    }else if(registro.quincena == 2){
                        quincena = 'Segunda';
                    }else{
                        quincena = '';
                    }
                    //para bonos de asesor
                if (registro.estado == 1 || registro.estado == 4) {
                    $("#show_data").append(
                      '<tr>'+
                        '<td>'+registro.agencia+'</td>'+  
                        '<td>'+nombre+'</td>'+ 
                        //NO23012023
                        '<td>'+bono+'</td>'+  
                        '<td>'+cargo+'</td>'+  
                        '<td>'+cartera+'</td>'+  
                        '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                        '<td>'+registro.mes+'</td>'+  
                        '<td>'+quincena+'</td>'+  

                        '<td>'+estado+'</td>'+
                      '</tr>'
                    );

                    total_bono += parseFloat(registro.bono);
                   
                }
                //para bonos de colocacion
                if (registro.estado == 3) {
                    $("#colocacion").append(
                      '<tr>'+
                        '<td>'+registro.agencia+'</td>'+  
                        '<td>'+registro.nombre+'</td>'+  
                        '<td>'+cargo+'</td>'+  
                        '<td>'+cartera+'</td>'+  
                        '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                        '<td>$'+parseFloat(registro.numero_control).toFixed(2)+'</td>'+  

                        '<td>'+estado+'</td>'+
                      '</tr>'
                    );

                    total_bono2 += parseFloat(registro.bono);
                 
                }
                //para bonos de recuperacion
                if (registro.estado == 2) {
                    
                    estado_empleado = '<span class="label label-success">Activo</span>';
                    $("#recupera").append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+  
                            '<td>'+registro.nombre+'</td>'+  
                            '<td>'+cargo+'</td>'+  
                            '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                            '<td>'+parseFloat(registro.numero_control).toFixed(2)+'</td>'+  
                            '<td>'+estado_empleado+'</td>'+  

                        '</tr>'
                    );

                    total_bono3 += parseFloat(registro.bono);
                  
                }
              }); 

              $("#tfoot_total").append(
                '<tr>'+
                '<td><b>Total</b></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td><b>$'+parseFloat(total_bono).toFixed(2)+'</b></td>'+  
                '<td></td>'+  
                '</tr>'
                );
              $("#tfoot_total2").append(
                '<tr>'+
                '<td><b>Total</b></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td><b>$'+parseFloat(total_bono2).toFixed(2)+'</b></td>'+  
                '<td></td>'+  
                '</tr>'
                );

                var myJSON = JSON.stringify(data.recuperados);
                $('#all_recuperados').val(myJSON);
              
              $.each(data.recuperados,function(key, registro){
                if(registro.contrato == null){
                    clase = 'danger';
                    estado_empleado = '<span class="label label-danger">Inactivo</span>';
                    $("#recupera_no").append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+  
                            '<td>'+registro.nombre+'</td>'+  
                            '<td>'+registro.rol+'</td>'+  
                            '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                            '<td>'+parseFloat(registro.pagos).toFixed(2)+'</td>'+  
                            '<td>'+estado_empleado+'</td>'+  

                        '</tr>'
                    );
                    total_bono4 += parseFloat(registro.bono);

                }else{
                    estado_empleado = '<span class="label label-success">Activo</span>';
                    $("#recupera").append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+  
                            '<td>'+registro.nombre+'</td>'+  
                            '<td>'+registro.rol+'</td>'+  
                            '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                            '<td>'+parseFloat(registro.pagos).toFixed(2)+'</td>'+  
                            '<td>'+estado_empleado+'</td>'+  

                        '</tr>'
                    );
                }
                
                total_bono3 += parseFloat(registro.bono);
                  
              });

              if(data.no_cancelados != null){
                $.each(data.no_cancelados,function(key, registro){
                    estado_empleado = '<span class="label label-danger">Inactivo</span>';
                    $("#recupera_no").append(
                        '<tr>'+
                            '<td>'+registro.agencia+'</td>'+  
                            '<td>'+registro.empleado+'</td>'+  
                            '<td>'+registro.rol+'</td>'+  
                            '<td>$'+parseFloat(registro.bono).toFixed(2)+'</td>'+  
                            '<td>'+parseFloat(registro.numero_control).toFixed(2)+'</td>'+  
                            '<td>'+estado_empleado+'</td>'+  
                        '</tr>'
                    );
                    total_bono4 += parseFloat(registro.bono);
                });
              }

              $("#tfoot_total3").append(
                '<tr>'+
                '<td><b>Total</b></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td><b>$'+parseFloat(total_bono3).toFixed(2)+'</b></td>'+  
                '<td></td>'+  
                '</tr>'
                );

              $("#tfoot_total4").append(
                '<tr>'+
                '<td><b>Total</b></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td></td>'+  
                '<td><b>$'+parseFloat(total_bono4).toFixed(2)+'</b></td>'+  
                '<td></td>'+  
                '</tr>'
                );

            $('[name="fecha_comision"]').val(data.mes);
            if(aprobar == 0 || agencia != 'todas'){
                $('#aprobar_comision').hide();
            }else if(aprobar > 0 && agencia == 'todas'){
                $('#aprobar_comision').show();
            }

            $('#mydata').dataTable({
                "bAutoWidth": false,
                "paging": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            }); 
            $('#mydata2').dataTable({
                "bAutoWidth": false,
                "paging": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            }); 
            $('#mydata3').dataTable({
                "bAutoWidth": false,
                "paging": false,
                "oLanguage": {
                    "sSearch": "Buscador: "
                }
            });
            $('#mydata4').dataTable({
                "bAutoWidth": false,
                "paging": false,
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

    function resolver1Seg() {
        return new Promise(resolve => {
          setTimeout(() => {
            resolve(aprobar_comision());
          }, 1000);
        });
    }

    async function llamadoAsincrono() {
        $("#Modal_Apro").modal('toggle');
        $('#modalGif').modal('show');
        await resolver1Seg();
                
    }

    function aprobar_comision(){
        var mes = $('#fecha_comision').val();
        var recuperados = $('#all_recuperados').val();
        //console.log(recuperados);
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/aprobar_comision')?>",
            dataType : "JSON",
            data : {mes:mes,recuperados:recuperados},
            
            success: function(data){
                Swal.fire(
                    'Comisiones aprobadas correctamente!',
                    '',
                    'success'
                )
                $("#modalGif").modal('toggle');
                seleccionar_comision();
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
        return false;
    }

    function eliminar_comision(id_bono){
        $('[name="eliminar_bono"]').val(id_bono);
        $('#Modal_Delete').modal('show');
    }

    function delete_comision(){
        var code = $('#eliminar_bono').val();
            
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/delete_bono')?>",
            dataType : "JSON",
            data : {code:code},
            success: function(data){
                $('[name="eliminar_bono"]').val("");
                $('#Modal_Delete').modal('toggle');
                Swal.fire(
                    'Comision eliminada correctamente!',
                    '',
                    'success'
                )
                seleccionar_comision();
                   
            },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
        });
        return false;
    }

    function ingresar_comision(){
        var cantidad = $('#cantidad_bono').val();
        var agencia = $('#agencia_bono').val();
        var empleado = $('#empleado_bono').val();
        var mes = $('#mes_bono').val();
        var quincena = $('#quincena_bono').val();

        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/insertar_comision')?>",
            dataType : "JSON",
            data : {cantidad:cantidad,agencia:agencia,empleado:empleado,mes:mes,quincena:quincena},
            
            success: function(data){
                //$('#Modal_Add').modal('toggle');
                if(data == null){
                    document.getElementById('validacion').innerHTML = '';
                    Swal.fire(
                        'Comisiones ingresada correctamente!',
                        '',
                        'success'
                    )
                    seleccionar_comision();
                }else{
                    document.getElementById('validacion').innerHTML = data;
                }
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
        return false;
    }

    function recalcular_comision(){
        var mes = $('#fecha_comision').val();
        $.ajax({
            type : "POST",
            url  : "<?php echo site_url('Seguimiento/recal_comision')?>",
            dataType : "JSON",
            data : {mes:mes},
            
            success: function(data){
                $('#Modal_recal').modal('toggle');
                Swal.fire(
                    'Comisiones recalculadas correctamente!',
                    '',
                    'success'
                )
                seleccionar_comision();
            },  
            error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
            }
        });
        return false;
    }

</script>