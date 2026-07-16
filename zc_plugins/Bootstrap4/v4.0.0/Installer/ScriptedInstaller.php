<?php
use Zencart\PluginSupport\ScriptedInstaller as ScriptedInstallBase;
use Zencart\PluginSupport\ScriptedInstallHelpers;
use Zencart\Traits\InteractsWithPlugins;

class ScriptedInstaller extends ScriptedInstallBase
{
    use Zencart\PluginSupport\ScriptedInstallHelpers;
    use Zencart\Traits\InteractsWithPlugins;

    protected function executeInstall()
    {
        // -----
        // @TODO: Is this necessary? Can the two co-exist?
        //
        if ($this->purgeOldFiles() === false) {
            return false;
        }

        // -----
        // Determine (or create) the configuration-group for the
        // template's settings. Passing `null` as the final parameter
        // causes the method to assign the sort-order based on the $cgi
        // value, if created.
        //
        $cgi = $this->getOrCreateConfigGroupId('Bootstrap Template Settings', 'Bootstrap Template Settings', null);
        $this->installTemplateSettings($cgi);

        // -----
        // Update the descriptions of some of the built-in configuration settings,
        // indicating their usage with the bootstrap template.
        //
        $this->updateConfigurationDescriptions();
        
        // -----
        // Install (or update) the template's color-related settings.
        //
        $this->installColorSettings();

        return parent::executeInstall();
    }

    protected function executeUpgrade($oldVersion)
    {
        return parent::executeUpgrade($oldVersion);
    }

    protected function executeUninstall()
    {
        return parent::executeUninstall();
    }

