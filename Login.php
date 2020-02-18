<?php require_once("Includes/DB.php");?>
<?php require_once("Includes/Functions.php");?>
<?php require_once("Includes/Sessions.php");?>
<?php 
if(isset($_SESSION["UserId"])){
    Redirect_to("Dashboard.php");
}
if(isset($_POST["Submit"])){
    $UserName=$_POST["Username"];
    $Password = $_POST['Password'];
   if(empty($UserName)||empty($Password)){
       $_SESSION["ErrorMessage"]="All fields must be filled out";
       redirect_to("Login.php");
   }else{
        $Found_Account=Login_Attempt($UserName, $Password);     
        if($Found_Account){
            $_SESSION["UserId"]=$Found_Account["id"];
            $_SESSION["UserName"]=$Found_Account["username"];
            $_SESSION["AdminName"]=$Found_Account["aname"];
            $_SESSION["SuccessMessage"]="Welcome ".$_SESSION["UserName"];
            if(isset($_SESSION["TrackingURL"])){
                Redirect_to($_SESSION["TrackingURL"]);
            } else {
                Redirect_to("Dashboard.php");
            }
        }else{
            $_SESSION["ErrorMessage"]="Incorrect Username/Password";
            Redirect_to("Login.php");
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
    <title>Login</title>
  </head>
  <body>
    <!-- Navbar -->
    <div style="height:10px; background:#27aae1"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
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
          
        </div>
      </div>
    </nav>
    <div style="height:10px; background:#27aae1"></div>
    <!-- NANBAR END -->
    <!-- Header -->
    <header class="bg-dark text-white py-3">
      <div class="container">
        <div class="row">
            <div class='col-md-12'>

            </div>
        </div>
      </div>
    </header>
    <!-- Header END -->
<section class='container py-2 mb-4'>
    <div class='row'>
        <div class=' offset-sm-3 col-sm-6' style="min-height:500px;">
            <br><br>
            <?php 
            echo ErrorMessage();
            echo SuccessMessage()
            ?>
            <div class="card bg-secondary text-light">
                <div class="card-header">
                    <h4>Welcome Back !</h4>
                </div>
                    <div class="card-body bg-dark">
                    <form class="" action="Login.php" method="post">
                        <div class="form-group">
                            <label for="username"><span class="FieldInfo">Username:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="bg-info input-group-text text-white"><i class="fas fa-user"></i></span>
                                </div>
                                <input class="form-control" type="text" name="Username" id="username" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="FieldInfo">Password:</span></label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="bg-info input-group-text text-white"><i class="fas fa-lock"></i></span>
                                </div>
                                <input class="form-control" type="password" name="Password" id="password" value="">
                            </div>
                        </div>
                        <input type="submit" name="Submit" class="btn btn-info btn-block" value="Login">

                    </form>
                </div>
            </div>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            
        </div>
    </div>

</section>



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
