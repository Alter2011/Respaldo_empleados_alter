<style type="text/css">
  .texto{
    margin-left: 20%; 
    margin-right:20%;
  }
  
  .constancia{
    margin: 10px;
    text-align: center;
  }
  .hr1{
    height: 5px;
    background-color: #872222;
  }
  .hr2{
    height: 2px;
    background-color: #872222;
    margin-top: -2%;
  }
  .firma{
    width:240px; 
    height: 200px
  }
  .pie_pag{
    margin-top: -2%;
    font-size: 15px;
  }
  .logoC{
      width: 220px;
      height: 100px;
    }
  .titulo{
    font-weight: bold;
  }
  .top{
    border-top-style: solid;
  }
  #pie {
    clear: both;
    text-align: center;
    padding: 15px;
  }
  .negrita{
    text-decoration: underline;
  }
  .subrayado{
      text-decoration: underline;
      margin-left: 8%;
  }
  
    @media print{
      .texto{
        margin-left: 12%; 
        margin-right:12%;
      }

      .imagen{
        margin-left: 5%;
      }
      .firma{
        width: 250px;
        height: 150px;
      }
      .constancia{
        margin-top: 5%;
        text-align: center;
      }
      .hr1{
        display: block;
        border-color: #872222;
        border-width:5px;
      }
      .hr2{
        display: block;
        border-color: #872222;
        margin-top: -4%;
        border-width:2px;
      }
      .pie_pag{
        margin-top: -3%;
        font-size: 15px;
      }
      .logoC{
        display: block;
        width: 250px;
        height: 120px;
        margin-top: 1%;
        margin-left: 30%
      }
      .negrita{
        font-weight: bold;
        font-size: 18px;
      }
      .negritaP{
        font-weight: bold;
        font-size: 18px;
      }
      .top{
        border-top-style: solid;
        font-weight: bold;
        font-size: 18px;
      }
          .titulo{
        font-weight: bold;
      }
      .subrayado{
        font-size: 18px;
      }

    }
    
</style>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
      <h2>Aguinaldo Para Empleados</h2>
  </div>
    <div class="col-sm-12">

      <div class="form-row">
        <div class="form-group col-md-3" id="anio">
          <label for="inputState">Año:</label>
            <select class="form-control" name="anio_agui" id="anio_agui" class="form-control">
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
        <div class="form-group col-md-6"></div>
        <div class="form-group col-md-3">
          <a class="btn btn-success crear ocultar" id="btn_permiso" style="display: none;"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
        </div>
      </div>
      <input type="hidden" name="empleado" id="empleado" value="<?php echo $this->uri->segment(3); ?>" readonly>

      <div class="col-sm-12" id='recibido'>
        
      </div>
                            
    </div>
</div>