    protected function purgeOldFiles(): bool
    {
        // -----
        // First, look for and remove the non-encapsulated versions' admin-directory
        // files.
        //
        $admin_files = [
            'includes/' => [
                'auto_loaders/config.bc.php',
                'auto_loaders/config/zca_bootstrap_admin.php',
                'css/colorpicker.css',
                'extra_datafiles/zca_bootstrap_colors.php',
                'init_includes/init_bc_config.php',
                'init_includesinit_bc_config_install_or_upgrade.php',
                'init_includesinit_zca_bootstrap_template_admin.php',
                'init_includesinit_zca_bootstrap_template_admin_install.php',
                'init_includesinit_zca_bootstrap_template_admin_update.php',
                'javascript/colorpicker.js',
                'languages/english/lang.zca_bootstrap_colors.php',
                'languages/english/lang.zca_bootstrap_uninstall.php',
                'languages/english/zca_bootstrap_colors.php',
                'languages/english/extra_definitions/lang.zca_bootstrap_colors.php',
                'languages/english/extra_definitions/lang.zca_bootstrap_messages.php',
                'languages/english/extra_definitions/zca_bootstrap_colors.php',
                'languages/english/extra_definitions/zca_bootstrap_messages.php',
            ],
            '' => [
                'zca_bootstrap_colors.php',
                'zca_bootstrap_uninstall.php',
            ],
        ];
        $admin_files_status = $this->removeFiles($admin_files, 'admin');

        // -----
        // Next, locate and attempt to remove the storefront files.
        //
        $catalog_files = [
            'includes/' => [
                'auto_loaders/config.zca_bootstrap.php',
                'classes/ajax/zcAjaxBootstrapSearch.php',
                'classes/observers/ZcaBootstrapObserver.php',
                'classes/zca/zca_message_stack.php',
                'classes/zca/zca_site_map.php',
                'classes/zca/zca_split_page_results.php',
                'extra_datafiles/dist.site-specific-bootstrap-settings.php',
                'functions/zca_bootstrap_functions.php',
                'init_includes/init_zca_bootstrap.php',
                'languages/english/bootstrap/lang.account_history_info.php',
                'languages/english/bootstrap/account_history_info.php',
                'languages/english/extra_definitions/bootstrap/lang.zca_bootstrap_common.php',
                'languages/english/extra_definitions/bootstrap/lang.zca_bootstrap_id.php',
                'languages/english/extra_definitions/bootstrap/zca_bootstrap_common.php',
                'languages/english/extra_definitions/bootstrap/zca_bootstrap_id.php',
                'languages/bootstrap/lang.english.php',
                'languages/bootstrap/english.php',
                'modules/bootstrap/attributes.php',
                'modules/bootstrap/bootstrap_additional_images.php',
                'modules/bootstrap/bootstrap_slide_additional_images.php',
                'modules/bootstrap/categories_tabs.php',
                'modules/bootstrap/category_row.php',
                'modules/bootstrap/product_listing.php',
                'modules/bootstrap/centerboxes/also_purchased_products.php',
                'modules/bootstrap/centerboxes/featured_categories.php',
                'modules/bootstrap/centerboxes/featured_products.php',
                'modules/bootstrap/centerboxes/manufacturer_info.php',
                'modules/bootstrap/centerboxes/new_products.php',
                'modules/bootstrap/centerboxes/product_notifications.php',
                'modules/bootstrap/centerboxes/specials_index.php',
                'modules/bootstrap/centerboxes/upcoming_products.php',
                'modules/pages/account_history/header_php_account_history_zca_bootstrap.php',
                'modules/pages/featured_products/header_php_featured_products_zca_bootstrap.php',
                'modules/pages/page_not_found/header_php_page_not_found_zca_bootstrap.php',
                'modules/pages/products_all/header_php_products_all_zca_bootstrap.php',
                'modules/pages/products_new/header_php_products_new_zca_bootstrap.php',
                'modules/pages/product_reviews/header_php_product_reviews_zca_bootstrap.php',
                'modules/pages/product_reviews_info/header_php_product_reviews_info_zca_bootstrap.php',
                'modules/pages/product_reviews_write/header_php_products_reviews_write_zca_bootstrap.php',
                'modules/pages/shopping_cart/header_php_shopping_cart_zca_bootstrap.php',
                'modules/pages/shopping_cart/jscript_addr_pulldowns_bootstrap.php',
                'modules/pages/site_map/header_php_site_map_zca_bootstrap.php',
                'modules/pages/specials/header_php_specials_zca_bootstrap.php',
                'modules/sideboxes/bootstrap/information.php',
                'modules/sideboxes/bootstrap/more_information.php',
                'modules/sideboxes/bootstrap/search_header.php',
                'templates/bootstrap/template_info.php',
                'templates/bootstrap/centerboxes/tpl_modules_also_purchased_products.php',
                'templates/bootstrap/centerboxes/pl_modules_featured_categories.php',
                'templates/bootstrap/centerboxes/tpl_modules_featured_products.php',
                'templates/bootstrap/centerboxes/tpl_modules_manufacturer_info.php',
                'templates/bootstrap/centerboxes/tpl_modules_no_notifications.php',
                'templates/bootstrap/centerboxes/tpl_modules_specials_default.php',
                'templates/bootstrap/centerboxes/tpl_modules_upcoming_products.php',
                'templates/bootstrap/centerboxes/tpl_modules_whats_new.php',
                'templates/bootstrap/centerboxes/tpl_modules_yes_notifications.php',
                'templates/bootstrap/common/html_header.php',
                'templates/bootstrap/common/html_header_css_loader.php',
                'templates/bootstrap/common/html_header_js_loader.php',
                'templates/bootstrap/common/tpl_box_default_left.php',
                'templates/bootstrap/common/tpl_box_default_right.php',
                'templates/bootstrap/common/tpl_box_default_single.php',
                'templates/bootstrap/common/tpl_columnar_display.php',
                'templates/bootstrap/common/tpl_columnar_display_carousel.php',
                'templates/bootstrap/common/tpl_footer.php',
                'templates/bootstrap/common/tpl_header.php',
                'templates/bootstrap/common/tpl_main_page.php',
                'templates/bootstrap/common/tpl_offcanvas_menu.php',
                'templates/bootstrap/common/tpl_tabular_display.php',
                'templates/bootstrap/common/tpl_zca_banner_carousel.php',
                'templates/bootstrap/css/bootstrap_color_vars.php',
                'templates/bootstrap/css/checkout_one.css',
                'templates/bootstrap/css/checkout_one_confirmation.css',
                'templates/bootstrap/css/checkout_success.css',
                'templates/bootstrap/css/dist-site_specific_styles.php',
                'templates/bootstrap/css/print_stylesheet.css',
                'templates/bootstrap/css/stylesheet.css',
                'templates/bootstrap/css/stylesheet_360.css',
                'templates/bootstrap/css/stylesheet_361.css',
                'templates/bootstrap/css/stylesheet_364.css',
                'templates/bootstrap/css/stylesheet_365.css',
                'templates/bootstrap/css/stylesheet_373.css',
                'templates/bootstrap/css/stylesheet_374.css',
                'templates/bootstrap/css/stylesheet_378.css',
                'templates/bootstrap/css/stylesheet_ajax_search.css',
                'templates/bootstrap/css/stylesheet_bootstrap.carousel.css',
                'templates/bootstrap/css/stylesheet_bootstrap.lightbox.css',
                'templates/bootstrap/css/stylesheet_colors.css',
                'templates/bootstrap/css/stylesheet_zca_colors.css',
                'templates/bootstrap/css/stylesheet_zca_colors.php',
                'templates/bootstrap/images/ZCA_BOOTSTRAP_TEMPLATE.png',
                'templates/bootstrap/jscript/ajax_search.js',
                'templates/bootstrap/jscript/ajax_search.min.js',
                'templates/bootstrap/jscript/jscript_addr_pulldowns_zca_bootstrap.php',
                'templates/bootstrap/jscript/jscript_bs4_ajax_search.php',
                'templates/bootstrap/jscript/jscript_bs4_matching_heights.php',
                'templates/bootstrap/jscript/jscript_framework.php',
                'templates/bootstrap/jscript/jquery.matchHeight.js',
                'templates/bootstrap/jscript/jquery.matchHeight.min.js',
                'templates/bootstrap/jscript/jquery.min.js',
                'templates/bootstrap/jscript/jscript_sidebox_select_form.php',
                'templates/bootstrap/jscript/jscript_view_password.js',
                'templates/bootstrap/jscript/jscript_zca_bootstrap.js',
                'templates/bootstrap/modalboxes/tpl_ajax_search.php',
                'templates/bootstrap/modalboxes/tpl_attributes_qty_prices.php',
                'templates/bootstrap/modalboxes/tpl_bootstrap_images.php',
                'templates/bootstrap/modalboxes/tpl_coupon_help.php',
                'templates/bootstrap/modalboxes/tpl_cvv_help.php',
                'templates/bootstrap/modalboxes/tpl_image.php',
                'templates/bootstrap/modalboxes/tpl_image_additional.php',
                'templates/bootstrap/modalboxes/tpl_info_shopping_cart.php',
                'templates/bootstrap/modalboxes/tpl_search_help.php',
                'templates/bootstrap/modalboxes/tpl_shipping_estimator.php',
                'templates/bootstrap/sideboxes/tpl_ajax_search_header.php',
                'templates/bootstrap/sideboxes/tpl_best_sellers.php',
                'templates/bootstrap/sideboxes/tpl_brands.php',
                'templates/bootstrap/sideboxes/tpl_categories.php',
                'templates/bootstrap/sideboxes/tpl_document_categories.php',
                'templates/bootstrap/sideboxes/tpl_ezpages.php',
                'templates/bootstrap/sideboxes/tpl_featured.php',
                'templates/bootstrap/sideboxes/tpl_information.php',
                'templates/bootstrap/sideboxes/tpl_more_information.php',
                'templates/bootstrap/sideboxes/tpl_order_history.php',
                'templates/bootstrap/sideboxes/tpl_reviews_random.php',
                'templates/bootstrap/sideboxes/tpl_search.php',
                'templates/bootstrap/sideboxes/tpl_search_header.php',
                'templates/bootstrap/sideboxes/tpl_shopping_cart.php',
                'templates/bootstrap/sideboxes/tpl_specials.php',
                'templates/bootstrap/sideboxes/tpl_whats_new.php',
                'templates/bootstrap/templates/tpl_account_default.php',
                'templates/bootstrap/templates/tpl_account_edit_default.php',
                'templates/bootstrap/templates/tpl_account_history_default.php',
                'templates/bootstrap/templates/tpl_account_history_info_default.php',
                'templates/bootstrap/templates/tpl_account_newsletters_default.php',
                'templates/bootstrap/templates/tpl_account_notifications_default.php',
                'templates/bootstrap/templates/tpl_account_password_default.php',
                'templates/bootstrap/templates/tpl_address_book_default.php',
                'templates/bootstrap/templates/tpl_address_book_process_default.php',
                'templates/bootstrap/templates/tpl_address_book_register.php',
                'templates/bootstrap/templates/tpl_advanced_search_default.php',
                'templates/bootstrap/templates/tpl_advanced_search_results_default.php',
                'templates/bootstrap/templates/tpl_ajax_checkout_confirmation_default.php',
                'templates/bootstrap/templates/tpl_ajax_search_results.php',
                'templates/bootstrap/templates/tpl_ask_a_question_default.php',
                'templates/bootstrap/templates/tpl_brands_default.php',
                'templates/bootstrap/templates/tpl_checkout_confirmation_default.php',
                'templates/bootstrap/templates/tpl_checkout_one_confirmation_default.php',
                'templates/bootstrap/templates/tpl_checkout_one_default.php',
                'templates/bootstrap/templates/tpl_checkout_payment_address_default.php',
                'templates/bootstrap/templates/tpl_checkout_payment_default.php',
                'templates/bootstrap/templates/tpl_checkout_shipping_address_default.php',
                'templates/bootstrap/templates/tpl_checkout_shipping_default.php',
                'templates/bootstrap/templates/tpl_checkout_success_default.php',
                'templates/bootstrap/templates/tpl_checkout_success_guest.php',
                'templates/bootstrap/templates/tpl_conditions_default.php',
                'templates/bootstrap/templates/tpl_contact_us_default.php',
                'templates/bootstrap/templates/tpl_cookie_usage_default.php',
                'templates/bootstrap/templates/tpl_create_account_default.php',
                'templates/bootstrap/templates/tpl_create_account_register.php',
                'templates/bootstrap/templates/tpl_create_account_success_default.php',
                'templates/bootstrap/templates/tpl_create_account_success_register.php',
                'templates/bootstrap/templates/tpl_customers_authorization_default.php',
                'templates/bootstrap/templates/tpl_discount_coupon_default.php',
                'templates/bootstrap/templates/tpl_document_general_info_display.php',
                'templates/bootstrap/templates/tpl_document_product_info_display.php',
                'templates/bootstrap/templates/tpl_download_time_out_default.php',
                'templates/bootstrap/templates/tpl_down_for_maintenance_default.php',
                'templates/bootstrap/templates/tpl_ezpages_bar_footer.php',
                'templates/bootstrap/templates/tpl_ezpages_bar_header.php',
                'templates/bootstrap/templates/tpl_featured_products_default.php',
                'templates/bootstrap/templates/tpl_gv_faq_default.php',
                'templates/bootstrap/templates/tpl_gv_redeem_default.php',
                'templates/bootstrap/templates/tpl_gv_send_default.php',
                'templates/bootstrap/templates/tpl_index_categories.php',
                'templates/bootstrap/templates/tpl_index_default.php',
                'templates/bootstrap/templates/tpl_index_product_list.php',
                'templates/bootstrap/templates/tpl_index_slider.php',
                'templates/bootstrap/templates/tpl_login_default.php',
                'templates/bootstrap/templates/tpl_login_guest.php',
                'templates/bootstrap/templates/tpl_logoff_default.php',
                'templates/bootstrap/templates/tpl_modules_additional_images.php',
                'templates/bootstrap/templates/tpl_modules_address_book_details.php',
                'templates/bootstrap/templates/tpl_modules_attributes.php',
                'templates/bootstrap/templates/tpl_modules_categories_tabs.php',
                'templates/bootstrap/templates/tpl_modules_category_icon_display.php',
                'templates/bootstrap/templates/tpl_modules_category_row.php',
                'templates/bootstrap/templates/tpl_modules_checkout_address_book.php',
                'templates/bootstrap/templates/tpl_modules_common_address_format.php',
                'templates/bootstrap/templates/tpl_modules_create_account.php',
                'templates/bootstrap/templates/tpl_modules_downloads.php',
                'templates/bootstrap/templates/tpl_modules_listing_display_order.php',
                'templates/bootstrap/templates/tpl_modules_main_product_image.php',
                'templates/bootstrap/templates/tpl_modules_media_manager.php',
                'templates/bootstrap/templates/tpl_modules_opc_address_block.php',
                'templates/bootstrap/templates/tpl_modules_opc_billing_address.php',
                'templates/bootstrap/templates/tpl_modules_opc_comments.php',
                'templates/bootstrap/templates/tpl_modules_opc_conditions.php',
                'templates/bootstrap/templates/tpl_modules_opc_credit_selections.php',
                'templates/bootstrap/templates/tpl_modules_opc_customer_info.php',
                'templates/bootstrap/templates/tpl_modules_opc_instructions.php',
                'templates/bootstrap/templates/tpl_modules_opc_payment_choices.php',
                'templates/bootstrap/templates/tpl_modules_opc_shipping_address.php',
                'templates/bootstrap/templates/tpl_modules_opc_shipping_choices.php',
                'templates/bootstrap/templates/tpl_modules_opc_shopping_cart.php',
                'templates/bootstrap/templates/tpl_modules_opc_submit_block.php',
                'templates/bootstrap/templates/tpl_modules_order_totals.php',
                'templates/bootstrap/templates/tpl_modules_products_quantity_discounts.php',
                'templates/bootstrap/templates/tpl_modules_product_image.php',
                'templates/bootstrap/templates/tpl_modules_product_listing.php',
                'templates/bootstrap/templates/tpl_modules_send_or_spend.php',
                'templates/bootstrap/templates/tpl_modules_shipping_estimator.php',
                'templates/bootstrap/templates/tpl_order_status_default.php',
                'templates/bootstrap/templates/tpl_page_2_default.php',
                'templates/bootstrap/templates/tpl_page_3_default.php',
                'templates/bootstrap/templates/tpl_page_4_default.php',
                'templates/bootstrap/templates/tpl_page_default.php',
                'templates/bootstrap/templates/tpl_page_not_found_default.php',
                'templates/bootstrap/templates/tpl_password_forgotten_default.php',
                'templates/bootstrap/templates/tpl_password_reset_default.php',
                'templates/bootstrap/templates/tpl_privacy_default.php',
                'templates/bootstrap/templates/tpl_products_all_default.php',
                'templates/bootstrap/templates/tpl_products_new_default.php',
                'templates/bootstrap/templates/tpl_products_next_previous.php',
                'templates/bootstrap/templates/tpl_product_free_shipping_info_display.php',
                'templates/bootstrap/templates/pl_product_info_display.php',
                'templates/bootstrap/templates/tpl_product_info_display_details.php',
                'templates/bootstrap/templates/tpl_product_info_noproduct.php',
                'templates/bootstrap/templates/tpl_product_music_info_display.php',
                'templates/bootstrap/templates/tpl_product_music_info_display_details.php',
                'templates/bootstrap/templates/tpl_product_music_info_display_extra.php',
                'templates/bootstrap/templates/tpl_product_reviews_default.php',
                'templates/bootstrap/templates/tpl_product_reviews_info_default.php',
                'templates/bootstrap/templates/tpl_product_reviews_write_default.php',
                'templates/bootstrap/templates/tpl_reviews_default.php',
                'templates/bootstrap/templates/tpl_search_default.php',
                'templates/bootstrap/templates/tpl_search_result_default.php',
                'templates/bootstrap/templates/tpl_shippinginfo_default.php',
                'templates/bootstrap/templates/tpl_shopping_cart_default.php',
                'templates/bootstrap/templates/tpl_site_map_default.php',
                'templates/bootstrap/templates/tpl_specials_default.php',
                'templates/bootstrap/templates/tpl_ssl_check_default.php',
                'templates/bootstrap/templates/tpl_time_out_default.php',
                'templates/bootstrap/templates/tpl_unsubscribe_default.php',
            ],
        ];
        $catalog_files_status = $this->removeFiles($catalog_files, 'catalog');

        return ($admin_files_status === true && $catalog_files_status === true);
    }

