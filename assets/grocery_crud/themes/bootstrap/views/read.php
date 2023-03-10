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
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-edit.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
?>

<style type="text/css">
	.readonly_label{
		width: 100%;
	    padding: 6px 10px;
	    margin: 8px 0;
	    box-sizing: border-box;
	}
</style>

<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'><center><br>
				<h3 style="width=90%; margin: 0;"><?php echo $this->l('list_record'); ?> <?php echo $subject?>
			</h3>
			</div>
			<div class='clear'></div></center><br>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" ><!--class="ptogtitle">-->
			<span></span>
		</div>
	</div>
	
	

<div id='main-table-box'>
	<?php echo form_open( $read_url, 'method="post" id="crudForm"  enctype="multipart/form-data"'); ?>
	<div class='form-div mdl-grid'>
		<?php
		$counter = 0;
			foreach($fields as $field)
			{
				$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
				$counter++;
		?>
			<div style="padding: 5px;" class='form-field-box <?php echo $even_odd?> mdl-cell--6-col' <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
				<div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
					<strong><?php echo $input_fields[$field->field_name]->display_as?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""?> :</strong>
				</div>
				<div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
					<?php echo $input_fields[$field->field_name]->input?>
				</div>
				<div class='clear'></div>
			</div>
		<?php }?>
		<?php if(!empty($hidden_fields)){?>
		<!-- Start of hidden inputs -->
			<?php
				foreach($hidden_fields as $hidden_field){
					echo $hidden_field->input;
				}
			?>
		<!-- End of hidden inputs -->
		<?php }?>
		<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>
		<div id='report-error' class='report-div error'></div>
		<div id='report-success' class='report-div success'></div>
	</div>
	<div class="pDiv mdl-grid">
		<div class='form-button-box'><!--class="btn btn-large"-->
			<input type='button' value='<?php echo $this->l('form_back_to_list'); ?>' class="back-to-list mdl-button mdl-js-button mdl-button--raised" id="cancel-button" />
		</div>
		<div class="btnseparator" style="margin-left: 10px;"></div>
		<div class='form-button-box'>
			<div class='small-loading' style="display: none;" id='FormLoading'><?php echo $this->l('form_update_loading'); ?></div>
		</div>
		<div class='clear'></div>
	</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_edit_form = "<?php echo $this->l('alert_edit_form')?>";
	var message_update_error = "<?php echo $this->l('update_error')?>";
</script>
