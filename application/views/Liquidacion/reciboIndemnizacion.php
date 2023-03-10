<style type="text/css">
    .texto{
      margin-left: 15%; 
      margin-right: 10%;
    }
    .constancia{
      margin: 10px;
      text-align: center;
    }
    .firma{
      width:260px; 
      height: 160px
    }
    
    .logoC{
      width: 220px;
      height: 100px;
    }
    .titulo{
      font-weight: bold;
    }
    .subrayado{
      text-decoration: underline;
      margin-left: 8%;
    }
    .negrita{
      text-decoration: underline;
    }
    .pago{
      margin-left: 35%;
    }
    .hr_liquidacion{
      border: 0 ; 
      border-top: 4px double #337AB7; 
      width: 90%;
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
    .pie_pag{
      margin-top: -2%;
      font-size: 15px;
    }
    @media print{
      .texto{
        margin-left: 8%; 
        margin-right:4%;
      }
      .firma{
        width: 295px;
        height: 135px;
      }
      .constancia{
        margin-top: 5%;
        text-align: center;
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
      .titulo{
        font-weight: bold;
      }
      .firmas_pres{
        font-size: 18px;
      }
      .hr_liquidacion{
        display: none;
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
        font-size: 12px;
      }

    }
</style>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
      <h2>Liquidaciones Para Empleados</h2>
  </div>
    <div class="col-sm-12">

      <div class="form-row">
        <div class="form-group col-md-3" id="anio">
          <label for="inputState">Año:</label>
            <select class="form-control" name="anio_inde" id="anio_inde" class="form-control">
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

      <div class="col-sm-12" id='retencion'>
        
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

  indemnizacion();
  $('#anio_inde').change(function(){
    indemnizacion();
  });

  function indemnizacion(){
    var anio = $('#anio_inde').val();
    var empleado = $('#empleado').val();
    var logo = '';

    $('#recibido').empty();
    $('#retencion').empty();
    $.ajax({
      type  : 'POST',
      url   : '<?php echo site_url('Liquidacion/datosIndemnizacion')?>',
      async : false,
      dataType : 'JSON',
      data : {empleado:empleado,anio:anio},
      success : function(data){
        //console.log(data);
        if(data.validacion == 0){
            $('.ocultar').show();

            if(data.datos[0].id_empresa == 1){
              logo = 'watermark.png';
            }else if(data.datos[0].id_empresa == 2){
              logo = 'AlterOcci.png';
            }else if(data.datos[0].id_empresa == 3){
              logo = 'secofi_logo.png';
            }

            if(data.datos[0].anio_aplicar >= 2022){
              img = '<img class="firma" src="<?= base_url();?>/assets/images/rrhh.jpg" id="img_vacacion">';
              img += '<h4>'+data.jefa+'</h4>';
              img += '<h4>Jefe Recursos Humanos</h4>';
            }else{
              img = '<img class="firma" src="<?= base_url();?>/assets/images/firma_vacacion.png" id="img_vacacion">';
            }

            $('#recibido').append(
              '<div style="text-align: center;">'+
              '<img class="logoC" src="<?= base_url();?>/assets/images/'+logo+'">'+
              '</div><br>'+
              '<div class="constancia">'+
              '<h3 class="titulo">RECIBO DE PAGO DE INDEMNIZACION '+data.datos[0].anio_aplicar+'</h3>'+
              '</div><br><br>'+
              '<div class="texto">'+
              '<h4 class="text-justify" style="line-height: 1.5;">'+
              'Yo, <b class="negrita">'+data.datos[0].nombre+' '+data.datos[0].apellido+'</b>, empleado de '+data.datos[0].nombre_empresa+' hago constar que he recibido en concepto de <b class="negrita">ANTICIPO DE INDEMNIZACION</b> por el año '+data.datos[0].anio_aplicar+' tal como lo expresa el Código de Trabajo de El Salvador Art. 58 párrafos 1 y 2; y el Reglamento Interno de Trabajo que se aplica en '+data.datos[0].nombre_empresa+'  la cantidad de '+data.letras+'.<br><br>'+
              'FECHA DE INGRESO: <b class="negrita">'+data.fechaF+'</b>.<br><br></h4>'+
              '<h4 class="subrayado">TOTAL A PAGAR:</h4>'+
              '<h3 class="pago "><b class="negrita">$'+parseFloat(data.datos[0].cantidad_bruto).toFixed(2)+'</b></h3><br><br>'+
              '<h4>'+data.fecha+'</b>.</h4>'+
              '<div style="height: 60px;"></div>'+

              '<div style="text-align: center;">'+
              '<h4>'+

              '<div class="row">'+
              '<div class="col-sm-6"><span class="firmas_pres">'+data.datos[0].nombre+' '+data.datos[0].apellido+'</span></div>'+
               '<div class="col-sm-6"><span class="firmas_pres">'+ data.get_empleado[0].nombre +'</span></div>'+
              '</div>'+

              '<div class="row">'+
              '<div class="col-sm-6"><span class="firmas_pres">DUI: '+data.datos[0].dui+'</span></div>'+
              '<div class="col-sm-1"><b></b></div>'+
              '</div>'+

              '<div style="text-align: center;">'+
              '<img class="firma" src="<?= base_url();?>/assets/images/rrhh.jpg" id="img_vacacion">'+
              '<h4>'+data.jefa+'</h4>'+
              '<h4>Jefe Recursos Humanos</h4>'+
              '</div>'+

              '</h4>'+
              '</div>'+

              '</div>'+
              '</div>'+
              '</div>'
            );
            var diff = data.datos[0].cantidad_bruto - data.datos[0].retencion_indem
            if(data.datos[0].retencion_indem > 0){
              if(data.datos[0].cantidad_liquida == 0){
                var monto = data.datos[0].cantidad_bruto
              }else{
                var monto = data.datos[0].retencion_indem
              }
              console.log("entre")
              $('#retencion').append(
                '<div style="margin-top:15px;page-break-before: always"> '+
                '<hr class="hr_liquidacion"><br>'+
                '<div style="text-align: center;">'+
                '<img class="logoC" src="<?= base_url();?>/assets/images/'+logo+'">'+
                '</div><br>'+
                '<div class="constancia">'+
                '<h3 class="titulo">RETENCION DE PASIVO LABORAL</h3>'+
                '</div><br><br>'+
                '<div class="texto">'+
                '<h4 class="text-justify" style="line-height: 1.5;">'+
                'Por medio de la presente se hace constar que al Sr(a) <b class="negrita">'+data.datos[0].nombre+' '+data.datos[0].apellido+'</b>, se le ha retenido la cantidad de '+data.letrasR+' ($'+parseFloat(monto).toFixed(2)+'), en cumplimiento a la <b class="negrita">política de Prestamos y Anticipos</b> que se aplica en la empresa '+data.datos[0].nombre_empresa+' a) <b class="negrita">Prestamos a empleados</b> la cual dice:  Para aplicar a la prestación de préstamos personal, a todo empleado se le retendrá un pasivo laboral equivalente a tres meses de su primer año dentro de la empresa. Dicha retención será devuelta al termino del pago del préstamo personal vigente.</h4><br><br>'+

                '<h4 class="text-justify" style="line-height: 1.5;">'+
                'Y para los usos que se estime conveniente se extiende la presente en la ciudad de '+data.fecha+'</h4><br><br>'+

                '<div class="row" style="text-align: center;">'+
                '<div class="col-sm-12">'+
                '<img class="firma" src="<?= base_url();?>/assets/images/rrhh.jpg" id="img_vacacion">'+
                '</div>'+
                '</div>'+
                '<div class="row" style="text-align: center;">'+
                '<div class="col-sm-12">'+
                '<h4 style="line-height: 1.5;">'+data.jefa+'</h4>'+
                '</div>'+
                '</div>'+
                '<div class="row" style="text-align: center;">'+
                '<div class="col-sm-12">'+
                '<h4 style="line-height: 1.5;">Jefe Recursos Humanos</h4>'+
                '</div>'+
                '</div>'+
                '<hr class="hr1"><hr class="hr2">'+
                '<p class="pie_pag">'+data.datos[0].casa_matriz+'<br>'+
                'Tel: 2448-0554 </p>'+
                '<br><br>'+
                '</div>'
              );
            }

        }else if(data.validacion == 1){
          $('.ocultar').hide();
          $('#recibido').append(
              '<div class="row">'+
              '<div class="col-sm-1"></div>'+
              '<div class="col-sm-10">'+
              '<div class="panel panel-primary">'+
              '<div class="panel-heading">Pago de Liquidacion</div>'+
              '<div class="panel-body">Liquidacion no ha sido aprobado</div>'+
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
              '<div class="panel-heading">Pago de Liquidacion</div>'+
              '<div class="panel-body">No se ha encontrado Liquidacion</div>'+
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