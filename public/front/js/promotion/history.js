$(document).ready(function () {
	$('.mtk-cupon-item-list').on('click', function () {
		window.location = $(this).attr('data-url');
	});

	$('.mtk-red-button-two').on('click', function (e) {
		e.preventDefault();

		var myRoute = $(this).attr('href');

        bootbox.confirm('¿Deseas eliminar el cupón ' + $(this).attr('data-name') + "?", function (result) {

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