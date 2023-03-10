
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

    <div class="mdl-grid demo-content" style="margin: 10px;">
	
	  <div class="mdl-cell mdl-cell--12-col table-responsive" style=" overflow-x: auto;
    width: 100%;
    box-shadow: 0 2px 2px 0 rgba(0,0,0,.14), 0 3px 1px -2px rgba(0,0,0,.2), 0 1px 5px 0 rgba(0,0,0,.12);">
	  	<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" width="100%" style="text-align: right;">
		    <thead>
		    	<tr>
		    		<td colspan="3"><center><strong>BLOQUEO DE PERMISOS</strong></center></td>
		    		<td colspan="1">
		    				<a id="check_all" style="text-decoration: none; cursor: pointer;">Marcar todos</a>
			    			/
			    			<a id="uncheck_all" style="text-decoration: none; cursor: pointer;">Desmarcar todos</a>
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
						  			<input type="checkbox" name="checkbox_<?php echo $permiso->id_permiso ?>" id="checkbox_<?php echo $permiso->id_permiso ?>" class="mdl-checkbox__input" <?php if ($permiso->agregado == "true") { echo "checked"; } ?>>
						  			<span class="mdl-checkbox__label"><?php echo $permiso->nombre ?></span>
								</label>
							</td>
						<?php $i++; ?>
						<?php if ($i==3) { echo "</tr>"; $i=0; } ?>
							
		    		<?php endforeach ?>
					
					</tr>
		    	<?php endif ?>
		    	
			</tbody>
		</table>


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