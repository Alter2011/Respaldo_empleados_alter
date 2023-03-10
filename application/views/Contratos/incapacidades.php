<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<input type="hidden" name="user" id="user" value="<?php echo ($_SESSION['login']['id_empleado']); ?>" readonly>
<input type="hidden" name="code" id="code" value="<?php echo $this->uri->segment(3); ?>" readonly>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
    <h2>Incapacidades</h2>
  </div>
            
                        
  <div class="col-sm-12">
    <div class="well" id="mostrar">
      <table class="table table-bordered" id="tabla_boleta">
        <thead>
          <?php if($datos[0]->id_empresa == 1){ ?>
            <tr>
              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
            </tr>
          <?php }else if($datos[0]->id_empresa == 2){ ?>
            <tr>
              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_permiso"></center></th>
            </tr>
          <?php }else if($datos[0]->id_empresa == 3){ ?>
            <tr>
              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\secofi_logo.png" id="logo_permiso"></center></th>
            </tr>
          <?php }else{ ?>
            <tr>
              <th scope="col" colspan="9"><center><img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso"></center></th>
            </tr>
          <?php } ?>
        </thead>
        <tbody>
          <tr class="success">
            <td><b>Nombre Empleado</b></td>
            <td><b>Agencia</b></td>
            <td><b>DUI</b></td>
            <td><b>Cargo</b></td>
            <td><b>Plaza</b></td>
          </tr>
          <tr>
            <td><?php echo($datos[0]->nombre);?> <?php echo($datos[0]->apellido);?></td>
            <td><?php echo($datos[0]->agencia);?></td>
            <td><?php echo($datos[0]->dui);?></td>
            <td><?php echo($datos[0]->cargo);?></td>
            <td><?php echo($datos[0]->nombrePlaza);?></td>
          </tr>
        </tbody>
      </table>

      <?php if(!empty($incapacidad)){ ?>
        <table class="table table-bordered" id="tabla_boleta">
          <tbody>
            <tr class="success">
              <td><b>Fecha de Ingreso</b></td>
              <td><b>Autorizante</b></td>
              <td><b>Desde</b></td>
              <td><b>Hasta</b></td>
              <td><b>Tipo de incapacidad</b></td>
              <td><b>Descricion</b></td>
              <td><b>Forma</b></td>
              <?php if($extencion == 1 || $cancelar == 1 || $imprimir == 1){ ?>
              <td><b>Accion</b></td>
              <?php } ?>

            </tr>
            <?php 
              $j = 0;
              $k = 0;
              foreach($incapacidad as $key){ 
                if($key->tipo_incapacidad == 1){
                  $tipo = 'Enfermedad común';
                }else if($key->tipo_incapacidad == 2){
                  $tipo = 'Accidente común';
                }else if($key->tipo_incapacidad == 3){
                  $tipo = 'Accidente trabajo';
                }else if($key->tipo_incapacidad == 4){
                  $tipo = 'Enfermedad profecional';
                }
            ?>

              <tr>
                <td>
                  <a title="Ver Incapacidad extendida" onclick="ocultar(this)" id="oculta-<?php echo $key->id_incapacida ?>" style="display: none;" data-codigo2="<?php echo $key->id_incapacida ?>">
                    <em class="glyphicon glyphicon-chevron-up"></em>
                  </a>
                  <?php if($ocultar[$j] == 0){ ?>
                  <a title="Ver Incapacidad extendida" onclick="mostrar(this)" id="mostrar-<?php echo $key->id_incapacida ?>" data-codigo="<?php echo $key->id_incapacida ?>">
                    <em class="glyphicon glyphicon-chevron-down"></em>
                  </a>
                  <?php } ?>
                  <?php echo($key->fecha_ingreso); ?>
                </td>
                <td><?php echo $autorizacion[$k]->nombre?> <?php echo $autorizacion[$k]->apellido ?></td>
                <td><?php echo($key->desde); ?></td>
                <td><?php echo($key->hasta); ?></td>
                <td><?php echo($tipo); ?></td>
                <td style="width: 20%;"><?php echo($key->descripcion); ?></td>
                <td><span class="badge badge-success">Normal</span></td>

                <?php if($extencion == 1 || $cancelar == 1 || $imprimir == 1){ ?>
                <td>
                  <?php if($ocultar[$j] == 1 && $extencion == 1){ ?>
                  <a data-toggle="modal" data-target="#Modal_Add" class="btn btn-default btn-sm item_agregar" title="Extender Incapacidad" data-codigo="<?php echo $key->id_incapacida; ?>" data-fecha="<?php echo $key->hasta; ?>">
                    <em class="glyphicon glyphicon-plus-sign"></em>
                  </a>
                  <?php } ?>
                  <?php if($cancelar == 1){ ?>
                  <a class="btn btn-danger btn-sm item_eliminar" data-toggle="modal" data-target="#Modal_Eliminar" title="Cancelar Incapacidad" data-codigo="<?php echo $key->id_incapacida; ?>" data-fecha="<?php echo $key->hasta; ?>">
                    <em class="glyphicon glyphicon-trash"></em>
                  </a>
                  <?php } ?>
                  <?php if($imprimir == 1){ ?>
                  <a href="<?php echo base_url();?>index.php/Contratacion/imprimirPermiso/<?php echo $key->id_incapacida; ?>" class="btn btn-primary btn-sm" title="Mostrar Permiso">
                    <em class="glyphicon glyphicon-print"></em>
                  </a>
                  <?php } ?>
                </td>
                <?php } ?>

              </tr>

              <?php 
                if(!empty($extendida)){ 
                  for($i = 0; $i < count($extendida); $i++){
                    if($key->id_incapacida == $extendida[$i]->id_inca_exte){
                       if($extendida[$i]->tipo_incapacidad == 1){
                          $tipo_exten = 'Enfermedad común';
                        }else if($extendida[$i]->tipo_incapacidad == 2){
                          $tipo_exten = 'Accidente común';
                        }else if($extendida[$i]->tipo_incapacidad == 3){
                          $tipo_exten = 'Accidente trabajo';
                        }else if($extendida[$i]->tipo_incapacidad == 4){
                          $tipo_exten = 'Enfermedad profecional';
                        }
              ?>
                      <tr class="info <?php echo $extendida[$i]->id_inca_exte ?>" style="display: none;">
                        <td><?php echo $extendida[$i]->fecha_ingreso ?></td>
                        <td><?php echo $autorizacion2[$i]->nombre;?> <?php echo $autorizacion2[$i]->apellido; ?></td>
                        <td><?php echo $extendida[$i]->desde ?></td>
                        <td><?php echo $extendida[$i]->hasta ?></td>
                        <td><?php echo $tipo_exten ?></td>
                        <td><?php echo $extendida[$i]->descripcion ?></td>
                        <td><span class="badge badge-warning">Extendida</span></td>
                        <td>
                          <?php if($ocultar2[$i] == 1 && $extencion == 1){ ?>
                          <a data-toggle="modal" data-target="#Modal_Add" class="btn btn-default btn-sm item_agregar2" title="Extender Incapacidad" data-codigo="<?php echo $extendida[$i]->id_inca_exte; ?>" data-fecha="<?php echo $extendida[$i]->hasta; ?>">  
                            <em class="glyphicon glyphicon-plus-sign"></em>
                          </a> 
                          <?php } ?>
                           <?php if($cancelar == 1){ ?>
                          <a data-toggle="modal" data-target="#Modal_Eliminar" class="btn btn-danger btn-sm item_eliminar" title="Cancelar Incapacidad" data-codigo="<?php echo $extendida[$i]->id_inca_exte; ?>" data-fecha="<?php echo $extendida[$i]->hasta; ?>">
                            <em class="glyphicon glyphicon-trash"></em>
                          </a> 
                          <?php } ?>
                          <?php if($imprimir == 1){ ?>
                          <a  href="<?php echo base_url();?>index.php/Contratacion/imprimirPermiso/<?php echo $extendida[$i]->id_incapacida; ?>" class="btn btn-primary btn-sm" title="Mostrar Permiso">
                            <em class="glyphicon glyphicon-print"></em>
                          </a>
                          <?php } ?>
                        </td>
                      </tr>
              <?php
                    }
                  }//fin for count($extendida)
                }//fin if(!empty($extendida))
                $j++;
                $k++;
              ?>
            <?php } ?>

          </tbody>
        </table>
      <?php }else{ ?>
          <div class="panel panel-success">
              <div class="panel-heading"><center><h4>Incapacidades</h4></center></div>
              <div class="panel-body"><center><h5>No han ingresado incapacidades</h5></center></div>
          </div>
      <?php } ?>
    </div>
  </div>
