<?php
/**
 * Page Template
 *
 * BOOTSTRAP v3.7.0
 *
 * Loaded automatically by index.php?main_page=document_product_info.
 * Displays template according to "document-product" product-type needs
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 16 Modified in v1.5.7 $
 */
// -----
// Starting with v3.7.0, simply use the common product_xxx_info display.
//
$html_id_prefix = 'documentProductInfo';
require $template->get_template_dir('/tpl_product_info_display.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_product_info_display.php';
