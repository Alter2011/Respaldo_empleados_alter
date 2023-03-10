<div class="col-sm-10" id="impresion_boleta">
            <div class="text-center well text-white blue" id="boletas">
                <h2>Cuentas Contables Personales</h2>
            </div>
            
                        
                <div class="col-sm-12">
                    <div class="well" id="mostrar">
                        <table class="table table-bordered" id="tabla_boleta">
                          <thead>
                            <tr>
                              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr class="success">
                              <td><b>Nombre de Empleado</b></td>
                              <td><b>Agencia</b></td>
                              <td><b>Empresa</b></td>
                              <td><b>Cargo</b></td>
                              <td><b>Plaza</b></td>
                              <td><b>Accion</b></td>
                            </tr>
                            <tr>
                              <td><?php echo($personal[0]->nombre);?> <?php echo($personal[0]->apellido);?></td>
                              <td><?php echo($personal[0]->agencia);?></td>
                              <td><?php echo($personal[0]->nombre_empresa);?></td>
                              <td><?php echo($personal[0]->cargo);?></td>
                              <td><?php echo($personal[0]->nombrePlaza);?></td>
                              <td>
                                <a data-toggle="modal" class="btn btn-primary btn-sm item_agregar" data-codigo="<?php echo($personal[0]->id_empleado);?>"> Agregar </a>
                              </td>
                            </tr>
                          </tbody>
                        </table>

                        <?php if($cuentas != null){ ?>
                        <table class="table table-bordered" id="tabla_boleta">
                          <tbody>
                            <tr class="success">
                              <td><b>Descripcion de la cuenta</b></td>
                              <td><b>Cuenta Contable</b></td>
                              <td><b>Autorizado por</b></td>
                              <td><b>Accion</b></td>
                            </tr>
                        <?php
                          $i = 0;
                          foreach ($cuentas as $key){
                        ?>
                            <tr>
                                  <td><?php echo($key->descripcion);?></td>
                                  <td><?php echo($key->cuenta_contable);?></td>
                                  <td><?php echo($autorizacion[$i]->nombre);?> <?php echo($autorizacion[$i]->apellido);?></td>
                                  <td>
                                    <a data-toggle="modal" class="btn btn-info btn-sm item_edit" data-codigo="<?php echo($key->id_personales);?>" data-empleado="<?php echo($key->id_empleado);?>"> Editar </a> 
                                    <a data-toggle="modal" class="btn btn-danger btn-sm item_delete" data-codigo="<?php echo($key->id_personales);?>"> Eliminar </a>
                                  </td>
                            </tr>

                        <?php 
                          $i++;
                        } ?>
                          </tbody>
                        </table>
                    <?php }else{ ?>
                        <div class="panel panel-success">
                                <div class="panel-heading"><center><h4>Cuentas contables de Tipo Personal</h4></center></div>
                                <div class="panel-body"><center><h5>No sean realizados ingresos de Cuentas Contables</h5></center></div>
                            </div>
                    <?php } ?>
                    </div>
                </div>
        </div>
    </div>
</div>
<input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Nueva Cuenta Contable Personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_per" id="aplica_per" class="form-control">
                            
                        </select>
                        <div id="validacion" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_per" id="cuenta_per" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
                <input type="hidden" name="id_empleado" id="id_empleado" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!-- MODAL EDIT -->
