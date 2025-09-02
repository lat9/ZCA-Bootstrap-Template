<?php
/**
 * @package admin
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Fri Feb 26 00:25:51 2016 -0500 Modified in v1.5.5 $
 *
 * BOOTSTRAP v3.6.2
 */
require 'includes/application_top.php';

$sqlGroup =
    "SELECT configuration_group_id
       FROM " . TABLE_CONFIGURATION_GROUP . "
      WHERE configuration_group_title = 'ZCA Bootstrap Colors'";
$groupID = $db->Execute($sqlGroup);
// Without a valid config group present, it means the ZCA Bootstrap module isn't installed/configured yet/anymore.
if ($groupID->EOF) {
    $messageStack->add_session(MISSING_CONFIGURATION, 'error');
    zen_redirect(zen_href_link(FILENAME_DEFAULT));
}

$gID = $groupID->fields['configuration_group_id'];
$action = $_GET['action'] ?? '';

switch ($action) {
    // BOF upload CSV file
    case 'uploadcsv':
        $color_list = [];
        $fail_count = 0;
        $line_count = 0;
        if (!empty($_FILES['csv_file']['tmp_name'])) {
            $filename = $_FILES['csv_file']['tmp_name'];
            if (($handle = fopen($filename, 'r')) !== false) {
                $import_issues_logfile = DIR_FS_LOGS . '/zca_bootstrap_colors_' . date('Ymd_His') . '.log';
                while (($data = fgetcsv($handle, 1000)) !== false) {
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
            $messageStack->add_session(UPLOAD_FAILED . CSV_FILE_MALFORMED, 'error');
        } elseif ($color_list === []) {
            $messageStack->add_session(UPLOAD_FAILED . NO_CSV_FILE, 'error');
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
                    error_log('Error in line ' . $line_count . ' - no matching key ' . $configuration_key . "\n", 3, $import_issues_logfile);
                    $fail_count++;
                }
            }
            if ($fail_count === 0) {
                $messageStack->add_session(UPLOAD_SUCCESS . sprintf(UPLOAD_FILE_PROCESSED_ALL_OK, $success_count), 'success');
            } else {
                $messageStack->add_session(UPLOAD_WARNING . sprintf(UPLOAD_FILE_PROCESSED_SOME_OK, $success_count, $success_count + $fail_count), 'caution');
            }
        }
        zen_redirect(zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS));
        break;
        // EOF upload SQL file

    // BOF download CSV file
    case 'downloadcsv':
        $filename = 'zca_bootstrap_colors_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $out = fopen('php://output', 'w');
        fputcsv($out, [CSV_HEADER_KEY, CSV_HEADER_VALUE, CSV_HEADER_TITLE, CSV_HEADER_DEFAULT]);

        $configuration = $db->Execute(
            "SELECT configuration_value, configuration_key, configuration_title, configuration_description
               FROM " . TABLE_CONFIGURATION . "
               WHERE configuration_group_id = $gID
               ORDER BY sort_order");
        foreach ($configuration as $item) {
            // -----
            // Grab the default value from the color's description, e.g. #000 or #ffffff.
            //
            preg_match('/.*(#[0-9a-zA-Z]{3,6})\./', $item['configuration_description'], $matches);
            $default_color = $matches[1] ?? 'not found';

            fputcsv($out, [$item['configuration_key'], $item['configuration_value'], $item['configuration_title'] , $default_color]);
        }

        fclose($out);
        die();
        break;
        // EOF download SQL file

    case 'save':
        $cID = (int)$_GET['cID'];

        $configuration_value = zen_db_prepare_input($_POST['configuration_value']);
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_value = '" . zen_db_input($configuration_value) . "',
                    last_modified = now()
              WHERE configuration_id = $cID
              LIMIT 1"
        );

        zen_redirect(zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . $cID));
        break;

    case 'edit':
        break;

    default:
        $action = '';
        break;
}
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
  <head>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>
    <style>
        .table-hover > tbody > tr.bg-primary:hover {
            color: black;
        }
        .fa fa-square fa-border {
            font-size: 1.35em;
            margin-right: .5em;
            background-color: #ffffff;
        }
        .color-value {
            font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
            font-size: larger;
        }
        .fa-border {
            padding: 0;
        }
    </style>
  </head>
  <body>
    <!-- header //-->
    <?php require DIR_WS_INCLUDES . 'header.php'; ?>
    <!-- header_eof //-->

    <!-- body //-->
    <div class="container-fluid">
        <h1><?php echo HEADING_TITLE; ?> <small><b>(v<?php echo ZCA_BOOTSTRAP_COLORS_CURRENT_VERSION; ?>)</b></small></h1>
        <p><?php echo TEXT_INFORMATION; ?></p>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 configurationColumnLeft">
                <table class="table table-hover">
                    <thead>
                        <tr class="dataTableHeadingRow">
                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_CONFIGURATION_TITLE; ?></th>
                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_CONFIGURATION_DEFAULT; ?></th>
                            <th class="dataTableHeadingContent"><?php echo TABLE_HEADING_CONFIGURATION_VALUE; ?></th>
                            <th class="dataTableHeadingContent text-center"><?php echo TABLE_HEADING_NOT_SET_OK; ?></th>
                            <th class="dataTableHeadingContent text-right"><?php echo TABLE_HEADING_ACTION; ?></th>
                        </tr>
                    </thead>
                    <tbody>
