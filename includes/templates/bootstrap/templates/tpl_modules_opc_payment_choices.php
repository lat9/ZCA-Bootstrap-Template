<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9
// Copyright (C) 2013-2025, Vinos de Frutas Tropicales.  All rights reserved.
//
// Note: This formatting has changed in v2.0.0+ of OPC, in support of the guest-checkout path.
// The $enabled_payment_modules variable must be handled using foreach, since numerical keys
// might have been removed if the payment method is not supported for guest-checkout!!
//
// Last updated: OPC v2.4.2/Bootstrap v3.7.9
//
// -----
// Don't display the payment-method block unless there is a shipping method available
// and the payment-related address is validated.
//
if ($shipping_module_available === true && $display_payment_block === true) {
?>
<div id="checkoutPaymentMethod" class="card mb-3">
    <h4 class="card-header"><?php echo TABLE_HEADING_PAYMENT_METHOD; ?></h4>
    <div class="card-body">
<?php 
    // ** BEGIN PAYPAL EXPRESS CHECKOUT **
    if (!$payment_modules->in_special_checkout()) {
    // ** END PAYPAL EXPRESS CHECKOUT ** 
        if (SHOW_ACCEPTED_CREDIT_CARDS != '0') {
            if (SHOW_ACCEPTED_CREDIT_CARDS == '1') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
          
            } elseif (SHOW_ACCEPTED_CREDIT_CARDS == '2') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
            }
        } 

        $selection = $enabled_payment_modules;
        $num_selections = count($selection);

        // -----
        // The 'base' bootstrap classes force a radio-button based on the classes associated with a
        // selection's label and its input (even if it's hidden).  If only one payment method is available,
        // don't use those classes as they result in a 'rogue' unclickable radio button.
        //
        $payment_div_class = '';
        $payment_label_class = '';
        if ($num_selections > 1) {
            $payment_div_class = ' custom-radio';
            $payment_label_class = ' class="custom-control-label radioButtonLabel"';
?>
        <p class="important"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></p>
<?php
        } elseif ($num_selections == 0) {
?>
        <p class="important"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></p>

<?php
        }

        $radio_buttons = 0;

        foreach ($selection as $current_method) {
?>
        <div class="custom-control<?php echo $payment_div_class; ?> mb-2">
<?php
            $payment_id = $current_method['id'];
            if ($num_selections > 1) {
                if (empty($current_method['noradio'])) {
                    $is_selected = (isset($_SESSION['payment']) && $payment_id == $_SESSION['payment']);
                    echo zen_draw_radio_field('payment', $payment_id, $is_selected, 'id="pmt-' . $payment_id . '"');
                }
            } else {
                echo zen_draw_hidden_field('payment', $payment_id, 'id="pmt-' . $payment_id . '"');
            }
?>
            <label for="pmt-<?php echo $payment_id; ?>"<?php echo $payment_label_class; ?>><?php echo $current_method['module']; ?></label>
        </div>
<?php
            if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS === 'true' && $payment_id === 'cod') {
                if (!defined('TEXT_INFO_COD_FEES')) {
                    // -----
                    // Need to load the 'ot_cod' language file, since it's not pre-loaded during AJAX operations.
                    //
                    $ot_cod_lang_file = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/modules/order_total/', 'ot_cod.php', 'false');
                    if (@file_exists($ot_cod_lang_file)) {
                        require $lang_file;
                    } else {
                        define('TEXT_INFO_COD_FEES', '<strong>Note:</strong> COD fees may apply');
                    }
                }
?>
        <div class="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
<?php
            }

            if (!empty($current_method['text'])) {
?>
        <div class="ccinfoText"><?= $current_method['text'] ?></div>
<?php
            }

            if (isset($current_method['error'])) {
?>
        <div><?php echo $current_method['error']; ?></div>

<?php
            } elseif (isset($current_method['fields']) && is_array($current_method['fields'])) {
?>
        <div class="ccinfo">
<?php
                foreach ($current_method['fields'] as $current_field) {
                    // -----
                    // Some payment methods provide a 'field' without a 'title'; conditionally include
                    // the requested label so long a the title exists and its non-blank (i.e. not 'empty').
                    //
                    if (!empty($current_field['title'])) {
?>
            <label <?php echo (isset($current_field['tag']) ? 'for="' . $current_field['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo $current_field['title']; ?></label>
<?php
                    }

                    // -----
                    // The 'field' value is **always** required; output it.
                    //
                    echo $current_field['field']; 
                }
?>
        </div>
<?php
            }
            $radio_buttons++;
        }
    // ** BEGIN PAYPAL EXPRESS CHECKOUT **
    } else {
?>
        <p><?php echo ${$_SESSION['payment']}->title; ?></p>
        <input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" />
<?php
    }
    // ** END PAYPAL EXPRESS CHECKOUT **
?>
    </div>
</div>
<?php
}  //-Shipping-method available, display payment block.
