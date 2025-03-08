<?php
// -----
// Configuration initialization for the ZCAdditions' bootstrap template.
//
// Note: Starting with v3.2.0 of the template, all template-specific settings are now present
// in their own configuration group!
//
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

define('ZCA_BOOTSTRAP_CURRENT_VERSION', '3.7.6');

// -----
// If a SuperUser admin is logged in, check to see that all of the new configuration settings required
// by the ZCA Bootstrap template are present, adding them if not.
//
if (zen_is_superuser()) {
    $configurationGroupTitle = 'Bootstrap Template Settings';
    $configuration = $db->Execute("SELECT configuration_group_id FROM " . TABLE_CONFIGURATION_GROUP . " WHERE configuration_group_title = '$configurationGroupTitle' LIMIT 1");
    if ($configuration->EOF) {
        $db->Execute(
            "INSERT INTO " . TABLE_CONFIGURATION_GROUP . " 
                (configuration_group_title, configuration_group_description, sort_order, visible) 
             VALUES
                ('$configurationGroupTitle', '$configurationGroupTitle', 1, 1)"
        );
        $cgi = $db->Insert_ID(); 
        $db->Execute("UPDATE " . TABLE_CONFIGURATION_GROUP . " SET sort_order = $cgi WHERE configuration_group_id = $cgi LIMIT 1");
    } else {
        $cgi = $configuration->fields['configuration_group_id'];
    }

    // -----
    // If not yet installed (or pre-v3.2.0 version installed), perform the initial installation.
    //
    if (!defined('ZCA_BOOTSTRAP_VERSION')) {
        require DIR_WS_INCLUDES . 'init_includes/init_zca_bootstrap_template_admin_install.php';
    }

    // -----
    // Next, update the description of a couple of the built-in settings to let the store owner know that
    // they're not applicable/used when the ZCA bootstrap template is active.
    //
    if (ZCA_BOOTSTRAP_VERSION === '0.0.0') {
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Left Column Boxes<br>px may be included<br>Default = 150px<br><b>This configuration has no affect with the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'BOX_WIDTH_LEFT' LIMIT 1"
        );
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Right Column Boxes<br>px may be included<br>Default = 150px<br><b>This configuration has no affect with the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'BOX_WIDTH_RIGHT' LIMIT 1"
        );
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Left Column<br>px may be included<br>Default = 150px<br><br><b>This configuration has no affect with the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'COLUMN_WIDTH_LEFT' LIMIT 1"
        );
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Right Column<br>px may be included<br>Default = 150px<br><b>This configuration has no affect with the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'COLUMN_WIDTH_RIGHT' LIMIT 1"
        );
    }

    // -----
    // Next, if the currently-installed version is different from the current version of the
    // template, perform any updates required.
    //
    if (ZCA_BOOTSTRAP_VERSION !== ZCA_BOOTSTRAP_CURRENT_VERSION) {
        require DIR_WS_INCLUDES . 'init_includes/init_zca_bootstrap_template_admin_update.php';
    }
}

// -----
// If the current template has just been CHANGED to the ZCA bootstrap (or a clone), ensure that the
// Zen Cart configuration values required contain the recommended values for the template (if existing).
//
// The ZCA Bootstrap template (and its clones) contains the storefront file /includes/languages/english/extra_definitions/YT/zca_bootstrap_id.php,
// where YT is the name of the template.  Use the PRESENCE of that file to identify a bootstrap template.
//
if ($current_page === (FILENAME_TEMPLATE_SELECT . '.php') && isset($_GET['action'], $_POST['ln']) && $_GET['action'] === 'save') {
    if (file_exists(DIR_FS_CATALOG . DIR_WS_LANGUAGES . 'english/extra_definitions/' . $_POST['ln'] . '/zca_bootstrap_id.php')) {
        // -----
        // Finally, compare the Zen Cart built-in settings to see if they're different from the ZCA Bootstrap
        // recommendations.  If so, create a log file identifying what's different and let the current admin
        // know about the changes.
        //
        $zca_bootstrap_configs = [
            'IMAGE_USE_CSS_BUTTONS' => 'Yes',
            'MAX_DISPLAY_PAGE_LINKS' => '3',
            'BREAD_CRUMBS_SEPARATOR' => '&nbsp;/&nbsp;',
            'CATEGORIES_SEPARATOR_SUBS' => '&vdash;&nbsp;',
            'CATEGORIES_COUNT_PREFIX' => '',
            'CATEGORIES_COUNT_SUFFIX' => '',
            'SHOW_SHIPPING_ESTIMATOR_BUTTON' => '2',
            'MAX_DISPLAY_PRODUCTS_LISTING' => '10',
            'MAX_DISPLAY_SEARCH_RESULTS_FEATURED' => '4',
            'MAX_DISPLAY_NEW_PRODUCTS' => '4',
            'MAX_DISPLAY_SPECIAL_PRODUCTS_INDEX' => '4',
            'PRODUCT_LIST_PRICE_BUY_NOW' => '1',
            'PRODUCT_LISTING_MULTIPLE_ADD_TO_CART' => '0',
            'MAX_RANDOM_SELECT_NEW' => '2',
            'MAX_DISPLAY_CATEGORIES_PER_ROW' => '2',
            'SHOW_PRODUCT_INFO_COLUMNS_NEW_PRODUCTS' => '2',
            'SHOW_PRODUCT_INFO_COLUMNS_FEATURED_PRODUCTS' => '2',
            'SHOW_PRODUCT_INFO_COLUMNS_SPECIALS_PRODUCTS' => '2'
        ];
        $sql_update = '';
        $zca_table_configuration = preg_replace('/' . DB_PREFIX . '/', '', TABLE_CONFIGURATION, 1);
        foreach ($zca_bootstrap_configs as $key => $value) {
            if (constant($key) !== $value) {
                $sql_update .= ("UPDATE " . $zca_table_configuration . " SET configuration_value = '$value', last_modified = now() WHERE configuration_key = '$key' LIMIT 1;" . PHP_EOL);
            }
        }

        if ($sql_update !== '') {
            $logfile_name = DIR_FS_LOGS . '/zca_bootstrap_' . date('YmdHis') . '.log';
            $messageStack->add(sprintf(ZCA_BOOTSTRAP_CONFIG_WARNING, $logfile_name), 'warning');

            $logfile_data = 'The ZCA "bootstrap" template (or a clone) was activated on ' . date('Y-m-d H:i:s') . ' and some of its default settings are different than those currently set.  You can copy and paste the following SQL into your admin\'s Tools :: Install SQL Patches to change those defaults:' . PHP_EOL . PHP_EOL . $sql_update;
            error_log($logfile_data, 3, $logfile_name);
        }
    }
}
