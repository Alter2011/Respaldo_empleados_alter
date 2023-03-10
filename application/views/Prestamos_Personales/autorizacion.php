<style type="text/css">
    .texto_pres{
      margin-left: 10%; 
      margin-right:10%;
    }
    .imagen_pres{
      float: left;
      margin-top: 10px;
      margin-left: 10%;
    }
    .imagen_pres2{
      float: left;
      margin-top: 10px;
      margin-left: 10%;
    }
    .constancia_pres{
      margin: 10px;
      text-align: right;
    }
    .logoC_pres{
      width: 170px;
      height: 70px;
    }
    .titulo_pres{
      font-weight: bold;
    }
    .hr1_pres{
      height: 5px;
      background-color: #872222;
    }
    .hr1_pres2{
      height: 5px;
      background-color: #872222;
    }
    .hr2_pres{
      height: 2px;
      background-color: #872222;
      margin-top: -2%;
    }
    .hr_div{
      border: 0 ; 
      border-top: 4px double #337AB7; 
      width: 90%;
    }
    .encabezado_pres{
      text-align: right;
      margin-right: 5%;
    }
    
    @media print{
      .encabezado_pres{
        font-size: 10px;
        text-align: right;
      }
      .imagen_pres{
        margin-top: 5%;
        margin-left: 3%;
      }
      .imagen_pres2{
        margin-bottom: 5%;
        margin-right:-20%;
      }

      .hr1_pres{
        margin-top: 25%;
        display: block;
        border-color: #872222;
        border-width:5px;
      }
      .hr2_pres{
        display: block;
        border-color: #872222;
        margin-top: -4%;
        border-width:2px;
      }
      .hr1_pres2{
        margin-top: 5%;
        display: block;
        border-color: #872222;
        border-width:5px;
      }
      .negrita_pres{
        font-weight: bold;
        font-size: 12px;
      }
      .pie_pag_pres{
        margin-top: -3%;
        font-size: 15px;
      }
      .firmas_pres{
        font-size: 12px;
      }
      .hr_div{
        display: none;
      }
    }
