<?php
/**
 * tpl_brands_default
 * 
 * BOOTSTRAP v3.4.0
 *
 * @copyright Copyright 2003-2022 Zen Cart Development Team
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: lat9 2022 Apr 30 New in v1.5.8-alpha $
 */
?>
<div id="indexBrandsList" class="centerColumn">
    <h1 id="indexBrandsList-pageHeading" class="pageHeading"><?php echo HEADING_TITLE; ?></h1>
<?php
// -----
// Display a message if no brands (aka manufacturers) are defined for the current store.
//
if (empty($brands['featured']) && empty($brands['other'])) {
?>
    <p><?php echo NO_BRANDS_AVAILABLE; ?></p>
<?php
} else {
    // -----
    // Display the list of featured brands, so long as at least one exists.
    //
    if (!empty($brands['featured'])) {
?>
    <div id="featuredBrands">
        <h2><?php echo FEATURED_BRANDS; ?></h2>
        <div class="row">
<?php
        foreach ($brands['featured'] as $record) {
            $manufacturers_name = $record['manufacturers_name'];
?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3 text-center mb-2">
                <div class="border p-2">
                    <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $record['manufacturers_id']); ?>">
                        <?php echo zen_image(DIR_WS_IMAGES . $record['manufacturers_image'], $manufacturers_name, BRANDS_IMAGE_WIDTH, BRANDS_IMAGE_HEIGHT); ?>
                        <span class="d-block"><?php echo $manufacturers_name; ?></span>
                    </a>
                </div>
            </div>
<?php
        }
?>
        </div>
    </div>
<?php
    }

    // -----
    // Display the list of 'other' brands, so long as at least one exists.
    //
    if (!empty($brands['other'])) {
?>
    <div class="otherBrands">
        <h2><?php echo OTHER_BRANDS; ?></h2>
        <div class="row">
<?php
        foreach ($brands['other'] as $record) {
            $manufacturers_name = $record['manufacturers_name'];
?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-xl-3 text-center mb-2">
                <div class="border p-2">
                    <a href="<?php echo zen_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $record['manufacturers_id']); ?>">
                        <?php echo zen_image(DIR_WS_IMAGES . $record['manufacturers_image'], $manufacturers_name, BRANDS_IMAGE_WIDTH, BRANDS_IMAGE_HEIGHT); ?>
                        <span class="d-block"><?php echo $manufacturers_name; ?></span>
                    </a>
                </div>
            </div>
<?php
        }
?>
        </div>
    </div>
<?php
    }
}
?>
</div>
