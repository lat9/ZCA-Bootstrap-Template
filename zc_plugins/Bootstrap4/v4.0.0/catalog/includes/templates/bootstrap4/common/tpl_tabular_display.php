<?php
/**
 * Common Template - tpl_tabular_display.php
 *
 * BOOTSTRAP v3.1.0
 *
 * This file is used for generating tabular output where needed, based on the supplied array of table-cell contents.
 *
 * @package templateSystem
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Drbyte Sun Jan 7 21:28:50 2018 -0500 Modified in v1.5.6 $
 */
$zco_notifier->notify('NOTIFY_TPL_TABULAR_DISPLAY_START', $current_page_base, $list_box_contents);

$cell_scope = (empty($cell_scope)) ? 'col' : $cell_scope;
$cell_title = (empty($cell_title)) ? 'list' : $cell_title;
?>
<table id="<?php echo 'cat' . $cPath . 'Table'; ?>" class="tabTable table-bordered table-striped table-hover">
<?php
foreach ($list_box_contents as $row => $cols) {
    $r_params = '';
    if (isset($list_box_contents[$row]['params'])) {
        $r_params .= ' ' . $list_box_contents[$row]['params'];
    }
?>
    <tr<?php echo $r_params; ?>>
<?php
    foreach ($cols as $col) {
        $c_params = '';
        $cell_type = ($row == 0) ? 'th' : 'td';
        if (isset($col['params'])) {
            $c_params .= ' ' . $col['params'];
        }
        if (!empty($col['align'])) {
            $c_params .= ' align="' . $col['align'] . '"';
        }

        if ($cell_type == 'th') {
            $c_params .= ' scope="' . $cell_scope . '"';
        }
        if (isset($col['text'])) {
            echo '<' . $cell_type . $c_params . '>' . $col['text'] . '</' . $cell_type . '>'  . "\n";
        }
    }
?>
    </tr>
<?php
}
?>
</table>
<?php
$zco_notifier->notify('NOTIFY_TPL_TABULAR_DISPLAY_END', $current_page_base, $list_box_contents);

