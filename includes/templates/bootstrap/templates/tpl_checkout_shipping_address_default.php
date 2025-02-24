<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.7.6
 *
 * Loaded automatically by index.php?main_page=checkout_shipping_adresss.
 * Allows customer to change the shipping address.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott C Wilson 2020 Feb 15 Modified in v1.5.7 $
 */
?>
<div id="checkoutShippingAddressDefault" class="centerColumn">
    <h1 id="checkoutShippingAddressDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>
<?php
if ($messageStack->size('checkout_address') > 0) {
    echo $messageStack->output('checkout_address');
}

if ($process == false || $error == true) {
?>
<!--bof shipping address card-->
    <div id="shippingAddress-card" class="card mb-3">
        <h2 id="shippingAddress-card-header" class="card-header"><?= TITLE_SHIPPING_ADDRESS ?></h2>
        <div id="shippingAddress-card-body" class="card-body p-3">
            <div class="row">
                <div id="shippingAddress-shipToAddress" class="shipToAddress col-sm-5">
                    <address><?= zen_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br>') ?></address>
                </div>
                <div class="col-sm-7">
                    <div id="shippingAddress-content" class="content">
<?php
    if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
        echo TEXT_CREATE_NEW_SHIPPING_ADDRESS;
    }
?>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
    <div class="row">
<!--eof shipping address card-->
<?php
    // -----
    // Starting with the as-delivered Zen Cart 1.5.8a, styling has been removed from various checkout language
    // constants.  To keep the same 'look' regardless whether the store's value contains a <strong> tag, strip
    // that tag and its end-tag from the constant and output the tag here.
    //
    $title_continue_checkout = str_replace(['<strong>', '</strong>'], '', TITLE_CONTINUE_CHECKOUT_PROCEDURE);

    if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {
?>
        <div class="col-lg-6">
            <div id="checkoutNewAddress-card" class="card mb-3">
                <?= zen_draw_form('checkout_address', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'), 'post', 'class="group"') ?>
                <h2 id="checkoutNewAddress-card-header" class="card-header"><?= TITLE_PLEASE_SELECT ?></h2>
                <div id="checkoutNewAddress-card-body" class="card-body p-3">
<?php 
        require $template->get_template_dir('tpl_modules_common_address_format.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_common_address_format.php';
?>
                    <div class="btn-toolbar justify-content-between mt-3" role="toolbar">
                        <?= '<strong>' . $title_continue_checkout . '</strong><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE ?>
                        <?= zen_draw_hidden_field('action', 'submit') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT) ?>
                    </div>
                </div>
                <?= '</form>' ?>
            </div>
        </div>
<?php
    }
?>
<!--bof choose from your address book entries card-->
        <div class="col-lg-6">
            <div id="addressBookEntries-card" class="card mb-3">
                <?= zen_draw_form('checkout_address_book', zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'), 'post', 'class="group"') ?>
                <h2 id="addressBookEntries-card-header" class="card-header"><?= TABLE_HEADING_ADDRESS_BOOK_ENTRIES ?></h2>
                <div id="addressBookEntries-card-body" class="card-body p-3">
<?php
    require $template->get_template_dir('tpl_modules_checkout_address_book.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_checkout_address_book.php';
?>
                    <div class="btn-toolbar justify-content-between" role="toolbar">
                        <?= '<strong>' . $title_continue_checkout . '</strong><br>' . TEXT_CONTINUE_CHECKOUT_PROCEDURE ?>
                        <?= zen_draw_hidden_field('action', 'submit') . zen_image_submit(BUTTON_IMAGE_CONTINUE, BUTTON_CONTINUE_ALT) ?>
                    </div>
                </div>
<!--eof choose from your address book entries card-->
                <?= '</form>' ?>
            </div>
        </div>
    </div>
<?php
}

if ($process == true) {
?>
    <div id="checkoutShippingAddressDefault-back-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
        <?= zca_button_link(zen_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'), BUTTON_BACK_ALT, 'button_back') ?>
    </div>
<?php
}
?>
</div>
