<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.7.0
 *
 * Loaded automatically by index.php?main_page=checkout_payment.<br />
 * Displays the allowed payment modules, for selection by customer.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Oct 29 Modified in v1.5.7a $
 */
?>
<?php echo $payment_modules->javascript_validation(); ?>
<div id="checkoutPayment" class="centerColumn">
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
    </div>

    <?php echo zen_draw_form('checkout_payment', zen_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post'); ?>
    <?php echo zen_draw_hidden_field('action', 'submit'); ?>

        <h1 id="checkoutPaymentDefault-pageHeading" class="pageHeading"><?php echo HEADING_TITLE; ?></h1>
<?php
if ($messageStack->size('redemptions') > 0) {
    echo $messageStack->output('redemptions');
}
if ($messageStack->size('checkout') > 0) {
    echo $messageStack->output('checkout');
}
if ($messageStack->size('checkout_payment') > 0) {
    echo $messageStack->output('checkout_payment');
}

// ** BEGIN PAYPAL EXPRESS CHECKOUT **
if (!$payment_modules->in_special_checkout()) {
// ** END PAYPAL EXPRESS CHECKOUT **
?>
        <div class="card-columns">

            <div id="billingAddress-card" class="card mb-3">
                <h4 class="card-header"><?php echo TITLE_BILLING_ADDRESS; ?></h4>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="billToAddress col-sm-5">
                            <address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'); ?></address>
                        </div>
                        <div class="col-sm-7">
                            <?php echo TEXT_SELECTED_BILLING_DESTINATION; ?>
<?php
    if (MAX_ADDRESS_BOOK_ENTRIES >= 2) {
?>
                            <div class="btn-toolbar justify-content-end mt-3" role="toolbar">
                                <?php echo zca_button_link(zen_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'), BUTTON_CHANGE_ADDRESS_ALT, 'button_change_address'); ?>
                            </div>
<?php
    }
?>
                        </div>
                    </div>
                </div>
            </div>

<?php
// ** BEGIN PAYPAL EXPRESS CHECKOUT **
}
// ** END PAYPAL EXPRESS CHECKOUT ** ?>

            <div id="yourTotal-card" class="card mb-3">
                <h4 class="card-header"><?php echo TEXT_YOUR_TOTAL; ?></h4>
                <div class="card-body p-3">
<?php
    if (MODULE_ORDER_TOTAL_INSTALLED) {
        $order_totals = $order_total_modules->process();

        // -----
        // "Unset" the session-based variable that lets tpl_modules_order_totals.php 'know'
        // how many columns are taken up by the products' display ... since no product
        // information is displayed on this page.
        //
        unset($_SESSION['zca_bootstrap_ot_colspan']);
?>
                    <div class="table-responsive">
                        <table class="cartTableDisplay table table-bordered table-striped" role="presentation">
                            <?php $order_total_modules->output(); ?>
                        </table>
                    </div>
<?php
    }
?>
                </div>
            </div>

<?php
    $selection =  $order_total_modules->credit_selection();
    if (count($selection) > 0) {
        for ($i = 0, $n = count($selection); $i < $n; $i++) {
            if (isset($_GET['credit_class_error_code']) && ($_GET['credit_class_error_code'] == (isset($selection[$i]['id'])) ? $selection[$i]['id'] : 0)) {
?>
            <div class="alert alert-danger" role="alert"><?php echo zen_output_string_protected($_GET['credit_class_error']); ?></div>
<?php
            }
            for ($j = 0, $n2 = (isset($selection[$i]['fields']) ? count($selection[$i]['fields']) : 0); $j < $n2; $j++) {
?>
            <div class="card mb-3">
                <h4 class="card-header"><?php echo $selection[$i]['module']; ?></h4>
                <div class="card-body p-3">
                    <?php echo $selection[$i]['redeem_instructions']; ?>
<?php
                if (isset($selection[$i]['checkbox'])) {
?>
                    <div><?php echo $selection[$i]['checkbox']; ?></div>
<?php
                }
?>

<?php
                if (strpos($selection[$i]['fields'][$j]['field'], 'type="checkbox"') !== false) {   // intercept checkbox selections
?>
                    <div class="custom-control custom-checkbox">
                      <?php echo $selection[$i]['fields'][$j]['field']; ?>
                      <label class="custom-control-label"<?php echo isset($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                    </div>
<?php
                } elseif (strpos($selection[$i]['fields'][$j]['field'], 'type="radio"') !== false) {    // intercept radio selections
?>
                    <div class="custom-control custom-radio">
                      <?php echo $selection[$i]['fields'][$j]['field']; ?>
                      <label class="custom-control-label"<?php echo isset($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                    </div>
<?php
                } else {
?>
                    <label class="inputLabel"<?php echo ($selection[$i]['fields'][$j]['tag']) ? ' for="'.$selection[$i]['fields'][$j]['tag'].'"': ''; ?>><?php echo $selection[$i]['fields'][$j]['title']; ?></label>
                    <?php echo $selection[$i]['fields'][$j]['field']; ?>
<?php
                }
?>
                </div>
            </div>
<?php
            }
        }
    }
// ** BEGIN PAYPAL EXPRESS CHECKOUT **
    if (!$payment_modules->in_special_checkout()) {
// ** END PAYPAL EXPRESS CHECKOUT **
?>
            <div id="paymentMethod-card" class="card mb-3">
                <h4 class="card-header"><?php echo HEADING_PAYMENT_METHOD; ?></h4>
                <div class="card-body p-3">
<?php
        if (SHOW_ACCEPTED_CREDIT_CARDS !== '0') {
            if (SHOW_ACCEPTED_CREDIT_CARDS === '1') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled();
            } elseif (SHOW_ACCEPTED_CREDIT_CARDS === '2') {
                echo TEXT_ACCEPTED_CREDIT_CARDS . zen_get_cc_enabled('IMAGE_');
            }
?>
                    <div class="p-3"></div>
<?php
        }

        $selection = $payment_modules->selection();

        if (count($selection) > 1) {
?>
                    <div id="paymentMethod-content" class="content"><?php echo TEXT_SELECT_PAYMENT_METHOD; ?></div>
<?php
        } elseif (count($selection) == 0) {
?>
                    <div id="paymentMethod-content-one" class="content"><?php echo TEXT_NO_PAYMENT_OPTIONS_AVAILABLE; ?></div>
<?php
        }

        $radio_buttons = 0;
        for ($i = 0, $n = count($selection); $i < $n; $i++) {
?>
                    <div class="card mb-3">
<?php
            if (count($selection) >= 1) {
                if (empty($selection[$i]['noradio'])) {
                    $radio_value = (isset($_SESSION['payment']) && $selection[$i]['id'] == $_SESSION['payment']);
?>
                        <div class="card-header">
                            <div class="custom-control custom-radio custom-control-inline">
                                <?php echo zen_draw_radio_field('payment', $selection[$i]['id'], $radio_value, 'id="pmt-'.$selection[$i]['id'].'"'); ?>
<?php
                }
            } else {
?>
                                <?php echo zen_draw_hidden_field('payment', $selection[$i]['id'], 'id="pmt-'.$selection[$i]['id'].'"'); ?>
<?php
            }
?>
                                <label for="pmt-<?php echo $selection[$i]['id']; ?>" class="custom-control-label radioButtonLabel"><?php echo $selection[$i]['module']; ?></label>
                            </div>
                        </div>
<?php
            if (defined('MODULE_ORDER_TOTAL_COD_STATUS') && MODULE_ORDER_TOTAL_COD_STATUS === 'true' && $selection[$i]['id'] === 'cod') {
?>
<div class="alert alert-danger" role="alert"><?php echo TEXT_INFO_COD_FEES; ?></div>
<?php
            } else {
                // echo 'WRONG ' . $selection[$i]['id'];
            }
?>

<?php
            if (isset($selection[$i]['error'])) {
?>
                        <div><?php echo $selection[$i]['error']; ?></div>

<?php
            } elseif (isset($selection[$i]['fields']) && is_array($selection[$i]['fields'])) {
?>
                        <div class="ccInfo card-body p-3">
<?php
                for ($j=0, $n2=sizeof($selection[$i]['fields']); $j<$n2; $j++) {
?>
<label <?php echo (isset($selection[$i]['fields'][$j]['tag']) ? 'for="'.$selection[$i]['fields'][$j]['tag'] . '" ' : ''); ?>class="inputLabelPayment"><?php echo isset($selection[$i]['fields'][$j]['title']) ? $selection[$i]['fields'][$j]['title'] : ''; ?></label><?php echo $selection[$i]['fields'][$j]['field']; ?>
                            <div class="p-2"></div>
<?php
                }
?>
                        </div>
<?php
            }
            $radio_buttons++;
?>
                    </div>
<?php
        }
?>
                </div>
            </div>

<?php // ** BEGIN PAYPAL EXPRESS CHECKOUT **
      } else {
?>
            <input type="hidden" name="payment" value="<?php echo $_SESSION['payment']; ?>" />
<?php
      }
      // ** END PAYPAL EXPRESS CHECKOUT **
?>
            <div id="orderComments-card" class="card mb-3">
                <h4 class="card-header"><?php echo HEADING_ORDER_COMMENTS; ?></h4>
                <div class="card-body p-3">
                    <?php echo zen_draw_textarea_field('comments', '45', '3', (isset($comments) ? $comments : ''), 'aria-label="' . HEADING_ORDER_COMMENTS . '"'); ?>
                </div>
            </div>
<?php
    if (DISPLAY_CONDITIONS_ON_CHECKOUT === 'true') {
?>
            <div id="conditions-card" class="card mb-3">
                <h4 class="card-header"><?php echo TABLE_HEADING_CONDITIONS; ?></h4>
                <div class="card-body p-3">
                    <?php echo TEXT_CONDITIONS_DESCRIPTION;?>

                    <div class="custom-control custom-checkbox">
                        <?php echo zen_draw_checkbox_field('conditions', '1', (isset($_SESSION['conditions']) && ($_SESSION['conditions'] === '1')), 'id="conditions" required oninput="this.setCustomValidity(\'\')" oninvalid="this.setCustomValidity(\'' . ERROR_CONDITIONS_NOT_ACCEPTED . '\')"');?><label class="custom-control-label checkboxLabel" for="conditions"><?php echo TEXT_CONDITIONS_CONFIRM; ?></label>
                    </div>

                </div>
            </div>
<?php
    }
?>
        </div>
<?php
    // -----
    // Starting with the as-delivered Zen Cart 1.5.8a, styling has been removed from various checkout language
    // constants.  To keep the same 'look' regardless whether the store's value contains a <strong> tag, strip
    // that tag and its end-tag from the constant and output the tag here.
    //
    $title_continue_checkout = str_replace(['<strong>', '</strong>'], '', TITLE_CONTINUE_CHECKOUT_PROCEDURE);
?>
        <div id="paymentSubmit" class="btn-toolbar justify-content-between" role="toolbar">
            <?php echo '<strong>' . $title_continue_checkout . '</strong><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE; ?>
            <?php echo zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT, 'onclick="submitFunction(' . zen_user_has_gv_account($_SESSION['customer_id']) . ',' . $order->info['total'] . ')"'); ?>
        </div>
    <?php echo '</form>'; ?>

<?php
    if (defined('MODULE_ORDER_TOTAL_COUPON_STATUS') && MODULE_ORDER_TOTAL_COUPON_STATUS === 'true') {
        require $template->get_template_dir('tpl_coupon_help.php',DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_coupon_help.php';
    }
?>

    <?php require $template->get_template_dir('tpl_cvv_help.php', DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_cvv_help.php'; ?>
</div>
