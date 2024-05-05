<?php
// -----
// Part of the Bootstrap template, assigning colors based on those configured.
//
// BOOTSTRAP v3.6.0
//
// Starting with Bootstrap v3.5.2, any color-specifications defined in that and follow-on
// versions start out, on an upgrade, with a value of 'not-set' to give the site a chance
// to define those colors to be compatible with the site's color scheme.
//
$zca_bootstrap_colors_added = [
    // -----
    // Added in v3.5.2.
    //
    'ZCA_BODY_RATING_STAR_BACKGROUND_COLOR',
    'ZCA_BODY_RATING_STAR_COLOR',
    'ZCA_HEADER_TABS_BORDER_COLOR',
    'ZCA_HEADER_TABS_BORDER_COLOR_HOVER',
    'ZCA_HEADER_TABS_ACTIVE_BACKGROUND_COLOR',
    'ZCA_HEADER_TABS_ACTIVE_BACKGROUND_COLOR_HOVER',
    'ZCA_HEADER_TABS_ACTIVE_COLOR',
    'ZCA_HEADER_TABS_ACTIVE_COLOR_HOVER',
    'ZCA_HEADER_TABS_ACTIVE_BORDER_COLOR',
    'ZCA_HEADER_TABS_ACTIVE_BORDER_COLOR_HOVER',
    'ZCA_HEADER_EZPAGE_BACKGROUND_COLOR_HOVER',
    'ZCA_FOOTER_EZPAGE_BACKGROUND_COLOR_HOVER',
    'ZCA_CHECKOUT_PROGRESS_BAR_BACKGROUND_COLOR',
    'ZCA_CHECKOUT_CONTINUE_BACKGROUND_COLOR',
    'ZCA_CHECKOUT_CONTINUE_BACKGROUND_COLOR_HOVER',
    'ZCA_CHECKOUT_CONTINUE_COLOR',
    'ZCA_CHECKOUT_CONTINUE_COLOR_HOVER',
    'ZCA_CHECKOUT_CONTINUE_BORDER_COLOR',
    'ZCA_CHECKOUT_CONTINUE_BORDER_COLOR_HOVER',
    'ZCA_CHECKOUT_CONFIRM_BACKGROUND_COLOR',
    'ZCA_CHECKOUT_CONFIRM_BACKGROUND_COLOR_HOVER',
    'ZCA_CHECKOUT_CONFIRM_COLOR',
    'ZCA_CHECKOUT_CONFIRM_COLOR_HOVER',
    'ZCA_CHECKOUT_CONFIRM_BORDER_COLOR',
    'ZCA_CHECKOUT_CONFIRM_BORDER_COLOR_HOVER',
    'ZCA_CAROUSEL_PREV_NEXT_COLOR',
    'ZCA_CAROUSEL_PREV_NEXT_COLOR_HOVER',
    'ZCA_CAROUSEL_BANNER_INDICATORS_BACKGROUND_COLOR',
    'ZCA_PRIMARY_ADDRESS_ADDRESS_BACKGROUND_COLOR',
    'ZCA_PRIMARY_ADDRESS_ADDRESS_COLOR',
    'ZCA_PRIMARY_ADDRESS_CARD_HEADER_BACKGROUND_COLOR',
    'ZCA_PRIMARY_ADDRESS_CARD_HEADER_COLOR',
    'ZCA_PRIMARY_ADDRESS_CARD_BORDER_COLOR',

    // -----
    // Added in v3.6.0
    //
    'ZCA_ALERT_INFO_COLOR',
    'ZCA_ALERT_INFO_BACKGROUND_COLOR',
    'ZCA_ALERT_INFO_BORDER_COLOR',
    'ZCA_HEADER_NAVBAR_LINK_BACKGROUND_COLOR_HOVER',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_TEXT_COLOR',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_TEXT_COLOR_HOVER',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BACKGROUND_COLOR',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BACKGROUND_COLOR_HOVER',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BORDER_COLOR',
    'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BORDER_COLOR_HOVER',
    'ZCA_SOLD_OUT_BACKGROUND_COLOR',
    'ZCA_SOLD_OUT_COLOR',
    'ZCA_SOLD_OUT_BORDER_COLOR',
];

