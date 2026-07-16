<?php
/**
 * Common Template - tpl_box_default_left.php
 * 
 * BOOTSTRAP v3.4.0
 *
 * @package templateSystem
 * @copyright Copyright 2003-2005 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: tpl_box_default_left.php 2975 2006-02-05 19:33:51Z birdbrain $
 */

// -----
// The "core" Zen Cart sideboxes normally bracket the $title with a <label></label>;
// those tags are neither needed nor wanted for the bootstrap implementation.
//
$title = str_replace(['<label>', '</label>'], '', $title);

if (!empty($title_link)) {
    $title = '<a href="' . zen_href_link($title_link) . '">' . $title . BOX_HEADING_LINKS . '</a>';
}
?>
<div id="<?php echo str_replace('_', '-', $box_id ) . '-leftBoxCard'; ?>" class="leftBoxCard card mb-3">
    <h4 id="<?php echo str_replace('_', '-', $box_id) . '-leftBoxHeading'; ?>" class="leftBoxHeading card-header"><?php echo $title; ?></h4>
    <?php echo $content; ?>
</div>
