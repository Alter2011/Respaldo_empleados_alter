<?php
	
	$this->set_css($this->default_theme_path.'/bootstrap/css/material.min.css');
	$this->set_css($this->default_theme_path.'/bootstrap/css/material.min.css.map');
	$this->set_js_lib($this->default_javascript_path.'/'.grocery_CRUD::JQUERY);
	

	$this->set_css($this->default_theme_path.'/bootstrap/css/style.css');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.min.js');
	$this->set_js($this->default_theme_path.'/bootstrap/js/material.min.js.map');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
	$this->set_js_lib($this->default_javascript_path.'/common/lazyload-min.js');

	if (!$this->is_IE7()) {
		$this->set_js_lib($this->default_javascript_path.'/common/list.js');
	}

	$this->set_js($this->default_theme_path.'/flexigrid/js/cookies.js');
	$this->set_js($this->default_theme_path.'/flexigrid/js/flexigrid.js');

    $this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.form.min.js');

	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.numeric.min.js');
	$this->set_js($this->default_theme_path.'/flexigrid/js/jquery.printElement.min.js');

	
	$this->set_css($this->default_css_path.'/jquery_plugins/fancybox/jquery.fancybox.css');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.fancybox-1.3.4.js');
	$this->set_js($this->default_javascript_path.'/jquery_plugins/jquery.easing-1.3.pack.js');
	//Fancybox */

	/** Jquery UI */
	$this->load_js_jqueryui();

?>

<script type='text/javascript'>
	var base_url = '<?php echo base_url();?>';

	var subject = '<?php echo addslashes($subject); ?>';
	var ajax_list_info_url = '<?php echo $ajax_list_info_url; ?>';
	var unique_hash = '<?php echo $unique_hash; ?>';

	var message_alert_delete = "<?php echo $this->l('alert_delete'); ?>";

</script>
<div id='list-report-error' class='report-div error'></div>
<div id='list-report-success' class='report-div success report-list' <?php if($success_message !== null){?>style="display:block"<?php }?>><?php
if($success_message !== null){?>
	<p><?php echo $success_message; ?></p>
<?php }
?></div>
<div class="flexigrid" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div id="hidden-operations" class="hidden-operations"></div>
	<!--<div class="mDiv">
		<div class="ftitle">
			&nbsp;
		</div>
		<div title="<?php //echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>-->
	<div id='main-table-box' class="main-table-box">

	<?php if(!$unset_add || !$unset_export || !$unset_print){?>
	
	<div class="tDiv mdl-grid"">
		<?php if(!$unset_add){?>
		<div class="tDiv2">
        	<a href='<?php echo $add_url?>' title='<?php echo $this->l('list_add'); ?> <?php echo $subject?>' class='add-anchor add_button'>
			<div class="mdl-button mdl-js-button mdl-button--raised">
				<div>
					<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">add</i><?php echo $this->l('list_add'); ?> <?php echo $subject?>
				</div>
			</div>
            </a>
			<!--<div class="btnseparator"></div>-->
		</div>
		<?php }?>
		<div class="tDiv2 mdl-grid" style="margin-right: 0; padding: 0; align-items: right;">
			<?php if(!$unset_export) { ?>
			<div>
	        	<a class="export-anchor" data-url="<?php echo $export_url; ?>" target="_blank">
					<div class="mdl-button mdl-js-button mdl-button--raised">
						<div>
							<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">import_export</i><?php echo $this->l('list_export');?>
						</div>
					</div>
	            </a>
	         </div>
			
			<div class="btnseparator" style="margin-left: 10px;">
			<?php } ?>
			<?php if(!$unset_print) { ?>
			<div class="">
	        	<a class="print-anchor" data-url="<?php echo $print_url; ?>">
					<div class="mdl-button mdl-js-button mdl-button--raised">
						<div>
							<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">print</i><?php echo $this->l('list_print');?>
						</div>
					</div>
	            </a>
            </div>
			<!--<div class="btnseparator"></div>-->
			<?php }?>
		</div>
		<div class='clear'></div>
	</div>
	<br>
	<?php }?>
