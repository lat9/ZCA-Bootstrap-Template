<?php
/**
 * Featured Products
 * 
 * BOOTSTRAP v3.8.0
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 6912 2007-09-02 02:23:45Z drbyte $
 *
 */
// -----
// featured_products: Provide updated processing **ONLY IF** the ZCA bootstrap is the active template.
//
if (!(function_exists('zca_bootstrap_active') && zca_bootstrap_active() === true)) {
    return;
}

// -----
// Set the maximum number of products in a page's listing to that defined for
// the 'featured_products' page.
//
$product_listing_max_results = $tplSetting->MAX_DISPLAY_PRODUCTS_FEATURED_PRODUCTS;

// -----
// Nothing further to do if the featured-products' raw SQL query is present (it no longer is in zc200).
//
if (!isset($featured_products_query_raw)) {
    return;
}

// -----
// Add manufacturers_id to the query; required by the common product_listing.php module.
//
$listing_sql = str_replace('p.master_categories_id', 'p.master_categories_id, p.manufacturers_id', $featured_products_query_raw);

$define_list = [
    'PRODUCT_LIST_MODEL' => $tplSetting->PRODUCT_LIST_MODEL,
    'PRODUCT_LIST_NAME' => $tplSetting->PRODUCT_LIST_NAME,
    'PRODUCT_LIST_MANUFACTURER' => $tplSetting->PRODUCT_LIST_MANUFACTURER,
    'PRODUCT_LIST_PRICE' => $tplSetting->PRODUCT_LIST_PRICE,
    'PRODUCT_LIST_QUANTITY' => $tplSetting->PRODUCT_LIST_QUANTITY,
    'PRODUCT_LIST_WEIGHT' => $tplSetting->PRODUCT_LIST_WEIGHT,
    'PRODUCT_LIST_IMAGE' => $tplSetting->PRODUCT_LIST_IMAGE,
];

asort($define_list);
$column_list = [];
foreach ($define_list as $key => $value) {
    if ((int)$value > 0) {
        $column_list[] = $key;
    }
}
