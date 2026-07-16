<?php
/**
 * Module Template
 * 
 * BOOTSTRAP v3.6.4
 *
 * Displays content related to "also-purchased-products"
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_also_purchased_products.php 3206 2006-03-19 04:04:09Z birdbrain $
 */
$zc_show_also_purchased = false;
require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_ALSO_PURCHASED_PRODUCTS);

if ($zc_show_also_purchased === false) {
    return;
}

$card_main_id = 'also-purchased';
$card_main_class = 'centerBoxWrapper';
$card_body_id = 'also-purchased-card-body';

require $template->get_template_dir('tpl_columnar_display.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_columnar_display.php';
