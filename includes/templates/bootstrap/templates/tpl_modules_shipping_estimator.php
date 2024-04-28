<?php
/**
 * Module Template - for shipping-estimator display
 *
 * BOOTSTRAP v3.7.0
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Steve 2022 Jun 29 Modified in v1.5.8-alpha $
 */
if (empty($extra)) {
    $extra = '';
} else {
    $extra = ' class="' . $extra . '"';
}

// -----
// NOTE: Since, for the Bootstrap template, the shipping estimator's popup displays
// as a modal, the link for its form is *always* the 'shopping_cart' page instead of
// possibly also being the popup_shipping_estimator!
//
?>
<div id="shippingEstimatorContent">
    <?php echo zen_draw_form('estimator', zen_href_link(FILENAME_SHOPPING_CART . '#seView', '', $request_type), 'post'); ?>
    <?php if (is_array($selected_shipping)) {
        echo zen_draw_hidden_field('scid', $selected_shipping['id']);
    } ?>
    <?php echo zen_draw_hidden_field('action', 'submit'); ?>
<?php
if ($_SESSION['cart']->count_contents() !== 0) {
    if (zen_is_logged_in() && !zen_in_guest_checkout()) {
?>
    <h2><?php echo CART_SHIPPING_OPTIONS; ?></h2>
<?php 
        if (!empty($totalsDisplay)) { 
?>
    <div class="text-center"><?php echo $totalsDisplay; ?></div>
<?php 
        }
        // only display addresses if more than 1
        if ($addresses->RecordCount() > 1) {
?>
    <label class="inputLabel" for="seAddressPulldown"><?php echo CART_SHIPPING_METHOD_ADDRESS; ?></label>
    <?php echo zen_draw_pull_down_menu('address_id', $addresses_array, $selected_address, 'onchange="return shipincart_submit();" id="seAddressPulldown"'); ?>
<?php
        }
?>
    <div class="font-weight-bold" id="seShipTo"><?php echo CART_SHIPPING_METHOD_TO; ?></div>
    <address><?php echo zen_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br>'); ?></address>
<?php
    } else {
?>
    <a id="seView"></a>

    <h2><?php echo CART_SHIPPING_OPTIONS; ?></h2>
<?php 
        if (!empty($totalsDisplay)) { 
?>
    <div class="text-center"><?php echo $totalsDisplay; ?></div>
<?php
        }
        if ($_SESSION['cart']->get_content_type() !== 'virtual') {
            $flag_show_pulldown_states = (ACCOUNT_STATE_DRAW_INITIAL_DROPDOWN === 'true');
?>
    <label class="inputLabel" for="country"><?php echo ENTRY_COUNTRY; ?></label>
    <?php echo zen_get_country_list('zone_country_id', $selected_country, 'id="country"' . (($flag_show_pulldown_states === true) ? ' onchange="update_zone(this.form);"' : '')); ?>
    <div class="p-2"></div>
<?php
            if ($flag_show_pulldown_states === true) {
?>
    <label class="inputLabel" for="stateZone" id="zoneLabel"><?php echo ENTRY_STATE; ?></label>
    <?php echo zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $state_zone_id, 'id="stateZone"'); ?>
    <div class="p-2" id="stBreak"></div>
<?php
            }
?>
    <label class="inputLabel" for="state" id="stateLabel"><?php echo $state_field_label ?? ''; ?></label>
    <?php echo zen_draw_input_field('state', $selectedState, zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state"'); ?>
    <div class="p-2"></div>
<?php
            if (CART_SHIPPING_METHOD_ZIP_REQUIRED === 'true') {
?>
    <label class="inputLabel" for="postcode"><?php echo ENTRY_POST_CODE; ?></label>
    <?php echo zen_draw_input_field('postcode', ${'postcode'}, 'size="7" id="postcode"'); ?>
    <div class="p-2"></div>
<?php
            }
?>
    <div class="text-right mt-2 mb-2"><?php echo zen_image_submit(BUTTON_IMAGE_UPDATE, BUTTON_UPDATE_ALT); ?></div>
<?php
        }
    }
    if ($_SESSION['cart']->get_content_type() === 'virtual') {
        echo CART_SHIPPING_METHOD_FREE_TEXT .  ' ' . CART_SHIPPING_METHOD_ALL_DOWNLOADS;
    } elseif ($free_shipping == 1) {
        echo sprintf(FREE_SHIPPING_DESCRIPTION, $currencies->format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER));
    } else {
        if (!zen_is_logged_in() || zen_in_guest_checkout()) {
?>
        <div>
            <div class="pb-2"><?php echo CART_SHIPPING_QUOTE_CRITERIA; ?></div>
            <div class="pb-2">
                <?php echo zen_get_zone_name((int)$selected_country, (int)$state_zone_id, '') .
                          ($selectedState != '' ? ' ' . $selectedState : '') . ' ' .
                          (isset($order->delivery['postcode']) ? $order->delivery['postcode'] : '') . ' ' .
                          zen_get_country_name($order->delivery['country_id']); ?>
            </div>
        </div>
<?php 
        }
?>
    <table class="table table-striped" id="seQuoteResults">
        <thead>
            <tr>
                <th scope="col" id="seProductsHeading"><?php echo CART_SHIPPING_METHOD_TEXT; ?></th>
                <th scope="col" id="seTotalHeading"><?php echo CART_SHIPPING_METHOD_RATES; ?></th>
            </tr>
        </thead>
        <tbody>
<?php
        for ($i = 0, $n = count($quotes); $i < $n; $i++) {
            $thisquoteid = '';
            if (isset($quotes[$i]['id']) && count($quotes[$i]['methods']) == 1 && isset($quotes[$i]['methods'][0]['id'])) {
                // simple shipping method (e.g. 'flat')
                $thisquoteid = $quotes[$i]['id'].'_'.$quotes[$i]['methods'][0]['id'];
?>
            <tr<?php echo $extra; ?>>
<?php
                if (isset($quotes[$i]['error']) && $quotes[$i]['error']) {
?>
                <td colspan="2"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['error']; ?>)</td>
            </tr>
<?php
                } else {
                    if ($selected_shipping['id'] == $thisquoteid) {
?>
                <td class="font-weight-bold"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][0]['title']; ?>)</td>
                <td class="cartTotalDisplay font-weight-bold"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][0]['cost'], isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)); ?></td>
            </tr>
