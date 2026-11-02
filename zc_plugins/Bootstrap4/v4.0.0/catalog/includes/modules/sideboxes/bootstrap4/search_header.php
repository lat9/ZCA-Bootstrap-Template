<?php
// -----
// Header search, modified for the Bootstrap-4 template's AJAX search extension.
//
// Bootstrap v3.8.1
//
/**
 * search_header ("sidebox") - this is a search field that appears in the navigation header
 * (it's not really a "sidebox" per se).
 *
 * @package templateSystem
 * @copyright Copyright 2003-2019 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: mc12345678 2019 Jan 28 Modified in v1.5.6b $
 */
// -----
// Don't render the header-based search form if we're already on the 'search' page.
//
if ($current_page_base === FILENAME_SEARCH) {
    return;
}

$search_header_status = $db->Execute(
    "SELECT layout_box_name
       FROM " . TABLE_LAYOUT_BOXES . "
      WHERE layout_box_status_single = 1
        AND layout_template = '" . $template_dir . "'
        AND layout_box_name = 'search_header.php'
      LIMIT 1"
);

if (!$search_header_status->EOF) {
    if ($tplSetting->BS4_AJAX_SEARCH_ENABLE === 'true') {
        require $template->get_template_dir('tpl_ajax_search_header.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_ajax_search_header.php';
    } else {
        require $template->get_template_dir('tpl_search_header.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_search_header.php';
    }
    require $template->get_template_dir('tpl_box_header.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/tpl_box_header.php';
}
