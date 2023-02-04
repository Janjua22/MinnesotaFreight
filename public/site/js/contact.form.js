/**
*
* -----------------------------------------------------------------------------
*
* Template : Reobiz - Consulting Business HTML Template
* Author : rs-theme
* Author URI : http://www.rstheme.com/
*
* -----------------------------------------------------------------------------
*
**/

(function($) {
    'use strict';
    // Get the form.
    var form = $('#contact-form');

    // Get the messages div.
    var formMessages = $('#form-messages');

    // Set up an event listener for the contact form.
    $(form).submit(function(e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        // Serialize the form data.
        var formData = $(form).serialize();

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })
        .done(function(response) {
            // Make sure that the formMessages div has the 'success' class.
            $(formMessages).removeClass('text-danger');
            $(formMessages).addClass('text-success');

            // Set the message text.
            $(formMessages).text(response.msg);

            // Clear the form.
            $('#name, #email, #phone, #website, #message').val('');
        })
        .fail(function(data) {
            // Make sure that the formMessages div has the 'error' class.
            $(formMessages).removeClass('text-success');
            $(formMessages).addClass('text-danger');

            // Set the message text.
            if (data.responseText !== '') {
                let msgHtml = `<p>${data.responseJSON.message}</p><ul>`;
    
                let obj =  data.responseJSON.errors;

                for (var i in obj) {
                    if (obj.hasOwnProperty(i)) {
                        msgHtml += `<li>${obj[i]}</li>`;
                    }
                }

                msgHtml += `</ul>`;
                
                $(formMessages).html(msgHtml);
            } else {
                $(formMessages).text('Oops! An error occured and your message could not be sent.');
            }
        });
    });
})(jQuery);