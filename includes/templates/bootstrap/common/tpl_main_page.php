<?php
/**
 * Common Template - tpl_main_page.php
 * 
 * BOOTSTRAP v3.7.3
 *
 * Governs the overall layout of an entire page
 * Normally consisting of a header, left side column. center column. right side column and footer
 * For customizing, this file can be copied to /templates/your_template_dir/pagename
 * example: to override the privacy page
 * - make a directory /templates/my_template/privacy
 * - copy /templates/templates_defaults/common/tpl_main_page.php to /templates/my_template/privacy/tpl_main_page.php
 * 
 * to override the global settings and turn off columns un-comment the lines below for the correct column to turn off
 * to turn off the header and/or footer uncomment the lines below
 * Note: header can be disabled in the tpl_header.php
 * Note: footer can be disabled in the tpl_footer.php
 * 
 * $flag_disable_header = true;
 * $flag_disable_left = true;
 * $flag_disable_right = true;
 * $flag_disable_footer = true;
 * 
 * // example to not display right column on main page when Always Show Categories is OFF
 * 
 * if ($current_page_base == 'index' and $cPath == '') {
 *  $flag_disable_right = true;
 * }
 * 
 * example to not display right column on main page when Always Show Categories is ON and set to categories_id 3
 * 
 * if ($current_page_base == 'index' and $cPath == '' or $cPath == '3') {
 *  $flag_disable_right = true;
 * }
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Aug 10 Modified in v1.5.7a $
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

/** bof DESIGNER TESTING ONLY: */
// $messageStack->add('header', 'this is a sample error message', 'error');
// $messageStack->add('header', 'this is a sample caution message', 'caution');
// $messageStack->add('header', 'this is a sample success message', 'success');
// $messageStack->add('main', 'this is a sample error message', 'error');
// $messageStack->add('main', 'this is a sample caution message', 'caution');
// $messageStack->add('main', 'this is a sample success message', 'success');
/** eof DESIGNER TESTING ONLY */

// the following IF statement can be duplicated/modified as needed to set additional flags
if (in_array($current_page_base, explode(',', str_replace(' ', '', 'product_info, document_general_info, document_product_info, product_music_info, product_free_shipping_info, shopping_cart, checkout_shipping, checkout_shipping_address, checkout_payment, checkout_payment_address, checkout_confirmation, checkout_success')))) {
    $flag_disable_right = true;
}
if (in_array($current_page_base, explode(',', str_replace(' ', '', 'checkout_shipping, checkout_shipping_address, checkout_payment, checkout_payment_address, checkout_confirmation')))) {
    $flag_disable_left = true;
}

// ZCA BOOTSTRAP TEMPLATE
if (!empty($flag_disable_right) || COLUMN_RIGHT_STATUS === '0' || SET_COLUMN_RIGHT_LAYOUT === '0') {
    $flag_disable_right = true;
    $box_width_right = '0';
    $box_width_right_new = '';
} else {
    $box_width_right = SET_COLUMN_RIGHT_LAYOUT;
    $box_width_right_new = 'col-sm-' . SET_COLUMN_RIGHT_LAYOUT . ' d-none d-lg-block';
}

if (!empty($flag_disable_left) || COLUMN_LEFT_STATUS === '0' || SET_COLUMN_LEFT_LAYOUT === '0') {
    $flag_disable_left = true;
    $box_width_left = '0';
    $box_width_left_new = '';
} else {
    $box_width_left = SET_COLUMN_LEFT_LAYOUT;
    $box_width_left_new = 'col-sm-' . SET_COLUMN_LEFT_LAYOUT . ' d-none d-lg-block';
}

$side_columns_total = $box_width_left + $box_width_right;
$center_column = '12'; // This value should not be altered
$center_column_width = $center_column - $side_columns_total;

// -----
// Added in v3.7.0, create arrays from the configured list of sideboxes
// to be displayed in 'carousel' mode.  These arrays are used by the
// supported sideboxes to determine the mode in which they display.
//
$sidebox_carousels = explode(',', str_replace([' ', "\n", "\r"], '', BS4_SIDEBOXES_DISPLAY_CAROUSEL));
$sidebox_carousels_to_fade = explode(',', str_replace([' ', "\n", "\r"], '', BS4_SIDEBOXES_FADE_CAROUSEL));

