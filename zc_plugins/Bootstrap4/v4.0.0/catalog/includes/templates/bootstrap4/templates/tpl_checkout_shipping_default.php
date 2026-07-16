<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.7.0
 *
 * Loaded automatically by index.php?main_page=checkout_shipping.<br>
 * Displays allowed shipping modules for selection by customer.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Oct 29 Modified in v1.5.7a $
 */
?>
<div id="checkoutShippingDefault" class="centerColumn">
    <div class="progress">
        <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
    </div>

    <?php echo zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL')) . zen_draw_hidden_field('action', 'process'); ?>

    <h1 class="pageHeading"><?php echo HEADING_TITLE; ?></h1>

<?php
if ($messageStack->size('checkout_shipping') > 0) {
    echo $messageStack->output('checkout_shipping');
}
?>
    <div class="card-columns">
        <div id="shippingInformation-card" class="card mb-3">
            <h2 class="card-header"><?php echo TITLE_SHIPPING_ADDRESS; ?></h2>
            <div class="card-body p-3">
                <div class="row">
                    <div class="shipToAddress col-sm-5">
                        <address><?php echo zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br>'); ?></address>      
                    </div>
                    <div class="col-sm-7">
                        <?php echo TEXT_CHOOSE_SHIPPING_DESTINATION; ?>
<?php
if ($displayAddressEdit) {
?>
                        <div class="btn-toolbar justify-content-end mt-3" role="toolbar">
                            <?php echo zca_button_link($editShippingButtonLink, BUTTON_CHANGE_ADDRESS_ALT, 'button_change_address'); ?>
                        </div>
<?php
}
?>
                    </div>
                </div>
            </div>
        </div>
<?php
if (zen_count_shipping_modules() > 0) {
?>
        <div id="shippingMethod-card" class="card mb-3">
            <h2 class="card-header"><?php echo HEADING_SHIPPING_METHOD; ?></h2>
            <div class="card-body p-3">
<?php
    if (count($quotes) > 1 && count($quotes[0]) > 1) {
?>
                <div id="shippingMethod-content" class="content"><?php echo TEXT_CHOOSE_SHIPPING_METHOD; ?></div>
 
<?php
    } elseif ($free_shipping === false) {
?>
                <div id="shippingMethod-content-one" class="content"><?php echo TEXT_ENTER_SHIPPING_INFORMATION; ?></div>
<?php
    }
?>
<?php
    if ($free_shipping === true) {
?>
                <div id="shippingMethod-content-two" class="content"><?php echo FREE_SHIPPING_TITLE . (isset($quotes[$i]['icon']) ? '&nbsp;' . $quotes[$i]['icon'] : ''); ?></div>

                <div id="shippingMethod-selected" class="selected"><?php echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER)) . zen_draw_hidden_field('shipping', 'free_free'); ?></div>
<?php
    } else {
        $radio_buttons = 0;
        for ($i = 0, $n = count($quotes); $i < $n; $i++) {
      // bof: field set
// allows FedEx to work comment comment out Standard and Uncomment FedEx
//      if (!empty($quotes[$i]['id']) || !empty($quotes[$i]['module'])) { // FedEx
            if (!empty($quotes[$i]['module'])) { // Standard
?>
<!--bof shipping method option card-->
                <div class="card mb-3">
                    <div class="card-header">
                        <?php echo $quotes[$i]['module']; ?>&nbsp;
<?php
                if (!empty($quotes[$i]['icon'])) {
                    echo $quotes[$i]['icon'];
                }
?>
                    </div>
                    <div class="card-body p-3">
<?php
                if (isset($quotes[$i]['error'])) {
?>
                        <div><?php echo $quotes[$i]['error']; ?></div>
<?php
                } else {
                    for ($j = 0, $n2 = count($quotes[$i]['methods']); $j < $n2; $j++) {
// set the radio button to be checked if it is the method chosen
                        $checked = false;
                        if (isset($_SESSION['shipping']) && isset($_SESSION['shipping']['id'])) {
                            $checked = ($quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']);
                        }

                        if ($n > 1 || $n2 > 1) {
?>
                        <div class="float-right"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], (isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0))); ?></div>
<?php
                        } else {
?>
                        <div class="float-right"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax'])) . zen_draw_hidden_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id']); ?></div>
<?php
                        }
?>
                        <div class="custom-control custom-radio custom-control-inline">
                            <?php echo zen_draw_radio_field('shipping', $quotes[$i]['id'] . '_' . $quotes[$i]['methods'][$j]['id'], $checked, 'id="ship-'.$quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']) .'"'); ?>

                            <label for="ship-<?php echo $quotes[$i]['id'] . '-' . str_replace(' ', '-', $quotes[$i]['methods'][$j]['id']); ?>" class="custom-control-label checkboxLabel"><?php echo $quotes[$i]['methods'][$j]['title']; ?></label>
                        </div>
                        <div class="p-1"></div>
<?php
                        $radio_buttons++;
                    }
                }
?>
                    </div>
                </div>
<?php
            }
        }
    }
?>
            </div>
        </div>
<?php
} else {
?>
        <div id="noShipping-card" class="card mb-3">
            <div class="card-body p-3">
                <h2 class="pageHeading"><?php echo TITLE_NO_SHIPPING_AVAILABLE; ?></h2>
                <div class="content"><?php echo TEXT_NO_SHIPPING_AVAILABLE; ?></div>
            </div>
        </div>
<?php
}

$comments = (isset($comments)) ? $comments : '';
?>
        <div id="orderComments-card" class="card mb-3">
            <h2 class="card-header"><?php echo HEADING_ORDER_COMMENTS; ?></h2>
            <div class="card-body p-3">
                <?php echo zen_draw_textarea_field('comments', '45', '3', $comments, 'aria-label="' . HEADING_ORDER_COMMENTS . '"'); ?>
            </div>
        </div>
    </div>
<?php
// -----
// Determine what messaging to give the customer, in case there are no shipping methods
// available for the order.  The $zca_show_contact_us_instead_of_continue variable
// can be overridden via extra_datafiles/site-specific-bootstrap-settings.php.
//
$show_contact_us_instead_of_continue = $zca_show_contact_us_instead_of_continue ?? false;
if (empty($show_contact_us_instead_of_continue) || zen_count_shipping_modules() > 0) {
    $action_button = zen_image_submit(BUTTON_IMAGE_CONTINUE_CHECKOUT, BUTTON_CONTINUE_ALT);
    $instruction_title = TITLE_CONTINUE_CHECKOUT_PROCEDURE;
    $instruction_text = TEXT_CONTINUE_CHECKOUT_PROCEDURE;
} else {
    $action_button =
        '<a href="' . zen_href_link(FILENAME_CONTACT_US, '', 'SSL') . '" id="linkContactUs">' .
            zen_image_button(BUTTON_IMAGE_CONTACT_US , BUTTON_CONTACT_US_TEXT) .
        '</a>';
    $instruction_title = TITLE_NO_SHIPPING_AVAILABLE;
    $instruction_text = TEXT_NO_SHIPPING_AVAILABLE;
}
?>
    <div id="checkoutShippingDefault-btn-toolbar1" class="btn-toolbar justify-content-between" role="toolbar">
        <?php echo '<strong>' . $instruction_title . '</strong><br>' . $instruction_text; ?>
        <?php echo $action_button; ?>
    </div>
    <?php echo '</form>'; ?>
</div>
