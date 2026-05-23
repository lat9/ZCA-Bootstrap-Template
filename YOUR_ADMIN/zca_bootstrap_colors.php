<?php
/**
 * @package admin
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Fri Feb 26 00:25:51 2016 -0500 Modified in v1.5.5 $
 *
 * BOOTSTRAP v3.8.0
 */
require 'includes/application_top.php';

$sqlGroup =
    "SELECT configuration_group_id
       FROM " . TABLE_CONFIGURATION_GROUP . "
      WHERE configuration_group_title = 'ZCA Bootstrap Colors'";
$groupID = $db->Execute($sqlGroup, 1);
// Without a valid config group present, it means the ZCA Bootstrap module isn't installed/configured yet/anymore.
if ($groupID->EOF) {
    $messageStack->add_session(MISSING_CONFIGURATION, 'error');
    zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

$gID = $groupID->fields['configuration_group_id'];
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'uploadcsv':
        $color_list = [];
        $fail_count = 0;
        $line_count = 0;
        if (!empty($_FILES['csv_file']['tmp_name'])) {
            $filename = $_FILES['csv_file']['tmp_name'];
            if (($handle = fopen($filename, 'r')) !== false) {
                $import_issues_logfile = DIR_FS_LOGS . '/zca_bootstrap_colors_' . date('Ymd_His') . '.log';
                while (($data = fgetcsv($handle, 1000, ',', '"', '')) !== false) {
                    $line_count++;
                    if (count($data) < 2) {
                        error_log('Insufficient columns in line ' . $line_count . "\n", 3, $import_issues_logfile);
                        $fail_count++;
                        continue;
                    }
                    if ($line_count === 1 && ($data[0] !== CSV_HEADER_KEY || $data[1] !== CSV_HEADER_VALUE)) {
                        error_log('Incorrect column headers in line ' . $line_count . "\n", 3, $import_issues_logfile);
                        $fail_count++;
                        continue;
                    }
                    $color_list[] = [
                        'configuration_key' => $data[0],
                        'configuration_value' => $data[1],
                    ];
                }
                fclose($handle);
            }
        }

        if ($fail_count !== 0) {
            $messageStack->add_session(CSV_FILE_MALFORMED, 'error');
        } elseif ($color_list === []) {
            $messageStack->add_session(NO_CSV_FILE, 'error');
        } else {
            $success_count = 0;
            $line_count = 0;
            foreach ($color_list as $color) {
                $line_count++;
                if ($line_count === 1) {           // ignore header line
                    continue;
                }
                $configuration_key = zen_db_input($color['configuration_key']);
                $configuration_value = zen_db_input($color['configuration_value']);

                $db->Execute(
                    "UPDATE " . TABLE_CONFIGURATION . "
                        SET configuration_value = '$configuration_value',
                            last_modified = now()
                      WHERE configuration_group_id = $gID
                        AND configuration_key = '$configuration_key'
                      LIMIT 1"
                );
                if ($db->affectedRows() === 1) {
                    $success_count++;
                } else {
                    error_log("Error in line $line_count - no matching key $configuration_key\n", 3, $import_issues_logfile);
                    $fail_count++;
                }
            }
            if ($fail_count === 0) {
                $messageStack->add_session(sprintf(UPLOAD_FILE_PROCESSED_ALL_OK, $success_count), 'success');
            } else {
                $messageStack->add_session(sprintf(UPLOAD_FILE_PROCESSED_SOME_OK, $success_count, $success_count + $fail_count), 'caution');
            }
        }
        zen_redirect(zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS));
        break;

    case 'downloadcsv':
        $filename = 'zca_bootstrap_colors_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $out = fopen('php://output', 'w');
        fputcsv($out, [CSV_HEADER_KEY, CSV_HEADER_VALUE, CSV_HEADER_TITLE, CSV_HEADER_DEFAULT], ',', '"', '');

        $configuration = $db->Execute(
            "SELECT configuration_value, configuration_key, configuration_title, configuration_description
               FROM " . TABLE_CONFIGURATION . "
               WHERE configuration_group_id = $gID
               ORDER BY sort_order");
        foreach ($configuration as $item) {
            // -----
            // Grab the default value from the color's description, e.g. #ffffff.
            //
            preg_match('/.*(#[0-9a-fA-F]{6})\./', $item['configuration_description'], $matches);
            $default_color = $matches[1] ?? 'not found';

            fputcsv($out, [$item['configuration_key'], $item['configuration_value'], $item['configuration_title'] , $default_color], ',', '"', '');
        }

        fclose($out);
        die();
        break;

    case 'saveall':
        $colors = $_POST['colors'] ?? false;
        $original = $_POST['orig'] ?? false;
        if (!is_array($colors) || !is_array($original) || count($colors) === 0) {
            $messageStack->add_session(MESSAGE_NOTHING_CHANGED, 'warning');
            zen_redirect(zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS));
        }

        $colors_update_count = 0;
        $colors_error_count = 0;
        foreach ($colors as $cID => $color) {
            // -----
            // No change, continue on ...
            //
            if (($original[$cID] ?? -1) === $color) {
                continue;
            }
            
            // -----
            // Otherwise, the color is updated and the updated-count incremented.
            //
            $cID = (int)$cID;
            $color = zen_db_prepare_input($color);
            $db->Execute(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_value = '" . zen_db_input($color) . "',
                        last_modified = now()
                  WHERE configuration_id = $cID
                  LIMIT 1"
            );
            $colors_update_count++;
        }

        $messageStack->add_session(sprintf(SAVED_CONFIGURATION_MESSAGE, $colors_update_count, $colors_error_count), ($colors_error_count === 0) ? 'success' : 'warning');
        zen_redirect(zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS));
        break;

    default:
        break;
}
?>
<!doctype html>
<html <?= HTML_PARAMS ?>>
  <head>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>
    <style>
        .row-hover:hover {
            background-color: #f8f9fa; /* Bootstrap's .table-hover color */
        }
        .save-button {position: fixed; bottom: 4rem; right: 2rem;}
        .row-hover > div {padding: .75rem;}
        .fa .fa-square .fa-border {
            font-size: 1.35em;
            margin-right: .5em;
            background-color: #ffffff;
        }
        .fa-border {padding: 0;}
        .color-value {
            font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
            font-size: larger;
        }

        .dataTableHeadingContent {font-weight: bold;}
        .dataTableRow {border-bottom: 1px solid #c0c0c0;}

        .flex-column {flex-direction: column;}
    </style>
    <link rel="stylesheet" href="includes/css/colorpicker.css">
  </head>
  <body>
    <!-- header //-->
    <?php require DIR_WS_INCLUDES . 'header.php'; ?>
    <!-- header_eof //-->

    <!-- body //-->
    <div class="container-fluid">
        <h1><?= HEADING_TITLE ?> <small><b>(v<?= ZCA_BOOTSTRAP_COLORS_VERSION ?>)</b></small></h1>

        <div id="csv-row" class="row pt-4 bg-info">
            <div class="col-md-6">
                <?= zen_draw_form('upload_csv', FILENAME_ZCA_BOOTSTRAP_COLORS, 'action=uploadcsv', 'post', 'enctype="multipart/form-data" class="form-horizontal"') ?>
                    <div class="form-group">
                        <?= zen_draw_label(TEXT_QUERY_FILENAME, 'csv_file', 'class="control-label col-sm-3"') ?>
                        <div class="col-sm-6">
                            <?= zen_draw_file_field('csv_file', '', 'class="form-control" id="csv_file"') ?>
                        </div>
                        <div class="col-sm-2 text-right">
                            <button type="submit" class="btn btn-primary">
                                <?= BUTTON_UPLOAD_CSV ?>
                            </button>
                        </div>
                    </div>
                <?= '</form>' ?>
            </div>

            <div class="col-md-6">
                <a class="btn btn-primary" role="button" href="<?= zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'action=downloadcsv', 'SSL') ?>">
                    <?= BUTTON_DOWNLOAD_CSV ?>
                </a>
            </div>
        </div>

        <p class="pt-2"><b><?= TEXT_NOTES ?></b></p>
        <ul><?= TEXT_NOTE_LIST ?></ul>
<?php
$filter_types = [
    ['id' => 'color', 'text' => TEXT_FILTER_COLOR_VALUE],
    ['id' => 'title', 'text' => TEXT_FILTER_TITLE_CONTAINS],
];
?>
        <div id="filter-row" class="row pt-4 bg-info">
            <div class="col-md-6">
                <form class="form-horizontal" action="javascript:void(0);" method="get">
                    <div class="form-group">
                        <label for="filter-type" class="col-sm-2 control-label"><?= TEXT_LABEL_FILTER_BY ?></label>
                        <div class="col-sm-4">
                            <?= zen_draw_pull_down_menu('filter_type', $filter_types, 'color', 'id="filter-type" class="form-control"') ?>
                        </div>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input id="filter-val" class="form-control" placeholder="Display only this color">
                                <span class="input-group-btn">
                                    <button id="go-cf" type="submit" class="btn btn-info"><?= BUTTON_GO ?></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <?= zen_draw_form('configuration', FILENAME_ZCA_BOOTSTRAP_COLORS, 'action=saveall', 'post', 'class="form-horizontal"') ?>
        <div class="row dataTableHeadingRow py-3">
            <div class="col-sm-4 dataTableHeadingContent"><?= TABLE_HEADING_CONFIGURATION_TITLE ?></div>
            <div class="col-sm-6 dataTableHeadingContent text-center"><?= TABLE_HEADING_CONFIGURATION_VALUE ?></div>
            <div class="col-sm-2 dataTableHeadingContent text-center"><?= TABLE_HEADING_DATES ?></div>
        </div>
<?php
$configuration = $db->Execute(
    "SELECT configuration_id, configuration_title, configuration_value, configuration_key, configuration_description, date_added, last_modified
       FROM " . TABLE_CONFIGURATION . "
      WHERE configuration_group_id = " . $gID . "
      ORDER BY sort_order"
);
foreach ($configuration as $item) {
    // -----
    // Any setting containing a <b> in its title indicates the start of a grouping; these have a different
    // background color for the row.
    //
    $is_grouping_row = (strpos($item['configuration_title'], '<b>') !== false);

    $row_class = /* ($is_grouping_row === true) ? 'bg-info' : */ 'dataTableRow';
    $cID = $item['configuration_id'];

    // -----
    // The configured value for any color-setting *added* on an upgrade is set to 'not-set', giving
    // the site to provide coloring that matches their theme.
    //
    $cfgValue = htmlspecialchars($item['configuration_value'], ENT_COMPAT, CHARSET, true);
    $cfgValueColor = empty($cfgValue) ? '#000000' : $cfgValue;

    // -----
    // Determine whether the associated setting was added during v3.5.2 or later.  If so, its value can be set to "not-set"
    // with no unwanted effect on the storefront; otherwise, not so!
    //
    $not_set_ok = str_contains($item['configuration_description'], 'Added');

    // -----
    // Determine the color's default value from its description.  The admin's color-install script has formatted the
    // description as 'Default: {default_color}.[ Added in v{version}.]', so the default color is found by first
    // stripping 'Default: ' and then grabbing everything left up to the '.' that follows the {default_color}
    // specification.
    //
    $cfg_default_color = strstr(str_replace('Default: ', '', $item['configuration_description']), '.', true);
?>
        <div class="row <?= $row_class ?> row-hover align-items-center py-2">
            <div class="col-sm-4 bc-title">
                <?= $item['configuration_title'] ?>
<?php
    if (!empty(zen_config('ADMIN_CONFIGURATION_KEY_ON'))) {
?>
                <p class="p-1"><small class="text-muted">Key: <?= $item['configuration_key'] ?></small></p>
<?php
    }
?>
            </div>

            <div class="col-sm-6 color-value">
                <div class="col-md-4">
<?php
    $disabled = '';
    if ($not_set_ok === true && $cfgValueColor === 'not-set') {
        $disabled = 'disabled';
        $choose_id = "choose-$cID";
?>
                    <?= zen_draw_label(TEXT_LABEL_NOT_SET_USE_DEFAULT, $choose_id, 'class="control-label"') ?>
                    <?= zen_draw_checkbox_field('choose', '', false, '', 'id="' . $choose_id . '" class="color-choose" data-cid="' . $cID . '" data-default="' . $cfg_default_color . '"') ?>
<?php
    }
?>
                </div>
                <div class="col-md-4 text-center">
                    <?= zen_draw_input_field("colors[$cID]", $cfgValueColor, 'class="form-control color-val" data-cid="' . $cID . '" data-color-format="hex" size="8" ' . $disabled) ?>
                </div>
                <div class="col-md-4">
                    <div class="p-2"><small class="text-muted">
                        <?= TEXT_DEFAULT ?>
                        <i class="fa fa-square fa-border" aria-hidden="true" style="color: <?= $cfg_default_color ?>;"></i>
                        <?= $cfg_default_color ?>
                    </small></div>
                    <div class="px-2"><small class="text-muted">
                        <?= TEXT_ORIGINAL ?>
<?php
    if ($cfgValueColor === 'not-set') {
        echo 'not-set';
    } else {
?>
                        <i class="fa fa-square fa-border" aria-hidden="true" style="color: <?= $cfg_default_color ?>;"></i>
                        <?= $cfg_default_color ?>
<?php
    }
?>
                    </small></div>
                    <?= zen_draw_hidden_field("orig[$cID]", $cfgValueColor) ?>
                </div>
            </div>
            <div class="col-sm-2 text-center">
                <?= zen_date_short($item['date_added']) . ' / ' . (!empty($item['last_modified']) ? zen_date_short($item['last_modified']) : '&mdash;') ?>
            </div>
        </div>
<?php
}
?>
        <div class="save-button d-flex flex-column">
            <button id="back-to-top" class="btn btn-primary d-none d-md-inline-block mb-1" title="<?=  BUTTON_BACK_TO_TOP_TITLE ?>" aria-label="<?=  BUTTON_BACK_TO_TOP_TITLE ?>">
                <i aria-hidden="true" class="fas fa-chevron-circle-up"></i> <?= BUTTON_BACK_TO_TOP ?>
            </button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> <?= BUTTON_SAVE_ALL ?></button>
        </div>
        <?= '</form>' ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinycolor/1.6.0/tinycolor.min.js" integrity="sha512-AvCfbOQzCVi2ctVWF4m89jLwTn/zVPJuS7rhiKyY3zqyCdbPqtvNa0I628GJqPytbowfFjkAGOpq85E5kQc40Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="includes/javascript/colorpicker.js?v380"></script>
    <script>
    $(document).ready(function(){
        $('.color-val').ColorPickerSliders({
            placement: 'bottom',
            hsvpanel: true,
            previewformat: 'hex',
            onchange: function(triggerelement, color) {
                let changedColor = $('input[name="colors['+triggerelement.data('cid')+']"]');
                if ($('input[name="orig['+triggerelement.data('cid')+']"]').val() === color.tiny.toHexString()) {
                    changedColor.next('span.changed').remove();

                } else if (changedColor.next('span.changed').length === 0) {
                    changedColor.after('<span class="changed"><small class="text-muted"><?= TEXT_CHANGED ?></small></span>');
                }
            },
        });

        $('.color-choose').on('change', function(){
            let cID = $(this).data('cid');
            $('input[name="colors['+cID+']"').after('<span class="changed"><small class="text-muted"><?= TEXT_CHANGED ?></small></span>');
            $('input[name="colors['+cID+']"')
                .attr('value', $(this).data('default'))
                .prop('disabled', false)
                .trigger('change');

            $('input[name="colors['+cID+']"').trigger('colorpickersliders.updateColor', $(this).data('default'));
            $(this).prev('label').remove();
            $(this).remove();
        });

        $('#filter-type').on('change', function(){
            $('#filter-val').val('');
            $('#go-cf').trigger('click');
        });

        $('#go-cf').on('click', function(e){
            if ($('#filter-val').val().length === 0) {
                if ($('#filter-type').val() === 'color') {
                    $('#filter-val').attr('placeholder', '<?= TEXT_PLACEHOLDER_CHOOSE_COLOR ?>');
                } else {
                    $('#filter-val').attr('placeholder', '<?= TEXT_PLACEHOLDER_CHOOSE_TITLE ?>');
                }
                $('div.row-hover').show();
            } else if ($('#filter-type').val() === 'color') {
                $('input.color-val').each(function(){
                    if ($(this).attr('value') !== $('#filter-val').val()) {
                        $(this).closest('div.row-hover').hide();
                    }
                });
            } else {
                $('div.bc-title').each(function(){
                    if ($(this).text().indexOf($('#filter-val').val()) === -1) {
                        $(this).closest('div.row-hover').hide();
                    }
                });
            }
        });

        if ($('#back-to-top').length) {
            var scrollTrigger = 100, // px
            backToTop = function () {
                var scrollTop = $(window).scrollTop();
                if (scrollTop > scrollTrigger) {
                    $('#back-to-top').addClass('show');
                } else {
                    $('#back-to-top').removeClass('show');
                }
            };
            backToTop();
            $(window).on('scroll', function () {
                backToTop();
            });
            $('#back-to-top').on('click', function (e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        }
    });
    </script>
    <!-- footer //-->
    <?php require DIR_WS_INCLUDES . 'footer.php'; ?>
    <!-- footer_eof //-->
    <br>
  </body>
</html>
<?php require DIR_WS_INCLUDES . 'application_bottom.php'; ?>
