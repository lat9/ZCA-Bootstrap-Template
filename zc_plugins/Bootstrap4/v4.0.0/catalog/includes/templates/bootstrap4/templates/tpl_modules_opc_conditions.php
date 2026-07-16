<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9 (cindy@vinosdefrutastropicales.com).
// Copyright (C) 2013-2026, Vinos de Frutas Tropicales.  All rights reserved.
//
// Last updated: OPC v2.4.4/Bootstrap v3.8.0
//
// -----
// Don't display the conditions' block unless there is a shipping method available
// and the payment-related address is validated.
//
if ($shipping_module_available === true && $display_payment_block === true) {
    if ($_SESSION['opc']->isGuestCheckout() && zen_config('DISPLAY_PRIVACY_CONDITIONS') === 'true') {
?>
<div id="privacy-div" class="card mb-3">
    <h4 class="card-header"><?= TABLE_HEADING_PRIVACY_CONDITIONS ?></h4>
    <div class="card-body">
        <div class="information mb-2"><?= TEXT_PRIVACY_CONDITIONS_DESCRIPTION ?></div>
        <div class="custom-control custom-checkbox">
            <?= zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy" required') ?>
            <label class="custom-control-label checkboxLabel" for="privacy"><?= TEXT_PRIVACY_CONDITIONS_CONFIRM ?></label>
        </div>
    </div>
</div>
<?php
    }

    if (zen_config('DISPLAY_CONDITIONS_ON_CHECKOUT') === 'true') {
?>
<div id="conditions-div" class="card mb-3">
    <h4 class="card-header"><?= TABLE_HEADING_CONDITIONS ?></h4>
    <div class="card-body">
        <div class="mb-2"><?= TEXT_CONDITIONS_DESCRIPTION ?></div>
        <div class="custom-control custom-checkbox">
            <?= zen_draw_checkbox_field('conditions', '1', false, 'id="conditions" required') ?>
            <label class="custom-control-label checkboxLabel" for="conditions"><?= TEXT_CONDITIONS_CONFIRM ?></label>
        </div>
    </div>
</div>
<?php
    }
}
