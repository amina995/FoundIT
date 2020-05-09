<?php 
  $senderlat= $_GET['slat'];
  $senderlng= $_GET['slng'];

  $receiverlat= $_GET['rlat'];
  $receiverlng= $_GET['rlng'];
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
  <style type="text/css">
          html, body {
          height: 100%;
          margin: 0;
          padding: 0;
      }
      #map-canvas {
          height: 100%;
          width: 100%;
      }
  </style>
  <title>FoundIt: Route</title>

  <script type="text/javascript">
    window.onload=function(){

      function initMap() {
        slat = <?php Print($senderlat); ?>;
        slng = <?php Print($senderlng); ?>;

        rlat = <?php Print($receiverlat); ?>;
        rlng = <?php Print($receiverlng); ?>;

        var pointA = new google.maps.LatLng(slat, slng),
            pointB = new google.maps.LatLng(rlat, rlng),
            myOptions = {
                zoom: 7,
                center: pointA
            },
            map = new google.maps.Map(document.getElementById('map-canvas'), myOptions),
            // Instantiate a directions service.
            directionsService = new google.maps.DirectionsService,
            directionsDisplay = new google.maps.DirectionsRenderer({
                map: map
            }),
            markerA = new google.maps.Marker({
                position: pointA,
                title: "point A",
                label: "A",
                map: map
            }),
            markerB = new google.maps.Marker({
                position: pointB,
                title: "point B",
                label: "B",
                map: map
            });

            // get route from A to B
            calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB);

      }

      function calculateAndDisplayRoute(directionsService, directionsDisplay, pointA, pointB) {
          directionsService.route({
              origin: pointA,
              destination: pointB,
              avoidTolls: true,
              avoidHighways: false,
              travelMode: google.maps.TravelMode.DRIVING
          }, function (response, status) {
              if (status == google.maps.DirectionsStatus.OK) {
                  directionsDisplay.setDirections(response);
              } else {
                  window.alert('Directions request failed due to ' + status);
              }
          });
      }

      initMap();

    }


  </script>
</head>

<body>
  <div id="map-canvas"></div>
  <script>
  // tell the embed parent frame the height of the content
  if (window.parent && window.parent.parent){
    window.parent.parent.postMessage(["resultsFrame", {
      height: document.body.getBoundingClientRect().height,
      slug: "None"
    }], "*")
  }
  </script>

</body>
</html>

