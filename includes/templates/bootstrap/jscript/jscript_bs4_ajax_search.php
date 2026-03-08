<?php
// -----
// Part of the AJAX Search (for Bootstrap template) by lat9.
//
// BOOTSTRAP v3.7.9
//
if (defined('BS4_AJAX_SEARCH_ENABLE') && BS4_AJAX_SEARCH_ENABLE === 'true') {
    $script_name = (BS4_AJAX_SEARCH_USE_MINIMIZED_SCRIPT === 'true') ? 'ajax_search.min.js' : 'ajax_search.js';
    $script_file = $template->get_template_dir($script_name, DIR_WS_TEMPLATE, $current_page_base, 'jscript') . '/' . $script_name;
    $script_file .= '?' . filemtime($script_file);
?>
<script src="<?= $script_file ?>" defer></script>
<?php
}
