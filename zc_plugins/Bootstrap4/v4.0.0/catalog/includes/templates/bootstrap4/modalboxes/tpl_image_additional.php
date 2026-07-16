<?php
/**
 * Override Modal for popup_image_additional
 * 
 * BOOTSTRAP v3.6.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
$modal_products_name = zen_output_string_protected($products_name);
$modal_image_alt = sprintf(MODAL_ADDL_IMAGE_PLACEHOLDER_ALT, $modal_products_name);
?>
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel"><?php echo $modal_products_name; ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo TEXT_MODAL_CLOSE; ?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="p-2"></div>
                <img class="showimage img-responsive" alt="<?php echo $modal_image_alt; ?>" title="<?php echo $modal_products_name; ?>" src="<?php echo $products_image_large; ?>">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo TEXT_MODAL_CLOSE; ?></button>
            </div>
        </div>
    </div>
</div>
