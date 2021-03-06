<?php echo $header; ?>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<?php if ($error_warning) { ?>
		<div class="warning"><?php echo $error_warning; ?></div>
	<?php } ?>
	<?php if ($success) { ?>
		<div class="success"><?php echo $success; ?></div>
	<?php } ?>
	<div class="box">
		<div class="heading order_head">
			<h1><img src="view/image/order.png" alt="" /> <?php echo $heading_title; ?></h1>
			<div class="buttons"><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
		</div>
		<div class="content">
			<form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
				<table style="width: 100%;">
					<tbody>
						<tr class="filter">
							<td colspan="2">
								<p>ID</p>
							<input type="text" name="filter_return_id" value="<?php echo $filter_return_id; ?>" size="2" style="text-align: right; width:15px;" /></td>
							<td>
								<p>№ заказа</p>
							<input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" size="4" style="text-align: right;" /></td>
							<td>
								<p>Покупатель</p>
							<input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" /></td>
							<td>
								<p>Товар</p>
							<input type="text" name="filter_product" value="<?php echo $filter_product; ?>" /></td>
							<td>
								<p>Артикул</p>
							<input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>							
							<td>
								<p>Статус</p>
								<select name="filter_return_status_id">
									<option value="*"></option>
									<?php foreach ($return_statuses as $return_status) { ?>
										<?php if ($return_status['return_status_id'] == $filter_return_status_id) { ?>
											<option value="<?php echo $return_status['return_status_id']; ?>" selected="selected"><?php echo $return_status['name']; ?></option>
											<?php } else { ?>
											<option value="<?php echo $return_status['return_status_id']; ?>"><?php echo $return_status['name']; ?></option>
										<?php } ?>
									<?php } ?>
								</select></td>
								<td>
									<p>	Дата создания</p>
								<input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" class="date" /></td>
								<td>
									<p>Дата изменения</p>
								<input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" size="12" class="date" /></td>
								<td align="right">
									<p>&#160;</p>
									<a onclick="filter();" class="button"><?php echo $button_filter; ?></a>
								</td>
						</tr>
					</tbody>
				</table>
				<div class="filter_bord"></div>
				<table class="list">
					<thead>
						<tr>
							<td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
							<td class="right"><?php if ($sort == 'r.return_id') { ?>
								<a href="<?php echo $sort_return_id; ?>" class="<?php echo strtolower($order); ?>">ID</a>
								<?php } else { ?>
								<a href="<?php echo $sort_return_id; ?>">ID</a>
							<?php } ?></td>
							<td class="right">
								П/К
							</td>
							<td class="right"><?php if ($sort == 'r.order_id') { ?>
								<a href="<?php echo $sort_order_id; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_order_id; ?>"><?php echo $column_order_id; ?></a>
							<?php } ?></td>
							<td class="left"><?php if ($sort == 'customer') { ?>
								<a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
							<?php } ?></td>
							<td></td>
							<td class="left"><?php if ($sort == 'r.product') { ?>
								<a href="<?php echo $sort_product; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_product; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_product; ?>"><?php echo $column_product; ?></a>
							<?php } ?></td>			
							<td class="left"><?php if ($sort == 'r.model') { ?>
								<a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>">Артикул</a>
								<?php } else { ?>
								<a href="<?php echo $sort_model; ?>">Артикул</a>
							<?php } ?></td>
							<td class="left">Кол.</td>
							<td class="left">Цена</td>
							<td class="left">Итог</td>
							<td class="left">
								Перезаказ
							</td>
							<td class="left"><?php if ($sort == 'status') { ?>
								<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
							<?php } ?></td>
							<td class="left"><?php if ($sort == 'r.date_added') { ?>
								<a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
							<?php } ?></td>
							<td class="left"><?php if ($sort == 'r.date_modified') { ?>
								<a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
								<?php } else { ?>
								<a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
							<?php } ?></td>
							<td class="right"><?php echo $column_action; ?></td>
						</tr>
					</thead>
					<tbody>
						
						<?php if ($returns) { ?>
							<?php foreach ($returns as $return) { ?>
								<tr>
									<td style="text-align: center;"><?php if ($return['selected']) { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $return['return_id']; ?>" checked="checked" />
										<?php } else { ?>
										<input type="checkbox" name="selected[]" value="<?php echo $return['return_id']; ?>" />
									<?php } ?></td>
									
									<td class="right"><b style="font-size:16px;"><?php echo $return['return_id']; ?></b></td>
									<td valign="center" style="text-align: center;">
										<span class="status_color_padding" style="color:#FFF;  background-color:<? if ($return['to_supplier'] == 1) { ?>#cf4a61<? } elseif ($return['to_supplier'] == 2) { ?>#4ea24e<? } elseif ($return['to_supplier'] == 0) { ?>#e4c25a<? } ?>;">
											<? if ($return['to_supplier'] == 1) { ?>Поставщику
												<? } elseif ($return['to_supplier'] == 2) { ?>Отказ
											<? } elseif ($return['to_supplier'] == 0) { ?>Клиента<? } ?>
										</span>
									</td>
									<td class="right"><a href="<? echo $return['order_href'] ?>" target="_blank"><?php echo $return['order_id']; ?></a></td>
									<td class="left"><a href="<? echo $return['customer_href'] ?>" target="_blank"><?php echo $return['customer']; ?></a></td>
									<td class="left" width="45px;"><img src="<? echo $return['image']; ?>" /></td>
									<td class="left"><a href="<? echo $return['product_href'] ?>" target="_blank"><?php echo $return['product']; ?></a></td>
									<td class="left"><?php echo $return['model']; ?></td>
									<td class="left"><?php echo $return['quantity']; ?></td>
									<td class="left" style="white-space: nowrap;"><?php echo $return['price']; ?></td>
									<td class="left" style="white-space: nowrap;"><?php echo $return['total']; ?></td>
									<td class="left"><?php echo $return['reorder_id']; ?></td>
									<td class="left"><?php echo $return['status']; ?></td>
									<td class="left"><?php echo $return['date_added']; ?></td>
									<td class="left"><?php echo $return['date_modified']; ?></td>
									<td class="center">
										<?php foreach ($return['action'] as $action) { ?>
											<a class="button" href="<?php echo $action['href']; ?>" style="padding: 3px 6px;margin: 0 0 4px 4px;"><i class="fa fa-edit"></i></a>
										<?php } ?>
										<br />
										<a class="button return-history" data-return-id="<?php echo $return['return_id']; ?>" style="padding:3px 7px;"><i class="fa fa-history"></i></a>
									</td>
								</tr>
							<?php } ?>
							<?php } else { ?>
							<tr>
								<td class="center" colspan="10"><?php echo $text_no_results; ?></td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</form>
			<div class="pagination"><?php echo $pagination; ?></div>
		</div>
	</div>
	<div id="mailpreview"></div>
</div>
<script>
	$('.return-history').click(function(){
		$.ajax({
			url: 'index.php?route=sale/return/history&token=<?php echo $token; ?>&return_id=' +  $(this).attr('data-return-id'),
			dataType: 'html',				
			success : function(html){
				$('#mailpreview').html(html).dialog({width:800, modal:true,resizable:true,position:{my: 'center', at:'center center', of: window}, closeOnEscape: true})				
			}
		})	
	});	
</script>
<script type="text/javascript"><!--
	function filter() {
		url = 'index.php?route=sale/return&token=<?php echo $token; ?>';
		
		var filter_return_id = $('input[name=\'filter_return_id\']').attr('value');
		
		if (filter_return_id) {
			url += '&filter_return_id=' + encodeURIComponent(filter_return_id);
		}
		
		var filter_order_id = $('input[name=\'filter_order_id\']').attr('value');
		
		if (filter_order_id) {
			url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
		}	
		
		var filter_customer = $('input[name=\'filter_customer\']').attr('value');
		
		if (filter_customer) {
			url += '&filter_customer=' + encodeURIComponent(filter_customer);
		}
		
		var filter_product = $('input[name=\'filter_product\']').attr('value');
		
		if (filter_product) {
			url += '&filter_product=' + encodeURIComponent(filter_product);
		}
		
		var filter_model = $('input[name=\'filter_model\']').attr('value');
		
		if (filter_model) {
			url += '&filter_model=' + encodeURIComponent(filter_model);
		}
		
		var filter_return_status_id = $('select[name=\'filter_return_status_id\']').attr('value');
		
		if (filter_return_status_id != '*') {
			url += '&filter_return_status_id=' + encodeURIComponent(filter_return_status_id);
		}	
		
		var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
		
		if (filter_date_added) {
			url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
		}
		
		var filter_date_modified = $('input[name=\'filter_date_modified\']').attr('value');
		
		if (filter_date_modified) {
			url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
		}
		
		location = url;
	}
//--></script> 
<script type="text/javascript"><!--
	$.widget('custom.catcomplete', $.ui.autocomplete, {
		_renderMenu: function(ul, items) {
			var self = this, currentCategory = '';
			
			$.each(items, function(index, item) {
				if (item.category != currentCategory) {
					ul.append('<li class="ui-autocomplete-category">' + item.category + '</li>');
					
					currentCategory = item.category;
				}
				
				self._renderItem(ul, item);
			});
		}
	});
	
	$('input[name=\'filter_customer\']').catcomplete({
		delay: 500,
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request.term),
				dataType: 'json',
				success: function(json) {		
					response($.map(json, function(item) {
						return {
							category: item.customer_group,
							label: item.name,
							value: item.customer_id
						}
					}));
				}
			});
		}, 
		select: function(event, ui) {
			$('input[name=\'filter_customer\']').val(ui.item.label);
			
			return false;
		},
		focus: function(event, ui) {
			return false;
		}
	});
//--></script> 
<script type="text/javascript"><!--
	$(document).ready(function() {
		$('.date').datepicker({dateFormat: 'yy-mm-dd'});
	});
//--></script> 
<?php echo $footer; ?> 	