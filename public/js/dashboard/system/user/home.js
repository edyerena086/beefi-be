$(document).ready(function () {

    $('#myTable').dataTable({
        "language" : datatTableSpanish
    });


    $('.btn-delete').on('click', function (e) {
        e.preventDefault();

        var myRoute = $(this).attr('href');

        bootbox.confirm('¿Deseas eliminar al usuario ' + $(this).attr('data-name'), function (result) {

            if (result == true)
            {
                $.ajax({
                    type : 'get',
                    url : myRoute,
                    dataType : 'json',
                    beforeSend : function () {
                        blockForm();
                    },
                    error : function () {
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

                        modalMessage(response.message);

                        if (response.error == false)
                        {
                            window.location.reload();
                        }

                    }
                });
            }

        });
    });

});