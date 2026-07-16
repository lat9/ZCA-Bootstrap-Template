<?php
// -----
// Part of the ZCA Bootstrap template, @zcadditions, @lat9
//
// BOOTSTRAP 3.7.4
//
// A collection of 'soft' configuration settings for use by the ZCA Bootstrap Template
// and its clones.
//
// For use on YOUR site, make a copy of this file (which has all entries commented-out) to
// /includes/extra_datafiles/site-specific-bootstrap-settings.php and make your edits there.
// Otherwise, your overrides might get "lost" on a future Bootstrap template update.
//

// -----
// This control instructs the zca_js_zone_list function whether to use a zone's zone_id (false, default)
// or zone_code (true) as the 'key' to the zone's name in the generated JSON array.
//
//$zca_js_zone_list_use_zone_code = false;

// -----
// This control, used at the bottom of tpl_main_page.php, indicates whether (false, the default) or not
// (true) to disable the back-to-top control on each page.
//
//$zca_disable_back_to_top = false;

// -----
// This control can eliminate categories from displaying if they have no products in them.
// Change to false if you don't want categories with no products to be displayed.
// @proseLA
//
// Note: Setting this to (bool)false has effect **only if** Configuration :: My Store :: Show Category Counts
// is set to 'true'!
//
//$zca_include_zero_product_categories = true;

// ----
// This controls preloading of fontawesome, jquery and boostrap css.
// If you don't want to preload the scripts and css, uncomment line below and
// change the variable's value to (bool)true.
//
//$zca_no_preloading = false;

// -----
// Checkout Shipping: when no shipping method is available, i.e. Checkout cannot proceed to Payment
//
// true .... Replace the "Continue" button with a "Contact Us" button/link.
// false ... Maintain the "Continue" button, which redirects back to Checkout Shipping; this is the default.
//
//$zca_show_contact_us_instead_of_continue = false;

// -----
// Include fontawesome brands icons?
//
// true .... Load the brands icons.
// false ... Don't load the brands icons; this is the default.
//
//$zca_load_fa_brands = false;