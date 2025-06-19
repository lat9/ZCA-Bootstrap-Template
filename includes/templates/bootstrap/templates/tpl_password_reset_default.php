<?php
/**
 * Loaded automatically by index.php?main_page=password_reset.<br />
 * Allows customer to change their password via a requested reset_token
 *
 * BOOTSTRAP v3.7.7
 *
 * @copyright Copyright 2003-2025 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_password_reset_default.php $
 */
?>
<div class="centerColumn" id="passwordReset">
    <h1><?= HEADING_TITLE ?></h1>
<?php
if ($messageStack->size('reset_password') > 0) {
    echo $messageStack->output('reset_password');
}

if (!$token_error) {
?>
    <?= zen_draw_form('account_password', zen_href_link(FILENAME_PASSWORD_RESET, '', 'SSL'), 'post', 'onsubmit="return check_form(account_password);"') ?>
    <?= zen_draw_hidden_field('action', 'process') ?>
    <?= zen_draw_hidden_field('reset_token', $reset_token) ?>
        <div class="content mb-3">
            <div class="card-body p-3">
                <div class="required-info text-right"><?= FORM_REQUIRED_INFORMATION ?></div>

                <label class="inputLabel" for="password-new"><?= ENTRY_PASSWORD_NEW ?></label>
                <?= zen_draw_password_field('password_new','','id="password-new" autocomplete="new-password" placeholder="' . ENTRY_PASSWORD_NEW_TEXT . '" required') ?>
                <div class="p-2"></div>

                <label class="inputLabel" for="password-confirm"><?= ENTRY_PASSWORD_CONFIRMATION ?></label>
                <?= zen_draw_password_field('password_confirmation','','id="password-confirm" autocomplete="new-password" placeholder="' . ENTRY_PASSWORD_CONFIRMATION_TEXT . '" required') ?>

                <div class="btn-toolbar justify-content-end my-3" role="toolbar">
                    <?= zen_image_submit(BUTTON_IMAGE_SUBMIT, BUTTON_SUBMIT_ALT) ?>
                </div>
            </div>
        </div>
    <?= '</form>' ?>
<?php
}
?>
</div>
