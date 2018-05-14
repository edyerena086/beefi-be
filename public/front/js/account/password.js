$(document).ready(function () {
	$('form').on('submit', function (e) {
		e.preventDefault();

		$.ajax({
	            type: 'post',
	            data: $('form').serialize(),
	            url: $('form').attr('action'),
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