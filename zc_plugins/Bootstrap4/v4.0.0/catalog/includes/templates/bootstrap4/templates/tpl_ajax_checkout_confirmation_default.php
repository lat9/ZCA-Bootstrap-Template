<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.8.0
 *
 * Loaded automatically by index.php?main_page=checkout_confirmation.
 * Displays final checkout details, cart, payment and shipping info details.
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2024 Jan 19 Modified in v2.0.0-alpha1 $
 */
?>
<div id="checkoutConfirmationDefault" class="centerColumn">
    <div class="progress">
      <div class="progress-bar" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">75%</div>
    </div>

    <h1 id="checkoutConfirmationDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>
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
            <h4 id="billingAddress-card-header" class="card-header">
                <?= HEADING_BILLING_ADDRESS ?>
            </h4>

            <div id="billingAddress-card-body" class="card-body p-3">
                <div class="card-deck">
                    <div id="billToAddress-card" class="card">
                        <div id="billToAddress-card-body" class="card-body">
                            <address>
                                <?= zen_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br>') ?>
                            </address>
<?php
if (!$flagDisablePaymentAddressChange) {
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
<?php
  $class = &$_SESSION['payment'];
?>
                        <h4 id="paymentMethod-card-header" class="card-header">
                            <?= HEADING_PAYMENT_METHOD ?>
                        </h4>
                        <div id="paymentMethod-card-body" class="card-body">
                            <h4 id="paymentMethod-paymentTitle">
                                <?= $GLOBALS[$class]->title ?>
                            </h4>
<?php
if (is_array($payment_modules->modules)) {
    if ($confirmation = $payment_modules->confirmation()) {
?>
                            <div id="paymentMethod-content" class="content">
                                <?= $confirmation['title'] ?>
                            </div>
<?php
    }
    if (!empty($confirmation['fields'])) {
?>
                            <div id="paymentMethod-content-one" class="content">
<?php
        for ($i = 0, $n = count($confirmation['fields']); $i < $n; $i++) {
?>
                                <div><?= $confirmation['fields'][$i]['title'] ?></div>
                                <div><?= $confirmation['fields'][$i]['field'] ?></div>
<?php
        }
?>
                            </div>
<?php
    }
}
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php
if ($_SESSION['sendto'] != false) {
?>
        <div id="deliveryAddress-card" class="card mb-3">
            <h4 id="deliveryAddress-card-header" class="card-header">
                <?= HEADING_DELIVERY_ADDRESS ?>
            </h4>
            <div id="deliveryAddress-card-body" class="card-body p-3">
                <div class="card-deck">
                    <div id="shipToAddress-card" class="card">
                        <div id="shipToAddress-card-body" class="card-body">
                            <address>
                                <?= zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>') ?>
                            </address>
    
                            <div id="shipToAddress-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                                <?= zca_button_link($editShippingButtonLink, BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                            </div>
                        </div>
                    </div>
<?php
    if ($order->info['shipping_method']) {
?>
                    <div id="shippingMethod-card" class="card">
                        <h4 id="shippingMethod-card-header" class="card-header">
                            <?= HEADING_SHIPPING_METHOD ?>
                        </h4>
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
            <h4 id="orderComment-card-header" class="card-header">
                <?= HEADING_ORDER_COMMENTS ?>
            </h4>
            <div id="orderComment-card-body" class="card-body p-3">
                <?= (empty($order->info['comments']) ? NO_COMMENTS_TEXT : nl2br(zen_output_string_protected($order->info['comments']), false) . zen_draw_hidden_field('comments', $order->info['comments'])) ?>

                <div id="orderComment-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                    <?= zca_button_link(zen_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'), BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                </div>
            </div>
        </div>

        <div id="cartContents-card" class="card mb-3">
            <h4 id="cartContents-card-header" class="card-header">
                <?= HEADING_PRODUCTS ?>
            </h4>
            <div id="cartContents-card-body" class="card-body p-3">
<?php
if ($flagAnyOutOfStock) {
    if (STOCK_ALLOW_CHECKOUT === 'true') {
?>
                <div class="alert alert-danger" role="alert"><?= OUT_OF_STOCK_CAN_CHECKOUT ?></div>
<?php
    } else {
?>
                <div class="alert alert-danger" role="alert"><?= OUT_OF_STOCK_CANT_CHECKOUT ?></div>
<?php
    }
}
?>
                <div class="table-responsive">
<?php
// -----
// Determine if more than one 'tax_group' is associated with the order. 
//
$tax_column_present = (count($order->info['tax_groups']) > 1);
?>
                    <table id="shoppingCartDefault-cartTableDisplay" class="cartTableDisplay table table-bordered table-striped">
                        <tr>
                            <th scope="col" id="cartTableDisplay-qtyHeading"><?= TABLE_HEADING_QUANTITY ?></th>
                            <th scope="col" id="cartTableDisplay-productsHeading"><?= TABLE_HEADING_PRODUCTS ?></th>
<?php
// If there are tax groups, display the tax columns for price breakdown
if ($tax_column_present) {
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
                            <td class="qtyCell"><?= $order->products[$i]['qty'] ?>&nbsp;x</td>
                            <td class="productsCell"><?= $order->products[$i]['name'] ?>
<?php
    if (!empty($stock_check[$i])) {
        echo $stock_check[$i];
    }

    // if there are attributes, loop thru them and display one per line
    if (isset($order->products[$i]['attributes']) && count($order->products[$i]['attributes']) > 0 ) {
?>
                                <div class="productsCell-attributes">
                                    <ul>
<?php
        foreach ($order->products[$i]['attributes'] as $next_attrib) {
?>
                                        <li>
                                            <?= $next_attrib['option'] . ': ' . nl2br(zen_output_string_protected($next_attrib['value']), false) ?>
                                        </li>
<?php
        } // end loop
?>
                                    </ul>
                                </div>
<?php
    } // endif attribute-info
?>
                            </td>
<?php
    // display tax info if exists
    if ($tax_column_present === true) {
?>
                            <td class="taxCell">
                                <?= zen_display_tax_value($order->products[$i]['tax']) ?>%
                            </td>
<?php
    }
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

if (zen_config('MODULE_ORDER_TOTAL_INSTALLED')) {
    $_SESSION['zca_bootstrap_ot_colspan'] = ($tax_column_present === true) ? '3' : '2';
    $order_totals = $order_total_modules->process();
    $order_total_modules->output();
}
?>
                    </table>
                </div>

                <div id="cartContents-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                    <?= zca_button_link(zen_href_link(FILENAME_SHOPPING_CART, '', 'SSL'), BUTTON_EDIT_SMALL_ALT, 'small_edit') ?>
                </div>
            </div>
        </div>
    </div>


    <?= zen_draw_form('checkout_confirmation', $form_action_url, 'post', 'id="checkout_confirmation" onsubmit="submitonce();"') ?>
    <div id="processButtonHolder"></div>
<?php
if (is_array($payment_modules->modules)) {
    $processButtonOptions = $payment_modules->process_button_ajax();
    if (isset($processButtonOptions['ccFields']) && count($processButtonOptions['ccFields'])> 0 ) {
        foreach ($processButtonOptions['ccFields'] as $newField => $oldField) {
            echo zen_draw_hidden_field($newField, '');
            if (!is_array($oldField)) {
?>
<script>
$(document).ready(function () {
    $(":input[name='<?= $newField ?>']").val($(":input[name='<?= $oldField ?>']").val());
});
</script>
<?php
            } else {
?>
<script>
    $(document).ready(function () {
     var oldField = window['<?= $oldField['name'] ?>'](<?= $oldField['args'] ?>);
     $(":input[name='<?= $newField ?>']").val(oldField);
    });
</script>
<?php
            }
        }
    }
    if (count($processButtonOptions['extraFields'] ?? []) > 0 ) {
        foreach ($processButtonOptions['extraFields'] as $fieldName => $fieldValue) {
           echo zen_draw_hidden_field($fieldName, $fieldValue);
        }
    }
}

// Add shipping-module "extra" variables so they get transported to the checkout_process page.
if (isset($_SESSION['shipping']['extras']) && is_array ($_SESSION['shipping']['extras'])) {
    [$module, $method] = explode ('_', $_SESSION['shipping']['id']);
    foreach ($_SESSION['shipping']['extras'] as $varname => $value) {
        echo zen_draw_hidden_field ($module . '_' . $varname, $value) . PHP_EOL;
    }
}

// -----
// Starting with the as-delivered Zen Cart 1.5.8a, styling has been removed from various checkout language
// constants.  To keep the same 'look' regardless whether the store's value contains a <strong> tag, strip
// that tag and its end-tag from the constant and output the tag here.
//
$title_continue_checkout = str_replace(['<strong>', '</strong>'], '', TITLE_CONTINUE_CHECKOUT_PROCEDURE);
?>
    <div id="checkoutConfirmationDefault-btn-toolbar" class="btn-toolbar justify-content-between confirm-order" role="toolbar">
        <strong><?= $title_continue_checkout ?></strong><br><?= TEXT_CONTINUE_CHECKOUT_PROCEDURE ?>
        <?= zen_image_submit(BUTTON_IMAGE_CONFIRM_ORDER, BUTTON_CONFIRM_ORDER_ALT, 'name="btn_submit" id="btn_submit"') ?>
    </div>

    <?= '</form>' ?>
</div>
