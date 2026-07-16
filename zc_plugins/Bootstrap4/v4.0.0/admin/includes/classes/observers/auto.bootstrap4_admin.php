<?php
/**
 * @copyright Copyright 2026 lat9 (https://vinosdefrutastropicales.com)
 *
 * BOOTSTRAP v4.0.0
 */
if (!defined('IS_ADMIN_FLAG') || IS_ADMIN_FLAG !== true) {
    die('Illegal Access');
}

use Zencart\Traits\InteractsWithPlugins;

class zcObserverBootstrap4Admin
{
    use InteractsWithPlugins;

    public function __construct()
    {
        global $current_page, $zca_bootstrap_colors_path;

        // -----
        // For the ZCA Bootstrap Colors tool, determine the webspace path to
        // this installation. It's used to load the color-picker CSS/JS files.
        //
        if ($current_page === FILENAME_ZCA_BOOTSTRAP_COLORS . '.php') {
            $this->detectZcPluginDetails(__DIR__);
            $zca_bootstrap_colors_path = '../' . $this->zcPluginAdminPath;
        }

        // -----
        // If the current template has just been CHANGED to the ZCA bootstrap (or a clone), ensure that the
        // Zen Cart configuration values required contain the recommended values for the template (if existing).
        //
        // The ZCA Bootstrap template (and its clones) contains the storefront file /includes/languages/english/extra_definitions/YT/lang.zca_bootstrap_id.php,
        // where YT is the name of the template.  Use the PRESENCE of that file to identify a bootstrap template.
        //
        if ($current_page === (FILENAME_TEMPLATE_SELECT . '.php') && isset($_GET['action'], $_POST['ln']) && $_GET['action'] === 'save') {
            if (is_file(DIR_FS_CATALOG . DIR_WS_LANGUAGES . 'english/extra_definitions/' . $_POST['ln'] . '/lang.zca_bootstrap_id.php')) {
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
    }
}
