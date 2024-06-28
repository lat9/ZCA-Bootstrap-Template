<?php
/*
 * BOOTSTRAP v3.6.5
 */
// -----
// Part of the Bootstrap template, defining commonly-used phrases and phrases unique to the bootstrap template.
//
$define = [
    'BOOTSTRAP_PLEASE_SELECT' => 'Please select ...',
    'BOOTSTRAP_CURRENT_ADDRESS' => ' (Currently Selected)',

// -----
// Additional buttons.
//
    'BUTTON_BACK_TO_TOP_TITLE' => 'Back to top',

// -----
// Used on the products_all and product listing for the alpha-filter dropdown.
// Note: Defined in multiple language files for zc158 and zc200!
//
    'TEXT_SHOW' => 'Filter by:',

// -----
// Used during checkout and on various address-rendering pages.
//
    'TEXT_SELECT_OTHER_PAYMENT_DESTINATION' => 'Please select the preferred billing address if the invoice to this order is to be delivered elsewhere.',
    'TEXT_SELECT_OTHER_SHIPPING_DESTINATION' => 'Please select the preferred shipping address if this order is to be delivered elsewhere.',
    'NEW_ADDRESS_TITLE' => 'Enter new address',
    'TEXT_PRIMARY_ADDRESS' => ' (Primary Address)',
    'PRIMARY_ADDRESS' => ' (Primary Address)',
    'TABLE_HEADING_ADDRESS_BOOK_ENTRIES' => 'Choose From Your Address Book Entries',

// -----
// Used on the product*_info pages.
//
    'TEXT_MULTIPLE_IMAGES' => ' Additional Images ',
    'TEXT_SINGLE_IMAGE' => ' Larger Image ',
    'PREV_NEXT_FROM' => ' from ',
    'IMAGE_BUTTON_PREVIOUS' => 'Previous Item',
    'IMAGE_BUTTON_NEXT' => 'Next Item',
    'IMAGE_BUTTON_RETURN_TO_PRODUCT_LIST' => 'Back to Product List',
    'MODAL_ADDL_IMAGE_PLACEHOLDER_ALT' => 'Modal Additional Images for %s',   //- %s is filled in with the product's name

// -----
// Used on the product_music_info page.
//
    'TEXT_ARTIST_URL' => 'For more information, please visit the Artist\'s <a href="%s" target="_blank">webpage</a>.',
    'TEXT_PRODUCT_RECORD_COMPANY' => 'Record Company: ',

// -----
// Used on the shopping_cart page.
//
    'TEXT_CART_MODAL_HELP' => '[help (?)]',
    'HEADING_TITLE_CART_MODAL' => 'Visitors Cart / Members Cart',
    'TEXT_CART_ARIA_HEADING_DELETE_COLUMN' => 'Click the icon in this column to delete it from your cart.',
    'TEXT_CART_ARIA_HEADING_UPDATE_COLUMN' => 'Click the icon in this column to update the quantity in your cart.',
// -----
// Used on various pages that display the cart's contents.
//
    'SUB_TITLE_TOTAL' => 'Total:',

// -----
// Used by various product listing pages, e.g. SNAF.
//
    // -----
    // The two image-heading constants are used when a site chooses to display listings
    // in table-mode (PRODUCT_LISTING_COLUMNS_PER_ROW is set to '1').  If your site wants
    // the image-heading to *always* be displayed, set the TABLE_HEADING_IMAGE value to
    // the text you desire.  If that value is set to an empty string, then a screen-reader-only
    // heading is used along with the TABLE_HEADING_IMAGE_SCREENREADER value.
    //
    'TABLE_HEADING_IMAGE' => '',
    'TABLE_HEADING_IMAGE_SCREENREADER' => 'Product Image',

    'TABLE_HEADING_PRODUCTS' => 'Product Name',
    'TABLE_HEADING_MANUFACTURER' => 'Manufacturer',
    'TABLE_HEADING_PRICE' => 'Price',
    'TABLE_HEADING_WEIGHT' => 'Weight',
    'TABLE_HEADING_BUY_NOW' => 'Buy Now',
    'TEXT_NO_PRODUCTS' => 'There are no products to list in this category.',
    'TEXT_NO_PRODUCTS2' => 'There is no product available from this manufacturer.',

// -----
// Used by various /modalboxes
//
    'TEXT_MODAL_CLOSE' => 'Close',
    'TEXT_MORE_INFO' => '[More Info]',
    'ARIA_REVIEW_STAR' => 'star',
    'ARIA_REVIEW_STARS' => 'stars',

// -----
// Overriding definition for the login page, removing unwanted javascript.
//
    'TEXT_VISITORS_CART' => '<strong>Note:</strong> If you have shopped with us before and left something in your cart, for your convenience, the contents will be merged if you log back in.',

// -----
// Used by the (optional) AJAX search feature.
//
    'TEXT_AJAX_SEARCH_TITLE' => 'What can we help you find?',
    'TEXT_AJAX_SEARCH_PLACEHOLDER' => 'Search here...',
    'TEXT_AJAX_SEARCH_RESULTS' => 'Total %u results found.',
    'TEXT_AJAX_SEARCH_VIEW_ALL' => 'View All',

// -----
// ARIA label text, used in the common header.
//
    'TEXT_HEADER_ARIA_LABEL_NAVBAR' =>'Navigation Bar',
    'TEXT_HEADER_ARIA_LABEL_LOGO' => 'Site Logo',

// -----
// <h1> text for index pages where the 'normal' heading-text isn't used by a
// store ... for accessibility.
//
// Note: For zc200, this constant will be in /includes/languages/english/lang.index.php.
//
    'HEADING_TITLE_SCREENREADER' => 'See Additional Content Below',
];
return $define;
