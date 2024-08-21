<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9 (cindy@vinosdefrutastropicales.com).
// Copyright (C) 2018-2024, Vinos de Frutas Tropicales.  All rights reserved.
//
// Adapted from the like-named page handling with the following history:
// - Integrated COWAA v1.0 (@davewest)
//
// Last updated: OPC v2.5.4/Bootstrap v3.7.3
//
// -----
// v3.7.3 and later, constants now have a 'ORDER_STATUS_' prefix to align with
// the zc210+ incorporation!
//
// Note that these definition-overrides can be dropped once Bootstrap requires zc210+.
//
zen_define_default('ORDER_STATUS_DISPLAY_PAYMENT', true);
zen_define_default('ORDER_STATUS_DISPLAY_SHIPPING', true);
zen_define_default('ORDER_STATUS_DISPLAY_PRODUCTS', true);

// -----
// Determine which blocks are to be displayed; they're currently set by
// init_includes/init_non_db_settings.php.
//
$display_payment = in_array(ORDER_STATUS_DISPLAY_PAYMENT, ['true', true]);
$display_shipping = in_array(ORDER_STATUS_DISPLAY_SHIPPING, ['true', true]);
$display_products = in_array(ORDER_STATUS_DISPLAY_PRODUCTS, ['true', true]);

?>
<div class="centerColumn" id="orderStatus">
    <h1 id="orderHistoryHeading"><?= HEADING_TITLE ?></h1>
<?php 
if ($messageStack->size('order_status') > 0) {
    echo $messageStack->output('order_status');
}

