<?php
/**
 * additional_images module
 *
 * BOOTSTRAP v3.8.0
 *
 * Prepares list of additional product images to be displayed in template
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Author: DrByte  Wed Jan 6 12:47:43 2016 -0500 Modified in v1.5.5 $
 */
if (!defined('IS_ADMIN_FLAG')) {
    die('Illegal Access');
}
$zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_PRODUCT_IMAGES_START');

$images_array = [];

// do not check for additional images when turned off
if ($products_image !== '' && $flag_show_product_info_additional_images !== '0') {
    $products_image_info = pathinfo($products_image);

    $products_image_extension = $products_image_info['extension'];  //-Note, does not include the leading '.'!
    $products_image_base = $products_image_info['filename'];
    $products_image_directory = $products_image_info['dirname'];

    // -----
    // Additional images in subdirectories *always" require an intervening '_' to match.
    // So do those in the /images root if we're running on zc210 or later and the
    // additional images' "mode" setting indicates that we're running in 'strict' mode,
    // in which case the intervening '_' is also needed.
    //
    if ($tplSetting->ADDITIONAL_IMAGES_MODE === 'legacy' && $products_image_directory === '.') {
        $products_image_base .= '?';
        $products_image_directory = '';
    } else {
        $products_image_base .= '_';
        $products_image_directory .= '/';
    }

    $products_image_directory = DIR_WS_IMAGES . $products_image_directory;

    // Check for additional matching images
    foreach (glob($products_image_directory . $products_image_base . '*.' . $products_image_extension) as $file) {
        $images_array[] = $file;
    }
}

// Build output based on images found
$num_images = count($images_array);
$list_box_contents = [];
$title = '';

if ($num_images !== 0) {
    $row = 0;
    $col = 0;
    $images_auto_added = (int)$tplSetting->IMAGES_AUTO_ADDED;
    if ($num_images < $images_auto_added || $images_auto_added === 0) {
        $col_width = floor(100 / $num_images);
    } else {
        $col_width = floor(100 / $images_auto_added);
    }

    $slideNumber = 1;
    $image_extension = '.' . $products_image_extension;
    foreach ($images_array as $file) {
        $products_image_large = str_replace(
            [
                DIR_WS_IMAGES,
                $image_extension,
            ],
            [
                DIR_WS_IMAGES . 'large/',
                zen_config('IMAGE_SUFFIX_LARGE') . $image_extension
            ],
            $file
        );

        // -----
        // This notifier lets any image-handler know the current image being processed, providing the following parameters:
        //
        // $p1 ... (r/o) ... The current product's name
        // $p2 ... (r/w) ... The (possibly updated) filename (including path) of the current additional image.
        //
        $zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_IMAGES_GET_LARGE', $products_name, $products_image_large);

        $flag_has_large = file_exists($products_image_large);
        $products_image_large = ($flag_has_large === true) ? $products_image_large : $file;

        zen_define_default('IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE', 'Yes');
        $flag_display_large = (IMAGE_ADDITIONAL_DISPLAY_LINK_EVEN_WHEN_NO_LARGE === 'Yes' || $flag_has_large === true);

        $base_image = $file;
        $thumb_slashes = zen_image(addslashes($base_image), addslashes($products_name), $tplSetting->SMALL_IMAGE_WIDTH, $tplSetting->SMALL_IMAGE_HEIGHT);
        $thumb_regular = zen_image($base_image, $products_name, $tplSetting->SMALL_IMAGE_WIDTH, $tplSetting->SMALL_IMAGE_HEIGHT);
        $large_link = zen_href_link(FILENAME_POPUP_IMAGE_ADDITIONAL, 'pID=' . $_GET['products_id'] . '&pic=' . $slideNumber . '&products_image_large_additional=' . $products_image_large);
        $slideNumber++;

        $slide = zen_image($products_image_large);
        // List Box array generation:
        $list_box_contents[$row][$col] = [
            'params' => 'class="item carousel-item" data-slide-number="' . $slideNumber . '"',
            'text' => $slide
        ];
        $col++;
        if ($col >= $images_auto_added) {
            $col = 0;
            $row++;
        }
    } // end for loop
} // endif

$zco_notifier->notify('NOTIFY_MODULES_ADDITIONAL_PRODUCT_IMAGES_END');
