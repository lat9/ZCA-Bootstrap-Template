<?php
/**
 * more_information sidebox - displays list of links to additional pages on the site.  Must separately build those pages' content.
 *
 * BOOTSTRAP v3.8.0
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2019 Jul 24 Modified in v1.5.7 $
 */
// -----
// Enabling this sidebox's information to also be used by the mobile-menu.  If the variable
// $more_information_sidebox_class is 'not empty', then it contains the classes to apply to the
// various links and the default sidebox display is to be bypassed.
//
// Note that it's the responsibility of the calling module (e.g. /common/tpl_offcanvas_menu.php) to see if the
// "More Information" sidebox elements are currently enabled via the admin's Layout Boxes Controller.
//
$more_information_classes = (!empty($more_information_sidebox_class)) ? $more_information_sidebox_class : 'list-group-item list-group-item-action';

// initialize
$more_information = [];

// test if links should display
if ($tplSetting->DEFINE_PAGE_2_STATUS <= 1) {
    $more_information[] = '<a class="' . $more_information_classes . '" href="' . zen_href_link(FILENAME_PAGE_2) . '">' . BOX_INFORMATION_PAGE_2 . '</a>';
}
if ($tplSetting->DEFINE_PAGE_3_STATUS <= 1) {
    $more_information[] = '<a class="' . $more_information_classes . '" href="' . zen_href_link(FILENAME_PAGE_3) . '">' . BOX_INFORMATION_PAGE_3 . '</a>';
}
if ($tplSetting->DEFINE_PAGE_4_STATUS <= 1) {
    $more_information[] = '<a class="' . $more_information_classes . '" href="' . zen_href_link(FILENAME_PAGE_4) . '">' . BOX_INFORMATION_PAGE_4 . '</a>';
}

// insert additional links below to add to the more_information box
// Example:
//    $more_information[] = '<a href="' . zen_href_link(FILENAME_DEFAULT) . '">' . 'TESTING' . '</a>';

// -----
// ... or create an observer-class file that monitors the following notification.
//
$zco_notifier->notify('NOTIFY_MORE_INFORMATION_SIDEBOX_ADDITIONS', [], $more_information);

// only show if links are active
if (count($more_information) > 0 && empty($more_information_sidebox_class)) {
    require $template->get_template_dir('tpl_more_information.php', DIR_WS_TEMPLATE, $current_page_base, 'sideboxes') . '/tpl_more_information.php';

    $title =  BOX_HEADING_MORE_INFORMATION;
    $title_link = false;
    require $template->get_template_dir($column_box_default, DIR_WS_TEMPLATE, $current_page_base, 'common') . '/' . $column_box_default;
}
