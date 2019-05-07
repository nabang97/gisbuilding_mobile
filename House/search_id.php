<?php
require '../mobile/koneksi.php';

if (isset($_GET['name'])) {
  $id = strtoupper($_GET["id"]);
$querysearch = " 	SELECT house_building_id, ST_X(ST_Centroid(geom)) AS longitude, ST_Y(ST_CENTROID(geom)) As latitude
					FROM house_building WHERE upper(house_building_id) like '%$id%' ORDER BY house_building_id
				";
$hasil = pg_query($querysearch);
while ($row = pg_fetch_array($hasil)) {
    $id = $row['house_building_id'];
    $longitude = $row['longitude'];
    $latitude = $row['latitude'];
    $dataarray[] = array('id' => $id, 'longitude' => $longitude, 'latitude' => $latitude);
}
	// echo json_encode($dataarray);
}
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -0.3209284, lng: 100.3484996},
          zoom: 13
        });
        // map.data.LoadGeojson('https://gis-kotogadang.herokuapp.com/dataumkm.php');

        var a = <?php echo json_encode($dataarray); ?>;
        console.log(a);
        console.log(a.length);
        panjang=a.length;
        // var layernya = new google.maps.Data();
        //                    layernya.loadGeoJson(a);
        //                    layernya.setMap(map);
        console.log(a[0]['latitude']);
        for (i=0; i < panjang; i++) {
          var myLatLng = {lat: parseFloat(a[i]['latitude']), lng: parseFloat(a[i]['longitude'])};
          var marker = new google.maps.Marker({
         position: myLatLng,
         map: map,
         title: 'Hello World!'
       });

       }
       var layernya = new google.maps.Data();
                          layernya.loadGeoJson('https://gis-kotogadang.herokuapp.com/batasnagari.php');
                          layernya.setMap(map);
        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&callback=initMap"
    async defer></script>
  </body>
</html>
  </body>
</html>