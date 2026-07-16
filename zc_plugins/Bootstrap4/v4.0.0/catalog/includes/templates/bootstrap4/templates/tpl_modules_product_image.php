<?php
/**
 * Module Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Wed Jan 6 12:47:43 2016 -0500 Modified in v1.5.5 $
 */
require DIR_WS_MODULES . zen_get_module_directory(FILENAME_MAIN_PRODUCT_IMAGE);
?>
<?= zen_image(addslashes($products_image_medium), addslashes($products_name), $tplSetting->MEDIUM_IMAGE_WIDTH, $tplSetting->MEDIUM_IMAGE_HEIGHT) ?>
<div class="p-3"></div>
