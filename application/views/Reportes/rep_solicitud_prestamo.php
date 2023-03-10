<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=cancelacion_deuda".$info_repor[0]->nombre.'_'.$info_repor[0]->apellido.".doc");
print_r($agencia);
$modelo='';
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
		<p style="text-align: center;"><b>SOLICITUD DE PRESTAMOS PARA EMPLEADOS</b></p><br>

		<span ><b>Monto: $__________<?php for ($i=0; $i <40 ; $i++) { ?>&nbsp;<?php } ?>Plazo ___ meses </b></span><br><br>

		<span><b>Nombre:</b>_________________________________________________________________</span><br>
		<span><b>Dirección:</b>_________________________________________________________________</span>
		<hr>
		<span><b>No. de DUI: </b></span><br>
		<span><b>No. de NIT: </b></span>
		
		<p style="text-align: center;"><b>Referencias: </b></p>

		<p style="text-decoration: underline;"><b>Familiar</b></p>
		<span><b>Nombre: </b>___________________________________________Parentesco:_______________</span><br>
		<span><b>Dirección:</b>____________________________________________________________________________________________________________________Teléfono:_________________</span>

		<p style="text-decoration: underline;"><b>Personal</b></p>
		<?php for ($i=0; $i < 2 ; $i++) { ?>
			<span><b>Nombre: </b>__________________________________________________________</span><br>
		<span><b>Dirección:</b>____________________________________________________________________________________________________________________Teléfono:_________________</span><br><br>
		<?php } ?>

<br clear=all style="mso-special-character:line-break;page-break-after:always" />
<div style="mso-element:footer" id="f1">
<p class=MsoFooter><span style="text-align: center;mso-field-code:" PAGE=""><?= $agencia->direccion ?><br> Teléfono: <?= $agencia->tel ?></span>
</p>
</div>
</body>
</html>