// -----
// There are a couple of "mis-named" color-configuration settings (these are 'legacy'
// and won't be changed in the database).  For the purists amongst us, set definitions
// that are used below (as of v3.6.0) that make more sense.
//
if (!defined('ZCA_BUTTON_BACKGROUND_COLOR')) {
    define('ZCA_BUTTON_BACKGROUND_COLOR', ZCA_BUTTON_COLOR);
}
if (!defined('ZCA_BUTTON_BACKGROUND_COLOR_HOVER')) {
    define('ZCA_BUTTON_BACKGROUND_COLOR_HOVER', ZCA_BUTTON_COLOR_HOVER);
}
if (!defined('ZCA_HEADER_TABS_BACKGROUND_COLOR')) {
    define('ZCA_HEADER_TABS_BACKGROUND_COLOR', ZCA_HEADER_TABS_COLOR);
}
if (!defined('ZCA_HEADER_TABS_BACKGROUND_COLOR_HOVER')) {
    define('ZCA_HEADER_TABS_BACKGROUND_COLOR_HOVER', ZCA_HEADER_TABS_COLOR_HOVER);
}

// -----
// Ditto for some of the color-settings that affect *only* the hamburger-menu-icon used
// on the mobile display.  Define aliases for use in the CSS-generating portion of this
// script for clarity.
//
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_COLOR')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_COLOR', ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR);
}
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_COLOR_HOVER')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_COLOR_HOVER', ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR_HOVER);
}
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR', ZCA_HEADER_NAVBAR_BUTTON_COLOR);
}
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR_HOVER')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR_HOVER', ZCA_HEADER_NAVBAR_BUTTON_COLOR_HOVER);
}
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR', ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR);
}
if (!defined('ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR_HOVER')) {
    define('ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR_HOVER', ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR_HOVER);
}

