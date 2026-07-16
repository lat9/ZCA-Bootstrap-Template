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
 * @version $Id: tpl_specials.php 18698 2011-05-04 14:50:06Z wilt $
 */
$is_carousel = in_array('specials', $sidebox_carousels);

$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent text-center p-3">';
if ($is_carousel === true) {
    $carousel_fade = in_array('specials', $sidebox_carousels_to_fade) ? 'carousel-fade' : '';
    $content .=
        '<div class="carousel slide ' . $carousel_fade . '" data-ride="carousel">
            <div class="carousel-inner">' .
                '<div class="card-deck h-100">';
}

$active_class = 'active';
while (!$random_specials_sidebox_product->EOF) {
    $current_special = $random_specials_sidebox_product->fields;
    $specials_id = $current_special['products_id'];
    $specials_box_price = zen_get_products_display_price($specials_id);
    $specials_name = $current_special['products_name'];
    $specials_link = zen_href_link(zen_get_info_page($specials_id), 'cPath=' . zen_get_generated_category_path_rev($current_special['master_categories_id']) . '&products_id=' . $specials_id);

    $carousel_start = ($is_carousel === true) ? '<div class="carousel-item h-100 ' . $active_class . '">' : '';
    $carousel_end = ($is_carousel === true) ? '</div>' : '';

    $content .=
        "\n" .
        $carousel_start .
        '<div class="card mb-3 p-3 sideBoxContentItem">' .
            '<a href="' . $specials_link . '" title="' . zen_output_string_protected($specials_name) . '">' .
                zen_image(DIR_WS_IMAGES . $current_special['products_image'], $specials_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                '<br>' .
                $specials_name .
            '</a>' .
            '<div>' .
                $specials_box_price .
            '</div>' .
        '</div>' .
        $carousel_end;

    $active_class = '';
    $random_specials_sidebox_product->MoveNextRandom();
}

if ($is_carousel === true) {
    $content .=
        '       </div>
            </div>
        </div>';
}

$content .= "</div>\n";
