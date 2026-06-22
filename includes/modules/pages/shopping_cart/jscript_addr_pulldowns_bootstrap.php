<?php
// -----
// If Configuration :: Shipping/Packaging :: Shipping Estimator Display Settings for Shopping Cart
// indicates that the shipping-estimator is to be displayed as a button ('1') on the
// shopping-cart page, load the address-pulldowns' jscript since that button's press
// displays the shipping-estimator as a modal (on-page) display.
//
// Note that the base Zen Cart's handling of the shopping-cart page already loads that
// jscript file if the shipping-estimator is to be displayed as an on-page listing!
//
// BOOTSTRAP 3.8.8
//
if (!(function_exists('zca_bootstrap_active') && zca_bootstrap_active()) || $tplSetting->SHOW_SHIPPING_ESTIMATOR_BUTTON !== '1') {
    return;
}

require $template->get_template_dir('zen_addr_pulldowns.php', DIR_WS_TEMPLATE, $current_page_base, 'jscript') . '/zen_addr_pulldowns.php';
