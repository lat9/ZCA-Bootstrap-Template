<?php
// -----
// Part of the Bootstrap template for Zen Cart.  Included by /includes/templates/bootstrap/common/tpl_main_page.php.
//
// Bootstrap v3.7.2
//
if (defined('BS4_AJAX_SEARCH_ENABLE') && BS4_AJAX_SEARCH_ENABLE === 'true') {
    $ajax_search_parameter = (defined('BS4_AJAX_SEARCH_INC_DESC') && BS4_AJAX_SEARCH_INC_DESC === 'true') ? 'search_in_description=1' : '';
?>
    <div id="search-wrapper" class="modal fade" role="dialog" aria-labelledby="search-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body container-fluid">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?= TEXT_MODAL_CLOSE ?>"><i class="fas fa-times"></i></button>
                    <h5 class="modal-title mb-1" id="search-modal-title"><?= TEXT_AJAX_SEARCH_TITLE ?></h5>
                    <div class="form-group">
                        <form class="search-form">
                            <label for="search-input"><?= BUTTON_SEARCH_ALT ?>:</label>
                            <input type="text" id="search-input" class="form-control" placeholder="<?= TEXT_AJAX_SEARCH_PLACEHOLDER ?>">
                            <input id="search-page" type="hidden" value="<?= zen_href_link(FILENAME_SEARCH_RESULT, $ajax_search_parameter) ?>">
                        </form>
                    </div>
                    <div id="search-content" class="row"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
