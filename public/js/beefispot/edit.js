var markers = [];

function initMap()
{
	var monterrey = new google.maps.LatLng(lat, lng);

	var map = new google.maps.Map(document.getElementById('map'), {
          center: monterrey,
          zoom: 17
        });

	placeMarker(monterrey, map);

	map.addListener('click', function(e) {
		console.log('My position: ' + e.latLng.lat());
		deleteMarkers();
		placeMarker(e.latLng, map);
		lat = e.latLng.lat();
		lng = e.latLng.lng();
	});
}

function placeMarker(position, map) {
	var marker = new google.maps.Marker({
		position: position,
		map: map
	});
	markers.push(marker);
	map.panTo(position);
}

function setMapOnAll(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function clearMarkers() {
        setMapOnAll(null);
      }

function deleteMarkers() {
  clearMarkers();
  markers = [];
}

$(document).ready(function () {
	$('form').on('submit', function (e) {

		e.preventDefault();
		console.log('He llegado');

		if (lat == null && lng == null) {
			alert('Debes seleccionar un punto en el mapa para Beefispot');
		} else {
			var data = $(this).serialize();

			data = data + "&latitud=" + lat;
			data = data + "&longitud=" + lng;

			$.ajax({
				type: 'post',
				data: data,
				url: $(this).attr('action'),
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
	                    modalMessage('Se ha actualizado con éxito el Beefispot');

	                    $('form')[0].reset();

	                    console.log(response.external);
	                } else {
	                    modalMessage('No se ha podido actualizar el Beefispot');
	                }
	            }
			});
		}
	});
});