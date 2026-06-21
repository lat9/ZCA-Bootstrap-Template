<?php
/**
 * Module Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Sep 20 Modified in v1.5.7a $
 */
require DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING);

// -----
// v3.6.4 adds a configuration setting to override the "Add Selected to Cart"
// button's default positioning.  The default, if not yet configured, is 'Always'.
//
switch (zen_config('BS4_FLOAT_ADD_SELECTED', 'Always')) {
    case 'Never':
        $top_button_extra_class = '';
        $bottom_button_extra_class = '';
        break;
    case 'Small Devices Only':
        $top_button_extra_class = 'bs4-button-float sm-only';
        $bottom_button_extra_class = 'bs4-button-hide-sm';
        break;
    default:
        $top_button_extra_class = 'bs4-button-float always';
        $bottom_button_extra_class = 'd-none';
        break;
}
?>
<div id="productsListing" class="listingCenterColumn">
<?php
if ($show_top_submit_button === true) {
?>
    <div id="productsListing-btn-toolbarTop" class="btn-toolbar justify-content-end my-3" role="toolbar">
        <?= zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit1" name="submit1"', $top_button_extra_class) ?>
    </div>
<?php
} // show top submit

if ($listing_split->number_of_rows > 0 && in_array(zen_config('PREV_NEXT_BAR_LOCATION'), ['1', '3'], true)) {
?>
    <div id="productsListing-topRow" class="d-flex align-items-center justify-content-between flex-column flex-md-row">
        <div id="productsListing-topNumber" class="topNumber"><?= $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) ?></div>
        <div id="productsListing-topLinks" class="topLinks">
            <?= TEXT_RESULT_PAGE . $listing_split->display_links($max_display_page_links, zen_get_all_get_params(['page', 'info', 'x', 'y', 'main_page']), $paginateAsUL) ?>
        </div>
    </div>
<?php
}

/**
 * load the list_box_content template to display the products
 */
if (in_array($product_listing_layout_style, ['columns', 'fluid'])) {
    require $template->get_template_dir('tpl_columnar_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_columnar_display.php';
} else {
    require $template->get_template_dir('tpl_tabular_display.php',DIR_WS_TEMPLATE, $current_page_base,'common'). '/tpl_tabular_display.php';
}

if ($listing_split->number_of_rows && in_array(zen_config('PREV_NEXT_BAR_LOCATION'), ['2', '3'], true)) {
?>
    <div id="productsListing-bottomRow" class="d-flex align-items-center justify-content-between flex-column flex-md-row">
        <div id="productsListing-bottomNumber" class="bottomNumber"><?= $listing_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS) ?></div>
        <div id="productsListing-bottomLinks" class="bottomLinks">
            <?= TEXT_RESULT_PAGE . $listing_split->display_links($max_display_page_links, zen_get_all_get_params(['page', 'info', 'x', 'y']), $paginateAsUL) ?>
        </div>
    </div>
<?php
}

if ($show_bottom_submit_button == true) {
?>
    <div id="productsListing-btn-toolbarBottom" class="btn-toolbar justify-content-end my-3" role="toolbar">
        <?= zen_image_submit(BUTTON_IMAGE_ADD_PRODUCTS_TO_CART, BUTTON_ADD_PRODUCTS_TO_CART_ALT, 'id="submit2" name="submit1"', $bottom_button_extra_class) ?>
    </div>
<?php
} // show_bottom_submit_button
?>
</div>
<?php
if ($show_top_submit_button == true || $show_bottom_submit_button == true) {
    echo '</form>';
}
