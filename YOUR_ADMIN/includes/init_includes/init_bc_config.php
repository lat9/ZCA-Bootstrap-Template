<?php
/**
 * ZCA Bootstrap Colors
 *
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: init_bc_config.php
 *
 * BOOTSTRAP v3.7.9
 */

// -----
// Wait until an admin is logged in before installing or updating ...
//
if (!isset($_SESSION['admin_id'])) {
    return;
}

// -----
// The ZCA Bootstrap Colors version doesn't necessarily change on each base
// Bootstrap template update, only when one or more configuration settings
// is added, removed or updated.  Initially added for Bootstrap v3.5.2, note that
// its setting might not be the same as the base template's version!
//
define('ZCA_BOOTSTRAP_COLORS_CURRENT_VERSION', '3.7.9');

// -----
// If this is an upgrade (or an initial install), load the installation/upgrade script to (at a minimum)
// get the ZCA_BOOTSTRAP_COLORS_VERSION recorded.
//
if (!defined('ZCA_BOOTSTRAP_COLORS_VERSION') || ZCA_BOOTSTRAP_COLORS_VERSION !== ZCA_BOOTSTRAP_COLORS_CURRENT_VERSION) {
    require DIR_WS_INCLUDES . 'init_includes/init_bc_config_install_or_upgrade.php';
}
