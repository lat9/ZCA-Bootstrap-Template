<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.7.0
 *
 * Provides the default display for a product's info-page details list.  A product-type,
 * e.g. product_music_info, can provide customized display of these details
 * by including a module named `tpl_{product_type}_display_details.php.  For
 * product_music_info, this file is named tpl_product_music_info_display_details.php.
 */
$display_product_model = ($flag_show_product_info_model === '1' && $products_model !== '');
$display_product_weight = ($flag_show_product_info_weight === '1' && $products_weight != 0);
$display_product_quantity = ($flag_show_product_info_quantity === '1');
$display_product_manufacturer = ($flag_show_product_info_manufacturer === '1' && !empty($manufacturers_name));
if ($display_product_model || $display_product_weight || $display_product_quantity || $display_product_manufacturer) {
?>
            <ul id="<?= $html_id_prefix ?>-productDetailsList" class="productDetailsList list-group mb-3">
                <?= (($display_product_model === true) ? '<li class="list-group-item">' . TEXT_PRODUCT_MODEL . $products_model . '</li>' : '') . "\n" ?>
                <?= (($display_product_weight === true) ? '<li class="list-group-item">' . TEXT_PRODUCT_WEIGHT .  $products_weight . TEXT_PRODUCT_WEIGHT_UNIT . '</li>'  : '') . "\n" ?>
                <?= (($display_product_quantity === true) ? '<li class="list-group-item">' . $products_quantity . TEXT_PRODUCT_QUANTITY . '</li>'  : '') . "\n" ?>
                <?= (($display_product_manufacturer === true) ? '<li class="list-group-item">' . TEXT_PRODUCT_MANUFACTURER . $manufacturers_name . '</li>' : '') . "\n" ?>
            </ul>
<?php
}
