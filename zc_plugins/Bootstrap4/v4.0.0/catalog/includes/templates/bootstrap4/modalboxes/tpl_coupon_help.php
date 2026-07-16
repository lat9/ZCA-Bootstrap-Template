<?php
/**
 * Override Template for common/tpl_main_page.php
 *
 * BOOTSTRAP v3.5.2
 *
 * @package templateSystem
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Drbyte Wed Aug 2 14:55:16 2017 -0400 Modified in v1.5.6 $
 */
// -----
// Nothing to render if no coupon has been applied to the order.  Perform a quick-return
// in this case to prevent PHP notices.
//
if (empty($_SESSION['cc_id'])) {
    return;
}

// -----
// Check to see that the coupon actually exists prior to rendering, performing a
// quick-return if not.
//
$sql =
    "SELECT c.*, cd.coupon_name, cd.coupon_description
       FROM " . TABLE_COUPONS . " c
            INNER JOIN " . TABLE_COUPONS_DESCRIPTION . " cd
                ON cd.coupon_id = c.coupon_id
               AND cd.language_id = :langID
      WHERE c.coupon_id = :couponID
      LIMIT 1";
$sql = $db->bindVars($sql, ':couponID', $_SESSION['cc_id'], 'integer');
$sql = $db->bindVars($sql, ':langID', $_SESSION['languages_id'], 'integer');
$coupon = $db->Execute($sql);
if ($coupon->EOF) {
    return;
}

// -----
// Load the language file for the popup_coupon_help page.
//
zca_load_language_for_modal('popup_coupon_help'); 
?>
<!-- Modal -->
<div class="modal fade" id="couponHelpModal" tabindex="-1" role="dialog" aria-labelledby="couponHelpModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="<?php echo TEXT_MODAL_CLOSE; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
<?php
$text_coupon_help = TEXT_COUPON_HELP_HEADER;

$text_coupon_help .= sprintf(TEXT_COUPON_HELP_NAME, $coupon->fields['coupon_name']);
if (!empty($coupon->fields['coupon_description'])) {
    $text_coupon_help .= sprintf(TEXT_COUPON_HELP_DESC, $coupon->fields['coupon_description']);
}

$coupon_amount = $coupon->fields['coupon_amount'];
$coupon_info = [];
switch ($coupon->fields['coupon_type']) {
    case 'F': // amount Off
        $coupon_info[] = str_replace('<br>', '', sprintf(TEXT_COUPON_HELP_FIXED, $currencies->format($coupon_amount)));
        break;
    case 'P': // percentage
        $coupon_info[] = str_replace('<br>', '', sprintf(TEXT_COUPON_HELP_FIXED, number_format($coupon_amount, 2) . '%'));
        break;
    case 'S': // Free Shipping
       $coupon_info[] = str_replace('<br>', '', TEXT_COUPON_HELP_FREESHIP);
        break;
    case 'E': // percentage & Free Shipping
        $coupon_info[] = str_replace('<br>', '', TEXT_COUPON_HELP_FREESHIP . sprintf(TEXT_COUPON_HELP_FIXED, number_format($coupon_amount, 2) . '%'));
        break;
    case 'O': // amount off & Free Shipping
        $coupon_info[] = str_replace('<br>', '', TEXT_COUPON_HELP_FREESHIP . sprintf(TEXT_COUPON_HELP_FIXED, $currencies->format($coupon_amount)));
        break;
    default:
        break;
}

if ($coupon->fields['coupon_is_valid_for_sales'] === '0') {
    $coupon_info[] = str_replace('<br>', '', TEXT_NO_PROD_SALES);
}

if ($coupon->fields['coupon_minimum_order'] > 0) {
    $coupon_info[] = str_replace('<br>', '', sprintf(TEXT_COUPON_HELP_MINORDER, $currencies->format($coupon->fields['coupon_minimum_order'])));
}

$coupon_info[] = str_replace('<br>', '', sprintf(TEXT_COUPON_HELP_DATE, zen_date_short($coupon->fields['coupon_start_date']), zen_date_short($coupon->fields['coupon_expire_date'])));
$text_coupon_help .= '<ul id="couponInfo">' . '<li>' . implode('</li><li>', $coupon_info) . '</li></ul>';

$text_coupon_help .= '<strong>' . str_replace('<br>', '', TEXT_COUPON_HELP_RESTRICT) . '</strong>';

if ($coupon->fields['coupon_zone_restriction'] > 0) {
    $text_coupon_help .= '<br><br>' . TEXT_COUPON_GV_RESTRICTION_ZONES;
}

$text_coupon_help .= '<br><br>' .  TEXT_COUPON_HELP_CATEGORIES;
$sql = "SELECT * FROM " . TABLE_COUPON_RESTRICT . "  WHERE coupon_id = :couponID: AND category_id !='0'";
$sql = $db->bindVars($sql, ':couponID:', $_SESSION['cc_id'], 'integer');
$get_result = $db->Execute($sql);

$cats = [];
if ($get_result->RecordCount() === 1 && $get_result->fields['category_id'] === '-1') {
    $cats[] = TEXT_NO_CAT_TOP_ONLY_DENY;
} elseif (!$get_result->EOF) {
    foreach ($get_result as $next_restriction) {
        if ($next_restriction['coupon_restrict'] === 'N') {
            $restrict = TEXT_ALLOWED;
        } else {
            $restrict = TEXT_DENIED;
        }
        if ($next_restriction['category_id'] !== '-1') {
            $result = $db->Execute(
                "SELECT *
                   FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd
                  WHERE c.categories_id = cd.categories_id
                    AND cd.language_id = " . (int)$_SESSION['languages_id'] . "
                    AND c.categories_id = " . $next_restriction['category_id'] . "
                  LIMIT 1"
            );
            $cats[] = $result->fields["categories_name"] . $restrict;
        }
    }
}
if (count($cats) === 0) {
    $cats[] = TEXT_NO_CAT_RESTRICTIONS;
} else {
    sort($cats);
}

$text_coupon_help .= '<ul id="couponCatRestrictions">' . '<li>' . implode('</li><li>', $cats) . '</li></ul>';

$text_coupon_help .= TEXT_COUPON_HELP_PRODUCTS;

$sql = "SELECT * FROM " . TABLE_COUPON_RESTRICT . " WHERE coupon_id = :couponID: AND product_id != 0";
$sql = $db->bindVars($sql, ':couponID:', $_SESSION['cc_id'], 'integer');
$get_result = $db->Execute($sql);

$prods = [];
foreach ($get_result as $next_restriction) {
    if ($next_restriction['coupon_restrict'] === 'N') {
        $restrict = TEXT_ALLOWED;
    } else {
        $restrict = TEXT_DENIED;
    }
    $prods[] = zen_get_products_name($next_restriction['product_id']) . $restrict;
}

if (count($prods) === 0) {
    $prods[] = TEXT_NO_PROD_RESTRICTIONS;
}
sort($prods);
$text_coupon_help .= '<ul id="couponProdRestrictions">' . '<li>' . implode('</li><li>', $prods) . '</li></ul>' . TEXT_COUPON_GV_RESTRICTION;

echo $text_coupon_help;
?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo TEXT_MODAL_CLOSE; ?></button>
            </div>
        </div>
    </div>
</div>
