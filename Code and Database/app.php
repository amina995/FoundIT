<?php 
  session_start();
  //echo session_id();
  $uu=$_SESSION['username'];
  //$uu=ucwords($_SESSION['username']);
  $user_email=$_SESSION['username'];
  if(!isset($_SESSION)){
  header('location:index.php');
  exit;
  }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Found It</title>
    <?php include 'app sources.php'?>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a id="l" class="navbar-brand" onclick='logout()'>FoundIt<i class="fa fa-map-marker" aria-hidden="true"></i></a>
        </div>
        <!-- Top Menu Items -->
        <ul class="nav navbar-right top-nav">
        </ul>
        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav pull-right ">
                <li class="active">
                    <a href="#" id="red">
                        <?php $uu=$_SESSION['username']; echo $uu;?>
                    </a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#inbox"><i class="fa fa-envelope" aria-hidden="true" ></i> Messages</a>

                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#foundModal"><i class="fa fa-plus-square"></i> Found something</a>
                </li>
                <li>
                    <a href="#" data-toggle="modal" data-target="#lostModal"><i class="fa fa-minus-square"></i> Lost something</a>
                </li>

                <li>
                    <a href="logout.php?logout=true" class="logout-link"><i class="fa fa-fw fa-power-off"></i>Logout</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
      </nav>
    <?php 
    $u=$_SESSION['username'];
    if(isset($_POST['button1']))
    {

    $db = mysqli_connect("localhost","root","aminas","foundit"); //keep your db name
    $image = addslashes(file_get_contents($_FILES['myfile']['tmp_name']));
    $name=$_POST['name1'];
    $description=$_POST['description1'];
    $datetime=date('Y-m-d H:i:s');
    $location=$_POST['location1'];
    $lat=$_POST['lat1'];
    $lng=$_POST['lng1'];
    $lostfound='lost';
    //you keep your column name setting for insertion. I keep image type Blob.
    $query = "INSERT INTO item (name1,image,name, description, datetime1, lat, lng, lostfound, location) VALUES('$uu','$image','$name','$description','$datetime','$lat', '$lng', '$lostfound', '$location')";  
    $qry = mysqli_query($db, $query); }
    ?>
            
    <div class="modal fade" id="lostModal" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header l">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">LOST</h4>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="fid">
                        <div class="field-container">

                            <input class="fill" type="text" name="name1" required placeholder="Item name">
                        </div>
                        <div class="field-container">
                            <div class="uploadklasa" name="" id="upload">Upload item image <i class="fa fa-upload" aria-hidden="true"></i></div>
                            <input id="uploadinput" type="file" name="myfile" style="display: none">
                        </div>
                        <div class="field-container" id="sivo">

                            <div id="getloc1" onclick="getLocation1()">Get my current location <i class="fa fa-hand-pointer-o"></i></div>
                            <input class="coordinates" onkeydown="return false;" type="text" id="lat1" name="lat1" value="Coordinates will be calculated"></input>
                            <input class="coordinates" type="text" id="lng1" name="lng1" value="automatically"></input>
                            <input class="controls fill" id="pac-input1" name="location1" type="text" placeholder="Enter location manually">
                            <div id="map1" style="display: none"></div>
                        </div>
                        <div class="field-container">

                            <textarea name="description1" class="fill1" rows="3" cols="35" wrap="soft" required placeholder="Item description"></textarea>
                        </div>

                        <button class="buttonshape1" name="button1">Post</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php 
    $u=$_SESSION['username'];
    if(isset($_POST['button']))
    {
    $db = mysqli_connect("localhost","root","aminas","foundit"); //keep your db name
    $image = addslashes(file_get_contents($_FILES['myfile']['tmp_name']));
    $name=$_POST['name'];
    $description=$_POST['description'];
    $datetime=date('Y-m-d H:i:s');
    $location=$_POST['location'];
    $lat=$_POST['lat'];
    $lng=$_POST['lng'];
    $lostfound='found';
    //you keep your column name setting for insertion. I keep image type Blob.
    $query = "INSERT INTO item (name1,image,name, description, datetime1, lat, lng, lostfound, location) VALUES('$uu','$image','$name','$description','$datetime','$lat', '$lng', '$lostfound', '$location')";  
    $qry = mysqli_query($db, $query); }
    ?>

    <div class="modal fade" id="inbox" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content" id="porukamodal">
                <div class="modal-header f">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Inbox</h4>
                </div>
                <div class="modal-body" id="msgmodal">
  

