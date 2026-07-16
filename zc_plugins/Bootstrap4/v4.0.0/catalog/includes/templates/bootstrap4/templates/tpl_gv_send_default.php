<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * Template used to collect/display details of sending a GV to a friend from own GV balance. <br />
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott C Wilson 2019 Jul 05 Modified in v1.5.7 $
 */
?>
<div id="gvSendDefault" class="centerColumn">
    <h1 id="gvSendDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>
    <div id="giftCertificateAccount-card" class="card mb-3">
        <h4 id="giftCertificateAccount-card-header" class="card-header"><?= TEXT_AVAILABLE_BALANCE ?></h4>
        <div id="giftCertificateAccount-card-body" class="card-body p-3">
            <?= TEXT_BALANCE_IS . $gv_current_balance ?>
<?php
$action = $_GET['action'] ?? '';
$to_name = zen_output_string_protected($_POST['to_name'] ?? '');
$error ??= false;
if ($gv_result->fields['amount'] > 0 && $action === 'doneprocess') {
?>
            <div id="giftCertificateAccount-content" class="content"><?= TEXT_SEND_ANOTHER ?></div>
            <div id="giftCertificateAccount-btn-toolbar" class="btn-toolbar justify-content-end my-3" role="toolbar">
                <?= zca_button_link(zen_href_link(FILENAME_GV_SEND, '', 'SSL'), BUTTON_SEND_ANOTHER_ALT, 'button_send_another') ?>
            </div>
<?php
}
?>
        </div>
    </div>
<?php
if ($action === 'doneprocess') {
?>
    <div id="giftCertificateSent-card" class="card mb-3">
        <h4 id="giftCertificateSent-card-header" class="card-header"><?= HEADING_TITLE_COMPLETED ?></h4>
        <div id="giftCertificateSent-card-body" class="card-body p-3">   
            <div id="giftCertificateSent-content" class="content"><?= TEXT_SUCCESS ?></div>
            <div id="giftCertificateSent-btn-toolbar" class="btn-toolbar justify-content-end my-3" role="toolbar">
                <?= zca_button_link(zen_href_link(FILENAME_DEFAULT, '', 'SSL', false), BUTTON_CONTINUE_ALT, 'button_continue') ?>
            </div>
        </div>
    </div>
<?php
} elseif ($action === 'send' && $error === false) {
?>
    <div id="giftCertificateConfirmation-card" class="card mb-3">
        <h4 id="giftCertificateConfirmation-card-header" class="card-header"><?= HEADING_TITLE_CONFIRM_SEND ?></h4>
        <div id="giftCertificateConfirmation-card-body" class="card-body p-3"> 
            <?= zen_draw_form('gv_send_process', zen_href_link(FILENAME_GV_SEND, 'action=process', 'SSL', false)) ?>
                <div id="confirmationMessage-card" class="card mb-3">
                    <div id="confirmationMessage-card-body" class="card-body p-3"> 
                        <div id="confirmationMessage-content" class="content">
                            <?= sprintf(MAIN_MESSAGE, $currencies->format($currencies->normalizeValue($_POST['amount']), false), $to_name, $_POST['email']) ?>
                        </div>
                        <div id="confirmationMessage-content-one" class="content">
                            <?= sprintf(SECONDARY_MESSAGE, $to_name, $currencies->format($currencies->normalizeValue($_POST['amount']), false), $send_name) ?>
                        </div>
<?php
    if (!empty($_POST['message'])) {
?>
                        <div id="confirmationMessage-content-two" class="content"><?= sprintf(PERSONAL_MESSAGE, $send_firstname) ?></div>
                        <div id="confirmationMessage-content-three" class="content"><?= stripslashes($_POST['message']) ?></div>
                    </div>
                </div>
<?php
    }
    echo zen_draw_hidden_field('to_name', stripslashes($to_name)) .
         zen_draw_hidden_field('email', $_POST['email']) .
         zen_draw_hidden_field('amount', $gv_amount) .
         zen_draw_hidden_field('message', stripslashes($_POST['message']));
?>
                <div id="giftCertificateConfirmation-content" class="content mb-3">
                    <?= EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY) ?>
                </div>

                <div id="giftCertificateConfirmation-btn-toolbar" class="btn-toolbar justify-content-between" role="toolbar">
                    <?= zen_image_submit(BUTTON_IMAGE_EDIT_SMALL, BUTTON_EDIT_SMALL_ALT, 'name="edit" value="edit"') .   zen_image_submit(BUTTON_IMAGE_CONFIRM_SEND, BUTTON_CONFIRM_SEND_ALT) ?>
                </div>
            <?= '</form>' ?>
        </div>
    </div>
<?php
} else {
?>
    <div id="sendGiftCertificate-card" class="card mb-3">
        <h4 id="sendGiftCertificate-card-header" class="card-header"><?= HEADING_TITLE ?></h4>
        <div id="sendGiftCertificate-card-body" class="card-body p-3">   
<?php
    if ($messageStack->size('gv_send') > 0) {
        echo $messageStack->output('gv_send');
    }
?>
            <?= zen_draw_form('gv_send_send', zen_href_link(FILENAME_GV_SEND, 'action=send', 'SSL', false)) ?>
                <div class="required-info text-right"><?= FORM_REQUIRED_INFORMATION ?></div>

                <div id="sendGiftCertificate-content" class="content mb-3"><?= HEADING_TEXT ?></div>

                <label class="inputLabel" for="to-name"><?= ENTRY_RECIPIENT_NAME ?></label>
                <?= zen_draw_input_field('to_name', $to_name, 'size="40" id="to-name" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)zen_config('ENTRY_FIRST_NAME_MIN_LENGTH') > 0 ? ' required' : '')) ?>
                <div class="p-2"></div>

                <label class="inputLabel" for="email-address"><?= ENTRY_EMAIL ?></label>
                <?= zen_draw_input_field('email', (!empty($_POST['email'])? $_POST['email'] : ''), 'size="40" id="email-address" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . ((int)zen_config('ENTRY_EMAIL_ADDRESS_MIN_LENGTH') > 0 ? ' required' : ''), 'email') ?>
                <div class="p-2"></div>

                <label class="inputLabel" for="amount"><?= ENTRY_AMOUNT ?></label>
                <?= zen_draw_input_field('amount', (!empty($_POST['amount']) ? $_POST['amount'] : ''), 'id="amount" placeholder="' . ENTRY_REQUIRED_SYMBOL . '"' . ' required', 'text', false) ?>
                <div class="p-2"></div>

                <label for="message-area"><?= ENTRY_MESSAGE ?></label>
                <?= zen_draw_textarea_field('message', 50, 10,  (!empty($_POST['message']) ? stripslashes($_POST['message']) : ''), 'id="message-area"') ?>
                <div class="p-2"></div>

                <div id="sendGiftCertificate-content-one" class="content"><?= EMAIL_ADVISORY_INCLUDED_WARNING . str_replace('-----', '', EMAIL_ADVISORY) ?></div>
                <div class="p-2"></div>

                <div id="sendGiftCertificate-btn-toolbar3" class="btn-toolbar justify-content-between" role="toolbar">
                    <?= zca_back_link() . zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_SEND_ALT) ?>
                </div>
            <?= '</form>' ?>
        </div>
    </div>
<?php
}
?>
</div>
