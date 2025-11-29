<?php
/**
 * categories_tabs.php module
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Dec 28 Modified in v1.5.8-alpha $
 *
 * Bootstrap 3.7.9
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$includeAllCategories = $zca_include_zero_product_categories ?? true;
$link_class_active = 'nav-item nav-link m-1 activeLink';
$link_class_inactive = 'nav-item nav-link m-1';
$span_wrapper_for_active = '';

// -----
// If running a ZC version >= 2.1.0, the above variables will be used
// by the base module to gather the information for the category tabs.
//
if (zen_get_zcversion() >= '2.1.0') {
    require DIR_WS_MODULES . 'categories_tabs.php';
    return;
}

// -----
// For ZC versions < 2.1.0, gather the information for the category tabs
// in this module.
//
$categories_tab_query =
    "SELECT c.sort_order, c.categories_id, cd.categories_name
       FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
      WHERE c.categories_id = cd.categories_id
        AND c.parent_id = " . (int)TOPMOST_CATEGORY_PARENT_ID . "
        AND cd.language_id = " . (int)$_SESSION['languages_id'] . "
        AND c.categories_status = 1
      ORDER BY c.sort_order, cd.categories_name";
$categories_tab = $db->Execute($categories_tab_query);

$links_list = [];
$current_category_tab = (int)$cPath;
foreach ($categories_tab as $category) {
    // currently selected category
    if ($current_category_tab === (int)$category['categories_id']) {
        $new_style = $link_class_active;
        $categories_tab_current = $category['categories_name'];
    } else {
        if (!$includeAllCategories) {
            $count = zen_products_in_category_count($category['categories_id']);
            if ($count === 0) {
                continue;
            }
        }
        $new_style = $link_class_inactive;
        $categories_tab_current = $category['categories_name'];
    }
    // create link to top level category
    $links_list[] =
        '<a class="' . $new_style . '" href="' . zen_href_link(FILENAME_DEFAULT, 'cPath=' . (int)$category['categories_id']) . '">' .
            $categories_tab_current .
        '</a> ';
}
