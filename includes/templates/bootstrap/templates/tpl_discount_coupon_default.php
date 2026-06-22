<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2019 Aug 23 Modified in v1.5.7 $
 */
?>
<div id="discountCouponDefault" class="centerColumn">
    <h1 id="discountCouponDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>

    <div id="discountCouponDefault-defineContent" class="defineContent mb-3">
<?php
if (in_array($tplSetting->DEFINE_DISCOUNT_COUPON_STATUS, ['1', '2'], true) && $text_coupon_help === '') {
    require $define_page;
 } else {
    echo $text_coupon_help;
}
?>
    </div>

    <?= zen_draw_form('discount_coupon', zen_href_link(FILENAME_DISCOUNT_COUPON, 'action=lookup', 'SSL', false)) ?>

        <div id="lookupDiscountCoupon-card" class="card">
            <h4 id="lookupDiscountCoupon-card-header" class="card-header"><?= TEXT_DISCOUNT_COUPON_ID_INFO ?></h4>
            <div id="lookupDiscountCoupon-card-body" class="card-body">
                <label class="inputLabel" for="lookup-discount-coupon"><?= TEXT_DISCOUNT_COUPON_ID ?></label>
                <?= zen_draw_input_field('lookup_discount_coupon', isset($_POST['lookup_discount_coupon']) ? $_POST['lookup_discount_coupon'] : '', 'size="40" id="lookup-discount-coupon" autofocus', 'search') ?>

                <div id="lookupDiscountCoupon-btn-toolbar" class="btn-toolbar justify-content-end mt-3" role="toolbar">
<?php
if ($text_coupon_help === '') {
    echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_LOOKUP_ALT);
} else {
    echo '<a href="' . zen_href_link(FILENAME_DISCOUNT_COUPON) . '">' . zen_image_button(BUTTON_IMAGE_CANCEL, BUTTON_CANCEL_ALT) . '</a>&nbsp;&nbsp;';
    echo zen_image_submit(BUTTON_IMAGE_SEND, BUTTON_LOOKUP_ALT);
}
?>
                </div>
            </div>
        </div>

        <div id="discountCouponDefault-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
            <?= zca_back_link() ?>
        </div>

    <?= '</form>' ?>
</div>
