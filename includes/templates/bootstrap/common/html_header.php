<?php
/**
 * Common Template
 *
 * BOOTSTRAP v3.7.0
 *
 * outputs the html header. i,e, everything that comes before the </head> tag.
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Zen4All 2020 May 12 Modified in v1.5.7 $
 */

if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}

$zco_notifier->notify('NOTIFY_HTML_HEAD_START', $current_page_base, $template_dir);

// Prevent clickjacking risks by setting X-Frame-Options:SAMEORIGIN
header('X-Frame-Options:SAMEORIGIN');

/**
 * load the module for generating page meta-tags
 */
require DIR_WS_MODULES . zen_get_module_directory('meta_tags.php');

// -----
// Define a set of preloaded css/js files.  Done here in array since it's
// important that the preload matches the actual <link>/<script> parameters.
//
$preloads = [
    'jquery' => [
        'link' => 'https://code.jquery.com/jquery-3.7.1.min.js',
        'integrity' => 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=',
        'type' => 'script',
    ],
    'bscss' => [
        'link' => 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css',
        'integrity' => 'sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N',
        'type' => 'style',
    ],
    'bsjs' => [
        'link' => 'https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js',
        'integrity' => 'sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct',
        'type' => 'script',
    ],
    'fa' => [
        'link' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/fontawesome.min.css',
        'integrity' => 'sha512-SgaqKKxJDQ/tAUAAXzvxZz33rmn7leYDYfBP+YoMRSENhf3zJyx3SBASt/OfeQwBHA1nxMis7mM3EV/oYT6Fdw==',
        'type' => 'style',
    ],
    'fa-solid' => [
        'link' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/solid.min.css',
        'integrity' => 'sha512-yDUXOUWwbHH4ggxueDnC5vJv4tmfySpVdIcN1LksGZi8W8EVZv4uKGrQc0pVf66zS7LDhFJM7Zdeow1sw1/8Jw==',
        'type' => 'style',
        ],
];
if (empty($disableFontAwesomeV4Compatibility)) {
    $preloads['fa-4shim'] = [
        'link' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/v4-shims.css',
        'integrity' => 'sha512-tqGH6Vq3kFB19sE6vx9P6Fm/f9jWoajQ05sFTf0hr3gwpfSGRXJe4D7BdzSGCEj7J1IB1MvkUf3V/xWR25+zvw==',
        'type' => 'style',
        ];
} 
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
  <head>
<?php
// -----
// Provide a notification that the <head> tag has been rendered for the current page.
//
$zco_notifier->notify('NOTIFY_HTML_HEAD_TAG_START', $current_page_base);

