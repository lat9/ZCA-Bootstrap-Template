<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.8.0
 *
 * Loaded automatically by index.php?main_page=create_account.<br />
 * Displays Create Account form.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Nov 17 Modified in v1.5.7b $
 */
if ($messageStack->size('create_account') > 0) {
    echo $messageStack->output('create_account');
}
?>
<div class="required-info text-right"><?= FORM_REQUIRED_INFORMATION ?></div>
<div class="card-columns">
<?php
if (zen_config('DISPLAY_PRIVACY_CONDITIONS') === 'true') {
?>
    <div id="privacyStatement-card" class="card mb-3">
        <h4 id="privacyStatement-card-header" class="card-header"><?= TABLE_HEADING_PRIVACY_CONDITIONS ?></h4>
        <div id="privacyStatement-card-body" class="card-body p-3">
            <div id="privacyStatement-content" class="content"><?= TEXT_PRIVACY_CONDITIONS_DESCRIPTION ?></div>

            <div class="custom-control custom-checkbox">
                <?= zen_draw_checkbox_field('privacy_conditions', '1', false, 'id="privacy"') ?>
                <?= '<label class="custom-control-label" for="privacy">' . TEXT_PRIVACY_CONDITIONS_CONFIRM . '</label>' ?>
            </div>
        </div>
    </div>
<?php
}

