<?php
/**
 * Module Template
 *
 * BOOTSTRAP 3.7.3
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Jul 10 Modified in v1.5.8-alpha $
 * based on tpl_modules_featured_products
 */
$zc_show_featured = false;
require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_FEATURED_CATEGORIES_MODULE);

if ($zc_show_featured === false) {
    return;
}

$card_main_id = 'featuredCategories';
$card_main_class = 'centerBoxWrapper';
$card_body_id = 'featuredCategoryCenterbox-card-body';

/**
 * require the list_box_content template to display the category
 */
require $template->get_template_dir('tpl_columnar_display.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_columnar_display.php';
