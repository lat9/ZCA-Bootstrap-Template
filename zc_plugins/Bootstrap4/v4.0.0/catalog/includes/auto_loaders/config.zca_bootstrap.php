<?php
/**
 * config.zca_bootstrap.php
 *
 * @package initSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @author ZCAdditions.com, ZCA Bootstrap Template Initialization
 *
 * BOOTSTRAP 3.1.3
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

// -----
// Loading at CP#132 to enable the template's messageStack override to
// have effect on the use in init_customer_auth.php.  For Zen Cart
// versions zc157c and earlier, this requires a core-file edit to
// /includes/auto_loaders/config.core.php.  See GitHub issue#69 for
// additional information.
//
$autoLoadConfig[132][] = array(
    'autoType' => 'init_script',
    'loadFile' => 'init_zca_bootstrap.php'
);

// -----
// Load, and instantiate, the template's observer-class.
//
$autoLoadConfig[200][] = array(
    'autoType' => 'class',
    'loadFile' => 'observers/ZcaBootstrapObserver.php'
);
$autoLoadConfig[200][] = array(
    'autoType' => 'classInstantiate',
    'className' => 'ZcaBootstrapObserver',
    'objectName' => 'zcaBootstrap'
);
