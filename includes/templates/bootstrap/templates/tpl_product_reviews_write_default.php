<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2019 Jul 15 Modified in v1.5.7 $
 */
?>
<div id="productReviewsWriteDefault" class="centerColumn">
<?= zen_draw_form('product_reviews_write', zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, 'action=process&products_id=' . $_GET['products_id'], 'SSL'), 'post', 'onsubmit="return checkForm(product_reviews_write);"') ?>

<!--bof Product Name-->
    <h1 id="productReviewsWriteDefault-productName" class="productName"><?= $products_name ?></h1>
<!--eof Product Name-->

    <div class="row">
        <div class="col-sm">
<!--bof Main Product Image -->
<?php
if ($products_image !== '') {
   	/**
     * require the image display code
     */
?>  
            <div id="productReviewsWriteDefault-productMainImage" class="productMainImage text-center">
                <?php require $template->get_template_dir('/tpl_modules_main_product_image.php', DIR_WS_TEMPLATE, $current_page_base,'templates') . '/tpl_modules_main_product_image.php'; ?>
            </div>
<?php
}
?>
<!--eof Main Product Image-->
<?php
if (!empty($products_model)) {
?>
<!--bof Product details list  -->
            <ul id="productReviewsWriteDefault-productDetailsList" class="productDetailsList list-group mb-3">
                <li class="list-group-item"><?= TEXT_PRODUCT_MODEL . $products_model ?></li>
            </ul>
<!--eof Product details list -->
<?php
}
?>
        </div>
        <div class="col-sm">
<!--bof Product Price block -->
            <div id="productsPriceTop-card" class="card mb-3">
                <div id="productsPriceTop-card-body" class="card-body p-3">
                    <h2 id="productsPriceTop-productPriceTopPrice" class="productPriceTopPrice">
                        <?= $products_price ?>
                    </h2>
                </div>
            </div>
<!--eof Product Price block -->

<!--bof product links card-->
            <div id="productLinks-card" class="card mb-3">
                <div id="productLinks-card-body" class="card-body">
                    <?= zca_button_link(zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params()), BUTTON_GOTO_PROD_DETAILS_ALT, 'button_goto_prod_details') ?>

                    <div class="p-1"></div>
                    <?= zca_button_link(zen_href_link(FILENAME_REVIEWS), BUTTON_REVIEWS_ALT, 'button_reviews') ?>
                </div>
            </div>
<!--eof product links card-->
        </div>
    </div>

<!--bof products review write card-->
    <div id="productsReviewWrite-card" class="card">
        <div id="productsReviewWrite-card-header" class="card-header">
<?php
// -----
// In zc200+, the name of the variable that contains the name of the reviewer has
// changed from $customer to $reviewer.  Since this template still supports
// zc157 and later, use $reviewer if present; otherwise, fall back to $customer.
//
$reviewer = $reviewer ?? $customer;
?>
            <?= SUB_TITLE_FROM . ' ' . zen_output_string_protected($reviewer->fields['customers_firstname'] . ' ' . $reviewer->fields['customers_lastname']) ?>
        </div>
        <div id="productsReviewWrite-card-body" class="card-body">
<?php
if ($messageStack->size('review_text') > 0) {
    echo $messageStack->output('review_text');
}
?>
            <div class="text-center p-3"><?= SUB_TITLE_RATING ?></div>

            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('rating', '1', ($_POST['rating'] ?? '') === '1', 'id="rating-1" class="custom-control-input"') ?>
                <label class="custom-control-label rating" for="rating-1"><?= zca_get_rating_stars(1, 'xs') ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('rating', '2', ($_POST['rating'] ?? '') === '2', 'id="rating-2" class="custom-control-input"') ?>
                <label class="custom-control-label rating" for="rating-2"><?= zca_get_rating_stars(2, 'xs') ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('rating', '3', ($_POST['rating'] ?? '') === '3', 'id="rating-3" class="custom-control-input"') ?>
                <label class="custom-control-label rating" for="rating-3"><?= zca_get_rating_stars(3, 'xs') ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('rating', '4', ($_POST['rating'] ?? '') === '4', 'id="rating-4" class="custom-control-input"') ?>
                <label class="custom-control-label rating" for="rating-4"><?= zca_get_rating_stars(4, 'xs') ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('rating', '5', ($_POST['rating'] ?? '') === '5', 'id="rating-5" class="custom-control-input"') ?>
                <label class="custom-control-label rating" for="rating-5"><?= zca_get_rating_stars(5, 'xs') ?></label>
            </div>

            <label id="textArea-label" for="review-text"><?= SUB_TITLE_REVIEW ?></label>
            <?= zen_draw_textarea_field('review_text', 60, 5, ($_POST['review_text'] ?? ''), 'id="review-text"') ?>
            
            <?= zen_draw_input_field($antiSpamFieldName, '', ' size="60" id="RAS" style="visibility:hidden; display:none;" autocomplete="off"') ?>

            <div id="productsReviewWrite-reviewsWriteNotice">
                <?= TEXT_NO_HTML . (zen_config('REVIEWS_APPROVAL') === '1' ? '<br>' . TEXT_APPROVAL_REQUIRED: '') ?>
            </div>

            <div id="productsReviewWrite-btn-toolbar" class="btn-toolbar justify-content-end my-3" role="toolbar">
                <?= zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT) ?>
            </div>

        </div>
    </div>
<!--eof products review write card-->
<?= '</form>' ?>
</div>
