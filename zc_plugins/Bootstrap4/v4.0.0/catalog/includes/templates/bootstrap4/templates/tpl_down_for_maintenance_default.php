<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.8.0
 *
 * Loaded automatically by index.php?main_page=down_for_maintenance.
 * When site is down for maintenance (and database is still active), this page is displayed to the customer
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_down_for_maintenance_default.php 2786 2006-01-05 01:52:38Z birdbrain $
 */
?>
<!-- body_text //-->
<div id="downForMaintenanceDefault" class="centerColumn">
    <h1 id="downForMaintenanceDefault-pageHeading" class="pageHeading"><?= HEADING_TITLE ?></h1>

    <?= zen_image(DIR_WS_TEMPLATE_IMAGES . OTHER_IMAGE_DOWN_FOR_MAINTENANCE, OTHER_DOWN_FOR_MAINTENANCE_ALT) ?>

    <div id="downForMaintenanceDefault-content" class="content">
        <h2><?= DOWN_FOR_MAINTENANCE_TEXT_INFORMATION ?></h2>
    </div>
<?php
if (zen_config('DISPLAY_MAINTENANCE_TIME') === 'true') {
?>
    <div id="downForMaintenanceDefault-content-one" class="content">
        <h3><?= TEXT_MAINTENANCE_ON_AT_TIME . '<br>' . TEXT_DATE_TIME ?></h3>
    </div>
<?php
}

if (zen_config('DISPLAY_MAINTENANCE_PERIOD') === 'true') {
?>
    <div id="downForMaintenanceDefault-content-two" class="content">
        <h3><?= TEXT_MAINTENANCE_PERIOD . TEXT_MAINTENANCE_PERIOD_TIME ?></h3>
    </div>
<?php
}
?>
    <div class="p-3"></div>

    <div id="downForMaintenanceDefault-btn-toolbar" class="btn-toolbar justify-content-between" role="toolbar">
        <?= DOWN_FOR_MAINTENANCE_STATUS_TEXT ?>
        <?= zca_button_link(zen_href_link(FILENAME_DEFAULT), BUTTON_CONTINUE_ALT, 'button_continue') ?>
    </div>
<!-- body_text_eof //-->
</div>
