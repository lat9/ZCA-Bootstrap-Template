<?php
// -----
// Part of the Bootstrap 4 Template Home-Page Carousel by lat9.
// Copyright (C) 2021-2025, Vinos de Frutas Tropicales.
//
// BOOTSTRAP v3.7.6
//
// -----
// Zen Cart's 'base' banner management requires that a 'banners_history' record be present for a 'banner' if that banner is
// to be expired.  Add a dummy record for any slider banners that don't already have such a record.
//
$slider_banner_check = $db->Execute(
    "SELECT b.banners_id
       FROM " . TABLE_BANNERS . " b
      WHERE b.banners_group = '" . BS4_SLIDER_BANNER_GROUP . "'
        AND b.banners_id NOT IN (SELECT bh.banners_id FROM " . TABLE_BANNERS_HISTORY . " bh)"
);
foreach ($slider_banner_check as $banner_history) {
    $banner_history['banners_history_date'] = 'now()';
    zen_db_perform(TABLE_BANNERS_HISTORY, $banner_history);
}

// -----
// Load any applicable home-page banners
//
$bs4_hp_banners = $db->Execute(
    "SELECT banners_id, banners_title, banners_image, banners_url, banners_open_new_windows
       FROM " . TABLE_BANNERS . "
      WHERE status = 1
        AND banners_group = '" . BS4_SLIDER_BANNER_GROUP . "'
      ORDER BY banners_sort_order, banners_id"
);
if ($bs4_hp_banners->EOF) {
    return;
}
?>
<div id="carouselHomeSlider" class="carousel banner-carousel slide" data-ride="carousel" data-interval="5000">
    <ol class="carousel-indicators">
<?php
for ($i = 0, $n = count($bs4_hp_banners), $hp_class = ' class="active"'; $i < $n; $i++) {
?>
        <li data-target="#carouselHomeSlider" data-slide-to="<?= $i ?>"<?= $hp_class ?>></li>
<?php
    $hp_class = '';
}
?>
    </ol>
    <div class="carousel-inner">
<?php
$hp_class = 'active';
foreach ($bs4_hp_banners as $row) {
    if (empty($row['banners_url'])) {
        $banner_href = 'javascript:void(0);';
        $anchor_target = '';
    } else {
        $banner_href = $row['banners_url'];
        $anchor_target = ($row['banners_open_new_windows'] === '1') ? ' target="_blank"' : '';
    }
?>
        <div class="carousel-item <?= $hp_class ?>">
            <a href="<?= $banner_href ?>" <?= $anchor_target ?>>
                <?= zen_image(DIR_WS_IMAGES . $row['banners_image'], $row['banners_title'], BS4_SLIDER_WIDTH, BS4_SLIDER_HEIGHT, ' class="mx-auto d-block"') ?>
            </a>
        </div>
<?php
    $hp_class = '';
}
?>
    </div>
    <a class="carousel-control-prev" data-target="#carouselHomeSlider" role="button" data-slide="prev">
        <span><i class="fas fa-lg fa-chevron-left" aria-hidden="true"></i></span>
        <span class="sr-only"><?= BUTTON_PREVIOUS_ALT ?></span>
    </a>
    <a class="carousel-control-next" data-target="#carouselHomeSlider" role="button" data-slide="next">
        <span><i class="fas fa-lg fa-chevron-right" aria-hidden="true"></i></span>
        <span class="sr-only"><?= BUTTON_NEXT_ALT ?></span>
    </a>
</div>
<div class="mb-2"></div>
