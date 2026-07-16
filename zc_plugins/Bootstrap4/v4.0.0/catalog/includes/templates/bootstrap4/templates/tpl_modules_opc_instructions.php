<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9 (cindy@vinosdefrutastropicales.com).
// Copyright (C) 2013-2017, Vinos de Frutas Tropicales.  All rights reserved.
//
// Last updated: OPC v2.4.2/Bootstrap v3.4.0
//
if (TEXT_CHECKOUT_ONE_INSTRUCTIONS !== '') {
?>
<div id="instructions" class="card mb-3">
<?php
    if (TEXT_CHECKOUT_ONE_INSTRUCTION_LABEL !== '') {
?>
    <h4 class="card-header"><?php echo TEXT_CHECKOUT_ONE_INSTRUCTION_LABEL; ?></h4>
<?php
    }
?>
    <div class="card-body">
        <p><?php echo TEXT_CHECKOUT_ONE_INSTRUCTIONS; ?></p>
    </div>
</div>
<?php
}
