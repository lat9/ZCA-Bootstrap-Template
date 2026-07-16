<?php
/**
 * Side Box Template: Searchbox for column header
 *
 * BOOTSTRAP v3.7.0
 *
 * @copyright Copyright 2003-2020 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: DrByte 2020 May 16 Modified in v1.5.7 $
 */
$content =
    zen_draw_form('quick_find_header', zen_href_link(FILENAME_SEARCH_RESULT, '', $request_type, false), 'get', 'class="form-inline"') .
        zen_draw_hidden_field('main_page', FILENAME_SEARCH_RESULT) .
        zen_draw_hidden_field('search_in_description', '1') .
        zen_hide_session_id() .
        '<div class="input-group">' .
            zen_draw_input_field('keyword', '', 'placeholder="' . HEADER_SEARCH_DEFAULT_TEXT . '" aria-label="' . HEADER_SEARCH_DEFAULT_TEXT . '" ') .
            '<div class="input-group-append">' .
                zen_image_submit(BUTTON_IMAGE_SEARCH, HEADER_SEARCH_BUTTON) .
            '</div>' .
        '</div>' .
    '</form>';
