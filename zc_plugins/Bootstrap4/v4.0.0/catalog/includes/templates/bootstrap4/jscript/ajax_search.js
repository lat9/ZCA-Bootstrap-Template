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
    $('#search-input').on('cut paste', function() {
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
    // A 'generic' debounce function.  The function returned carries an additional 'cancel'
    // method, enabling a pending (but not-yet-issued) call to be discarded.
    //
    function debounce(func, delay)
    {
        let timeoutId;

        function debounced(...args) {
            // Retain the calling context, so that the deferred call is made with the same
            // 'this' as the original.
            const context = this;

            // Clear the previous timer to reset the delay window
            clearTimeout(timeoutId);

            // Start a fresh timer for the current keystroke
            timeoutId = setTimeout(function () {
                func.apply(context, args);
            }, delay);
        }

        debounced.cancel = function () {
            clearTimeout(timeoutId);
        };

        return debounced;
    }

    // -----
    // The actual search processing, debounced by the input-event listener below.
    //
    // Note: This function takes no arguments; it's invoked from the debounce timer, i.e. after
    // the triggering event has finished dispatching, so no event object is available (nor useful)
    // here.  That also allows it to be re-issued from the request-completion handler below.
    //
    const MIN_KW_LENGTH = 3;
    const MAX_KW_LENGTH = 64;
    function doSearch()
    {
        var keyword = getKeyword();

        // -----
        // If the keyword's length is outside the range that's submitted to the AJAX handler,
        // don't issue a request and clear any previously-displayed matches, so that results
        // for an earlier keyword aren't left on display.  This covers, for example, the
        // customer backspacing from 'ked' to 'ke'; the matches for 'ked' are no longer
        // applicable to what's been entered.
        //
        // The last-sent value is reset at the same time so that returning to a submittable
        // length re-issues the search, even if the keyword is one that's been sent before.
        //
        // Note that no automatic redirect is performed for an over-length keyword, since that
        // would navigate away from the page without the customer having asked.  Pressing
        // 'Enter' still runs the full, non-AJAX search on whatever has been entered.
        //
        if (keyword.length < MIN_KW_LENGTH || keyword.length > MAX_KW_LENGTH) {
            $('#search-input').data('last-sent', '');
            $('#search-content').html('');
            return;
        }

        // -----
        // Don't send if the last keyword sent matches the current keyword or if a request is
        // currently in-progress.  In that last case, the request's completion handler (below)
        // re-issues the search if the keyword has changed in the interim.
        //
        if ($('#search-input').data('last-sent') === keyword || $('#search-input').data('in-progress') === 1) {
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
                searchRequestFinished();
            },
        }).done(function(response) {
            searchRequestFinished();

            // -----
            // If the keyword has changed while this request was in-flight, its results are no
            // longer applicable to what's currently entered; don't display them.  Either the
            // completion handler above has just re-issued the search for the current keyword,
            // or the keyword is no longer of a submittable length and the matches have already
            // been cleared.
            //
            if (keyword !== getKeyword()) {
                return;
            }

            $('#search-content').html(response.searchHtml);
            $('#search-content .sugg-button').attr('href', getSearchPageLink(keyword));
        });
    }

    // -----
    // Called when a search request has finished, whether successfully or not.
    //
    // Any keystrokes made while that request was in-flight were disregarded by the
    // 'in-progress' check above.  If the keyword currently entered no longer matches the one
    // just requested, re-issue the search so that the display catches up with what the
    // customer has actually typed.
    //
    function searchRequestFinished()
    {
        $('#search-input').data('in-progress', 0);
        if (getKeyword() !== $('#search-input').data('last-sent')) {
            doDebouncedSearch();
        }
    }

    // -----
    // Add a 500ms delay for each request.
    //
    const doDebouncedSearch = debounce(doSearch, 500);

    // -----
    // If the 'Enter' key is pressed, discard any pending (debounced) search request — its
    // results could never be displayed — and redirect to the non-AJAX search page with the
    // current keywords.
    //
    $('#search-input').on('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            doDebouncedSearch.cancel();
            $('#search-wrapper').modal('dispose');
            window.location.replace(getSearchPageLink(getKeyword()));
        }
    });

    // -----
    // When the search-input field has been manipulated in some way ...
    //
    $('#search-input').on('input', function() {
        doDebouncedSearch();
    });
});
