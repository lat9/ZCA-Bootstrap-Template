<?php
/**
 * Common Template
 *
 * BOOTSTRAP 4.0.0
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
// First, load the template's CSS variables formatter.
//
require $template->get_template_dir('^bootstrap_color_vars.php', DIR_WS_TEMPLATE, $current_page_base, 'css', includeDefaultDirs: false) . '/bootstrap_color_vars.php';

// -----
// Now, bring in the common CSS loader to deal with the rest of the load.
//
require DIR_WS_TEMPLATES . 'template_default/common/html_header_css_loader.php';