<?php
$configuration = $db->Execute(
    "SELECT configuration_id, configuration_title, configuration_value, configuration_key, configuration_description, date_added, last_modified
       FROM " . TABLE_CONFIGURATION . "
      WHERE configuration_group_id = " . $gID . "
      ORDER BY sort_order"
);

$icon_info_image = zen_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO);
foreach ($configuration as $item) {
    if ((!isset($_GET['cID']) || $_GET['cID'] === $item['configuration_id']) && !isset($cInfo)) {
        $cInfo = new objectInfo($item);
    }

    // -----
    // Any setting containing a <b> in its title indicates the start of a grouping; these have a different
    // background color for the row.
    //
    $is_grouping_row = (strpos($item['configuration_title'], '<b>') !== false);

    if ((isset($cInfo) && is_object($cInfo)) && $item['configuration_id'] === $cInfo->configuration_id) {
        $row_parameters = 'id="defaultSelected" class="' . (($is_grouping_row === true) ? 'bg-primary' : 'dataTableRowSelected') . '"';
        $cID_value = $cInfo->configuration_id;
    } else {
        $row_parameters = 'class="' . (($is_grouping_row === true) ? 'bg-info' : 'dataTableRow') . '"';
        $cID_value = $item['configuration_id'];
    }

    // -----
    // The configured value for any color-setting *added* on an upgrade is set to 'not-set', giving
    // the site to provide coloring that matches their theme.
    //
    $cfgValue = htmlspecialchars($item['configuration_value'], ENT_COMPAT, CHARSET, true);
    $cfgValueColor = $cfgValue;
    if ($cfgValue === 'not-set') {
        $cfgValue = '<span class="text-danger"><b>' . $cfgValue . '</b></span>';
    }

    // -----
    // Determine whether the associated setting was added during v3.5.2 or later.  If so, its value can be set to "not-set"
    // with no unwanted effect on the storefront; otherwise, not so!
    //
    if (strpos($item['configuration_description'], 'Added') !== false) {
        $not_ok_class = 'text-success';
        $not_ok_icon = 'fa-check';
    } else {
        $not_ok_class = 'text-danger';
        $not_ok_icon = 'fa-ban';
    }

    // -----
    // Determine the color's default value from its description.  The admin's color-install script has formatted the
    // description as 'Default: {default_color}.[ Added in v{version}.]', so the default color is found by first
    // stripping 'Default: ' and then grabbing everything left up to the '.' that follows the {default_color}
    // specification.
    //
    $cfg_default_color = strstr(str_replace('Default: ', '', $item['configuration_description']), '.', true);
?>
                        <tr <?php echo $row_parameters; ?> onclick="document.location.href = '<?php echo zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . $cID_value . '&action=edit'); ?>'">
                            <td><?php echo zen_lookup_admin_menu_language_override('configuration_key_title', $item['configuration_key'], $item['configuration_title']); ?></td>
                            <td class="color-value">
                                <i class="fa fa-square fa-border" aria-hidden="true" style="color: <?php echo $cfg_default_color; ?>;"></i>
                                <?php echo $cfg_default_color; ?>
                            </td>
                            <td class="color-value">
<?php
    if ($cfg_default_color !== $cfgValue) {
?>
                                <i class="fa fa-square fa-border" aria-hidden="true" style="color: <?php echo $cfgValueColor; ?>;"></i>
                                <?php echo $cfgValue; ?>
<?php
    }
?>
                            </td>
                            <td class="text-center">
                                <span class="<?php echo $not_ok_class; ?>"><i class="fa fa-lg <?php echo $not_ok_icon; ?>" aria-hidden="true"></i></span>
                            </td>
                            <td class="text-right">
<?php
    if ((isset($cInfo) && is_object($cInfo)) && $item['configuration_id'] === $cInfo->configuration_id) {
        echo zen_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', '');
    } else {
        echo '<a href="' . zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . $item['configuration_id']) . '" id="link_' . $item['configuration_key'] . '">' . $icon_info_image . '</a>';
    }
?>
                            </td>
                        </tr>
<?php
}
?>
                    </tbody>
                </table>