// -----
// Provide an easy way for a site to disable the preload, if they want to ensure
// that it's working properly.  If  includes/extra_datafiles/site-specific-bootstrap-settings.php does not exist 
// copy dist.site-specific-bootstrap-settings.php to site-specific-bootstrap-settings.php 
// and uncomment "// $zca_no_preloading = true;".
//
if (empty($zca_no_preloading)) {
    foreach ($preloads as $load) {
?>
    <link rel="preload" href="<?= $load['link'] ?>" integrity="<?= $load['integrity'] ?>" crossorigin="anonymous" as="<?= $load['type'] ?>">
<?php
    }
}
?>
    <meta charset="<?php echo CHARSET; ?>">
    <title><?php echo META_TAG_TITLE; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="<?php echo META_TAG_KEYWORDS; ?>">
    <meta name="description" content="<?php echo META_TAG_DESCRIPTION; ?>">
    <meta name="author" content="<?php echo STORE_NAME ?>">
    <meta name="generator" content="shopping cart program by Zen Cart&reg;, https://www.zen-cart.com eCommerce">
    <?php if (defined('ROBOTS_PAGES_TO_SKIP') && in_array($current_page_base, explode(",", constant('ROBOTS_PAGES_TO_SKIP'))) || $current_page_base == 'down_for_maintenance' || $robotsNoIndex === true) { ?>
      <meta name="robots" content="noindex, nofollow">
    <?php } ?>
    <?php if (defined('FAVICON')) { ?>
      <link href="<?php echo FAVICON; ?>" type="image/x-icon" rel="icon">
      <link href="<?php echo FAVICON; ?>" type="image/x-icon" rel="shortcut icon">
    <?php } //endif FAVICON  ?>

    <base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER . DIR_WS_HTTPS_CATALOG : HTTP_SERVER . DIR_WS_CATALOG ); ?>">
    <?php if (isset($canonicalLink) && $canonicalLink != '') { ?>
      <link href="<?php echo $canonicalLink; ?>" rel="canonical">
    <?php } ?>
    <?php
    // BOF hreflang for multilingual sites
    if (!isset($lng) || (isset($lng) && !is_object($lng))) {
      $lng = new language;
    }

    if (count($lng->catalog_languages) > 1) {
      foreach ($lng->catalog_languages as $key => $value) {
        echo '<link href="' . ($this_is_home_page ? zen_href_link(FILENAME_DEFAULT, 'language=' . $key, $request_type, false) : $canonicalLink . (strpos($canonicalLink, '?') ? '&amp;' : '?') . 'language=' . $key) . '" hreflang="' . $key . '" rel="alternate">' . "\n";
      }
    }
    // EOF hreflang for multilingual sites
    // Important to load Bootstrap CSS First...
    foreach ($preloads as $load) {
        if ($load['type'] === 'style') {
?>
    <link rel="stylesheet" href="<?= $load['link'] ?>" integrity="<?= $load['integrity'] ?>" crossorigin="anonymous">
<?php
        }
    }

    /**
     * load all template-specific stylesheets, named like "style*.css", alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^style/', '.css');
    foreach ($directory_array as $key => $value) {
      echo '<link href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '" rel="stylesheet">' . "\n";
    }
    /**
     * load stylesheets on a per-page/per-language/per-product/per-manufacturer/per-category basis. Concept by Juxi Zoza.
     */
    $manufacturers_id = (isset($_GET['manufacturers_id'])) ? $_GET['manufacturers_id'] : '';
    $tmp_products_id = (isset($_GET['products_id'])) ? (int)$_GET['products_id'] : '';
    $tmp_pagename = ($this_is_home_page) ? 'index_home' : $current_page_base;
    if ($current_page_base == 'page' && isset($ezpage_id)) {
      $tmp_pagename = $current_page_base . (int)$ezpage_id;
    }
    $sheets_array = array('/' . $_SESSION['language'] . '_stylesheet',
      '/' . $tmp_pagename,
      '/' . $_SESSION['language'] . '_' . $tmp_pagename,
      '/c_' . $cPath,
      '/' . $_SESSION['language'] . '_c_' . $cPath,
      '/m_' . $manufacturers_id,
      '/' . $_SESSION['language'] . '_m_' . (int)$manufacturers_id,
      '/p_' . $tmp_products_id,
      '/' . $_SESSION['language'] . '_p_' . $tmp_products_id
    );
    foreach ($sheets_array as $key => $value) {
      //echo "<!--looking for: $value-->\n";
      $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . $value . '.css';
      if (file_exists($perpagefile)) {
        echo '<link href="' . $perpagefile . '" rel="stylesheet">' . "\n";
      }
    }

    /**
     *  custom category handling for a parent and all its children ... works for any c_XX_XX_children.css  where XX_XX is any parent category
     */
    $tmp_cats = explode('_', $cPath);
    $value = '';
    foreach ($tmp_cats as $val) {
      $value .= $val;
      $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/c_' . $value . '_children.css';
      if (file_exists($perpagefile)) {
        echo '<link href="' . $perpagefile . '" rel="stylesheet">' . "\n";
      }
      $perpagefile = $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $_SESSION['language'] . '_c_' . $value . '_children.css';
      if (file_exists($perpagefile)) {
        echo '<link href="' . $perpagefile . '" rel="stylesheet">' . "\n";
      }
      $value .= '_';
    }

    /**
     * load printer-friendly stylesheets -- named like "print*.css", alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css'), '/^print/', '.css');
    sort($directory_array);
    foreach ($directory_array as $key => $value) {
      echo '<link href="' . $template->get_template_dir('.css', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/' . $value . '" media="print" rel="stylesheet">' . "\n";
    }

    require($template->get_template_dir('stylesheet_zca_colors.php', DIR_WS_TEMPLATE, $current_page_base, 'css') . '/stylesheet_zca_colors.php');

    // User defined styles come last 
    $user_styles = DIR_WS_TEMPLATE . 'css/site_specific_styles.php'; 
    if (file_exists($user_styles)) {
        require $user_styles; 
    }

    /** CDN for jQuery core * */
    foreach ($preloads as $load) {
          if ($load['type'] === 'script') {
?>
    <script src="<?= $load['link'] ?>" integrity="<?= $load['integrity'] ?>" crossorigin="anonymous"></script>
<?php
          }
    }
    /**
     * load all site-wide jscript_*.js files from includes/templates/YOURTEMPLATE/jscript, alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.js', DIR_WS_TEMPLATE, $current_page_base, 'jscript'), '/^jscript_/', '.js');
    foreach ($directory_array as $key => $value) {
      echo '<script src="' . $template->get_template_dir('.js', DIR_WS_TEMPLATE, $current_page_base, 'jscript') . '/' . $value . '"></script>' . "\n";
    }

    /**
     * load all page-specific jscript_*.js files from includes/modules/pages/PAGENAME, alphabetically
     */
    $directory_array = $template->get_template_part($page_directory, '/^jscript_/', '.js');
    foreach ($directory_array as $key => $value) {
      echo '<script src="' . $page_directory . '/' . $value . '"></script>' . "\n";
    }

    /**
     * load all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically
     */
    $directory_array = $template->get_template_part($template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'jscript'), '/^jscript_/', '.php');
    foreach ($directory_array as $key => $value) {
      /**
       * include content from all site-wide jscript_*.php files from includes/templates/YOURTEMPLATE/jscript, alphabetically.
       * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
       */
      require($template->get_template_dir('.php', DIR_WS_TEMPLATE, $current_page_base, 'jscript') . '/' . $value);
      echo "\n";
    }
    /**
     * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
     */
    $directory_array = $template->get_template_part($page_directory, '/^jscript_/');
    foreach ($directory_array as $key => $value) {
      /**
       * include content from all page-specific jscript_*.php files from includes/modules/pages/PAGENAME, alphabetically.
       * These .PHP files can be manipulated by PHP when they're called, and are copied in-full to the browser page
       */
      require($page_directory . '/' . $value);
      echo "\n";
    }

// DEBUG: echo '<!-- I SEE cat: ' . $current_category_id . ' || vs cpath: ' . $cPath . ' || page: ' . $current_page . ' || template: ' . $current_template . ' || main = ' . ($this_is_home_page ? 'YES' : 'NO') . ' -->';
    ?>

  <?php
  $zco_notifier->notify('NOTIFY_HTML_HEAD_END', $current_page_base);
  ?>
  </head>

<?php // NOTE: Blank line following is intended:   ?>
