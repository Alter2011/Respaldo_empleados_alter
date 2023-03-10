
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material.min.css">


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/material/material-icons.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/material.min.js"></script>

<script type="text/javascript">
	$("button").on('click', function(form){
		form.preventDefault();
	});
</script>


<?php if (isset($perfil_add)): ?>
	<script type="text/javascript">
    $(document).ready(function(){
       $('#add-button').on('click', function(form){
				form.preventDefault();
	            $.post('<?php echo $ajax_url ?>', $('form.jsform').serialize(), function(data){
	                if (data.status == "success"  && data.nombre == "Correct" && data.desc == "Correct" ) {
	                	 alert("Perfil Creado Correctamente"); 
	                	  window.location.href = "<?php echo site_url() ?>/Perfiles/ver/"+data.id_perfil;                          
	                }else{
	                	if (data.nombre == "Incorrect") {
	                		alert("Porfavor ingrese un nombre de perfil valido");
	                	}else{
	                		alert("Porfavor ingrese una descripcion al perfil");
	                	};
	                }
	               
	        }, "json");
			
        });
    });
 </script>

<?php endif ?>




<?php if (isset($perfil_edit)): ?>

	<script type="text/javascript">
    $(document).ready(function(){
       $('#edit-button').on('click', function(form){
				form.preventDefault();
				
	            $.post('<?php echo $ajax_url ?>', $('form.jsform').serialize(), function(data){

	                if (data.status == "success"  && data.nombre == "Correct" && data.desc == "Correct" ) {
	                	 alert("Perfil modificado con exito");
	                	 window.location.href = "<?php echo site_url() ?>/Perfiles/ver/"+data.id;
	                }else{

	                	if (data.nombre == "Incorrect") {
	                		alert("Porfavor ingrese un nombre de perfil valido");
	                	}else{
	                		alert("Porfavor ingrese una descripcion al perfil");
	                	};

	                }
	               
	        }, "json");
			
        });
    });
    </script>
<?php endif ?>

<style type="text/css">

	.table-responsive>.fixed-column {
    position: absolute;
    display: inline-block;
  	margin: -1px;
  	margin-left: -13px; 
    width: 8% !important;
    z-index: 0;
    box-shadow: none;
}

@media(max-width:768px) {
    .table-responsive>.fixed-column {
       display: none;
    }
}
.demo-content{
	max-width: 100%;
}

tr:first-child {
	width: 100px !important;
}
</style>

    <?php if (isset($perfil_edit)): ?>
    <?php echo form_open('Perfiles/modificar', array('class'=>'jsform')); ?>
<?php endif ?>
<?php if (isset($perfil_crud)): ?>
<?php endif ?>
   <?php if (isset($perfil_add)): ?>
    <?php echo form_open('Perfiles/insertar', array('class'=>'jsform')); ?>
