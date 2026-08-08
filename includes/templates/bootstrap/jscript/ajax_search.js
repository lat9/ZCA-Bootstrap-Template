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
    // When a 'keyup' (devices with keyboards) or 'touchend' (those without) condition 
    // is seen on the search-input, gather the current keywords, submit them to the 
    // AJAX handler and display the returned HTML in the search-content section.
    //
    const MIN_KW_LENGTH = 3;
    const MAX_KW_LENGTH = 64;
    $('#search-input').on('keyup keydown touchend paste cut', function(e) {
        // -----
        // The source of the current keyword depends on the type of event being
        // handled.
        // - For the 'paste' event, the value is present in the clipboard.
        // - For the 'keydown' event, we're only watching for the 'Enter' key, which
        //   will redirect to the base 'search' page.
        // - Otherwise, the keyword is updated value in the form's input field.
        //
        if (e.type === 'paste') {
            var keyword = e.originalEvent.clipboardData.getData('text');
        } else {
            if (e.type === 'keydown' && e.key !== 'Enter') {
                 return;
            }
            var keyword = $('#search-input').val();
        }

        // -----
        // If the "Enter/Go" key is pressed, send the customer to the advanced-search-results
        // page with the current keywords.  Replacing Safari's "smart quotes" with 'vanilla' quotes
        // for matching.
        //
        keyword = keyword.replace(/”|“/g, '"');
        keyword = keyword.replace(/‘|’/g, "'");

//        console.log(e.type+': ('+keyword+'), '+e.key+', ('+$('#search-input').data('last-sent')+'), '+$('#search-input').data('in-progress'));

        // -----
        // Don't send if the minimum-keyword-length is not yet met, if the last keyword
        // sent matches the current keyword or if a request is currently in-progress.
        //
        // Note: The keyword value is trimmed prior to length-checking, mimicking the server-side processing.
        //
        keyword = keyword.trim();
        if (keyword.length < MIN_KW_LENGTH || $('#search-input').data('last-sent') === keyword || $('#search-input').data('in-progress') === 1) {
            return;
        }

        var separator = ($('#search-page').val().indexOf('?') == -1) ? '?' : '&';
        var searchLink = $('#search-page').val()+separator+'keyword='+keyword;

        // -----
        // If the keywords' length is more than the maximum or if the Enter key is pressed,
        // force a submission to the non-AJAX search.
        //
        if (e.key === 'Enter' || keyword.length > MAX_KW_LENGTH) {
            e.preventDefault();
            $('#search-wrapper').modal('dispose');
            window.location.replace(searchLink);
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
            $('#search-content .sugg-button').attr('href', searchLink);
        });
    });
});
