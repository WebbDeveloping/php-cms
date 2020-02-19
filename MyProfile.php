<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php
$_SESSION["TrackingURL"]=$_SERVER["PHP_SELF"];
Confirm_Login(); ?>

<?php 
$IMG = './Images/avatar.png';
// fetching existing admin data
$AdminId = $_SESSION["UserId"];
$ConnectingDB;
$sql = "SELECT aname FROM admins WHERE id=$AdminId";
$stmt=$ConnectingDB->query($sql);
while($DataRows=$stmt->fetch()){
    $ExistingName = $DataRows['aname'];
}


if(isset($_POST["Submit"])){
  $AName = $_POST["Name"];
  $AHeadline = $_POST["Headline"];
  $ABio = $_POST["Bio"];
  $Image = $_FILES["Image"]["name"];
  $Target = "Images/".basename($_FILES["Image"]["name"]);
//   CANT GET THE IMAGE TO UPLOAD :(


if(strlen($AHeadline)> 12){
    $_SESSION["ErrorMessage"]= "Headline should be less than 12 characters";
    Redirect_to("MyProfile.php");
  }elseif(strlen($ABio)> 500){
    $_SESSION["ErrorMessage"]= "Bio should be less than 500 characters";
    Redirect_to("MyProfile.php");
  } else {
    global $ConnectingDB;
    if(!empty($_FILES["Image"]["name"])){
      $sql = 
      "UPDATE admins 
      SET aname = '$AName',
      aheadline='$AHeadline', 
      abio ='$ABio', aimage='$Image'
      WHERE id = '$AdminId'";
    } else {
      $sql = 
      "UPDATE admins 
      SET aname = '$AName',
      aheadline='$AHeadline', 
      abio ='$ABio'
      WHERE id = '$AdminId'";
    }
      $Execute=$ConnectingDB->query($sql);
      move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);
      if($Execute){
        $_SESSION["SuccessMessage"]="Details Updated Succesfully";
        Redirect_to('MyProfile.php');
      } else {
          // BUG!!
          // WHY WONT YOU EFFING UPDATE
        $_SESSION["ErrorMessage"]="Something went wrong updating profile";
        Redirect_to('MyProfile.php');
      }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!-- fontawesome -->
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
      integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
      crossorigin="anonymous"
    />
    <!-- bootstrap -->
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
      integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="Css/Styles.css" />
    <title>My Profile</title>
  </head>
  <body>
    <!-- Navbar -->
    <div style="height:10px; background:#27aae1"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark text-light">
      <div class="container">
        <a href="#" class="navbar-brand">JoeDirt.Com</a>
        <button
          class="navbar-toggler"
          data-toggle="collapse"
          data-target="#navbarcollapseCMS"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarcollapseCMS">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a href="MyProfile.php" class="nav-link"
                ><i class="text-success fas fa-user"></i> My Profile</a
              >
            </li>
            <li class="nav-item">
              <a href="Dashboard.php" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
              <a href="Posts.php" class="nav-link">Posts</a>
            </li>
            <li class="nav-item">
              <a href="Categories.php" class="nav-link">Categories</a>
            </li>
            <li class="nav-item">
              <a href="Admins.php" class="nav-link">Manage Admins</a>
            </li>
            <li class="nav-item">
              <a href="Comments.php" class="nav-link">Comments</a>
            </li>
            <li class="nav-item">
              <a href="Blog.php?page=1" class="nav-link">Live Blog</a>
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link text-danger" href="Logout.php"
                ><i class="fas fa-user-times"></i> Logout</a
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div style="height:10px; background:#27aae1"></div>
    <!-- NAVBAR END -->

    <!-- Header -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
            <div class='col-md-12'>
                <h1><i class='fas fa-user mr-2' style='color:#72aae1'></i> My Profile</h1>
            </div>
            
        </div>
      </div>
    </header>
    <!-- Header END -->





<!-- MAIN AREA -->
<section class='container py-2 mb-4'>
    <div class='row' >
        <!-- Left area -->
        <div class='col-md-3'>
            <div class='card'>
                <div class='card-header bg-dark text-light'>
                    <h3><?php echo $ExistingName ?></h3>
                </div>
                <div class='card-body'>
                  <img src='<?php echo $IMG?>' class="block img-fluid mb-3"alt="">
                  <div class="">
                  "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                  </div>
                </div>
            </div>

        </div>


        
        <!-- RIGHT AREA -->

      <div class='col-md-9' style="min-height:400px;" >
      <?php 
      echo ErrorMessage();
      echo SuccessMessage();
      ?>
        <form class="" action="MyProfile.php" method="post" enctype="multipart/form-data">
          <div class='card bg-dark text-light'>
          <div class="card-header bg-secondary text-light">
          <h4>Edit Profile</h4>
          </div>
              <div class='card-body'>
                <div class='form-group'>
                  <input class='form-control' type="text" name="Name" id="title" placeholder="Type name here.." value="">
                </div>  
                <div class="form-group">
                  <input class="form-control" type="text" value="" id="title" placeholder="Headline" name="Headline">
                  <small class="text-muted"> Add A professional headline.</small>
                  <span class="text-danger">Not more than 12 charachters</span>
                </div>  
                <div class="form-group">
  
                  
                  <textarea class="form-control" id="Post" name="Bio" placeholder="Bio" rows="8" cols="80"></textarea>
                </div>

                
                <div class="form-group">
                  <div class="custom-file">
                        <input class="custom-file-input" type="File" name="Image" id="image" value="">
                        <label for="Image" class="custom-file-label">Select Image</label>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-6 mb-2">
                    <a href="Dashboard.php" class="btn btn-warning btn-block">
                      <i class="fas fa-arrow-left">Back To Dashboard</i>
                    </a>
                  </div>
                  <div class='col-lg-6 mb-2'>
                    <button type="submit" name="Submit" class='btn btn-success btn-block'>
                    <i class='fas fa-check'> Publish</i>
                    </button>
                  </div>
                </div>           
            </div>
          </div>
        </form>
    </div>
    </div>
</section>
<!-- MAIN AREA END -->




    <!-- FOOTER -->
    <footer class="bg-dark text-white">
      <div class="container">
        <div class="row">
          <div class="col">
            <p class="lead text-center">
              Theme By | Joe Dirt |<span id="year"></span> &copy; ----ALL Rights
              Reserved
            </p>
            <p class="text-center small">
              <a style="color: white; text-decoration: none; cursor: pointer;"
                >This site is only used for study purposes. No one is allowed to
                use it.</a
              >
            </p>
          </div>
        </div>
      </div>
    </footer>
    <div style="height:10px; background:#27aae1"></div>
    <script
      src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
      integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
      integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
      integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
      crossorigin="anonymous"
    ></script>
    <script>
      $('#year').text(new Date().getFullYear());
    </script>
  </body>
</html>
