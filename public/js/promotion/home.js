$(document).ready(function () {
    $('.btn-delete').on('click', function (e) {
        e.preventDefault();

        var myRoute = $(this).attr('href');

        bootbox.confirm('¿Deseas eliminar la promoción ' + $(this).attr('data-name') + '?', function (result) {

            console.log(result);

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

                        if (response.status == true)
                        {
                            window.location.reload();
                        }

                    }
                });
            }

        });
    });
});