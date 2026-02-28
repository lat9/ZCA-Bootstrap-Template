<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.7.9
 *
 * Loaded by main_page=index
 * Displays product-listing when a particular category/subcategory is selected for browsing
 *
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Scott Wilson 2024 Mar 09 Modified in v2.0.0-rc2 $
 */
?>
<div id="indexProductList" class="centerColumn">
    <h1 id="indexProductList-pageHeading" class="pageHeading"><?= $current_categories_name ?></h1>

    <div id="indexProductList-cat-wrap">
<?php
if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS === 'true') {
// categories_image
    if ($categories_image = zen_get_categories_image($current_category_id)) {
?>
        <div id="indexProductList-categoryImage" class="categoryImage">
            <?= zen_image(DIR_WS_IMAGES . $categories_image, '', CATEGORY_ICON_IMAGE_WIDTH, CATEGORY_ICON_IMAGE_HEIGHT) ?>
        </div>
<?php
    }
} // categories_image
?>

<?php
// categories_description
if ($current_categories_description != '') {
?>
        <div id="indexProductList-content" class="content">
            <?= $current_categories_description ?>
        </div>
<?php 
} // categories_description
?>
    </div>

    <div id="indexProductList-filterRow" class="row">
<?php
$check_for_alpha = $listing_sql;
$check_for_alpha = $db->Execute($check_for_alpha);

if ($do_filter_list || isset($_GET['alpha_filter_id']) || (PRODUCT_LIST_ALPHA_SORTER === 'true' && !$check_for_alpha->EOF)) {
    echo
        zen_draw_form('filter', zen_href_link(FILENAME_DEFAULT), 'get', 'class="form-inline"') .
        '<label class="inputLabel">' . TEXT_SHOW . '</label>' .
        zen_draw_hidden_field('main_page', FILENAME_DEFAULT);
?>
<?php
  // draw cPath if known
    if (empty($getoption_set)) {
        echo zen_draw_hidden_field('cPath', $cPath);
    } else {
    // draw manufacturers_id
        echo zen_draw_hidden_field($get_option_variable, $_GET[$get_option_variable]);
    }

  // draw music_genre_id
    if (isset($_GET['music_genre_id']) && $_GET['music_genre_id'] != '') {
        echo zen_draw_hidden_field('music_genre_id', $_GET['music_genre_id']);
    }

    // draw record_company_id
    if (isset($_GET['record_company_id']) && $_GET['record_company_id'] != '') {
        echo zen_draw_hidden_field('record_company_id', $_GET['record_company_id']);
    }

    // draw typefilter
    if (isset($_GET['typefilter']) && $_GET['typefilter'] != '') {
        echo zen_draw_hidden_field('typefilter', $_GET['typefilter']);
    }

    // draw manufacturers_id if not already done earlier
    if (!(isset($get_option_variable) && $get_option_variable == 'manufacturers_id') && !empty($_GET['manufacturers_id'])) {
        echo zen_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);
    }

    // draw disp_order
    if (!empty($_GET['disp_order'])) {
        echo zen_draw_hidden_field('disp_order', $_GET['disp_order']);
    } else {
        unset($_GET['disp_order']);
    }

    // draw sort
    if (!empty($_GET['sort']) && $_GET['sort'] !== '20a') {
        echo zen_draw_hidden_field('sort', $_GET['sort']);
    } else {
        unset($_GET['sort']);
    }

    // draw filter_id (ie: category/mfg depending on $options)
    if ($do_filter_list) {
?>
        <div class="col">
            <?= zen_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'aria-label="' . TEXT_SHOW . '" onchange="this.form.submit()"') ?>
        </div>
<?php
    }
?>
        <div class="col">
<?php
    // draw alpha sorter
    require DIR_WS_MODULES . zen_get_module_directory(FILENAME_PRODUCT_LISTING_ALPHA_SORTER);
?>
        </div>
    <?= '</form>'; ?>
<?php
}

// -----
// Zen Cart versions prior to 2.0.0 don't include the display-order sort, so neither
// does this template when run on an earlier version.
//
if (PROJECT_VERSION_MAJOR > 1) {
?>
        <div class="col">
<?php
    require $template->get_template_dir('/tpl_modules_listing_display_order.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_listing_display_order.php';
?>
        </div>
<?php
}
?>
    </div>
    <div class="p-3"></div>
<?php
/**
 * require the code for listing products
 */
require $template->get_template_dir('tpl_modules_product_listing.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_product_listing.php';

//// bof: categories error
if ($error_categories) {
    // verify lost category and reset category
    $check_category = $db->Execute("SELECT categories_id FROM " . TABLE_CATEGORIES . " WHERE categories_id = '" . $cPath . "'");
    if ($check_category->EOF) {
        $new_products_category_id = '0';
        $cPath = '';
    }

    $show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_MISSING);
    foreach ($show_display_category as $content_box_to_display) {
        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_MISSING_FEATURED_PRODUCTS') {
            /**
             * display the Featured Products Center Box
             */
            require $template->get_template_dir('tpl_modules_featured_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_products.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_MISSING_SPECIALS_PRODUCTS') {
            /**
             * display the Special Products Center Box
             */
            require $template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_specials_default.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_MISSING_NEW_PRODUCTS') {
            /**
             * display the New Products Center Box
             */
            require $template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_whats_new.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_MISSING_UPCOMING') {
            require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS);
        }
    }
} else {
    $show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_LISTING_BELOW);
    foreach ($show_display_category as $content_box_to_display) {
        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_LISTING_BELOW_FEATURED_PRODUCTS') {
            /**
             * display the Featured Products Center Box
             */
            require $template->get_template_dir('tpl_modules_featured_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_products.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_LISTING_BELOW_SPECIALS_PRODUCTS') {
            /**
             * display the Special Products Center Box
             */
            require $template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_specials_default.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_LISTING_BELOW_NEW_PRODUCTS') {
            /**
             * display the New Products Center Box
             */
            require $template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_whats_new.php';
        }

        if ($content_box_to_display['configuration_key'] === 'SHOW_PRODUCT_INFO_LISTING_BELOW_UPCOMING') {
            require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS);
        }
    } // !EOF
} //// eof: categories
?>
</div>
