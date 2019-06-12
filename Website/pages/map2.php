<html>
    <head>
        <script src="http://s-web.it.gla/in17/boeltes/statistika/js/leaflet/leaflet.js"></script>
        <script>
            var districtMap;

            function loadMap() {
                districtMap = L.map('landkreisKarte').setView([53.119194, 10.334165], 8);


            }

            function displayDistrict(latLng, txtInfo) {

            }
        </script>
    </head>
<body>
<!-- MAP -->


<div id="landkreisKarte"></div>
<script>loadMap(); displayDistrict();</script>
</body>
</html>

