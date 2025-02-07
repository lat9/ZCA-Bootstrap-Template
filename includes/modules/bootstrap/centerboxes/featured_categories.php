<?php
/**
 * featured_categories module - prepares content for display
 *
 * BOOTSTRAP v3.7.6
 *
 * @copyright Copyright 2003-2023 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2024 May 24 Modified in v2.1.0-alpha1 $
 * based on featured_products
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// initialize vars
$categories_categories_id_list = [];
$sql = '';
$display_limit = '';

$sql =
    "SELECT c.categories_id, c.categories_image, cd.categories_name
       FROM " . TABLE_CATEGORIES . " c
            LEFT JOIN " . TABLE_FEATURED_CATEGORIES . " fc
                ON c.categories_id = fc.categories_id
            LEFT JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd
                ON c.categories_id = cd.categories_id
               AND cd.language_id = " . (int)$_SESSION['languages_id'] . "
      WHERE c.categories_status = 1
        AND fc.status = 1";
$featured_categories = $db->ExecuteRandomMulti($sql, MAX_DISPLAY_SEARCH_RESULTS_FEATURED);

$row = 0;
$col = 0;
$list_box_contents = [];
$title = '';

$num_categories_count = $featured_categories->RecordCount();

// show only when 1 or more
if ($num_categories_count > 0) {
    while (!$featured_categories->EOF) {
        $category_info = new Category((int)$featured_categories->fields['categories_id']);
        $data = $category_info->getDataForLanguage();

        $featured_cat_link = zen_href_link(FILENAME_DEFAULT, 'cPath=' .  zen_get_generated_category_path_rev($data['categories_id']));

        $featured_cat_image = '';
        if (!(empty($data['categories_image']) && PRODUCTS_IMAGE_NO_IMAGE_STATUS === '0')) {
            $featured_cat_image =
                '<a href="' . $featured_cat_link . '" title="' . zen_output_string_protected($data['categories_name']) . '">' .
                    zen_image(DIR_WS_IMAGES . (string)$data['categories_image'], $data['categories_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                '</a><br>';
        }
        $list_box_contents[$row][$col] = [
            'params' => ' class="centerBoxContentsFeaturedCategory centerBoxContents card mb-3 p-3 text-center"',
            'text' => $featured_cat_image . '<a href="' . $featured_cat_link . '">' . $data['categories_name'] . '</a><br>',
        ];

        $col++;
        if ($col > (SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS - 1)) {
            $col = 0;
            $row++;
        }
        $featured_categories->MoveNextRandom();
    }

    if (!empty($current_category_id)) {
        $category_title = zen_get_category_name((int)$current_category_id);
        $title = '<p id="featuredCategoryCenterbox-card-header" class="centerBoxHeading card-header h3">' . TABLE_HEADING_FEATURED_CATEGORIES . ($category_title !== '' ? ' - ' . $category_title : '') . '</p>';
    } else {
        $title = '<p id="featuredCategoryCenterbox-card-header" class="centerBoxHeading card-header h3">' . TABLE_HEADING_FEATURED_CATEGORIES . '</p>';
    }
    $zc_show_featured = true;
}