<?php
require('config.php');

$sql10 = ("SELECT * from message WHERE receiver = '$uu' order by msgdate desc");

$result10 = $conn->query($sql10);
if ($result10->num_rows > 0) {
    
    while ($row10 = $result10->fetch_assoc()) {
        
        echo '<div id="poruka" class="col-md-12"><hr id="line">';
        echo '<div class="col-md-12" id="user" style="text-transform:uppercase"><i class="fa fa-user"></i> ' . $row10['sender'] . '</div>';
        echo '<div class="col-md-6">SUBJECT:' . $row10['subject'] . '</div>';
        echo '<div class="col-md-6" id="datum">' . $row10['msgdate'] . '</div>';
        echo '<div class="col-md-12" id="msg">MESSAGE:<br>' . $row10['message'] . '</div><hr>';
        
        if ($row10['lat'] || $row10['lng'] || $row10['location'] != null) {
            echo '<div class="col-md-12" id="msg">';
            echo '<input  style="display:none" class="coordinates" type="text" id="lat4" name="lat4" value="' . $row10['lat'] . '"></input>';
            
            echo '<input style="display:none" class="coordinates" type="text" id="lng4" name="lng4" value="' . $row10['lng'] . '"></input>';
            
            echo '<div style="display:inline; padding-left:0px" class="col-md-10" id="loc4">Location:' . $row10['location'] . '</div></div>';
            
            echo '<div id="' . $row10['lat'] . '" class="' . $row10['lng'] . '" style="text-align:right; cursor: pointer" onclick="getLocation4(this.id, this.className)">Show on map <i class="fa fa-map"></i></div>';
            echo ' <input style="display:none" class="coordinates" type="text" id="lat5" name="lat5" value="Coordinates will be calculated" ></input>';
            echo '<input style="display:none" class="coordinates" type="text" id="lng5" name="lng5" value="Coordinates will be calculated" ></input>';
            
            echo '  <div class="col-sm-8" id="msgmap" style="display:none"></div>';
            
        }
        
        echo '</div><hr>';
    }
}
?> 

        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="foundModal" role="dialog">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
              <div class="modal-header f">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">FOUND</h4>
              </div>
              <div class="modal-body">
                  <form method="post" enctype="multipart/form-data" id="lid">
                      <div class="field-container">

                          <input class="fill" type="text" name="name" required placeholder="Item name">
                      </div>

                      <div class="field-container">
                          <div class="uploadklasa1" name="" id="upload1">Upload item image <i class="fa fa-upload" aria-hidden="true"></i></div>
                          <input id="uploadinput1" type="file" name="myfile" style="display: none">
                      </div>

                      <div class="field-container" id="sivo">

                          <div id="getloc" onclick="getLocation()">Get my current location <i class="fa fa-hand-pointer-o"></i></div>
                          <input class="coordinates" type="text" id="lat" name="lat" value="Coordinates will be calculated"></input>
                          <input class="coordinates" type="text" id="lng" name="lng" value="automatically"></input>
                          <input id="pac-input" class="controls" name="location" type="text" placeholder="Enter location manually">
                          <div id="map" style="display: none"></div>
                      </div>
                      <div class="field-container">

                          <textarea name="description" class="fill1" rows="3" cols="35" wrap="soft" required placeholder="Item description"></textarea>
                      </div>

                      <button class="buttonshape1" name="button">Post</button>
                  </form>
              </div>
              <div class="modal-footer">
              </div>
          </div>
      </div>
  </div>
  </div>
                <!--<button onclick="showOther()">ljudi</button>
<button onclick="showItems()">stvari</button>-->
  <div class="col-sm-4" id="left">
      <div class="row">
          <div class="col-lg-12">
              <ol class="breadcrumb">
                  <li class="active" id="news">
                      <i class="fa fa-bullhorn"></i> News Feed
                  </li>
              </ol>
          </div>
      </div>
