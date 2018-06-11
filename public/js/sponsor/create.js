$(document).ready(function () {
    $('#atributos').hide();
                $('#empresas').hide();


    $('select[name=tipo]').change(function () {
        switch($(this).val()) {
            case '1':
                console.log('Entro a 1');
                $('#atributos').show();
                $('#empresas').hide();
            break;

            case '2':
                $('#atributos').hide();
                $('#empresas').show();
            break;

            case '0':
                $('#atributos').hide();
                $('#empresas').hide();
            break;
        }
    });

	$('form').on('submit', function (e) {
		e.preventDefault();

		var data = new FormData();

        $('form').find(':input').not('#imagen').not('input[type=checkbox]').each(function () {

            if ($.trim($(this).val()).length > 0) {
                //console.log($(this).attr('name') + "=" + $(this).val());

                data.append($(this).attr('name'), $(this).val());
            }
        });

        //Get all the ctegories
        $('#lblCat input[type=checkbox]').each(function () {
            if ($(this).is(':checked')) {
                console.log('este tiene valor');
                data.append('categoria[]', $(this).val());
            }
        });

        //Get all the companies
        $('#lblCompa input[type=checkbox]').each(function () {
            if ($(this).is(':checked')) {
                console.log($(this).val());
                data.append('compania[]', $(this).val());
            }
        });

        if ($('#imagen').get(0).files.length == 0) {
            console.log('No tiene archivos');
        } else {
            data.append('imagen', $('#imagen')[0].files[0]);
        }

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
                    modalMessage('Se ha guardado con éxito el sponsor');

                    $('form')[0].reset();

                    //console.log(response.external);
                } else {
                    modalMessage('No se ha podido guardar el sponsor');
                }
            }
        });
	});
});