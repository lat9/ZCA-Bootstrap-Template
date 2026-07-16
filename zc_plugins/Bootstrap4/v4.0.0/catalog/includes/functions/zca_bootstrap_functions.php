<?php
/**
 * @author ZCAdditions.com, ZCA Bootstrap Template
 *
 * BOOTSTRAP v4.0.0
 *
 */
 
// -----
// This function returns a boolean value indicating whether (true) or not (false)
// a ZCA bootstrap encapsulated template is the currently-active template. The definition
// is present in an encapsulated template's manifest.php.
//
function is_bootstrap_template(): bool
{
    global $template_dir;

    $templateRecord = new \Zencart\ResourceLoaders\TemplateResolver()->getTemplateRecord($template_dir);
    return !empty($templateRecord['manifest']['template']['isBootstrap']);
}

function zca_js_zone_list(string $varname = 'c2z'): string
{
    global $db;

    $countries = $db->Execute(
        "SELECT DISTINCT zone_country_id
           FROM " . TABLE_ZONES . "
                INNER JOIN " . TABLE_COUNTRIES . "
                    ON countries_id = zone_country_id
                   AND status = 1
           ORDER BY zone_country_id"
    );

    $c2z = [];
    $use_zone_code = !empty($GLOBALS['zca_js_zone_list_use_zone_code']);
    foreach ($countries as $country) {
        $current_country_id = $country['zone_country_id'];
        $c2z[$current_country_id] = [];

        $states = $db->Execute(
            "SELECT zone_name, zone_id, zone_code
               FROM " . TABLE_ZONES . "
              WHERE zone_country_id = $current_country_id
           ORDER BY zone_name"
        );
        foreach ($states as $state) {
            $zone_key = ($use_zone_code === true) ? $state['zone_code'] : $state['zone_id'];
            $c2z[$current_country_id][$zone_key] = $state['zone_name'];
        }
    }

    if ($c2z === []) {
        $output_string = '';
    } else {
        $output_string = 'var ' . $varname . ' = \'' . addslashes(json_encode($c2z)) . '\';' . PHP_EOL;
    }
    return $output_string;
}

// -----
// Loads a language-file for the requested modal page.  Some of the "core" Zen Cart pop-up pages
// are replaced by modals for the Bootstrap template.
//
function zca_load_language_for_modal(string $modal_pagename): void
{
    global $languageLoader;

    $languageLoader->setCurrentPage($modal_pagename);
    $languageLoader->loadLanguageForView();
}

// -----
// Common function to get font-awesome version of the products' rating stars.
//
// $rating ... An integer value between 0 and 5.
// $size ..... A character string to identify the relative 'size' of the generated stars, one of the font-awesome size suffixes:
//             'xs', 'sm', 'lg', '2x', '3x', '5x', '7x' or '10x'.  Note that this value is unchecked!
//
function zca_get_rating_stars(int|string $rating, string $size = ''): string
{
    $rating = (int)$rating;
    $rating = ($rating < 0) ? 0 : $rating;
    $rating = ($rating > 5) ? 5 : $rating;
    
    $rating_stars = '<span class="sr-only">' . $rating . ' ' . (($rating === 1) ? ARIA_REVIEW_STAR : ARIA_REVIEW_STARS) . '</span>';
    $size = ($size != '') ? " fa-$size" : '';
    for ($i = 1; $i <= $rating; $i++) {
        $fa_class = ($i <= $rating) ? 'fas' : 'far';
        $rating_stars .= '<i class="' . $fa_class . ' fa-star' . $size . '"></i>';
    }
    return $rating_stars;
}

// -----
// A function to return the current month's translated name.
//
function zca_get_translated_month_name(): string
{
    global $zcDate;
    return $zcDate->output('%B');
}

// -----
// A function to return a button-styled anchor link, used in the majority of the
// templates.  Added in v3.5.0.
//
function zca_button_link(string $link, string $text, string $extra_classes = '', string $parameters = ''): string
{
    $extra_classes = ($extra_classes !== '') ? ' ' . trim($extra_classes) : '';
    $parameters = ($parameters !== '') ? ' ' . trim($parameters) : '';
    return '<a class="p-2 btn' . $extra_classes . '" href="' . $link . '"' . $parameters . '>' . $text . '</a>';
}

// -----
// A function to return a button-styled 'back-link', used in many of the
// templates.  Added in v3.5.0.
//
function zca_back_link(string $extra_classes = '', string $parameters = '', string $button_name = ''): string
{
    $extra_classes = ($extra_classes !== '') ? ' ' . trim($extra_classes) : '';
    $parameters = ($parameters !== '') ? ' ' . trim($parameters) : '';
    $button_name = ($button_name === '') ? BUTTON_BACK_ALT : $button_name;
    return '<a class="p-2 btn button_back' . $extra_classes . '" href="' . zen_back_link(true) . '"' . $parameters . '>' . $button_name . '</a>';
}