// -----
// Each of the newly-added color values is saved as a lower-case variable
// of the same name, e.g. ZCA_BODY_RATING_STAR_COLOR becomes $zca_body_rating_star_color)
// whose value is either the associated constant's value (if the constant's defined and
// its value is not 'not-set') or an empty string (for which the associated style will not
// be included).
//
foreach ($zca_bootstrap_colors_added as $next_color) {
    $next_color_varname = strtolower($next_color);
    $$next_color_varname = ((defined($next_color) && constant($next_color) !== 'not-set') ? constant($next_color) : '');
}
?>
<style>
<?php
//- Body
?>
body {
    color: <?php echo ZCA_BODY_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_BODY_BACKGROUND_COLOR; ?>;
}
a {
    color: <?php echo ZCA_BUTTON_LINK_COLOR; ?>;
}
a:hover {
    color: <?php echo ZCA_BUTTON_LINK_COLOR_HOVER; ?>;
}
.form-control::placeholder,
.required-info,
span.alert {
    color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;
}
.alert-info {
    <?php echo ($zca_alert_info_color !== '') ? "color: $zca_alert_info_color;" : ''; ?>
    <?php echo ($zca_alert_info_background_color !== '') ? "background-color: $zca_alert_info_background_color;" : ''; ?>
    <?php echo ($zca_alert_info_border_color !== '') ? "border-color: $zca_alert_info_border_color;" : ''; ?>
}
.rating {
    <?php echo ($zca_body_rating_star_background_color !== '') ? "background-color: $zca_body_rating_star_background_color;" : ''; ?>
    <?php echo ($zca_body_rating_star_color !== '') ? "color: $zca_body_rating_star_color;" : ''; ?>
}
<?php
//- Buttons
?>
.btn {
    color: <?php echo ZCA_BUTTON_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_BUTTON_BACKGROUND_COLOR; ?>;
    border-color: <?php echo ZCA_BUTTON_BORDER_COLOR; ?>;
}
.btn:hover {
    color: <?php echo ZCA_BUTTON_TEXT_COLOR_HOVER; ?>;
    background-color: <?php echo ZCA_BUTTON_BACKGROUND_COLOR_HOVER; ?>;
    border-color: <?php echo ZCA_BUTTON_BORDER_COLOR_HOVER; ?>;
}
<?php
//- Base header
?>
#headerWrapper {
    background-color: <?php echo ZCA_HEADER_WRAPPER_BACKGROUND_COLOR; ?>;
}
#tagline {
    color: <?php echo ZCA_HEADER_TAGLINE_TEXT_COLOR; ?>;
}
<?php
//- Header navbar
?>
nav.navbar {
    background-color: <?php echo ZCA_HEADER_NAV_BAR_BACKGROUND_COLOR; ?>;
}
nav.navbar a.nav-link {
    color: <?php echo ZCA_HEADER_NAVBAR_LINK_COLOR; ?>;
}
nav.navbar a.nav-link:hover {
    color: <?php echo ZCA_HEADER_NAVBAR_LINK_COLOR_HOVER; ?>;
    <?php echo ($zca_header_navbar_link_background_color_hover !== '') ? "background-color: $zca_header_navbar_link_background_color_hover;" : ''; ?>
}
nav.navbar .navbar-toggler {
    color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_COLOR; ?>;
    background-color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR; ?>;
    border-color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR; ?>;
}
nav.navbar .navbar-toggler:hover {
    color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_COLOR_HOVER; ?>;
    background-color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR_HOVER; ?>;
    border-color: <?php echo ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR_HOVER; ?>;
}
nav.navbar .btn {
    <?php echo ($zca_header_navbar_extra_button_text_color !== '') ? "color: $zca_header_navbar_extra_button_text_color;" : ''; ?>
    <?php echo ($zca_header_navbar_extra_button_background_color !== '') ? "background-color: $zca_header_navbar_extra_button_background_color;" : ''; ?>
    <?php echo ($zca_header_navbar_extra_button_border_color !== '') ? "border-color: $zca_header_navbar_extra_button_border_color;" : ''; ?>
}
nav.navbar .btn:hover {
    <?php echo ($zca_header_navbar_extra_button_text_color_hover !== '') ? "color: $zca_header_navbar_extra_button_text_color_hover;" : ''; ?>
    <?php echo ($zca_header_navbar_extra_button_background_color_hover !== '') ? "background-color: $zca_header_navbar_extra_button_background_color_hover;" : ''; ?>
    <?php echo ($zca_header_navbar_extra_button_border_color_hover !== '') ? "border-color: $zca_header_navbar_extra_button_border_color_hover;" : ''; ?>
}
<?php
//- Header EZ-Pages Bar
?>
#ezpagesBarHeader {
    background-color: <?php echo ZCA_HEADER_EZPAGE_BACKGROUND_COLOR; ?>;
}
#ezpagesBarHeader a.nav-link {
    color: <?php echo ZCA_HEADER_EZPAGE_LINK_COLOR; ?>;
}
#ezpagesBarHeader a.nav-link:hover {
    color: <?php echo ZCA_HEADER_EZPAGE_LINK_COLOR_HOVER; ?>;
    <?php echo ($zca_header_ezpage_background_color_hover !== '') ? "background-color: $zca_header_ezpage_background_color_hover;" : ''; ?>
}
<?php
//- Header Category Tabs
?>
#navCatTabs a {
    color: <?php echo ZCA_HEADER_TABS_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_HEADER_TABS_BACKGROUND_COLOR; ?>;
    <?php echo ($zca_header_tabs_border_color !== '') ? "border-color: $zca_header_tabs_border_color;" : ''; ?>
}
#navCatTabs a.activeLink {
    <?php echo ($zca_header_tabs_active_background_color !== '') ? "background-color: $zca_header_tabs_active_background_color;" : ''; ?>
    <?php echo ($zca_header_tabs_active_color !== '') ? "color: $zca_header_tabs_active_color;" : ''; ?>
    <?php echo ($zca_header_tabs_active_border_color !== '') ? "border-color: $zca_header_tabs_active_border_color;" : ''; ?>
}
#navCatTabs a:hover {
    color: <?php echo ZCA_HEADER_TABS_TEXT_COLOR_HOVER; ?>;
    background-color: <?php echo ZCA_HEADER_TABS_BACKGROUND_COLOR_HOVER; ?>;
    <?php echo ($zca_header_tabs_border_color_hover !== '') ? "border-color: $zca_header_tabs_border_color_hover;" : ''; ?>
}
#navCatTabs a.activeLink:hover {
    <?php echo ($zca_header_tabs_active_background_color_hover !== '') ? "background-color: $zca_header_tabs_active_background_color_hover;" : ''; ?>
    <?php echo ($zca_header_tabs_active_color_hover !== '') ? "color: $zca_header_tabs_active_color_hover;" : ''; ?>
    <?php echo ($zca_header_tabs_active_border_color_hover !== '') ? "border-color: $zca_header_tabs_active_border_color_hover;" : ''; ?>
}
<?php
//- Breadcrumbs
?>
#navBreadCrumb ol {
    background-color: <?php echo ZCA_BODY_BREADCRUMBS_BACKGROUND_COLOR; ?>;
}
#navBreadCrumb li {
    color: <?php echo ZCA_BODY_BREADCRUMBS_TEXT_COLOR; ?>;
}
#navBreadCrumb li a {
    color: <?php echo ZCA_BODY_BREADCRUMBS_LINK_COLOR; ?>;
}
#navBreadCrumb li a:hover {
    color: <?php echo ZCA_BODY_BREADCRUMBS_LINK_COLOR_HOVER; ?>;
}
<?php
//- Footer
?>
#footerWrapper {
    color: <?php echo ZCA_FOOTER_WRAPPER_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_FOOTER_WRAPPER_BACKGROUND_COLOR; ?>;
}
.legalCopyright,
.legalCopyright a {
    color: <?php echo ZCA_FOOTER_WRAPPER_TEXT_COLOR; ?>;
}
#ezpagesBarFooter {
    background-color: <?php echo ZCA_FOOTER_EZPAGE_BACKGROUND_COLOR; ?>;
}
#ezpagesBarFooter a.nav-link {
    color: <?php echo ZCA_FOOTER_EZPAGE_LINK_COLOR; ?>;
}
#ezpagesBarFooter a.nav-link:hover {
    color: <?php echo ZCA_FOOTER_EZPAGE_LINK_COLOR_HOVER; ?>;
    <?php echo ($zca_footer_ezpage_background_color_hover !== '') ? "background-color: $zca_footer_ezpage_background_color_hover;" : ''; ?>
}
<?php
//- Sideboxes
?>
.leftBoxCard,
.rightBoxCard {
    color: <?php echo ZCA_SIDEBOX_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_SIDEBOX_BACKGROUND_COLOR; ?>;
}
.leftBoxHeading,
.rightBoxHeading {
    color: <?php echo ZCA_SIDEBOX_HEADER_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_SIDEBOX_HEADER_BACKGROUND_COLOR; ?>;
}
.leftBoxHeading a,
.rightBoxHeading a {
    color: <?php echo ZCA_SIDEBOX_HEADER_LINK_COLOR; ?>;
}
.leftBoxHeading a:hover,
.rightBoxHeading a:hover {
    color: <?php echo ZCA_SIDEBOX_HEADER_LINK_COLOR_HOVER; ?>;
}
#categoriesContent .badge,
#documentcategoriesContent .badge {
    color: <?php echo ZCA_SIDEBOX_COUNTS_COLOR; ?>;
    background-color: <?php echo ZCA_SIDEBOX_COUNTS_BACKGROUND_COLOR; ?>;
}
.leftBoxCard .list-group-item,
.rightBoxCard .list-group-item {
    color: <?php echo ZCA_SIDEBOX_LINK_COLOR; ?>;
    background-color: <?php echo ZCA_SIDEBOX_LINK_BACKGROUND_COLOR; ?>;
}
.leftBoxCard .list-group-item:hover,
.rightBoxCard .list-group-item:hover {
    color: <?php echo ZCA_SIDEBOX_LINK_COLOR_HOVER; ?>;
    background-color: <?php echo ZCA_SIDEBOX_LINK_BACKGROUND_COLOR_HOVER; ?>;
}
<?php
//- Centerboxes
?>
.centerBoxContents.card {
    color: <?php echo ZCA_CENTERBOX_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_CENTERBOX_BACKGROUND_COLOR; ?>;
}
.centerBoxHeading {
    color: <?php echo ZCA_CENTERBOX_HEADER_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_CENTERBOX_HEADER_BACKGROUND_COLOR; ?>;
}
<?php
//- Category cards
?>
.categoryListBoxContents.card {
    color: <?php echo ZCA_CENTERBOX_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_CENTERBOX_BACKGROUND_COLOR; ?>;
}
.categoryListBoxContents {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR; ?>;
}
.categoryListBoxContents:hover {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;
}
<?php
//- Pagination links
?>
a.page-link {
    color: <?php echo ZCA_BUTTON_PAGEINATION_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_BUTTON_PAGEINATION_COLOR; ?>;
    border-color: <?php echo ZCA_BUTTON_PAGEINATION_BORDER_COLOR; ?>;
}
a.page-link:hover {
    color: <?php echo ZCA_BUTTON_PAGEINATION_TEXT_COLOR_HOVER; ?>;
    background-color: <?php echo ZCA_BUTTON_PAGEINATION_COLOR_HOVER; ?>;
    border-color: <?php echo ZCA_BUTTON_PAGEINATION_BORDER_COLOR_HOVER; ?>;
}
.page-item.active span.page-link {
    color: <?php echo ZCA_BUTTON_PAGEINATION_ACTIVE_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_BUTTON_PAGEINATION_ACTIVE_COLOR; ?>;
}
<?php
//- Product cards
?>
.sideBoxContentItem {
    background-color: <?php echo ZCA_SIDEBOX_CARD_BACKGROUND_COLOR; ?>;
}
.sideBoxContentItem:hover {
    background-color: <?php echo ZCA_SIDEBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;
}
.centerBoxContents {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR; ?>;
}
.centerBoxContents:hover {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;
}
.centerBoxContentsListing:hover {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;
}
.listingProductImage {
    min-width: <?php echo (int)IMAGE_PRODUCT_LISTING_WIDTH; ?>px;
}
<?php
//- Product reviews
?>
.productReviewCard:hover {
    background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;
}
<?php
//- Product pricing
?>
.productBasePrice {
    color: <?php echo ZCA_BODY_PRODUCTS_BASE_COLOR; ?>;
}
.normalprice {
    color: <?php echo ZCA_BODY_PRODUCTS_NORMAL_COLOR; ?>;
}
.productSpecialPrice {
    color: <?php echo ZCA_BODY_PRODUCTS_SPECIAL_COLOR; ?>;
}
.productPriceDiscount {
    color: <?php echo ZCA_BODY_PRODUCTS_DISCOUNT_COLOR; ?>;
}
.productSalePrice {
    color: <?php echo ZCA_BODY_PRODUCTS_SALE_COLOR; ?>;
}
.productFreePrice {
    color: <?php echo ZCA_BODY_PRODUCTS_FREE_COLOR; ?>;
}
<?php
// -----
// Additional coloring for v3.1.2.
//
if (defined('ZCA_ADD_TO_CART_TEXT_COLOR')) {
?>
#addToCart-card-header {
    color: <?php echo ZCA_ADD_TO_CART_TEXT_COLOR; ?>;
    background-color: <?php echo ZCA_ADD_TO_CART_BACKGROUND_COLOR; ?>;
}
#addToCart-card {
    border-color: <?php echo ZCA_ADD_TO_CART_BORDER_COLOR; ?>;
}
<?php
}

