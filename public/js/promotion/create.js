$(document).ready(function () {

    //alert('Hola');

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

                console.log('Haz llegado cabron');

                if (response.status == true) {
                    modalMessage('Se ha guardado con éxito la promoción. El ID de la promoción es: ' + response.external);

                    $('form')[0].reset();

                    console.log(response.external);
                } else {
                    modalMessage('No se ha podido crear la promoción');
                }
            }
        });


    });

    /**

    $('form').on('submit', function (e) {
        e.preventDefault();

        var myData = $('form').find(":input").not('#archivo').filter(function () {
            return $.trim(this.value).length > 0
        }).serialize();

        console.log(myData);

        $.ajax({
            type : 'post',
            data : myData,
            url : $(this).attr('action'),
            dataType: 'json',
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
                    modalMessage('Se ha guardado con éxito la promoción. El ID de la promoción es: ' + response.external);

                    $('form')[0].reset();
                } else {
                    modalMessage('No se ha podido crear la promoción');
                }
            }
        });
    }); **/


    /**

    $('form').on('submit', function (e) {
        e.preventDefault();

        var myData = $('form').find(":input").not('#archivo').filter(function () {
            return $.trim(this.value).length > 0
        }).serialize();

        //console.log(myData);

        var data = myData;



        if ($('#archivo').get(0).files.length == 0) {
            data = myData;


        } else {
            data = new FormData();

            $('form').find(":input").not('#archivo').each(function () {

                if ($.trim($(this).val()).length > 0) {
                    data.append($(this).attr('name'), $(this).val());
                }
            });

            data.append('_token', $('input[name=_token]').val());

            data.append( 'archivo', $( '#archivo' )[0].files[0] );
        }

        console.log(data);


        $.ajax({
            type : 'post',
            data : data,
            url : $(this).attr('action'),
            contentType: false,       // The content type used when sending data to the server.
            cache: false,             // To unable request pages to be cached
            processData:false,
            dataType: 'json',
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
                    modalMessage('Se ha guardado con éxito la promoción. El ID de la promoción es: ' + response.external);
                } else {
                    modalMessage('No se ha podido crear la promoción');
                }
            }
        });

    });

     **/
});
