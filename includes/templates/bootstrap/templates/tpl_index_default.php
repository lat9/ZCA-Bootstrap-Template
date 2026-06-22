<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * Main index page
 * Displays greetings, welcome text (define-page content), and various centerboxes depending on switch settings in Admin
 * Centerboxes are called as necessary
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Sep 10 Modified in v1.5.7a $
 */
?>
<div id="indexDefault" class="centerColumn">
<?php
// -----
// For accessibility, an <h1> tag can't contain an empty string.  If that's the case, use
// generic wording for the title and render the <h1> tag for screen-readers only.
//
$screen_reader_only = '';
$heading_title = HEADING_TITLE;
if ($heading_title === '') {
    $heading_title = HEADING_TITLE_SCREENREADER;
    $screen_reader_only = ' sr-only';
}
?>
    <h1 id="indexDefault-pageHeading" class="pageHeading<?= $screen_reader_only ?>"><?= $heading_title ?></h1>
<?php
if ($tplSetting->SHOW_CUSTOMER_GREETING === '1') {
?>
    <h2 id="indexDefault-greeting" class="greeting"><?= zen_customer_greeting() ?></h2>
<?php
}

// -----
// Load the home-page slider.
//
?>
    <div id="home-slider">
        <?php require $template->get_template_dir('tpl_index_slider.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_index_slider.php'; ?>
    </div>
<?php
if (in_array($tplSetting->DEFINE_MAIN_PAGE_STATUS, ['1', '2'], true)) {
/**
 * get the Define Main Page Text
 */
?>
    <div id="indexDefault-defineContent" class="defineContent"><?php require $define_page; ?></div>
<?php
}

$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MAIN);
foreach ($show_display_category as $next_display) {
    switch ($next_display['configuration_key']) {
        case 'SHOW_PRODUCT_INFO_MAIN_FEATURED_PRODUCTS':
            require $template->get_template_dir('tpl_modules_featured_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_products.php';
            break;
        case 'SHOW_PRODUCT_INFO_MAIN_SPECIALS_PRODUCTS':
            require $template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_specials_default.php';
            break;
        case 'SHOW_PRODUCT_INFO_MAIN_NEW_PRODUCTS':
            require $template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_whats_new.php';
            break;
        case 'SHOW_PRODUCT_INFO_MAIN_UPCOMING':
            require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS);
            break;
        case 'SHOW_PRODUCT_INFO_MAIN_FEATURED_CATEGORIES':
            require $template->get_template_dir('tpl_modules_featured_categories.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_categories.php';
            break;
        default:
            break;
    }
}
?>
</div>