</div>

<!-- MODAL ADD -->
<form>
    <div class="modal fade" id="Modal_Add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="text-align: center;">
            <h3 class="modal-title" id="exampleModalLabel">Agregar Extención de Incapacidad </h3>
            <h5 id="fecha_fin"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div style="color:red">Ingrese cuidadosamente las fechas a ingresar</div><br>
            <div class="form-group row">
                <div class="col-md-10">
                    <input type="hidden" name="contrato_user" id="contrato_user" class="form-control" placeholder="Product Code" readonly>
                </div>
            </div>
                <div id="validacion1" style="color:red"></div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Hasta:</label>
                    <div class="col-md-10">
                        <input type="date" name="hasta" id="hasta" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                        <div id="validacion2" style="color:red"></div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-2 col-form-label">Descripcion:</label>
                    <div class="col-md-10">
                        <textarea class="md-textarea form-control" id="descripcion" name="descripcion"></textarea>
                        <div id="validacion3" style="color:red"></div>
                    </div>
                </div>

            </div>
            
            <div class="modal-footer">
              <input type="hidden" name="code_egregar" id="code_egregar" class="form-control" readonly>
              <input type="hidden" name="hasta_egregar" id="hasta_egregar" class="form-control" readonly>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" type="submit" id="btn_save" class="btn btn-primary" data-backdrop="false" data-dismiss="modal" >Guardar</button>
            </div>
        </div>
        </div>
    </div>
