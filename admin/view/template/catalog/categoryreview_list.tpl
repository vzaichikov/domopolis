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
      <h1><img src="view/image/review.png" alt="" /> <?php echo $heading_title; ?></h1>
       <div class="buttons"><a onclick="$('#form').attr('action', '<?php echo $enabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_enable; ?></span></a><a onclick="$('#form').attr('action', '<?php echo $disabled; ?>'); $('#form').submit();" class="button"><span><?php echo $button_disable; ?></span></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td width="1" style="text-align: center;"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="left"><?php if ($sort == 'cd.name') { ?>
                <a href="<?php echo $sort_category; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_category; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_category; ?>"><?php echo $column_category; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'cr.author') { ?>
                <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>
                <?php } ?></td>
              <td class="right"><?php if ($sort == 'cr.rating') { ?>
                <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'cr.status') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'cr.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <?php if ($categoryreviews) { ?>
            <?php foreach ($categoryreviews as $categoryreview) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($categoryreview['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $categoryreview['categoryreview_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $categoryreview['categoryreview_id']; ?>" />
                <?php } ?></td>
              <td class="left"><?php echo $categoryreview['name']; ?></td>
              <td class="left"><?php echo $categoryreview['author']; ?></td>
              <td class="right"><?php echo $categoryreview['rating']; ?></td>
              <td class="left"><?php echo $categoryreview['status']; ?></td>
              <td class="left"><?php echo $categoryreview['date_added']; ?></td>
              <td class="right"><?php foreach ($categoryreview['action'] as $action) { ?>
                <a class="button" href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a>
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="7"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
	<div class="bottom">	
  </div>
</div>
<?php echo $footer; ?>