if (zen_config('ACCOUNT_COMPANY') === 'true') {
?>
    <div id="companyDetails-card" class="card mb-3">
        <h4 id="companyDetails-card-header" class="card-header"><?= CATEGORY_COMPANY ?></h4>
        <div id="companyDetails-card-body" class="card-body p-3">
            <label class="inputLabel" for="company"><?= ENTRY_COMPANY ?></label>
            <?= zen_draw_input_field('company', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_company', '40') . ' id="company" autocomplete="organization" placeholder="' . ENTRY_COMPANY_TEXT . '"' . ((int)ENTRY_COMPANY_MIN_LENGTH !== 0 ? ' required' : '')) ?>
        </div>
    </div>
<?php
}
?>
    <div id="addressDetails-card" class="card mb-3">
        <h4 id="addressDetails-card-header" class="card-header"><?= TABLE_HEADING_ADDRESS_DETAILS ?></h4>
        <div id="addressDetails-card-body" class="card-body p-3">
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
            <?= zen_draw_input_field('firstname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_firstname', '40') . ' id="firstname" placeholder="' . ENTRY_FIRST_NAME_TEXT . '"' . ((int)zen_config('ENTRY_FIRST_NAME_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="lastname"><?= ENTRY_LAST_NAME ?></label>
            <?= zen_draw_input_field('lastname', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_lastname', '40') . ' id="lastname" placeholder="' . ENTRY_LAST_NAME_TEXT . '"'. ((int)zen_config('ENTRY_LAST_NAME_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="street-address"><?= ENTRY_STREET_ADDRESS ?></label>
            <?= zen_draw_input_field('street_address', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_street_address', '40') . ' id="street-address" placeholder="' . ENTRY_STREET_ADDRESS_TEXT . '"'. ((int)zen_config('ENTRY_STREET_ADDRESS_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <?= zen_draw_input_field($antiSpamFieldName, '', ' size="40" id="CAAS" style="visibility:hidden; display:none;" autocomplete="off"') ?>
<?php
if (zen_config('ACCOUNT_SUBURB') === 'true') {
?>
            <label class="inputLabel" for="suburb"><?= ENTRY_SUBURB ?></label>
            <?= zen_draw_input_field('suburb', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_suburb', '40') . ' id="suburb" autocomplete="address-line2" placeholder="' . ENTRY_SUBURB_TEXT . '"') ?>
            <div class="p-2"></div>
<?php
}
?>
            <label class="inputLabel" for="city"><?= ENTRY_CITY ?></label>
            <?= zen_draw_input_field('city', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_city', '40') . ' id="city" placeholder="' . ENTRY_CITY_TEXT . '"'. ((int)zen_config('ENTRY_CITY_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="country"><?= ENTRY_COUNTRY ?></label><?php if (!empty(ENTRY_COUNTRY_TEXT) ? '<span class="alert">' . ENTRY_COUNTRY_TEXT . '</span>': '') ?>
            <?= zen_get_country_list('zone_country_id', $selected_country, 'id="country"' . (($flag_show_pulldown_states === true) ? ' onchange="update_zone(this.form);"' : '')) ?>
            <div class="p-2"></div>
<?php
// -----
// Adding a (hidden) span to contain a 'stBreak' identifier, to keep the 'base' Zen Cart
// jscript_addr_pulldowns.php from throwing a javascript error for that missing 'id'.
//
?>
            <span class="d-none" id="stBreak">&nbsp;</span>
<?php
if (zen_config('ACCOUNT_STATE') === 'true') {
    if ($flag_show_pulldown_states === true) {
?>
            <label class="inputLabel" for="stateZone" id="zoneLabel"><?= ENTRY_STATE ?></label><span class="alert"><?= ((!empty(ENTRY_STATE_TEXT) && (int)zen_config('ENTRY_STATE_MIN_LENGTH') > 0) ? ENTRY_STATE_TEXT : '') ?></span>
            <?= zen_draw_pull_down_menu('zone_id', zen_prepare_country_zones_pull_down($selected_country), $zone_id, 'id="stateZone"') ?>
            <div class="clearfix"></div>
<?php
    }
?>
            <label class="inputLabel" for="state" id="stateLabel"><?= $state_field_label ?></label>
            <?= zen_draw_input_field('state', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_state', '40') . ' id="state" class="form-control"' . ((int)zen_config('ENTRY_STATE_MIN_LENGTH') > 0 ? ' placeholder="' . ENTRY_STATE_TEXT . '"' : '')) ?>
            <?= ($flag_show_pulldown_states === false) ? zen_draw_hidden_field('zone_id', $zone_name, ' ') : '' ?>
<?php
}
?>
            <div class="p-2"></div>

            <label class="inputLabel" for="postcode"><?= ENTRY_POST_CODE ?></label>
            <?= zen_draw_input_field('postcode', '', zen_set_field_length(TABLE_ADDRESS_BOOK, 'entry_postcode', '40') . ' id="postcode" placeholder="' . ENTRY_POST_CODE_TEXT . '"' . ((int)zen_config('ENTRY_POSTCODE_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>
        </div>
    </div>

    <div id="contactDetails-card" class="card mb-3">
        <h4 id="contactDetails-card-header" class="card-header"><?= TABLE_HEADING_PHONE_FAX_DETAILS ?></h4>
        <div id="contactDetails-card-body" class="card-body p-3">
            <label class="inputLabel" for="telephone"><?= ENTRY_TELEPHONE_NUMBER ?></label>
            <?= zen_draw_input_field('telephone', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_telephone', '40') . ' id="telephone" placeholder="' . ENTRY_TELEPHONE_NUMBER_TEXT . '"' . ((int)zen_config('ENTRY_TELEPHONE_MIN_LENGTH') > 0 ? ' required' : ''), 'tel') ?>
<?php
if (zen_config('ACCOUNT_FAX_NUMBER') === 'true') {
?>
            <div class="p-2"></div>
            <label class="inputLabel" for="fax"><?= ENTRY_FAX_NUMBER ?></label>
            <?= zen_draw_input_field('fax', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_fax', '32') . ' id="fax" placeholder="' . ENTRY_FAX_NUMBER_TEXT . '"', 'tel') ?>
<?php
}
?>
        </div>
    </div>
<?php
if (zen_config('ACCOUNT_DOB') === 'true') {
?>
    <div id="verifyAge-card" class="card mb-3">
        <h4 id="verifyAge-card-header" class="card-header"><?= TABLE_HEADING_DATE_OF_BIRTH ?></h4>
        <div id="verifyAge-card-body" class="card-body p-3">
            <label class="inputLabel" for="dob"><?= ENTRY_DATE_OF_BIRTH ?></label>
            <?= zen_draw_input_field('dob','', zen_set_field_length(TABLE_CUSTOMERS, 'customers_dob', '20') . ' id="dob" placeholder="' . ENTRY_DATE_OF_BIRTH_TEXT . '"' . ((int)zen_config('ENTRY_DOB_MIN_LENGTH') !== 0 ? ' required' : '')) ?>

        </div>
    </div>
<?php
}
?>
    <div id="loginDetails-card" class="card mb-3">
        <h4 id="loginDetails-card-header" class="card-header"><?= TABLE_HEADING_LOGIN_DETAILS ?></h4>
        <div id="loginDetails-card-body" class="card-body p-3">
            <label class="inputLabel" for="email-address"><?= ENTRY_EMAIL_ADDRESS ?></label>
            <?= zen_draw_input_field('email_address', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_email_address', '40') . ' id="email-address" placeholder="' . ENTRY_EMAIL_ADDRESS_TEXT . '"' . ((int)zen_config('ENTRY_EMAIL_ADDRESS_MIN_LENGTH') > 0 ? ' required' : ''), 'email') ?>
            <div class="p-2"></div>
<?php
if ($display_nick_field === true) {
?>
            <label class="inputLabel" for="nickname"><?= ENTRY_NICK ?></label>
            <?= zen_draw_input_field('nick','', zen_set_field_length(TABLE_CUSTOMERS, 'customers_nick', '32') . ' id="nickname" placeholder="' . ENTRY_NICK_TEXT . '"') ?>
            <div class="p-2"></div>
<?php
}
?>
            <label class="inputLabel" for="password-new"><?= ENTRY_PASSWORD ?></label>
            <?= zen_draw_password_field('password', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-new" autocomplete="off" placeholder="' . ENTRY_PASSWORD_TEXT . '"'. ((int)zen_config('ENTRY_PASSWORD_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>

            <label class="inputLabel" for="password-confirm"><?= ENTRY_PASSWORD_CONFIRMATION ?></label>
            <?= zen_draw_password_field('confirmation', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_password', '20') . ' id="password-confirm" autocomplete="off" placeholder="' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '"'. ((int)zen_config('ENTRY_PASSWORD_MIN_LENGTH') > 0 ? ' required' : '')) ?>
            <div class="p-2"></div>
        </div>
    </div>

    <div id="newsletterDetails-card" class="card mb-3">
        <h4 id="newsletterDetails-card-header" class="card-header"><?= ENTRY_EMAIL_PREFERENCE ?></h4>
        <div id="newsletterDetails-card-body" class="card-body p-3">
<?php
if (zen_config('ACCOUNT_NEWSLETTER_STATUS') !== '0') {
?>
            <div class="custom-control custom-checkbox">
                <?= zen_draw_checkbox_field('newsletter', '1', $newsletter, 'id="newsletter-checkbox"') . '<label class="custom-control-label" for="newsletter-checkbox">' . ENTRY_NEWSLETTER . '</label>' . (!empty(ENTRY_NEWSLETTER_TEXT) ? '<span class="alert">' . ENTRY_NEWSLETTER_TEXT . '</span>': '') ?>
            </div>
<?php
}
?>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'HTML', ($email_format === 'HTML'),'id="email-format-html"') . '<label class="custom-control-label" for="email-format-html">' . ENTRY_EMAIL_HTML_DISPLAY . '</label>' ?> 
            </div>
            <div class="custom-control custom-radio custom-control-inline">
                <?= zen_draw_radio_field('email_format', 'TEXT', ($email_format === 'TEXT'), 'id="email-format-text"') . '<label class="custom-control-label" for="email-format-text">' . ENTRY_EMAIL_TEXT_DISPLAY . '</label>' ?>
            </div>
        </div>
    </div>
<?php
if (zen_config('CUSTOMERS_REFERRAL_STATUS') === '2') {
?>
    <div id="ReferredToUs-card" class="card mb-3">
        <h4 id="ReferredToUs-card" class="card-header"><?= TABLE_HEADING_REFERRAL_DETAILS ?></h4>
        <div id="ReferredToUs-card" class="card-body p-3">
            <label class="inputLabel" for="customers_referral"><?= ENTRY_CUSTOMERS_REFERRAL ?></label>
            <?= zen_draw_input_field('customers_referral', '', zen_set_field_length(TABLE_CUSTOMERS, 'customers_referral', '15') . ' id="customers_referral"') ?>
        </div>
    </div>
<?php
}
?>
</div>
