<?php echo $header; ?>
<style>
	a.button.active { color: #fff !important;background-color: #6A6A6A;text-decoration: none !important; }
	tr.hovered td {background-color:#faf9f1 !important;}
	tr.blue:hover td{background:#99CCFF !important; color:#FFF !important;}
	tr.blue  td{background:#99CCFF !important; color:#FFF !important;}
	td.td_alert {background:#FF99CC !important;}
	.admin_home{width:100%;background: #f3f3f3 url(/admin/view/image/bg_grey.png) repeat;}
	.admin_home tr td{text-align:center; padding-bottom:30px;}
	.admin_home tr td i{font-size:72px; color:#3a4247;}
	.admin_home tr td a{color:#3a4247;}
	div.admin_button {float:left; text-align:center; border: 1px solid #ededed; margin-right:10px; margin-bottom:10px;}
	div.admin_button_status {float:left; padding: 10px; text-align:center;margin-right:10px; margin-bottom:10px;border-radius: 2px;width: 105px;height: 95px;}
	div.admin_button_status a {font-size:11px;}
	.admin_button i{font-size:40px;opacity: 0.8;padding: 15px;}
	.admin_button_status i {font-size:40px;opacity: 0.8;}
	.admin_button i:hover, .admin_button_status i:hover {opacity: 1;}
	.admin_button a, .admin_button_status a {text-decoration:none; color:#FFF; }
	.admin_button.red {color:#f91c02;}
	.admin_button.red i {color:#f91c02;}
	/*
	.admin_button._green {background:#00ad07;}
	.admin_button._blue {background:#0054b3}
	.admin_button._yellow {background:#ffcc00}
	*/
</style>
<style type="text/css">
	.pull-right {
	float:right;
	}
	.label {
	display: inline;
	padding: .2em .6em .3em;
	font-size: 75%;
	font-weight: bold;
	line-height: 1;
	color: #ffffff;
	text-align: center;
	white-space: nowrap;
	vertical-align: baseline;
	border-radius: .25em;
	}
	.label-success {
	background-color: #5cb85c;
	}
	.label-info {
	background-color: #5bc0de;
	}
	.label-warning {
	background-color: #f0ad4e;
	}
	.label-danger {
	background-color: #d9534f;
	}
</style>
<style>
	span._red{display:inline-block; font-size:18px; background:#FF8080; color:#fff;}
	span._orange{display:inline-block; font-size:18px; background:#F93; color:#fff;}
	span._green{display:inline-block; font-size:18px; background:#CCFFCC; color:#000!important;}
</style>
<div id="content">
	<div class="breadcrumb">
		<?php foreach ($breadcrumbs as $breadcrumb) { ?>
			<?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
		<?php } ?>
	</div>
	<div class="box">
		<div class="heading order_head">
			<h1>???????? ?????????????????????????? ????????????????????</h1>				  					
		</div>
		<div class="clear:both"></div>
		<div class="content" style="padding:5px;">
			<div> 
				<? foreach ($periods as $period) { ?>
					<a class="button <? if ($current_period == $period['date']) { ?>active<? } ?>" href="<? echo $period['href']; ?>" style="margin-right:10px; margin-bottom:5px;"><? echo $period['name']; ?></a>
				<? } ?>
			</div>
			<div style="margin-top:10px;"> 
				<table class="list">
					
					<tr class='blue'>
						<td></td>
						<? foreach ($managers as $manager) { ?>						
							<td style="font-size:20px; text-align:center;"><? echo $manager['realname']; ?></td>
						<? } ?>
					</tr>
					
					<tr>
						<td width="200px"; height="110px"; style="text-align:center; max-width:200px; font-size:24px;">KPI</td>
						<? unset($manager); foreach ($managers as $manager) { ?>
							<td style="padding:10px; text-align:center;">
								<? if (!empty($manager['kpi_stats'])) { ?>
									<span class="ktooltip_hover label <? echo $manager['kpi_stats']['complete_cancel_percent_clr']; ?>" style="" data-tooltip-content="#complete_cancel_percent-html-content">???????? <? echo $manager['kpi_stats']['complete_cancel_percent']; ?></span><br /><br />
									<span class="ktooltip_hover label <? echo $manager['kpi_stats']['average_confirm_time_clr']; ?>" style="margin-left:10px" data-tooltip-content="#average_confirm_time-html-content">???????? <? echo $manager['kpi_stats']['average_confirm_time']; ?> ????.</span><br /><br />
									<span class="ktooltip_hover label <? echo $manager['kpi_stats']['average_process_time_clr']; ?>" style="margin-left:10px" data-tooltip-content="#average_process_time-html-content">???????? <? echo $manager['kpi_stats']['average_process_time']; ?> ????.</span><br /><br />
									
									<div style="display:none;" >
										<div id="complete_cancel_percent-html-content">
											<b style="font-size:18px;">???????? - ?????????????? ?????????????????????????????? ?????????????? ??????????????????</b><br /><br />
											<span class="label _green">?????????????? ???????? ???? <? echo $manager['kpi_stats']['complete_cancel_percent_params'][0]; ?>%</span><br /><br />
											<span class="label _orange">???????????? ???????? ???? <? echo $manager['kpi_stats']['complete_cancel_percent_params'][0]; ?>% ???? <? echo $manager['kpi_stats']['complete_cancel_percent_params'][1]; ?>%</span><br /><br />
											<span class="label _red">?????????????? ???????? ?????????? <? echo $manager['kpi_stats']['complete_cancel_percent_params'][1]; ?>%</span>
										</div>
									</div>
									
									<div style="display:none;" >
										<div id="average_confirm_time-html-content">
											<b style="font-size:18px;">???????? - ?????????????? ?????????? ?????????????????????????? ??????????????</b><br /><br />
											<span class="label _green">?????????????? ???????? ???? <? echo $manager['kpi_stats']['average_confirm_time_params'][0]; ?> ????.</span><br /><br />
											<span class="label _orange">???????????? ???????? ???? <? echo $manager['kpi_stats']['average_confirm_time_params'][0]; ?> ???? <? echo $manager['kpi_stats']['average_confirm_time_params'][1]; ?> ????.</span><br /><br />
											<span class="label _red">?????????????? ???????? ?????????? <? echo $manager['kpi_stats']['average_confirm_time_params'][1]; ?> ????.</span>
										</div>
									</div>
									
									<div style="display:none;" >
										<div id="average_process_time-html-content">
											<b style="font-size:18px;">???????? - ?????????????? ?????????? ???????????????? ??????????????</b><br /><br />
											<span class="label _green">?????????????? ???????? ???? <? echo $manager['kpi_stats']['average_process_time_params'][0]; ?> ????.</span><br /><br />
											<span class="label _orange">???????????? ???????? ???? <? echo $manager['kpi_stats']['average_process_time_params'][0]; ?> ???? <? echo $manager['kpi_stats']['average_process_time_params'][1]; ?> ????.</span><br /><br />
											<span class="label _red">?????????????? ???????? ?????????? <? echo $manager['kpi_stats']['average_process_time_params'][1]; ?> ????.</span>
										</div>
									</div>
								<? } ?>
							</td>
						<? } ?>
					</tr>
					
					<? foreach ($order_statuses as $order_status) { ?>
						
						<tr>
							<td width="200px"; height="110px"; style="text-align:center; max-width:200px; background-color: #<?php echo isset($order_status['order_status']['status_bg_color']) ? $order_status['order_status']['status_bg_color'] : ''; ?> !important; color: #<?php echo isset($order_status['order_status']['status_txt_color']) ? $order_status['order_status']['status_txt_color'] : ''; ?>;">
								<div style="font-size:28px;"><? if ($order_status['order_status']['status_fa_icon']) { ?>
									<i class="fa <? echo $order_status['order_status']['status_fa_icon']; ?>" aria-hidden="true"  style="color: #<?php echo isset($order_status['order_status']['status_txt_color']) ? $order_status['order_status']['status_txt_color'] : ''; ?>"></i>
									<? } else { ?>
									<i class="fa fa-shopping-bag" aria-hidden="true"  style="color: #<?php echo isset($order_status['order_status']['status_txt_color']) ? $order_status['order_status']['status_txt_color'] : ''; ?>"></i>
								<? } ?></div>
								<div style="font-size:12px;"><? echo $order_status['order_status']['name']; ?></div>
							</td>
							
							<? unset($manager); foreach ($order_status['managers'] as $manager) { ?>	
								<td style="text-align:center; font-size:28px; wordwrap:none; word-wrap: normal;">
									<div>
										<? if ($order_status['order_status']['is_problem'] && $manager['count'] > 0) { ?>
											
											<? if (isset($manager['was_today_morning'])) { ?>
												<span title="???????? ?????????????? ?? ????????" class="ktooltip_hover status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#FFF">
													<? echo $manager['was_today_morning']; ?>	
												</span>
												&nbsp;<i class="fa fa-arrow-right" style="color:#cf4a61; font-size:14px;" aria-hidden="true"></i>&nbsp;
											<? } ?>
											
											<? if (isset($manager['was_that_morning'])) { ?>
												<span title="???????? ?????????? ?? ???????? ????????" class="ktooltip_hover status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#FFF">
													<? echo $manager['was_that_morning']; ?>	
												</span>
												&nbsp;<i class="fa fa-arrow-right" style="color:#cf4a61; font-size:14px;" aria-hidden="true"></i>&nbsp;
											<? } ?>
											
											<span title="???? ?????????? ??????" class="ktooltip_hover status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#FFF">
												<? echo $manager['count']; ?>												
											</span>
											
											<? } else { ?>
											
											<? if (isset($manager['was_today_morning'])) { ?>
												<span title="???????? ?????????????? ?? ????????" class="ktooltip_hover" style="color:#1f4962">
													<? echo $manager['was_today_morning']; ?>	
												</span>
												&nbsp;<i class="fa fa-arrow-right" style="color:#1f4962; font-size:14px;" aria-hidden="true"></i>&nbsp;
											<? } ?>
											
											<? if (isset($manager['was_that_morning'])) { ?>
												<span title="???????? ?????????? ?? ???????? ????????" class="ktooltip_hover" style="color:#1f4962">
													<? echo $manager['was_that_morning']; ?>	
												</span>
												&nbsp;<i class="fa fa-arrow-right" style="color:#1f4962; font-size:14px;" aria-hidden="true"></i>&nbsp;
											<? } ?>
											
											<span title="???? ?????????? ??????" class="ktooltip_hover" style="color:#1f4962">
												<? echo $manager['count']; ?>												
											</span>
											
										<? } ?>
									</div>
									<div style="margin-top:10px;  font-size:13px; border-top:1px solid #eee; padding:5px; text-align:center;">
										<div>
											<? if (isset($manager['diff_morning'])) { ?>
												<? if ($order_status['order_status']['is_problem']) { ?>
													<? if ($manager['diff_morning'] >= 0) { ?>
														<? /* ???????????????????? ?????????? ???????????? */ ?>
														
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#FFF">															
															???? ?????????????? <? echo $manager['diff_morning']; ?>
														</span>
														
														<? } else { ?>
														<? /* ???????????????????? ?????????? ???????????? */ ?>	
														
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#4ea24e; color:#FFF">															
															???? ?????????????? <? echo $manager['diff_morning']; ?>
														</span>
														
													<? } ?>		
													
													<? if ($manager['last_order_date']) { ?>
														
														<? if ($manager['last_order_date_diff'] > 42) { ?>														
															<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#fff;">?????????????? ???? <? echo $manager['last_order_date']; ?></span>
															<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61;  color:#fff;"><? echo $manager['last_order_date_diff']; ?> ????.</span>
															<? } else { ?>
															<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ffaa56;">?????????????? ???? <? echo $manager['last_order_date']; ?></span>
															<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ffaa56;"><? echo $manager['last_order_date_diff']; ?> ????.</span>
														<? } ?>
														
														
													<? } ?>
													
													<? } else { ?>
													
													<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ccc;">															
														???? ?????????????? <? echo $manager['diff_morning']; ?>
													</span>
													<? if ($manager['last_order_date_diff'] > 42) { ?>														
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#fff;">?????????????? ???? <? echo $manager['last_order_date']; ?></span>
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61;  color:#fff;"><? echo $manager['last_order_date_diff']; ?> ????.</span>
														<? } else { ?>
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ffaa56;">?????????????? ???? <? echo $manager['last_order_date']; ?></span>
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ffaa56;"><? echo $manager['last_order_date_diff']; ?> ????.</span>
													<? } ?>
													
												<? } ?>
												
												
												
												<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ccc;"><a href="<? echo $manager['href']; ?>" style="text-decoration:none" target="_blank">????????????</a></span>												
											<? } ?>
											
											<? if (isset($manager['diff_day'])) { ?>
												<? if ($order_status['order_status']['is_problem']) { ?>
													<? if ($manager['diff_day'] >= 0) { ?>
														<? /* ???????????????????? ?????????? ???????????? */ ?>
														
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#cf4a61; color:#FFF">															
															???? ???????? <? echo $manager['diff_day']; ?>
														</span>
														
														<? } else { ?>
														<? /* ???????????????????? ?????????? ???????????? */ ?>	
														
														<span class="status_color" style="display:inline-block; padding:3px 5px; background:#4ea24e; color:#FFF">															
															???? ???????? <? echo $manager['diff_day']; ?>
														</span>
														
													<? } ?>
													<? } else { ?>
													
													<span class="status_color" style="display:inline-block; padding:3px 5px; background:#ccc;">															
														???? ???????? <? echo $manager['diff_day']; ?>
													</span>
												<? } ?>
											<? } ?>											
										</div>
										<div></div>
									</div>
								</td>
							<? } ?>
							
						</tr>
						
					<? } ?>
				</table>
			</div>
			
		</div>
	</div>
</div>
<?php echo $footer; ?> 	