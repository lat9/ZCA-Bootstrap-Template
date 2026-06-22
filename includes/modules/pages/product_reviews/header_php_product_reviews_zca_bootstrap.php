<?php
// -----
// product_reviews: Slight modification of the formatting of the 'products_model' and use of the template-specific
// splitPageResults formatting, if the ZCA Bootstrap template is installed and active.
//
// BOOTSTRAP v3.8.0
//
if (function_exists('zca_bootstrap_active') && zca_bootstrap_active()) {
    if ($review->fields['products_model'] != '') {
        $products_model = $review->fields['products_model'];
    } else {
        $products_model = '';
    }
    
    unset($reviews_split, $reviews, $reviewsArray);
    $reviews_split = new zca_splitPageResults($reviews_query_raw, $tplSetting->MAX_DISPLAY_NEW_REVIEWS);
    $reviews = $db->Execute($reviews_split->sql_query);
    $reviewsArray = [];
    foreach ($reviews as $next_review) {
        $reviewsArray[] = [
            'id' => $next_review['reviews_id'],
            'customersName' => $next_review['customers_name'],
            'dateAdded' => $next_review['date_added'],
            'reviewsText' => $next_review['reviews_text'],
            'reviewsRating' => $next_review['reviews_rating']
        ];
    }
}
