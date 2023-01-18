(function($) {
    'use strict';


    /*************************
     * 
     * Image preview
     * 
     **************************/

    $(document).on('change', '#listing-image', function(event){

        const size = 
            (this.files[0].size / 1024 / 1024).toFixed(2);
        
        if (size > 1 ) {
            alert("File must be less than 1 MB");
            $(this).val("");
        } else {
            var reader = new FileReader();
            reader.onload = function(){
              var output = document.getElementById('listing-image-preview');
              output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    })

    $(document).on('click', '#listing-submit', function(){

        let that = $(this);
        
        let title = $("#listing-title").val();
        let content = tinymce.get( $("#listing-content").attr( 'id' ) ).getContent( { format: 'text' } );

        if( title == '' || $('#listing-image').get(0).files.length === 0){
            $('.directia-field-required').text(directia.field_required);
        } else {
            var fd = new FormData();
            fd.append( "listing_title", title );
            fd.append( "listing_content", content );
            fd.append( "listing_user", directia.user_id );
            fd.append( "listing_image", $('#listing-image')[0].files[0]);


            that.prop('disabled', true);
            that.val(directia.request_text);

            jQuery.ajax({
                type: 'POST',
                url: directia.site_url + '/directia-api/v1/create-listing',
                data: fd, 
                processData: false,
                contentType: false,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader( 'X-WP-Nonce', directia.nonce );
                },
                success: function(data, textStatus, XMLHttpRequest) {
                    console.log('res==>', data);

                    if(data.status == 'success'){
                        that.val(directia.button_text);
                        alert(data.msg);
                        window.location.reload();
                    } else {
                        that.val(directia.button_text);
                        that.prop('disabled', false);
                        $('.directia-field-required').text(data.msg);
                    }

                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    that.val(directia.button_text);
                    that.prop('disabled', false);
                    $('.directia-field-required').text(directia.error);
                }

            });
        }
    })

    /*************************
     * 
     * Login
     * 
     **************************/
    
    $(document).on('click', '#listing-login', function(){

        let that = $(this);

        let username = $("#listing-username").val();
        let password = $("#listing-password").val();
        if( username == '' || password == ''){
            $('.directia-field-required').text(directia.field_required);
        } else {
            that.prop('disabled', true);
            that.val(directia.request_text);

            let data = {
                username: username,
                password: password
            }

            jQuery.ajax({
                type: 'POST',
                url: directia.site_url + '/directia-api/v1/login',
                data: data,
                beforeSend: function(xhr) {
                    xhr.setRequestHeader( 'X-WP-Nonce', directia.nonce );
                },
                success: function(response, textStatus, XMLHttpRequest) {

                    if (response.errorMessage) {
                        alert(response.errorMessage);
                     } else if (!response.isLoggedIn) {
                        // Unknown error logging in.
                     } else {
                        // We've successfully logged-in.
                        // Reload the current page.
                        location.reload();
                     }

                },
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    that.val(directia.login_text);
                    that.prop('disabled', false);
                    $('.directia-field-required').text(directia.error);
                },
                

            });
        }
    });


})(jQuery);