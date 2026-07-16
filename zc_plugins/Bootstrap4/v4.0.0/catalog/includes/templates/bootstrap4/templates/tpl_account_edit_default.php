<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * Loaded automatically by index.php?main_page=account_edit.
 * View or change Customer Account Information
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: rbarbour zcadditions.com Fri Feb 26 00:03:33 2016 -0500 Modified in v1.5.5 $
 */
?>
<div id="accountEditDefault" class="centerColumn">
    <?= zen_draw_form('account_edit', zen_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post', 'onsubmit="return check_form(account_edit);"') . zen_draw_hidden_field('action', 'process') ?>

<?php
if ($messageStack->size('account_edit') > 0){
    echo $messageStack->output('account_edit');
}
?>
<!--bof my account information card-->
    <div id="myAccountInfo-card" class="card mb-3">
        <div id="myAccountInfo-card-header" class="card-header"><?= '<h2>' . HEADING_TITLE . '</h2>' ?></div>
        <div id="myAccountInfo-card-body" class="card-body p-3">
            <div class="required-info text-right"><?= FORM_REQUIRED_INFORMATION ?></div>
<?php
if (zen_config('ACCOUNT_GENDER') === 'true') {
?>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('gender', 'm', '1', 'id="gender-male"') . '<label class="custom-control-label radioButtonLabel" for="gender-male">' . MALE . '</label>' ?>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('gender', 'f', '', 'id="gender-female"') . '<label class="custom-control-label radioButtonLabel" for="gender-female">' . FEMALE . '</label>' ?>
            </div>
            <div class="p-2"></div>
<?php
 }
?>
            <label class="inputLabel" for="firstname"><?= ENTRY_FIRST_NAME ?></label>
            <?= zen_draw_input_field('firstname', $account->fields['customers_firstname'], 'id="firstname" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)zen_config('ENTRY_FIRST_NAME_MIN_LENGTH ')> 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="lastname"><?= ENTRY_LAST_NAME ?></label>
            <?= zen_draw_input_field('lastname', $account->fields['customers_lastname'], 'id="lastname" placeholder="' . ENTRY_LAST_NAME_TEXT . '"' . ((int)zen_config('ENTRY_LAST_NAME_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>
<?php
if (zen_config('ACCOUNT_DOB') === 'true') {
?>
            <label class="inputLabel" for="dob"><?= ENTRY_DATE_OF_BIRTH ?></label>
            <?= zen_draw_input_field('dob', zen_date_short($account->fields['customers_dob']), 'id="dob" placeholder="' . ENTRY_DATE_OF_BIRTH_TEXT . '"' . (ACCOUNT_DOB == 'true' && (int)zen_config('ENTRY_DOB_MIN_LENGTH') != 0 ? ' required' : '')) ?>
            <div class="p-2"></div>
<?php
}
?>
            <label class="inputLabel" for="email-address"><?= ENTRY_EMAIL_ADDRESS ?></label>
            <?= zen_draw_input_field('email_address', $account->fields['customers_email_address'], 'id="email-address" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"'. ((int)zen_config('ENTRY_EMAIL_ADDRESS_MIN_LENGTH') > 0 ? ' required' : ''), 'email') ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="telephone"><?= ENTRY_TELEPHONE_NUMBER ?></label>
            <?= zen_draw_input_field('telephone', $account->fields['customers_telephone'], 'id="telephone" placeholder="' . ENTRY_TELEPHONE_NUMBER_TEXT . '"' . ((int)zen_config('ENTRY_TELEPHONE_MIN_LENGTH') > 0 ? ' required' : ''), 'tel') ?>
            <div class="p-2"></div>
<?php
if (zen_config('ACCOUNT_FAX_NUMBER') === 'true' ) {
?>
            <label class="inputLabel" for="fax"><?= ENTRY_FAX_NUMBER ?></label>
            <?= zen_draw_input_field('fax', $account->fields['customers_fax'], 'id="fax" placeholder="' . ENTRY_FAX_NUMBER_TEXT . '"', 'tel') ?>
            <div class="p-2"></div>
<?php 
}

if (zen_config('CUSTOMERS_REFERRAL_STATUS') === '2' && $customers_referral == '') {
?>
            <label class="inputLabel" for="customers-referral"><?= ENTRY_CUSTOMERS_REFERRAL ?></label>
            <?= zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', 15) . 'id="customers-referral"') ?>
            <div class="p-2"></div>
<?php
}

if (zen_config('CUSTOMERS_REFERRAL_STATUS') === '2' && $customers_referral != '') {
?>
            <label for="customers-referral-readonly"><?= ENTRY_CUSTOMERS_REFERRAL ?></label>
            <?= $customers_referral . zen_draw_hidden_field('customers_referral', $customers_referral,'id="customers-referral-readonly"') ?>
            <div class="p-2"></div>
<?php
}
?>
        </div>
    </div>
<!--eof my account information card-->

<!--bof newsletter and email details card-->
    <div id="details-card" class="card mb-3">
        <h4 id="details-card-header" class="card-header"><?= ENTRY_EMAIL_PREFERENCE ?></h4>
        <div id="details-card-body" class="card-body p-3">
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'HTML', $email_pref_html,'id="email-format-html"') . '<label class="custom-control-label" for="email-format-html">' . ENTRY_EMAIL_HTML_DISPLAY . '</label>' ?> 
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'TEXT', $email_pref_text, 'id="email-format-text"') . '<label  class="custom-control-label" for="email-format-text">' . ENTRY_EMAIL_TEXT_DISPLAY . '</label>' ?>
            </div>
        </div>
    </div>
<!--eof newsletter and email details card-->

    <div id="accountEditDefault-btn-toolbar" class="btn-toolbar justify-content-between" role="toolbar">
        <?= zca_button_link(zen_href_link(FILENAME_ACCOUNT, '', 'SSL'), BUTTON_BACK_ALT, 'button_back') ?>
        <?= zen_image_submit(BUTTON_IMAGE_UPDATE , BUTTON_UPDATE_ALT) ?>
    </div>
    <?= '</form>' ?>
</div>
