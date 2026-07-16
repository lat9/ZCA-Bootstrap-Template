<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9 (cindy@vinosdefrutastropicales.com).
// Copyright (C) 2013-2026, Vinos de Frutas Tropicales.  All rights reserved.
//
// Last updated: OPC v2.4.2/Bootstrap v3.8.0
//
// -----
// Display shipping-address information **only if** the order contains at least one physical product (i.e. it's not virtual).
//
if ($is_virtual_order === true) {
    echo zen_draw_checkbox_field('shipping_billing', '1', false, 'id="shipping_billing" style="display: none;"');
} else {
    if (zen_config('CHECKOUT_ONE_ENABLE_SHIPPING_BILLING') === 'false') {
        echo zen_draw_checkbox_field('shipping_billing', '1', false, 'id="shipping_billing" style="display: none;"');
    } else {
?>
<div id="checkoutOneShippingFlag" class="custom-control custom-checkbox mb-3" style="display: none;">
    <?= zen_draw_checkbox_field('shipping_billing', '1', $shipping_billing, 'id="shipping_billing"') ?>
    <label class="custom-control-label checkboxLabel" for="shipping_billing"><?= TEXT_USE_BILLING_FOR_SHIPPING ?></label>
</div>
<?php
    }
?>
<div id="checkoutOneShipto" class="card mb-3">
    <h4 class="card-header"><?= TITLE_SHIPPING_ADDRESS ?></h4>
    <div class="card-body">
<?php
    $opc_address_type = 'ship';
    $opc_disable_address_change = !$editShippingButtonLink;
    require $template->get_template_dir('tpl_modules_opc_address_block.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_opc_address_block.php';

    if ($editShippingButtonLink === true) {
        $cancel_title = 'title="' . BUTTON_CANCEL_CHANGES_TITLE . '"';
        $save_title = 'title="' . BUTTON_SAVE_CHANGES_TITLE . '"';
        $show_add_address = $_SESSION['opc']->showAddAddressField();
        $parameters = ($show_add_address) ? '' : ' class="hiddenField"';
?>
        <div class="opc-buttons">
<?php
        if ($show_add_address === true) {
?>
            <div class="custom-control custom-checkbox">
                <?= zen_draw_checkbox_field("add_address['ship']", '1', false, 'id="opc-add-ship"' . $parameters) ?>
                <label class="checkboxLabel custom-control-label" for="opc-add-ship" title="<?= TITLE_ADD_TO_ADDRESS_BOOK ?>"><?= TEXT_ADD_TO_ADDRESS_BOOK ?></label>
            </div>
<?php
        }
?>
            <div class="d-flex justify-content-around mt-2">
                <div id="opc-ship-cancel"><?= zen_image_button(BUTTON_IMAGE_CANCEL, BUTTON_CANCEL_CHANGES_ALT, $cancel_title) ?></div>
                <div id="opc-ship-save"><?= zen_image_button(BUTTON_IMAGE_UPDATE, BUTTON_SAVE_CHANGES_ALT, $save_title) ?></div>
            </div>
        </div>
<?php 
    } 
?>
    </div>
</div>
<?php
}
