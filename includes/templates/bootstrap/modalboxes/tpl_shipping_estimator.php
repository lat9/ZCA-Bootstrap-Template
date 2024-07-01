<?php
// -----
// Part of the Bootstrap template, displaying a modal shipping-estimator on the shopping-cart page.
//
// BOOTSTRAP v3.7.2
//
?>
<div class="modal fade" id="shippingEstimatorModal" tabindex="-1" role="dialog" aria-labelledby="shippingEstimatorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title mx-auto" id="shippingEstimatorModalLabel"><?= CART_SHIPPING_OPTIONS ?></h3>
                <button type="button" class="close m-0 p-0" data-dismiss="modal" aria-label="<?= TEXT_MODAL_CLOSE ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
      
            <div class="modal-body">
                <?php require DIR_WS_MODULES . zen_get_module_directory('shipping_estimator.php'); ?>
            </div>
      
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= TEXT_MODAL_CLOSE ?></button>
            </div>
        </div>
    </div>
</div>
