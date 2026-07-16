<?php
// -----
// Loop through the to-be-displayed productArray, changing any submit-type image in
// its 'buttonUpdate' elements to contain a font-awesome glyph instead.
//
// That regex "magic" says find the first '<input type="image"{...}/>', replace it with the
// button and then copy anything else (like the 'hidden' input that follows).
//
// BOOTSTRAP 4.0.0
//
if (!(function_exists('is_bootstrap_template') && is_bootstrap_template())) {
    return;
}

if (!isset($productArray) || !is_array($productArray)) {
    $productArray = [];
}
for ($i = 0, $n = count($productArray); $i < $n; $i++) {
    // -----
    // For whatever reason, the base Zen Cart formatting for the 'buttonUpdate' entry
    // includes a *disabled* update button when a product requires a fixed quantity
    // to be displayed.  If that's the case, just don't include the button.
    //
    if ($productArray[$i]['flagShowFixedQuantity'] === true) {
        $productArray[$i]['buttonUpdate'] = '&nbsp;' . zen_draw_hidden_field('products_id[]', $productArray[$i]['id']);

        // -----
        // When a product's set to show a fixed-quantity, the 'assumption' is that the incoming
        // 'showFixedQuantityAmount' field is formatted in a manner similar to:
        //
        // 1<input type="hidden" name="cart_quantity[]" value="1">
        //
        // The fixed-quantity amount (which could also be a fractional value, e.g. 1.125) is extracted
        // and put into a span that matches the height of any non-fixed-quantity input fields.
        //
        $fixed_quantity_values = preg_match('/^([0-9]+\.?[0-9]*)(.*)$/', $productArray[$i]['showFixedQuantityAmount'], $matches);
        if ($fixed_quantity_values !== 1) {
            trigger_error('Malformed showFixedQuantityAmount, expecting leading int/float string:' . PHP_EOL . json_encode($productArray[$i], JSON_PRETTY_PRINT), E_USER_NOTICE);
        } else {
            $productArray[$i]['showFixedQuantityAmount'] = '<span class="f-q-a p-2 d-block">' . $matches[1] . '</span>' . $matches[2];
        }
    } else {
        // -----
        // Depending on the string-length of the ICON_UPDATE_ALT language constant, the base Zen Cart
        // CSS button generation creates the update-icon in one of two forms, either of which is 'converted'
        // into an FA icon:
        //
        // <button type="submit" class="btn button_update_cart">Update</button>
        //
        // <input type="image" src="includes/templates/template_default/buttons/english/button_update_cart.png" alt="Change your quantity by highlighting the number in the box, correcting the quantity and clicking this button." title="Change your quantity by highlighting the number in the box, correcting the quantity and clicking this button.">
        //
        $productArray[$i]['buttonUpdate'] = preg_replace(
            [
                '/<input.*type="image".*?\/?>/',
                '/<button.*type="submit".*?>.*button>/'
            ],
            '<button type="submit" class="btn btn-sm" aria-label="' . ICON_UPDATE_ALT . '" title="' . ICON_UPDATE_ALT . '"><i aria-hidden="true" class="fas fa-sm fa-sync-alt"></i></button>',
            $productArray[$i]['buttonUpdate']
        );
    }
    $productArray[$i]['quantityField'] = str_replace('form-control', 'form-control mx-auto text-center p-0', $productArray[$i]['quantityField']);
}
