<?php
/**
 * Side Box Template
 * 
 * BOOTSTRAP v3.7.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2011 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_whats_new.php 18698 2011-05-04 14:50:06Z wilt $
 */
$is_carousel = in_array('whats_new', $sidebox_carousels);

$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent text-center p-3">';
if ($is_carousel === true) {
    $carousel_fade = in_array('whats_new', $sidebox_carousels_to_fade) ? 'carousel-fade' : '';
    $content .=
        '<div class="carousel slide ' . $carousel_fade . '" data-ride="carousel">
            <div class="carousel-inner">' .
                '<div class="card-deck h-100">';
}

$active_class = 'active';
while (!$random_whats_new_sidebox_product->EOF) {
    $current_new = $random_whats_new_sidebox_product->fields;
    $whats_new_id = $current_new['products_id'];
    $whats_new_price = zen_get_products_display_price($whats_new_id);
    $whats_new_name = $current_new['products_name'];
    $whats_new_link =  zen_href_link(zen_get_info_page($whats_new_id), 'cPath=' . zen_get_generated_category_path_rev($current_new['master_categories_id']) . '&products_id=' . $whats_new_id);

    $carousel_start = ($is_carousel === true) ? '<div class="carousel-item h-100 ' . $active_class . '">' : '';
    $carousel_end = ($is_carousel === true) ? '</div>' : '';

    $content .=
        "\n" .
        $carousel_start .
        '<div class="card mb-3 p-3 sideBoxContentItem">' .
            '<a href="' . $whats_new_link . '" title="' . zen_output_string_protected($whats_new_name) . '">' .
                zen_image(DIR_WS_IMAGES . $current_new['products_image'], $whats_new_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                '<br>' .
                $whats_new_name .
            '</a>' .
            '<div>' .
                $whats_new_price .
            '</div>' .
        '</div>' .
        $carousel_end;

    $active_class = '';
    $random_whats_new_sidebox_product->MoveNextRandom();
}

if ($is_carousel === true) {
    $content .=
        '       </div>
            </div>
        </div>';
}

$content .= "</div>\n";
