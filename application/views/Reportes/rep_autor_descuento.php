<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=documento.doc");
print_r($info_repor);
?>
<!DOCTYPE html>
<html>
<!--inicio para poder hacer un footer-->
<style>
p.MsoFooter, li.MsoFooter, div.MsoFooter{
margin: 0cm;
margin-bottom: 0001pt;
font-size: 12.0 pt;
text-align: right;
}

@page Section1{
mso-footer:f1;
}
div.Section1 { page:Section1;}
</style>
<!--Fin para poder hacer un footer-->
</head>
<body>
<div class="Section1">
<div class='col-sm-6'>
      <img src="<?= base_url();?>\assets\images\watermark2.png" width="120" height="45"/>                
</div>
	<div class="col-sm-12 principal Section1" style="font-family:Arial; font-size: 14px; line-height: 1.5em;">
		<p>
			<b>Autorización de descuentos sobre salarios por préstamo personal al empleado por adquisición de </b>
		</p>

		<p>
			<b>Valor del Préstamo  Personal:
				<span style="text-decoration:underline; "><?= $info_repor[0]->monto_letras ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$ <?=number_format($info_repor[0]->monto_otorgado, 2, '.', '')?>
				</span>
			</b>
		</p>

		<p>
			<b>Total de Financiamiento: </b>
		<span style="text-decoration:underline; ">
			<b><?php for ($i=0; $i <40 ; $i++) { ?>&nbsp;&nbsp;<?php } ?></b>
		</span>
		</p>

		<p>
			<b>Nombre del empleado:
				<span style="text-decoration:underline;"><?= $info_repor[0]->nombre.' '.$info_repor[0]->apellido ?></span>
			</b>
		</p>

		<span style="text-decoration: underline;">Constancia de recibo autorización</span><br><br>
		<span>
			Recibí de la sociedad
			<span style="text-transform: uppercase;"><?= $info_repor[0]->nombre_empresa ?></span>
			la suma de 
			<b>
				<span style="text-decoration: underline;"><?= $info_repor[0]->monto_letras ?></span>
			</b>, en calidad de préstamo, con una tasa de interés del dos punto cincuenta por ciento mensual.
		</span><br>

		<span>Por lo anterior, autorizo expresamente al pagador de la empresa para que se me descuente de mis salarios de la siguiente forma:</span>

		<ol type="a">
			<li>
				<span style="text-decoration: underline;"><?= $info_repor[0]->plazo_quincena ?></span> Cuotas por valor <span style="text-decoration:underline; "> <?= $info_repor[0]->monto_letras ?> $ <?=number_format($info_repor[0]->cuota, 2, '.', '')?></span> que serán descontadas en cada pago <?php if ($info_repor[0]->nombre_plazo=='Quincena'){echo "quincenal";}else if($info_repor[0]->nombre_plazo=="Meses"){echo "mensual";}else if($info_repor[0]->nombre_plazo=="Años"){echo "anual";} ?>.
			</li>
		</ol><br>

		<span>Así mismo autorizo expresamente al empleador para que retenga y cobre de mi liquidación final de prestaciones sociales, salarios e indemnizaciones los saldos que este adeudando, si llegase a finalizar mi contrato de trabajo antes de completar el pago total de este préstamo.</span><br>

		<p>Recibí conforme:</p><br><br>

		<p align="center">Firma.____________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Firma.____________________</p>
		<p align="center">DUI: <?= $info_repor[0]->dui ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Autoriza:</p>
</div>
<br clear=all style="mso-special-character:line-break;page-break-after:always" />
<div style="mso-element:footer" id="f1">
<p class=MsoFooter><span style="text-align: center;mso-field-code:" PAGE=""><?= $info_repor[0]->direccion ?><br> Telefono: <?= $info_repor[0]->tel ?></span>
</p>
</div>
</body>
</html>
