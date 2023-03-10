<div class="col-sm-10" id="impresion_boleta">
    <div class="text-center well text-white blue" id="boletas">
        <h2>Historial de tiempo tomado</h2>
    </div>
                       
    <div class="col-sm-12">
      <div class="well" id="mostrar">

        <table class="table table-bordered" id="tabla_boleta">
          <thead>
            <tr>
              <th scope="col" colspan="9">
                <center>
                  <img src="<?= base_url();?>\assets\images\watermark.png" id="logo_permiso">
                </center>
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="success">
              <td><b>Agencia</b></td>
              <td><b>Nombre del Empleado</b></td>
              <td><b>Cargo</b></td>
              <td><b>Plaza</b></td>
              
            </tr>
              <tr>
                <td><?php echo($persona[0]->agencia);?></td>
                <td><?php echo($persona[0]->nombre);?> <?php echo($persona[0]->apellido);?></td>
                <td><?php echo($persona[0]->cargo);?></td>
                <td><?php echo($persona[0]->nombrePlaza);?></td>
              </tr>
          </tbody>
        </table>

        <?php if($dias != null || $diasAnt != null){ ?>
        <table class="table table-bordered" id="tabla_boleta">
          <tbody>
            <tr class="success">
              <td><b>Ingresado Por</b></td>                
              <td><b>Fecha de Ingreso</b></td>                
              <td><b>Fecha de Vacacion</b></td>                
              <td><b>Dia</b></td>                
              <td><b>Horas</b></td>                
              <td><b>Minutos</b></td>                
              <td><b>Tipo</b></td>                
              <?php if($eliminar == 1){ ?><td><b>Accion</b></td><?php } ?>                
            </tr>
            <?php
              $totalHoras = 0;
              $totalMin = 0;
              $tital = 0;
              if($dias != null){
              for($i=0; $i < count($dias); $i++){
                if($dias[$i]->estado == 1){
                  $estado = '<span class="badge badge-info">Vacacion</span>';
                }else if($dias[$i]->estado == 2){
                  $estado = '<span class="badge badge-success">Anticipada</span>';
                }
              ?>            
            <tr>
                <td><?php echo($autorizante[$i]->nombre);?> <?php echo($autorizante[$i]->apellido);?></td>       
                <td><?php echo($dias[$i]->fecha_ingreso);?></td>       
                <td><?php echo($dias[$i]->fechas_vacacion);?></td> 
                <td><?php echo($autorizante[$i]->dia);?></td>      
                <td><?php echo($dias[$i]->horas);?></td>       
                <td><?php echo($dias[$i]->minutos);?></td>       
                <td><?php echo $estado; ?></td>       
                <?php if($eliminar == 1){ ?>
                  <td>
                    <a class="btn btn-danger btn-sm item_delete" data-codigo="<?php echo($dias[$i]->id_control);?>" data-vacacion="<?php echo($dias[$i]->id_vacacion);?>"> Eliminar </a>
                  </td> 
                <?php } ?>      
            </tr>
          <?php 
            $totalHoras += $dias[$i]->horas;
            $totalMin += $dias[$i]->minutos;
          }
          }

          if($diasAnt != null){ 
            for($i=0; $i < count($diasAnt); $i++){
            ?>
            <tr>
                <td><?php echo($autorizanteAnt[$i]->nombre);?> <?php echo($autorizanteAnt[$i]->apellido);?></td>       
                <td><?php echo($diasAnt[$i]->fecha_ingreso);?></td>       
                <td><?php echo($diasAnt[$i]->fechas_vacacion);?></td>  
                <td><?php echo($autorizanteAnt[$i]->dia);?></td>      
                <td><?php echo($diasAnt[$i]->horas);?></td>       
                <td><?php echo($diasAnt[$i]->minutos);?></td>
                <td><span class="badge badge-success">Anticipada</span></td>       
                <?php if($eliminar == 1){ ?>
                  <td>
                    <a class="btn btn-danger btn-sm item_delete_ant" data-codigo="<?php echo($diasAnt[$i]->id_anticipada);?>"> Eliminar </a>
                  </td>
                <?php } ?>       
            </tr>

          <?php 
            $totalHoras += $diasAnt[$i]->horas;
            $totalMin += $diasAnt[$i]->minutos;

            } 
          }

          $allmin = ($totalHoras * 60) + $totalMin;
          if($allmin > 480){
            $dias = intval((($allmin)/60)/8);
            $horas = intval(($allmin - ($dias*60*8))/60);
            $min = $allmin -($dias*60*8) - ($horas*60); 
          }else{
            $dias = null;
            $horas = intval($allmin/60);
            $min = $allmin - ($horas * 60);
          }
          
          ?>
          </tbody>
          <tfoot class="ultimo">
            <tr>
              <td><b>Total de Tiempo</b></td>
              <td><b>------</b></td>
              <td><b>------</b></td>
              <td colspan="4">
                <b>
                  <?php if($dias != null){ ?>
                    <?php echo($dias);?> Dias con <?php echo($horas);?> Horas y <?php echo($min);?> Minutos
                  <?php }else{ ?>
                  <?php echo($horas);?> Horas con <?php echo($min);?> Minutos
                  <?php } ?>
                </b>
              </td>
            </tr>
          </tfoot>
        </table>
        <?php }else{ ?>
          <div class="panel panel-success">
            <div class="panel-heading"><center><h4>Vacaciones</h4></center></div>
            <div class="panel-body"><center><h5>No se ha realizado ningun registro</h5></center></div>
          </div>
        <?php } ?>

      </div>
    </div>
       
