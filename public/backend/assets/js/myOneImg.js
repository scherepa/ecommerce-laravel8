
$(document).ready(function() {
    
    $('#preview-image-before-upload').hide();
    $('#photo').on('change', function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#arrow').empty().append("<i class='text-3xl text-gray-200 fa fa-long-arrow-right' aria-hidden='true'></i>");
            $('#preview-image-before-upload').show();
            $("#box").css("background-image", "url(" + e.target.result + ")");
        }
        reader.readAsDataURL(this.files[0]);
    });
    
});
