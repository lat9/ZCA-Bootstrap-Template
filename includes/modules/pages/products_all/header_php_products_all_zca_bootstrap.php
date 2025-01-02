<?php
/**
 * products_all  header_php.php
 * 
 * BOOTSTRAP v3.7.5
 *
 * @package page
 * @copyright Copyright 2003-2007 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 *
 */
// -----
// all_products: Provide updated processing **ONLY IF** the ZCA bootstrap is the active template.
//
if (!(function_exists('zca_bootstrap_active') && zca_bootstrap_active() === true)) {
    return;
}

// -----
// Set the maximum number of products in a page's listing to that defined for
// the 'products_all' page.
//
$product_listing_max_results = MAX_DISPLAY_PRODUCTS_ALL;

// -----
// Nothing further to do if the all-products' raw SQL query is not present (it no longer is as of zc200).
//
if (!isset($products_all_query_raw)) {
    return;
}

$listing_sql = $products_all_query_raw;

$define_list = [
    'PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
    'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
    'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
    'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
    'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
    'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
    'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE
];
asort($define_list);

$column_list = [];
foreach ($define_list as $key => $value) {
    if ((int)$value > 0) {
        $column_list[] = $key;
    }
}