    protected function installTemplateSettings(int $cgi): void
    {
        $this->detectZcPluginDetails(__DIR__);
        $template_version = zen_db_input(ltrim($this->zcPluginVersionDir, 'v'));

        $sql =
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, use_function, set_function)
             VALUES
                ('Bootstrap Template Version', 'ZCA_BOOTSTRAP_VERSION', '$template_version', 'Displays the template\'s current version.', $cgi, now(), 0, NULL, 'zen_cfg_read_only('),

                ('Header Container Type', 'BS4_HEADER_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s header. Refer to <a href=\"https://www.w3schools.com/bootstrap4/bootstrap_containers.asp\" target=\"_blank\" rel=\"noreferrer noopener\">this</a> W<sup>3</sup>Schools article about the differences between the two types.', $cgi, now(), 100, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Main Content Container Type', 'BS4_MAIN_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s main content, i.e. the sideboxes and main-page.', $cgi, now(), 102, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Footer Container Type', 'BS4_FOOTER_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s footer.', $cgi, now(), 104, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Responsive Left Column Width', 'SET_COLUMN_LEFT_LAYOUT', '3', 'Set Width of Left Column<br>Default is <b>3</b>, Total columns <b>12</b>.<br>Responsive Left, Center & Right Column Width must sum to 12', $cgi, now(), 200, NULL, 'zen_cfg_select_option([\'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\'],'),

                ('Responsive Center Column Width', 'SET_COLUMN_CENTER_LAYOUT', '6', 'Set Width of Center Column<br>Default is <b>6</b>, Total columns <b>12</b>.<br>Responsive Left, Center & Right Column Width must sum to 12', $cgi, now(), 201, NULL, 'zen_cfg_select_option([\'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\'],'),

                ('Responsive Right Column Width', 'SET_COLUMN_RIGHT_LAYOUT', '3', 'Set Width of Right Column<br>Default is <b>3</b>, Total columns <b>12</b>.<br>Responsive Left, Center & Right Column Width must sum to 12', $cgi, now(), 202, NULL, 'zen_cfg_select_option([\'0\', \'1\', \'2\', \'3\', \'4\', \'5\', \'6\', \'7\', \'8\', \'9\', \'10\', \'11\', \'12\'],'),

                ('Float the <em>Add Selected to Cart</em> button?', 'BS4_FLOAT_ADD_SELECTED', 'Always', 'Should the positioning of this button override the setting in <code>Product Listing :: Display Product Add to Cart Button</code>, so that the button is always visible?<br><br>Choose <em>Always</em> (the default), <em>Small Devices Only</em> to override only on small devices or <em>Never</em>.', $cgi, now(), 205, NULL, 'zen_cfg_select_option([\'Always\', \'Small Devices Only\', \'Never\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Header Position 1 Carousel Feature', 'ZCA_ACTIVATE_BANNER_ONE_CAROUSEL', 'false', 'Enable the Header Position 1 Banner Carousel.', $cgi, now(), 213, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Header Position 2 Carousel Feature', 'ZCA_ACTIVATE_BANNER_TWO_CAROUSEL', 'false', 'Enable the Header Position 2 Banner Carousel.', $cgi, now(), 214, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Header Position 3 Carousel Feature', 'ZCA_ACTIVATE_BANNER_THREE_CAROUSEL', 'false', 'Enable the Header Position 3 Banner Carousel.', $cgi, now(), 215, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Footer Position 1 Carousel Feature', 'ZCA_ACTIVATE_BANNER_FOUR_CAROUSEL', 'false', 'Enable the Footer Position 1 Banner Carousel.', $cgi, now(), 216, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Footer Position 2 Carousel Feature', 'ZCA_ACTIVATE_BANNER_FIVE_CAROUSEL', 'false', 'Enable the Footer Position 2 Banner Carousel.', $cgi, now(), 217, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('<i>Bootstrap Banner Display</i> - Enable Footer Position 3 Carousel Feature', 'ZCA_ACTIVATE_BANNER_SIX_CAROUSEL', 'false', 'Enable the Footer Position 3 Banner Carousel.', $cgi, now(), 218, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('Enable <em>Bootstrap</em> Modal Image Popups', 'PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_POPUPS', 'Yes', 'Should the ZCA <code>bootstrap</code> template display pop-up product images using its <em>modal</em> dialog? If your store uses an image-display plugin (like <b>Zen ColorBox</b>), set this value to <em>No</em>. Default: <b>Yes</b>', $cgi, now(), 300, NULL, 'zen_cfg_select_option([\'No\', \'Yes\'],'),

                ('Use Bootstrap Additional Image Carousel', 'PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_SLIDE', '0', 'Default is <b>0</b>, Opens images in an individual modal, <b>1</b> opens images in a single modal with carousel.', $cgi, now(), 301, NULL, 'zen_cfg_select_option([\'0\', \'1\'],'),

                ('Display the Manufacturer Box on Product Pages', 'PRODUCT_INFO_SHOW_MANUFACTURER_BOX', '1', 'Used by the ZCA Bootstrap template.  Default is <b>1</b>, Displays on Info Page, <b>0</b> Does not Display.', $cgi, now(), 302, NULL, 'zen_cfg_select_option([\'0\', \'1\'],'),

                ('Display the Notifications Box on Product Pages', 'PRODUCT_INFO_SHOW_NOTIFICATIONS_BOX', '1', 'Used by the ZCA Bootstrap template. Default is <b>1</b>, Displays on Info Page, <b>0</b> Does not Display.', $cgi, now(), 303, NULL, 'zen_cfg_select_option([\'0\', \'1\'],'),

                ('Product Info Pricing Location', 'BS4_PRICING_LOCATION', 'Both', 'When a product has attributes, where should a product\'s pricing be displayed relative to the attributes\' display? Default: <samp>Both</samp>.', $cgi, now(), 400, NULL, 'zen_cfg_select_option([\'Both\', \'Above Only\', \'Below Only\'],'),

                ('Sideboxes as Carousels', 'BS4_SIDEBOXES_DISPLAY_CAROUSEL', '', 'Choose which sideboxes to display using a carousel, using a comma-separated list.  Currently supported: <samp>best_sellers</samp>, <samp>featured</samp>, <samp>reviews</samp>, <samp>specials</samp> and <samp>whats_new</samp>.<br>', $cgi, now(), 500, NULL, 'zen_cfg_textarea_small('),

                ('Sideboxes Carousels to Fade', 'BS4_SIDEBOXES_FADE_CAROUSEL', '', 'Of the sideboxes chosen above, which should <em>fade</em> to the next instead of <em>sliding</em>?  Use a comma-separated list.<br>', $cgi, now(), 502, NULL, 'zen_cfg_textarea_small('),

                ('Featured Centerbox as Carousel?', 'BS4_FEATURED_CENTERBOX_CAROUSEL', '', 'If the <em>Featured Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: Featured Products Columns per Row</code>.<br>', $cgi, now(), 520, NULL, NULL),

                ('New Centerbox as Carousel?', 'BS4_NEW_CENTERBOX_CAROUSEL', '', 'If the <em>New Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: New Products Columns per Row</code>.<br>', $cgi, now(), 522, NULL, NULL),

                ('Specials Centerbox as Carousel?', 'BS4_SPECIALS_CENTERBOX_CAROUSEL', '', 'If the <em>Specials Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: Special Products Columns per Row</code>.<br>', $cgi, now(), 524, NULL, NULL),

                ('Enable AJAX Search?', 'BS4_AJAX_SEARCH_ENABLE', 'false', 'Enable the template\'s AJAX search feature?', $cgi, now(), 1000, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('AJAX Search: Max Results', 'BS4_AJAX_SEARCH_RESULTS_PER_PAGE', '8', 'Identify the number of matching products to display in the AJAX search modal display.  Default: <b>8</b>.', $cgi, now(), 1005, NULL, NULL),

                ('AJAX Search: Image Width', 'BS4_AJAX_SEARCH_IMAGE_WIDTH', '50', 'Identify the width of a product\'s image displayed in the AJAX search modal.  Default: <b>50</b>.', $cgi, now(), 1010, NULL, NULL),

                ('AJAX Search: Image Height', 'BS4_AJAX_SEARCH_IMAGE_HEIGHT', '50', 'Identify the height of a product\'s image displayed in the AJAX search modal.  Default: <b>50</b>.', $cgi, now(), 1011, NULL, NULL),

                ('AJAX Search: Use minified script?', 'BS4_AJAX_SEARCH_USE_MINIMIZED_SCRIPT', 'true', 'Use the minimized version of the AJAX search script?', $cgi, now(), 1020, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('AJAX Search: Include descriptions?', 'BS4_AJAX_SEARCH_INC_DESC', 'false', 'Include product descriptions when using the AJAX search?  Default: <samp>false</samp>.', $cgi, now(), 1022, NULL, 'zen_cfg_select_option([\'false\', \'true\',],'),

                ('Home Slider: &quot;Banner Manager&quot; Group', 'BS4_SLIDER_BANNER_GROUP', 'HomeSlider', 'Identify the <em>Banner Manager</em> group containing the home-page slider images. Refer to <a href=\"https://github.com/lat9/ZCA-Bootstrap-Template/wiki/Using-the-Home%E2%80%90Page-Slider-Feature\" target=\"_blank\" rel=\"noreferrer noopener\">this</a> GitHub Wiki article for additional information about the <em>Home Slider</em> settings.', $cgi, now(), 1100, NULL, NULL),

                ('Home Slider: Image Width', 'BS4_SLIDER_WIDTH', '1170!', 'What image-width should be applied to the home-page slider images?', $cgi, now(), 1110, NULL, NULL),

                ('Home Slider: Image Height', 'BS4_SLIDER_HEIGHT', '400!', 'What image-height should be applied to the home-page slider images?', $cgi, now(), 1115, NULL, NULL)";
        $this->executeInstallerSql($sql);

        if (!zen_page_key_exists('configBootstrapTemplate')) {
            zen_register_admin_page('configBootstrapTemplate', 'BOX_ZCA_BOOTSTRAP', 'FILENAME_CONFIGURATION', "gID=$cgi", 'configuration', 'Y');
        }

        // -----
        // This might be an upgrade from an older version, need to also fix-up the sort-orders
        // of various template configuration settings.
        //
        $bootstrap_settings = [
            'SET_COLUMN_LEFT_LAYOUT' => 200,
            'SET_COLUMN_CENTER_LAYOUT' => 201,
            'SET_COLUMN_RIGHT_LAYOUT' => 202,
            'ZCA_ACTIVATE_BANNER_ONE_CAROUSEL' => 213,
            'ZCA_ACTIVATE_BANNER_TWO_CAROUSEL' => 214,
            'ZCA_ACTIVATE_BANNER_THREE_CAROUSEL' => 215,
            'ZCA_ACTIVATE_BANNER_FOUR_CAROUSEL' => 216,
            'ZCA_ACTIVATE_BANNER_FIVE_CAROUSEL' => 217,
            'ZCA_ACTIVATE_BANNER_SIX_CAROUSEL' => 218,
            'PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_POPUPS' => 300,
            'PRODUCT_INFO_SHOW_BOOTSTRAP_MODAL_SLIDE' => 301,
            'PRODUCT_INFO_SHOW_MANUFACTURER_BOX' => 302,
            'PRODUCT_INFO_SHOW_NOTIFICATIONS_BOX' => 303,
        ];
        foreach ($bootstrap_settings as $key => $sort_order) {
            $this->executeInstallerSql(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_group_id = $cgi,
                        sort_order = $sort_order
                  WHERE configuration_key = '$key'
                  LIMIT 1"
            );
        }
    }

    protected function installColorSettings(): void
    {
        // -----
        // This array identifies the current "Bootstrap Colors" configuration elements.
        // These values are used by the processing below on an initial installation or upgrade
        // of the ZCA Bootstrap template's 'coloring'.
        //
        // Each entry, keyed by the color's 'configuration_key' contains:
        //
        // - 'configuration_title' ... The color's configuration title
        // - 'configuration_value' ... The color's default configuration value; its description indicates this default value.
        // - 'sort_order' ............ The sort-order of the color on the display.  Note that different sections use a different sort-order range!
        // - 'added' ................. This (optional) value indicates the version of Bootstrap (prior to v3.5.2) or the Bootstrap Colors (after that) that the color was added.
        // - 'set_default' ........... This (optional) value indicates whether, on an upgrade, a newly-added color should be initialized to its default; otherwise, the value's set to 'not-set'.
        //
        $zca_bc_colors = [
            // -----
            // Body-related colors sort-orders range from 0-999
            //
            'ZCA_BODY_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Body</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 1,
            ],
            'ZCA_BODY_TEXT_COLOR' => [
                'configuration_title' => 'Body Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 10,
            ],
            'ZCA_BODY_BREADCRUMBS_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Body Breadcrumbs</b> Background Color',
                'configuration_value' => '#cccccc',
                'sort_order' => 100,
            ],
            'ZCA_BODY_BREADCRUMBS_TEXT_COLOR' => [
                'configuration_title' => 'Body Breadcrumbs Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 110,
            ],
            'ZCA_BODY_BREADCRUMBS_LINK_COLOR' => [
                'configuration_title' => 'Body Breadcrumbs Link Color',
                'configuration_value' => '#0a3f52',
                'sort_order' => 120,
            ],
            'ZCA_BODY_BREADCRUMBS_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Body Breadcrumbs Link Color on Hover',
                'configuration_value' => '#003c52',
                'sort_order' => 130,
            ],
            'ZCA_BODY_PRODUCTS_BASE_COLOR' => [
                'configuration_title' => '<b>Body Products</b> Base Price',
                'configuration_value' => '#000000',
                'sort_order' => 200,
            ],
            'ZCA_BODY_PRODUCTS_NORMAL_COLOR' => [
                'configuration_title' => 'Body Products Normal Price',
                'configuration_value' => '#000000',
                'sort_order' => 210,
            ],
            'ZCA_BODY_PRODUCTS_SPECIAL_COLOR' => [
                'configuration_title' => 'Body Products Special Price',
                'configuration_value' => '#a80000',
                'sort_order' => 220,
            ],
            'ZCA_BODY_PRODUCTS_DISCOUNT_COLOR' => [
                'configuration_title' => 'Body Products Price Discount Price',
                'configuration_value' => '#a80000',
                'sort_order' => 230,
            ],
            'ZCA_BODY_PRODUCTS_SALE_COLOR' => [
                'configuration_title' => 'Body Products Sale Price',
                'configuration_value' => '#a80000',
                'sort_order' => 240,
            ],
            'ZCA_BODY_PRODUCTS_FREE_COLOR' => [
                'configuration_title' => 'Body Products Free Price',
                'configuration_value' => '#0000ff',
                'sort_order' => 250,
            ],
            'ZCA_BODY_PLACEHOLDER' => [
                'configuration_title' => '<b>Body Form</b> Placeholder',
                'configuration_value' => '#a80000',
                'sort_order' => 260,
            ],
            'ZCA_ALERT_INFO_COLOR' => [
                'configuration_title' => '<b>Alert Info Color</b>',
                'configuration_value' => '#13525e',
                'sort_order' => 270,
                'added' => '3.6.0',
            ],
            'ZCA_ALERT_INFO_BACKGROUND_COLOR' => [
                'configuration_title' => 'Alert Info Background Color',
                'configuration_value' => '#d1ecf1',
                'sort_order' => 280,
                'added' => '3.6.0',
            ],
            'ZCA_ALERT_INFO_BORDER_COLOR' => [
                'configuration_title' => 'Alert Info Border Color',
                'configuration_value' => '#bee5eb',
                'sort_order' => 290,
                'added' => '3.6.0',
            ],
            'ZCA_BODY_RATING_STAR_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Body Rating Stars</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 500,
                'added' => '3.5.2',
            ],
            'ZCA_BODY_RATING_STAR_COLOR' => [
                'configuration_title' => 'Body Rating Stars Color',
                'configuration_value' => '#987000',
                'sort_order' => 510,
                'added' => '3.5.2',
                'set_default' => true,
            ],

            // -----
            // Button-related colors sort-orders range from 1000-1999
            //
            'ZCA_BUTTON_TEXT_COLOR' => [
                'configuration_title' => '<b>Button</b> Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 1000,
            ],
            'ZCA_BUTTON_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Button Text Color on Hover',
                'configuration_value' => '#0056b3',
                'sort_order' => 1010,
            ],
            'ZCA_BUTTON_COLOR' => [         //- Note, mis-named, should "really" be ZCA_BUTTON_BACKGROUND_COLOR; aliased on the storefront
                'configuration_title' => 'Button Background Color',
                'configuration_value' => '#13607c',
                'sort_order' => 1030,
            ],
            'ZCA_BUTTON_COLOR_HOVER' => [   //- Note, mis-named, should "really" be ZCA_BUTTON_BACKGROUND_COLOR_HOVER; aliased on the storefront
                'configuration_title' => 'Button Background Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 1040,
            ],
            'ZCA_BUTTON_BORDER_COLOR' => [
                'configuration_title' => 'Button Border Color',
                'configuration_value' => '#13607c',
                'sort_order' => 1050,
            ],
            'ZCA_BUTTON_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Button Border Color on Hover',
                'configuration_value' => '#a80000',
                'sort_order' => 1060,
            ],
            'ZCA_BUTTON_LINK_COLOR' => [
                'configuration_title' => '<b>A Link</b> Color',
                'configuration_value' => '#0000a0',
                'sort_order' => 1070,
            ],
            'ZCA_BUTTON_LINK_COLOR_HOVER' => [
                'configuration_title' => 'A Link Color on Hover',
                'configuration_value' => '#0056b3',
                'sort_order' => 1080,
            ],
            'ZCA_BUTTON_PAGEINATION_TEXT_COLOR' => [
                'configuration_title' => '<b>Pagination Button</b> Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 1080,
            ],
            'ZCA_BUTTON_PAGEINATION_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Pagination Button Text Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 1090,
            ],
            'ZCA_BUTTON_PAGEINATION_COLOR' => [
                'configuration_title' => 'Pagination Button Color',
                'configuration_value' => '#cccccc',
                'sort_order' => 1100,
            ],
            'ZCA_BUTTON_PAGEINATION_COLOR_HOVER' => [
                'configuration_title' => 'Pagination Button Color on Hover',
                'configuration_value' => '#0099cc',
                'sort_order' => 1110,
            ],
            'ZCA_BUTTON_PAGEINATION_BORDER_COLOR' => [
                'configuration_title' => 'Pagination Button Border Color',
                'configuration_value' => '#cccccc',
                'sort_order' => 1120,
            ],
            'ZCA_BUTTON_PAGEINATION_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Pagination Button Border Color on Hover',
                'configuration_value' => '#0099cc',
                'sort_order' => 1130,
            ],
            'ZCA_BUTTON_PAGEINATION_ACTIVE_TEXT_COLOR' => [
                'configuration_title' => 'Pagination Active Button Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 1140,
            ],
            'ZCA_BUTTON_PAGEINATION_ACTIVE_COLOR' => [
                'configuration_title' => 'Pagination Active Button Color',
                'configuration_value' => '#13607c',
                'sort_order' => 1150,
            ],

            // -----
            // Header-related colors sort-orders range from 2000-2999
            //
            'ZCA_HEADER_WRAPPER_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Header Wrapper</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2000,
            ],
            'ZCA_HEADER_TAGLINE_TEXT_COLOR' => [
                'configuration_title' => 'Header Tagline Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 2010,
            ],
            'ZCA_HEADER_NAV_BAR_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Header Nav Bar</b> Background Color',
                'configuration_value' => '#333333',
                'sort_order' => 2100,
            ],
            'ZCA_HEADER_NAVBAR_LINK_COLOR' => [
                'configuration_title' => '<b>Header Nav Bar Link</b> Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2110,
            ],
            'ZCA_HEADER_NAVBAR_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Header Nav Bar Link Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 2120,
            ],
            'ZCA_HEADER_NAVBAR_LINK_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Header Nav Bar Link Background Color on Hover',
                'configuration_value' => '#333333',
                'sort_order' => 2130,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR' => [          //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_COLOR; aliased on the storefront
                'configuration_title' => '<b>Header Nav Bar Toggler</b> Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2140,
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_TEXT_COLOR_HOVER' => [    //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_COLOR_HOVER; aliased on the storefront
                'configuration_title' => 'Header Nav Bar Toggler Text Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 2160,
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_COLOR' => [               //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR; aliased on the storefront
                'configuration_title' => 'Header Nav Bar Toggler Background Color',
                'configuration_value' => '#343a40',
                'sort_order' => 2170,
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_COLOR_HOVER' => [         //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_BACKGROUND_COLOR_HOVER; aliased on the storefront
                'configuration_title' => 'Header Nav Bar Toggler Background Color on Hover',
                'configuration_value' => '#919aa1',
                'sort_order' => 2180,
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR' => [        //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR; aliased on the storefront
                'configuration_title' => 'Header Nav Bar Toggler Border Color',
                'configuration_value' => '#343a40',
                'sort_order' => 2190,
            ],
            'ZCA_HEADER_NAVBAR_BUTTON_BORDER_COLOR_HOVER' => [  //- Note, mis-named, should "really" be ZCA_HEADER_NAVBAR_TOGGLER_BORDER_COLOR_HOVER; aliased on the storefront
                'configuration_title' => 'Header Nav Bar Toggler Border Color on Hover',
                'configuration_value' => '#919aa1',
                'sort_order' => 2200,
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_TEXT_COLOR' => [
                'configuration_title' => '<b>Header Nav Bar Extra Button</b> Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2300,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Header Nav Bar Extra Button Text Color on Hover',
                'configuration_value' => '#0056b3',
                'sort_order' => 2310,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BACKGROUND_COLOR' => [
                'configuration_title' => 'Header Nav Bar Extra Button Background Color',
                'configuration_value' => '#13607c',
                'sort_order' => 2330,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Header Nav Bar Extra Button Background Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 2340,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BORDER_COLOR' => [
                'configuration_title' => 'Header Nav Bar Extra Button Border Color',
                'configuration_value' => '#13607c',
                'sort_order' => 2350,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_NAVBAR_EXTRA_BUTTON_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Header Nav Bar Extra Button Border Color on Hover',
                'configuration_value' => '#a80000',
                'sort_order' => 2360,
                'added' => '3.6.0',
            ],
            'ZCA_HEADER_TABS_COLOR' => [                        //- Note, mis-named, should "really" be ZCA_HEADER_TABS_BACKGROUND_COLOR; aliased on the storefront
                'configuration_title' => '<b>Header Category Tabs</b> Background Color',
                'configuration_value' => '#13607c',
                'sort_order' => 2500,
            ],
            'ZCA_HEADER_TABS_COLOR_HOVER' => [                  //- Note, mis-named, should "really" be ZCA_HEADER_TABS_BACKGROUND_COLOR_HOVER; aliased on the storefront
                'configuration_title' => 'Header Category Tabs Background Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 2510,
            ],
            'ZCA_HEADER_TABS_TEXT_COLOR' => [
                'configuration_title' => 'Header Category Tabs Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2520,
            ],
            'ZCA_HEADER_TABS_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Header Category Tabs Text Color on Hover',
                'configuration_value' => '#13607c',
                'sort_order' => 2540,
            ],
            'ZCA_HEADER_TABS_BORDER_COLOR' => [
                'configuration_title' => 'Header Category Tabs Border Color',
                'configuration_value' => '#13607c',
                'sort_order' => 2560,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Header Category Tabs Border Color on Hover',
                'configuration_value' => '#13607c',
                'sort_order' => 2580,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Header Category Tabs Active</b> Background Color',
                'configuration_value' => '#a80000',
                'sort_order' => 2590,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Header Category Tabs Active Background Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 2592,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_COLOR' => [
                'configuration_title' => 'Header Category Tabs Active Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2600,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_COLOR_HOVER' => [
                'configuration_title' => 'Header Category Tabs Active Color on Hover',
                'configuration_value' => '#a80000',
                'sort_order' => 2602,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_BORDER_COLOR' => [
                'configuration_title' => 'Header Category Tabs Active Border Color',
                'configuration_value' => '#a80000',
                'sort_order' => 2620,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_TABS_ACTIVE_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Header Category Tabs Active Border Color on Hover',
                'configuration_value' => '#a80000',
                'sort_order' => 2622,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_EZPAGE_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Header EZ-Page Bar</b> Background Color',
                'configuration_value' => '#464646',
                'sort_order' => 2700,
            ],
            'ZCA_HEADER_EZPAGE_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Header EZ-Page Bar Background Color on Hover',
                'configuration_value' => '#363636',
                'sort_order' => 2710,
                'added' => '3.5.2',
            ],
            'ZCA_HEADER_EZPAGE_LINK_COLOR' => [
                'configuration_title' => 'Header EZ-Page Bar Link Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 2720,
            ],
            'ZCA_HEADER_EZPAGE_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Header EZ-Page Bar Link Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 2740,
            ],

            // -----
            // Footer-related colors sort-orders range from 3000-3999
            //
            'ZCA_FOOTER_WRAPPER_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Footer Wrapper</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 3000,
            ],
            'ZCA_FOOTER_WRAPPER_TEXT_COLOR' => [
                'configuration_title' => 'Footer Wrapper Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 3010,
            ],
            'ZCA_FOOTER_EZPAGE_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Footer EZ-Page Bar</b> Background Color',
                'configuration_value' => '#464646',
                'sort_order' => 3020,
            ],
            'ZCA_FOOTER_EZPAGE_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Footer EZ-Page Bar Background Color on Hover',
                'configuration_value' => '#363636',
                'sort_order' => 3022,
                'added' => '3.5.2',
            ],
            'ZCA_FOOTER_EZPAGE_LINK_COLOR' => [
                'configuration_title' => 'Footer EZ-Page Bar Link Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 3030,
            ],
            'ZCA_FOOTER_EZPAGE_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Footer EZ-Page Bar Link Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 3040,
            ],

            // -----
            // Sidebox-related colors sort-orders range from 4000-4999
            //
            'ZCA_SIDEBOX_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Sidebox</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4000,
            ],
            'ZCA_SIDEBOX_TEXT_COLOR' => [
                'configuration_title' => 'Sidebox Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 4010,
            ],
            'ZCA_SIDEBOX_LINK_BACKGROUND_COLOR' => [
                'configuration_title' => 'Sidebox Link Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4020,
            ],
            'ZCA_SIDEBOX_LINK_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Sidebox Link Background Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 4030,
            ],
            'ZCA_SIDEBOX_LINK_COLOR' => [
                'configuration_title' => 'Sidebox Link Color',
                'configuration_value' => '#0000a0',
                'sort_order' => 4040,
            ],
            'ZCA_SIDEBOX_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Sidebox Link Color on Hover',
                'configuration_value' => '#003975',
                'sort_order' => 4050,
            ],
            'ZCA_SIDEBOX_CARD_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Sidebox Product Card</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4060,
            ],
            'ZCA_SIDEBOX_CARD_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Sidebox Product Card Background Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 4070,
            ],
            'ZCA_SIDEBOX_HEADER_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Sidebox Header</b> Background Color',
                'configuration_value' => '#333333',
                'sort_order' => 4080,
            ],
            'ZCA_SIDEBOX_HEADER_TEXT_COLOR' => [
                'configuration_title' => 'Sidebox Header Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4090,
            ],
            'ZCA_SIDEBOX_HEADER_LINK_COLOR' => [
                'configuration_title' => 'Sidebox Header Link Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4100,
            ],
            'ZCA_SIDEBOX_HEADER_LINK_COLOR_HOVER' => [
                'configuration_title' => 'Sidebox Header Link Color on Hover',
                'configuration_value' => '#cccccc',
                'sort_order' => 4110,
            ],
            'ZCA_SIDEBOX_COUNTS_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Sidebox Category Counts</b> Background Color',
                'configuration_value' => '#13607c',
                'sort_order' => 4120,
            ],
            'ZCA_SIDEBOX_COUNTS_COLOR' => [
                'configuration_title' => 'Sidebox Category Counts Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 4130,
            ],

            // -----
            // Centerbox-related colors range from 5000-5999
            //
            'ZCA_CENTERBOX_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Centerbox</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 5000,
            ],
            'ZCA_CENTERBOX_TEXT_COLOR' => [
                'configuration_title' => 'Centerbox Text Color',
                'configuration_value' => '#000000',
                'sort_order' => 5010,
            ],
            'ZCA_CENTERBOX_CARD_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Centerbox Product Card</b> Background Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 5020,
            ],
            'ZCA_CENTERBOX_CARD_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Centerbox Product Card Background Color on Hover',
                'configuration_value' => '#efefef',
                'sort_order' => 5030,
            ],
            'ZCA_CENTERBOX_HEADER_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Centerbox Header</b> Background Color',
                'configuration_value' => '#333333',
                'sort_order' => 5040,
            ],
            'ZCA_CENTERBOX_HEADER_TEXT_COLOR' => [
                'configuration_title' => 'Centerbox Header Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 5050,
            ],

            // -----
            // Add-to-cart colors sort-orders range from 6000-6999
            //
            'ZCA_ADD_TO_CART_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Add-to-Cart Card</b> Background Color',
                'configuration_value' => '#036811',
                'sort_order' => 6000,

            ],
            'ZCA_ADD_TO_CART_TEXT_COLOR' => [
                'configuration_title' => 'Add-to-Cart Card Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 6010,
                'added' => '3.1.2',
            ],
            'ZCA_ADD_TO_CART_BORDER_COLOR' => [
                'configuration_title' => 'Add-to-Cart Card Border Color',
                'configuration_value' => '#036811',
                'sort_order' => 6020,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_IN_CART_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Add-to-Cart Button</b> Background Color',
                'configuration_value' => '#036811',
                'sort_order' => 6030,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_IN_CART_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Add-to-Cart Button Background Color on Hover',
                'configuration_value' => '#007e33',
                'sort_order' => 6040,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_IN_CART_TEXT_COLOR' => [
                'configuration_title' => 'Add-to-Cart Button Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 6050,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_IN_CART_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Add-to-Cart Button Text Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 6060,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Add-Selected Button</b> Background Color',
                'configuration_value' => '#036811',
                'sort_order' => 6070,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_ADD_SELECTED_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Add-Selected Button Background Color on Hover',
                'configuration_value' => '#007e33',
                'sort_order' => 6080,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR' => [
                'configuration_title' => 'Add-Selected Button Text Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 6090,
                'added' => '3.1.2',
            ],
            'ZCA_BUTTON_ADD_SELECTED_TEXT_COLOR_HOVER' => [
                'configuration_title' => 'Add-Selected Button Text Color on Hover',
                'configuration_value' => '#ffffff',
                'sort_order' => 6100,
                'added' => '3.1.2',
            ],

            // -----
            // Checkout-related colors sort-orders range from 7000-7499
            //
            'ZCA_CHECKOUT_PROGRESS_BAR_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Checkout 3-Page</b> Progress Bar Background Color',
                'configuration_value' => '#036811',
                'sort_order' => 7000,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_CHECKOUT_CONTINUE_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Checkout &quot;Continue&quot; Button</b> Background Color',
                'configuration_value' => '#ffd814',
                'sort_order' => 7100,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONTINUE_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Continue&quot; Button Background Color on Hover',
                'configuration_value' => '#f7ca00',
                'sort_order' => 7120,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONTINUE_COLOR' => [
                'configuration_title' => 'Checkout &quot;Continue&quot; Button Color',
                'configuration_value' => '#0f1111',
                'sort_order' => 7140,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONTINUE_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Continue&quot; Button Color on Hover',
                'configuration_value' => '#0f1111',
                'sort_order' => 7160,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONTINUE_BORDER_COLOR' => [
                'configuration_title' => 'Checkout &quot;Continue&quot; Button Border Color',
                'configuration_value' => '#fcd200',
                'sort_order' => 7180,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONTINUE_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Continue&quot; Button Border Color on Hover',
                'configuration_value' => '#f2c200',
                'sort_order' => 7200,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Checkout &quot;Confirm&quot; Button</b> Background Color',
                'configuration_value' => '#ffd814',
                'sort_order' => 7300,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_BACKGROUND_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Confirm&quot; Button Background Color on Hover',
                'configuration_value' => '#f7ca00',
                'sort_order' => 7320,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_COLOR' => [
                'configuration_title' => 'Checkout &quot;Confirm&quot; Button Color',
                'configuration_value' => '#0f1111',
                'sort_order' => 7340,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Confirm&quot; Button Color on Hover',
                'configuration_value' => '#0f1111',
                'sort_order' => 7360,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_BORDER_COLOR' => [
                'configuration_title' => 'Checkout &quot;Confirm&quot; Button Border Color',
                'configuration_value' => '#fcd200',
                'sort_order' => 7380,
                'added' => '3.5.2',
            ],
            'ZCA_CHECKOUT_CONFIRM_BORDER_COLOR_HOVER' => [
                'configuration_title' => 'Checkout &quot;Confirm&quot; Button Border Color on Hover',
                'configuration_value' => '#f2c200',
                'sort_order' => 7400,
                'added' => '3.5.2',
            ],

            // -----
            // "Sold Out" button coloring sort-orders range from 7500-7519
            //
            'ZCA_SOLD_OUT_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Sold Out Button</b> Background Color',
                'configuration_value' => '#a80000',
                'sort_order' => 7500,
                'added' => '3.6.0',
            ],
            'ZCA_SOLD_OUT_COLOR' => [
                'configuration_title' => 'Sold Out Button Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 7505,
                'added' => '3.6.0',
            ],
            'ZCA_SOLD_OUT_BORDER_COLOR' => [
                'configuration_title' => 'Sold Out Button Border Color',
                'configuration_value' => '#a80000',
                'sort_order' => 7510,
                'added' => '3.6.0',
            ],

            // -----
            // Carousel-related colors sort-orders range from 8000-8499
            //
            'ZCA_CAROUSEL_PREV_NEXT_COLOR' => [
                'configuration_title' => '<b>Carousel</b> Prev/Next Icon Color',
                'configuration_value' => '#000000',
                'sort_order' => 8000,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_CAROUSEL_PREV_NEXT_COLOR_HOVER' => [
                'configuration_title' => 'Carousel Prev/Next Icon Color on Hover',
                'configuration_value' => '#000000',
                'sort_order' => 8100,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_CAROUSEL_BANNER_INDICATORS_BACKGROUND_COLOR' => [
                'configuration_title' => 'Carousel Indicators Background Color',
                'configuration_value' => '#000000',
                'sort_order' => 8120,
                'added' => '3.5.2',
                'set_default' => true,
            ],

            // -----
            // Primary-address-related colors sort-orders range from 8500-8999
            //
            'ZCA_PRIMARY_ADDRESS_ADDRESS_BACKGROUND_COLOR' => [
                'configuration_title' => '<b>Primary Address</b> Address Book Background Color',
                'configuration_value' => '#036811',
                'sort_order' => 8500,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_PRIMARY_ADDRESS_ADDRESS_COLOR' => [
                'configuration_title' => 'Primary Address Address Book Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 8510,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_PRIMARY_ADDRESS_CARD_HEADER_BACKGROUND_COLOR' => [
                'configuration_title' => 'Primary Address Card Header Background Color',
                'configuration_value' => '#13607c',
                'sort_order' => 8520,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_PRIMARY_ADDRESS_CARD_HEADER_COLOR' => [
                'configuration_title' => 'Primary Address Card Header Color',
                'configuration_value' => '#ffffff',
                'sort_order' => 8530,
                'added' => '3.5.2',
                'set_default' => true,
            ],
            'ZCA_PRIMARY_ADDRESS_CARD_BORDER_COLOR' => [
                'configuration_title' => 'Primary Address Card Border Color',
                'configuration_value' => '#13607c',
                'sort_order' => 8540,
                'added' => '3.5.2',
                'set_default' => true,
            ],
        ];

        // -----
        // The ZCA Bootstrap Colors version doesn't necessarily change on each base
        // Bootstrap template update, only when one or more configuration settings
        // is added, removed or updated.  Initially added for Bootstrap v3.5.2, note that
        // its setting might not be the same as the base template's version!
        //
        define('ZCA_BOOTSTRAP4_COLORS_CURRENT_VERSION', '3.8.0');

        // -----
        // Determine the configuration-group-id for the template's color settings.
        //
        $cgi = $this->getOrCreateConfigGroupId('ZCA Bootstrap Colors', 'ZCA Bootstrap Colors', null);
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION_GROUP . "
                SET visible = 0
              WHERE configuration_group_id = $cgi
              LIMIT 1"
        );

        // -----
        // Further, if this is an _initial_ install of the Bootstrap template and its associated colors, all
        // current colors' default values are set as their color selection.  If that color-setting *is* defined,
        // then any colors added on or after v3.5.2 will be added with a 'not-set' value to enable a
        // site to choose the best color for their store's color-scheme prior to use on the storefront.
        //
        $install_check = $this->executeInstallerSelectQuery(
            "SELECT *
               FROM " . TABLE_CONFIGURATION . "
              WHERE configuration_group_id = $cgi
              LIMIT 1"
        );
        $already_installed = !$install_check->EOF;
        foreach ($zca_bc_colors as $key => $values) {
            $default_value = $values['configuration_value'];
            $added_version = (($values['added'] ?? '0.0.0') >= '3.5.2') ? (' (Added in v'. $values['added'] . ')') : '';
            $default_color = ($already_installed === true && $added_version !== '' && empty($values['set_default'])) ? 'not-set' : $default_value;
            $description = "Default: $default_value.$added_version";

            $this->executeInstallerSql(
                "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                    (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added)
                 VALUES
                    ('" . $values['configuration_title'] . "', '$key', '$default_color', '$description', $cgi, " . $values['sort_order'] . ", now())"
            );

            $this->executeInstallerSql(
                "UPDATE " . TABLE_CONFIGURATION . "
                    SET configuration_title = '" . $values['configuration_title'] . "',
                        configuration_description = '$description',
                        sort_order = " . $values['sort_order'] . "
                  WHERE configuration_key = '$key'
                  LIMIT 1"
            );
        }

        // -----
        // Create the menu item for the ZCA Bootstrap Colors tool, if it's not already there.
        //
        if (!zen_page_key_exists('toolsZCABootstrapColors')) {
            zen_register_admin_page('toolsZCABootstrapColors', 'BOX_TOOLS_ZCA_BOOTSTRAP_COLORS', 'FILENAME_ZCA_BOOTSTRAP_COLORS', '', 'tools', 'Y');
        }

        // -----
        // If the Bootstrap Colors version setting hasn't yet been recorded, do that now.  In any
        // case, update that setting to reflect the 'Bootstrap Colors' current version.  Note, this
        // setting is recorded in the 'Modules' configuration group, so it's not displayed as a row
        // within the Tools :: ZCA Bootstrap Colors tool.
        //
        $this->executeInstallerSql(
            "INSERT INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, set_function)
             VALUES
                ('Bootstrap Colors Version', 'ZCA_BOOTSTRAP_COLORS_VERSION', '" . ZCA_BOOTSTRAP4_COLORS_CURRENT_VERSION . "', 'Displays the current version of the <em>ZCA Bootstrap Colors</em> tool.', 6, now(), 0, 'zen_cfg_read_only(')"
        );
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_value = '" . ZCA_BOOTSTRAP4_COLORS_CURRENT_VERSION . "',
                    last_modified = now()
              WHERE configuration_key = 'ZCA_BOOTSTRAP_COLORS_VERSION'
              LIMIT 1"
        );
    }

    protected function updateConfigurationDescriptions(): void
    {
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Left Column Boxes<br>px may be included<br>Default = 150px<br><b>This setting is not used by the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'BOX_WIDTH_LEFT' LIMIT 1"
        );
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Right Column Boxes<br>px may be included<br>Default = 150px<br><b>This setting is not used by the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'BOX_WIDTH_RIGHT' LIMIT 1"
        );
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Left Column<br>px may be included<br>Default = 150px<br><br><b>This setting is not used by the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'COLUMN_WIDTH_LEFT' LIMIT 1"
        );
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Width of the Right Column<br>px may be included<br>Default = 150px<br><b>This setting is not used by the ZCA Responsive Components or ZCA Bootstrap Themes</b>',
                    last_modified = now()
              WHERE configuration_key = 'COLUMN_WIDTH_RIGHT' LIMIT 1"
        );
        $this->executeInstallerSql(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Select the number of columns of products to show per row in the product listing.<br>Recommended: 3<br>1=[rows] mode.<br><br>For the <code>bootstrap</code> templates, use 0 (fluid columns) or 1 (rows).<br>'
              WHERE configuration_key = 'PRODUCT_LISTING_COLUMNS_PER_ROW'
              LIMIT 1"
        );
    }
}
