  $(document).ready(function() {
        $('#photo').on('change', function() {
            $("#del_photo").prop("checked", false);
            $("#uncheck_wrap").hide();
            $("#btn_check").show();

        });
        $("#btn_check").click(function() {
            /* remove file from form */
            $('#photo').val('');
            /* sign checkbox */
            $("#del_photo").prop("checked", true);
            $("#btn_check").hide();
            $("#uncheck_wrap").show();
            /* if there is a photo chosen before for upload preview remove arrow and preview */
            $('#arrow').empty();
            $('#preview-image-before-upload').hide();
        });

        $("#btn_uncheck").click(function() {
            $("#del_photo").prop("checked", false);
            $("#uncheck_wrap").hide();
            $("#btn_check").show();

        });
    });