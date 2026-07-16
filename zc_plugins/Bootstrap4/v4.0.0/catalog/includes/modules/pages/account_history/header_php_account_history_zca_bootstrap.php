<?php
// -----
// account_history: Use the template-specific splitPageResults formatting, if the ZCA Bootstrap template is installed and active.
//
// Last updated: Bootstrap 4.0.0
//
if ($accountHasHistory && function_exists('is_bootstrap_template') && is_bootstrap_template()) {
    // -----
    // Retrieve the paginated SQL query from the 'base' split-page collection, stripping off the
    // trailing 'LIMIT ' clause and submit that to the Bootstrap template's split-pages class
    // for proper pagination display.
    //
    $history_query = $history_split->getSqlQuery();
    $history_query = substr($history_query, 0, strripos($history_query, ' limit'));
    $history_split = new zca_splitPageResults($history_query, $tplSetting->MAX_DISPLAY_ORDER_HISTORY);
}
