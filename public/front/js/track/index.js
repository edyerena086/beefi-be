$(document).ready(function () {
	setInterval(function () {
		console.log('heartbeat');

		var params = 'empresa=' + $('#track').attr('data-name');
		var route = $('#track').attr('data-url');

		$.ajax({
			'type': 'post',
			'data': params,
			'dataType': 'json',
			'url': route,
			success: function(response) {
				if (response.status == true) {
					$('#woman').html(response.data['woman']);
					$('#man').html(response.data['man']);
					$('#total').html(response.data['total']);
				}
			}
		});
	}, 300000);
});