<?php 
  require('config.php');

  $flatarray=[];
  $flngarray=[];
  $fname=[];
  $fdesc=[];
  $floc=[];
  $i=0;

  $llatarray=[];
  $llngarray=[];
  $lname=[];
  $ldesc=[];
  $lloc=[];

  $j=0;
  $sql1 = "(SELECT * from item order by datetime1 desc)";

  $result1 = $conn->query($sql1);
  if ($result1->num_rows > 0) {

  while($row1 = $result1->fetch_assoc()) {

    if ($row1['lostfound']=='found')
      {

      echo '<div class="panel panel-primary">

      <div class="panel-heading">
      <div class="row">
      <div class="col-xs-12">FOUND: '.$row1['name'];

      $flatarray[$i] = $row1['lat']; 
      $flngarray[$i] = $row1['lng']; 
      $fname[$i]=$row1['name'];
      $fdesc[$i]=$row1['description'];
      $floc[$i]=$row1['location'];
      $fimage[$i]=$row1['image'];

      $i=$i+1;

    }

    else{
      echo '<div class="panel panel-danger">

      <div class="panel-heading">
      <div class="row">
      <div class="col-xs-12">LOST: '.$row1['name'];

      $llatarray[$i] = $row1['lat']; 
      $llngarray[$i] = $row1['lng']; 
      $lname[$i]=$row1['name'];
      $ldesc[$i]=$row1['description'];
      $lloc[$i]=$row1['location'];
      $j=$j+1;

    }

    echo'</div>

    </div>
    </div> 
    <div class="panel-footer">

    <div class="pull-left">'.$row1['description'].'</div><hr>';

    echo '<div id="imagepreview">';

    if(empty( $row1['image'])){ 
    
      echo '<img id="slika" src="img/default.jpg"/><br>';
    
    }

    else{

      echo '<img id="slika" src="data:image/jpeg;base64,'.base64_encode( $row1['image'] ).'"/><br>';}

      echo '</div>';

      echo '<div class="clearfix"></div><br>
      <div class="lokacija"><i class="smallicon fa fa-map-marker" aria-hidden="true"></i>'.$row1['location'].'</div>
      <div class="lokacija"><i class="smallicon fa fa-map-marker" aria-hidden="true"></i>Coordinates: '.$row1['lat'].', '.$row1['lng'].'</div>
      <div class="datetime"><i class="smallicon fa fa-clock-o"></i>'.$row1['datetime1'].'</div>
      <br>';

      echo '

      <a href="#" class="'.$row1['name1'].'"  hreflang="'.$row1['name'].'" id="korisnik" data-toggle="modal" onclick="updateLink(this)" data-target="#message"><i class="fa fa-envelope" data-id="'.$row1['name1'].'"></i> '.$row1['name1'].'</a>
      </div>

      </div>';

    }
  }

?>

    </div>

    <div class="modal fade" id="message" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header f">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Message</h4>

                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="lid">
                        <div class="field-container">
                            <label>Korisnik:</label>
                            <input class="fill" type="text" name="korisnikemail" id="korisnikemail" required placeholder="Enter Your Text">
                        </div>
                        <div class="field-container">
                            <label>Subject:</label>
                            <input class="fill" type="text" name="subject" id="subject" required placeholder="Enter Your Text">
                        </div>

                        <div class="field-container">
                            <label>Message text:</label>
                            <textarea name="message" class="fill1" rows="3" cols="35" wrap="soft" required placeholder="Enter Your Text"></textarea>
                        </div>
                        <div class="field-container" id="plavo">

                            <div id="getloc3" onclick="getLocation3()" style="cursor: pointer;">Send my current location <i class="fa fa-map"></i></div>
                            <input class="coordinates" type="text" id="lat3" name="lat3" value="Coordinates will be calculated"></input>
                            <input class="coordinates" type="text" id="lng3" name="lng3" value="automatically"></input>
                            <input id="pac-input3" class="controls" name="location3" type="text" placeholder="Enter location manually">
                            <div id="map3" style="display: none"></div>
                        </div>

                        <button name="sendmsg" class="buttonshape1">Send</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<?php 
  if (isset($_POST["sendmsg"])){
    $db = mysqli_connect("localhost","root","sarajevo95","foundit"); //keep your db name

    $korisnik=$_POST['korisnikemail'];
    $subject=$_POST['subject'];
    $message=$_POST['message'];
    $lat3=$_POST['lat3'];
    $lng3=$_POST['lng3'];
    $loc3=$_POST['location3'];
    $datee=date('Y-m-d H:i:s');

    //you keep your column name setting for insertion. I keep image type Blob.
    $query = "INSERT INTO message (sender,receiver,subject, message, msgdate, lat, lng, location) VALUES('$uu','$korisnik','$subject','$message', '$datee', '$lat3', '$lng3', '$loc3')";  
    $qry = mysqli_query($db, $query);
  }
