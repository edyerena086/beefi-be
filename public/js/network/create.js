$(document).ready(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();

		var data = new FormData();

        $('form').find(':input').not('#logo').not('#logoBlanco').each(function () {

            if ($.trim($(this).val()).length > 0) {
                //console.log($(this).attr('name') + "=" + $(this).val());

                data.append($(this).attr('name'), $(this).val());
            }
        });

        $.ajax({
            type: 'post',
            data: data,
            url: $(this).attr('action'),
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
                blockForm();
            },
            error: function (jgXHR) {
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
            success: function (response) {
                unblockForm();

                //console.log('Haz llegado cabron');

                if (response.status == true) {
                    modalMessage('Se ha guardado con éxito la contraseña');

                    $('form')[0].reset();

                    //console.log(response.external);
                } else {
                    modalMessage('No se ha podido guardar la contraseña');
                }
            }
        });
	});
});