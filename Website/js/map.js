var districtMap;

function loadMap() {
	districtMap = L.map('landkreisKarte').setView([53.119194, 10.334165], 8);
	
	L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
		maxZoom: 18,
		attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	}).addTo(districtMap);
}

function displayDistrict(latLng, txtInfo) {
	var district = L.polygon([[53.119194, 10.334165],[53.634766, 11.812505], [52.435183, 10.272738], [53.044833, 8.330061]], {
		color: 'red',
		fillOpacity: 1,
	}).addTo(districtMap);
	
	district.bindPopup("<b>Bambi stinkt</b><br>Sagt seine Mutter lolololololololololo.", {
		closeButton: false,
	});
	
	district.on('mouseover', function() {
		district.openPopup();
	});
	
	district.on('mouseout', function() {
		district.closePopup();
	});
}