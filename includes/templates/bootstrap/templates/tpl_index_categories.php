<?php
/**
 * Page Template
 * 
 * BOOTSTRAP v3.5.2
 *
 * Loaded by main_page=index<br />
 * Displays category/sub-category listing<br />
 * Uses tpl_index_category_row.php to render individual items
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 Sep 10 Modified in v1.5.7a $
 */
?>
<div id="indexCategories" class="centerColumn">
<?php
if ($show_welcome === true) {
    // -----
    // zc158 introduces the HEADING_TITLE_NESTED constant.  Use that, if defined,
    // otherwise fall-back to the legacy title.
    //
    $heading_title = (defined('HEADING_TITLE_NESTED')) ? HEADING_TITLE_NESTED : HEADING_TITLE;
?>
<?php if (!empty($heading_title)) { ?>
    <h1 id="indexCategories-pageHeading" class="pageHeading"><?php echo $heading_title; ?></h1>
<?php } ?>
<?php
    if (SHOW_CUSTOMER_GREETING === '1') {
?>
    <h2 id="indexCategories-greeting" class="greeting"><?php echo zen_customer_greeting(); ?></h2>
<?php
    }

    if (DEFINE_MAIN_PAGE_STATUS === '1' || DEFINE_MAIN_PAGE_STATUS === '2') {
?>
    <div id="indexCategories-defineContent" class="defineContent">
<?php
        /**
         * require the html_define for the index/categories page
         */
        require $define_page;
?>
    </div>
<?php
    }
} else {
?>
    <h1 id="indexCategories-pageHeading" class="pageHeading"><?php echo $current_categories_name; ?></h1>
<?php
}

if (PRODUCT_LIST_CATEGORIES_IMAGE_STATUS_TOP === 'true') {
    // categories_image
    if ($categories_image = zen_get_categories_image($current_category_id)) {
?>
    <div id="indexCategories-categoryImage" class="categoryImage">
        <?php echo zen_image(DIR_WS_IMAGES . $categories_image, '', SUBCATEGORY_IMAGE_TOP_WIDTH, SUBCATEGORY_IMAGE_TOP_HEIGHT); ?>
    </div>
<?php
    }
} // categories_image

// categories_description
if ($current_categories_description !== '') {
?>
    <div id="indexCategories-categoryDescription" class="categoryDescription content">
        <?php echo $current_categories_description;  ?>
    </div>
<?php
} // categories_description

if (PRODUCT_LIST_CATEGORY_ROW_STATUS !== '0') {
   /**
    * require the code to display the sub-categories-grid, if any exist
    */
    require $template->get_template_dir('tpl_modules_category_row.php', DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/tpl_modules_category_row.php';
}

$show_display_category = $db->Execute(SQL_SHOW_PRODUCT_INFO_CATEGORY);
foreach ($show_display_category as $next_display_category) {
    switch ($next_display_category['configuration_key']) {
        case 'SHOW_PRODUCT_INFO_CATEGORY_FEATURED_PRODUCTS':
            require $template->get_template_dir('tpl_modules_featured_products.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_featured_products.php';
            break;
        case 'SHOW_PRODUCT_INFO_CATEGORY_SPECIALS_PRODUCTS':
            require $template->get_template_dir('tpl_modules_specials_default.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_specials_default.php';
            break;
        case 'SHOW_PRODUCT_INFO_CATEGORY_NEW_PRODUCTS':
            require $template->get_template_dir('tpl_modules_whats_new.php', DIR_WS_TEMPLATE, $current_page_base, 'centerboxes') . '/tpl_modules_whats_new.php';
            break;
        case 'SHOW_PRODUCT_INFO_CATEGORY_UPCOMING':
            require DIR_WS_MODULES . zen_get_module_directory('centerboxes/' . FILENAME_UPCOMING_PRODUCTS);
            break;
        default:
            break;
    }
}
?>
</div>
