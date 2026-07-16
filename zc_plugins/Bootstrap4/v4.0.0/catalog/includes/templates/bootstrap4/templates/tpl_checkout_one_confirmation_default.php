<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9 (cindy@vinosdefrutastropicales.com).
// Copyright (C) 2013-2026, Vinos de Frutas Tropicales.  All rights reserved.
//
// Last updated: OPC v2.6.0/Bootstrap v3.8.0
//
// -----
// The "display: none;" on the loading icon enables that to "not display" if javascript is disabled in the customer's browser.  The
// page's jscript_main.php handling will "show" that when javascript is enabled and we're not forcing the confirmation-page's display.
//
?>
<div class="centerColumn" id="checkoutOneConfirmation<?= ($confirmation_required === true) ? 'Display' : '' ?>">
<?php
// -----
// If the current payment method requires that the confirmation page be displayed ...
//
if ($confirmation_required === true) {
?>
    <h1 id="checkoutConfirmDefaultHeading"><?= HEADING_TITLE ?></h1>
<?php
    if ($messageStack->size('redemptions') > 0) {
        echo $messageStack->output('redemptions');
    }
    if ($messageStack->size('checkout_confirmation') > 0) {
        echo $messageStack->output('checkout_confirmation');
    }
    if ($messageStack->size('checkout') > 0) {
        echo $messageStack->output('checkout');
    }
?>

    <div class="card-columns">
        <div id="billingAddress-card" class="card mb-3">
            <h4 id="billingAddress-card-header" class="card-header"><?= HEADING_BILLING_ADDRESS ?></h4>
            <div id="billingAddress-card-body" class="card-body p-3">
                <div class="card-deck">
                    <div id="billToAddress-card" class="card">
                        <div id="billToAddress-card-body" class="card-body">
                            <address><?= zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>') ?></address>
<?php 
    if ($flagDisablePaymentAddressChange === false) { 
?>
                            <div id="billToAddress-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                                <?= zca_button_link(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'), BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                            </div>
<?php 
    } 
?>
                        </div>
                    </div>

                    <div id="paymentMethod-card" class="card">
                        <h4 id="paymentMethod-card-header" class="card-header"><?= HEADING_PAYMENT_METHOD ?></h4>
                        <div id="paymentMethod-card-body" class="card-body">
                            <h4 id="paymentMethod-paymentTitle"><?= $payment_title ?></h4>
<?php
    if (!empty($confirmation_title)) {
?>
                            <div id="paymentMethod-content" class="content"><?= $confirmation_title ?></div>
<?php
    }
    if (!empty($confirmation_fields)) {
?>
                            <div id="paymentMethod-content-one" class="content">
<?php
        foreach ($confirmation_fields as $next_field) {
?>
                                <div><?= $next_field['title'] ?></div>
                                <div><?= $next_field['field'] ?></div>
<?php
        }
?>
                            </div>
<?php
    }
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
    if ($_SESSION['sendto'] !== false) {
?>
        <div id="deliveryAddress-card" class="card mb-3">
            <h4 id="deliveryAddress-card-header" class="card-header"><?= HEADING_DELIVERY_ADDRESS ?></h4>
            <div id="deliveryAddress-card-body" class="card-body p-3">
                <div class="card-deck">
                    <div id="shipToAddress-card" class="card">
                        <div id="shipToAddress-card-body" class="card-body">
                            <address><?= zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>') ?></address>
                            <div id="shipToAddress-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                                <?= zca_button_link($editShippingButtonLink, BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                            </div>

                        </div>
                    </div>
<?php
        if (!empty($order->info['shipping_method'])) {
?>
                    <div id="shippingMethod-card" class="card">
                        <h4 id="shippingMethod-card-header" class="card-header"><?= HEADING_SHIPPING_METHOD ?></h4>
                        <div id="shippingMethod-card-body" class="card-body">
                            <h4><?= $order->info['shipping_method'] ?></h4>
                        </div>
                    </div>
<?php
        }
?>
                </div>
            </div>
        </div>
<?php
    }
?>
        <div id="orderComment-card" class="card mb-3">
            <h4 id="orderComment-card-header" class="card-header"><?= HEADING_ORDER_COMMENTS ?></h4>
            <div id="orderComment-card-body" class="card-body p-3">
                <?= empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments']), false) ?>
                <?= zen_draw_hidden_field('comments', zen_output_string_protected($order->info['comments'])) ?>

                <div id="orderComment-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                    <?= zca_button_link(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'), BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                </div>
            </div>
        </div>

        <div id="cartContents-card" class="card mb-3">
            <h4 id="cartContents-card-header" class="card-header"><?= HEADING_PRODUCTS ?></h4>
            <div id="cartContents-card-body" class="card-body p-3">
<?php  
    if ($flagAnyOutOfStock) { 
        if (zen_config('STOCK_ALLOW_CHECKOUT') === 'true') {  
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
<?php
    // -----
    // Determine if more than one 'tax_group' is associated with the order.  If not, display
    // the 'Products' column in two columns to ensure alignment of the order-totals' values.
    //
    $tax_column_present = (count($order->info['tax_groups']) > 1);
?>
                    <table id="shoppingCartDefault-cartTableDisplay" class="cartTableDisplay table table-bordered table-striped">
                        <tr>
                            <th scope="col" id="cartTableDisplay-qtyHeading"><?= TABLE_HEADING_QUANTITY ?></th>
                            <th scope="col" id="cartTableDisplay-productsHeading"><?= TABLE_HEADING_PRODUCTS ?></th>
<?php
  // If there are tax groups, display the tax columns for price breakdown
    if ($tax_column_present === true) {
?>
                            <th scope="col" id="cartTableDisplay-taxHeading"><?= HEADING_TAX ?></th>
<?php
    }
?>
                            <th scope="col" id="cartTableDisplay-totalHeading"><?= TABLE_HEADING_TOTAL ?></th>
                        </tr>
<?php 
// now loop thru all products to display quantity and price
    for ($i = 0, $n = count($order->products); $i < $n; $i++) { 
?>
                        <tr>
                            <td  class="qtyCell"><?= $order->products[$i]['qty'] ?>&nbsp;x</td>
                            <td class="productsCell"><?= $order->products[$i]['name'] . ((!empty($stock_check[$i])) ? $stock_check[$i] : '') ?>
<?php 
        // if there are attributes, loop thru them and display one per line
        if (isset($order->products[$i]['attributes']) && count($order->products[$i]['attributes']) > 0 ) {
?>
                                <div class="productsCell-attributes">
                                    <ul>
<?php
            foreach ($order->products[$i]['attributes'] as $next_attribute) {
?>
                                        <li><?= $next_attribute['option'] . ': ' . nl2br(zen_output_string_protected($next_attribute['value']), false) ?></li>
<?php
            } // end loop
?>
                                    </ul>
                                </div>
<?php
        } // endif attribute-info
    
        if (isset ($posStockMessage)) {
            echo '<br>' . $posStockMessage[$i];
        }
?>
                            </td>
<?php 
        // display tax info if exists
        if ($tax_column_present)  { 
?>
                            <td class="taxCell"><?= zen_display_tax_value($order->products[$i]['tax']) ?>%</td>
<?php    
        }  // endif tax info display  
?>
                            <td class="totalCell">
<?php
        echo $currencies->display_price($order->products[$i]['final_price'], $order->products[$i]['tax'], $order->products[$i]['qty']);
        if ($order->products[$i]['onetime_charges'] != 0 ) {
            echo '<br> ' . $currencies->display_price($order->products[$i]['onetime_charges'], $order->products[$i]['tax'], 1);
        }
?>
                            </td>
                        </tr>
<?php  
    }  // end for loopthru all products 

    // -----
    // Some payment modules (notably firstdata_hco) make use of the $order_totals object which has been set by the page's header processing.
    //
    if (zen_config('MODULE_ORDER_TOTAL_INSTALLED')) {
        if ($confirmation_required === true) {
            $order_total_modules->output();
        }
    }
?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
}  //-Display confirmation information, if required

// -----
// Now, display the form that actually submits this order.
//
echo zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation"' . ($confirmation_required ? ' onsubmit="submitonce();"' : ''));
?>
    <div id="checkoutOneConfirmationButtons">
<?php
// -----
// Add the selected payment module's final HTML to the display.
//
echo $payment_process_button;
?>
        <div class="text-right"><?= zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ?></div>
    </div>
<?php
echo '</form>';
?>
    <div id="checkoutOneConfirmationLoading" style="display: none;">
        <?= 
            ((CHECKOUT_ONE_CONFIRMATION_INSTRUCTIONS === '') ? '' : (CHECKOUT_ONE_CONFIRMATION_INSTRUCTIONS . '<br><br>')) . 
            zen_image($template->get_template_dir(CHECKOUT_ONE_CONFIRMATION_LOADING, DIR_WS_TEMPLATE, $current_page_base, 'images') . '/' . CHECKOUT_ONE_CONFIRMATION_LOADING, CHECKOUT_ONE_CONFIRMATION_LOADING_ALT) ?>
    </div>
</div>
