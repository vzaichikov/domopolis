<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
		<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div class="g f-content">
		<?php if (isset($warning) && !empty($warning)) { ?>
		<div class="f-message f-message-error"><?php echo $warning; ?></div>
		<?php } ?>
		<?php if (isset($success) && !empty($success)) { ?>
		<div class="f-message f-message-success"><?php echo $success; ?></div>
		<?php } ?>
		<?php echo $app_header; ?>
		<div class="g-row">
			<div class="g-6 f-sub-header">
				<h3><?php echo $heading_title; ?></h3>
			</div>
			<div class="g-6 f-text-right">&nbsp;</div>
		</div>
		<div class="g-row">
			<div id="tabs">
				<ul class="f-nav f-nav-tabs">
					<li><a href="#tab_export" id="link_tab_export"><?php echo $tab_export; ?></a></li>
					<li><a href="#tab_import" id="link_tab_import"><?php echo $tab_import; ?></a></li>
				</ul>
				<!-- f-nav-tabs -->
			</div>
		</div>
		<div class="g-row">
			<div id="tab_export" class="f-tabs">
				<form action="<?php echo $action_export; ?>" method="post" id="form_category_export" enctype="multipart/form-data">
					<div class="g-row">
						<div class="g-7">
							<div class="f-row">
								<label data-prop_id="0"><?php echo $entry_file_encoding; ?></label>
								<div class="f-input">
									<select name="csv_export[file_encoding]" class="g-3">
									<?php if (isset($charsets) && !empty($charsets)) { ?>
										<?php foreach ($charsets as $key => $val) { ?>
											<?php if ( $csv_export['file_encoding'] == $key ) { ?>
												<option value="<?php echo $key;?>" selected="selected"><?php echo $val;?></option>
											<?php } else { ?>
												<option value="<?php echo $key;?>"><?php echo $val;?></option>
											<?php } ?>
										<?php } ?>
									<?php } else { ?>
										<option value="UTF-8" <?php if ( $csv_export['file_encoding'] == 'UTF-8' ) echo 'selected'; ?>>UTF-8</option>
										<option value="WINDOWS-1251" <?php if ( $csv_export['file_encoding'] == 'WINDOWS-1251' ) echo 'selected'; ?>>Windows-1251</option>
									<?php } ?>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="f-row">
								<label data-prop_id="1"><?php echo $entry_csv_delimiter; ?></label>
								<div class="f-input">
									<select name="csv_export[csv_delimiter]" class="g-1">
										<option value=";" <?php if ( isset($csv_export['csv_delimiter']) && $csv_export['csv_delimiter'] == ';' ) echo ' selected="selected"'; ?>> ; </option>
										<option value="," <?php if ( isset($csv_export['csv_delimiter']) && $csv_export['csv_delimiter'] == ',' ) echo ' selected="selected"'; ?>> , </option>
										<option value="^" <?php if ( isset($csv_export['csv_delimiter']) && $csv_export['csv_delimiter'] == '^' ) echo ' selected="selected"'; ?>> ^ </option>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							<!-- <div class="f-row">
								<label data-prop_id="9"><?php echo $entry_csv_text_delimiter; ?></label>
								<div class="f-input">
									<input class="g-1" type="text" name="csv_export[csv_text_delimiter]" value='<?php if ( isset($csv_export['csv_text_delimiter']) ) echo $csv_export['csv_text_delimiter'];else echo '"'; ?>' />
								</div>
							</div> -->
							<div class="clearfix"></div>
							<div class="f-row">
								<label data-prop_id="2"><?php echo $entry_languages; ?></label>
								<div class="f-input">
									<select class="g-3" name="csv_export[language_id]">
										<?php foreach ($languages as $language) { ?>
										<?php if ( $csv_export['language_id'] == $language['language_id'] ) { ?>
										<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="f-row">
								<input type="hidden" name="csv_export[from_store]" value="0">
								<label data-prop_id="3"><?php echo $entry_store; ?></label>
								<div class="f-input">
									<div class="scrollbox">
										<?php $class = 'even'; ?>
										<div class="<?php echo $class; ?>">
											<?php if (!empty($csv_export['from_store']) && in_array(0, $csv_export['from_store'])) { ?>
											<label><input type="checkbox" name="csv_export[from_store][]" value="0" checked="checked" />
											<?php echo $text_default; ?></label>
											<?php } else { ?>
											<label><input type="checkbox" name="csv_export[from_store][]" value="0" />
											<?php echo $text_default; ?></label>
											<?php } ?>
										</div>
										<?php foreach ($stores as $store) { ?>
										<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
										<div class="<?php echo $class; ?>">
											<?php if (is_array($csv_export['from_store']) && in_array($store['store_id'], $csv_export['from_store'])) { ?>
											<label><input type="checkbox" name="csv_export[from_store][]" value="<?php echo $store['store_id']; ?>" checked="checked" />
											<?php echo $store['name']; ?></label>
											<?php } else { ?>
											<label><input type="checkbox" name="csv_export[from_store][]" value="<?php echo $store['store_id']; ?>" />
											<?php echo $store['name']; ?></label>
											<?php } ?>
										</div>
										<?php } ?>
									</div>
									<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
								</div>
								<!-- end f-input -->
							</div>
							<div class="clearfix"></div>
							<!-- end f-row -->
							<div class="f-row">
								<label data-prop_id="4"><?php echo $entry_manufacturer; ?></label>
								<div class="f-input">
									<input type="hidden" name="csv_export[product_manufacturer]" value="0" />
									<div id="export_product_manufacturer">
									<div class="scrollbox">
										<?php $class = 'odd'; ?>
										<?php foreach ($manufacturers as $manufacturer) { ?>
										<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
										<label title="<?php echo $manufacturer['name']; ?>">
											<span class="<?php echo $class; ?>">
												<input type="checkbox" name="csv_export[product_manufacturer][]" value="<?php echo $manufacturer['manufacturer_id']; ?>" />
												<?php echo $manufacturer['name']; ?>
											</span>
										</label>
										<?php } ?>
									</div>
									<a onclick="$(this).parent().find(':checkbox').attr('checked', true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);"><?php echo $text_unselect_all; ?></a>
									/ <a class="show_scroll"><?php echo $text_select;?></a>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="f-row">
								<label data-prop_id="32"><?php echo $entry_image_url; ?></label>
								<div class="f-input">
									<select class="g-2" name="csv_export[image_url]">
										<option value="1"<?php if ( isset($csv_export['image_url']) && $csv_export['image_url'] == 1 ) { echo '  selected="selected"'; }?>><?php echo $text_enabled; ?></option>
										<option value="0"<?php if ( !isset($csv_export['image_url']) || $csv_export['image_url'] == 0 ) { echo '  selected="selected"'; }?>><?php echo $text_disabled; ?></option>
									</select>
								</div>
							</div>
						</div>
						<!-- end g-7 -->
						<div class="g-5">
							<div><a onclick="$('.f-field-set').find(':checkbox:not(:checked)').parent().parent().parent().hide();"><?php echo $text_hide_all; ?></a> / <a onclick="$('.f-field-set').find('tr').show();"><?php echo $text_show_all; ?></a></div>
							<table class="f-field-set">
								<?php foreach( $csv_export['fields_set_data'] as $field ) { ?>
								<tr id="row_<?php echo $field['uid']; ?>">
									<td>
										<label title="<?php echo $fields_set_help[$field['uid']]; ?> <?php echo $field['uid']; ?>">
										<input <?php if (array_key_exists($field['uid'], $csv_export['fields_set']) || $field['uid'] == '_ID_') echo 'checked="checked"';?> <?php    if ($field['uid'] == '_ID_') echo ' disabled="disabled" class="field_id" ';?> type="checkbox" id="<?php echo $field['uid']; ?>" name="csv_export[fields_set][<?php echo $field['uid']; ?>]" value="1" />
										<?php echo $fields_set_help[$field['uid']]; ?>
										</label>
									</td>
									<td><span><?php echo $field['uid']; ?></span></td>
								</tr>
								<?php } ?>
							</table>
							<input type="hidden" name="csv_export[fields_set][_ID_]" value="1">
							<a onclick="$(this).parent().find(':checkbox').attr('checked', true);initFieldsSet();"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').attr('checked', false);initFieldsSet();"><?php echo $text_unselect_all; ?></a>
						</div>
						<!-- end g-5 -->
					</div>
				</form>
				<!-- end g-row -->
				<div class="f-row"></div>
				<div class="f-row f-actions-left"><a onclick="$('#form_category_export').submit();" class="f-bu f-bu-default g-2"><?php echo $button_export;?></a></div>
			</div>
			<!-- end tab_export -->
			<div id="tab_import" class="f-tabs">
				<form action="<?php echo $action_import; ?>" method="post" id="form_category_import" enctype="multipart/form-data">
					<div class="g-row">
						<div class="g-12 f-form">
							<div class="f-row">
								<label data-prop_id="0"><?php echo $entry_file_encoding; ?></label>
								<div class="f-input">
									<select name="csv_import[file_encoding]" class="g-3">
										<?php if (isset($charsets) && !empty($charsets)) { ?>
											<?php foreach ($charsets as $key => $val) { ?>
												<?php if ( $csv_import['file_encoding'] == $key ) { ?>
													<option value="<?php echo $key;?>" selected="selected"><?php echo $val;?></option>
												<?php } else { ?>
													<option value="<?php echo $key;?>"><?php echo $val;?></option>
												<?php } ?>
											<?php } ?>
										<?php } else { ?>
											<option value="UTF-8" <?php if ( $csv_import['file_encoding'] == 'UTF-8' ) echo 'selected'; ?>>UTF-8</option>
											<option value="WINDOWS-1251" <?php if ( $csv_import['file_encoding'] == 'WINDOWS-1251' ) echo 'selected'; ?>>Windows-1251</option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="f-row">
								<label data-prop_id="1"><?php echo $entry_csv_delimiter; ?></label>
								<div class="f-input">
									<select name="csv_import[csv_delimiter]" class="g-1">
										<option value=";" <?php if ( isset($csv_import['csv_delimiter']) && $csv_import['csv_delimiter'] == ';' ) echo ' selected="selected"'; ?>> ; </option>
										<option value="," <?php if ( isset($csv_import['csv_delimiter']) && $csv_import['csv_delimiter'] == ',' ) echo ' selected="selected"'; ?>> , </option>
										<option value="^" <?php if ( isset($csv_import['csv_delimiter']) && $csv_import['csv_delimiter'] == '^' ) echo ' selected="selected"'; ?>> ^ </option>
									</select>
								</div>
							</div>
							<!-- <div class="f-row">
								<label data-prop_id="9"><?php echo $entry_csv_text_delimiter; ?></label>
								<div class="f-input">
									<input class="g-1" type="text" name="csv_import[csv_text_delimiter]" value='<?php if ( isset($csv_import['csv_text_delimiter']) ) echo $csv_import['csv_text_delimiter'];else echo '"'; ?>' />
								</div>
							</div> -->
							<div class="f-row">
								<label data-prop_id="2"><?php echo $entry_languages; ?></label>
								<div class="f-input">
									<select class="g-3" name="csv_import[language_id]">
										<?php foreach ($languages as $language) { ?>
										<?php if ( $csv_import['language_id'] == $language['language_id'] ) { ?>
										<option value="<?php echo $language['language_id']; ?>" selected="selected"><?php echo $language['name']; ?></option>
										<?php } else { ?>
										<option value="<?php echo $language['language_id']; ?>"><?php echo $language['name']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="f-row">
								<label data-prop_id="5"><?php echo $entry_import_mode; ?></label>
								<div class="f-input">
									<select class="g-3" name="csv_import[mode]">
										<option value="2" <?php if ( $csv_import['mode'] == 2 ) echo ' selected="selected"'; ?>><?php echo $text_import_mode_update; ?></option>
										<option value="3" <?php if ( $csv_import['mode'] == 3 ) echo ' selected="selected"'; ?>><?php echo $text_import_mode_insert; ?></option>
										<option value="1" <?php if ( $csv_import['mode'] == 1 ) echo ' selected="selected"'; ?>><?php echo $text_import_mode_both; ?></option>
									</select>
								</div>
							</div>
							<div class="f-row">
								<label data-prop_id="6"><?php echo $entry_key_field; ?></label>
								<div class="f-input">
									<select class="g-3 f-margin-top" name="csv_import[key_field]">
										<?php foreach($csv_import_key_fields as $key => $name) { ?>
										<option value="<?php echo $key; ?>"<?php if ($csv_import['key_field'] == $key)echo ' selected="selected"';?>><?php echo $name;?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="f-row">
								<label><?php echo $entry_store; ?></label>
								<div class="f-input">
									<div class="scrollbox" style="width: 320px;">
										<?php $class = 'even'; ?>
										<label>
											<span class="<?php echo $class; ?>"><input type="checkbox" name="csv_import[to_store][]" value="0" checked="checked" /> <?php echo $text_default; ?></span>
										</label>
										<?php foreach ($stores as $store) { ?>
										<?php $class = ($class == 'even' ? 'odd' : 'even'); ?>
										<label>
											<span class="<?php echo $class; ?>"> <input type="checkbox" name="csv_import[to_store][]" value="<?php echo $store['store_id']; ?>" <?if(isset($csv_import['to_store']) && in_array($store['store_id'], $csv_import['to_store'])){echo ' checked="checked"';}?> /> <?php echo $store['name']; ?></span>
										</label>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="f-row">
								<label data-prop_id="7"><?php echo $entry_import_id; ?></label>
								<div class="f-input">
									<select class="g-2 f-margin-top" name="csv_import[import_id]">
										<?php if (isset($csv_import['import_id']) && $csv_import['import_id'] == 1) { ?>
										<option value="1" selected="selected"><?php echo $text_yes; ?></option>
										<option value="0"><?php echo $text_no; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_yes; ?></option>
										<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="f-row">
								<label><?php echo $entry_sort_order; ?></label>
								<div class="f-input">
									<input class="g-1 f-text-right" type="text" name="csv_import[sort_order]" value="<?php if(isset($csv_import['sort_order']))echo $csv_import['sort_order'];?>" />
								</div>
							</div>
							<div class="f-row">
								<label data-prop_id="8"><?php echo $entry_import_img_download; ?></label>
								<div class="f-input">
									<select class="g-2 f-margin-top" name="csv_import[image_download]">
										<?php if (isset($csv_import['image_download']) && $csv_import['image_download'] == 1) { ?>
										<option value="1" selected="selected"><?php echo $text_yes; ?></option>
										<option value="0"><?php echo $text_no; ?></option>
										<?php } else { ?>
										<option value="1"><?php echo $text_yes; ?></option>
										<option value="0" selected="selected"><?php echo $text_no; ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="f-row"></div>
							<div class="f-row">
								<label><?php echo $entry_import_file; ?></label>
								<div class="f-input">
									<input  type="file" name="import" />
								</div>
							</div>
						</div>
						<!-- end g-12 -->
					</div>
				</form>
				<div class="g-row">
					<div class="f-actions-left"><a onclick="$('#form_category_import').submit();" class="f-bu f-bu-default g-2"><?php echo $button_import;?></a></div>
				</div>
			</div>
		</div>
	</div>
	<?php echo $app_footer; ?>
</div>
<script type="text/javascript"><!--
	var prop_descr=new Array();
	<?php if(isset($prop_descr)){echo $prop_descr;}?>
	// Document Ready
	$(document).ready(function(){
		$('#tbl_name option').change();
		$('#tabs ul li a').tabs();
	        $('.f-tabs').hide();
		$("#link_<?php echo $tab_selected; ?>").parent().addClass('active');
		$("#<?php echo $tab_selected; ?>").show();
	        if($.fn.jquery == '1.6.1') {
	        	$('#tabs ul li a').bind('click', tabsClassActive);
	        } else {
	        	$('#tabs ul li a').on('click',tabsClassActive);
	        }
	
	});
	
	//--></script>
<script type="text/javascript"><!--
	function setBackgroundColor(obj) {
	    var row = '#row_' + $(obj).attr('id') + ' td';
	    if($(obj).attr('checked') == 'checked'){
	        $(row).addClass('selected');
	    } else {
	        $(row).removeClass('selected');
	    }
	}
	function initFieldsSet() {
	    $('.field_id').attr('checked', 'checked');
	    $('.f-field-set input[type=checkbox]').each(function() {
	        setBackgroundColor(this);
	    });
	}
	
	$(document).ready(function(){
		initFieldsSet();
	});
	
	$('.f-field-set input[type=checkbox]').change(function(){
	    setBackgroundColor(this);
	});
	//--></script>
<?php echo $footer; ?>