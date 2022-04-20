 $(document).ready(function() {
        $('#preview-image-before-upload').hide();
        $('#image').on('change', function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                $('#preview-image-before-upload').show();
                $('#preview').attr('src', e.target.result);;
            }
            reader.readAsDataURL(this.files[0]);
        });

    });