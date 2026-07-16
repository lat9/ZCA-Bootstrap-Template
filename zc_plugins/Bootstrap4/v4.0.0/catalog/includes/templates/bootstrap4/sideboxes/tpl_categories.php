<?php
/**
 * Side Box Template
 *
 * BOOTSTRAP v3.7.0
 *
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: piloujp 2024 Oct 15 Modified in v2.1.0 $
 */
$includeAllCategories = $zca_include_zero_product_categories ?? true;

$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="list-group-flush sideBoxContent">';
foreach ($box_categories_array as $next_box_cat) {
    // -----
    // If 0-product categories are not to be displayed (see /extra_datafiles/site-specific-bootstrap-settings.php)
    // don't include if no products.
    //
    // Note: The 'soft setting' applies **only when** Configuration :: My Store :: Show Category Counts
    // is set to 'true'; otherwise, the 'count' element is not available!
    //
    if ($includeAllCategories === false && isset($next_box_cat['count']) && $next_box_cat['count'] === 0) {
        continue;
    }

    switch (true) {
// to make a specific category stand out define a new class in the stylesheet example: A.category-holiday
// uncomment the select below and set the cPath=3 to the cPath= your_categories_id
// many variations of this can be done
//      case ($box_categories_array[$i]['path'] == 'cPath=3'):
//        $new_style = 'category-holiday';
//        break;
        case ($next_box_cat['top'] === 'true'):
            $new_style = 'sideboxCategory-top';
            break;
        case ($next_box_cat['has_sub_cat'] === true):
            $new_style = 'sideboxCategory-subs';
            break;
        default:
            $new_style = 'sideboxCategory-products';
            break;
    }

    if ($next_box_cat['has_sub_cat'] === true) {
        $next_box_cat['name'] .= CATEGORIES_SEPARATOR;
    }

    if (($next_box_cat['top'] !== 'true' && SHOW_CATEGORIES_SUBCATEGORIES_ALWAYS !== '1') || zen_get_product_types_to_category($next_box_cat['path']) == 3) {
        // skip if this is for the document box (==3)
    } else {
        $content .=
            '<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . $new_style . '" href="' . zen_href_link(FILENAME_DEFAULT, $next_box_cat['path']) . '">';

        if ($next_box_cat['current'] === true) {
            if ($next_box_cat['has_sub_cat'] === true) {
                $content .= '<span class="sideboxCategory-subs-parent">' . $next_box_cat['name'] . '</span>';
            } else {
                $content .= '<span class="sideboxCategory-subs-selected">' . $next_box_cat['name'] . '</span>';
            }
        } else {
            $content .= $next_box_cat['name'];
        }

        if (SHOW_COUNTS === 'true') {
            if ((CATEGORIES_COUNT_ZERO === '1' && $next_box_cat['count'] === 0) || $next_box_cat['count'] >= 1) {
                $content .= '<span class="badge badge-pill">' . CATEGORIES_COUNT_PREFIX . $next_box_cat['count'] . CATEGORIES_COUNT_SUFFIX . '</span>';
            }
        }

        $content .= '</a>';
    }
}

if (SHOW_CATEGORIES_BOX_SPECIALS === 'true') {
    $show_this = $db->Execute("SELECT s.products_id FROM " . TABLE_SPECIALS . " s WHERE s.status = 1 LIMIT 1");
    if (!$show_this->EOF) {
        $content .= '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_SPECIALS) . '">' . CATEGORIES_BOX_HEADING_SPECIALS . '</a>';
    }
}
if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW === 'true') {
    // display limits
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
if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS === 'true') {
    $show_this = $db->Execute("SELECT products_id FROM " . TABLE_FEATURED . " WHERE status = 1 LIMIT 1");
    if (!$show_this->EOF) {
        $content .= '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_FEATURED_PRODUCTS) . '">' . CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS . '</a>';
    }
}
if (defined('SHOW_CATEGORIES_BOX_FEATURED_CATEGORIES') && SHOW_CATEGORIES_BOX_FEATURED_CATEGORIES === 'true') {
    $show_this = $db->Execute("SELECT categories_id FROM " . TABLE_FEATURED_CATEGORIES . " WHERE status = 1 LIMIT 1");
    if (!$show_this->EOF) {
        $content .=
            '<a class="list-group-item list-group-item-action list-group-item-secondary" href="' . zen_href_link(FILENAME_FEATURED_CATEGORIES) . '">' .
                CATEGORIES_BOX_HEADING_FEATURED_CATEGORIES .
            '</a>' . "\n";
    }
}
if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL === 'true') {
    $content .= '<a class="list-group-item list-group-item-action  list-group-item-secondary" href="' . zen_href_link(FILENAME_PRODUCTS_ALL) . '">' . CATEGORIES_BOX_HEADING_PRODUCTS_ALL . '</a>';
}

$content .= '</div>';
