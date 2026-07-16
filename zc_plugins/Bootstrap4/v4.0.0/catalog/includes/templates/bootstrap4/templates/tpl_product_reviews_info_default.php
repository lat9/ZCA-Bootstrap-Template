<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.7.8
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_product_reviews_info_default.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
?>
<div id="productReviewsInfoDefault" class="centerColumn">
<!--bof Product Name-->
    <h1 id="productReviewsInfoDefault-productName" class="productName"><?= $products_name ?></h1>
<!--eof Product Name-->

    <div class="row">
        <div class="col-sm">
<!--bof Main Product Image -->
<?php
if (!empty($products_image)) {
   	/**
     * require the image display code
     */
?>
            <div id="productReviewsInfoDefault-productMainImage" class="productMainImage text-center">
                <?php require $template->get_template_dir('/tpl_modules_main_product_image.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_main_product_image.php'; ?>
            </div>
<?php
}
?>
<!--eof Main Product Image-->

<!--bof Product details list  -->
            <ul id="productReviewsInfoDefault-productDetailsList" class="productDetailsList list-group mb-3">
                <li class="list-group-item"><?= TEXT_PRODUCT_MODEL . $products_model ?></li>
            </ul>
<!--eof Product details list -->
        </div>
        <div class="col-sm">
            <div id="productsPriceTop-card" class="card mb-3">
                <div id="productsPriceTop-card-body" class="card-body p-3">
                    <h2 id="productsPriceTop-productPriceTopPrice" class="productPriceTopPrice">
                        <?= $products_price ?>
                    </h2>
                </div>
            </div>

            <div id="productLinks-card" class="card mb-3">
                <div id="productLinks-card-body" class="card-body">
<?php
// more info in place of buy now
if (!zen_has_product_attributes($review_info->fields['products_id'])) {
    $the_button =
        '<a class="p-2 btn button_in_cart" href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(['action', 'reviews_id']) . 'action=buy_now') . '">' .
            BUTTON_IN_CART_ALT .
        '</a>';
    echo zen_get_buy_now_button($review_info->fields['products_id'], $the_button, '') . '<br>' . zen_get_products_quantity_min_units_display($review_info->fields['products_id']);
}

$get_params = zen_get_all_get_params(['reviews_id']);
?>
                    <div class="p-1"></div>
                    <?= zca_button_link(zen_href_link(zen_get_info_page($_GET['products_id']), $get_params), BUTTON_GOTO_PROD_DETAILS_ALT, 'button_goto_prod_details') ?>
<?php
if ($reviews_counter > 1) {
?>
                    <div class="p-1"></div>
                    <?= zca_button_link(zen_href_link(FILENAME_PRODUCT_REVIEWS, $get_params), BUTTON_MORE_REVIEWS_ALT, 'button_more_reviews') ?>
<?php
}
?>
                    <div class="p-1"></div>
                    <?= zca_button_link(zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, $get_params), BUTTON_WRITE_REVIEW_ALT, 'button_write_review') ?>
                </div>
            </div>
        </div>
    </div>

<!--bof products review card-->
    <div id="productsReview-card" class="card">
        <div id="productsReview-card-header" class="card-header">
            <?= sprintf(TEXT_REVIEW_DATE_ADDED, zen_date_short($review_info->fields['date_added'])) ?>
        </div>
        <div id="productsReview-card-body" class="card-body">
            <div id="productsReview-rating" class="rating text-center"> 
                <h3 class="rating"><?= zca_get_rating_stars($review_info->fields['reviews_rating'], 'xs') ?></h3>
            </div>
            <blockquote class="blockquote mb-0">
                <div id="productReviewsInfoDefault-content" class="content">
                    <?= nl2br(zen_output_string_protected(stripslashes($review_info->fields['reviews_text'])), false) ?>
                </div>
                <footer class="blockquote-footer">
                    <cite title="Source Title">
                        <?= sprintf(TEXT_REVIEW_BY, zen_output_string_protected($review_info->fields['customers_name'])) ?>
                    </cite>
                </footer>
            </blockquote>
        </div>
    </div>
<!--eof products review card-->
</div>
