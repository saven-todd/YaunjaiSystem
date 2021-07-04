<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- <script src="js/jquery-3.5.1.min.js"></script> -->
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDbvy9FRDIpuVpWYzYkJyVb42DCbbIKwd8&libraries=places,geometry">
    </script>
    <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    #map-canvas {
        height: 100%;
        width: 100%;
    }
    </style>
    <?php
        include_once 'db.php';
        If(isset($_GET['id'])){
            $id = $_GET['id'];
            $sql = "SELECT lat,lng FROM orders WHERE OrderID = 11 ;";
            $data = mysqli_query($con,$sql);
            $result = mysqli_fetch_assoc($data);

            $_lat = $result['lat'];
            $_lng = $result['lng'];

            // echo "$_lat, $_lng";
        }

    ?>
</head>

<body>
    <div id="map-canvas"></div>

    <script>
    function initMap() {
        var pointA = new google.maps.LatLng(17.3992447, 102.79184),
            pointB = new google.maps.LatLng(<?=$_lat?>, <?=$_lng?>),
            myOptions = {
                zoom: 7,
                center: pointA
            },
            map = new google.maps.Map(document.getElementById('map-canvas'), myOptions),
            // Instantiate a directions service.
            directionsService = new google.maps.DirectionsService(),
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
        }, function(response, status) {
            if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
            } else {
                window.alert('Directions request failed due to ' + status);
            }
        });
    }

    initMap();
    </script>
</body>

</html>