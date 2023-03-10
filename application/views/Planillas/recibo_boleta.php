<style type="text/css">
  @media print{
    #tabla_boleta{
      width: 700px;
      margin-top: 5%;
    }
    .bordes{
      border: black 5px solid;  
    }
    #cantidadB{
      font-size: 1.1em;
      border-top: 3px solid;
    }
    b{
      font-size: 1.1em;
    }
    #celdas{
      font-size: 1.1em;
    }
    td{
      font-size: 1.1em;
    }
    .secofi_boleta{
      width: 500px;
      height: 500px;
    }
    .logo{
      float: left;
    }
  }
</style>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
      <h2>Boletas de Pago</h2>
  </div>
    <div class="col-sm-12">

      <div class="form-row">
        <div id="validacion" style="color:red"></div>
        <div class="form-group col-md-3 cajaO">
          <label for="inputState">Quincena</label>
          <select class="form-control" name="num_quincena" id="num_quincena" class="form-control">
            <option value="1">Primera Quincena</option>
            <option value="2">Segunda Quincena</option>
          </select>
        </div>

        <div class="form-group col-md-3 cajaO">
          <label for="inputState">Mes:</label>
          <input type="month" class="form-control" id="mes_quincena" name="mes_quincena" value="<?php echo date("Y-m"); ?>">
        </div>

        <div class="form-group col-md-3 cajaO">
          <label for="inputState" style="font-size: 15px;">BOLETA NORMAL/GOBIERNO</label>
          <select class="form-control" name="boleta" id="boleta" class="form-control">
            <option value="1">Normal</option>
            <option value="2">Gobierno</option>
          </select>
        </div>

        <div class="form-group col-md-2 cajaO">
          <center>
            <button type="submit" class="btn btn-primary item_filtrar" style="margin-top: 23px;"><span class="glyphicon glyphicon-saved"></span> Aceptar</button>
          </center>
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
      $('.cajaO').hide();
      window.print();
      $('.cajaO').show();
  });

  boletas();
  $('.item_filtrar').on('click',function(){
    boletas();
  });
  function boletas(){
    var empleado = $('#empleado').val();
    var num_quincena = $('#num_quincena').val();
    var mes_quincena = $('#mes_quincena').val();
    var boleta = $('#boleta').val();
    var anticipo=[];
    var herramientas=[];
    var interno=[];
    var personal=[];
    var bancos=[];
    var viaticos=[];
    var comision=[];    //WM12012023 se agrego el arreglo para mostrar los tipos de comisiones
    var total_dev = 0;
    var titulo_gob = '';
    var img = '';
    var margin = '';
    viaticos[0] = '';

    $("#recibido").empty();
    document.getElementById('validacion').innerHTML = '';
      $.ajax({
        type : "POST",
        url  : "<?php echo site_url('Planillas/datosBoleta')?>",
        async : false,
        dataType : "JSON",
        data : {empleado:empleado,num_quincena:num_quincena,mes_quincena:mes_quincena,boleta:boleta},
        success: function(data){
          console.log(data);
          if(data.validacion.length == 0){

            if(data.datos[0].estado == 2){
              titulo_gob = 'Subsidio para la Recuperación de las Empresas Salvadoreñas en Cumplimiento a la ley de Protección del Empleo<br>'+ 
              'Salvadoreño otorgado por el Gobierno de El Salvador.<br>'+  
              'En cumplimiento al DL. N° 641 y el DL. N° 685<br>';
              img = '<img style="margin-left: -10%; margin-right: 10%; width:80px;" class="logoF" src="<?= base_url();?>/assets/images/logo_sv.png">';
              margin = 'style="margin-right: 10%;"';
            }else{
              titulo_gob = '';
              margin = '';
            }

            $('.ocultar').show();
            document.getElementById('validacion').innerHTML = '';
            if(data.anticipo != null || data.herramientas != null){
              if(data.anticipo != null){
                for(var i = 0; i < data.anticipo.length; i++){
                  anticipo[i] = '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> '+data.anticipo[i].nombre_tipo+'</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.anticipo[i].monto_otorgado).toFixed(2)+'</td>'+
                                '</tr>';
                }
              }else{
                anticipo[0] = '';
              }//fin if(data.anticipo != null)

              if(data.herramientas != null){
                for(var i = 0; i < data.herramientas.length; i++){
                  herramientas[i] = '<tr>'+
                                    '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> '+data.herramientas[i].nombre_tipo+'</td>'+
                                    '<td>$</td>'+
                                    '<td id="cantidadB">'+parseFloat(data.herramientas[i].pago).toFixed(2)+'</td>'+
                                    '</tr>';
                }
              }else{
                herramientas[0] = '';
              }//fin if(data.herramientas != null)
            }else{
              anticipo[0] = '';
              herramientas[0] = '';
            }//fin if(data.anticipo != null || data.herramientas != null)

            if(data.interno != null){
              for(var i = 0; i < data.interno.length; i++){
                interno[i] =  '<tr>'+
                              '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> '+data.interno[i].nombre_prestamo+'</td>'+
                              '<td>$</td>'+
                              '<td id="cantidadB">'+parseFloat(data.interno[i].pago_total).toFixed(2)+'</td>'+
                              '</tr>';
              }
            }else{
              interno[0] = '';
            }//fin if(data.interno != null)

            if(data.personal != null){
              for(var i = 0; i < data.personal.length; i++){
                personal[i] = '<tr>'+
                              '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> '+data.personal[i].nombre_tipos+'</td>'+
                              '<td>$</td>'+
                              '<td id="cantidadB">'+parseFloat(data.personal[i].pago_total).toFixed(2)+'</td>'+
                              '</tr>';
              }
            }else{
              personal[0] = '';
            }//fin if(data.personal != null)

            if(data.bancos != null){
              for(var i = 0; i < data.bancos.length; i++){
                bancos[i] =   '<tr>'+
                              '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> '+data.bancos[i].nombre_banco+'</td>'+
                              '<td>$</td>'+
                              '<td id="cantidadB">'+parseFloat(data.bancos[i].cantidad_abonada).toFixed(2)+'</td>'+
                              '</tr>';
              }
            }else{
              bancos[0] = '';
            }

            if(data.viaticos_extra != null){
              if(parseFloat(data.viaticos_extra[0].consumo_ruta) > 0){
                viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Extra</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_extra[0].consumo_ruta).toFixed(2)+'</td>'+
                                '</tr>';

              } 
            }

            if(data.viaticos_permanente != null){
              if(parseFloat(data.viaticos_permanente[0].consumo_ruta) > 0){
                viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Permanente</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_permanente[0].consumo_ruta).toFixed(2)+'</td>'+
                                '</tr>';

              } 
            }

            if(data.viaticos_ruta != null){
                if(parseFloat(data.viaticos_ruta[0].consumo_ruta) > 0){
                viaticos[0] +=   '<tr>'+
                              '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Comusumo ruta</td>'+
                              '<td>$</td>'+
                              '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].consumo_ruta).toFixed(2)+'</td>'+
                              '</tr>';
              }

                if(parseFloat(data.viaticos_ruta[0].depreciacion) > 0){
                  viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Depreciaciòn</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].depreciacion).toFixed(2)+'</td>'+
                                '</tr>';

                }              

                if(parseFloat(data.viaticos_ruta[0].llanta_del) > 0){
                  viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Llanta delantera</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].llanta_del).toFixed(2)+'</td>'+
                                '</tr>';

                }
                if(parseFloat(data.viaticos_ruta[0].llanta_tra) > 0){
                  viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Llanta tracer</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].llanta_tra).toFixed(2)+'</td>'+
                                '</tr>';

                }
                if(parseFloat(data.viaticos_ruta[0].mant_gral) > 0){
                  viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Mant. Gral</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].mant_gral).toFixed(2)+'</td>'+
                                '</tr>';

                }
                if(parseFloat(data.viaticos_ruta[0].aceite) > 0){
                  viaticos[0] +=   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span> Aceite</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.viaticos_ruta[0].aceite).toFixed(2)+'</td>'+
                                '</tr>';
                }

                

            }else if(data.viaticos_extra == null && data.viaticos_permanente == null && data.viaticos_ruta == null){
              viaticos[0] = '';
            }

            //WM12012023 separacion de comisiones segun su tipo
            if(data.comisiones != null){      
           for(var i=0; i < data.comisiones.length; i++){
             if(data.comisiones[i].estado == 1){
               comision[i] =   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span>Comision por cartera</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.comisiones[i].bono).toFixed(2)+'</td>'+
                                '</tr>';

             }else if(data.comisiones[i].estado == 2){
               comision[i] =   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span>Comision por recuperacion</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.comisiones[i].bono).toFixed(2)+'</td>'+
                                '</tr>';
           }else if(data.comisiones[i].estado == 3){
               comision[i] =   '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span>Comision por colocacion</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.comisiones[i].bono).toFixed(2)+'</td>'+
                                '</tr>';
           }else if(data.comisiones[i].estado == 4){
               comision[i] =  '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span>Comision extra</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.comisiones[i].bono).toFixed(2)+'</td>'+
                                '</tr>';
           }else if(data.comisiones[i].estado == 5){
            comision[i] =  '<tr>'+
                                '<td id="titulosB"><span class="glyphicon glyphicon-arrow-right"></span>Comision por asesor del mes</td>'+
                                '<td>$</td>'+
                                '<td id="cantidadB">'+parseFloat(data.comisiones[i].bono).toFixed(2)+'</td>'+
                                '</tr>';
           }
         }
       }

            $('#recibido').append(
              '<div  style="margin: 5px;text-align: left;width: 400px; float: left;">'+
              img+
              '<img '+margin+'  src="<?= base_url();?>assets/images/'+data.datos[0].img+'" id="logo_permiso">'+
              
              '<div style="margin: 5px;text-align: center; width: 200px; float: right;text-transform: uppercase;" >'+
              '<b>'+titulo_gob+
              'BOLETA DE PAGO</b>'+             //WM12012023 Se hizo un solo div para optimizar el espacio de la boleta
              '<br>'+
              '<b>'+data.actual+'</b>'+
              '<br>'+
              '<b>'+data.fecha+'</b>'+
              '</div>'+
              '</div><br>'+

              '<table class="table table-bordered" id="tabla_boleta">'+
              '<thead>'+
              '<tr>'+
              '<th style="border: none;" colspan="4">DATOS DEL EMPLEADO</th>'+
              '</tr>'+
              '</thead>'+
              '<tbody>'+
              '<tr>'+
              '<td style="border:1px solid;"><b>Nombres</b></td>'+
              '<td style="border:1px solid;"><b>Apellidos</b></td>'+
              '<td style="border:1px solid;"><b>DUI</b></td>'+
              '<td style="border:1px solid;"><b>Cargo</b></td>'+
              '</tr>'+
              '<tr>'+
              '<td style="border:1px solid"><b>'+data.datos[0].nombre+'</b></td>'+
              '<td style="border:1px solid"><b>'+data.datos[0].apellido+'</b></td>'+
              '<td style="border:1px solid"><b>'+data.datos[0].dui+'</b></td>'+
              '<td style="border:1px solid"><b>'+data.datos[0].cargo+'</b></td>'+
              '</tr>'+
              '</tbody>'+
              '</table>'+
              '<table class="table table-bordered">'+
              '<thead>'+
              '<tr>'+
              '<th style="border:1px solid;" id="celdas" colspan="2">N° de dias trabajados:'+parseFloat(data.datos[0].dias).toFixed(2)+'</th>'+
              '</tr>'+
              '<tr>'+
              '<th style="border:1px solid; width: 50%;" id="celdas">REMUNERACIONES</th>'+
              '<th style="border:1px solid;" id="celdas">RETENCIONES/DESCUENTOS</th>'+
              '</tr>'+
              '</thead>'+
              '<tbody>'+
              '<tr>'+
              '<td style="border:1px solid"> '+
              '<table class="table table-bordered" style="border: hidden">'+
              '<tr>'+
              '<td id="titulosB">Salario Devengado</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].sueldo_bruto).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">Comisión</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].comision).toFixed(2)+'</td>'+
              '</tr>'+
              comision.join('')+                         //WM12012023 se agrego para mostrar tipo de comisiones 
              '<tr>'+
              '<td id="titulosB">Gratificación</td>'+   //WM12012023 Se cambio el nombre de bono a gratificacion
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].bono).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">Horas Extras</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].horas_extras).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">Viático</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].viaticos).toFixed(2)+'</td>'+
              '</tr>'+
              viaticos.join('')+
              '<tr>'+
              '<td id="titulosB">TOTAL DEVENGADO</td>'+
              '<td style="border-top:double;">$</td>'+
              '<td id="cantidadB" style="border-top:double;">'+parseFloat(data.total_dev).toFixed(2)+'</td>'+
              '</tr>'+
              '</table>'+
              '</td>'+

              '<td style="border:1px solid">'+
              '<table class="table table-bordered" style="border: hidden">'+
              '<tr>'+
              '<td id="titulosB">ISSS</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].isss).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">AFP/IPSFA</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].afp_ipsfa).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">ISR</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].isr).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">Total Anticipo</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].anticipos).toFixed(2)+'</td>'+
              '</tr>'+
              anticipo.join('')+
              herramientas.join('')+
              '<tr>'+
              '<td id="titulosB">Faltantes</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].descuentos_faltantes).toFixed(2)+'</td>'+
              '</tr>'+
              '<tr>'+
              '<td id="titulosB">Total Prestamo Interno</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].prestamo_interno).toFixed(2)+'</td>'+
              '</tr>'+
              interno.join('')+
              '<tr>'+
              '<td id="titulosB">Prestamo personal</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].prestamo_personal).toFixed(2)+'</td>'+
              '</tr>'+
              personal.join('')+
              '<tr>'+
              '<td id="titulosB">Total Bancos</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].orden_descuento).toFixed(2)+'</td>'+
              '</tr>'+
              bancos.join('')+
              '<tr>'+
              '<td id="titulosB">Descuento de horas</td>'+
              '<td>$</td>'+
              '<td id="cantidadB">'+parseFloat(data.datos[0].horas_descuento).toFixed(2)+'</td>'+
              '</tr>'+
              '<td id="titulosB">TOTAL DEDUCCIONES</td>'+
              '<td style="border-top:double;">$</td>'+
              '<td id="cantidadB" style="border-top:double;">'+parseFloat(data.total_ded).toFixed(2)+'</td>'+
              '</tr>'+
              '</table>'+
              '</td>'+
              '</tr>'+
              '</tbody>'+
              '</table>'+
              '<div class="col-sm-6"></div>'+
              '<div class="col-sm-6" style="margin-top: 0.1%; border:1px solid; border-radius: 15px;">'+
              '<div class="row" style="margin: 10px">'+
              '<div class="col-sm-6"><b>TOTAL A PAGAR</b></div>'+
              '<div class="col-sm-2"></div>'+
              '<div class="col-sm-4"><label> $'+parseFloat(data.datos[0].total_pagar).toFixed(2)+'</label></div>'+
              '</div>'+
              '</div>'+

              '<div class="col-sm-12" style="margin-top: 4%; margin-bottom: 1%">'+
              '<div class="row">'+
              '<center><div class="col-md-6" id="firma_auto"><b>__________________________<br>'+
              data.autorizante+'<br>'+
              'Firma Realiza Pago</b></div></center>'+
              '<center><div class="col-md-6" id="jefe_inme"><b>__________________________<br>Firma Empleado<br>N° DUI: '+data.datos[0].dui+' <br> N° NIT: '+data.datos[0].nit+'</b></div></center>'+
              '</div>'+
              '</div>'

            );

          }else{
            $('.ocultar').hide();
            document.getElementById('validacion').innerHTML = data.validacion;
            $('#recibido').append(
              '<div class="row">'+
              '<div class="col-sm-1"></div>'+
              '<div class="col-sm-10">'+
              '<div class="panel panel-danger">'+
              '<div class="panel-heading">Boleta de pago</div>'+
              '<div class="panel-body">No se ha encontrado boleta</div>'+
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
          this.disabled=false;
        }
      });
  };
        
});//Fin jQuery
  
</script>