<form>
    <div class="modal fade" id="Modal_Edit_Per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Editar Cuenta Contable Personal</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Se aplica:</label>
                    <div class="col-md-10">
                        <select class="form-control" name="aplica_per_edit" id="aplica_per_edit" class="form-control">
                            
                        </select>
                        <div id="validacion_edit" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cuenta:</label>
                    <div class="col-md-10">
                        <input type="text" name="cuenta_per_edit" id="cuenta_per_edit" class="form-control" placeholder="Ingrese Cuenta">
                        <div id="validacion2_edit" style="color:red"></div>
                    </div>
                </div>
        
            </div>

            <div class="modal-footer">
            <input type="hidden" name="id_personal" id="id_personal" class="form-control" readonly>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <button type="button" type="submit" id="btn_update" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Modificar</button>

            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL EDIT-->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar Cuanta Contable Personal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar esta cuenta?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_delete" id="code_delete" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<script type="text/javascript">
  $(document).ready(function(){

    $(document).on( "click",".item_agregar", function(event){
      var code   = $(this).data('codigo');
      $("#aplica_per").empty();
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Contabilidad/cuentasPersonales')?>",
        dataType : "JSON",
        data : {code:code},
        success: function(data){
          $.each(data,function(key, registro) {
            $("#aplica_per").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
          });
          $('[name="id_empleado"]').val(code);
          $('#Modal_Add').modal('show');
        },  
        error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
          this.disabled=false;
        }
      });
 
    });

    $('#btn_save').on('click',function(){
      var descripcion = $('select[name="aplica_per"] option:selected').text();
      var aplica_per = $('#aplica_per').children(":selected").attr("value");
      var cuenta_per = $('#cuenta_per').val();
      var code = $('#id_empleado').val();
      var autorizado = $('#user').val();

      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Contabilidad/saveCuentaPer')?>",
        dataType : "JSON",
        data : {code:code,descripcion:descripcion,aplica_per:aplica_per,cuenta_per:cuenta_per,autorizado:autorizado},
        success: function(data){
          if(data == null){
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';

            location.reload();
            this.disabled=false;
            
          }else{
            document.getElementById('validacion').innerHTML = '';
            document.getElementById('validacion2').innerHTML = '';

            for (i = 0; i <= data.length-1; i++){
              if(data[i] == 1){
                document.getElementById('validacion').innerHTML += "Debe de ingresar donde aplica la cuanta";
              }
              if(data[i] == 2){
                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
              }
              if(data[i] == 3){
                document.getElementById('validacion2').innerHTML += "Debe de ingresar la cuanta";
              }
            }//Fin For
          }//Fin if else
                                
        },  
        error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
          this.disabled=false;
        }
      });
      return false;
                
    });//fin de insercionde

    $(document).on( "click",".item_edit", function(event){
            document.getElementById('validacion_edit').innerHTML = '';
            document.getElementById('validacion2_edit').innerHTML = '';
            var code   = $(this).data('codigo');
            var empleado   = $(this).data('empleado');
            $("#aplica_per_edit").empty();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/llenarCuentaPer')?>",
                dataType : "JSON",
                data : {code:code,empleado:empleado},
                success: function(data){
                    $.each(data.forma,function(key, registro){
                      $("#aplica_per_edit").append('<option id='+registro.id+' value='+registro.id+'>'+registro.nom+'</option>');
                    });
                    $('[name="aplica_per_edit"]').val(data.verificar[0].forma);
                    $('[name="cuenta_per_edit"]').val(data.verificar[0].cuenta_contable);
                    $('[name="id_personal"]').val(code);
                    $('#Modal_Edit_Per').modal('show');
                    agencia_editC();

                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                    this.disabled=false;
                }
            });  
        });



    $('#btn_update').on('click',function(){
            var code = $('#id_personal').val();
            var aplica = $('#aplica_per_edit').children(":selected").attr("value");
            var descripcion = $('select[name="aplica_per_edit"] option:selected').text();
            var cuenta_contable = $('#cuenta_per_edit').val();

            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contabilidad/updateCuentaPer')?>",
                dataType : "JSON",
                data : {code:code,aplica:aplica,descripcion:descripcion,cuenta_contable:cuenta_contable},
                success: function(data){
                    if(data==null){
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';

                        $('#Modal_Edit_Per').modal('toggle');
                        $('.modal-backdrop').remove();
                        location.reload();

                    }else{
                        document.getElementById('validacion_edit').innerHTML = '';
                        document.getElementById('validacion2_edit').innerHTML = '';

                        for (i = 0; i <= data.length-1; i++){
                            if(data[i] == 1){
                                document.getElementById('validacion_edit').innerHTML += "Debe de ingresar donde aplica la cuanta";
                            }
                            if(data[i] == 2){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de ingresar la cuanta";
                            }
                            if(data[i] == 3){
                                document.getElementById('validacion2_edit').innerHTML += "Debe de ingresar la cuenta en el formato correcto ej: 1234";
                            }

                        }//Fin For
                    }
                            
                },  
                error: function(data){
                  var a =JSON.stringify(data['responseText']);
                  alert(a);
                }
            });
            return false;
      });//Fin metodo modificar

    $(document).on( "click",".item_delete", function(event){
      var code   = $(this).data('codigo');
      $('#Modal_Delete').modal('show');
      $('[name="code_delete"]').val(code);
    });

    $('#btn_delete').on('click',function(){
      var code = $('#code_delete').val();
            
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Contabilidad/deleteCuentaPer')?>",
        dataType : "JSON",
        data : {code:code},
        success: function(data){
          $('[name="code_delete"]').val("");
                    
          $('#Modal_Delete').modal('toggle');
          $('.modal-backdrop').remove();
          location.reload();

        },  
        error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
        }
      });
      return false;
    });

  });//Fin Jquery
</script>
</body>