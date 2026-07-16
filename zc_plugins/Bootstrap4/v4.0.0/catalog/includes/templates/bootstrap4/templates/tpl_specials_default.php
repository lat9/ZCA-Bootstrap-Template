<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.6.5
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2024 Jan 31 Modified in v2.0.0-beta1 $
 */
?>
<div id="specialsDefault" class="centerColumn">
    <h1 id="specialsDefault-pageHeading" class="pageHeading">
        <?= HEADING_TITLE ?>
<?php
if (!empty($_GET['sale_category'])) {
    echo ' : ' . zen_get_category_name((int)$_GET['sale_category']);
}
?>
    </h1>
<?php
/**
 * Display the product sort dropdown, for Zen Cart versions 2.0.0 and later *only*.
 * Earlier Zen Cart versions do not recognize the display-order variable when performing
 * the page's query for the products' listing.
 */
if (PROJECT_VERSION_MAJOR > 1) {
    require $template->get_template_dir('/tpl_modules_listing_display_order.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_listing_display_order.php';
}

/**
 * require the list_box_content template to display the products
 */
require $template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_product_listing.php';
?>
</div>
