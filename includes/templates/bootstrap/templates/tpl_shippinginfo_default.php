<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_shippinginfo_default.php 3464 2006-04-19 00:07:26Z ajeh $
 */
?>
<div id="shippinginfoDefault" class="centerColumn">
    <h1 id="shippinginfoDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>

<?php
if (in_array($tplSetting->DEFINE_SHIPPINGINFO_STATUS, ['1', '2'], true)) {
?>
    <div id="shippinginfoDefault-defineContent" class="defineContent">
<?php
/**
 * require the html_define for the shippinginfo page
 */
    require $define_page;
?>
    </div>
<?php
}
?>
    <div id="shippinginfoDefault-btn-toolbar" class="btn-toolbar my-3" role="toolbar">
        <?= zca_back_link() ?>
    </div>
</div>