<?php
/* BOF CSV file */
if (!empty($gID)) {
?>
                <div class="row">
                    <?php echo zen_draw_form('upload_csv', FILENAME_ZCA_BOOTSTRAP_COLORS, 'action=uploadcsv', 'post', 'enctype="multipart/form-data" class="form-horizontal"'); ?>
                        <div class="form-group">
                            <?php echo zen_draw_label(TEXT_QUERY_FILENAME, 'csv_file', 'class="control-label col-sm-3"'); ?>
                            <div class="col-sm-6"><?php echo zen_draw_file_field('csv_file', '', 'class="form-control" id="csv_file"'); ?></div>
                            <div class="col-sm-3 text-right"><button type="submit" class="btn btn-primary"><?php echo BUTTON_UPLOAD_CSV; ?></button></div>
                        </div>
                    <?php echo '</form>'; ?>
                </div>
                <div class="row text-right">
                    <a class="btn btn-primary" role="button" href="<?php echo zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'action=downloadcsv', 'SSL') ?>"><?php echo BUTTON_DOWNLOAD_CSV; ?></a>
                </div>
<?php
}
/* EOF CSV file */
?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 configurationColumnRight">
<?php
$heading = [];
$contents =[];

switch ($action) {
    case 'edit':
        $heading[] = ['text' => '<h4>' . zen_lookup_admin_menu_language_override('configuration_key_title', $cInfo->configuration_key, $cInfo->configuration_title) . '</h4>'];

        $value_field = zen_draw_input_field('configuration_value', htmlspecialchars($cInfo->configuration_value, ENT_COMPAT, CHARSET, true), 'size="60" class="cfgInput form-control col-md-3" id="full-popover" data-color-format="hex"');

        $contents = ['form' => zen_draw_form('configuration', FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . (int)$cInfo->configuration_id . '&action=save')];
        if (ADMIN_CONFIGURATION_KEY_ON === '1') {
            $contents[] = ['text' => '<strong>Key: ' . $cInfo->configuration_key . '</strong><br>'];
        }
        $contents[] = ['text' => TEXT_INFO_EDIT_INTRO];
        $contents[] = ['text' => '<strong>' . zen_lookup_admin_menu_language_override('configuration_key_title', $cInfo->configuration_key, $cInfo->configuration_title) . '</strong><br>' . zen_lookup_admin_menu_language_override('configuration_key_description', $cInfo->configuration_key, $cInfo->configuration_description) . '<br>' . $value_field];
        $contents[] = [
            'align' => 'center',
            'text' =>
                '<button type="submit" class="btn btn-primary" name="submit' . $cInfo->configuration_key . '">' . IMAGE_UPDATE . '</button>&nbsp;' .
                '<a href="' . zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . $cInfo->configuration_id) . '" class="btn btn-default" role="button">' . IMAGE_CANCEL . '</a>'
        ];
        break;

    default:
        if (isset($cInfo) && is_object($cInfo)) {
            $heading[] = ['text' => '<h4>' . zen_lookup_admin_menu_language_override('configuration_key_title', $cInfo->configuration_key, $cInfo->configuration_title) . '</h4>'];
            if (ADMIN_CONFIGURATION_KEY_ON == 1) {
                $contents[] = ['text' => '<strong>Key: ' . $cInfo->configuration_key . '</strong><br>'];
            }

            $contents[] = [
                'align' => 'center',
                'text' => '<a href="' . zen_href_link(FILENAME_ZCA_BOOTSTRAP_COLORS, 'cID=' . $cInfo->configuration_id . '&action=edit') . '" class="btn btn-primary">' . IMAGE_EDIT . '</a>'
            ];
            $contents[] = ['text' => zen_lookup_admin_menu_language_override('configuration_key_description', $cInfo->configuration_key, $cInfo->configuration_description)];
            $contents[] = ['text' => TEXT_INFO_DATE_ADDED . ' ' . zen_date_short($cInfo->date_added)];
            if (!empty($cInfo->last_modified)) {
                $contents[] = ['text' => TEXT_INFO_LAST_MODIFIED . ' ' . zen_date_short($cInfo->last_modified)];
            }
        }
        break;
}

if (!empty($heading) && !empty($contents)) {
    $box = new box();
    echo $box->infoBox($heading, $contents);
}
?>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="includes/css/colorpicker.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinycolor/0.11.1/tinycolor.min.js"></script>
    <script src="includes/javascript/colorpicker.js"></script>

    <script>
      $(document).ready(function () {
        $("input#full-popover").ColorPickerSliders({
          placement: 'bottom',
          hsvpanel: true,
          previewformat: 'hex'
        });
      });
    </script>
    <!-- body_eof //-->

    <!-- footer //-->
    <?php require DIR_WS_INCLUDES . 'footer.php'; ?>
    <!-- footer_eof //-->
    <br>
  </body>
</html>
<?php require DIR_WS_INCLUDES . 'application_bottom.php'; ?>