if (defined('ZCA_BUTTON_IN_CART_BACKGROUND_COLOR')) {
?>
.btn.button_add_selected {
    background: <?php echo ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR; ?>;
    color: <?php echo ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR; ?>;
}
.btn.button_add_selected:hover {
    background: <?php echo ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR_HOVER; ?>;
    color:<?php echo ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR_HOVER; ?>;
}
.btn.button_in_cart {
    background: <?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR; ?>;
    color: <?php echo ZCA_BUTTON_IN_CART_TEXT_COLOR; ?>;
}
.fa-cart-plus {
    color: <?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR; ?>;
}
.btn.button_in_cart:hover {
    background: <?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR_HOVER; ?>;
    color: <?php echo ZCA_BUTTON_IN_CART_TEXT_COLOR_HOVER; ?>;
}
a:hover > .fa-cart-plus {
    color: <?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR_HOVER; ?>;
}
<?php
}
//- Checkout buttons and progress-bar
?>
button.button_continue_checkout,
a.button_checkout {
    <?php echo ($zca_checkout_continue_background_color !== '') ? "background-color: $zca_checkout_continue_background_color;" : ''; ?>
    <?php echo ($zca_checkout_continue_color !== '') ? "color: $zca_checkout_continue_color;" : ''; ?>
    <?php echo ($zca_checkout_continue_border_color !== '') ? "border-color: $zca_checkout_continue_border_color;" : ''; ?>
}
button.button_continue_checkout:hover,
a.button_checkout:hover {
    <?php echo ($zca_checkout_continue_background_color_hover !== '') ? "background-color: $zca_checkout_continue_background_color_hover;" : ''; ?>
    <?php echo ($zca_checkout_continue_color_hover !== '') ? "color: $zca_checkout_continue_color_hover;" : ''; ?>
    <?php echo ($zca_checkout_continue_border_color_hover !== '') ? "border-color: $zca_checkout_continue_border_color_hover;" : ''; ?>
}
button.button_confirm_order {
    <?php echo ($zca_checkout_confirm_background_color !== '') ? "background-color: $zca_checkout_confirm_background_color;" : ''; ?>
    <?php echo ($zca_checkout_confirm_color !== '') ? "color: $zca_checkout_confirm_color;" : ''; ?>
    <?php echo ($zca_checkout_confirm_border_color !== '') ? "border-color: $zca_checkout_confirm_border_color;" : ''; ?>
}
button.button_confirm_order:hover {
    <?php echo ($zca_checkout_confirm_background_color_hover !== '') ? "background-color: $zca_checkout_confirm_background_color_hover;" : ''; ?>
    <?php echo ($zca_checkout_confirm_color_hover !== '') ? "color: $zca_checkout_confirm_color_hover;" : ''; ?>
    <?php echo ($zca_checkout_confirm_border_color_hover !== '') ? "border-color: $zca_checkout_confirm_border_color_hover;" : ''; ?>
}
#checkoutShippingDefault .progress-bar,
#checkoutPayment .progress-bar,
#checkoutConfirmationDefault .progress-bar,
#checkoutSuccessDefault .progress-bar {
    <?php echo ($zca_checkout_progress_bar_background_color !== '') ? "background-color: $zca_checkout_progress_bar_background_color!important;" : ''; ?>
}
<?php
//- "Sold Out" button colors (it's not a hoverable/clickable button).
?>
button.button_sold_out_sm, button.button_sold_out_sm:hover, button.button_sold_out, button.button_sold_out:hover {
    <?php echo ($zca_sold_out_background_color !== '') ? "background-color: $zca_sold_out_background_color;" : ''; ?>
    <?php echo ($zca_sold_out_color !== '') ? "color: $zca_sold_out_color;" : ''; ?>
    <?php echo ($zca_sold_out_border_color !== '') ? "border-color: $zca_sold_out_border_color;" : ''; ?>
}
<?php
//- Carousel prev/next and indicators
?>
a.carousel-control-prev,
a.carousel-control-next {
    <?php echo ($zca_carousel_prev_next_color !== '') ? "color: $zca_carousel_prev_next_color;" : ''; ?>
}
a.carousel-control-prev:hover,
a.carousel-control-next:hover {
    <?php echo ($zca_carousel_prev_next_color_hover !== '') ? "color: $zca_carousel_prev_next_color_hover;" : ''; ?>
}
.banner-carousel .carousel-indicators li {
    <?php echo ($zca_carousel_banner_indicators_background_color !== '') ? "background-color: $zca_carousel_banner_indicators_background_color;" : ''; ?>
}
<?php
//- Primary address <address> and cards
?>
.defaultAddress address {
    <?php echo ($zca_primary_address_address_background_color !== '') ? "background-color: $zca_primary_address_address_background_color;" : ''; ?>
    <?php echo ($zca_primary_address_address_color !== '') ? "color: $zca_primary_address_address_color;" : ''; ?>
}
.card.primary-address {
    <?php echo ($zca_primary_address_card_border_color !== '') ? "border-color: $zca_primary_address_card_border_color;" : ''; ?>
}
.card.primary-address > .card-header{
    <?php echo ($zca_primary_address_card_header_background_color !== '') ? "background-color: $zca_primary_address_card_header_background_color;" : ''; ?>
    <?php echo ($zca_primary_address_card_header_color !== '') ? "color: $zca_primary_address_card_header_color;" : ''; ?>
}
</style>
