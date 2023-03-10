<meta charset="utf-8">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/impresion_estilo/impresion_estilos.css" >
<?php
setlocale(LC_TIME, 'es_ES.UTF-8');
//header("Content-type: application/vnd.ms-word");
//header("Content-Disposition: attachment;Filename=acta_entrega_motocicleta_".$info_repor[0]->nombre.'_'.$info_repor[0]->apellido.".doc");

print_r($info_repor);
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
		<p style="text-align: center;">ACTA DE ENTREGA DE MOTOCICLETA</p>
		<p>Recibí de la empresa <span style="text-transform: uppercase;"><?= $info_repor[0]->nombre_empresa ?></span> una motocicleta.</p>
		<p>Marca: <b>_______</b>  Modelo: <b>_______</b>  COLOR:<b> _______</b> PLACAS: <b>_______</b></p>
		<span>Destinado al uso en el ámbito laboral.</span><br>
		<span>La motocicleta es recibida, con su respectiva tarjeta de circulación y una llave.</span><br>
		<span>Correrán por cuenta del empleado, los mantenimientos preventivos, los gastos que se produzcan por desperfectos, o accidentes.</span><br>

		<span>El equipo que aquí se entrega es propiedad de la empresa, y se da en concepto de arrendamiento para un plazo de <?= $info_repor[0]->plazo_quincena; ?> cuotas <?php if ($info_repor[0]->nombre_plazo=='Quincena'){echo "quincenas ";}else if($info_repor[0]->nombre_plazo=="Meses"){echo "mensuales ";}else if($info_repor[0]->nombre_plazo=="Años"){echo "anuales ";} ?>, en caso de renuncia o despido del empleado, este deberá entregar la motocicleta, tarjeta de circulación y llave quedando la motocicleta resguardada dentro de las instalaciones de la agencia, manteniendo la opción de compra.</span><br>

		<span>En caso de finalizar el contrato a tres años, cancelando su financiamiento por $<?= number_format($info_repor[0]->monto_otorgado, 2, '.', '') ?> con cuotas de $ <?= number_format($info_repor[0]->cuota, 2, '.', '') ?> <?php if ($info_repor[0]->nombre_plazo=='Quincena'){echo "quincenal";}else if($info_repor[0]->nombre_plazo=="Meses"){echo "mensual";}else if($info_repor[0]->nombre_plazo=="Años"){echo "anual";} ?>, por un plazo de <?= $info_repor[0]->quincenas_letras ?> quincenas o su valor equivalente en el contrato del préstamo la motocicleta será propiedad del empleado y se procederá a su traspaso.</span><br>

		<span>Para constancia se firman dos ejemplares de la presente acta, en <?php if ($info_repor[0]->agencia=='Administracion'){echo "San Salvador";}else{echo $info_repor[0]->agencia; } ?> a los <?= date("j")." días de ".strftime("%B")." de ".date("Y"); ?>. </span><br><br>
		<span>Recibido</span><br>
		<span>F.____________________________</span><br>
		<span>Empleado: <?= $info_repor[0]->nombre.' '.$info_repor[0]->apellido ?></span><br>
		<span>Cargo:  <?= $info_repor[0]->cargo ?></span><br><br>

		<span>Entregado</span><br>
		<span>F.____________________________</span><br>
		<span> <?= $info_aut[0]->nombre.' '.$info_aut[0]->apellido ?></span><br>
		<span>Cargo: <?= $info_aut[0]->cargo ?></span><br><br>
	</div>
</body>
</html>