</style>
<div class="col-sm-10" id="impresion_boleta">
  <div class="text-center well text-white blue" id="boletas">
        <h2>Autorizacion/Orden de descuento</h2>
    </div>

    <a class="btn btn-success crear ocultar" id="btn_permiso"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
    <div class="col-sm-12">
        <?php if($id_empresa == 1){ ?>
          <div class="imagen_pres">
              <img class="logoC_pres" src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
            </div><br><br><br><br><br>
                    
        <?php }else if($id_empresa == 2){ ?>
            <div class="imagen_pres">
              <img class="logoC_pres" src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
            </div><br><br><br><br><br>
            
        <?php } ?>

        <div class="constancia_pres">
            <h4 class="titulo_pres"><?php echo $fecha; ?></h4>
        </div>
        <br><br>
        <div class="texto_pres">
          <h5 class="titulo_pres">Autorización de descuentos sobre salarios por préstamo personal al empleado.</h5><br>
            <div class="row">
              <div class="col-sm-4"><b class="negrita_pres">Valor del Préstamo  Personal:</b></div>
              <div class="col-sm-5"><b class="negrita_pres" style="text-decoration: underline;"><?php echo $otorgadoL; ?></b></div>
              <div class="col-sm-2"><b class="negrita_pres">$<?php echo $otorgado; ?></b></div>
            </div><br>
            <div class="row">
              <div class="col-sm-4"><b class="negrita_pres">Total de Financiamiento:</b></div>
              <div class="col-sm-5"><b class="negrita_pres" style="text-decoration: underline;"><?php echo $finanziamientoL; ?></b></div>
              <div class="col-sm-2"><b class="negrita_pres">$<?php echo $finanziamiento; ?></b></div>
            </div><br>
            <div class="row">
              <div class="col-sm-4"><b class="negrita_pres">Monto a Entregar:</b></div>
              <div class="col-sm-5"><b class="negrita_pres" style="text-decoration: underline;"><?php echo $entregarL; ?></b></div>
              <div class="col-sm-2"><b class="negrita_pres">$<?php echo $entregar; ?></b></div>
            </div><br>
            <div class="row">
              <div class="col-sm-4"><b class="negrita_pres">Nombre del Empleado:</b></div>
              <div class="col-sm-5"><b class="negrita_pres" style="text-decoration: underline;"><?php echo $Empleado; ?></b></div>
              <div class="col-sm-2"><b class="negrita_pres"></b></div>
            </div><br><br>

            <h5 class="titulo_pres">Constancia de recibo de autorización</h5>

            <h5 class="text-justify" style="line-height: 1.5;">
              Recibí de la sociedad <?php echo $empresa ?> la suma de <?php echo $recibido ?> , en calidad de préstamo, con una tasa de interés del <?php echo $tasa ?> quincenal.
            </h5>

            <h5 class="text-justify" style="line-height: 1.5;">
              Por lo anterior, autorizo expresamente al pagador de la empresa para que se me descuente de mis salarios de la siguiente forma:
            </h5>

            <h5 class="text-justify" style="line-height: 1.5;">
              a) <?php echo $plazo ?> Cuotas por valor <?php echo $cuotaL ?> ($<?php echo $cuota ?>) que serán descontadas en cada pago quincenal.
            </h5>

            <h5 class="text-justify" style="line-height: 1.5;">
              Así mismo autorizo expresamente al empleador para que retenga y cobre de mi liquidación final de prestaciones sociales, salarios e indemnizaciones los saldos que este adeudando, si llegase a finalizar mi contrato de trabajo antes de completar el pago total de este préstamo.
            </h5>

            <h5 class="text-justify" style="line-height: 1.5;">
              Recibí conforme:
            </h5><br><br><br><br>

            <div class="row">
              <div class="col-sm-6"><span class="firmas_pres">F_______________________</span></div>
              <div class="col-sm-3"><b></b></div>
              <div class="col-sm-5"><span class="firmas_pres">F_______________________</span></div>
            </div>
            <div class="row">
              <div class="col-sm-6"><span class="firmas_pres"><?php echo $empleado ?></span></div>
              <div class="col-sm-3"><b></b></div>
              <div class="col-sm-5"><span class="firmas_pres">Iris Indira Mayen de Alvarado</span></div>
            </div>
            <div class="row">
              <div class="col-sm-6"><span class="firmas_pres">DUI:<?php echo $dui ?></span></div>
              <div class="col-sm-3"><b></b></div>
              <div class="col-sm-5"><span class="firmas_pres">Autoriza</span></div>
            </div>
            <br><br>
            <hr class="hr1_pres"><hr class="hr2_pres">
            <p class="pie_pag_pres"><?= $casa ?><br>
            Tel: 2448-0554 </p>
        </div><br>

        <div style="margin-top:15px;page-break-before: always">  

        <hr class="hr_div"><br>
        <?php if($id_empresa == 1){ ?>
          <div class="imagen_pres2">
              <img class="logoC_pres" src="<?= base_url();?>\assets\images\watermark.png" id="logo_empre">
            </div><br><br><br><br><br>
                    
        <?php }else if($id_empresa == 2){ ?>
            <div class="imagen_pres2">
              <img class="logoC_pres" src="<?= base_url();?>\assets\images\AlterOcci.png" id="logo_empre">
            </div><br><br><br><br><br>
            
        <?php } ?>

        <div>
          <h4 style="text-align: center;">Orden Irrevocable de descuento</h4>
        </div>
        <div class="encabezado_pres">
            <h5><?php echo $fecha; ?></h5>
          </div>
        <div class="texto_pres">
          <h5>
            Señores<br><br>
            Empresa: <?php echo $empresa; ?><br><br>
            Estimados señores:<br>
          </h5>

          <h6 class="text-justify" style="line-height: 1.5;">
            Informamos a usted(es) que hemos concedido a la  Señor(a): <?php echo $Empleado; ?>, empleado(a) de esa empresa, el crédito Nº <?php echo $cantidadP; ?> por valor de <?php echo $recibido; ?> pagaderos por medio de cuotas mensuales en el plazo de <?php echo $meses; ?> meses.<br>
            Al respecto, muy atentamente le(s) solicitamos que de acuerdo a lo convenido con la señor(a) <?php echo $Empleado; ?>, y la autorización suscrita por el (ella) mismo (a) al pie de esta nota, a partir del pago correspondiente al mes de <?php echo $mes; ?>, se le descuente o retenga de sus ingresos, <?php echo $cuotaL ?> c/u durante <?php echo $plazo ?> Cuotas y el saldo al final del plazo, agradeciéndole (s) hacer la remisión por medio de remesas en Cualquier  bancos que a continuación le detallamos.<br>

            <?php for($i = 0; $i < count($bancos); $i++){ ?>
              <?php echo $bancos[$i]->nombre_banco; ?> Cuenta Corriente No. <?php echo $bancos[$i]->numero_cuenta; ?> de <?php echo $empresa; ?><br>
            <?php } ?>

            <br>Dichas cantidades deberá abonarse a más tardar en los tres primeros días siguientes de efectuado el descuento y pueden notificarse al correo altecredit.pagaduria@gmail.com   adjuntado la remesa.<br><br>
            Le rogamos conservar una copia de la presente y devolvernos el original y el duplicado fechados, sellados y firmados, como acuse de recibo y conformidad.<br><br>
            Atentamente,<br><br>
            Departamentos de Créditos<br>
            <?php echo $empresa; ?><br><br>
            Yo, <?php echo $Empleado; ?> acuerdo con lo arriba expuesto por <?php echo $empresa; ?>, por medio de la presente autorizo expresamente a mi patrono, para que se proceda a descontar a retener de mi sueldo y demás remuneraciones que devengue, las cuotas en la forma indicada por <?php echo $empresa; ?> hasta la completa cancelación de la deuda que he contraído.<br><br>
            __________________________<br>
            Firma del Solicitante<br><br>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="text-align:left;" colspan="3">ESPACIO EXCLUSIVO (Para la empresa que se encargara de hacer los descuentos)</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td WIDTH="20%"></td>
                  <td WIDTH="20%"></td>
                  <td>Le (s) agradeceremos informar a <?php echo $empresa; ?> oportunamente cuando el empleado deje de trabaja  r en la empresa.</td>
                </tr>
                <tr>
                  <td>Lugar y Fecha</td>
                  <td>Sello y Firma</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </h6>

          <hr class="hr1_pres2"><hr class="hr2_pres">
            <p class="pie_pag_pres"><?= $casa ?><br>
            Tel: 2448-0554 </p>

        </div><br>



      </div>
    </div>

</div>
<script type="text/javascript">
$(document).ready(function(){
  $('.crear').click(function(){
        window.print();
    });
});//Fin jQuery
  
</script>