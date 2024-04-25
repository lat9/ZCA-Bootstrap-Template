<?php
/**
 * Side Box Template
 *
 * BOOTSTRAP v3.7.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Drbyte Sun Jan 7 21:28:50 2018 -0500 Modified in v1.5.6 $
 */
$includeAllCategories = $zca_include_zero_product_categories ?? false;

$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="list-group-flush sideBoxContent">';
for ($i = 0, $j = count($box_categories_array); $i < $j; $i++) {
    // -----
    // If 0-product categories are not to be displayed (see /extra_datafiles/site-specific-bootstrap-settings.php)
    // don't include if no products.
    //
    if ($includeAllCategories === false && $box_categories_array[$i]['count'] === 0) {
        continue;
    }

    switch (true) {
// to make a specific category stand out define a new class in the stylesheet example: A.category-holiday
// uncomment the select below and set the cPath=3 to the cPath= your_categories_id
// many variations of this can be done
//      case ($box_categories_array[$i]['path'] == 'cPath=3'):
//        $new_style = 'category-holiday';
//        break;
        case ($box_categories_array[$i]['top'] == 'true'):
            $new_style = 'sideboxCategory-top';
            break;
        case ($box_categories_array[$i]['has_sub_cat']):
            $new_style = 'sideboxCategory-subs';
            break;
        default:
            $new_style = 'sideboxCategory-products';
            break;
    }
    
    if ($box_categories_array[$i]['has_sub_cat']) {
        $box_categories_array[$i]['name'] .= CATEGORIES_SEPARATOR;
    }
    
    if (zen_get_product_types_to_category($box_categories_array[$i]['path']) == 3 or ($box_categories_array[$i]['top'] != 'true' and SHOW_CATEGORIES_SUBCATEGORIES_ALWAYS != 1)) {
        // skip if this is for the document box (==3)
    } else {
        $content .= '<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . $new_style . '" href="' . zen_href_link(FILENAME_DEFAULT, $box_categories_array[$i]['path']) . '">';

        if ($box_categories_array[$i]['current']) {
            if ($box_categories_array[$i]['has_sub_cat']) {
                $content .= '<span class="sideboxCategory-subs-parent">' . $box_categories_array[$i]['name'] . '</span>';
            } else {
                $content .= '<span class="sideboxCategory-subs-selected">' . $box_categories_array[$i]['name'] . '</span>';
            }
        } else {
            $content .= $box_categories_array[$i]['name'];
        }
      
        if (SHOW_COUNTS == 'true') {
            if ((CATEGORIES_COUNT_ZERO == '1' and $box_categories_array[$i]['count'] == 0) or $box_categories_array[$i]['count'] >= 1) {
                $content .= '<span class="badge badge-pill">' . CATEGORIES_COUNT_PREFIX . $box_categories_array[$i]['count'] . CATEGORIES_COUNT_SUFFIX . '</span>';
            }
        }
      
        $content .= '</a>';
    }
}

if (SHOW_CATEGORIES_BOX_SPECIALS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true' or SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true' or SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
// display a separator between categories and links
//    if (SHOW_CATEGORIES_SEPARATOR_LINK == '1') {
//      $content .= '<hr id="catBoxDivider" />' . "\n";
//    }
    if (SHOW_CATEGORIES_BOX_SPECIALS == 'true') {
        $show_this = $db->Execute("SELECT s.products_id FROM " . TABLE_SPECIALS . " s WHERE s.status= 1 LIMIT 1");
        if (!$show_this->EOF) {
            $content .= '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_SPECIALS) . '">' . CATEGORIES_BOX_HEADING_SPECIALS . '</a>';
        }
    }
    if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW == 'true') {
      // display limits
//      $display_limit = zen_get_products_new_timelimit();
        $display_limit = zen_get_new_date_range();

        $show_this = $db->Execute(
            "SELECT p.products_id
               FROM " . TABLE_PRODUCTS . " p
              WHERE p.products_status = 1 " . $display_limit . " LIMIT 1"
        );
        if (!$show_this->EOF) {
            $content .= '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_PRODUCTS_NEW) . '">' . CATEGORIES_BOX_HEADING_WHATS_NEW . '</a>';
        }
    }
    if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS == 'true') {
        $show_this = $db->Execute("SELECT products_id FROM " . TABLE_FEATURED . " WHERE status = 1 LIMIT 1");
        if (!$show_this->EOF) {
            $content .= '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a>';
        }
    }
    if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL == 'true') {
        $content .= '<a class="list-group-item list-group-item-action  list-group-item-secondary" href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a>';
    }
}
$content .= '</div>';
