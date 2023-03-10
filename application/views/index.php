	 <?php

	 if (isset($_SESSION['login'])) {
	 	redirect(base_url()."index.php/dashboard/");
	 }


	 ?>
	 <form action="<?= base_url();?>index.php/Iniciar/login/" enctype="multipart/form-data" method="post" accept-charset="utf-8">
	 	<!--css puesto para no estorbar en el header-->
	 	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material.min.css">
	 	<link media="all" rel="stylesheet" type="text/css" href="<?php echo base_url().'assets/css/altercredit.css?'.time();?>">

	 	<div class="demo-layout mdl-layout mdl-layout--fixed-header mdl-js-layout mdl-color--grey-100">

	 		<div style="width: 100%; height: 50vh;"></div>


	 		<main class="demo-main mdl-layout__content">
	 			
	 			<div class="demo-container mdl-grid">
	 				<div class="mdl-cell mdl-cell--4-col mdl-cell--1-col-tablet mdl-cell--hide-phone"></div>
	 				<div class="mdl-color--white mdl-shadow--4dp content mdl-color-text--grey-800 mdl-cell mdl-cell--4-col mdl-cell--6-col-tablet mdl-cell--8-phone" style="border-radius: 2px; padding: 30px 20px">
	 					
	 					

	 					<div class="mdl-cell mdl-cell--hide-col mdl-cell--hide-tablet mdl-cell--hide-phone"></div>
	 					<div class="mdl-cell mdl-cell--12-col mdl-cell--10-tablet" style="text-align: left;">
	 						<img src="<?= base_url();?>\assets\images\logo.png" width="150" heigth="150"> 
	 						<center>

	 							<h4>Sistema de empleados</h4>
	 						</center>
	 						<p style="color:red"><?php if(isset($mensaje)) echo $mensaje; ?></p>
	 						<p><?=validation_errors('<div style="color:red;" class="errors">','</div>');?><!--mostrar los errores de validación-->
	 						</p>
	 						<div class="mdl-grid mdl-cell-12-col">
	 							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
	 								<input class="mdl-textfield__input"   type="text" id="usuario" name="usuario" style="width: 100%;">
	 								<label class="mdl-textfield__label" for="sample1">Usuario</label>
	 							</div>

	 							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" style="width: 100%;">
	 								<input class="mdl-textfield__input"  type="password" id="contraseña" name="contraseña" style="width: 100%;">
	 								<label class="mdl-textfield__label" for="sample1">Contraseña</label>
	 							</div>
	 						</div>
	 						
	 						
	 						<div class="mdl-grid" style="padding: 0;">
	 							<div class="mdl-cell mdl-cell--6-col mdl-cell--hide-phone-phone"></div>
	 							<div class="mdl-cell mdl-cell--6-col">
	 								<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" style="float: right;">
	 									Iniciar sesión
	 								</button>
	 							</div>
	 						</div>
	 					</div>
	 				</center>
	 			</div>

	 		</div>
	 	</form>

