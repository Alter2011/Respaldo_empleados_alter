<div class="col-sm-10">
    <div class="text-center well text-white blue">
        <h2>Bonificaciones</h2>
    </div>
<div id="cuerpo">
  <div class="panel panel-default">
    <br>
          <div class="row">
            <div class="col-md-12 col-form-label">
              <div class="col-md-3 ">
                <label>Agencia:</label>

                <select class="form-control" name="agencia" id="agencia" class="form-control">
                        <option value="TODAS">Todas las agencias</option>

                    <?php
                        foreach($agencias as $agencia){
                    ?>
                        <option value="<?= ($agencia->id_agencia);?>" data-estado="0"><?php echo($agencia->agencia);?></option>
                    <?php
                        }
                    ?>
                </select>
              </div>
              <div class="col-md-3 ">
                <label>Mes:</label>
                <input type="month" class="form-control" name="mes"  id="mes">
              </div>

             
              <div class="col-md-1 ">
                <label>Filtrar</label>
                <br>
                <button type="button" title="Capturar fecha y hora actual" onclick="seleccionar_fecha()" class="btn btn-default">
                 <span class="glyphicon glyphicon-time"></span> 
                </button>
              </div>

            </div>

          </div>
    <div class="panel panel-body">
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home" id="pag1">Informacion general</a></li>
        <li><a data-toggle="tab" href="#menu1" id="pag2">Bonificacion</a></li>
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active"><br>

          <table id="tabla_general" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th style="text-align: center">Agencia  </th>
                  <th style="text-align: left">Asesor</th>
                  <th style="text-align: center">Nombre cartera</th>
                  <th style="text-align: center">Cartera activa</th>
                  <th style="text-align: center">Mora</th>

                  <th style="text-align: center">Indice eficiencia</th>
                  <th style="text-align: center">Bono asesor</th>
                  <th style="text-align: center">Bono consuelo asesor</th>
                  <!--<th style="text-align: center">Acciones</th>-->


                </tr>
              </thead>
              <tbody class="general">

           </tbody>
         </table>

        </div>

        <div id="menu1" class="tab-pane fade"><br>
            

          <table id="tabla_bonificacion" class="table table-striped table-bordered" style="width:100%">
              <thead>
                <tr>
                  <th style="text-align: center">Agencia</th>
                  <th style="text-align: left">Empleado</th>
                  <th style="text-align: center">Cargo</th>
                  <th style="text-align: center">Bono</th>

                  <!--<th style="text-align: center">Acciones</th>-->
                </tr>
              </thead>
              <tbody class="bonificacion">

           </tbody>
         </table>

        </div>
      </div>

 </div>
</div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
    $('#tabla_general').DataTable( {
      //"order": [[ 1, "asc" ]],
      "bAutoWidth": false,
      "oLanguage": {
        "sSearch": "Buscador: "
      }
    } );

    $('#tabla_bonificacion').DataTable( {
      //"order": [[ 1, "asc" ]],
      "bAutoWidth": false,
      "oLanguage": {
        "sSearch": "Buscador: "
      }
    } );


    var date = new Date();
    var primerDia = new Date(date.getFullYear(), date.getMonth(), 1);
    var ultimoDia = new Date(date.getFullYear(), date.getMonth() + 1, 0);
  //inicio del mes
   var mes = primerDia.getMonth()+1; //obteniendo mes
    var dia = primerDia.getDate(); //obteniendo dia
    var ano = primerDia.getFullYear(); //obteniendo año
    if(dia<10)
      dia='0'+dia; //agrega cero si el menor de 10
    if(mes<10)
      mes='0'+mes //agrega cero si el menor de 10
    document.getElementById('mes').value=ano+"-"+mes;

  } );
  function seleccionar_fecha(){
    mes = $('#mes').val();
    agencia = $('#agencia').val();

    $('#tabla_general').DataTable().destroy();
    $('#tabla_general .general').empty();

    $('#tabla_bonificacion').DataTable().destroy();
    $('#tabla_bonificacion .bonificacion').empty();

    if (mes!='' && agencia!='') {
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Seguimiento/calculo_bonificacion')?>",
        dataType : "JSON",
        data : {mes:mes,agencia:agencia},
        success: function(data){
          console.log(data);
          if (data != null) {
          for (var i = 0 ; i <data.informacion.length; i++) {
            $(".general").append('<tr>' + 
              '<td>'+data.informacion[i].agencia+'</td>'+
              '<td>'+data.informacion[i].empleado+'</td>'+
              '<td>'+data.informacion[i].cartera+'</td>'+
              '<td>$'+number_format(data.informacion[i].cartera_act,2,',','')+'</td>'+
              '<td>$'+number_format(data.informacion[i].mora,2,',','')+'</td>'+

              '<td>'+number_format(data.informacion[i].indice_eficiencia,2,',','')+'</td>'+
              '<td>'+number_format(data.informacion[i].bono_asesor,2,',','')+'</td>'+
              '<td>'+number_format(data.informacion[i].bono_asesor_consuelo,2,',','')+'</td>'+
              //'<td></td>'+

              '</tr>'
            );
          }

          //for (var i = 0 ; i <data.bonos_jefes.length; i++) {
          $.each(data.bonos_jefes,function(key, registro){
            $(".bonificacion").append(
              '<tr>' + 
              '<td>'+registro.agencia+'</td>'+
              '<td>'+registro.nombre+'</td>'+
              '<td>'+registro.cargo+'</td>'+
              
              '<td>$'+number_format(registro.bono,2,',','')+'</td>'+
              //'<td></td>'+
              '</tr>'
            );
          })

      }

      $('#tabla_general').DataTable({
        "bAutoWidth": false,
        "oLanguage": {
          "sSearch": "Buscador: "
        }
      });

      $('#tabla_bonificacion').DataTable({
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

  }
</script>
