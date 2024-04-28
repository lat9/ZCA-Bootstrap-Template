<?php
// -----
// Part of the Bootstrap template for Zen Cart.  Included by /includes/templates/bootstrap/common/tpl_main_page.php.
//
// Bootstrap v3.7.0.
//
if (defined('BS4_AJAX_SEARCH_ENABLE') && BS4_AJAX_SEARCH_ENABLE === 'true') {
?>
    <div id="search-wrapper" class="modal fade" role="dialog" aria-labelledby="search-modal-title" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body container-fluid">
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo TEXT_MODAL_CLOSE; ?>"><i class="fas fa-times"></i></button>
                    <h5 class="modal-title mb-1" id="search-modal-title"><?php echo TEXT_AJAX_SEARCH_TITLE; ?></h5>
                    <div class="form-group">
                        <form class="search-form">
                            <label for="search-input"><?php echo BUTTON_SEARCH_ALT; ?>:</label>
                            <input type="text" id="search-input" class="form-control" placeholder="<?php echo TEXT_AJAX_SEARCH_PLACEHOLDER; ?>">
                            <input id="search-page" type="hidden" value="<?php echo zen_href_link(FILENAME_SEARCH_RESULT); ?>">
                        </form>
                    </div>
                    <div id="search-content" class="row"></div>
                </div>
            </div>
        </div>
    </div>
<?php
}
