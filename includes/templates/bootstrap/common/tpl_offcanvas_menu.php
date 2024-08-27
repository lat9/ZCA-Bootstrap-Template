<?php
/**
 * Template for Mobile Header Drop Down
 * 
 * BOOTSTRAP v3.7.3
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 */
?>
<li class="nav-item dropdown d-lg-none">
    <a class="nav-link dropdown-toggle" href="#" id="categoryDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo BOX_HEADING_CATEGORIES; ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="categoryDropdown">
        <ul class="m-0 p-0">
<?php
$categories_tab = $db->Execute(
    "SELECT c.categories_id, cd.categories_name 
       FROM " . TABLE_CATEGORIES . " c 
            INNER JOIN " . TABLE_CATEGORIES_DESCRIPTION . " cd
                ON cd.categories_id = c.categories_id 
               AND cd.language_id = " . (int)$_SESSION['languages_id'] . "
      WHERE c.categories_status = 1
        AND c.parent_id = 0
      ORDER BY c.sort_order, cd.categories_name"
);

foreach ($categories_tab as $category_tab) {
    $cat_tab_link = zen_href_link(FILENAME_DEFAULT, 'cPath=' . $category_tab['categories_id']);
    $cat_tab_name = htmlspecialchars($category_tab['categories_name'], ENT_COMPAT, CHARSET, true);
    if (isset($cPath) && ((int)$cPath == $category_tab['categories_id'])) {
        $cat_tab_name = '<span class="category-subs-selected">' . $cat_tab_name . '</span>';
    }
?>
            <li><a class="dropdown-item" href="<?php echo $cat_tab_link; ?>"><?php echo $cat_tab_name; ?></a></li>
<?php
}
?>
        </ul>
<?php
if (SHOW_CATEGORIES_BOX_SPECIALS === 'true') {
    $show_this = $db->Execute("SELECT s.products_id FROM " . TABLE_SPECIALS . " s WHERE s.status = 1 LIMIT 1");
    if (!$show_this->EOF) {
?>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo zen_href_link(FILENAME_SPECIALS); ?>'"><?php echo CATEGORIES_BOX_HEADING_SPECIALS; ?></a>
<?php
    }
}

if (SHOW_CATEGORIES_BOX_PRODUCTS_NEW === 'true') {
      // display limits
    $display_limit = zen_get_new_date_range();
    $show_this = $db->Execute("SELECT p.products_id FROM " . TABLE_PRODUCTS . " p WHERE p.products_status = 1 " . $display_limit . " LIMIT 1");
    if (!$show_this->EOF) { 
?>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo zen_href_link(FILENAME_PRODUCTS_NEW); ?>"><?php echo CATEGORIES_BOX_HEADING_WHATS_NEW; ?></a>
<?php
    }
}

if (SHOW_CATEGORIES_BOX_FEATURED_PRODUCTS === 'true') {
    $show_this = $db->Execute("SELECT products_id FROM " . TABLE_FEATURED . " WHERE status = 1 LIMIT 1");
    if (!$show_this->EOF) {
?>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo zen_href_link(FILENAME_FEATURED_PRODUCTS); ?>"><?php echo CATEGORIES_BOX_HEADING_FEATURED_PRODUCTS; ?></a>
<?php
    }
}

if (SHOW_CATEGORIES_BOX_PRODUCTS_ALL === 'true') {
?>
        <div class="dropdown-divider"></div><a class="dropdown-item" href="<?php echo zen_href_link(FILENAME_PRODUCTS_ALL); ?>"><?php echo CATEGORIES_BOX_HEADING_PRODUCTS_ALL; ?></a>
<?php
}
?>
    </div>
</li>
<?php
// -----
// Check to see that the information sidebox is to be displayed.  If so, bring in the $information
// array from the 'standard' sidebox, with modifications to its class for the offcanvas menu's display.
//
$information_sidebox = $db->Execute(
    "SELECT *
       FROM " . TABLE_LAYOUT_BOXES . "
      WHERE layout_template = '$template_dir'
        AND layout_box_name = 'information.php'
        AND layout_box_status = 1
      LIMIT 1"
);
if (!$information_sidebox->EOF) {
    $information_box = DIR_WS_MODULES . zen_get_module_sidebox_directory('information.php'); 
    if (file_exists($information_box)) {
        $information_sidebox_class = 'dropdown-item';
        require $information_box;
        unset($information_sidebox_class);
        
        if (count($information) > 0) {
?>
<li class="nav-item dropdown d-lg-none">
    <a class="nav-link dropdown-toggle" href="#" id="infoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo BOX_HEADING_INFORMATION; ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="infoDropdown">
        <ul class="m-0 p-0">
<?php
            foreach ($information as $next_information_link) {
?>
            <li><?php echo $next_information_link; ?></li>
<?php
            }
?>
        </ul>
    </div>
</li>
<?php
        }
    }
}

