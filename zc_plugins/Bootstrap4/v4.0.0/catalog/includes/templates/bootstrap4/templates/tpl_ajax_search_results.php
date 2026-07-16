<?php
// -----
// Template formatting for the Bootstrap template's AJAX search feature.  Required by the
// template's AJAX search script (/includes/classes/ajax/zcAjaxBootstrapSearch.php).
//
// Bootstrap v3.7.0.
//
foreach ($products_search as $next) {
?>
<div class="sugg col-md-6">
    <div class="sugg-content">
        <a href="<?= $next['link'] ?>">
            <div class="sugg-img"><?= $next['image'] ?></div>
            <div class="sugg-name"><?= $next['name'] ?></div>
            <div class="sugg-model"><?= $next['model'] ?></div>
            <div class="sugg-brand"><?= $next['brand'] ?></div>
            <div class="sugg-price"><?= $next['price'] ?></div>
        </a>
    </div>
</div>
<?php
}
?>
<div class="row col-12">
    <div class="col-12 d-flex justify-content-center">
        <?= sprintf(TEXT_AJAX_SEARCH_RESULTS, $search_results_count) ?>&nbsp;
        <a class="btn btn-default sugg-button" role="button" href="<?= zen_href_link(FILENAME_SEARCH_RESULT) ?>">
            <?= TEXT_AJAX_SEARCH_VIEW_ALL; ?>
        </a>
    </div>
</div>
