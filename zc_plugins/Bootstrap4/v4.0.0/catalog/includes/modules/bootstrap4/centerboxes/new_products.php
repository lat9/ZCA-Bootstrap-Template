<?php
/**
 * new_products.php module
 * 
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2022 May 05 Modified in v1.5.8-alpha $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// initialize vars
$categories_products_id_list = [];
$list_of_products = '';
$new_products_query = '';

$display_limit = zen_get_new_date_range();

if ((($manufacturers_id > 0 && empty($_GET['filter_id'])) || !empty($_GET['music_genre_id']) || !empty($_GET['record_company_id'])) || empty($new_products_category_id)) {
    $new_products_query =
        "SELECT DISTINCT p.products_id, p.products_image, pd.products_name, p.products_price, p.master_categories_id
           FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
          WHERE p.products_id = pd.products_id
            AND pd.language_id = " . (int)$_SESSION['languages_id'] . "
            AND p.products_status = 1 " . $display_limit;
} else {
    // get all products and cPaths in this subcat tree
    $productsInCategory = zen_get_categories_products_list((($manufacturers_id > 0 && !empty($_GET['filter_id'])) ? zen_get_generated_category_path_rev($_GET['filter_id']) : $cPath), false, true, 0, $display_limit);

    if (is_array($productsInCategory) && count($productsInCategory) > 0) {
        // build products-list string to insert into SQL query
        $list_of_products = implode(',', array_keys($productsInCategory));
        $new_products_query =
            "SELECT DISTINCT p.products_id, p.products_image, pd.products_name, p.products_price, p.master_categories_id
               FROM " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd
              WHERE p.products_id = pd.products_id
                AND pd.language_id = " . (int)$_SESSION['languages_id'] . "
                AND p.products_status = 1
                AND p.products_id IN (" . $list_of_products . ")";
    }
}

$num_products_count = 0;
if ($new_products_query !== '') {
    $new_products = $db->ExecuteRandomMulti($new_products_query, zen_config('MAX_DISPLAY_NEW_PRODUCTS'));
    $num_products_count = $new_products->RecordCount();
}

$row = 0;
$col = 0;
$list_box_contents = [];
$title = '';

// show only when 1 or more
if ($num_products_count > 0) {
    $new_products_columns = $tplSetting->SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS;
    if ($num_products_count < $new_products_columns || $new_products_columns === '0') {
        $col_width = floor(100 / $num_products_count);
    } else {
        $col_width = floor(100 / $new_products_columns);
    }

    while (!$new_products->EOF) {
        $new_products_id = $new_products->fields['products_id'];
        if (!isset($productsInCategory[$new_products_id])) {
            $productsInCategory[$new_products_id] = zen_get_generated_category_path_rev($new_products->fields['master_categories_id']);
        }

        $products_price = zen_get_products_display_price($new_products_id);
        $new_products_link = zen_href_link(zen_get_info_page($new_products_id), 'cPath=' . $productsInCategory[$new_products_id] . '&products_id=' . $new_products_id);
        $new_products_name = $new_products->fields['products_name'];

        $new_products_image = '';
        if (!($new_products->fields['products_image'] === '' && $tplSetting->PRODUCTS_IMAGE_NO_IMAGE_STATUS === '0')) {
            $new_products_image =
                '<a href="' . $new_products_link . '" title="' . zen_output_string_protected($new_products_name) . '">' .
                    zen_image(DIR_WS_IMAGES . $new_products->fields['products_image'], $new_products_name, $tplSetting->IMAGE_PRODUCT_NEW_WIDTH, $tplSetting->IMAGE_PRODUCT_NEW_HEIGHT) .
                '</a><br>';
        }

        $zco_notifier->notify('NOTIFY_MODULES_NEW_PRODUCTS_B4_LIST_BOX', [], $new_products->fields, $products_price);

        $list_box_contents[$row][$col] = [
            'params' => ' class="centerBoxContentsNew centerBoxContents card mb-3 p-3 text-center"',
            'text' => $new_products_image . '<a href="' . $new_products_link . '">' . $new_products_name . '</a><br>' . $products_price
        ];

        $col++;
        if ($col >= $tplSetting->SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS) {
            $col = 0;
            $row++;
        }
        $new_products->MoveNextRandom();
    }

    $heading_month_name = sprintf(TABLE_HEADING_NEW_PRODUCTS, zca_get_translated_month_name());
    $category_title = '';
    if (!empty($current_category_id)) {
        $category_title = zen_get_category_name((int)$current_category_id);
        if ($category_title !== '') {
            $category_title = ' - ' . $category_title;
        }
    }
    $title = '<p id="newCenterbox-card-header" class="centerBoxHeading card-header h3">' . $heading_month_name . $category_title . '</p>';
    $zc_show_new_products = true;
}
