<?php
/**
 * Common Template - tpl_columnar_display.php
 *
 * BOOTSTRAP v3.6.4
 *
 * This file is used for generating columnar output where needed, based on the supplied array of table-cell contents.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Dec 27  For v1.5.7 $
 */
$title = $title ?? '';
$zco_notifier->notify('NOTIFY_TPL_COLUMNAR_DISPLAY_START', $current_page_base, $list_box_contents, $title);

$card_main_id = $card_main_id ?? '';
if ($card_main_id !== '') {
    $card_main_id = ' id="' . trim($card_main_id) . '"';
}
$card_main_class = $card_main_class ?? '';
if ($card_main_class !== '') {
    $card_main_class = ' ' . trim($card_main_class);
}
$card_body_id = $card_body_id ?? '';
if ($card_body_id !== '') {
    $card_body_id = ' id="' . $card_body_id . '"';
}
?>
<div class="card mb-3<?= $card_main_class ?>"<?= $card_main_id ?>>
<?php
echo $title;
?>
    <div class="card-body text-center"<?= $card_body_id ?>>
<?php
if (is_array($list_box_contents)) {
    foreach ($list_box_contents as $row => $cols) {
        $r_params = $list_box_contents[$row]['params'] ?? 'class="card-deck text-center"';
?>
        <div <?= $r_params ?>>
<?php
        foreach ($cols as $col) {
            if ($cols === 'params') {
                continue; // a $cols index named 'params' is only display-instructions ($r_params above) for the row, no data, so skip this iteration
            }

            if (!empty($col['wrap_with_classes'])) {
?>
            <div class="<?= $col['wrap_with_classes'] ?>">
<?php
            }

            $c_params = '';
            if (isset($col['params'])) {
                $c_params .= ' ' . (string)$col['params'];
            }
            if (isset($col['text'])) {
?>
                <div<?= $c_params ?>><?= $col['text'] ?></div>
<?php
            }

            if (!empty($col['wrap_with_classes'])) {
?>
            </div>
<?php
            }
        }
?>
        </div>
<?php
    }
}
?>
    </div>
</div>
<?php
$zco_notifier->notify('NOTIFY_TPL_COLUMNAR_DISPLAY_END', $current_page_base, $list_box_contents, $title);
