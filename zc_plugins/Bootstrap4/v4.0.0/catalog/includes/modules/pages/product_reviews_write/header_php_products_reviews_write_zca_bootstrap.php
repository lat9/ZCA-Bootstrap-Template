<?php
// -----
// product_reviews_write: Slight modification of the formatting of the 'products_model', if the ZCA Bootstrap template
// is installed and active.
//
if (function_exists('is_bootstrap_template') && is_bootstrap_template()) {
    if ($product_info->fields['products_model'] != '') {
        $products_model = $product_info->fields['products_model'];
    } else {
        $products_model = '';
    }
}
