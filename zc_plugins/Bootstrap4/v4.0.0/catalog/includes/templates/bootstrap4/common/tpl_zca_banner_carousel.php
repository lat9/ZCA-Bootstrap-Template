<?php
/**
 * ZCA Banners Carousel
 * Plugin Template
 * 
 * BOOTSTRAP v3.7.6
 *
 */
// -----
// Filter the banners query if desired
//
$my_banner_filter = '';

// -----
// The $find_banners value is presumed to be set by the invoking script and is the
// output of that script's call to zen_build_banners_group.
//
$sql =
    "SELECT banners_id
       FROM " . TABLE_BANNERS . "
      WHERE status = 1 " .
           $find_banners .
           $my_banner_filter . "
      ORDER BY banners_sort_order";
$banners = $db->Execute($sql);

// if no active banner in the specified banner group then the box will not show
if ($banners->EOF) {
    return;
}

$carousel_group_id = 'carouselGroup' . (int)$banner_group;
?>
<div id="<?= $carousel_group_id ?>" class="carousel banner-carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
<?php
$num_banners = $banners->RecordCount();
$slide_to_class = ' class="active"';
for ($slide_to = 0; $slide_to < $num_banners; $slide_to++) {
?>
        <li data-target="#<?= $carousel_group_id ?>" data-slide-to="<?= $slide_to ?>"<?= $slide_to_class ?>></li>
<?php
    $slide_to_class = '';
}
?>
    </ol>
    <div class="carousel-inner rounded">
<?php
// -----
// The first banner in the group is active; all others won't have this class as
// the variable's reset to an empty string at the end of the foreach loop below.
//
$addBannerClass = ' active';
foreach ($banners as $row) {
?>
        <div class="carousel-item<?= $addBannerClass ?>">
            <?= zen_display_banner('static', $row['banners_id']) ?>
        </div>
  
<?php
    $addBannerClass = '';
}
?>
    </div>
    <a class="carousel-control-prev" role="button" data-slide="prev" data-target="#<?= $carousel_group_id ?>">
        <span><i class="fas fa-lg fa-chevron-left" aria-hidden="true"></i></span>
        <span class="sr-only"><?= BUTTON_PREVIOUS_ALT ?></span>
    </a>
    <a class="carousel-control-next" role="button" data-slide="next" data-target="#<?= $carousel_group_id ?>">
        <span><i class="fas fa-lg fa-chevron-right" aria-hidden="true"></i></span>
        <span class="sr-only"><?= BUTTON_NEXT_ALT ?></span>
    </a>
</div>
