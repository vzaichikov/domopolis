<?php
// Heading
$_['heading_title']           = '<b>Pickup Advanced</b>';

// Text
$_['text_shipping']           = 'Shipping';
$_['text_success']            = 'Success: You have modified Pickup Advanced!';
$_['text_browse']             = 'Browse';
$_['text_clear']              = 'Clear';
$_['text_image_manager']      = 'Image Manager';
$_['text_settings']           = 'General Settings';
$_['text_points']             = 'List of pickup points';
$_['text_about_title']        = 'Information';
$_['text_about_description']  = '<tr><td style="width: 85px;"><b>Version:</b></td><td><a href="https://opencartforum.com/files/file/754-расширенный-самовывоз/" target="_blank">3.1</a></td></tr><tr><td style="width: 85px;"><b>Developer:</b></td><td><a href="https://opencartforum.com/user/19070-codeoneteam/" target="_blank">CODEONETEAM</a></td><tr><td style="width: 85px;"><b>Support:</b></td><td><a href="https://opencartforum.com/topic/15282-rasshirennyi-samovyvoz/" target="_blank">Request Support</a></td><tr>';

// Tab
$_['tab_settings']            = 'Settings';
$_['tab_points']              = 'Pickup points';
$_['tab_about']               = 'About';

// Entry
$_['entry_title']             = '<b>Title:</b>';
$_['entry_null_cost']         = '<b>Displays zero cost:</b>';
$_['entry_group_points']      = '<b>Group pickup points:</b>';
$_['entry_status']            = '<b>Status:</b>';
$_['entry_sort_order']        = '<b>Sort Order:</b>';
$_['entry_null_cost_text']    = '<b>Zero cost text:</b><br /><span class="help">Displayed when you disable the display zero cost.</span>';
$_['entry_image']             = 'Image';
$_['entry_description']       = 'Description';
$_['entry_link']              = 'Link';
$_['entry_link_text']         = 'Link text';
$_['entry_link_status']       = 'Link status';
$_['entry_cost']              = 'Cost';
$_['entry_weight']            = 'Depending on the weight of order *';
$_['entry_relation']          = 'Depending on the sum of order **';
$_['entry_percentage']        = 'In percentage on the order sum ***';
$_['entry_display_threshold'] = 'Threshold cost ****';
$_['entry_action']            = 'Action';
$_['entry_geo_zone']          = 'Geo Zone';
$_['entry_status_text']       = 'Status';
$_['entry_sort_text']         = 'Sort Order';
$_['entry_tip_text']          = '<span class="help"><h2>Help</h2>*&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;When you select this option, the cost of delivery must be specified in the format: 1000:100,10000:200, for order weight ​​from 1 to 1000 g. shipping cost will be equal to $ 100, <br />for order weight ​​from 1000 to 10000 g. shipping cost will be equal to $ 200. If the primary unit of weight in the store is a kilograms, then the dependence of delivery cost to the weight <br />must be specified in kilograms, the previous example in that case would be: 1:100,10:200.<br /><br />**&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;When you select this option, the cost of delivery must be specified in the format: 100:10,500:5, for order values ​​from 1 to 100 USD shipping cost will be equal to $ 10, <br />for order values ​​from 100 to 500 USD shipping cost will be equal to $ 5, for order over $ 500 shipping will be free.<br /><br />***&nbsp;&nbsp;&nbsp;When you select this option, the cost of delivery must be specified as a percentage of the total order, for example, in order amount equal to $ 100 in the "Cost" you specified 10, <br />the resulting shipping cost will be equal to $ 10.<br /><br />****&nbsp;Display threshold depends on the amount of the order, the range must be specified in the format: 100,1000 (minimum_limit, maximum_limit).<br /> If ordering from $ 1 to $ 100 pickup item will be hidden (the minimum limit of the display), if the amount of the order of $ 100 to $ 1000 pickup item will be available, <br /> for order over $ 1000 pickup item will be hidden again (maximum limit display). <br /> Also has a the ability to specify only the minimum or maximum limit display to indicate only the minimum limit just do not specify a maximum, <br /> for example, enter 100, and if the amount of the order of $ 1 to $ 100 pickup item will be hidden. <br />To specify only the maximum limit, enter it in the format of 0,1000 and with the amount of the order of $ 1000 pickup item will be hidden.</span>';

// Error
$_['error_permission']        = 'Warning: You do not have permission to modify Pickup Advanced!';
?>
