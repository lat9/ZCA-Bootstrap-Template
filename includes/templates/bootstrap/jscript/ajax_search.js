// -----
// AJAX search for the Zen Cart Bootstrap template.
//
// BOOTSTRAP v3.8.1
//
$(function() {
    // -----
    // When a search-icon is clicked, display the search form.
    //
    $('#search-icon, #mobile-search').on('click', function() {
        $('#search-wrapper').modal();
    });

    $('#search-wrapper').on('shown.bs.modal', function() {
        $('#search-input').focus();
        $('#search-input').trigger('focus');
    });

    // -----
    // Initialize the previous keyword value sent.
    //
    $('#search-input').data('last-sent', $('#search-input').val());
    $('#search-input').data('in-progress', 0);

    // -----
    // When a cut or paste action is performed in the search-keywords, clear
    // out the resultant matches, noting that this event will be followed by an
    // input-event where the cut/paste result is available.
    //
    $('#search-input').on('cut paste', function(e) {
        $('#search-input').data('last-sent', '');
        $('#search-content').html('');
    });

    // -----
    // A common function to retrieve the main-page search link.
    //
    function getSearchPageLink(keyword)
    {
        var separator = ($('#search-page').val().indexOf('?') == -1) ? '?' : '&';
        return $('#search-page').val() + separator + 'keyword=' + encodeURIComponent(keyword);
    }

    // -----
    // A common function to retrieve the current search keyword. Safari's "smart quotes" are replaced
    // with 'vanilla' quotes for matching and then trimmed of starting/ending whitespace.
    //
    function getKeyword()
    {
        return $('#search-input').val().replace(/”|“/g, '"').replace(/‘|’/g, "'").trim();
    }

    // -----
    // If the 'Enter' key is pressed, redirect to the non-AJAX search page with
    // the current keywords.
    //
    $('#search-input').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            $('#search-wrapper').modal('dispose');
            window.location.replace(getSearchPageLink(getKeyword()));
            return;
        }
    });

    // -----
    // A 'generic' debounce function.
    //
    function debounce(func, delay)
    {
        let timeoutId;

        return function (...args) {
            // Clear the previous timer to reset the delay window
            clearTimeout(timeoutId);

            // Start a fresh timer for the current keystroke
            timeoutId = setTimeout(() => {
                func.apply(this, args);
            }, delay);
        };
    }

    // -----
    // The actual search processing, debounced by event listener.
    //
    const MIN_KW_LENGTH = 3;
    const MAX_KW_LENGTH = 64;
    function doSearch(e)
    {
        var keyword = getKeyword();

        // -----
        // Don't send if the minimum-keyword-length is not yet met, if the last keyword
        // sent matches the current keyword or if a request is currently in-progress.
        //
        if (keyword.length < MIN_KW_LENGTH || $('#search-input').data('last-sent') === keyword || $('#search-input').data('in-progress') === 1) {
            return;
        }

        // -----
        // If the keywords' length is more than the maximum, force a submission
        // to the non-AJAX search.
        //
        if (keyword.length > MAX_KW_LENGTH) {
            e.preventDefault();
            $('#search-wrapper').modal('dispose');
            window.location.replace(getSearchPageLink(keyword));
            return;
        }

        $('#search-input').data('last-sent', keyword);
        $('#search-input').data('in-progress', 1);
        zcJS.ajax({
            url: 'ajax.php?act=ajaxBootstrapSearch&method=searchProducts',
            data: {
                keywords: keyword
            },
            cache: false,
            headers: { 'cache-control': 'no-cache' },
            error: function (jqXHR, textStatus, errorThrown) {
                $('#search-input').data('in-progress', 0);
            },
        }).done(function(response) {
            $('#search-input').data('in-progress', 0);
            $('#search-content').html(response.searchHtml);
            $('#search-content .sugg-button').attr('href', getSearchPageLink(keyword));
        });
    }

    // -----
    // Add a 500ms delay for each request.
    //
    const doDebouncedSearch = debounce(doSearch, 500);

    // -----
    // When the search-input field has been manipulated in some way ...
    //
    $('#search-input').on('input', function(e) {
        doDebouncedSearch(e);
    });
});