</form>
<!--END MODAL ADD-->

<!--Modal_Eliminar-->
<form>
  <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="text-align: center;">
          <h4 class="modal-title" id="exampleModalLabel">Cancelacion de Incapacidad</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <strong>¿Seguro que desea cancelar esta incapacidad?</strong><br><br>
          <p><span class="badge badge-warning">Advertencia:</span> Si cancela esta incapacidad todas sus extenciones tambien lo harán</p>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="code_eliminar" id="code_eliminar" class="form-control" readonly>
          <input type="hidden" name="fecha_eliminar" id="fecha_eliminar" class="form-control" readonly>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!--END Modal_Eliminar-->

<!-- Llamar JavaScript -->
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery-3.2.1.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/bootstrap.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/jquery.dataTables.js'?>"></script>
<script type="text/javascript" src="<?php echo base_url().'assets/js/dataTables.bootstrap4.js'?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $('.item_agregar').click(function(){
        var code   = $(this).data('codigo');
        var fecha   = $(this).data('fecha');
        $('[name="code_egregar"]').val(code);
        $('[name="hasta_egregar"]').val(fecha);
        document.getElementById('fecha_fin').innerHTML = 'Fecha de finalizacion: '+fecha;
      });

      $('.item_agregar2').click(function(){
        var code   = $(this).data('codigo');
        var fecha   = $(this).data('fecha');
        $('[name="code_egregar"]').val(code);
        $('[name="hasta_egregar"]').val(fecha);
        document.getElementById('fecha_fin').innerHTML = 'Fecha de finalizacion: '+fecha;
      });

      //Save Plazas
      $('#btn_save').on('click',function(){
        var code = $('#code').val();
        var user = $('#user').val();
        var desde = $('#hasta_egregar').val();
        var hasta = $('#hasta').val();
        var descripcion = $('#descripcion').val();
        var id_incapacida = $('#code_egregar').val();

          $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/extenderIncapacidad')?>",
                dataType : "JSON",
                data : {code:code,user:user,desde:desde,hasta:hasta,descripcion:descripcion,id_incapacida:id_incapacida},
                success: function(data){
                  if(data == null){
                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';

                    $('[name="hasta"]').val("");
                    $('[name="descripcion"]').val("");
            
                    Swal.fire(
                      'La incapacidad se extendio con exito!',
                      '',
                      'success'
                    )
                    setTimeout('document.location.reload()',2000);
                    $("#Modal_Add").modal('toggle');

                    this.disabled=false;
                  
                  }else{
                    document.getElementById('validacion1').innerHTML = '';
                    document.getElementById('validacion2').innerHTML = '';
                    document.getElementById('validacion3').innerHTML = '';

                    for (i = 0; i <= data.error.length-1; i++){
                      if(data.error[i] == 1){
                        document.getElementById('validacion2').innerHTML += "Debe de ingresar hasta cuando aplica la Incapacidad";
                      }
                      if(data.error[i] == 2){
                        document.getElementById('validacion2').innerHTML += "La fecha hasta tiene que ser mayor o igual a la fecha de finalizacion";
                      }
                      if(data.error[i] == 3){
                        document.getElementById('validacion3').innerHTML += "Debe de ingresar la descripcion de la extencion";
                      }
                      if(data.error[i] == 4){
                        document.getElementById('validacion3').innerHTML += "La descripcion no puede ser mayor a 500 carracteres (cuentas los espacios)";
                      }
                      
                    }

                    if(data.mensaje != null){
                      document.getElementById('validacion1').innerHTML += data.mensaje;
                    }
                  }
                   
              },  
              error: function(data){
                var a =JSON.stringify(data['responseText']);
                alert(a);
                this.disabled=false;
              }
            });
          return false;
        });//fin $('#btn_save').on('click',function()

        $('.item_eliminar').click(function(){
          var code   = $(this).data('codigo');
          var fecha   = $(this).data('fecha');
          $('[name="code_eliminar"]').val(code);
          $('[name="fecha_eliminar"]').val(fecha); 
        });

        //Metodo para eliminar 
         $('#btn_eliminar').on('click',function(){
            var code = $('#code_eliminar').val();
            var fecha = $('#fecha_eliminar').val();
            $.ajax({
                type : "POST",
                url  : "<?php echo site_url('Contratacion/cancelarIncapacidad')?>",
                dataType : "JSON",
                data : {code:code,fecha:fecha},
    
                success: function(data){
                    $('[name="code_eliminar"]').val("");
                    $('[name="fecha_eliminar"]').val("");
                    $('#Modal_Eliminar').modal('toggle');
                    Swal.fire(
                      'La incapacidad se cancelo con exito!',
                      '',
                      'error'
                    )
                    setTimeout('document.location.reload()',2000);
                    this.disabled=false;
                    
                },  
                error: function(data){
                    var a =JSON.stringify(data['responseText']);
                    alert(a);
                }
            });
            return false;
        });//Fin metodo eliminar 

    });//Fin jQuery

    function mostrar(boton){
      var codigo = boton.dataset.codigo;
      $('.'+codigo).show(1000);
      $('#mostrar-'+codigo).hide(1000);
      $('#oculta-'+codigo).show(1000);
    }

    function ocultar(boton){
      var codigo = boton.dataset.codigo2;
      $('.'+codigo).hide(1000);
      $('#mostrar-'+codigo).show(1000);
      $('#oculta-'+codigo).hide(1000);
      
    }

</script>
</body>

</style>
</html>