<?php
/**
 * Module Template
 * 
 * BOOTSTRAP v3.5.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_modules_order_totals.php 2993 2006-02-08 07:14:52Z birdbrain $
 */
// -----
// If a column-span for the title is provided, use it; otherwise, no colspan.
//
$zca_bootstrap_ot_colspan = !empty($_SESSION['zca_bootstrap_ot_colspan']) ? ' colspan="' . $_SESSION['zca_bootstrap_ot_colspan'] . '"' : '';

/**
 * Displays order-totals modules' output, as called from order_total::output
 */
for ($i = 0; $i < $size; $i++) {
?>
<tr id="<?php echo str_replace('_', '', $GLOBALS[$class]->code); ?>">
    <td<?php echo $zca_bootstrap_ot_colspan; ?> class="ot-title"><?php echo $GLOBALS[$class]->output[$i]['title']; ?></td>
    <td class="ot-text"><?php echo $GLOBALS[$class]->output[$i]['text']; ?></td> 
</tr>
<?php
}
