<?php
/**
 * Common Template
 *
 * BOOTSTRAP 3.7.3
 *
 * NOTE: This module can be removed from the template once support for Zen Cart
 * versions less than v2.1.0 is dropped! Unless, of course, there are site-specific
 * changes made!
 *
 * Outputs the html header's CSS files.
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2024 Feb 11 Modified in v2.0.0-beta1 $
 
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// -----
// If the site's Zen Cart version provides the 'common' CSS loader is present(i.e. zc210+), use that.
//
if (file_exists(DIR_WS_TEMPLATES . 'template_default/common/html_header_css_loader.php')) {
    require DIR_WS_TEMPLATES . 'template_default/common/html_header_css_loader.php';
    return;
}

/**
 * load all template-specific stylesheets, named like "style*.css", alphabetically
 */
$directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^style/', '.css');
foreach ($directory_array as $value) {
    echo '<link rel="stylesheet" href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '">' . "\n";
}
/**
 * load stylesheets on a per-page/per-language/per-product/per-manufacturer/per-category basis. Concept by Juxi Zoza.
 */
$manufacturers_id = $_GET['manufacturers_id'] ?? '';
$tmp_products_id = (int)($_GET['products_id'] ?? 0);
$tmp_pagename = ($this_is_home_page) ? 'index_home' : $current_page_base;
if ($current_page_base === 'page' && isset($ezpage_id)) {
    $tmp_pagename = $current_page_base . (int)$ezpage_id;
}
$sheets_array = [
    '/' . $_SESSION['language'] . '_stylesheet',
    '/' . $tmp_pagename,
    '/' . $_SESSION['language'] . '_' . $tmp_pagename,
    '/c_' . $cPath,
    '/' . $_SESSION['language'] . '_c_' . $cPath,
    '/m_' . $manufacturers_id,
    '/' . $_SESSION['language'] . '_m_' . (int)$manufacturers_id,
    '/p_' . $tmp_products_id,
    '/' . $_SESSION['language'] . '_p_' . $tmp_products_id,
];
foreach ($sheets_array as $value) {
    $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . $value . '.css';
    if (file_exists($perpagefile)) {
        echo '<link rel="stylesheet" href="' . $perpagefile . '">' . "\n";
    }
}

/**
 *  custom category handling for a parent and all its children ... works for any c_XX_XX_children.css  where XX_XX is any parent category
 */
$tmp_cats = explode('_', $cPath);
$value = '';
foreach ($tmp_cats as $val) {
    $value .= $val;
    $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/c_' . $value . '_children.css';
    if (file_exists($perpagefile)) {
        echo '<link rel="stylesheet" href="' . $perpagefile . '">' . "\n";
    }
    $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $_SESSION['language'] . '_c_' . $value . '_children.css';
    if (file_exists($perpagefile)) {
        echo '<link rel="stylesheet" href="' . $perpagefile . '">' . "\n";
    }
    $value .= '_';
}

/**
 * load printer-friendly stylesheets -- named like "print*.css", alphabetically
 */
$directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^print/', '.css');
foreach ($directory_array as $value) {
    echo '<link rel="stylesheet" media="print" href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '">' . "\n";
}

/**
 * load all DYNAMIC template-specific stylesheets, named like "style*.php", alphabetically
 */
$directory_array = $template->get_template_part($template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^style/', '.php');
foreach ($directory_array as $value) {
    require $template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value;
}

// -----
// Site-specific styles come last. For Zen Cart versions *prior to* v2.0.1, continue
// to look *specifically* in the current template; for v2.0.1 and later, use the $template
// class to locate that file.
//
$zca_zcversion = zen_get_zcversion();
if (substr($zca_zcversion, 0, 1) === '1' || version_compare($zca_zcversion, '2.0.1', '<')) {
    $user_styles = DIR_WS_TEMPLATE . 'css/site_specific_styles.php';
    if (file_exists($user_styles)) {
        require $user_styles;
    }
} else {
    $user_styles = $template->get_template_dir('^site_specific_styles.php', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/site_specific_styles.php';
    if (file_exists($user_styles)) {
        require $user_styles;
    }
}
