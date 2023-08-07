<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/tarjetasCapa.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-3 mb-4" style="">
      <div>
        <h1>Básico</h1> 
      </div>
      <?php
        $i = 0;
        foreach($basico as $basico){
      ?>
        <div class="card" data-id="<?= $basico->id_historieta ?>" data-empleado="<?= $id_empleado ?>">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $basico->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>

    <div class="col-md-3 mb-4">
      <div>
        <h1>Intermedio</h1> 
      </div>
      <?php
        foreach($intermedio as $intermedio){
      ?>
        <div class="card" data-id="<?= $intermedio->id_historieta ?>" data-empleado="<?= $id_empleado ?>">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $intermedio->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>

    <div class="col-md-3 mb-4">
      <div>
        <h1>Avanzado</h1> 
      </div>
      <?php
        foreach($avanzado as $avanzado){
      ?>
        <div class="card" data-id="<?= $avanzado->id_historieta ?>" data-empleado="<?= $id_empleado ?>">
          <div class="box">
            <div class="content">
              <h2>0<?= $i+1;?></h2>
              <h3><?= $avanzado->historieta ?></h3>
            </div>
          </div>
        </div>
      <?php  $i++; } ?>
    </div>
  </div>
</div>

<!--modal de resultados-->
<div class="modal fade" id="modal_resultados" tabindex="-1" role="dialog" aria-labelledby="result_pensum" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title text-center" id="result">Resultado de examenes</h3>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12" id="contenedor_historietas">
                    <table id="tabla_data_his" class="table table-striped table-bordered" style="width:100%">
                        <thead class="text-center">
                            <tr>
                                <th style="text-align: center">Examen</th>
                                <th style="text-align: center">Historieta</th>
                                <th style="text-align: center">Modulo</th>
                                <th style="text-align: center">Nota</th>
                            </tr>
                        </thead>
                        <tbody id="data_historieta"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-end"> <!-- Agrega la clase "justify-content-end" para alinear los botones a la derecha -->
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $('.card').click(function() {
      // Obtener el ID de la historieta desde el atributo de datos y el id_empleado de la sesion
      var idHistorieta = $(this).data('id')
      var id_empleado = $(this).data('empleado')

      // Realizar la petición AJAX 
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('empleado/resultados_examen_pensum')?>",
        dataType : "JSON",
        data : { id_empleado: id_empleado,idHistorieta:idHistorieta },
        success: function(data){
          $('#tabla_data_his').DataTable().destroy();
          $('#tabla_data_his #data_historieta').empty(); 
          if (data != null) {
             console.log(data.resultados)
              for (var i = 0 ; i <data.resultados.length; i++) {
                // var nota = data.resultados[i].nota;
                // console.log(nota.toFixed(2))
                // var notaFormateada =  nota.toFixed(2);
                $('#data_historieta').append('<tr><td>'+data.resultados[i].nombre_examen+'</td>'+ 
                                  '<td>'+data.resultados[i].historieta+'</td>'+
                                  '<td>'+data.resultados[i].capitulo+'</td>'+
                                  '<td>'+data.resultados[i].nota+'</td></tr>');
              }
              $('#data_historieta').append('<tr><td></td><td></td><td>Promedio</td>'+
                                '<td>'+(data.promedio).toFixed(2)+'</td></tr>');

            // Abrir el modal
            $('#modal_resultados').modal('show');
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Error al obtener datos',
              text: 'No se ha realizado ningun examen.',
            })
          }
        },
        error: function(data){
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se ha realizado ningun examen.',
          })
        }
      });
    });
  });
</script>





