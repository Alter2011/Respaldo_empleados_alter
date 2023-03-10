<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=cancelacion_deuda".$info_repor[0]->nombre.'_'.$info_repor[0]->apellido.".doc");

//print_r($info_repor);
	if ($info_repor[0]->fecha_fin!=null) {
 		$fecha_expe = strftime("%d de %B de %Y", strtotime($info_repor[0]->fecha_fin));
	}else{
		$fecha_expe ='______';
	}
//print_r($info_aut);	faltan detalles de nombres: quincenas mensuales anuales y tambien lugar de emision 
?>
<!DOCTYPE html>
<html>
<!--inicio para poder hacer un footer-->
<style>

	.letra{
		font-size: 18px;
	}
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
		<p class="letra" style="text-align: center;"><b>DEUDA DE CANCELACION</b></p><br><br>

		<p class="letra">Por medio de la presente se hace constar que el señor <?= $info_repor[0]->nombre.' '.$info_repor[0]->apellido ?>,  da por finalizado el crédito personal que poseía con la empresa <?= $info_repor[0]->nombre_empresa?>  en concepto de adquisición de ___________,  por un monto de <?= $info_repor[0]->monto_letras?>($<?= number_format($info_repor[0]->monto_otorgado, 2, '.', '') ?>), cancelándolo en su totalidad el día <?php echo $fecha_expe; ?>.</p>

		<p class="letra">Detalle de las características de _____________.</p><br>

		<span class="letra">Marca:_____________________</span><br>
		<span class="letra">Modelo:____________________</span><br>
		<span class="letra">Placa:_____________________</span><br><br><br><br>

		<p class="letra">Y para los usos que se estime conveniente se extiende la presente en la ciudad de Santa Ana a los <?= date("j")." días de ".strftime("%B")." de ".date("Y"); ?>.</p>

		<div class='col-sm-6' style="text-align: center;">
			<img src="<?= base_url();?>\assets\images\firma_vacacion.png" width="270" height="170"/>               
		</div>
	</div>

<br clear=all style="mso-special-character:line-break;page-break-after:always" />
<div style="mso-element:footer" id="f1">
<p class=MsoFooter><span style="text-align: center;mso-field-code:" PAGE=""><?= $info_repor[0]->direccion ?><br> Telefono: <?= $info_repor[0]->tel ?></span>
</p>
</div>
</body>
</html>