<?php endif ?>

    <div class="mdl-grid demo-content" style="margin: 10px;">

	  <div class="mdl-cell mdl-cell--6-col">

	  		<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
	    		<input class="mdl-textfield__input" type="text" name="data_perfil_nombre" id="data_perfil_nombre" <?php if (isset($perfil_view)) { echo "disabled='true'"; } ?> value="<?php if (isset($perfil)) { echo $perfil->nombre; } ?>">
	    		<label class="mdl-textfield__label" for="data_perfil_nombre">Nombre</label>
	  		</div>

	  </div>

	  <div class="mdl-cell mdl-cell--6-col">
	  			<i style="color: rgb(33,150,243);">Descripción:</i>
	  			<br>
	    		<textarea placeholder="..." rows="3" name="data_perfil_descr" id="data_perfil_descr" <?php if (isset($perfil_view)) { echo "disabled='true'"; } ?> style="width: 100%;"><?php if (isset($perfil)) { echo $perfil->descripcion; } ?></textarea>
	  </div>

		  <?php if (isset($perfil_edit)): ?>
	  	  <div style="display: none"><input type="hidden" name="data_perfil_id" value="<?php if (isset($perfil)) {
	  	echo $perfil->id_perfil;
	  } ?>"></div>
	  <?php endif ?>
	
	<?php if (isset($perfil_add)): ?>
	  	  <div style="display: none"><input type="hidden" name="data_perfil_id" value="<?php if (isset($perfil)) {
	  	echo $perfil->id_perfil;
	  } ?>"></div>
	  <?php endif ?>
	  
	
	  <div class="mdl-cell mdl-cell--12-col table-responsive" style=" overflow-x: auto;
    width: 100%;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">
	  	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" width="100%" style="text-align: right;">
		    <thead>
		    	<tr>
		    		<td colspan="3"><center><strong>PERMISOS</strong></center></td>
		    		<td colspan="2">
		    			<?php if (!isset($perfil_view)): ?>
		    				<?php if (isset($perfil_edit)): ?>
		    				<a id="check_rest" style="text-decoration: none; cursor: pointer;">Restablecer</a>
			    			/	
		    				<?php endif ?>
		    				<a id="check_all" style="text-decoration: none; cursor: pointer;">Marcar todos</a>
			    			/
			    			<a id="uncheck_all" style="text-decoration: none; cursor: pointer;">Desmarcar todos</a>
		    			<?php endif ?>
		    			
		    		</td>
		    	</tr>
		    </thead>
		    <tbody>
		    	
		    	<?php $i = 0; ?>
		    	<?php $cont= 0;  ?>
		    	<?php if (isset($permisos)): ?>
		    		<?php foreach ($permisos as $permiso): ?>
						<?php if ($i==0) : ?> 
							<tr>
								<td></td>
						<?php $cont++; endif ?>
			    			<td>
								<label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" style="text-align: left;" for="checkbox_<?php echo $permiso->id_permiso ?>">
						  			<input type="checkbox" name="checkbox_<?php echo $permiso->id_permiso ?>" id="checkbox_<?php echo $permiso->id_permiso ?>" class="mdl-checkbox__input" <?php if ($permiso->agregado == "true") { echo "checked"; } ?> <?php if (isset($perfil_view)) { echo "disabled='true'"; } ?>>
						  			<span class="mdl-checkbox__label"><?php echo $permiso->nombre ?></span>
								</label>
							</td>
						<?php $i++; ?>
						<?php if ($i==4) { echo "</tr>"; $i=0; } ?>
							
		    		<?php endforeach ?>
					
					</tr>
		    	<?php endif ?>
		    	<!--<tr>
		    		<td><center><strong>Acciones</strong></center></td>
		    		<td><center><i class="material-icons">add_circle_outline</i></center></td>
		    		<td><center><i class="material-icons"> edit</i></center></td>
		    		<td><center><i class="material-icons"> delete</i></center></td>
		    		<td><center><i class="material-icons"> visibility</i></center></td>
		    	</tr>-->
			</tbody>
		</table>

		<?php if (isset($permisos) and !isset($perfil_view)): ?>
			<script type="text/javascript">
				document.getElementById('check_all').addEventListener("click", function() {
					<?php foreach ($permisos as $permiso): ?>
						var checkbox = document.getElementById("checkbox_<?php echo $permiso->id_permiso ?>");
						if (checkbox.checked == false) {
							checkbox.click();
						}
					<?php endforeach ?>
				});

				document.getElementById('uncheck_all').addEventListener("click", function() {
					<?php foreach ($permisos as $permiso): ?>
						var checkbox = document.getElementById("checkbox_<?php echo $permiso->id_permiso ?>");
						if (checkbox.checked == true) {
							checkbox.click();
						}
					<?php endforeach ?>
				});
			</script>
		<?php endif ?>

		<?php if (isset($perfil_edit) or isset($perfil_add)): ?>
			<script type="text/javascript">
				document.getElementById('check_rest').addEventListener("click", function() {
					<?php foreach ($permisos as $permiso): ?>
						<?php if ($permiso->agregado == "true"): ?>
							var checkbox = document.getElementById("checkbox_<?php echo $permiso->id_permiso?>");
							if (checkbox.checked == false) {
								checkbox.click();
							}
						<?php else: ?>
							var checkbox = document.getElementById("checkbox_<?php echo $permiso->id_permiso?>");
							if (checkbox.checked == true) {
								checkbox.click();
							}
						<?php endif ?>
						
					<?php endforeach ?>
				});
			</script>
		<?php endif ?>


	  </div>
	  	<?php if(isset($perfil_crud)): ?>
              <?php echo $perfil_crud; ?>
              <?php endif ?>
    </div>

</main>

</form>

<script type="text/javascript">
	var $table = $('.mdl-data-table');
var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');

$fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();

$fixedColumn.find('tr').each(function (i, elem) {
    $(this).height($table.find('tr:eq(' + i + ')').height());
});
</script>