// -----
// Check to see that the more_information sidebox is to be displayed.  If so, bring in the $more_information
// array from the 'standard' sidebox, with modifications to its class for the offcanvas menu's display.
//
$more_information_sidebox = $db->Execute(
    "SELECT *
       FROM " . TABLE_LAYOUT_BOXES . "
      WHERE layout_template = '$template_dir'
        AND layout_box_name = 'more_information.php'
        AND layout_box_status = 1
      LIMIT 1"
);
if (!$more_information_sidebox->EOF) {
    $more_information_box = DIR_WS_MODULES . zen_get_module_sidebox_directory('more_information.php'); 
    if (file_exists($more_information_box)) {
        $more_information_sidebox_class = 'dropdown-item';
        require $more_information_box;
        unset($more_information_sidebox_class);
        
        if (count($more_information) > 0) {
?>
<li class="nav-item dropdown d-lg-none">
    <a class="nav-link dropdown-toggle" href="#" id="moreInfoDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo BOX_HEADING_MORE_INFORMATION; ?>
    </a>
    <div class="dropdown-menu" aria-labelledby="moreInfoDropdown">
        <ul class="m-0 p-0">
<?php
            foreach ($more_information as $next_information_link) {
?>
            <li><?php echo $next_information_link; ?></li>
<?php
            }
?>
        </ul>
    </div>
</li>
<?php
        }
    }
}

// test if ez-pages links should display
if (EZPAGES_STATUS_SIDEBOX === '1' || (EZPAGES_STATUS_SIDEBOX === '2' && zen_is_whitelisted_admin_ip())) {
    if (isset($var_linksList)) {
        unset($var_linksList);
    }

    $page_query = $db->Execute(
        "SELECT e.*, ec.*
           FROM " . TABLE_EZPAGES . " e
                INNER JOIN " . TABLE_EZPAGES_CONTENT . " ec
                    ON ec.pages_id = e.pages_id
                   AND ec.languages_id = " . (int)$_SESSION['languages_id'] . "
          WHERE e.status_sidebox = 1
            AND e.sidebox_sort_order > 0
          ORDER BY e.sidebox_sort_order, ec.pages_title"
    );

    if (!$page_query->EOF) {
        $page_query_list_sidebox = [];
        foreach ($page_query as $next_page) {
            $next_page_entry = array(
                'name' => htmlspecialchars($next_page['pages_title'], ENT_COMPAT, CHARSET, true),
            );
            
            switch (true) {
                // external link new window or same window
                case ($next_page['alt_url_external'] !== ''):
                    $offcanvasAltURL = $next_page['alt_url_external'];
                    break;

                // internal link new window or same window
                case ($next_page['alt_url'] != ''):
                    if (strpos($next_page['alt_url'], 'http') === 0) {
                        $offcanvasAltURL = $next_page['alt_url'];
                    } else {
                        $offcanvasAltURL =  zen_href_link($next_page['alt_url'], '', 'SSL', true, true, true);
                    }
                    break;

                default:
                    $offcanvasAltURL = '';
                    break;
            }

            // if altURL is specified, use it; otherwise, use EZPage ID to create link
            if ($offcanvasAltURL === '') {
                $toc_chapter = ($next_page['toc_chapter'] > 0) ? ('&chapter=' . $next_page['toc_chapter']) : '';
                $next_page_entry['link'] = zen_href_link(FILENAME_EZPAGES, 'id=' . $next_page['pages_id'] . $toc_chapter, 'SSL');
            } else {
                $next_page_entry['link'] = $offcanvasAltURL;
            }

            // -----
            // NOTE: The trailing double-quote is INTENTIONALLY not provided since that will be provided when the anchor-link is
            // generated in the loop below!
            //
            $next_page_entry['link'] .= ($next_page['page_open_new_window'] === '1') ? '" target="_blank" rel="noopener' : '';
            
            $page_query_list_sidebox[] = $next_page_entry;
        }
    }
    if (!empty($page_query_list_sidebox)) {
?>
<li class="nav-item dropdown d-lg-none">
    <a class="nav-link dropdown-toggle" href="#" id="ezpagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <?php echo BOX_HEADING_EZPAGES; ?>
    </a>
    <div class="dropdown-menu mb-2" aria-labelledby="ezpagesDropdown">
        <ul class="m-0 p-0">
<?php
        foreach ($page_query_list_sidebox as $next_entry) {
?>
            <li><a class="dropdown-item" href="<?php echo $next_entry['link']; ?>"><?php echo $next_entry['name']; ?></a></li>
<?php
        } // end FOR loop
?>
        </ul>
    </div>
</li>  
<?php
    }
} // eof ezpages
