  $(document).ready(function(){
        $('#product-image').on('change', function(){
            const input = this;
            const preview = $('#image-preview');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e){
                    preview.attr('src', e.target.result);
                    preview.show();
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.attr('src', '#');
                preview.hide();
            }
        });
    });