$body_id = ($this_is_home_page) ? 'indexHome' : str_replace('_', '', $_GET['main_page']);
$body_onload = ($zv_onload !== '') ? ' onload="' . $zv_onload . '"' : '';
?>
<body id="<?=  $body_id . 'Body' ?>"<?= $body_onload ?>>
<?php
if (defined('BS4_AJAX_SEARCH_ENABLE') && BS4_AJAX_SEARCH_ENABLE === 'true') {
    require $template->get_template_dir('tpl_ajax_search.php', DIR_WS_TEMPLATE, $current_page_base, 'modalboxes') . '/tpl_ajax_search.php';
}
?>
<div class="<?= BS4_HEADER_CONTAINER ?>" id="header-wrapper">
<?php
// -----
// Define the spacer-div that pushes either the "Header Position 1" banner or
// the logoWrapper in the header down under the navigation bar .. whichever comes first!
//
$navbar_spacer = '<div id="navbar-spacer" class="mt-5 pt-4"></div>';

if (SHOW_BANNERS_GROUP_SET1 !== '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET1)) {
    if ($banner->RecordCount() > 0) {
        $find_banners = zen_build_banners_group(SHOW_BANNERS_GROUP_SET1);
        $banner_group = 1;

        // -----
        // Output the navbar's spacer div and then set it to an empty string so that
        // it won't be output a second time by tpl_header.php.
        //
        echo $navbar_spacer;
        $navbar_spacer = '';
?>
    <div class="zca-banner bannerOne rounded">
<?php 
        if (ZCA_ACTIVATE_BANNER_ONE_CAROUSEL === 'true') {
            require $template->get_template_dir('tpl_zca_banner_carousel.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_zca_banner_carousel.php'; 
        } else {
            echo zen_display_banner('static', $banner);
        }
?>
    </div>
<?php
    }
}
?>
    <div class="row mb-3">
        <div class="col">
<?php
/**
* prepares and displays header output
*
*/
if (CUSTOMERS_APPROVAL_AUTHORIZATION === '1' && CUSTOMERS_AUTHORIZATION_HEADER_OFF === 'true' && ($_SESSION['customers_authorization'] != 0 || !zen_is_logged_in())) {
    $flag_disable_header = true;
}
require $template->get_template_dir('tpl_header.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_header.php';
?>

        </div>
    </div>
</div>

<div id="mainWrapper" class="<?= BS4_MAIN_CONTAINER ?>">
    <div class="row">
<?php
if (COLUMN_LEFT_STATUS === '0' || (CUSTOMERS_APPROVAL === '1' && !zen_is_logged_in()) || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_LEFT_OFF === 'true' && ($_SESSION['customers_authorization'] != 0 || !zen_is_logged_in()))) {
    // global disable of column_left
    $flag_disable_left = true;
}
if (empty($flag_disable_left)) {
?> 
        <div id="navColumnOne" class="<?=  $box_width_left_new ?>">
<?php
 /**
  * prepares and displays left column sideboxes
  *
  */
?>
            <div id="navColumnOneWrapper">
                <?php require DIR_WS_MODULES . zen_get_module_directory('column_left.php'); ?>
            </div>
        </div>
<?php
}
?>
        <div class="col-12 col-lg-<?=  $center_column_width ?>">
<?php
if (!$breadcrumb->isEmpty() && (DEFINE_BREADCRUMB_STATUS === '1' || (DEFINE_BREADCRUMB_STATUS === '2' && !$this_is_home_page))) {
?>
            <div id="navBreadCrumb">
                <ol class="breadcrumb">
<?php
    // -----
    // Getting the breadcrumbs to produce valid HTML, since the breadcrumb class adds the separator after the closing </li>.
    //
    // 1. Replace all occurrences of the separator followed by 'whitespace' characters.
    // 2. Insert the separator into a span at the beginning of each breadcrumb element.
    // 3. Remove the leading separator from the first breadcrumb element and output.
    //
    $breadcrumbs = preg_replace('^' . BREAD_CRUMBS_SEPARATOR . '\s?^', '', $breadcrumb->trail(BREAD_CRUMBS_SEPARATOR, '<li>', '</li>'));
    $breadcrumbs = str_replace('<li>', '<li><span class="breadcrumb-separator">' . BREAD_CRUMBS_SEPARATOR . '</span>', $breadcrumbs);
    echo preg_replace('^<li><span class="breadcrumb-separator">' . BREAD_CRUMBS_SEPARATOR . '</span>^', '<li>', $breadcrumbs, 1);
?>
                </ol>
            </div>
<?php
}

if (SHOW_BANNERS_GROUP_SET3 !== '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET3)) {
    if ($banner->RecordCount() > 0) {
        $find_banners = zen_build_banners_group(SHOW_BANNERS_GROUP_SET3);
        $banner_group = 3;
?>
            <div class="zca-banner bannerThree rounded">
<?php 
        if (ZCA_ACTIVATE_BANNER_THREE_CAROUSEL === 'true') {
            require $template->get_template_dir('tpl_zca_banner_carousel.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_zca_banner_carousel.php'; 
        } else {
            echo zen_display_banner('static', $banner);
        }
?>
            </div>
<?php
    }
}
?>
            <main>
<?php
if ($messageStack->size('upload') > 0) {
    echo $messageStack->output('upload');
}
if ($messageStack->size('main_content') > 0) {
    echo $messageStack->output('main_content');
}

/**
 * prepares and displays center column
 *
 */
require $body_code;
?>
            </main>
<?php
if (SHOW_BANNERS_GROUP_SET4 !== '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET4)) {
    if ($banner->RecordCount() > 0) {
        $find_banners = zen_build_banners_group(SHOW_BANNERS_GROUP_SET4);
        $banner_group = 4;
?>
            <div class="zca-banner bannerFour rounded">
<?php 
        if (ZCA_ACTIVATE_BANNER_FOUR_CAROUSEL === 'true') {
            require $template->get_template_dir('tpl_zca_banner_carousel.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_zca_banner_carousel.php'; 
        } else {
            echo zen_display_banner('static', $banner);
        }
?>
            </div>
<?php
    }
}
?>
        </div>
<?php
if (COLUMN_RIGHT_STATUS === '0' || (CUSTOMERS_APPROVAL === '1' && !zen_is_logged_in()) || (CUSTOMERS_APPROVAL_AUTHORIZATION == 1 && CUSTOMERS_AUTHORIZATION_COLUMN_RIGHT_OFF === 'true' && ($_SESSION['customers_authorization'] != 0 || !zen_is_logged_in()))) {
  // global disable of column_right
    $flag_disable_right = true;
}
if (empty($flag_disable_right)) {
?>    
        <div id="navColumnTwo" class="<?=  $box_width_right_new ?>">
<?php
 /**
  * prepares and displays right column sideboxes
  *
  */
?>
            <div id="navColumnTwoWrapper">
                <?php require DIR_WS_MODULES . zen_get_module_directory('column_right.php'); ?>
            </div>
        </div>
<?php
}
?>
    </div>
</div>

<div id="footer-wrapper" class="<?= BS4_FOOTER_CONTAINER ?>">
    <div class="row mt-3">
        <div class="col">
<?php
/**
 * prepares and displays footer output
 *
 */
if (CUSTOMERS_APPROVAL_AUTHORIZATION === '1' && CUSTOMERS_AUTHORIZATION_FOOTER_OFF === 'true' && ($_SESSION['customers_authorization'] != 0 || !zen_is_logged_in())) {
    $flag_disable_footer = true;
}
require $template->get_template_dir('tpl_footer.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_footer.php';

if (defined('DISPLAY_PAGE_PARSE_TIME') && DISPLAY_PAGE_PARSE_TIME === 'true') {
?>
            <div class="text-center">
                Parse Time: <?=  $parse_time ?? 'n/a' ?> - Number of Queries: <?=  $db->queryCount() ?> - Query Time: <?= $db->queryTime() ?>
            </div>
<?php
}
?>
        </div>
    </div>

<!--bof- banner #6 display -->
<?php
if (SHOW_BANNERS_GROUP_SET6 !== '' && $banner = zen_banner_exists('dynamic', SHOW_BANNERS_GROUP_SET6)) {
    if ($banner->RecordCount() > 0) {
        $find_banners = zen_build_banners_group(SHOW_BANNERS_GROUP_SET6);
        $banner_group = 6;
?>
    <div class="zca-banner bannerSix rounded">
<?php 
        if (ZCA_ACTIVATE_BANNER_SIX_CAROUSEL === 'true') {
            require $template->get_template_dir('tpl_zca_banner_carousel.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_zca_banner_carousel.php'; 
        } else {
            echo zen_display_banner('static', $banner);
        }
?>
    </div>
<?php
    }
}
?>
<!--eof- banner #6 display -->
<?php /* add any end-of-page code via an observer class */
$zco_notifier->notify('NOTIFY_FOOTER_END', $current_page);

// -----
// Don't display the back-to-top control if it's been disabled via a 'soft'
// setting.  See /includes/extra_datafiles/dist.site-specific-bootstrap-settings.php
// for additional information.
//
if (empty($zca_disable_back_to_top)) {
?>
    <a href="#" id="back-to-top" class="btn d-none d-lg-inline-block" title="<?=  BUTTON_BACK_TO_TOP_TITLE ?>" aria-label="<?=  BUTTON_BACK_TO_TOP_TITLE ?>" role="button">
        <i aria-hidden="true" class="fas fa-chevron-circle-up"></i>
    </a>
<?php
}
?>
</div>
</body>
