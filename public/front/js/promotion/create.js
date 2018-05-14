var bwallet = 1;
var wichForm = "original";

$(document).ready(function () {
	$( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

	$('.add-bwallet').on('click', function (e) {
		e.preventDefault();

		var state = $(this).attr('data-state');

		if (state == "false") {
			$(this).html('-');
			bwallet = 2;
			$('.btn-bwallet-wrapper').html('<a href="" class="btn btn-warning mtk-yellow-button-two">Agregar a BWallet</a><br/>');
			$(this).attr('data-state', 'true');
		} else {
			$(this).html('+');
			bwallet = 1;
			$('.btn-bwallet-wrapper').html('');
			$(this).attr('data-state', 'false');
		}
	});


	$('.lnkSubmit').on('click', function (e) {
		e.preventDefault();

		wichForm = "send";

		$('form').submit();
	});

	$('form').on('submit', function (e) {
		e.preventDefault();

		var data = new FormData();

        $('form').find(':input').not('#icono').each(function () {

        	//console.log("Ebtro aqui");

            if ($.trim($(this).val()).length > 0) {
                //console.log($(this).attr('name') + "=" + $(this).val());

                data.append($(this).attr('name'), $(this).val());
            }
        });

        //For development
        //data.append('url', 'http://metodika.com.mx');
        data.append('bwallet', bwallet);

        if ($('#icono').get(0).files.length == 0) {
	            console.log('No tiene archivos');
	    } else {
	        data.append('icono', $('#icono')[0].files[0]);
	    }

	        for (var pair of data.entries()) {
	            console.log(pair[0]+ '= ' + pair[1]);
	        }

	        var route = (wichForm == 'original') ? 'store' : 'send-push';
	        route = $('form').attr('action') + "/" + route;

	        console.log(route);

	        
	        $.ajax({
	            type: 'post',
	            data: data,
	            //url: $('form').attr('action') + '/' + route,
	            url: route,
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
	                    modalMessage(response.message);

	                    $('form')[0].reset();

	                    //console.log(response.external);
	                } else {
	                    modalMessage(response.message);
	                }
	            }
	        });
	        
	});
});