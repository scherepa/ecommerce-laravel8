$(document).ready(function() {
    $(function() {
    // Multiple images preview
    var imagesPreview = function(input, placeToInsertImagePreview, multiStatus = false) {
        if (input.files) {
           // count files
            var filesAmount = input.files.length;
            for (i = 0; i < filesAmount; i++) {
                console.log(/(\.|\/)(gif|jpe?g|png|webp)$/i.test(input.files[i].type));
                var reader = new FileReader();
                reader.onload = function(event) {
                    //if it's only one image and not multiple input then empty and replace
                    if(!multiStatus) { $(placeToInsertImagePreview).empty();}
                    $($.parseHTML('<img>')).attr('src', event.target.result).css('opacity','0').addClass('h-20 object-contain rounded').appendTo(placeToInsertImagePreview).animate({opacity:1}, 2000);    
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }; 

    $('#image').on('change', function() {
        //if supported...
        if(window.File && window.FileList && window.FileReader && window.Blob){
            imagesPreview(this, '#showImageHere', true);
        }
    });
    $('#thumbnail').on('change', function() {
        //if supported...
        if(window.File && window.FileList && window.FileReader && window.Blob){
            imagesPreview(this, '#preview');
        }
    });
});//end of function
});//end of document ready
