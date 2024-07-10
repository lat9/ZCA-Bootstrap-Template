<?php
// -----
// AJAX Search for the Zen Cart Bootstrap Template.
//
// Bootstrap v3.7.2
//
class zcAjaxBootstrapSearch extends base
{
    // -----
    // Create and return a formatted search-results collection.  On entry:
    //
    // $_POST['keywords'] ... The current search keywords
    //
    public function searchProducts()
    {
        global $db, $currencies, $template, $template_dir, $language_page_directory, $current_page_base, $current_page, $request_type, $zco_notifier;

        $search_html = '';

        // -----
        // First, check that the supplied keywords aren't empty (if so, there's nothing to be returned).
        //
        if (!empty($_POST['keywords']) && !empty(trim($_POST['keywords']))) {
            $keywords = trim($_POST['keywords']);
            if (zen_parse_search_string(stripslashes($keywords), $search_keywords)) {
                $from_clause =
                    '  FROM ' . TABLE_PRODUCTS . ' p
                            INNER JOIN ' . TABLE_PRODUCTS_DESCRIPTION . ' pd
                                ON pd.products_id = p.products_id
                               AND pd.language_id = ' . (int)$_SESSION['languages_id'];

                $where_clause =
                    ' WHERE p.products_status = 1 ';
                $search_fields = [
                    'pd.products_name',
                    'p.products_model',
                ];
                if (defined('BS4_AJAX_SEARCH_INC_DESC') && BS4_AJAX_SEARCH_INC_DESC === 'true') {
                    $search_fields[] = 'pd.products_description';
                }
                if (function_exists('zen_build_keyword_where_clause')) {
                    $where_clause .= zen_build_keyword_where_clause($search_fields, $keywords);
                } else {
                    $where_clause .= 'AND (' . $this->buildWhereClause($search_keywords) . ' )';
                }

                $select_clause = 'SELECT DISTINCT p.products_image, p.products_id, p.products_sort_order, pd.products_name, p.master_categories_id, p.products_model';
                $order_by_clause = ' ORDER BY p.products_sort_order, pd.products_name';
                $limit_clause = ' LIMIT ' . (int)BS4_AJAX_SEARCH_RESULTS_PER_PAGE;

                // -----
                // Give a watching observer the opportunity to modify any of the query's clauses.
                //
                $this->notify('NOTIFY_AJAX_BOOTSTRAP_SEARCH_CLAUSES', $search_keywords, $select_clause, $from_clause, $where_clause, $order_by_clause, $limit_clause);

                $results = $db->Execute("SELECT COUNT(*) AS count FROM ($select_clause $from_clause $where_clause) AS items");
                $search_results_count = (int)$results->fields['count'];
                if ($search_results_count !== 0) {
                    $results = $db->Execute($select_clause . $from_clause . $where_clause . $order_by_clause . $limit_clause);
                    $products_search = [];
                    foreach ($results as $next_item) {
                        $products_id = $next_item['products_id'];
                        $next_search_result = [
                            'image' => zen_image(DIR_WS_IMAGES . $next_item['products_image'], $next_item['products_name'], (int)BS4_AJAX_SEARCH_IMAGE_WIDTH, (int)BS4_AJAX_SEARCH_IMAGE_HEIGHT),
                            'name' => $next_item['products_name'],
                            'model' => $next_item['products_model'],
                            'products_id' => $products_id,
                            'brand' => zen_get_products_manufacturers_name($products_id),
                            'price' => zen_get_products_display_price($products_id),
                            'link' => zen_href_link(zen_get_info_page($products_id), 'cPath=' . zen_get_generated_category_path_rev($next_item['master_categories_id']) . '&products_id=' . $products_id),
                        ];

                        // -----
                        // Give a watching observer the opportunity to add fields to the current
                        // search result.
                        //
                        $this->notify('NOTIFY_AJAX_BOOTSTRAP_SEARCH_NEXT_RESULT', $next_item, $next_search_result);

                        $products_search[] = $next_search_result;
                    }

                    // get html
                    ob_start();
                    require $template->get_template_dir('tpl_ajax_search_results.php', DIR_WS_TEMPLATE, FILENAME_DEFAULT, 'templates') . '/tpl_ajax_search_results.php';
                    $search_html = ob_get_contents();
                    ob_end_clean();
                }
            }
        }

        // -----
        // Return the HTML to be displayed in the search-results element.
        //
        return [
            'searchHtml' => $search_html,
        ];
    }

    protected function buildWhereClause($search_keywords)
    {
        global $db;

        $where_clause = '';
        foreach ($search_keywords as $current_keyword) {
            switch ($current_keyword) {
                case '(':
                case ')':
                    break;

                case 'and':
                case 'or':
                    $where_clause .= " $current_keyword ";
                    break;

                default:
                    $where_clause .= $db->bindVars(
                        "(pd.products_name LIKE '%:keywords%' OR pd.products_description LIKE '%:keywords%' OR p.products_model LIKE '%:keywords%')",
                        ':keywords',
                        $current_keyword,
                        'noquotestring'
                    );
                    break;
            }
        }
        return $where_clause;
    }
}
