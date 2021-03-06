<!DOCTYPE html>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
	<head>
		<? require_once(dirname(__FILE__).'/../pwa.tpl'); ?>
		
		<meta charset="utf-8">
		<meta name="viewport"
		content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title><?php echo $title; ?></title>
		<link href="<? echo FAVICON; ?>" rel="icon" type="image/x-icon" />
		<base href="<?php echo $base; ?>" />
		<?php if ($description) { ?>
			<meta name="description" content="<?php echo $description; ?>" />
		<?php } ?>
		<?php if ($keywords) { ?>
			<meta name="keywords" content="<?php echo $keywords; ?>" />
		<?php } ?>
		<?php foreach ($links as $link) { ?>
			<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
		<?php } ?>
		<link rel="stylesheet" href="view/stylesheet/font-awesome-4.7.0/css/font-awesome.min.css">
		<link type="text/css" href="view/javascript/jquery/ui/themes/redmond/jquery-ui-1.9.2.custom.min.css" rel="stylesheet" />
		<link rel="stylesheet" type="text/css" href="view/stylesheet/<? echo FILE_STYLE; ?>?v=<?php echo mt_rand(0,10000); ?>" />
		<link rel="stylesheet" type="text/css" href="view/stylesheet/<? echo FILE_STYLE2; ?>?v=<?php echo mt_rand(0,10000); ?>" />
		<link rel="stylesheet" type="text/css" href="view/stylesheet/mobile.css?v=<?php echo rand(); ?>" />
		<link rel="stylesheet" type="text/css" href="view/stylesheet/tickets.css" />
		<?php foreach ($styles as $style) { ?>
			<link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
		<?php } ?>
		
		<script type="text/javascript" src="view/javascript/jquery/jquery-1.7.2.min.js"></script>
		<script type="text/javascript" src="view/javascript/jquery/ui/jquery-ui-1.9.2.custom.min.js"></script>
		<script type="text/javascript" src="view/javascript/common.js"></script>
		<script type="text/javascript" src="view/javascript/script-mobile.js"></script>
		
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic" rel="stylesheet"> 
		<?php foreach ($scripts as $script) { ?>
			<script type="text/javascript" src="<?php echo $script; ?>"></script>
		<?php } ?>
		<script type="text/javascript">
			//-----------------------------------------
			// Confirm Actions (delete, uninstall)
			//-----------------------------------------
			$(document).ready(function(){
				// Confirm Delete
				$('#form').submit(function(){
					if ($(this).attr('action').indexOf('delete',1) != -1) {
						if (!confirm('<?php echo $text_confirm; ?>')) {
							return false;
						}
					}
				});
				// Confirm Uninstall
				$('a').click(function(){
					if ($(this).attr('href') != null && $(this).attr('href').indexOf('uninstall', 1) != -1) {
						if (!confirm('<?php echo $text_confirm; ?>')) {
							return false;
						}
					}
				});
			});
		</script>
		
		<!-- Admin Header Notices 1.0 -->
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
		<!-- Admin Header Notices 1.0 -->
		
		<?php if ($this->config->get('admin_quick_edit_status') && ($this->config->get('aqe_alternate_row_colour') || $this->config->get('aqe_row_hover_highlighting'))) { ?>
			<style type="text/css">
				<?php if ($this->config->get('aqe_alternate_row_colour')) { ?>
					table.list tbody tr:not([class~=filter]):nth-child(even) td {background: #F8F8FB !important}
					table.list tbody tr:not([class~=filter]).selected_row td {background-color:#ffffde !important}
				<?php } ?>
				<?php if ($this->config->get('aqe_row_hover_highlighting')) { ?>
					table[class=list] tbody tr:not([class~=filter]):hover td {background: #faf9f1 !important}
					table[class=list] tbody tr:not([class~=filter]).selected_row:hover td {background: #ffefde !important}
				<?php } ?>
			</style>
		<?php } ?>
		<script type="text/javascript">
			$(document).ready(function() {
				$('input[type=checkbox][name^="selected"]').change(function () {
					if ($(this).is(':checked')) {
						$(this).parents('tr').first().addClass('selected_row');
						} else {
						$(this).parents('tr').first().removeClass('selected_row');
					}
				});
			});
		</script>
		
		<link rel="Stylesheet" type="text/css" href="view/stylesheet/jpicker-1.1.6.min.css" />
		<link rel="Stylesheet" type="text/css" href="view/stylesheet/jpicker.css" />
		<script src="view/javascript/jquery/jpicker-1.1.6.min.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div class="div1">
					<div class="div2">
						<?php if ($logged) { ?>
							<style>
								@media (max-width: 600px) { .hidden-xs{display:none;} .user-name-1{padding-left:0px!important;}  }

							</style>
							<img class="d_img hidden-xs" src="view/image/<? echo FILE_LOGO; ?>" style="float:left;margin-top:0px; height:38px!important;" title="<?php echo $heading_title; ?>" height="38px" onclick="location = '<?php echo $home; ?>'" />	
							<div class="user-name-1" style="float:left; color:#000; font-weight:700; padding-left:20px;">
								<i class="fa fa-user-o icon_header hidden-xs"></i>
								<div style="display: inline-block;"><? echo $this->user->getUserFullName(); ?> (<? echo $this->user->getUserName(); ?>) <a style="color:#788084" href="<?php echo $logout; ?>"><b><i class="fa fa-external-link"></i></b></a>
								<span class="hidden-xs"><br /><? echo $this->user->getUserGroupName(); ?></span>
								</div>
							</div>
						<? } ?>	
						<?php if ($logged) { ?>
							<div id="menu_top">
								<ul class="left">
									<li id="alertlog"><a class="top" href="<? echo $user_alerts; ?>" id="alert_history_preview_click"><span class="label label-danger" style="font-size:16px;"><i class='fa fa-bell' style="color:#FFF"></i></span></a></li>
									<!-- Admin Panel Notication -->
									<li id="notification" class="header-notifications delayed-load short-delayed-load" data-route='common/home/loadNotifications'>
										
									</li>
									<!-- Admin Header Notices 1.0 -->
									<li id="callbacks">
										<a class="top" href="<? echo $callback; ?>"><span class="label label-danger" style="font-size:16px;"><i class="fa fa-phone-square" ></i> &nbsp;<?php echo $total_callbacks; ?></span></a>		
									</li>
									
									<li id="waitlists">
										<a class="top" href="<? echo $waitlist_ready; ?>"><span class="label label-danger" style="font-size:16px;"><i class="fa fa-thumbs-up" ></i>&nbsp;<?php echo $total_waitlist_ready; ?></span></a>										
									</li>

									<li id="waitlists-pre">
										<a class="top" href="<? echo $waitlist_pre; ?>"><span class="label label-danger" style="font-size:16px;"><i class="fa fa-hourglass-half" ></i>&nbsp;<?php echo $total_waitlist_prewaits; ?></span></a>
									</li>
									
									<li id="waitlists-pre">
										<a class="top" href="<? echo $courier_face2; ?>"><span class="label label-danger" style="font-size:16px;"><i class="fa fa-truck" ></i></span></a>
									</li>
									
								</ul>
								<style>
									#menu_top > ul li ul{
									display:none;
									}
									
									#menu_top > ul > li.hover > ul{
									display:block;
									}
									
									#menu_top > ul > li.sfhover > ul{
									display:block;
									}
									
									#menu_top > ul > li > ul > li > ul{
									display:none;
									}
									
									#menu_top > ul > li > ul > li:hover > ul{
									display:block;
									}
								</style>
								
								<div style="clear: both;"></div>
							</div>
						<? } ?>	
					</div>
					<?php if ($logged) { ?>
						<div class="div3" id="cacheButtons" style="margin-right:100px; float:right;">
							
						</div>
						<script>
							function loadCacheButtons(){
								$('#cacheButtons').load('index.php?route=setting/setting/getFPCINFO&token=<?php echo $token;?>');
							}
							
							$(document).ready(function() {
								loadCacheButtons();
								setInterval(function() { loadCacheButtons(); }, 10000);   				
							});
						</script>
					<? } ?>
					<div style="clear: both;"></div>
				</div>
				<?php if ($logged) { ?>  	
					<div id="menu">										
						<ul class="left">
							<? if ($user_sip_history) { ?>
								<li id="user_sip_history"><a href="<?php echo $user_sip_history; ?>" class="top"><i class="fa fa-phone-square icon_menu" aria-hidden="true"></i>????????????</a></li>
							<? } ?>
							<li id="tasks"><a href="<?php echo $user_ticket; ?>" class="top"><i class="fa fa-calendar icon_menu" aria-hidden="true"></i>????????????</a></li>
							<li id="add_task"><a id="trigger_add_task" class="top"><i class="fa fa-calendar-plus-o icon_menu" aria-hidden="true"></i>????????????</a></li> 
						</ul>
						
						
						<? if (isset($ONLYCURRENCY)) { ?>
							<div style="float:left; margin-left:40px; color:#FFF; font-size:26px; line-height:60px;">
								1??? = <? echo $ONLYCURRENCY; ?>
							</div>
							<? } else { ?>
							<div style="float:left; margin-left:40px; color:#FFF; font-size:14px; line-height:30px;">
								1??? = <? echo $RUBEUR; ?><br />
								1??? = <? echo $UAHEUR; ?><br />
							</div>
						<? } ?>
						
						
						<ul class="right">
							<li id="dashboard"><a href="<?php echo $home; ?>" class="top"><i class="fa fa-home icon_menu"></i><?php echo $text_dashboard; ?></a></li>
							<li id="panel">
								<a class="top" href="<?php echo $panel; ?>"><i class="fa fa-bell icon_menu"></i>????????????</a>
							</li>
							<li id="cronmon">
								<a class="top" href="<?php echo $cronmon; ?>"><i class="fa fa-refresh icon_menu"></i>Cron</a>
							</li>
							<? if (in_array($this->user->getID(), array(2, 3))) { ?>
								<li id="worktime"><a class="top"><i class="fa fa-eye icon_menu"></i>????????????</a>
									<ul>
										<li id="user_worktime"><a class="home_icon_style" href="<?php echo $user_worktime; ?>"><i class="fa fa-eye"  aria-hidden="true"></i><span>???????????? ???????????? ???? ????????</span></a></li>
										<li id="manager_quality"><a class="home_icon_style" href="<?php echo $manager_quality; ?>"><i class="fa fa-bar-chart"  aria-hidden="true"></i><span>???????????? ???? ????????????????????</span></a></li>
										<li id="salary_manager"><a class="home_icon_style" href="<?php echo $salary_manager; ?>"><i class="fa fa-handshake-o"  aria-hidden="true"></i><span>?????????? ???? ???????????????? ?????????????? - ??????????????????</span></a></li>
										<li id="salary_customerservice"><a class="home_icon_style" href="<?php echo $salary_customerservice; ?>"><i class="fa fa-users"  aria-hidden="true"></i><span>?????????? ???? ?????????????????????? ???????????? - ????????????-????????????</span></a></li>
									</ul>
								</li>
							<? } ?>
						</li>
						<li id="catalog"><a class="top"><i class="fa fa-bars icon_menu"></i><?php echo $text_catalog; ?></a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $category; ?>"><i class="fa fa-minus"></i><span><?php echo $text_category; ?></span></a></li>								
								<li><a class="home_icon_style" href="<?php echo $product; ?>"><i class="fa fa-cubes"></i><span><?php echo $text_product; ?></span></a></li>	
								<li><a class="home_icon_style" href="<?php echo $product_deletedasin; ?>"><i class="fa fa-amazon"></i><span>?????????????????????? ASIN  <sup style="color:red">(NEW)</sup></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $ocfilter; ?>"><i class="fa fa-cubes"></i><span><?php echo $text_ocfilter; ?> <sup style="color:red">(DEV)</sup></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $ocfilter_page; ?>"><i class="fa fa-cubes"></i><span>???????????????????? ???????????????? <sup style="color:red">(DEV)</sup></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $batch_editor_link; ?>"><i class="fa fa-pencil-square-o"></i><span>Batch Editor v.023</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $batch_editor_link2; ?>"><i class="fa fa-pencil-square-o"></i><span>Batch Editor v.047</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $filter; ?>"><i class="fa fa-filter"></i><span><?php echo $text_filter; ?></span></a></li>        
								<li><a class="home_icon_style parent"><i class="fa fa-file-text-o"></i><span><?php echo $text_attribute; ?></span></a>
									<ul>
										<li><a href="<?php echo $attribute; ?>"><?php echo $text_attribute; ?></a></li>
										<li><a href="<?php echo $attribute_group; ?>"><?php echo $text_attribute_group; ?></a></li>
									</ul>
								</li>
								<li><a class="home_icon_style" href="<?php echo $option; ?>"><i class="fa fa-sliders"></i><span><?php echo $text_option; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $manufacturer; ?>"><i class="fa fa-barcode"></i><span>????????????</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $countrybrands_link; ?>"><i class="fa fa-flag"></i><span>???????????? ???? ??????????????</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $collections_link; ?>"><i class="fa fa-linode"></i><span>??????????????????</span></a></li>
								
								<? /*	
									<li><a href="<?php echo $labelmaker; ?>">?????????? ??????????????</a></li>
									<li><a href="<?php echo $product_statuses; ?>"><?php echo $text_product_statuses; ?></a></li>  
								*/ ?>
								<li><a class="home_icon_style" href="<?php echo $keyworder_link; ?>"><i class="fa fa-exchange"></i><span>???????????? ??????????????????????????/??????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $sets_link; ?>"><i class="fa fa-window-restore"></i><span>?????????????????? ??????????????</span></a></li>								
								
								<!--<li><a href="<?php echo $download; ?>"><?php echo $text_download; ?></a></li>-->
								<!-- FAproduct -->
								<li><a class="home_icon_style" href="<?php echo $facategory; ?>"><i class="fa fa-diamond"></i><span><?php echo $text_facategory; ?></span></a></li>
								<!-- FAproduct -->
							</ul>
						</li>
						<li id="information"><a class="top"><i class="fa fa-info icon_menu"></i>????????</a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $review; ?>"><i class="fa fa-comments-o"></i><span><?php echo $text_review; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $shop_rating; ?>"><i class="fa fa-bar-chart"></i><span><?php echo $text_shop_rating; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $review_category; ?>"><i class="fa fa-comments-o"></i><span><?php echo $text_review_category; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $information; ?>"><i class="fa fa-newspaper-o"></i><span><?php echo $text_information; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $landingpage; ?>"><i class="fa fa-star"></i><span>???????????????????? ????????????????</span></a></li>
								<li><a class="home_icon_style parent"><i class="fa fa-info-circle"></i><span>?????????????? + ????????</span></a>
									<ul>
										<li><a style="width: 195px;" href="<?php echo $npages; ?>"><?php echo $entry_npages; ?></a></li>
										<li><a style="width: 195px;" href="<?php echo $ncategory; ?>"><?php echo $entry_ncategory; ?></a></li>
										<li><a style="width: 195px;" href="<?php echo $tocomments; ?>"><?php echo $text_commod; ?></a></li>
										<li><a style="width: 195px;" href="<?php echo $nauthor; ?>"><?php echo $text_nauthor; ?></a></li>
										<li><a style="width: 195px;" href="<?php echo $nmod; ?>"><?php echo $entry_nmod; ?></a></li>
										<li><a style="width: 195px;" href="<?php echo $ncmod; ?>"><?php echo $entry_ncmod; ?></a></li>
									</ul>
								</li>
								<li><a class="home_icon_style" href="<?php echo $information_attribute; ?>"><i class="fa fa-newspaper-o"></i><span>???????????? ?????? ??????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $faq_url; ?>"><i class="fa fa-question-circle-o"></i><span>FAQ ????????????-??????????</span></a></li>
								<li><a class="home_icon_style" href="<? echo $sms_link; ?>"><i class="fa fa-envelope-o"></i><span>SMS</span></a></li>
							</ul>
						</li>				 
						
						<li id="sale"><a class="top"><i class="fa fa-handshake-o icon_menu"></i><?php echo $text_sale; ?></a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $order; ?>"><i class="fa fa-cart-arrow-down"></i><span><?php echo $text_order; ?></span></a></li>														
								
								<li><a class="home_icon_style parent"><i class="fa fa fa-bar-chart"></i><span>????????????</span></a>
									<ul>
										<li><a href="<?php echo $report_reject; ?>"><i class="fa fa-bar-chart"></i> ?????????????? ??????????</a></li>
										<li><a href="<?php echo $report_marketplace; ?>"><i class="fa fa-bar-chart"></i> ????????????????????????</a></li>
									</ul>
								</li>
								
								<? if ($fucked_order_total > 0) { ?>
									<li><a class="home_icon_style" href="<? echo $fucked_link; ?>"><i class="fa fa-cart-plus"></i><span>?????????????????????????? ???????????? <span style="color:#cf4a61;">(<? echo $fucked_order_total; ?>)</span></span></a></li>
								<? } ?>
								<li><a class="home_icon_style" href="<? echo $callback; ?>"><i class="fa fa-phone"></i><span>???????????????? ???????????? <span style="color:#cf4a61;">(<? echo $total_callbacks; ?>)</span></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $return; ?>"><i class="fa fa-refresh"></i><span><?php echo $text_return; ?></span></a></li>
								<li><a class="home_icon_style parent"><i class="fa fa-users"></i><span><?php echo $text_customer; ?></span></a>
									<ul>
										<li><a href="<?php echo $customer; ?>"><i class="fa fa-list-ol"></i> <?php echo $text_customer; ?></a></li>
										<li><a href="<?php echo $customer_group; ?>"><i class="fa fa-newspaper-o"></i> <?php echo $text_customer_group; ?></a></li>
										<li><a href="<?php echo $segments_link; ?>"><i class="fa fa-bar-chart"></i> ?????????????????? ??????????????????????</a></li>
										<li><a href="<?php echo $actiontemplate; ?>"><i class="fa fa-envelope-o"></i> ?????????????? ???????????????????? ????????????????</a></li>
										<li><a href="<?php echo $customer_ban_ip; ?>"><i class="fa fa-refresh"></i> <?php echo $text_customer_ban_ip; ?></a></li>
									</ul>
								</li>
								<li><a class="home_icon_style" href="<?php echo $user_sip; ?>"><i class="fa fa-list-ol"></i><span>?????????????? ???????????????????? ??????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $coupon; ?>"><i class="fa fa-barcode"></i><span>??????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $addspecials; ?>"><i class="fa fa-clone"></i><span>??????????????????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $actions; ?>"><i class="fa fa-percent"></i><span>?????????????????? ??????????????????????</span></a></li>
								<li><a class="home_icon_style parent"><i class="fa fa-cc"></i><span><?php echo $text_voucher; ?></span></a>
									<ul>
										<li><a href="<?php echo $voucher; ?>"><?php echo $text_voucher; ?></a></li>
										<li><a href="<?php echo $voucher_theme; ?>"><?php echo $text_voucher_theme; ?></a></li>
									</ul>
								</li>									
								
							</ul>
						</li>
						
						<li id="buyer"><a class="top"><i class="fa fa-eur icon_menu" aria-hidden="true"></i>??????????????</a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $waitlist; ?>"><i class="fa fa-clock-o"></i><span>???????? ????????????????</span></a></li> 
								<li><a class="home_icon_style" href="<?php echo $stocks; ?>"><i class="fa fa-cubes"></i><span>?????????????????? ??????????????</span></a></li>	
								
								<li><a class="home_icon_style" href="<?php echo $yandex; ?>" style="color:#cf4a61"><i class="fa fa-yahoo"></i><span>Yandex Market</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $priceva; ?>" style="color:#7F00FF"><i class="fa fa-product-hunt"></i><span>???????????????????? ??????????????????????</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $report_buyanalyze; ?>"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i><span>?????????????????????? ?? ??????????????</span></a></li>			
								<li><a class="home_icon_style" href="<?php echo $parties; ?>"><i class="fa fa-list-ol"></i><span>???????????????????? ????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $suppliers; ?>"><i class="fa fa-list-alt"></i><span>???????????????????? ??????????????????????</span></a></li>

								<li id="opt"><a class="parent home_icon_style"><i class="fa fa-cubes"></i><span>??????</span></a>
									<ul>
										<li><a href="<?php echo $optprices; ?>">???????????????????? ????????????</a></li>       
										<li><a href="<?php echo $customer; ?>"><?php echo $text_customer; ?></a></li>
										<li><a href="<?php echo $customer_group; ?>"><?php echo $text_customer_group; ?></a></li>	   
									</ul>
								</li>																
							<?php /* ?????? ???????????????????????????? ????????????
								<li><a class="home_icon_style" href="<?php echo $buyerprices; ?>"><i class="fa fa-exchange"></i><span>???????????????? ?????? ???? ASIN / EAN</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $amazonorder; ?>"><i class="fa fa-amazon"></i><span>???????????? ?????????????????????? ???? Amazon.de</span></a></li>
							*/ ?>
							</ul>
						</li>
						
						<li id="extension"><a class="top"><i class="fa fa-clone icon_menu"></i>????????????</a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $module; ?>"><i class="fa fa-cogs"></i><span><?php echo $text_module; ?></span></a></li>
								<li><a class="parent home_icon_style"><i class="fa fa-newspaper-o"></i><span>???????????????? ????????????</span></a>
									<ul>			
										<li><a href="<?php echo $mod_latest; ?>"><i class="fa fa-check-square-o"></i><span>?????????????????? ?????????????????????? (????????)</span></a></li>
										<li><a href="<?php echo $mod_bestseller; ?>"><i class="fa fa-diamond"></i><span>???????? ???????????? (????????)</span></a></li>
										<li><a href="<?php echo $mod_special; ?>"><i class="fa fa-percent"></i><span>?????????????????? ???????????? (????????)</span></a></li>										
										<li><a href="<?php echo $mod_customproduct; ?>"><i class="fa fa-hand-pointer-o"></i><span>?????????????????????????????????????? (????????????)</span></a></li>
										
										<li><a href="<?php echo $mod_blokviewed; ?>"><i class="fa fa-eye"></i><span>???????? ?????????????????????????? (????????-????????)</span></a></li>
										<li><a href="<?php echo $mod_featured; ?>"><i class="fa fa-thumbs-up"></i><span>?????????????????????????? ???????????? (????????????)</span></a></li>
										<li><a href="<?php echo $mod_featuredreview; ?>"><i class="fa fa-comment"></i><span>?????????????????? ?? ???????????????? (????????)</span></a></li>
									</ul>										
								</li>		
								<li><a class="home_icon_style" href="<?php echo $notify_bar; ?>"><i class="fa fa-cog"></i><span>?????????????? ????????????</span></a></li>								
								<li><a class="home_icon_style" href="<?php echo $etemplate; ?>"><i class="fa fa-cog"></i><span>?????????????????? ???????????????? EMail</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $shipping; ?>"><i class="fa fa-truck"></i><span><?php echo $text_shipping; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $payment; ?>"><i class="fa fa-credit-card"></i><span><?php echo $text_payment; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $total; ?>"><i class="fa fa-plus"></i><span><?php echo $text_total; ?></span></a></li>
								<li><a class="home_icon_style" href="<?php echo $feed; ?>"><i class="fa fa-line-chart"></i><span><?php echo $text_feed; ?></span></a></li>
								<? /*
									<li><a class="home_icon_style" href="<?php echo $rewards_gen; ?>"><i class="fa fa-exchange"></i><span>?????????????????? ???????????????? ????????????</span></a></li>
									<li><a class="home_icon_style" href="<?php echo $rewards_mod; ?>"><i class="fa fa-cog"></i><span>?????????????????? ???????????????? ??????????????????</span></a></li>
								*/ ?>
								
								<li><a class="home_icon_style" href="<?php echo $invite_after_order; ?>"><i class="fa fa-bar-chart"></i><span>?????????? ?????????? ??????????????</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $affiliate; ?>"><i class="fa fa-handshake-o"></i><span>???????????????? / ??????????. ??????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $affiliate_mod_link; ?>"><i class="fa fa-cog"></i><span>?????????????????? ??????????. ??????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $subscribe; ?>"><i class="fa fa-check-square-o"></i><span><?php echo $text_subscribe; ?></span></a></li>
								
								<!--li><a href="<?php echo $recurring_profile; ?>"><?php echo $text_recurring_profile; ?></a></li-->
								<!-- PAYPAL MANAGE NAVIGATION LINK -->
								<?php if ($pp_express_status) { ?>
									<li><a class="parent home_icon_style" href="<?php echo $paypal_express; ?>"><i class="fa fa-cc-paypal"></i><span><?php echo $text_paypal_express; ?></span></a>
										<ul>
											<li><a href="<?php echo $paypal_express_search; ?>"><?php echo $text_paypal_express_search; ?></a></li>
										</ul>
									</li>
								<?php } ?>
								<!-- PAYPAL MANAGE NAVIGATION LINK END -->		
								<li><a class="home_icon_style" href="<?php echo $contact; ?>"><i class="fa fa-at"></i><span><?php echo $text_contact; ?></span></a></li>
								
								
								<li><a class="home_icon_style parent" href="<?php echo $vk_export; ?>"><i class="fa fa-vk"></i><span><?php echo $text_vk_export; ?></span></a>
									<ul>
										<li><a href="<?php echo $vk_export; ?>"><?php echo $text_vk_export; ?></a></li>
										<li><a href="<?php echo $vk_export_albums; ?>"><?php echo $text_vk_export_albums; ?></a></li>
										<li><a href="<?php echo $vk_export_setting; ?>"><?php echo $text_vk_export_setting; ?></a></li>
										<li><a href="<?php echo $vk_export_report; ?>"><?php echo $text_vk_export_cron_report; ?></a></li>
									</ul>
								</li>
								<?php if ($openbay_show_menu == 1) { ?>
									<li><a class="parent home_icon_style"><i class="fa fa-folder-open-o"></i><span><?php echo $text_openbay_extension; ?></span></a>
										<ul>
											<li><a href="<?php echo $openbay_link_extension; ?>"><?php echo $text_openbay_dashboard; ?></a></li>
											<li><a href="<?php echo $openbay_link_orders; ?>"><?php echo $text_openbay_orders; ?></a></li>
											<li><a href="<?php echo $openbay_link_items; ?>"><?php echo $text_openbay_items; ?></a></li>
											
											<?php if($openbay_markets['ebay'] == 1){ ?>
												<li><a class="parent" href="<?php echo $openbay_link_ebay; ?>"><?php echo $text_openbay_ebay; ?></a>
													<ul>
														<li><a href="<?php echo $openbay_link_ebay_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
														<li><a href="<?php echo $openbay_link_ebay_links; ?>"><?php echo $text_openbay_links; ?></a></li>
														<li><a href="<?php echo $openbay_link_ebay_orderimport; ?>"><?php echo $text_openbay_order_import; ?></a></li>
													</ul>
												</li>
											<?php } ?>
											
											<?php if($openbay_markets['amazon'] == 1){ ?>
												<li><a class="parent" href="<?php echo $openbay_link_amazon; ?>"><?php echo $text_openbay_amazon; ?></a>
													<ul>
														<li><a href="<?php echo $openbay_link_amazon_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
														<li><a href="<?php echo $openbay_link_amazon_links; ?>"><?php echo $text_openbay_links; ?></a></li>
													</ul>
												</li>
											<?php } ?>
											
											<?php if($openbay_markets['amazonus'] == 1){ ?>
												<li><a class="parent" href="<?php echo $openbay_link_amazonus; ?>"><?php echo $text_openbay_amazonus; ?></a>
													<ul>
														<li><a href="<?php echo $openbay_link_amazonus_settings; ?>"><?php echo $text_openbay_settings; ?></a></li>
														<li><a href="<?php echo $openbay_link_amazonus_links; ?>"><?php echo $text_openbay_links; ?></a></li>
													</ul>
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
							</ul>
						</li>							
						<li id="seo"><a class="top"><i class="fa fa-puzzle-piece icon_menu"></i>SEO</a>
							<ul>
								<li><a class="home_icon_style" href="<?php echo $redirect_manager; ?>"><i class="fa fa-wrench"></i><span>???????????????????? ??????????????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $seogen; ?>"><i class="fa fa-sitemap"></i><span>?????????????????? SEO</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $metaseo_anypage; ?>"><i class="fa fa-sitemap"></i><span>????????-????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $autolink_link; ?>"><i class="fa fa-font"></i><span>?????????????? ???????? ???? ????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $keyworder_link; ?>"><i class="fa fa-retweet"></i><span>???????????? ????????????./??????.</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $microdata_link; ?>"><i class="fa fa-sitemap"></i><span>Microdata v1</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $seo_snippet_link; ?>"><i class="fa fa-sitemap"></i><span>Microdata v2</span></a></li>
								<li><a class="home_icon_style" href="<?php echo HTTPS_CATALOG.'reviewgen/'; ?>"><i class="fa fa-sitemap"></i><span>?????????????????? ??????????????</span></a></li>
							</ul>
						</li>
						<li id="system"><a class="top"><i class="fa fa-cogs icon_menu"></i><?php echo $text_system; ?></a>
							<ul>
								<li><a class="home_icon_style"  href="<?php echo $panel; ?>"><i class="fa fa-server"></i><span>????????????</span></a></li>
								
								<li><a class="home_icon_style"  href="<?php echo $courier_face2; ?>" target="_blank"><i class="fa fa-bus" ></i><span>?????????????????? ??????????????</span></a></li>
								
								<li><a class="home_icon_style"  href="<?php echo $simple_module; ?>" target="_blank"><i class="fa fa-server"></i><span>????????????</span></a></li>
								<li><a class="home_icon_style"  href="<?php echo $simple_module_abandoned; ?>"><i class="fa fa-server"></i><span>?????????????????? ??????????????</span></a></li>
								
								<li><a class="home_icon_style"  href="<?php echo $ocfilter_module; ?>" target="_blank"><i class="fa fa-server"></i><span>???????????? ??????????????</span></a></li>
								
								<li><a class="home_icon_style" href="<?php echo $setting; ?>"><i class="fa fa-cog"></i><span><?php echo $text_setting; ?></span></a></li>
								<li><a class="home_icon_style" href="<? echo $adminlog_url; ?>"><i class="fa fa-user"></i><span>???????????? ??????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $error_log; ?>"><i class="fa fa-bars"></i><span>?????????????? ??????????????</span></a></li>
								<li><a class="parent home_icon_style"><i class="fa fa-file-image-o"></i><span><?php echo $text_design; ?></span></a>
									<ul>
										<li><a href="<?php echo $layout; ?>">?????????? / ????????????</a></li>
										<li><a href="<?php echo $custom_template_link; ?>">???????????????????????????? ???????????????????????????? ????????????????!</a></li>
										<li><a href="<?php echo $banner; ?>"><?php echo $text_banner; ?></a></li>
										<li><a href="<?php echo $advanced_banner_link; ?>">?????????? ??????????????</a></li>
									</ul>
								</li>
								<li><a class="parent home_icon_style"><i class="fa fa-users"></i><span><?php echo $text_users; ?></span></a>
									<ul>
										<li><a href="<?php echo $user; ?>"><?php echo $text_user; ?></a></li>
										<li><a href="<?php echo $user_group; ?>"><?php echo $text_user_group; ?></a></li>
									</ul>
								</li>
								<li><a class="home_icon_style" href="<?php echo $translator; ?>"><i class="fa fa-language"></i><span>?????????????? ???????????????? ????????????</span></a></li>
								<li><a class="parent home_icon_style"><i class="fa fa-globe"></i><span><?php echo $text_localisation; ?></span></a>
									<ul>
										<li><a href="<?php echo $language; ?>"><?php echo $text_language; ?></a></li>
										<li><a href="<?php echo $currency; ?>"><?php echo $text_currency; ?></a></li>
										<li><a href="<?php echo $stock_status; ?>"><?php echo $text_stock_status; ?></a></li>
										<li><a href="<?php echo $order_status; ?>"><?php echo $text_order_status; ?></a></li>
										<li><a href="<?php echo $return_status; ?>"><?php echo $text_return_status; ?></a></li>
										<li><a href="<?php echo $return_action; ?>"><?php echo $text_return_action; ?></a></li>
										<li><a href="<?php echo $return_reason; ?>"><?php echo $text_return_reason; ?></a></li>
										
										<li><a href="<?php echo $country; ?>"><?php echo $text_country; ?></a></li>
										<li><a href="<?php echo $legalperson; ?>">???????????? ?????? ?????????????????????? ????????????</a></li>
										<li><a href="<?php echo $zone; ?>"><?php echo $text_zone; ?></a></li>
										<li><a href="<?php echo $geo_zone; ?>"><?php echo $text_geo_zone; ?></a></li>
										<li><a class="parent"><?php echo $text_tax; ?></a>
											<ul>
												<li><a href="<?php echo $tax_class; ?>"><?php echo $text_tax_class; ?></a></li>
												<li><a href="<?php echo $tax_rate; ?>"><?php echo $text_tax_rate; ?></a></li>
											</ul>
										</li>
										<li><a href="<?php echo $length_class; ?>"><?php echo $text_length_class; ?></a></li>
										<li><a href="<?php echo $weight_class; ?>"><?php echo $text_weight_class; ?></a></li>
										
										<li><a href="<?php echo $order_bottom_forms; ?>">?????????????? ??????????????????????????</a></li>
									</ul>
									
								</li>		   									
								<li><a class="home_icon_style" href="<?php echo $vqmod_manager; ?>"><i class="fa fa-pencil-square-o"></i><span><?php echo $text_vqmod_manager; ?></span></a></li>							
								<li><a class="home_icon_style" href="<?php echo $backup; ?>"><i class="fa fa-tasks"></i><span>???????????????? ??????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $csvpricelink; ?>"><i class="fa fa-cubes"></i><span>CSV IMPORT/EXPORT</span></a></li>								
								<li><a class="parent home_icon_style"><i class="fa fa-window-close"></i><span>???????????????????????????? ??????????????</span></a>
									<ul>
										<li><a href="<?php echo $geoip_link; ?>">?????????????????? GeoIP</a></li>
										<li><a href="<?php echo $profile; ?>"><?php echo $text_profile; ?></a></li>
										<li><a class="home_icon_style parent"><i class="fa fa-spinner"></i><span>??????????????????</span></a>
											<ul>
												<li><a href="<?php echo $masspcategupd; ?>">??????????????????</a></li>
												<li><a href="<?php echo $masspdiscoupd; ?>">????????????</a></li>
											</ul>
										</li>
									</ul>
								</li>
							</ul>
						</li>							   
						<li id="reports"><a class="top"><i class="fa fa-area-chart icon_menu"></i><?php echo $text_reports; ?></a>
							<ul>		
								<li><a class="home_icon_style" href="<?php echo $report_product_viewed; ?>"><i class="fa fa-eye"></i><span>?????????? ????????????????????</span></a></li>
							<? /* ?>
									<li><a class="home_icon_style" href="<?php echo $mreport_ttnscan ?>"><i class="fa fa-area-chart"></i><span>?????????? ???? ??????</span></a></li>
									<li><a class="home_icon_style" href="<?php echo $mreport_needtocall ?>"><i class="fa fa-spinner"></i><span>???????????? ?? ???????????????? ????????????</span></a></li>
									<li><a class="home_icon_style" href="<?php echo $mreport_nopaid ?>"><i class="fa fa-spinner"></i><span>???????????? ?? ???????????????? ????????????</span></a></li>
									<li><a class="home_icon_style" href="<?php echo $mreport_forgottencart ?>"><i class="fa fa-pencil-square-o"></i><span>?????????????????????????? ????????????</span></a></li>
								<?	*/ ?>
								<li><a class="home_icon_style" href="<?php echo $mreport_minusscan ?>"><i class="fa fa-exclamation"></i><span>???????????????? ????????????</span></a></li>
								<li><a class="home_icon_style" href="<?php echo $cdek_integrator ?>"><i class="fa fa-truck"></i><span>???????? ????????????????????</span></a></li>
								<li><a class="parent home_icon_style"><i class="fa fa-database"></i><span><?php echo $text_sale; ?></span></a>
									<ul>											
										<li><a href="<?php echo $report_adv_sale_order ?>">?????????????????????????? ??????????</a></li>
										<li><a href="<?php echo $report_adv_product_purchased; ?>">?????????????????????????? ?????????? ???? ??????????????</a></li> 
										<li><a href="<?php echo $report_sale_order; ?>"><?php echo $text_report_sale_order; ?></a></li>
										<li><a href="<?php echo $report_sale_tax; ?>"><?php echo $text_report_sale_tax; ?></a></li>
										<li><a href="<?php echo $report_sale_shipping; ?>"><?php echo $text_report_sale_shipping; ?></a></li>
										<li><a href="<?php echo $report_sale_return; ?>"><?php echo $text_report_sale_return; ?></a></li>
										<li><a href="<?php echo $report_sale_coupon; ?>"><?php echo $text_report_sale_coupon; ?></a></li>
									</ul>
								</li>
								<li><a class="parent home_icon_style"><i class="fa fa-cubes"></i><span><?php echo $text_product; ?></span></a>
									<ul>										
										<li><a href="<?php echo $report_product_purchased; ?>"><?php echo $text_report_product_purchased; ?></a></li>
									</ul>
								</li>
								<li><a class="parent home_icon_style"><i class="fa fa-users"></i><span><?php echo $text_customer; ?></span></a>
									<ul>
										<li><a href="<?php echo $report_customer_online; ?>"><?php echo $text_report_customer_online; ?></a></li>
										<li><a href="<?php echo $report_customer_order; ?>"><?php echo $text_report_customer_order; ?></a></li>
										<li><a href="<?php echo $report_customer_reward; ?>"><?php echo $text_report_customer_reward; ?></a></li>
										<li><a href="<?php echo $report_customer_credit; ?>"><?php echo $text_report_customer_credit; ?></a></li>
									</ul>
								</li>
								<li><a class="parent home_icon_style"><i class="fa fa-handshake-o"></i><span><?php echo $text_affiliate; ?></span></a>
									<ul>
										<li><a href="<?php echo $report_affiliate_commission; ?>"><?php echo $text_report_affiliate_commission; ?></a></li>
										<li><a href="<?php echo $report_affiliate_statistics; ?>"><?php echo $text_report_affiliate_statistics; ?></a></li>
										<li><a href="<?php echo $report_affiliate_statistics_all; ?>"><?php echo $text_report_affiliate_statistics_all; ?></a></li>
									</ul>
								</li>
							</ul>
						</li>
						<li id="store"><a href="<?php echo $store; ?>" target="_blank" class="top"><i class="fa fa-share icon_menu"></i><?php echo $text_front; ?></a>
							<ul>
								<?php foreach ($stores as $stores) { ?>
									<li><a href="<?php echo $stores['href']; ?>" target="_blank"><?php echo $stores['name']; ?></a></li>
								<?php } ?>
							</ul>
						</li>
						<li></li>
						
					</ul>
					<style>
						#menu > ul li ul{
						display:none;
						}
						
						#menu > ul > li.hover > ul{
						display:block;
						}
						
						#menu > ul > li.sfhover > ul{
						display:block;
						}
						
						#menu > ul > li > ul > li > ul{
						display:none;
						}
						
						#menu > ul > li > ul > li:hover > ul{
						display:block;
						}
					</style>
					<div style="clear: both;"></div>
				</div>
			<?php } ?>
		</div>
		<div id="alert_history_preview"></div>
		<script>
			$('a#alert_history_preview_click').click(function(){
				$.ajax({
					url: 'index.php?route=user/user_alerts&token=<?php echo $token; ?>&ajax=1',
					dataType: 'html',				
					success : function(html){
						$('#alert_history_preview').html(html).dialog({width:800, height:800, modal:true,resizable:true,position:{my: 'center', at:'center center', of: window}, closeOnEscape: true, title: "?????? ??????????????????????"})				
					}
				});
				return false;
			});	
		</script>																																																													