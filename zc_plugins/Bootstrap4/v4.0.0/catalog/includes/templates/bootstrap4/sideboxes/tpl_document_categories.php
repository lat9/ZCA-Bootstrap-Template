<?php
/**
 * Side Box Template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Drbyte Sun Jan 7 21:28:50 2018 -0500 Modified in v1.5.6 $
 *
 * BOOTSTRAP v3.5.2
 *
 */
$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="list-group-flush sideBoxContent">';
foreach ($box_categories_array as $next_category) {
    switch(true) {
        case ($next_category['top'] == 'true'):
            $new_style = 'sideboxCategory-top';
            break;
        case ($next_category['has_sub_cat']):
            $new_style = 'sideboxCategory-subs';
            break;
      default:
            $new_style = 'sideboxCategory-products';
            break;
    }

    $content .= '<a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center ' . $new_style . '" href="' . zen_href_link(FILENAME_DEFAULT, $next_category['path']) . '">';

    if ($next_category['current']) {
        if ($next_category['has_sub_cat']) {
            $content .= '<span class="sideboxCategory-subs-parent">' . $next_category['name'] . '</span>';
        } else {
            $content .= '<span class="sideboxCategory-subs-selected">' . $next_category['name'] . '</span>';
        }
    } else {
        $content .= $next_category['name'];
    }

    if ($next_category['has_sub_cat']) {
        $content .= CATEGORIES_SEPARATOR;
    }

    if (SHOW_COUNTS === 'true') {
        if ((CATEGORIES_COUNT_ZERO === '1' && $next_category['count'] == 0) || $next_category['count'] >= 1) {
            $content .= '<span class="badge badge-pill">' . CATEGORIES_COUNT_PREFIX . $next_category['count'] . CATEGORIES_COUNT_SUFFIX . '</span>';
        }
    }

    $content .= '</a>';
}
$content .= '</div>';