</div>

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel">Eliminar Tiempo de Vacacion</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar este registro?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_delete" id="code_delete" class="form-control" readonly>
                <input type="hidden" name="code_vacacion" id="code_vacacion" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->

<!--MODAL DELETE-->
<form>
    <div class="modal fade" id="Modal_Delete_Ant" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <center><h4 class="modal-title" id="exampleModalLabel">Eliminar Tiempo de Vacacion Anticipada</h4></center>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <strong>¿Seguro que desea eliminar este registro?</strong>
                </div>
                <div class="modal-footer">
                <input type="hidden" name="code_delete_ant" id="code_delete_ant" class="form-control" readonly>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" type="submit" id="btn_delete_ant" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!--END MODAL DELETE-->


<script type="text/javascript">
    $(document).ready(function(){
      //se obtiene el id para poder eliminar
      $('.item_delete').click(function(){
            var code   = $(this).data('codigo');
            var vacacion   = $(this).data('vacacion');
                $('#Modal_Delete').modal('show');
                $('[name="code_delete"]').val(code);
                $('[name="code_vacacion"]').val(vacacion);
        });//fin metodo llenado
        
      });//Fin jQuery

    //Metodo para eliminar 
    $('#btn_delete').on('click',function(){
      var code = $('#code_delete').val();
      var code_vacacion = $('#code_vacacion').val();
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Vacaciones/deleteTiempo')?>",
        dataType : "JSON",
        data : {code:code,code_vacacion:code_vacacion},
    
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
    });//Fin metodo eliminar

    //se obtiene el id para poder eliminar
    $('.item_delete_ant').click(function(){
      var code   = $(this).data('codigo');
      $('#Modal_Delete_Ant').modal('show');
      $('[name="code_delete_ant"]').val(code);
    });//fin metodo llenado 


    //Metodo para eliminar 
    $('#btn_delete_ant').on('click',function(){
      var code = $('#code_delete_ant').val();
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Vacaciones/deleteTiempoAnt')?>",
        dataType : "JSON",
        data : {code:code},
    
          success: function(data){
            $('[name="code_delete_ant"]').val("");
            $('#Modal_Delete_Ant').modal('toggle');
            $('.modal-backdrop').remove();
            location.reload();
              
          },  
          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
      });
      return false;
    });//Fin metodo eliminar

</script>
</body>

</style>
</html>