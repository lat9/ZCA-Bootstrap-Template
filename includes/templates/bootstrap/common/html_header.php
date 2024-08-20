<?php
/**
 * Common Template
 *
 * BOOTSTRAP v3.7.3
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
        'link' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/fontawesome.min.css',
        'integrity' => 'sha512-UuQ/zJlbMVAw/UU8vVBhnI4op+/tFOpQZVT+FormmIEhRSCnJWyHiBbEVgM4Uztsht41f3FzVWgLuwzUqOObKw==',
        'type' => 'style',
    ],
    'fa-solid' => [
        'link' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/solid.min.css',
        'integrity' => 'sha512-Hp+WwK4QdKZk9/W0ViDvLunYjFrGJmNDt6sCflZNkjgvNq9mY+0tMbd6tWMiAlcf1OQyqL4gn2rYp7UsfssZPA==',
        'type' => 'style',
    ],
];
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
  <head>
    <meta charset="<?php echo CHARSET; ?>">
<?php
// -----
// Provide a notification that the <head> tag has been rendered for the current page.
//
$zco_notifier->notify('NOTIFY_HTML_HEAD_TAG_START', $current_page_base);

// -----
// Provide an easy way for a site to disable the preload, if they want to ensure
// that it's working properly.  If  includes/extra_datafiles/site-specific-bootstrap-settings.php does not exist 
// copy dist.site-specific-bootstrap-settings.php to site-specific-bootstrap-settings.php 
// and uncomment "// $zca_no_preloading = false;" and change that variable's value to (bool)true.
//
if (empty($zca_no_preloading)) {
    foreach ($preloads as $load) {
?>
    <link rel="preload" href="<?= $load['link'] ?>" integrity="<?= $load['integrity'] ?>" crossorigin="anonymous" as="<?= $load['type'] ?>">
<?php
    }
}
?>
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
if (!isset($lng) || !is_object($lng)) {
    $lng = new language;
}

if (count($lng->catalog_languages) > 1) {
    foreach ($lng->catalog_languages as $key => $value) {
        if ($this_is_home_page) {
            $hreflang_link = zen_href_link(FILENAME_DEFAULT, 'language=' . $key, $request_type, false);
        } else {
            $hreflang_link = $canonicalLink . (strpos($canonicalLink, '?') !== false ? '&amp;' : '?') . 'language=' . $key;
        }
        echo '<link href="' . $hreflang_link . '" hreflang="' . $key . '" rel="alternate">' . "\n";
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
 * Load all template-specific stylesheets, via the common CSS loader.
 */
require $template->get_template_dir('html_header_css_loader.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/html_header_css_loader.php';

/** CDN for jQuery core * */
foreach ($preloads as $load) {
    if ($load['type'] === 'script') {
?>
    <script src="<?= $load['link'] ?>" integrity="<?= $load['integrity'] ?>" crossorigin="anonymous"></script>
<?php
    }
}

/**
 * Load all template-specific jscript files, via the common jscript loader.
 */
require $template->get_template_dir('html_header_js_loader.php', DIR_WS_TEMPLATE, $current_page_base, 'common') . '/html_header_js_loader.php';

$zco_notifier->notify('NOTIFY_HTML_HEAD_END', $current_page_base);
?>
  </head>

<?php // NOTE: Blank line following is intended:   ?>
