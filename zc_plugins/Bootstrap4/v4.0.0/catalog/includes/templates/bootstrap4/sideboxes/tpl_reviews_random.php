<?php
/**
 * Side Box Template
 * 
 * BOOTSTRAP v3.7.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Sat Oct 17 21:00:46 2015 -0400 Modified in v1.5.5 $
 */
$is_carousel = in_array('reviews', $sidebox_carousels);

$content = '<div id="' . str_replace('_', '-', $box_id . 'Content') . '" class="sideBoxContent text-center p-3">';
if ($is_carousel === true) {
    $carousel_fade = in_array('reviews', $sidebox_carousels_to_fade) ? 'carousel-fade' : '';
    $content .=
        '<div class="carousel slide ' . $carousel_fade . '" data-ride="carousel">
            <div class="carousel-inner">' .
                '<div class="card-deck h-100">';
}

$active_class = 'active';
while (!$random_review_sidebox_product->EOF) {
    $current_review = $random_review_sidebox_product->fields;

    $carousel_start = ($is_carousel === true) ? '<div class="carousel-item h-100 ' . $active_class . '">' : '';
    $carousel_end = ($is_carousel === true) ? '</div>' : '';

    $content .=
        $carousel_start .
        '<div class="card mb-3 p-3 sideBoxContentItem">' .
            '<a href="' . zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $current_review['products_id'] . '&reviews_id=' . $current_review['reviews_id']) . '" title="' . zen_output_string_protected($current_review['products_name']) . '">' .
                zen_image(DIR_WS_IMAGES . $random_review_sidebox_product->fields['products_image'], $current_review['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT) .
                '<br>' .
                nl2br(zen_trunc_string(zen_output_string_protected(stripslashes($current_review['reviews_text'])), 60), true) .
            '</a>' .
            '<div class="p-3 text-center rating">' .
                zca_get_rating_stars($random_review_sidebox_product->fields['reviews_rating'], 'xs') .
            '</div>' .
        '</div>' .
        $carousel_end;

    $active_class = '';
    $random_review_sidebox_product->MoveNextRandom();
}

if ($is_carousel === true) {
    $content .=
        '       </div>
            </div>
        </div>';
}

$content .= "</div>\n";

