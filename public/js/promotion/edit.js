$(document).ready(function () {

    $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

    //Form

    $('form').on('submit', function (e) {

        e.preventDefault();

        var data = new FormData();

        $('form').find(':input').not('#archivo').each(function () {

            if ($.trim($(this).val()).length > 0) {
                //console.log($(this).attr('name') + "=" + $(this).val());

                data.append($(this).attr('name'), $(this).val());
            }
        });

        if ($('#archivo').get(0).files.length == 0) {
            console.log('No tiene archivos');
        } else {
            data.append('archivo', $('#archivo')[0].files[0]);
        }

        for (var pair of data.entries()) {
            console.log(pair[0]+ '= ' + pair[1]);
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

                if (response.status == true) {
                    modalMessage('Se ha actualizado con éxito la promoción');

                    //$('form')[0].reset();
                } else {
                    modalMessage('No se ha podido crear la promoción');
                }
            }
        });


    });

});