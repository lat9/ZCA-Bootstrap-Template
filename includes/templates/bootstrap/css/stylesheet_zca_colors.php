<style>
/* BOOTSTRAP4 Template v3.1.2 */
/* body */
body {color: <?php echo ZCA_BODY_TEXT_COLOR; ?>;background-color: <?php echo ZCA_BODY_BACKGROUND_COLOR; ?>;}
a {color: <?php echo ZCA_BUTTON_LINK_COLOR; ?>;}
a:hover {color: <?php echo ZCA_BUTTON_LINK_COLOR_HOVER; ?>;}
.form-control::-webkit-input-placeholder {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;} 
.form-control::-moz-placeholder {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;} 
.form-control:-ms-input-placeholder {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;}
.form-control::-ms-input-placeholder {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;}
.form-control::placeholder {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;}
.required-info, .alert {color: <?php echo ZCA_BODY_PLACEHOLDER; ?>;}

/* Nav Bar Active Links */
.activeLink {color: <?php echo ZCA_ACTIVE_LINK_COLOR; ?> !important;background-color: <?php echo ZCA_ACTIVE_LINK_BACKGROUND_COLOR; ?> !important;}

/* for button specific colors, examples are in stylesheet_css_buttons.css */
/* buttons */
.btn {color: <?php echo ZCA_BUTTON_TEXT_COLOR; ?>;background-color: <?php echo ZCA_BUTTON_COLOR; ?>;border-color: <?php echo ZCA_BUTTON_BORDER_COLOR; ?>;}
.btn:hover {color: <?php echo ZCA_BUTTON_TEXT_COLOR_HOVER; ?>;background-color: <?php echo ZCA_BUTTON_COLOR_HOVER; ?>;border-color: <?php echo ZCA_BUTTON_BORDER_COLOR_HOVER; ?>;}

/* header */
#headerWrapper {background-color: <?php echo ZCA_HEADER_WRAPPER_BACKGROUND_COLOR; ?>;}
#tagline {color: <?php echo ZCA_HEADER_TAGLINE_TEXT_COLOR; ?>;}

/* header nav bar */
nav.navbar {background-color: <?php echo ZCA_HEADER_NAV_BAR_BACKGROUND_COLOR; ?>;}

/* header nav bar links */
nav.navbar a.nav-link {color: <?php echo ZCA_HEADER_NAVBAR_LINK_COLOR; ?>;}
nav.navbar a.nav-link:hover {color: <?php echo ZCA_HEADER_NAVBAR_LINK_COLOR_HOVER; ?>;}

/* header nav bar buttons */
nav.navbar .navbar-toggler {color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR; ?>;background-color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_COLOR; ?>;border-color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR; ?>;}
nav.navbar .navbar-toggler:hover {color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR_HOVER; ?>;background-color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_COLOR_HOVER; ?>;border-color: <?php echo ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR_HOVER; ?>;}

/* header ezpage bar */
#ezpagesBarHeader {background-color: <?php echo ZCA_HEADER_EZPAGE_BACKGROUND_COLOR; ?>;}
#ezpagesBarHeader a.nav-link {color: <?php echo ZCA_HEADER_EZPAGE_LINK_COLOR; ?>;}
#ezpagesBarHeader a.nav-link:hover {color: <?php echo ZCA_HEADER_EZPAGE_LINK_COLOR_HOVER; ?>;background-color: <?php echo ZCA_HEADER_EZPAGE_BACKGROUND_COLOR_HOVER; ?>;}

/* header category tabs */
#navCatTabs a {color: <?php echo ZCA_HEADER_TABS_TEXT_COLOR; ?>;background-color: <?php echo ZCA_HEADER_TABS_BACKGROUND_COLOR; ?>;}
#navCatTabs a:hover {color: <?php echo ZCA_HEADER_TABS_TEXT_COLOR_HOVER; ?>;background-color: <?php echo ZCA_HEADER_TABS_BACKGROUND_COLOR_HOVER; ?>;}

/* bof items for extra navCatTabs settings */

/*  eof items for extra navCatTabs settings */

