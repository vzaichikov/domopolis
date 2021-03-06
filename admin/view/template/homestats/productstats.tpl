<style>
	.list.big thead td, .list.big tr.small td{font-size:12px; font-weight:700;}
	.list.big tbody td{font-size:16px;}
	.list.small-bottom-margin{margin-bottom: 0px;}
	.list.no-top-border td{border-top:0px;}
	.list tbody td a{text-decoration: none; color: gray;}
</style>


<div class="dashboard-heading">
	<i class="fa fa-ambulance"></i> Что происходит с контентом?			
</div>
<div class="dashboard-content" style="min-height:91px;">
			<table class="list big small-bottom-margin">
				<thead>
					<tr>
						<td colspan="5" class="left">
							Товары
						</td>
					</tr>					
				</thead>
				<tr class="small">
					<td style="color:#66c7a3"><i class="fa fa-plus" aria-hidden="true"></i> <a style="color:#66c7a3" href="<?php echo $filter_total_products_added_today; ?>">Сегодня<i class="fa fa-filter"></i></a></td>
					<td style="color:#3276c2"><i class="fa fa-plus" aria-hidden="true"></i> <a style="color:#3276c2" href="<?php echo $filter_total_products_added_yesterday; ?>">Вчера <i class="fa fa-filter"></i></a></td>
					<td style="color:#24a4c1"><i class="fa fa-plus" aria-hidden="true"></i> Неделя</td>		
					<td style="color:#24a4c1"><i class="fa fa-plus" aria-hidden="true"></i> Месяц</td>
					<td style="color:#fa4934"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <a style="color:#fa4934" href="<?php echo $filter_total_products_invalid_asin; ?>">Плохие <i class="fa fa-filter"></i></a></td>			
				</tr>
				<tr class="small">
					<td><?php echo $total_products_added_today; ?></td>
					<td><?php echo $total_products_added_yesterday; ?></td>
					<td><?php echo $total_products_added_week; ?></td>
					<td><?php echo $total_products_added_month; ?></td>
					<td style="color:#fa4934"><?php echo $total_products_invalid_asin; ?></td>
				</tr>

				<tr class="small">
						<td style="color:#66c7a3">Σ В базе</td>
						<td style="color:#fa4934"><a style="color:#fa4934" href="<?php echo $filter_total_products_enabled; ?>">Включено<i class="fa fa-filter"></i></a></td>
						<td style="color:#3276c2"><a style="color:#3276c2" href="<?php echo $filter_total_products_in_tech; ?>">В тех.кат.<i class="fa fa-filter"></i></a></td>
						<td style="color:#24a4c1"><a style="color:#24a4c1" href="<?php echo $filter_total_product_parsed; ?>">Загружено <i class="fa fa-filter"></i></a></td>
						<td style="color:#24a4c1">Загружать</td>						
					</tr>
				<tr class="small">
					<td><?php echo $total_products; ?></td>
					<td><?php echo $total_product_enabled; ?></td>
					<td><?php echo $total_products_in_tech; ?> </td>
					<td><?php echo $total_product_parsed; ?></td>
					<td><?php echo $total_product_need_to_be_parsed; ?></td>
				</tr>				
			</table>

			<table class="list big small-bottom-margin">
				<thead>
					<tr>
						<td colspan="6" class="left">
							Офферы
						</td>
					</tr>					
				</thead>
				<tr class="small">
					<td style="color:#3276c2"><i class="fa fa-hourglass" aria-hidden="true"></i> Ждет</td>
					<td style="color:#24a4c1">Σ Всего</td>
					<td style="color:#3276c2"><i class="fa fa-refresh" aria-hidden="true"></i> Сегодня</td>
					<td style="color:#3276c2"><i class="fa fa-refresh" aria-hidden="true"></i> Вчера</td>
					<td style="color:#66c7a3"><i class="fa fa-thumbs-up" aria-hidden="true"></i> <a style="color:#66c7a3" href="<?php echo $filter_total_product_have_offers; ?>">В нал <i class="fa fa-filter"></i></a></td>		
					<td style="color:#fa4934"><i class="fa fa-thumbs-down" aria-hidden="true"></i> <a style="color:#fa4934" href="<?php echo $filter_total_product_have_no_offers; ?>">Нету <i class="fa fa-filter"></i></a></td>				
				</tr>
				<tr class="small">
					<td><?php echo $total_product_to_get_offers; ?></td>
					<td><?php echo $total_product_got_offers; ?></td>
					<td><?php echo $total_product_got_offers_today; ?></td>
					<td><?php echo $total_product_got_offers_yesterday; ?></td>
					<td><?php echo $total_product_have_offers; ?></td>
					<td><?php echo $total_product_have_no_offers; ?></td>
				</tr>		
			</table>			

			<table class="list big small-bottom-margin no-top-border">
				<thead>
					<tr>
						<td colspan="4" class="left">
							Категории
						</td>
					</tr>
					<tr>
						<td style="color:#66c7a3"><i class="fa fa-list" aria-hidden="true"></i> Всего</td>
						<td style="color:#3276c2"><i class="fa fa-amazon" aria-hidden="true"></i> Конечных</td>
						<td style="color:#24a4c1"><i class="fa fa-share" aria-hidden="true"></i> Синхрон</td>
						<td style="color:#fa4934"><i class="fa fa-refresh" aria-hidden="true"></i> Полные</td>
					</tr>
					<tr>
						<td><?php echo $total_categories; ?></td>
						<td><?php echo $total_categories_final; ?></td>
						<td><?php echo $total_categories_enable_load; ?></td>
						<td><?php echo $total_categories_enable_full_load; ?></td>
					</tr>
				</thead>
			</table>

			<table class="list big small-bottom-margin no-top-border">
				<thead>
					<tr>
						<td colspan="6" class="left">
							Переводчик
						</td>
					</tr>
					<tr>
						<td style="color:#66c7a3"><i class="fa fa-yahoo" aria-hidden="true"></i> Всего</td>
						<td style="color:#66c7a3"><i class="fa fa-yahoo" aria-hidden="true"></i> Час</td>
						<td style="color:#66c7a3"><i class="fa fa-yahoo" aria-hidden="true"></i> Сегодня</td>
						<td style="color:#3276c2"><i class="fa fa-yahoo" aria-hidden="true"></i> Вчера</td>
						<td style="color:#24a4c1"><i class="fa fa-yahoo" aria-hidden="true"></i> Неделя</td>
						<td style="color:#fa4934"><i class="fa fa-yahoo" aria-hidden="true"></i> Месяц</td>
					</tr>
					<tr>
						<td><?php echo $translated_total; ?></td>
						<td><?php echo $translated_total_hour; ?></td>
						<td><?php echo $translated_total_today; ?></td>
						<td><?php echo $translated_total_yesterday; ?></td>
						<td><?php echo $translated_total_week; ?></td>
						<td><?php echo $translated_total_month; ?></td>
					</tr>
				</thead>

			</table>
</div>
