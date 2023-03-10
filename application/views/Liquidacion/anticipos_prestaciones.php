<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<input type="hidden" name="code" id="code" value="<?php echo $this->uri->segment(3); ?>" readonly>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
    <h2>Anticipo de Prestaciones</h2>
  </div>
                                   
  <div class="col-sm-12">
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

      <table class="table table-striped table-bordered" id="mydata">
        <thead>
          <tr>
            <th colspan="5" >

              <div class="col-md-12">
                <div class="col-md-5"></div>
                <label class="col-md-1 col-form-label">Año:</label>
                <div class="col-md-3">
                  <select class="form-control" name="anio_anticipo" id="anio_anticipo" class="form-control">
                    <option value="todos">Todos</option>
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

            </th>
          </tr>
          <tr class="success">
            <td WIDTH="150"><b>Fecha de Ingreso</b></td>
            <td><b>Autorizante</b></td>
            <td WIDTH="150"><b>Fecha Aplicacion</b></td>
            <td WIDTH="150"><b>Cantidad</b></td>
            <td><b>Accion</b></td>
          </tr>
        </thead>
        <tbody id="show_data"><!--Aca deberia mandar a llamar los datos de la funcion js show_data-->

        </tbody>
      </table>

  </div>
</div>

<!--Modal_Eliminar-->
<form>
  <div class="modal fade" id="Modal_Eliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header" style="text-align: center;">
          <h4 class="modal-title" id="exampleModalLabel">Cancelacion de Anticipo de Prestaciones</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <strong>¿Seguro que desea cancelar este Anticipo?</strong><br><br>
        </div>
        <div class="modal-footer">
          <input type="hidden" name="code_eliminar" id="code_eliminar" class="form-control" readonly>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" id="btn_eliminar" class="btn btn-danger">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</form>
<!--END Modal_Eliminar-->

<script type="text/javascript">
  $(document).ready(function(){
    show_data();    
    $('#anio_anticipo').change(function(){
      show_data();
    });

    function show_data(){
      //Se usa para destruir la tabla 
      $('#mydata').dataTable().fnDestroy();
      var anio_anticipo = $('#anio_anticipo').children(":selected").attr("value");
      var code = $('#code').val();
      var nombreAuto=[];
      var j = 0;
      var k = 0;
      var borrar = '';

      $('#show_data').empty()
      $.ajax({
        type  : 'POST',
        url   : '<?php echo site_url('Liquidacion/anticipos_empleados')?>',
        async : false,
        dataType : 'JSON',
        data : {code:code,anio_anticipo:anio_anticipo},
        success : function(data){
        console.log(data);
        for (i = 0; i < data.autorizacion.length; i++) {
          nombreAuto[i] = data.autorizacion[i];
        }
        $.each(data.datos,function(key, registro){
          if(registro.estado == 1){
            borrar = '<a data-toggle="modal" data-target="#Modal_Eliminar" class="btn btn-danger btn-sm item_eliminar" title="Eliminar Anticipo" data-codigo="'+registro.id_prestaciones+'"><em class="glyphicon glyphicon-trash"></em></a>';
          }else{
            borrar = '';
          }
          $('#show_data').append(
            '<tr>'+
              '<td WIDTH="150">'+registro.fecha_ingreso+'</td>'+
              '<td>'+nombreAuto[j].nombre+' '+nombreAuto[j].apellido+'</td>'+
              '<td WIDTH="150">'+registro.fecha_aplicar+'</td>'+
              '<td WIDTH="150">$'+parseFloat(registro.monto).toFixed(2)+'</td>'+
              '<td style="text-align:center;">'+
              borrar+
               ' <a href="<?php echo base_url();?>index.php/Liquidacion/reportAnticipoPrest/'+registro.id_prestaciones+'" class="btn btn-primary btn-sm" title="Mostrar Permiso">'+
                   '<em class="glyphicon glyphicon-print"></em>'+
              '</a> '+  
              '</td>'+
            '</tr>'
          );
            j++;
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

     $('.item_eliminar').click(function(){
          var code   = $(this).data('codigo');
          $('[name="code_eliminar"]').val(code); 
      });

     //Metodo para eliminar 
      $('#btn_eliminar').on('click',function(){
        var code = $('#code_eliminar').val();
        $.ajax({
          type : "POST",
          url  : "<?php echo site_url('Liquidacion/cancelarAnticipo')?>",
          dataType : "JSON",
          data : {code:code},
    
          success: function(data){
            $('[name="code_eliminar"]').val("");
            $('#Modal_Eliminar').modal('toggle');
              Swal.fire(
                'La incapacidad se cancelo con exito!',
                '',
                'error'
              )
              show_data();
          },  
          error: function(data){
            var a =JSON.stringify(data['responseText']);
            alert(a);
          }
        });
        return false;
      });//Fin metodo eliminar 
  });
</script>