/*  bof Extra Colors for Standard Checkout  */
.bg-success {background-color: <?php echo ZCA_STD_CHECKOUT_PROGRESS_BAR_COLOR; ?> !important;}
/*  eof Extra Colors for Standard Checkout  */

/* breadcrumbs */
#navBreadCrumb ol {background-color: <?php echo ZCA_BODY_BREADCRUMBS_BACKGROUND_COLOR; ?>;}
#navBreadCrumb li {color: <?php echo ZCA_BODY_BREADCRUMBS_TEXT_COLOR; ?>;}
#navBreadCrumb li a {color: <?php echo ZCA_BODY_BREADCRUMBS_LINK_COLOR; ?>;}
#navBreadCrumb li a:hover {color: <?php echo ZCA_BODY_BREADCRUMBS_LINK_COLOR_HOVER; ?>;}

/* footer */
#footerWrapper {color: <?php echo ZCA_FOOTER_WRAPPER_TEXT_COLOR; ?>;background-color: <?php echo ZCA_FOOTER_WRAPPER_BACKGROUND_COLOR; ?>;}
.legalCopyright, .legalCopyright a {color: <?php echo ZCA_FOOTER_WRAPPER_TEXT_COLOR; ?>;}

/* footer ezpage bar */
#ezpagesBarFooter {background-color: <?php echo ZCA_FOOTER_EZPAGE_BACKGROUND_COLOR; ?>;}
#ezpagesBarFooter a.nav-link {color: <?php echo ZCA_FOOTER_EZPAGE_LINK_COLOR; ?>;}
#ezpagesBarFooter a.nav-link:hover {color: <?php echo ZCA_FOOTER_EZPAGE_LINK_COLOR_HOVER; ?>;}

/* sideboxes */
/* sideboxes card */
.leftBoxCard, .rightBoxCard {color: <?php echo ZCA_SIDEBOX_TEXT_COLOR; ?>;background-color: <?php echo ZCA_SIDEBOX_BACKGROUND_COLOR; ?>;}

/* sideboxes card header */
.leftBoxHeading, .rightBoxHeading {color: <?php echo ZCA_SIDEBOX_HEADER_TEXT_COLOR; ?>;background-color: <?php echo ZCA_SIDEBOX_HEADER_BACKGROUND_COLOR; ?>;}
.leftBoxHeading a, .rightBoxHeading a {color: <?php echo ZCA_SIDEBOX_HEADER_LINK_COLOR; ?>;}
.leftBoxHeading a:hover, .rightBoxHeading a:hover {color: <?php echo ZCA_SIDEBOX_HEADER_LINK_COLOR_HOVER; ?>;}
#categoriesContent .badge, #documentcategoriesContent .badge {color: <?php echo ZCA_SIDEBOX_COUNTS_COLOR; ?>;background-color: <?php echo ZCA_SIDEBOX_COUNTS_BACKGROUND_COLOR; ?>;}
.leftBoxCard .list-group-item, .rightBoxCard .list-group-item {color: <?php echo ZCA_SIDEBOX_LINK_COLOR; ?>;background-color: <?php echo ZCA_SIDEBOX_LINK_BACKGROUND_COLOR; ?>;}
.leftBoxCard .list-group-item:hover, .rightBoxCard .list-group-item:hover {color: <?php echo ZCA_SIDEBOX_LINK_COLOR_HOVER; ?>;background-color: <?php echo ZCA_SIDEBOX_LINK_BACKGROUND_COLOR_HOVER; ?>;}

/* centerboxes */
.centerBoxContents.card {color: <?php echo ZCA_CENTERBOX_TEXT_COLOR; ?>;background-color: <?php echo ZCA_CENTERBOX_BACKGROUND_COLOR; ?>;}
.centerBoxHeading {color: <?php echo ZCA_CENTERBOX_HEADER_TEXT_COLOR; ?>;background-color: <?php echo ZCA_CENTERBOX_HEADER_BACKGROUND_COLOR; ?>;}

