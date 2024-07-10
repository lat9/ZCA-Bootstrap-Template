<?php
// -----
// Configuration update for the ZCAdditions' bootstrap template.  Required by
// init_zca_bootstrap_template_admin if the current template version isn't yet registered.
//
// The $cgi value contains the configuration_group_id associated with the template's configuration.
// settings.
//
// Bootstrap v3.7.0
//
switch (true) {
    // -----
    // v3.2.0: Add settings for the Bootstrap template's AJAX search feature.  Update
    // description for 'Product Listing :: Columns Per Row' to indicate the preferred
    // values for the Bootstrap template.
    //
    case version_compare(ZCA_BOOTSTRAP_VERSION, '3.2.0', '<'):
        $db->Execute(
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, use_function, set_function)
             VALUES
                ('Enable AJAX Search?', 'BS4_AJAX_SEARCH_ENABLE', 'false', 'Enable the template\'s AJAX search feature?', $cgi, now(), 1000, NULL, 'zen_cfg_select_option([\'true\', \'false\'],'),

                ('AJAX Search: Max Results', 'BS4_AJAX_SEARCH_RESULTS_PER_PAGE', '8', 'Identify the number of matching products to display in the AJAX search modal display.  Default: <b>8</b>.', $cgi, now(), 1005, NULL, NULL),

                ('AJAX Search: Image Width', 'BS4_AJAX_SEARCH_IMAGE_WIDTH', '50', 'Identify the width of a product\'s image displayed in the AJAX search modal.  Default: <b>50</b>.', $cgi, now(), 1010, NULL, NULL),

                ('AJAX Search: Image Height', 'BS4_AJAX_SEARCH_IMAGE_HEIGHT', '50', 'Identify the height of a product\'s image displayed in the AJAX search modal.  Default: <b>50</b>.', $cgi, now(), 1011, NULL, NULL),

                ('AJAX Search: Use minified script?', 'BS4_AJAX_SEARCH_USE_MINIMIZED_SCRIPT', 'true', 'Use the minimized version of the AJAX search script?', $cgi, now(), 1020, NULL, 'zen_cfg_select_option([\'true\', \'false\'],')"
        );
        $db->Execute(
            "UPDATE " . TABLE_CONFIGURATION . "
                SET configuration_description = 'Select the number of columns of products to show per row in the product listing.<br>Recommended: 3<br>1=[rows] mode.<br><br>For the <code>bootstrap</code> template, use 0 (fluid columns) or 1 (rows).<br>'
              WHERE configuration_key = 'PRODUCT_LISTING_COLUMNS_PER_ROW'
              LIMIT 1"
        );
    // -----
    // v3.6.4: Add setting to force 'floating' "Add Selected to Cart" button on
    // product-listing pages.
    //
    case version_compare(ZCA_BOOTSTRAP_VERSION, '3.6.4', '<'):  //- Fall through from above
        $db->Execute(
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, use_function, set_function)
             VALUES
                ('Float the <em>Add Selected to Cart</em> button?', 'BS4_FLOAT_ADD_SELECTED', 'Always', 'Should the positioning of this button override the setting in <code>Product Listing :: Display Product Add to Cart Button</code>, so that the button is always visible?<br><br>Choose <em>Always</em> (the default), <em>Small Devices Only</em> to override only on small devices or <em>Never</em>.', $cgi, now(), 205, NULL, 'zen_cfg_select_option([\'Always\', \'Small Devices Only\', \'Never\'],')"
        );
    // -----
    // v3.7.0:
    //
    // - Add settings associated with the incorporation of the Bootstrap Home Slider
    // - Add settings to control the type of "container" used for the header, main-content and footer.
    // - Add setting to control location(s) of product pricing when attributes are present.
    // - Add settings to enable/control various sidebox carousels.
    // - Add settings to enable/control various centerbox carousels.
    //
    case version_compare(ZCA_BOOTSTRAP_VERSION, '3.7.0', '<'):  //- Fall through from above
        $db->Execute(
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, use_function, set_function)
             VALUES
                ('Header Container Type', 'BS4_HEADER_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s header. Refer to <a href=\"https://www.w3schools.com/bootstrap4/bootstrap_containers.asp\" target=\"_blank\" rel=\"noreferrer noopener\">this</a> W<sup>3</sup>Schools article about the differences between the two types.', $cgi, now(), 100, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Main Content Container Type', 'BS4_MAIN_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s main content, i.e. the sideboxes and main-page.', $cgi, now(), 102, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Footer Container Type', 'BS4_FOOTER_CONTAINER', 'container-fluid', 'Choose the type of <samp>container</samp> used to display the site\'s footer.', $cgi, now(), 104, NULL, 'zen_cfg_select_option([\'container-fluid\', \'container\',],'),

                ('Product Info Pricing Location', 'BS4_PRICING_LOCATION', 'Both', 'When a product has attributes, where should a product\'s pricing be displayed relative to the attributes\' display? Default: <samp>Both</samp>.', $cgi, now(), 400, NULL, 'zen_cfg_select_option([\'Both\', \'Above Only\', \'Below Only\'],'),

                ('Sideboxes as Carousels', 'BS4_SIDEBOXES_DISPLAY_CAROUSEL', '', 'Choose which sideboxes to display using a carousel, using a comma-separated list.  Currently supported: <samp>best_sellers</samp>, <samp>featured</samp>, <samp>reviews</samp>, <samp>specials</samp> and <samp>whats_new</samp>.<br>', $cgi, now(), 500, NULL, 'zen_cfg_textarea_small('),

                ('Sideboxes Carousels to Fade', 'BS4_SIDEBOXES_FADE_CAROUSEL', '', 'Of the sideboxes chosen above, which should <em>fade</em> to the next instead of <em>sliding</em>?  Use a comma-separated list.<br>', $cgi, now(), 502, NULL, 'zen_cfg_textarea_small('),

                ('Featured Centerbox as Carousel?', 'BS4_FEATURED_CENTERBOX_CAROUSEL', '', 'If the <em>Featured Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: Featured Products Columns per Row</code>.<br>', $cgi, now(), 520, NULL, NULL),

                ('New Centerbox as Carousel?', 'BS4_NEW_CENTERBOX_CAROUSEL', '', 'If the <em>New Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: New Products Columns per Row</code>.<br>', $cgi, now(), 522, NULL, NULL),

                ('Specials Centerbox as Carousel?', 'BS4_SPECIALS_CENTERBOX_CAROUSEL', '', 'If the <em>Specials Products</em> centerbox is to be displayed as a carousel, enter the number of products to be displayed in the large and medium viewports as a comma-separated list with <code>;fade</code> at the end to <em>fade</em> the carousel instead of sliding, e.g. <code>3, 2</code> or <code>3, 2;fade</code>.  Leave this setting blank (the default) to display the centerbox based on <code>Index Listing :: Special Products Columns per Row</code>.<br>', $cgi, now(), 524, NULL, NULL),

                ('Home Slider: &quot;Banner Manager&quot; Group', 'BS4_SLIDER_BANNER_GROUP', 'HomeSlider', 'Identify the <em>Banner Manager</em> group containing the home-page slider images. Refer to <a href=\"https://github.com/lat9/ZCA-Bootstrap-Template/wiki/Using-the-Home%E2%80%90Page-Slider-Feature\" target=\"_blank\" rel=\"noreferrer noopener\">this</a> GitHub Wiki article for additional information about the <em>Home Slider</em> settings.', $cgi, now(), 1100, NULL, NULL),

                ('Home Slider: Image Width', 'BS4_SLIDER_WIDTH', '1170!', 'What image-width should be applied to the home-page slider images?', $cgi, now(), 1110, NULL, NULL),

                ('Home Slider: Image Height', 'BS4_SLIDER_HEIGHT', '400!', 'What image-height should be applied to the home-page slider images?', $cgi, now(), 1115, NULL, NULL)"
        );
    // -----
    // v3.7.2:
    //
    // - Add setting to identify whether/not a product's description is included in the AJAX search.
    //
    case version_compare(ZCA_BOOTSTRAP_VERSION, '3.7.2', '<'):  //- Fall through from above
        $db->Execute(
            "INSERT IGNORE INTO " . TABLE_CONFIGURATION . "
                (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, date_added, sort_order, use_function, set_function)
             VALUES
                ('AJAX Search: Include descriptions?', 'BS4_AJAX_SEARCH_INC_DESC', 'false', 'Include product descriptions when using the AJAX search?  Default: <samp>false</samp>.', $cgi, now(), 1022, NULL, 'zen_cfg_select_option([\'false\', \'true\',],')"
        );
    default:                                                    //- Fall through from above
        break;
}

$db->Execute(
    "UPDATE " . TABLE_CONFIGURATION . "
        SET configuration_value = '" . ZCA_BOOTSTRAP_CURRENT_VERSION . "',
            last_modified = now()
      WHERE configuration_key = 'ZCA_BOOTSTRAP_VERSION'
      LIMIT 1"
);

if (!zen_page_key_exists('configBootstrapTemplate')) {
    zen_register_admin_page('configBootstrapTemplate', 'BOX_ZCA_BOOTSTRAP', 'FILENAME_CONFIGURATION', "gID=$cgi", 'configuration', 'Y');
}
