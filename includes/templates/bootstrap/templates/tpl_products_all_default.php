<?php
/**
 * Page Template
 * 
 * BOOTSTRAP 3.7.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Sat Jan 9 13:13:41 2016 -0500 Modified in v1.5.5 $
 */
?>
<div id="productsAllDefault" class="centerColumn">
    <h1 id="productsAllDefault-pageHeading" class="pageHeading"><?php echo HEADING_TITLE; ?></h1>
    <div class="row">
<?php
if (PRODUCT_LIST_ALPHA_SORTER === 'true') {
?>
        <div class="col">
<?php
    echo zen_draw_form('filter', zen_href_link(FILENAME_SEARCH_RESULT), 'get', 'class="form-inline"');
    echo '<label class="inputLabel mx-2">' . TEXT_SHOW . '</label>';

    /* Redisplay all $_GET variables, except currency */
    echo zen_post_all_get_params('currency');

    require DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING_ALPHA_SORTER);

    echo '</form>';
?>
        </div>
<?php
}
?>
        <div class="col">
<?php
require $template->get_template_dir('/tpl_modules_listing_display_order.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_listing_display_order.php';
?>
        </div>
    </div>
<?php
require $template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_product_listing.php';
?>
</div>