/* category cards */
.categoryListBoxContents.card {color: <?php echo ZCA_CENTERBOX_TEXT_COLOR; ?>;background-color: <?php echo ZCA_CENTERBOX_BACKGROUND_COLOR; ?>;}
.categoryListBoxContents {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR; ?>;}
.categoryListBoxContents:hover {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;}

/* pagination links */
a.page-link {color: <?php echo ZCA_BUTTON_PAGEINATION_TEXT_COLOR; ?>;background-color: <?php echo ZCA_BUTTON_PAGEINATION_COLOR; ?>;border-color: <?php echo ZCA_BUTTON_PAGEINATION_BORDER_COLOR; ?>;}
a.page-link:hover {color: <?php echo ZCA_BUTTON_PAGEINATION_TEXT_COLOR_HOVER; ?>;background-color: <?php echo ZCA_BUTTON_PAGEINATION_COLOR_HOVER; ?>;border-color: <?php echo ZCA_BUTTON_PAGEINATION_BORDER_COLOR_HOVER; ?>;}
.page-item.active span.page-link {color: <?php echo ZCA_BUTTON_PAGEINATION_ACTIVE_TEXT_COLOR; ?>;background-color: <?php echo ZCA_BUTTON_PAGEINATION_ACTIVE_COLOR; ?>;}

/* product cards */
.sideBoxContentItem {background-color: <?php echo ZCA_SIDEBOX_CARD_BACKGROUND_COLOR; ?>;}
.sideBoxContentItem:hover {background-color: <?php echo ZCA_SIDEBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;}
.centerBoxContents {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR; ?>;}
.centerBoxContents:hover {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;}
.centerBoxContentsListing:hover {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;}
.listingProductImage {min-width: <?php echo (int)IMAGE_PRODUCT_LISTING_WIDTH; ?>px;}

/* product reviews */
.productReviewCard:hover {background-color: <?php echo ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER; ?>;}
.rating {color: <?php echo ZCA_RATING_STAR_COLOR; ?>;background-color: <?php echo ZCA_RATING_STAR_BACKGROUND_COLOR; ?>;}

/* product prices */
.productBasePrice {color: <?php echo ZCA_BODY_PRODUCTS_BASE_COLOR; ?>;}
.normalprice {color: <?php echo ZCA_BODY_PRODUCTS_NORMAL_COLOR; ?>;}
.productSpecialPrice {color: <?php echo ZCA_BODY_PRODUCTS_SPECIAL_COLOR; ?>;}
.productPriceDiscount {color: <?php echo ZCA_BODY_PRODUCTS_DISCOUNT_COLOR; ?>;}
.productSalePrice {color: <?php echo ZCA_BODY_PRODUCTS_SALE_COLOR; ?>;}
.productFreePrice {color: <?php echo ZCA_BODY_PRODUCTS_FREE_COLOR; ?>;}

/* product info pages */
<?php
// -----
// Additional coloring for v3.1.2.
//
if (defined('ZCA_ADD_TO_CART_TEXT_COLOR')) {
?>
#addToCart-card-header {color: <?php echo ZCA_ADD_TO_CART_TEXT_COLOR; ?> !important; background-color: <?php echo ZCA_ADD_TO_CART_BACKGROUND_COLOR; ?> !important;}
#addToCart-card {border-color: <?php echo ZCA_ADD_TO_CART_BORDER_COLOR; ?>;}
<?php
}

if (defined('ZCA_BUTTON_IN_CART_BACKGROUND_COLOR')) {
?>
.btn.button_add_selected {background:<?php echo ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR; ?>;color:<?php echo ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR; ?>;}
.btn.button_add_selected:hover {background:<?php echo ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR_HOVER; ?>;color:<?php echo ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR_HOVER; ?>;}
.btn.button_in_cart {background:<?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR; ?>;color:<?php echo ZCA_BUTTON_IN_CART_TEXT_COLOR; ?>;}
.btn.button_in_cart:hover {background:<?php echo ZCA_BUTTON_IN_CART_BACKGROUND_COLOR_HOVER; ?>;color:<?php echo ZCA_BUTTON_IN_CART_TEXT_COLOR_HOVER; ?>;}
<?php
}
?>
</style>
