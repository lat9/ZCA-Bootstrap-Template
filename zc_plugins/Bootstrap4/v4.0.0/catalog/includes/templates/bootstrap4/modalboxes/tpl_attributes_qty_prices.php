<?php
/**
 * Override Modal for popup_attributes_qty_prices
 *
 * BOOTSTRAP v3.8.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2016 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
// -----
// Issue a notification, just in case an override is needed.
//
$processing_completed = false;
$zco_notifier->notify('NOTIFY_BOOTSTRAP_ATTRIBUTES_QTY_PRICES', $products_tax_class_id, $processing_completed);
if ($processing_completed === true) {
    return;
}
?>
<div class="modal fade" id="attributesQtyPricesModal" tabindex="-1" role="dialog" aria-labelledby="attributesQtyPricesModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="attributesQtyPricesModalLabel"><?= TEXT_ATTRIBUTES_QTY_PRICES_HELP ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="<?= TEXT_MODAL_CLOSE ?>">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
<?php
$show_onetime = 'false';

// attributes_qty_price
if (zen_config('PRODUCTS_OPTIONS_SORT_ORDER') === '0') {
    $options_order_by = " ORDER BY LPAD(popt.products_options_sort_order,11,'0')";
} else {
    $options_order_by = ' ORDER BY popt.products_options_name';
}

$sql =
    "SELECT DISTINCT popt.products_options_id, popt.products_options_name, popt.products_options_sort_order,
                     popt.products_options_type, popt.products_options_length, popt.products_options_comment, popt.products_options_size
       FROM " . TABLE_PRODUCTS_OPTIONS . " popt, " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
      WHERE patrib.products_id = " . (int)$_GET['products_id'] . "
        AND patrib.options_id = popt.products_options_id
        AND popt.language_id = " . (int)$_SESSION['languages_id'] .
      $options_order_by;
$products_options_names_lookup = $db->Execute($sql);

if (zen_config('PRODUCTS_OPTIONS_SORT_BY_PRICE') === '1') {
    $order_by = " ORDER BY LPAD(pa.products_options_sort_order,11,'0'), pov.products_options_values_name";
} else {
    $order_by = " ORDER BY LPAD(pa.products_options_sort_order,11,'0'), pa.options_values_price";
}
foreach ($products_options_names_lookup as $next_option) {
    $sql =
        "SELECT pov.products_options_values_id, pov.products_options_values_name, pa.*
           FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
          WHERE pa.products_id = " . (int)$_GET['products_id'] . "
            AND pa.options_id = " . $next_option['products_options_id'] . "
            AND pa.options_values_id = pov.products_options_values_id
            AND pov.language_id = " . (int)$_SESSION['languages_id'] .
          $order_by;
    $products_options_lookup = $db->Execute($sql);

    foreach ($products_options_lookup as $next_option_value) {
        $cnt_qty_prices = 0;

        // set for attributes_qty_prices_onetime
        if (!empty($next_option_value['attributes_qty_prices_onetime'])) {
            $show_onetime = 'true';
        }

        if (!empty($next_option_value['attributes_qty_prices'])) {
            $attribute_quantity = '';
            $attribute_quantity_price = '';
            $attribute_table_cost = preg_split('/[:,]/' , str_replace(' ', '', $next_option_value['attributes_qty_prices']));

            // -----
            // An attributes_qty_prices layout is expected to be of the form
            //
            // qty:price[,qty:price]...
            //
            // If the count of the attribute's cost table is *not* a multiple of 2, then something's awry
            // with the configuration and a PHP notice is logged.
            //
            $size = count($attribute_table_cost);
            if (($size % 2) !== 0) {
                trigger_error('Malformed attributes_qty_prices for products_id #' . (int)$_GET['products_id'] . ', attribute id #' . $next_option_value['products_attributes_id'] . ': ' . $next_option_value['attributes_qty_prices'] . '.', E_USER_NOTICE);
            }
            for ($i = 0, $n = $size; $i < $n; $i += 2) {
                // -----
                // For the last entry, the quantity is ignored and the associated price applies to all
                // quantities >= the next-to-last entry's quantity.
                //
                if (($i + 2) >= $n) {
                    $zc_disp_qty = $attribute_table_cost[$i - 2] + 1 . '+';

                // -----
                // For the first entry, the quantity is either a singular '1' (if that's the quantity indicated) or
                // a range from '1' to the entry's quantity.  Use a 'lazy' comparison, in case a store uses fractional
                // quantities!
                //
                } elseif ($i === 0) {
                    $zc_disp_qty = (($attribute_table_cost[$i] == 1) ? '' : '1-') . $attribute_table_cost[$i];

                // -----
                // Otherwise, this is an intermediary entry which will display either as a quantity
                // range (from the previous entry's quantity +1 to the current entry's quantity) or a singular quantity (if the
                // previous entry's quantity is specifically 1 less than this entry's quantity).  Again, use a lazy
                // comparison in case the store uses fractional quantities.
                //
                } elseif ($attribute_table_cost[$i - 2] + 1 != $attribute_table_cost[$i]) {
                    $zc_disp_qty = $attribute_table_cost[$i - 2] + 1 . '-' . $attribute_table_cost[$i];
                } else {
                    $zc_disp_qty = $attribute_table_cost[$i];
                }

                $attribute_quantity .= '<td class="text-center">' . $zc_disp_qty . '</td>';
                $attribute_quantity_price .= '<td class="text-right">' . $currencies->display_price($attribute_table_cost[$i + 1], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                $cnt_qty_prices++;
            }
?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tr>
              <td colspan="<?= $cnt_qty_prices + 1 ?>">
                <b><?= $next_option['products_options_name'] ?></b>: <em><?= $next_option_value['products_options_values_name'] ?></em>
              </td>
            </tr>
            <tr>
              <td><?= TABLE_ATTRIBUTES_QTY_PRICE_QTY ?></td>
              <?= $attribute_quantity ?>
            </tr>
            <tr>
              <td><?= TABLE_ATTRIBUTES_QTY_PRICE_PRICE ?></td>
              <?= $attribute_quantity_price ?>
            </tr>
          </table>
        </div>
<?php
        }
    }
}

// -----
// If there is one or more onetime price discount ...
//
if ($show_onetime === 'true') {
?>
        <h2 class="pageHeading"><?= TEXT_ATTRIBUTES_QTY_PRICES_ONETIME_HELP ?></h2>
<?php
    foreach ($products_options_names_lookup as $next_option) {
        $sql =
            "SELECT pov.products_options_values_id, pov.products_options_values_name, pa.*
               FROM " . TABLE_PRODUCTS_ATTRIBUTES . " pa, " . TABLE_PRODUCTS_OPTIONS_VALUES . " pov
              WHERE pa.products_id = " . (int)$_GET['products_id'] . "
                AND pa.options_id = " . $next_option['products_options_id'] . "
                AND pa.options_values_id = pov.products_options_values_id
                AND pov.language_id = " . (int)$_SESSION['languages_id'] .
              $order_by;
        $products_options_lookup = $db->Execute($sql);

        foreach ($products_options_lookup as $next_option_value) {
            $cnt_qty_prices = 0;

            if (!empty($next_option_value['attributes_qty_prices_onetime'])) {
                $attribute_quantity = '';
                $attribute_quantity_price = '';
                $attribute_table_cost = preg_split("/[:,]/" , $next_option_value['attributes_qty_prices_onetime']);
                
                // -----
                // An attributes_qty_prices layout is expected to be of the form
                //
                // qty:price[,qty:price]...
                //
                // If the count of the attribute's cost table is *not* a multiple of 2, then something's awry
                // with the configuration and a PHP notice is logged.
                //
                $size = count($attribute_table_cost);
                if (($size % 2) !== 0) {
                    trigger_error('Malformed attributes_qty_prices_onetime for products_id #' . (int)$_GET['products_id'] . ', attribute id #' . $next_option_value['products_attributes_id'] . ': ' . $next_option_value['attributes_qty_prices_onetime'] . '.', E_USER_NOTICE);
                }
                for ($i = 0, $n = $size; $i < $n; $i += 2) {
                    $attribute_quantity .= '<td class="text-center">' . $attribute_table_cost[$i] . '</td>';
                    $attribute_quantity_price .= '<td class="text-right">' . $currencies->display_price($attribute_table_cost[$i + 1], zen_get_tax_rate($products_tax_class_id)) . '</td>';
                    $cnt_qty_prices++;
                }
?>
        <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tr>
              <td colspan="<?= $cnt_qty_prices + 1 ?>">
                <b><?= $next_option['products_options_name'] ?></b>: <em><?= $next_option_value['products_options_values_name'] ?></em>
              </td>
            </tr>
            <tr>
              <td><?= TABLE_ATTRIBUTES_QTY_PRICE_QTY ?></td>
              <?= $attribute_quantity ?>
            </tr>
            <tr>';
              <td><?= TABLE_ATTRIBUTES_QTY_PRICE_PRICE ?></td>
              <?= $attribute_quantity_price ?>
            </tr>
          </table>
        </div>
<?php
            }
        }
    }
} // show onetime
?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= TEXT_MODAL_CLOSE ?></button>
      </div>
    </div>
  </div>
</div>