?>

  <div class="col-lg-4" id="left1" style="display: none;">
      <div class="row">
          <div class="col-lg-12">
              <ol class="breadcrumb">
                  <li class="active" id="news">
                      <i class="fa fa-bullhorn"></i> News Feed
                  </li>
              </ol>
          </div>
      </div>
<?php 
  require('config.php');

  $flatarray=[];
  $flngarray=[];
  $fname=[];
  $fdesc=[];
  $floc=[];
  $i=0;

  $llatarray=[];
  $llngarray=[];
  $lname=[];
  $ldesc=[];
  $lloc=[];
  $j=0;
  $sql1 = "(SELECT * from item order by datetime1 desc)";

  $result1 = $conn->query($sql1);
  if ($result1->num_rows > 0) {

    while($row1 = $result1->fetch_assoc()) {

      if ($row1['lostfound']=='found'){

        echo '<div class="panel panel-primary">

        <div class="panel-heading">
        <div class="row">
        <div class="col-xs-12">FOUND: '.$row1['name'];

        $flatarray[$i] = $row1['lat']; 
        $flngarray[$i] = $row1['lng']; 
        $fname[$i]=$row1['name'];
        $fdesc[$i]=$row1['description'];
        $floc[$i]=$row1['location'];
        $fimage[$i]=$row1['image'];

        $i=$i+1;

      }

      else{

        echo '<div class="panel panel-danger">

        <div class="panel-heading">
        <div class="row">
        <div class="col-xs-12">LOST: '.$row1['name'];

        $llatarray[$i] = $row1['lat']; 
        $llngarray[$i] = $row1['lng']; 
        $lname[$i]=$row1['name'];
        $ldesc[$i]=$row1['description'];
        $lloc[$i]=$row1['location'];
        $j=$j+1;
      }

      echo'</div>

      </div>
      </div> <a href="#">
      <div class="panel-footer">

      <div class="pull-left">'.$row1['description'].'</div><hr>
      <div class="clearfix"></div>
      <div class="lokacija"><i class="smallicon fa fa-map-marker" aria-hidden="true"></i>'.$row1['location'].'</div>
      <div class="datetime"><i class="smallicon fa fa-clock-o"></i>'.$row1['datetime1'].'</div><br>
      <img id="slika" src="data:image/jpeg;base64,'.base64_encode( $row1['image'] ).'"/>
      </div>
      </a>
      </div>';

    }
  }

