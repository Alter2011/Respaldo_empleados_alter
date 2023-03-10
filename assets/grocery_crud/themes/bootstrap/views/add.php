<?php
	$this->set_css($this->default_theme_path.'/bootstrap/css/material.css');
	$this->set_css($this->default_theme_path.'/bootstrap/css/material.min.css');
	$this->set_css($this->default_theme_path.'/bootstrap/css/material.min.css.map');
	

	$this->set_css($this->default_theme_path.'/bootstrap/css/style.css');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.min.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.min.js.map');
	//$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
    $this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-add.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>

<style type="text/css">
	.form-control, .chosen-single{
		width: 100% !important;
	    padding: 6px 10px;
	    margin: 8px 0;
	    border: 1px solid black;
	    font-size: 17px;

	}

	.chosen-container{
		width: 100% !important;
	}
	.letter{
	}
</style>
</style>
<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'><center><br>
				<h3 style="width=90%; margin: 0;"><?php echo $this->l('form_add'); ?> <?php echo $subject?></h3>
			</div>
			<div class='clear'></div></center><br>
			<div id='report-error' class='report-div error'></div>
			<div id='report-success' class='report-div success'></div>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>
	<!--mensaje -->

<div id='main-table-box'>
	<?php echo form_open( $insert_url, 'method="post" id="crudForm"  enctype="multipart/form-data"'); ?>
		<div class='form-div form-div mdl-grid'>
			<?php
			$counter = 0;
				foreach($fields as $field)
				{
					$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
					$counter++;
			?>
			<div style="padding: 5px;" class='form-field-box <?php echo $even_odd?> mdl-cell--6-col' id="<?php echo $field->field_name; ?>_field_box">
				<div class='form-display-as-box ' id="<?php echo $field->field_name; ?>_display_as_box">
					<?php echo $input_fields[$field->field_name]->display_as; ?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""; ?> :
				</div>
				<div class='form-input-box ' id="<?php echo $field->field_name; ?>_input_box">
					<?php echo $input_fields[$field->field_name]->input?>
				</div>
				<div class='clear'></div>
			</div>
			<?php }?>
			<!-- Start of hidden inputs -->
				<?php
					foreach($hidden_fields as $hidden_field){
						echo $hidden_field->input;
					}
				?>
			<!-- End of hidden inputs -->
			<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>

			
		</div>
		<div class="pDiv mdl-grid">
		<!--	<div class='form-button-box'>
				<input id="form-button-save" type='submit' value='<?php echo $this->l('form_save'); ?>'  class="mdl-button mdl-js-button mdl-button--raised"/>
			</div><div class="btnseparator" style="margin-left: 10px;"></div> -->
<?php 	if(!$this->unset_back_to_list) { ?>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_save_and_go_back'); ?>' id="save-and-go-back-button"  class="mdl-button mdl-js-button mdl-button--raised"/>
			</div><div class="btnseparator" style="margin-left: 10px;"></div>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_cancel'); ?>' class="mdl-button mdl-js-button mdl-button--raised" id="cancel-button" />
			</div><div class="btnseparator" style="margin-left: 10px;"></div>
<?php 	} ?>
			<div class='form-button-box'>
				<div class='small-loading' style="display: none;" id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>
			</div>
			<div class='clear'></div>
		</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
	var message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>