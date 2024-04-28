<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.7.0
 *
 * Loaded automatically by index.php?main_page=contact_us.<br />
 * Displays contact us page form.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: rbarbour zcadditions.com 2019 Jul 22 Modified in v1.5.7 $
 */
?>
<div id="contactUsDefault" class="centerColumn">
<?php
if (CONTACT_US_STORE_NAME_ADDRESS === '1') {
?>
    <address><?php echo nl2br(STORE_NAME_ADDRESS); ?></address>
<?php
}

if (isset($_GET['action']) && $_GET['action'] === 'success') {
?>
    <div id="contactUsDefault-content" class="content"><?php echo TEXT_SUCCESS; ?></div>

    <div id="contactUsDefault-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
        <?php echo zca_back_link(); ?>
    </div>
<?php
} else {
    // -----
    // If configured, include the define-page for the contact_us page.
    //
    if (DEFINE_CONTACT_US_STATUS === '1' || DEFINE_CONTACT_US_STATUS === '2') {
?>
    <div id="contactUsDefault-defineContent" class="defineContent">
        <?php require $define_page; ?>
    </div>
<?php
    }

    if ($messageStack->size('contact') > 0) {
        echo $messageStack->output('contact');
    }
?>
    <?php echo zen_draw_form('contact_us', zen_href_link(FILENAME_CONTACT_US, 'action=send', 'SSL')); ?>
    <div id="contactUs-card" class="card">
        <h2 id="contactUs-card-header" class="card-header"><?php echo HEADING_TITLE; ?></h2>
        <div id="contactUs-card-body" class="card-body">
            <div id="contactUs-required-info" class="required-info text-right my-3"><?php echo FORM_REQUIRED_INFORMATION; ?></div>
<?php
    // show dropdown if set
    if (CONTACT_US_LIST !== '') {
?>
            <label class="inputLabel" for="send-to"><?php echo SEND_TO_TEXT; ?></label><?php echo '<span class="alert">' . ENTRY_REQUIRED_SYMBOL . '</span>'; ?>
            <?php echo zen_draw_pull_down_menu('send_to',  $send_to_array, $send_to_default, 'id="send-to" required size="' . count($send_to_array) . '"'); ?>
            <div class="p-2"></div>
<?php
    }
?>
            <label class="inputLabel" for="contactname"><?php echo ENTRY_NAME; ?></label>
            <?php echo zen_draw_input_field('contactname', $name, ' size="40" id="contactname" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required'); ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="email-address"><?php echo ENTRY_EMAIL; ?></label>
            <?php echo zen_draw_input_field('email', ($email_address), ' size="40" id="email-address" autocomplete="off" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required', 'email'); ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="telephone"><?php echo ENTRY_TELEPHONE_NUMBER; ?></label>
            <?php echo zen_draw_input_field('telephone', ($telephone), ' size="20" id="telephone" autocomplete="off"', 'tel'); ?>
            <div class="p-2"></div>

            <label for="enquiry"><?php echo ENTRY_ENQUIRY; ?></label>
            <?php echo zen_draw_textarea_field('enquiry', '30', '7', $enquiry, 'id="enquiry" placeholder="' . ENTRY_REQUIRED_SYMBOL . '" required'); ?>
            <div class="p-2"></div>

            <?php echo zen_draw_input_field($antiSpamFieldName, '', ' size="40" id="CUAS" style="visibility:hidden; display:none;" autocomplete="off"'); ?>

            <div id="contactUs-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
                <?php echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT); ?>
            </div>
        </div>
    </div>

    <div id="contactUsDefault-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
        <?php echo zca_back_link(); ?>
    </div>
    <?php echo '</form>'; ?>
<?php
}
?>
</div>
