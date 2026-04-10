/**
 * BOOTSTRAP 3.7.10 (new)
 *
 * This script adds an icon to any password-related fields, enabling
 * the customer to view/hide the password entry.
 */
$(document).ready(function() {
    // -----
    // For each 'password' type input on the page ...
    //
    $('input[type="password"]').each(function() {
        // -----
        // ... that has an 'id=' attribute ...
        //
        let password_id = $(this).attr('id');
        if (!password_id) {
            return false;
        }
        $(this).after('<span toggle="#'+password_id+'" class="fa-solid fa-eye toggle-pw" style="float: right;margin-right:.5rem;margin-top:-1.8rem;position:relative;z-index:2;"></span>');
    });

    $('.toggle-pw').click(function() {
        $(this).toggleClass('fa-eye fa-eye-slash');
        let input = $($(this).attr('toggle'));
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
        } else {
            input.attr('type', 'password');
        }
    });
});
