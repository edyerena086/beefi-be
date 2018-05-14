$(document).ready(function () {

    //Password strength
    $('#frmPassword').strength();

    //Form submit
    $('form').on('submit', function (e) {

        e.preventDefault();

        $.ajax({
            type : 'post',
            data : $(this).serialize(),
            url : $(this).attr('action'),
            dataType : 'json',
            beforeSend : function () {
                blockForm();
            },
            error : function (jgXHR) {
                unblockForm();

                if (jgXHR.status == 422)
                {

                    modalErrors(JSON.parse(jgXHR.responseText));
                }
                else
                {
                    modalMessage('Experimentamos fallas técnicas, intentelo más tarde.');
                }
            },
            success : function (response) {

                unblockForm();

                if (response.error == false && typeof response.action == 'undefined')
                {
                    $('form')[0].reset();
                }

                modalMessage(response.message);
            }
        });
    });

});