?>
  </div>
  <div class="col-sm-8" id="mapid"></div>
                  
        <script type="text/javascript">
            //document.getElementById("lat").disabled = true;
            //document.getElementById("lng").disabled = true;
            $(document).ready(function() {
                $("#button").keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            });

            function logout() {

                if (confirm("Da li se želite odjaviti i vratiti na početnu stranicu?")) {

                    window.location.href = "http://127.0.0.1/FoundIt/index.php";
                    // document.location.href = 'http://127.0.0.1/TelecomIS/index.php',true;
                } else {

                }
                return false;
            }
            var mymap = L.map('mapid').setView([43.86, 18.4317], 11);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
                maxZoom: 18,
            }).addTo(mymap);

            /*var msgmap = L.map('msgmap').setView([43.86, 18.4317], 11);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 18,
            }).addTo(msgmap);*/

            var mm;
            var mmm;

            function createIcons(iconUrl, w, h) {
                var iconName = L.icon({
                    iconUrl: iconUrl,
                    iconSize: [w, h]
                });
                return iconName;
            }

            var lostIcon = createIcons('img/red.png', 40, 40);
            var foundIcon = createIcons('img/blue.png', 40, 40);

            var foundlat = [<?php echo '"'.implode('","', $flatarray).'"' ?>];
            var foundlng = [<?php echo '"'.implode('","', $flngarray).'"' ?>];
            var foundname = [<?php echo '"'.implode('","', $fname).'"' ?>];
            var founddesc = [<?php echo '"'.implode('","', $fdesc).'"' ?>];
            var foundloc = [<?php echo '"'.implode('","', $floc).'"' ?>];

            var lostlat = [<?php echo '"'.implode('","', $llatarray).'"' ?>];
            var lostlng = [<?php echo '"'.implode('","', $llngarray).'"' ?>];
            var lostname = [<?php echo '"'.implode('","', $lname).'"' ?>];
            var lostdesc = [<?php echo '"'.implode('","', $ldesc).'"' ?>];
            var lostloc = [<?php echo '"'.implode('","', $lloc).'"' ?>];

            var foundmarker = [];
            for (var i = 0; i < foundlng.length; i++)
                foundmarker[i] = new L.marker([foundlat[i], foundlng[i]], {
                    draggable: false,
                    icon: foundIcon
                }).bindPopup("FOUND" + "<br>" + foundname[i] + "<br>" + "Lokacija: " + foundloc[i]).addTo(mymap);

            var lostmarker = [];
            for (var i = 0; i < lostlng.length; i++)
                lostmarker[i] = new L.marker([lostlat[i], lostlng[i]], {
                    draggable: false,
                    icon: lostIcon
                }).bindPopup("LOST" + "<br>" + lostname[i] + "<br>" + "Lokacija: " + lostloc[i]).addTo(mymap);

            function getLocation() {
                if (navigator.geolocation) {

                    navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }
            }

            function showPosition(position) {
                //alert(position.coords.latitude);
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lng').value = position.coords.longitude;
                var geocoder;
                geocoder = new google.maps.Geocoder();
                var lat = document.getElementById("lat").value;
                var lng = document.getElementById("lng").value;
                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {

                    document.getElementById("pac-input").value = results[4].formatted_address;
                });

            }

            function getLocation1() {

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition1);

                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }

            }

            function showPosition1(position) {
                //alert(position.coords.latitude);
                document.getElementById('lat1').value = position.coords.latitude;
                document.getElementById('lng1').value = position.coords.longitude;

                var geocoder;
                geocoder = new google.maps.Geocoder();
                var lat = document.getElementById("lat1").value;
                var lng = document.getElementById("lng1").value;
                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {

                    document.getElementById("pac-input1").value = results[4].formatted_address;
                });

            }

            function getLocation3() {

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition3);

                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }

            }

            function showPosition3(position) {
                //alert(position.coords.latitude);
                document.getElementById('lat3').value = position.coords.latitude;
                document.getElementById('lng3').value = position.coords.longitude;

                var geocoder;
                geocoder = new google.maps.Geocoder();
                var lat = document.getElementById("lat3").value;
                var lng = document.getElementById("lng3").value;
                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {

                    document.getElementById("pac-input3").value = results[4].formatted_address;
                });

            }

            var senderlat;
            var senderlng;

            function getLocation4(a, b) {

                if (navigator.geolocation) {
                    senderlat = a;
                    senderlng = b;
                    navigator.geolocation.getCurrentPosition(showPosition4);
                    mymap.removeLayer(mm);
                    mymap.removeLayer(mmm);
                } else {
                    x.innerHTML = "Geolocation is not supported by this browser.";
                }

            }

            function showPosition4(position) {
                //alert(senderlat+ senderlng);
                document.getElementById('lat5').value = position.coords.latitude;
                document.getElementById('lng5').value = position.coords.longitude;

                var javascriptVariable = "John";
                window.location.href = "location.php?slat=" + senderlat + "&slng=" + senderlng + "&rlat=" + position.coords.latitude + "&rlng=" + position.coords.longitude;
                /*var slat=document.getElementById('lat4').value;
                var slng=document.getElementById('lng4').value;*/
                var rlat = position.coords.latitude;
                var rlng = position.coords.longitude;

                var foundIcon = createIcons('img/back.png', 40, 40);

                mm = new L.marker([senderlat, senderlng], {
                    draggable: false,
                    icon: foundIcon
                }).addTo(mymap);
                mmm = new L.marker([rlat, rlng], {
                    draggable: false,
                    icon: foundIcon
                }).addTo(mymap);

                var latLngs = [mm.getLatLng()];
                var markerBounds = L.latLngBounds(latLngs);
                mymap.fitBounds(markerBounds);

                var geocoder;
                geocoder = new google.maps.Geocoder();
                var lat = document.getElementById("lat5").value;
                var lng = document.getElementById("lng5").value;
                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({
                    'latLng': latlng
                }, function(results, status) {

                    //document.getElementById("pac-input").value = results[4].formatted_address;
                });

            }

            function initAutocomplete() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: -33.8688,
                        lng: 151.2195
                    },
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });
                var map1 = new google.maps.Map(document.getElementById('map1'), {
                    center: {
                        lat: -33.8688,
                        lng: 151.2195
                    },
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });
                var map3 = new google.maps.Map(document.getElementById('map1'), {
                    center: {
                        lat: -33.8688,
                        lng: 151.2195
                    },
                    zoom: 13,
                    mapTypeId: 'roadmap'
                });

                // Create the search box and link it to the UI element.
                var input = document.getElementById('pac-input');
                var input1 = document.getElementById('pac-input1');
                var input3 = document.getElementById('pac-input3');
                var searchBox = new google.maps.places.SearchBox(input);
                var searchBox1 = new google.maps.places.SearchBox(input1);
                var searchBox3 = new google.maps.places.SearchBox(input3);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                map1.controls[google.maps.ControlPosition.TOP_LEFT].push(input1);
                map3.controls[google.maps.ControlPosition.TOP_LEFT].push(input3);

                // Bias the SearchBox results towards current map's viewport.
                /*map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
                });*/

                var markers = [];
                // Listen for the event fired when the user selects a prediction and retrieve
                // more details for that place.
                searchBox.addListener('places_changed', function() {
                    //GetLatlong();

                    var places = searchBox.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {

                        document.getElementById('lat').value = place.geometry.location.lat();
                        document.getElementById('lng').value = place.geometry.location.lng();

                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);

                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map.fitBounds(bounds);

                });

                searchBox3.addListener('places_changed', function() {
                    //GetLatlong();

                    var places = searchBox3.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {

                        document.getElementById('lat3').value = place.geometry.location.lat();
                        document.getElementById('lng3').value = place.geometry.location.lng();

                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);

                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map3.fitBounds(bounds);

                });

                searchBox1.addListener('places_changed', function() {
                    //GetLatlong();

                    var places = searchBox1.getPlaces();

                    if (places.length == 0) {
                        return;
                    }

                    // Clear out the old markers.
                    markers.forEach(function(marker) {
                        marker.setMap(null);
                    });
                    markers = [];

                    // For each place, get the icon, name and location.
                    var bounds = new google.maps.LatLngBounds();
                    places.forEach(function(place) {

                        document.getElementById('lat1').value = place.geometry.location.lat();
                        document.getElementById('lng1').value = place.geometry.location.lng();

                        if (!place.geometry) {
                            console.log("Returned place contains no geometry");
                            return;
                        }
                        var icon = {
                            url: place.icon,
                            size: new google.maps.Size(71, 71),
                            origin: new google.maps.Point(0, 0),
                            anchor: new google.maps.Point(17, 34),
                            scaledSize: new google.maps.Size(25, 25)
                        };

                        // Create a marker for each place.
                        markers.push(new google.maps.Marker({
                            map: map,
                            icon: icon,
                            title: place.name,
                            position: place.geometry.location
                        }));

                        if (place.geometry.viewport) {
                            // Only geocodes have viewport.
                            bounds.union(place.geometry.viewport);

                        } else {
                            bounds.extend(place.geometry.location);
                        }
                    });
                    map1.fitBounds(bounds);

                });

            }

            function showOther() {
                document.getElementById("left1").style.display = "block";
                document.getElementById("left").style.display = "none";
            }

            function showItems() {
                document.getElementById("left1").style.display = "none";
                document.getElementById("left").style.display = "block";
            }

            function updateLink(a) {
                var newurl = "";

                //You could retrieve the object name
                newurl = a.getAttribute("class");
                newurl1 = a.getAttribute("hreflang");

                //Or, retrieve the id

                document.getElementById('korisnikemail').value = newurl;
                document.getElementById('subject').value = newurl1;
                //redirect 

            }

            $("#upload").click(function() {
                $("#uploadinput").trigger('click');
                document.getElementById('upload').style.color = "orange";

            });

            $("#upload1").click(function() {
                $("#uploadinput1").trigger('click');
                document.getElementById('upload1').style.color = "orange";
            });

            if (window.history.replaceState) {
                window.history.replaceState(null, null, window.location.href);

            }
        </script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqDZNp-3PQgzQwGmvS-ngIzQAWjvtgO4Q&libraries=places&callback=initAutocomplete" async defer></script>
  </body>
</html>