<?php
                    } else {
?>
                <td><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][0]['title']; ?>)</td>
                <td class="cartTotalDisplay"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][0]['cost'], isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)); ?></td>
            </tr>
<?php
                    }
                }
            } else {
                // shipping method with sub methods (e.g. UPS, USPS, multipickup, etc)
                for ($j = 0, $n2 = (empty($quotes[$i]['methods']) ? 0 : count($quotes[$i]['methods'])); $j < $n2; $j++) {
                    $thisquoteid = '';
                    if (isset($quotes[$i]['id']) && isset($quotes[$i]['methods'][$j]['id'])) {
                        $thisquoteid = $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'];
                    }
?>
            <tr<?php echo $extra; ?>>
<?php
                    if (!empty($quotes[$i]['error'])) {
?>
                <td colspan="2"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['error']; ?>)</td>
            </tr>
<?php
                    } else {
                        if ($selected_shipping['id'] == $thisquoteid) {
?>
                <td class="font-weight-bold"><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][$j]['title']; ?>)</td>
                <td class="cartTotalDisplay font-weight-bold"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)); ?></td>
            </tr>
<?php
                        } else {
?>
                <td><?php echo $quotes[$i]['module']; ?>&nbsp;(<?php echo $quotes[$i]['methods'][$j]['title']; ?>)</td>
                <td class="cartTotalDisplay"><?php echo $currencies->format(zen_add_tax($quotes[$i]['methods'][$j]['cost'], isset($quotes[$i]['tax']) ? $quotes[$i]['tax'] : 0)); ?></td>
            </tr>
<?php
                        }
                    }
                }
            }
        }
?>
        </tbody>
    </table>
<?php
    }
}
?>
    <?php echo '</form>'; ?>
</div>
