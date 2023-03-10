<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=pagare_sin_protesto_".$info_repor[0]->nombre.'_'.$info_repor[0]->apellido.".doc");

//print_r($info_repor);
//print_r($info_aut);	faltan detalles de nombres: quincenas mensuales anuales y tambien lugar de emision 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class='col-sm-6'>
	<img src="<?= base_url();?>\assets\images\watermark2.png" width="120" height="45"/>               
</div>
	<div class="principal" style=" font-family:Arial; font-size: 15px; line-height: 1.5em;">
	
      <div class="col-sm-5">
      </div>
      <div class="col-sm-6" style="text-align: right;">
        <p>Agencia<?php echo ", ". date("j")." de ".strftime("%B")." de ".date("Y"); ?></p>
      </div>
    </div>
    <div id="margen">
      <center>
        <h4>PAGARÉ SIN PROTESTO</h4> 
      </center>
    </div><br>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
          <p style="font-size: 15px">Por este PAGARE SIN PROTESTO, me obligo a pagar a la orden de _______________ el día ______________ del mes _____________ del año ____ en sus oficinas en la Ciudad de AGENCIA, la cantidad de ________________ Dólares de los Estados Unidos de América, más intereses del __________ por ciento anual; y en caso de no ser pagados el capital y los intereses en la fecha de vencimiento, pagaré intereses moratorios del ________ por ciento anual.</p>
          <p style="font-size: 15px">Para los efectos legales de esta obligación Mercantil, fijo como domicilio especial la Ciudad de NOMBRE DE AGENCIA, Departamento de NOMBRE DEL DEPARTAMENTO y en caso de ejecución renuncio al derecho de apelar del decreto de embargo, sentencia de remate y de cualquier resolución que admita este recurso y que se pronuncie en el Juicio Mercantil Ejecutivo correspondiente; será depositario de los bienes que se embarguen la persona designada por el Acreedor, a quien relevo de la obligación de rendir fianza; será a mi cargo todos los gastos que hiciere el Acreedor en el cobro de esta deuda, inclusive los llamados personales y aunque no sea especialmente condenado en costas procesales. </p><br><br>
        <p style="font-size: 15px">En fe de lo anterior, firmo este PAGARE SIN PROTESTO en la ciudad de________________, Departamento de  _________________, el día_________del mes de_____________ de dos mil______.</p><br><br>
        <p style="font-size: 15px">NOMBRE: <label style="font-size: 15px"><?= $info_repor[0]->nombre.' '.$info_repor[0]->apellido ?></label></p> 
        <p style="font-size: 15px">DUI: <label style="font-size: 15px"><?= $info_repor[0]->dui?></label></p>
        <p style="font-size: 15px">DIRECCION: <label style="font-size: 15px"><?= $info_repor[0]->direccion1?></label></p>
        <p style="font-size: 15px">F:__________________________</p><br> 
        <div class="col-sm-1"></div>
      </div>
    </div>
</body>
</html>