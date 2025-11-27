<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.7.9
 *
 * Loaded automatically by index.php?main_page=product_info.
 * Displays details of a typical product
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Marco Ponchia 2020 May 20 Modified in v1.5.7 $
 */
// -----
// This variable, added in v3.7.0, enables all product_xx_info pages' templates to
// use this common one.  The prefix value is used to designate which page is active
// for various HTML 'id' attributes.
//
$html_id_prefix = $html_id_prefix ?? 'productInfo';
?>
<div id="<?= $html_id_prefix ?>" class="centerColumn">
    <?= zen_draw_form('cart_quantity', zen_href_link(zen_get_info_page($_GET['products_id']), zen_get_all_get_params(['action']) . 'action=add_product', $request_type), 'post', 'enctype="multipart/form-data"') . "\n" ?>
<?php
if ($messageStack->size('product_info') > 0) {
    echo $messageStack->output('product_info');
}

if ($module_show_categories !== '0') {
?>
    <!--bof Category Icon -->
    <div id="<?= $html_id_prefix ?>-productCategoryIcon" class="productCategoryIcon">
        <?php require $template->get_template_dir('/tpl_modules_category_icon_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_category_icon_display.php'; ?>
    </div>
    <!--eof Category Icon -->
<?php
}

if (PRODUCT_INFO_PREVIOUS_NEXT === '1' || PRODUCT_INFO_PREVIOUS_NEXT === '3') {
?>
    <!--bof Prev/Next top position -->
    <div id="<?= $html_id_prefix ?>-productPrevNextTop" class="productPrevNextTop">
        <?php require $template->get_template_dir('/tpl_products_next_previous.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_products_next_previous.php'; ?>
    </div>
    <!--eof Prev/Next top position-->
<?php
}
?>
    <!--bof Product Name-->
    <h1 id="<?= $html_id_prefix ?>-productName" class="productName"><?= $products_name ?></h1>
    <!--eof Product Name-->

    <div id="<?= $html_id_prefix ?>-displayRow" class="row">
       <div id="<?= $html_id_prefix ?>-displayColLeft" class="col-sm mb-3">

            <!--bof Main Product Image -->
<?php
if (!empty($products_image)) {
 ?>
            <div id="<?= $html_id_prefix ?>-productMainImage" class="productMainImage pt-3 text-center">
                <?php require $template->get_template_dir('/tpl_modules_main_product_image.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_main_product_image.php'; ?>
            </div>
<?php
}
?>
            <!--eof Main Product Image-->

            <!--bof Additional Product Images -->
            <div id="<?= $html_id_prefix ?>-productAdditionalImages" class="productAdditionalImages text-center">
<?php
/**
 * display the products additional images in a model carousel
 */
if (PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_POPUPS === 'Yes' && PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_SLIDE === '1') {
    require $template->get_template_dir('tpl_bootstrap_images.php', DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_bootstrap_images.php';

    if ($num_images > 0) {
        $buttonText = $num_images . TEXT_MULTIPLE_IMAGES;
?>
                <div class="p-1"></div>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bootstrap-slide-modal-lg">
                    <?= $buttonText ?>
                </button>
                <div class="p-3"></div>
<?php
    }
/**
 * display the products additional images in individual modal
 */
} else {
?>
                <div class="p-3"></div>
                <?php require $template->get_template_dir('/tpl_modules_additional_images.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_additional_images.php';
}
?>
            </div>
            <!--eof Additional Product Images -->

            <!--bof Product description -->
<?php
if ($products_description != '') {
?>
            <div id="<?= $html_id_prefix ?>-productDescription" class="productDescription mb-3">
                <?= stripslashes($products_description) ?>
            </div>
<?php
}
?>
            <!--eof Product description -->

            <!--bof Reviews button and count-->
<?php
if ($flag_show_product_info_reviews === '1') {
    // if more than 0 reviews, then show reviews button; otherwise, show the "write review" button
    if ($reviews->fields['count'] > 0 ) {
?>
            <div id="<?= $html_id_prefix ?>-productReviewLink" class="productReviewLink mb-3">
                <?= zca_button_link(zen_href_link(FILENAME_PRODUCT_REVIEWS, zen_get_all_get_params()), BUTTON_REVIEWS_ALT, 'button_reviews') ?>
            </div>

            <p id="<?= $html_id_prefix ?>-productReviewCount" class="productReviewCount">
                <?= ($flag_show_product_info_reviews_count === '1' ? TEXT_CURRENT_REVIEWS . ' ' . $reviews->fields['count'] : '') ?>
            </p>
<?php
    } else {
?>
            <div id="<?= $html_id_prefix ?>-productReviewLink" class="productReviewLink mb-3">
                <?= zca_button_link(zen_href_link(FILENAME_PRODUCT_REVIEWS_WRITE, zen_get_all_get_params()), BUTTON_WRITE_REVIEW_ALT, 'button_write_review') ?>
            </div>
<?php
    }
}
?>
            <!--eof Reviews button and count -->
        </div>

        <div id="<?= $html_id_prefix ?>-displayColRight"  class="col-sm mb-3">
            <!--bof Product details list  -->
<?php
// -----
// Starting with v3.7.0, the product-info display is common to all product
// types.  Some types, like product_music_info, might supply their own version
// of the product-details list.
//
// If such a file, based on the current type, is available, use that override
// instead of the base processing.
//
$product_details_filename = '/tpl_' . $current_page_base . '_display_details.php';
$product_details_filepath = $template->get_template_dir($product_details_filename, DIR_WS_TEMPLATE, $current_page_base, 'templates') . $product_details_filename;
if (file_exists($product_details_filepath)) {
    require $product_details_filepath;
} else {
    require $template->get_template_dir('/tpl_product_info_display_details.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_product_info_display_details.php';
}
?>
            <!--eof Product details list -->
<?php
if ($flag_show_ask_a_question === true) {
?>
            <!-- bof Ask a Question -->
            <div class="p-1"></div>
            <span id="productQuestions">
                <?= zca_button_link(zen_href_link(FILENAME_ASK_A_QUESTION, 'pid=' . $_GET['products_id'], 'SSL'), BUTTON_ASK_A_QUESTION_ALT, 'button_ask_a_question') ?>
            </span>
            <div class="p-2"></div>
            <!-- eof Ask a Question -->
<?php
}

// -----
// Starting with v3.7.0, a product type's base template can identify additional
// formatting for the specific product type, e.g. product-music.
//
if (isset($product_info_display_extra)) {
    require $template->get_template_dir($product_info_display_extra, DIR_WS_TEMPLATE, $current_page_base, 'templates') . $product_info_display_extra;
}
?>
            <!--bof Attributes Module -->
<?php
$one_time = '';
$display_price_bottom = (zen_get_products_allow_add_to_cart((int)$_GET['products_id']) === 'Y');
if ($pr_attr->fields['total'] > 0) {
    if ($show_onetime_charges_description === true) {
        $one_time = '<small>' . TEXT_ONETIME_CHARGE_SYMBOL . TEXT_ONETIME_CHARGE_DESCRIPTION . '</small><br>';
    }

    if (zen_get_products_allow_add_to_cart((int)$_GET['products_id']) === 'N') {
        $display_price_top = false;
        $display_price_bottom = false;
    } else {
        $display_price_top = (BS4_PRICING_LOCATION === 'Both' || BS4_PRICING_LOCATION === 'Above Only');
        $display_price_bottom = (BS4_PRICING_LOCATION === 'Both' || BS4_PRICING_LOCATION === 'Below Only');
    }
?>
            <!--bof Product Price block above Attributes -->
<?php
    if ($display_price_top === true) {
?>
            <!--bof products price top card-->
            <div id="productsPriceTop-card" class="card mb-3">
                <div id="productsPriceTop-card-body" class="card-body p-3">
                    <h2 id="productsPriceTop-productPriceTopPrice" class="productPriceTopPrice">
  <?php
// base price
        echo
            $one_time .
            ((zen_has_product_attributes_values((int)$_GET['products_id']) && $flag_show_product_info_starting_at == 1) ? TEXT_BASE_PRICE : '') .
            zen_get_products_display_price((int)$_GET['products_id']);
?>
                    </h2>
                </div>
            </div>
            <!--eof products price top card-->
<?php
    }
?>
            <!--eof Product Price block above Attributes -->

            <div id="productAttributes">
                <?php require $template->get_template_dir('/tpl_modules_attributes.php',DIR_WS_TEMPLATE, $current_page_base,'templates') . '/tpl_modules_attributes.php'; ?>
            </div>
<?php
}
?>
            <!--eof Attributes Module -->
<?php
 if ($flag_show_product_info_free_shipping === '1' && zen_get_product_is_always_free_shipping($products_id_current)) {
?>
            <!--bof free ship icon  -->
            <div id="<?= $html_id_prefix ?>-productFreeShippingIcon" class="productFreeShippingIcon text-center m-3">
                <?= TEXT_PRODUCT_FREE_SHIPPING_ICON ?>
            </div>
            <!--eof free ship icon  -->
<?php
}

if ($products_discount_type !== '0') {
?>
            <!--bof Quantity Discounts table -->
            <div id="<?= $html_id_prefix ?>-productQuantityDiscounts" class="productQuantityDiscounts">
                <?php require $template->get_template_dir('/tpl_modules_products_quantity_discounts.php',DIR_WS_TEMPLATE, $current_page_base,'templates') . '/tpl_modules_products_quantity_discounts.php'; ?>
            </div>
            <!--eof Quantity Discounts table -->
<?php
}

if ($display_price_bottom === true) {
?>
            <!--bof products price bottom card-->
            <div id="productsPriceBottom-card" class="card mb-3">
                <div id="productsPriceBottom-card-body" class="card-body p-3">
                    <h2 id="productsPriceBottom-productPriceBottomPrice" class="productPriceBottomPrice">
                        <?= $one_time .
                            (($flag_show_product_info_starting_at === '1' && zen_has_product_attributes_values((int)$_GET['products_id'])) ? TEXT_BASE_PRICE : '') .
                            zen_get_products_display_price((int)$_GET['products_id']) ?>
                    </h2>
                </div>
            </div>
            <!--eof products price bottom card-->
<?php
}
?>
            <!--bof Add to Cart Box -->
<?php
if (CUSTOMERS_APPROVAL === '3' && TEXT_LOGIN_FOR_PRICE_BUTTON_REPLACE_SHOWROOM === '') {
  // do nothing
} else {
    $display_qty = ($flag_show_product_info_in_cart_qty === '1' && $_SESSION['cart']->in_cart($_GET['products_id'])) ? '<p>' . PRODUCTS_ORDER_QTY_TEXT_IN_CART . $_SESSION['cart']->get_quantity($_GET['products_id']) . '</p>' : '';
    if ($products_qty_box_status === '0' || $products_quantity_order_max === '1') {
        // hide the quantity box and default to 1
        $the_button =
            zen_draw_hidden_field('cart_quantity', '1') .
            zen_draw_hidden_field('products_id', (int)$_GET['products_id']) .
            zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT);
    } else {
        // show the quantity box
        $the_button =
            '<div class="input-group mb-3">' .
                '<input class="form-control" type="text" name="cart_quantity" value="' . $products_get_buy_now_qty . '" aria-label="' . ARIA_QTY_ADD_TO_CART . '">' .
                '<div class="input-group-append">' .
                    zen_draw_hidden_field('products_id', (int)$_GET['products_id']) .
                    zen_image_submit(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT) .
                '</div>' .
            '</div>';
    }
    $display_button = zen_get_buy_now_button($_GET['products_id'], $the_button);

    if ($display_qty !== '' || !empty($display_button)) {
        if (zen_get_products_quantity_min_units_display((int)$_GET['products_id']) > 0) {
?>
                <div id="min-max-units" class="d-flex justify-content-around mb-2">
                    <?= zen_get_products_quantity_min_units_display((int)$_GET['products_id']) ?>
                </div>
<?php
        }
?>
            <!--bof add to cart card-->
            <div id="addToCart-card" class="card mb-3">
                <div id="addToCart-card-header" class="card-header"><?= PRODUCTS_ORDER_QTY_TEXT ?></div>
                <div id="cartAdd" class="card-body text-center">
                    <?= $display_qty . $display_button ?>
                </div>
            </div>
            <!--eof add to cart card-->
<?php
    } // display qty and button
} // CUSTOMERS_APPROVAL == 3
 ?>
            <!--eof Add to Cart Box-->
        </div>
    </div>

    <div id="<?= $html_id_prefix ?>-moduledDisplayRow" class="row">
<?php
if (PRODUCT_INFO_SHOW_NOTIFICATIONS_BOX === '1') {
?>
        <!--bof Products Notification Module-->
        <div id="<?= $html_id_prefix ?>-moduleDisplayColLeft" class="col-sm">
            <?php require DIR_WS_MODULES . zen_get_module_directory('centerboxes/product_notifications.php'); ?>
        </div>
        <!--eof Products Notification Module-->
<?php
}

if (PRODUCT_INFO_SHOW_MANUFACTURER_BOX === '1') {
?>
        <!--bof Products Manufacturer Info Module-->
        <div id="<?= $html_id_prefix ?>-moduleDisplayColRight" class="col-sm">
            <?php require DIR_WS_MODULES . zen_get_module_directory('centerboxes/manufacturer_info.php'); ?>
        </div>
        <!--eof Products Manufacturer Info Module-->
<?php
}
?>
    </div>

    <!--bof Product date added/available-->

<?php
if ($products_date_available > date('Y-m-d H:i:s')) {
    if ($flag_show_product_info_date_available === '1') {
?>
    <p id="<?= $html_id_prefix ?>-productDateAvailable" class="productDateAvailable text-center">
         <?= sprintf(TEXT_DATE_AVAILABLE, zen_date_long($products_date_available)) ?>
    </p>
<?php
    }
} elseif ($flag_show_product_info_date_added === '1') {
?>
    <p id="<?= $html_id_prefix ?>-productDateAdded" class="productDateAdded text-center">
        <?= sprintf(TEXT_DATE_ADDED, zen_date_long($products_date_added)) ?>
    </p>
<?php
}
?>
<!--eof Product date added/available -->

<!--bof Product URL -->
<?php
  if ($flag_show_product_info_url === '1' && !empty($products_url)) {
?>
    <p id="<?= $html_id_prefix ?>-productUrl" class="productUrl text-center">
        <?= sprintf(TEXT_MORE_INFORMATION, zen_href_link(FILENAME_REDIRECT, 'action=product&products_id=' . zen_output_string_protected($_GET['products_id']), 'NONSSL', true, false)) ?>
    </p>
<?php
}
?>
<!--eof Product URL -->

<!--bof also purchased products module-->

<?php require $template->get_template_dir('tpl_modules_also_purchased_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes').  '/tpl_modules_also_purchased_products.php' ?>

<!--eof also purchased products module-->

<!--bof Prev/Next bottom position -->
<?php
if (PRODUCT_INFO_PREVIOUS_NEXT === '2' || PRODUCT_INFO_PREVIOUS_NEXT === '3') {
?>
    <div id="<?= $html_id_prefix ?>-productPrevNextBottom" class="productPrevNextBottom">
        <?php require $template->get_template_dir('/tpl_products_next_previous.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_products_next_previous.php'; ?>
    </div>
<?php
}
?>
<!--eof Prev/Next bottom position -->

    <!--bof Form close-->
    <?= '</form>' ?>
    <!--bof Form close-->
</div>
