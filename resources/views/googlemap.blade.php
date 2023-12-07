<!DOCTYPE html>
<html >
    
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Google Map </title>
    <style type="text/css">
        #map {
          height: 400px;
        }
    </style>
</head>
    
<body>
    <div id="map"></div>
    <button onclick="showMap(25.594095, 85.137566)">Show Map</button>  
  
    <script type="text/javascript">
       
        function showMap(lat, lng) {
          const myLatLng = { lat: lat, lng: lng };
          const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 5,
            center: myLatLng,
          });
  
          new google.maps.Marker({
            position: myLatLng,
            map,
            title: "Hello Rajkot!",
          });
        }  
    </script>
  
   <script type="text/javascript"
        src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries" >
</script>



</body>
</html>