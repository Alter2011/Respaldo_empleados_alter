<?php 
	

	$column_width = (int)(80/count($columns));
	
	if(!empty($list)){
?>
<style type="text/css">

	.table-responsive>.fixed-column {
    position: absolute;
    display: inline-block;
  	margin: -1px;
    width: 18% !important;
    z-index: ;
    box-shadow: none;
}
@media(max-width:768px) {
    .table-responsive>.fixed-column {
       display: none;
    }
}


</style>

	<div class="bDiv table-responsive" >
		<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp" style="width: 100%;" cellspacing="0" cellpadding="0" border="0" id="flex1">
		<thead>
			<tr class='hDiv'>
				<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
				<th align="left" abbr="tools" axis="col1" class="" width='20%'>
					<div class="text-center" style="text-align: center;">
						ACCIONES <?php //echo $this->l('list_actions'); ?>
					</div>
				</th>
				<?php }?>
				<?php foreach($columns as $column){?>
				<th style="cursor: pointer;" width='<?php echo $column_width?>%'>
					<div style="text-align: center;" class="text-left field-sorting <?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?><?php echo $order_by[1]?><?php }?>" 
						rel='<?php echo $column->field_name?>'>
						<?php echo $column->display_as?>
					</div>
				</th>
				<?php }?>
				
			</tr>
		</thead>		
		<tbody>
<?php foreach($list as $num_row => $row){ ?>        
		<tr  <?php if($num_row % 2 == 1){?>class="erow"<?php }?>>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td align="left" width='20%'>
				<div class='tools' style="text-align: center;">				
					<?php if(!$unset_delete){?>
                    	<a href='<?php echo $row->delete_url?>' title='<?php echo $this->l('list_delete')?>_<?php echo $subject?>' class="delete-row" >
                    			<i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">delete</i>
                    	</a>
                    <?php }?>
                    <?php if(!$unset_edit){?>
						<a href='<?php echo $row->edit_url?>' title='<?php echo $this->l('list_edit')?> <?php echo $subject?>' class="edit_button"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">edit</i></a>
					<?php }?>
					<?php if(!$unset_read){?>
						<a href='<?php echo $row->read_url?>' title='<?php echo $this->l('list_view')?> <?php echo $subject?>' class="edit_button"><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation">search</i></a>
					<?php }?>
					<?php 
					if(!empty($row->action_urls)){
						foreach($row->action_urls as $action_unique_id => $action_url){ 
							$action = $actions[$action_unique_id];
					?>
							<a href="<?php echo $action_url; ?>" class="<?php echo $action->css_class; ?> crud-action"  style="text-decoration: none;" title="<?php echo $action->label?>"><?php 
								if(!empty($action->image_url))
								{
									?><i class="mdl-color-text--blue-grey-400 material-icons" role="presentation"><?php echo $action->image_url; ?></i>
									<!--<img src="<?php //echo $action->image_url; ?>" alt="<?php //echo $action->label?>" />--><?php
								}
							?></a>		
					<?php }
					}
					?>					
                    <div class='clear'></div>
				</div>
			</td>
			<?php }?>

			<?php foreach($columns as $column){?>
			<td width='<?php echo $column_width?>%' class='<?php if(isset($order_by[0]) &&  $column->field_name == $order_by[0]){?>sorted<?php }?>'>
				<div class='text-left' style="text-align: center;"><?php echo $row->{$column->field_name} != '' ? $row->{$column->field_name} : '&nbsp;' ; ?></div>
			</td>
			<?php }?>
			
		</tr>
<?php } ?>        
		</tbody>
		</table>
	</div>
<?php }else{?>
	<br/>
	&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $this->l('list_no_items'); ?>
	<br/>
	<br/>
	
<?php }?>	

<script type="text/javascript">
	var $table = $('.mdl-data-table');
var $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column');

$fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();

$fixedColumn.find('tr').each(function (i, elem) {
    $(this).height($table.find('tr:eq(' + i + ')').height());
});
</script>
