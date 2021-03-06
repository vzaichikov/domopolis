<?php echo $header; ?>
<div id="content">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <div class="breadcrumb">
                    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="">
            <?php if ($error_warning) { ?>
            <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
                <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
            <?php } ?>


            <div class="box">
                <div class="heading order_head">
                    <h1><i class="fa fa-pencil"></i> <?php echo $heading_title; ?></h1>
                    <div class="buttons">
                        <a onclick="$('#form-information').submit();" class="button"><?php echo $button_save; ?></a>
                        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
                    </div>

                </div>

                <div class="content">
                <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
                    <table class="form">
                        <tbody>
                        <tr>
                            <td class="text-right">
                                <label class="control-label" for="input-moderate"><?php echo $entry_count; ?></label>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="shop_rating_horizontal_count" id="shop_rating_horizontal_count" value="<?php echo $shop_rating_horizontal_count; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <label class="control-label" for="input-moderate"><?php echo $entry_show_rating; ?></label>
                            </td>
                            <td>
                                <input type="checkbox" class="checkbox form-control" name="shop_rating_horizontal_show_rating" id="shop_rating_horizontal_show_rating" <?php if($shop_rating_horizontal_show_rating) echo 'checked'; ?>>
                            <label for="shop_rating_horizontal_show_rating"></label>
							</td>
                        </tr>
                        <tr>
                            <td class="text-right">
                                <label class="control-label" for="input-moderate"><?php echo $entry_status; ?></label>
                            </td>
                            <td>
                                <select name="shop_rating_horizontal_status" id="input-status" class="form-control">
                                    <?php if ($shop_rating_horizontal_status) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table id="module" class="list">
                        <thead>
                        <tr>
                            <td class="left"><?php echo $entry_layout; ?></td>
                            <td class="left"><?php echo $entry_position; ?></td>
                            <td class="left"><?php echo $entry_status; ?></td>
                            <td class="right"><?php echo $entry_sort_order; ?></td>
                            <td></td>
                        </tr>
                        </thead>
                        <?php $module_row = 0; ?>
                        <?php foreach ($modules as $module) { ?>
                        <tbody id="module-row<?php echo $module_row; ?>">
                        <tr>
                            <td class="left"><select name="shop_rating_horizontal_module[<?php echo $module_row; ?>][layout_id]">
                                    <?php foreach ($layouts as $layout) { ?>
                                    <?php if ($layout['layout_id'] == $module['layout_id']) { ?>
                                    <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                                    <?php } else { ?>
                                    <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                                    <?php } ?>
                                    <?php } ?>
                                </select></td>
                            <td class="left"><select name="shop_rating_horizontal_module[<?php echo $module_row; ?>][position]">
                                    <?php if ($module['position'] == 'content_top') { ?>
                                    <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
                                    <?php } else { ?>
                                    <option value="content_top"><?php echo $text_content_top; ?></option>
                                    <?php } ?>
                                    <?php if ($module['position'] == 'content_bottom') { ?>
                                    <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
                                    <?php } else { ?>
                                    <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
                                    <?php } ?>
                                    <?php if ($module['position'] == 'column_left') { ?>
                                    <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
                                    <?php } else { ?>
                                    <option value="column_left"><?php echo $text_column_left; ?></option>
                                    <?php } ?>
                                    <?php if ($module['position'] == 'column_right') { ?>
                                    <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
                                    <?php } else { ?>
                                    <option value="column_right"><?php echo $text_column_right; ?></option>
                                    <?php } ?>
                                </select></td>
                            <td class="left"><select name="shop_rating_horizontal_module[<?php echo $module_row; ?>][status]">
                                    <?php if ($module['status']) { ?>
                                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                                    <option value="0"><?php echo $text_disabled; ?></option>
                                    <?php } else { ?>
                                    <option value="1"><?php echo $text_enabled; ?></option>
                                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                                    <?php } ?>
                                </select></td>
                            <td class="right"><input type="text" name="shop_rating_horizontal_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $module['sort_order']; ?>" size="3" /></td>
                            <td class="right"><a onclick="$('#module-row<?php echo $module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
                        </tr>
                        </tbody>
                        <?php $module_row++; ?>
                        <?php } ?>
                        <tfoot>
                        <tr>
                            <td colspan="4"></td>
                            <td class="right"><a onclick="addModule();" class="button"><?php echo $button_add_module; ?></a></td>
                        </tr>
                        </tfoot>
                    </table>

                </form>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript"><!--
        var module_row = <?php echo $module_row; ?>;

        function addModule() {
            html  = '<tbody id="module-row' + module_row + '">';
            html += '  <tr>';
            html += '    <td class="left"><select name="shop_rating_horizontal_module[' + module_row + '][layout_id]">';
        <?php foreach ($layouts as $layout) { ?>
                html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
            <?php } ?>
            html += '    </select></td>';
            html += '    <td class="left"><select name="shop_rating_horizontal_module[' + module_row + '][position]">';
            html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
            html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
            html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
            html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
            html += '    </select></td>';
            html += '    <td class="left"><select name="shop_rating_horizontal_module[' + module_row + '][status]">';
            html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
            html += '      <option value="0"><?php echo $text_disabled; ?></option>';
            html += '    </select></td>';
            html += '    <td class="right"><input type="text" name="shop_rating_horizontal_module[' + module_row + '][sort_order]" value="" size="3" /></td>';
            html += '    <td class="right"><a onclick="$(\'#module-row' + module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
            html += '  </tr>';
            html += '</tbody>';

            $('#module tfoot').before(html);

            module_row++;
        }
        //--></script>

    <?php echo $footer; ?>