<?php
// -----
// Part of the One-Page Checkout plugin, provided under GPL 2.0 license by lat9
// Copyright (C) 2017-2026, Vinos de Frutas Tropicales.  All rights reserved.
//
// Last updated: OPC v2.6.0/Bootstrap v3.7.9
//
?>
<div class="centerColumn" id="registerDefault">

    <h1 id="createAcctDefaultHeading"><?= HEADING_TITLE ?></h1>
    <?= zen_draw_form('create_account', zen_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return check_register_form();"') ?>
    <?= zen_draw_hidden_field('action', 'register') ?>
    <?= zen_draw_hidden_field('email_pref_html', 'email_format') ?>
    <div id="registerDefaultLoginLink"><?= sprintf(TEXT_INSTRUCTIONS, zen_href_link(FILENAME_LOGIN, '', 'SSL')) ?></div>
<?php
if ($messageStack->size('create_account') > 0) {
    echo $messageStack->output('create_account');
}
?>
    <div class="required-info text-right"><?= FORM_REQUIRED_INFORMATION ?></div>
<?php
if (DISPLAY_PRIVACY_CONDITIONS === 'true') {
?>
    <div class="card mb-3 w-100">
        <h4 class="card-header"><?= TABLE_HEADING_PRIVACY_CONDITIONS ?></h4>
        <div class="card-body">
            <div class="information"><?= TEXT_PRIVACY_CONDITIONS_DESCRIPTION ?></div>
            <div class="custom-control custom-checkbox mb-3 mt-2">
                <?= zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy" required') ?>
                <label class="custom-control-label checkboxLabel" for="privacy"><?= TEXT_PRIVACY_CONDITIONS_CONFIRM ?></label>
            </div>
        </div>
    </div>
<?php
}

if (ACCOUNT_COMPANY === 'true') {
    $company_field_length = zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40');
?>
    <div class="card mb-3">
        <h4 class="card-header"><?= CATEGORY_COMPANY ?></h4>
        <div class="card-body">
            <label class="inputLabel" for="company"><?= ENTRY_COMPANY ?></label>
            <?= zen_draw_input_field('company', '', $company_field_length . ' id="company" placeholder="' . ENTRY_COMPANY_TEXT . '"'. ((int)ENTRY_COMPANY_MIN_LENGTH > 0 ? ' required' : '')) ?>
        </div>
    </div>
<?php
}
?>
    <div class="card mb-3">
        <h4 class="card-header"><?= HEADING_CONTACT_DETAILS ?></h4>
        <div class="card-body">
<?php
if (ACCOUNT_GENDER === 'true') {
?>
            <label class="inputLabel"><?= ENTRY_GENDER ?></label><br>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('gender', 'm', '', 'id="gender-male"') ?>
                <label class="custom-control-label radioButtonLabel" for="gender-male"><?= MALE ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('gender', 'f', '', 'id="gender-female"') ?>
                <label class="custom-control-label radioButtonLabel" for="gender-female"><?= FEMALE ?></label>
            </div>
            <div class="clearfix"></div>
<?php
}

$firstname_field_length = zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40');
$lastname_field_length = zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40');
$telephone_field_length = zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40');

// -----
// Set by OPC's v2.6.0 additional header for the create_account page. Set the defaults
// if running with an earlier version of OPC.
//
$telephone_min_length ??= (int)ENTRY_TELEPHONE_MIN_LENGTH;
$telephone_placeholder ??= ENTRY_TELEPHONE_NUMBER_TEXT;

$telephone_required = ($telephone_min_length > 0) ? ' required' : '';
?>
            <label class="inputLabel" for="firstname"><?= ENTRY_FIRST_NAME ?></label>
            <?= zen_draw_input_field('firstname', '', $firstname_field_length . ' id="firstname" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0 ? ' required' : '')) ?>
            <label class="inputLabel" for="lastname"><?= ENTRY_LAST_NAME ?></label>
            <?= zen_draw_input_field('lastname', '', $lastname_field_length . ' id="lastname" placeholder="' . ENTRY_LAST_NAME_TEXT . '"'. ((int)ENTRY_LAST_NAME_MIN_LENGTH > 0 ? ' required' : '')) ?>
            <label class="inputLabel phone" for="telephone"><?= ENTRY_TELEPHONE_NUMBER ?></label>
            <?= zen_draw_input_field('telephone', '', $telephone_field_length . ' id="telephone" class="phone" placeholder="' . $telephone_placeholder . '"' . $telephone_required, 'tel') ?>
<?php
unset($company_field_length, $firstname_field_length, $lastname_field_length, $telephone_field_length);

if (ACCOUNT_DOB === 'true') {
?>
            <label class="inputLabel" for="dob"><?= ENTRY_DATE_OF_BIRTH ?></label>
            <?= zen_draw_input_field('dob','', 'id="dob" placeholder="' . ENTRY_DATE_OF_BIRTH_TEXT . '"' . ((int)ENTRY_DOB_MIN_LENGTH > 0 ? ' required' : '')) ?>
<?php
}

if ($display_nick_field === true) {
?>
            <label class="inputLabel" for="nickname"><?= ENTRY_NICK ?></label>
            <?= zen_draw_input_field('nick', '', 'id="nickname" placeholder="' . ENTRY_NICK_TEXT . '"') ?>
<?php
}
?>
        </div>
    </div>

    <div class="card mb-3">
        <h4 class="card-header"><?= TABLE_HEADING_LOGIN_DETAILS ?></h4>
        <div class="card-body">
            <label class="inputLabel" for="email-address"><?= ENTRY_EMAIL_ADDRESS ?></label>
<?php
$email_field_length = zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40');
$email_required = ((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0 ? ' required' : '');
echo zen_draw_input_field('email_address', '', $email_field_length . ' id="email-address" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . $email_required, 'email'); 
?>
            <label class="inputLabel" for="email-address-confirm"><?= ENTRY_EMAIL_ADDRESS_CONFIRM ?></label>
            <?= zen_draw_input_field('email_address_confirm', '', $email_field_length . ' id="email-address-confirm" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . $email_required, 'email') ?>
            <label class="inputLabel"><?= ENTRY_EMAIL_FORMAT ?></label><br>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'HTML', ($email_format === 'HTML'),'id="email-format-html"') ?>
                <label class="custom-control-label radioButtonLabel" for="email-format-html"><?= ENTRY_EMAIL_HTML_DISPLAY ?></label>
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'TEXT', ($email_format === 'TEXT'), 'id="email-format-text"') ?>
                <label class="custom-control-label radioButtonLabel" for="email-format-text"><?= ENTRY_EMAIL_TEXT_DISPLAY ?></label>
            </div>
            <div class="clearfix"></div>

            <label class="inputLabel" for="password-new"><?= ENTRY_PASSWORD ?></label>
<?php
$password_field_length = zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20');
$password_required = ((int)ENTRY_PASSWORD_MIN_LENGTH > 0 ? ' required' : '');
echo zen_draw_password_field('password', '', $password_field_length . ' id="password-new" autocomplete="off" placeholder="' . ENTRY_PASSWORD_TEXT . '"'. $password_required); 
?>
            <label class="inputLabel" for="password-confirm"><?= ENTRY_PASSWORD_CONFIRMATION ?></label>
            <?= zen_draw_password_field('confirmation', '', $password_field_length . ' id="password-confirm" autocomplete="off" placeholder="' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '"'. $password_required) ?>
        </div>
    </div>
    
<?php
if (ACCOUNT_NEWSLETTER_STATUS !== '0') {
?>
    <div class="card mb-3">
        <h4 class="card-header"><?= ENTRY_EMAIL_PREFERENCE ?></h4>
        <div class="card-body">
            <div class="custom-control custom-checkbox">
                <?= zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="newsletter-checkbox"') ?>
                <label class="custom-control-label checkboxLabel" for="newsletter-checkbox"><?= ENTRY_NEWSLETTER ?></label>
                <?= (!empty(ENTRY_NEWSLETTER_TEXT)) ? '<span class="alert">' . ENTRY_NEWSLETTER_TEXT . '</span>': '' ?>
            </div>
        </div>
    </div>
<?php
} 

if (CUSTOMERS_REFERRAL_STATUS === '2') {
?>
    <div class="card mb-3">
        <h4 class="card-header"><?= TABLE_HEADING_REFERRAL_DETAILS ?></div>
        <div class="card-body">
            <label class="inputLabel" for="customers_referral"><?= ENTRY_CUSTOMERS_REFERRAL ?></label>
            <?= zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral"') ?>
        </div>
    </div>
<?php
} 
?>
    <div class="buttonRow text-center"><?= zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_REGISTER_ALT) ?></div>
<?php
echo '</form>';
?>
</div>
