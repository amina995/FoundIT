<?php 
  require('config.php');
  session_start();
  //echo session_id();
  
  if(isset($_POST['submit'])){

    if((isset($_POST['email']) 
      && $_POST['email'] !='') 
      && (isset($_POST['password']) 
      && $_POST['password'] !='')){

      $email = $_POST['email'];
      $password = $_POST['password'];
      $sql = "select * from user where email = '".$email."'";
      
      $rs = mysqli_query($conn,$sql);
      $numRows = mysqli_num_rows($rs);
      
      if($numRows  == 1){

        $row = mysqli_fetch_assoc($rs);
        if($password===$row['sifra']){

          $_SESSION['username'] = $row['email'];
          $_SESSION['u'] = $row['username'];
          
          //echo "<pre>";
          //print_r($_SESSION);
          //echo "</pre>";
          //exit;
          
          header('location:app.php');
          exit;
        }

        else{
          $errorMsg =  "Wrong Email Or Password";
          echo "<script type='text/javascript'>alert('$errorMsg');</script>";
        }

      }

      else{
        $errorMsg =  "No User Found";
        echo "<script type='text/javascript'>alert('$errorMsg');</script>";

      }
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Found It</title>
  <?php include 'index sources.php' ?>
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({pageLanguage: 'en'}, 
        'google_translate_element');
    }
  </script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
</head>

<body>     
<!--<div id="google_translate_element"></div>-->
<div class="col-lg-4 col-lg-offset-4 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 col-xs-12 " id="center" role="dialog">
    <img class="col-lg-12 col-lg-offset-0 col-md-12 col-md-offset-0 col-sm-12 col-sm-offset-0 col-xs-12 col-xs-offset-0" id="logo" src="img/logo.png">

    <div class="modal-body">
        <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
            <div class="field-container">

                <input type="email" name="email" required placeholder="Enter Your E-mail">
            </div>
            <div class="field-container">

                <input type="password" name="password" required placeholder="Enter Your Password" autocomplete="new-password">
            </div>
            <div class="field-container">
                <button type="submit" class="buttonshape1" id="submit" name="submit">Submit</button>

            </div>

<?php 

  if(isset($_GET['logout'])){
    echo "<div class='success-msg'>";
    echo "You have successfully logout";
    echo "</div>"; 
  }

?>

      </form>

    <button type="submit" data-toggle="modal" data-target="#registration" class="buttonshape1" id="signup" name="signup">Don`t have an account? - Sign Up</button>

    </div>

    </div>
    <div class="modal fade" id="registration" role="dialog">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header f">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div><img class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4 col-sm-4 col-sm-offset-4 col-xs-6 col-xs-offset-3" id="logo" src="img/logo.png"></div>
                    <div class="col-xs-12 modal-title">REGISTRATION</div>
                </div>
                <div class="modal-body col-md-10 col-md-offset-1">
                    <div class=" m"> Please fill in your information:</div>

                    <form class="" method="post" enctype="multipart/form-data" id="fid">
                        <div class="field-container">

                            <input class="fill" type="text" name="username" required placeholder="Username">
                        </div>
                        <div class="field-container">

                            <input class="fill" type="email" name="email" required placeholder="E-mail">
                        </div>
                        <div class="field-container">

                            <input class="fill" type="password" name="password" required placeholder="Password">
                        </div>

                        <button class="buttonshape1" name="register">Register</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<?php 

  if(isset($_POST['register'])){
    $db = mysqli_connect("localhost","root","aminas","foundit");
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $sql10 = ("SELECT * from user");
    $result10 = $conn->query($sql10);
    
    if ($result10->num_rows > 0) {
      $row10 = $result10->fetch_assoc();
      if($row10["email"]==$email){
        $errorMsg =  "User Already Exists";
        echo "<script type='text/javascript'>alert('$errorMsg');</script>";
      }

    else{
      $query = "INSERT INTO user (username,email, sifra) VALUES('$username','$email','$password')";  
      $qry = mysqli_query($db, $query);
      $msg =  "Registration successful";
      echo "<script type='text/javascript'>alert('$msg');</script>";
    }
    }}
    
?>
</body>
</html>