<br>
	<?php echo form_open( $ajax_list_url, 'method="post" id="filtering_form" class="filtering_form" style="width: 100%;" autocomplete = "off" data-ajax-list-info-url="'.$ajax_list_info_url.'"'); ?>
	<div class="sDiv quickSearchBox" id='quickSearchBox'>
		<div class='search-div-clear-button' style="padding-top: 14px; float: left;">
        	<input type="button" value="<?php echo $this->l('list_clear_filtering');?>" id='search_clear' class="search_clear mdl-button mdl-js-button mdl-button--raised">
        </div>
		<div class="sDiv2" style="float: right;">
			<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
			  <input type="text" class="qsbsearch_fieldox search_text mdl-textfield__input" name="search_text" size="30" id='search_text'>
		      <label class="mdl-textfield__label" for="search_text"><?php echo $this->l('list_search');?>: </label>
		    </div>
		    
			<select name="search_field" id="search_field" class="search_field mdl-button">
				<option value=""><?php echo $this->l('list_search_all');?></option>
				<?php foreach($columns as $column){?>
				<option value="<?php echo $column->field_name?>"><?php echo $column->display_as?>&nbsp;&nbsp;</option>
				<?php }?>
			</select>
                       <input type="button" value="<?php echo $this->l('list_search');?>" class="crud_search mdl-button mdl-js-button mdl-button--raised" id='crud_search'>

              
		</div>
       
	</div>


	
	<div id='ajax_list' class="ajax_list">
		<?php echo $list_view?>
	</div>
	
	<div class="pDiv mdl-grid">
		<div class="pDiv2 mdl-grid" style="margin: 0;">
			<div class="pGroup">
				<span class="pcontrol">
					<?php list($show_lang_string, $entries_lang_string) = explode('{paging}', $this->l('list_show_entries')); ?>
					<?php echo $show_lang_string; ?>
					<select name="per_page" id='per_page' class="per_page mdl-button">
						<?php foreach($paging_options as $option){?>
							<option value="<?php echo $option; ?>" <?php if($option == $default_per_page){?>selected="selected"<?php }?>><?php echo $option; ?>&nbsp;&nbsp;</option>
						<?php }?>
					</select>
					<?php echo $entries_lang_string; ?>
					<input type='hidden' name='order_by[0]' id='hidden-sorting' class='hidden-sorting' value='<?php if(!empty($order_by[0])){?><?php echo $order_by[0]?><?php }?>' />
					<input type='hidden' name='order_by[1]' id='hidden-ordering' class='hidden-ordering'  value='<?php if(!empty($order_by[1])){?><?php echo $order_by[1]?><?php }?>'/>
				</span>
			</div>
			<div class="btnseparator" style="margin-left: 10px;">
			</div>
			<div class="pGroup mdl-grid" style="margin: 0; padding: 0;">
				<div class="pFirst pButton first-button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
					<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">skip_previous</i>
				</div>			<div class="btnseparator" style="margin-left: 5px;">

				<div class="pPrev pButton prev-button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
					<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">navigate_before</i>
				</div>
			</div>
			<div class="btnseparator" style="margin-left: 10px;">
			</div>
			<div class="pGroup" style="margin-top: 10.5px;">
				<span class="pcontrol"><?php echo $this->l('list_page'); ?> <input name='page' type="text" value="1" size="4" id='crud_page' class="crud_page">
				<?php echo $this->l('list_paging_of'); ?>
				<span id='last-page-number' class="last-page-number"><?php echo ceil($total_results / $default_per_page)?></span></span>
			</div>
			<div class="btnseparator" style="margin-left: 10px;">
			</div>
			<div class="pGroup mdl-grid" style="margin: 0; padding: 0;">
				<div class="pNext pButton next-button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab" >
					<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">navigate_next</i>
				</div>
							<div class="btnseparator" style="margin-left: 10px;">

				<div class="pLast pButton last-button mdl-button mdl-js-button mdl-button--fab mdl-button--mini-fab">
					<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">skip_next</i>
				</div>
			</div>
			<div class="btnseparator" style="margin-left: 10px;">
			</div>
			<div class="pGroup">
				<div class="pReload pButton ajax_refresh_and_loading" id='ajax_refresh_and_loading'>
					<!--<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">refresh</i>-->
				</div>
			</div>
			<div class="btnseparator" style="margin-left: 10px;">
			</div>
			<div class="pGroup" style="margin-top: 10.5px;">
				<span class="pPageStat">
					<?php $paging_starts_from = "<span id='page-starts-from' class='page-starts-from'>1</span>"; ?>
					<?php $paging_ends_to = "<span id='page-ends-to' class='page-ends-to'>". ($total_results < $default_per_page ? $total_results : $default_per_page) ."</span>"; ?>
					<?php $paging_total_results = "<span id='total_items' class='total_items'>$total_results</span>"?>
					<?php echo str_replace( array('{start}','{end}','{results}'),
											array($paging_starts_from, $paging_ends_to, $paging_total_results),
											$this->l('list_displaying')
										   ); ?>
				</span>
			</div>
		</div>
		<div style="clear: both;">
		</div>
	</div>
		</div>
</div>
	<?php echo form_close(); ?>

