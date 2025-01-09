<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.7.5
 *
 * Loaded automatically by index.php?main_page=shopping_cart.<br />
 * Displays shopping-cart contents
 *
 * @copyright Copyright 2003-2025 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
?>
<div id="shoppingCartDefault" class="centerColumn">
<?php
if ($flagHasCartContents) {
    if ($_SESSION['cart']->count_contents() > 0) {
?>
    <div id="shoppingCartDefault-helpLink" class="helpLink float-right p-3">
        <a data-toggle="modal" href="#cartHelpModal"><?= TEXT_CART_MODAL_HELP ?></a>
    </div>

    <?php require $template->get_template_dir('tpl_info_shopping_cart.php', DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_info_shopping_cart.php'; ?>

    <div class="clearfix"></div>
<?php
    }
?>
    <h1 id="shoppingCartDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1> 

<?php
    if ($messageStack->size('shopping_cart') > 0) {
        echo $messageStack->output('shopping_cart');
    }
?>

    <?= zen_draw_form('cart_quantity', zen_href_link(FILENAME_SHOPPING_CART, 'action=update_product', $request_type), 'post', 'id="shoppingCartForm"') ?> 

    <div id="shoppingCartDefault-content" class="content">
<?php
/**
 * require the html_define for the shopping_cart page
 */
    require $define_page;
?>
    </div>

<?php 
    if (!empty($totalsDisplay)) {
?>
    <div id="shoppingCartDefault-cartTotalsDisplay" class="cartTotalsDisplay text-center font-weight-bold p-3"><?= $totalsDisplay ?></div>
<?php
    }

    if ($flagAnyOutOfStock) {
        if (STOCK_ALLOW_CHECKOUT === 'true') {
?>
    <div class="alert alert-danger" role="alert"><?= OUT_OF_STOCK_CAN_CHECKOUT ?></div>
<?php
        } else {
?>
    <div class="alert alert-danger" role="alert"><?= OUT_OF_STOCK_CANT_CHECKOUT ?></div>
<?php    
        } //endif STOCK_ALLOW_CHECKOUT
    } //endif flagAnyOutOfStock 
?>
    <div class="table-responsive">
        <table id="shoppingCartDefault-cartTableDisplay" class="cartTableDisplay table table-bordered table-striped table-sm">
            <tr>
                <th scope="col" id="cartTableDisplay-qtyHeading"><?= TABLE_HEADING_QUANTITY ?></th>
                <th scope="col" class="d-none d-sm-table-cell" id="cartTableDisplay-qtyUpdateHeading"><span aria-label="<?= TEXT_CART_ARIA_HEADING_UPDATE_COLUMN ?>">&nbsp;</span></th>
                <th scope="col" id="cartTableDisplay-productsHeading"><?= TABLE_HEADING_PRODUCTS ?></th>
                <th scope="col" id="cartTableDisplay-priceHeading"><?= TABLE_HEADING_PRICE ?></th>
                <th scope="col" id="cartTableDisplay-totalsHeading"><?= TABLE_HEADING_TOTAL ?></th>
                <th scope="col" class="d-none d-sm-table-cell" id="cartTableDisplay-removeHeading"><span aria-label="<?= TEXT_CART_ARIA_HEADING_DELETE_COLUMN ?>">&nbsp;</span></th>
            </tr>
<?php
    foreach ($productArray as $product) {
?>
            <tr>
                <td class="qtyCell text-center pb-4">
                    <?php
        if ($product['flagShowFixedQuantity']) {
            echo $product['showFixedQuantityAmount'] . ' ' . $product['flagStockCheck'] . ' ' . $product['showMinUnits'];
        } else {
            echo $product['quantityField'] . ' ' . $product['flagStockCheck'] . ' ' . $product['showMinUnits'];
        }
?>

                    <div class="d-sm-none mt-1">
<?php
        if ($product['buttonDelete']) {
?>
                    <a href="<?= zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']) ?>" class="btn btn-sm mt-1" aria-label="<?= ICON_TRASH_ALT ?>" title="<?= ICON_TRASH_ALT ?>"><i aria-hidden="true" class="fas fa-sm fa-trash-alt"></i></a>
<?php
        }
        if ($product['checkBoxDelete'] ) {
            $checkbox_field = zen_draw_checkbox_field('cart_delete[]', $product['id'], false, 'id="del-r-' . $product['id'] . '"');
            $checkbox_field = str_replace('custom-control-input', 'form-check-input', $checkbox_field);
?>
                    <div class="form-check mt-1">
                        <?= $checkbox_field ?>
                        <label class="form-check-label sr-only" for="del-r-<?= $product['id'] ?>"><?= ARIA_DELETE_ITEM_FROM_CART ?></label>
                    </div>
<?php
        }
?>
                    </div>
                </td>

                <td class="qtyUpdateCell text-center d-none d-sm-table-cell"><?= (!empty($product['buttonUpdate'])) ? $product['buttonUpdate'] : '' ?></td>

                <td class="productsCell">
                    <a href="<?= $product['linkProductsName'] ?>">
                        <span class="d-none d-sm-block float-left mr-3"><?= $product['productsImage'] ?></span>
                        <?= $product['productsName'] . ' ' . $product['flagStockCheck'] ?>
                    </a>

<?php
        echo $product['attributeHiddenField'];
        if (isset($product['attributes']) && is_array($product['attributes'])) {
?>
                    <div class="productsCell-attributes">
                        <ul>
<?php
            foreach ($product['attributes'] as $option => $value) {
?>
                            <li><?= $value['products_options_name'] . TEXT_OPTION_DIVIDER . nl2br($value['products_options_values_name'], false) ?></li>
<?php
            }
?>
                        </ul>
                    </div>
<?php
        }
?>
                </td>
                <td class="priceCell"><?= $product['productsPriceEach'] ?></td>
                <td class="totalsCell"><?= $product['productsPrice'] ?></td>
                <td class="removeCell text-center d-none d-sm-table-cell">
<?php
        if ($product['buttonDelete']) {
?>
                    <a href="<?= zen_href_link(FILENAME_SHOPPING_CART, 'action=remove_product&product_id=' . $product['id']) ?>" class="btn btn-sm" aria-label="<?= ICON_TRASH_ALT ?>" title="<?= ICON_TRASH_ALT ?>"><i aria-hidden="true" class="fas fa-sm fa-trash-alt"></i></a>
<?php
        }
        if ($product['checkBoxDelete'] ) {
            $checkbox_field = zen_draw_checkbox_field('cart_delete[]', $product['id'], false, 'id="del-' . $product['id'] . '"');
            $checkbox_field = str_replace('custom-control-input', 'form-check-input', $checkbox_field);
?>
                    <div class="form-check mt-1">
                        <?= $checkbox_field ?>
                        <label class="form-check-label sr-only" for="del-<?= $product['id'] ?>"><?= ARIA_DELETE_ITEM_FROM_CART ?></label>
                    </div>
<?php
        }
?>
                </td>
            </tr>
<?php
    } // end foreach ($productArray as $product)
?>
            <tr>
                <td colspan="1">

<?php
    // show update cart button
    if (SHOW_SHOPPING_CART_UPDATE === '2' || SHOW_SHOPPING_CART_UPDATE === '3') {
?>
                    <div id="cartUpdate" class="text-center">
                        <button type="submit" class="btn btn-sm" aria-label="<?= BUTTON_UPDATE_ALT ?>"><i class="fas fa-sm fa-sync-alt"></i></button>
                    </div>
<?php
    }
?>
                </td>
                <td colspan="5">
                    <div id="cartTotal" class="text-right font-weight-bold"><?= SUB_TITLE_SUB_TOTAL ?> <?= $cartShowTotal ?></div>
                </td>
            </tr>
        </table>
    </div>

<!--bof shopping cart buttons-->
    <div id="shoppingCartDefault-btn-toolbar" class="btn-toolbar justify-content-between my-3" role="toolbar">
        <?= zca_back_link('button_continue_shopping', '', BUTTON_CONTINUE_SHOPPING_ALT) ?>
        <?= zca_button_link(zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'), BUTTON_CHECKOUT_ALT, 'button_checkout') ?>
    </div>
<!--eof shopping cart buttons-->

    <?= '</form>' ?>
<?php
    if (SHOW_SHIPPING_ESTIMATOR_BUTTON === '1') {
        // -----
        // Determine whether the modal should be shown on the page's initial rendering.  It will be if its
        // form was just posted.
        //
        if (isset($_POST['action']) && $_POST['action'] === 'submit') {
?>
    <script>
    jQuery(document).ready(function () {
        jQuery('#shippingEstimatorModal').modal('show');
    });
    </script>
<?php
        }
?>
    <div id="shoppingCartDefault-shoppingEstimator-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
        <?= zen_image_button(BUTTON_IMAGE_SHIPPING_ESTIMATOR, BUTTON_SHIPPING_ESTIMATOR_ALT, 'data-toggle="modal" data-target="#shippingEstimatorModal"') ?>
    </div>
<?php
        require $template->get_template_dir('tpl_shipping_estimator.php', DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_shipping_estimator.php';
    }
?>
<!-- ** BEGIN PAYPAL EXPRESS CHECKOUT ** -->
<?php  // the tpl_ec_button template only displays EC option if cart contents >0 and value >0
    if (defined('MODULE_PAYMENT_PAYPALWPP_STATUS') && MODULE_PAYMENT_PAYPALWPP_STATUS === 'True') {
        require DIR_FS_CATALOG . DIR_WS_MODULES . 'payment/paypal/tpl_ec_button.php';
    }
?>
<!-- ** END PAYPAL EXPRESS CHECKOUT ** -->

<?php
    if (SHOW_SHIPPING_ESTIMATOR_BUTTON === '2') {
/**
 * load the shipping estimator code if needed
 */
        require DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php');
    }

    // -----
    // Enable extra content to be included, via additional header_php_*.php files present
    // in /includes/modules/pages/shopping_cart.
    //
    if (!empty($extra_content_shopping_cart) && is_array($extra_content_shopping_cart)) {
        foreach ($extra_content_shopping_cart as $extra_content) {
            require $extra_content;
        }
    }
} else {
?>
    <h1 id="shoppingCartDefault-pageHeading" class="pageHeading"><?= TEXT_CART_EMPTY ?></h1>
<?php
    // -----
    // Enable extra content to be included, via additional header_php_*.php files present
    // in /includes/modules/pages/shopping_cart.
    //
    if (!empty($extra_content_shopping_cart) && is_array($extra_content_shopping_cart)) {
        foreach ($extra_content_shopping_cart as $extra_content) {
            require $extra_content;
        }
    }
?>
<?php
    $show_display_shopping_cart_empty = $db->Execute(SQL_SHOW_SHOPPING_CART_EMPTY);
    foreach ($show_display_shopping_cart_empty as $next_section) {
        if ($next_section['configuration_key'] === 'SHOW_SHOPPING_CART_EMPTY_FEATURED_PRODUCTS') {
            /**
             * display the Featured Products Center Box
             */
            require $template->get_template_dir('tpl_modules_featured_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_products.php';
        }

        if ($next_section['configuration_key'] === 'SHOW_SHOPPING_CART_EMPTY_SPECIALS_PRODUCTS') {
            /**
             * display the Special Products Center Box
             */
            require $template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_specials_default.php';
        }

        if ($next_section['configuration_key'] === 'SHOW_SHOPPING_CART_EMPTY_NEW_PRODUCTS') {
            /**
             * display the New Products Center Box
             */
            require $template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_whats_new.php';
        }

        if ($next_section['configuration_key'] === 'SHOW_SHOPPING_CART_EMPTY_UPCOMING') {
            require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS);
        }
    }
}
?>
</div>
