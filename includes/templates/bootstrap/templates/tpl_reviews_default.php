<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott C Wilson 2019 Jul 23 Modified in v1.5.7 $
 */
?>
<div id="reviewsDefault" class="centerColumn">
    <h1 id="reviewsDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>

<?php
if ($reviews_split->number_of_rows > 0) {
    if (in_array($tplSetting->PREV_NEXT_BAR_LOCATION, ['1', '3'], true)) {
?>
    <div id="reviewsDefault-topRow" class="row p-3">
        <div id="reviewsDefault-topNumber" class="topNumber col-sm"><?= $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS) ?></div>

        <div id="reviewsDefault-topLinks" class="topLinks col-sm">
            <?= TEXT_RESULT_PAGE . $reviews_split->display_links($max_display_page_links, zen_get_all_get_params(['page', 'info', 'main_page']), $paginateAsUL) ?>
        </div>
    </div>
<?php
    }

    $reviews = $db->Execute($reviews_split->sql_query);
    foreach ($reviews as $review) {
        $reviews_id = $review['reviews_id'];
        $products_id = $review['products_id'];
?>
<!--bof reviews card-->
    <div id="review<?= $reviews_id ?>-card" class="card mb-3">
        <div id="review<?= $reviews_id ?>-card-header" class="card-header">
            <?= sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($review['date_added'])) ?>
        </div>
        <div id="review<?= $reviews_id ?>-card-body" class="card-body">
            <h1 id="review<?= $reviews_id ?>-productName" class="productName"><?= $review['products_name'] ?></h1>

            <div class="row">
                <div class="col-sm text-center">
                    <a href="<?= zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $products_id . '&reviews_id=' . $reviews_id) ?>">
                        <?= zen_image(DIR_WS_IMAGES . $review['products_image'], $review['products_name'], $tplSetting->SMALL_IMAGE_WIDTH, $tplSetting->SMALL_IMAGE_HEIGHT) ?>
                    </a>
                </div>
                <div class="col-sm">
                    <?= zca_button_link(zen_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id=' . $products_id . '&reviews_id=' . $reviews_id), BUTTON_READ_REVIEWS_ALT, 'button_read_reviews') ?>
                    <div class="p-1"></div>
                    <?= zca_button_link(zen_href_link(zen_get_info_page($products_id), 'products_id=' . $products_id), BUTTON_GOTO_PROD_DETAILS_ALT, 'button_goto_prod_details') ?>
                </div>
            </div>

            <hr>

            <div id="review<?= $reviews_id ?>-rating" class="rating text-center"> 
                <h3 class="rating"><?= zca_get_rating_stars($review['reviews_rating'], 'xs') ?></h3>
            </div>
            <blockquote class="blockquote mb-0">
                <div id="review<?= $reviews_id ?>-content" class="content">
                    <?= zen_trunc_string(nl2br(zen_output_string_protected(stripslashes($review['reviews_text'])), false), $tplSetting->MAX_PREVIEW) ?>
                </div>
                <footer class="blockquote-footer">
                    <cite title="Source Title"><?= sprintf(TEXT_REVIEW_BY, zen_output_string_protected($review['customers_name'])) ?></cite>
                </footer>
            </blockquote>
        </div>
    </div>
<!--eof reviews card-->
<?php
    }
?>
<?php
} else {
?>
    <div id="reviewsDefault-content" class="content">
        <?= TEXT_NO_REVIEWS ?>
    </div>
<?php
}
?>
<?php
if ($reviews_split->number_of_rows > 0 && in_array($tplSetting->PREV_NEXT_BAR_LOCATION, ['2', '3'], true)) {
?>
    <div id="reviewsDefault-bottomRow" class="row">
        <div id="reviewsDefault-bottomNumber" class="bottomNumber col-sm"><?= $reviews_split->display_count(TEXT_DISPLAY_NUMBER_OF_REVIEWS) ?></div>
        <div id="reviewsDefault-bottomLinks" class="bottomLinks col-sm">
            <?= TEXT_RESULT_PAGE . $reviews_split->display_links($max_display_page_links, zen_get_all_get_params(['page', 'info', 'main_page']), $paginateAsUL) ?>
        </div>
    </div>

<?php
}
?>
</div>