<script type="text/javascript">
$(document).ready(function(){
  $('.crear').click(function(){
        $('#anio').hide();
        window.print();
        $('#anio').show();
    });

  aguinaldos();
  $('#anio_agui').change(function(){
    aguinaldos();
  });
  
  function aguinaldos(){
    var anio = $('#anio_agui').val();
    var empleado = $('#empleado').val();
    var logo = '';
    var descuentos = '';
    var clase = '';

    $('#recibido').empty()
    $.ajax({
      type  : 'POST',
      url   : '<?php echo site_url('Liquidacion/datosAguialdo')?>',
      async : false,
      dataType : 'JSON',
      data : {empleado:empleado,anio:anio},
      success : function(data){
        console.log(data);
        if(data.validacion == 0){
           $('.ocultar').show();
            if(data.datos[0].id_empresa == 1){
              logo = 'watermark.png';
            }else if(data.datos[0].id_empresa == 2){
              logo = 'AlterOcci.png';
            }else if(data.datos[0].id_empresa == 3){
              logo = 'secofi_logo.png';
            }

            if(parseInt(data.datos[0].anio_aplicar) >= 2022){
              img = '<img class="firma" src="<?= base_url();?>/assets/images/rrhh.jpg" id="img_vacacion">';
              img += '<h4>'+data.jefa+'</h4>';
              img += '<h4>Jefe Recursos Humanos</h4>';             
            }else{
              img = '<img class="firma" src="<?= base_url();?>/assets/images/firma_vacacion.png" id="img_vacacion">';
            }

            if(data.datos[0].isr > 0){
              descuentos = '<div class="row">'+
              '<div class="col-sm-2"><b></b></div>'+
              '<div class="col-sm-4"><b class="negritaP">Aguinaldo:</b></div>'+
              '<div class="col-sm-1" style="text-align: right;"><b class="negritaP">$</b></div>'+
              '<div class="col-sm-2" style="text-align: right;"><b class="negritaP">'+parseFloat(data.datos[0].cantidad).toFixed(2)+'</b></div>'+
              '</div>'+
              '<div class="row">'+
              '<div class="col-sm-2"><b></b></div>'+
              '<div class="col-sm-4"><b class="negritaP">(-) ISR:</b></div>'+
              '<div class="col-sm-1" style="text-align: right;"><b class="negritaP">$</b></div>'+
              '<div class="col-sm-2" style="text-align: right;"><b class="negritaP">'+parseFloat(data.datos[0].isr).toFixed(2)+'</b></div>'+
              '</div>';
              clase = 'top';
            }else{
              clase = 'negrita';
            }

            $('#recibido').append(
              '<div class="col-sm-12">'+
              '<div style="text-align: center;">'+
              '<img class="logoC" src="<?= base_url();?>/assets/images/'+logo+'">'+
              '</div>'+
              '<div class="constancia">'+
              '<h3 class="titulo">RECIBO DE PAGO DE AGUINALDO '+data.datos[0].anio_aplicar+'</h3>'+
              '</div>'+
              '<br><br>'+
              '<div class="texto">'+
              '<h4 class="text-justify" style="line-height: 1.5;">'+
              'Yo, <b class="negrita">'+data.datos[0].nombre+' '+data.datos[0].apellido+'</b>, empleado de '+data.datos[0].nombre_empresa+' hago constar que he recibido en concepto de <b class="negrita">AGUINALDO</b> por el año '+data.datos[0].anio_aplicar+' tal como lo expresa el Código de Trabajo de El Salvador Art. 197 y 198 numeral 1º y el Reglamento Interno de Trabajo que se aplica en '+data.datos[0].nombre_empresa+'  la cantidad de '+data.letras+'.<br><br>'+
              'FECHA DE INGRESO: <b class="negrita">'+data.fechaF+'</b>.<br><br>'+
              '<div class="subrayado">TOTAL A PAGAR:</div><br>'+
              descuentos+
              '<div class="row">'+
              '<div class="col-sm-2"><b></b></div>'+
              '<div class="col-sm-4"><b class="negritaP">Liquido a Recibir:</b></div>'+
              '<div class="col-sm-1" style="text-align: right;"><b class="negritaP">$</b></div>'+
              '<div class="col-sm-2" style="text-align: right;"><b class="'+clase+'">'+parseFloat(data.datos[0].liquido).toFixed(2)+'</b></div>'+
              '</div>'+
              '</h4>'+
              '<br><br>'+
              '<h4>'+data.fecha+'</b>.</h4>'+
               '<div style="height: 60px;"></div>'+
              '<div style="text-align: center;" id="prueba">'+
              '<h4>'+
              '<div class="row">'+
              '<div class="col-sm-6"><span class="firmas_pres">'+data.datos[0].nombre+' '+data.datos[0].apellido+'</span></div>'+
              '<div class="col-sm-1"><b></b></div>'+
              '<div class="col-sm-6"><span class="firmas_pres">_____________________________</span></div>'+ //modificacion 07-12-22 se cambio el nombre 
              '</div>'+
              '<div class="row">'+
              '<div class="col-sm-6"><span class="firmas_pres">DUI: '+data.datos[0].dui+'</span></div>'+
              '<div class="col-sm-1"><b></b></div>'+
              '<div class="col-sm-6"><span class="firmas_pres">' + data.get_empleado[0].nombre  +  '</span></div>'+ //modificacion 07-12-22 se cambio el parrafo a pagador
              '</div>'+
              '<div class="row">'+
              '<div class="col-sm-6"><span class="firmas_pres">NIT: '+data.datos[0].nit+'</span></div>'+
              '<div class="col-sm-1"><b></b></div>'+
              '<div class="col-sm-6"><span class="firmas_pres"></span></div>'+
              '</div>'+
              '<div style="text-align: center;">'+
              img+
              '</div>'+
              '</h4>'+
              '</div>'+
              '</div>'
            );
        }else if(data.validacion == 1){
          $('.ocultar').hide();
          $('#recibido').append(
              '<div class="row">'+
              '<div class="col-sm-1"></div>'+
              '<div class="col-sm-10">'+
              '<div class="panel panel-primary">'+
              '<div class="panel-heading">Pago de Aguinaldo</div>'+
              '<div class="panel-body">Aguinaldo no ha sido aprobado</div>'+
              '</div>'+
              '<div class="col-sm-1"></div>'+
              '</div>'+
              '</div>'
            );
        }else if(data.validacion == 2){
          $('.ocultar').hide();
          $('#recibido').append(
              '<div class="row">'+
              '<div class="col-sm-1"></div>'+
              '<div class="col-sm-10">'+
              '<div class="panel panel-danger">'+
              '<div class="panel-heading">Pago de Aguinaldo</div>'+
              '<div class="panel-body">No se ha encontrado aguinaldo</div>'+
              '</div>'+
              '<div class="col-sm-1"></div>'+
              '</div>'+
              '</div>'
            );
        }
      },  
      error: function(data){
          var a =JSON.stringify(data['responseText']);
          alert(a);
        }
    });
  };
        
});//Fin jQuery
  
</script>