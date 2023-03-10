<style type="text/css">
  .logoF{
    width: 200px;
  }
  @media print{
    .logoF{
      margin-top: 4%;
      width: 200px;
      height: 50px;
    }
  }
</style>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
      <h2>Hoja de Firmas</h2>
  </div>
    <div class="col-sm-12">

      <div class="form-row">

        <div class="form-group col-md-3" id="anio">
          <label for="inputState">Año:</label>
            <select class="form-control" name="anio_firmas" id="anio_firmas" class="form-control">
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

        <div class="form-group col-md-3" id="empresa">
          <label for="inputState">Empresa:</label>
            <select class="form-control" name="empresa_firma" id="empresa_firma" class="form-control">
              <?php
                $i=0;
                foreach($empresa as $a){                                                    
              ?>
                  <option id="<?= ($empresa[$i]->id_empresa);?>" value="<?= ($empresa[$i]->id_empresa);?>"><?php echo($empresa[$i]->nombre_empresa);?></option>
              <?php
                $i++;
                }
              ?>
            </select>
        </div>

        <div class="form-group col-md-3" id="hojas">
          <label for="inputState">Hoja de:</label>
            <select class="form-control" name="hoja_de" id="hoja_de" class="form-control">
              <option id="1" value="1">Aguinaldo</option>
              <option id="2" value="2">Liquidacion</option>
            </select>
        </div>

        <div class="form-group col-md-3" id="btn_aceptar">
          <div class="form-group col-md-2">
            <center><a class="btn btn-primary btn-sm item_reporteL" style="margin-top: 25px;">Aceptar</a></center>
          </div>
        </div>

      </div>

      <input type="hidden" name="agencia" id="agencia" value="<?php echo $agencia; ?>" readonly>                     
    </div>

    <div class="form-row" id="btn_impresion" style="display: none;">
      <a class="btn btn-success crear ocultar" id="btn_permiso">
        <span class="glyphicon glyphicon-print"></span> Imprimir
      </a>
    </div>

    <div class="col-sm-12" id='recibido'>
      <div class="col-sm-12" id="encabezado"></div>   
    </div> 
</div>

<script type="text/javascript">
  $(document).ready(function(){

    $('.crear').click(function(){
      $('#anio').hide();  
      $('#empresa').hide();  
      $('#hojas').hide();  
      $('#btn_aceptar').hide();  
      window.print();
      $('#anio').show();
      $('#empresa').show();
      $('#hojas').show();
      $('#btn_aceptar').show();
    });

    firmas();
    $('.item_reporteL').on('click',function(){
      firmas();
    });
    function firmas(){
      var anio_firmas = $('#anio_firmas').val();
      var hoja_de = $('#hoja_de').val();
      var agencia = $('#agencia').val();
      var empresa = $('#empresa_firma').children(":selected").attr("value");
      var i = 0;
      var hoja = '';

      $('#encabezado').empty();
      $.ajax({
        type  : 'POST',
        url   : '<?php echo site_url('Liquidacion/hojaFimas')?>',
        async : false,
        dataType : 'JSON',
        data : {anio_firmas:anio_firmas,hoja_de:hoja_de,agencia:agencia,empresa:empresa},
        success : function(data){
          console.log(data);
          $('#btn_impresion').show();
          if(empresa == 1){
            logo = 'watermark.png';
          }else if(empresa == 2){
            logo = 'AlterOcci.png';
          }else if(empresa == 3){
            logo = 'secofi_logo.png';
          }else{
            logo = 'watermark.png';
          }

          if(hoja_de == 1){
            hoja = 'AGUINALDOS';
          }else if(hoja_de == 2){
            hoja = 'LIQUIDACIONES';
          }

          if(data.validar==0){
            $('#btn_impresion').hide();
            $('#encabezado').append(
              '<div class="alert alert-warning">'+
              '<div class="panel-heading"><h4>Hoja de Firmas</h4></div>'+
              '<div class="panel-body">No se ha encontrado ningun resultado</div>'+
              '</div>'
            );
          }else{

            $.each(data.datos,function(key, registro){

              if(i == 0){
                $('#encabezado').append(
                    '<div style="text-align: center;">'+
                    '<img class="logoF" src="<?= base_url();?>/assets/images/'+logo+'">'+
                    '</div>'+
                    '<div style="margin: 10px;text-align: center;" >'+
                      '<div>HOJA DE FIRMAS DE '+hoja+'</div>'+
                      '<div><b>'+data.fecha+'</b></div>'+
                    '</div>'
                );
              }

              $('#encabezado').append(
                '<div class="col-sm-12" style="text-align: center; "><!--Contenedor de todo-->'+
                  '<div class="col-sm-1"></div>'+
                  '<div class="col-sm-9">'+
                    '<div class="row" style="margin: 5px;text-align: center">'+
                      '<div class="col-sm-5"><b>'+registro.nombre+' '+registro.apellido+'</b></div>'+
                      '<div class="col-sm-3"></div>'+
                      '<div class="col-sm-4"><b>F____________________</b></div>'+
                      '<br><hr style="border: solid 0.5px;">'+
                    '</div>'+
                  '</div>'+
                  '<div class="col-sm-2"></div>'+
                '</div><br><br>'
              );
              i++;

              if(i == 12){
                $('#encabezado').append(
                  '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;"><!--Contenedor de todo-->'+
                      '<br><hr style="border: solid 0.5px;">'+
                      '<div><b>'+data.fecha+'</b></div>'+
                    '</div>'+
                  '<div style="margin-top:15px;page-break-before: always"><br>'
                );
                i=0;
              }

            });

            if(i<12){
              for (var j = i; j <= 11; j++) {
                $('#encabezado').append(
                  '<div class="col-sm-12" style="text-align: center; "><!--Contenedor de todo-->'+
                    '<div class="col-sm-1"></div>'+
                      '<div class="col-sm-9">'+
                        '<div class="row" style="margin: 5px;text-align: center">'+
                          '<div class="col-sm-5"><b></b></div>'+
                          '<div class="col-sm-3"><b></b></div>'+
                          '<div class="col-sm-4"><b></b></div>'+
                          '<br><hr style="border: solid 0.0px;'+
                        '</div>'+
                      '</div>'+
                    '<div class="col-sm-2"></div>'+
                  '</div>'
                ); 
              }
                      
              $('#encabezado').append(
                '<div class="col-sm-12" style="text-align: center;text-transform: uppercase;margin-bottom:40px;"><!--Contenedor de todo-->'+
                  '<br><hr style="border: solid 0.5px;">'+
                  '<div><b>'+data.fecha+'</b></div>'+
                '</div>'//en una hoja solo caben 12 por agencia
              ); 
            }
          }//if(data.validar==0)
        },  
        error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
        }
      });

    }

  });//Fin jQuery
</script>