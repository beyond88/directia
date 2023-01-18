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
        
        let title = $("#").val();
        let content = $("#listing-content").val();

        if( title == '' || content == '' || $('#listing-image').get(0).files.length === 0){
            $('#directia-field-required').html(directia.field_required);;
        } else {
            var fd = new FormData();
            fd.append( "listing_title", title );
            fd.append( "listing_content", content );
            fd.append( "listing_image", $('#listing-image')[0].files[0]);

            jQuery.ajax({
                type: 'POST',
                url: apfajax.ajaxurl,
                data: fd, 
                processData: false,
                contentType: false,
                success: function(data, textStatus, XMLHttpRequest) {
                    var id = '#apf-response';
                    jQuery(id).html('');
                    jQuery(id).append(data);
                },
        
                error: function(MLHttpRequest, textStatus, errorThrown) {
                    alert(errorThrown);
                }

            });
        }

        console.log('hello')
    })

})(jQuery);