if (isset($order)) {
?>
    <div class="card mb-3">
        <h2 id="orderHistoryDetailedOrder" class="card-header">
            <?= SUB_HEADING_TITLE . ORDER_HEADING_DIVIDER . sprintf(HEADING_ORDER_NUMBER, $_POST['order_id']) ?>
        </h2>
        <div class="card-body">
            <div class="text-right"><?= HEADING_ORDER_DATE . ' ' . zen_date_long($order->info['date_purchased']) ?></div>
<?php 
    if ($display_products === true) { 
        $display_tax_column = (count($order->info['tax_groups']) > 1);
?>
            <div class="table-responsive">
                <table id="orderHistoryHeading" class="table table-bordered table-striped">
                    <tr class="tableHeading">
                        <th scope="col" id="myAccountQuantity"><?= HEADING_QUANTITY ?></th>
                        <th scope="col" id="myAccountProducts"><?= HEADING_PRODUCTS ?></th>
<?php
        if ($display_tax_column === true) {
?>
                        <th scope="col" id="myAccountTax"><?= HEADING_TAX ?></th>
<?php
        }
?>
                        <th scope="col" id="myAccountTotal"><?= HEADING_TOTAL ?></th>
                    </tr>
<?php
        $currency = $order->info['currency'];
        $currency_value = $order->info['currency_value'];
        foreach ($order->products as $current_product) {
?>
                    <tr>
                        <td class="accountQuantityDisplay"><?= $current_product['qty'] . QUANTITY_SUFFIX ?></td>
                        <td class="accountProductDisplay"><?= $current_product['name'];

            if (isset($current_product['attributes']) && is_array($current_product['attributes']) && count($current_product['attributes']) > 0) {
?>
                            <ul id="orderAttribsList">
<?php
                foreach ($current_product['attributes'] as $current_attribute) {
?>
                                <li>
                                    <?= $current_attribute['option'] . TEXT_OPTION_DIVIDER . nl2br(zen_output_string_protected($current_attribute['value']), false) ?>
                                </li>
<?php
                }
?>
                            </ul>
<?php
            }
?>
                        </td>
<?php
            $product_tax = $current_product['tax'];
            if ($display_tax_column === true) {
?>
                        <td class="accountTaxDisplay"><?= zen_display_tax_value($product_tax) . '%' ?></td>
<?php
            }
?>
                        <td class="accountTotalDisplay">
                            <?= $currencies->format(zen_add_tax($current_product['final_price'], $product_tax) * $current_product['qty'], true, $currency, $currency_value) . ($current_product['onetime_charges'] != 0 ? '<br>' . $currencies->format(zen_add_tax($current_product['onetime_charges'], $product_tax), true, $currency, $currency_value) : '') ?>
                        </td>
                    </tr>
<?php
        }

        foreach ($order->totals as $current_ot) {
?>
                    <tr>
                        <td colspan="<?= ($display_tax_column === true) ? '3' : '2' ?>" class="ot-title">
                            <?= $current_ot['title'] ?>
                        </td>
                        <td class="ot-text"><?= $current_ot['text'] ?></td>
                    </tr>
<?php
        }
?>
                </table>
            </div>
<?php 
    }

    // -----
    // Displays any downloads associated with the order.  The base processing (from the zc156+ versions) will
    // search based on an email address, if set into the session.
    //
    // We'll set the order's email address into the session for that module's processing and then remove
    // that value, once finished.
    //
    if (DOWNLOAD_ENABLED === 'true') {
        require $template->get_template_dir('tpl_modules_downloads.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_downloads.php';
    }

    // -----
    // Display the order's status information.
    //
    if (!empty($statusArray)) {
?>
            <h3 class="text-center"><?= HEADING_ORDER_HISTORY ?></h3>
            <table id="myAccountOrdersStatus" class="table table-bordered table-striped">
                <tr class="tableHeading">
                    <th scope="col" id="myAccountStatusDate"><?= TABLE_HEADING_STATUS_DATE ?></th>
                    <th scope="col" id="myAccountStatus"><?= TABLE_HEADING_STATUS_ORDER_STATUS ?></th>
                    <th scope="col" id="myAccountStatusComments"><?= TABLE_HEADING_STATUS_COMMENTS ?></th>
                </tr>
<?php
        // -----
        // Only the **first** order comment -- the one provided by the customer -- is "protected", i.e. any HTML tags
        // display as the tag itself without the HTML being formatted.  All others have been provided by an
        // admin or a trusted 3rd-party (like a payment method) and are trusted not to have 'naughty' HTML.
        //
        $protected = true;
        foreach ($statusArray as $statuses) {
?>
                <tr>
                    <td><?= zen_date_short($statuses['date_added']) ?></td>
                    <td><?= $statuses['orders_status_name'] ?></td>
                    <td><?= (empty($statuses['comments'])) ? '&nbsp;' : nl2br(zen_output_string($statuses['comments'], false, $protected), false) ?></td>
                </tr>
<?php
            $protected = false;
        }
?>
            </table>
<?php 
    }

    $display_card_group = (($display_shipping === true && !empty($order->info['shipping_method'])) || $display_payment === true);
    if ($display_card_group === true) {
?>
            <div class="card-deck row">
<?php
        if ($display_shipping === true && !empty($order->info['shipping_method'])) {
?>
                <div id="myAccountShipInfo" class="card col-md-6 p-0">
                    <h5 class="card-header"><?= HEADING_SHIPPING_METHOD ?></h5>
                    <div class="card-body">
                        <div><?= $order->info['shipping_method'] ?></div>
                    </div>
                </div>
<?php 
        }

        if ($display_payment === true) { 
?>
                <div id="myAccountPaymentInfo" class="card col-md-6 p-0">
                    <h5 class="card-header"><?= HEADING_PAYMENT_METHOD ?></h5>
                    <div class="card-body">
                        <div><?= $order->info['payment_method'] ?></div>
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
} 

echo zen_draw_form('order_status', zen_href_link(FILENAME_ORDER_STATUS, 'action=status', $request_type), 'post');
?>
    <div class="card">
        <h2 class="card-header"><?= HEADING_TITLE ?></h2>
        <div class="card-body">
            <p><?= TEXT_LOOKUP_INSTRUCTIONS ?></p>
            <div class="form-group row">
                <label class="inputLabel" for="order_id" class="col-sm-2 col-form-label"><?= ENTRY_ORDER_NUMBER ?></label>
                <div class="col-sm-2">
                    <?= zen_draw_input_field('order_id', $orderID, 'size="10" id="order_id" required', 'number') ?> 
                </div>

                <label class="inputLabel" for="query_email_address" class="col-sm-2 col-form-label"><?= ENTRY_EMAIL ?></label>
                <div class="col-sm-6">
                    <?= zen_draw_input_field('query_email_address', $query_email_address, 'size="35" id="query_email_address" required', 'email') ?>
                </div>
            </div>

            <?= zen_draw_input_field($spam_input_name, '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"') ?>
            <?= $extra_validation_html ?>

            <div class="text-right"><?= zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT) ?></div>
        </div>
    </div>
<?= '</form>' ?>
</div>
